<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyLowStockReportMail;

class StockController extends Controller
{
    /**
     * Afficher la page de gestion des stocks
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'seller']);

        // Filtres
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'critical':
                    $query->where('quantity', 0);
                    break;
                case 'low':
                    $query->where('quantity', '>', 0)
                          ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'));
                    break;
                case 'normal':
                    $query->where('quantity', '>', \DB::raw('COALESCE(min_stock_alert, 5)'));
                    break;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        // Tri par stock croissant
        $query->orderBy('quantity', 'asc');

        $products = $query->paginate(20);

        // Statistiques
        $stats = [
            'total_products' => Product::count(),
            'critical_stock' => Product::where('quantity', 0)->count(),
            'low_stock' => Product::where('quantity', '>', 0)
                                 ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
                                 ->count(),
            'normal_stock' => Product::where('quantity', '>', \DB::raw('COALESCE(min_stock_alert, 5)'))->count(),
        ];

        return view('admin.stocks.index', compact('products', 'stats'));
    }

    /**
     * Envoyer manuellement le rapport des stocks faibles
     */
    public function sendLowStockReport()
    {
        $lowStockProducts = Product::with(['category', 'seller'])
            ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'))
            ->where('is_active', true)
            ->orderBy('quantity', 'asc')
            ->get();

        if ($lowStockProducts->isEmpty()) {
            return redirect()->back()->with('info', 'Aucun produit en stock faible trouvé.');
        }

        // Envoyer le rapport à tous les admins
        $admins = \App\Models\User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            try {
                Mail::to($admin->email)->send(new DailyLowStockReportMail($lowStockProducts, $admin));
            } catch (\Exception $e) {
                \Log::error("Erreur lors de l'envoi du rapport à {$admin->email}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Rapport des stocks faibles envoyé avec succès !');
    }

    /**
     * Mettre à jour le stock d'un produit
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'max_stock_alert' => 'nullable|integer|min:0',
        ]);

        $oldQuantity = $product->quantity;
        
        $product->update([
            'quantity' => $request->quantity,
            'min_stock_alert' => $request->min_stock_alert ?? $product->min_stock_alert,
            'max_stock_alert' => $request->max_stock_alert ?? $product->max_stock_alert,
        ]);

        // Log de la modification
        \Log::info("Stock mis à jour", [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'old_quantity' => $oldQuantity,
            'new_quantity' => $request->quantity,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Stock mis à jour avec succès !');
    }

    /**
     * Exporter les données de stock en CSV
     */
    public function export(Request $request)
    {
        $query = Product::with(['category', 'seller']);

        // Appliquer les mêmes filtres que dans index()
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'critical':
                    $query->where('quantity', 0);
                    break;
                case 'low':
                    $query->where('quantity', '>', 0)
                          ->where('quantity', '<=', \DB::raw('COALESCE(min_stock_alert, 5)'));
                    break;
                case 'normal':
                    $query->where('quantity', '>', \DB::raw('COALESCE(min_stock_alert, 5)'));
                    break;
            }
        }

        $products = $query->get();

        $filename = 'stocks_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'ID', 'Nom', 'Catégorie', 'Vendeur', 'Prix', 'Stock actuel', 
                'Seuil d\'alerte min', 'Seuil d\'alerte max', 'Statut', 'Date de création'
            ]);
            
            // Données
            foreach ($products as $product) {
                $status = $product->quantity == 0 ? 'Rupture' : 
                         ($product->quantity <= ($product->min_stock_alert ?? 5) ? 'Stock faible' : 'Normal');
                
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->category->name ?? 'Non définie',
                    $product->seller->name ?? 'Non assigné',
                    $product->price,
                    $product->quantity,
                    $product->min_stock_alert ?? 5,
                    $product->max_stock_alert ?? 50,
                    $status,
                    $product->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}

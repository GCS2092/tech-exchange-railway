<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdersController extends Controller
{
    /**
     * Afficher la page de gestion des commandes avec filtres
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'livreur', 'products']);

        // Filtres
        $filters = [
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'livreur_id' => $request->get('livreur_id'),
            'search' => $request->get('search'),
        ];

        // Filtre par statut
        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        // Filtre par période
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        // Filtre par livreur
        if ($filters['livreur_id']) {
            $query->where('livreur_id', $filters['livreur_id']);
        }

        // Recherche par nom client ou ID commande
        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('id', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('user', function ($userQuery) use ($filters) {
                      $userQuery->where('name', 'like', '%' . $filters['search'] . '%')
                               ->orWhere('email', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        // Tri
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $orders = $query->paginate(20)->withQueryString();

        // Récupérer les livreurs pour le filtre
        $livreurs = User::role('livreur')->get();

        // Statistiques
        $stats = $this->getOrderStats($filters);

        return view('admin.orders.index', compact('orders', 'filters', 'livreurs', 'stats'));
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(Order::STATUSES)),
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        $order->update([
            'status' => $newStatus,
            'notes' => $request->notes ?? $order->notes,
        ]);

        // Log de la modification
        \Log::info("Statut de commande mis à jour", [
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'updated_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Statut mis à jour avec succès',
            'new_status' => $newStatus,
            'status_label' => Order::STATUSES[$newStatus] ?? $newStatus,
        ]);
    }

    /**
     * Mettre à jour le statut de plusieurs commandes
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|string|in:' . implode(',', array_keys(Order::STATUSES)),
            'notes' => 'nullable|string|max:500',
        ]);

        $orderIds = $request->order_ids;
        $newStatus = $request->status;
        $notes = $request->notes;

        $updatedCount = 0;

        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update([
                    'status' => $newStatus,
                    'notes' => $notes ? $notes : $order->notes,
                ]);
                $updatedCount++;
            }
        }

        \Log::info("Statut mis à jour en masse", [
            'order_ids' => $orderIds,
            'new_status' => $newStatus,
            'updated_count' => $updatedCount,
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Statut mis à jour pour {$updatedCount} commande(s)",
            'updated_count' => $updatedCount,
        ]);
    }

    /**
     * Exporter les commandes en PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Order::with(['user', 'livreur', 'products']);

        // Appliquer les mêmes filtres que la page
        $filters = [
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
            'livreur_id' => $request->get('livreur_id'),
            'search' => $request->get('search'),
        ];

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        if ($filters['livreur_id']) {
            $query->where('livreur_id', $filters['livreur_id']);
        }
        if ($filters['search']) {
            $query->where(function ($q) use ($filters) {
                $q->where('id', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('user', function ($userQuery) use ($filters) {
                      $userQuery->where('name', 'like', '%' . $filters['search'] . '%')
                               ->orWhere('email', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->get();

        // Statistiques pour le PDF
        $stats = $this->getOrderStats($filters);

        $pdf = PDF::loadView('admin.orders.pdf', compact('orders', 'filters', 'stats'));
        
        $filename = 'commandes_' . now()->format('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Obtenir les statistiques des commandes
     */
    private function getOrderStats($filters = [])
    {
        $query = Order::query();

        // Appliquer les mêmes filtres
        if ($filters['date_from']) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if ($filters['date_to']) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        if ($filters['livreur_id']) {
            $query->where('livreur_id', $filters['livreur_id']);
        }

        $totalOrders = $query->count();
        $totalRevenue = $query->sum('total_price');
        
        $statsByStatus = [];
        foreach (Order::STATUSES as $status => $label) {
            $count = (clone $query)->where('status', $status)->count();
            $revenue = (clone $query)->where('status', $status)->sum('total_price');
            
            $statsByStatus[$status] = [
                'label' => $label,
                'count' => $count,
                'revenue' => $revenue,
                'percentage' => $totalOrders > 0 ? round(($count / $totalOrders) * 100, 1) : 0,
            ];
        }

        return [
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'by_status' => $statsByStatus,
        ];
    }
}

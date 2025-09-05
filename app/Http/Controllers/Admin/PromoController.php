<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoController extends Controller
{
    /**
     * Afficher la liste des codes promos
     */
    public function index(Request $request)
    {
        $query = PromoCode::query();

        // Filtres
        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true)
                          ->where('expires_at', '>', now());
                    break;
                case 'expired':
                    $query->where('expires_at', '<', now());
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
            }
        }

        $promoCodes = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistiques
        $stats = [
            'total' => PromoCode::count(),
            'active' => PromoCode::where('is_active', true)->where('expires_at', '>', now())->count(),
            'expired' => PromoCode::where('expires_at', '<', now())->count(),
            'used' => PromoCode::where('usage_count', '>', 0)->count(),
        ];

        return view('admin.promos.index', compact('promoCodes', 'stats'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Enregistrer un nouveau code promo
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'description' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'required|date|after:now',
            'is_active' => 'nullable',
        ]);

        // Validation spécifique selon le type de réduction
        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Le pourcentage ne peut pas dépasser 100%']);
        }

        PromoCode::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_usage' => $request->max_usage,
            'min_order_amount' => $request->min_order_amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Code promo créé avec succès !');
    }

    /**
     * Créer plusieurs codes promos en masse
     */
    public function createBulk(Request $request)
    {
        try {
            $request->validate([
                'quantity' => 'required|integer|min:1|max:100',
                'prefix' => 'nullable|string|max:10',
                'description' => 'required|string|max:255',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'max_usage' => 'nullable|integer|min:1',
                'min_order_amount' => 'nullable|numeric|min:0',
                'expires_at' => 'required|date|after:now',
                'is_active' => 'nullable',
            ]);

            // Validation spécifique selon le type de réduction
            if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
                return back()->withErrors(['discount_value' => 'Le pourcentage ne peut pas dépasser 100%'])->withInput();
            }

            $createdCodes = [];
            $errors = [];

            \Log::info('Début de la création en masse', [
                'quantity' => $request->quantity,
                'prefix' => $request->prefix,
                'description' => $request->description
            ]);

            for ($i = 0; $i < $request->quantity; $i++) {
                try {
                    // Générer un code unique avec retry
                    $maxAttempts = 10;
                    $attempts = 0;
                    $code = null;
                    
                    do {
                        $attempts++;
                        $code = $request->prefix ? 
                            strtoupper($request->prefix . '_' . Str::random(6)) : 
                            strtoupper(Str::random(8));
                            
                        if ($attempts >= $maxAttempts) {
                            throw new \Exception("Impossible de générer un code unique après $maxAttempts tentatives");
                        }
                    } while (PromoCode::where('code', $code)->exists());

                    \Log::info("Création du code promo #" . ($i + 1), ['code' => $code]);

                    $promoCode = PromoCode::create([
                        'code' => $code,
                        'description' => $request->description . ' #' . ($i + 1),
                        'discount_type' => $request->discount_type,
                        'discount_value' => $request->discount_value,
                        'max_usage' => $request->max_usage ?: null,
                        'min_order_amount' => $request->min_order_amount ?: null,
                        'expires_at' => $request->expires_at,
                        'is_active' => $request->has('is_active'),
                    ]);

                    $createdCodes[] = $promoCode;
                    
                } catch (\Exception $e) {
                    $errorMsg = "Erreur lors de la création du code #" . ($i + 1) . ": " . $e->getMessage();
                    $errors[] = $errorMsg;
                    \Log::error($errorMsg, ['exception' => $e]);
                }
            }

            if (count($errors) > 0) {
                \Log::warning('Erreurs lors de la création en masse', ['errors' => $errors]);
                return back()->withErrors($errors)->withInput();
            }

            \Log::info('Création en masse terminée avec succès', [
                'created_count' => count($createdCodes),
                'codes' => array_map(function($code) { return $code->code; }, $createdCodes)
            ]);

            return redirect()->route('admin.promos.index')
                ->with('success', count($createdCodes) . ' codes promos créés avec succès !');

        } catch (\Exception $e) {
            \Log::error('Erreur générale dans createBulk', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors(['general' => 'Erreur lors de la création en masse: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Afficher un code promo
     */
    public function show(PromoCode $promo)
    {
        return view('admin.promos.show', compact('promo'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(PromoCode $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Mettre à jour un code promo
     */
    public function update(Request $request, PromoCode $promo)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $promo->id,
            'description' => 'required|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'expires_at' => 'required|date',
            'is_active' => 'nullable',
        ]);

        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()->withErrors(['discount_value' => 'Le pourcentage ne peut pas dépasser 100%']);
        }

        $promo->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'max_usage' => $request->max_usage,
            'min_order_amount' => $request->min_order_amount,
            'expires_at' => $request->expires_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.promos.index')->with('success', 'Code promo mis à jour avec succès !');
    }

    /**
     * Supprimer un code promo
     */
    public function destroy(PromoCode $promo)
    {
        if ($promo->usage_count > 0) {
            return back()->with('error', 'Impossible de supprimer un code promo qui a été utilisé.');
        }

        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Code promo supprimé avec succès !');
    }

    /**
     * Générer un code promo automatiquement
     */
    public function generateCode()
    {
        try {
            do {
                $code = strtoupper(Str::random(8));
            } while (PromoCode::where('code', $code)->exists());

            return response()->json(['code' => $code]);
        } catch (\Exception $e) {
            // En cas d'erreur, générer un code simple
            $code = strtoupper(Str::random(8));
            return response()->json(['code' => $code]);
        }
    }

    /**
     * Activer/Désactiver un code promo
     */
    public function toggleStatus(PromoCode $promo)
    {
        $promo->update(['is_active' => !$promo->is_active]);
        
        $status = $promo->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Code promo {$status} avec succès !");
    }

    /**
     * Exporter les codes promos en CSV
     */
    public function export()
    {
        $promoCodes = PromoCode::all();
        
        $filename = 'codes_promos_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($promoCodes) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Code', 'Description', 'Type', 'Valeur', 'Utilisations', 'Max Utilisations',
                'Montant Minimum', 'Expire le', 'Statut', 'Créé le'
            ]);
            
            // Données
            foreach ($promoCodes as $promo) {
                $status = $promo->is_active ? 'Actif' : 'Inactif';
                if ($promo->expires_at < now()) {
                    $status = 'Expiré';
                }
                
                fputcsv($file, [
                    $promo->code,
                    $promo->description,
                    $promo->discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe',
                    $promo->discount_value . ($promo->discount_type === 'percentage' ? '%' : ' FCFA'),
                    $promo->usage_count,
                    $promo->max_usage ?? 'Illimité',
                    $promo->min_order_amount ? number_format($promo->min_order_amount, 0, ',', ' ') . ' FCFA' : 'Aucun',
                    $promo->expires_at->format('d/m/Y H:i'),
                    $status,
                    $promo->created_at->format('d/m/Y H:i'),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PromoUsage;
use App\Helpers\CurrencyHelper;

class PromoController extends Controller
{
    public function index() {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            $promos = Promotion::with(['seller', 'usages'])->orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('vendeur')) {
            $promos = Promotion::where('seller_id', $user->id)->with(['usages'])->orderBy('created_at', 'desc')->get();
        } else {
            $promos = Promotion::active()->orderBy('created_at', 'desc')->get();
        }
        
        return view('promos.index', compact('promos'));
    }

    public function create() {
        $user = auth()->user();
        
        if (!$user->hasRole(['admin', 'vendeur'])) {
            abort(403, 'Accès refusé.');
        }
        
        $sellers = User::role('vendeur')->get();
        return view('promos.create', compact('sellers'));
    }

    public function store(Request $request) {
        $user = auth()->user();
        
        if (!$user->hasRole(['admin', 'vendeur'])) {
            abort(403, 'Accès refusé.');
        }
        
        $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date|after:today',
            'max_uses' => 'nullable|integer|min:1',
            'min_order_amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'seller_id' => 'nullable|exists:users,id'
        ]);

        $data = $request->all();
        
        // Si c'est un vendeur, assigner automatiquement son ID
        if ($user->hasRole('vendeur')) {
            $data['seller_id'] = $user->id;
        }
        
        // Si c'est un admin et qu'aucun vendeur n'est spécifié, créer un code global
        if ($user->hasRole('admin') && empty($data['seller_id'])) {
            $data['seller_id'] = null;
        }

        $promo = Promotion::create($data);

        $message = 'Code promo "' . $promo->code . '" créé avec succès !';
        return redirect()->route('promos.index')->with('success', $message);
    }
    public function edit(Promotion $promo)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès refusé.');
        }
    
        return view('promos.edit', compact('promo'));
    }
    public function destroy(Promotion $promo)
{
    $promo->delete();
    return redirect()->route('promos.index')->with('success', 'Code promo supprimé avec succès.');
}
 public function usageHistory($id)
{
    $promo = Promotion::findOrFail($id);
    $usages = PromoUsage::where('promotion_id', $id)
        ->with('user:id,name,email')
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($usage) {
            return [
                'id' => $usage->id,
                'order_id' => $usage->order_id,
                'user' => [
                    'id' => $usage->user->id,
                    'name' => $usage->user->name,
                ],
                'created_at' => $usage->created_at,
                'original_amount' => $usage->original_amount,
                'discount_amount' => $usage->discount_amount,
                'final_amount' => $usage->final_amount,
                'discount_percent' => round(($usage->discount_amount / $usage->original_amount) * 100, 2)
            ];
        });

    return view('promos.usage-history', compact('promo', 'usages'));
}

    /**
     * Valider un code promo
     */
    public function validate(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'order_amount' => 'required|numeric|min:0'
        ]);

        $code = strtoupper(trim($request->code));
        $orderAmount = $request->order_amount;
        $user = auth()->user();

        $promo = Promotion::where('code', $code)->first();

        if (!$promo) {
            return response()->json([
                'valid' => false,
                'message' => 'Code promo invalide.'
            ]);
        }

        if (!$promo->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'Ce code promo n\'est plus valide.'
            ]);
        }

        if (!$promo->canBeUsedBy($user)) {
            return response()->json([
                'valid' => false,
                'message' => 'Vous avez déjà utilisé ce code promo.'
            ]);
        }

        if ($promo->min_order_amount && $orderAmount < $promo->min_order_amount) {
            return response()->json([
                'valid' => false,
                'message' => 'Montant minimum requis : ' . CurrencyHelper::formatXOF($promo->min_order_amount)
            ]);
        }

        $discount = $promo->calculateDiscount($orderAmount);
        $finalAmount = $orderAmount - $discount;

        return response()->json([
            'valid' => true,
            'promo' => [
                'id' => $promo->id,
                'code' => $promo->code,
                'type' => $promo->type,
                'value' => $promo->value,
                'formatted_value' => $promo->formatted_value,
                'description' => $promo->description
            ],
            'discount' => [
                'amount' => $discount,
                'formatted' => CurrencyHelper::formatXOF($discount),
                'percent' => $promo->type === 'percent' ? $promo->value : round(($discount / $orderAmount) * 100, 1)
            ],
            'order' => [
                'original_amount' => $orderAmount,
                'final_amount' => $finalAmount,
                'formatted_original' => CurrencyHelper::formatXOF($orderAmount),
                'formatted_final' => CurrencyHelper::formatXOF($finalAmount)
            ]
        ]);
    }

    /**
     * Rechercher des codes promos
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $status = $request->get('status', '');
        
        $promos = Promotion::query();
        
        if ($query) {
            $promos->where('code', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
        }
        
        if ($status) {
            switch ($status) {
                case 'active':
                    $promos->active();
                    break;
                case 'expired':
                    $promos->expired();
                    break;
                case 'inactive':
                    $promos->where('is_active', false);
                    break;
            }
        }
        
        $promos = $promos->with(['seller', 'usages'])->orderBy('created_at', 'desc')->get();
        
        return response()->json($promos);
    }
}

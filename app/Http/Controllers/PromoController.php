<?php
namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\PromoUsage;
class PromoController extends Controller
{
    public function index() {
        $promos = Promotion::all();
        return view('promos.index', compact('promos'));
    }

    public function create() {
        return view('promos.create');
    }

    public function store(Request $request) {
        $request->validate([
            'code' => 'required|unique:promotions',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric',
            'expires_at' => 'nullable|date'
        ]);

        Promotion::create($request->all());

        return redirect()->route('promos.index')->with('success', 'Code promo ajouté !');
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



}

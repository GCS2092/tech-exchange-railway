<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class VendorPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::where('seller_id', auth()->id())->paginate(10);
        return view('vendor.promos.index', compact('promos'));
    }

    public function create()
    {
        return view('vendor.promos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promos,code',
            'discount' => 'required|numeric|min:1',
            'expires_at' => 'nullable|date',
        ]);
        Promo::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'expires_at' => $request->expires_at,
            'seller_id' => auth()->id(),
        ]);
        return redirect()->route('vendeur.promos.index')->with('success', 'Code promo créé !');
    }

    public function edit($id)
    {
        $promo = Promo::where('seller_id', auth()->id())->findOrFail($id);
        return view('vendor.promos.edit', compact('promo'));
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::where('seller_id', auth()->id())->findOrFail($id);
        $request->validate([
            'code' => 'required|string|max:50|unique:promos,code,' . $promo->id,
            'discount' => 'required|numeric|min:1',
            'expires_at' => 'nullable|date',
        ]);
        $promo->update($request->only('code', 'discount', 'expires_at'));
        return redirect()->route('vendeur.promos.index')->with('success', 'Code promo modifié !');
    }

    public function destroy($id)
    {
        $promo = Promo::where('seller_id', auth()->id())->findOrFail($id);
        $promo->delete();
        return redirect()->route('vendeur.promos.index')->with('success', 'Code promo supprimé !');
    }
} 
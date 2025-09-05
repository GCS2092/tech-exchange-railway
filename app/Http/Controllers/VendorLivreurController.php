<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VendorLivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        // On suppose qu'un livreur est un utilisateur avec le rôle 'livreur' et un champ seller_id (à adapter si besoin)
        $livreurs = \App\Models\User::role('livreur')->where('seller_id', $user->id)->get();
        return view('vendor.livreurs.index', compact('livreurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.livreurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'seller_id' => auth()->id(),
        ]);
        $user->assignRole('livreur');
        return redirect()->route('vendeur.livreurs.index')->with('success', 'Livreur ajouté !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $livreur = \App\Models\User::findOrFail($id);
        return view('vendor.livreurs.edit', compact('livreur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, $id)
    {
        $livreur = \App\Models\User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$livreur->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $livreur->name = $request->name;
        $livreur->email = $request->email;
        if ($request->filled('password')) {
            $livreur->password = bcrypt($request->password);
        }
        $livreur->save();
        return redirect()->route('vendeur.livreurs.index')->with('success', 'Livreur modifié !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $livreur = \App\Models\User::findOrFail($id);
        $livreur->delete();
        return redirect()->route('vendeur.livreurs.index')->with('success', 'Livreur supprimé !');
    }

    /**
     * Affiche la liste complète des livreurs (tous, pas seulement ceux du vendeur)
     */
    public function allLivreurs()
    {
        $livreurs = User::role('livreur')->get();
        return view('vendor.livreurs.all', compact('livreurs'));
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses;
        return response()->json(['addresses' => $addresses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'is_default' => 'boolean',
            'phone' => 'required|string|max:20',
            'name' => 'required|string|max:255',
        ]);

        if ($request->is_default) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        $address = Auth::user()->addresses()->create($validated);
        return response()->json(['address' => $address], 201);
    }

    public function update(Request $request, Address $address)
    {
        $this->authorize('update', $address);

        $validated = $request->validate([
            'street' => 'string|max:255',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
            'zip_code' => 'string|max:10',
            'country' => 'string|max:255',
            'is_default' => 'boolean',
            'phone' => 'string|max:20',
            'name' => 'string|max:255',
        ]);

        if ($request->is_default) {
            Auth::user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);
        return response()->json(['address' => $address]);
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);
        $address->delete();
        return response()->json(null, 204);
    }

    public function setDefault(Address $address)
    {
        $this->authorize('update', $address);
        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);
        return response()->json(['message' => 'Adresse par défaut mise à jour']);
    }
} 
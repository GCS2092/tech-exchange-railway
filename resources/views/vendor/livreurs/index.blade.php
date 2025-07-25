@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-indigo-700">Mes livreurs</h1>
        <a href="{{ route('vendeur.livreurs.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">Ajouter un livreur</a>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        @if($livreurs->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($livreurs as $livreur)
                    <tr>
                        <td class="px-4 py-2">{{ $livreur->name }}</td>
                        <td class="px-4 py-2">{{ $livreur->email }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('vendeur.livreurs.edit', $livreur) }}" class="text-blue-600 hover:underline">Éditer</a>
                            <form action="{{ route('vendeur.livreurs.destroy', $livreur) }}" method="POST" onsubmit="return confirm('Supprimer ce livreur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Aucun livreur pour l'instant.</p>
        @endif
    </div>
</div>
@endsection 
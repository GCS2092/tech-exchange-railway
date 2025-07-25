@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-indigo-700">Catégories</h1>
        <a href="{{ route('vendeur.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-semibold">Ajouter une catégorie</a>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        @if($categories->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($categories as $category)
                    <tr>
                        <td class="px-4 py-2">{{ $category->name }}</td>
                        <td class="px-4 py-2 flex gap-2">
                            <a href="{{ route('vendeur.categories.edit', $category) }}" class="text-blue-600 hover:underline">Éditer</a>
                            <form action="{{ route('vendeur.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $categories->links() }}</div>
        @else
            <p class="text-gray-500">Aucune catégorie pour l'instant.</p>
        @endif
    </div>
</div>
@endsection 
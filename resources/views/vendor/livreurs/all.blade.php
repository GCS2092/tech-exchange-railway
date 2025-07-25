@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-2xl font-bold text-indigo-700 mb-6">Tous les livreurs</h1>
    <div class="bg-white rounded-xl shadow p-6">
        @if($livreurs->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nom</th>
                        <th class="px-4 py-2 text-left">Email</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($livreurs as $livreur)
                    <tr>
                        <td class="px-4 py-2">{{ $livreur->name }}</td>
                        <td class="px-4 py-2">{{ $livreur->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-500">Aucun livreur trouvé.</p>
        @endif
    </div>
</div>
@endsection 
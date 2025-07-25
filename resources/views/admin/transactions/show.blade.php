@extends('layouts.admin')
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Détail de la Transaction #{{ $transaction->id }}</h1>
    <div class="bg-white rounded-lg shadow p-6 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <span class="text-gray-500 text-sm">Commande :</span>
                <div class="font-semibold">#{{ $transaction->order_id }}</div>
            </div>
            <div>
                <span class="text-gray-500 text-sm">Client :</span>
                <div class="font-semibold">{{ $transaction->user->name ?? '—' }}</div>
            </div>
            <div>
                <span class="text-gray-500 text-sm">Montant :</span>
                <div class="font-semibold">{{ $transaction->formatted_amount }}</div>
            </div>
            <div>
                <span class="text-gray-500 text-sm">Méthode de paiement :</span>
                <div class="font-semibold">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</div>
            </div>
            <div>
                <span class="text-gray-500 text-sm">Statut :</span>
                <div class="font-semibold">{{ $transaction->status_label }}</div>
            </div>
            <div>
                <span class="text-gray-500 text-sm">Date :</span>
                <div class="font-semibold">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.transactions.edit', $transaction) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Modifier</a>
            <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" onsubmit="return confirm('Supprimer cette transaction ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">Supprimer</button>
            </form>
            <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Retour</a>
        </div>
    </div>
</div>
@endsection 
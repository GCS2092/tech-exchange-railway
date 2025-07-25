@extends('layouts.admin')
@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Nouvelle Transaction</h1>
    <form action="{{ route('admin.transactions.store') }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="order_id" class="block text-sm font-medium text-gray-700 mb-1">Commande</label>
                <select name="order_id" id="order_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="">Sélectionner une commande</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}">#{{ $order->id }} - {{ $order->user->name ?? 'Client inconnu' }} ({{ number_format($order->total_price, 0, ',', ' ') }} FCFA)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Client</label>
                <select name="user_id" id="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="">Sélectionner un client</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                <input type="number" name="amount" id="amount" class="w-full border border-gray-300 rounded-md px-3 py-2" min="0" required>
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Méthode de paiement</label>
                <select name="payment_method" id="payment_method" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="cash">Espèces</option>
                    <option value="card">Carte</option>
                    <option value="mobile_money">Mobile Money</option>
                    <option value="bank_transfer">Virement</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="pending">En attente</option>
                    <option value="completed">Payé</option>
                    <option value="failed">Échoué</option>
                    <option value="refunded">Remboursé</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.transactions.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Annuler</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">Créer</button>
        </div>
    </form>
</div>
@endsection 
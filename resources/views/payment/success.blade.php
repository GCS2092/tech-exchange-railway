@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    <h2 class="text-2xl font-bold text-green-600 mb-4">🎉 Paiement réussi</h2>
    <p class="text-gray-700">Votre commande a été prise en compte et vous recevrez une confirmation sous peu.</p>
    <a href="{{ route('orders.index') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded">
        Voir mes commandes
    </a>
</div>
@endsection

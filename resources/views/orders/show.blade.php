@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="min-h-screen bg-white text-gray-800">
    <div class="container mx-auto p-6">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-blue-800 mb-6">Détail de la commande #{{ $order->id }}</h2>
            <div class="mb-3"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div class="mb-3"><strong>Client :</strong> {{ $order->user->name ?? 'Anonyme' }}</div>
            <div class="mb-3"><strong>Statut :</strong> <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                @if($order->status === 'en attente') bg-yellow-100 text-yellow-800
                @elseif($order->status === 'expédié') bg-blue-100 text-blue-800
                @elseif($order->status === 'livré') bg-green-100 text-green-800
                @else bg-gray-100 text-gray-800
                @endif">{{ ucfirst($order->status) }}</span></div>
                                    <div class="mb-3"><strong>Total :</strong> {{ number_format($order->total_price, 0, ',', ' ') }} FCFA</div>
            <div class="mb-3"><strong>Adresse de livraison :</strong> {{ $order->delivery_address }}</div>
            <div class="mb-3"><strong>Produits :</strong>
                <ul class="list-disc ml-6">
                    @foreach($order->products as $product)
                        <li>{{ $product->name }} x {{ $product->pivot->quantity }} ({{ number_format($product->pivot->price, 2, ',', ' ') }} FCFA)</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
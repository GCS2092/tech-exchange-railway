@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-green-50 to-emerald-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
        <!-- Header avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-green-600 to-emerald-600 mb-4">
                Commande Validée !
            </h1>
            <p class="text-gray-600 text-lg">Votre commande a été enregistrée avec succès.</p>
        </div>

        <!-- Détails de la commande -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Détails de votre commande</h2>
            
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Numéro de commande</span>
                    <span class="font-semibold">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Date</span>
                    <span class="font-semibold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total</span>
                    @php $currentCurrency = session('currency', 'XOF'); @endphp
                    <span class="font-semibold text-green-600">{{ \App\Helpers\CurrencyHelper::format($order->total_price, $currentCurrency) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Statut</span>
                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                Suivre ma commande
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                Continuer mes achats
            </a>
        </div>
    </div>
</div>
@endsection 
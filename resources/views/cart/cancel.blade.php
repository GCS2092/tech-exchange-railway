@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-red-50 to-rose-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
        <!-- Header avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h1 class="text-2xl md:text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-red-600 to-rose-600 mb-4">
                Paiement Annulé
            </h1>
            <p class="text-gray-600 text-lg">Votre paiement a été annulé ou n'a pas abouti.</p>
        </div>

        <!-- Message d'information -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="space-y-4">
                <p class="text-gray-600">
                    Si vous avez des questions concernant votre paiement, n'hésitez pas à nous contacter.
                </p>
                <ul class="list-disc list-inside text-gray-600 space-y-2">
                    <li>Vérifiez que votre carte est valide et dispose de fonds suffisants</li>
                    <li>Assurez-vous que les informations de paiement sont correctes</li>
                    <li>Si le problème persiste, contactez votre banque</li>
                </ul>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('cart.index') }}" class="btn btn-primary">
                Retour au panier
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                Continuer mes achats
            </a>
        </div>
    </div>
</div>
@endsection 
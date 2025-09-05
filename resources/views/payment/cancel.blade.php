@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto text-center py-12">
    <h2 class="text-2xl font-bold text-red-600 mb-4">❌ Paiement annulé</h2>
    <p class="text-gray-700">Votre paiement a été annulé. Vous pouvez réessayer à tout moment.</p>
    <a href="{{ route('cart.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-6 py-2 rounded">
        Revenir au panier
    </a>
</div>
@endsection

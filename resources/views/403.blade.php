@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50">
    <div class="bg-white rounded-3xl shadow-2xl p-10 flex flex-col items-center">
        <div class="text-7xl font-extrabold text-pink-500 mb-4">403</div>
        <div class="text-2xl font-bold text-gray-800 mb-2">Accès interdit</div>
        <div class="text-lg text-gray-600 mb-6">Vous n'avez pas la permission d'accéder à cette page.</div>
        <a href="{{ route('home') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl shadow-lg hover:from-purple-600 hover:to-pink-500 transition-all font-semibold text-lg">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection 
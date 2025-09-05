@extends('layouts.admin')

@section('head')
    @vite(['resources/css/pages/dashboard.css'])
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête du tableau de bord -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600">
                    Tableau de bord
                </h1>
                <p class="mt-2 text-lg text-gray-600">Bienvenue, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-white shadow-lg rounded-xl px-4 py-2 flex items-center">
                    <span class="text-sm font-medium text-gray-600 mr-2">Rôle:</span>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold 
                        @if(auth()->user()->getRoleNames()->first() === 'admin') bg-purple-100 text-purple-800
                        @elseif(auth()->user()->getRoleNames()->first() === 'moderator') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ auth()->user()->getRoleNames()->first() ?? 'Utilisateur' }}
                    </span>
                </div>
                <a href="{{ route('profile.edit') }}" class="bg-white shadow-lg rounded-xl p-3 hover:bg-gray-50 transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 group-hover:text-purple-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Grille principale -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Statistiques -->
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-600">Commandes</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $ordersCount ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-sm text-gray-600">Favoris</p>
                        <p class="text-2xl font-bold text-pink-600">{{ $favoritesCount ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Notifications</h2>
                    <a href="{{ route('notifications.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Voir toutes
                    </a>
                </div>
                @if(isset($notifications) && count($notifications) > 0)
                    <div class="space-y-4">
                        @foreach($notifications->take(3) as $notif)
                            <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors">
                                <p class="text-sm text-gray-800">{{ $notif->data['message'] ?? 'Notification' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-50 rounded-xl p-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <p class="text-sm text-gray-500 mt-2">Aucune notification pour le moment</p>
                    </div>
                @endif
            </div>

            <!-- Profil -->
            <div class="bg-white rounded-2xl shadow-xl p-6 transform transition-all duration-300 hover:scale-105">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Mon Profil</h2>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-gray-100 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Dernière connexion:</span>
                        {{ auth()->user()->last_login_at ? auth()->user()->last_login_at->format('d/m/Y H:i') : 'Jamais' }}
                    </p>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('products.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-purple-100 rounded-lg p-3 group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Produits</h3>
                            <p class="text-sm text-gray-500">Voir tous les produits</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('orders.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 rounded-lg p-3 group-hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Commandes</h3>
                            <p class="text-sm text-gray-500">Voir mes commandes</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('favorites.index') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-pink-100 rounded-lg p-3 group-hover:bg-pink-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Favoris</h3>
                            <p class="text-sm text-gray-500">Voir mes favoris</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center space-x-4">
                        <div class="bg-green-100 rounded-lg p-3 group-hover:bg-green-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Paramètres</h3>
                            <p class="text-sm text-gray-500">Gérer mon compte</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>
@endpush
@endsection

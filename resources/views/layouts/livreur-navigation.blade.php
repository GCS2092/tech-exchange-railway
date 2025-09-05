<nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo et titre -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-white">Espace Livreur</span>
                </div>
            </div>

            <!-- Navigation principale -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('livreur.orders.index') }}" 
                   class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('livreur.orders.*') ? 'bg-blue-700' : '' }}">
                    📦 Mes Livraisons
                </a>
                
                <a href="{{ route('livreur.planning') }}" 
                   class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('livreur.planning') ? 'bg-blue-700' : '' }}">
                    📅 Planning
                </a>
                
                <a href="{{ route('livreur.statistics') }}" 
                   class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('livreur.statistics') ? 'bg-blue-700' : '' }}">
                    📊 Statistiques
                </a>
                
                <a href="{{ route('livreur.settings') }}" 
                   class="text-white hover:text-blue-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ request()->routeIs('livreur.settings') ? 'bg-blue-700' : '' }}">
                    ⚙️ Paramètres
                </a>
            </div>

            <!-- Menu utilisateur -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <div class="relative">
                    <button class="text-white hover:text-blue-200 p-2 rounded-md transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                </div>

                <!-- Profil utilisateur -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-white hover:text-blue-200 transition-colors duration-200">
                        <div class="flex items-center space-x-2">
                            <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Menu déroulant -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('livreur.profile') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            👤 Mon Profil
                        </a>
                        <a href="{{ route('profile.edit') }}" 
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            ✏️ Modifier Profil
                        </a>
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                🚪 Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white hover:text-blue-200 p-2 rounded-md">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile -->
    <div x-show="mobileMenuOpen" class="md:hidden bg-blue-700">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('livreur.orders.index') }}" 
               class="text-white hover:text-blue-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('livreur.orders.*') ? 'bg-blue-800' : '' }}">
                📦 Mes Livraisons
            </a>
            
            <a href="{{ route('livreur.planning') }}" 
               class="text-white hover:text-blue-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('livreur.planning') ? 'bg-blue-800' : '' }}">
                📅 Planning
            </a>
            
            <a href="{{ route('livreur.statistics') }}" 
               class="text-white hover:text-blue-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('livreur.statistics') ? 'bg-blue-800' : '' }}">
                📊 Statistiques
            </a>
            
            <a href="{{ route('livreur.settings') }}" 
               class="text-white hover:text-blue-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200 {{ request()->routeIs('livreur.settings') ? 'bg-blue-800' : '' }}">
                ⚙️ Paramètres
            </a>
            
            <hr class="border-blue-600 my-2">
            
            <a href="{{ route('livreur.profile') }}" 
               class="text-white hover:text-blue-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                👤 Mon Profil
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full text-left text-red-300 hover:text-red-200 block px-3 py-2 rounded-md text-base font-medium transition-colors duration-200">
                    🚪 Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>

<!-- Barre d'état du livreur -->
<div class="bg-blue-50 border-b border-blue-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-2">
            <div class="flex items-center space-x-4 text-sm text-blue-700">
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span>En ligne</span>
                </div>
                <span>•</span>
                <span>Livraisons aujourd'hui: {{ auth()->user()->orders()->whereDate('created_at', today())->count() }}</span>
                <span>•</span>
                <span>Distance parcourue: {{ number_format(auth()->user()->total_distance ?? 0, 1) }} km</span>
            </div>
            
            <div class="flex items-center space-x-2">
                <button id="updateLocationBtn" class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full hover:bg-blue-700 transition-colors duration-200">
                    📍 Mettre à jour position
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du menu mobile
    window.mobileMenuOpen = false;
    
    // Mise à jour de la position
    document.getElementById('updateLocationBtn').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const data = {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    _token: '{{ csrf_token() }}'
                };
                
                fetch('{{ route("livreur.update-location") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Afficher une notification de succès
                        const btn = document.getElementById('updateLocationBtn');
                        btn.textContent = '✅ Position mise à jour';
                        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        btn.classList.add('bg-green-600');
                        
                        setTimeout(() => {
                            btn.textContent = '📍 Mettre à jour position';
                            btn.classList.remove('bg-green-600');
                            btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }, function(error) {
                console.error('Erreur de géolocalisation:', error);
                alert('Impossible d\'obtenir votre position. Veuillez vérifier les permissions de géolocalisation.');
            });
        } else {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
        }
    });
});
</script>

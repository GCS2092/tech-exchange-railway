
<nav x-data="{ open: false }" class="sticky top-0 w-full z-50 bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 lg:space-x-3 group flex-shrink-0">
                <div class="w-8 h-8 lg:w-12 lg:h-12 bg-black rounded-full flex items-center justify-center shadow-lg group-hover:scale-105 transition-all duration-300">
                    <svg class="w-4 h-4 lg:w-7 lg:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <span class="text-lg lg:text-2xl font-extrabold tracking-tight text-black group-hover:text-gray-700 transition-all duration-500 ease-in-out">
                    TechExchange
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1 xl:space-x-2">
                <a href="{{ route('dashboard') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Accueil</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('products.index') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Appareils</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('trades.search') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Troc</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('orders.index') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Commandes</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('promos.index') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Promos</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('fidelity.calendar') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Fidélité</span>
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                <a href="{{ route('favorites.index') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                    <span class="relative z-10">Favoris</span>
                    @auth
                        @if($navData['favorites_count'] > 0)
                            <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">
                                {{ $navData['favorites_count'] }}
                            </span>
                        @endif
                    @endauth
                    <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                </a>
                @role('vendeur')
                    <a href="{{ route('vendeur.livreurs.all') }}" class="text-sm xl:text-base font-semibold text-black hover:text-gray-600 transition-all duration-300 relative group px-2 xl:px-3 py-2 rounded-lg">
                        <span class="relative z-10">Livreurs</span>
                        <div class="absolute inset-0 bg-gray-100 rounded-lg scale-0 group-hover:scale-100 transition-transform duration-300 -z-10"></div>
                    </a>
                @endrole
            </div>

            <!-- Actions -->
            <div class="flex items-center space-x-2 lg:space-x-3">
                <!-- Panier -->
                @auth
                    <a href="{{ route('cart.index') }}" class="relative group">
                        <div class="flex items-center space-x-1 lg:space-x-2 px-2 lg:px-3 py-2 bg-white hover:bg-gray-50 border border-gray-200 hover:border-black rounded-lg lg:rounded-xl transition-all duration-300">
                            <div class="relative">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-black group-hover:text-gray-700 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                @php
                                    $cartCount = $navData['cart_count'];
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 lg:-top-2 lg:-right-2 bg-black text-white text-xs rounded-full h-4 w-4 lg:h-5 lg:w-5 flex items-center justify-center font-bold">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </div>
                            <span class="hidden xl:inline text-black group-hover:text-gray-700 font-medium transition-colors duration-300 text-sm">Panier</span>
                        </div>
                    </a>
                @endauth

                <!-- Notifications -->
                @auth
                    <div class="relative">
                        <button class="flex items-center space-x-1 lg:space-x-2 px-2 lg:px-3 py-2 bg-white hover:bg-gray-50 border border-gray-200 hover:border-black rounded-lg lg:rounded-xl transition-all duration-300 group">
                            <div class="relative">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 text-black group-hover:text-gray-700 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @if($navData['notifications_count'] > 0)
                                    <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-3 w-3 lg:h-4 lg:w-4 flex items-center justify-center font-bold">
                                        {{ $navData['notifications_count'] }}
                                    </span>
                                @endif
                            </div>
                            <span class="hidden xl:inline text-black group-hover:text-gray-700 font-medium transition-colors duration-300 text-sm">Alertes</span>
                        </button>

                        <!-- Notifications Dropdown -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 z-50" style="display: none;">
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-black">Notifications</h3>
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-gray-600 hover:text-black">Voir tout</a>
                                </div>
                                
                                @if($navData['notifications_count'] > 0)
                                    <div class="space-y-3">
                                        @foreach($navData['recent_notifications'] ?? [] as $notification)
                                            <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-bell text-white text-sm"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-black font-medium">{{ $notification->title ?? 'Nouvelle notification' }}</p>
                                                    <p class="text-xs text-gray-600 mt-1">{{ $notification->message ?? 'Vous avez une nouvelle notification' }}</p>
                                                    <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at ? $notification->created_at->diffForHumans() : 'À l\'instant' }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="fas fa-bell text-gray-400 text-xl"></i>
                                        </div>
                                        <p class="text-gray-500">Aucune notification</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- User Menu -->
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 lg:space-x-3 px-2 lg:px-3 py-2 bg-white hover:bg-gray-50 border border-gray-200 hover:border-black rounded-lg lg:rounded-xl transition-all duration-300 group">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 bg-black rounded-full flex items-center justify-center text-white font-semibold text-sm lg:text-base">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden xl:inline text-black group-hover:text-gray-700 font-medium transition-colors duration-300 text-sm">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-black group-hover:text-gray-700 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 z-50" style="display: none;">
                            <div class="py-2">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-black">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-colors duration-200">
                                    <i class="fas fa-user mr-3 text-gray-400"></i>
                                Mon profil
                            </a>
                            
                                @role('admin')
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-colors duration-200">
                                        <i class="fas fa-cog mr-3 text-gray-400"></i>
                                        Administration
                                    </a>
                                @endrole
                            
                            @role('vendeur')
                                    <a href="{{ route('vendeur.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-colors duration-200">
                                        <i class="fas fa-store mr-3 text-gray-400"></i>
                                        Espace vendeur
                            </a>
                            @endrole
                            
                                <div class="border-t border-gray-100 my-2"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-black transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                        Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <div class="lg:hidden">
                    <button @click="open = !open" class="p-2 rounded-lg text-black hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="lg:hidden bg-white border-t border-gray-200" style="display: none;">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Accueil</a>
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Appareils</a>
                <a href="{{ route('trades.search') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Troc</a>
                <a href="{{ route('orders.index') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Commandes</a>
                <a href="{{ route('promos.index') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Promos</a>
                <a href="{{ route('fidelity.calendar') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Fidélité</a>
                <a href="{{ route('favorites.index') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Favoris</a>
            @role('vendeur')
                    <a href="{{ route('vendeur.livreurs.all') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors duration-200">Livreurs</a>
            @endrole
                </div>
        </div>
    </div>
</nav>

<!-- Spacer to prevent content from being hidden under fixed navbar -->
<div class="h-16 lg:h-20"></div>

<script>
    // Add scroll behavior for navbar
    document.addEventListener('alpine:init', () => {
        // Pour les animations supplémentaires au chargement de la page
        const navLinks = document.querySelectorAll('nav a');

        // Animation progressive des liens
        navLinks.forEach((link, index) => {
            link.style.opacity = '0';
            link.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                link.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                link.style.opacity = '1';
                link.style.transform = 'translateY(0)';
            }, 100 + (index * 70));
        });

        // Ajout d'un effet sur le lien actif
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('bg-blue-500/20', 'text-blue-300', 'font-bold', 'scale-105');
            }
        });

        // Effet de scroll pour la navbar
        let lastScrollTop = 0;
        const navbar = document.querySelector('nav');
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop && scrollTop > 100) {
                // Scroll down - hide navbar
                navbar.style.transform = 'translateY(-100%)';
            } else {
                // Scroll up - show navbar
                navbar.style.transform = 'translateY(0)';
            }
            
            // Add glow effect when scrolling
            if (scrollTop > 50) {
                navbar.classList.add('shadow-2xl', 'shadow-blue-500/10');
            } else {
                navbar.classList.remove('shadow-2xl', 'shadow-blue-500/10');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    });

    // Ajout d'un effet de pulse sur l'icône du panier si des produits sont ajoutés
    if (parseInt("{{ session('cart') ? count(session('cart')) : 0 }}") > 0) {
        const cartIcons = document.querySelectorAll('a[href="{{ route("cart.index") }}"] svg');
        cartIcons.forEach(icon => {
            icon.classList.add('animate-pulse');
            setTimeout(() => {
                icon.classList.remove('animate-pulse');
            }, 2000);
        });
    }

    // Animation hover pour les éléments du dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownItems = document.querySelectorAll('.group\\/item');
        dropdownItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
    });
</script>

<style>
    /* Transitions fluides pour la navbar */
    nav {
        transition: all 0.3s ease-in-out;
    }
    
    /* Animation des liens de navigation */
    nav a {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Effet de glow pour les boutons */
    button:hover, a:hover {
        filter: brightness(1.1);
    }
    
    /* Animation du gradient du logo */
    .bg-clip-text {
        background-size: 200% 200%;
        animation: gradient 3s ease infinite;
    }
    
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .max-w-7xl {
            max-width: 100%;
        }
    }
    
    @media (max-width: 640px) {
        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
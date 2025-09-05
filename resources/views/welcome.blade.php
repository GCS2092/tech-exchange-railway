<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechExchange - Appareils Électroniques</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/mobile-responsive.css') }}">
</head>
<body class="bg-white text-black">

@if(session('success'))
    <div class="fixed top-4 right-4 bg-black text-white px-6 py-3 z-50">
        {{ session('success') }}
    </div>
@endif

<!-- Navigation -->
<nav class="fixed top-0 w-full bg-white border-b border-gray-200 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">T</span>
                </div>
                <span class="text-lg sm:text-xl font-bold text-black">TechExchange</span>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('products.index') }}" class="text-black hover:text-gray-600 transition-colors">Produits</a>
                <a href="{{ route('trades.search') }}" class="text-black hover:text-gray-600 transition-colors">Échanges</a>
                <a href="{{ route('help.client') }}" class="text-black hover:text-gray-600 transition-colors">Support</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-black text-white px-4 py-2 hover:bg-gray-800 transition-all">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-black text-white px-4 py-2 hover:bg-gray-800 transition-all">
                        Se connecter
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-black hover:text-gray-600 transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('products.index') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors">Produits</a>
                <a href="{{ route('trades.search') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors">Échanges</a>
                <a href="{{ route('help.client') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors">Support</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-black hover:bg-gray-50 rounded-lg transition-colors">Se connecter</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>

<!-- Hero Section - Style Nike "Just Do It" -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-white pt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Left Side - Text -->
            <div class="text-left">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-8xl font-black mb-4 sm:mb-6 leading-tight text-black">
                    JUST DO IT.
        </h1>
                <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl text-gray-600 mb-6 sm:mb-8 font-light">
            L'avenir de l'électronique à portée de main
                </p>
                <p class="text-base sm:text-lg lg:text-xl text-gray-500 mb-8 sm:mb-12 max-w-2xl leading-relaxed">
            Smartphones dernière génération, ordinateurs ultra-performants, accessoires gaming... 
            Découvrez notre sélection d'appareils électroniques avec possibilité d'échange et garantie premium.
        </p>

                <!-- CTA Buttons - Style Nike -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                    <a href="{{ route('products.index') }}" class="bg-black text-white px-6 sm:px-8 py-3 sm:py-4 font-semibold text-center hover:bg-gray-800 transition-all duration-300 text-sm sm:text-base">
                        EXPLORER LES PRODUITS
                    </a>
                    <a href="{{ route('trades.search') }}" class="bg-gray-100 text-black px-6 sm:px-8 py-3 sm:py-4 font-semibold text-center hover:bg-gray-200 transition-all duration-300 border border-gray-300 text-sm sm:text-base">
                        SYSTÈME D'ÉCHANGE
                    </a>
        </div>
            </div>
            
            <!-- Right Side - Product Image -->
            <div class="flex justify-center lg:justify-end mt-8 lg:mt-0">
                <div class="w-64 h-64 sm:w-80 sm:h-80 lg:w-96 lg:h-96 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-mobile-alt text-xl sm:text-2xl text-gray-400"></i>
            </div>
            </div>
        </div>
    </div>
</section>

<!-- New Collection Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Text -->
            <div class="text-left">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-black">
                    NEW COLLECTION
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Découvrez nos dernières nouveautés en matière de technologie
                </p>
                <a href="{{ route('products.index') }}" class="bg-black text-white px-8 py-4 font-semibold inline-block hover:bg-gray-800 transition-all duration-300">
                    SHOP NOW
                </a>
        </div>

            <!-- Right Side - Product Image -->
            <div class="flex justify-center lg:justify-start">
                <div class="w-80 h-80 lg:w-96 lg:h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                    <i class="fas fa-laptop text-2xl text-gray-500"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Product Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Product Image -->
            <div class="flex justify-center lg:justify-end">
                <div class="w-80 h-80 lg:w-96 lg:h-96 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-headphones text-2xl text-gray-400"></i>
                </div>
            </div>

            <!-- Right Side - Text -->
            <div class="text-left">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 text-black">
                    FEATURED PRODUCT
                </h2>
                <p class="text-xl text-gray-600 mb-8">
                    Nos produits vedettes sélectionnés avec soin
                </p>
                <a href="{{ route('products.index') }}" class="bg-black text-white px-8 py-4 font-semibold inline-block hover:bg-gray-800 transition-all duration-300">
                    SHOP NOW
                        </a>
                    </div>
                </div>
            </div>
</section>

<!-- Stats Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl md:text-5xl font-bold text-black mb-2">1000+</div>
                <div class="text-gray-600">Produits disponibles</div>
                    </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold text-black mb-2">500+</div>
                <div class="text-gray-600">Clients satisfaits</div>
                </div>
                        <div>
                <div class="text-4xl md:text-5xl font-bold text-black mb-2">24/7</div>
                <div class="text-gray-600">Support client</div>
            </div>
            <div>
                <div class="text-4xl md:text-5xl font-bold text-black mb-2">100%</div>
                <div class="text-gray-600">Garantie qualité</div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-black mb-6">
                POURQUOI NOUS CHOISIR
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez ce qui fait de TechExchange la référence en matière d'électronique
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">Qualité Garantie</h3>
                <p class="text-gray-600">Tous nos produits sont testés et garantis pour votre satisfaction</p>
            </div>

            <div class="text-center p-8">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-exchange-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">Système d'Échange</h3>
                <p class="text-gray-600">Échangez vos anciens appareils contre de nouveaux modèles</p>
            </div>

            <div class="text-center p-8">
                <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-truck text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-black mb-4">Livraison Rapide</h3>
                <p class="text-gray-600">Livraison gratuite et rapide dans toute la France</p>
            </div>
        </div>
    </div>
</section>

<!-- Système d'Échange Section -->
<section class="py-20 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-black mb-6">
                SYSTÈME D'ÉCHANGE
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Échangez vos anciens appareils contre de nouveaux modèles. Un processus simple et sécurisé pour maximiser la valeur de vos équipements.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <!-- Left Side - Comment ça marche -->
            <div class="text-left">
                <h3 class="text-3xl font-bold text-black mb-6">Comment ça marche ?</h3>
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">1</div>
                        <div>
                            <h4 class="text-lg font-semibold text-black mb-2">Évaluation en ligne</h4>
                            <p class="text-gray-600">Décrivez votre appareil et recevez une estimation instantanée de sa valeur d'échange.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                        <div>
                            <h4 class="text-lg font-semibold text-black mb-2">Validation technique</h4>
                            <p class="text-gray-600">Nos experts vérifient l'état de votre appareil pour confirmer la valeur proposée.</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-4">
                        <div class="w-8 h-8 bg-black text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                        <div>
                            <h4 class="text-lg font-semibold text-black mb-2">Échange finalisé</h4>
                            <p class="text-gray-600">Recevez votre nouvel appareil avec la différence de prix ou l'argent complémentaire.</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="{{ route('trades.search') }}" class="bg-black text-white px-8 py-4 font-semibold inline-block hover:bg-gray-800 transition-all duration-300">
                        COMMENCER UN ÉCHANGE
                    </a>
                </div>
            </div>

            <!-- Right Side - Produits populaires -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-black mb-6 text-center">Appareils les plus échangés</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-gray-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-black">Smartphones</h4>
                            <p class="text-sm text-gray-600">iPhone, Samsung, Huawei...</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">Jusqu'à 70%</p>
                            <p class="text-xs text-gray-500">de la valeur</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-laptop text-gray-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-black">Ordinateurs</h4>
                            <p class="text-sm text-gray-600">MacBook, PC portables...</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">Jusqu'à 60%</p>
                            <p class="text-xs text-gray-500">de la valeur</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i class="fas fa-gamepad text-gray-600"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-black">Gaming</h4>
                            <p class="text-sm text-gray-600">PS5, Xbox, Nintendo...</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-green-600">Jusqu'à 65%</p>
                            <p class="text-xs text-gray-500">de la valeur</p>
                        </div>
                    </div>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('trades.search') }}" class="text-black font-semibold hover:text-gray-600 transition-colors">
                        Voir tous les appareils échangeables →
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6">
            PRÊT À COMMENCER ?
        </h2>
        <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
            Rejoignez des milliers de clients satisfaits et découvrez la technologie de demain
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('products.index') }}" class="bg-white text-black px-8 py-4 font-semibold hover:bg-gray-100 transition-all duration-300">
                EXPLORER LES PRODUITS
            </a>
            <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-4 font-semibold hover:bg-white hover:text-black transition-all duration-300">
                CRÉER UN COMPTE
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                        <span class="text-black font-bold text-sm">T</span>
                    </div>
                    <span class="text-2xl font-bold">TechExchange</span>
                </div>
                <p class="text-gray-400 mb-6 max-w-md">
                    La plateforme innovante pour acheter, vendre et échanger vos appareils électroniques.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center text-white hover:bg-gray-700 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition-colors">Produits</a></li>
                    <li><a href="{{ route('trades.search') }}" class="text-gray-400 hover:text-white transition-colors">Échanges</a></li>
                    <li><a href="{{ route('help.client') }}" class="text-gray-400 hover:text-white transition-colors">Aide</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">À propos</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-400">contact@techexchange.com</li>
                    <li class="text-gray-400">+33 1 23 45 67 89</li>
                    <li class="text-gray-400">Paris, France</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} TechExchange. Tous droits réservés.</p>
        </div>
    </div>
</footer>

</body>
</html>
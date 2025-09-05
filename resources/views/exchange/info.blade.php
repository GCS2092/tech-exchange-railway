<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système d'Échange - TechHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
        .animate-fadeInUp-delay { animation: fadeInUp 0.8s ease-out 0.2s both; }
        .animate-fadeInUp-delay2 { animation: fadeInUp 0.8s ease-out 0.4s both; }
    </style>
</head>
<body class="bg-gray-900 text-white">

    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fadeInUp">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fadeInUp">
            {{ session('info') }}
        </div>
    @endif

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-gray-900/95 backdrop-blur-md border-b border-gray-800 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">T</span>
                        </div>
                        <span class="text-xl font-bold text-white">TechHub</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-300 hover:text-cyan-400 transition-colors">Accueil</a>
                    <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-cyan-400 transition-colors">Produits</a>
                    <a href="{{ route('help.client') }}" class="text-gray-300 hover:text-cyan-400 transition-colors">Support</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 px-4 py-2 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 rounded-lg hover:from-cyan-600 hover:to-blue-700 transition-all">
                            Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-16 min-h-screen flex items-center justify-center relative overflow-hidden">
        <!-- Background -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-blue-900/20 to-cyan-900/30"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #0ea5e9 0%, transparent 50%), radial-gradient(circle at 75% 75%, #3b82f6 0%, transparent 50%); opacity: 0.1;"></div>
        
        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-cyan-500/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-blue-500/20 rounded-full blur-xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-20 left-1/3 w-24 h-24 bg-indigo-500/20 rounded-full blur-xl animate-pulse delay-2000"></div>

        <div class="relative z-10 text-center max-w-6xl mx-auto px-4">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 bg-gray-800/50 border border-cyan-500/30 rounded-full text-cyan-400 text-sm font-medium mb-8 backdrop-blur-sm animate-fadeInUp">
                <div class="w-2 h-2 bg-cyan-400 rounded-full mr-2 animate-pulse"></div>
                Système d'échange révolutionnaire
            </div>

            <!-- Main Title -->
            <h1 class="text-2xl md:text-8xl font-black mb-6 leading-tight animate-fadeInUp">
                <span class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 bg-clip-text text-transparent">
                    ÉCHANGE
                </span>
                <span class="text-white">INTELLIGENT</span>
            </h1>

            <h2 class="text-2xl md:text-2xl font-light text-gray-300 mb-8 animate-fadeInUp-delay">
                Donnez une seconde vie à vos appareils électroniques
            </h2>

            <!-- Description -->
            <p class="text-xl text-gray-400 mb-12 max-w-3xl mx-auto leading-relaxed animate-fadeInUp-delay2">
                Échangez vos anciens smartphones, ordinateurs, tablettes contre des appareils récents. 
                Processus simple, estimation gratuite, prise en charge rapide garantie.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto mb-12 animate-fadeInUp-delay2">
                <div class="text-center">
                    <div class="text-xl md:text-2xl font-bold text-cyan-400 mb-2">{{ $stats['total_exchanges'] }}+</div>
                    <div class="text-gray-400 text-sm">Échanges réalisés</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-2xl font-bold text-green-400 mb-2">{{ $stats['satisfied_customers'] }}%</div>
                    <div class="text-gray-400 text-sm">Clients satisfaits</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-2xl font-bold text-blue-400 mb-2">{{ $stats['average_savings'] }}%</div>
                    <div class="text-gray-400 text-sm">D'économies moyennes</div>
                </div>
                <div class="text-center">
                    <div class="text-xl md:text-2xl font-bold text-purple-400 mb-2">{{ $stats['processing_time'] }}h</div>
                    <div class="text-gray-400 text-sm">Traitement moyen</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Comment ça marche -->
    <section class="py-20 bg-gray-800 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl font-bold text-white mb-4">Comment fonctionne notre système d'échange ?</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Un processus simple en 4 étapes pour maximiser la valeur de vos appareils
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Étape 1 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Évaluation en ligne</h3>
                    <p class="text-gray-400">
                        Décrivez votre appareil via notre plateforme sécurisée. Recevez une estimation instantanée et personnalisée.
                    </p>
                </div>

                <!-- Étape 2 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Validation technique</h3>
                    <p class="text-gray-400">
                        Nos experts vérifient l'état de votre appareil et confirment la valeur d'échange proposée.
                    </p>
                </div>

                <!-- Étape 3 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Sélection du nouveau</h3>
                    <p class="text-gray-400">
                        Choisissez votre nouvel appareil dans notre catalogue. Complétez avec un paiement si nécessaire.
                    </p>
                </div>

                <!-- Étape 4 -->
                <div class="text-center group">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-2xl font-bold text-white">4</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">Échange finalisé</h3>
                    <p class="text-gray-400">
                        Livraison rapide de votre nouvel appareil. Votre ancien appareil est recyclé de manière responsable.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Appareils concernés -->
    <section class="py-20 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl font-bold text-white mb-4">Appareils éligibles à l'échange</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Large gamme d'appareils électroniques acceptés pour l'échange
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">
                @foreach($exchangeableCategories as $category)
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-6 text-center hover:border-cyan-500/50 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <h3 class="text-white font-semibold mb-2">{{ $category->name }}</h3>
                        <p class="text-gray-400 text-sm">{{ $category->products_count }} modèles</p>
                    </div>
                @endforeach
            </div>

            <!-- Exemples de produits populaires -->
            @if($popularExchangeProducts->count() > 0)
                <div class="text-center mb-12">
                    <h3 class="text-2xl font-bold text-white mb-8">Appareils les plus échangés</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($popularExchangeProducts->take(3) as $product)
                            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-6 hover:border-cyan-500/50 transition-all">
                                <h4 class="text-white font-semibold mb-2">{{ $product->name }}</h4>
                                <p class="text-cyan-400 font-bold">Jusqu'à {{ number_format($product->price * 0.7, 0, ',', ' ') }} FCFA</p>
                                <p class="text-gray-400 text-sm">de valeur d'échange</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact et Action -->
    <section class="py-20 bg-gradient-to-r from-cyan-600 via-blue-600 to-indigo-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-xl font-bold text-white mb-6">
                Prêt à échanger votre appareil ?
            </h2>
            
            <p class="text-xl text-cyan-100 mb-8 max-w-2xl mx-auto">
                Pour une prise en charge optimale et un processus fluide, utilisez notre plateforme en ligne.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                <a href="{{ route('exchange.start') }}" class="group relative px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl overflow-hidden transform hover:scale-105 transition-all duration-300">
                    <span class="relative z-10 flex items-center">
                        Commencer l'échange en ligne
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                
                <div class="text-center">
                    <p class="text-cyan-100 mb-2">Besoin d'aide ou d'informations ?</p>
                    <a href="tel:+221776543210" class="text-white font-semibold hover:text-cyan-200 transition-colors">
                        📞 +221 77 654 32 10
                    </a>
                </div>
            </div>

            <!-- Avantages de la plateforme -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-cyan-100">
                <div class="flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Compte requis pour sécurité</span>
                </div>
                <div class="flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Traitement ultra-rapide</span>
                </div>
                <div class="flex items-center justify-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>100% sécurisé</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ rapide -->
    <section class="py-20 bg-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-2xl font-bold text-white mb-4">Questions fréquentes</h2>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-3">Quels appareils puis-je échanger ?</h3>
                    <p class="text-gray-400">Smartphones, ordinateurs, tablettes, consoles de jeu, appareils photo, montres connectées et bien plus. L'appareil doit être fonctionnel.</p>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-3">Combien de temps prend l'évaluation ?</h3>
                    <p class="text-gray-400">L'estimation en ligne est instantanée. La validation technique prend en moyenne 24h après réception de votre appareil.</p>
                </div>

                <div class="bg-gray-900 rounded-xl p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-3">Pourquoi créer un compte ?</h3>
                    <p class="text-gray-400">Le compte garantit la sécurité de vos données, le suivi de votre échange et la protection contre la fraude. C'est gratuit et sécurisé.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer simplifié -->
    <footer class="bg-gray-900 border-t border-gray-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center space-x-2 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-cyan-400 to-blue-600 rounded-xl flex items-center justify-center">
                    <span class="text-white font-bold">T</span>
                </div>
                <span class="text-2xl font-bold text-white">TechHub</span>
            </div>
            <p class="text-gray-400 mb-6">Système d'échange d'appareils électroniques de confiance</p>
            <div class="flex justify-center space-x-6 text-sm">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-cyan-400 transition-colors">Accueil</a>
                <a href="{{ route('help.client') }}" class="text-gray-400 hover:text-cyan-400 transition-colors">Support</a>
                <a href="tel:+221776543210" class="text-gray-400 hover:text-cyan-400 transition-colors">Contact</a>
            </div>
        </div>
    </footer>

    <!-- Auto-hide messages -->
    <script>
        // Auto-hide success/info messages
        setTimeout(() => {
            const messages = document.querySelectorAll('.fixed.top-4.right-4');
            messages.forEach(message => {
                message.style.opacity = '0';
                message.style.transform = 'translateY(-20px)';
                setTimeout(() => message.remove(), 500);
            });
        }, 5000);
    </script>

</body>
</html>

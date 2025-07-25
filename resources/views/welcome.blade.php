@extends('layouts.app')

@section('content')
<!-- Hero Section avec design moderne -->
<div class="relative min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-indigo-50 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-gradient-to-br from-pink-400/20 to-purple-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 right-0 w-96 h-96 bg-gradient-to-br from-purple-400/20 to-indigo-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-0 left-1/2 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-pink-400/20 rounded-full blur-3xl animate-pulse delay-2000"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 flex items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-4xl mx-auto">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-pink-500/10 to-purple-500/10 border border-pink-200/50 text-pink-700 text-sm font-medium mb-8 animate-fade-in">
                <span class="w-2 h-2 bg-pink-500 rounded-full mr-2 animate-pulse"></span>
                Nouveaux produits disponibles
            </div>

            <!-- Main Title -->
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent animate-gradient">
                    Découvrez
                </span>
                <br>
                <span class="text-gray-800">la beauté naturelle</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-xl sm:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
                Une collection exclusive de produits cosmétiques naturels et bio, 
                sélectionnés avec soin pour prendre soin de votre peau et de votre bien-être.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="{{ route('products.index') }}" 
                   class="group relative px-8 py-4 bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <span class="relative z-10 flex items-center">
                        Explorer nos produits
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-pink-600 to-purple-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                
                <a href="{{ route('register') }}" 
                   class="group px-8 py-4 border-2 border-purple-300 text-purple-700 font-semibold rounded-2xl hover:bg-purple-50 hover:border-purple-400 transition-all duration-300">
                    Créer un compte
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 max-w-2xl mx-auto">
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-600 mb-2">500+</div>
                    <div class="text-gray-600">Produits naturels</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-pink-600 mb-2">10k+</div>
                    <div class="text-gray-600">Clients satisfaits</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-indigo-600 mb-2">24h</div>
                    <div class="text-gray-600">Livraison express</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</div>

<!-- Features Section -->
<section class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Pourquoi nous choisir ?</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Nous nous engageons à vous offrir les meilleurs produits cosmétiques naturels 
                avec un service client exceptionnel.
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group relative p-8 bg-gradient-to-br from-pink-50 to-purple-50 rounded-3xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-pink-500/5 to-purple-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Qualité Premium</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tous nos produits sont rigoureusement sélectionnés et testés pour garantir 
                        une qualité exceptionnelle et des résultats visibles.
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="group relative p-8 bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-indigo-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Livraison Express</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Recevez vos commandes en 24h avec notre service de livraison express. 
                        Suivez votre colis en temps réel.
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="group relative p-8 bg-gradient-to-br from-indigo-50 to-pink-50 rounded-3xl hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-pink-500/5 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Paiement Sécurisé</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Vos données sont protégées par un cryptage SSL de niveau bancaire. 
                        Paiement 100% sécurisé et confidentiel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Produits en Vedette</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Découvrez nos produits les plus populaires, sélectionnés spécialement pour vous.
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Quick Add Button -->
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center hover:bg-white transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors duration-200">
                        {{ $product->name }}
                    </h3>
                    <p class="text-2xl font-bold text-purple-600 mb-4">{{ $product->price }} €</p>
                    
                    <!-- Add to Cart Button -->
                    <button class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-semibold py-3 px-4 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                        Ajouter au panier
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- View All Products Button -->
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-semibold rounded-2xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                Voir tous les produits
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-gradient-to-r from-pink-500 to-purple-600 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-4">Restez informé</h2>
        <p class="text-xl text-pink-100 mb-8">
            Recevez en avant-première nos nouveautés et offres exclusives.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" placeholder="Votre adresse email" 
                   class="flex-1 px-6 py-4 rounded-2xl border-0 focus:ring-2 focus:ring-white/50 focus:outline-none text-gray-900">
            <button class="px-8 py-4 bg-white text-purple-600 font-semibold rounded-2xl hover:bg-gray-100 transition-colors duration-300">
                S'abonner
            </button>
        </div>
    </div>
</section>

<!-- Custom CSS for animations -->
<style>
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 1s ease-out;
}

@keyframes slide-in {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

.animate-slide-in {
    animation: slide-in 1s ease-out 0.5s both;
}
</style>

<x-onboarding-button tourId="welcome" position="fixed" />
@endsection

@push('scripts')
<script>
window.tourSteps_ = [
  {
    id: 'step-1',
    title: 'Bienvenue sur Mon Site Cosmétique',
    text: 'Découvrez nos <b>produits de beauté premium</b> et profitez de nos offres exclusives.',
    attachTo: { element: 'h1, .brand', on: 'bottom' },
    buttons: [ { text: 'Suivant', action: function() { tour.next(); } } ]
  },
  {
    id: 'step-2',
    title: 'Navigation intuitive',
    text: 'Utilisez le <b>menu principal</b> pour explorer les différentes sections du site.',
    attachTo: { element: 'nav, .nav-link', on: 'bottom' },
    buttons: [ { text: 'Terminer', action: function() { tour.complete(); } } ]
  }
];
window.showOnboardingTour = function(tourId, steps) {
  const tour = window.createCustomTour(steps);
  window.tour = tour;
  tour.start();
};
</script>
@endpush

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js/dist/css/shepherd.css">
<script src="https://cdn.jsdelivr.net/npm/shepherd.js/dist/js/shepherd.min.js"></script>
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black flex items-center justify-center px-4 py-12 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="30" cy="30" r="2"/></g></svg>');"></div>
    </div>
    
    <!-- Main Card - Style Nike Premium -->
    <div class="relative w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl p-12 text-center border border-gray-100 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-50 to-transparent rounded-full -translate-y-16 translate-x-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-gray-50 to-transparent rounded-full translate-y-12 -translate-x-12"></div>
            
            <!-- Icon -->
            <div class="relative mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-900 to-black rounded-2xl flex items-center justify-center mx-auto shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <!-- Pulse Effect -->
                <div class="absolute inset-0 w-20 h-20 bg-gray-900 rounded-2xl mx-auto animate-ping opacity-20"></div>
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">
                À BIENTÔT
            </h1>
            
            <!-- Subtitle -->
            <div class="h-1 w-20 bg-gray-900 mx-auto mb-6 rounded-full"></div>
            
            <!-- Message -->
            <p class="text-gray-600 text-lg mb-10 leading-relaxed max-w-sm mx-auto">
                Merci d'avoir utilisé notre plateforme. Nous espérons vous revoir bientôt !
            </p>
            
            <!-- Reconnect Button - Style Nike -->
            <div class="mb-10">
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 bg-black text-white font-bold rounded-2xl shadow-xl hover:bg-gray-800 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl focus:outline-none focus:ring-4 focus:ring-gray-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span class="tracking-wide">SE RECONNECTER</span>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <div class="flex justify-center space-x-8 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-900 transition-colors duration-300 flex items-center group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7-7v18" />
                    </svg>
                    <span class="font-semibold tracking-wide">ACCUEIL</span>
                </a>
                
                <a href="mailto:contact@techworld.com" class="text-gray-500 hover:text-gray-900 transition-colors duration-300 flex items-center group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="font-semibold tracking-wide">CONTACT</span>
                </a>
                
                <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-900 transition-colors duration-300 flex items-center group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="font-semibold tracking-wide">PRODUITS</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Help Button -->
    <div class="fixed bottom-6 right-6">
        <button class="w-14 h-14 bg-gray-900 text-white rounded-full shadow-xl hover:bg-gray-800 transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>
    </div>
</div>

<style>
/* Animations personnalisées */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
}

/* Effet de brillance sur le bouton */
.group:hover .group-hover\:translate-x-1 {
    transform: translateX(0.25rem);
}
</style>

<script>
// Animation d'entrée
document.addEventListener('DOMContentLoaded', function() {
    const card = document.querySelector('.bg-white');
    card.classList.add('animate-fadeInUp');
});
</script>
@endsection
@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-r from-indigo-700 via-purple-600 to-indigo-600 flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 rounded-2xl shadow-2xl p-8 border border-white border-opacity-20 text-center">
        <div class="mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </div>
        
        <h1 class="text-xl sm:text-2xl font-extrabold text-white mb-4 tracking-tight">
            Vous avez été déconnecté
        </h1>
        
        <div class="h-1 w-16 bg-indigo-300 mx-auto my-4 rounded-full"></div>
        
        <p class="text-indigo-100 text-lg mb-8">
            Merci d'avoir utilisé notre plateforme. Nous espérons vous revoir bientôt !
        </p>
        
        <div class="mt-8">
            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:bg-indigo-50 transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Se reconnecter</span>
            </a>
        </div>
        
        <div class="mt-12 flex justify-center space-x-4">
            <a href="{{ route('home') }}" class="text-indigo-100 hover:text-white transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7-7v14" />
                </svg>
                Accueil
            </a>
            
            <a href="/contact">Contactez-nous</a>

            
            <a href="/about">À propos</a>
        </div>
    </div>
</div>
@endsection
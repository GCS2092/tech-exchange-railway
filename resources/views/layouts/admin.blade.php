<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Assets compilés -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-CyCvDCPa.css') }}">
    <link rel="stylesheet" href="{{ asset('build/assets/admin-pWb8ZbA5.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nike-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icons-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/soften-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-improvements.css') }}">
    <script type="module" src="{{ asset('build/assets/app-n1eXXn1V.js') }}"></script>
    
    <!-- Force reload pour éviter les problèmes de cache -->
    <script>
        // Vider le cache du service worker s'il existe
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                for(let registration of registrations) {
                    registration.unregister();
                });
            });
        }
        
        // Désactiver les tentatives de connexion Vite en production
        if (typeof window !== 'undefined' && window.location.hostname !== 'localhost' && window.location.hostname !== '127.0.0.1') {
            window.__VITE_PROD__ = true;
        }
        
        // Correction de la mise en page
        document.addEventListener('DOMContentLoaded', function() {
            // Forcer la largeur correcte
            document.body.style.width = '100vw';
            document.body.style.maxWidth = '100vw';
            document.body.style.overflowX = 'hidden';
            
            // Empêcher l'affichage en mode fenêtre
            if (window.navigator.userAgent.includes('Electron')) {
                document.body.style.webkitAppRegion = 'no-drag';
            }
            
            // Correction pour les conteneurs
            const containers = document.querySelectorAll('.container, .max-w-7xl');
            containers.forEach(container => {
                container.style.maxWidth = '100%';
                container.style.overflowX = 'hidden';
            });
        });
    </script>
</head>
<body class="bg-gray-100 min-h-screen overflow-x-hidden">
    @include('layouts.admin-navigation')
    <main class="min-h-screen pt-16">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html> 
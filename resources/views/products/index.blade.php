<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site Cosmétique | Produits de beauté premium</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f3e8ff 100%);
            color: #22223b;
        }

        h1, h2, h3, .brand {
            font-family: 'Playfair Display', serif;
        }

        /* Elements with custom animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.7s cubic-bezier(.4,0,.2,1) both;
        }

        /* Glass morphism effect */
        .glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.10);
        }
        
        .glass-dark {
            background: rgba(44, 44, 44, 0.8);
            backdrop-filter: blur(7px);
            -webkit-backdrop-filter: blur(7px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15);
        }

        /* Navigation Styles */
        .brand { 
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--primary-color);
            letter-spacing: -0.5px;
        }

        .nav-link {
            position: relative;
            font-weight: 600;
            color: var(--text-color);
            transition: color 0.3s ease;
            padding-bottom: 3px;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color);
        }

        .nav-link:hover:after, .nav-link.active:after {
            width: 100%;
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(90deg, #ff3e83, #7e57c2);
            color: #fff;
            font-weight: 700;
            border-radius: 9999px;
            padding: 12px 32px;
            box-shadow: 0 4px 20px rgba(255,62,131,0.10);
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            position: relative;
            overflow: hidden;
            z-index: 1;
            letter-spacing: 0.3px;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #e6007e, #5f3dc4);
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 32px rgba(126,87,194,0.15);
        }

        .btn-primary:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .btn-primary:hover:before {
            left: 100%;
        }

        .btn-secondary {
            background: #fff;
            color: #ff3e83;
            border: 2px solid #ff3e83;
            font-weight: 700;
            border-radius: 9999px;
            padding: 12px 32px;
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            letter-spacing: 0.3px;
        }

        .btn-secondary:hover {
            background: #ff3e83;
            color: #fff;
            border-color: #ff3e83;
            transform: translateY(-2px) scale(1.04);
        }

        /* Product Card Styles */
        .card {
            border-radius: 1.5rem;
            background: #fff;
            box-shadow: 0 4px 24px rgba(126,87,194,0.07);
            transition: box-shadow 0.3s, transform 0.3s;
            position: relative;
            z-index: 1;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.8));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        .card:hover {
            box-shadow: 0 12px 32px rgba(255,62,131,0.10);
            transform: translateY(-6px) scale(1.02);
        }

        .card:hover::before {
            opacity: 0.4;
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: linear-gradient(90deg, #ff3e83, #7e57c2);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.25rem 0.75rem;
            box-shadow: 0 2px 8px rgba(255,62,131,0.10);
            z-index: 10;
        }

        /* Form Controls */
        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 50px;
            padding: 10px 16px;
            width: 100%;
            transition: all 0.3s ease;
            background-color: #fff;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 62, 131, 0.15);
            outline: none;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232d3748'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .page-item {
            margin: 0 2px;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            color: var(--text-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #f3f4f6;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            color: white;
        }

        /* Floating Label for Inputs */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-label {
            position: absolute;
            top: 0;
            left: 16px;
            padding: 10px 0;
            pointer-events: none;
            transition: 0.3s ease all;
            color: #a0aec0;
        }

        .form-control:focus ~ .form-label,
        .form-control:not(:placeholder-shown) ~ .form-label {
            top: -25px;
            left: 5px;
            font-size: 12px;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Custom Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e8f0;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary-color);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        /* Footer Styles */
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Hero Section Gradient */
        .hero-gradient {
            background: linear-gradient(135deg, #ff79c6, #bd93f9);
        }

        /* Product Image Overlay */
        .product-image-wrapper {
            position: relative;
            overflow: hidden;
        }

        .product-image-wrapper img {
            transition: transform 0.5s ease;
        }

        .product-image-wrapper:hover img {
            transform: scale(1.05);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0,0,0,0.7));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-image-wrapper:hover .product-overlay {
            opacity: 1;
        }

        /* Custom currency badge */
        .currency-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            background-color: #f3f4f6;
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .currency-badge:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Features Icon Box */
        .feature-box {
            padding: 20px;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 62, 131, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: var(--primary-color);
            font-size: 24px;
        }

        /* Styles pour les cartes de produits */
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Styles pour les boutons */
        .btn {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Styles pour les inputs et selects */
        .form-input, .form-select {
            transition: all 0.3s ease;
        }

        .form-input:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        }

        /* Styles pour la pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination li {
            margin: 0 0.25rem;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background-color: white;
            color: #4B5563;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background-color: #F3F4F6;
            transform: translateY(-2px);
        }

        .pagination .active a {
            background-color: #EC4899;
            color: white;
        }

        /* Animation pour le chargement des produits */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Styles pour les filtres */
        .filter-section {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .filter-section:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Styles pour les badges de statut */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge i {
            margin-right: 0.25rem;
        }

        /* Styles pour les images de produits */
        .product-image {
            position: relative;
            overflow: hidden;
            border-radius: 1rem 1rem 0 0;
        }

        .product-image img {
            transition: transform 0.5s ease;
        }

        .product-image:hover img {
            transform: scale(1.1);
        }

        /* Styles pour les prix */
        .price {
            font-weight: 600;
            color: #EC4899;
        }

        .old-price {
            text-decoration: line-through;
            color: #9CA3AF;
            font-size: 0.875rem;
        }

        /* Styles pour les boutons d'action */
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
        }

        .action-button:active {
            transform: translateY(0);
        }

        /* Styles pour les icônes */
        .icon {
            transition: transform 0.3s ease;
        }

        .action-button:hover .icon {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- PHP pour le panier - avant le rendu de la page -->
    @php
        $cart = session()->get('cart', []);
        $cartCount = collect($cart)->sum('quantity');
        $currentCurrency = session('currency', 'XOF');
    @endphp

    <!-- Navigation - Glass Morphism Effect -->
    <nav class="glass sticky top-0 z-50 py-4 px-6 md:px-8 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo/Brand -->
            <a href="{{ route('dashboard') }}" class="brand flex items-center">
                <svg class="w-8 h-8 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                     <path d="M12.5 7.5C12.5 7.77614 12.2761 8 12 8C11.7239 8 11.5 7.77614 11.5 7.5C11.5 7.22386 11.7239 7 12 7C12.2761 7 12.5 7.22386 12.5 7.5Z" fill="currentColor" stroke="currentColor"/>
                    <path d="M12 16V10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span>Luxe Cosmétique</span>
            </a>

            <!-- Main Navigation Links -->
<div class="hidden md:flex space-x-8">
    <a href="{{ route('dashboard') }}" class="nav-link active">Accueil</a>
    <a href="{{ route('products.index') }}" class="nav-link">Produits</a>
    <a href="{{ route('orders.index') }}" class="nav-link">Commandes</a>
    <a href="{{ route('promos.index') }}" class="nav-link">Codes Promos</a>
    <a href="{{ route('fidelity.calendar') }}" class="nav-link">Fidélité</a>
    <a href="{{ route('favorites.index') }}" class="nav-link">Coup De Coeur</a>
</div>

            <!-- User Actions -->
            <div class="flex space-x-6 items-center">
                <!-- Currency Selector with Icon -->
                <div class="relative">
                    <select name="currency" id="currency-selector" class="form-control py-2 pl-9 pr-10 text-sm" onchange="changeCurrency(this.value)">
                        <option value="XOF" {{ $currentCurrency == 'XOF' ? 'selected' : '' }}>XOF (FCFA)</option>
                        <option value="EUR" {{ $currentCurrency == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                        <option value="USD" {{ $currentCurrency == 'USD' ? 'selected' : '' }}>USD ($)</option>
                    </select>
                    <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
                
                <!-- Shopping Cart with Animation -->
                <a href="{{ route('cart.index') }}" class="relative group">
                    <div class="p-2 bg-white rounded-full shadow-md transition-all duration-300 group-hover:bg-pink-50 group-hover:shadow-lg">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-pink-500 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="badge">{{ $cartCount }}</span>
                </a>

                <!-- User Dropdown with Avatar -->
                <div class="relative">
                    @if (Auth::check())
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none" id="userMenu">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-700 to-purple-600 flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="hidden md:block">
                                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Mon compte</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <!-- Menu déroulant -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 hidden z-50">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                Tableau de bord
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Mon profil
                            </a>
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                Mes commandes
                            </a>
                            @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-100 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                                Administration
                            </a>
                            @endif
                            <div class="border-t border-gray-200 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-gray-800 hover:bg-indigo-100 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414l-5-5H3zm7 5a1 1 0 10-2 0v4.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L12 12.586V8z" clip-rule="evenodd" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-md transform transition-transform hover:-translate-y-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span>Connexion</span>
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-white hover:bg-gray-100 text-indigo-700 border border-indigo-300 rounded-lg shadow-md transform transition-transform hover:-translate-y-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                            <span>Inscription</span>
                        </a>
                    </div>
                @endif

                    <!-- Dropdown Menu with Animation -->
                    <div id="userDropdown" class="absolute right-0 mt-3 w-64 bg-white shadow-xl rounded-xl z-50 hidden overflow-hidden fade-in transform origin-top-right">
                        <div class="px-4 py-3 bg-gradient-to-r from-pink-400 to-purple-500 text-white">
                            <p class="text-sm font-bold">{{ Auth::user()->name ?? 'Bienvenue' }}</p>
                            <p class="text-xs opacity-80">{{ Auth::user()->email ?? 'Connectez-vous pour continuer' }}</p>
                        </div>
                        <div id="userDropdown" class="absolute right-0 mt-3 w-64 bg-white shadow-xl rounded-xl z-50 hidden overflow-hidden fade-in transform origin-top-right">
                            <div class="px-4 py-3 bg-gradient-to-r from-pink-400 to-purple-500 text-white">
                                <p class="text-sm font-bold">{{ Auth::user()->name ?? 'Bienvenue' }}</p>
                                <p class="text-xs opacity-80">{{ Auth::user()->email ?? 'Connectez-vous pour continuer' }}</p>
                            </div>
                            <div class="py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center">
                                    <i class="fas fa-user-circle mr-3 text-gray-400"></i> Mon Profil
                                </a>
                                @if(Auth::check())
                                    <!-- Ajout du lien vers les favoris -->
                                    <a href="{{ route('favorites.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center">
                                        <i class="fas fa-heart mr-3 text-gray-400"></i> Mes Favoris
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center">
                                        <i class="fas fa-box mr-3 text-gray-400"></i> Mes Commandes
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition duration-200 flex items-center">
                                            <i class="fas fa-sign-out-alt mr-3 text-red-400"></i> Déconnexion
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center">
                                        <i class="fas fa-sign-in-alt mr-3 text-gray-400"></i> Connexion
                                    </a>
                                    <a href="{{ route('register') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition duration-200 flex items-center">
                                        <i class="fas fa-user-plus mr-3 text-gray-400"></i> Créer un compte
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <section class="mb-16 relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-500 to-pink-500">
            <div class="absolute inset-0 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <defs>
                        <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse" patternTransform="rotate(45)">
                            <rect width="100%" height="100%" fill="none"/>
                            <circle cx="20" cy="20" r="2" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#pattern)" />
                </svg>
            </div>
            <div class="container mx-auto px-6 py-16 md:py-24 relative z-10">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 md:pr-12 text-center md:text-left mb-10 md:mb-0">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                            Révélez votre <span class="relative">beauté<span class="absolute bottom-2 left-0 w-full h-2 bg-white opacity-30"></span></span> naturelle
                        </h1>
                        <p class="text-lg md:text-xl text-white opacity-90 mb-10">
                            Découvrez notre collection de produits cosmétiques premium, éthiques et efficaces pour sublimer votre routine beauté.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-6">
                            <a href="{{ route('products.index') }}" class="btn-primary text-center">
                                Découvrir nos produits
                            </a>
                            <a href="#" class="btn-secondary bg-white border-white text-pink-500 text-center">
                                Nos best-sellers
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/2 relative flex flex-col items-center justify-center gap-6">
                        @php $firstTwo = $products->take(2); @endphp
                        <div class="flex flex-col sm:flex-row gap-6 w-full justify-center items-center">
                            @foreach($firstTwo as $product)
                                <a href="{{ route('products.show', $product->id) }}" class="group block w-64 h-64 md:w-72 md:h-72 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-300 relative bg-white/30">
                                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                        <span class="text-white text-lg font-bold drop-shadow">{{ $product->name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="mb-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Produits Naturels</h3>
                    <p class="text-gray-600">Nos cosmétiques sont formulés à partir d'ingrédients naturels et biologiques.</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Qualité Premium</h3>
                    <p class="text-gray-600">Nous sélectionnons uniquement des ingrédients de la plus haute qualité pour nos formulations.</p>
                </div>
                
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Non testé sur les animaux</h3>
                    <p class="text-gray-600">Tous nos produits sont cruelty-free et respectueux de l'environnement.</p>
                </div>
            </div>
        </section>
        
        <!-- Page Header with Animation -->
        <section class="mb-8 text-center relative">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
                Nos Produits
                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-pink-500 rounded"></span>
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">Découvrez notre sélection de produits cosmétiques haut de gamme et nos offres exclusives.</p>
        </section>
        
        <!-- Filtres et Recherche -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- 🔍 Recherche par nom -->
                <div class="relative">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher un produit</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                            placeholder="Ex: Crème hydratante..." 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 pl-10">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
            
                <!-- 📁 Catégorie -->
                <div class="relative">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <div class="relative">
                        <select name="category_id" id="category_id" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 appearance-none">
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- 💰 Prix -->
                <div class="relative">
                    <label for="price_range" class="block text-sm font-medium text-gray-700 mb-2">Prix</label>
                    <div class="relative">
                        <select name="price_range" id="price_range" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 appearance-none">
                            <option value="">Tous les prix</option>
                            <option value="0-20" {{ request('price_range') == '0-20' ? 'selected' : '' }}>Moins de 20€</option>
                            <option value="20-50" {{ request('price_range') == '20-50' ? 'selected' : '' }}>20€ - 50€</option>
                            <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>50€ - 100€</option>
                            <option value="100+" {{ request('price_range') == '100+' ? 'selected' : '' }}>Plus de 100€</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- 🔄 Trier par -->
                <div class="relative">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <div class="relative">
                        <select name="sort" id="sort" 
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all duration-300 appearance-none">
                            <option value="">Sélectionner</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom Z-A</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récent</option>
                        </select>
                        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Admin filter options -->
            @if(auth()->check() && auth()->user()->isAdmin())
                <div class="mt-6 flex justify-between items-center bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl">
                    <h2 class="text-xl font-semibold flex items-center">
                        <span class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-600 rounded-full mr-2 shadow-sm">
                            <i class="fas fa-crown text-sm"></i>
                        </span>
                        Administration des Produits
                    </h2>
                    <form method="GET" action="{{ route('products.index') }}" class="flex">
                        <select name="filter" onchange="this.form.submit()" 
                            class="px-4 py-2 bg-white border border-purple-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 text-sm">
                            <option value="">-- Tous les produits --</option>
                            <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>En Stocks</option>
                            <option value="inactive" {{ request('filter') == 'inactive' ? 'selected' : '' }}>En Rupture</option>
                        </select>
                    </form>
                </div>
            @endif
        </div>

        <!-- Pagination Top -->
        <div class="mb-6 flex justify-center">
            {{ $products->withQueryString()->links() }}
        </div>
        
        <!-- Product Grid avec cards améliorées -->
        <div id="product-list" class="py-8">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group flex flex-col h-full">
                        <!-- Product Image avec overlay et effets -->
                        <div class="relative h-56 sm:h-64 overflow-hidden flex-shrink-0">
                            <img 
                                src="{{ Str::startsWith($product->image, 'http') 
                                    ? $product->image 
                                    : asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <!-- Quick Actions Buttons -->
                            <div class="absolute top-4 right-4 space-y-2 z-10">
                                <!-- Admin Status Badge -->
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <span class="{{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs px-3 py-1 rounded-full font-medium flex items-center shadow-lg">
                                        <i class="fas {{ $product->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $product->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                @endif
                                <!-- Quick View Button -->
                                <a href="{{ route('products.show', $product->id) }}" class="w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center text-gray-600 hover:text-pink-500 transition-all duration-300 hover:bg-pink-50 transform hover:scale-110" title="Voir le détail du produit">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Product Details avec design amélioré -->
                        <div class="p-4 flex flex-col flex-1">
                            <!-- Category Badge -->
                            <div class="mb-2">
                                <span class="inline-block px-3 py-1 text-xs font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full shadow-sm">
                                    {{ $product->category->name ?? 'Non catégorisé' }}
                                </span>
                            </div>
                            <!-- Title and Description -->
                            <h3 class="text-lg font-semibold mb-1 group-hover:text-pink-600 transition-colors duration-300 truncate">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-2 text-sm line-clamp-2">{{ $product->description }}</p>
                            <!-- Price and Status -->
                            <div class="flex flex-wrap justify-between items-center mb-3 gap-2">
                                <div class="flex items-baseline">
                                    @if($product->old_price > $product->price)
                                        <span class="text-sm text-gray-400 line-through mr-2">{{ \App\Helpers\CurrencyHelper::format($product->old_price, $currentCurrency) }}</span>
                                    @endif
                                    <p class="text-pink-600 font-bold text-lg">
                                        {{ \App\Helpers\CurrencyHelper::format($product->price, $currentCurrency) }}
                                    </p>
                                </div>
                                @if (!$product->is_active)
                                    <span class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full flex items-center shadow-sm">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        Rupture de stock
                                    </span>
                                @else
                                    <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full flex items-center shadow-sm">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        En stock
                                    </span>
                                @endif
                            </div>
                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 w-full mt-auto">
                                @if ($product->is_active)
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-xl flex items-center justify-center hover:from-pink-600 hover:to-purple-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                Ajouter au panier
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white px-4 py-2 rounded-xl flex items-center justify-center hover:from-pink-600 hover:to-purple-600 transition-all duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm">
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Ajouter au panier
                                        </a>
                                        <div class="text-xs text-gray-400 mt-1">Connectez-vous ou créez un compte pour acheter</div>
                                    @endauth
                                    @auth
                                        @php
                                            $isFavorite = Auth::user()->favorites()->where('product_id', $product->id)->exists();
                                        @endphp
                                        @if($isFavorite)
                                            <form action="{{ route('favorites.remove', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white rounded-xl px-4 py-2 flex items-center justify-center transition duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('favorites.add', $product) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl px-4 py-2 flex items-center justify-center transition duration-300 transform hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                @else
                                    <button class="bg-gray-200 text-gray-500 px-4 py-2 rounded-xl cursor-not-allowed w-full flex items-center justify-center text-sm" disabled>
                                        <i class="fas fa-ban mr-2"></i>
                                        Indisponible
                                    </button>
                                @endif
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <form action="{{ route('products.toggleActive', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" 
                                            class="{{ $product->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded-xl transition-all duration-300 w-full flex items-center justify-center transform hover:-translate-y-1 shadow-lg hover:shadow-xl text-sm mt-2 sm:mt-0">
                                            <i class="fas {{ $product->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }} mr-2"></i>
                                            {{ $product->is_active ? 'Désactiver' : 'Activer' }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </section>
            
            <!-- Pagination Bottom -->
            <div class="mt-12 flex justify-center">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
        
        <!-- Testimonials Section -->
        <section class="my-20">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
                    Ce que disent nos clients
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-pink-500 rounded"></span>
                </h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Découvrez les témoignages de nos clients satisfaits qui ont adopté nos produits dans leur routine beauté.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-lg relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="pt-5">
                        <p class="text-gray-600 italic mb-6">"J'ai essayé de nombreux produits, mais celui-ci a vraiment fait la différence. Ma peau est plus éclatante et les compliments ne s'arrêtent pas !"</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-purple-200 flex items-center justify-center text-purple-700 font-bold mr-4">
                                MS
                            </div>
                            <div>
                                <h4 class="font-semibold">Marie S.</h4>
                                <p class="text-gray-500 text-sm">Cliente fidèle depuis 2023</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-lg relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="pt-5">
                        <p class="text-gray-600 italic mb-6">"La qualité des ingrédients est exceptionnelle. Je n'ai jamais vu d'aussi bons résultats avec des produits aussi naturels et respectueux."</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 font-bold mr-4">
                                PL
                            </div>
                            <div>
                                <h4 class="font-semibold">Philippe L.</h4>
                                <p class="text-gray-500 text-sm">Client depuis 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-lg relative">
                    <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="pt-5">
                        <p class="text-gray-600 italic mb-6">"Le service client est impeccable et les produits sont divins. J'ai recommandé cette boutique à toutes mes amies !"</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold mr-4">
                                SC
                            </div>
                            <div>
                                <h4 class="font-semibold">Sophie C.</h4>
                                <p class="text-gray-500 text-sm">Cliente VIP</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Newsletter Section -->
        <section class="my-20 bg-gradient-to-r from-purple-600 to-pink-600 rounded-3xl overflow-hidden relative">
            <div class="absolute inset-0 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                    <defs>
                        <pattern id="pattern-circles" width="40" height="40" patternUnits="userSpaceOnUse">
                            <rect width="100%" height="100%" fill="none"/>
                            <circle cx="20" cy="20" r="4" fill="currentColor" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#pattern-circles)" />
                </svg>
            </div>
            <div class="container mx-auto px-6 py-16 md:py-20 relative z-10">
                <div class="max-w-3xl mx-auto text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Restez informé de nos nouveautés</h2>
                    <p class="text-lg text-white opacity-90 mb-10">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres et découvrir nos nouveaux produits en avant-première.</p>
                    
                    <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                        <input type="email" placeholder="Votre adresse email" class="form-control flex-1 py-3 px-6 bg-white bg-opacity-20 backdrop-filter backdrop-blur-md border-0 text-white placeholder-white placeholder-opacity-70 focus:bg-opacity-30">
                        <button type="submit" class="btn-primary bg-white text-purple-600 hover:bg-gray-100 py-3 px-6">
                            S'abonner
                        </button>
                    </form>
                    
                    <p class="text-sm text-white opacity-70 mt-4">Nous respectons votre vie privée. Vous pouvez vous désabonner à tout moment.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-auto">
        <div class="container mx-auto px-4">
            <!-- Footer Top -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <!-- Brand/Logo -->
                <div>
                    <h3 class="text-2xl font-semibold text-pink-400 mb-6">Luxe Cosmétique</h3>
                    <p class="text-gray-400 mb-6">Des produits de beauté exceptionnels pour sublimer votre quotidien et révéler votre beauté naturelle.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Liens Rapides</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Accueil</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Produits</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">À Propos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Blog</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Catégories</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Soins du visage</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Soins du corps</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Maquillage</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Parfums</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink-400 transition-colors">Accessoires</a></li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Contact</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-pink-400 mt-1 mr-3"></i>
                            <span class="text-gray-400">12 Avenue des Cosmétiques, 75008 Paris, France</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone-alt text-pink-400 mr-3"></i>
                            <span class="text-gray-400">+33 1 23 45 67 89</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-pink-400 mr-3"></i>
                            <span class="text-gray-400">contact@luxecosmetique.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500">&copy; {{ date('Y') }} Luxe Cosmétique. Tous droits réservés.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-pink-400 transition-colors">Conditions d'utilisation</a>
                    <a href="#" class="text-gray-500 hover:text-pink-400 transition-colors">Politique de confidentialité</a>
                    <a href="#" class="text-gray-500 hover:text-pink-400 transition-colors">Mentions légales</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back To Top Button -->
    <button id="backToTop" class="fixed bottom-6 right-6 w-12 h-12 bg-pink-600 text-white rounded-full shadow-lg flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-pink-700 z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <!-- Script pour changer de devise (CORRECTION) -->
    <script>
        function changeCurrency(currency) {
            // Créer un formulaire temporaire
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('currency.change') }}";
            
            // Ajouter le token CSRF
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";
            
            // Ajouter la devise
            const currencyInput = document.createElement('input');
            currencyInput.type = 'hidden';
            currencyInput.name = 'currency';
            currencyInput.value = currency;
            
            // Ajouter le redirect_url pour revenir à la page actuelle
            const redirectInput = document.createElement('input');
            redirectInput.type = 'hidden';
            redirectInput.name = 'redirect_url';
            redirectInput.value = window.location.href;
            
            // Ajouter les inputs au formulaire
            form.appendChild(csrfToken);
            form.appendChild(currencyInput);
            form.appendChild(redirectInput);
            
            // Ajouter le formulaire au body et le soumettre
            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <!-- User Dropdown Toggle Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const userButton = document.getElementById("userMenu");
            const dropdownMenu = document.getElementById("userDropdown");

            userButton.addEventListener("click", (event) => {
                event.stopPropagation();
                dropdownMenu.classList.toggle("hidden");
            });

            document.addEventListener("click", (event) => {
                if (!userButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }
            });
            
            // Back to Top Button
            const backToTopButton = document.getElementById('backToTop');
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    backToTopButton.classList.remove('opacity-0', 'invisible');
                    backToTopButton.classList.add('opacity-100', 'visible');
                } else {
                    backToTopButton.classList.remove('opacity-100', 'visible');
                    backToTopButton.classList.add('opacity-0', 'invisible');
                }
            });
            
            backToTopButton.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    
    <!-- Filter Script -->
    <script>
        function applyFilters() {
            const data = {
                search: document.querySelector('[name="search"]').value,
                category_id: document.querySelector('[name="category_id"]').value,
                sort: document.querySelector('[name="sort"]').value,
                currency: "{{ $currentCurrency }}" // Ajouter la devise actuelle
            };
            
            // Ajout du filtre admin s'il existe
            const filterEl = document.querySelector('[name="filter"]');
            if (filterEl) {
                data.filter = filterEl.value;
            }
            
            // Ajout des prix min/max s'ils existent
            const minPriceEl = document.querySelector('[name="min_price"]');
            if (minPriceEl) {
                data.min_price = minPriceEl.value;
            }
            
            const maxPriceEl = document.querySelector('[name="max_price"]');
            if (maxPriceEl) {
                data.max_price = maxPriceEl.value;
            }
            
            // Afficher un indicateur de chargement
            document.getElementById("product-list").innerHTML = '<div class="text-center py-10"><div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-pink-600 border-t-transparent"></div><p class="mt-4 text-gray-600">Chargement en cours...</p></div>';
            
            fetch("{{ route('products.ajax.filter') }}?" + new URLSearchParams(data), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("product-list").innerHTML = data.html;
                
                // Réinitialiser les animations pour les nouvelles cartes
                const cards = document.querySelectorAll('.card');
                cards.forEach(card => {
                    card.classList.add('fade-in');
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById("product-list").innerHTML = '<div class="text-center py-10 bg-red-50 rounded-xl p-6"><i class="fas fa-exclamation-circle text-red-500 text-4xl mb-4"></i><p class="text-red-600">Une erreur est survenue. Veuillez réessayer.</p></div>';
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Attacher l'événement à tous les éléments avec la classe filter-input
            document.querySelectorAll('.filter-input').forEach(input => {
                input.addEventListener('change', applyFilters);
            });
            
            // Ajouter un délai pour le champ de recherche (pour éviter trop de requêtes)
            const searchInput = document.querySelector('[name="search"]');
            if (searchInput) {
                let timeoutId;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(applyFilters, 500);
                });
            }
            
            // Empêcher la soumission du formulaire pour utiliser AJAX à la place
            const filterForm = document.querySelector('form[action*="products.index"]');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    applyFilters();
                });
            }
            
            // Animation initiale pour les cartes produits
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });
        });
    </script>
</body>
</html>

@push('scripts')
<script>
window.tourSteps_ = [
  {
    id: 'step-1',
    title: 'Bienvenue sur le catalogue',
    text: 'Découvrez tous nos <b>produits de beauté premium</b> ici. Utilisez les filtres et la recherche pour trouver votre bonheur !',
    attachTo: { element: 'h1', on: 'bottom' },
    buttons: [ { text: 'Suivant', action: function() { tour.next(); } } ]
  },
  {
    id: 'step-2',
    title: 'Recherche rapide',
    text: 'Utilisez la <b>barre de recherche</b> pour trouver un produit en un clin d'œil.',
    attachTo: { element: 'input[type=search], .search-bar', on: 'bottom' },
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechWorld | Appareils électroniques premium</title>
    
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --accent-blue: #60a5fa;
            --dark-blue: #1e3a8a;
            --light-blue: #dbeafe;
            --tech-gray: #374151;
            --bg-gray: #f8fafc;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e0f2fe 100%);
            color: var(--tech-gray);
        }

        .mono-font {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Tech-inspired animations */
        @keyframes slideInFromLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.5); }
        }

        .slide-in {
            animation: slideInFromLeft 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }

        /* Glass morphism effect with tech styling */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(59, 130, 246, 0.15);
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.08);
        }
        
        .glass-dark {
            background: rgba(30, 58, 138, 0.9);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(96, 165, 250, 0.2);
            box-shadow: 0 8px 32px rgba(30, 64, 175, 0.15);
        }

        /* Navigation Styles */
        .brand { 
            font-weight: 800;
            font-size: 1.75rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
        }

        .nav-link {
            position: relative;
            font-weight: 500;
            color: var(--tech-gray);
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--light-blue), rgba(96, 165, 250, 0.1));
            border-radius: 8px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            opacity: 1;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-blue);
            transform: translateY(-1px);
        }

        /* Tech-inspired buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(96, 165, 250, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.25);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-secondary {
            background: white;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(30, 64, 175, 0.2);
        }

        /* Product Card Styles */
        .tech-card {
            border-radius: 16px;
            background: white;
            border: 1px solid var(--border-color);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .tech-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .tech-card:hover::before {
            transform: scaleX(1);
        }

        .tech-card:hover {
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.12);
            transform: translateY(-8px);
            border-color: var(--accent-blue);
        }

        /* Tech badge */
        .tech-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 20px;
            padding: 6px 12px;
            z-index: 10;
            box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
        }

        /* Form Controls */
        .tech-input {
            border: 2px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 16px;
            width: 100%;
            transition: all 0.3s ease;
            background: white;
            font-size: 0.95rem;
        }

        .tech-input:focus {
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            outline: none;
            background: rgba(219, 234, 254, 0.05);
        }

        .tech-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%233b82f6'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 18px;
            padding-right: 45px;
        }

        /* Hero gradient with tech vibes */
        .hero-tech {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-tech::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.5;
        }

        /* Status indicators */
        .status-online {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .status-offline {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        /* Tech price styling */
        .tech-price {
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.25rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }

        .page-item {
            margin: 0 4px;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            color: var(--tech-gray);
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
            border: 2px solid var(--border-color);
        }

        .page-link:hover {
            background: var(--light-blue);
            border-color: var(--secondary-blue);
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        .page-item.active .page-link {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        /* Features tech styling */
        .tech-feature {
            padding: 24px;
            border-radius: 16px;
            background: white;
            border: 1px solid var(--border-color);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .tech-feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .tech-feature:hover::before {
            transform: scaleX(1);
        }

        .tech-feature:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(30, 64, 175, 0.1);
            border-color: var(--accent-blue);
        }

        .tech-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--light-blue), rgba(96, 165, 250, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            color: var(--primary-blue);
            font-size: 24px;
            transition: all 0.3s ease;
        }

        .tech-feature:hover .tech-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
        }

        /* Circuit pattern overlay */
        .circuit-bg {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-opacity='0.03'%3E%3Cpolygon fill='%23ffffff' points='50 0 60 40 100 50 60 60 50 100 40 60 0 50 40 40'/%3E%3C/g%3E%3C/svg%3E");
        }

        /* Scrollbar customization */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary-blue);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-blue);
        }

        /* Loading animation */
        .loading-spinner {
            border: 3px solid rgba(59, 130, 246, 0.3);
            border-radius: 50%;
            border-top: 3px solid var(--secondary-blue);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 1000;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(30, 64, 175, 0.4);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navigation avec effet glass tech -->
    <nav class="glass sticky top-0 z-50 py-4 px-6 md:px-8">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo/Brand -->
            <a href="#" class="brand flex items-center slide-in">
                <svg class="w-8 h-8 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
                    <rect x="7" y="8" width="4" height="8" fill="currentColor"/>
                    <rect x="13" y="8" width="4" height="8" fill="currentColor"/>
                    <circle cx="9" cy="16" r="1" fill="white"/>
                    <circle cx="15" cy="16" r="1" fill="white"/>
                </svg>
                <span>TechWorld</span>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-2">
                <a href="#" class="nav-link active">Accueil</a>
                <a href="#" class="nav-link">Produits</a>
                <a href="#" class="nav-link">Smartphones</a>
                <a href="#" class="nav-link">Ordinateurs</a>
                <a href="#" class="nav-link">Accessoires</a>
                <a href="#" class="nav-link">Support</a>
            </div>

            <!-- User Actions -->
            <div class="flex space-x-4 items-center">
                <!-- Currency Selector -->
                <div class="relative">
                    <select class="tech-input tech-select py-2 pl-4 pr-10 text-sm w-32">
                        <option value="XOF">XOF (FCFA)</option>
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                    </select>
                </div>
                
                <!-- Shopping Cart -->
                <a href="#" class="relative group">
                    <div class="p-3 bg-white border-2 border-gray-200 rounded-xl transition-all duration-300 group-hover:border-blue-400 group-hover:bg-blue-50">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <span class="tech-badge -top-2 -right-2">3</span>
                </a>

                <!-- User Menu -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center text-white font-bold text-sm">
                        JD
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold">John Doe</p>
                        <p class="text-xs text-gray-500 mono-font">Membre Pro</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Hero Section -->
        <section class="mb-16 relative overflow-hidden rounded-2xl hero-tech circuit-bg">
            <div class="container mx-auto px-8 py-20 md:py-28 relative z-10">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 md:pr-12 text-center md:text-left mb-12 md:mb-0">
                        <h1 class="text-2xl md:text-xl lg:text-2xl font-bold text-white leading-tight mb-6 slide-in">
                            La <span class="relative mono-font">technologie</span> 
                            <br>à portée de main
                        </h1>
                        <p class="text-lg md:text-xl text-blue-100 mb-10 fade-in-up">
                            Découvrez notre sélection d'appareils électroniques haute performance. 
                            Smartphones, ordinateurs, accessoires et bien plus.
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-6 fade-in-up">
                            <a href="#products" class="btn-primary text-center">
                                <i class="fas fa-bolt mr-2"></i>
                                Voir les produits
                            </a>
                            <a href="#" class="btn-secondary bg-white/10 border-white/20 text-white hover:bg-white hover:text-blue-600 text-center">
                                <i class="fas fa-star mr-2"></i>
                                Nos best-sellers
                            </a>
                        </div>
                    </div>
                    <div class="md:w-1/2 relative">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="tech-card p-4 bg-white/10 border-white/20 backdrop-blur-sm hover:bg-white/20">
                                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=300&h=300&fit=crop" 
                                     alt="Smartphone" class="w-full h-32 object-cover rounded-lg mb-3">
                                <h3 class="text-white font-semibold text-sm">Smartphones</h3>
                                <p class="text-blue-100 text-xs">Dernière génération</p>
                            </div>
                            <div class="tech-card p-4 bg-white/10 border-white/20 backdrop-blur-sm hover:bg-white/20 mt-8">
                                <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300&h=300&fit=crop" 
                                     alt="Laptop" class="w-full h-32 object-cover rounded-lg mb-3">
                                <h3 class="text-white font-semibold text-sm">Ordinateurs</h3>
                                <p class="text-blue-100 text-xs">Performance ultime</p>
                            </div>
                            <div class="tech-card p-4 bg-white/10 border-white/20 backdrop-blur-sm hover:bg-white/20 -mt-4">
                                <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=300&h=300&fit=crop" 
                                     alt="Headphones" class="w-full h-32 object-cover rounded-lg mb-3">
                                <h3 class="text-white font-semibold text-sm">Audio</h3>
                                <p class="text-blue-100 text-xs">Son cristallin</p>
                            </div>
                            <div class="tech-card p-4 bg-white/10 border-white/20 backdrop-blur-sm hover:bg-white/20 mt-4">
                                <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=300&h=300&fit=crop" 
                                     alt="Smartwatch" class="w-full h-32 object-cover rounded-lg mb-3">
                                <h3 class="text-white font-semibold text-sm">Wearables</h3>
                                <p class="text-blue-100 text-xs">Connectés</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="mb-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="tech-feature">
                    <div class="tech-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Garantie Premium</h3>
                    <p class="text-gray-600">Tous nos produits bénéficient d'une garantie étendue et d'un support technique 24/7.</p>
                </div>
                
                <div class="tech-feature">
                    <div class="tech-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Livraison Express</h3>
                    <p class="text-gray-600">Livraison rapide et sécurisée partout au Sénégal en 24-48h.</p>
                </div>
                
                <div class="tech-feature">
                    <div class="tech-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Qualité Certifiée</h3>
                    <p class="text-gray-600">Produits authentiques certifiés par les fabricants officiels.</p>
                </div>

                <div class="tech-feature">
                    <div class="tech-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-800">Support Expert</h3>
                    <p class="text-gray-600">Notre équipe d'experts vous accompagne avant et après votre achat.</p>
                </div>
            </div>
        </section>
        
        <!-- Header Section -->
        <section id="products" class="mb-10 text-center">
            <h2 class="text-2xl md:text-xl font-bold text-gray-800 mb-6 relative inline-block">
                <span class="mono-font">Nos Produits</span>
                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full"></span>
            </h2>
            <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                Découvrez notre gamme complète d'appareils électroniques haute performance, 
                sélectionnés pour leur qualité et leur innovation technologique.
            </p>
        </section>
        
        <!-- Filtres et Recherche -->
        <div class="glass rounded-2xl p-8 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Recherche -->
                <div class="relative">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Rechercher</label>
                    <div class="relative">
                        <input type="text" placeholder="iPhone, MacBook, Samsung..." 
                               class="tech-input pl-12">
                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-500">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Catégorie -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Catégorie</label>
                    <select class="tech-input tech-select">
                        <option>Toutes les catégories</option>
                        <option>Smartphones</option>
                        <option>Ordinateurs</option>
                        <option>Tablettes</option>
                        <option>Audio & Vidéo</option>
                        <option>Accessoires</option>
                    </select>
                </div>

                <!-- Prix -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Prix</label>
                    <select class="tech-input tech-select">
                        <option>Tous les prix</option>
                        <option>Moins de 100 000 FCFA</option>
                        <option>100 000 - 500 000 FCFA</option>
                        <option>500 000 - 1 000 000 FCFA</option>
                        <option>Plus de 1 000 000 FCFA</option>
                    </select>
                </div>

                <!-- Trier -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Trier par</label>
                    <select class="tech-input tech-select">
                        <option>Plus récents</option>
                        <option>Prix croissant</option>
                        <option>Prix décroissant</option>
                        <option>Popularité</option>
                        <option>Meilleures notes</option>
                    </select>
                </div>
            </div>

            <!-- Filtres avancés pour admin -->
            <div class="mt-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-bold text-blue-800 flex items-center">
                        <span class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-lg mr-3">
                            <i class="fas fa-cog text-sm"></i>
                        </span>
                        Administration Système
                    </h3>
                    <select class="tech-input w-48 text-sm">
                        <option>Tous les produits</option>
                        <option>En stock uniquement</option>
                        <option>Rupture de stock</option>
                        <option>Nouveautés</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Pagination Top -->
        <div class="mb-8 flex justify-center">
            <ul class="pagination">
                <li class="page-item">
                    <a href="#" class="page-link">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li class="page-item active">
                    <a href="#" class="page-link">1</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">2</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">3</a>
                </li>
                <li class="page-item">
                    <a href="#" class="page-link">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Product Grid -->
        <div id="product-list" class="py-8">
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <!-- Product Card 1 - iPhone -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop" 
                             alt="iPhone 15 Pro" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="tech-badge">Nouveau</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                Smartphone
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            iPhone 15 Pro
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Le smartphone le plus avancé d'Apple avec puce A17 Pro, caméras professionnelles et design en titane.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">850 000 FCFA</span>
                                <span class="text-sm text-gray-400 line-through ml-2">900 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.9</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>

                <!-- Product Card 2 - MacBook -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop" 
                             alt="MacBook Pro" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-purple-600 to-purple-800">Pro</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">
                                Ordinateur portable
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            MacBook Pro 16"
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Puissance professionnelle avec puce M3 Max, écran Liquid Retina XDR et autonomie exceptionnelle.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">2 500 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.8</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-red-200 text-red-500 border-red-400 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Activer
                        </button>
                    </div>
                </div>

                <!-- Product Card 3 - Samsung Galaxy -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?w=400&h=300&fit=crop" 
                             alt="Samsung Galaxy" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-green-600 to-green-800">-15%</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-offline text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-times-circle text-xs mr-1"></i>
                                Rupture
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                Smartphone
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            Galaxy S24 Ultra
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Le flagship Samsung avec S Pen intégré, caméras 200MP et intelligence artificielle avancée.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">750 000 FCFA</span>
                                <span class="text-sm text-gray-400 line-through ml-2">880 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.7</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="bg-gray-300 text-gray-500 flex-1 text-sm py-3 rounded-xl cursor-not-allowed">
                                <i class="fas fa-ban mr-2"></i>
                                Indisponible
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="bg-green-500 hover:bg-green-600 text-white w-full mt-2 text-sm py-2 rounded-xl transition-colors">
                            <i class="fas fa-toggle-on mr-2"></i>
                            Activer
                        </button>
                    </div>
                </div>

                <!-- Product Card 4 - Headphones -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&h=300&fit=crop" 
                             alt="AirPods Pro" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge">Audio</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                                Écouteurs
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            AirPods Pro 2
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Écouteurs sans fil avec réduction de bruit adaptive et audio spatial personnalisé.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">180 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.6</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>

                <!-- Product Card 5 - iPad -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=300&fit=crop" 
                             alt="iPad Air" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-orange-600 to-orange-800">Populaire</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-orange-100 text-orange-800 rounded-full">
                                Tablette
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            iPad Air M2
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Tablette polyvalente avec puce M2, écran Liquid Retina et compatibilité Apple Pencil.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">450 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.8</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-red-200 text-red-500 border-red-400 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>

                <!-- Product Card 6 - Gaming Console -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?w=400&h=300&fit=crop" 
                             alt="PlayStation 5" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-blue-800 to-purple-800">Gaming</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">
                                Console
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            PlayStation 5
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Console de jeux nouvelle génération avec ray tracing, SSD ultra-rapide et manette haptique.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">650 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.9</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>

                <!-- Product Card 7 - Smartwatch -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1579952363873-27d3bfad9c0d?w=400&h=300&fit=crop" 
                             alt="Apple Watch" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-red-600 to-pink-600">Santé</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-pink-100 text-pink-800 rounded-full">
                                Montre connectée
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            Apple Watch Series 9
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Montre intelligente avec suivi santé avancé, GPS, et écran Always-On Retina.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">280 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.5</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>

                <!-- Product Card 8 - Monitor -->
                <div class="tech-card group h-full flex flex-col fade-in-up">
                    <div class="relative h-64 overflow-hidden rounded-t-2xl">
                        <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&h=300&fit=crop" 
                             alt="4K Monitor" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <span class="tech-badge bg-gradient-to-r from-cyan-600 to-blue-800">4K</span>
                        <div class="absolute top-4 left-4">
                            <span class="status-online text-xs px-3 py-1 rounded-full flex items-center">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                En Stock
                            </span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-semibold bg-cyan-100 text-cyan-800 rounded-full">
                                Écran
                            </span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800 group-hover:text-blue-600 transition-colors">
                            Moniteur 4K 27"
                        </h3>
                        <p class="text-gray-600 mb-4 text-sm flex-1">
                            Écran professionnel 4K avec calibrage des couleurs, HDR10 et connectivité USB-C.
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="tech-price">320 000 FCFA</span>
                            </div>
                            <div class="flex items-center text-yellow-500 text-sm">
                                <i class="fas fa-star"></i>
                                <span class="ml-1 font-semibold">4.4</span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="btn-primary flex-1 text-sm py-3">
                                <i class="fas fa-cart-plus mr-2"></i>
                                Ajouter
                            </button>
                            <button class="tech-input border-2 border-gray-200 hover:border-red-400 hover:text-red-500 w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                        <button class="btn-secondary w-full mt-2 text-sm py-2">
                            <i class="fas fa-toggle-off mr-2"></i>
                            Désactiver
                        </button>
                    </div>
                </div>
            </section>
            
            <!-- Pagination Bottom -->
            <div class="mt-12 flex justify-center">
                <ul class="pagination">
                    <li class="page-item">
                        <a href="#" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a href="#" class="page-link">1</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">2</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">3</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">4</a>
                    </li>
                    <li class="page-item">
                        <a href="#" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Testimonials Section -->
        <section class="my-20">
            <div class="text-center mb-12">
                <h2 class="text-2xl md:text-xl font-bold text-gray-800 mb-6 relative inline-block">
                    <span class="mono-font">Avis Clients</span>
                    <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-32 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full"></span>
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto text-lg">
                    Découvrez ce que pensent nos clients de nos produits et services. 
                    Leur satisfaction est notre priorité.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="tech-card p-8 relative">
                    <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <div class="pt-8">
                        <p class="text-gray-600 italic mb-6 leading-relaxed">
                            "Service exceptionnel ! J'ai acheté mon iPhone ici et la livraison était ultra rapide. 
                            L'équipe technique m'a parfaitement conseillé."
                        </p>
                        <div class="flex items-center
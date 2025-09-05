<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#000000">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-o9N1jvA+p1p+z1CvNHEfMTG9Dth61EMvh2W0Z8A+7vM="
          crossorigin="">

    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">

    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/notifications.js',
    ]); ?>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/soften-elements.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/mobile-improvements.css')); ?>">
    
    <!-- Nike-Inspired Minimalist Design -->
    <style>
        /* Modern CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            font-family: 'Inter', 'Figtree', sans-serif;
        }
        
        body {
            font-family: 'Inter', 'Figtree', sans-serif;
            background: #ffffff;
            color: #000000;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Nike-Inspired Typography */
        .nike-title {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        
        .nike-subtitle {
            font-size: 1.5rem;
            font-weight: 400;
            color: #666666;
        }
        
        .nike-heading {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.01em;
        }
        
        .nike-text {
            font-size: 1.125rem;
            font-weight: 400;
            color: #333333;
        }
        
        /* Nike-Inspired Buttons */
        .btn-nike {
            background: #000000;
            color: #ffffff;
            border: none;
            padding: 16px 32px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }
        
        .btn-nike:hover {
            background: #333333;
            transform: translateY(-2px);
        }
        
        .btn-nike-outline {
            background: transparent;
            color: #000000;
            border: 2px solid #000000;
            padding: 14px 30px;
        }
        
        .btn-nike-outline:hover {
            background: #000000;
            color: #ffffff;
        }
        
        /* Nike-Inspired Cards */
        .card-nike {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        .card-nike:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        /* Nike-Inspired Navigation */
        .nav-nike {
            background: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            backdrop-filter: blur(20px);
        }
        
        .nav-link-nike {
            color: #000000;
            text-decoration: none;
            font-weight: 500;
            padding: 1rem;
            transition: color 0.3s ease;
        }
        
        .nav-link-nike:hover {
            color: #666666;
        }
        
        /* Nike-Inspired Layout */
        .container-nike {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section-nike {
            padding: 4rem 0;
        }
        
        .grid-nike {
            display: grid;
            gap: 2rem;
        }
        
        .grid-nike-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .grid-nike-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        
        .grid-nike-4 {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        
        /* Nike-Inspired Product Cards */
        .product-card-nike {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .product-card-nike:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .product-image-nike {
            width: 100%;
            height: 300px;
            object-fit: cover;
            background: #f8f8f8;
        }
        
        .product-info-nike {
            padding: 1.5rem;
        }
        
        .product-title-nike {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #000000;
        }
        
        .product-price-nike {
            font-size: 1.5rem;
            font-weight: 800;
            color: #000000;
        }
        
        .product-price-old-nike {
            text-decoration: line-through;
            color: #999999;
            margin-right: 0.5rem;
        }
        
        /* Nike-Inspired Forms */
        .form-nike {
            background: #ffffff;
            border: 1px solid #f0f0f0;
            padding: 2rem;
            border-radius: 0;
        }
        
        .input-nike {
            width: 100%;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background: #ffffff;
            color: #000000;
        }
        
        .input-nike:focus {
            outline: none;
            border-color: #000000;
        }
        
        .label-nike {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #000000;
        }
        
        /* Nike-Inspired Footer */
        .footer-nike {
            background: #000000;
            color: #ffffff;
            padding: 4rem 0 2rem;
        }
        
        .footer-section-nike h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #ffffff;
        }
        
        .footer-section-nike a {
            color: #cccccc;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-section-nike a:hover {
            color: #ffffff;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nike-title {
                font-size: 2.5rem;
            }
            
            .nike-heading {
                font-size: 2rem;
            }
            
            .container-nike {
                padding: 0 1rem;
            }
            
            .section-nike {
                padding: 2rem 0;
            }
        }
        
        /* Nike-Inspired Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-in-left {
            opacity: 0;
            transform: translateX(-30px);
            animation: slideInLeft 0.6s ease forwards;
        }
        
        @keyframes slideInLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .slide-in-right {
            opacity: 0;
            transform: translateX(30px);
            animation: slideInRight 0.6s ease forwards;
        }
        
        @keyframes slideInRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        /* Nike-Inspired Spacing */
        .space-y-nike > * + * {
            margin-top: 2rem;
        }
        
        .space-y-nike-sm > * + * {
            margin-top: 1rem;
        }
        
        .space-y-nike-lg > * + * {
            margin-top: 3rem;
        }
        
        /* Nike-Inspired Utilities */
        .text-center-nike {
            text-align: center;
        }
        
        .text-left-nike {
            text-align: left;
        }
        
        .text-right-nike {
            text-align: right;
        }
        
        .flex-nike {
            display: flex;
        }
        
        .flex-col-nike {
            flex-direction: column;
        }
        
        .items-center-nike {
            align-items: center;
        }
        
        .justify-center-nike {
            justify-content: center;
        }
        
        .justify-between-nike {
            justify-content: space-between;
        }
        
        .gap-nike {
            gap: 1rem;
        }
        
        .gap-nike-lg {
            gap: 2rem;
        }
        
        .gap-nike-xl {
            gap: 3rem;
        }
    </style>
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-o8EN4bfESZ6Stq3Yc8Jt1KZDUOGpyVho+a3wZzMe/c4="
            crossorigin="" defer></script>

    <!-- Leaflet Routing Machine JavaScript -->
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js" defer></script>

    <!-- Shepherd.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/shepherd.js/dist/css/shepherd.css">
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js/dist/js/shepherd.min.js"></script>
    
    <style>
    /* Nike-Inspired Shepherd.js Styling */
    .shepherd-theme-nike .shepherd-content {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 0;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        font-size: 1rem;
        color: #000000;
        padding: 2rem;
        max-width: 400px;
    }
    
    .shepherd-theme-nike .shepherd-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        font-size: 1.25rem;
        color: #000000;
        font-weight: 700;
        padding-bottom: 1rem;
    }
    
    .shepherd-theme-nike .shepherd-button {
        background: #000000;
        color: #ffffff;
        border: none;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.75rem 1.5rem;
        margin: 0 0.5rem;
        transition: all 0.3s ease;
    }
    
    .shepherd-theme-nike .shepherd-button:hover {
        background: #333333;
    }
    
    .shepherd-theme-nike .shepherd-footer {
        text-align: right;
        margin-top: 1.5rem;
    }
    
    .shepherd-theme-nike .shepherd-cancel-icon {
        color: #000000;
        font-size: 1.25rem;
        top: 1.5rem;
        right: 1.5rem;
    }
    </style>
    
    <script>
    // Nike-Inspired Shepherd Tour Creation
    window.createNikeTour = function(steps) {
        const tour = new Shepherd.Tour({
            defaultStepOptions: {
                classes: 'shepherd-theme-nike',
                scrollTo: true,
                cancelIcon: { enabled: true }
            }
        });
        steps.forEach(step => tour.addStep(step));
        return tour;
    };
    </script>
</head>
<body class="font-sans antialiased">
    <!-- Service Worker Registration - TEMPORAIREMENT DÉSACTIVÉ -->
    <!--
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => {
                        console.log('✅ Service Worker registered successfully:', reg.scope);
                    })
                    .catch(err => {
                        console.log('❌ Service Worker registration failed:', err);
                    });
            });
        }
    </script>
    -->
      
    <!-- Auth ID for Echo -->
    <script>
        window.userId = <?php echo e(auth()->check() ? auth()->id() : 'null'); ?>;
    </script>

    <?php echo $__env->make('components.toast', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php if(auth()->check()): ?>
        <?php
            $currentRoute = request()->route()->getName();
            $tourId = null;
            
            // Déterminer quel tour afficher selon la route
            if (str_contains($currentRoute, 'dashboard')) {
                $tourId = 'dashboard';
            } elseif (str_contains($currentRoute, 'products')) {
                $tourId = 'products';
            } elseif (str_contains($currentRoute, 'cart')) {
                $tourId = 'cart';
            } elseif (str_contains($currentRoute, 'profile')) {
                $tourId = 'profile';
            } elseif (str_contains($currentRoute, 'welcome') || str_contains($currentRoute, 'home')) {
                $tourId = 'welcome';
            }
        ?>
        
        <?php if($tourId): ?>
            <?php if (isset($component)) { $__componentOriginal7668fad7795586306e1972f2f11338ca = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7668fad7795586306e1972f2f11338ca = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.onboarding-tour','data' => ['tourId' => $tourId,'autoStart' => App\Helpers\OnboardingHelper::shouldAutoStart($tourId, auth()->id())]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('onboarding-tour'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tourId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tourId),'autoStart' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(App\Helpers\OnboardingHelper::shouldAutoStart($tourId, auth()->id()))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7668fad7795586306e1972f2f11338ca)): ?>
<?php $attributes = $__attributesOriginal7668fad7795586306e1972f2f11338ca; ?>
<?php unset($__attributesOriginal7668fad7795586306e1972f2f11338ca); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7668fad7795586306e1972f2f11338ca)): ?>
<?php $component = $__componentOriginal7668fad7795586306e1972f2f11338ca; ?>
<?php unset($__componentOriginal7668fad7795586306e1972f2f11338ca); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal8d5f9f712ad68735ee0009ff5065f869 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.onboarding-button','data' => ['tourId' => $tourId]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('onboarding-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tourId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tourId)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $attributes = $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $component = $__componentOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
            <script>
                <?php echo App\Helpers\OnboardingHelper::generateTourScript($tourId); ?>

            </script>
        <?php endif; ?>
    <?php endif; ?>

    <div class="min-h-screen flex flex-col relative">
        
        <?php $currentRoute = request()->route()->getName(); ?>
        <?php if($currentRoute === 'home'): ?>
            <nav class="nav-nike sticky top-0 z-50 w-full">
                <div class="container-nike">
                    <div class="flex-nike justify-between items-center h-16">
                        <?php if(!auth()->check()): ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-nike">
                                <?php echo e(__('Connexion')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn-nike">
                                <?php echo e(__('Mon espace')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        <?php else: ?>
            <?php if(auth()->check() && auth()->user()->hasRole('livreur')): ?>
            <!-- Navbar ultra-simplifiée pour livreur -->
                <nav class="nav-nike sticky top-0 z-50">
                <div class="container-nike">
                    <div class="flex-nike justify-end h-16">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-nike">
                                <?php echo e(__('Déconnexion')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        <?php elseif(!auth()->check()): ?>
            <!-- Si non connecté, bouton connexion -->
                <nav class="nav-nike sticky top-0 z-50">
                <div class="container-nike">
                    <div class="flex-nike justify-end h-16">
                            <a href="<?php echo e(route('login')); ?>" class="btn-nike">
                            <?php echo e(__('Connexion')); ?>

                        </a>
                    </div>
                </div>
            </nav>
        <?php else: ?>
            <!-- Regular navbar pour tous les autres rôles -->
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Page heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white border-b border-gray-200">
                <div class="container-nike py-6">
                    <div class="flex-nike items-center justify-between">
                        <?php echo e($header); ?>

                    </div>
                </div>
            </header>
        <?php endif; ?>

        <!-- Content -->
        <main class="flex-grow relative z-10">
            <div class="container-nike py-8">
                <?php echo $__env->yieldContent('content'); ?>
                <?php if (isset($component)) { $__componentOriginal8d5f9f712ad68735ee0009ff5065f869 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.onboarding-button','data' => ['tourId' => 'main','position' => 'fixed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('onboarding-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tourId' => 'main','position' => 'fixed']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $attributes = $__attributesOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__attributesOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869)): ?>
<?php $component = $__componentOriginal8d5f9f712ad68735ee0009ff5065f869; ?>
<?php unset($__componentOriginal8d5f9f712ad68735ee0009ff5065f869); ?>
<?php endif; ?>
            </div>
        </main>

        <!-- Nike-Inspired Footer -->
        <footer class="footer-nike mt-auto relative z-10">
            <div class="container-nike">
                <div class="grid-nike grid-nike-4 gap-nike-xl">
                    <!-- Brand Section -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex-nike items-center space-x-4 mb-6">
                            <div class="w-12 h-12 bg-black rounded-full flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">TechExchange</span>
                        </div>
                        <p class="text-gray-300 mb-8 max-w-lg text-lg leading-relaxed">
                            La plateforme innovante pour acheter, vendre et échanger vos appareils électroniques. 
                            Smartphones, tablettes, ordinateurs et plus encore avec un système de troc unique.
                        </p>
                        <div class="flex-nike space-x-4">
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-black hover:bg-gray-200 transition-all duration-300">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-black hover:bg-gray-200 transition-all duration-300">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-black hover:bg-gray-200 transition-all duration-300">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="footer-section-nike h3">Liens rapides</h3>
                        <ul class="space-y-nike-sm">
                            <li><a href="<?php echo e(route('products.index')); ?>" class="footer-section-nike a">Nos produits</a></li>
                            <li><a href="<?php echo e(route('promos.index')); ?>" class="footer-section-nike a">Codes promo</a></li>
                            <li><a href="<?php echo e(route('help.index')); ?>" class="footer-section-nike a">Aide</a></li>
                            <li><a href="#" class="footer-section-nike a">À propos</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="footer-section-nike h3">Contact</h3>
                        <ul class="space-y-nike-sm">
                            <li class="flex-nike items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope text-black"></i>
                                </div>
                                <span>contact@cosmetique.com</span>
                            </li>
                            <li class="flex-nike items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-phone text-black"></i>
                                </div>
                                <span>+33 1 23 45 67 89</span>
                            </li>
                            <li class="flex-nike items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-map-marker-alt text-black"></i>
                                </div>
                                <span>Paris, France</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="border-t border-gray-700 mt-12 pt-8">
                    <div class="flex-nike flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-300 text-sm">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Laravel')); ?>. Tous droits réservés.</p>
                        <div class="flex-nike space-x-8 mt-4 md:mt-0">
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300">Mentions légales</a>
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300">Politique de confidentialité</a>
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300">CGV</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Enhanced Promo code functionality script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy promo code functionality with enhanced feedback
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const code = this.getAttribute('data-code');
                    navigator.clipboard.writeText(code)
                        .then(() => {
                            const originalIcon = this.innerHTML;
                            this.innerHTML = '<i class="fas fa-check"></i>';
                            this.classList.add('text-green-500', 'scale-110');
                            
                            setTimeout(() => {
                                this.innerHTML = originalIcon;
                                this.classList.remove('text-green-500', 'scale-110');
                            }, 1500);
                        })
                        .catch(err => {
                            console.error('Failed to copy text:', err);
                        });
                });
            });
            
            // Enhanced promo code status filtering
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.addEventListener('change', function() {
                    const value = this.value;
                    const rows = document.querySelectorAll('.promo-table tbody tr');
                    
                    rows.forEach(row => {
                        if (value === 'all' || row.classList.contains(value)) {
                            row.style.display = '';
                            row.classList.add('animate-fade-in');
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Enhanced promo code search functionality
            const searchInput = document.getElementById('searchPromo');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchText = this.value.toLowerCase();
                    const rows = document.querySelectorAll('.promo-table tbody tr');
                    
                    rows.forEach(row => {
                        const code = row.querySelector('.promo-code').textContent.toLowerCase();
                        if (code.includes(searchText)) {
                            row.style.display = '';
                            row.classList.add('animate-fade-in');
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
            
            // Enhanced random promo code generation
            const generateCodeBtn = document.querySelector('.generate-code');
            if (generateCodeBtn) {
                generateCodeBtn.addEventListener('click', function() {
                    const codeInput = document.getElementById('code');
                    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let result = '';
                    for (let i = 0; i < 8; i++) {
                        result += chars.charAt(Math.floor(Math.random() * chars.length));
                    }
                    codeInput.value = result;
                    codeInput.classList.add('animate-pulse');
                    setTimeout(() => codeInput.classList.remove('animate-pulse'), 1000);
                });
            }
            
            // Enhanced dynamic value symbol update
            const typeSelect = document.getElementById('type');
            if (typeSelect) {
                const updateSymbol = () => {
                    const symbol = typeSelect.value === 'percent' ? '%' : 'FCFA';
                    const symbolElement = document.getElementById('value-symbol');
                    if (symbolElement) {
                        symbolElement.textContent = symbol;
                        symbolElement.classList.add('animate-bounce');
                        setTimeout(() => symbolElement.classList.remove('animate-bounce'), 1000);
                    }
                };
                
                updateSymbol();
                typeSelect.addEventListener('change', updateSymbol);
            }
            
            // Enhanced responsive tables
            document.querySelectorAll('table.w-full').forEach(table => {
                if (!table.parentElement.classList.contains('overflow-x-auto')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'overflow-x-auto rounded-2xl shadow-lg';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
            
            // Add smooth animations to all interactive elements
            document.querySelectorAll('a, button, .card, .btn').forEach(element => {
                element.classList.add('transition-all', 'duration-300', 'ease-in-out');
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/layouts/app.blade.php ENDPATH**/ ?>
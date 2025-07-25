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
    <meta name="theme-color" content="#6366f1">
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
    
    <!-- Advanced Custom Styles -->
    <style>
        /* Modern CSS Reset and Base Styles */
        * {
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
            font-family: 'Inter', 'Figtree', sans-serif;
        }
        
        body {
            font-family: 'Inter', 'Figtree', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Advanced Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #6366f1, #8b5cf6, #ec4899);
            border-radius: 10px;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #4f46e5, #7c3aed, #db2777);
        }
        
        /* Glass Morphism 2.0 */
        .glass-modern {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Advanced Gradient Animations */
        .gradient-animate {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c, #4facfe, #00f2fe);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }
        
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Floating Elements */
        .float-slow {
            animation: floatSlow 8s ease-in-out infinite;
        }
        
        .float-medium {
            animation: floatMedium 6s ease-in-out infinite;
        }
        
        .float-fast {
            animation: floatFast 4s ease-in-out infinite;
        }
        
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(2deg); }
        }
        
        @keyframes floatMedium {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(-1deg); }
        }
        
        @keyframes floatFast {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        
        /* Advanced Hover Effects */
        .hover-3d {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform-style: preserve-3d;
        }
        
        .hover-3d:hover {
            transform: translateY(-8px) rotateX(5deg) rotateY(5deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .hover-glow {
            transition: all 0.3s ease;
        }
        
        .hover-glow:hover {
            box-shadow: 0 0 30px rgba(99, 102, 241, 0.4);
            transform: scale(1.05);
        }
        
        /* Text Animations */
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .text-shimmer {
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: shimmer 3s ease-in-out infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Loading Animations */
        .spinner-modern {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top: 4px solid #6366f1;
            border-radius: 50%;
            animation: spinModern 1s linear infinite;
        }
        
        @keyframes spinModern {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Pulse Effects */
        .pulse-modern {
            animation: pulseModern 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulseModern {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Morphing Shapes */
        .morph-shape {
            animation: morphShape 6s ease-in-out infinite;
        }
        
        @keyframes morphShape {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }
        
        /* Advanced Button Styles */
        .btn-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }
        
        /* Card Hover Effects */
        .card-modern {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .card-modern:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }
        
        /* Navigation Enhancements */
        .nav-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .nav-link-modern {
            position: relative;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-link-modern::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }
        
        .nav-link-modern:hover::after {
            width: 100%;
        }
        
        /* Footer Modern */
        .footer-modern {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            position: relative;
            overflow: hidden;
        }
        
        .footer-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .glass-modern {
                backdrop-filter: blur(10px);
            }
            
            .card-modern:hover {
                transform: translateY(-5px) scale(1.01);
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            }
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
    /* Enhanced Shepherd.js Styling */
    .shepherd-theme-custom .shepherd-content {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        font-size: 1.1rem;
        color: #1e293b;
        padding: 2.5rem 2rem 2rem 2rem;
        max-width: 450px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .shepherd-theme-custom .shepherd-header {
        background: transparent;
        border-bottom: none;
        font-size: 1.4rem;
        color: #6366f1;
        font-weight: 700;
        padding-bottom: 1rem;
    }
    .shepherd-theme-custom .shepherd-button {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        padding: 0.75rem 2rem;
        margin: 0 0.5rem;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        border: none;
        transition: all 0.3s ease;
    }
    .shepherd-theme-custom .shepherd-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
    }
    .shepherd-theme-custom .shepherd-footer {
        text-align: right;
        margin-top: 2rem;
    }
    .shepherd-theme-custom .shepherd-cancel-icon {
        color: #6366f1;
        font-size: 1.5rem;
        top: 1.5rem;
        right: 1.5rem;
    }
    </style>
    <script>
    // Enhanced Shepherd Tour Creation
    window.createCustomTour = function(steps) {
        const tour = new Shepherd.Tour({
            defaultStepOptions: {
                classes: 'shepherd-theme-custom',
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
    <!-- Service Worker Registration -->
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
        <!-- Background Decorative Elements -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-br from-purple-400/20 to-pink-400/20 rounded-full blur-3xl float-slow"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-gradient-to-tr from-blue-400/20 to-cyan-400/20 rounded-full blur-3xl float-medium"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-to-r from-indigo-400/15 to-purple-400/15 rounded-full blur-2xl float-fast"></div>
        </div>

        
        <?php $currentRoute = request()->route()->getName(); ?>
        <?php if($currentRoute === 'home'): ?>
            <nav class="nav-glass sticky top-0 z-50 w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-end md:justify-end h-16 items-center w-full">
                        <?php if(!auth()->check()): ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn-modern hover-glow w-full md:w-auto text-center md:ml-auto">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                <?php echo e(__('Connexion')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('dashboard')); ?>" class="btn-modern hover-glow w-full md:w-auto text-center md:ml-auto">
                                <i class="fas fa-user mr-2"></i>
                                <?php echo e(__('Mon espace')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        <?php else: ?>
            <?php if(auth()->check() && auth()->user()->hasRole('delivery')): ?>
            <!-- Navbar ultra-simplifiée pour livreur -->
                <nav class="nav-glass sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-end h-16">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                                <button type="submit" class="btn-modern hover-glow">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <?php echo e(__('Déconnexion')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        <?php elseif(!auth()->check()): ?>
            <!-- Si non connecté, bouton connexion -->
                <nav class="nav-glass sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-end h-16">
                            <a href="<?php echo e(route('login')); ?>" class="btn-modern hover-glow">
                            <i class="fas fa-sign-in-alt mr-2"></i>
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
            <header class="glass-modern shadow-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <?php echo e($header); ?>

                    </div>
                </div>
            </header>
        <?php endif; ?>

        <!-- Content -->
        <main class="flex-grow relative z-10">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
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

        <!-- Enhanced Footer -->
        <footer class="footer-modern mt-auto relative z-10">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8 relative">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Brand Section -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg hover-glow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <span class="text-3xl font-bold text-white text-shimmer">Mon Site Cosmetique</span>
                        </div>
                        <p class="text-gray-300 mb-8 max-w-lg text-lg leading-relaxed">
                            Découvrez notre collection exclusive de produits cosmétiques naturels et bio, 
                            sélectionnés avec soin pour prendre soin de votre peau et de votre bien-être.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white hover-glow transition-all duration-300 hover:scale-110">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white hover-glow transition-all duration-300 hover:scale-110">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                            <a href="#" class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center text-white hover-glow transition-all duration-300 hover:scale-110">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 text-gradient">Liens rapides</h3>
                        <ul class="space-y-3">
                            <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-purple-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                Nos produits
                            </a></li>
                            <li><a href="<?php echo e(route('promos.index')); ?>" class="text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-purple-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                Codes promo
                            </a></li>
                            <li><a href="<?php echo e(route('help.index')); ?>" class="text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-purple-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                Aide
                            </a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-all duration-300 hover:translate-x-2 flex items-center group">
                                <i class="fas fa-chevron-right mr-2 text-purple-400 group-hover:translate-x-1 transition-transform duration-300"></i>
                                À propos
                            </a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-xl font-bold text-white mb-6 text-gradient">Contact</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <span>contact@cosmetique.com</span>
                            </li>
                            <li class="flex items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <span>+33 1 23 45 67 89</span>
                            </li>
                            <li class="flex items-center text-gray-300 hover:text-white transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <span>Paris, France</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="border-t border-gray-700 mt-12 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-300 text-sm">&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name', 'Laravel')); ?>. Tous droits réservés.</p>
                        <div class="flex space-x-8 mt-4 md:mt-0">
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300 hover:translate-y-[-2px]">Mentions légales</a>
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300 hover:translate-y-[-2px]">Politique de confidentialité</a>
                            <a href="#" class="text-gray-300 hover:text-white text-sm transition-all duration-300 hover:translate-y-[-2px]">CGV</a>
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
                    const symbol = typeSelect.value === 'percent' ? '%' : '€';
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
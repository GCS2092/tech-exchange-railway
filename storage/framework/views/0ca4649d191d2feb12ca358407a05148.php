<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechExchange - Appareils Électroniques</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-white text-black">

<?php if(session('success')): ?>
    <div class="fixed top-4 right-4 bg-black text-white px-6 py-3 z-50">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<!-- Navigation -->
<nav class="fixed top-0 w-full bg-white border-b border-gray-200 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-sm">T</span>
                </div>
                <span class="text-xl font-bold text-black">TechExchange</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="<?php echo e(route('products.index')); ?>" class="text-black hover:text-gray-600 transition-colors">Produits</a>
                <a href="<?php echo e(route('trades.search')); ?>" class="text-black hover:text-gray-600 transition-colors">Échanges</a>
                <a href="<?php echo e(route('help.client')); ?>" class="text-black hover:text-gray-600 transition-colors">Support</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="bg-black text-white px-4 py-2 hover:bg-gray-800 transition-all">
                        Dashboard
                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="bg-black text-white px-4 py-2 hover:bg-gray-800 transition-all">
                        Se connecter
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section - Style Nike "Just Do It" -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Side - Text -->
            <div class="text-left">
                <h1 class="text-6xl md:text-8xl font-black mb-6 leading-tight text-black">
                    JUST DO IT.
        </h1>
                <p class="text-2xl md:text-3xl text-gray-600 mb-8 font-light">
            L'avenir de l'électronique à portée de main
                </p>
                <p class="text-xl text-gray-500 mb-12 max-w-2xl leading-relaxed">
            Smartphones dernière génération, ordinateurs ultra-performants, accessoires gaming... 
            Découvrez notre sélection d'appareils électroniques avec possibilité d'échange et garantie premium.
        </p>

                <!-- CTA Buttons - Style Nike -->
                <div class="flex flex-col sm:flex-row gap-6">
                    <a href="<?php echo e(route('products.index')); ?>" class="bg-black text-white px-8 py-4 font-semibold text-center hover:bg-gray-800 transition-all duration-300">
                        SHOP MEN
                    </a>
                    <a href="<?php echo e(route('products.index')); ?>" class="bg-black text-white px-8 py-4 font-semibold text-center hover:bg-gray-800 transition-all duration-300">
                        SHOP WOMEN
            </a>
        </div>
            </div>
            
            <!-- Right Side - Product Image -->
            <div class="flex justify-center lg:justify-end">
                <div class="w-80 h-80 lg:w-96 lg:h-96 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-mobile-alt text-2xl text-gray-400"></i>
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
                <a href="<?php echo e(route('products.index')); ?>" class="bg-black text-white px-8 py-4 font-semibold inline-block hover:bg-gray-800 transition-all duration-300">
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
                <a href="<?php echo e(route('products.index')); ?>" class="bg-black text-white px-8 py-4 font-semibold inline-block hover:bg-gray-800 transition-all duration-300">
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
            <a href="<?php echo e(route('products.index')); ?>" class="bg-white text-black px-8 py-4 font-semibold hover:bg-gray-100 transition-all duration-300">
                EXPLORER LES PRODUITS
            </a>
            <a href="<?php echo e(route('register')); ?>" class="border-2 border-white text-white px-8 py-4 font-semibold hover:bg-white hover:text-black transition-all duration-300">
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
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-400 hover:text-white transition-colors">Produits</a></li>
                    <li><a href="<?php echo e(route('trades.search')); ?>" class="text-gray-400 hover:text-white transition-colors">Échanges</a></li>
                    <li><a href="<?php echo e(route('help.client')); ?>" class="text-gray-400 hover:text-white transition-colors">Aide</a></li>
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
            <p class="text-gray-400">&copy; <?php echo e(date('Y')); ?> TechExchange. Tous droits réservés.</p>
        </div>
    </div>
</footer>

</body>
</html><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/welcome.blade.php ENDPATH**/ ?>
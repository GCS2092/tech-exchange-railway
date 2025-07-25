<nav x-data="{ open: false }" class="sticky top-0 w-full z-50 bg-white/70 backdrop-blur-xl shadow-lg border-b border-gray-200/40">
    <div class="flex items-center justify-between px-4 md:px-10 h-20 w-full">
            <!-- Logo -->
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center space-x-2 group">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-400 via-purple-400 to-indigo-400 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                <svg class="w-7 h-7 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
            <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent group-hover:from-indigo-600 group-hover:to-pink-600 transition-all duration-700 ease-in-out drop-shadow-md">
                Luxe Cosmétique
                    </span>
                </a>
        <!-- Desktop menu -->
        <div class="hidden lg:flex items-center space-x-8">
            <a href="<?php echo e(route('dashboard')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Accueil</a>
            <a href="<?php echo e(route('products.index')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Produits</a>
            <a href="<?php echo e(route('orders.index')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Commandes</a>
            <a href="<?php echo e(route('promos.index')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Codes Promos</a>
            <a href="<?php echo e(route('fidelity.calendar')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Fidélité</a>
            <a href="<?php echo e(route('favorites.index')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Coup De Coeur</a>
            <?php if (\Illuminate\Support\Facades\Blade::check('role', 'vendeur')): ?>
                <a href="<?php echo e(route('vendeur.livreurs.all')); ?>" class="text-lg font-semibold text-gray-800 hover:text-pink-600 transition-colors">Tous les livreurs</a>
            <?php endif; ?>
        </div>
        <!-- Actions -->
        <div class="flex items-center space-x-3">
            <?php if(Auth::check()): ?>
                <!-- Menu utilisateur connecté -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none" id="userMenu">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-700 to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow">
                            <?php echo e(strtoupper(substr(Auth::user()->name ?? 'U', 0, 1))); ?>

            </div>
                        <span class="hidden md:inline-block font-semibold text-gray-800"><?php echo e(strtok(Auth::user()->name, ' ')); ?></span>
                        <svg class="w-5 h-5 text-gray-400 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    </button>
                    <!-- Dropdown -->
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 hidden group-hover:block group-focus:block transition-all duration-300">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="font-bold text-gray-800"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                            <p class="text-xs text-indigo-600 font-bold mt-1">Rôle : <?php echo e(Auth::user()->roles->first()->name ?? Auth::user()->role ?? '-'); ?></p>
                    </div>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                            <i class="fas fa-user-circle mr-2 text-pink-400"></i> Mon profil
                        </a>
                        <a href="<?php echo e(route('orders.index')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                            <i class="fas fa-box mr-2 text-pink-400"></i> Mes commandes
                        </a>
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'vendeur')): ?>
                        <a href="<?php echo e(route('vendeur.orders.index')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                            <i class="fas fa-store mr-2 text-green-500"></i> Commandes vendeur
                        </a>
                        <a href="<?php echo e(route('vendeur.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                            <i class="fas fa-chart-line mr-2 text-blue-500"></i> Dashboard vendeur
                        </a>
                        <?php endif; ?>
                        <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                            <i class="fas fa-crown mr-2 text-yellow-500"></i> Administration
                            </a>
                            <?php endif; ?>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-left block px-4 py-2 text-gray-700 hover:bg-pink-50 transition flex items-center">
                                <i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                <!-- Actions non connecté -->
                <a href="<?php echo e(route('login')); ?>" class="hidden md:inline-block px-5 py-2 rounded-full text-base font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 shadow-lg transition">Connexion</a>
                <a href="<?php echo e(route('register')); ?>" class="hidden md:inline-block px-5 py-2 rounded-full text-base font-semibold text-pink-600 border-2 border-pink-400 bg-white hover:bg-pink-50 shadow transition">Inscription</a>
            <?php endif; ?>
            <!-- Hamburger -->
            <button @click="open = true" class="lg:hidden p-2 rounded-full bg-white border border-gray-200 text-pink-600 shadow hover:bg-pink-50 focus:outline-none focus:ring-2 focus:ring-pink-400">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <!-- Overlay for mobile menu -->
        <template x-if="open">
            <div class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="open = false"></div>
        </template>
        <!-- Mobile drawer -->
        <div class="lg:hidden fixed inset-0 z-50 transition-all duration-300" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="relative w-full h-full bg-white/95 flex flex-col">
                <button @click="open = false" class="absolute top-4 right-4 z-50 p-2 rounded-full border-2 border-pink-400 bg-white text-pink-600 hover:bg-pink-50 hover:text-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500 transition-all duration-300">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <nav class="flex flex-col items-center justify-center h-full space-y-8 pt-24">
                    <?php if(Auth::check()): ?>
                        <div class="flex flex-col items-center mb-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-indigo-700 to-pink-500 flex items-center justify-center text-white font-bold text-2xl shadow mb-2">
                                <?php echo e(strtoupper(substr(Auth::user()->name ?? 'U', 0, 1))); ?>

                </div>
                            <span class="font-semibold text-gray-800"><?php echo e(strtok(Auth::user()->name, ' ')); ?></span>
                            <span class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></span>
                            <p class="text-xs text-indigo-600 font-bold mt-1">Rôle : <?php echo e(Auth::user()->roles->first()->name ?? Auth::user()->role ?? '-'); ?></p>
            </div>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-pink-600 border-2 border-pink-400 bg-white hover:bg-pink-50 shadow transition flex items-center justify-center"><i class="fas fa-user-circle mr-2 text-pink-400"></i> Mon profil</a>
                        <a href="<?php echo e(route('orders.index')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-pink-600 border-2 border-pink-400 bg-white hover:bg-pink-50 shadow transition flex items-center justify-center"><i class="fas fa-box mr-2 text-pink-400"></i> Mes commandes</a>
                        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'vendeur')): ?>
                        <a href="<?php echo e(route('vendeur.orders.index')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-green-600 border-2 border-green-400 bg-white hover:bg-green-50 shadow transition flex items-center justify-center"><i class="fas fa-store mr-2 text-green-500"></i> Commandes vendeur</a>
                        <a href="<?php echo e(route('vendeur.dashboard')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-blue-600 border-2 border-blue-400 bg-white hover:bg-blue-50 shadow transition flex items-center justify-center"><i class="fas fa-chart-line mr-2 text-blue-500"></i> Dashboard vendeur</a>
                        <?php endif; ?>
                        <?php if(Auth::user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-yellow-600 border-2 border-yellow-400 bg-white hover:bg-yellow-50 shadow transition flex items-center justify-center"><i class="fas fa-crown mr-2 text-yellow-500"></i> Administration</a>
            <?php endif; ?>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                    <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-gray-700 border-2 border-gray-300 bg-white hover:bg-gray-50 shadow transition flex items-center justify-center"><i class="fas fa-sign-out-alt mr-2 text-gray-400"></i> Déconnexion</button>
                </form>
            <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-white bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 shadow-lg transition">Connexion</a>
                        <a href="<?php echo e(route('register')); ?>" class="w-full text-center px-5 py-3 rounded-full text-base font-semibold text-pink-600 border-2 border-pink-400 bg-white hover:bg-pink-50 shadow transition">Inscription</a>
                    <?php endif; ?>
                </nav>
                </div>
        </div>
    </div>
</nav>

<!-- Spacer to prevent content from being hidden under fixed navbar -->
<div class="h-24"></div>

<script>
    // Add scroll behavior for navbar
    document.addEventListener('alpine:init', () => {
        // Pour les animations supplémentaires au chargement de la page
        const navLinks = document.querySelectorAll('nav a');

        // Animation progressive des liens
        navLinks.forEach((link, index) => {
            link.style.opacity = '0';
            link.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                link.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                link.style.opacity = '1';
                link.style.transform = 'translateY(0)';
            }, 100 + (index * 70));
        });

        // Ajout d'un effet sur le lien actif
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('bg-purple-50', 'text-purple-700', 'font-semibold');
            }
        });
    });

    // Ajout d'un effet de pulse sur l'icône du panier si des produits sont ajoutés
    if (parseInt("<?php echo e(session('cart') ? count(session('cart')) : 0); ?>") > 0) {
        const cartIcons = document.querySelectorAll('a[href="<?php echo e(route("cart.index")); ?>"] svg');
        cartIcons.forEach(icon => {
            icon.classList.add('animate-pulse');
            setTimeout(() => {
                icon.classList.remove('animate-pulse');
            }, 2000);
        });
    }
</script><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>


<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Header avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                Mon Panier
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>

        <!-- Message de confirmation -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-lg mb-8 flex items-center animate-fade-in">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Message d'erreur -->
        <?php if(session('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg mb-8 flex items-center animate-fade-in">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Panier vide -->
        <?php if($cart->isEmpty()): ?>
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center animate-scale-in">
                <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Votre panier est vide</h2>
                <p class="text-gray-600 mb-8">Découvrez nos produits et commencez vos achats</p>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary group">
                    <span>Découvrir nos produits</span>
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </a>
            </div>

            <!-- Suggestions de produits -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Produits populaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php $__currentLoopData = $popularProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card hover:shadow-lg transform hover:-translate-y-2 transition-all duration-300">
                        <div class="aspect-ratio-1">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover rounded-t-xl">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo e($product->name); ?></h3>
                            <p class="text-indigo-600 font-bold mt-2"><?php echo e($product->price); ?>€</p>
                            <button class="btn btn-secondary w-full mt-4" onclick="addToCart(<?php echo e($product->id); ?>)">
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Résumé du panier -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="p-6 border-b border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800">Résumé du panier</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            <?php $currentCurrency = session('currency', 'XOF'); ?>
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-6 hover:bg-gray-50 transition-colors duration-300 group animate-fade-in">
                                <div class="flex items-center space-x-4">
                                    <!-- Image du produit -->
                                    <div class="relative w-24 h-24 rounded-xl overflow-hidden shadow-sm group-hover:shadow-md transition-all duration-300">
                                        <img 
                                            src="<?php echo e(Str::startsWith($item->product->image, 'http') 
                                                ? $item->product->image 
                                                : asset('storage/' . $item->product->image)); ?>" 
                                            alt="<?php echo e($item->product->name); ?>" 
                                            class="w-full h-full max-w-full h-auto object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    
                                    <!-- Informations du produit -->
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800 group-hover:text-purple-600 transition-colors">
                                            <?php echo e($item->product->name); ?>

                                        </h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            Prix unitaire: <?php echo e(\App\Helpers\CurrencyHelper::format($item->price, $currentCurrency)); ?>

                                        </p>
                                        
                                        <!-- Contrôles de quantité -->
                                        <div class="flex items-center mt-4 space-x-4">
                                            <form action="/panier/mise-a-jour/<?php echo e($item->id); ?>" method="POST" class="flex items-center">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                <button type="submit" name="action" value="decrease" 
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <span class="mx-4 font-medium"><?php echo e($item->quantity); ?></span>
                                                <button type="submit" name="action" value="increase" 
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                            
                                            <!-- Supprimer l'article -->
                                            <form action="<?php echo e(route('cart.remove')); ?>" method="POST" class="ml-auto">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="id" value="<?php echo e($item->id); ?>">
                                                <button type="submit" 
                                                    class="text-red-500 hover:text-red-600 transition-colors"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Récapitulatif de la commande -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-4">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6">Récapitulatif</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="font-medium"><?php echo e(\App\Helpers\CurrencyHelper::format($originalTotal, 'XOF')); ?></span>
                            </div>
                            
                            <?php if($promo): ?>
                            <div class="flex justify-between text-green-600">
                                <span>Réduction (<?php echo e($promo['value']); ?>%)</span>
                                <span class="font-medium">-<?php echo e(\App\Helpers\CurrencyHelper::format($discount, 'XOF')); ?></span>
                            </div>
                            <?php endif; ?>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-bold text-purple-600"><?php echo e(\App\Helpers\CurrencyHelper::format($total, 'XOF')); ?></span>
                                </div>
                            </div>

                            <?php if(!$isMinimumAmountReached): ?>
                            <div class="mt-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-r-lg">
                                <p class="text-yellow-700 text-sm">
                                    Le montant minimum pour passer commande est de <?php echo e(\App\Helpers\CurrencyHelper::format($minimumAmount, 'XOF')); ?>

                                </p>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-6">
                            <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary w-full py-3 group <?php echo e(!$isMinimumAmountReached ? 'opacity-50 cursor-not-allowed' : ''); ?>">
                                <span>Passer la commande</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Code promo -->
                        <div class="mt-6">
                            <form action="<?php echo e(route('cart.apply-coupon')); ?>" method="POST" class="flex">
                                <?php echo csrf_field(); ?>
                                <input type="text" name="code" placeholder="Code promo" 
                                    class="form-input flex-1 rounded-r-none focus:ring-2 focus:ring-purple-500"
                                    value="<?php echo e($promo['code'] ?? ''); ?>">
                                <?php if($promo): ?>
                                    <button type="submit" formaction="<?php echo e(route('cart.removePromo')); ?>" 
                                        class="btn btn-danger rounded-l-none">
                                        Retirer
                                    </button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-secondary rounded-l-none">
                                        Appliquer
                                    </button>
                                <?php endif; ?>
                            </form>
                            <?php if($promo): ?>
                            <div class="mt-2 text-sm text-green-600">
                                <p>Code promo "<?php echo e($promo['code']); ?>" appliqué</p>
                                <p>Réduction de <?php echo e($promo['value']); ?>%</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produits complémentaires -->
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-8">Produits complémentaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php $__currentLoopData = $complementaryProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card hover:shadow-lg transform hover:-translate-y-2 transition-all duration-300">
                        <div class="aspect-ratio-1">
                            <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover rounded-t-xl">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo e($product->name); ?></h3>
                            <p class="text-indigo-600 font-bold mt-2"><?php echo e(\App\Helpers\CurrencyHelper::format($product->price, 'XOF')); ?></p>
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="mt-4">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-secondary w-full group">
                                    <span>Ajouter au panier</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fonction pour ajouter un produit au panier
    function addToCart(productId) {
        // Créer un formulaire dynamique
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/cart/add/${productId}`;
        
        // Ajouter le token CSRF
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfToken);
        
        // Ajouter le formulaire à la page et le soumettre
        document.body.appendChild(form);
        form.submit();
    }

    // Animation pour les éléments du panier
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.animate-fade-in');
        items.forEach((item, index) => {
            item.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/cart/index.blade.php ENDPATH**/ ?>
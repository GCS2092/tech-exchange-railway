<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Breadcrumb - Style Nike -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="<?php echo e(route('dashboard')); ?>" class="hover:text-black transition-colors">Accueil</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="<?php echo e(route('products.index')); ?>" class="hover:text-black transition-colors">Produits</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-black font-medium"><?php echo e($product->name); ?></li>
        </ol>
    </nav>

        <!-- Détail du produit - Style Nike -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-16">
            
            <!-- Images du produit -->
            <div class="space-y-4">
                <?php if($product->images && count($product->images) > 0): ?>
                    <!-- Image principale -->
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        <img src="<?php echo e(asset('storage/' . $product->images->first()->path)); ?>" 
                             alt="<?php echo e($product->name); ?>" 
                             class="w-full h-full object-cover">
        </div>

                    <!-- Galerie d'images -->
                    <?php if(count($product->images) > 1): ?>
                        <div class="grid grid-cols-4 gap-4">
                            <?php $__currentLoopData = $product->images->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-80 transition-opacity">
                                    <img src="<?php echo e(asset('storage/' . $image->path)); ?>" 
                                         alt="<?php echo e($product->name); ?>" 
                                         class="w-full h-full object-cover">
            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                    <?php endif; ?>
                <?php else: ?>
                    <!-- Placeholder si pas d'image -->
                    <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-lg text-gray-400"></i>
            </div>
                <?php endif; ?>
            </div>

            <!-- Informations du produit -->
            <div class="space-y-8">
                <!-- Titre et catégorie -->
                <div>
                    <h1 class="nike-heading mb-4"><?php echo e($product->name); ?></h1>
                    <p class="text-gray-600"><?php echo e($product->category->name ?? 'Sans catégorie'); ?></p>
            </div>

                <!-- Prix -->
                <div class="space-y-2">
                    <?php if($product->promo_price): ?>
                        <div class="flex items-center space-x-4">
                            <span class="text-xl font-bold text-black"><?php echo e(number_format($product->promo_price)); ?> FCFA</span>
                            <span class="text-xl text-gray-500 line-through"><?php echo e(number_format($product->price)); ?> FCFA</span>
                            <span class="bg-black text-white px-3 py-1 text-sm font-semibold">
                                PROMO
                    </span>
                        </div>
                <?php else: ?>
                        <span class="text-xl font-bold text-black"><?php echo e(number_format($product->price)); ?> FCFA</span>
                <?php endif; ?>
            </div>

                <!-- Description -->
                <div>
                    <h3 class="text-lg font-semibold text-black mb-3">Description</h3>
                    <p class="text-gray-600 leading-relaxed"><?php echo e($product->description); ?></p>
                </div>
                
                <!-- Caractéristiques -->
                <?php if($product->specifications): ?>
                    <div>
                        <h3 class="text-lg font-semibold text-black mb-3">Caractéristiques</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php $__currentLoopData = json_decode($product->specifications, true) ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="font-medium text-gray-700"><?php echo e($key); ?></span>
                                    <span class="text-gray-600"><?php echo e($value); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="space-y-4">
                    <!-- Quantité -->
                    <div>
                        <label class="label-nike mb-2">Quantité</label>
                        <div class="flex items-center space-x-4">
                            <button type="button" class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="decreaseQuantity()">
                                <i class="fas fa-minus text-gray-600"></i>
                            </button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo e($product->stock ?? 99); ?>" class="w-20 text-center border border-gray-300 rounded-lg py-2">
                            <button type="button" class="w-10 h-10 border border-gray-300 rounded-lg flex items-center justify-center hover:bg-gray-50 transition-colors" onclick="increaseQuantity()">
                                <i class="fas fa-plus text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Boutons d'action -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" id="quantity-input" value="1">
                            <button type="submit" class="btn-nike w-full">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                AJOUTER AU PANIER
                            </button>
                        </form>
                        
                        <a href="<?php echo e(route('favorites.toggle', $product->id)); ?>" 
                           class="btn-nike-outline w-full text-center">
                            <i class="fas fa-heart mr-2 <?php echo e($product->isFavoritedBy(auth()->id()) ? 'text-red-500' : ''); ?>"></i>
                            <?php echo e($product->isFavoritedBy(auth()->id()) ? 'Retirer des favoris' : 'Ajouter aux favoris'); ?>

                        </a>
                    </div>
                    
                    <!-- Stock -->
                    <?php if(isset($product->stock)): ?>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Stock disponible : <span class="font-semibold text-black"><?php echo e($product->stock); ?></span> unité(s)
                            </p>
                        </div>
                    <?php endif; ?>
            </div>
        </div>
    </div>

        <!-- Produits similaires - Style Nike -->
        <?php if($relatedProducts->count() > 0): ?>
            <div class="border-t border-gray-200 pt-16">
                <h2 class="nike-heading text-center mb-12">PRODUITS SIMILAIRES</h2>
                <div class="grid-nike grid-nike-3 gap-nike-lg">
            <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="product-card-nike group">
                            <!-- Image du produit -->
                            <div class="relative overflow-hidden">
                                <?php if($relatedProduct->images && count($relatedProduct->images) > 0): ?>
                                    <img src="<?php echo e(asset('storage/' . $relatedProduct->images->first()->path)); ?>" 
                                         alt="<?php echo e($relatedProduct->name); ?>" 
                                         class="product-image-nike group-hover:scale-105 transition-transform duration-300">
                                <?php else: ?>
                                    <div class="product-image-nike bg-gray-100 flex items-center justify-center">
                                        <i class="fas fa-image text-2xl text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Badge de promotion -->
                                <?php if($relatedProduct->promo_price): ?>
                                    <div class="absolute top-4 left-4 bg-black text-white px-3 py-1 text-sm font-semibold">
                                        PROMO
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Informations du produit -->
                            <div class="product-info-nike">
                                <h3 class="product-title-nike group-hover:text-gray-600 transition-colors">
                                    <a href="<?php echo e(route('products.show', $relatedProduct)); ?>"><?php echo e($relatedProduct->name); ?></a>
                                </h3>
                                
                                <!-- Prix -->
                                <div class="flex items-center justify-between mb-4">
                                    <?php if($relatedProduct->promo_price): ?>
                                        <div class="flex items-center space-x-2">
                                            <span class="product-price-old-nike"><?php echo e(number_format($relatedProduct->price)); ?> FCFA</span>
                                            <span class="product-price-nike"><?php echo e(number_format($relatedProduct->promo_price)); ?> FCFA</span>
                                        </div>
                                    <?php else: ?>
                                        <span class="product-price-nike"><?php echo e(number_format($relatedProduct->price)); ?> FCFA</span>
                                    <?php endif; ?>
                    </div>
                                
                                <!-- Bouton d'action -->
                                <a href="<?php echo e(route('products.show', $relatedProduct)); ?>" class="btn-nike w-full text-center">
                                    Voir détails
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const quantityInput = document.getElementById('quantity-input');
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
        quantityInput.value = input.value;
    }
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const quantityInput = document.getElementById('quantity-input');
    const max = parseInt(input.getAttribute('max'));
    if (input.value < max) {
        input.value = parseInt(input.value) + 1;
        quantityInput.value = input.value;
    }
}

// Synchroniser les inputs de quantité
document.getElementById('quantity').addEventListener('change', function() {
    document.getElementById('quantity-input').value = this.value;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projets\mon-site-cosmetique\mon-site-cosmetique\resources\views/products/show.blade.php ENDPATH**/ ?>
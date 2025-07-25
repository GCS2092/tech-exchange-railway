<?php

use App\Http\Controllers\{
    CartController,
    ProfileController,
    ProductController,
    CategoryController,
    OrderController,
    PaymentController,
    DashboardController,
    Auth\AuthenticatedSessionController,
    Auth\RegisteredUserController,
    MessageController,
    NotificationController,
    Admin\UserManagementController,
    Auth\RegisterWithCodeController,
    Auth\ForgotPasswordWithCodeController,
    CurrencyController,
    InvoiceController,
    FidelityController,
    LivreurController,
    PromoController,
    FavoriteController,
    WelcomeController,
    OnboardingController,
    HelpController,
    ContactAdminController,
    VendorDashboardController,
    VendorOrderController,
    VendorProductController,
    VendorQuickManageController
};
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\StockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES
|--------------------------------------------------------------------------
*/

// Route principale pour React (doit être la première route)
Route::get('/', [WelcomeController::class, 'index'])->name('home')->middleware('web');

// Page d'accueil alternative
Route::get('/welcome', function () {
    return view('welcome');
});

// Produits publics
Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/featured', [ProductController::class, 'featured'])->name('products.featured');
Route::get('/products/filter/ajax', [ProductController::class, 'ajaxFilter'])->name('products.ajax.filter');
Route::get('/products/category/{category}', [ProductController::class, 'filterByCategory'])->name('products.filter');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/favorite', [ProductController::class, 'addToFavorites'])->name('products.favorite');

// Vérification de factures
Route::get('/invoices/verify/{id}/{token}', [InvoiceController::class, 'verify'])->name('invoices.verify');

// Tests publics
Route::get('/test', function () {
    return response()->json(['message' => 'API OK']);
});

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION
|--------------------------------------------------------------------------
*/

// Auth classique
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Routes pour invités uniquement
Route::middleware('guest')->group(function () {
    // Inscription avec étapes
    Route::get('/register', [RegisterWithCodeController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterWithCodeController::class, 'handleStep'])->name('register.submit');
    Route::post('/register/code', [RegisterWithCodeController::class, 'sendCode'])->name('register.code');
    Route::get('/register/verify-code', [RegisterWithCodeController::class, 'showVerifyForm'])->name('register.verify');
    Route::post('/register/verify-code', [RegisterWithCodeController::class, 'verifyCode'])->name('register.verify.submit');
    Route::post('/register/code/resend', [RegisterWithCodeController::class, 'resendCode'])->name('register.code.resend');
    Route::get('/register/set-password', [RegisterWithCodeController::class, 'showSetPasswordForm'])->name('register.set.password');
    Route::post('/register/set-password', [RegisterWithCodeController::class, 'setPassword'])->name('register.set.password.submit');

    // Récupération de mot de passe avec code (OTP)
    Route::get('/forgot-password-code', [ForgotPasswordWithCodeController::class, 'showRequestForm'])->name('password.code.request');
    Route::post('/forgot-password-code', [ForgotPasswordWithCodeController::class, 'sendCode'])->name('password.code.send');
    Route::get('/verify-code', [ForgotPasswordWithCodeController::class, 'showVerifyForm'])->name('password.verify.code.form');
    Route::post('/verify-code', [ForgotPasswordWithCodeController::class, 'verifyCode'])->name('password.code.check');
    Route::get('/reset-password', function () { return view('auth.reset-password'); })->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordWithCodeController::class, 'resetPassword'])->name('password.store');
});

// Page de déconnexion
Route::get('/goodbye', fn () => view('auth.goodbye'))->name('goodbye');

/*
|--------------------------------------------------------------------------
| ROUTES AUTHENTIFIÉES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    
    // Dashboard et profil
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Gestion du panier
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/panier/mise-a-jour/{cartItemId}', [CartController::class, 'update'])->name('cart.update');
    
    // Codes promo dans le panier
    Route::post('/cart/apply-coupon', [CartController::class, 'applyPromo'])->name('cart.apply-coupon');
    Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.applyPromo');
    Route::post('/cart/remove-promo', [CartController::class, 'removePromo'])->name('cart.removePromo');

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success', [CartController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/cancel', [CartController::class, 'checkoutCancel'])->name('checkout.cancel');

    // Commandes utilisateur
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::delete('/orders/clear', [OrderController::class, 'clear'])->name('orders.clear');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/clear', [NotificationController::class, 'clearAll'])->name('notifications.clear');

    // Messages
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

    // Fidélité
    Route::get('/fidelite', [FidelityController::class, 'index'])->name('fidelity.calendar');

    // Codes promos
    Route::resource('promos', PromoController::class);
    Route::get('/promos/{promo}/usage-history', [PromoController::class, 'usageHistory'])->name('promos.usage-history');
    
    // Produits favoris
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/add/{product}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::delete('/favorites/remove/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');

    // Onboarding
    Route::post('/onboarding/mark-seen', [OnboardingController::class, 'markAsSeen'])->name('onboarding.mark-seen');
    Route::get('/onboarding/has-seen', [OnboardingController::class, 'hasSeen'])->name('onboarding.has-seen');
    Route::get('/onboarding/steps', [OnboardingController::class, 'getSteps'])->name('onboarding.steps');
    Route::post('/onboarding/reset', [OnboardingController::class, 'reset'])->name('onboarding.reset');

    // Aide
    Route::get('/help', [HelpController::class, 'index'])->name('help.index');
    Route::get('/help/client', [HelpController::class, 'client'])->name('help.client');
    Route::get('/help/admin', [HelpController::class, 'admin'])->name('help.admin');
    Route::get('/help/livreur', [HelpController::class, 'livreur'])->name('help.livreur');

    // Gestion des produits (pour utilisateurs authentifiés)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggleActive');
});

// Routes vendeur supprimées - conflit avec le groupe ci-dessous

/*
|--------------------------------------------------------------------------
| ROUTES LIVREURS
|--------------------------------------------------------------------------
*/

// Routes livreurs avec middleware spécifique
Route::middleware(['auth'])->prefix('livreurs')->name('livreur.')->group(function () {
    Route::get('/orders', [LivreurController::class, 'index'])->name('orders');
    Route::patch('/orders/{order}', [LivreurController::class, 'markAsDelivered'])->name('delivery.complete');
    Route::get('/view-route/{order}', [LivreurController::class, 'viewRoute'])->name('view-route');
});

// Routes livreurs alternatives (sans middleware livreur spécifique)
Route::middleware(['auth'])->group(function () {
    Route::get('/livreurs', [LivreurController::class, 'index'])->name('livreurs.route_liste');
    Route::get('/livreurs/orders', [LivreurController::class, 'index'])->name('livreur.orders');
    Route::patch('/livreurs/orders/{order}', [LivreurController::class, 'markAsDelivered'])->name('livreurs.delivery.complete');
    Route::get('/livreurs/view-route/{order}', [LivreurController::class, 'viewRoute'])->name('livreur.view-route');
    Route::get('/livreur/planning', [LivreurController::class, 'planning'])->name('livreurs.planning');
    // Route protégée pour livreur
    Route::middleware(['auth'])->get('/livreur/commandes', [OrderController::class, 'livreurCommandes'])->name('livreurs.orders.index');
    Route::patch('/livreur/commande/{id}/complete', [OrderController::class, 'completeDelivery'])->name('livreur.commande.complete');
});

// Route AJAX pour mise à jour de la position du livreur
Route::post('/livreur/update-location', [LivreurController::class, 'updateLocation'])
    ->middleware(['auth']);

// Route AJAX pour récupération des livraisons selon la période
Route::post('/livreur/fetch-deliveries', [LivreurController::class, 'fetchDeliveries'])->middleware(['auth']);

// Page de livraison
Route::get('/delivery', function () {
    return view('delivery.index');
});

/*
|--------------------------------------------------------------------------
| ROUTES VENDEURS
|--------------------------------------------------------------------------
*/

// Routes vendeurs
Route::middleware(['auth', 'role:vendeur'])->prefix('vendeur')->name('vendeur.')->group(function () {
    // Dashboard vendeur
    Route::get('/dashboard', [\App\Http\Controllers\VendorDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des commandes vendeur
    Route::get('/orders', [\App\Http\Controllers\VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\VendorOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/prepare', [\App\Http\Controllers\VendorOrderController::class, 'markAsPrepared'])->name('orders.prepare');
    
    // Gestion des produits vendeur
    Route::resource('products', \App\Http\Controllers\VendorProductController::class);
    Route::put('/products/{product}/toggle', [\App\Http\Controllers\VendorProductController::class, 'toggle'])->name('products.toggle');
    
    // Gestion des catégories vendeur
    Route::resource('categories', \App\Http\Controllers\VendorCategoryController::class);
    
    // Gestion des codes promos vendeur
    Route::resource('promos', \App\Http\Controllers\VendorPromoController::class);
    
    // Gestion des livreurs du vendeur
    Route::resource('livreurs', \App\Http\Controllers\VendorLivreurController::class);
    Route::get('/livreurs-tous', [\App\Http\Controllers\VendorLivreurController::class, 'allLivreurs'])->name('livreurs.all');
    
    // Gestion rapide
    Route::get('/quick-manage', [\App\Http\Controllers\VendorQuickManageController::class, 'index'])->name('quick-manage');
    Route::get('/quickmanage', [\App\Http\Controllers\VendorQuickManageController::class, 'index'])->name('quickmanage');
});

/*
|--------------------------------------------------------------------------
| ROUTES ADMINISTRATEUR
|--------------------------------------------------------------------------
*/

// Définition du middleware admin
Route::aliasMiddleware('admin', function ($request, $next) {
    if (!auth()->check() || !auth()->user()->hasRole('admin')) {
        abort(403);
    }
    return $next($request);
});

// Test middleware admin
Route::get('/test-admin', function () {
    return 'Admin reconnu !';
})->middleware('admin');

// Routes admin principales
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [UserManagementController::class, 'details'])->name('users.list');
    Route::resource('users', AdminUserController::class);
    Route::put('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
    Route::get('users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::post('users/{user}/update-password', [AdminUserController::class, 'updatePassword'])->name('users.update-password');
    Route::post('users/{user}/block', [\App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block');
    Route::post('users/{user}/unblock', [\App\Http\Controllers\Admin\UserController::class, 'unblock'])->name('users.unblock');
    
    // Gestion des commandes admin
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'adminShow'])->name('orders.show');
    Route::put('/orders/{order}/delivery-notes', [OrderController::class, 'updateDeliveryNotes'])->name('orders.updateDeliveryNotes');
    Route::put('/orders/{order}/update-delivery-notes', [OrderController::class, 'updateDeliveryNotes'])->name('orders.updateDeliveryNotesAlt');
    Route::post('/orders/{order}/assign-livreur', [OrderController::class, 'assignLivreur'])->name('orders.assignLivreur');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Factures admin
    Route::get('/orders/{order}/facture', [OrderController::class, 'invoice'])->name('orders.invoice');
    Route::get('/orders/export/pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');
    Route::get('/orders/pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');
    
    // Gestion des stocks
    Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('/products/inventory', [ProductController::class, 'inventory'])->name('products.inventory');
    Route::patch('/products/{id}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');
    
    // Gestion des transactions
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class);
    Route::post('transactions/{transaction}/mark-completed', [\App\Http\Controllers\Admin\TransactionController::class, 'markAsCompleted'])->name('transactions.mark-completed');
    Route::post('transactions/{transaction}/mark-failed', [\App\Http\Controllers\Admin\TransactionController::class, 'markAsFailed'])->name('transactions.mark-failed');
    Route::post('transactions/{transaction}/mark-refunded', [\App\Http\Controllers\Admin\TransactionController::class, 'markAsRefunded'])->name('transactions.mark-refunded');
    Route::get('transactions/export/csv', [\App\Http\Controllers\Admin\TransactionController::class, 'export'])->name('transactions.export');
    
    // Gestion des rôles et permissions
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::post('users/{user}/assign-role', [\App\Http\Controllers\Admin\RoleController::class, 'assignRole'])->name('users.assign-role');
    Route::delete('users/{user}/remove-role', [\App\Http\Controllers\Admin\RoleController::class, 'removeRole'])->name('users.remove-role');
    Route::get('permissions', [\App\Http\Controllers\Admin\RoleController::class, 'permissions'])->name('permissions.index');
    Route::post('permissions', [\App\Http\Controllers\Admin\RoleController::class, 'createPermission'])->name('permissions.create');
    Route::delete('permissions/{permission}', [\App\Http\Controllers\Admin\RoleController::class, 'destroyPermission'])->name('permissions.destroy');
    
    // Test des commandes récentes
    Route::get('/test-orders', function () {
        $orders = \App\Models\Order::latest()->take(5)->get();
        return view('admin.latest-orders', compact('orders'));
    })->name('latestOrders');

    // ... autres routes admin ...
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products.index');
});

// Routes admin alternatives (pour compatibilité)
Route::middleware(['auth', 'admin'])->group(function () {
    // Facture avec closure
    Route::get('/admin/orders/{order}/facture', function (\App\Models\Order $order) {
        $total = 0;
        foreach ($order->products as $product) {
            $price = $product->pivot->price ?? $product->price ?? 0;
            $qty = $product->pivot->quantity ?? 1;
            $total += $price * $qty;
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice-order', [
            'order' => $order,
            'user' => $order->user,
            'total' => $total,
        ]);

        return $pdf->download('facture-commande-' . $order->id . '.pdf');
    })->name('admin.orders.invoice');
    
    // Routes utilisateurs admin alternatives (commentées pour éviter les conflits)
    // Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    // Route::get('/admin/users/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.editUser');
    // Route::put('/admin/users/{user}', [AdminUserController::class, 'update'])->name('admin.updateUser');
    // Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.deleteUser');
    // Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    // Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Export PDF
    Route::get('/admin/orders/pdf', [OrderController::class, 'exportPdf'])->name('orders.exportPdf');
});

// Routes pour la gestion des permissions (admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::post('permissions/generate-default', [\App\Http\Controllers\Admin\PermissionController::class, 'generateDefaultPermissions'])->name('permissions.generate-default');
    Route::get('permissions/{permission}/stats', [\App\Http\Controllers\Admin\PermissionController::class, 'stats'])->name('permissions.stats');
    Route::post('permissions/{permission}/assign-role', [\App\Http\Controllers\Admin\PermissionController::class, 'assignToRole'])->name('permissions.assign-role');
    Route::post('permissions/{permission}/remove-role', [\App\Http\Controllers\Admin\PermissionController::class, 'removeFromRole'])->name('permissions.remove-role');
});

/*
|--------------------------------------------------------------------------
| CRUD RESOURCES
|--------------------------------------------------------------------------
*/

// CRUD Produits
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::put('/products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggleActive');
});

// CRUD Catégories
Route::resource('categories', CategoryController::class);
 
// OU routes individuelles :
// Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
// Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
/*
|--------------------------------------------------------------------------
| GESTION DES DEVISES
|--------------------------------------------------------------------------
*/

Route::prefix('currency')->group(function () {
    Route::post('/change', [CurrencyController::class, 'change'])->name('currency.change');
    Route::get('/rates', [CurrencyController::class, 'getRates'])->name('currency.rates');
    Route::post('/convert', [CurrencyController::class, 'convert'])->name('currency.convert');
});

// Route alternative pour changement de devise
Route::post('/currency/change', function (Request $request) {
    $currency = $request->input('currency');

    if (!in_array($currency, ['XOF', 'EUR', 'USD'])) {
        abort(400, 'Devise non supportée.');
    }

    session(['currency' => $currency]);

    return redirect($request->input('redirect_url', '/'));
})->name('currency.change');

/*
|--------------------------------------------------------------------------
| ROUTES DE TEST ET DEBUG
|--------------------------------------------------------------------------
*/

// Test Redis
Route::get('/test-redis', function () {
    try {
        // Test de mise en cache
        $start = microtime(true);
        
        // Test 1: Mise en cache d'une requête
        $products = Cache::tags(['products'])->remember('test.products', 60, function () {
            return \App\Models\Product::with(['category', 'brand'])->take(10)->get();
        });
        
        $time1 = microtime(true) - $start;
        
        // Test 2: Récupération depuis le cache
        $start = microtime(true);
        $products = Cache::tags(['products'])->get('test.products');
        $time2 = microtime(true) - $start;
        
        // Test 3: Requête sans cache
        $start = microtime(true);
        $products = \App\Models\Product::with(['category', 'brand'])->take(10)->get();
        $time3 = microtime(true) - $start;
        
        // Test de connexion Redis
        $redis = Cache::getRedis();
        $redisInfo = $redis->info();
        
        return response()->json([
            'status' => 'success',
            'redis_status' => 'fonctionnel',
            'test1_cache_write' => round($time1 * 1000, 2) . 'ms',
            'test2_cache_read' => round($time2 * 1000, 2) . 'ms',
            'test3_no_cache' => round($time3 * 1000, 2) . 'ms',
            'cache_hit' => Cache::tags(['products'])->has('test.products'),
            'redis_version' => $redisInfo['redis_version'] ?? 'unknown',
            'connected_clients' => $redisInfo['connected_clients'] ?? 'unknown'
        ]);
    } catch (\Exception $e) {
        \Log::error('Redis test error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Test API
Route::put('/test', fn (Request $request) => response()->json(['success' => true, 'status' => $request->status]));

// Test message Pusher
Route::get('/send-message', fn () => event(new \App\Events\MessageSent('Hello from Pusher!')) && response()->json(['message' => 'Message envoyé !']));

/*
|--------------------------------------------------------------------------
| ROUTES AUTH INCLUSES
|--------------------------------------------------------------------------
*/

// Include auth routes
require __DIR__.'/auth.php';

Route::get('/contact-admin', [ContactAdminController::class, 'show'])->name('contact-admin.show');
Route::post('/contact-admin', [ContactAdminController::class, 'send'])->name('contact-admin.send');
Route::get('/livreur/profil', [LivreurController::class, 'profile'])->name('livreur.profile');

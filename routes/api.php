<?php
use Illuminate\Http\Request;

// use App\Http\Controllers\API\AuthController;
// use App\Http\Controllers\API\CartController;
// use App\Http\Controllers\API\ProductController;
// use App\Http\Controllers\API\CategoryController;
// use App\Http\Controllers\API\OrderController;
// use App\Http\Controllers\API\ProfileController;
// use App\Http\Controllers\API\NotificationController;
// use App\Http\Controllers\API\PaymentController;
// use App\Http\Controllers\API\LivreurController;
// use App\Http\Controllers\API\FavoriteController;
// use App\Http\Controllers\API\AddressController;
// use App\Http\Controllers\API\ReviewController;
// use App\Http\Controllers\API\DeliveryController;
use Illuminate\Support\Facades\Route;
 

 
/*a
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

// Route::get('/products', [ProductController::class, 'index']);

// Routes publiques
// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     // Ici tu peux définir les routes protégées par le middleware Admin
//     Route::get('/admin/orders', [OrderController::class, 'adminOrders']);
//     // Ajoute d'autres routes pour les administrateurs
// });


// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/verify-code', [AuthController::class, 'verifyCode']);
// Route::post('/resend-code', [AuthController::class, 'resendCode']);
// Route::post('/set-password', [AuthController::class, 'setPassword']);

// Réinitialisation de mot de passe
// Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
// Route::post('/verify-reset-code', [AuthController::class, 'verifyResetCode']);
// Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Routes publiques pour les produits et catégories
// Route::get('/products', [ProductController::class, 'index']);  
// Route::get('/products/featured', [ProductController::class, 'featured']);
// Route::get('/products/{product}', [ProductController::class, 'show']);
// Route::get('/products/category/{category}', [ProductController::class, 'filterByCategory']);
// Route::get('/products/filter', [ProductController::class, 'filter']);

// Route::get('/categories', [CategoryController::class, 'index']);
// Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Modification de la devise
// Route::post('/currency/change', [PaymentController::class, 'changeCurrency']);

// Routes protégées par authentification
// Route::middleware('auth:sanctum')->group(function () {
//     // Informations utilisateur et logout
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::post('/logout', [AuthController::class, 'logout']);
    
//     // Profil utilisateur
//     Route::get('/profile', [ProfileController::class, 'show']);
//     Route::put('/profile', [ProfileController::class, 'update']);
    
//     // Panier
//     Route::get('/cart', [CartController::class, 'index']);
//     Route::post('/cart/add/{product}', [CartController::class, 'add']);
//     Route::delete('/cart/remove/{item}', [CartController::class, 'remove']);
//     Route::put('/cart/update', [CartController::class, 'update']);
//     Route::delete('/cart/clear', [CartController::class, 'clear']);
//     Route::get('/checkout', [CartController::class, 'checkout']);
    
//     // Commandes
//     Route::get('/orders', [OrderController::class, 'index']);
//     Route::get('/orders/{order}', [OrderController::class, 'show']);
//     Route::post('/orders', [OrderController::class, 'store']);
//     Route::delete('/orders/clear', [OrderController::class, 'clear']);
    
//     // Notifications
//     Route::get('/notifications', [NotificationController::class, 'index']);
//     Route::post('/notifications/mark-read/{id}', [NotificationController::class, 'markAsRead']);
//     Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
//     Route::post('/notifications/clear', [NotificationController::class, 'clearAll']);
    
//     // Routes pour les livreurs
//     Route::middleware('livreur')->prefix('livreur')->group(function () {
//         Route::get('/orders', [LivreurController::class, 'index']);
//         Route::patch('/orders/{order}/deliver', [LivreurController::class, 'markAsDelivered']);
//         Route::get('/orders/{order}/route', [LivreurController::class, 'viewRoute']);
//     });
    
//     // Routes pour les admins
//     Route::middleware('admin')->prefix('admin')->group(function () {
//         // Gestion produits
//         Route::get('/products', [ProductController::class, 'adminIndex']);
//         Route::post('/products', [ProductController::class, 'store']);
//         Route::put('/products/{product}', [ProductController::class, 'update']);
//         Route::delete('/products/{product}', [ProductController::class, 'destroy']);
//         Route::put('/products/{product}/toggle-active', [ProductController::class, 'toggleActive']);
//         Route::get('/products/inventory', [ProductController::class, 'inventory']);
//         Route::patch('/products/{product}/stock', [ProductController::class, 'updateStock']);
        
//         // Gestion catégories
//         Route::post('/categories', [CategoryController::class, 'store']);
//         Route::put('/categories/{category}', [CategoryController::class, 'update']);
//         Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
        
//         // Gestion commandes
//         Route::get('/orders', [OrderController::class, 'adminIndex']);
//         Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
//         Route::post('/orders/{order}/assign-livreur', [OrderController::class, 'assignLivreur']);
//         Route::put('/orders/{order}/delivery-notes', [OrderController::class, 'updateDeliveryNotes']);
//         Route::get('/orders/export', [OrderController::class, 'export']);
//         Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice']);
        
//         // Gestion stocks
//         Route::get('/stocks', [ProductController::class, 'stocks']);
//     });

//     // Favoris
//     Route::get('/favorites', [FavoriteController::class, 'index']);
//     Route::post('/favorites/{product}', [FavoriteController::class, 'toggle']);
//     Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy']);

//     // Adresses
//     Route::get('/addresses', [AddressController::class, 'index']);
//     Route::post('/addresses', [AddressController::class, 'store']);
//     Route::put('/addresses/{address}', [AddressController::class, 'update']);
//     Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);
//     Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault']);

//     // Avis/Reviews
//     Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);
//     Route::post('/products/{product}/reviews', [ReviewController::class, 'store']);
//     Route::put('/reviews/{review}', [ReviewController::class, 'update']);
//     Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
//     Route::post('/reviews/{review}/report', [ReviewController::class, 'report']);

//     // Routes pour les commandes
//     Route::post('/orders', [OrderController::class, 'create']);
//     Route::get('/orders/delivery-options', [OrderController::class, 'getDeliveryOptions']);
// });

// Routes de livraison
Route::prefix('delivery')->group(function () {
    Route::get('test', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'API de livraison fonctionnelle'
        ]);
    });
    
    // Route::get('options', [DeliveryController::class, 'getOptions']);
    // Route::post('calculate', [DeliveryController::class, 'calculateCost']);
});

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});

 

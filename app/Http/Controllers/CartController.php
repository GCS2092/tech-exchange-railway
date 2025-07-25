<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Promotion;
use App\Models\PromoUsage;
use App\Constants\MessageText;
use App\Models\Order;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    const MINIMUM_AMOUNT = 1000; // Montant minimum en FCFA

    // 🛒 Afficher le panier
    public function index(Request $request)
    {
        $cartKey = 'cart.' . auth()->id();
        
        $cart = Cache::remember($cartKey, 3600, function () {
            return auth()->user()->cartItems()->with('product')->get();
        });
        
        $total = 0;
    
        // Calcul du total original des articles - CORRECTION: utiliser une méthode unifiée d'accès au prix
        foreach ($cart as $item) {
            // Assurez-vous que le prix unitaire est correctement défini
            if (!$item->price || $item->price <= 0) {
                // Si le prix dans le panier est invalide, utilisez le prix du produit
                if (isset($item->product) && $item->product->price > 0) {
                    $item->price = $item->product->price;
                    $item->save(); // Mettre à jour le prix dans la base de données
                }
            }
            
            $itemPrice = $item->price ?? ($item->product->price ?? 0);
            $total += $itemPrice * $item->quantity;
            
            // Log pour débogage
            \Log::debug('Cart item price', [
                'cart_item_id' => $item->id,
                'product_id' => $item->product_id,
                'item_price_db' => $item->price,
                'product_price' => $item->product->price ?? 'null',
                'used_price' => $itemPrice
            ]);
        }
    
        $originalTotal = $total;
        $promo = Session::get('promo');
        $discount = 0;
    
        // ⚠️ Appliquer la promo uniquement si l'utilisateur l'a validée
        $applyPromo = $request->query('applyPromo', false);
        if ($applyPromo && $promo) {
            $discount = $total * ($promo['value'] / 100);
            $total = $total - $discount;
        }
    
        // Vérifier si le montant minimum est atteint
        $isMinimumAmountReached = $total >= self::MINIMUM_AMOUNT;
        
        // Produits populaires pour panier vide
        $popularProducts = [];
        if ($cart->isEmpty()) {
            $popularProducts = Product::where('is_active', true)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();
        }

        // Récupérer les produits complémentaires
        $complementaryProducts = collect();
        if (!$cart->isEmpty()) {
            // Récupérer les IDs des produits dans le panier
            $cartProductIds = $cart->pluck('product_id')->toArray();
            
            // Récupérer les produits complémentaires (produits actifs mais pas dans le panier)
            $complementaryProducts = Product::where('is_active', true)
                ->whereNotIn('id', $cartProductIds)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }
    
        return view('cart.index', [
            'cart' => $cart,
            'total' => $total,
            'originalTotal' => $originalTotal,
            'discount' => $discount,
            'promo' => $promo,
            'isMinimumAmountReached' => $isMinimumAmountReached,
            'minimumAmount' => self::MINIMUM_AMOUNT,
            'complementaryProducts' => $complementaryProducts,
            'popularProducts' => $popularProducts
        ]);
    }
    
    // ➕ Ajouter un produit au panier
    public function add(Request $request, Product $product)
{
    $cartKey = 'cart.' . auth()->id();

    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Connectez-vous pour ajouter des produits au panier.');
    }

    if (!$product->is_active) {
        return redirect()->route('products.index')->with('error', 'Rupture de stock ! Ce produit est actuellement indisponible.');
    }

    $quantity = $request->input('quantity', 1);

    if (!is_numeric($quantity) || $quantity < 1) {
        $quantity = 1;
    }

    if (isset($product->stock)) {
        $currentCartItem = auth()->user()->cartItems()->where('product_id', $product->id)->first();
        $currentQuantity = $currentCartItem ? $currentCartItem->quantity : 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($product->stock <= 0 || $newQuantity > $product->stock) {
            return redirect()->back()->with('error', 'Stock insuffisant. Il reste seulement ' . $product->stock . ' unités disponibles.');
        }
    }

    $productPrice = $product->price ?? 0;
    if ($productPrice <= 0) {
        \Log::warning('Tentative d\'ajout d\'un produit avec un prix invalide', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $productPrice
        ]);
        return redirect()->back()->with('error', 'Le prix du produit n\'est pas valide.');
    }

    // Forcer la mise à jour du prix et de la quantité
    $cartItem = auth()->user()->cartItems()->updateOrCreate(
        ['product_id' => $product->id],
        ['price' => $productPrice, 'quantity' => $quantity] // Mettre à jour la quantité directement
    );

    // Invalider le cache
    Cache::forget($cartKey);

    // Recalculer les totaux si un code promo est appliqué
    $this->recalculateCartWithPromo();

    \Log::debug('Ajout d\'un produit au panier', [
        'product_id' => $product->id,
        'product_name' => $product->name,
        'price' => $productPrice,
        'quantity' => $quantity,
        'cart_item_id' => $cartItem->id
    ]);

    return redirect()->route('cart.index')->with('success', $product->name . ' ajouté au panier !');
}
    
    // 📝 Mettre à jour la quantité d'un produit
    public function update(Request $request, $cartItemId)
    {
        if (!$cartItemId) {
            return redirect()->route('cart.index')->with('error', 'ID de l\'élément du panier manquant.');
        }
    
        $item = auth()->user()->cartItems()->where('id', $cartItemId)->first();
        if (!$item) {
            return redirect()->route('cart.index')->with('error', 'Élément introuvable.');
        }
    
        $quantity = $item->quantity;
        if ($request->action === 'increase') {
            $quantity++;
            
            // Vérifier le stock disponible
            if (isset($item->product->stock) && $quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', 'Stock insuffisant. Il reste seulement ' . $item->product->stock . ' unités disponibles.');
            }
        } elseif ($request->action === 'decrease' && $quantity > 1) {
            $quantity--;
        }
    
        // CORRECTION: Assurez-vous que le prix est correct lors de la mise à jour
        if (!$item->price || $item->price <= 0) {
            // Si le prix dans le cart item est nul ou invalide, récupérer le prix du produit
            $productPrice = $item->product->price ?? 0;
            if ($productPrice <= 0) {
                return redirect()->route('cart.index')->with('error', 'Le prix du produit n\'est pas valide.');
            }
            
            $item->update([
                'quantity' => $quantity,
                'price' => $productPrice
            ]);
        } else {
            $item->update(['quantity' => $quantity]);
        }
    
        Cache::forget('cart.' . auth()->id());
        
        // Recalculer les totaux avec le code promo si nécessaire
        $this->recalculateCartWithPromo();
    
        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour avec succès.');
    }

    
    // 🗑️ Supprimer un produit du panier
    public function remove(Request $request)
    {
        $cartKey = 'cart.' . auth()->id();
        
        $cartItemId = $request->input('id');
        
        if (!$cartItemId) {
            return redirect()->route('cart.index')->with('error', 'ID de l\'élément du panier manquant.');
        }
        
        // Supprimer l'élément du panier
        $deleted = auth()->user()->cartItems()->where('id', $cartItemId)->delete();
        
        if (!$deleted) {
            return redirect()->route('cart.index')->with('error', 'Impossible de supprimer l\'élément du panier.');
        }
        
        // Invalider le cache du panier
        Cache::forget($cartKey);
        
        // Recalculer les totaux avec le code promo si nécessaire
        $this->recalculateCartWithPromo();
        
        return redirect()->route('cart.index')->with('success', 'Article supprimé du panier.');
    }
    
    // 🧹 Vider le panier
    public function clear()
    {
        $cartKey = 'cart.' . auth()->id();
        
        // Supprimer tous les éléments du panier de l'utilisateur
        auth()->user()->cartItems()->delete();
        
        // Invalider le cache
        Cache::forget($cartKey);
        
        // Supprimer le code promo
        Session::forget('promo');
        
        return redirect()->route('cart.index')->with('success', 'Votre panier a été vidé avec succès.');
    }
    
    // ✅ Page de validation de commande
    public function checkout()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour finaliser votre commande.');
        }
        
        $cartKey = 'cart.' . auth()->id();
        $cart = Cache::remember($cartKey, 3600, function () {
            return auth()->user()->cartItems()->with('product')->get();
        });
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide. Ajoutez des produits avant de procéder au paiement.');
        }
        
        $originalTotal = 0;
        foreach ($cart as $item) {
            // CORRECTION: Utiliser une méthode unifiée pour calculer le prix
            $itemPrice = $item->price ?? ($item->product->price ?? 0);
            $originalTotal += $itemPrice * $item->quantity;
        }
        
        $total = $originalTotal;
        $discount = 0;
        
        // Appliquer un code promo si existant
        $promo = session()->get('promo');
        if ($promo) {
            $discount = $total * ($promo['value'] / 100);
            $total = $total - $discount;
            Session::flash('promo_checkout_info', MessageText::PROMO_LABEL . ' "' . $promo['code'] . '" appliqué! Vous économisez ' . number_format($discount, 2) . '€ (' . $promo['value'] . '%)');
        }
        
        return view('cart.checkout', compact('cart', 'total', 'promo', 'originalTotal', 'discount'));
    }

    // 🚀 Traitement du paiement
    public function processCheckout(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour finaliser votre commande.');
        }

        $cartKey = 'cart.' . auth()->id();
        $cart = Cache::remember($cartKey, 3600, function () {
            return auth()->user()->cartItems()->with('product')->get();
        });
        
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Calcul du total
        $total = $this->calculateCartTotal($cart);

        // Vérifier si le montant minimum est atteint
        if ($total < self::MINIMUM_AMOUNT) {
            return redirect()->route('cart.index')
                ->with('error', 'Le montant minimum pour passer commande est de ' . number_format(self::MINIMUM_AMOUNT, 0, ',', ' ') . ' FCFA');
        }

        // Validation des données
        $request->validate([
            'phone_number' => 'required|string|regex:/^\+?\d{8,15}$/',
            'payment_method' => 'required|string|in:card,orange_money,mtn_momo',
            'delivery_address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        // Calcul du total avec promo si existante
        $originalTotal = $total;
        $discount = 0;

        // Appliquer le code promo si existant
        $promo = session()->get('promo');
        if ($promo) {
            $discount = $total * ($promo['value'] / 100);
            $total = $total - $discount;
        }

        // Création de la commande
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'original_price' => $originalTotal,
            'status' => 'pending',
            'phone_number' => $request->phone_number,
            'payment_method' => $request->payment_method,
            'delivery_address' => $request->delivery_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'promo_code' => $promo['code'] ?? null,
            'discount_amount' => $discount
        ]);

        // Ajouter les produits à la commande
        foreach ($cart as $item) {
            // CORRECTION: Utiliser une méthode unifiée pour récupérer le prix
            $itemPrice = $item->price ?? ($item->product->price ?? 0);
            $order->products()->attach($item->product_id, [
                'quantity' => $item->quantity,
                'price' => $itemPrice
            ]);
        }

        // Enregistrer l'utilisation du code promo
        if ($promo) {
            PromoUsage::create([
                'user_id' => auth()->id(),
                'promotion_id' => $promo['id'],
                'order_id' => $order->id
            ]);
        }

        // Vider le panier
        auth()->user()->cartItems()->delete();
        Cache::forget($cartKey);
        session()->forget('promo');

        // Envoyer une notification
        auth()->user()->notify(new OrderPlacedNotification($order));

        return redirect()->route('checkout.success', ['order' => $order->id])->with('success', 'Votre commande a été passée avec succès !');
    }

    // 🎉 Page de succès après paiement
    public function checkoutSuccess(Request $request, Order $order)
    {
        if (!auth()->check() || auth()->id() !== $order->user_id) {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return view('cart.success', compact('order'));
    }

    // ❌ Page d'annulation du paiement
    public function checkoutCancel()
    {
        return view('cart.cancel');
    }
    
    // 🎟️ Appliquer un code promo
    public function applyPromo(Request $request)
    {
        $promoCode = $request->input('code');
        
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour utiliser un code promo.');
        }
        
        $cartKey = 'cart.' . auth()->id();
        $cart = Cache::remember($cartKey, 3600, function () {
            return auth()->user()->cartItems()->with('product')->get();
        });
    
        if ($cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide. Ajoutez des produits avant d\'appliquer un code promo.');
        }
    
        // Vérifier si le code promo existe
        $promo = Promotion::where('code', $promoCode)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();
    
        if (!$promo) {
            return redirect()->route('cart.index')->with('error', 'Code promo invalide ou expiré.');
        }
    
        // Vérifier si le code promo a atteint son nombre maximum d'utilisations
        if ($promo->max_uses && $promo->uses_count >= $promo->max_uses) {
            return redirect()->route('cart.index')->with('error', 'Ce code promo a atteint son nombre maximum d\'utilisations.');
        }
    
        // Vérifier si le code promo a déjà été utilisé par cet utilisateur
        $userPromoUsage = PromoUsage::where('user_id', auth()->id())
            ->where('promotion_id', $promo->id)
            ->count();
    
        if ($promo->max_uses_per_user && $userPromoUsage >= $promo->max_uses_per_user) {
            return redirect()->route('cart.index')->with('error', 'Vous avez déjà utilisé ce code promo le nombre maximum de fois autorisé.');
        }
    
        // Calculer la réduction
        $cartTotal = $this->calculateCartTotal($cart);
        $discount = $cartTotal * ($promo->value / 100);
        $discountedTotal = $cartTotal - $discount;
    
        // Stocker les informations du code promo
        session()->put('promo', [
            'id' => $promo->id,
            'code' => $promo->code,
            'value' => $promo->value,
            'discounted_total' => $discountedTotal,
            'original_total' => $cartTotal,
        ]);
    
        return redirect()->route('cart.index', ['applyPromo' => true])
            ->with('success', 'Code promo "' . $promo->code . '" appliqué avec succès! Vous économisez ' . \App\Helpers\CurrencyHelper::format($discount, 'XOF') . '.');
    }
    
    // Supprimer un code promo
    public function removePromo()
    {
        $promoCode = Session::get('promo.code');
        Session::forget('promo');
        
        if ($promoCode) {
            return redirect()->route('cart.index')->with('success', 'Code promo "' . $promoCode . '" retiré du panier.');
        }
        
        return redirect()->route('cart.index');
    }
    
    // CORRECTION: Méthode unifiée pour calculer le total du panier
    protected function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            // Utiliser une méthode cohérente et robuste pour récupérer le prix
            $itemPrice = $item->price ?? ($item->product->price ?? 0);
            $total += $itemPrice * $item->quantity;
            
            // Journalisation pour le débogage
            \Log::debug('Item price calculation', [
                'item_id' => $item->id ?? 'unknown',
                'item_price' => $item->price ?? 'null',
                'product_price' => $item->product->price ?? 'null',
                'used_price' => $itemPrice,
                'quantity' => $item->quantity ?? 1,
                'subtotal' => $itemPrice * ($item->quantity ?? 1)
            ]);
        }
        return $total;
    }
    
    // Recalculer le panier avec le code promo si applicable
    protected function recalculateCartWithPromo()
    {
        $promo = Session::get('promo');
        
        if ($promo) {
            $cartKey = 'cart.' . auth()->id();
            $cart = Cache::remember($cartKey, 3600, function () {
                return auth()->user()->cartItems()->with('product')->get();
            });
            
            $cartTotal = $this->calculateCartTotal($cart);
            $discount = $cartTotal * ($promo['value'] / 100);
            
            // Mettre à jour les totaux dans la session
            $promo['original_total'] = $cartTotal;
            $promo['discounted_total'] = $cartTotal - $discount;
            
            Session::put('promo', $promo);
        }
    }
}
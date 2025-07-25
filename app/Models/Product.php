<?php

namespace App\Models;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'is_active',
        'quantity',
        'is_featured',
        'min_stock_alert',
        'max_stock_alert',
        'seller_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'min_stock_alert' => 'integer',
        'max_stock_alert' => 'integer',
    ];

    // Relation avec les favoris
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Relation avec les items de commande
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relation avec la catégorie
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function reviews()
    {
        return $this->hasMany(Avis::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    // === GESTION AVANCÉE DES STOCKS ===

    /**
     * Vérifier si le stock est suffisant
     */
    public function checkStock(int $quantity): bool
    {
        return $this->quantity >= $quantity;
    }

    /**
     * Vérifier si le produit est en stock
     */
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Vérifier si le stock est faible
     */
    public function isLowStock(): bool
    {
        $minStock = $this->min_stock_alert ?? 5;
        return $this->quantity <= $minStock;
    }

    /**
     * Vérifier si le stock est épuisé
     */
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    /**
     * Réduire le stock de manière sécurisée
     */
    public function reduceStock(int $quantity): bool
    {
        if (!$this->checkStock($quantity)) {
            Log::warning("Tentative de réduction de stock impossible", [
                'product_id' => $this->id,
                'requested_quantity' => $quantity,
                'available_quantity' => $this->quantity
            ]);
            return false;
        }

        $this->decrement('quantity', $quantity);
        
        // Vérifier si le stock est maintenant faible
        if ($this->isLowStock()) {
            $this->triggerLowStockAlert();
        }

        Log::info("Stock réduit avec succès", [
            'product_id' => $this->id,
            'quantity_reduced' => $quantity,
            'new_quantity' => $this->quantity
        ]);

        return true;
    }

    /**
     * Augmenter le stock
     */
    public function increaseStock(int $quantity): void
    {
        $this->increment('quantity', $quantity);
        
        Log::info("Stock augmenté", [
            'product_id' => $this->id,
            'quantity_added' => $quantity,
            'new_quantity' => $this->quantity
        ]);
    }

    /**
     * Définir le stock
     */
    public function setStock(int $quantity): void
    {
        $oldQuantity = $this->quantity;
        $this->update(['quantity' => $quantity]);
        
        Log::info("Stock défini", [
            'product_id' => $this->id,
            'old_quantity' => $oldQuantity,
            'new_quantity' => $quantity
        ]);
    }

    /**
     * Déclencher une alerte de stock faible
     */
    private function triggerLowStockAlert(): void
    {
        // Envoyer notification aux admins
        $admins = User::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\LowStockAlert($this));
        }
        // Notifier aussi le vendeur du produit
        if ($this->seller) {
            $this->seller->notify(new \App\Notifications\LowStockAlert($this));
        }
        Log::warning("Alerte de stock faible déclenchée", [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'current_quantity' => $this->quantity
        ]);
    }

    /**
     * Méthode pour effectuer un achat avec gestion de stock améliorée
     */
    public function purchase(int $userId, int $qty)
    {
        // Vérifier le stock
        if (!$this->checkStock($qty)) {
            throw new \Exception("Stock insuffisant pour {$this->name}. Disponible: {$this->quantity}");
        }

        // Vérifier si le produit est actif
        if (!$this->is_active) {
            throw new \Exception("Le produit {$this->name} n'est plus disponible.");
        }

        // Créer la commande
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $this->price * $qty,
            'status' => 'en attente',
        ]);

        // Attacher le produit à la commande
        $order->products()->attach($this->id, [
            'quantity' => $qty,
            'price' => $this->price,
        ]);

        // Réduire le stock
        $this->reduceStock($qty);

        return $order;
    }

    // === SCOPES POUR FILTRER ===

    /**
     * Scope pour les produits en stock
     */
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    /**
     * Scope pour les produits en rupture
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /**
     * Scope pour les produits avec stock faible
     */
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 5);
    }

    /**
     * Scope pour les produits actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les produits mis en avant
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // === ATTRIBUTS CALCULÉS ===

    /**
     * Statut du stock en texte
     */
    public function getStockStatusAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'Rupture de stock';
        }
        
        if ($this->isLowStock()) {
            return 'Stock faible';
        }
        
        return 'En stock';
    }

    /**
     * Classe CSS pour le statut du stock
     */
    public function getStockStatusClassAttribute(): string
    {
        if ($this->isOutOfStock()) {
            return 'text-red-600 bg-red-100';
        }
        
        if ($this->isLowStock()) {
            return 'text-yellow-600 bg-yellow-100';
        }
        
        return 'text-green-600 bg-green-100';
    }
}

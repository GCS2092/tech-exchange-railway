<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;

    public const STATUSES = [
        'en attente' => 'En attente',
        'payé' => 'Payé',
        'en préparation' => 'En préparation',
        'expédié' => 'Expédié',
        'en livraison' => 'En livraison',
        'livré' => 'Livré',
        'annulé' => 'Annulé',
        'retourné' => 'Retourné',
        'remboursé' => 'Remboursé',
    ];

    // Statuts constants pour éviter les erreurs de frappe
    public const STATUS_PENDING = 'en attente';
    public const STATUS_PAID = 'payé';
    public const STATUS_PREPARING = 'en préparation';
    public const STATUS_SHIPPED = 'expédié';
    public const STATUS_DELIVERING = 'en livraison';
    public const STATUS_DELIVERED = 'livré';
    public const STATUS_CANCELLED = 'annulé';
    public const STATUS_RETURNED = 'retourné';
    public const STATUS_REFUNDED = 'remboursé';

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'livreur_id',
        'total_price',
        'original_price',
        'discount_amount',
        'promo_code',
        'status',
        'delivered_at',
        'phone_number',
        'payment_method',
        'latitude',
        'longitude',
        'delivery_address',
        'shipping_address',
        'billing_address',
        'total',
        'notes',
        'estimated_delivery_time',
        'actual_delivery_time',
    ];

    protected $casts = [
        'total_price' => 'float',
        'original_price' => 'float',
        'discount_amount' => 'float',
        'total' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'delivered_at' => 'datetime',
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['quantity', 'price'])
            ->withTimestamps();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function promoUsage()
    {
        return $this->hasOne(PromoUsage::class);
    }

    // === MÉTHODES DE STATUT ===

    public function isStatus($status)
    {
        return $this->status === $status;
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Vérifications de statut spécifiques
    public function isPending()
    {
        return $this->isStatus(self::STATUS_PENDING);
    }

    public function isPaid()
    {
        return $this->isStatus(self::STATUS_PAID);
    }

    public function isPreparing()
    {
        return $this->isStatus(self::STATUS_PREPARING);
    }

    public function isShipped()
    {
        return $this->isStatus(self::STATUS_SHIPPED);
    }

    public function isDelivering()
    {
        return $this->isStatus(self::STATUS_DELIVERING);
    }

    public function isDelivered()
    {
        return $this->isStatus(self::STATUS_DELIVERED);
    }

    public function isCancelled()
    {
        return $this->isStatus(self::STATUS_CANCELLED);
    }

    public function isReturned()
    {
        return $this->isStatus(self::STATUS_RETURNED);
    }

    public function isRefunded()
    {
        return $this->isStatus(self::STATUS_REFUNDED);
    }

    // === MÉTHODES DE TRANSITION DE STATUT ===

    public function markAsPaid()
    {
        $this->updateStatus(self::STATUS_PAID);
        Log::info("Commande marquée comme payée", ['order_id' => $this->id]);
    }

    public function markAsPreparing()
    {
        $this->updateStatus(self::STATUS_PREPARING);
        Log::info("Commande en préparation", ['order_id' => $this->id]);
    }

    public function markAsShipped()
    {
        $this->updateStatus(self::STATUS_SHIPPED);
        Log::info("Commande expédiée", ['order_id' => $this->id]);
    }

    public function markAsDelivering()
    {
        $this->updateStatus(self::STATUS_DELIVERING);
        Log::info("Commande en livraison", ['order_id' => $this->id]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'delivered_at' => now(),
            'actual_delivery_time' => now(),
        ]);
        
        Log::info("Commande livrée", [
            'order_id' => $this->id,
            'delivered_at' => now()
        ]);
    }

    public function markAsCancelled($reason = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'notes' => $reason ? "Annulée: $reason" : $this->notes,
        ]);

        // Restaurer les stocks
        $this->restoreProductStocks();
        
        Log::warning("Commande annulée", [
            'order_id' => $this->id,
            'reason' => $reason
        ]);
    }

    public function markAsReturned($reason = null)
    {
        $this->update([
            'status' => self::STATUS_RETURNED,
            'notes' => $reason ? "Retournée: $reason" : $this->notes,
        ]);
        
        Log::info("Commande retournée", [
            'order_id' => $this->id,
            'reason' => $reason
        ]);
    }

    public function markAsRefunded()
    {
        $this->updateStatus(self::STATUS_REFUNDED);
        Log::info("Commande remboursée", ['order_id' => $this->id]);
    }

    private function updateStatus($status)
    {
        $oldStatus = $this->status;
        $this->update(['status' => $status]);
        
        // Notifier le changement de statut
        $this->user->notify(new \App\Notifications\OrderStatusUpdated($this, $oldStatus, $status));
        
        Log::info("Statut de commande mis à jour", [
            'order_id' => $this->id,
            'old_status' => $oldStatus,
            'new_status' => $status
        ]);
    }

    // === GESTION DES STOCKS ===

    private function restoreProductStocks()
    {
        foreach ($this->products as $product) {
            $quantity = $product->pivot->quantity;
            $product->increaseStock($quantity);
        }
    }

    // === CALCULS ===

    public function getTotalCalculated()
    {
        return $this->products->sum(function ($product) {
            $price = $product->pivot->price;
            $qty = $product->pivot->quantity;
            return $price * $qty;
        });
    }

    public function getDiscountPercentage()
    {
        if ($this->original_price > 0) {
            return round((($this->original_price - $this->total_price) / $this->original_price) * 100, 2);
        }
        return 0;
    }

    public function getSavingsAmount()
    {
        return $this->original_price - $this->total_price;
    }

    // === SCOPES POUR FILTRER ===

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::STATUS_PAID);
    }

    public function scopePreparing($query)
    {
        return $query->where('status', self::STATUS_PREPARING);
    }

    public function scopeShipped($query)
    {
        return $query->where('status', self::STATUS_SHIPPED);
    }

    public function scopeDelivering($query)
    {
        return $query->where('status', self::STATUS_DELIVERING);
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeReturned($query)
    {
        return $query->where('status', self::STATUS_RETURNED);
    }

    public function scopeRefunded($query)
    {
        return $query->where('status', self::STATUS_REFUNDED);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', [
            self::STATUS_CANCELLED,
            self::STATUS_RETURNED,
            self::STATUS_REFUNDED
        ]);
    }

    // === ATTRIBUTS CALCULÉS ===

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? 'Inconnu';
    }

    public function getStatusClassAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_PAID => 'bg-blue-100 text-blue-800',
            self::STATUS_PREPARING => 'bg-purple-100 text-purple-800',
            self::STATUS_SHIPPED => 'bg-indigo-100 text-indigo-800',
            self::STATUS_DELIVERING => 'bg-orange-100 text-orange-800',
            self::STATUS_DELIVERED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            self::STATUS_RETURNED => 'bg-gray-100 text-gray-800',
            self::STATUS_REFUNDED => 'bg-pink-100 text-pink-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getCanBeCancelledAttribute()
    {
        return in_array($this->status, [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_PREPARING
        ]);
    }

    public function getCanBeReturnedAttribute()
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function getDeliveryTimeAttribute()
    {
        if ($this->delivered_at && $this->created_at) {
            return $this->created_at->diffInHours($this->delivered_at);
        }
        return null;
    }
}
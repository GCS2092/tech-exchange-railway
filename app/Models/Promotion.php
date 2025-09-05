<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Helpers\CurrencyHelper;

class Promotion extends Model
{
    protected $fillable = [
        'code', 
        'type', 
        'value', 
        'expires_at',
        'is_active',
        'max_uses',
        'min_order_amount',
        'description',
        'seller_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2'
    ];

    public function usages()
    {
        return $this->hasMany(PromoUsage::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'promo_code', 'code');
    }

    /**
     * Vérifie si le code promo est valide
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses && $this->usages()->count() >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Vérifie si un utilisateur peut utiliser ce code
     */
    public function canBeUsedBy($user)
    {
        if (!$this->isValid()) {
            return false;
        }

        // Vérifier si l'utilisateur a déjà utilisé ce code
        $alreadyUsed = $this->usages()->where('user_id', $user->id)->exists();
        
        return !$alreadyUsed;
    }

    /**
     * Calcule la réduction pour un montant donné
     */
    public function calculateDiscount($orderAmount)
    {
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) {
            return 0;
        }

        if ($this->type === 'percent') {
            return ($orderAmount * $this->value) / 100;
        }

        return $this->value;
    }

    /**
     * Formate la valeur de la réduction
     */
    public function getFormattedValueAttribute()
    {
        if ($this->type === 'percent') {
            return CurrencyHelper::formatPercent($this->value);
        }

        return CurrencyHelper::formatXOF($this->value);
    }

    /**
     * Formate le montant minimum de commande
     */
    public function getFormattedMinOrderAttribute()
    {
        if (!$this->min_order_amount) {
            return 'Aucun minimum';
        }

        return CurrencyHelper::formatXOF($this->min_order_amount);
    }

    /**
     * Obtient le statut du code promo
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'Inactif';
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return 'Expiré';
        }

        if ($this->max_uses && $this->usages()->count() >= $this->max_uses) {
            return 'Épuisé';
        }

        return 'Actif';
    }

    /**
     * Obtient le nombre d'utilisations restantes
     */
    public function getRemainingUsesAttribute()
    {
        if (!$this->max_uses) {
            return 'Illimité';
        }

        $used = $this->usages()->count();
        return max(0, $this->max_uses - $used);
    }

    /**
     * Scope pour les codes actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    /**
     * Scope pour les codes expirés
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }
}
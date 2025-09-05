<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    /**
     * Définir la colonne à utiliser pour le route model binding
     */
    public function getRouteKeyName()
    {
        return 'code';
    }

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_usage',
        'usage_count',
        'min_order_amount',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'float',
        'max_usage' => 'integer',
        'usage_count' => 'integer',
        'min_order_amount' => 'float',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relation avec les utilisations du code promo
     */
    public function usages()
    {
        return $this->hasMany(PromoUsage::class);
    }

    /**
     * Relation avec les commandes qui ont utilisé ce code
     */
    public function orders()
    {
        return $this->hasManyThrough(Order::class, PromoUsage::class);
    }

    /**
     * Vérifier si le code promo est valide
     */
    public function isValid()
    {
        return $this->is_active && 
               $this->expires_at > now() && 
               ($this->max_usage === null || $this->usage_count < $this->max_usage);
    }

    /**
     * Vérifier si le code promo peut être utilisé pour un montant donné
     */
    public function canBeUsedForAmount($amount)
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->min_order_amount && $amount < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    /**
     * Calculer la réduction pour un montant donné
     */
    public function calculateDiscount($amount)
    {
        if (!$this->canBeUsedForAmount($amount)) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return ($amount * $this->discount_value) / 100;
        } else {
            return min($this->discount_value, $amount);
        }
    }

    /**
     * Incrémenter le compteur d'utilisation
     */
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    /**
     * Scope pour les codes actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope pour les codes expirés
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    /**
     * Scope pour les codes utilisés
     */
    public function scopeUsed($query)
    {
        return $query->where('usage_count', '>', 0);
    }

    /**
     * Scope pour les codes non utilisés
     */
    public function scopeUnused($query)
    {
        return $query->where('usage_count', 0);
    }

    /**
     * Accesseur pour le statut
     */
    public function getStatusAttribute()
    {
        if ($this->expires_at < now()) {
            return 'expired';
        } elseif (!$this->is_active) {
            return 'inactive';
        } else {
            return 'active';
        }
    }

    /**
     * Accesseur pour le statut formaté
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'active':
                return 'Actif';
            case 'inactive':
                return 'Inactif';
            case 'expired':
                return 'Expiré';
            default:
                return 'Inconnu';
        }
    }

    /**
     * Accesseur pour le type de réduction formaté
     */
    public function getDiscountTypeTextAttribute()
    {
        return $this->discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe';
    }

    /**
     * Accesseur pour la valeur de réduction formatée
     */
    public function getDiscountValueFormattedAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value . '%';
        } else {
            return number_format($this->discount_value, 0, ',', ' ') . ' FCFA';
        }
    }

    /**
     * Accesseur pour le montant minimum formaté
     */
    public function getMinOrderAmountFormattedAttribute()
    {
        if (!$this->min_order_amount) {
            return 'Aucun minimum';
        }
        return number_format($this->min_order_amount, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur pour le nombre maximum d'utilisations formaté
     */
    public function getMaxUsageFormattedAttribute()
    {
        if (!$this->max_usage) {
            return 'Illimité';
        }
        return $this->max_usage;
    }
}

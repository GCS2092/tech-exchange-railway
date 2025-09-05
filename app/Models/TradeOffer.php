<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'offered_product_id',
        'message',
        'status',
        'responded_at',
        'custom_device_name',
        'custom_device_brand',
        'custom_device_model',
        'custom_device_type',
        'custom_device_description',
        'custom_device_condition',
        'custom_device_year',
        'custom_device_ram',
        'custom_device_storage',
        'custom_device_screen_size',
        'custom_device_os',
        'custom_device_color',
        'custom_device_processor',
        'custom_device_gpu',
        'additional_cash_amount',
        'offer_type'
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'additional_cash_amount' => 'decimal:2',
        'custom_device_year' => 'integer',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function offeredProduct()
    {
        return $this->belongsTo(Product::class, 'offered_product_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Méthodes
    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now()
        ]);
    }

    public function reject()
    {
        $this->update([
            'status' => 'rejected',
            'responded_at' => now()
        ]);
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'responded_at' => now()
        ]);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Méthodes pour l'appareil personnalisé
    public function hasCustomDevice()
    {
        return $this->offer_type === 'custom_device' && !empty($this->custom_device_name);
    }

    public function hasAdditionalCash()
    {
        return $this->additional_cash_amount > 0;
    }

    public function getFormattedAdditionalCashAttribute()
    {
        return \App\Helpers\CurrencyHelper::formatXOF($this->additional_cash_amount);
    }

    public function getCustomDeviceDisplayNameAttribute()
    {
        if ($this->hasCustomDevice()) {
            return $this->custom_device_brand . ' ' . $this->custom_device_model;
        }
        return null;
    }

    public function getCustomDeviceSpecsAttribute()
    {
        if (!$this->hasCustomDevice()) {
            return [];
        }

        $specs = [];
        
        if ($this->custom_device_ram) {
            $specs['RAM'] = $this->custom_device_ram;
        }
        if ($this->custom_device_storage) {
            $specs['Stockage'] = $this->custom_device_storage;
        }
        if ($this->custom_device_screen_size) {
            $specs['Écran'] = $this->custom_device_screen_size;
        }
        if ($this->custom_device_os) {
            $specs['OS'] = $this->custom_device_os;
        }
        if ($this->custom_device_color) {
            $specs['Couleur'] = $this->custom_device_color;
        }
        if ($this->custom_device_processor) {
            $specs['Processeur'] = $this->custom_device_processor;
        }
        if ($this->custom_device_gpu) {
            $specs['GPU'] = $this->custom_device_gpu;
        }
        if ($this->custom_device_year) {
            $specs['Année'] = $this->custom_device_year;
        }

        return $specs;
    }
} 
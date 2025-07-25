<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryOption extends Model
{
    protected $fillable = [
        'name',
        'type', // 'delivery' ou 'pickup'
        'zone', // 'zone1', 'zone2', etc.
        'fixed_price',
        'is_active'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
} 
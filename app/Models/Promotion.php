<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['code', 'type', 'value', 'expires_at'];

    public function usages()
    {
        return $this->hasMany(PromoUsage::class);
    }
}
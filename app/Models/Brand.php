<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    // Si tu veux autoriser l’assignation de masse (mass assignment)
    protected $fillable = ['name'];

    /**
     * Une marque peut avoir plusieurs produits
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

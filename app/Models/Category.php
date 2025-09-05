<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    // Correction : ajout de description et image_path
    protected $fillable = ['name', 'description', 'image_path'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

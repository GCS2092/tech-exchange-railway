<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PromoUsage extends Model
{
    protected $fillable = [
        'promotion_id', 
        'promo_code_id',
        'user_id', 
        'order_id',
        'original_amount',
        'discount_amount',
        'final_amount'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    
    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }
}

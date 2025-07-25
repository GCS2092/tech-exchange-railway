<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions, HasRoles;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'last_login_at',
        'phone_number',
        'profile_photo',
        'is_blocked',
        'eligible_for_reward',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
        'eligible_for_reward' => 'boolean',
    ];

    // === RELATIONS ===

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function commandesLivreur()
    {
        return $this->hasMany(Order::class, 'livreur_id');
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class);
    }

    public function cartItems()
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    // === MÉTHODES DE RÔLES UNIFIÉES (Spatie uniquement) ===

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isLivreur()
    {
        return $this->hasRole('livreur');
    }

    public function isClient()
    {
        return $this->hasRole('client');
    }

    public function isVendeur()
    {
        return $this->hasRole('vendeur');
    }

    public function isManager()
    {
        return $this->hasRole('manager');
    }

    public function isSupervisor()
    {
        return $this->hasRole('supervisor');
    }

    public function isSupport()
    {
        return $this->hasRole('support');
    }

    // === MÉTHODES DE PERMISSIONS ===

    public function canManageUsers()
    {
        return $this->hasPermissionTo('manage users');
    }

    public function canManageProducts()
    {
        return $this->hasPermissionTo('manage products');
    }

    public function canManageOrders()
    {
        return $this->hasPermissionTo('manage orders');
    }

    public function canViewReports()
    {
        return $this->hasPermissionTo('view reports');
    }

    public function canManageDelivery()
    {
        return $this->hasPermissionTo('manage delivery');
    }

    // === MÉTHODES UTILITAIRES ===

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo ? asset('storage/' . $this->profile_photo) : asset('/default-avatar.png');
    }

    public function eligibleOrdersForReward()
    {
        return $this->orders()
            ->where('total_price', '>=', 5000)
            ->orderBy('created_at', 'desc');
    }

    public function getTotalSpentAttribute()
    {
        return $this->orders()
            ->where('status', '!=', 'annulé')
            ->sum('total_price');
    }

    public function getOrderCountAttribute()
    {
        return $this->orders()
            ->where('status', '!=', 'annulé')
            ->count();
    }

    public function getAverageOrderValueAttribute()
    {
        $orderCount = $this->order_count;
        if ($orderCount > 0) {
            return $this->total_spent / $orderCount;
        }
        return 0;
    }

    // === MÉTHODES DE STATUT ===

    public function isActive()
    {
        return !$this->is_blocked;
    }

    public function isBlocked()
    {
        return $this->is_blocked;
    }

    public function block($reason = null)
    {
        $this->update(['is_blocked' => true]);
        
        Log::warning("Utilisateur bloqué", [
            'user_id' => $this->id,
            'reason' => $reason,
            'blocked_by' => auth()->id()
        ]);
    }

    public function unblock()
    {
        $this->update(['is_blocked' => false]);
        
        Log::info("Utilisateur débloqué", [
            'user_id' => $this->id,
            'unblocked_by' => auth()->id()
        ]);
    }

    // === SCOPES POUR FILTRER ===

    public function scopeActive($query)
    {
        return $query->where('is_blocked', false);
    }

    public function scopeBlocked($query)
    {
        return $query->where('is_blocked', true);
    }

    public function scopeAdmins($query)
    {
        return $query->role('admin');
    }

    public function scopeLivreurs($query)
    {
        return $query->role('livreur');
    }

    public function scopeClients($query)
    {
        return $query->role('client');
    }

    public function scopeVendeurs($query)
    {
        return $query->role('vendeur');
    }

    // === MÉTHODES DE SÉCURITÉ ===

    public function updateLastLogin()
    {
        $this->update(['last_login_at' => now()]);
        
        Log::info("Connexion utilisateur", [
            'user_id' => $this->id,
            'email' => $this->email,
            'ip' => request()->ip()
        ]);
    }

    public function canAccessAdminPanel()
    {
        return $this->hasAnyRole(['admin', 'manager', 'supervisor']);
    }

    public function canAccessLivreurPanel()
    {
        return $this->hasRole('livreur');
    }

    public function canAccessVendeurPanel()
    {
        return $this->hasRole('vendeur');
    }

    // === MÉTHODES DE NOTIFICATION ===

    public function sendOrderNotification($order, $message)
    {
        $this->notify(new \App\Notifications\OrderNotification($order, $message));
    }

    public function sendStatusUpdateNotification($order, $oldStatus, $newStatus)
    {
        $this->notify(new \App\Notifications\OrderStatusUpdated($order, $oldStatus, $newStatus));
    }

    // === ATTRIBUTS CALCULÉS ===

    public function getRoleLabelAttribute()
    {
        $role = $this->roles->first();
        return $role ? ucfirst($role->name) : 'Utilisateur';
    }

    public function getRoleClassAttribute()
    {
        return match($this->roles->first()?->name) {
            'admin' => 'bg-red-100 text-red-800',
            'manager' => 'bg-purple-100 text-purple-800',
            'supervisor' => 'bg-indigo-100 text-indigo-800',
            'vendeur' => 'bg-blue-100 text-blue-800',
            'livreur' => 'bg-green-100 text-green-800',
            'support' => 'bg-yellow-100 text-yellow-800',
            'client' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_blocked ? 'Bloqué' : 'Actif';
    }

    public function getStatusClassAttribute()
    {
        return $this->is_blocked ? 'text-red-600' : 'text-green-600';
    }
}

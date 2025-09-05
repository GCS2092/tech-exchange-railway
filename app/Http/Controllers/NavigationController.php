<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    /**
     * Récupérer les données de navigation optimisées
     */
    public static function getNavigationData()
    {
        $userId = Auth::id();
        $cacheKey = "navigation_data_{$userId}";
        
        return Cache::remember($cacheKey, 300, function () use ($userId) { // Cache 5 minutes
            $data = [
                'cart_count' => 0,
                'favorites_count' => 0,
                'notifications_count' => 0,
                'user_info' => null
            ];
            
            if ($userId) {
                $user = Auth::user();
                
                // Compteur du panier
                $data['cart_count'] = $user->cartItems()->sum('quantity');
                
                // Compteur des favoris
                $data['favorites_count'] = $user->favorites()->count();
                
                // Compteur des notifications non lues
                $data['notifications_count'] = $user->unreadNotifications()->count();
                
                // Informations utilisateur
                $data['user_info'] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->roles->first()->name ?? $user->role ?? 'user',
                    'avatar' => $user->profile_photo_url
                ];
            }
            
            return $data;
        });
    }
    
    /**
     * Invalider le cache de navigation
     */
    public static function clearNavigationCache($userId = null)
    {
        if (!$userId) {
            $userId = Auth::id();
        }
        
        if ($userId) {
            Cache::forget("navigation_data_{$userId}");
        }
    }
    
    /**
     * Mettre à jour le cache de navigation
     */
    public static function updateNavigationCache()
    {
        $userId = Auth::id();
        if ($userId) {
            Cache::forget("navigation_data_{$userId}");
            return self::getNavigationData();
        }
        
        return null;
    }
}

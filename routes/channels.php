<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal privé pour les commandes
Broadcast::channel('orders', function ($user) {
    return $user->hasRole('admin'); 
});

Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    $order = \App\Models\Order::find($orderId);
    return $user->id === $order->user_id || $user->hasRole('admin');
});

// Canal pour les administrateurs
Broadcast::channel('admin.orders', function ($user) {
    return $user->hasRole('admin');
});

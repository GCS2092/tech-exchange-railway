<?php
namespace App\Observers;

use App\Models\Order;
use App\Models\Transaction;
use App\Notifications\OrderDeliveredByLivreur;
use App\Models\User;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order)
    {
        // Créer une transaction 'pending' à la création de la commande
        Transaction::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'amount' => $order->total_price,
            'currency' => 'FCFA',
            'payment_method' => $order->payment_method ?? 'cash',
            'status' => Transaction::STATUS_PENDING,
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order)
    {
        // Création notification admin si livré (déjà existant)
        if ($order->isDirty('status') && $order->status === 'livré') {
            $admin = User::role('admin')->first();
            if ($admin) {
                $admin->notify(new OrderDeliveredByLivreur($order));
            }
        }
        // Si la commande passe à 'payé', mettre à jour la transaction associée
        if ($order->isDirty('status') && $order->status === Order::STATUS_PAID) {
            $transaction = $order->transactions()->latest()->first();
            if ($transaction && $transaction->isPending()) {
                $transaction->markAsCompleted();
            }
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderManagementController extends Controller
{
    /**
     * Afficher la page de gestion complète d'une commande
     */
    public function show(Order $order)
    {
        try {
            // Charger les relations avec vérification
            $order->load(['user', 'products', 'livreur', 'transactions']);
            
            // Récupérer tous les livreurs disponibles avec vérification
            $livreurs = collect();
            try {
                $livreurs = User::role('livreur')->where('active', true)->get();
            } catch (\Exception $e) {
                \Log::error("Erreur lors de la récupération des livreurs: " . $e->getMessage());
            }
            
            // Récupérer l'historique des statuts
            $statusHistory = $this->getStatusHistory($order);
            
            return view('admin.orders.manage', compact('order', 'livreurs', 'statusHistory'));
        } catch (\Exception $e) {
            \Log::error("Erreur dans OrderManagementController@show: " . $e->getMessage());
            return back()->with('error', 'Erreur lors du chargement de la commande: ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', \Illuminate\Validation\Rule::in(array_keys(\App\Models\Order::STATUSES))],
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;
        
        $order->update([
            'status' => $newStatus,
            'notes' => $request->notes ?? $order->notes,
        ]);

        // Log de la modification
        \Log::info("Statut de commande mis à jour", [
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'updated_by' => auth()->id(),
            'notes' => $request->notes,
        ]);

        // Envoyer des notifications selon le nouveau statut
        $this->sendStatusNotification($order, $oldStatus, $newStatus);

        return redirect()->back()->with('success', 'Statut de la commande mis à jour avec succès !');
    }

    /**
     * Assigner un livreur à une commande
     */
    public function assignLivreur(Request $request, Order $order)
    {
        $request->validate([
            'livreur_id' => 'required|exists:users,id',
        ]);

        $livreur = User::findOrFail($request->livreur_id);
        
        if (!$livreur->hasRole('livreur')) {
            return redirect()->back()->with('error', 'L\'utilisateur sélectionné n\'est pas un livreur.');
        }

        $oldLivreur = $order->livreur;
        $order->update(['livreur_id' => $livreur->id]);

        // Log de l'assignation
        \Log::info("Livreur assigné à la commande", [
            'order_id' => $order->id,
            'old_livreur' => $oldLivreur ? $oldLivreur->name : 'Aucun',
            'new_livreur' => $livreur->name,
            'assigned_by' => auth()->id(),
        ]);

        // Notifier le livreur
        try {
            Mail::to($livreur->email)->send(new \App\Mail\CommandAssignedToLivreur($order, $livreur));
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'envoi de la notification au livreur: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Livreur assigné avec succès !');
    }

    /**
     * Télécharger la facture PDF
     */
    public function downloadInvoice(Order $order)
    {
        $order->load(['user', 'products']);
        
        $pdf = PDF::loadView('admin.orders.invoice', compact('order'));
        
        $filename = 'facture_commande_' . $order->id . '_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Obtenir l'historique des statuts
     */
    private function getStatusHistory(Order $order)
    {
        // Pour l'instant, on retourne un historique basique
        // Dans une vraie application, vous auriez une table pour stocker l'historique
        return [
            [
                'status' => $order->status,
                'date' => $order->updated_at,
                'user' => auth()->user(),
                'notes' => $order->notes,
            ]
        ];
    }

    /**
     * Envoyer des notifications selon le statut
     */
    private function sendStatusNotification(Order $order, $oldStatus, $newStatus)
    {
        try {
            switch ($newStatus) {
                case 'payé':
                    // Notifier le vendeur
                    if ($order->user) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    break;
                    
                case 'en préparation':
                    // Notifier le client
                    if ($order->user) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    break;
                    
                case 'expédié':
                    // Notifier le client et le livreur
                    if ($order->user) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    if ($order->livreur) {
                        Mail::to($order->livreur->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    break;
                    
                case 'livré':
                    // Notifier le client et l'admin
                    if ($order->user) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    break;
                    
                case 'annulé':
                    // Notifier le client et rembourser si nécessaire
                    if ($order->user) {
                        Mail::to($order->user->email)->send(new \App\Mail\OrderStatusUpdateMail($order, $newStatus));
                    }
                    break;
            }
        } catch (\Exception $e) {
            \Log::error("Erreur lors de l'envoi de la notification de statut: " . $e->getMessage());
        }
    }
}

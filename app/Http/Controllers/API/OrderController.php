<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Créer une nouvelle commande
     */
    public function create(Request $request)
    {
        // Récupérer les options de livraison disponibles
        $deliveryOptions = $this->deliveryService->getAvailableOptions();
        $zones = $this->deliveryService->getZones();

        // Valider la requête
        $request->validate([
            'delivery_option_id' => 'required|exists:delivery_options,id',
            'zone' => 'required_if:delivery_option_id,!=,1|string|in:zone1,zone2,zone3',
            // ... autres validations possibles
        ]);

        // Calculer le coût de livraison
        $deliveryCost = 0;
        if ($request->delivery_option_id != 1) { // Si ce n'est pas le retrait en magasin
            $deliveryCost = $this->deliveryService->getDeliveryCost($request->zone);
        }

        // Créer la commande
        $order = Order::create([
            'user_id' => Auth::id(),
            'delivery_option_id' => $request->delivery_option_id,
            'delivery_cost' => $deliveryCost,
            'zone' => $request->zone,
            // ... autres champs de la commande
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Commande créée avec succès',
            'data' => [
                'order' => $order,
                'delivery_cost' => $deliveryCost
            ]
        ]);
    }

    /**
     * Récupérer les options de livraison disponibles
     */
    public function getDeliveryOptions()
    {
        $options = $this->deliveryService->getAvailableOptions();
        $zones = $this->deliveryService->getZones();

        return response()->json([
            'status' => 'success',
            'data' => [
                'options' => $options,
                'zones' => $zones
            ]
        ]);
    }

    /**
     * Récupérer les commandes de l'utilisateur authentifié
     */
    public function index(Request $request)
    {
        try {
            $orders = Order::where('user_id', Auth::id())
                ->with(['products']) // Charger les produits associés
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $orders,
                'message' => 'Commandes récupérées avec succès.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des commandes : ' . $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class LivreurController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $orders = Order::where('livreur_id', $userId)->get();
        $todayOrders = Order::where('livreur_id', $userId)->whereDate('created_at', today())->get();
        $pendingOrders = Order::where('livreur_id', $userId)->where('status', 'en attente')->get();
        $deliveredOrders = Order::where('livreur_id', $userId)->where('status', 'livrée')->get();

        // Comptage des statuts pour le graphique
        $statusCounts = [
            'En attente' => $pendingOrders->count(),
            'Livrée' => $deliveredOrders->count(),
        ];
        // Ajoute d'autres statuts si besoin, ex : 'Annulée' => ...

        return view('livreurs.orders.index', compact('orders', 'todayOrders', 'pendingOrders', 'deliveredOrders', 'statusCounts'));
    }

    public function markAsDelivered(Request $request, Order $order)
    {
        if (!auth()->user()->hasRole('livreur') || $order->livreur_id !== auth()->id()) {
            abort(403, 'Accès refusé. Vous ne pouvez modifier que vos propres commandes.');
        }

        if (!$order) {
            abort(404, 'Commande non trouvée.');
        }

        $order->status = 'livrée';
        $order->delivered_at = now();
        $order->save();

        return redirect()->route('livreur.orders')->with('success', 'Commande marquée comme livrée.');
    }

    public function viewRoute(Order $order)
    {
        if (!auth()->user()->hasRole('livreur') || $order->livreur_id !== auth()->id()) {
            abort(403, 'Accès non autorisé à cet itinéraire.');
        }

        if (!$order || !$order->latitude || !$order->longitude) {
            abort(404, 'Itinéraire non disponible pour cette commande.');
        }

        return view('livreurs.orders.route', compact('order'));
    }
   public function planning()
{
    $userId = auth()->id();
    $today = now()->toDateString();

    // Livraisons du jour
    $todayDeliveries = \App\Models\Order::where('livreur_id', $userId)
        ->whereDate('created_at', $today)
        ->get();

    // Livraisons à venir (prochaines 7 jours)
    $upcomingDeliveries = \App\Models\Order::where('livreur_id', $userId)
        ->whereDate('created_at', '>=', $today)
        ->orderBy('created_at')
        ->get();

    return view('livreurs.planning', compact('todayDeliveries', 'upcomingDeliveries'));
}

    public function profile()
    {
        return view('livreurs.profile');
    }

    // Calcul de distance Haversine (en km)
    public static function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat/2) * sin($dLat/2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return round($earthRadius * $c, 2);
    }

    // Nouvelle méthode : mise à jour de la position du livreur et retour des livraisons du jour avec distance dynamique
    public function updateLocation(Request $request)
    {
        $user = auth()->user();
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->save();

        $today = now()->toDateString();
        $todayDeliveries = \App\Models\Order::where('livreur_id', $user->id)
            ->whereDate('created_at', $today)
            ->get();

        // Ajout de la distance dynamique à chaque commande
        foreach ($todayDeliveries as $order) {
            if ($order->latitude && $order->longitude && $user->latitude && $user->longitude) {
                $order->distance_km = self::haversine($user->latitude, $user->longitude, $order->latitude, $order->longitude);
            } else {
                $order->distance_km = null;
            }
        }

        return response()->json([
            'success' => true,
            'todayDeliveries' => $todayDeliveries
        ]);
    }

    public function fetchDeliveries(Request $request)
    {
        $user = auth()->user();
        $type = $request->input('type', 'day'); // 'day', 'month', 'year'
        $date = $request->input('date', now()->toDateString());

        $query = \App\Models\Order::where('livreur_id', $user->id);

        if ($type === 'day') {
            $query->whereDate('created_at', $date);
        } elseif ($type === 'month') {
            $query->whereMonth('created_at', date('m', strtotime($date)))
                  ->whereYear('created_at', date('Y', strtotime($date)));
        } elseif ($type === 'year') {
            $query->whereYear('created_at', date('Y', strtotime($date)));
        }

        $deliveries = $query->get();

        foreach ($deliveries as $order) {
            if ($order->latitude && $order->longitude && $user->latitude && $user->longitude) {
                $order->distance_km = self::haversine($user->latitude, $user->longitude, $order->latitude, $order->longitude);
            } else {
                $order->distance_km = null;
            }
        }

        return response()->json([
            'success' => true,
            'deliveries' => $deliveries
        ]);
    }
}
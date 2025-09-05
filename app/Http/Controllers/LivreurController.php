<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LivreurController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $orders = Order::where('livreur_id', $userId)->get();
        $todayOrders = Order::where('livreur_id', $userId)->whereDate('created_at', today())->get();
        $pendingOrders = Order::where('livreur_id', $userId)->where('status', 'en attente')->get();
        $deliveredOrders = Order::where('livreur_id', $userId)->where('status', 'livré')->get();

        // Calcul de la distance totale parcourue
        $totalDistance = 0;
        foreach ($deliveredOrders as $order) {
            if ($order->latitude && $order->longitude) {
                // Distance depuis Dakar (centre) - à adapter selon la logique métier
                $totalDistance += self::haversine(14.6928, -17.4467, $order->latitude, $order->longitude);
            }
        }

        // Comptage des statuts pour le graphique
        $statusCounts = [
            'En attente' => $pendingOrders->count(),
            'Livré' => $deliveredOrders->count(),
        ];

        return view('livreurs.orders.index', compact('orders', 'todayOrders', 'pendingOrders', 'deliveredOrders', 'statusCounts', 'totalDistance'));
    }

    public function markAsDelivered(Request $request, Order $order)
    {
        if (!auth()->user()->hasRole('livreur') || $order->livreur_id !== auth()->id()) {
            abort(403, 'Accès refusé. Vous ne pouvez modifier que vos propres commandes.');
        }

        if (!$order) {
            abort(404, 'Commande non trouvée.');
        }

        $order->status = 'livré';
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

    public function show(Order $order)
    {
        // Vérifier que la commande appartient au livreur connecté
        if ($order->livreur_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('livreurs.orders.show', compact('order'));
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
        $user = auth()->user();
        return view('livreurs.profile', compact('user'));
    }

    public function settings()
    {
        return view('livreurs.settings');
    }

    public function statistics()
    {
        $userId = auth()->id();
        
        // Statistiques de base
        $totalDeliveries = Order::where('livreur_id', $userId)->where('status', 'livré')->count();
        $onTimeDeliveries = Order::where('livreur_id', $userId)
            ->where('status', 'livré')
            ->where('delivered_at', '<=', \DB::raw('created_at + INTERVAL \'1 hour\''))
            ->count();
        
        $onTimeRate = $totalDeliveries > 0 ? round(($onTimeDeliveries / $totalDeliveries) * 100, 1) : 0;
        
        // Statistiques par mois (derniers 6 mois)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $date->format('M Y'),
                'deliveries' => Order::where('livreur_id', $userId)
                    ->where('status', 'livré')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count()
            ];
        }
        
        return view('livreurs.statistics', compact('totalDeliveries', 'onTimeRate', 'monthlyStats'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'vehicle_type' => 'nullable|string|max:100',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->vehicle_type = $request->vehicle_type;

        // Mise à jour du mot de passe si fourni
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('livreur.profile')->with('success', 'Profil mis à jour avec succès.');
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
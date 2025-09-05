<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExchangeInfoController extends Controller
{
    /**
     * Affiche la page d'information sur le système d'échange
     */
    public function index()
    {
        // Récupérer quelques statistiques pour rendre la page plus attractive
        $stats = Cache::remember('exchange.stats', 3600, function () {
            return [
                'total_exchanges' => 1250, // Vous pouvez remplacer par des vraies données
                'satisfied_customers' => 98, // Pourcentage de satisfaction
                'average_savings' => 35, // Pourcentage d'économies moyennes
                'processing_time' => 24, // Heures de traitement moyen
            ];
        });

        // Récupérer les catégories d'appareils échangeables
        $exchangeableCategories = Cache::remember('exchange.categories', 3600, function () {
            return Category::whereIn('name', [
                'Smartphones',
                'Ordinateurs',
                'Ordinateurs portables', 
                'Tablettes',
                'Gaming',
                'Consoles de jeu',
                'Audio',
                'Écouteurs',
                'Appareils photo',
                'Montres connectées'
            ])->withCount('products')->get();
        });

        // Quelques exemples de produits populaires pour l'échange
        $popularExchangeProducts = Cache::remember('exchange.popular', 1800, function () {
            return Product::whereHas('category', function($query) {
                $query->whereIn('name', ['Smartphones', 'Ordinateurs portables', 'Gaming']);
            })
            ->inRandomOrder()
            ->take(6)
            ->get();
        });

        return view('exchange.info', compact('stats', 'exchangeableCategories', 'popularExchangeProducts'));
    }

    /**
     * Redirige vers le système d'échange en ligne
     */
    public function startExchange()
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('info', 'Vous devez vous connecter pour procéder à un échange.');
        }

        // Rediriger vers la page d'échange (si elle existe)
        try {
            return redirect()->route('trades.search')
                ->with('success', 'Commencez votre échange dès maintenant !');
        } catch (\Exception $e) {
            // Si la route n'existe pas, rediriger vers les produits avec un message
            return redirect()->route('products.index')
                ->with('info', 'Sélectionnez les produits que vous souhaitez échanger.');
        }
    }
}
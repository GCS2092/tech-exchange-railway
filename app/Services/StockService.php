<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\TradeOffer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    /**
     * Diminue le stock d'un produit lors d'une vente
     */
    public function decreaseStock(Product $product, int $quantity = 1): bool
    {
        try {
            DB::beginTransaction();
            
            // Vérifier si le stock est suffisant
            if ($product->quantity < $quantity) {
                Log::warning("Stock insuffisant pour le produit {$product->id}: {$product->quantity} disponible, {$quantity} demandé");
                DB::rollBack();
                return false;
            }
            
            // Diminuer le stock
            $product->quantity -= $quantity;
            $product->save();
            
            Log::info("Stock diminué pour le produit {$product->id}: -{$quantity} (nouveau stock: {$product->quantity})");
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la diminution du stock pour le produit {$product->id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Augmente le stock d'un produit (retour, annulation, etc.)
     */
    public function increaseStock(Product $product, int $quantity = 1): bool
    {
        try {
            DB::beginTransaction();
            
            // Augmenter le stock
            $product->quantity += $quantity;
            $product->save();
            
            Log::info("Stock augmenté pour le produit {$product->id}: +{$quantity} (nouveau stock: {$product->quantity})");
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de l'augmentation du stock pour le produit {$product->id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Gère le stock lors d'un échange (troc)
     */
    public function handleTradeStock(TradeOffer $tradeOffer): bool
    {
        try {
            DB::beginTransaction();
            
            $product = $tradeOffer->product;
            
            // Pour un échange, on peut soit augmenter le stock (si l'échange est accepté)
            // soit le laisser tel quel (si l'échange est refusé)
            if ($tradeOffer->status === 'accepted') {
                // L'échange est accepté, le produit rejoint le stock
                $this->increaseStock($product, 1);
                Log::info("Échange accepté: produit {$product->id} ajouté au stock");
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la gestion du stock pour l'échange {$tradeOffer->id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Gère le stock lors d'une commande
     */
    public function handleOrderStock(Order $order): bool
    {
        try {
            DB::beginTransaction();
            
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity ?? 1;
                
                if (!$this->decreaseStock($product, $quantity)) {
                    DB::rollBack();
                    return false;
                }
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la gestion du stock pour la commande {$order->id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Restaure le stock lors d'une annulation de commande
     */
    public function restoreOrderStock(Order $order): bool
    {
        try {
            DB::beginTransaction();
            
            foreach ($order->products as $product) {
                $quantity = $product->pivot->quantity ?? 1;
                $this->increaseStock($product, $quantity);
            }
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la restauration du stock pour la commande {$order->id}: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Vérifie si un produit est en stock
     */
    public function isInStock(Product $product, int $quantity = 1): bool
    {
        return $product->quantity >= $quantity;
    }
    
    /**
     * Obtient les statistiques de stock
     */
    public function getStockStatistics(): array
    {
        return [
            'total_products' => Product::count(),
            'in_stock' => Product::where('quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('quantity', 0)->count(),
            'low_stock' => Product::where('quantity', '<=', 5)->where('quantity', '>', 0)->count(),
            'total_value' => Product::sum(DB::raw('price * quantity')),
            'average_stock' => Product::avg('quantity'),
            'products_by_stock_level' => [
                'critical' => Product::where('quantity', '<=', 2)->count(),
                'low' => Product::whereBetween('quantity', [3, 10])->count(),
                'normal' => Product::whereBetween('quantity', [11, 50])->count(),
                'high' => Product::where('quantity', '>', 50)->count(),
            ]
        ];
    }
    
    /**
     * Obtient les produits avec stock faible
     */
    public function getLowStockProducts(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Product::where('quantity', '<=', 5)
            ->where('quantity', '>', 0)
            ->orderBy('quantity', 'asc')
            ->limit($limit)
            ->get();
    }
    
    /**
     * Obtient les produits en rupture de stock
     */
    public function getOutOfStockProducts(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Product::where('quantity', 0)
            ->orderBy('name', 'asc')
            ->limit($limit)
            ->get();
    }
}

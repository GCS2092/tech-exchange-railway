<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TradeOffer;
use App\Notifications\TradeOfferNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    /**
     * Afficher la page de troc pour un produit
     */
    public function showTradePage(Product $product)
    {
        // Vérifier que le produit est éligible au troc
        if (!$product->isTradeEligible()) {
            return redirect()->back()->with('error', 'Ce produit n\'est pas éligible au troc.');
        }

        // Variables pour les utilisateurs connectés
        $userProducts = collect();
        $existingOffers = collect();

        // Si l'utilisateur est connecté, récupérer ses données
        if (Auth::check()) {
            // Récupérer les produits éligibles au troc de l'utilisateur
            $userProducts = Product::where('seller_id', Auth::id())
                ->tradeEligible()
                ->where('id', '!=', $product->id)
                ->get();

            // Récupérer les offres existantes pour ce produit
            $existingOffers = TradeOffer::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->with(['offeredProduct'])
                ->get();
        }

        return view('trades.show', compact('product', 'userProducts', 'existingOffers'));
    }

    /**
     * Créer une nouvelle offre de troc
     */
    public function createOffer(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'offer_type' => 'required|in:existing_product,custom_device',
            'offered_product_id' => 'nullable|exists:products,id',
            'message' => 'nullable|string|max:500',
            'additional_cash_amount' => 'nullable|numeric|min:0',
            
            // Validation pour appareil personnalisé
            'custom_device_name' => 'required_if:offer_type,custom_device|string|max:255',
            'custom_device_brand' => 'required_if:offer_type,custom_device|string|max:255',
            'custom_device_model' => 'required_if:offer_type,custom_device|string|max:255',
            'custom_device_type' => 'required_if:offer_type,custom_device|string|max:255',
            'custom_device_description' => 'nullable|string|max:1000',
            'custom_device_condition' => 'required_if:offer_type,custom_device|string|max:255',
            'custom_device_year' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
            'custom_device_ram' => 'nullable|string|max:255',
            'custom_device_storage' => 'nullable|string|max:255',
            'custom_device_screen_size' => 'nullable|string|max:255',
            'custom_device_os' => 'nullable|string|max:255',
            'custom_device_color' => 'nullable|string|max:255',
            'custom_device_processor' => 'nullable|string|max:255',
            'custom_device_gpu' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Vérifier le type d'offre
        if ($request->offer_type === 'existing_product') {
            // Vérifier que le produit offert appartient à l'utilisateur
            $offeredProduct = Product::find($request->offered_product_id);
            if (!$offeredProduct || $offeredProduct->seller_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Vous ne pouvez échanger que vos propres produits.');
            }

            // Vérifier que le produit offert est éligible au troc
            if (!$offeredProduct->isTradeEligible()) {
                return redirect()->back()->with('error', 'Le produit offert n\'est pas éligible au troc.');
            }

            // Vérifier qu'il n'y a pas déjà une offre en cours
            $existingOffer = TradeOffer::where('product_id', $product->id)
                ->where('offered_product_id', $offeredProduct->id)
                ->where('user_id', Auth::id())
                ->whereIn('status', ['pending', 'accepted'])
                ->first();

            if ($existingOffer) {
                return redirect()->back()->with('error', 'Vous avez déjà une offre en cours pour cet échange.');
            }
        }

        // Préparer les données de l'offre
        $offerData = [
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'message' => $request->message,
            'status' => 'pending',
            'offer_type' => $request->offer_type,
            'additional_cash_amount' => $request->additional_cash_amount ?? 0,
        ];

        // Ajouter les données selon le type d'offre
        if ($request->offer_type === 'existing_product') {
            $offerData['offered_product_id'] = $request->offered_product_id;
        } else {
            // Appareil personnalisé
            $offerData = array_merge($offerData, [
                'custom_device_name' => $request->custom_device_name,
                'custom_device_brand' => $request->custom_device_brand,
                'custom_device_model' => $request->custom_device_model,
                'custom_device_type' => $request->custom_device_type,
                'custom_device_description' => $request->custom_device_description,
                'custom_device_condition' => $request->custom_device_condition,
                'custom_device_year' => $request->custom_device_year,
                'custom_device_ram' => $request->custom_device_ram,
                'custom_device_storage' => $request->custom_device_storage,
                'custom_device_screen_size' => $request->custom_device_screen_size,
                'custom_device_os' => $request->custom_device_os,
                'custom_device_color' => $request->custom_device_color,
                'custom_device_processor' => $request->custom_device_processor,
                'custom_device_gpu' => $request->custom_device_gpu,
            ]);
        }

        // Créer l'offre
        $tradeOffer = TradeOffer::create($offerData);

        // Envoyer une notification au propriétaire du produit
        $product->seller->notify(new TradeOfferNotification($tradeOffer, 'new_offer'));

        $successMessage = 'Votre offre de troc a été envoyée avec succès.';
        if ($request->additional_cash_amount > 0) {
            $successMessage .= ' Montant supplémentaire : ' . \App\Helpers\CurrencyHelper::formatXOF($request->additional_cash_amount);
        }

        return redirect()->back()->with('success', $successMessage);
    }

    /**
     * Afficher les offres reçues par l'utilisateur
     */
    public function myOffers()
    {
        $receivedOffers = TradeOffer::whereHas('product', function ($query) {
            $query->where('seller_id', Auth::id());
        })
        ->with(['product', 'offeredProduct', 'user'])
        ->orderBy('created_at', 'desc')
        ->get();

        $sentOffers = TradeOffer::where('user_id', Auth::id())
            ->with(['product', 'offeredProduct'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('trades.my-offers', compact('receivedOffers', 'sentOffers'));
    }

    /**
     * Accepter une offre de troc
     */
    public function acceptOffer(TradeOffer $offer)
    {
        // Vérifier que l'utilisateur est le propriétaire du produit
        if ($offer->product->seller_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accepter cette offre.');
        }

        // Vérifier que l'offre est en attente
        if (!$offer->isPending()) {
            return redirect()->back()->with('error', 'Cette offre ne peut plus être acceptée.');
        }

        $offer->accept();

        // Envoyer une notification à l'auteur de l'offre
        $offer->user->notify(new TradeOfferNotification($offer, 'offer_accepted'));

        return redirect()->back()->with('success', 'Offre acceptée ! Vous pouvez maintenant organiser l\'échange.');
    }

    /**
     * Rejeter une offre de troc
     */
    public function rejectOffer(TradeOffer $offer)
    {
        // Vérifier que l'utilisateur est le propriétaire du produit
        if ($offer->product->seller_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à rejeter cette offre.');
        }

        $offer->reject();

        // Envoyer une notification à l'auteur de l'offre
        $offer->user->notify(new TradeOfferNotification($offer, 'offer_rejected'));

        return redirect()->back()->with('success', 'Offre rejetée.');
    }

    /**
     * Annuler une offre de troc
     */
    public function cancelOffer(TradeOffer $offer)
    {
        // Vérifier que l'utilisateur est l'auteur de l'offre
        if ($offer->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à annuler cette offre.');
        }

        $offer->cancel();

        // Envoyer une notification au propriétaire du produit
        $offer->product->seller->notify(new TradeOfferNotification($offer, 'offer_cancelled'));

        return redirect()->back()->with('success', 'Offre annulée.');
    }

    /**
     * Afficher la page de recherche de produits pour troc
     */
    public function searchTradeProducts(Request $request)
    {
        $query = Product::tradeEligible()->with(['seller', 'category']);

        // Filtres
        if ($request->filled('device_type')) {
            $query->byDeviceType($request->device_type);
        }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('condition')) {
            $query->byCondition($request->condition);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('model', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->paginate(12);

        // Récupérer les filtres disponibles
        $deviceTypes = Product::tradeEligible()->distinct()->pluck('device_type')->filter();
        $brands = Product::tradeEligible()->distinct()->pluck('brand')->filter();
        $conditions = Product::tradeEligible()->distinct()->pluck('condition')->filter();

        return view('trades.search', compact('products', 'deviceTypes', 'brands', 'conditions'));
    }
} 
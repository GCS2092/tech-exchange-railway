@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-xl font-bold text-gray-900 mb-2">Échange d'appareil</h1>
            <p class="text-gray-600">Proposez un échange pour cet appareil électronique</p>
        </div>

        <!-- Produit à échanger -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center space-x-6">
                <div class="flex-shrink-0">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                         class="w-24 h-24 object-cover rounded-xl">
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                        <div>
                            <span class="text-gray-500">Marque:</span>
                            <span class="font-medium">{{ $product->brand ?? 'Non spécifiée' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Modèle:</span>
                            <span class="font-medium">{{ $product->model ?? 'Non spécifié' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">État:</span>
                            <span class="font-medium">{{ $product->formatted_condition }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Valeur d'échange:</span>
                            <span class="font-medium text-blue-600">{{ $product->formatted_trade_value }}</span>
                        </div>
                    </div>
                    
                    <!-- Détails spécifiques selon le type d'appareil -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-900 mb-3">Spécifications techniques :</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                            @if($product->device_type === 'smartphone')
                                <div>
                                    <span class="text-gray-500">RAM:</span>
                                    <span class="font-medium">{{ $product->ram ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Stockage:</span>
                                    <span class="font-medium">{{ $product->storage ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Taille écran:</span>
                                    <span class="font-medium">{{ $product->screen_size ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Système:</span>
                                    <span class="font-medium">{{ $product->os ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Couleur:</span>
                                    <span class="font-medium">{{ $product->color ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Année:</span>
                                    <span class="font-medium">{{ $product->year ?? 'Non spécifiée' }}</span>
                                </div>
                            @elseif($product->device_type === 'laptop')
                                <div>
                                    <span class="text-gray-500">Processeur:</span>
                                    <span class="font-medium">{{ $product->processor ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">RAM:</span>
                                    <span class="font-medium">{{ $product->ram ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Stockage:</span>
                                    <span class="font-medium">{{ $product->storage ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Taille écran:</span>
                                    <span class="font-medium">{{ $product->screen_size ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Système:</span>
                                    <span class="font-medium">{{ $product->os ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Carte graphique:</span>
                                    <span class="font-medium">{{ $product->gpu ?? 'Non spécifiée' }}</span>
                                </div>
                            @elseif($product->device_type === 'tablet')
                                <div>
                                    <span class="text-gray-500">Stockage:</span>
                                    <span class="font-medium">{{ $product->storage ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Taille écran:</span>
                                    <span class="font-medium">{{ $product->screen_size ?? 'Non spécifiée' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Système:</span>
                                    <span class="font-medium">{{ $product->os ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Couleur:</span>
                                    <span class="font-medium">{{ $product->color ?? 'Non spécifiée' }}</span>
                                </div>
                            @else
                                <div>
                                    <span class="text-gray-500">Type:</span>
                                    <span class="font-medium">{{ $product->device_type ?? 'Non spécifié' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Description:</span>
                                    <span class="font-medium">{{ Str::limit($product->description, 50) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @auth
            <!-- Vos appareils disponibles pour l'échange -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Vos appareils disponibles pour l'échange</h3>
                
                @if($userProducts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($userProducts as $userProduct)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="{{ asset('storage/' . $userProduct->image) }}" 
                                     alt="{{ $userProduct->name }}" 
                                     class="w-16 h-16 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $userProduct->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $userProduct->brand }} - {{ $userProduct->model }}</p>
                                    <p class="text-sm text-gray-500">{{ $userProduct->formatted_condition }}</p>
                                </div>
                            </div>
                            
                            <form action="{{ route('trades.create-offer', $product) }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="offer_type" value="existing_product">
                                <input type="hidden" name="offered_product_id" value="{{ $userProduct->id }}">
                                
                                <div>
                                    <label for="additional_cash_{{ $userProduct->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Montant d'argent supplémentaire (FCFA)
                                    </label>
                                    <input type="number" name="additional_cash_amount" id="additional_cash_{{ $userProduct->id }}" min="0" step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Ex: 50000 (optionnel)">
                                </div>
                                
                                <div>
                                    <label for="message_{{ $userProduct->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Message (optionnel)
                                    </label>
                                    <textarea name="message" id="message_{{ $userProduct->id }}" rows="2" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Décrivez pourquoi cet échange vous intéresse..."></textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                                    Proposer cet échange
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Aucun appareil disponible</h4>
                    <p class="text-gray-600 mb-4">Vous n'avez pas encore d'appareils éligibles au troc.</p>
                    <a href="{{ route('products.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Ajouter un appareil
                    </a>
                </div>
            @endif
            
            <!-- Section pour proposer un appareil personnalisé -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Proposer un appareil personnalisé</h3>
                <p class="text-gray-600 mb-4">Vous n'avez pas l'appareil dans votre inventaire ? Proposez un appareil personnalisé avec un montant d'argent supplémentaire.</p>
                
                <form action="{{ route('trades.create-offer', $product) }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="offer_type" value="custom_device">
                    
                    <!-- Informations de base de l'appareil -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="custom_device_name" class="block text-sm font-medium text-gray-700 mb-1">Nom de l'appareil *</label>
                            <input type="text" name="custom_device_name" id="custom_device_name" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: iPhone 13 Pro">
                        </div>
                        
                        <div>
                            <label for="custom_device_brand" class="block text-sm font-medium text-gray-700 mb-1">Marque *</label>
                            <input type="text" name="custom_device_brand" id="custom_device_brand" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: Apple">
                        </div>
                        
                        <div>
                            <label for="custom_device_model" class="block text-sm font-medium text-gray-700 mb-1">Modèle *</label>
                            <input type="text" name="custom_device_model" id="custom_device_model" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: iPhone 13 Pro">
                        </div>
                        
                        <div>
                            <label for="custom_device_type" class="block text-sm font-medium text-gray-700 mb-1">Type d'appareil *</label>
                            <select name="custom_device_type" id="custom_device_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner un type</option>
                                <option value="smartphone">Smartphone</option>
                                <option value="tablet">Tablette</option>
                                <option value="laptop">Ordinateur portable</option>
                                <option value="desktop">Ordinateur de bureau</option>
                                <option value="smartwatch">Montre connectée</option>
                                <option value="headphones">Écouteurs</option>
                                <option value="console">Console de jeu</option>
                                <option value="camera">Appareil photo</option>
                                <option value="other">Autre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="custom_device_condition" class="block text-sm font-medium text-gray-700 mb-1">État *</label>
                            <select name="custom_device_condition" id="custom_device_condition" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner un état</option>
                                <option value="excellent">Excellent</option>
                                <option value="very_good">Très bon</option>
                                <option value="good">Bon</option>
                                <option value="acceptable">Acceptable</option>
                                <option value="fair">Passable</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="custom_device_year" class="block text-sm font-medium text-gray-700 mb-1">Année de fabrication</label>
                            <input type="number" name="custom_device_year" id="custom_device_year" min="1990" max="{{ date('Y') + 1 }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Ex: 2023">
                        </div>
                    </div>
                    
                    <!-- Spécifications techniques -->
                    <div>
                        <h4 class="text-lg font-medium text-gray-900 mb-3">Spécifications techniques (optionnel)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label for="custom_device_ram" class="block text-sm font-medium text-gray-700 mb-1">RAM</label>
                                <input type="text" name="custom_device_ram" id="custom_device_ram"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: 8GB">
                            </div>
                            
                            <div>
                                <label for="custom_device_storage" class="block text-sm font-medium text-gray-700 mb-1">Stockage</label>
                                <input type="text" name="custom_device_storage" id="custom_device_storage"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: 256GB">
                            </div>
                            
                            <div>
                                <label for="custom_device_screen_size" class="block text-sm font-medium text-gray-700 mb-1">Taille écran</label>
                                <input type="text" name="custom_device_screen_size" id="custom_device_screen_size"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: 6.1 pouces">
                            </div>
                            
                            <div>
                                <label for="custom_device_os" class="block text-sm font-medium text-gray-700 mb-1">Système d'exploitation</label>
                                <input type="text" name="custom_device_os" id="custom_device_os"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: iOS 17">
                            </div>
                            
                            <div>
                                <label for="custom_device_color" class="block text-sm font-medium text-gray-700 mb-1">Couleur</label>
                                <input type="text" name="custom_device_color" id="custom_device_color"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: Bleu">
                            </div>
                            
                            <div>
                                <label for="custom_device_processor" class="block text-sm font-medium text-gray-700 mb-1">Processeur</label>
                                <input type="text" name="custom_device_processor" id="custom_device_processor"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: A15 Bionic">
                            </div>
                            
                            <div>
                                <label for="custom_device_gpu" class="block text-sm font-medium text-gray-700 mb-1">Carte graphique</label>
                                <input type="text" name="custom_device_gpu" id="custom_device_gpu"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Ex: RTX 3060">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="custom_device_description" class="block text-sm font-medium text-gray-700 mb-1">Description détaillée</label>
                        <textarea name="custom_device_description" id="custom_device_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Décrivez votre appareil en détail..."></textarea>
                    </div>
                    
                    <!-- Montant d'argent supplémentaire -->
                    <div>
                        <label for="additional_cash_amount" class="block text-sm font-medium text-gray-700 mb-1">Montant d'argent supplémentaire (FCFA)</label>
                        <input type="number" name="additional_cash_amount" id="additional_cash_amount" min="0" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ex: 50000">
                        <p class="text-sm text-gray-500 mt-1">Laissez vide si vous n'ajoutez pas d'argent</p>
                    </div>
                    
                    <!-- Message -->
                    <div>
                        <label for="custom_message" class="block text-sm font-medium text-gray-700 mb-1">Message (optionnel)</label>
                        <textarea name="message" id="custom_message" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Décrivez pourquoi cet échange vous intéresse..."></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white font-medium py-3 px-6 rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-200">
                        Proposer cet appareil personnalisé
                    </button>
                </form>
            </div>
        </div>
        @endauth
        
        @guest
            <!-- Section pour utilisateurs non connectés -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-medium text-gray-900 mb-2">Connectez-vous pour proposer un échange</h4>
                    <p class="text-gray-600 mb-6">Vous devez être connecté pour proposer un échange pour cet appareil.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-blue-600 font-medium rounded-lg hover:bg-blue-50 transition-all duration-200">
                            Créer un compte
                        </a>
                    </div>
                </div>
            </div>
        @endguest

        @auth
            <!-- Vos offres existantes -->
            @if($existingOffers->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Vos offres existantes</h3>
                <div class="space-y-4">
                    @foreach($existingOffers as $offer)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    @if($offer->hasCustomDevice())
                                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $offer->custom_device_display_name }}</h4>
                                            <p class="text-sm text-gray-600">{{ ucfirst($offer->custom_device_condition) }}</p>
                                            <p class="text-xs text-purple-600">Appareil personnalisé</p>
                                        </div>
                                    @else
                                        <img src="{{ asset('storage/' . $offer->offeredProduct->image) }}" 
                                             alt="{{ $offer->offeredProduct->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $offer->offeredProduct->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $offer->offeredProduct->formatted_condition }}</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    @if($offer->hasAdditionalCash())
                                        <div class="mb-2">
                                            <span class="text-xs text-green-600 font-medium">+ {{ $offer->formatted_additional_cash }}</span>
                                        </div>
                                    @endif
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                 {{ $offer->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($offer->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                                    'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($offer->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @endauth
    </div>
</div>
@endsection 
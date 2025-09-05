@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de la page avec design moderne -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="text-4xl">🎫</span>
                    Créer un Code Promo
                </h1>
                <p class="mt-2 text-gray-600">Ajouter un nouveau code de réduction pour votre boutique</p>
            </div>
            <div>
                <a href="{{ route('admin.promos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <!-- Alertes avec design moderne -->
        @if($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-gray-400 rounded-r-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-gray-800 mb-2">Veuillez corriger les erreurs suivantes :</h3>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulaire principal -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informations du Code Promo</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.promos.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Code et Type de réduction -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Code Promo *
                                    </label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <input type="text" 
                                               class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('code') border-red-300 focus:ring-gray-500 @enderror" 
                                               id="code" 
                                               name="code" 
                                               value="{{ old('code') }}" 
                                               placeholder="Ex: SAVE20" 
                                               required 
                                               maxlength="50">
                                        <button type="button" 
                                                class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-lg bg-gray-50 text-gray-700 hover:bg-gray-100 transition-colors duration-200" 
                                                id="generateCode">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 011 1v4a1 1 0 01-1 1h-2v4a1 1 0 01-1 1H8a1 1 0 01-1-1v-4H5a1 1 0 01-1-1V5a1 1 0 011-1h2z"></path>
                                            </svg>
                                            Générer
                                        </button>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Le code sera automatiquement converti en majuscules</p>
                                    @error('code')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Type de Réduction *
                                    </label>
                                    <select class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('discount_type') border-red-300 focus:ring-gray-500 @enderror" 
                                            id="discount_type" 
                                            name="discount_type" 
                                            required>
                                        <option value="">Choisir le type</option>
                                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Montant fixe (FCFA)</option>
                                    </select>
                                    @error('discount_type')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Valeur de réduction et Montant minimum -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">
                                        Valeur de la Réduction *
                                    </label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <input type="number" 
                                               class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('discount_value') border-red-300 focus:ring-gray-500 @enderror" 
                                               id="discount_value" 
                                               name="discount_value" 
                                               value="{{ old('discount_value') }}" 
                                               step="0.01" 
                                               min="0" 
                                               required>
                                        <span class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg" 
                                              id="discount_unit">%</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500" id="discount_help">Pourcentage maximum : 100%</p>
                                    @error('discount_value')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="min_order_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Montant Minimum de Commande
                                    </label>
                                    <div class="flex rounded-lg shadow-sm">
                                        <input type="number" 
                                               class="flex-1 block w-full px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('min_order_amount') border-red-300 focus:ring-gray-500 @enderror" 
                                               id="min_order_amount" 
                                               name="min_order_amount" 
                                               value="{{ old('min_order_amount') }}" 
                                               step="100" 
                                               min="0">
                                        <span class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 bg-gray-50 text-gray-500 rounded-r-lg">FCFA</span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour aucun minimum</p>
                                    @error('min_order_amount')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Usage maximum et Date d'expiration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="max_usage" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nombre Maximum d'Utilisations
                                    </label>
                                    <input type="number" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('max_usage') border-red-300 focus:ring-gray-500 @enderror" 
                                           id="max_usage" 
                                           name="max_usage" 
                                           value="{{ old('max_usage') }}" 
                                           min="1" 
                                           placeholder="Illimité">
                                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour un usage illimité</p>
                                    @error('max_usage')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                                        Date d'Expiration *
                                    </label>
                                    <input type="datetime-local" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('expires_at') border-red-300 focus:ring-gray-500 @enderror" 
                                           id="expires_at" 
                                           name="expires_at" 
                                           value="{{ old('expires_at') }}" 
                                           required>
                                    @error('expires_at')
                                        <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description *
                                </label>
                                <textarea class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('description') border-red-300 focus:ring-gray-500 @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="3" 
                                          placeholder="Description du code promo..." 
                                          required 
                                          maxlength="255">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-black">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Activation -->
                            <div class="flex items-center">
                                <input class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300 rounded" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Activer le code promo immédiatement
                                </label>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                                <button type="submit" 
                                        class="inline-flex items-center justify-center px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Créer le Code Promo
                                </button>
                                <a href="{{ route('admin.promos.index') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                                    Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar avec conseils et prévisualisation -->
            <div class="space-y-6">
                <!-- Conseils -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="text-xl mr-2">💡</span>
                            Conseils
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Types de réduction :</h4>
                            <div class="space-y-2">
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <div>
                                        <span class="font-medium text-gray-900">Pourcentage :</span>
                                        <span class="text-gray-600"> Réduction de X% sur le total</span>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <div>
                                        <span class="font-medium text-gray-900">Montant fixe :</span>
                                        <span class="text-gray-600"> Réduction de X FCFA sur le total</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-3">Bonnes pratiques :</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">✓</span>
                                    Utilisez des codes courts et mémorables
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">✓</span>
                                    Définissez une date d'expiration réaliste
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">✓</span>
                                    Limitez les utilisations pour éviter les abus
                                </li>
                                <li class="flex items-start">
                                    <span class="text-green-500 mr-2">✓</span>
                                    Testez vos codes avant de les publier
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Prévisualisation -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="text-xl mr-2">👁️</span>
                            Prévisualisation
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center">
                            <!-- Card de prévisualisation du code promo -->
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-dashed border-blue-300 rounded-lg p-6 mb-4">
                                <div class="mb-4">
                                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Code Promo</h4>
                                    <div class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg font-mono text-lg font-bold tracking-wider" id="preview_code">
                                        XXXX
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <p class="text-gray-700 text-sm" id="preview_description">
                                        Description du code promo
                                    </p>
                                    <div class="flex items-center justify-center">
                                        <div class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full">
                                            <span class="text-lg font-bold" id="preview_discount">-0%</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-500 text-xs" id="preview_expiry">
                                        Expire le : --/--/----
                                    </p>
                                </div>
                            </div>

                            <div class="text-xs text-gray-500 italic">
                                Cette prévisualisation se met à jour automatiquement
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const codeInput = document.getElementById('code');
    const discountTypeSelect = document.getElementById('discount_type');
    const discountValueInput = document.getElementById('discount_value');
    const discountUnit = document.getElementById('discount_unit');
    const discountHelp = document.getElementById('discount_help');
    const descriptionInput = document.getElementById('description');
    const expiresAtInput = document.getElementById('expires_at');
    const generateCodeBtn = document.getElementById('generateCode');

    // Prévisualisation avec animations
    function updatePreview() {
        // Code
        const codePreview = document.getElementById('preview_code');
        const newCode = codeInput.value.toUpperCase() || 'XXXX';
        if (codePreview.textContent !== newCode) {
            codePreview.style.transform = 'scale(0.9)';
            setTimeout(() => {
                codePreview.textContent = newCode;
                codePreview.style.transform = 'scale(1)';
            }, 100);
        }

        // Description
        const descPreview = document.getElementById('preview_description');
        const newDesc = descriptionInput.value || 'Description du code promo';
        descPreview.textContent = newDesc;
        
        // Réduction
        const discountPreview = document.getElementById('preview_discount');
        const discountType = discountTypeSelect.value;
        const discountValue = discountValueInput.value;
        if (discountType && discountValue) {
            const unit = discountType === 'percentage' ? '%' : ' FCFA';
            const newDiscount = `-${discountValue}${unit}`;
            if (discountPreview.textContent !== newDiscount) {
                discountPreview.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    discountPreview.textContent = newDiscount;
                    discountPreview.style.transform = 'scale(1)';
                }, 100);
            }
        } else {
            discountPreview.textContent = '-0%';
        }
        
        // Date d'expiration
        const expiryPreview = document.getElementById('preview_expiry');
        if (expiresAtInput.value) {
            const date = new Date(expiresAtInput.value);
            expiryPreview.textContent = `Expire le : ${date.toLocaleDateString('fr-FR')}`;
        } else {
            expiryPreview.textContent = 'Expire le : --/--/----';
        }
    }

    // Événements pour la prévisualisation
    codeInput.addEventListener('input', updatePreview);
    discountTypeSelect.addEventListener('change', updatePreview);
    discountValueInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    expiresAtInput.addEventListener('input', updatePreview);

    // Gestion du type de réduction avec animations
    discountTypeSelect.addEventListener('change', function() {
        const type = this.value;
        
        // Animation pour le changement d'unité
        discountUnit.style.opacity = '0.5';
        discountHelp.style.opacity = '0.5';
        
        setTimeout(() => {
            if (type === 'percentage') {
                discountUnit.textContent = '%';
                discountHelp.textContent = 'Pourcentage maximum : 100%';
                discountValueInput.max = '100';
            } else if (type === 'fixed') {
                discountUnit.textContent = 'FCFA';
                discountHelp.textContent = 'Montant en FCFA';
                discountValueInput.removeAttribute('max');
            }
            
            discountUnit.style.opacity = '1';
            discountHelp.style.opacity = '1';
            updatePreview();
        }, 150);
    });

    // Génération automatique de code avec loading
    generateCodeBtn.addEventListener('click', function() {
        const originalContent = generateCodeBtn.innerHTML;
        generateCodeBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Génération...';
        generateCodeBtn.disabled = true;

        fetch('{{ route("admin.promos.generate-code") }}')
            .then(response => response.json())
            .then(data => {
                codeInput.value = data.code;
                updatePreview();
                
                // Animation de succès
                codeInput.style.backgroundColor = '#dcfce7';
                setTimeout(() => {
                    codeInput.style.backgroundColor = '';
                }, 1000);
            })
            .catch(error => {
                console.error('Erreur lors de la génération du code:', error);
                alert('Erreur lors de la génération du code');
            })
            .finally(() => {
                generateCodeBtn.innerHTML = originalContent;
                generateCodeBtn.disabled = false;
            });
    });

    // Auto-hide des erreurs
    setTimeout(function() {
        const errorAlert = document.querySelector('.bg-red-50');
        if (errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s ease-out';
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 500);
        }
    }, 8000);

    // Initialisation
    updatePreview();

    // Ajout de transitions CSS en JavaScript pour les éléments de prévisualisation
    const previewElements = ['preview_code', 'preview_discount'];
    previewElements.forEach(id => {
        const element = document.getElementById(id);
        element.style.transition = 'transform 0.2s ease-in-out';
    });
});
</script>
@endpush
@endsection
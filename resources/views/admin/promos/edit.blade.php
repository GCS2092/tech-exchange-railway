@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête de la page -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
            <div class="mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <span class="text-4xl">✏️</span>
                    Modifier le Code Promo
                </h1>
                <p class="mt-2 text-gray-600">Modifier les informations du code promo</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.promos.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
                <a href="{{ route('admin.promos.show', $promo->id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-black text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Voir détails
                </a>
            </div>
        </div>

        <!-- Alertes -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-gray-400 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-gray-800 font-medium">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="mt-1 text-red-700 text-sm">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulaire principal -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h2 class="text-xl font-semibold text-gray-900">Informations du Code Promo</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.promos.update', $promo->id) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Code Promo -->
                            <div>
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Code Promo <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="code" id="code" value="{{ old('code', $promo->code) }}" required
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                           placeholder="Ex: SAVE20">
                                    <button type="button" onclick="generateCode()" 
                                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm rounded-md hover:bg-gray-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Générer
                                    </button>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Le code sera automatiquement converti en majuscules</p>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="description" id="description" value="{{ old('description', $promo->description) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                       placeholder="Ex: Code promo été 2024">
                            </div>

                            <!-- Type de réduction -->
                            <div>
                                <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type de réduction <span class="text-red-500">*</span>
                                </label>
                                <select name="discount_type" id="discount_type" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                    <option value="">Choisir le type</option>
                                    <option value="percentage" {{ old('discount_type', $promo->discount_type) === 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
                                    <option value="fixed" {{ old('discount_type', $promo->discount_type) === 'fixed' ? 'selected' : '' }}>Montant fixe (FCFA)</option>
                                </select>
                            </div>

                            <!-- Valeur de la réduction -->
                            <div>
                                <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-2">
                                    Valeur de la réduction <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" name="discount_value" id="discount_value" step="0.01" min="0" value="{{ old('discount_value', $promo->discount_value) }}" required
                                           class="w-full px-3 py-2 pr-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                           placeholder="Ex: 20 pour 20% ou 1000 pour 1000 FCFA">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm" id="discount_suffix">
                                            {{ $promo->discount_type === 'percentage' ? '%' : 'FCFA' }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1" id="discount_hint">
                                    @if($promo->discount_type === 'percentage')
                                        Pourcentage maximum : 100%
                                    @else
                                        Montant fixe en FCFA
                                    @endif
                                </p>
                            </div>

                            <!-- Montant minimum -->
                            <div>
                                <label for="min_order_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Montant minimum de commande
                                </label>
                                <div class="relative">
                                    <input type="number" name="min_order_amount" id="min_order_amount" step="0.01" min="0" value="{{ old('min_order_amount', $promo->min_order_amount) }}"
                                           class="w-full px-3 py-2 pr-16 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                           placeholder="Ex: 5000">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 text-sm">FCFA</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">Laissez vide pour aucun minimum</p>
                            </div>

                            <!-- Nombre maximum d'utilisations -->
                            <div>
                                <label for="max_usage" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre maximum d'utilisations
                                </label>
                                <input type="number" name="max_usage" id="max_usage" min="1" value="{{ old('max_usage', $promo->max_usage) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                                       placeholder="Ex: 100">
                                <p class="text-sm text-gray-500 mt-1">Laissez vide pour illimité</p>
                            </div>

                            <!-- Date d'expiration -->
                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                                    Date d'expiration <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at', $promo->expires_at->format('Y-m-d\TH:i')) }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                            </div>

                            <!-- Actif -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Activer ce code promo
                                </label>
                            </div>

                            <!-- Boutons -->
                            <div class="flex justify-end space-x-3 pt-6">
                                <a href="{{ route('admin.promos.index') }}"
                                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors duration-200">
                                    Annuler
                                </a>
                                <button type="submit"
                                        class="px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition-all duration-200">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Conseils -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <h3 class="text-lg font-semibold text-gray-900">Conseils</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Types de réduction :</h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>• <strong>Pourcentage :</strong> Réduction de X% sur le total</li>
                                    <li>• <strong>Montant fixe :</strong> Réduction de X FCFA sur le total</li>
                                </ul>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Bonnes pratiques :</h4>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li>✓ Utilisez des codes courts et mémorables</li>
                                    <li>✓ Définissez une date d'expiration réaliste</li>
                                    <li>✓ Limitez les utilisations pour éviter les abus</li>
                                    <li>✓ Testez vos codes avant de les publier</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations actuelles -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="text-lg font-semibold text-gray-900">Informations actuelles</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Utilisations actuelles :</span>
                            <span class="text-sm font-semibold text-gray-900 ml-2">{{ $promo->usage_count }}</span>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-600">Statut :</span>
                            <span class="text-sm font-semibold {{ $promo->is_active ? 'text-black' : 'text-black' }} ml-2">
                                {{ $promo->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                        
                        <div>
                            <span class="text-sm font-medium text-gray-600">Validité :</span>
                            <span class="text-sm font-semibold {{ $promo->isValid() ? 'text-black' : 'text-black' }} ml-2">
                                {{ $promo->isValid() ? 'Valide' : 'Invalide' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Génération automatique de code
function generateCode() {
    fetch('{{ route("admin.promos.generate-code") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('code').value = data.code;
        })
        .catch(error => {
            console.error('Erreur lors de la génération du code:', error);
            alert('Erreur lors de la génération du code');
        });
}

// Mise à jour du suffixe et des conseils selon le type de réduction
document.getElementById('discount_type').addEventListener('change', function() {
    const discountType = this.value;
    const suffix = document.getElementById('discount_suffix');
    const hint = document.getElementById('discount_hint');
    
    if (discountType === 'percentage') {
        suffix.textContent = '%';
        hint.textContent = 'Pourcentage maximum : 100%';
    } else if (discountType === 'fixed') {
        suffix.textContent = 'FCFA';
        hint.textContent = 'Montant fixe en FCFA';
    } else {
        suffix.textContent = '';
        hint.textContent = '';
    }
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.bg-red-50');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease-out';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">
        <!-- En-tête avec animation -->
        <div class="text-center mb-12 transform transition duration-700 hover:scale-105">
            <h1 class="text-4xl md:text-5xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 to-pink-600 mb-4">
                Modifier le Code Promo
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8 transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Oups ! Il y a eu des erreurs :</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('promos.update', $promo) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $promo->code) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type de réduction</label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="percent" {{ old('type', $promo->type) === 'percent' ? 'selected' : '' }}>Pourcentage</option>
                            <option value="fixed" {{ old('type', $promo->type) === 'fixed' ? 'selected' : '' }}>Montant fixe</option>
                        </select>
                    </div>

                    <!-- Valeur -->
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700">Valeur</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="value" id="value" value="{{ old('value', $promo->value) }}" required step="0.01" min="0"
                                class="block w-full pr-10 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span id="value-symbol" class="text-gray-500 sm:text-sm">
                                    {{ old('type', $promo->type) === 'percent' ? '%' : '€' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Date d'expiration -->
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700">Date d'expiration (optionnel)</label>
                        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $promo->expires_at ? $promo->expires_at->format('Y-m-d') : '') }}"
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Nombre maximum d'utilisations -->
                    <div>
                        <label for="max_uses" class="block text-sm font-medium text-gray-700">Nombre maximum d'utilisations (optionnel)</label>
                        <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses', $promo->max_uses) }}" min="1"
                            class="mt-1 block w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('promos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg hover:from-purple-700 hover:to-pink-700 transition-all duration-300 transform hover:-translate-y-1">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mise à jour du symbole de valeur
        const typeSelect = document.getElementById('type');
        if (typeSelect) {
            const updateSymbol = () => {
                const symbol = typeSelect.value === 'percent' ? '%' : '€';
                document.getElementById('value-symbol').textContent = symbol;
            };
            
            updateSymbol();
            typeSelect.addEventListener('change', updateSymbol);
        }
    });
</script>
@endpush

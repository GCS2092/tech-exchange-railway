@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-indigo-50 to-blue-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Créer un code promo</h1>
                <a href="{{ route('promos.index') }}" class="text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
            </div>

            <form action="{{ route('promos.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Code promo</label>
                        <input type="text" name="code" id="code" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ex: WELCOME10">
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type de réduction</label>
                        <select name="type" id="type" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="percent">Pourcentage</option>
                            <option value="fixed">Montant fixe</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valeur -->
                    <div>
                        <label for="value" class="block text-sm font-medium text-gray-700">Valeur</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="value" id="value" step="0.01" required
                                class="block w-full rounded-md border-gray-300 pr-12 focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 sm:text-sm" id="value-symbol">%</span>
                            </div>
                        </div>
                        @error('value')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date d'expiration -->
                    <div>
                        <label for="expires_at" class="block text-sm font-medium text-gray-700">Date d'expiration (optionnel)</label>
                        <input type="date" name="expires_at" id="expires_at"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('expires_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Créer le code promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('type').addEventListener('change', function() {
        const valueSymbol = document.getElementById('value-symbol');
        valueSymbol.textContent = this.value === 'percent' ? '%' : '€';
    });
</script>
@endpush
@endsection
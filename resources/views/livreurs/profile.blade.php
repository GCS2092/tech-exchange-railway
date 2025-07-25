@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-purple-50 to-pink-50 py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil</h1>
            <p class="mt-2 text-sm text-gray-600">Gérez vos informations personnelles et consultez vos statistiques</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informations personnelles -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Informations personnelles</h2>
                        <button type="button" class="btn btn-secondary" onclick="toggleEdit()">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span>Modifier</span>
                        </button>
                    </div>

                    <!-- Formulaire -->
                    <form action="{{ route('livreur.profile.update') }}" method="POST" id="profile-form" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <input type="text" name="name" id="name" value="{{ auth()->user()->name }}"
                                    class="mt-1 form-input block w-full" disabled>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}"
                                    class="mt-1 form-input block w-full" disabled>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}"
                                    class="mt-1 form-input block w-full" disabled>
                            </div>

                            <div>
                                <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Type de véhicule</label>
                                <input type="text" name="vehicle_type" id="vehicle_type" value="{{ auth()->user()->vehicle_type }}"
                                    class="mt-1 form-input block w-full" disabled>
                            </div>
                        </div>

                        <div class="hidden" id="password-section">
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900">Changer le mot de passe</h3>
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="mt-1 form-input block w-full">
                                    </div>

                                    <div>
                                        <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                        <input type="password" name="new_password" id="new_password"
                                            class="mt-1 form-input block w-full">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hidden pt-6" id="form-buttons">
                            <div class="flex justify-end space-x-3">
                                <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistiques de livraison -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Statistiques de livraison</h2>
                    
                    <!-- Graphique des livraisons -->
                    <div class="h-64 mb-6">
                        <canvas id="deliveryChart"></canvas>
                    </div>

                    <!-- Métriques -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 rounded-xl p-4">
                            <p class="text-sm font-medium text-blue-600">Taux de livraison</p>
                            <p class="mt-2 text-3xl font-bold text-blue-900">98%</p>
                            <p class="mt-1 text-sm text-blue-500">+2.5% ce mois</p>
                        </div>

                        <div class="bg-green-50 rounded-xl p-4">
                            <p class="text-sm font-medium text-green-600">Livraisons à l'heure</p>
                            <p class="mt-2 text-3xl font-bold text-green-900">95%</p>
                            <p class="mt-1 text-sm text-green-500">+1.2% ce mois</p>
                        </div>

                        <div class="bg-purple-50 rounded-xl p-4">
                            <p class="text-sm font-medium text-purple-600">Note moyenne</p>
                            <p class="mt-2 text-3xl font-bold text-purple-900">4.8/5</p>
                            <p class="mt-1 text-sm text-purple-500">Basé sur 124 avis</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Carte de profil -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" 
                                alt="Photo de profil" 
                                class="w-32 h-32 rounded-full">
                            <button class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <h3 class="mt-4 text-xl font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-500">Livreur depuis {{ auth()->user()->created_at->diffForHumans(null, true) }}</p>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-600">Status</dt>
                                <dd class="text-sm font-medium text-green-600">En ligne</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-600">Zone de livraison</dt>
                                <dd class="text-sm text-gray-900">{{ auth()->user()->delivery_zone }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-600">Disponibilité</dt>
                                <dd class="text-sm text-gray-900">Lun-Sam, 8h-18h</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Derniers avis -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Derniers avis</h2>
                    <div class="space-y-6">
                        @foreach(range(1, 3) as $review)
                        <div class="border-b border-gray-100 last:border-0 pb-6 last:pb-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-sm font-medium text-gray-600">C</span>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900">Client {{ $review }}</h3>
                                        <div class="flex items-center">
                                            @for($i = 0; $i < 5; $i++)
                                            <svg class="w-4 h-4 {{ $i < 5 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">Livraison rapide et service impeccable. Le livreur était très professionnel.</p>
                                    <p class="mt-1 text-xs text-gray-500">Il y a 2 jours</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleEdit() {
    const form = document.getElementById('profile-form');
    const inputs = form.querySelectorAll('input:not([type="hidden"])');
    const passwordSection = document.getElementById('password-section');
    const formButtons = document.getElementById('form-buttons');

    inputs.forEach(input => {
        input.disabled = false;
    });

    passwordSection.classList.remove('hidden');
    formButtons.classList.remove('hidden');
}

function cancelEdit() {
    const form = document.getElementById('profile-form');
    const inputs = form.querySelectorAll('input:not([type="hidden"])');
    const passwordSection = document.getElementById('password-section');
    const formButtons = document.getElementById('form-buttons');

    inputs.forEach(input => {
        input.disabled = true;
        input.value = input.defaultValue;
    });

    passwordSection.classList.add('hidden');
    formButtons.classList.add('hidden');
}

// Graphique des livraisons
const ctx = document.getElementById('deliveryChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
        datasets: [{
            label: 'Livraisons',
            data: [12, 19, 15, 17, 14, 13, 8],
            borderColor: 'rgb(99, 102, 241)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: false
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush
@endsection 
<x-admin-layout>
    <div class="min-h-screen bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête de la page avec design moderne -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="text-4xl">✏️</span>
                        Modifier l'Utilisateur
                    </h1>
                    <p class="mt-2 text-gray-600">Mettre à jour les informations et permissions de l'utilisateur</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Alertes avec design moderne -->
            @if (session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-gray-400 rounded-r-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800">Succès !</h3>
                            <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-8 bg-red-50 border-l-4 border-gray-400 rounded-r-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-gray-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-gray-800">Erreur !</h3>
                            <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Formulaire principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informations de l'utilisateur -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="text-xl mr-2">👤</span>
                                Profil de l'Utilisateur
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-6">
                                <div class="flex-shrink-0 h-16 w-16 relative">
                                    <img class="h-16 w-16 rounded-full object-cover ring-4 ring-white shadow-lg" 
                                         src="{{ $user->profile_photo_url ?? '/images/default-avatar.png' }}" 
                                         alt="{{ $user->name }}"
                                         onerror="this.src='/images/default-avatar.png'">
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                    <p class="text-sm text-gray-500">Membre depuis {{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <!-- Informations de base -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                                        <input type="text" 
                                               id="name" 
                                               name="name" 
                                               value="{{ $user->name }}" 
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                                               required>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                        <input type="email" 
                                               id="email" 
                                               name="email" 
                                               value="{{ $user->email }}" 
                                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                                               required>
                                    </div>
                                </div>

                                <!-- Rôles actuels -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Rôles actuels</label>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($user->roles as $role)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800 border border-blue-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                                </svg>
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @empty
                                            <span class="text-sm text-gray-500 italic">Aucun rôle attribué</span>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Attribution de rôles -->
                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Changer le rôle principal</label>
                                    <select id="role" 
                                            name="role" 
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                                        <option value="">Sélectionner un rôle</option>
                                        @foreach($availableRoles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Sélectionnez un nouveau rôle pour remplacer le rôle actuel</p>
                                </div>

                                <!-- Permissions -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Permissions directes</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($permissions as $permission)
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="permission_{{ $permission->id }}" 
                                                       name="permissions[]" 
                                                       value="{{ $permission->id }}" 
                                                       {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}
                                                       class="h-4 w-4 text-black focus:ring-gray-500 border-gray-300 rounded"
                                                       data-permission="{{ $permission->name }}">
                                                <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">
                                                    {{ ucfirst(str_replace(['-', '_'], ' ', $permission->name)) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Boutons d'action -->
                                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Mettre à jour
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200">
                                        Annuler
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar avec informations et actions -->
                <div class="space-y-6">
                    <!-- Informations de l'utilisateur -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="text-xl mr-2">ℹ️</span>
                                Informations
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">ID Utilisateur :</span>
                                    <span class="font-medium text-gray-900">#{{ $user->id }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Créé le :</span>
                                    <span class="font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Dernière connexion :</span>
                                    <span class="font-medium text-gray-900">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600">Statut :</span>
                                    @if($user->is_blocked)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Bloqué
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Actif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="text-xl mr-2">⚡</span>
                                Actions Rapides
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('admin.users.details', $user->id) }}" 
                                   class="flex items-center text-sm text-black hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Voir les détails
                                </a>
                                <a href="{{ route('admin.users.orders', $user->id) }}" 
                                   class="flex items-center text-sm text-black hover:text-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Voir les commandes
                                </a>
                                @if($user->id !== auth()->id())
                                    <button onclick="showBlockModal({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" 
                                            class="flex items-center text-sm {{ $user->is_blocked ? 'text-black hover:text-gray-600' : 'text-black hover:text-gray-600' }} transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z" />
                                        </svg>
                                        {{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Conseils de sécurité -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <span class="text-xl mr-2">🔒</span>
                                Sécurité
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Gestion des rôles sécurisée
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Permissions granulaires
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Audit des modifications
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour bloquer/débloquer -->
    <div id="blockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4" id="blockModalTitle">Confirmation</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="blockModalMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
                    <div class="mt-4">
                        <label for="adminPassword" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe admin *</label>
                        <input type="password" id="adminPassword" name="password" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent" 
                               placeholder="Entrez votre mot de passe admin" required>
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmBlockBtn" class="px-4 py-2 bg-black text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Confirmer
                    </button>
                    <button onclick="hideBlockModal()" class="mt-3 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentUserId = null;
        let currentAction = null;

        function showBlockModal(userId, userName, isBlocked) {
            currentUserId = userId;
            currentAction = isBlocked ? 'unblock' : 'block';
            
            const modal = document.getElementById('blockModal');
            const title = document.getElementById('blockModalTitle');
            const message = document.getElementById('blockModalMessage');
            const confirmBtn = document.getElementById('confirmBlockBtn');
            
            if (isBlocked) {
                title.textContent = 'Débloquer l\'utilisateur';
                message.textContent = `Êtes-vous sûr de vouloir débloquer l'utilisateur "${userName}" ?`;
                confirmBtn.textContent = 'Débloquer';
                confirmBtn.className = 'px-4 py-2 bg-black text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300';
            } else {
                title.textContent = 'Bloquer l\'utilisateur';
                message.textContent = `Êtes-vous sûr de vouloir bloquer l'utilisateur "${userName}" ?`;
                confirmBtn.textContent = 'Bloquer';
                confirmBtn.className = 'px-4 py-2 bg-black text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-red-300';
            }
            
            modal.classList.remove('hidden');
        }

        function hideBlockModal() {
            document.getElementById('blockModal').classList.add('hidden');
            document.getElementById('adminPassword').value = ''; // Vider le champ mot de passe
        }

        document.getElementById('confirmBlockBtn').addEventListener('click', function() {
            if (currentUserId && currentAction) {
                const password = document.getElementById('adminPassword').value;
                if (!password) {
                    alert('Veuillez entrer votre mot de passe admin');
                    return;
                }
                
                const url = currentAction === 'block' 
                    ? `/admin/users/${currentUserId}/block`
                    : `/admin/users/${currentUserId}/unblock`;
                
                // Créer un FormData pour envoyer les données
                const formData = new FormData();
                formData.append('password', password);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                fetch(url, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        return response.text().then(text => {
                            throw new Error(text);
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'opération: ' + error.message);
                });
                
                hideBlockModal();
            }
        });

        // Auto-hide des messages de succès et d'erreur
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-50');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
            
            const errorAlert = document.querySelector('.bg-red-50');
            if (errorAlert) {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500);
            }
        }, 5000);
    </script>
</x-admin-layout> 
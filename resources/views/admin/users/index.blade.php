<x-admin-layout>
    <div class="min-h-screen bg-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- En-tête principal avec design moderne -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8">
                <div class="mb-4 lg:mb-0">
                    <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="text-4xl">👥</span>
                        Gestion des Utilisateurs
                    </h1>
                    <p class="mt-2 text-gray-600">Gérez les utilisateurs et leurs rôles sur votre plateforme</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.users.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un utilisateur
                    </a>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au tableau de bord
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

            <!-- Statistiques des utilisateurs -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Administrateurs</p>
                            <p class="text-2xl font-bold text-black">{{ $users->filter(fn($u) => $u->hasRole('admin'))->count() }}</p>
                        </div>
                        <div class="p-3 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Vendeurs</p>
                            <p class="text-2xl font-bold text-black">{{ $users->filter(fn($u) => $u->hasRole('vendeur'))->count() }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Livreurs</p>
                            <p class="text-2xl font-bold text-black">{{ $users->filter(fn($u) => $u->hasRole('livreur'))->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des utilisateurs avec design moderne -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="text-xl mr-2">📋</span>
                        Liste des Utilisateurs
                    </h3>
                </div>
                
                <!-- Version desktop -->
                <div class="hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Utilisateur</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rôle</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Statut</th>
                                    <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 relative">
                                                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-lg" 
                                                         src="{{ $user->profile_photo_url ?? '/images/default-avatar.png' }}" 
                                                         alt="{{ $user->name }}"
                                                         onerror="this.src='/images/default-avatar.png'">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        ID: #{{ $user->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            <div class="text-sm text-gray-700 font-medium">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            @php $role = $user->getRoleNames()->first(); @endphp
                                            <span class="px-4 py-2 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm border
                                                {{ $role === 'admin' ? 'bg-gray-100 text-gray-800 border-red-200' :
                                                   ($role === 'livreur' ? 'bg-gray-100 text-gray-800 border-green-200' :
                                                   ($role === 'vendeur' ? 'bg-gray-100 text-gray-800 border-blue-200' :
                                                   'bg-gray-100 text-gray-800 border-gray-200')) }}">
                                                {{ ucfirst($role) ?? 'Utilisateur' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap">
                                            @if($user->is_blocked)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Bloqué
                                                </span>
                                            @else
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                    Actif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <!-- Bouton Éditer - Seulement pour vendeurs et livreurs -->
                                                @if($user->hasAnyRole(['vendeur', 'livreur']))
                                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Éditer
                                                    </a>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-md text-sm leading-4 font-medium text-gray-400 bg-gray-50">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                        Non éditable
                                                    </span>
                                                @endif
                                                
                                                @if ($user->id !== auth()->id())
                                                    <!-- Bouton Bloquer/Débloquer -->
                                                    <button onclick="showBlockModal({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" 
                                                            class="inline-flex items-center px-3 py-2 border rounded-md text-sm leading-4 font-medium transition-colors duration-200
                                                            {{ $user->is_blocked 
                                                                ? 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100 focus:ring-gray-500' 
                                                                : 'border-red-300 text-red-700 bg-red-50 hover:bg-red-100 focus:ring-gray-500' }}">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z" />
                                                        </svg>
                                                        {{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Version mobile -->
                <div class="lg:hidden">
                    <div class="p-4 space-y-4">
                        @foreach ($users as $user)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <img class="h-10 w-10 rounded-full object-cover ring-2 ring-white shadow-lg" 
                                             src="{{ $user->profile_photo_url ?? '/images/default-avatar.png' }}" 
                                             alt="{{ $user->name }}"
                                             onerror="this.src='/images/default-avatar.png'">
                                        <div class="ml-3">
                                            <div class="text-sm font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    @php $role = $user->getRoleNames()->first(); @endphp
                                    <span class="px-3 py-1 text-xs font-bold rounded-full
                                        {{ $role === 'admin' ? 'bg-gray-100 text-gray-800' :
                                           ($role === 'livreur' ? 'bg-gray-100 text-gray-800' :
                                           ($role === 'vendeur' ? 'bg-gray-100 text-gray-800' :
                                           'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($role) ?? 'Utilisateur' }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm text-gray-600">ID: #{{ $user->id }}</span>
                                    @if($user->is_blocked)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Bloqué
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Actif
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="flex space-x-2">
                                    @if($user->hasAnyRole(['vendeur', 'livreur']))
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Éditer
                                        </a>
                                    @else
                                        <span class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-200 rounded-md text-sm font-medium text-gray-400 bg-gray-50">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Non éditable
                                        </span>
                                    @endif
                                    
                                    @if ($user->id !== auth()->id())
                                        <button onclick="showBlockModal({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" 
                                                class="flex-1 inline-flex justify-center items-center px-3 py-2 border rounded-md text-sm font-medium transition-colors duration-200
                                                {{ $user->is_blocked 
                                                    ? 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100' 
                                                    : 'border-red-300 text-red-700 bg-red-50 hover:bg-red-100' }}">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z" />
                                            </svg>
                                            {{ $user->is_blocked ? 'Débloquer' : 'Bloquer' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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

        // Auto-hide des messages de succès
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-50');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease-out';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>
</x-admin-layout>
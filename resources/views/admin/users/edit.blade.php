<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Modifier l'utilisateur</h2>
                        <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            Retour à la liste
                        </a>
                    </div>

                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        {{ $user->name }}
                                    </h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                        {{ $user->email }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Membre depuis {{ $user->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="grid grid-cols-1 gap-6">
                                    <!-- Informations de base -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                            <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <!-- Rôles actuels -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rôles actuels</label>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($user->roles as $role)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                                    {{ ucfirst($role->name) }}
                                                    <form action="{{ route('admin.users.remove-role', $user) }}" method="POST" class="ml-2 inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="role" value="{{ $role->name }}">
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900" onclick="return confirm('Retirer ce rôle ?')">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </span>
                                            @empty
                                                <span class="text-sm text-gray-500">Aucun rôle attribué</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Attribution de rôles -->
                                    <div>
                                        <label for="role" class="block text-sm font-medium text-gray-700">Attribuer un nouveau rôle</label>
                                        <div class="mt-1 flex gap-2">
                                            <select id="role" name="role" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="">Sélectionner un rôle</option>
                                                @foreach($availableRoles as $role)
                                                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Ajouter
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Permissions -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Permissions directes</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($permissions as $permission)
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}" 
                                                           {{ $user->hasDirectPermission($permission->name) ? 'checked' : '' }}
                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label for="permission_{{ $permission->id }}" class="ml-2 text-sm text-gray-700">
                                                        {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Statut du compte -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut du compte</label>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center">
                                                <input type="radio" id="status_active" name="is_blocked" value="0" {{ !$user->is_blocked ? 'checked' : '' }}
                                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                                                <label for="status_active" class="ml-2 text-sm text-gray-700">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Actif
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="flex items-center">
                                                <input type="radio" id="status_blocked" name="is_blocked" value="1" {{ $user->is_blocked ? 'checked' : '' }}
                                                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                                                <label for="status_blocked" class="ml-2 text-sm text-gray-700">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Bloqué
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Annuler
                                        </a>
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Mettre à jour
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 
@push('scripts')
<script>
    // Permissions par rôle (à adapter selon la logique du projet)
    const rolePermissions = {
        'admin': @json($permissions->pluck('name')),
        'vendeur': @json($permissions->filter(fn($p) => str_contains($p->name, 'product') || str_contains($p->name, 'order'))->pluck('name')),
        'livreur': @json($permissions->filter(fn($p) => str_contains($p->name, 'delivery'))->pluck('name')),
        'user': []
    };
    document.getElementById('role').addEventListener('change', function(e) {
        const selectedRole = e.target.value;
        const perms = rolePermissions[selectedRole] || [];
        document.querySelectorAll('input[type=checkbox][name="permissions[]"]').forEach(cb => {
            cb.checked = perms.includes(cb.value);
        });
    });
</script>
@endpush 
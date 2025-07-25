<x-admin-layout>
    <div class="py-12 bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-2xl sm:rounded-3xl border border-white/20">
                <div class="p-8 bg-gradient-to-r from-white to-gray-50/50 border-b border-gray-200/30">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Gestion des utilisateurs
                            </h2>
                            <p class="text-gray-600 mt-2">Gérez les utilisateurs et leurs rôles</p>
                        </div>
                        <div class="flex space-x-4">
                            <a href="{{ route('admin.users.create') }}" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajouter un utilisateur
                            </a>
                            <a href="{{ route('admin.dashboard') }}" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl hover:from-indigo-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7-7 7V20l7-7m-7 7h18" />
                                </svg>
                                Retour au tableau de bord
                            </a>
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl shadow-sm backdrop-blur-sm">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm backdrop-blur-sm">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <span class="block sm:inline font-medium">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="overflow-hidden rounded-2xl border border-gray-200/50 shadow-lg bg-white/50 backdrop-blur-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200/50">
                                <thead class="bg-gradient-to-r from-gray-50/80 to-slate-50/80 backdrop-blur-sm">
                                    <tr>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nom</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rôle actuel</th>
                                        <th class="px-8 py-5 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white/30 backdrop-blur-sm divide-y divide-gray-200/30">
                                    @foreach ($users as $user)
                                        <tr class="hover:bg-white/60 transition-all duration-300 hover:shadow-md group">
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-12 w-12 relative">
                                                        <img class="h-12 w-12 rounded-full object-cover ring-2 ring-white shadow-lg group-hover:ring-indigo-200 transition-all duration-300" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-transparent to-black/10"></div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-900 transition-colors duration-300">
                                                            {{ $user->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                <div class="text-sm text-gray-700 font-medium">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap">
                                                @php $role = $user->getRoleNames()->first(); @endphp
                                                <span class="px-4 py-2 inline-flex text-xs leading-5 font-bold rounded-full shadow-sm border backdrop-blur-sm
                                                    {{ $role === 'admin' ? 'bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border-red-200' :
                                                       ($role === 'livreur' ? 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border-emerald-200' :
                                                       ($role === 'vendeur' ? 'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-blue-200' :
                                                       'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-gray-200')) }}">
                                                    {{ ucfirst($role) ?? 'Utilisateur' }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-4">
                                                    <a href="{{ route('admin.users.edit', $user) }}" class="group/btn text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50 transition-all duration-300 transform hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                    @if ($user->id !== auth()->id())
                                                        <button onclick="showBlockModal({{ $user->id }}, '{{ $user->name }}', {{ $user->is_blocked ? 'true' : 'false' }})" class="group/btn {{ $user->is_blocked ? 'text-green-600 hover:text-green-900' : 'text-yellow-600 hover:text-yellow-900' }} p-2 rounded-lg hover:bg-yellow-50 transition-all duration-300 transform hover:scale-110">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z" />
                                                            </svg>
                                                        </button>
                                                        <button onclick="showDeleteModal({{ $user->id }}, '{{ $user->name }}')" class="group/btn text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-300 transform hover:scale-110">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover/btn:rotate-12 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
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

                    <div class="mt-8">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-3xl bg-white/95 backdrop-blur-md border-white/20">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirmer la suppression</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-600 mb-4">
                        Vous êtes sur le point de supprimer l'utilisateur <span id="userName" class="font-bold text-gray-900"></span>. Veuillez entrer votre mot de passe pour confirmer.
                    </p>
                    <form id="deleteForm" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="user_id" id="userId">
                        <div class="mb-6">
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-300" placeholder="Mot de passe" required>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition-all duration-300 transform hover:scale-105 font-medium" onclick="hideDeleteModal()">Annuler</button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">Supprimer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de blocage/déblocage -->
    <div id="blockModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-2xl rounded-3xl bg-white/95 backdrop-blur-md border-white/20">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-1.414 1.414A9 9 0 105.636 18.364l1.414-1.414A7 7 0 1116.95 7.05z" />
                    </svg>
                </div>
                <h3 id="blockModalTitle" class="text-xl font-bold text-gray-900 mb-2">Confirmer l'action</h3>
                <div class="mt-2 px-7 py-3">
                    <p id="blockModalText" class="text-sm text-gray-600 mb-4"></p>
                    <form id="blockForm" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="user_id" id="blockUserId">
                        <div class="mb-6">
                            <input type="password" name="password" id="blockPassword" class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all duration-300" placeholder="Mot de passe admin" required>
                        </div>
                        <div class="flex justify-end space-x-3">
                            <button type="button" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-xl hover:bg-gray-300 transition-all duration-300 transform hover:scale-105 font-medium" onclick="hideBlockModal()">Annuler</button>
                            <button type="submit" id="blockActionBtn" class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 transform hover:scale-105 shadow-lg font-medium">Confirmer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showDeleteModal(userId, userName) {
            document.getElementById('userId').value = userId;
            document.getElementById('userName').textContent = userName;
            document.getElementById('deleteForm').action = `/admin/users/${userId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('password').focus();
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('password').value = '';
            document.getElementById('userId').value = '';
            document.getElementById('userName').textContent = '';
        }

        function showBlockModal(userId, userName, isBlocked) {
            document.getElementById('blockUserId').value = userId;
            document.getElementById('blockPassword').value = '';
            document.getElementById('blockModal').classList.remove('hidden');
            document.getElementById('blockModalTitle').textContent = isBlocked ? 'Confirmer le déblocage' : 'Confirmer le blocage';
            document.getElementById('blockModalText').textContent = isBlocked
                ? `Vous êtes sur le point de débloquer l'utilisateur ${userName}. Veuillez entrer votre mot de passe pour confirmer.`
                : `Vous êtes sur le point de bloquer l'utilisateur ${userName}. Veuillez entrer votre mot de passe pour confirmer.`;
            document.getElementById('blockForm').action = isBlocked
                ? `/admin/users/${userId}/unblock`
                : `/admin/users/${userId}/block`;
            document.getElementById('blockActionBtn').textContent = isBlocked ? 'Débloquer' : 'Bloquer';
            setTimeout(() => document.getElementById('blockPassword').focus(), 200);
        }
        function hideBlockModal() {
            document.getElementById('blockModal').classList.add('hidden');
            document.getElementById('blockUserId').value = '';
            document.getElementById('blockPassword').value = '';
        }
    </script>
    @endpush
</x-admin-layout>
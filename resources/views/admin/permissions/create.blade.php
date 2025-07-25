@extends('layouts.admin')
@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-800">Créer une nouvelle permission</h1>
                <a href="{{ route('admin.permissions.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg shadow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('admin.permissions.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Nom de la permission -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom de la permission <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="ex: user-create, product-edit, order-view"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Utilisez le format: action-resource (ex: create-user, edit-product, view-orders)
                    </p>
                </div>

                <!-- Groupe -->
                <div>
                    <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                        Groupe
                    </label>
                    <select id="group" 
                            name="group" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Sélectionner un groupe</option>
                        @foreach($permissionGroups as $key => $label)
                            <option value="{{ $key }}" {{ old('group') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('group')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Description détaillée de cette permission...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rôles -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Attribuer aux rôles
                    </label>
                    <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
                        @forelse($roles as $role)
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="roles[]" 
                                       value="{{ $role->id }}"
                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">{{ ucfirst($role->name) }}</span>
                                @if($role->description)
                                    <span class="ml-2 text-xs text-gray-500">({{ $role->description }})</span>
                                @endif
                            </label>
                        @empty
                            <p class="text-sm text-gray-500">Aucun rôle disponible</p>
                        @endforelse
                    </div>
                    @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">
                        Sélectionnez les rôles qui auront automatiquement cette permission
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.permissions.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Créer la permission
                    </button>
                </div>
            </form>
        </div>

        <!-- Aide -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-lg font-medium text-blue-800 mb-2">Conseils pour créer une permission</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Utilisez des noms descriptifs et cohérents</li>
                <li>• Suivez le format: action-resource (ex: create-user, edit-product)</li>
                <li>• Les permissions sont automatiquement en minuscules</li>
                <li>• Vous pouvez attribuer la permission à des rôles existants</li>
                <li>• Une description claire aide à comprendre l'usage de la permission</li>
            </ul>
        </div>
    </div>
</div>

@endsection 
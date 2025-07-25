@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Ajouter un Utilisateur</h1>

    <form method="POST" action="{{ route('admin.storeUser') }}" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="username" class="block text-gray-700">Nom d'utilisateur</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700">Mot de passe</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-gray-700">Rôle</label>
            <select name="role" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Sélectionner un rôle</option>
                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Ajouter l'utilisateur
        </button>
    </form>
</div>
@endsection

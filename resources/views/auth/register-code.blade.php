// resources/views/auth/register-code.blade.php
<x-guest-layout>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Créer un compte</h2>
        <form method="POST" action="{{ route('register.init') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block font-medium text-sm text-gray-700">Nom</label>
                <input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus>
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                <input id="email" name="email" type="email" class="mt-1 block w-full" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded">Envoyer le code</button>
        </form>
    </div>
</x-guest-layout>


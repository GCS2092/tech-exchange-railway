<x-guest-layout>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Vérification du code</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulaire pour entrer le code --}}
        <form method="POST" action="{{ route('register.verify.submit') }}" class="mb-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="mb-4">
                <label for="code" class="block font-medium text-sm text-gray-700">Code reçu</label>
                <input id="code" name="code" type="text" class="mt-1 block w-full border-gray-300 rounded" required maxlength="6" minlength="6">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                Valider le code
            </button>
        </form>

        {{-- Bouton renvoyer le code --}}
        <a href="{{ route('register') }}" class="w-full block text-center bg-gray-200 text-gray-800 py-2 rounded hover:bg-gray-300 mt-2">
            Renvoyer le code
        </a>
    </div>
</x-guest-layout>

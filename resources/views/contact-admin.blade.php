<x-guest-layout>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">
        <h2 class="text-2xl font-bold mb-4">Demande de déblocage</h2>
        <p class="mb-4">Bonjour {{ $user->name }},<br>Votre compte est actuellement bloqué. Si vous pensez qu'il s'agit d'une erreur, vous pouvez envoyer un message à l'administrateur ci-dessous.</p>
        <form method="POST" action="{{ route('contact-admin.send') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="mb-4">
                <label for="message" class="block font-medium text-sm text-gray-700">Votre message</label>
                <textarea id="message" name="message" class="mt-1 block w-full border-gray-300 rounded" required minlength="10" rows="4">Bonjour, je souhaite demander le déblocage de mon compte. Merci.</textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Envoyer la demande</button>
        </form>
    </div>
</x-guest-layout> 
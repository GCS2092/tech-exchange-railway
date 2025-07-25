<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Mot de passe oublié ?</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="text-center mt-8">
                <p class="mb-4 text-gray-700">La réinitialisation par lien est désactivée.<br>Pour réinitialiser votre mot de passe, cliquez sur le bouton ci-dessous pour recevoir un <b>code par email</b>.</p>
                <a href="{{ route('password.code.request') }}" class="inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Recevoir un code de réinitialisation</a>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Retour à la connexion
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

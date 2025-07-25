<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold">Réinitialiser le mot de passe</h2>
        </x-slot>

        @if(session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.code.send') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Envoyer le code') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

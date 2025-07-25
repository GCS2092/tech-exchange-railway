<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <h2 class="text-xl font-bold">Vérification du code</h2>
        </x-slot>

        @if(session('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('success') }}
            </div>
        @endif
        @if(session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.code.check') }}">
            @csrf
            @php $email = session('password_reset_email') ?? old('email'); @endphp
            <input type="hidden" name="email" value="{{ $email }}" />

            <!-- Code OTP -->
            <div class="mt-4">
                <x-input-label for="code" :value="__('Code reçu par email')" />
                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" maxlength="6" required pattern="[0-9]{6}" placeholder="123456" autofocus />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Vérifier le code') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('password.code.send') }}" class="mt-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}" />
            <button type="submit" class="underline text-sm text-blue-600 hover:text-blue-800">Renvoyer le code</button>
        </form>
    </x-auth-card>
</x-guest-layout> 
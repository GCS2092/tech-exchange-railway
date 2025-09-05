<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Modifiez vos informations personnelles et votre adresse e-mail.") }}
        </p>
    </header>

    {{-- Formulaire d'envoi du lien de vérification --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Formulaire principal de mise à jour --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nom complet --}}
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full"
                :value="old('name', $user->name)"
                required
                minlength="3"
                maxlength="100"
                autocomplete="name"
                autofocus
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Adresse email --}}
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Statut vérification e-mail --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-red-600">
                    {{ __('Votre adresse e-mail n’est pas vérifiée.') }}
                    <button form="send-verification"
                        class="ml-2 underline text-sm text-indigo-600 hover:text-indigo-900 focus:outline-none">
                        {{ __('Renvoyer l’e-mail de vérification') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm text-green-600 font-medium">
                        {{ __('Un nouveau lien de vérification vous a été envoyé.') }}
                    </p>
                @endif
            @endif
        </div>

        {{-- Bouton + message de succès --}}
        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Enregistrer') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 3000)"
                   class="text-sm text-green-600">
                    {{ __('Modifications enregistrées.') }}
                </p>
            @endif
        </div>
    </form>
</section>

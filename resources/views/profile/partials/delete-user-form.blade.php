<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement perdues. Veuillez télécharger toutes les informations que vous souhaitez conserver avant de continuer.') }}
        </p>
    </header>

    <x-danger-button
        x-data
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Supprimer le compte') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="POST" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Cette action est irréversible. Entrez votre mot de passe pour confirmer la suppression définitive de votre compte.') }}
            </p>

            {{-- Champ mot de passe --}}
            <div class="mt-6">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="••••••••"
                    required
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- Boutons --}}
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Confirmer la suppression') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

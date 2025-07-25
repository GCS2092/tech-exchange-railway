```blade
<x-guest-layout>
    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded">

        <h2 class="text-2xl font-bold mb-4">
            @php
                $step = Session::get('register_step', 1);
            @endphp

            @if($step === 1)
                Créer un compte
            @elseif($step === 2)
                Vérification du code
            @elseif($step === 3)
                Définir un mot de passe
            @endif
        </h2>

        <!-- Bouton d'aide pour onboarding -->
        <div class="mb-4 text-center">
            <button type="button" id="show-onboarding-btn" class="text-sm text-purple-700 hover:text-pink-600 underline font-medium focus:outline-none">
                <i class="fas fa-question-circle mr-1"></i> Besoin d'aide pour créer un compte ?
            </button>
        </div>

        <!-- Modale d'onboarding (affichée seulement si demandée) -->
        <div id="onboarding-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative animate-fade-in">
                <button id="close-onboarding-btn" class="absolute top-3 right-3 text-gray-400 hover:text-pink-500 text-xl focus:outline-none">&times;</button>
                <h3 class="text-xl font-bold mb-4 text-pink-600">Comment créer un compte ?</h3>
                <ol class="list-decimal list-inside text-gray-700 space-y-2 mb-4">
                    <li>Remplissez votre nom et votre adresse e-mail.</li>
                    <li>Vous recevrez un code de vérification par e-mail.</li>
                    <li>Entrez ce code pour valider votre adresse.</li>
                    <li>Choisissez un nom d'utilisateur et un mot de passe sécurisé.</li>
                    <li>Votre compte est prêt ! Vous pouvez maintenant commander.</li>
                </ol>
                <div class="text-center">
                    <button id="close-onboarding-btn-2" class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-xl font-semibold hover:from-pink-600 hover:to-purple-700 transition-all duration-300">J'ai compris</button>
                </div>
            </div>
        </div>

        {{-- Messages Flash --}}
        @if (session('success'))
            <div class="mb-4 px-4 py-2 rounded text-sm bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 px-4 py-2 rounded text-sm bg-red-100 text-red-800">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" 
            @if($step === 1)
                action="{{ route('register.submit') }}"
            @elseif($step === 2)
                action="{{ route('register.verify.submit') }}"
            @elseif($step === 3)
                action="{{ route('register.set.password.submit') }}"
            @endif
            enctype="multipart/form-data">
            @csrf

            @if($step === 1)
                {{-- Étape 1 : Nom & Email --}}
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input id="name" name="name" type="text" value="{{ old('name') ?? Session::get('register_name') }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           required maxlength="255" minlength="2">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email') ?? Session::get('register_email') }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                           required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @elseif($step === 2)
                {{-- Étape 2 : Code OTP --}}
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700">Code reçu par mail</label>
                    <input id="code" name="code" type="text" value="{{ old('code') }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('code') border-red-500 @enderror"
                           required pattern="[0-9]{6}" maxlength="6" minlength="6" inputmode="numeric">
                    @error('code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">Veuillez saisir le code à 6 chiffres qui vous a été envoyé par email</p>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('register.resend-code') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                        Renvoyer le code
                    </a>
                </div>
            @elseif($step === 3)
                {{-- Étape 3 : Nom d'utilisateur et Mot de passe --}}
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror"
                           required minlength="3" maxlength="30" pattern="[A-Za-z0-9_\-]+">
                    <p class="text-gray-500 text-xs mt-1">Lettres, chiffres, tirets et underscores uniquement (3-30 caractères)</p>
                    @error('username')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" name="password" type="password"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                           required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">
                    <p class="text-gray-500 text-xs mt-1">
                        Au moins 8 caractères, avec une minuscule, une majuscule, un chiffre et un caractère spécial (@$!%*?&)
                    </p>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmer le mot de passe
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('password_confirmation') border-red-500 @enderror"
                           required minlength="6">
                    @error('password_confirmation')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Photo de profil (optionnelle) --}}
                <div class="mb-4">
                    <label for="profile_photo" class="block text-sm font-medium text-gray-700">
                        Photo de profil (facultatif)
                    </label>
                    <input id="profile_photo" name="profile_photo" type="file"
                           accept="image/jpeg,image/png,image/jpg,image/gif"
                           class="mt-1 block w-full text-sm text-gray-700 @error('profile_photo') border-red-500 @enderror">
                    <p class="text-gray-500 text-xs mt-1">Formats acceptés: JPEG, PNG, JPG, GIF. Max: 2MB</p>
                    @error('profile_photo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div class="mb-4">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    @if($step === 1)
                        Suivant
                    @elseif($step === 2)
                        Vérifier
                    @elseif($step === 3)
                        Créer un compte
                    @endif
                </button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                Déjà inscrit? Connectez-vous
            </a>
        </div>
    </div>

    @if($step === 3)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const form = document.querySelector('form');
            // Harmonisation avec le pattern HTML :
            // 8+ caractères, 1 minuscule, 1 majuscule, 1 chiffre, 1 spécial
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            // Ajout de la checklist visuelle
            let checklist = document.getElementById('password-checklist');
            if (!checklist) {
                checklist = document.createElement('div');
                checklist.id = 'password-checklist';
                checklist.className = 'mb-2 space-y-1 text-sm';
                passwordInput.parentNode.insertBefore(checklist, passwordInput.nextSibling);
            }

            function updateChecklist() {
                const pwd = passwordInput.value;
                const checks = [
                    { label: 'Au moins 8 caractères', valid: pwd.length >= 8 },
                    { label: 'Une minuscule', valid: /[a-z]/.test(pwd) },
                    { label: 'Une majuscule', valid: /[A-Z]/.test(pwd) },
                    { label: 'Un chiffre', valid: /[0-9]/.test(pwd) },
                    { label: 'Un caractère spécial (@$!%*?&)', valid: /[@$!%*?&]/.test(pwd) },
                ];
                checklist.innerHTML = checks.map(c =>
                    `<span class="flex items-center gap-2 ${c.valid ? 'text-green-600' : 'text-red-500'}">
                        <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${c.valid ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}" />
                        </svg>
                        ${c.label}
                    </span>`
                ).join('');
            }
            passwordInput.addEventListener('input', updateChecklist);
            updateChecklist();

            function checkPasswordValidity() {
                const password = passwordInput.value;
                let errorMessage = '';
                if (password.length < 8) {
                    errorMessage = 'Le mot de passe doit contenir au moins 8 caractères.';
                } else if (!password.match(/[a-z]/)) {
                    errorMessage = 'Le mot de passe doit contenir au moins une minuscule.';
                } else if (!password.match(/[A-Z]/)) {
                    errorMessage = 'Le mot de passe doit contenir au moins une majuscule.';
                } else if (!password.match(/[0-9]/)) {
                    errorMessage = 'Le mot de passe doit contenir au moins un chiffre.';
                } else if (!password.match(/[@$!%*?&]/)) {
                    errorMessage = 'Le mot de passe doit contenir au moins un caractère spécial (@$!%*?&).';
                }
                return errorMessage;
            }

            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const passwordError = checkPasswordValidity();
                if (passwordError) {
                    e.preventDefault();
                    alert(passwordError);
                    return false;
                }
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Les mots de passe ne correspondent pas.');
                    return false;
                }
                return true;
            });
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showBtn = document.getElementById('show-onboarding-btn');
            const modal = document.getElementById('onboarding-modal');
            const closeBtn = document.getElementById('close-onboarding-btn');
            const closeBtn2 = document.getElementById('close-onboarding-btn-2');
            let lastFocusedElement = null;

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                lastFocusedElement = document.activeElement;
                // Focus sur la modale pour accessibilité
                setTimeout(() => {
                    modal.querySelector('h3')?.focus();
                }, 100);
            }
            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                if (lastFocusedElement) lastFocusedElement.focus();
            }
            if (showBtn && modal) {
                showBtn.addEventListener('click', openModal);
            }
            if (closeBtn && modal) {
                closeBtn.addEventListener('click', closeModal);
            }
            if (closeBtn2 && modal) {
                closeBtn2.addEventListener('click', closeModal);
            }
            // Fermeture par touche Echap
            document.addEventListener('keydown', function(e) {
                if (!modal || modal.classList.contains('hidden')) return;
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>

    @push('scripts')
    <script>
    window.tourSteps_ = [
      {
        id: 'step-welcome',
        title: '<span style="display:flex;align-items:center;"><svg class="w-6 h-6 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>Créer un compte facilement</span>',
        text: '<div style="font-size:1.1rem;">Bienvenue ! Suivez ces étapes pour créer votre compte et profiter de tous nos services.</div>',
        attachTo: { element: 'h2', on: 'bottom' },
        buttons: [ { text: 'Commencer', action: function() { tour.next(); } } ]
      },
      {
        id: 'step-nom-email',
        title: 'Étape 1 : Vos informations',
        text: 'Renseignez <b>votre nom</b> et <b>votre adresse e-mail</b> pour commencer.',
        attachTo: { element: '#name', on: 'bottom' },
        buttons: [ { text: 'Retour', action: function() { tour.back(); }, classes: 'shepherd-button-secondary' }, { text: 'Suivant', action: function() { tour.next(); } } ]
      },
      {
        id: 'step-code',
        title: 'Étape 2 : Vérification',
        text: 'Saisissez le <b>code reçu par e-mail</b> pour valider votre adresse.',
        attachTo: { element: '#code', on: 'bottom' },
        buttons: [ { text: 'Retour', action: function() { tour.back(); }, classes: 'shepherd-button-secondary' }, { text: 'Suivant', action: function() { tour.next(); } } ]
      },
      {
        id: 'step-password',
        title: 'Étape 3 : Mot de passe',
        text: 'Choisissez un <b>nom d'utilisateur</b> et un <b>mot de passe sécurisé</b>. Vous pouvez aussi ajouter une photo de profil.',
        attachTo: { element: '#password', on: 'bottom' },
        buttons: [ { text: 'Retour', action: function() { tour.back(); }, classes: 'shepherd-button-secondary' }, { text: 'Terminer', action: function() { tour.complete(); } } ]
      }
    ];
    window.showOnboardingTour = function(tourId, steps) {
      const tour = window.createCustomTour(steps);
      window.tour = tour;
      tour.start();
    };
    </script>
    @endpush
</x-guest-layout>
```
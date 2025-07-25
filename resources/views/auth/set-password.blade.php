<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Créer un mot de passe</h2>
                <p class="mt-2 text-sm text-gray-600">
                    Choisissez un mot de passe sécurisé pour votre compte.
                </p>
            </div>

        @if ($errors->any())
                <div class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
            </div>
        @endif
        
            <form method="POST" action="{{ route('register.set.password.submit') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
            @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    {{-- Nom d'utilisateur --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                        <div class="mt-1">
            <input id="username" name="username" type="text" value="{{ old('username') }}"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror"
                                required autofocus>
                            @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Photo de profil --}}
                    <div>
                        <label for="profile_photo" class="block text-sm font-medium text-gray-700">Photo de profil</label>
                        <div class="mt-1 flex items-center space-x-4">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center border-2 border-dashed border-gray-300 overflow-hidden">
                        <div id="preview" class="w-full h-full hidden bg-cover bg-center"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" id="defaultIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                            <div>
                    <label for="profile_photo" class="cursor-pointer text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">
                        Choisir une photo
                        <input type="file" name="profile_photo" id="profile_photo" class="hidden" accept="image/*" onchange="previewImage()">
                    </label>
                                <p class="text-xs text-gray-500">(optionnelle)</p>
                            </div>
                </div>
            </div>
            
            {{-- Mot de passe --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                        <div class="mt-1 relative">
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                                minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$">
                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2">
                    <div class="flex items-center mb-1">
                        <div id="strength-bar" class="h-1 w-full bg-gray-200 rounded-full overflow-hidden">
                            <div id="strength-indicator" class="h-full bg-gray-400 transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <span id="strength-text" class="ml-2 text-xs text-gray-500">Faible</span>
                    </div>
                    <ul class="text-xs text-gray-500 mt-2 space-y-1">
                        <li id="length-check" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Au moins 8 caractères
                        </li>
                        <li id="uppercase-check" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Une lettre majuscule
                        </li>
                        <li id="lowercase-check" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Une lettre minuscule
                        </li>
                        <li id="number-check" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Un chiffre
                        </li>
                        <li id="special-check" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                            Un caractère spécial (@$!%*?&)
                        </li>
                    </ul>
                </div>
            </div>
            
                    {{-- Confirmation du mot de passe --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                        <div class="mt-1 relative">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('password_confirmation') border-red-500 @enderror">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p id="match-message" class="text-xs mt-1 hidden">Les mots de passe correspondent.</p>
                    </div>
            </div>
            
            <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                    </svg>
                        </span>
                        Créer mon compte
                </button>
            </div>
        </form>
        </div>
    </div>

    <script>
        // Prévisualisation de l'image
        function previewImage() {
            const input = document.getElementById('profile_photo');
            const preview = document.getElementById('preview');
            const defaultIcon = document.getElementById('defaultIcon');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.style.backgroundImage = `url(${e.target.result})`;
                    preview.classList.remove('hidden');
                    defaultIcon.classList.add('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Afficher/masquer le mot de passe
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
        
        // Vérification de force du mot de passe
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strength-indicator');
        const strengthText = document.getElementById('strength-text');
        const lengthCheck = document.getElementById('length-check');
        const uppercaseCheck = document.getElementById('uppercase-check');
        const lowercaseCheck = document.getElementById('lowercase-check');
        const numberCheck = document.getElementById('number-check');
        const specialCheck = document.getElementById('special-check');
        const matchMessage = document.getElementById('match-message');
        
        passwordInput.addEventListener('input', checkPasswordStrength);
        confirmInput.addEventListener('input', checkPasswordMatch);
        
        function checkPasswordStrength() {
            const password = passwordInput.value;
            let strength = 0;
            let checks = 0;
            
            // Longueur
            if (password.length >= 8) {
                strength += 20;
                checks++;
                updateCheckmark(lengthCheck, true);
            } else {
                updateCheckmark(lengthCheck, false);
            }
            
            // Majuscule
            if (/[A-Z]/.test(password)) {
                strength += 20;
                checks++;
                updateCheckmark(uppercaseCheck, true);
            } else {
                updateCheckmark(uppercaseCheck, false);
            }
            
            // Minuscule
            if (/[a-z]/.test(password)) {
                strength += 20;
                checks++;
                updateCheckmark(lowercaseCheck, true);
            } else {
                updateCheckmark(lowercaseCheck, false);
            }
            
            // Chiffre
            if (/[0-9]/.test(password)) {
                strength += 20;
                checks++;
                updateCheckmark(numberCheck, true);
            } else {
                updateCheckmark(numberCheck, false);
            }
            
            // Caractère spécial
            if (/[^A-Za-z0-9]/.test(password)) {
                strength += 20;
                checks++;
                updateCheckmark(specialCheck, true);
            } else {
                updateCheckmark(specialCheck, false);
            }
            
            // Mise à jour de l'indicateur
            strengthBar.style.width = `${strength}%`;
            
            // Mise à jour du texte
            if (strength <= 20) {
                strengthText.textContent = 'Très faible';
                strengthBar.style.backgroundColor = '#ef4444';
            } else if (strength <= 40) {
                strengthText.textContent = 'Faible';
                strengthBar.style.backgroundColor = '#f97316';
            } else if (strength <= 60) {
                strengthText.textContent = 'Moyen';
                strengthBar.style.backgroundColor = '#eab308';
            } else if (strength <= 80) {
                strengthText.textContent = 'Fort';
                strengthBar.style.backgroundColor = '#22c55e';
            } else {
                strengthText.textContent = 'Très fort';
                strengthBar.style.backgroundColor = '#16a34a';
            }
        }
        
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (password && confirm) {
                if (password === confirm) {
                    matchMessage.textContent = 'Les mots de passe correspondent';
                    matchMessage.classList.remove('hidden', 'text-red-600');
                    matchMessage.classList.add('text-green-600');
                } else {
                    matchMessage.textContent = 'Les mots de passe ne correspondent pas';
                    matchMessage.classList.remove('hidden', 'text-green-600');
                    matchMessage.classList.add('text-red-600');
                }
            } else {
                matchMessage.classList.add('hidden');
            }
        }
        
        function updateCheckmark(element, isValid) {
            const svg = element.querySelector('svg');
            if (isValid) {
                svg.classList.remove('text-gray-400');
                svg.classList.add('text-green-500');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            } else {
                svg.classList.remove('text-green-500');
                svg.classList.add('text-gray-400');
                svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />';
            }
        }
    </script>
</x-guest-layout>
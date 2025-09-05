@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white">
    <div class="container-nike py-12">
        
        <!-- Header - Style Nike -->
        <div class="text-center mb-16">
            <h1 class="nike-title mb-4">MON PROFIL</h1>
            <p class="nike-text text-gray-600">Gérez vos informations personnelles et vos préférences</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Navigation du profil -->
            <div class="lg:col-span-1">
                <div class="card-nike">
                    <h2 class="nike-heading mb-6">Navigation</h2>
                    <nav class="space-y-2">
                        <a href="#profile" class="block px-4 py-3 text-black hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-user mr-3"></i>
                            Informations personnelles
                        </a>
                        <a href="#security" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-black rounded-lg transition-colors">
                            <i class="fas fa-shield-alt mr-3"></i>
                            Sécurité
                        </a>
                        <a href="#preferences" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-black rounded-lg transition-colors">
                            <i class="fas fa-cog mr-3"></i>
                            Préférences
                        </a>
                        <a href="#notifications" class="block px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-black rounded-lg transition-colors">
                            <i class="fas fa-bell mr-3"></i>
                            Notifications
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                
                <!-- Informations personnelles -->
                <div id="profile" class="card-nike mb-8">
                    <h2 class="nike-heading mb-6">Informations personnelles</h2>
                    
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="label-nike mb-2">Prénom</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" 
                                       class="input-nike @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="label-nike mb-2">Nom</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" 
                                       class="input-nike @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                   class="input-nike @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Téléphone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                   class="input-nike @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Adresse</label>
                            <textarea name="address" rows="3" class="input-nike @error('address') border-red-500 @enderror">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="label-nike mb-2">Ville</label>
                                <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                                       class="input-nike @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="label-nike mb-2">Code postal</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" 
                                       class="input-nike @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="label-nike mb-2">Pays</label>
                                <select name="country" class="input-nike @error('country') border-red-500 @enderror">
                                    <option value="">Sélectionner un pays</option>
                                    <option value="France" {{ old('country', $user->country) == 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Belgique" {{ old('country', $user->country) == 'Belgique' ? 'selected' : '' }}>Belgique</option>
                                    <option value="Suisse" {{ old('country', $user->country) == 'Suisse' ? 'selected' : '' }}>Suisse</option>
                                    <option value="Canada" {{ old('country', $user->country) == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Autre" {{ old('country', $user->country) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="btn-nike">
                                <i class="fas fa-save mr-2"></i>
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Sécurité -->
                <div id="security" class="card-nike mb-8">
                    <h2 class="nike-heading mb-6">Sécurité</h2>
                    
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')
                        
                        <div>
                            <label class="label-nike mb-2">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="input-nike @error('current_password') border-red-500 @enderror">
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Nouveau mot de passe</label>
                            <input type="password" name="password" class="input-nike @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" class="input-nike">
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="btn-nike">
                                <i class="fas fa-key mr-2"></i>
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Préférences -->
                <div id="preferences" class="card-nike mb-8">
                    <h2 class="nike-heading mb-6">Préférences</h2>
                    
                    <form method="post" action="{{ route('profile.preferences') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="label-nike mb-2">Devise préférée</label>
                            <select name="currency" class="input-nike">
                                <option value="XOF" {{ old('currency', $user->currency ?? 'XOF') == 'XOF' ? 'selected' : '' }}>FCFA (XOF)</option>
                                <option value="EUR" {{ old('currency', $user->currency ?? 'XOF') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                <option value="USD" {{ old('currency', $user->currency ?? 'XOF') == 'USD' ? 'selected' : '' }}>Dollar US (USD)</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="label-nike mb-2">Langue préférée</label>
                            <select name="language" class="input-nike">
                                <option value="fr" {{ old('language', $user->language ?? 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ old('language', $user->language ?? 'fr') == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center">
                            <input type="checkbox" name="newsletter" id="newsletter" 
                                   {{ old('newsletter', $user->newsletter ?? false) ? 'checked' : '' }}
                                   class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                            <label for="newsletter" class="ml-2 text-gray-700">
                                Recevoir la newsletter
                            </label>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="btn-nike">
                                <i class="fas fa-save mr-2"></i>
                                Sauvegarder les préférences
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Notifications -->
                <div id="notifications" class="card-nike">
                    <h2 class="nike-heading mb-6">Notifications</h2>
                    
                    <form method="post" action="{{ route('profile.notifications') }}" class="space-y-6">
                        @csrf
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-black">Commandes</h4>
                                    <p class="text-sm text-gray-600">Recevoir des notifications sur l'état de vos commandes</p>
                                </div>
                                <input type="checkbox" name="notifications[orders]" value="1" 
                                       {{ old('notifications.orders', $user->notifications['orders'] ?? true) ? 'checked' : '' }}
                                       class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-black">Promotions</h4>
                                    <p class="text-sm text-gray-600">Recevoir des notifications sur les offres spéciales</p>
                                </div>
                                <input type="checkbox" name="notifications[promotions]" value="1" 
                                       {{ old('notifications.promotions', $user->notifications['promotions'] ?? true) ? 'checked' : '' }}
                                       class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-black">Nouveautés</h4>
                                    <p class="text-sm text-gray-600">Recevoir des notifications sur les nouveaux produits</p>
                                </div>
                                <input type="checkbox" name="notifications[news]" value="1" 
                                       {{ old('notifications.news', $user->notifications['news'] ?? false) ? 'checked' : '' }}
                                       class="w-4 h-4 text-black border-gray-300 rounded focus:ring-black">
                </div>
            </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-nike">
                                <i class="fas fa-save mr-2"></i>
                                Sauvegarder les notifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Navigation fluide vers les sections
document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Mise à jour de la navigation active
function updateActiveNav() {
    const sections = document.querySelectorAll('[id]');
    const navLinks = document.querySelectorAll('nav a[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (window.pageYOffset >= sectionTop - 200) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('text-black', 'bg-gray-50');
        link.classList.add('text-gray-600');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.remove('text-gray-600');
            link.classList.add('text-black', 'bg-gray-50');
        }
    });
}

window.addEventListener('scroll', updateActiveNav);
updateActiveNav();
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen py-6">
    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-12">
            <h1 class="text-5xl font-serif text-gray-800 mb-4 bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                PRODUITS DE BEAUTÉ
            </h1>
            <p class="text-gray-600 text-lg">Découvrez nos collections exclusives</p>
        </div>

        <!-- Boutons et navigation -->
        <div class="flex justify-between items-center mb-8">
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-4 py-2 rounded-lg hover:from-gray-700 hover:to-gray-800 transition-all duration-300 flex items-center shadow-lg text-sm transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour au Dashboard
            </a>
            
            @if(auth()->user()->isAdmin())
            <div class="text-right">
                <span class="text-sm text-gray-600 block mb-1">{{ $categories->count() }} catégorie(s) au total</span>
                <a href="#add-category" onclick="document.getElementById('add-category').scrollIntoView({behavior: 'smooth'})" 
                   class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                    + Nouvelle Catégorie
                </a>
            </div>
            @endif
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-md animate-fade-in" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md" role="alert">
                <div class="flex items-center mb-2">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Erreurs détectées :</span>
                </div>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire d'ajout -->
        @if(auth()->user()->isAdmin())
        <div id="add-category" class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-xl mb-12 border border-white/20">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-pink-500 to-purple-600 p-3 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h2 class="text-3xl font-serif text-gray-800">Ajouter une nouvelle catégorie</h2>
            </div>
            
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom de la catégorie *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-pink-500 focus:ring-0 transition-colors duration-300 @error('name') border-red-500 @enderror" 
                               placeholder="Ex: Soins du visage" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="image_path" class="block text-sm font-semibold text-gray-700 mb-2">Image de la catégorie</label>
                        <div class="relative">
                            <input type="file" name="image_path" id="image_path" accept="image/*"
                                   class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-pink-500 focus:ring-0 transition-colors duration-300 @error('image_path') border-red-500 @enderror">
                            <small class="text-gray-500 text-xs">Formats acceptés: JPG, PNG, GIF (max 2MB)</small>
                        </div>
                        @error('image_path')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-pink-500 focus:ring-0 transition-colors duration-300 @error('description') border-red-500 @enderror"
                              placeholder="Décrivez cette catégorie de produits...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-4">
                    <button type="reset" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-300">
                        Réinitialiser
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg transform hover:scale-105 font-semibold">
                        Créer la catégorie
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Liste des catégories -->
        @if($categories->count())
            <div class="mb-6">
                <h3 class="text-2xl font-serif text-gray-800 mb-2">Nos Catégories</h3>
                <div class="h-1 w-20 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($categories as $category)
                    <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-white/20 transform hover:scale-105" 
                         id="category-{{ $category->id }}">
                        
                        <!-- Image de la catégorie -->
                        <div class="relative h-48 overflow-hidden">
                            @if($category->image_path && file_exists(public_path($category->image_path)))
                                <img src="{{ asset($category->image_path) }}" 
                                     alt="{{ $category->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-pink-100 to-purple-100 flex items-center justify-center">
                                    <div class="text-center text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-sm font-medium">Aucune image</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Badge nombre de produits -->
                            @if(isset($category->products_count))
                            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-semibold text-gray-700">
                                {{ $category->products_count }} produit{{ $category->products_count > 1 ? 's' : '' }}
                            </div>
                            @endif
                        </div>

                        <!-- Contenu -->
                        <div class="p-6">
                            <h3 class="text-xl font-serif text-gray-800 mb-3 text-center border-b border-gray-200 pb-2">
                                {{ $category->name }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm text-center leading-relaxed mb-4">
                                {{ $category->description ?? 'Collection de produits de beauté de luxe' }}
                            </p>

                            <!-- Actions Admin -->
                            @if(auth()->user()->isAdmin())
                            <div class="flex justify-center space-x-3 pt-4 border-t border-gray-100">
                                <a href="{{ route('categories.show', $category->id) }}" 
                                   class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 text-sm font-medium shadow-md transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Voir
                                </a>
                                
                                <a href="{{ route('categories.edit', $category->id) }}" 
                                   class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-4 py-2 rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-all duration-300 text-sm font-medium shadow-md transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Modifier
                                </a>
                                
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer la catégorie « {{ $category->name }} » ?\n\nCette action est irréversible et supprimera tous les produits associés.')" 
                                            class="bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 text-sm font-medium shadow-md transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                                <button onclick="document.getElementById('quick-add-product-{{ $category->id }}').classList.toggle('hidden')" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 text-sm font-medium shadow-md transform hover:scale-105">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Ajouter un produit
                                </button>
                            </div>
                            <!-- Formulaire d'ajout rapide de produit -->
                            <form id="quick-add-product-{{ $category->id }}" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <input type="text" name="name" placeholder="Nom du produit" class="w-full px-3 py-2 rounded border border-gray-300" required>
                                    </div>
                                    <div>
                                        <input type="number" name="price" step="0.01" placeholder="Prix" class="w-full px-3 py-2 rounded border border-gray-300" required>
                                    </div>
                                    <div>
                                        <select name="currency" class="w-full px-3 py-2 rounded border border-gray-300" required>
                                            <option value="EUR">Euro (€)</option>
                                            <option value="USD">Dollar ($)</option>
                                            <option value="XOF">Franc CFA (XOF)</option>
                                            <option value="GBP">Livre (£)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <input type="number" name="quantity" min="0" placeholder="Quantité" class="w-full px-3 py-2 rounded border border-gray-300" required>
                                    </div>
                                    <div class="md:col-span-2">
                                        <input type="text" name="description" placeholder="Description" class="w-full px-3 py-2 rounded border border-gray-300">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Image (fichier)</label>
                                        <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 rounded border border-gray-300">
                                    </div>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all">Ajouter</button>
                                    <button type="button" onclick="document.getElementById('quick-add-product-{{ $category->id }}').classList.add('hidden')" class="ml-2 px-4 py-2 rounded border border-gray-400 text-gray-700 hover:bg-gray-100">Annuler</button>
                                </div>
                            </form>
                            @else
                            <!-- Bouton Voir pour les non-admins -->
                            <div class="text-center pt-4 border-t border-gray-100">
                                <a href="{{ route('categories.show', $category->id) }}" 
                                   class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 font-medium shadow-md transform hover:scale-105">
                                    Découvrir cette collection
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- État vide -->
            <div class="text-center py-20">
                <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-12 shadow-lg max-w-md mx-auto">
                    <div class="text-gray-400 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif text-gray-700 mb-4">Aucune catégorie trouvée</h3>
                    <p class="text-gray-500 mb-8">Commencez par créer votre première catégorie de produits</p>
                    
                    @if(auth()->user()->isAdmin())
                    <a href="#add-category" onclick="document.getElementById('add-category').scrollIntoView({behavior: 'smooth'})" 
                       class="inline-block bg-gradient-to-r from-pink-500 to-purple-600 text-white px-8 py-3 font-serif rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg transform hover:scale-105">
                        Créer ma première catégorie
                    </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}

/* Animations au scroll */
[id^="category-"] {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[id^="category-"].animate-in {
    opacity: 1;
    transform: translateY(0);
}

/* Effet de focus sur les inputs */
input:focus, textarea:focus {
    box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
}

/* Scrollbar styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #ec4899, #8b5cf6);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #db2777, #7c3aed);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'apparition des catégories
    const categoryItems = document.querySelectorAll('[id^="category-"]');
    
    if (categoryItems.length > 0) {
        // Intersection Observer pour les animations au scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        categoryItems.forEach((item, index) => {
            // Animation initiale avec délai
            setTimeout(() => {
                item.style.opacity = "1";
                item.style.transform = "translateY(0)";
                observer.observe(item);
            }, 100 * index);
        });
    }

    // Preview d'image lors de l'upload
    const imageInput = document.getElementById('image_path');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Créer ou mettre à jour la preview (optionnel)
                    let preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'image-preview';
                        preview.className = 'mt-2 max-w-xs h-32 object-cover rounded-lg border-2 border-gray-200';
                        imageInput.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
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

    // Auto-hide success messages
    const successAlert = document.querySelector('.bg-green-100');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease-out';
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.remove();
            }, 500);
        }, 5000);
    }
});
</script>
@endsection
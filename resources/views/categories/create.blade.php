 @extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-8 relative">
        <span class="relative inline-block after:content-[''] after:absolute after:w-1/2 after:h-1 after:bg-blue-500 after:bottom-0 after:left-1/4">
            Ajouter une Catégorie
        </span>
    </h1>
    
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition-colors flex items-center w-fit">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg transform transition-all duration-300 hover:shadow-2xl">
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm" class="space-y-6">
            @csrf
            
            <!-- Vendeur (admin uniquement) -->
            @if(isset($vendeurs))
            <div>
                <label class="block font-semibold text-gray-700">Vendeur</label>
                <select name="seller_id" class="w-full mt-1 p-2 border rounded" required>
                    <option value="">-- Sélectionner un vendeur --</option>
                    @foreach($vendeurs as $vendeur)
                        <option value="{{ $vendeur->id }}">{{ $vendeur->name }} ({{ $vendeur->email }})</option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Nom de la catégorie -->
            <div class="group">
                <label class="block text-gray-700 font-medium mb-2 transition-all group-focus-within:text-blue-600">
                    Nom de la catégorie <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="name" required value="{{ old('name') }}"
                        class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        placeholder="Entrez le nom de la catégorie">
                    <div class="absolute right-3 top-3 opacity-0 group-focus-within:opacity-100 transition-opacity text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Description (optionnelle) -->
            <div class="group" id="descriptionGroup" style="display: none;">
                <label class="block text-gray-700 font-medium mb-2 transition-all group-focus-within:text-blue-600">
                    Description (optionnelle)
                </label>
                <div class="relative">
                    <textarea name="description" 
                        class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all h-24"
                        placeholder="Décrivez cette catégorie">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Image (optionnelle) -->
            <div class="group" id="imageGroup" style="display: none;">
                <label class="block text-gray-700 font-medium mb-2 transition-all group-focus-within:text-blue-600">
                    Image (optionnelle)
                </label>
                <div class="relative">
                    <input type="file" name="image" accept="image/*"
                        class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <small class="text-gray-500">Formats acceptés: JPEG, PNG, JPG, GIF. Taille max: 2MB</small>
                </div>
            </div>

            <!-- Options d'ajout -->
            <div class="flex flex-col space-y-2 pt-2">
                <button type="button" id="toggleDescriptionBtn" class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter une description
                </button>
                
                <button type="button" id="toggleImageBtn" class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center w-fit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Ajouter une image
                </button>
            </div>

            <!-- Bouton Ajouter -->
            <div class="pt-4">
                <button type="submit" id="submitBtn"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajouter la catégorie</span>
                </button>
            </div>
        </form>

        <!-- Liste des catégories existantes -->
        <div class="mt-10 pt-6 border-t border-gray-200">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                Catégories existantes
            </h2>
            <div class="max-h-64 overflow-y-auto pr-2" id="categoriesList">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-lg mb-2 group transition-all">
                            <div class="flex items-center">
                                @if($category->image_path)
                                    <img src="{{ $category->image_path }}" alt="{{ $category->name }}" class="w-8 h-8 object-cover rounded mr-3">
                                @endif
                                <div>
                                    <span class="font-medium text-gray-700">{{ $category->name }}</span>
                                    @if($category->description)
                                        <p class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 py-4">Aucune catégorie trouvée</div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle description field
        const toggleDescriptionBtn = document.getElementById('toggleDescriptionBtn');
        const descriptionGroup = document.getElementById('descriptionGroup');
        
        toggleDescriptionBtn.addEventListener('click', function() {
            if (descriptionGroup.style.display === 'none') {
                descriptionGroup.style.display = 'block';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    Masquer la description
                `;
            } else {
                descriptionGroup.style.display = 'none';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Ajouter une description
                `;
            }
        });

        // Toggle image field
        const toggleImageBtn = document.getElementById('toggleImageBtn');
        const imageGroup = document.getElementById('imageGroup');
        
        toggleImageBtn.addEventListener('click', function() {
            if (imageGroup.style.display === 'none') {
                imageGroup.style.display = 'block';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    Masquer l'image
                `;
            } else {
                imageGroup.style.display = 'none';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Ajouter une image
                `;
            }
        });
        
        // Form animation effect
        const formInputs = document.querySelectorAll('input, textarea');
        
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.parentElement.classList.add('scale-105');
                this.parentElement.parentElement.style.transition = 'transform 0.3s';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.parentElement.classList.remove('scale-105');
            });
        });
    });
</script>
@endsection
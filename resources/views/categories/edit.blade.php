{{-- resources/views/categories/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        {{-- En-tête --}}
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Retour aux catégories
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">
                Modifier la catégorie
            </h1>
            <p class="text-gray-600 mt-2">
                Catégorie actuelle : <span class="font-semibold text-blue-600">{{ $category->name }}</span>
            </p>
        </div>

        {{-- Formulaire --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Champ nom --}}
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nom de la catégorie
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                           placeholder="Entrez le nom de la catégorie">
                    
                    {{-- Erreur de validation --}}
                    @error('name')
                        <p class="text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Aperçu --}}
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-400">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Aperçu</h3>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <span id="preview-name">{{ $category->name }}</span>
                        </span>
                    </div>
                </div>

                {{-- Boutons d'action --}}
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <div class="flex gap-3">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Enregistrer les modifications
                        </button>

                        <a href="{{ route('categories.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                            Annuler
                        </a>
                    </div>

                    {{-- Bouton supprimer --}}
                    <form action="{{ route('categories.destroy', $category->id) }}" 
                          method="POST" 
                          class="inline-block"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 font-medium rounded-lg hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </form>
        </div>

        {{-- Informations supplémentaires --}}
        <div class="mt-6 text-sm text-gray-500">
            <p>
                <strong>Créée le :</strong> {{ $category->created_at->format('d/m/Y à H:i') }}
            </p>
            @if($category->updated_at != $category->created_at)
                <p>
                    <strong>Dernière modification :</strong> {{ $category->updated_at->format('d/m/Y à H:i') }}
                </p>
            @endif
        </div>
    </div>
</div>

{{-- JavaScript pour l'aperçu en temps réel --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const previewName = document.getElementById('preview-name');
    
    nameInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewName.textContent = value || '{{ $category->name }}';
    });
});
</script>

<style>
/* Animations personnalisées */
.container {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Focus states améliorés */
input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

button:focus {
    outline: none;
}

/* Hover effects */
.hover-lift:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
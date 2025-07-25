@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8 relative">
        <span class="relative inline-block after:content-[''] after:absolute after:w-1/2 after:h-1 after:bg-blue-500 after:bottom-0 after:left-1/4">
            Add Product
        </span>
    </h1>

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-lg transform transition-all duration-300 hover:shadow-2xl">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label class="block font-semibold text-gray-700">Nom du produit</label>
                <input type="text" name="name" class="w-full mt-1 p-2 border rounded" required>
            </div>

            <!-- Price -->
            <div>
                <label class="block font-semibold text-gray-700">Prix</label>
                <input type="number" step="0.01" name="price" class="w-full mt-1 p-2 border rounded" required>
            </div>
<!-- Currency -->
<div>
    <label for="currency" class="block text-sm font-medium text-gray-700">Devise</label>
    <select name="currency" id="currency" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        <option value="EUR">Euro (€)</option>
        <option value="USD">Dollar ($)</option>
        <option value="XOF">Franc CFA (XOF)</option>
        <option value="GBP">Livre (£)</option>
    </select>
</div>
<!-- Quantité -->
<div class="mb-6">
    <label for="quantity" class="block text-gray-300 text-sm font-semibold mb-2">QUANTITÉ EN STOCK</label>
    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" min="0"
           class="w-full px-4 py-2 rounded bg-gray-800 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

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

            <!-- Catégorie -->
            <div>
                <label class="block font-semibold text-gray-700">Catégorie</label>
                <select name="category_id" class="w-full mt-1 p-2 border rounded" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type d'image -->
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Type d'image</label>
                <div class="flex items-center space-x-4">
                    <label>
                        <input type="radio" name="image_type" value="upload" checked onchange="toggleImageField()"> Télécharger
                    </label>
                    <label>
                        <input type="radio" name="image_type" value="url" onchange="toggleImageField()"> Lien URL
                    </label>
                </div>
            </div>

            <!-- Image upload -->
            <div id="uploadField">
                <label class="block font-semibold text-gray-700 mt-4">Image (fichier)</label>
                <input type="file" name="image" accept="image/*" class="w-full p-2 border rounded">
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image URL -->
            <div id="urlField" class="hidden">
                <label class="block font-semibold text-gray-700 mt-4">Image (lien)</label>
                <input type="url" name="image_url" class="w-full p-2 border rounded" placeholder="https://example.com/image.jpg">
                @error('image_url')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block font-semibold text-gray-700">Description</label>
                <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded"></textarea>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition-all">
                    Ajouter le produit
                </button>
            </div>
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </form>
    </div>
</div>

<script>
    function toggleImageField() {
        const upload = document.getElementById('uploadField');
        const url = document.getElementById('urlField');
        const imageType = document.querySelector('input[name="image_type"]:checked').value;

        if (imageType === 'upload') {
            upload.classList.remove('hidden');
            url.classList.add('hidden');
        } else {
            upload.classList.add('hidden');
            url.classList.remove('hidden');
        }
    }
</script>
@endsection

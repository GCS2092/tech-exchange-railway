@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white text-center mb-8">EDIT PRODUCT</h1>

    <div class="max-w-2xl mx-auto bg-gray-900 bg-opacity-80 rounded-lg p-8 shadow-lg backdrop-blur-sm">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-300 text-sm font-semibold mb-2">PRODUCT NAME</label>
                <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none" required>
                </div>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-gray-300 text-sm font-semibold mb-2">DESCRIPTION</label>
                <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
                    <textarea name="description" id="description" rows="3" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none">{{ old('description', $product->description) }}</textarea>
                </div>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Price -->
            <div class="mb-6">
                <label for="price" class="block text-gray-300 text-sm font-semibold mb-2">PRICE</label>
                <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
                    <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price) }}" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none" required>
                </div>
                @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Currency -->
            <div class="mb-6">
                <label for="currency" class="block text-gray-300 text-sm font-semibold mb-2">CURRENCY</label>
                <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
                    <select name="currency" id="currency"
                            class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none appearance-none">
                        <option value="€" {{ $product->currency == '€' ? 'selected' : '' }}>€ - Euro</option>
                        <option value="$" {{ $product->currency == '$' ? 'selected' : '' }}>$ - Dollar</option>
                        <option value="CFA" {{ $product->currency == 'CFA' ? 'selected' : '' }}>CFA</option>
                    </select>
                </div>
                @error('currency')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            
<!-- Stock Quantity -->
<div class="mb-6">
    <label for="quantity" class="block text-gray-300 text-sm font-semibold mb-2">STOCK QUANTITY</label>
    <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" 
            class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none" required>
    </div>
    @error('quantity')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
            <!-- Image Upload or URL -->
            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-semibold mb-2">PRODUCT IMAGE</label>
                
                <!-- Option Tabs -->
                <div class="flex mb-4">
                    <button type="button" id="btn-upload" class="flex-1 py-2 px-4 rounded-tl-md rounded-tr-md bg-gray-700 text-gray-300 focus:outline-none image-option-btn active">
                        Upload Image
                    </button>
                    <button type="button" id="btn-link" class="flex-1 py-2 px-4 rounded-tl-md rounded-tr-md bg-gray-800 text-gray-400 focus:outline-none image-option-btn">
                        Provide URL Link
                    </button>
                </div>
                
                <!-- Current Image Preview -->
                @if($product->image && Str::startsWith($product->image, ['http://', 'https://']))
                    <div class="mb-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-24 rounded-md mb-2">
                        <p class="text-sm text-gray-400">Current image (external URL)</p>
                    </div>
                @elseif($product->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 rounded-md mb-2">
                        <p class="text-sm text-gray-400">Current image (local storage)</p>
                    </div>
                @endif
                
                <!-- Upload Option -->
                <div id="upload-option" class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300 mb-2">
                    <input type="file" name="image" id="image" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none">
                </div>
                <p id="upload-help" class="text-gray-400 text-xs mt-1 mb-4">Accepted formats: JPG, PNG, GIF (max 2MB)</p>
                
                <!-- URL Option (Hidden by Default) -->
                <div id="link-option" class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300 mb-2 hidden">
                    <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $product->image && Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : '') }}" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none"
                        placeholder="https://example.com/image.jpg">
                </div>
                <p id="link-help" class="text-gray-400 text-xs mt-1 mb-4 hidden">Enter the full URL of the external image</p>
                
                <!-- Hidden field to track which option is active -->
                <input type="hidden" name="image_source" id="image_source" value="upload">
                
                @error('image')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @error('image_url')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category (if categories exist in your system) -->
            @if(isset($categories))
            <div class="mb-6">
                <label for="category_id" class="block text-gray-300 text-sm font-semibold mb-2">CATEGORY</label>
                <div class="relative border border-gray-700 rounded-md focus-within:border-gray-500 transition-all duration-300">
                    <select name="category_id" id="category_id" 
                        class="w-full bg-gray-800 bg-opacity-50 text-white p-3 rounded-md focus:outline-none appearance-none">
                        <option value="">NONE</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('category_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif

            <!-- Submit Button -->
            <div>
                <button type="submit" id="submitBtn" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-3 px-6 rounded-md font-bold tracking-wide 
                    hover:from-blue-700 hover:to-indigo-800 transform hover:-translate-y-0.5 hover:shadow-lg 
                    transition-all duration-300 ease-in-out focus:outline-none">
                    Update Product
                </button>
            </div>
        </form>
    </div> 
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image option toggling
        const btnUpload = document.getElementById('btn-upload');
        const btnLink = document.getElementById('btn-link');
        const uploadOption = document.getElementById('upload-option');
        const linkOption = document.getElementById('link-option');
        const uploadHelp = document.getElementById('upload-help');
        const linkHelp = document.getElementById('link-help');
        const imageSource = document.getElementById('image_source');
        
        // Toggle between upload and link options
        btnUpload.addEventListener('click', function() {
            btnUpload.classList.add('bg-gray-700', 'text-gray-300');
            btnUpload.classList.remove('bg-gray-800', 'text-gray-400');
            btnLink.classList.add('bg-gray-800', 'text-gray-400');
            btnLink.classList.remove('bg-gray-700', 'text-gray-300');
            
            uploadOption.classList.remove('hidden');
            uploadHelp.classList.remove('hidden');
            linkOption.classList.add('hidden');
            linkHelp.classList.add('hidden');
            
            imageSource.value = 'upload';
        });
        
        btnLink.addEventListener('click', function() {
            btnLink.classList.add('bg-gray-700', 'text-gray-300');
            btnLink.classList.remove('bg-gray-800', 'text-gray-400');
            btnUpload.classList.add('bg-gray-800', 'text-gray-400');
            btnUpload.classList.remove('bg-gray-700', 'text-gray-300');
            
            linkOption.classList.remove('hidden');
            linkHelp.classList.remove('hidden');
            uploadOption.classList.add('hidden');
            uploadHelp.classList.add('hidden');
            
            imageSource.value = 'url';
        });
        
        // Initialize based on existing data
        if ('{{ old('image_source', $product->image && Str::startsWith($product->image, ['http://', 'https://']) ? 'url' : 'upload') }}' === 'url') {
            btnLink.click();
        }
        
        // Form field interactions
        const formFields = document.querySelectorAll('input, textarea, select');
        
        formFields.forEach(field => {
            // Add active class to parent on focus
            field.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
            
            field.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            });
        });
        
        // Submit button animation
        const submitBtn = document.getElementById('submitBtn');
        
        // Submit animation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            submitBtn.innerHTML = 'PROCESSING...';
            submitBtn.classList.add('opacity-80');
        });
    });
</script>
@endsection
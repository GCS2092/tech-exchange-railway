@foreach($products as $product)
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-bold">{{ $product->name }}</h3>
        <p class="text-gray-600">{{ $product->description }}</p>
        @php $currentCurrency = session('currency', 'XOF'); @endphp
        <p class="text-pink-600 font-semibold">{{ \App\Helpers\CurrencyHelper::format($product->price, $currentCurrency) }}</p>
        @if($product->is_active)
            <span class="text-green-500 text-sm font-medium">Disponible</span>
        @else
            <span class="text-red-500 text-sm font-medium">Rupture de stock</span>
        @endif
    </div>
@endforeach

// Exemple dans dashboard.blade.php (Tableau de bord utilisateur)
@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

@foreach ($orders as $order)
    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
        <h2 class="text-lg font-bold">Commande #{{ $order->id }}</h2>
        <p>Total : {{ number_format($order->total_price, 2) }} €</p>
        <p>Statut : {{ ucfirst($order->status) }}</p>
    </div>
@endforeach

@php $currentCurrency = session('currency', 'XOF'); @endphp

<td>
    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-8 h-8 object-contain inline-block mr-2">
    {{ $product->name }}
</td>
<td>{{ \App\Helpers\CurrencyHelper::format($product->price, $currentCurrency) }}</td>

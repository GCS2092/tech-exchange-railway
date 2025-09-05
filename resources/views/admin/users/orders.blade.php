@foreach($orders as $order)
<tr class="border-t border-gray-200">
    <td class="py-2 px-4 text-sm text-gray-700">{{ $order->id }}</td>
    <td class="py-2 px-4 text-sm text-gray-700">{{ $order->user->name }}</td>
                            <td class="py-2 px-4 text-sm text-gray-700">{{ number_format($order->total_price, 2) }} FCFA</td>
    <td class="py-2 px-4 text-sm text-gray-700">
        <span class="inline-block px-3 py-1 rounded-full text-xs
            @if($order->status == 'en attente') bg-yellow-200 text-yellow-800
            @elseif($order->status == 'confirmé') bg-green-200 text-green-800
            @elseif($order->status == 'expédié') bg-blue-200 text-blue-800
            @endif">
            {{ ucfirst($order->status) }}
        </span>
    </td>
    <td class="py-2 px-4 text-sm">
        @if(Auth::user()->hasRole('admin'))
            <!-- Admin: mettre à jour le statut de la commande -->
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="form-select">
                    <option value="en attente" {{ $order->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmé" {{ $order->status == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                    <option value="expédié" {{ $order->status == 'expédié' ? 'selected' : '' }}>Expédié</option>
                </select>
                <button type="submit" class="bg-yellow-500 text-white">Mettre à jour le statut</button>
            </form>
        @else
            <!-- Utilisateur: voir les détails de la commande -->
            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800">Voir les détails</a>
        @endif
    </td>
</tr>
@endforeach

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Historique d'utilisation du code promo : {{ $promo->code }}</h1>

    <table class="table-auto w-full bg-white shadow-md rounded border">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-2">#</th>
                <th class="px-4 py-2">Commande</th>
                <th class="px-4 py-2">Utilisateur</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Montant Initial</th>
                <th class="px-4 py-2">Remise</th>
                <th class="px-4 py-2">Montant Final</th>
                <th class="px-4 py-2">Remise (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usages as $usage)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $usage['id'] }}</td>
                    <td class="px-4 py-2">#{{ $usage['order_id'] }}</td>
                    <td class="px-4 py-2">{{ $usage['user']['name'] }}</td>
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($usage['created_at'])->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">{{ number_format($usage['original_amount'], 2) }} XOF</td>
                    <td class="px-4 py-2 text-red-600">{{ number_format($usage['discount_amount'], 2) }} XOF</td>
                    <td class="px-4 py-2">
                        {{ isset($usage['final_amount']) ? number_format($usage['final_amount'], 2) : 'N/A' }} XOF
                    </td>
                    <td class="px-4 py-2 text-green-600">{{ $usage['discount_percent'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

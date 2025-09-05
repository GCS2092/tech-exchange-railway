@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport quotidien des transactions et commandes</title>
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f7fafc; color: #222; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #e2e8f0; padding: 32px; }
        h1 { color: #4f46e5; font-size: 2rem; margin-bottom: 1.5rem; }
        h2 { color: #6366f1; font-size: 1.2rem; margin-top: 2rem; margin-bottom: 0.5rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { padding: 8px 10px; border: 1px solid #e5e7eb; font-size: 0.95rem; }
        th { background: #f1f5f9; color: #374151; }
        tr:nth-child(even) { background: #f9fafb; }
        .total { font-weight: bold; color: #059669; }
    </style>
</head>
<body>
<div class="container">
    <h1>Rapport quotidien - {{ $date }}</h1>

    <h2>Transactions du jour ({{ count($transactions) }})</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Commande</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Méthode</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @forelse($transactions as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>#{{ $t->order_id }}</td>
                <td>{{ $t->user->name ?? '—' }}</td>
                <td>{{ number_format($t->amount, 0, ',', ' ') }} {{ $t->currency }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $t->payment_method)) }}</td>
                <td>{{ $t->status_label }}</td>
                <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="7" style="text-align:center;">Aucune transaction</td></tr>
        @endforelse
        </tbody>
    </table>

    <h2>Commandes du jour ({{ count($orders) }})</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $o)
            <tr>
                <td>#{{ $o->id }}</td>
                <td>{{ $o->user->name ?? '—' }}</td>
                <td>{{ number_format($o->total_price, 0, ',', ' ') }} FCFA</td>
                <td>{{ $o->status }}</td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center;">Aucune commande</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:2rem; color:#64748b; font-size:0.95rem;">
        Rapport généré automatiquement par le site {{ config('app.name') }}.
    </div>
</div>
</body>
</html> 
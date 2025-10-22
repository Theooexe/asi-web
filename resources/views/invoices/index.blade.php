<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des factures</title>
</head>
<body>
<h1>Liste des factures</h1>

<p>
    <a href="{{ route('invoices.index', ['order' => 'asc']) }}">Trier par montant croissant</a> |
    <a href="{{ route('invoices.index', ['order' => 'desc']) }}">Trier par montant décroissant</a>
</p>

@if($invoices->isEmpty())
    <p>Aucune facture trouvée.</p>
@else
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Montant hors taxe (€)</th>
            <th>Taxe (€)</th>
            <th>Montant total (€)</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->client_id ?? 'Non renseigné' }}</td>
                <td>{{ $invoice->amount_before_tax ?? '—' }}</td>
                <td>{{ $invoice->tax ?? '—' }}</td>
                <td>{{ $invoice->total_amount ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $invoices->links() }}
    </div>
@endif

</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $facture->id }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        h1, h2 { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <h1>Facture n°{{ $facture->id }}</h1>
    <p><strong>Date :</strong> {{ $facture->date_facture }}</p>
    <p><strong>Client :</strong> {{ $facture->user->name }}</p>

    <h2>Détails de la commande</h2>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($facture->commande->panier as $item)
                <tr>
                    <td>{{ $item->burger->nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->burger->prix, 2) }} FCFA</td>
                    <td>{{ number_format($item->quantite * $item->burger->prix, 2) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-align: right;">Montant total : {{ number_format($facture->montant_total, 2) }} FCFA</h3>
</body>
</html>
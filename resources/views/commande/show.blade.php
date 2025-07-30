@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Détails de la Commande #{{ $commande->id }}</h3>

    <p>statut : <strong>{{ ucfirst($commande->statut) }}</strong></p>
    <p>Montant : <strong>{{ $commande->facture->montant_total }} FCFA</strong></p>

    <h4>Produits :</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Burger</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->panier as $item)
                <tr>
                    <td>{{ $item->burger->nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ $item->burger->prix }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Formulaire pour changer le statut --}}
<form method="POST" action="{{ route('commandes.updatestatut', $commande->id) }}">
        @csrf
        @method('PUT')
        <select name="statut" class="form-select mb-2">
            <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="en_preparation" {{ $commande->statut == 'en_preparation' ? 'selected' : '' }}>En préparation</option>
            <option value="prete" {{ $commande->statut == 'prete' ? 'selected' : '' }}>Prete</option>
            <option value="payee" {{ $commande->statut == 'payee' ? 'selected' : '' }}>Payée</option>
        </select>
        <button class="btn btn-primary">Mettre à jour le statut</button>
    </form>

    {{-- Paiement --}}
    @if(is_null($commande->facture->date_paiement) && $commande->statut === 'Payee')
    <form method="POST" action="{{ route('commandes.payer', $commande->id) }}">
        @csrf
        @method('PUT')
        <button class="btn btn-success mt-2">Enregistrer le paiement en espèces</button>
    </form>
    @elseif($commande->facture->date_paiement)
        <p class="mt-2">Paiement effectué le : {{ $commande->facture->date_paiement }}</p>
    @endif

    {{-- Annulation --}}
    @if($commande->statut !== 'Annulée' && $commande->statut !== 'Payee')
        <form method="POST" action="{{ route('commandes.cancel', $commande->id) }}" class="mt-2">
            @csrf
            @method('PUT')
            <button class="btn btn-danger">Annuler la commande</button>
        </form>
    @endif
</div>
@endsection

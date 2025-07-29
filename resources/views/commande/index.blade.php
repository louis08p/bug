@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Liste des Commandes</h3>

    @foreach($commandes as $commande)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>Commande #{{ $commande->id }} - Client: {{ $commande->user->name }}</span>
                <span>Status: <strong>{{ ucfirst($commande->status) }}</strong></span>
            </div>
            <div class="card-body">
                <p>Montant: <strong>{{ $commande->facture->montant_total ?? 'Non défini' }} FCFA</strong></p>
                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-primary btn-sm">Voir détails</a>
            </div>
        </div>
    @endforeach
</div>
@endsection

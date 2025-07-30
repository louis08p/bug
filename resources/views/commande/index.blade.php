@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Liste des Commandes</h3>

    {{-- Messages de succès et d'erreur --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach($commandes as $commande)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <span>Commande #{{ $commande->id }} - Client: {{ $commande->user->name }}</span>
                <span>statut: <strong>{{ ucfirst($commande->statut) }}</strong></span>
            </div>
            <div class="card-body">
                <p>Montant: <strong>{{ $commande->facture->montant_total ?? 'Non défini' }} FCFA</strong></p>
                <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-primary btn-sm">Voir détails</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
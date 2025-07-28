@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Votre Panier</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($paniers->isEmpty())
        <p>Votre panier est vide.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Burger</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($paniers as $item)
                    <tr>
                        <td>{{ $item->burger->nom }}</td>
                        <td>{{ $item->quantite }}</td>
                        <td>{{ $item->burger->prix }} FCFA</td>
                        <td>
                            <form method="POST" action="{{ route('panier.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form method="POST" action="{{ route('panier.valider') }}">
            @csrf
            <button class="btn btn-success">Valider la commande</button>
        </form>
    @endif
</div>
@endsection

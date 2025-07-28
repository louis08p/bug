@extends('layouts.app')

@section('title', 'Statistiques des ventes')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📊 Statistiques des ventes</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Carte 1 : Nombre total de commandes -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Commandes totales</h5>
                    <p class="card-text display-4">{{ $totalCommandes }}</p>
                </div>
            </div>
        </div>

        <!-- Carte 2 : Total des ventes -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Total des ventes (FCFA)</h5>
                    <p class="card-text display-4">{{ number_format($totalMontant, 0, ',', ' ') }} F</p>
                </div>
            </div>
        </div>

        <!-- Carte 3 : Commandes du jour -->
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3 shadow">
                <div class="card-body">
                    <h5 class="card-title">Commandes aujourd'hui</h5>
                    <p class="card-text display-4">{{ $commandesJour }}</p>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Tableau récapitulatif -->
    <h4 class="mt-5">📅 Statistiques par jour</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Date</th>
                    <th>Nombre de commandes</th>
                    <th>Total des ventes (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statsParJour as $jour => $data)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($jour)->format('d/m/Y') }}</td>
                        <td>{{ $data['commandes'] }}</td>
                        <td>{{ number_format($data['montant'], 0, ',', ' ') }} F</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<style>
    .container-archived {
        max-width: 1000px;
        margin: 40px auto;
        background-color: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        font-family: 'Segoe UI', sans-serif;
    }

    .container-archived h2 {
        text-align: center;
        color: #7f8c8d;
        margin-bottom: 25px;
        font-weight: bold;
    }

    .table thead th {
        background-color: #f1c40f;
        color: #2c3e50;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .btn-retour {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .btn-retour:hover {
        background-color: #2980b9;
    }

    .archived-img {
        height: 50px;
        width: 50px;
        object-fit: cover;
        border-radius: 5px;
    }
</style>

{{-- resources/views/burger/archiveBurger.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2 class="text-warning">Burgers Archivés</h2>

    @if($burgers->isEmpty())
        <div class="alert alert-info">Aucun burger archivé.</div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-bordered table-hover align-middle text-center">
                <thead class="table-warning text-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($burgers as $b)
                        <tr>
                            <td>{{ $b->id }}</td>
                            <td>{{ $b->nom }}</td>
                            <td>{{ $b->prix }} FCFA</td>
                            <td><img src="{{ asset('storage/' . $b->image) }}" width="60"></td>
                            <td>{{ $b->description }}</td>
                            <td>{{ $b->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

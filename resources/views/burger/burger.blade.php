@extends('layouts.app')

@section('content')

<style>
    .table thead th {
        background-color: #f1c40f;
        color: #2c3e50;
        font-weight: bold;
    }

    .table tbody tr:hover {
        background-color: #2c3e50;
    }

    .btn-icon {
        padding: 5px 8px;
        font-size: 1.2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-primary {
        background-color: #2980b9;
        border: none;
    }

    .btn-primary:hover {
        background-color: #3498db;
    }

    .btn-danger {
        background-color: #c0392b;
        border: none;
    }

    .btn-danger:hover {
        background-color: #e74c3c;
    }

    .alert {
        font-size: 14px;
    }

    .img-thumbnail {
        width: 60px;
        height: auto;
        object-fit: cover;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center text-primary">🍔 Liste des Burgers</h2>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if(session('messageDelete'))
        <div class="alert alert-warning">{{ session('messageDelete') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('burgers.create') }}" class="btn btn-success">➕ Ajouter un Burger</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Prix</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($burgers as $burger)
            <tr>
                <td>{{ $burger->nom }}</td>
                <td>{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</td>
                <td>{{ $burger->description }}</td>
                <td>{{ $burger->stock }}</td>
                <td>
                    @if($burger->image)
                        <img src="{{ asset('storage/' . $burger->image) }}" alt="image" class="img-thumbnail">
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <!-- Icône Modifier -->
                    <a href="{{ route('burgers.edit', $burger->id) }}" class="btn btn-sm btn-primary btn-icon" title="Modifier">
                        ✏️
                    </a>

                    <!-- Bouton Archiver -->
                    <form action="{{ route('archiveBurger', $burger->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Archiver ce burger ?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Archiver">
                            🗑️
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Aucun burger disponible.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

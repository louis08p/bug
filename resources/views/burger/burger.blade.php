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

    .btn-warning {
        background-color: #f39c12;
        border: none;
    }

    .btn-warning:hover {
        background-color: #e67e22;
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
    }

    .card-body {
        text-align: center;
    }

    .btn-commander {
        background-color: #f39c12;
        border: none;
        color: #fff;
        font-weight: bold;
    }

    .btn-commander:hover {
        background-color: #e67e22;
    }

    .alert {
        font-size: 14px;
    }
</style>

{{-- resources/views/burger/burger.blade.php --}}
@extends('layouts.app')
@section('content')
<div class="container py-4">
    @if(Auth::check() && Auth::user()->role === 'gestionnaire')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-warning">Liste des Burgers</h2>
            <a href="{{ route('add') }}" class="btn btn-warning fw-bold text-dark">➕ Ajouter un Burger</a>
        </div>
    @endif

    @if(session('message'))<div class="alert alert-success">{{ session('message') }}</div>@endif
    @if(session('messageDelete'))<div class="alert alert-danger">{{ session('messageDelete') }}</div>@endif

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
                    @if(Auth::user()->role === 'gestionnaire')<th>Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @foreach($burgers as $b)
                    @if(!$b->archive)
                        <tr>
                            <td>{{ $b->id }}</td>
                            <td>{{ $b->nom }}</td>
                            <td>{{ $b->prix }} FCFA</td>
                            <td><img src="{{ asset('storage/' . $b->image) }}" width="60"></td>
                            <td>{{ $b->description }}</td>
                            <td>{{ $b->stock }}</td>
                            @if(Auth::user()->role === 'gestionnaire')
                                <td>
                                    <a href="{{ route('editBurger', $b->id) }}" class="btn btn-sm btn-primary">✏️</a>
                                    <form action="{{ route('archiveBurger', $b->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Archiver ce burger ?')">🗑️</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

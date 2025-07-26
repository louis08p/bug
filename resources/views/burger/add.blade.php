@extends('layouts.app')

@section('content')

<style>
    .form-container {
        max-width: 700px;
        margin: auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container h2 {
        text-align: center;
        color: #d35400;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
    }

    .form-control {
        border-radius: 6px;
        padding: 10px;
        font-size: 16px;
    }

    .form-control:focus {
        border-color: #f39c12;
        box-shadow: 0 0 5px rgba(243, 156, 18, 0.5);
    }

    .invalid-feedback {
        font-size: 14px;
        color: #c0392b;
    }

    .btn-warning {
        background-color: #f39c12;
        border: none;
        color: white;
        font-weight: bold;
        padding: 10px 30px;
        border-radius: 8px;
        transition: 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #e67e22;
    }

    .container {
        padding-top: 50px;
        padding-bottom: 50px;
    }
</style>
<div class="container py-5">
    <div class="form-container">
        <h2>{{ $burger->id ? '✏️ Modifier le Burger' : '➕ Ajouter un Nouveau Burger' }}</h2>
        <form action="{{ route($burger->id ? 'updateBurger' : 'saveBurger', $burger->id) }}" method="POST" enctype="multipart/form-data">
            @method($burger->id ? 'put' : 'post')
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $burger->nom) }}">
                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Prix -->
            <div class="mb-3">
                <label class="form-label">Prix (FCFA)</label>
                <input type="number" name="prix" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix', $burger->prix) }}">
                @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $burger->description) }}">
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $burger->stock) }}">
                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <!-- Submit -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-warning px-5">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
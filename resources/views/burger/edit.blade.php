@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Modifier le Burger</h4>
                </div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <form action="{{ route('burgers.update', $burger->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Champ Nom -->
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" value="{{ old('nom', $burger->nom) }}" required>
                            @error('nom') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Champ Prix -->
                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix (FCFA)</label>
                            <input type="number" name="prix" class="form-control" value="{{ old('prix', $burger->prix) }}" required>
                            @error('prix') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Champ Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $burger->description) }}</textarea>
                            @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Champ Stock -->
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', $burger->stock) }}" required>
                            @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Image actuelle -->
                        @if($burger->image)
                            <div class="mb-3">
                                <label class="form-label">Image actuelle</label><br>
                                <img src="{{ asset('storage/' . $burger->image) }}" alt="Image du burger" class="img-thumbnail" style="width: 150px;">
                            </div>
                        @endif

                        <!-- Champ Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Changer l'image (optionnel)</label>
                            <input type="file" name="image" class="form-control">
                            @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('burgers.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Mettre à jour</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

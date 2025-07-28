@extends('layouts.app')

@section('content')
<style>
    .burger-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 15px;
        overflow: hidden;
    }

    .burger-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    .burger-img {
        height: 180px;
        object-fit: cover;
        border-bottom: 1px solid #eee;
    }

    .btn-add {
        width: 100%;
        border-radius: 25px;
        background: linear-gradient(45deg, #ff7e5f, #feb47b);
        border: none;
    }

    .btn-add:hover {
        background: linear-gradient(45deg, #feb47b, #ff7e5f);
    }

    h2 {
        margin-bottom: 30px;
        text-align: center;
        font-weight: bold;
        color: #333;
    }
</style>

<div class="container">
    <h2>🍔 Menu des Burgers 🍔</h2>
    <div class="row">
        @foreach($burgers as $burger)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card burger-card shadow-sm">
                    @if($burger->image)
                        <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top burger-img" alt="burger image">
                    @endif
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $burger->nom }}</h5>
                            <p class="card-text text-muted">{{ $burger->description }}</p>
                        </div>
                        <div>
                            <p class="card-text fw-bold">{{ $burger->prix }} FCFA</p>
                            <form action="{{ route('panier.ajouter', $burger->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

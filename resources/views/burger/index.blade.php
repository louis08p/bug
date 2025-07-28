@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Nos Burgers</h1>

    <div class="row">
        @foreach($burgers as $burger)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($burger->image)
                        <img src="{{ asset('storage/' . $burger->image) }}" class="card-img-top" alt="{{ $burger->nom }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $burger->nom }}</h5>
                        <p class="card-text">{{ $burger->description }}</p>
                        <p class="card-text fw-bold">{{ $burger->prix }} FCFA</p>
                        <p class="text-muted">Stock : {{ $burger->stock }}</p>
                        <a href="#" class="btn btn-primary">Commander</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

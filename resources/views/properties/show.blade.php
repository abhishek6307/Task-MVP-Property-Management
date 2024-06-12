@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-md-8">
            <img src="https://via.placeholder.com/800x400" alt="{{ $property->title }}" class="img-fluid">
        </div>
        <div class="col-md-4">
            <h2>{{ $property->title }}</h2>
            <p>{{ $property->description }}</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Address:</strong> {{ $property->address }}</li>
                <li class="list-group-item"><strong>Price:</strong> ${{ number_format($property->price, 2) }}</li>
                <li class="list-group-item"><strong>Bedrooms:</strong> {{ $property->bedrooms }}</li>
                <li class="list-group-item"><strong>Bathrooms:</strong> {{ $property->bathrooms }}</li>
                <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($property->type) }}</li>
                <li class="list-group-item"><strong>Owner:</strong> {{ $property->user->name }}</li>
            </ul>
        </div>
    </div>

</div>
@endsection

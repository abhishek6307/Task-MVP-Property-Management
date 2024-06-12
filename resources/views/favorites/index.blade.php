@extends('layouts.guest')

@section('content')
<div class="container">
    <h1 class="my-4">Your Favorite Properties</h1>

    @if($favoriteProperties->isEmpty())
    <p>You have no favorite properties.</p>
    @else
    <div class="row">
        @foreach($favoriteProperties as $property)
        <div class="col-12 col-sm-12 col-md-4 mb-4">
            <div class="card h-100">
                <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="{{ $property->title }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $property->title }}</h5>
                    <p class="card-text">{{ Str::limit($property->description, 100) }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Address: {{ $property->address }}</li>
                        <li class="list-group-item">Price: ${{ number_format($property->price, 2) }}</li>
                        <li class="list-group-item">Bedrooms: {{ $property->bedrooms }}</li>
                        <li class="list-group-item">Bathrooms: {{ $property->bathrooms }}</li>
                        <li class="list-group-item">Type: {{ ucfirst($property->type) }}</li>
                        <li class="list-group-item">Owner: {{ $property->user->name }}</li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary">View Details</a>
                    <button class="btn btn-danger remove-favorite-button" data-property-id="{{ $property->id }}">
                        <i class="fas fa-heart"></i> Remove Favorite
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $favoriteProperties->links() }}
    </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('.remove-favorite-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var propertyId = button.data('property-id');

            $.ajax({
                type: 'POST',
                url: '/properties/' + propertyId + '/favorite',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.favorite === false) {
                        button.closest('.col-md-4').fadeOut();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    }
                }
            });
        });
    });
</script>
@endsection
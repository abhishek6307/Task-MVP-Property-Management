@extends('layouts.guest')

@section('content')
<div class="container">
    <a href="{{ route('properties.map') }}" class="btn btn-primary mb-3">View Properties On Map</a>
    <h1 class="my-4">Available Properties</h1>

    <form method="GET" action="{{ url('/') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <input type="text" name="search" class="form-control" placeholder="Search by title or description" value="{{ request('search') }}">
            </div>
            <div class="col-md-2 mb-3">
                <select name="type" class="form-control">
                    <option value="">Filter by Type</option>
                    <option value="house" {{ request('type') == 'house' ? 'selected' : '' }}>House</option>
                    <option value="apartment" {{ request('type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2 mb-3">
                <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="{{ request('max_price') }}">
            </div>
            <div class="col-md-1 mb-3">
                <input type="number" name="bedrooms" class="form-control" placeholder="Bedrooms" value="{{ request('bedrooms') }}">
            </div>
            <div class="col-md-1 mb-3">
                <input type="number" name="bathrooms" class="form-control" placeholder="Bathrooms" value="{{ request('bathrooms') }}">
            </div>
            <div class="col-md-2 mb-3">
                <select name="sort_by" class="form-control">
                    <option value="">Sort by</option>
                    <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                    <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Date Added</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <select name="sort_direction" class="form-control">
                    <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <button type="submit" class="btn btn-primary btn-block">Apply</button>
            </div>
            <div class="col-md-2 mb- d-flex">
            <a href="/" class="btn btn-primary mb-3">Clear All Filters</a>
            </div>
        </div>
    </form>

    @if($properties->isEmpty())
    <p>No properties found.</p>
    @else
    <div class="row">
        @foreach($properties as $property)
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
                    @auth
                    <button class="btn btn-secondary inquiry-button" data-property-id="{{ $property->id }}">Inquire</button>
                    <button class="btn btn-info schedule-button" data-property-id="{{ $property->id }}">Schedule Viewing</button>

                    @else
                    <button class="btn btn-secondary inquiry-button" data-property-id="{{ $property->id }}">Inquire</button>
                    <button class="btn btn-info schedule-button" data-property-id="{{ $property->id }}">Schedule Viewing</button>
                    @endauth
                </div>
                <div class="card-footer text-center">
                    @auth
                    <button class="btn btn-primary favorite-button" data-property-id="{{ $property->id }}">
                        <i class="{{ auth()->user()->isFavorite($property) ? 'fas text-danger' : 'far' }} fa-heart"></i>
                    </button>
                    <button class="btn btn-secondary like-button {{ auth()->user()->likedProperties->contains($property->id) ? 'text-success' : '' }}" data-property-id="{{ $property->id }}">
                        <i class="fas fa-thumbs-up"></i> <span class="like-count">{{ $property->likedUsers->count() }}</span>
                    </button>
                    <button class="btn btn-info share-button" data-property-id="{{ $property->id }}" data-property-url="{{ route('properties.show', $property->id) }}">
                        <i class="fas fa-share"></i> Share <span class="share-count">{{ $property->shares }}</span>
                    </button>
                    @else
                    <button class="btn btn-primary favorite-button" data-property-id="{{ $property->id }}">
                        <i class="fas fa-heart"></i>
                    </button>
                    
                    <button class="btn btn-secondary like-button " data-property-id="{{ $property->id }}">
                        <i class="fas fa-thumbs-up"></i> <span class="like-count">{{ $property->likedUsers->count() }}</span>
                    </button>
                    <button class="btn btn-info share-button" data-property-id="{{ $property->id }}" data-property-url="{{ route('properties.show', $property->id) }}">
                        <i class="fas fa-share"></i> Share <span class="share-count">{{ $property->shares }}</span>
                    </button>
                    @endauth
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary">View Details</a>
                </div>
                </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $properties->appends(request()->query())->links() }}
    </div>
    @endif
</div>
<!-- Inquiry Modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" id="inquiryForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inquiryModalLabel">Submit Inquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea name="message" class="form-control" rows="5" placeholder="Your message"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Inquiry</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" id="scheduleForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Viewing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="datetime-local" name="viewing_date" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Schedule Viewing</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('.like-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var propertyId = button.data('property-id');
            var icon = button.find('i');
            var likeCountSpan = button.find('.like-count');

            $.ajax({
                type: 'POST',
                url: '/properties/' + propertyId + '/toggle-like',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    likeCountSpan.text(data.likes);
                    if (data.liked) {
                        button.addClass('text-success');
                    } else {
                        button.removeClass('text-success');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 401) {

                        window.location.href = '/login';
                    } else {
                        
                    }
                }
            });
        });

        $('.share-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var propertyId = button.data('property-id');
            var propertyUrl = button.data('property-url');
            var shareCountSpan = button.find('.share-count');

            $.ajax({
                type: 'POST',
                url: '/properties/' + propertyId + '/share',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    shareCountSpan.text(data.shares);
                    navigator.clipboard.writeText(propertyUrl).then(function() {
                        
                    }, function(err) {
                        
                    });
                },
                error: function(xhr) {
                    
                }
            });
        });

    });

    $(document).ready(function() {

        $('.inquiry-button').click(function() {
            var propertyId = $(this).data('property-id');
            $('#inquiryForm').attr('action', '/properties/' + propertyId + '/inquiry');
            $('#inquiryModal').modal('show');
        });

        $('.schedule-button').click(function() {
            var propertyId = $(this).data('property-id');
            $('#scheduleForm').attr('action', '/properties/' + propertyId + '/schedule');
            $('#scheduleModal').modal('show');
        });

        $('.favorite-button').hover(function() {
            $(this).find('i').toggleClass('text-danger');
        });

        $('.favorite-button').click(function(e) {
            e.preventDefault();
            var button = $(this);
            var propertyId = button.data('property-id');
            var icon = button.find('i');

            $.ajax({
                type: 'POST',
                url: '/properties/' + propertyId + '/favorite',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    if (data.favorite) {
                        icon.removeClass('far').addClass('fas').addClass('text-danger');
                    } else {
                        icon.removeClass('fas').addClass('far').removeClass('text-danger');
                    }
                    $('.favorite-count').text(data.favoriteCount);
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

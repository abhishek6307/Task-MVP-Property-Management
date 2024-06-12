@extends('layouts.guest')

@section('content')
<div class="container">
    <h1 class="my-4">Your Inquiries</h1>

    @if($inquiries->isEmpty())
        <p>You have not made any inquiries yet.</p>
    @else
        <div class="row">
            @foreach($inquiries as $inquiry)
                <div class="col-12 col-sm-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="{{ $inquiry->property->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $inquiry->property->title }}</h5>
                            <p class="card-text">{{ Str::limit($inquiry->property->description, 100) }}</p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Address: {{ $inquiry->property->address }}</li>
                                <li class="list-group-item">Price: ${{ number_format($inquiry->property->price, 2) }}</li>
                                <li class="list-group-item">Bedrooms: {{ $inquiry->property->bedrooms }}</li>
                                <li class="list-group-item">Bathrooms: {{ $inquiry->property->bathrooms }}</li>
                                <li class="list-group-item">Type: {{ ucfirst($inquiry->property->type) }}</li>
                                <li class="list-group-item">Inquiry Message: {{ $inquiry->message }}</li>
                            </ul>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('properties.show', $inquiry->property->id) }}" class="btn btn-primary">View Property Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit Property')

@section('content')
<div class="container">
    <h1>Edit Property</h1>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <form action="{{ route('properties.update', $property->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $property->title }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $property->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $property->address }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $property->price }}" required>
        </div>
        <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ $property->bedrooms }}" required>
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ $property->bathrooms }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $property->type }}" required>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control" id="latitude" value="{{ old('latitude', $property->latitude) }}">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control" id="longitude" value="{{ old('longitude', $property->longitude) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Property</button>
    </form>
</div>
@endsection

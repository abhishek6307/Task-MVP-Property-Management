@extends('layouts.app')

@section('title', 'Add Property')

@section('content')
<div class="container">
    <h1>Add New Property</h1>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <form action="{{ route('properties.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
        </div>
        <div class="form-group">
            <label for="bedrooms">Bedrooms</label>
            <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" required>
        </div>
        <div class="form-group">
            <label for="bathrooms">Bathrooms</label>
            <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" required>
        </div>
        <div class="form-group">
            <label for="type">Type</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required>
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control" id="latitude" value="{{ old('latitude') }}">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control" id="longitude" value="{{ old('longitude') }}">
        </div>
        <div id="map" style="height: 400px;"></div>
        <button type="submit" class="btn btn-primary mt-3">Add Property</button>
    </form>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>

<script>
    function initMap() {
        var myLatLng = { lat: {{ old('latitude', 28.6139) }}, lng: {{ old('longitude', 77.2090) }} };

        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 10
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true
        });

        marker.addListener('dragend', function() {
            var position = marker.getPosition();
            document.getElementById('latitude').value = position.lat();
            document.getElementById('longitude').value = position.lng();
        });
    }
</script>
@endsections
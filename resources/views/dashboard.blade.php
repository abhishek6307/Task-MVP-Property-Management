<!-- resources/views/properties/index.blade.php -->

@extends('layouts.app')

@section('title', 'Properties')

@section('content')
<div class="container">
    <h1>Properties</h1>
    <a href="{{ route('properties.create') }}" class="btn btn-primary mb-3">Add New Property</a>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


<div class="container">
    <h1>Properties List</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Address</th>
                <th>Price</th>
                <th>Bedrooms</th>
                <th>Bathrooms</th>
                <th>Type</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
            @foreach($properties as $property)
                <tr>
                    <td>{{ $property->title }}</td>
                    <td>{{ $property->description }}</td>
                    <td>{{ $property->address }}</td>
                    <td>${{ number_format($property->price, 2) }}</td>
                    <td>{{ $property->bedrooms }}</td>
                    <td>{{ $property->bathrooms }}</td>
                    <td>{{ ucfirst($property->type) }}</td>
                    <td>{{ $property->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


</div>
@endsection

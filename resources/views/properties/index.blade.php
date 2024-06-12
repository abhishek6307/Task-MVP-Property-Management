@extends('layouts.app')

@section('title', 'Properties')

@section('content')

    <a href="{{ route('properties.create') }}" class="btn btn-primary mb-3">Add New Property</a>
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
                <th>Actions</th>
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
                    <td>{{ $property->type }}</td>
                    <td>{{ $property->user->name }}</td>
                    <td>
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

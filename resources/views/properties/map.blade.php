@extends('layouts.guest')

@section('content')
<div class="container">
    <h1 class="my-4">Property Locations</h1>
    <div id="property-map" style="height: 500px;"></div>
</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>

<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('property-map'), {
        zoom: 10,
        center: { lat: 28.6139, lng: 77.2090 } 
    });


    @foreach($properties as $property)

        @if ($property->latitude && $property->longitude)
            var marker = new google.maps.Marker({
                position: { lat: {{ $property->latitude }}, lng: {{ $property->longitude }} },
                map: map,
                title: '{{ $property->title }}'
            });

            var infowindow = new google.maps.InfoWindow({
                content: `
                    <h2>{{ $property->title }}</h5>
                    <p>{{ $property->address }}</p>
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-primary">View Details</a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $property->latitude }},{{ $property->longitude }}" target="_blank" class="btn btn-info mt-2">Get Directions</a>
                `
            });

            marker.addListener('click', (function(infowindow, marker) {
                return function() {
                    infowindow.open(map, marker);
                };
            })(infowindow, marker));
        @endif
    @endforeach
}

</script>
@endsection

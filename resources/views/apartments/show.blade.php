@extends('layouts.user')
@section('content')
    <div class="col d-flex p-5 gap-4">
        <img width="500" style="object-fit: cover" src="{{ $apartment->media }}" alt="{{ $apartment->title }}">
        <div class="details">
            <h1> {{ $apartment->title }}</h1>
            <h3>{{ $apartment->slug }}</h3>
            <p>{{ $apartment->description }}</p>
            <ul class="list-unstyled">
                <li><strong>Address: </strong>{{ $apartment->address }}</li>
                <li><strong>Squar meters: </strong>{{ $apartment->mq }}</li>
                <li><strong>Total rooms: </strong>{{ $apartment->total_rooms }}</li>
                <li><strong>Beds: </strong>{{ $apartment->beds }}</li>
                <li><strong>Baths</strong> {{ $apartment->baths }}</li>
            </ul>
        </div>
    </div>
@endsection

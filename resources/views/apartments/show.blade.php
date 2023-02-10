@extends('layouts.user')
@section('content')
    <div class="col d-flex p-5 gap-4">
        <img width="500" style="object-fit: cover"
            src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
            alt="{{ $apartment->title }}">
        <div class="details">
            <h1> {{ $apartment->title }}</h1>
            <h3>{{ $apartment->slug }}</h3>
            <p>{{ $apartment->description }}</p>
            <ul class="list-unstyled">
                <li><strong>Indirizzo: </strong>{{ $apartment->address }}</li>
                <li><strong>Categoria: </strong>{{ $apartment->apartment_category->name }}</li>
                <li><strong>Metri quadrati: </strong>{{ $apartment->mq }}m²</li>
                <li><strong>Camere: </strong>{{ $apartment->total_rooms }}</li>
                <li><strong>Letti: </strong>{{ $apartment->beds }}</li>
                <li><strong>Bagni: </strong> {{ $apartment->baths }}</li>
                <li><strong>Ospiti: </strong> {{ $apartment->guests }}</li>
                <li><strong>Prezzo: </strong> {{ $apartment->price }}$</li>
                <li><strong>Check_in: </strong> {{ $apartment->check_in }} </li>
                <li><strong>Check_out: </strong> {{ $apartment->check_out }} </li>
                <li><strong>Servizi:</strong> <br>
                    @if (count($apartment->services) > 0)
                        @foreach ($apartment->services as $service)
                <li>{{ $service->name }}</li>
                <ul class="list-unstyled">
                    @endforeach
                @else
                    <li>Non ci sono servizi associati a questo appartamento</li>
                    @endif

                </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection

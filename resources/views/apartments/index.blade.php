@extends('layouts.user')
@section('content')
    <div class="col d-flex flex-column justify-content-center">
        <div class="container apartments ms-xxl-2 p-xxl-5">
            <h1>Apartments</h1>
            <a name="" id="" class="btn btn-primary" href="{{ route('apartments.create') }}" role="button">New
                Apartments
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </a>
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row row-cols-1">
                @forelse($apartments as $apartment)
                    <div class="col">
                        <div class="card ms_card d-flex flex-row flex-wrap flex-xxl-nowrap my-3">
                            <img class="apartment-img" src="{{ $apartment->media }}" alt="Title">
                            <div class="card-body">
                                <h4 class="card-title">{{ $apartment->title }}</h4>
                                <p class="card-text">{{ $apartment->description }}</p>
                                <a href="{{ route('apartments.show', $apartment->slug) }}">
                                    <i class="fas fa-eye fa-sm fa-fw"></i>
                                </a>
                                <!-- edit -->
                                <a href="{{ route('apartments.edit', $apartment->slug) }}">
                                    <i class="fas fa-pencil fa-sm fa-fw"></i>
                                </a>
                                <a href="">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>




    </div>
    </div>
@endsection

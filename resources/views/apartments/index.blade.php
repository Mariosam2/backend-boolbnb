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
                            <img class="apartment-img"
                                src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                                alt="Title">
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

                                <!-- Modal trigger button -->
                                <a type="button" data-bs-toggle="modal" data-bs-target="#apartment-{{ $apartment->slug }}"
                                    style="color: #0d6efd">
                                    <i class="fa-solid fa-trash"></i>

                                </a>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="apartment-{{ $apartment->slug }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                    aria-labelledby="modal-{{ $apartment->slug }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modal-{{ $apartment->slug }}">Delete
                                                    {{ $apartment->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">


                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this apartment?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>

                                                <form action="{{ route('apartments.destroy', $apartment->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirm</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    No Apartment now
                @endforelse
            </div>
        </div>




    </div>
    </div>
@endsection

@extends('layouts.user')
@section('content')
    <div class="col d-flex flex-column justify-content-center">
        <div class="apartments py-5">
            <h1>Appartamenti</h1>
            <a name="" id="" class="btn create_btn text-white mb-5" href="{{ route('apartments.create') }}"
                role="button">Aggiungi
                un appartamento
                <i class="fa fa-plus-circle" aria-hidden="true"></i>
            </a>
            @if (session('message'))
                <div class="alert alert-success my-2">
                    {{ session('message') }}
                </div>
            @endif
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                @forelse($apartments as $apartment)
                    <div class="col">
                        <div class="card my_card my-3 rounded-0 border-0">
                            <img class="my-img img-fluid"
                                src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                                alt="Title">
                            <div class="card-body ">
                                <h4 class="">{{ $apartment->title }}</h4>
                                <div class="text-end">
                                    <a href="http://localhost:5174/blog/{{ $apartment->slug }}"
                                        class="btn show_btn text-white">
                                        <i class="fas fa-eye fa-sm fa-fw"></i>
                                    </a>
                                    <!-- edit -->
                                    <a href="{{ route('apartments.edit', $apartment->slug) }}"
                                        class="btn edit_btn text-white">
                                        <i class="fas fa-pencil fa-sm fa-fw"></i>
                                    </a>

                                    <!-- Modal trigger button -->
                                    <a type="button" data-bs-toggle="modal"
                                        data-bs-target="#apartment-{{ $apartment->slug }}"
                                        class="btn delete_btn text-white">
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
                                                    <h5 class="modal-title" id="modal-{{ $apartment->slug }}">Eliminare
                                                        {{ $apartment->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">


                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Sei sicuro di voler eliminare questo appartamento?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Chiudi</button>

                                                    <form action="{{ route('apartments.destroy', $apartment->slug) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                                    </form>

                                                </div>
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

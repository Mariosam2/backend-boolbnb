@extends('layouts.user')
@section('content')
    <div class="col d-flex flex-column justify-content-center flex-grow-1 px-2 px-xl-5">
        <div class="container-fluid remove_scrollbar" style=" min-height: 500px; height: 100vh; overflow-y:auto">
            <div class="apartments spacing">
                <div class="d-flex justify-content-between flex-wrap">
                    <h1>I Tuoi Appartamenti</h1>
                    <a name="" id="" class="create_btn mt-3 mt-md-0 mb-4 me-lg-3"
                        href="{{ route('apartments.create') }}" role="button">Aggiungi
                        un appartamento
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </div>
                @if (session('message'))
                    <div class="alert alert-success my-2">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="row g-3">
                    @forelse($apartments as $apartment)
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <div
                                class="card ms_card_apartment border-0  h-100 {{ isset($apartment->subscription) && $apartment->subscription->stripe_status == 'active' && $apartment->subscription->name == 'Bronze' ? 'bronze' : '' }} {{ isset($apartment->subscription) && $apartment->subscription->stripe_status == 'active' && $apartment->subscription->name == 'Silver' ? 'silver' : '' }} {{ isset($apartment->subscription) && $apartment->subscription->stripe_status == 'active' && $apartment->subscription->name == 'Gold' ? 'gold' : '' }}">
                                <div class="card_img">
                                    <img class="my-img img-fluid"
                                        src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                                        alt="Title">
                                </div>
                                <div class="card-body text-start d-flex flex-column justify-content-between">
                                    <h5 class="pb-3">{{ $apartment->title }}</h5>

                                    <div class="text-end d-flex justify-content-between  flex-wrap">
                                        @if (!isset($apartment->subscription))
                                            <a href="{{ route('products', $apartment->slug) }}"
                                                class="sponsor_btn text-white">
                                                Sponsorizza
                                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                                            </a>
                                        @elseif(isset($apartment->subscription))
                                            @if ($apartment->subscription->stripe_status !== 'active')
                                                <a href="{{ route('products', $apartment->slug) }}"
                                                    class="sponsor_btn text-white">
                                                    Sponsorizza
                                                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                                                </a>
                                            @else
                                                <span class="d-block sponsor_badge">Sponsorizzato fino
                                                    al{{ ' ' . date('d-m-Y', strtotime($apartment->subscription->ends_at)) }}</span>
                                            @endif
                                        @endif

                                        <!-- show -->
                                        <a href="https://front.boolbnb-host.com/blog/{{ $apartment->slug }}"
                                            class="d-inline-block btn show_btn mx-2  mb-2 text-white flex-grow-1 flex-md-grow-0">
                                            Visualizza
                                            <i class="fas fa-eye fa-sm fa-fw"></i>
                                        </a>
                                        <!-- edit -->
                                        <a href="{{ route('apartments.edit', $apartment->slug) }}"
                                            class="d-inline-block btn mx-2 mb-2 edit_btn text-white flex-grow-1 flex-md-grow-0">
                                            Modifica
                                            <i class="fas fa-pencil fa-sm fa-fw"></i>
                                        </a>

                                        <!-- Modal trigger button -->
                                        <a type="button" data-bs-toggle="modal"
                                            data-bs-target="#apartment-{{ $apartment->slug }}"
                                            class="d-inline-block btn mx-2 ms-2 ms-md-auto mb-2 delete_btn text-white flex-grow-1 flex-md-grow-0">
                                            Cancella
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
                                                        <h5 class="modal-title" id="modal-{{ $apartment->slug }}">
                                                            Eliminare
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
    </div>

@endsection

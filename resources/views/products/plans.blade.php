@extends('layouts.user')



@section('content')
    <div class="col">

        <h1 class="mb-5">Sponsorizza </h1>
        <div class="row  justify-content-evenly align-items-center my-5 flex-row-reverse">

            @forelse($products as $product)
                <div class="col-1 col-md-3 text-center  ">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header sponsor py-3">
                            <span class="text-white">In evidenza per
                                @if ($product->name == 'Bronze')
                                    1 giorno
                                @elseif ($product->name == 'Silver')
                                    3 giorni
                                @else
                                    7 giorni
                                @endif
                                {{ $product->duration }}
                            </span>
                        </div>
                        <h2 class="mt-4">

                            <a class="d-block text-uppercase text-decoration-none {{ $product->name == 'Bronze' ? 'bronze' : '' }} {{ $product->name == 'Silver' ? 'silver' : '' }} {{ $product->name == 'Gold' ? 'gold' : '' }}"
                                href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}">


                                {{ $product->name }}
                            </a>


                        </h2>

                        <div class="card-body">
                            <span>
                                Sponsorizzato per
                                @if ($product->name == 'Bronze')
                                    1 giorno.
                                @elseif ($product->name == 'Silver')
                                    3 giorni.
                                @else
                                    7 giorni.
                                @endif

                                Prima posizione durante la ricerca
                                Icona distintiva per sponsorizzazione
                                Sezione dedicata in homepage del sito
                            </span>
                            <h3 class="my-4">
                                @if ($product->name == 'Bronze')
                                    10 $
                                @elseif ($product->name == 'Silver')
                                    25$
                                @else
                                    50$
                                @endif

                            </h3>

                            <button type="button" class="w-100 btn btn-lg btn-outline-primary">Acquista</button>
                        </div>
                    </div>

                </div>

            @empty
            @endforelse
        </div>

    </div>
@endsection

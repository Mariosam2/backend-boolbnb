@extends('layouts.user')



@section('content')
    <div class="col col-plans flex-grow-1">
        <h1 class="  ms-0 mb-3 mt-5 ms-sm-5">Sponsorizza: {{ $apartment->title }} </h2>
            <a href="{{ route('apartments.index') }}" class="torna mb-5 ms-0 ms-sm-5">
                <i class="fa-solid fa-chevron-left"></i>
                Torna alla pagina dei tuoi appartamenti
            </a>
            <div class="row   justify-content-evenly align-items-center my-5 pt-5 flex-row-reverse">

                @forelse($products as $product)
                    <div class="col-12 col-sm-8 col-md-5 col-xxl-3 text-center  sponsor-card">
                        <div class="card mb-4  shadow-sm">
                            <div class="card-header sponsor py-3 ">
                                <span class="text-white">In evidenza per
                                    <strong>

                                        @if ($product->name == 'Bronze')
                                            1 giorno
                                        @elseif ($product->name == 'Silver')
                                            3 giorni
                                        @else
                                            7 giorni
                                        @endif
                                        {{ $product->duration }}
                                </span>
                                </strong>

                            </div>
                            <div class="card-body body-sponsor d-flex flex-column text-center justify-content-evenly">

                                <h1 class="mt-4">

                                    <a class="d-block text-uppercase text-decoration-none {{ $product->name == 'Bronze' ? 'bronze' : '' }} {{ $product->name == 'Silver' ? 'silver' : '' }} {{ $product->name == 'Gold' ? 'gold' : '' }}"
                                        href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}">


                                        {{ $product->name }}
                                    </a>


                                </h1>

                                <span class="text-center">
                                    Sponsorizzato per
                                    @if ($product->name == 'Bronze')
                                        1 giorno.
                                    @elseif ($product->name == 'Silver')
                                        3 giorni.
                                    @else
                                        7 giorni.
                                    @endif
                                    <br>
                                    Prima posizione durante la ricerca
                                    <br>
                                    Icona distintiva per sponsorizzazione
                                    <br>
                                    Sezione dedicata in homepage del sito
                                </span>
                                <h2 class="my-4">
                                    @if ($product->name == 'Bronze')
                                        10 $
                                    @elseif ($product->name == 'Silver')
                                        25$
                                    @else
                                        50$
                                    @endif

                                    </h3>
                                    <span class="text-center">

                                        <a href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}"
                                            type="button" class=" btn  buy">Acquista</a>
                                    </span>

                            </div>
                        </div>

                    </div>

                @empty
                @endforelse
            </div>

    </div>
@endsection

@extends('layouts.user')



@section('content')
    <div class="col col-plans flex-grow-1 spacing px-2 px-xl-5">
        <div class="container mx-auto">
            <h1 class="">Sponsorizza: {{ $apartment->title }} </h2>
                <a href="{{ route('apartments.index') }}" class="torna">
                    <i class="fa-solid fa-chevron-left"></i>
                    Torna alla pagina dei tuoi appartamenti
                </a>

                <div class="row   justify-content-evenly align-items-center my-5 pt-5 flex-row-reverse">

                    @forelse($products as $product)
                        <div class="col-12 col-md-6 col-xxl-4 text-center  sponsor-card">
                            <div class="card mb-4  shadow-sm">
                                <div class="card-body body-sponsor d-flex flex-column text-center justify-content-evenly">

                                    <h1 class="mt-4">

                                        <a class="d-block text-uppercase text-decoration-none {{ $product->name == 'Bronze' ? 'bronze' : '' }} {{ $product->name == 'Silver' ? 'silver' : '' }} {{ $product->name == 'Gold' ? 'gold' : '' }}"
                                            href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}">


                                            {{ $product->name }}
                                        </a>


                                    </h1>
                                    <h2 class="my-4">
                                        {{ $product->price }} $

                                    </h2>

                                    <span class="text-center">
                                        <div class="py-4">
                                            Sponsorizzato per
                                            @if ($product->name == 'Bronze')
                                                <strong>1</strong> giorno.
                                            @elseif ($product->name == 'Silver')
                                                <strong>3</strong> giorni.
                                            @else
                                                <strong>7</strong> giorni.
                                            @endif
                                        </div>
                                        <div class="py-2">
                                            <i class="fa-solid fa-check mx-2"></i> Prima posizione durante la ricerca
                                        </div>
                                        <div class="py-2">
                                            <i class="fa-solid fa-check mx-2"></i> Icona distintiva per sponsorizzazione
                                        </div>
                                        <div class="py-2">
                                            <i class="fa-solid fa-check mx-2"></i> Sezione dedicata in homepage del sito
                                        </div>

                                    </span>

                                    <span class="text-center mt-4">

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


    </div>
@endsection

@extends('layouts.user')



@section('content')
    @forelse($products as $product)
        <div class="col-1 col-md-3 text-center  ">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <a class="d-block pt-5 mx-4"
                        href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}">{{ $product->name }}</a>

                </div>

            </div>

            <div class="card-body">
                <h1>

                </h1>

                <button type="button" class="w-100 btn btn-lg btn-outline-primary">Subscripe</button>
            </div>
        </div>

    @empty
    @endforelse
@endsection

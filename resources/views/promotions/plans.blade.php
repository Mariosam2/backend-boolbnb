@extends('layouts.user')



@section('content')
    <div class="col">

        @forelse($promotions as $promotion)
            <a class="d-block pt-5 mx-4"
                href="{{ route('products.purchase', ['apartment' => $apartment->slug, 'product' => $product->prod_id]) }}">{{ $product->name }}</a>
        @empty
        @endforelse
    </div>
@endsection

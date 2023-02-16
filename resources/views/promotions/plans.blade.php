@extends('layouts.user')



@section('content')
    <div class="col">

        @forelse($promotions as $promotion)
            <a class="d-block pt-5 mx-4"
                href="{{ route('promo.purchase', ['apartment' => $apartment->slug, 'promotion' => $promotion->id]) }}">{{ $promotion->name }}</a>
        @empty
        @endforelse
    </div>
@endsection

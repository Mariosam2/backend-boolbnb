@extends('layouts.user')



@section('content')
    @forelse($promotions as $promotion)
        <div class="col-1 col-md-3 text-center  ">

            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header py-3">
                    <a class="d-block pt-5 mx-4 text-uppercase"
                        href="{{ route('promo.purchase', ['apartment' => $apartment->slug, 'promotion' => $promotion->id]) }}">{{ $promotion->name }}</a>

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

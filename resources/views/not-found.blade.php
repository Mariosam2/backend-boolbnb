@extends('layouts.user')

@section('content')
    <div class="col">
        <div class="d-flex flex-column align-items-center justify-content-center vh-100">
            <p class="lead text-center ">
                😨 Ops, Page not found!
            </p>
            <a href="{{ route('apartments.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>
@endsection

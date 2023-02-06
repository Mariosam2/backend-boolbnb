@extends('layouts.user')


@section('content')
    <div class="col">
        <h1>Aggiungi un nuovo appartamento</h1>
        <form action="{{ route('apartments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('title') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('address') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="mq" class="form-label">Square meters</label>
                <input type="number" name="mq" id="mq" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="32767" value="{{ old('mq') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="d-flex"></div>
            <div class="mb-3">
                <label for="beds" class="form-label">Beds</label>
                <input type="number" name="beds" id="beds" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="127" value="{{ old('beds') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="total_rooms" class="form-label">Total rooms</label>
                <input type="number" name="total_rooms" id="total_rooms" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="127" value="{{ old('total_rooms') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="baths" class="form-label">Baths</label>
                <input type="number" name="baths" id="baths" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="127" value="{{ old('baths') }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
        </form>
    </div>
@endsection

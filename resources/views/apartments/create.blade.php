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
        </form>
    </div>
@endsection

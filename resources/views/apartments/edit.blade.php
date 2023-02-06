@extends('layouts.user')


@section('content')
    <div class="col">
        <h1 class="mt-5 ps-5">Aggiungi un nuovo appartamento</h1>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('apartments.update', $apartment->slug) }}" method="POST" class=" ms_form m-5 p-5 rounded-3"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('title', $apartment->title) }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('address', $apartment->address) }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="mq" class="form-label">Square meters</label>
                <input type="number" name="mq" id="mq" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="32767" value="{{ old('mq', $apartment->mq) }}">
                <small id="helpId" class="text-muted">Help text</small>
            </div>
            <div class="mb-3">
                <label for="apartment_category_id" class="form-label">Categories</label>
                <select class="form-select form-select-md" name="apartment_category_id" id="apartment_category_id">
                    <option selected value="[]">None</option>
                    @foreach ($categories as $apartment_category)
                        <option value="{{ $apartment_category->id }}"
                            {{ old('apartment_category_id', $apartment->apartment_category->id) == $apartment_category->id ? 'selected' : '' }}>
                            {{ $apartment_category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center">
                <div class="mb-3 mx-2 me-auto d-flex align-items-center">
                    <img width="160" height="120"style="object-fit: cover"
                        src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                        alt="">


                    <div class="mx-3">
                        <label for="media" class="form-label">Media</label>
                        <input type="file" class="form-control" name="media" id="media" placeholder=""
                            aria-describedby="fileHelpId" value="{{ $apartment->media }}">
                        <div id="fileHelpId" class="form-text">Help text</div>
                    </div>


                </div>
                <div class="mb-3 mx-2">
                    <label for="beds" class="form-label">Beds</label>
                    <input type="number" name="beds" id="beds" class="form-control" placeholder=""
                        aria-describedby="helpId" min="1" max="127"
                        value="{{ old('beds', $apartment->beds) }}">
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3 mx-2">
                    <label for="total_rooms" class="form-label">Total rooms</label>
                    <input type="number" name="total_rooms" id="total_rooms" class="form-control" placeholder=""
                        aria-describedby="helpId" min="1" max="127"
                        value="{{ old('total_rooms', $apartment->total_rooms) }}">
                    <small id="helpId" class="text-muted">Help text</small>
                </div>
                <div class="mb-3 mx-2">
                    <label for="baths" class="form-label">Baths</label>
                    <input type="number" name="baths" id="baths" class="form-control" placeholder=""
                        aria-describedby="helpId" min="1" max="127"
                        value="{{ old('baths', $apartment->baths) }}">
                    <small id="helpId" class="text-muted">Help text</small>
                </div>

            </div>
            <div class="mb-3">
                <label for="description" class="form-label"></label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $apartment->description) }}</textarea>
            </div>
            <button type="submit" class="btn button">Edit</button>

        </form>
    </div>
@endsection

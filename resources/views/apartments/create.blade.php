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
        <form action="{{ route('apartments.store') }}" method="POST" class=" ms_form m-5 p-5 rounded-3"
            enctype="multipart/form-data">
            @csrf
            <div class="row d-flex ">
                <div class="col-7">
                    <div class="title-category">

                        <div class="mb-3 ">
                            <label for="title" class="form-label">Titolo*</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder=""
                                aria-describedby="helpId" value="{{ old('title') }}">
                        </div>
                        <div class="searchBoxWrapper"></div>
                    </div>
                    <div class="d-flex justify-content-between">


                        <div class="mb-3">
                            <label for="apartment_category_id" class="form-label">Categorie*</label>
                            <select class="form-select form-select-md" name="apartment_category_id"
                                id="apartment_category_id">
                                <option selected value="[]" disabled>None</option>
                                @foreach ($categories as $apartment_category)
                                    <option value="{{ $apartment_category->id }}"
                                        {{ old('apartment_category_id') ? 'selected' : '' }}>
                                        {{ $apartment_category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="mq" class="form-label">M.Q.*</label>
                            <input type="number" name="mq" id="mq" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="32767" value="{{ old('mq') }}"
                                required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="beds" class="form-label">Letti*</label>
                            <input type="number" name="beds" id="beds" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('beds') }}"
                                required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="total_rooms" class="form-label">Camere*</label>
                            <input type="number" name="total_rooms" id="total_rooms" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('total_rooms') }}"
                                required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="baths" class="form-label">Bagni*</label>
                            <input type="number" name="baths" id="baths" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('baths') }}"
                                required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="guests" class="form-label">Ospiti</label>
                            <input type="number" name="guests" id="guests" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('guests') }}">
                        </div>


                    </div>
                    <div class=" d-flex">
                        <div class="mb-3 mx-2">
                            <label for="check_in" class="form-label">Check in:</label>
                            <input type="text" name="check_in" id="check_in" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('check_in') }}">
                        </div>

                        <div class="mb-3 mx-2">
                            <label for="check_out" class="form-label">Check out:</label>
                            <input type="text" name="check_out" id="check_out" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('check_out') }}">
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="price" class="form-label">Prezzo:</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127" value="{{ old('price') }}">
                        </div>

                    </div>
                    <div class="d-flex my-3 align-items-center justify-content-center">

                        <label for="services" class="mx-3">Servizi</label>
                        <select multiple class="custom-select" name="services[]" id="services">
                            <option value="" disabled>Seleziona i Servizi</option>

                            @foreach ($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ in_array($service->id, old('service', [])) ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach


                        </select>
                        @error('services')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex col-5 justify-content-center align-items-end">

                    <div class="d-flex ">
                        <div class="form-group mx-3">
                            <div class="placeholder">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/681px-Placeholder_view_vector.svg.png"
                                    width="400" alt="Placeholder">
                            </div>
                            <div class="mb-3">
                                <label for="media" class="form-label">Immagine*</label>
                                <input type="file" class="form-control" name="media" id="media" placeholder=""
                                    aria-describedby="fileHelpId" required>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrizione*</label>
                    <textarea class="form-control" name="description" id="description" rows="3" required>{{ old('description') }}</textarea>
                    <div class="row mt-3 justify-content-end">
                        <button type="submit  " class="btn button col-2 ">Crea</button>

                    </div>
        </form>

    </div>
@endsection

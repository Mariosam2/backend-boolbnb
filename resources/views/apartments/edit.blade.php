@extends('layouts.user')


@section('content')
    <div class="col">
        <h1 class="mt-5  ps-5">Modifica questo appartamento</h1>
        @if ($errors->any())
            <div class="alert alert-danger " role="alert">
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
                <label for="title" class="form-label">Titolo:*</label>
                <input type="text" name="title" id="title" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('title', $apartment->title) }}" required>
                <small id="helpId" class="text-muted">Modificare il titolo</small>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Indirizzo:*</label>
                <input type="text" name="address" id="address" class="form-control" placeholder=""
                    aria-describedby="helpId" value="{{ old('address', $apartment->address) }}" required>
                <small id="helpId" class="text-muted">Modificare l'indirizzo</small>
            </div>
            <div class="mb-3">
                <label for="mq" class="form-label">Metri quadrati:*</label>
                <input type="number" name="mq" id="mq" class="form-control" placeholder=""
                    aria-describedby="helpId" min="1" max="32767" value="{{ old('mq', $apartment->mq) }}"
                    required>
                <small id="helpId" class="text-muted">Modificare i Metri quadrati</small>
            </div>
            <div class="mb-3">
                <label for="apartment_category_id" class="form-label">Categorie:*</label>
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
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center col-6">
                    <div class="mb-3 mx-2">
                        <label for="beds" class="form-label">Letti:*</label>
                        <input type="number" name="beds" id="beds" class="form-control" placeholder=""
                            aria-describedby="helpId" min="1" max="127"
                            value="{{ old('beds', $apartment->beds) }}" required>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="total_rooms" class="form-label">Camere:*</label>
                        <input type="number" name="total_rooms" id="total_rooms" class="form-control" placeholder=""
                            aria-describedby="helpId" min="1" max="127"
                            value="{{ old('total_rooms', $apartment->total_rooms) }}" required>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="baths" class="form-label">Bagni:*</label>
                        <input type="number" name="baths" id="baths" class="form-control" placeholder=""
                            aria-describedby="helpId" min="1" max="127"
                            value="{{ old('baths', $apartment->baths) }}" required>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="guests" class="form-label">Ospiti:</label>
                        <input type="number" name="guests" id="guests" class="form-control" placeholder=""
                            aria-describedby="helpId" min="1" max="127"
                            value="{{ old('guests', $apartment->guests) }}">
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="price" class="form-label">Prezzo:</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder=""
                            aria-describedby="helpId" value="{{ old('price', $apartment->price) }}">
                    </div>

                </div>
                <div class="col-6">
                    <div class="mb-3 mx-2 me-auto d-flex align-items-center justify-content-end">


                        <div class="mx-3">
                            <label for="media" class="form-label">Immagine:*</label>
                            <input type="file" class="form-control" name="media" id="media" placeholder=""
                                aria-describedby="fileHelpId"
                                value="{{ storage_path('uploads\D5brKTH0mrz7dgFRutQLSGvPyL6aubA5HKjEUFj8.jpg') }}">
                        </div>
                        <img width="160" height="120"style="object-fit: cover"
                            src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                            alt="">


                    </div>
                </div>

            </div>
            <div class="d-flex">
                <div class="col-6 d-flex">
                    <div class="mb-3 mx-2">
                        <label for="check_in" class="form-label">Check in:</label>
                        <input type="text" name="check_in" id="check_in" class="form-control" placeholder=""
                            aria-describedby="helpId" value="{{ old('check_in', $apartment->check_in) }}">
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="check_out" class="form-label">Check out:</label>
                        <input type="text" name="check_out" id="check_out" class="form-control" placeholder=""
                            aria-describedby="helpId" value="{{ old('check_out', $apartment->check_out) }}">
                    </div>
                </div>
                <div class="col-6">
                    <label for="services" class="form-label">Servizi</label>
                    <select multiple class="form-select form-select-sm" name="services[]" id="services">
                        <option value="" disabled>Select a service</option>
                        @forelse ($services as $service)
                            @if ($errors->any())
                                <!-- Pagina con errori di validazione, deve usare old per verificare quale id di service preselezionare -->
                                <option value="{{ $service->id }}"
                                    {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
                                    {{ $service->name }}</option>
                            @else
                                <!-- Pagina caricate per la prima volta: deve mostrarare i service preseleziononati dal db -->
                                <option value="{{ $service->id }}"
                                    {{ $apartment->services->contains($service->id) ? 'selected' : '' }}>
                                    {{ $service->name }}</option>
                            @endif
                        @empty
                            <option value="" disabled>Sorry 😥 no services in the system</option>
                        @endforelse

                    </select>
                </div>

            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrizione:*</label>
                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $apartment->description) }}</textarea>
                <small id="helpId" class="text-muted">Modifica la descrizione</small>
            </div>
            <button type="submit" class="btn button">Modifica</button>

        </form>
    </div>
@endsection

@extends('layouts.user')


@section('content')
    <div class="col flex-grow-1 spacing remove_scrollbar" style="min-height: 500px; height: 100vh; overflow-y:auto">
        <div class="mb-3 mb-xxl-0 ps-3 ps-xxl-5">
            <h1>Modifica: {{ $apartment->title }}</h1>
            <a href="{{ route('apartments.index') }}" class="torna">
                <i class="fa-solid fa-chevron-left"></i>
                Torna alla pagina dei tuoi appartamenti
            </a>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('apartments.update', $apartment->slug) }}" method="POST"
            class=" col-12 col-xxl-10 ms_form p-3 pt-xxl-5 px-xxl-5  rounded-3" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row d-flex  ">
                <div class="col-12 col-xxl-7">
                    <div class="title-category">

                        <div class="mb-3 ">
                            <label for="title" class="form-label">Titolo*</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" value="{{ old('title', $apartment->title) }}" required>
                        </div>
                        <div class="searchBoxWrapper"></div>
                    </div>
                    <div class="d-flex justify-content-between justify-content-xxl-start my-3 flex-wrap">



                        <div class="mb-3">

                            <label for="apartment_category_id" class="form-label">Categorie:*</label>
                            <select class="form-select form-select-md" name="apartment_category_id"
                                id="apartment_category_id">
                                @foreach ($categories as $apartment_category)
                                    <option value="{{ $apartment_category->id }}"
                                        {{ old('apartment_category_id', $apartment->apartment_category->id) == $apartment_category->id ? 'selected' : '' }}>
                                        {{ $apartment_category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="mq" class="form-label">M.Q.*</label>
                            <input type="number" name="mq" id="mq"
                                class="form-control  @error('mq') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" min="1" max="32767"
                                value="{{ old('mq', $apartment->mq) }}" required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="beds" class="form-label">Letti*</label>
                            <input type="number" name="beds" id="beds"
                                class="form-control  @error('beds') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('beds', $apartment->beds) }}" required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="total_rooms" class="form-label">Camere*</label>
                            <input type="number" name="total_rooms" id="total_rooms"
                                class="form-control @error('total_rooms') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('total_rooms', $apartment->total_rooms) }}" required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="baths" class="form-label">Bagni*</label>
                            <input type="number" name="baths" id="baths"
                                class="form-control  @error('baths') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('baths', $apartment->baths) }}" required>
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="guests" class="form-label  ">Ospiti*</label>
                            <input type="number" name="guests" id="guests"
                                class="form-control @error('guests') 'is-invalid' @enderror" placeholder=""
                                aria-describedby="helpId" min="1" max="127" required
                                value="{{ old('guests', $apartment->guests) }}">
                        </div>


                    </div>
                    <div class=" d-flex">
                        <div class="mb-3 mx-2">
                            <label for="check_in" class="form-label">Check in:</label>
                            <input type="text" name="check_in" id="check_in" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('check_in', $apartment->check_in) }}">
                        </div>

                        <div class="mb-3 mx-2">
                            <label for="check_out" class="form-label">Check out:</label>
                            <input type="text" name="check_out" id="check_out" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('check_out', $apartment->check_out) }}">
                        </div>
                        <div class="mb-3 mx-2">
                            <label for="price" class="form-label">Prezzo:</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder=""
                                aria-describedby="helpId" min="1" max="127"
                                value="{{ old('price', $apartment->price) }}">
                        </div>

                    </div>
                    <div class="d-flex my-2 align-items-center flex-wrap">
                        <div class="ms_slider">

                            <label class="switch d-flex align-items-center gap-2">
                                <label for="visible" class="me-3">Visibilità dell'appartmento</label>
                                <input type="hidden" id="visible" name="visible" value="{{ old('visible', '0') }}">
                                <input type="checkbox" id="visible" name="visible" value="{{ old('visible', '1') }}"
                                    {{ $apartment->visible ? 'checked active' : '' }}>
                                <span class="slider"></span>


                            </label>
                        </div>
                        <div class="d-flex align-items-center my-2 my-lg-0 ms-md-5 ps-sm-5">
                            <label for="services" class="form-label me-4">Servizi</label>
                            <select multiple class="form-select form-select-sm" name="services[]" id="services">
                                <option class="p-1" value="" disabled>Select a service</option>
                                @forelse ($services as $service)
                                    @if ($errors->any())
                                        <!-- Pagina con errori di validazione, deve usare old per verificare quale id di service preselezionare -->
                                        <option class="p-1" value="{{ $service->id }}"
                                            {{ in_array($service->id, old('services', [])) ? 'selected' : '' }}>
                                            {{ $service->name }}</option>
                                    @else
                                        <!-- Pagina caricate per la prima volta: deve mostrarare i service preseleziononati dal db -->
                                        <option class="p-1" value="{{ $service->id }}"
                                            {{ $apartment->services->contains($service->id) ? 'selected' : '' }}>
                                            {{ $service->name }}</option>
                                    @endif
                                @empty
                                    <option class="p-1" value="" disabled>Scusa 😥 non ci sono servizi nel
                                        sistema</option>
                                @endforelse

                            </select>
                        </div>
                    </div>
                </div>

                <div class="d-flex col-12  col-xxl-5 justify-content-start justify-content-xxl-center align-items-center">


                    <div class="form-group my-2 my-xxl-0 mx-0 mx-xxl-3">
                        <div class="mb-3 mx-2 me-auto d-flex align-items-center justify-content-end d-none d-xxl-block">

                            <img width="100%" height="300"style="object-fit: cover"
                                src="{{ Storage::exists($apartment->media) ? asset('storage/' . $apartment->media) : $apartment->media }}"
                                alt="">


                        </div>
                        <div class="mx-3">
                            <label for="media" class="form-label">Immagine:*</label>
                            <input type="file" class="form-control" name="media" id="media" placeholder=""
                                aria-describedby="fileHelpId">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descrizione*</label>
                    <textarea class="form-control @error('description') 'is-invalid' @enderror" name="description" id="description"
                        rows="3" required>{{ old('description', $apartment->description) }}</textarea>
                    <div class="d-flex mt-3 justify-content-end">
                        <button type="submit  " class="btn button ms_submit-button">Modifica</button>
                    </div>
        </form>

    </div>
@endsection

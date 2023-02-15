@extends('layouts.user')
@section('content')
    <div class="col p-5">
        <div class="mb-5">
            <h1>Tutti i messaggi</h1>
            <a href="{{ route('apartments.index') }}" class="torna">
                <i class="fa-solid fa-chevron-left"></i>
                Torna alla pagina dei tuoi appartamenti
            </a>
        </div>
        <div class="container-fluid">
            <div class="row row-cols-1">





                @forelse ($messages as $message)
                    <div class="col">
                        <div class="card ms_card d-flex flex-row flex-wrap my-3">
                            <img width="250" height="150" class="apartment-img"
                                src="{{ Storage::exists($message->media) ? asset('storage/' . $message->media) : $message->media }}"
                                alt="Title">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div class="data">
                                    {{ substr($message->created_at, 2, 9) }}

                                </div>
                                <div class="info d-flex  align-items-center gap-2">
                                    <div class="img_msg rounded-5 text-white">
                                        {{ substr($message->name, 0, 1) }}
                                        {{ substr($message->surname, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="name">
                                            {{ $message->name }} {{ $message->surname }}
                                        </h6>
                                        <h6>
                                            {{ $message->email }}
                                        </h6>
                                    </div>
                                </div>
                                <div>

                                    <h5>{{ $message->title }}</h5>


                                    {{ $message->body }}
                                </div>
                                <a target=”_blank” href="mailto:{{ $message->email }}" class="btn send_msg_btn me-4">
                                    <h6> Rispondi</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Non Hai messaggi!</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection

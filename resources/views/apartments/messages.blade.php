@extends('layouts.user')
@section('content')
    <div class="col">
        <h1 class="my-5">Tutti i messaggi</h1>

        @foreach ($apartments as $apartment)
            @if ($apartment->messages)
                @foreach ($apartment->messages as $message)
                    <div class="col">
                        <div class="card mb-5 w-25">
                            <div class="details p-3">
                                <div>
                                    <strong>Nome appartamento:</strong> {{ $apartment->title }}
                                </div>
                                <div>
                                    <strong>Nome:</strong> {{ $message->name }}
                                </div>
                                <div>
                                    <strong>Cognome:</strong> {{ $message->surname }}
                                </div>
                                <div>
                                    <strong>Email:</strong> {{ $message->email }}
                                </div>
                                <div>
                                    <strong>Messagio:</strong> {{ $message->body }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Non ci sono messaggi!</p>
            @endif
        @endforeach
    </div>
@endsection

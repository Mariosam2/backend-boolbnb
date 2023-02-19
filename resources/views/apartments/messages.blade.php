@extends('layouts.user')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')
    <div class="col px-2 px-xl-5 flex-grow-1">
        <div class="container mx-auto ms-xl-3 spacing">
            <div class="mb-5 mx-3 mx-xl-0">
                <h1>Tutti i messaggi</h1>
                <a href="{{ route('apartments.index') }}" class="torna">
                    <i class="fa-solid fa-chevron-left"></i>
                    Torna alla pagina dei tuoi appartamenti
                </a>
            </div>

            <div class="row row-cols-1">
                @forelse ($messages as $message)
                    <div class="col">



                        <div class="card ms_card ms_message d-flex   flex-row justifuy-content-start justify-content-xl-between my-3 mx-3 mx-xl-0 p-3 p-md-0 border-1 border-muted  {{ !$message->is_read ? 'new_message' : '' }}"
                            data-id="{{ $message->id }}">
                            <div class="col-4 d-none d-md-flex  align-items-center">
                                <img class="apartment-img"
                                    src="{{ Storage::exists($message->media) ? asset('storage/' . $message->media) : $message->media }}"
                                    alt="Title">
                                <span class="data flex-grow-1 p-3 d-none d-xl-block text-center ps-3 text-secondary">
                                    {{ substr($message->created_at, 2, 9) }}
                                </span>
                            </div>
                            <div
                                class="col-3 d-flex d-none d-xl-flex flex-column p-3 justify-content-center align-items-start gap-3 ps-5">

                                <div class="img_msg text-white d-flex justify-content-center align-items-center">
                                    {{ substr($message->name, 0, 1) }}
                                    {{ substr($message->surname, 0, 1) }}
                                </div>

                                <div class="info">
                                    <h6 class="name">
                                        {{ $message->name }} {{ $message->surname }}
                                    </h6>
                                    <h6>
                                        {{ $message->email }}
                                    </h6>
                                </div>
                            </div>
                            <div
                                class="col-5 d-flex flex-wrap flex-sm-nowrap justify-content-center justify-content-lg-between align-items-center flex-grow-1 ">
                                <div class="body p-3">
                                    <h5>{{ $message->title }}</h5>
                                    {{ $message->body }}
                                </div>
                                <a target="_blank" href="mailto:{{ $message->email }}" class="btn send_msg_btn me-4">
                                    Rispondi
                                </a>

                            </div>
                        </div>

                    </div>
                @empty
                    <p>Non hai messaggi!</p>
                @endforelse
                {{-- <div class="pagination d-flex justify-content-center">
                    {{ $messages->links() }}
                </div> --}}
            </div>
        </div>
    </div>
    <script>
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        window.messageId = '{{ $message->id }}';
        const messages = document.querySelectorAll('.card.ms_card.ms_message');
        console.log(messages, window.messageId)
        messages.forEach(message => {
            console.log(window.messageId)
            message.addEventListener('click', () => {
                console.log(`http://127.0.0.1:8000/prova/`);
                axios.put('http://127.0.0.1:8000/prova/1', {}, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    auth: {
                        username: '{{ Auth::user()->email }}', // sostituisci con il tuo nome utente o email
                        password: '{{ Auth::user()->password }}' // sostituisci con la tua password
                    }
                })
                axios.get('http://127.0.0.1:8000/apartments')
                    .then(resp => {
                        console.log(resp);
                    })

            })
        })
    </script>
@endsection

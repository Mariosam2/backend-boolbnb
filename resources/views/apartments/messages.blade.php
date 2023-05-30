@extends('layouts.user')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
@section('content')
    <div class="col px-2 px-xl-5 flex-grow-1">
        <div class="container remove_scrollbar mx-auto spacing" style=" min-height: 500px; height: 100vh; overflow-y:auto">
            <div class="d-flex flex-wrap align-items-center">
                <div class="mb-4 mx-3 mx-xl-0">
                    <h1>Tutti i messaggi</h1>
                    <a href="{{ route('apartments.index') }}" class="torna">
                        <i class="fa-solid fa-chevron-left"></i>
                        Torna alla pagina dei tuoi appartamenti
                    </a>
                </div>
                <a id="read_all" class="btn read_btn mx-3 mb-3 mb-sm-0 ms-md-auto me-3">
                    Leggi tutti
                </a>
            </div>
            <div class="row row-cols-1">
                @forelse ($messages as $message)
                    <div class="col message_wrapper my-3">
                        <div class="card ms_card ms_message d-flex   flex-row justifuy-content-start justify-content-xl-between mx-3 mx-xl-0 p-3 p-md-0 border-1 border-muted  {{ !$message->is_read ? 'new_message' : '' }}"
                            data-id="{{ $message->id }}">
                            <div class="col-4 d-none d-md-flex  align-items-center">
                                <img class="apartment-img"
                                    src="{{ Storage::exists($message->media) ? asset('storage/' . $message->media) : $message->media }}"
                                    alt="Title">
                            </div>
                            <div
                                class="col-3 d-flex d-none d-xxl-flex flex-row p-3 justify-content-center align-items-center gap-3 ps-5">

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
                                    <span class="data  text-center  text-secondary">
                                        {{ substr($message->created_at, 2, 9) }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="col-5 d-flex flex-wrap flex-sm-nowrap justify-content-center justify-content-lg-between align-items-center flex-grow-1 ">
                                <div class="body p-3">
                                    <h5>{{ $message->title }}</h5>
                                    {{ $message->body }}
                                </div>
                                <a target="_blank" href="mailto:{{ $message->email }}"
                                    class="btn send_msg_btn me-0 me-md-4">
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
    <script type="module">
       const axios = window.axios;
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;
        const messages = document.getElementsByClassName('ms_message');
        const readAllBtn = document.getElementById('read_all');
        
       
        let newMessages = null;

        readAllBtn.addEventListener('click', function(){
            let url = 'https://boolbnb-host.com/message/'+ 0 + '/'+ true;
            axios.put(url, { }, 
            {
                headers: {
                    'X-CSRF-TOKEN': csrfToken, 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                //console.log(response.data)
                newMessages = response.data.results;
                newMessages.forEach((newMessage, index)=> {
                    if(newMessage.is_read){
                        if(newMessage.id == messages[index].getAttribute('data-id')){
                        messages[index].classList.remove('new_message')
                        }
                    }
                
            })
            })
            .catch(error => {
                console.error('Si è verificato un errore durante l\'aggiornamento del valore:', error);
            });
        })


        messages.forEach(message=>{
            message.addEventListener('click', function(){
                let messageId = this.getAttribute('data-id');
                //console.log(messageId)
                let url = 'https://boolbnb-host.com/message/' + messageId + '/'+ false;
                console.log()
            axios.put(url, { }, 
            {
                headers: {
                    'X-CSRF-TOKEN': csrfToken, 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                //console.log(response.data)
                newMessages = response.data.results;
                newMessages.forEach((newMessage, index)=> {
                    //console.log(newMessage.is_read);
                    if(newMessage.is_read){
                        //console.log('messaggio letto')
                        if(newMessage.id == messages[index].getAttribute('data-id')){
                            //console.log(messages[index])
                           messages[index].classList.remove('new_message')
                        }
                    }
                
            })
            })
            .catch(error => {
                console.error('Si è verificato un errore durante l\'aggiornamento del valore:', error);
            });
            })
        
        })

        
    </script>
@endsection

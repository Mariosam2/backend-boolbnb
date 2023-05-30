@extends('layouts.user.log')

<!-- TODO fix stylesheet -->

@section('content')
    <div id="user_access" class="py-5">
        <div class="container">
            <div class="col-md-10  col-xl-7 mx-auto">

                <div class="content my-4 p-4 p-sm-5">
                    <!-- TODO add link correct -->
                    <a href="https://front.boolbnb-host.com/" class="close"></a>

                    <div class="logo">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 162.89 25.84">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #58cdf7;
                                    }

                                    .cls-2 {
                                        fill: #79f1b0;
                                    }

                                    .cls-3 {
                                        fill: url(#Sfumatura_senza_nome_3);
                                    }
                                </style>
                                <linearGradient id="Sfumatura_senza_nome_3" x1="22.29" y1="12.92" x2="67.58"
                                    y2="12.92" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#58cdf7" />
                                    <stop offset="1" stop-color="#79f1b0" />
                                </linearGradient>
                            </defs>
                            <g id="Livello_2" data-name="Livello 2">
                                <g id="Livello_1-2" data-name="Livello 1">
                                    <path class="cls-1"
                                        d="M0,25.69V.61H9.88c3,0,5.22.61,6.61,1.82a6.37,6.37,0,0,1,2.09,5.06A5.74,5.74,0,0,1,17.44,11a5.15,5.15,0,0,1-3.34,2v0a5.88,5.88,0,0,1,3.78,2,5.68,5.68,0,0,1,1.35,3.74,6.16,6.16,0,0,1-2.36,5.1Q14.52,25.69,10,25.69ZM4,11.4H9.58q4.78,0,4.78-3.69T9.58,4H4ZM4,22.31h6.23a5.53,5.53,0,0,0,3.59-1A3.41,3.41,0,0,0,15,18.54a3.39,3.39,0,0,0-1.2-2.77,5.53,5.53,0,0,0-3.59-1H4Z" />
                                    <path class="cls-2" d="M74.84,22.19H88.67v3.5H70.77V.61h4.07Z" />
                                    <path class="cls-2"
                                        d="M92.54,25.69V.61h9.88q4.52,0,6.61,1.82a6.37,6.37,0,0,1,2.09,5.06A5.74,5.74,0,0,1,110,11a5.17,5.17,0,0,1-3.35,2v0a5.9,5.9,0,0,1,3.79,2,5.72,5.72,0,0,1,1.34,3.74,6.15,6.15,0,0,1-2.35,5.1q-2.35,1.86-6.84,1.86Zm4-14.29h5.58q4.78,0,4.79-3.69T102.11,4H96.53Zm0,10.91h6.23a5.55,5.55,0,0,0,3.59-1,3.41,3.41,0,0,0,1.2-2.78,3.39,3.39,0,0,0-1.2-2.77,5.55,5.55,0,0,0-3.59-1H96.53Z" />
                                    <path class="cls-2"
                                        d="M137.25.61V25.69h-4.83L122.73,9.88,120.3,5.43h0l.16,4.07V25.69h-3.73V.61h4.79l9.65,15.77,2.47,4.52h0l-.15-4.1V.61Z" />
                                    <path class="cls-2"
                                        d="M143.66,25.69V.61h9.88c3,0,5.22.61,6.61,1.82a6.37,6.37,0,0,1,2.09,5.06A5.74,5.74,0,0,1,161.1,11a5.15,5.15,0,0,1-3.34,2v0a5.88,5.88,0,0,1,3.78,2,5.68,5.68,0,0,1,1.35,3.74,6.16,6.16,0,0,1-2.36,5.1q-2.35,1.86-6.84,1.86Zm4-14.29h5.58c3.2,0,4.79-1.23,4.79-3.69S156.43,4,153.23,4h-5.58Zm0,10.91h6.23a5.53,5.53,0,0,0,3.59-1,3.41,3.41,0,0,0,1.2-2.78,3.39,3.39,0,0,0-1.2-2.77,5.53,5.53,0,0,0-3.59-1h-6.23Z" />
                                    <path class="cls-3"
                                        d="M66.11,6A10.45,10.45,0,0,0,62,1.56,12.62,12.62,0,0,0,55.53,0a12.72,12.72,0,0,0-6.44,1.56A10.46,10.46,0,0,0,44.93,6a10.46,10.46,0,0,0-4.13-4.4A12.63,12.63,0,0,0,34.37,0a12.72,12.72,0,0,0-6.44,1.56A10.49,10.49,0,0,0,23.75,6a15.23,15.23,0,0,0-1.46,6.92,15.23,15.23,0,0,0,1.46,6.92,10.49,10.49,0,0,0,4.18,4.44,12.72,12.72,0,0,0,6.44,1.56,12.63,12.63,0,0,0,6.43-1.56,10.42,10.42,0,0,0,4.13-4.41,10.43,10.43,0,0,0,4.16,4.41,12.72,12.72,0,0,0,6.44,1.56A12.62,12.62,0,0,0,62,24.28a10.45,10.45,0,0,0,4.16-4.44,15.1,15.1,0,0,0,1.47-6.92A15.1,15.1,0,0,0,66.11,6ZM40.21,17.63A6.22,6.22,0,0,1,38,20.56a6.3,6.3,0,0,1-3.58,1,6.38,6.38,0,0,1-3.59-1,6.13,6.13,0,0,1-2.28-2.93,12.61,12.61,0,0,1-.78-4.71,12.61,12.61,0,0,1,.78-4.71,6.13,6.13,0,0,1,2.28-2.93,6.38,6.38,0,0,1,3.59-1,6.3,6.3,0,0,1,3.58,1,6.22,6.22,0,0,1,2.26,2.93A12.61,12.61,0,0,1,41,12.92,12.61,12.61,0,0,1,40.21,17.63Zm21.15,0a6.1,6.1,0,0,1-2.26,2.93,6.26,6.26,0,0,1-3.57,1,6.38,6.38,0,0,1-3.59-1,6.13,6.13,0,0,1-2.28-2.93,12.61,12.61,0,0,1-.78-4.71,12.61,12.61,0,0,1,.78-4.71,6.13,6.13,0,0,1,2.28-2.93,6.38,6.38,0,0,1,3.59-1,6.26,6.26,0,0,1,3.57,1,6.1,6.1,0,0,1,2.26,2.93,12.61,12.61,0,0,1,.78,4.71A12.61,12.61,0,0,1,61.36,17.63Z" />
                                </g>
                            </g>
                        </svg>
                    </div>

                    <div class="links">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a class="nav-link on" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf




                        <div class="column  flex-wrap justify-content-early">
                            <div class="column_el px-2 flex-grow-1 col-12 col-sm-6 ">
                                <label for="name" class="col-form-label text-md-right">{{ __('Nome') }}</label>
                                <input id="name" type="text"
                                    class="form-control col-sm-12 col-md-5 @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="column_el px-2 flex-grow-1 col-12 col-sm-6">
                                <label for="surname" class="col-form-label text-md-right">{{ __('Cognome') }}</label>
                                <input id="surname" type="text"
                                    class="form-control col-sm-12 col-md-5 @error('surname') is-invalid @enderror"
                                    name="surname" value="{{ old('surname') }}" autocomplete="surname" autofocus>
                                @error('surname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">

                            <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address*') }}</label>
                            <input id="email" type="email" class="form-control  @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="column gx-3 flex-wrap justify-content-early">
                            <div class="column_el px-2 flex-grow-1 col-12 col-sm-6">
                                <label for="password" class="col-form-label text-md-right">{{ __('Password*') }}</label>
                                <input id="password" type="password"
                                    class="form-control col-sm-12 col-md-5 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="column_el px-2 flex-grow-1 col-12 col-sm-6">
                                <label for="password-confirm"
                                    class="col-form-label text-md-right">{{ __('Confirm Password*') }}</label>
                                <input id="password-confirm" type="password" class="form-control col-sm-12 col-md-5"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <label for="birth_date" class="col-form-label text-md-right">Data di Nascita</label>
                        <input type="date" name="birth_date" id="birth_date"
                            class="form-control  @error('birth_date') is-invalid @enderror" placeholder=""
                            value="{{ old('surname') }}" aria-describedby="helpId">
                        @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <div class="send">
                            <button type="submit" class="button btn ">
                                {{ __('Registrati') }}
                            </button>
                        </div>
                </div>


                </form>
            </div>
        </div>


    </div>
    </div>

    </div>
@endsection

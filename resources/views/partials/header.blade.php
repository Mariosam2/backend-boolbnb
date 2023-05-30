<nav class="navbar navbar-expand-md d-block d-xl-none ms_navbar px-0 px-md-4  shadow-sm fixed-top">
    <div class="container-fluid">
        <a style="width: 200px" class="navbar-brand " href="{{ url('/') }}">
            <img class="img-fluid" src="{{ asset('assets/boolbnb-white.svg') }}" alt="">
            <!-- {{-- config('app.name', 'Laravel') --}} -->
        </a>

        <button class="navbar-toggler ms_navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                <path
                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
            </svg>
        </button>

        <div class="collapse navbar-collapse text-white" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav ms-auto ms_navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apartments.index') }}">{{ __('Apartments') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('apartments.messages') }}">{{ __('Messaggi') }}</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link ms_nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if (Auth::user()->name)
                                {{ Auth::user()->name }}
                            @else
                                {{ 'user' }}
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-start ms_logout mt-0" id="ms_dropdown"
                            aria-labelledby="navbarDropdown">
                            {{-- <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">{{ __('Dashboard') }}</a> --}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse ms_sidebar p-2 p-md-3 p-xxl-5">
    <div class="position-sticky pt-3 sidebar-sticky h-100 d-flex flex-column">
        <img src="{{ asset('assets/boolbnb-white.svg') }}" alt="">
        <ul class="nav flex-column mt-5">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link active">
                    <span class="align-text-bottom"></span>
                    <i class="fa-solid fa-chart-line fa-fw"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('apartments.index') }}" class="nav-link active">
                    <span class="align-text-bottom"></span>
                    <i class="fa-solid fa-house fa-fw"></i></i>Appartamenti
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('apartments.messages') }}" class="nav-link active">
                    <span class="align-text-bottom"></span>
                    <i class="fa-solid fa-envelope fa-fw"></i></i></i>Messaggi
                </a>
            </li>
        </ul>
        <ul class="nav flex-column mt-auto">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <span class="align-text-bottom"></span>
                    <i class="fa-solid fa-gear fa-fw"></i></i>Impostazioni
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="nav-link active">
                    <span class="align-text-bottom"></span>
                    <i class="fa-solid fa-arrow-right-from-bracket fa-fw"></i></i>Log out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>

    </div>
</nav>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse ms_sidebar p-2 p-md-3 p-xxl-5">
    <div class="position-sticky pt-3 sidebar-sticky h-100 d-flex flex-column">
        <h1 class="text-uppercase text_lighter font_secondary mb-5">
            B<svg class="infinite_logo" version="1.0" xmlns="http://www.w3.org/2000/svg" width="64.000000pt"
                height="64.000000pt" viewBox="0 0 64.000000 64.000000" preserveAspectRatio="xMidYMid meet">

                <g transform="translate(0.000000,64.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                    <path
                        d="M85 440 c-23 -11 -48 -33 -58 -49 -22 -37 -22 -105 0 -142 18 -30 84
           -69 118 -69 30 0 98 38 118 66 26 35 13 43 -21 12 -56 -53 -105 -61 -158 -29
           -90 55 -47 201 59 201 46 0 79 -24 170 -120 84 -89 141 -130 181 -130 11 0 39
           9 62 20 99 48 99 192 0 240 -23 11 -51 20 -61 20 -30 0 -98 -38 -118 -66 -26
           -35 -13 -43 21 -12 56 53 105 61 158 29 66 -40 66 -142 0 -182 -69 -42 -112
           -23 -229 101 -84 90 -141 130 -182 130 -11 0 -38 -9 -60 -20z" />
                </g>
            </svg>lBnB
        </h1>
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
                <a href="#" class="nav-link active">
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

<!-- HEADER DESKTOP-->
<header class="header-desktop2">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap2">
                <div class="logo d-block d-lg-none">
                    <a href="#">
                        <img src="{{ asset('logo-white.png') }}" class="w-50" alt="CoolAdmin" />
                    </a>
                </div>
                <div class="header-button2">
                    <div class="header-button-item">
                        <a class="bntCerrarSesion cursor-pointer" data-toggle="tooltip" title="Cerrar sesión">
                            <i class="fa fa-power-off text-md"></i>
                        </a>
                    </div>

                    <div class="header-button-item mr-0 js-sidebar-btn">
                        <i class="zmdi zmdi-menu"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<aside class="menu-sidebar2 js-right-sidebar d-block d-lg-none">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('logo-white.png') }}" alt="Cool Admin" />
        </a>
    </div>
    <div class="menu-sidebar2__content js-scrollbar2">
        <div class="account2">
            <div class="image img-cir img-120">
                <img src="{{ imageRouteAvatar(Auth::user()->avatar, 1) }}" alt="{{ Auth::user()->name." ".Auth::user()->ap_paterno }} " />
            </div>
            <h4 class="name text-center">{{ Auth::user()->name." ".Auth::user()->ap_paterno }}</h4>
            <a href="/perfil_usuario" class="cursor-pointer font-weight-bold text-primary">Ver perfil de usuario</a>
        </div>
        <nav class="navbar-sidebar2">
            @include('layouts.sections.menuList')
        </nav>
    </div>
</aside>
<aside class="menu-sidebar2">
    <div class="logo">
        <img src="{{ asset('logo.png') }}" class="white-image" alt="Cool Admin" />
    </div>
    <div class="menu-sidebar2__content js-scrollbar1">
        <div class="account2">
            <div class="image img-cir img-120">
                <img src="{{ asset('avatar.png') }}" alt="{{ Auth::user()->name." ".Auth::user()->ap_paterno }} " />
            </div>
            <h4 class="name text-center">{{ Auth::user()->name." ".Auth::user()->ap_paterno }} </h4>
            <a class="bntCerrarSesion cursor-pointer font-weight-bold text-secondary">Cerrar sesión</a>
        </div>
        <nav class="navbar-sidebar2">
            @include('layouts.sections.menuList')
        </nav>
    </div>
</aside>
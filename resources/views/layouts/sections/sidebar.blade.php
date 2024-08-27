<aside class="menu-sidebar2">
    <div class="logo text-center">
        <center>
        <img src="{{ asset('logo2.png') }}" alt="Cool Admin" class="w-75" />
    </center>
    </div>
    <div class="menu-sidebar2__content js-scrollbar1">
        <div class="account2">
            <div class="image img-cir img-120">
                <img src="{{ imageRouteAvatar(Auth::user()->avatar, 1) }}" alt="{{ Auth::user()->name." ".Auth::user()->ap_paterno }} " />
            </div>
            <h4 class="name text-center">{{ Auth::user()->name." ".Auth::user()->ap_paterno }} </h4>
            <span>{{ Auth::user()->rolUser->name }}</span>
            <a href="/perfil_usuario" class="cursor-pointer font-weight-bold text-primary">Ver perfil de usuario</a>
        </div>
        <nav class="navbar-sidebar2">
            @include('layouts.sections.menuList')
        </nav>
    </div>
</aside>
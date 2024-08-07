<ul class="list-unstyled navbar__list">
    <li class=" {{ strstr($item,'.',true) == '0' ? 'active font-weight-bold' : '' }} ">
        <a href="/">
            <i class="fas fa-home"></i>Inicio
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '1' ? 'active font-weight-bold' : '' }} ">
        <a href="/">
            <i class="fas fa-list-alt"></i>Novedades
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '2' ? 'active font-weight-bold' : '' }} ">
        <a href="/cuentas">
            <i class="fas fa-list-ul"></i>Cuentas
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '3' ? 'active font-weight-bold' : '' }} ">
        <a href="/">
            <i class="fas fa-car-side"></i>Vehículos
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '4' ? 'active font-weight-bold' : '' }} ">
        <a href="/regionales">
            <i class="fas fa-city"></i>Regionales
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '5' ? 'active font-weight-bold' : '' }} ">
        <a href="/users">
            <i class="fas fa-user"></i>Usuarios
        </a>
    </li>

    {{-- <li class="has-sub">
        <a class="js-arrow" href="#">
            <i class="fas fa-trophy"></i>Features
            <span class="arrow">
                <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="list-unstyled navbar__sub-list js-sub-list">
            <li>
                <a href="table.html">
                    <i class="fas fa-table"></i>Tables</a>
            </li>
            <li>
                <a href="form.html">
                    <i class="far fa-check-square"></i>Forms</a>
            </li>
            <li>
                <a href="calendar.html">
                    <i class="fas fa-calendar-alt"></i>Calendar</a>
            </li>
            <li>
                <a href="map.html">
                    <i class="fas fa-map-marker-alt"></i>Maps</a>
            </li>
        </ul>
    </li> --}}

</ul>
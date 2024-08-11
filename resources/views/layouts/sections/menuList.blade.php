<ul class="list-unstyled navbar__list">
    <li class=" {{ strstr($item,'.',true) == '0' ? 'active font-weight-bold' : '' }} ">
        <a href="/">
            <i class="fas fa-home"></i>Inicio
        </a>
    </li>

    <li class=" {{ strstr($item,'.',true) == '1' ? 'active font-weight-bold' : '' }} ">
        <a href="/novedades">
            <i class="fas fa-list-alt"></i>Novedades
        </a>
    </li>

    @php
        $activeMenuCuentasPadre = strstr($item,'.',true) == '2';
    @endphp
    <li class="has-sub @if($activeMenuCuentasPadre) active @endif">
        <a class="js-arrow" href="#">
            <i class="fas fa-list-ul"></i>Cuentas
            <span class="arrow @if($activeMenuCuentasPadre) up @endif">
                <i class="fas fa-angle-down"></i>
            </span>
        </a>
        <ul class="list-unstyled navbar__sub-list js-sub-list" style="@if($activeMenuCuentasPadre) display:block @endif">
            <li class="{{ strstr($item,':',true) == '2.0' ? 'active font-weight-bold' : '' }}">
                <a href="/clientes">
                    <i class="fas fa-user-tie"></i>Clientes
                </a>
            </li>
            <li class="{{ strstr($item,':',true) == '2.1' ? 'active font-weight-bold' : '' }}">
                <a href="/cuentas">
                    <i class="fa fa-list-ul"></i>Ver cuentas
                </a>
            </li>
        </ul>
    </li>

    <li class=" {{ strstr($item,'.',true) == '3' ? 'active font-weight-bold' : '' }} ">
        <a href="/vehiculos">
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



</ul>
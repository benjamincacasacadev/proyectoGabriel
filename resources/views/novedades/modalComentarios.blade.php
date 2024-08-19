    <div class="modal-status bg-info"></div>
    <div class="modal-body pt-4 px-4">
        {{-- SI LA CUENTA TIENE REGISTROS ASOCIADOS NO PERMITIR ELIMINAR REGISTRO --}}
        <div class="text-center mt-2">
            <i class="fa fa-comment-dots icon text-info icon-lg" style="font-size:50px"></i>
        </div>
        <div class="text-muted text-lg text-center">
            Comentarios: <b>{{ $novedad->cod }}</b>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left mt-2 text-sm">
            @if (isset($novedad->contacto_cuenta_id))
                <b>Cliente: </b> {{ $novedad->contacto->cuenta->cliente->nombre }}
                <br><b>Cuenta: </b> {{ $novedad->contacto->cuenta->nombre_cuenta }}
                <br><b>Contacto: </b> {{ $novedad->contacto->nombre_contacto }}
                <br><b>Cargo: </b> {{ $novedad->contacto->cargo_contacto }}
                <br><b>Celular: </b> {{ $novedad->contacto->celular_contacto }}
                <br><b>Email: </b> {{ $novedad->contacto->email_contacto }}
            @endif

            @if (isset($novedad->conductor_vehiculo_id))
                <b>Vehículo: </b> {{ $novedad->conductor->vehiculo->nombre_vehiculo }}
                <br><b>Placa de vehículo: </b> {{ $novedad->conductor->vehiculo->matricula }}
                <br><b>Conductor</b> {{ $novedad->conductor->nombre_conductor }}
                <br><b>Celular</b> {{ $novedad->conductor->celular_conductor }}
            @endif
            @if (isset($novedad->zona_alarma))
                <br><b>Datos de alarma</b>
                <br><b>Zona: </b> {{ $novedad->zona_alarma }}
                <br><b>Sensor: </b> {{ $novedad->sensor_alarma }}
                <br><b>Ubicación: </b> {{ $novedad->ubicacion_alarma }}
            @endif
            @if (isset($novedad->comentarios))
                <br><b>Comentarios adicionales:</b> <br>
                {!! nl2br($novedad->comentarios) !!}
            @endif

            @if ($novedad->estado == 'C' && isset($novedad->nombre_autorizador))
                <br><b>Autorizado por: </b> {{ $novedad->nombre_autorizador }}
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="col-12">
                    <a class="w-100 au-btn btn-outline-secondary border border-secondary text-center" data-dismiss="modal">
                        Cerrar
                    </a>
                </div>
            </div>
        </div>
    </div>


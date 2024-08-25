
<table>
    <thead>
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>LISTA DE DE NOVEDADES</th>
        </tr>
        <tr>
            <th>COD</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>DÍA</th>
            <th>OPERADOR</th>
            <th>ÁMBITO</th>
            <th>EVENTO</th>
            <th>CUENTA / MATRICULA</th>
            <th>REGIONAL</th>
            <th>DEPARTAMENTO</th>
            <th>Paf</th>
            <th>ACCIONES</th>
            <th>REPORTADO A</th>
            <th>ESTADO</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($novedades as $novedad)
            <tr>
                @php
                    $fecha = Carbon\Carbon::parse($novedad->fecha_novedad);
                    $diaLiteral = mb_strtoupper($fecha->locale('es')->isoFormat('dddd'));

                    $estado = 'EN SEGUIMIENTO';
                    if($novedad->estado == 'C'){
                        $estado = 'CERRADO';
                    }

                    $paf = '';
                    // ACCIONES (COMENTARIOS)
                    $comentariosHTML = '';
                    if (isset($novedad->contacto_cuenta_id)){
                        $comentariosHTML .= 'CLIENTE: '. $novedad->contacto->cuenta->cliente->nombre;
                        $comentariosHTML .= '<br>CONTACTO: '. $novedad->contacto->nombre_contacto;
                        $comentariosHTML .= '<br>ASIGNACIÓN: '. $novedad->contacto->getInfoAsignacion();
                        $comentariosHTML .= '<br>CARGO: '. $novedad->contacto->cargo_contacto;
                        $comentariosHTML .= '<br>CELULAR: '. $novedad->contacto->celular_contacto;
                        $comentariosHTML .= '<br>EMAIL: '. $novedad->contacto->email_contacto;

                        $paf = $novedad->contacto->cuenta->nombre_cuenta;
                    }

                    if (isset($novedad->conductor_vehiculo_id)){
                        $comentariosHTML .= 'VEHÍCULO: '.$novedad->conductor->vehiculo->nombre_vehiculo;
                        $comentariosHTML .= '<br>CONDUCTOR: '.$novedad->conductor->nombre_conductor;
                        $comentariosHTML .= '<br>CELULAR: '.$novedad->conductor->celular_conductor;

                        $paf = $novedad->conductor->vehiculo->matricula;
                    }
                    if (isset($novedad->zona_alarma)){
                        $comentariosHTML .= '<br>ZONA: '.$novedad->zona_alarma;
                        $comentariosHTML .= '<br>SENSOR: '.$novedad->sensor_alarma;
                        $comentariosHTML .= '<br>UBICACIÓN: '.$novedad->ubicacion_alarma;
                    }
                    if (isset($novedad->comentarios)){
                        $comentariosHTML .= '<br>'.nl2br($novedad->comentarios);
                    }
                    if ($novedad->estado == 'C' && isset($novedad->nombre_autorizador)){
                        $comentariosHTML .= '<br>AUTORIZADOR POR: '.$novedad->nombre_autorizador;
                    }
                @endphp

                <td>{{ $novedad->cod }}</td>
                <td>{{ date('d/m/Y', strtotime($novedad->fecha_novedad)) }}</td>
                <td>{{ date('H:i', strtotime($novedad->fecha_novedad)) }}</td>
                <td>{{ $diaLiteral }}</td>
                <td>{{ $novedad->operador->fullName }}</td>
                <td>{{ $novedad->nameAmbito() }}</td>
                <td>{{ $novedad->nameEvento(false) }}</td>
                <td>{{ $novedad->getCuentaMatricula(false) }}</td>
                <td>{{ $novedad->getRegional() }}</td>
                <td>{{ $novedad->getDepartamento() }}</td>
                <td>{{ $paf }} </td>
                <td>{!! $comentariosHTML !!}</td>
                <td>{{ $novedad->reportado->fullName }}</td>
                <td>{{ $estado }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

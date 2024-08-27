<link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">
<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar novedad: {{ $novedad->cod }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    {{Form::Open(array('action'=>array('NovedadesController@update',code($novedad->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarNovedad', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="fechaNovedadedit--label">
                    <span>* Fecha y hora de novedad</span>
                </label> <br>
                <div class='input-group date datetimepicker p-0'>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    <input type='text' class="form-control" name="fechaNovedadedit" placeholder="dd/mm/YYYY HH:mm" value="{{ date('d/m/Y H:i', strtotime($novedad->fecha_novedad)) }}">
                </div>
                <span id="fechaNovedadedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group" id="operadoredit-sel2">
                <label id="operadoredit--label">* Operador</label> <br>
                @if (permisoAdministrador())
                    <select name="operadoredit" class="form-control selector-modal-edit" style="width: 100%">
                        <option value="">Seleccionar</option>
                        @foreach($operadores as $operador)
                            @php
                                $selected = '';
                                if($operador->id == $novedad->operador_id){
                                    $selected = 'selected';
                                }
                            @endphp
                            <option value="{{ code($operador->id) }}" {{ $selected }}> {{ $operador->fullName }} </option>
                        @endforeach
                    </select>
                @else
                    <input class="form-control" type="text" value="{{ userFullName(userId()) }}" disabled>
                    <input type="text" name="operadoredit" value="{{ code(userId()) }}" hidden>
                @endif
                <span id="operadoredit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group" id="ambitoedit-sel2">
                <label id="ambitoedit--label">* Ámbito</label> <br>
                <select name="ambitoedit" class="form-control selector-modal-edit selectAmbitoEdit" style="width: 100%">
                    <option value="">Seleccionar</option>
                    @foreach(listaAmbitos() as $key => $ambito)
                        @php
                            $selected = '';
                            if($key == $novedad->ambito){
                                $selected = 'selected';
                            }
                        @endphp
                        <option value="{{ $key }}" {{ $selected }}> {{ $ambito }} </option>
                    @endforeach
                </select>
                <span id="ambitoedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="form-group" id="eventoedit-sel2">
                <label id="eventoedit--label">* Evento</label> <br>
                <select name="eventoedit" class="form-control selector-modal-edit selectEventoEdit" style="width: 100%">
                    <option value="">Seleccionar</option>
                    @foreach(listaEventos() as $key => $evento)
                        @php
                            $selected = '';
                            if($key == $novedad->evento){
                                $selected = 'selected';
                            }
                        @endphp
                        <option value="{{ $key }}" {{ $selected }}> {{ $evento }} </option>
                    @endforeach
                </select>
                <span id="eventoedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divAlarmaEdit hidden">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <b class="text-primarydark" id="titleCuentaEdit">Datos de alarma</b>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-form-label" id="zonaedit--label">* Zona</label> <br>
                                <input class="form-control" name="zonaedit" type="text" placeholder="Zona" value="{{ $novedad->zona_alarma }}">
                                <span id="zonaedit-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-form-label" id="sensoredit--label">* Sensor</label> <br>
                                <input class="form-control" name="sensoredit" type="text" placeholder="Sensor" value="{{ $novedad->sensor_alarma }}">
                                <span id="sensoredit-error" class="text-red"></span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-form-label" id="ubicacionedit--label">* Ubicación</label> <br>
                                <input class="form-control" name="ubicacionedit" type="text" placeholder="Ubicación" value="{{ $novedad->ubicacion_alarma }}">
                                <span id="ubicacionedit-error" class="text-red"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <b class="text-primarydark" style="font-size:20px" id="titleCuentaEdit">Datos de cuenta</b>
                        </div>
                        @php
                            $cuentaId = $novedad->contacto->cuenta_id ?? '';
                        @endphp

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectCuentaEdit">
                            <div class="" id="cuentaedit-sel2">
                                <label id="cuentaedit--label">* Código de cuenta</label>
                                <select name="cuentaedit" class="form-control form-select selector-cuenta-edit" style="width: 100%">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($cuentas as $cuenta)
                                        @php
                                            $selected = '';
                                            if($cuenta->id == $cuentaId){
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $cuenta->id }}" data-info="{{ $cuenta->getInfoCuentas() }}" {{ $selected }}>{{ $cuenta->cod.' - '.$cuenta->nombre_cuenta }}</option>
                                    @endforeach
                                </select>
                                <span id="cuentaedit-error" class="text-red"></span>
                            </div>
                            <div class="divInfoCuentaEdit" @if ($cuentaId == '') style="display:none" @endif>
                                @if ($cuentaId != '')
                                    {!! $novedad->contacto->cuenta->getInfoCuentas() !!}
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectCuentaEdit">
                            <div class="" id="contactoedit-sel2">
                                <label id="contactoedit--label">* Contacto</label>
                                <select name="contactoedit" class="form-control selector-contacto-edit" style="width:100%">
                                    <option value="">Seleccionar</option>
                                    @if ($cuentaId != '')
                                        <option value="{{ code($novedad->contacto_cuenta_id) }}" selected id="optSelectContacto">{{ $novedad->contacto->nombre_contacto }}</option>
                                    @endif
                                </select>
                                <span id="contactoedit-error" class="text-red"></span>
                            </div>
                            <div class="divInfoContactoEdit" @if ($cuentaId == '') style="display:none" @endif>
                                @if ($cuentaId != '')
                                    {!! $novedad->contacto->getInfoContactos() !!}
                                @endif
                            </div>
                        </div>

                        @php
                            $vehiculoId = $novedad->conductor->vehiculo_id ?? '';
                        @endphp
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectVehiculoEdit hidden">
                            <div id="vehiculoedit-sel2">
                                <label id="vehiculoedit--label">* Matricula de vehículo</label>
                                <select name="vehiculoedit" class="form-control form-select selector-vehiculo-edit" style="width: 100%">
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($vehiculos as $vehiculo)
                                        @php
                                            $selected = '';
                                            if($vehiculo->id == $vehiculoId){
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $vehiculo->id }}" data-info="{{ $vehiculo->getInfoVehiculos() }}" {{ $selected }}>{{ $vehiculo->matricula.' - '.$vehiculo->nombre_vehiculo }}</option>
                                    @endforeach
                                </select>
                                <span id="vehiculoedit-error" class="text-red"></span>
                            </div>
                            <div class="divInfoVehiculoEdit" @if ($vehiculoId == '') style="display:none" @endif>
                                @if ($vehiculoId != '')
                                    {!! $novedad->conductor->vehiculo->getInfoVehiculos() !!}
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectVehiculoEdit hidden">
                            <div class="" id="conductoredit-sel2">
                                <label id="conductoredit--label">* Conductor</label>
                                <select name="conductoredit" class="form-control selector-conductor-edit" style="width:100%">
                                    <option value="">Seleccionar</option>
                                    @if ($vehiculoId != '')
                                        <option value="{{ code($novedad->conductor_vehiculo_id) }}" selected id="optSelectConductor">{{ $novedad->conductor->nombre_conductor }}</option>
                                    @endif
                                </select>
                                <span id="conductoredit-error" class="text-red"></span>
                            </div>
                            <div class="divInfoConductorEdit" @if ($vehiculoId == '') style="display:none" @endif>
                                @if ($vehiculoId != '')
                                    {!! $novedad->conductor->getInfoConductores() !!}
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                            <div class="form-group" id="reportadoedit-sel2">
                                <label id="reportadoedit--label">* Reportado a</label> <br>
                                <select name="reportadoedit" class="form-control selector-modal-edit" style="width: 100%">
                                    <option value="">Seleccionar</option>
                                    @foreach($administrativos as $administrativo)
                                        @php
                                            $selected = '';
                                            if($administrativo->id == $novedad->reportado_id){
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ code($administrativo->id) }}" {{ $selected }}> {{ $administrativo->fullName }} </option>
                                    @endforeach
                                </select>
                                <span id="reportadoedit-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="col-form-label" id="comentarioedit--label">Comentarios adicionales</label> <br>
                                <textarea name="comentarioedit"  rows="2" class="form-control" style="width:100%;resize:none" placeholder="Comentarios adicionales">{!! $novedad->comentarios !!}</textarea>
                                <span id="comentarioedit-error" class="text-red"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divAutorizadoEdit">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                            <label class="text-primarydark cursor-pointer font-weight-bold">
                                @php
                                    $checked = '';
                                    if(isset($novedad->nombre_autorizador)){
                                        $checked = 'checked';
                                    }
                                @endphp
                                ¿Está autorizado?
                                <input type="checkbox" class="checkAutorizadoedit" name="checkAutorizadoedit" value="1" {{ $checked }}>
                            </label>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divInputAutorizadoredit hidden mb-2">
                            <div class="form-group">
                                <label class="col-form-label" id="autorizadoredit--label">* Nombre de autorizador</label> <br>
                                <input class="form-control" name="autorizadoredit" type="text" placeholder="Nombre de autorizador" value="{{ $novedad->nombre_autorizador }}">
                                <span id="autorizadoredit-error" class="text-red"></span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divInputAutorizadoredit hidden mb-2">
                            <div class="form-group" id="estadoedit-sel2">
                                <label id="estadoedit--label">* Estado</label> <br>
                                <select name="estadoedit" class="form-control selector-modal-edit" style="width: 100%">
                                    <option value="">Seleccionar</option>
                                    <option value="C" @if($novedad->estado == 'C') selected @endif>Cerrado</option>
                                    <option value="S" @if($novedad->estado == 'S') selected @endif>Seguimiento por operador entrante</option>
                                </select>
                                <span id="estadoedit-error" class="text-red"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primarydark pull-right" name="botonEditar">Modificar</button>
        </div>
    </div>
    {{Form::Close()}}
</div>

<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');

        // Si el ambito es vehiculo
        var valAmbito = $('.selectAmbitoEdit').val();
        if(valAmbito == '3'){
            $('.divSelectVehiculoEdit').show();
            $('.divSelectCuentaEdit').hide();
            $('#titleCuentaEdit').text('Datos de vehículo');
        }else{
            $('.divSelectVehiculoEdit').hide();
            $('.divSelectCuentaEdit').show();
            $('#titleCuentaEdit').text('Datos de cuenta');
        }

        // Si el evento es alarma
        var valEvento = $('.selectEventoEdit').val();
        if(valEvento == '1'){
            $('.divAlarmaEdit').show();
            $('.divAutorizadoEdit').hide();
        }else{
            $('.divAlarmaEdit').hide();
            $('.divAutorizadoEdit').show();
        }

        if($(".checkAutorizadoedit").prop('checked')) {
            $('.divInputAutorizadoredit').show();
        }else{
            $('.divInputAutorizadoredit').hide();
        }
    });

    $('.datetimepicker').datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        autoclose: true,
        endDate: '{{now()}}',
    });

    // SELECT 2 GENERAL
    $('select.selector-modal-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
        });
    });

    $('.checkAutorizadoedit').iCheck({
        checkboxClass: 'icheckbox_square-blue',
    }).on('ifChecked', function (event) {
        $('.divInputAutorizadoredit').show();
    }).on('ifUnchecked', function (event){
        $('.divInputAutorizadoredit').hide();
    });
</script>

<script>
    $('.selectAmbitoEdit').change(function () {
        var val = $(this).val();

        // Si el ambito es vehiculo
        if(val == '3'){
            $('.divSelectVehiculoEdit').show();
            $('.divSelectCuentaEdit').hide();
            $('#titleCuentaEdit').text('Datos de vehículo');
        }else{
            $('.divSelectVehiculoEdit').hide();
            $('.divSelectCuentaEdit').show();
            $('#titleCuentaEdit').text('Datos de cuenta');
        }
    });

    $('.selectEventoEdit').change(function () {
        var val = $(this).val();

        // Si el ambito es vehiculo
        if(val == '1'){
            $('.divAlarmaEdit').show();
            $('.divAutorizadoEdit').hide();
        }else{
            $('.divAlarmaEdit').hide();
            $('.divAutorizadoEdit').show();
        }
    });

</script>

<script>
    // =================================================
    // FUNCIONES PARA SELECT DE CUENTAS
    // =================================================
    function formatCuentaSelect(cuenta) {
        var cuentaExtraSelect = $(cuenta.element).data('info');

        if (typeof cuentaExtraSelect === 'undefined') {
            return cuenta.text;
        }
        var salidaHTML = "";
        if(cuentaExtraSelect != ""){
            salidaHTML = cuentaExtraSelect;
        }

        var $cuenta = $(
            '<span><b>' + cuenta.text + '</b>' + salidaHTML + '</span>'
        );
        return $cuenta;
    };

    $('select.selector-cuenta-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatCuentaSelect,
        });
    });

    $('.selector-cuenta-edit').change(function () {
        $('.selector-contacto-edit').val('').trigger('change');
        var data = $('.selector-cuenta-edit').select2('data')[0];
        var infoAdd = $(data.element).data('info');
        var info;
        if (typeof infoAdd === 'undefined') {
            info = '';
            $(".divInfoCuentaEdit").hide();
            $(".divInfoCuentaEdit").removeClass('mb-2');
        }else{
            info = infoAdd;
            $(".divInfoCuentaEdit").show();
            $(".divInfoCuentaEdit").addClass('mb-2');
        }
        $(".divInfoCuentaEdit").html(info);
    });

    // ===========================================================
    // FUNCIONES PARA SELECT DE CONTACTOS EN FUNCION DE CUENTAS
    // ============================================================
    function formatContactoCuentas (state) {
        var info;
        if (typeof state.info === 'undefined') {
            info = "";
        }else{
            info = state.info;
        }

        var $state = $(
            '<span><b>' + state.text + '</b>' + info + '</span>'
        );
        return $state;
    };

    $('select.selector-contacto-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            placeholder:'Busque el contacto con el que se comunico',
            templateResult: formatContactoCuentas,
            ajax: {
                url: "{{ route('contactos.listContactos.detalles') }}",
                dataType: 'json',
                method: "GET",
                delay: 500,
                data: function (params) {
                    var query = {
                        search: params.term,
                        cuenta: $('.selector-cuenta-edit').val(),
                        page: params.page || 5
                    }
                    return query;
                },
                processResults: function(data, params){
                    data = data.results.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text,
                            info: item.info,
                        };
                    });
                    return { results: data };
                },
            }
        });
    });

    $('.selector-contacto-edit').change(function () {
        $('#optSelectContacto').remove();
        var val = $(this).val();
        var data = $('.selector-contacto-edit').select2('data')[0];
        var info;
        if (typeof data.info === 'undefined') {
            info = "";
            $(".divInfoContactoEdit").hide();
            $(".divInfoContactoEdit").removeClass('mb-2');
        }else{
            info = data.info;
            $(".divInfoContactoEdit").show();
            $(".divInfoContactoEdit").addClass('mb-2');
        }
        $(".divInfoContactoEdit").html(info);
    });

</script>

<script>
    // =================================================
    // FUNCIONES PARA SELECT DE VEHICULOS
    // =================================================
    function formatVehiculoSelect(vehiculo) {
        var vehiculoExtraSelect = $(vehiculo.element).data('info');

        if (typeof vehiculoExtraSelect === 'undefined') {
            return vehiculo.text;
        }
        var salidaHTML = "";
        if(vehiculoExtraSelect != ""){
            salidaHTML = vehiculoExtraSelect;
        }

        var $vehiculo = $(
            '<span><b>' + vehiculo.text + '</b>' + salidaHTML + '</span>'
        );
        return $vehiculo;
    };

    $('select.selector-vehiculo-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatVehiculoSelect,
        });
    });

    $('.selector-vehiculo-edit').change(function () {
        $('.selector-conductor-edit').val('').trigger('change');
        var data = $('.selector-vehiculo-edit').select2('data')[0];
        var infoAdd = $(data.element).data('info');
        var info;
        if (typeof infoAdd === 'undefined') {
            info = '';
            $(".divInfoVehiculoEdit").hide();
            $(".divInfoVehiculoEdit").removeClass('mb-2');
        }else{
            info = infoAdd;
            $(".divInfoVehiculoEdit").show();
            $(".divInfoVehiculoEdit").addClass('mb-2');
        }
        $(".divInfoVehiculoEdit").html(info);
    });

    // ===========================================================
    // FUNCIONES PARA SELECT DE CONDUCTORES EN FUNCION DE VEHICULOS
    // ============================================================
    function formatConductorVehiculos (state) {
        var info;
        if (typeof state.info === 'undefined') {
            info = "";
        }else{
            info = state.info;
        }

        var $state = $(
            '<span><b>' + state.text + '</b>' + info + '</span>'
        );
        return $state;
    };

    $('select.selector-conductor-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            placeholder:'Busque el conductor con el que se comunico',
            templateResult: formatConductorVehiculos,
            ajax: {
                url: "{{ route('conductores.listConductores.detalles') }}",
                dataType: 'json',
                method: "GET",
                delay: 500,
                data: function (params) {
                    var query = {
                        search: params.term,
                        vehiculo: $('.selector-vehiculo-edit').val(),
                        page: params.page || 5
                    }
                    return query;
                },
                processResults: function(data, params){
                    data = data.results.map(function (item) {
                        return {
                            id: item.id,
                            text: item.text,
                            info: item.info,
                        };
                    });
                    return { results: data };
                },
            }
        });
    });

    $('.selector-conductor-edit').change(function () {
        $('#optSelectConductor').remove();
        var val = $(this).val();
        var data = $('.selector-conductor-edit').select2('data')[0];
        var info;
        if (typeof data.info === 'undefined') {
            info = "";
            $(".divInfoConductorEdit").hide();
            $(".divInfoConductorEdit").removeClass('mb-2');
        }else{
            info = data.info;
            $(".divInfoConductorEdit").show();
            $(".divInfoConductorEdit").addClass('mb-2');
        }
        $(".divInfoConductorEdit").html(info);
    });

</script>

<script>
    var camposNormales = ['fechaNovedadedit','operadoredit','ambitoedit','eventoedit'];
    var camposSensor = ['zonaedit','sensoredit','ubicacionedit'];
    var camposCuenta = ['cuentaedit','contactoedit'];
    var camposVehiculos = ['vehiculoedit','conductoredit'];
    var camposNormales2 = ['reportadoedit','comentarioedit'];
    var camposAutorizador = ['checkAutorizadoedit','autorizadoredit','estado'];

    var camposFinal = [
        ...camposNormales,
        ...camposSensor,
        ...camposCuenta,
        ...camposVehiculos,
        ...camposNormales2,
        ...camposAutorizador
    ];
    ValidateAjax("formEditarNovedad",camposFinal,"botonEditar","{{ route('novedades.update',code($novedad->id) )}}","POST","/novedades");
</script>
<link rel="stylesheet" href="{{asset('/plugins/iCheck/all.css')}}">
{!! Form::open( array('route' =>'novedades.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearNovedad', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="fechaNovedad--label">
                <span>* Fecha y hora de novedad</span>
            </label> <br>
            <div class='input-group date datetimepicker p-0'>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                <input type='text' class="form-control" name="fechaNovedad" placeholder="dd/mm/YYYY HH:mm" value="{{ date('d/m/Y H:i') }}">
            </div>
            <span id="fechaNovedad-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group" id="operador-sel2">
            <label id="operador--label">* Operador</label> <br>
            <select name="operador" class="form-control selector-modal" style="width: 100%">
                <option value="">Seleccionar</option>
                @foreach($operadores as $operador)
                    @php
                        // SELECCIONAR EL USUARIO LOGEADO POR DEFECTO
                        $selected = '';
                        if($operador->id == userId()){
                            $selected = 'selected';
                        }
                    @endphp
                    <option value="{{ code($operador->id) }}" {{ $selected }}> {{ $operador->fullName }} </option>
                @endforeach
            </select>
            <span id="operador-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group" id="ambito-sel2">
            <label id="ambito--label">* Ámbito</label> <br>
            <select name="ambito" class="form-control selector-modal selectAmbito" style="width: 100%">
                <option value="">Seleccionar</option>
                @foreach(listaAmbitos() as $key => $ambito)
                    <option value="{{ $key }}"> {{ $ambito }} </option>
                @endforeach
            </select>
            <span id="ambito-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group" id="evento-sel2">
            <label id="evento--label">* Evento</label> <br>
            <select name="evento" class="form-control selector-modal selectEvento" style="width: 100%">
                <option value="">Seleccionar</option>
                @foreach(listaEventos() as $key => $evento)
                    <option value="{{ $key }}"> {{ $evento }} </option>
                @endforeach
            </select>
            <span id="evento-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divAlarma hidden">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <b class="text-primarydark" id="titleCuenta">Datos de alarma</b>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="col-form-label" id="zona--label">* Zona</label> <br>
                            <input class="form-control" name="zona" type="text" placeholder="Zona">
                            <span id="zona-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="col-form-label" id="sensor--label">* Sensor</label> <br>
                            <input class="form-control" name="sensor" type="text" placeholder="Sensor">
                            <span id="sensor-error" class="text-red"></span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="col-form-label" id="ubicacion--label">* Ubicación</label> <br>
                            <input class="form-control" name="ubicacion" type="text" placeholder="Ubicación">
                            <span id="ubicacion-error" class="text-red"></span>
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
                        <b class="text-primarydark" style="font-size:20px" id="titleCuenta">Datos de cuenta</b>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectCuenta">
                        <div class="" id="cuenta-sel2">
                            <label id="cuenta--label">* Código de cuenta</label>
                            <select name="cuenta" class="form-control form-select selector-cuenta" style="width: 100%">
                                <option value="">Seleccione una opción</option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}" data-info="{{ $cuenta->getInfoCuentas() }}">{{ $cuenta->cod.' - '.$cuenta->nombre_cuenta }}</option>
                                @endforeach
                            </select>
                            <span id="cuenta-error" class="text-red"></span>
                        </div>
                        <div class="divInfoCuenta" style="display:none"></div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectCuenta">
                        <div class="" id="contacto-sel2">
                            <label id="contacto--label">* Contacto</label>
                            <select name="contacto" class="form-control selector-contacto" style="width:100%">
                                <option value="">Seleccionar</option>
                            </select>
                            <span id="contacto-error" class="text-red"></span>
                        </div>
                        <div class="divInfoContacto" style="display:none"></div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectVehiculo hidden">
                        <div class="" id="vehiculo-sel2">
                            <label id="vehiculo--label">* Matricula de vehículo</label>
                            <select name="vehiculo" class="form-control form-select selector-vehiculo" style="width: 100%">
                                <option value="">Seleccione una opción</option>
                                @foreach ($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}" data-info="{{ $vehiculo->getInfoVehiculos() }}">{{ $vehiculo->matricula.' - '.$vehiculo->nombre_vehiculo }}</option>
                                @endforeach
                            </select>
                            <span id="vehiculo-error" class="text-red"></span>
                        </div>
                        <div class="divInfoVehiculo" style="display:none"></div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divSelectVehiculo hidden">
                        <div class="" id="conductor-sel2">
                            <label id="conductor--label">* Conductor</label>
                            <select name="conductor" class="form-control selector-conductor" style="width:100%">
                                <option value="">Seleccionar</option>
                            </select>
                            <span id="conductor-error" class="text-red"></span>
                        </div>
                        <div class="divInfoConductor" style="display:none"></div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <div class="form-group" id="reportado-sel2">
                            <label id="reportado--label">* Reportado a</label> <br>
                            <select name="reportado" class="form-control selector-modal" style="width: 100%">
                                <option value="">Seleccionar</option>
                                @foreach($administrativos as $administrativo)
                                    <option value="{{ code($administrativo->id) }}"> {{ $administrativo->fullName }} </option>
                                @endforeach
                            </select>
                            <span id="reportado-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="col-form-label" id="comentario--label">Comentarios adicionales</label> <br>
                            <textarea name="comentario"  rows="2" class="form-control" style="width:100%;resize:none" placeholder="Comentarios adicionales"></textarea>
                            <span id="comentario-error" class="text-red"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 divAutorizado">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <label class="text-primarydark cursor-pointer font-weight-bold">
                            ¿Está autorizado?
                            <input type="checkbox" class="checkAutorizado" name="checkAutorizado" value="1">
                        </label>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divInputAutorizador hidden mb-2">
                        <div class="form-group">
                            <label class="col-form-label" id="autorizador--label">* Nombre de autorizador</label> <br>
                            <input class="form-control" name="autorizador" type="text" placeholder="Nombre de autorizador">
                            <span id="autorizador-error" class="text-red"></span>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 divInputAutorizador hidden mb-2">
                        <div class="form-group" id="estado-sel2">
                            <label id="estado--label">* Estado</label> <br>
                            <select name="estado" class="form-control selector-modal" style="width: 100%">
                                <option value="">Seleccionar</option>
                                <option value="C">Cerrado</option>
                                <option value="S">Seguimiento por operador entrante</option>
                            </select>
                            <span id="estado-error" class="text-red"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}
<script src="{{asset('/plugins/iCheck/icheck.min.js')}}"></script>
<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');
    });

    $('.datetimepicker').datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        autoclose: true,
        endDate: '{{now()}}',
    });

    // SELECT 2 GENERAL
    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
        });
    });

    $('.checkAutorizado').iCheck({
        checkboxClass: 'icheckbox_square-blue',
    }).on('ifChecked', function (event) {
        $('.divInputAutorizador').show();
    }).on('ifUnchecked', function (event){
        $('.divInputAutorizador').hide();
    });
</script>

<script>
    $('.selectAmbito').change(function () {
        var val = $(this).val();

        // Si el ambito es vehiculo
        if(val == '3'){
            $('.divSelectVehiculo').show();
            $('.divSelectCuenta').hide();
            $('#titleCuenta').text('Datos de vehículo');
        }else{
            $('.divSelectVehiculo').hide();
            $('.divSelectCuenta').show();
            $('#titleCuenta').text('Datos de cuenta');
        }
    });

    $('.selectEvento').change(function () {
        var val = $(this).val();

        // Si el ambito es vehiculo
        if(val == '1'){
            $('.divAlarma').show();
            $('.divAutorizado').hide();
        }else{
            $('.divAlarma').hide();
            $('.divAutorizado').show();
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

    $('select.selector-cuenta:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatCuentaSelect,
        });
    });

    $('.selector-cuenta').change(function () {
        $('.selector-contacto').val('').trigger('change');
        var data = $('.selector-cuenta').select2('data')[0];
        var infoAdd = $(data.element).data('info');
        var info;
        if (typeof infoAdd === 'undefined') {
            info = '';
            $(".divInfoCuenta").hide();
            $(".divInfoCuenta").removeClass('mb-2');
        }else{
            info = infoAdd;
            $(".divInfoCuenta").show();
            $(".divInfoCuenta").addClass('mb-2');
        }
        $(".divInfoCuenta").html(info);
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

    $('select.selector-contacto:not(.normal)').each(function () {
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
                        cuenta: $('.selector-cuenta').val(),
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

    $('.selector-contacto').change(function () {
        var val = $(this).val();
        var data = $('.selector-contacto').select2('data')[0];
        var info;
        if (typeof data.info === 'undefined') {
            info = "";
            $(".divInfoContacto").hide();
            $(".divInfoContacto").removeClass('mb-2');
        }else{
            info = data.info;
            $(".divInfoContacto").show();
            $(".divInfoContacto").addClass('mb-2');
        }
        $(".divInfoContacto").html(info);
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

    $('select.selector-vehiculo:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatVehiculoSelect,
        });
    });

    $('.selector-vehiculo').change(function () {
        $('.selector-conductor').val('').trigger('change');
        var data = $('.selector-vehiculo').select2('data')[0];
        var infoAdd = $(data.element).data('info');
        var info;
        if (typeof infoAdd === 'undefined') {
            info = '';
            $(".divInfoVehiculo").hide();
            $(".divInfoVehiculo").removeClass('mb-2');
        }else{
            info = infoAdd;
            $(".divInfoVehiculo").show();
            $(".divInfoVehiculo").addClass('mb-2');
        }
        $(".divInfoVehiculo").html(info);
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

    $('select.selector-conductor:not(.normal)').each(function () {
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
                        vehiculo: $('.selector-vehiculo').val(),
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

    $('.selector-conductor').change(function () {
        var val = $(this).val();
        var data = $('.selector-conductor').select2('data')[0];
        var info;
        if (typeof data.info === 'undefined') {
            info = "";
            $(".divInfoConductor").hide();
            $(".divInfoConductor").removeClass('mb-2');
        }else{
            info = data.info;
            $(".divInfoConductor").show();
            $(".divInfoConductor").addClass('mb-2');
        }
        $(".divInfoConductor").html(info);
    });

</script>

<script>
    var camposNormales = ['fechaNovedad','operador','ambito','evento'];
    var camposSensor = ['zona','sensor','ubicacion'];
    var camposCuenta = ['cuenta','contacto'];
    var camposVehiculos = ['vehiculo','conductor'];
    var camposNormales2 = ['reportado','comentario'];
    var camposAutorizador = ['checkAutorizado','autorizador','estado'];

    var camposFinal = [
        ...camposNormales,
        ...camposSensor,
        ...camposCuenta,
        ...camposVehiculos,
        ...camposNormales2,
        ...camposAutorizador
    ];
    ValidateAjax("formCrearNovedad",camposFinal,"botonGuardar","{{route('novedades.store')}}","POST","/novedades");
</script>
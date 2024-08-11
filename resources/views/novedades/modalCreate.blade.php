{!! Form::open( array('route' =>'cuentas.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearCuenta', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

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
            <select name="ambito" class="form-control selector-modal" style="width: 100%">
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
            <select name="evento" class="form-control selector-modal" style="width: 100%">
                <option value="">Seleccionar</option>
                @foreach(listaEventos() as $key => $evento)
                    <option value="{{ $key }}"> {{ $evento }} </option>
                @endforeach
            </select>
            <span id="evento-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="nombre--label">* Nombre de cuenta</label> <br>
            <input class="form-control" name="nombre" type="text" placeholder="Nombre de cuenta">
            <span id="nombre-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
        <div class="" id="regional-sel2">
            <label id="regional--label">* Regional</label>
            <select name="regional" class="form-control form-select selector-regional" style="width: 100%">
                <option value="">Seleccione una opción</option>
                @foreach ($regionales as $regional)
                    <option value="{{ $regional->id }}" data-departamento="{{ $regional->nameCiudad() }}" data-extra= {{ $regional->departamento }}>{{ $regional->nombre_regional }}</option>
                @endforeach
            </select>
            <span id="regional-error" class="text-red"></span>
        </div>
        <div class="divInfoDepartamento" style="display:none"></div>
    </div>

    <input class="form-control" name="departamentoId" id="departamentoInput"  type="text" hidden>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}

<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');
    });

    $('.datetimepicker').datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        autoclose: true,
        startDate: '{{now()}}',
    });

    // SELECT 2 GENERAL
    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
        });
    });

    function formatState (regional) {
        var departamentoSelect = $(regional.element).data('departamento');

        if (typeof departamentoSelect === 'undefined') {
            return regional.text;
        }
        var departamentoHTML = "";
        if(departamentoSelect != ""){
            departamentoHTML = '<br><i style="font-size:11px"><b style="font-size:11px">Departamento:</b> '+departamentoSelect+'</i>';
        }

        var $regional = $(
            '<span>' + regional.text + departamentoHTML + '</span>'
        );
        return $regional;
    };

    $('select.selector-regional:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatState,
        });
    });

    $('.selector-regional').change(function () {
        var data = $('.selector-regional').select2('data')[0];
        var departamento = $(data.element).data('departamento');
        var departamentoId = $(data.element).data('extra');
        var info;
        if (typeof departamento === 'undefined') {
            info = '';
            $('#departamentoInput').val('');
            $(".divInfoDepartamento").hide();
            $(".divInfoDepartamento").removeClass('mb-2');
        }else{
            info = '<i style="font-size:11px"><b style="font-size:11px">Departamento: </b>'+departamento+'</i>';
            $(".divInfoDepartamento").show();
            $(".divInfoDepartamento").addClass('mb-2');
            $('#departamentoInput').val(departamentoId);
        }
        $(".divInfoDepartamento").html(info);
    });

    var campos = ['nombre','regional'];
    ValidateAjax("formCrearCuenta",campos,"botonGuardar","{{route('cuentas.store')}}","POST","/cuentas");
</script>
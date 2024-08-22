<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar regional: {{ $cuenta->nombre_cuenta }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('CuentasController@update',code($cuenta->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarCuenta', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        {!! datosRegistro('edit') !!}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label class="col-form-label" id="nombreedit--label">* Nombre de cuenta</label> <br>
                <input class="form-control" name="nombreedit" type="text" placeholder="Nombre de cuenta" value="{{ $cuenta->nombre_cuenta }}">
                <span id="nombreedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
            <div class="" id="clienteedit-sel2">
                <label id="clienteedit--label">* Cliente</label>
                <select name="clienteedit" class="form-control form-select selector-modal-edit" style="width: 100%">
                    <option value="">Seleccione una opción</option>
                    @foreach ($clientes as $cliente)
                        @php
                            $isSelected = '';
                            if($cliente->id == $cuenta->cliente_id){
                                $isSelected = 'selected';
                            }
                        @endphp
                        <option value="{{ $cliente->id }}" {{ $isSelected }}>{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
                <span id="clienteedit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
            <div class="" id="regionaledit-sel2">
                <label id="regionaledit--label">* Regional
                    @php
                        $textpopover ='data-toggle="popover" data-trigger="hover" data-content="<span style=\'font-size:11px\'>Si cambia a una regional que esté en un departamento diferente al actual, el código de cuenta se MODIFICARÁ</span>" data-title="<b>Información Importante</b>"';
                    @endphp
                    <span class="edithover form-help" {!! $textpopover !!}>?</span>
                </label>
                <select name="regionaledit" class="form-control form-select selector-modal-edit" style="width: 100%">
                    <option value="">Seleccione una opción</option>
                    @foreach ($regionales as $regional)
                        @php
                            $isSelected = '';
                            if($regional->id == $cuenta->regional_id){
                                $isSelected = 'selected';
                            }
                        @endphp
                        <option value="{{ $regional->id }}" data-departamento="{{ $regional->nameCiudad() }}" data-extra= {{ $regional->departamento }} {{ $isSelected }}>{{ $regional->nombre_regional }}</option>
                    @endforeach
                </select>
                <span id="regionaledit-error" class="text-red"></span>
            </div>
            <div class="divInfoDepartamentoEdit">
                <i style="font-size:11px"><b style="font-size:11px">Departamento: </b>{{ $cuenta->regional->nameCiudad() }}</i>
            </div>
        </div>

        <input class="form-control" name="departamentoIdedit" id="departamentoInputEdit" type="text" value="{{ $cuenta->regional->departamento }}" hidden>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
            <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primarydark pull-right" name="botonEditar">Modificar</button>
        </div>
    </div>
    {{Form::Close()}}
</div>

<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');
    });

    $('[data-toggle="popover"]').popover({
        html: true,
        "trigger" : "hover",
        "placement": "top",
        "container": "body",
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

    $('select.selector-modal-edit:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatState,
        });
    });

    $('.selector-modal-edit').change(function () {
        var data = $('.selector-modal-edit').select2('data')[0];
        var departamento = $(data.element).data('departamento');
        var departamentoId = $(data.element).data('extra');
        var info;
        if (typeof departamento === 'undefined') {
            info = '';
            $('#departamentoInputEdit').val('');
            $(".divInfoDepartamentoEdit").hide();
            $(".divInfoDepartamentoEdit").removeClass('mb-2');
        }else{
            info = '<i style="font-size:11px"><b style="font-size:11px">Departamento: </b>'+departamento+'</i>';
            $(".divInfoDepartamentoEdit").show();
            $(".divInfoDepartamentoEdit").addClass('mb-2');
            $('#departamentoInputEdit').val(departamentoId);
        }
        $(".divInfoDepartamentoEdit").html(info);
    });

    var campos = ['nombreedit','clienteedit','regionaledit'];
    ValidateAjax("formEditarCuenta",campos,"botonEditar","{{ route('cuentas.update',code($cuenta->id) )}}","POST","/cuentas");
</script>
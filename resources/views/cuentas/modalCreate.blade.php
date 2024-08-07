{!! Form::open( array('route' =>'cuentas.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearCuenta', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

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
            <select name="regional" class="form-control form-select selector-modal" style="width: 100%">
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

    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent(),
            width: '100%',
            templateResult: formatState,
        });
    });

    $('.selector-modal').change(function () {
        var data = $('.selector-modal').select2('data')[0];
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
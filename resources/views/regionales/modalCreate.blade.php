{!! Form::open( array('route' =>'regionales.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearRegional', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label class="col-form-label" id="nombre--label">* Nombre de regional</label> <br>
            <input class="form-control" name="nombre" type="text" placeholder="Nombre de regional">
            <span id="nombre-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
        <div class="form-group" id="departamento-sel2">
            <label id="departamento--label">* Departamento</label>
            <select name="departamento" class="form-control form-select selector-modal" style="width: 100%">
                <option value="">Seleccione una opción</option>
                @foreach (listaDepartamentos() as $key => $departamento)
                    <option value="{{ $key }}">{{ $departamento }}</option>
                @endforeach
            </select>
            <span id="departamento-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}

<script src="{{asset('/plugins/fileinput/js/fileinput.min.js')}}"></script>
<script>

    $(document).ready(function () {
        $(".select2-selection").addClass('form-select2').css('border-color','#ccc');
        $(".select2-selection--single").addClass('form-selectcont');
    });

    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent()
        });
    });

    var campos = ['nombre','departamento'];
    ValidateAjax("formCrearRegional",campos,"botonGuardar","{{route('regionales.store')}}","POST","/regionales");
</script>
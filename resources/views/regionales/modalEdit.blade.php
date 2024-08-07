<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        <i class="fa fa-plus"></i>
        Editar regional {{ $regional->nombre_regional }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('RegionalesController@update',code($regional->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarRegional', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
        <div class="row">
            {!! datosRegistro('edit') !!}

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label class="col-form-label" id="nombreedit--label">* Nombre de regional</label> <br>
                    <input class="form-control" name="nombreedit" type="text" placeholder="Nombre de regional" value="{{ $regional->nombre_regional }}">
                    <span id="nombreedit-error" class="text-red"></span>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                <div class="form-group" id="departamentoedit-sel2">
                    <label id="departamentoedit--label">* Departamento</label>
                    <select name="departamentoedit" class="form-control form-select selector-modal" style="width: 100%">
                        <option value="">Seleccione una opción</option>
                        @foreach (listaDepartamentos() as $key => $departamento)
                            @if ($regional->departamento == $key)
                                <option value="{{ $key }}" selected>{{ $departamento }}</option>
                            @else
                                <option value="{{ $key }}">{{ $departamento }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span id="departamentoedit-error" class="text-red"></span>
                </div>
            </div>

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

    $('select.selector-modal:not(.normal)').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent().parent()
        });
    });

    var campos = ['nombreedit','departamentoedit'];
    ValidateAjax("formEditarRegional",campos,"botonEditar","{{ route('regionales.update',code($regional->id) )}}","POST","/regionales");
</script>
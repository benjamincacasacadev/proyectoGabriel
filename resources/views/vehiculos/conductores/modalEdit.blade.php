<div class="modal-header">
    <h5 class="modal-title font-weight-bold text-primarydark">
        Editar conductor: {{ $conductor->nombre_conductor }}
    </h5>
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    {{Form::Open(array('action'=>array('ConductoresVehiculosController@update',code($conductor->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEditarVehiculo', 'onsubmit'=>'botonEditar.disabled = true; return true;'))}}
    <div class="row">
        {!! datosRegistro('edit') !!}

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label id="nombreConductoredit--label">* Nombre completo</label>
                <input class="form-control" type="text" name="nombreConductoredit" placeholder="Nombre de conductor" value="{{ $conductor->nombre_conductor }}">
                <span id="nombreConductoredit-error" class="text-red"></span>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
            <div class="form-group">
                <label id="celularedit--label">* Celular</label>
                <input class="form-control" type="text" name="celularedit" placeholder="Celular" value="{{ $conductor->celular_conductor }}">
                <span id="celularedit-error" class="text-red"></span>
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
    var campos = ['nombreConductoredit', 'celularedit'];
    ValidateAjax("formEditarVehiculo",campos,"botonEditar","{{ route('conductores.update',code($conductor->id) )}}","POST","/vehiculos/show/{{ code($conductor->vehiculo_id) }}");
</script>
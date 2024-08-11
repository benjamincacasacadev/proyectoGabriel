{!! Form::open( array('route' =>'conductores.store','method'=>'POST','autocomplete'=>'off','files'=>'true','id'=>'formCrearConductor', 'onsubmit'=>'botonGuardar.disabled = true; return true;'))!!}
<div class="row">
    {!! datosRegistro('create') !!}

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <label id="nombreConductor--label">* Nombre completo</label>
            <input class="form-control" type="text" name="nombreConductor" placeholder="Nombre de conductor">
            <span id="nombreConductor-error" class="text-red"></span>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-6">
        <div class="form-group">
            <label id="celular--label">* Celular</label>
            <input class="form-control" type="text" name="celular" placeholder="Celular">
            <span id="celular-error" class="text-red"></span>
        </div>
    </div>

    <input type="text" name="vehiculoId" value="{{$vehiculoId}}" hidden>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
        <button type="button" class="btn btn-ghost-secondary pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primarydark pull-right" name="botonGuardar">Registrar</button>
    </div>
</div>
{{Form::Close()}}

<script>

    var campos = ['nombreConductor', 'celular', 'vehiculoId'];
    ValidateAjax("formCrearConductor",campos,"botonGuardar","{{route('conductores.store')}}","POST","/vehiculos/show/{{ $vehiculoId }}");
</script>
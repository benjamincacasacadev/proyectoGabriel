{{Form::Open(array('action'=>array('NovedadesController@changeEstado',code($novedad->id)),'method'=>'POST','autocomplete'=>'off','id'=>'formEstadoNovedad', 'onsubmit'=>'botonEstado.disabled = true; return true;'))}}
    <div class="modal-status bg-green"></div>
    <div class="modal-body text-center pt-4 px-4">
        {{-- SI LA CUENTA TIENE REGISTROS ASOCIADOS NO PERMITIR ELIMINAR REGISTRO --}}
        <svg class="icon mb-2 text-success icon-lg" style="" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg>
        <h5 class="font-weight-bold">¿Está seguro?</h5>
        <div class="text-muted">
            ¿Está seguro de cerrar la novedad <b>{{ $novedad->cod }}</b>?
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left mt-2">
            <div class="form-group">
                <label class="col-form-label" id="autorizador--label">* Nombre de autorizador</label> <br>
                <input class="form-control" name="autorizador" type="text" placeholder="Nombre de autorizador" value="{{ $novedad->nombre_autorizador }}">
                <span id="autorizador-error" class="text-red"></span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="col-6">
                    <a class="w-100 au-btn btn-outline-secondary border border-secondary text-center" data-dismiss="modal">
                        Cancelar
                    </a>
                </div>
                <div class="col-6">
                    <button type="submit" class="au-btn au-btn--green w-100 p-0" name="botonEstado">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
{{Form::Close()}}

<script>
    var campos = ['autorizador'];
    ValidateAjax("formEstadoNovedad",campos,"botonEstado","{{ route('novedades.cambioEstado',code($novedad->id) )}}","POST","/novedades");
</script>


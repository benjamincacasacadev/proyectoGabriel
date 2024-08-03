
{{Form::open(array('action'=>array('StFormController@destroyContainer',$idcont,$idsubc,$id, $sw),'method'=>'delete', 'onsubmit'=>'deleteboton.disabled = true; return true;')) }}
    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-status bg-red"></div>
    <div class="modal-body text-center py-4">
        <svg class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
        <h3>¿Está seguro?</h3>
        <div class="text-muted">
            ¿Está seguro de eliminar  el <br> {{ ($sw=='subc') ? 'SUB CONTENEDOR' : 'CONTENEDOR'}} {{$nombre_campo}}?<br>

            <i style="font-size:11px">
                @if ($sw == 'subc')
                    Al eliminar el sub contenedor también se eliminarán "TODOS" los campos asociados en los procedimientos creados
                @else
                    Al eliminar el contenedor también se eliminarán "TODOS" los sub-contenedores y campos asociados en los procedimientos creados
                @endif
            </i>
        </div>
    </div>

    <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="col">
                    <a class="btn @if(themeMode() == 'D') btn-secondary @endif w-100" data-dismiss="modal">
                        Cancelar
                    </a>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-danger w-100" name="deleteboton">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
{{Form::Close()}}

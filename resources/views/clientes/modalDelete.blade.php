{{Form::open(array('action'=>array('ClientesController@destroy',code($cliente->id)),'method'=>'post', 'onsubmit'=>'botonEliminar.disabled = true; return true;'))}}
    <div class="modal-status @if($cantAsociados > 0) bg-yellow @else bg-red @endif"></div>
    <div class="modal-body text-center py-4 px-4">
        {{-- SI EL CLIENTE TIENE REGISTROS ASOCIADOS NO PERMITIR ELIMINAR REGISTRO --}}
        @if($cantAsociados > 0)
            <svg class="icon mb-2 text-yellow icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" />
            </svg>
            <h6>No puede eliminar el cliente <b>{{ $cliente->nombre }}</b> </h6>
            <div class="text-muted">
                El cliente tiene {{ $cantAsociados }} registro(s) asociados.
            </div>
        @else
            <svg class="icon mb-2 text-danger icon-lg" style="" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>
            <h5 class="font-weight-bold">¿Está seguro?</h5>
            <div class="text-muted">
                ¿Está seguro de eliminar el cliente <b>{{ $cliente->nombre }}</b>?
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <div class="w-100">
            <div class="row">
                <div class="@if($cantAsociados > 0) col-12 @else col-6 @endif">
                    <a class="w-100 au-btn btn-outline-secondary border border-secondary text-center" data-dismiss="modal">
                        Cancelar
                    </a>
                </div>
                @if($cantAsociados == 0)
                    <div class="col-6">
                        <button type="submit" class="au-btn au-btn--red w-100 p-0" name="botonEliminar">Confirmar</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
{{Form::Close()}}



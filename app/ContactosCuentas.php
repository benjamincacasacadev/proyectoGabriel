<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactosCuentas extends Model
{
    // =====================================================================
    //                          RELACIONES
    // =====================================================================
    public function cuenta(){
        return $this->belongsTo(Cuentas::class, 'cuenta_id');
    }

    // =====================================================================
    //                          FUNCIONES
    // =====================================================================
    public function getOperacionesHTML(){
        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/contactos/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/contactos/modalDelete/'.code($this->id).'" title="Eliminar">
            <i class="fa fa-trash-alt"></i>
        </a>';

        return $editarHTML.'&nbsp;'.$eliminarHTML;
    }

}

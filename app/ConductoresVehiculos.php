<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConductoresVehiculos extends Model
{
    // =====================================================================
    //                          RELACIONES
    // =====================================================================
    public function vehiculo(){
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id');
    }

    // =====================================================================
    //                          FUNCIONES
    // =====================================================================
    public function getOperacionesHTML(){
        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/conductores/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/conductores/modalDelete/'.code($this->id).'" title="Eliminar">
            <i class="fa fa-trash-alt"></i>
        </a>';

        return $editarHTML.'&nbsp;'.$eliminarHTML;
    }
}

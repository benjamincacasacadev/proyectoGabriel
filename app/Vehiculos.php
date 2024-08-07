<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
        // =====================================================================
    //                          RELACIONES
    // =====================================================================
    public function regional(){
        return $this->belongsTo(Regionales::class, 'regional_id');
    }

    // =====================================================================
    //                          FUNCIONES
    // =====================================================================
    public function getEstadoHTML(){
        if($this->estado == '1'){
            $html =
            '<a href="/vehiculos/estado/'. code($this->id) .'/1" class="badge badge-pill bg-green text-white" title="Desactivar cuenta">
                ACTIVO
            </a>';
        }else{
            $html =
            '<a href="/vehiculos/estado/'. code($this->id) .'/0" class="badge badge-pill bg-red text-white" title="Activar cuenta">
                INACTIVO
            </a>';
        }
        return $html;
    }

    public function getOperacionesHTML(){
        $imagenHTML = '';
        if($this->archivo != null){
            $imagenHTML =
            '<a class="btn btn-outline-success btn-sm" href="/storage/vehiculos/'.$this->archivo.'" target="_blank" title="Ver imagen adjunta">
                <i class="fa fa-image"></i>
            </a>&nbsp;';
        }

        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/vehiculos/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/vehiculos/modalDelete/'.code($this->id).'" title="Eliminar">
            <i class="fa fa-trash-alt"></i>
        </a>';

        return $imagenHTML.$editarHTML.'&nbsp;'.$eliminarHTML;
    }

    // ==========================================================================
    // SCOPES (WHERES MYSQL)
    // ==========================================================================
    public function scopeMatricula($query, $val){
        if ($val != ''){
            $query->where('matricula', 'like', "%{$val}%");
        }
    }

    public function scopeNombre($query, $val){
        if ($val != ''){
            $query->where('nombre_vehiculo', 'like', "%{$val}%");
        }
    }

    public function scopeRegional($query, $val){
        if ($val != '') {
            $query->whereHas('regional', function ($q1) use ($val) {
                $q1->where('nombre_regional', 'like', "%{$val}%");
            });
        }
    }

    public function scopeDepartamento($query, $val){
        if ($val != '') {
            $query->whereHas('regional', function ($q1) use ($val) {
                $q1->where('departamento', $val);
            });
        }
    }
}

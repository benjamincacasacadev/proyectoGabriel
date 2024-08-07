<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
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
            '<a href="/cuentas/estado/'. code($this->id) .'/1" class="badge badge-pill bg-green text-white" title="Desactivar cuenta">
                ACTIVO
            </a>';
        }else{
            $html =
            '<a href="/cuentas/estado/'. code($this->id) .'/0" class="badge badge-pill bg-red text-white" title="Activar cuenta">
                INACTIVO
            </a>';
        }
        return $html;
    }

    public function getOperacionesHTML(){
        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/cuentas/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/cuentas/modalDelete/'.code($this->id).'" title="Eliminar">
            <i class="fa fa-trash-alt"></i>
        </a>';

        return $editarHTML.'&nbsp;'.$eliminarHTML;
    }

    // ==========================================================================
    // SCOPES (WHERES MYSQL)
    // ==========================================================================
    public function scopeCod($query, $val){
        if ($val != ''){
            $query->where('cod', 'like', "%{$val}%");
        }
    }

    public function scopeNombre($query, $val){
        if ($val != ''){
            $query->where('nombre_cuenta', 'like', "%{$val}%");
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

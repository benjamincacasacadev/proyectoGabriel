<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{

    // =====================================================================
    //                          FUNCIONES
    // =====================================================================
    public function getEstadoHTML(){
        if($this->estado == '1'){
            $html =
            '<a href="/clientes/estado/'. code($this->id) .'/1" class="badge badge-pill bg-green text-white" title="Desactivar cliente">
                ACTIVO
            </a>';
        }else{
            $html =
            '<a href="/clientes/estado/'. code($this->id) .'/0" class="badge badge-pill bg-red text-white" title="Activar cliente">
                INACTIVO
            </a>';
        }
        return $html;
    }

    public function getOperacionesHTML(){
        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/clientes/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/clientes/modalDelete/'.code($this->id).'" title="Eliminar">
            <i class="fa fa-trash-alt"></i>
        </a>';

        return $editarHTML.'&nbsp;'.$eliminarHTML;
    }

    // ==========================================================================
    // SCOPES
    // ==========================================================================

    public function scopeNombre($query, $val){
        if ($val != ''){
            $query->where('nombre', 'like', "%{$val}%");
        }
    }

    public function scopeNit($query, $val){
        if ($val != ''){
            $query->where('nit', 'like', "%{$val}%");
        }
    }

    public function scopeDireccion($query, $val){
        if ($val != ''){
            $query->where('direccion', 'like', "%{$val}%");
        }
    }

    public function scopeEstado($query, $val){
        if ($val != ''){
            $query->where('estado', $val);
        }
    }
}

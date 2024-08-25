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

        return $editarHTML.' '.$eliminarHTML;
    }

    public function getInfoContactos(){
        $cargo = "<b>Cargo: </b>".$this->cargo_contacto.'<br>';
        $celular = "<b>Celular: </b>".$this->celular_contacto.'<br>';
        $email = "<b>Email: </b>".$this->email_contacto.'<br>';
        $asignacion = "<b>Asignación: </b>".$this->getInfoAsignacion();

        return
        '<div class="text-sm mt-2">'
            .$cargo.$celular.$email.$asignacion.
        '</div>';
    }

    public function getInfoAsignacion(){
        if($this->asignacion == 'L'){
            return 'Llave';
        }
        if($this->asignacion == 'C'){
            return 'Clave';
        }
        return '-';
    }

    // ==========================================================================
    // SCOPES (WHERES MYSQL)
    // ==========================================================================
    public function scopeNombre($query, $val){
        if ($val != ''){
            $query->where('nombre_contacto', 'like', "%{$val}%");
        }
    }
}
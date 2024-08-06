<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regionales extends Model
{
    // =====================================================================
    //                          RELACIONES
    // =====================================================================

    public function nameCiudad(){
        $listDepartamentos = listaDepartamentos();
        return $listDepartamentos[$this->departamento] ?? '-';
    }
}

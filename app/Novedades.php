<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Novedades extends Model
{
    // =====================================================================
    //                          RELACIONES
    // =====================================================================
    public function contacto(){
        return $this->belongsTo(ContactosCuentas::class, 'contacto_cuenta_id');
    }

    public function conductor(){
        return $this->belongsTo(ConductoresVehiculos::class, 'conductor_vehiculo_id');
    }

    public function operador(){
        return $this->belongsTo(User::class, 'operador_id');
    }

    public function reportado(){
        return $this->belongsTo(User::class, 'reportado_id');
    }

    // =====================================================================
    //                          FUNCIONES
    // =====================================================================


    public function infoFecha(){
        $fecha = Carbon::parse($this->fecha_novedad);
        $fechaFormateada = $fecha->format('d/m/Y')."<br>".$fecha->format('H:i') .'<br><b>'. mb_strtoupper($fecha->locale('es')->isoFormat('dddd')).'</b>';
        return $fechaFormateada;
    }

    public function nameAmbito(){
        $lista = listaAmbitos();
        return $lista[$this->ambito] ?? '-';
    }

    public function nameEvento(){
        $lista = listaEventos();
        return $lista[$this->evento] ?? '-';
    }

    public function getCuentaMatricula(){
        if(isset($this->contacto_cuenta_id)){
            return $this->contacto->cuenta->getCodLink();
        }
        if(isset($this->conductor_vehiculo_id)){
            return $this->conductor->vehiculo->getCodLink();
        }
    }

    public function getDepartamento(){
        if(isset($this->contacto_cuenta_id)){
            return $this->contacto->cuenta->regional->nameCiudad();
        }
        if(isset($this->conductor_vehiculo_id)){
            return $this->conductor->vehiculo->regional->nameCiudad();
        }
    }

    public function getRegional(){
        if(isset($this->contacto_cuenta_id)){
            return $this->contacto->cuenta->regional->nombre_regional;
        }
        if(isset($this->conductor_vehiculo_id)){
            return $this->conductor->vehiculo->regional->nombre_regional;
        }
    }

    public function getComentarios(){
        return nl2br($this->comentarios);
    }

    public function getEstadoHTML(){
        if($this->estado == 'C'){
            $html =
            '<span class="badge badge-pill bg-green text-white">
                CERRADO
            </span>';
        }else{
            $html =
            '<a href="/vehiculos/estado/'. code($this->id) .'/0" class="badge badge-pill bg-red text-white" title="Cambiar estado">
                SEGUIMIENTO
            </a>';
        }
        return $html;
    }

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

    // ==========================================================================
    // SCOPES (WHERES MYSQL)
    // ==========================================================================
    public function scopeCod($query, $val){
        if ($val != ''){
            $query->where('cod', 'like', "%{$val}%");
        }
    }
}

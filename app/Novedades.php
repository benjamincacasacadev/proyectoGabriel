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

    public function nameAmbito($html = false){
        $lista = listaAmbitos();
        $ambito = $lista[$this->ambito] ?? '-';
        switch ($this->ambito) {
            case '1':
                $textColor = '<b class="text-azure">'.$ambito.'</b>';
            break;
            case '2':
                $textColor = '<b class="text-teal">'.$ambito.'</b>';
            break;
            case '3':
                $textColor = '<b class="text-pink">'.$ambito.'</b>';
            break;

            default:
                $textColor = $ambito;
            break;
        }

        return $html ? $textColor : $ambito;
    }

    public function nameEvento(){
        $lista = listaEventos();
        // Si el evento es activacion de alarma
        if($this->evento == '1'){
            $nameEvento = $lista[$this->evento] ?? '-';
            $tooltipContent = '<b>Datos de alarma</b>';
            $tooltipContent .= '<br><b>Zona: </b>'.$this->zona_alarma;
            $tooltipContent .= '<br><b>Sensor: </b>'.$this->sensor_alarma;
            $tooltipContent .= '<br><b>Ubicación: </b>'.$this->ubicacion_alarma;
            $verMas = '<br><i class="fa fa-info-circle fa-lg text-primarydark" data-toggle="tooltip" data-html="true" title="'.$tooltipContent.'"></i>';
            return $nameEvento.$verMas;
        }
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
            $tooltipContent = '<b>Autorizador</b><br>'.$this->nombre_autorizador;

            $html =
            '<span class="badge badge-pill bg-green text-white" data-toggle="tooltip" data-html="true" title="'.$tooltipContent.'">
                CERRADO
            </span>';
        }else{
            $html =
            '<a href="/novedades/modalEstado/'. code($this->id).'" rel="modalEstado" class="badge badge-pill bg-yellow text-white" title="Cambiar estado">
                SEGUIMIENTO
            </a>';
        }
        return $html;
    }

    public function getOperacionesHTML(){
        if($this->estado == 'C'){
            return '';
        }

        $editarHTML =
        '<a class="btn btn-outline-primarydark btn-sm" rel="modalEditar" href="/novedades/modalEdit/'.code($this->id).'" title="Editar">
            <i class="fa fa-edit"></i>
        </a>';

        $eliminarHTML =
        '<a class="btn btn-outline-danger btn-sm" rel="modalEliminar" href="/novedades/modalDelete/'.code($this->id).'" title="Eliminar">
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

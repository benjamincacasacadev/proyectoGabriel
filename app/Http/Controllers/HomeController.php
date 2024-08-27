<?php

namespace App\Http\Controllers;

use App\Novedades;
use App\WorkOrders;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        $novedad = Novedades::selectRaw('COUNT(id) as total,
        sum(case when evento = "1" then 1 else 0 end) AS activacion_alarma,
        sum(case when evento = "2" then 1 else 0 end) AS movimiento_fuera_de_horario,
        sum(case when evento = "3" then 1 else 0 end) AS apertura_remota,
        sum(case when evento = "4" then 1 else 0 end) AS cierre_remoto,
        sum(case when evento = "5" then 1 else 0 end) AS asignacion_de_llaves,
        sum(case when evento = "6" then 1 else 0 end) AS control_remoto_vehiculo,
        sum(case when evento = "7" then 1 else 0 end) AS salida_vehiculo_fuera_horario,
        sum(case when evento = "8" then 1 else 0 end) AS pernocte_diferente,
        sum(case when evento = "9" then 1 else 0 end) AS vehiculo_taller,
        sum(case when evento = "10" then 1 else 0 end) AS vehiculo_sin_comunicacion')
        ->where('estado','C')
        ->first();

        // =============================================================================================
        //                                       NOVEDADES POR FECHA
        // =============================================================================================
        $novedadesFecha = Novedades::
        selectRaw('COUNT(id) as novedades_cant, DATE_FORMAT(fecha_novedad, "%d/%m/%Y") as fecha_novedad')
        ->groupBy(\DB::raw('DATE(fecha_novedad)'))
        ->orderBy('fecha_novedad')
        ->get();

        $fechasGraf = $novedadesFecha->pluck('fecha_novedad')->toArray();
        $cantidadGraf = $novedadesFecha->pluck('novedades_cant')->toArray();
        $cantE = '';
        foreach ($cantidadGraf as $cant) {
            $cantE .= '"'.($cant).'",';
        }
        $fechaE = '';
        foreach ($fechasGraf as $fecha) {
            $fechaE .= '"'.$fecha.'",';
        }

        // AMBITOS
        $ambitos = Novedades::selectRaw('COUNT(id) as total,
        sum(case when ambito = "1" then 1 else 0 end) AS fisica,
        sum(case when ambito = "2" then 1 else 0 end) AS electronica,
        sum(case when ambito = "3" then 1 else 0 end) AS vehiculos')
        ->where('estado','C')
        ->first();
        Session::put('item','0.');
        return view('home',compact('novedad','ambitos','fechaE','cantE'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\Novedades;
use App\Regionales;
use App\User;
use App\Vehiculos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Flasher\Prime\FlasherInterface;
class NovedadesController extends Controller
{
    public function index(Request $request){
        $selectDepartamento = $request->selectDepartamento ?? '';
        Session::put('item','1.');
        return view('novedades.index', compact('selectDepartamento'));
    }

    public function modalCreate(){
        // canPassAdminJefe();
        $regionales = Regionales::where('estado', 1)->orderBy('nombre_regional')->get();
        // $operadores = User::where('active', 1)->where('role_id', 2)->orderBy('ap_paterno')->get();
        $operadores = User::where('active', 1)->orderBy('ap_paterno')->get();
        $administrativos = User::where('active', 1)->where('role_id', 1)->orderBy('ap_paterno')->get();
        $cuentas = Cuentas::where('estado', 1)->get();
        $vehiculos = Vehiculos::where('estado', 1)->get();
        return view('novedades.modalCreate', compact('regionales','operadores','administrativos','cuentas','vehiculos'));
    }

    public function store(Request $request, FlasherInterface $flasher) {
        // canPassAdminJefe();
        $this->validarFormulario($request);

        $fechaSave = Carbon::createFromFormat('d/m/Y H:i', $request->fechaNovedad);
        $registroMaximo = Novedades::select('cod')->where('cod', 'LIKE', "%NV%")->max('cod');
        $cod = generateCode($registroMaximo,'NV000001','NV',2,6);

        // Guardar nueva novedad en base de datos
        $novedad = new Novedades();
        $novedad->cod = $cod;
        $novedad->fecha_novedad = $fechaSave;
        $novedad->operador_id = decode($request->operador);
        $novedad->ambito = $request->ambito;
        $novedad->evento = $request->evento;
        $novedad->reportado_id = decode($request->reportado);
        $novedad->comentarios = $request->comentario;

        // Si el evento es activacion de alarma guardar datos de sensor
        if($request->evento == '1'){
            $novedad->zona_alarma = $request->zona;
            $novedad->sensor_alarma = $request->sensor;
            $novedad->ubicacion_alarma = $request->ubicacion;
            $novedad->estado = 'S';
        }else{
            // Si se marca el check autorizado
            if($request->checkAutorizado == '1'){
                $novedad->nombre_autorizador = $request->sensor;
                $novedad->estado = $request->estado;
            }else{
                $novedad->estado = 'S';
            }
        }

        // Si el ambito es de vehiculos guardar datos de vehiculos
        if($request->ambito == '3'){
            $novedad->conductor_vehiculo_id = decode($request->conductor);
            $novedad->contacto_cuenta_id = null;
        }else{
            // Si no adicionar validaciones de cuentas
            $novedad->contacto_cuenta_id = decode($request->contacto);
            $novedad->conductor_vehiculo_id = null;
        }
        $novedad->save();
        $flasher->addFlash('success', 'Creada con éxito', 'Novedad '.$novedad->cod);
        return  \Response::json(['success' => '1']);
    }

    public function validarFormulario(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $fechaNovedad = 'fechaNovedad'.$edit;
        $operador = 'operador'.$edit;
        $ambito = 'ambito'.$edit;
        $evento = 'evento'.$edit;
        $zona = 'zona'.$edit;
        $sensor = 'sensor'.$edit;
        $ubicacion = 'ubicacion'.$edit;
        $novedad = 'cuenta'.$edit;
        $contacto = 'contacto'.$edit;
        $vehiculo = 'vehiculo'.$edit;
        $conductor = 'conductor'.$edit;
        $reportado = 'reportado'.$edit;
        $comentario = 'comentario'.$edit;
        $checkAutorizado = 'checkAutorizado'.$edit;
        $autorizador = 'autorizador'.$edit;
        $estado = 'estado'.$edit;

        $reglasGeneralArray = [
            $fechaNovedad => 'bail|required|date_format:d/m/Y H:i',
            $operador => 'required',
            $ambito => 'required',
            $evento => 'required',
            $reportado => 'required',
            $comentario => 'bail|nullable|min:2',
        ];

        $reglasSensorArray = [
            $zona => 'required',
            $sensor => 'required',
            $ubicacion => 'required',
        ];

        $reglasCuentaArray = [
            $novedad => 'required',
            $contacto => 'required',
        ];

        $reglasVehiculoArray = [
            $vehiculo => 'required',
            $conductor => 'required',
        ];

        $reglasAutorizadorArray = [
            $autorizador => 'required',
            $estado => 'required',
        ];

        // Si el evento es activacion de alarma adicionar validaciones de sensor
        if($request->get($evento) == '1'){
            $reglasGeneralArray = array_merge($reglasGeneralArray, $reglasSensorArray);
        }else{
            // Si se marca el check autorizado
            if($request->get($checkAutorizado) == '1'){
                $reglasGeneralArray = array_merge($reglasGeneralArray, $reglasAutorizadorArray);
            }
        }

        // Si el ambito es de vehiculos adicionar validaciones de vehiculos
        if($request->get($ambito) == '3'){
            $reglasGeneralArray = array_merge($reglasGeneralArray, $reglasVehiculoArray);
        }else{
            // Si no adicionar validaciones de cuentas
            $reglasGeneralArray = array_merge($reglasGeneralArray, $reglasCuentaArray);
        }

        $aliasArray = [
            $fechaNovedad => '<b>Fecha y hora de novedad</b>',
            $operador => '<b>Operador</b>',
            $ambito => '<b>Ámbito</b>',
            $evento => '<b>Evento</b>',
            $zona => '<b>Zona</b>',
            $sensor => '<b>Sensor</b>',
            $ubicacion => '<b>Ubicación</b>',
            $novedad => '<b>Código de cuenta</b>',
            $contacto => '<b>Contacto</b>',
            $vehiculo => '<b>Matricula de vehículo</b>',
            $conductor => '<b>Conductor</b>',
            $reportado => '<b>Reportado a</b>',
            $comentario => '<b>Comentarios adicionales</b>',
            $checkAutorizado => '<b>Autorizado</b>',
            $autorizador => '<b>Nombre de autorizador</b>',
            $estado => '<b>Estado</b>',
        ];

        return $request->validate($reglasGeneralArray, [], $aliasArray);
    }
}

<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\Exports\NovedadesExport;
use App\Novedades;
use App\Regionales;
use App\User;
use App\Vehiculos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use Flasher\Prime\FlasherInterface;
use Maatwebsite\Excel\Facades\Excel;
class NovedadesController extends Controller
{
    public function index(Request $request){
        $selectDepartamento = $request->selectDepartamento ?? '';
        $selectEstado = $request->selectEstado ?? '';

        Session::put('item','1.');
        return view('novedades.index', compact('selectDepartamento','selectEstado'));
    }

    public function tableNovedades(Request $request){
        $totalData = Novedades::count();
        $totalFiltered = $totalData;

        $limit = empty($request->input('length')) ? 10 : $request->input('length');
        $start = empty($request->input('start')) ? 0 :  $request->input('start');

        $departamento = $request->departamento ?? '';
        $estado = $request->estado ?? '';

        $novedades = Novedades::
        Cod($request->input('columns.0.search.value'))
        ->Fecha($request->input('columns.1.search.value'))
        ->Operador($request->input('columns.2.search.value'))
        ->Ambito($request->input('columns.3.search.value'))
        ->Evento($request->input('columns.4.search.value'))
        ->CuentaMatricula($request->input('columns.5.search.value'))
        ->Regional($request->input('columns.6.search.value'))
        ->Reportado($request->input('columns.7.search.value'))
        ->Estado($estado)
        ->Departamento($departamento);

        $totalFiltered = $novedades->count();
        $novedades = $novedades
        ->offset($start)
        ->limit($limit)
        ->orderBy('id','desc')
        ->get();

        $data = array();
        foreach ($novedades as $novedad){
            $nestedData['cod'] = $novedad->getCod();
            $nestedData['fecha'] = $novedad->infoFecha();
            $nestedData['operador'] = $novedad->operador->fullName;
            $nestedData['ambito'] = $novedad->nameAmbito(true);
            $nestedData['evento'] = $novedad->nameEvento();
            $nestedData['cuentaMatricula'] = $novedad->getCuentaMatricula();
            $nestedData['regional'] = $novedad->getRegional();
            $nestedData['departamento'] = $novedad->getDepartamento();
            $nestedData['reportado'] = $novedad->reportado->fullName;
            $nestedData['estado'] = $novedad->getEstadoHTML();
            $nestedData['operations'] = $novedad->getOperacionesHTML();
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
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
            $novedad->nombre_autorizador = 'Via alarma';
            $novedad->estado = 'C';
        }else{
            // Si se marca el check autorizado
            if($request->checkAutorizado == '1'){
                $novedad->nombre_autorizador = $request->autorizador;
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

    public function modalEdit($id){
        $novedad = Novedades::findOrFail(decode($id));
        // canPassAdminJefe();
        $regionales = Regionales::where('estado', 1)->orderBy('nombre_regional')->get();
        // $operadores = User::where('active', 1)->where('role_id', 2)->orderBy('ap_paterno')->get();
        $operadores = User::where('active', 1)->orderBy('ap_paterno')->get();
        $administrativos = User::where('active', 1)->where('role_id', 1)->orderBy('ap_paterno')->get();
        $cuentas = Cuentas::where('estado', 1)->get();
        $vehiculos = Vehiculos::where('estado', 1)->get();
        return view('novedades.modalEdit', compact('novedad','regionales','operadores','administrativos','cuentas','vehiculos'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $this->validarFormulario($request, $id);

        $novedad = Novedades::findOrFail(decode($id));

        $fechaSave = Carbon::createFromFormat('d/m/Y H:i', $request->fechaNovedadedit);
        // Guardar nueva novedad en base de datos
        $novedad->fecha_novedad = $fechaSave;
        $novedad->operador_id = decode($request->operadoredit);
        $novedad->ambito = $request->ambitoedit;
        $novedad->evento = $request->eventoedit;
        $novedad->reportado_id = decode($request->reportadoedit);
        $novedad->comentarios = $request->comentarioedit;

        // Si el evento es activacion de alarma guardar datos de sensor
        if($request->eventoedit == '1'){
            $novedad->zona_alarma = $request->zonaedit;
            $novedad->sensor_alarma = $request->sensoredit;
            $novedad->ubicacion_alarma = $request->ubicacionedit;
            $novedad->nombre_autorizador = 'Via alarma';
            $novedad->estado = 'C';
        }else{
            // Si se marca el check autorizado
            if($request->checkAutorizado == '1'){
                $novedad->nombre_autorizador = $request->autorizadoredit;
                $novedad->estado = $request->estadoedit;
            }else{
                $novedad->estado = 'S';
            }
        }

        // Si el ambito es de vehiculos guardar datos de vehiculos
        if($request->ambitoedit == '3'){
            $novedad->conductor_vehiculo_id = decode($request->conductoredit);
            $novedad->contacto_cuenta_id = null;
        }else{
            // Si no adicionar validaciones de cuentas
            $novedad->contacto_cuenta_id = decode($request->contactoedit);
            $novedad->conductor_vehiculo_id = null;
        }
        $novedad->update();
        $flasher->addFlash('info', 'Modificada con éxito', 'Novedad '.$novedad->cod);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $novedad = Novedades::findOrFail(decode($id));
        return view('novedades.modalDelete', compact('novedad'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $novedad = Novedades::findOrFail(decode($id));
        if($novedad->estado == 'C'){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar la novedad '.$novedad->cod);
            return redirect()->route('novedades.index');
        }
        $novedad->delete();
        $flasher->addFlash('error', 'Eliminada correctamente', 'Novedad '.$novedad->cod);
        return redirect()->route('novedades.index');
    }

    public function modalEstado($id){
        canPassAdminJefe();
        $novedad = Novedades::findOrFail(decode($id));
        return view('novedades.modalState', compact('novedad'));
    }

    public function changeEstado(Request $request, FlasherInterface $flasher, $id){

        $reglasGeneralArray = [
            'autorizador' => 'required',
        ];
        $aliasArray = [
            'autorizador' => '<b>Nombre de autorizador</b>',
        ];
        $request->validate($reglasGeneralArray, [], $aliasArray);

        canPassAdminJefe();
        $novedad = Novedades::findOrFail(decode($id));
        $novedad->nombre_autorizador = $request->autorizador;
        $novedad->estado = 'C';
        $novedad->update();
        $flasher->addFlash('success', 'Cerrada correctamente', 'Novedad '.$novedad->cod);
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

    public function modalComentarios($id){
        $novedad = Novedades::findOrFail(decode($id));
        return view('novedades.modalComentarios', compact('novedad'));
    }

    public function export(Request $request){

        $codb = $request->codb;
        $fechab = $request->fechab;
        $operadorb = $request->operadorb;
        $operadorb = $operadorb != "" ? decode($operadorb) : '';
        $ambitob = $request->ambitob;
        $eventob = $request->eventob;
        $cuentab = $request->cuentab;
        $regionalb = $request->regionalb;
        $reportadob = $request->reportadob;
        $reportadob = $reportadob != "" ? decode($reportadob) : '';
        $estadob = $request->estadob;
        $departamentob = $request->departamentob;

        $novedades = Novedades::
        Cod($codb)
        ->Fecha($fechab)
        ->Operador($operadorb)
        ->Ambito($ambitob)
        ->Evento($eventob)
        ->CuentaMatricula($cuentab)
        ->Regional($regionalb)
        ->Reportado($reportadob)
        ->Estado($estadob)
        ->Departamento($departamentob)
        ->orderBy('cod','desc')->get();

        if($novedades->count() == 0){
            return  \Response::json(['success' => '3'], 201);
        }

        libxml_use_internal_errors(true);
        return Excel::download((new NovedadesExport())->parametros($novedades),'novedades_'.date("d-m-Y").'.xlsx');

    }
}

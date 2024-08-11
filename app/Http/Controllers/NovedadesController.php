<?php

namespace App\Http\Controllers;

use App\Regionales;
use App\User;
use Illuminate\Http\Request;
use Session;

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
        $autorizadores = User::where('active', 1)->where('role_id', 1)->orderBy('ap_paterno')->get();
        return view('novedades.modalCreate', compact('regionales','operadores','autorizadores'));
    }

    public function store(Request $request, FlasherInterface $flasher) {
        canPassAdminJefe();
        $this->validarFormulario($request);

        // departamentoId
        // GUARDANDO EL CODIGO DE LA OT
        $departamentoId = $request->departamentoId;
        $registroMaximo = Cuentas::select('cod')->where('cod', 'LIKE', "$departamentoId%")->max('cod');
        $cod = generateCode($registroMaximo, $departamentoId.'001', $departamentoId, 1, 3);
        // Guardar nueva regional en base de datos
        $cuenta = new Cuentas();
        $cuenta->cod = $cod;
        $cuenta->nombre_cuenta = $request->nombre;
        $cuenta->regional_id = $request->regional;
        $cuenta->estado = 1;
        $cuenta->save();

        $flasher->addFlash('success', 'Creada con éxito', 'Cuenta '.$cuenta->nombre_cuenta);
        return  \Response::json(['success' => '1']);
    }
}

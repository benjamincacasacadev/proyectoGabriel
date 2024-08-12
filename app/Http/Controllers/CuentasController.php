<?php

namespace App\Http\Controllers;

use App\ContactosCuentas;
use App\Cuentas;
use App\Regionales;
use Illuminate\Http\Request;
use Session;
use Flasher\Prime\FlasherInterface;
class CuentasController extends Controller
{
    public function index(Request $request){
        $selectDepartamento = $request->selectDepartamento ?? '';
        Session::put('item','2.1:');
        return view('cuentas.index', compact('selectDepartamento'));
    }

    public function show($id){
        $cuenta = Cuentas::findOrFail(decode($id));
        $contactos = ContactosCuentas::where('cuenta_id', $cuenta->id)->orderBy('id','desc')->get();
        Session::put('item','2.1:');
        return view('cuentas.show', compact('cuenta','contactos'));
    }

    public function tableCuentas(Request $request){
        $totalData = Cuentas::count();
        $totalFiltered = $totalData;

        $limit = empty($request->input('length')) ? 10 : $request->input('length');
        $start = empty($request->input('start')) ? 0 :  $request->input('start');
        $cuentas = Cuentas::
        Cod($request->input('columns.0.search.value'))
        ->Nombre($request->input('columns.1.search.value'))
        ->Cliente($request->input('columns.2.search.value'))
        ->Regional($request->input('columns.3.search.value'))
        ->Departamento($request->departamento);

        $totalFiltered = $cuentas->count();
        $cuentas = $cuentas
        ->offset($start)
        ->limit($limit)
        ->orderBy('id','desc')
        ->get();

        $data = array();
        foreach ($cuentas as $cuenta){
            $nestedData['cod'] = $cuenta->getCodLink();
            $nestedData['nombre'] = $cuenta->nombre_cuenta;
            $nestedData['cliente'] = $cuenta->cliente->nombre;
            $nestedData['regional'] = $cuenta->regional->nombre_regional;
            $nestedData['departamento'] = $cuenta->regional->nameCiudad();
            $nestedData['estado'] = $cuenta->getEstadoHTML();
            $nestedData['operations'] = $cuenta->getOperacionesHTML();
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
        canPassAdminJefe();
        $regionales = Regionales::where('estado', 1)->orderBy('nombre_regional')->get();
        return view('cuentas.modalCreate', compact('regionales'));
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

    public function modalEdit($id){
        canPassAdminJefe();
        $cuenta = Cuentas::findOrFail(decode($id));
        $regionales = Regionales::where('estado', 1)->orderBy('nombre_regional')->get();
        return view('cuentas.modalEdit', compact('cuenta','regionales'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $this->validarFormulario($request, $id);

        $cuenta = Cuentas::findOrFail(decode($id));

        // Si el departamento se edita se cambia el codigo
        $letraCod = $cuenta->cod[0];
        $departamentoId = $request->departamentoIdedit;
        if($letraCod != $departamentoId){
            $registroMaximo = Cuentas::select('cod')->where('cod', 'LIKE', "$departamentoId%")->max('cod');
            $cod = generateCode($registroMaximo, $departamentoId.'001', $departamentoId, 1, 3);
            $cuenta->cod = $cod;
        }

        $cuenta->nombre_cuenta = $request->nombreedit;
        $cuenta->regional_id = $request->regionaledit;
        $cuenta->update();

        $flasher->addFlash('info', 'Modificada con éxito', 'Cuenta '.$cuenta->nombre_cuenta);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $cuenta = Cuentas::findOrFail(decode($id));
        $cantAsociados = 0;
        return view('cuentas.modalDelete', compact('cuenta','cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $cuenta = Cuentas::findOrFail(decode($id));
        $cantAsociados = 0;
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar la cuenta '.$cuenta->nombre_cuenta);
            return redirect()->route('cuentas.index');
        }
        $cuenta->delete();
        $flasher->addFlash('error', 'Eliminada correctamente', 'Cuenta '.$cuenta->nombre_cuenta);
        return redirect()->route('cuentas.index');
    }

    function changeEstado(FlasherInterface $flasher, $id, $estado){
        $cuenta = Cuentas::findOrFail(decode($id));
        if ($estado == 1) {
            $cuenta->estado = '0';
            $cuenta->update();
            $flasher->addFlash('warning', 'Desactivada correctamente', 'Cuenta '.$cuenta->nombre_cuenta);
        } else {
            $cuenta->estado = '1';
            $cuenta->update();
            $flasher->addFlash('success', 'Activada correctamente', 'Cuenta '.$cuenta->nombre_cuenta);
        }
        return redirect()->route('cuentas.index');
    }

    public function validarFormulario(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombre = 'nombre'.$edit;
        $regional = 'regional'.$edit;

        $reglasArray = [
            $nombre => 'bail|required|min:2|max:100',
            $regional => 'required',
        ];

        $aliasArray = [
            $nombre => '<b>Nombre de cuenta</b>',
            $regional => '<b>Departamento</b>',
        ];

        return $request->validate($reglasArray, [], $aliasArray);
    }

}

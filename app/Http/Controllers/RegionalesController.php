<?php

namespace App\Http\Controllers;

use App\Regionales;
use Illuminate\Http\Request;
use Session;
use Flasher\Prime\FlasherInterface;
class RegionalesController extends Controller
{
    public function index(){
        $regionales = Regionales::get();
        Session::put('item','4.');
        return view('regionales.index', compact('regionales'));
    }

    public function modalCreate(){
        canPassAdminJefe();
        return view('regionales.modalCreate');
    }

    public function store(Request $request, FlasherInterface $flasher) {
        canPassAdminJefe();
        $this->validarFormulario($request);

        // Guardar nueva regional en base de datos
        $regional = new Regionales();
        $regional->nombre_regional = $request->nombre;
        $regional->departamento = $request->departamento;
        $regional->estado = 1;
        $regional->save();

        $flasher->addFlash('success', 'Creada con éxito', 'Regional '.$regional->nombre_regional);
        return  \Response::json(['success' => '1']);
    }

    public function modalEdit($id){
        canPassAdminJefe();
        $regional = Regionales::findOrFail(decode($id));
        return view('regionales.modalEdit', compact('regional'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $this->validarFormulario($request, $id);

        $regional = Regionales::findOrFail(decode($id));
        $regional->nombre_regional = $request->nombreedit;
        $regional->departamento = $request->departamentoedit;
        $regional->update();

        $flasher->addFlash('info', 'Modificada con éxito', 'Regional '.$regional->nombre_regional);
        return  \Response::json(['success' => '1']);
    }

    public function validarFormulario(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombre = 'nombre'.$edit;
        $departamento = 'departamento'.$edit;

        $reglasArray = [
            $nombre => 'bail|required|min:2|max:100',
            $departamento => 'required',
        ];

        $aliasArray = [
            $nombre => '<b>Nombre de regional</b>',
            $departamento => '<b>Departamento</b>',
        ];

        return $request->validate($reglasArray, [], $aliasArray);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $regional = Regionales::findOrFail(decode($id));
        $cantAsociados = 0;
        return view('regionales.modalDelete', compact('regional', 'cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $regional = Regionales::findOrFail(decode($id));
        $cantAsociados = 0;
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar la regional '.$regional->nombre_regional);
            return redirect()->route('regionales.index');
        }
        $regional->delete();
        $flasher->addFlash('error', 'Eliminada correctamente', 'Regional '.$regional->nombre_regional);
        return redirect()->route('regionales.index');
    }


    function changeEstado(FlasherInterface $flasher, $id, $estado){
        $regional = Regionales::where('id',decode($id) )->first();
        if ($estado == 1) {
            $regional->estado = '0';
            $regional->update();
            $flasher->addFlash('warning', 'Desactivada correctamente', 'Regional '.$regional->nombre);
        } else {
            $regional->estado = '1';
            $regional->update();
            $flasher->addFlash('success', 'Activada correctamente', 'Regional '.$regional->nombre);
        }
        return redirect()->route('regionales.index');
    }
}

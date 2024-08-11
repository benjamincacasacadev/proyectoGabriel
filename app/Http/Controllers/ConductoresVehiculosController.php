<?php

namespace App\Http\Controllers;

use App\ConductoresVehiculos;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;

class ConductoresVehiculosController extends Controller
{
    public function modalCreate($vehiculoId){
        canPassAdminJefe();
        return view('vehiculos.conductores.modalCreate', compact('vehiculoId'));
    }

    public function store(Request $request, FlasherInterface $flasher) {
        $this->validateConductores($request);
        $conductor = new ConductoresVehiculos();
        $conductor->vehiculo_id = decode($request->vehiculoId);
        $conductor->nombre_conductor = $request->nombreConductor;
        $conductor->celular_conductor = $request->celular;
        $conductor->save();

        $flasher->addFlash('success', 'Creado con éxito', 'Conductor '.$conductor->nombre_conductor);
        return  \Response::json(['success' => '1']);
    }

    public function modalEdit(Request $request, $id){
        $conductor = ConductoresVehiculos::findOrFail(decode($id));
        return view('vehiculos.conductores.modalEdit', compact('conductor'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        $this->validateConductores($request, $id);

        $conductor = ConductoresVehiculos::findOrFail(decode($id));
        $conductor->nombre_conductor = $request->nombreConductoredit;
        $conductor->celular_conductor = $request->celularedit;
        $conductor->update();

        $flasher->addFlash('info', 'Modificado con éxito', 'Conductor '.$conductor->nombre_conductor);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $conductor = ConductoresVehiculos::findOrFail(decode($id));
        $cantAsociados = 0;
        return view('vehiculos.conductores.modalDelete', compact('conductor','cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $conductor = ConductoresVehiculos::findOrFail(decode($id));
        $cantAsociados = 0;
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar el conductor '.$conductor->nombre_conductor);
            return redirect()->route('cuentas.show', code($conductor->cuenta_id));
        }
        $conductor->delete();
        $flasher->addFlash('error', 'Eliminado correctamente', 'Conductor '.$conductor->nombre_conductor);
        return redirect()->route('vehiculos.show', code($conductor->vehiculo_id));
    }
    public function validateConductores(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombreConductor = 'nombreConductor'.$edit;
        $celular = 'celular'.$edit;

        $validateArray = [
            $nombreConductor => 'bail|required|min:3|max:100',
            $celular => 'bail|required|min:3|max:20',
        ];

        $aliasArray = [
            $nombreConductor => '<b>Nombre completo</b>',
            $celular => '<b>Celular</b>',
        ];

        return $request->validate($validateArray, [], $aliasArray);
    }
}

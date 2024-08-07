<?php

namespace App\Http\Controllers;

use App\Regionales;
use App\Vehiculos;
use Illuminate\Http\Request;
use Session;
use Flasher\Prime\FlasherInterface;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;

class VehiculosController extends Controller
{
    public function index(Request $request){
        $selectDepartamento = $request->selectDepartamento ?? '';
        Session::put('item','3.');
        return view('vehiculos.index', compact('selectDepartamento'));
    }

    public function tableVehiculos(Request $request){
        $totalData = Vehiculos::count();
        $totalFiltered = $totalData;

        $limit = empty($request->input('length')) ? 10 : $request->input('length');
        $start = empty($request->input('start')) ? 0 :  $request->input('start');
        $vehiculos = Vehiculos::
        Matricula($request->input('columns.0.search.value'))
        ->Nombre($request->input('columns.1.search.value'))
        ->Regional($request->input('columns.2.search.value'))
        ->Departamento($request->departamento);

        $totalFiltered = $vehiculos->count();
        $vehiculos = $vehiculos
        ->offset($start)
        ->limit($limit)
        ->orderBy('id','desc')
        ->get();


        $data = array();
        foreach ($vehiculos as $vehiculo){
            $nestedData['matricula'] = '<b>'.$vehiculo->matricula.'</b>';
            $nestedData['nombre'] = $vehiculo->nombre_vehiculo;
            $nestedData['regional'] = $vehiculo->regional->nombre_regional;
            $nestedData['departamento'] = $vehiculo->regional->nameCiudad();
            $nestedData['estado'] = $vehiculo->getEstadoHTML();
            $nestedData['operations'] = $vehiculo->getOperacionesHTML();
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
        return view('vehiculos.modalCreate', compact('regionales'));
    }

    public function store(Request $request, FlasherInterface $flasher) {
        canPassAdminJefe();
        $this->validarFormulario($request);

        // Guardar nueva regional en base de datos
        $vehiculo = new Vehiculos();
        $vehiculo->matricula = $request->matricula;
        $vehiculo->nombre_vehiculo = $request->nombre;
        $vehiculo->regional_id = $request->regional;
        $vehiculo->estado = 1;
        // Guardar archivo
        if ($request->hasFile('fileVehiculos')) {
            $archivo = $request->file('fileVehiculos');
            $extension = $archivo->getClientOriginalExtension();
            $ext = strtolower($extension);
            $nombreConExtension = $archivo->getClientOriginalName();
            $nombreConExtension = delete_charspecial($nombreConExtension);
            $vehiculo->archivo = $vehiculo->matricula . '_' . strtolower($nombreConExtension);

            $archivo->storeAs("public/vehiculos/", $vehiculo->archivo);
            if($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
                $size = getimagesize($archivo);
                if($size[0]<=1024 && $size[1]<=1024){
                    InterventionImage::make($archivo)->resize(function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/vehiculos/'.$vehiculo->archivo, 90);
                }else{
                    InterventionImage::make($archivo)->resize(1024,1024, function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/vehiculos/'.$vehiculo->archivo, 80);
                }
            }
        }
        $vehiculo->save();

        $flasher->addFlash('success', 'Creado con éxito', 'Vehículo '.$vehiculo->nombre_vehiculo);
        return  \Response::json(['success' => '1']);
    }

    public function modalEdit($id){
        canPassAdminJefe();
        $vehiculo = Vehiculos::findOrFail(decode($id));
        $regionales = Regionales::where('estado', 1)->orderBy('nombre_regional')->get();
        return view('vehiculos.modalEdit', compact('vehiculo','regionales'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $this->validarFormulario($request, $id);

        $vehiculo = Vehiculos::findOrFail(decode($id));
        $vehiculo->matricula = $request->matricula;
        $vehiculo->nombre_vehiculo = $request->nombreedit;
        $vehiculo->regional_id = $request->regionaledit;

        if ($request->hasFile('fileVehiculosedit')) {
            $rutaFile = 'public/vehiculos/'.$vehiculo->archivo;
            if (Storage::exists($rutaFile)){
                Storage::delete($rutaFile);
            }

            $archivo = $request->file('fileVehiculosedit');
            $extension = $archivo->getClientOriginalExtension();
            $ext = strtolower($extension);
            $nombreConExtension = $archivo->getClientOriginalName();
            $nombreConExtension = delete_charspecial($nombreConExtension);
            $vehiculo->archivo = $vehiculo->matricula . '_' . strtolower($nombreConExtension);

            $archivo->storeAs("public/vehiculos/", $vehiculo->archivo);
            if($ext == 'gif' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png'){
                $size = getimagesize($archivo);
                if($size[0]<=1024 && $size[1]<=1024){
                    InterventionImage::make($archivo)->resize(function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/vehiculos/'.$vehiculo->archivo, 90);
                }else{
                    InterventionImage::make($archivo)->resize(1024,1024, function ($constraint){
                        $constraint->aspectRatio();
                    })->save(storage_path().'/app/public/vehiculos/'.$vehiculo->archivo, 80);
                }
            }
        }

        $vehiculo->update();

        $flasher->addFlash('info', 'Modificado con éxito', 'Vehículo '.$vehiculo->nombre_vehiculo);
        return  \Response::json(['success' => '1']);
    }


    function changeEstado(FlasherInterface $flasher, $id, $estado){
        $vehiculo = Vehiculos::findOrFail(decode($id));
        if ($estado == 1) {
            $vehiculo->estado = '0';
            $vehiculo->update();
            $flasher->addFlash('warning', 'Desactivado correctamente', 'Vehículo '.$vehiculo->nombre_vehiculo);
        } else {
            $vehiculo->estado = '1';
            $vehiculo->update();
            $flasher->addFlash('success', 'Activado correctamente', 'Vehículo '.$vehiculo->nombre_vehiculo);
        }
        return redirect()->route('vehiculos.index');
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $vehiculo = Vehiculos::findOrFail(decode($id));
        $cantAsociados = 0;
        return view('vehiculos.modalDelete', compact('vehiculo','cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $vehiculo = Vehiculos::findOrFail(decode($id));
        $cantAsociados = 0;
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar el vehículo '.$vehiculo->nombre_cuenta);
            return redirect()->route('vehiculos.index');
        }
        $rutaFile = 'public/vehiculos/'.$vehiculo->archivo;
        if (Storage::exists($rutaFile)){
            Storage::delete($rutaFile);
        }
        $vehiculo->delete();
        $flasher->addFlash('error', 'Eliminado correctamente', 'Vehículo '.$vehiculo->nombre_cuenta);
        return redirect()->route('vehiculos.index');
    }

    public function validarFormulario(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombre = 'nombre'.$edit;
        $matricula = 'matricula';
        $regional = 'regional'.$edit;
        $fileVehiculos = 'fileVehiculos'.$edit;

        // VALIDAR QUE LA MATRICULA SEA UNICA
        $validarMatricula = ['required', Rule::unique('vehiculos')->where(function ($query) {
            $query->where('estado','1');
        })];
        if($id != ''){
            $validarMatricula = ['required', Rule::unique('vehiculos')->ignore(decode($id))->where(function ($query) {
                $query->where('estado','1');
            })];
        }

        // Validacion de archivos
        $valFile = 'mimes:jpg,jpeg,png|max:2048';
        if($request->cambioarchivo == 1){
            $valFile = 'required|mimes:jpg,jpeg,png|max:2048';
        }

        $reglasArray = [
            $nombre => 'bail|required|min:2|max:100',
            $regional => 'required',
            $matricula => $validarMatricula,
            $fileVehiculos => $valFile,
        ];

        $aliasArray = [
            $nombre => '<b>Nombre de vehículo</b>',
            $regional => '<b>Departamento</b>',
            $matricula => '<b>Matrícula</b>',
            $fileVehiculos => '<b>Archivo adjunto</b>',
        ];

        return $request->validate($reglasArray, [], $aliasArray);
    }
}

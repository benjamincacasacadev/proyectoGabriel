<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Validation\Rule;
use App\Clientes;
use Session;
class ClientesController extends Controller
{
    public function index (Request $request){
        Session::put('item','2.0:');
        return view('clientes.index');
    }

    public function tableClientes(Request $request){
        $totalData = Clientes::count();
        $totalFiltered = $totalData;

        $limit = empty($request->input('length')) ? 10 : $request->input('length');
        $start = empty($request->input('start')) ? 0 :  $request->input('start');

        $posts = Clientes::Nombre($request->input('columns.0.search.value'))
        ->Nit($request->input('columns.1.search.value'))
        ->Direccion($request->input('columns.2.search.value'));

        $totalFiltered = $posts->count();
        $posts = $posts
        ->offset($start)
        ->limit($limit)
        ->orderBy('id','desc')
        ->get();

        $data = array();
        foreach ($posts as $post){
            $nestedData['nombre'] = $post->nombre;
            $nestedData['nit'] = $post->nit;
            $nestedData['direccion'] = purify(nl2br($post->direccion));
            $nestedData['estado'] = $post->getEstadoHTML();
            $nestedData['operations'] = $post->getOperacionesHTML();
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
        return view('clientes.modalCreate');
    }

    public function store(Request $request, FlasherInterface $flasher) {
        $this->validateClientes($request);

        $client = new Clientes();
        $client->nombre = $request->nombre;
        $client->nit = $request->nit;
        $client->direccion = $request->direccion;
        $client->estado = 1;
        $client->save();

        $flasher->addFlash('success', 'Creado con éxito', 'Cliente '.$client->nombre);
        return  \Response::json(['success' => '1']);
    }

    public function modalEdit(Request $request, $id){
        $cliente = Clientes::findOrFail(decode($id));
        return view('clientes.modalEdit', compact('cliente'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        $this->validateClientes($request, $id);

        $client = Clientes::findOrFail(decode($id));
        $client->nombre = $request->nombreedit;
        $client->nit = $request->nit;
        $client->direccion = $request->direccionedit;
        $client->update();

        $flasher->addFlash('info', 'Modificado con éxito', 'Cliente '.$client->nombre);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $cliente = Clientes::findOrFail(decode($id));
        $cantAsociados = 0;
        return view('clientes.modalDelete', compact('cliente','cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $cliente = Clientes::findOrFail(decode($id));
        $cantAsociados = 0;
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar el cliente '.$cliente->nombre);
            return redirect()->route('clientes.index');
        }
        $cliente->delete();
        $flasher->addFlash('error', 'Eliminado correctamente', 'Cliente '.$cliente->nombre);
        return redirect()->route('clientes.index');
    }

    function changeEstado(FlasherInterface $flasher, $id, $estado){
        $cliente = Clientes::findOrFail(decode($id));
        if ($estado == 1) {
            $cliente->estado = '0';
            $cliente->update();
            $flasher->addFlash('warning', 'Desactivado correctamente', 'Cliente '.$cliente->nombre);
        } else {
            $cliente->estado = '1';
            $cliente->update();
            $flasher->addFlash('success', 'Activado correctamente', 'Cliente '.$cliente->nombre);
        }
        return redirect()->route('clientes.index');
    }

    public function validateClientes(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombre = 'nombre'.$edit;
        $nit = 'nit';
        $direccion = 'direccion'.$edit;

        $validateNit = ['required', Rule::unique('clientes')->where(function ($query) {
            $query->where('estado','1');
        })];

        if($id != ''){
            $validateNit = ['required', Rule::unique('clientes')->ignore(decode($id))->where(function ($query) {
                $query->where('estado','1');
            })];
        }

        $validateArray = [
            $nombre => 'bail|required|min:2|max:255',
            $nit => $validateNit,
            $direccion => 'nullable|min:3|max:255',
        ];

        $aliasArray = [
            $nombre => '<b>Nombre</b>',
            $nit => '<b>Número de NIT</b>',
            $direccion => '<b>Dirección</b>',
        ];

        return $request->validate($validateArray, [], $aliasArray);
    }

}

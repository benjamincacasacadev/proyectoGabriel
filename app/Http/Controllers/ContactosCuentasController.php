<?php

namespace App\Http\Controllers;

use App\ContactosCuentas;
use App\Novedades;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
class ContactosCuentasController extends Controller
{
    public function modalCreate($cuentaId){
        canPassAdminJefe();
        return view('cuentas.contactos.modalCreate', compact('cuentaId'));
    }

    public function store(Request $request, FlasherInterface $flasher) {
        $this->validateContactos($request);
        $contacto = new ContactosCuentas();
        $contacto->cuenta_id = decode($request->cuentaId);
        $contacto->nombre_contacto = $request->nombreContacto;
        $contacto->cargo_contacto = $request->cargo;
        $contacto->celular_contacto = $request->celular;
        $contacto->email_contacto = $request->email;
        $contacto->asignacion = $request->asignacion;
        $contacto->save();

        $flasher->addFlash('success', 'Creado con éxito', 'Contacto '.$contacto->nombre_contacto);
        return  \Response::json(['success' => '1']);
    }

    public function modalEdit(Request $request, $id){
        $contacto = ContactosCuentas::findOrFail(decode($id));
        return view('cuentas.contactos.modalEdit', compact('contacto'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id){
        $this->validateContactos($request, $id);

        $contacto = ContactosCuentas::findOrFail(decode($id));
        $contacto->nombre_contacto = $request->nombreContactoedit;
        $contacto->cargo_contacto = $request->cargoedit;
        $contacto->celular_contacto = $request->celularedit;
        $contacto->email_contacto = $request->emailedit;
        $contacto->asignacion = $request->asignacionedit;
        $contacto->update();

        $flasher->addFlash('info', 'Modificado con éxito', 'Contacto '.$contacto->nombre_contacto);
        return  \Response::json(['success' => '1']);
    }

    public function modalDelete($id){
        canPassAdminJefe();
        $contacto = ContactosCuentas::findOrFail(decode($id));
        $cantAsociados = Novedades::where('contacto_cuenta_id', $contacto->id)->count();
        return view('cuentas.contactos.modalDelete', compact('contacto','cantAsociados'));
    }

    public function destroy(FlasherInterface $flasher, $id){
        canPassAdminJefe();
        $contacto = ContactosCuentas::findOrFail(decode($id));
        $cantAsociados = Novedades::where('contacto_cuenta_id', $contacto->id)->count();
        if($cantAsociados > 0){
            $flasher->addFlash('warning', 'Tiene registros asociados', 'No se puede eliminar el contacto '.$contacto->nombre_contacto);
            return redirect()->route('cuentas.show', code($contacto->cuenta_id));
        }
        $contacto->delete();
        $flasher->addFlash('error', 'Eliminado correctamente', 'Contacto '.$contacto->nombre_contacto);
        return redirect()->route('cuentas.show', code($contacto->cuenta_id));
    }

    public function validateContactos(Request $request, $id = ''){
        $edit = $id != '' ? 'edit' : '';

        $nombreContacto = 'nombreContacto'.$edit;
        $cargo = 'cargo'.$edit;
        $celular = 'celular'.$edit;
        $email = 'email'.$edit;
        $asignacion = 'asignacion'.$edit;

        $validateArray = [
            $nombreContacto => 'bail|required|min:3|max:100',
            $cargo => 'bail|required|min:3|max:100',
            $celular => 'bail|required|min:3|max:20',
            $email => 'bail|required|max:20|email:filter',
            $asignacion => 'required',
        ];

        $aliasArray = [
            $nombreContacto => '<b>Nombre completo</b>',
            $cargo => '<b>Cargo</b>',
            $celular => '<b>Celular</b>',
            $email => '<b>Email</b>',
            $asignacion => '<b>Asignación</b>',
        ];

        return $request->validate($validateArray, [], $aliasArray);
    }

    public function listContactosDetallesAjax(Request $request) {
        $request['search'] = limpiarTexto($request->search,'s2');

        $cuenta = $request->cuenta;
        $contactos = ContactosCuentas::Nombre($request->search)
        ->where('cuenta_id', $cuenta)
        ->orderBy('id','desc')
        ->limit(20)
        ->get();

        $array = [];
        $array['results'][0]['id'] = "";
        $array['results'][0]['text'] = "Seleccione una opción";
        $array['results'][0]['info'] = "";
        foreach ($contactos as $k => $contacto) {
            $array['results'][$k + 1]['id'] = code($contacto->id);
            $array['results'][$k + 1]['text'] = $contacto->nombre_contacto;
            $array['results'][$k + 1]['info'] = $contacto->getInfoContactos();
        }
        $array['pagination']['more'] = false;
        return response()->json($array);
    }
}

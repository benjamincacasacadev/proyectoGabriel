<?php

use App\User;
use Flasher\Prime\FlasherInterface;
use Spatie\Permission\Models\Role;
function nameEmpresa(){
    return "PROYECTO UAB";
}

function userId(){
    return auth()->user()->id;
}

function roleId(){
    return auth()->user()->role_id;
}

function userData($id){
    $user = User::find($id);
    return isset($user) ? $user : null;
}

function roleName($id){
    $rol = Role::find($id);
    return isset($rol) ? $rol->name : "";
}

function userMail($id){
    return userData($id) != null ? userData($id)->email : '';
}

function themeMode(){
    return isset( auth()->user()->layout ) ? auth()->user()->layout[0] : "L";
}

/**
 * Devuelve el id encriptado
* @param int $id es el numero que será encriptado
* @return int $id
*/
function code($id){
    return \Hashids::encode($id);
}

/**
 * Devuelve el id desencriptado
* @param int $id es el numero que se encuentra encriptado
* @return int $id
*/
function decode($id){
    $deco = \Hashids::decode($id);
    return count($deco) == 0 ? 0 : \Hashids::decode($id)[0];
}

/**
 * Devuelve el nombre y el apellido paterno de un usuario
 * @param  int $id ID del usuario del cual que quiere obtener su nombre
 * @return string $user_name
 */
function userFullName($id){
    if(isset($id)){
        $user = User::select('name','ap_paterno','ap_materno')->whereId($id)->first();
        return isset($user) ? $user->name." ".$user->ap_paterno." ".$user->ap_materno : "Usuario desconocido";
    }else
        return "Sin usuario asignado";
}

// Ruta para obtener el avatar
// $name: nombre del avatar en la tabla Users
// $swT: 1 obtener el thumbnail, 0: obtener tamaño grande
function imageRouteAvatar($name,$swT){
    $routeAttach = storage_path('app/public/general/avatar/'.$name);
    $routeAttachThumb = storage_path('app/public/general/avatar/thumbnail/'.$name);
    if($swT == 1){
        if (isset($name) && file_exists($routeAttachThumb))
            $ruta = '/storage/general/avatar/thumbnail/'.$name."?".rand();
        else
            $ruta = '/storage/thumbnail/avatar0.png?'.rand();
    }else{
        if (isset($name) && file_exists($routeAttach))
            $ruta = '/storage/general/avatar/'.$name."?".rand();
        else
            $ruta = '/storage/avatar0.png?'.rand();
    }
    return $ruta;
}

/**
 * Convierte la fecha de entrada dd/mm/YYYY a YYYY-mm-dd
* @param date $fechaEntreda  es la fecha de entrada del dataTable
* @return date $fechaSalida  es la fecha de salida para el filtro
*/
function convFechaDT($fechaInicial){
    $fechaFinal=explode("/",$fechaInicial);
    switch (count($fechaFinal)) {
        case '1':   return $fechaFinal[0];  break;
        case '2':   return $fechaFinal[1]."-".$fechaFinal[0];   break;
        case '3':   return $fechaFinal[2]."-".$fechaFinal[1]."-".$fechaFinal[0];    break;
        default:    return "";  break;
    }
}

/**
 * Devuelve los permisos
 * @return array $permisos el listado de los permisos
 */
function getPermisos($id){
    return Permission::where('parent_id',$id)->where('active','1')->orderBy('orden')->get();
}

function permisoName($id){
    $perm = Permission::find($id);
    return isset($perm) ? $perm->description : "";
}

function purify($val){
    return \Purify::clean($val);
}



function datosRegistro($type){
    $titulo = $type == 'edit' ? 'Modificado por' : 'Registrado por';
    $fecha = $type == 'edit' ? 'Fecha de modificación' : 'Fecha de registro';

    return
    '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label>'.$titulo.'</label> <br>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                </div>
                <input class="form-control input-incon cursor-not-allowed" value="'.userFullName(userId()).'" disabled>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="form-group">
            <label>'.$fecha.'</label> <br>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <input class="form-control input-incon cursor-not-allowed" value="'.date("d/m/Y").'" disabled>
            </div>
        </div>
    </div>';
}

/**
 * Devuelve el codigo generado
 * @param $maximo El registro máximo Ejm: OV000234
 * @param $code Es el inicial Ejm: OV000001
 * @param $letter La letra(s) que corresponden al código Ejm: OV
 * @param $cant_letras La cantidad de letras que debe tener el código Ejm: 2
 * @param $zero La cantidad de digitos (en muchos casos ceros) con la cual se debe completar el código Ejm: 6
 * @return $cod Codigo final Ejm: OV000235
 */
function generateCode($maximo,$code,$letter,$cant_letras,$zero){
    if($maximo == null){
        $cod = $code;
    }else{
        $cont = substr($maximo, $cant_letras);
        $cont = $cont+1;
        $codConCeros = str_pad($cont, $zero,"0", STR_PAD_LEFT);
        $cod = $letter.$codConCeros;
    }
    return $cod;
}

function checkVacio($var){
    return isset($var) && $var != "";
}

function delete_char_file($url){
    $url = mb_strtolower($url);
    $array_characters = array('Š'=>'S', 'š'=>'s', 'Ṕ'=>'Z', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y','ñ'=>'n','ç'=>'c','/'=>'_',"\\"=>'_','%'=>'_' );
    $url = strtr( $url, $array_characters );
    $url = preg_replace('([^A-_a-z!-@ ])', '-', $url);
    return $url;
}

function delete_charspecial($url){
    $url = strtolower($url);
    $array_characters = array('Š'=>'S', 'š'=>'s', 'Ṕ'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y','ñ'=>'n','ç'=>'c','/'=>'_',"\\"=>'_','%'=>'_' );
    $url = strtr( $url, $array_characters );
    $find = array(' ', '&', '\r\n', '\n','+');
    $url = str_replace($find, '-', $url);
    $url = preg_replace('([^A-_a-z!-@ ])', '_', $url);
    return $url;
}

function cleanAll($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-_]/', '-', $string); // Removes special chars.
}

function isBetween($varToCheck, $high, $low) {
    if($varToCheck < $low) return false;
    if($varToCheck > $high) return false;
    return true;
}

function fechaLiteral($fecha = false){
    $dias = array("", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    /* pregunta si ingreso el dato de fecha */
    if (!$fecha) $fecha = date("Y-m-d");
    return $dias[date('N', strtotime($fecha))] . " " . date('j', strtotime($fecha)) . " de " . $meses[date('n', strtotime($fecha))] . " de " . date('Y', strtotime($fecha));
}

function permisoOperador(){
    return roleId() == 2;
}

function permisoAdministrador(){
    return roleId() == 1;
}

function canPassAdminJefe(){
    if(!permisoAdministrador()){
        return abort(403);
    }
}

function limpiarTexto($texto,$type){
    if($type == 's2'){
        $find = array('â','ê','î','ô','û','ã','õ','ç');
        $repl = array('a','e','i','o','u','a','o','c');
        $texto = str_replace($find, $repl, $texto);
        $txt = trim(preg_replace('([^A-_a-z!-@ñ ])', '-*', $texto));
    }
    return $txt;
}

function randAvatar(){
    $arr = ["bg-green-lt","bg-red-lt","bg-yellow-lt","bg-blue-lt","bg-purple-lt"];
    shuffle($arr);
    return $arr[0];
}

function mostrarArchivosST($file, $ruta_archivo, $i, $cod, $modulo = 'reports' ){
    $extension=explode('.',$file);
    $extensionNueva=end($extension);
    $extensionNueva = strtolower($extensionNueva);
    if ($extensionNueva=='png' || $extensionNueva=='jpg' || $extensionNueva=='jpeg' || $extensionNueva=='gif' || $extensionNueva=='svg') {
        return  '<a rel="modalImagen" style="text-decoration: none" href="/reports/mostrarImagen/' . $i . '" title="Ver Imagen">
                    <svg class="icon text-orange iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="15" y1="8" x2="15.01" y2="8" /><rect x="4" y="4" width="16" height="16" rx="3" /><path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" /><path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" /></svg>
                </a>';
    } elseif ($extensionNueva=='pdf') {
        return '<a href="/storage'.$ruta_archivo.$file.'" title="PDF" target="_blank">
                    <svg class="icon text-red iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="9" y1="17" x2="9" y2="12" /><line x1="12" y1="17" x2="12" y2="16" /><line x1="15" y1="17" x2="15" y2="14" /></svg>
                </a>';
    } elseif ($extensionNueva=='doc' || $extensionNueva=='docx') {
        return '<a href="/'.$modulo.'/downloadfile/'.$file.'/'.$cod.'" title="Word">
                    <svg class="icon text-primary iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><line x1="9" y1="9" x2="10" y2="9" /><line x1="9" y1="13" x2="15" y2="13" /><line x1="9" y1="17" x2="15" y2="17" /></svg>
                </a>';
    } elseif ($extensionNueva=='rar' || $extensionNueva=='zip' || $extensionNueva=='tar') {
        return '<a href="/'.$modulo.'/downloadfile/'.$file.'/'.$cod.'" title="Archivo comprimido">
                    <svg class="icon iconhover" style="color:#f7daab" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 20.735a2 2 0 0 1 -1 -1.735v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-1" /><path d="M11 17a2 2 0 0 1 2 2v2a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1v-2a2 2 0 0 1 2 -2z" /><line x1="11" y1="5" x2="10" y2="5" /><line x1="13" y1="7" x2="12" y2="7" /><line x1="11" y1="9" x2="10" y2="9" /><line x1="13" y1="11" x2="12" y2="11" /><line x1="11" y1="13" x2="10" y2="13" /><line x1="13" y1="15" x2="12" y2="15" /></svg>
                </a>';
    }elseif ($extensionNueva=='xlsx' || $extensionNueva=='xlsm' || $extensionNueva=='xls' || $extensionNueva=='csv') {
        return '<a href="/'.$modulo.'/downloadfile/'.$file.'/'.$cod.'" title="Excel">
                    <svg class="icon text-green iconhover" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M10 12l4 4m0 -4l-4 4" /></svg>
                </a>';
    }
}

function iconoArchivos($nom_archivo, $size = '100px'){
    $extension = explode('.',$nom_archivo);
    $extensionNueva = end($extension);
    if($extensionNueva=='xlsx' || $extensionNueva=='xlsm' || $extensionNueva=='xls' || $extensionNueva=='csv'){
        return '<img class="mb-2" src="/imagenes/iconoExcel.png" class="img-rounded img-responsive pull-left" style="width: '.$size.'; " alt="Sin imagen para mostdar" id="imgItem">'; }
    elseif($extensionNueva=='rar' || $extensionNueva=='zip' || $extensionNueva=='tar'){
        return '<img class="mb-2" src="/imagenes/iconoZip.png" class="img-rounded img-responsive pull-left" style="width: '.$size.'; " alt="Sin imagen para mostdar" id="imgItem">'; }
    elseif($extensionNueva=='doc' || $extensionNueva=='docx'){
        return '<img class="mb-2" src="/imagenes/iconoWord.png" class="img-rounded img-responsive pull-left" style="width: '.$size.'; " alt="Sin imagen para mostdar" id="imgItem">'; }
    elseif($extensionNueva=='pdf'){
        return '<img class="mb-2" src="/imagenes/iconoPdf.png" class="img-rounded img-responsive pull-left" style="width: '.$size.'; " alt="Sin imagen para mostdar" id="imgItem">' ; }
    else{
        return '<img class="mb-2" src="/imagenes/iconoImg.svg" class="img-rounded img-responsive pull-left" style="width: '.$size.'; " alt="Sin imagen para mostdar" id="imgItem">';
    }
}

function sliderImg(){
    $imgslider = ['01.png','02.png','03.png'];
    $salida = [];
    foreach ($imgslider as $img){
        if (Storage::exists('public/general/slider/'.$img)){
            $salida[] = asset('/storage/general/slider/'.$img);
        }
    }
    return $salida;
}

function monedaVal($valor){
    $numero = floatval(str_replace(",","",$valor));
    return $numero;
}


function generarCorreoGmail($nombreCompleto) {
    // Convertir el nombre completo a minúsculas y eliminar espacios
    $nombreCompleto = strtolower(str_replace(' ', '', $nombreCompleto));

    // Eliminar caracteres especiales y acentos
    $nombreNormalizado = iconv('UTF-8', 'ASCII//TRANSLIT', $nombreCompleto);

    // Eliminar cualquier carácter no alfanumérico excepto puntos
    $nombreNormalizado = preg_replace('/[^a-z0-9.]+/i', '', $nombreNormalizado);

    // Generar el correo electrónico agregando "@gmail.com"
    $correoElectronico = $nombreNormalizado . '@gmail.com';

    return $correoElectronico;
}

// ============================================================================
// Listas de parametros del sistema
// ============================================================================
function listaDepartamentos(){
    $departamentos = [
        '1' => 'La Paz',
        '2' => 'Santa Cruz',
        '3' => 'Tarija',
        '4' => 'El Alto',
        '5' => 'Potosí',
        '6' => 'Cochabamba',
        '7' => 'Oruro',
        '8' => 'Chuquisaca',
        '9' => 'Beni',
        '10' => 'Pando'
    ];

    asort($departamentos);

    return $departamentos;
}


function listaAmbitos(){
    $ambitos = [
        '1' => 'Seguridad física',
        '2' => 'Seguridad electrónica',
        '3' => 'Vehículos',
    ];

    asort($ambitos);

    return $ambitos;
}

function listaEventos(){
    $eventos = [
        '1' => 'Activación de alarma',
        '2' => 'Movimiento fuera de horario',
        '3' => 'Apertura remota',
        '4' => 'Cierre remoto',
        '5' => 'Asignación de llaves',
        '6' => 'Control retorno de vehículo',
        '7' => 'Salida de vehículo fuera de horario',
        '8' => 'Pernocte diferente',
        '9' => 'Vehiculo en taller de mantenimiento',
        '10' => 'Vehiculo sin comunicación',
    ];

    asort($eventos);
    return $eventos;
}



<?php

Route::get('/list_of_contactos_details', 'ContactosCuentasController@listContactosDetallesAjax')->name('contactos.listContactos.detalles');
Route::get('/list_of_conductores_details', 'ConductoresVehiculosController@listConductoresDetallesAjax')->name('conductores.listConductores.detalles');

// ========================================================================================
//                                          USUARIOS
// ========================================================================================
// VER INDEX DE USUARIOS
Route::get('/users','UserController@index')->name('users.index');
Route::get('/users/show/{id}','UserController@show')->name('users.show');
Route::get('/usuario/export', 'UserController@export')->name('users.export');
Route::get('/users/create','UserController@create')->name('users.create');
Route::post('/users/store','UserController@store')->name('users.store');
Route::get('/users/create','UserController@create')->name('users.create');
Route::post('/users/store','UserController@store')->name('users.store');
Route::get('/users/{user}/edit','UserController@edit')->name('users.edit');
Route::post('/users/{user}','UserController@update')->name('users.update');
Route::post('/users_delete/{user}','UserController@destroy')->name('users.destroy');
Route::get('/users/modalDelete/{id}', 'UserController@modalDelete')->name('users.modalDelete');
Route::get('/users/modalCambEstado/{id}', 'UserController@modalCambioEstado')->name('users.modalState');
Route::post('/users/cambiarestado/{id}','UserController@cambiarestado')->name('users.cambiarestado');
Route::get('/users_privilegios/{user}/edit','UserController@privilegios')->name('users.privilegios');
Route::put('/users/privilegios/{user}','UserController@privilegiosupdate')->name('users.privilegiosupdate');
Route::put('/users/{user}/rol','UserController@updaterol')->name('updaterol');
Route::get('/perfil_usuario','UserController@perfil')->name('perfil');
Route::post('updateprofile/{user}','UserController@updateprofile')->name('updateprofile');
Route::post('/useravatar', 'UserController@uploadAvatarImagen')->name('users.avatar');
Route::post('/validar_user','UserController@validarUsername')->name('users.validar');
Route::post('/userfirma', 'UserController@uploadFirmaImagen')->name('users.firma');

// ========================================================================================
//                                      REGIONALES
// ========================================================================================
Route::get('/regionales', 'RegionalesController@index')->name('regionales.index');
Route::get('/regionales/modalCreate', 'RegionalesController@modalCreate')->name('regionales.createmodal');
Route::post('/store_regionales', 'RegionalesController@store')->name('regionales.store');
Route::get('/regionales/modalEdit/{id}', 'RegionalesController@modalEdit')->name('regionales.editmodal');
Route::post('/regionales/update/{id}', 'RegionalesController@update')->name('regionales.update');
Route::get('/regionales/modalDelete/{id}', 'RegionalesController@modalDelete')->name('regionales.deletemodal');
Route::post('/regionales/delete/{id}','RegionalesController@destroy')->name('regionales.destroy');
Route::get('/regionales/estado/{id}/{estado}', 'RegionalesController@changeEstado')->name('regionales.cambioEstado');


// ========================================================================================
//                                      CLIENTES
// ========================================================================================
Route::get('/clientes', 'ClientesController@index')->name('clientes.index');
Route::post('/table_clientes', 'ClientesController@tableClientes')->name('clientes.table');
Route::get('/clientes/estado/{id}/{estado}', 'ClientesController@changeEstado')->name('clientes.cambioEstado');
Route::get('/clientes/modalCreate', 'ClientesController@modalCreate')->name('clienteS.createmodal');
Route::post('/store_clientes', 'ClientesController@store')->name('clientes.store');
Route::get('/clientes/modalEdit/{id}', 'ClientesController@modalEdit')->name('clientes.editmodal');
Route::post('/clientes/update/{id}', 'ClientesController@update')->name('clientes.update');
Route::get('/clientes/modalDelete/{id}', 'ClientesController@modalDelete')->name('clientes.deletemodal');
Route::post('/clientes/delete/{id}','ClientesController@destroy')->name('clientes.destroy');

// ========================================================================================
//                                      CUENTAS
// ========================================================================================
Route::get('/cuentas', 'CuentasController@index')->name('cuentas.index');
Route::get('/cuentas/show/{id}', 'CuentasController@show')->name('cuentas.show');
Route::post('/table_cuentas', 'CuentasController@tableCuentas')->name('cuentas.table');
Route::get('/cuentas/modalCreate', 'CuentasController@modalCreate')->name('cuentas.createmodal');
Route::post('/store_cuentas', 'CuentasController@store')->name('cuentas.store');
Route::get('/cuentas/modalEdit/{id}', 'CuentasController@modalEdit')->name('cuentas.editmodal');
Route::post('/cuentas/update/{id}', 'CuentasController@update')->name('cuentas.update');
Route::get('/cuentas/modalDelete/{id}', 'CuentasController@modalDelete')->name('cuentas.deletemodal');
Route::post('/cuentas/delete/{id}','CuentasController@destroy')->name('cuentas.destroy');
Route::get('/cuentas/estado/{id}/{estado}', 'CuentasController@changeEstado')->name('cuentas.cambioEstado');

// ========================================================================================
//                                      CONTACTOS
// ========================================================================================
Route::get('/contactos', 'ContactosCuentasController@index')->name('contactos.index');
Route::get('/contactos/modalCreate/{cuentaId}', 'ContactosCuentasController@modalCreate')->name('contactos.createmodal');
Route::post('/store_contactos', 'ContactosCuentasController@store')->name('contactos.store');
Route::get('/contactos/modalEdit/{id}', 'ContactosCuentasController@modalEdit')->name('contactos.editmodal');
Route::post('/contactos/update/{id}', 'ContactosCuentasController@update')->name('contactos.update');
Route::get('/contactos/modalDelete/{id}', 'ContactosCuentasController@modalDelete')->name('contactos.deletemodal');
Route::post('/contactos/delete/{id}','ContactosCuentasController@destroy')->name('contactos.destroy');

// ========================================================================================
//                                      VEHICULOS
// ========================================================================================
Route::get('/vehiculos', 'VehiculosController@index')->name('vehiculos.index');
Route::get('/vehiculos/show/{id}', 'VehiculosController@show')->name('vehiculos.show');
Route::post('/table_vehiculos', 'VehiculosController@tableVehiculos')->name('vehiculos.table');
Route::get('/vehiculos/modalCreate', 'VehiculosController@modalCreate')->name('vehiculos.createmodal');
Route::post('/store_vehiculos', 'VehiculosController@store')->name('vehiculos.store');
Route::get('/vehiculos/modalEdit/{id}', 'VehiculosController@modalEdit')->name('vehiculos.editmodal');
Route::post('/vehiculos/update/{id}', 'VehiculosController@update')->name('vehiculos.update');
Route::get('/vehiculos/modalDelete/{id}', 'VehiculosController@modalDelete')->name('vehiculos.deletemodal');
Route::post('/vehiculos/delete/{id}','VehiculosController@destroy')->name('vehiculos.destroy');
Route::get('/vehiculos/estado/{id}/{estado}', 'VehiculosController@changeEstado')->name('vehiculos.cambioEstado');

// ========================================================================================
//                                      CONDUCTORES
// ========================================================================================
Route::get('/conductores', 'ConductoresVehiculosController@index')->name('conductores.index');
Route::get('/conductores/modalCreate/{vehiculoId}', 'ConductoresVehiculosController@modalCreate')->name('conductores.createmodal');
Route::post('/store_conductores', 'ConductoresVehiculosController@store')->name('conductores.store');
Route::get('/conductores/modalEdit/{id}', 'ConductoresVehiculosController@modalEdit')->name('conductores.editmodal');
Route::post('/conductores/update/{id}', 'ConductoresVehiculosController@update')->name('conductores.update');
Route::get('/conductores/modalDelete/{id}', 'ConductoresVehiculosController@modalDelete')->name('conductores.deletemodal');
Route::post('/conductores/delete/{id}','ConductoresVehiculosController@destroy')->name('conductores.destroy');

// ========================================================================================
//                                      NOVEDADES
// ========================================================================================
Route::get('/novedades', 'NovedadesController@index')->name('novedades.index');
Route::post('/table_novedades', 'NovedadesController@tableNovedades')->name('novedades.table');
Route::get('/novedades/modalCreate', 'NovedadesController@modalCreate')->name('novedades.createmodal');
Route::post('/store_novedades', 'NovedadesController@store')->name('novedades.store');
Route::get('/novedades/modalEdit/{id}', 'NovedadesController@modalEdit')->name('novedades.editmodal');
Route::post('/novedades/update/{id}', 'NovedadesController@update')->name('novedades.update');
Route::get('/novedades/modalDelete/{id}', 'NovedadesController@modalDelete')->name('novedades.deletemodal');
Route::post('/novedades/delete/{id}','NovedadesController@destroy')->name('novedades.destroy');
Route::get('/novedades/estado/{id}/{estado}', 'NovedadesController@changeEstado')->name('novedades.cambioEstado');

Route::get('/createClientsX', function () {
    abort(403);

    $nombres_contacto = array("Juan Pérez","María Rodríguez","Carlos García","Ana Martínez","Luis López","Laura Hernández","Diego González","Sofía Díaz","Pedro Sánchez","Elena Ramírez","Miguel Gómez","Lucía Torres","Alejandro Vásquez","Paula Castro","José Morales","Valentina Álvarez","Javier Ruiz","Camila Herrera","Fernando Ortiz","Isabel Cruz");

    $numeros_celular_bolivia = array("61234567","72345678","63456789","74567890","65678901","76789012","67890123","78901234","69012345","70123456","61234567","72345678","63456789","74567890","65678901","76789012","67890123","78901234","69012345","70123456");

    $cargos_empresa = array("Gerente de Ventas","Analista de Marketing","Jefe de Recursos Humanos","Desarrollador de Software","Director Financiero","Especialista en Soporte Técnico","Coordinador de Proyectos","Ejecutivo de Cuentas","Diseñador Gráfico","Técnico de Mantenimiento","Consultor de Negocios","Analista de Datos","Ingeniero de Producción","Asistente Administrativo","Especialista en Logística","Asesor Legal","Arquitecto de Sistemas","Investigador de Mercado","Analista de Calidad","Coordinador de Eventos");

    $cuentas = \App\Cuentas::get();
    foreach ($cuentas as $cuenta) {
        $i = rand(0, 19);
        $nombreContacto = $nombres_contacto[$i];
        $emailContacto = generarCorreoGmail($nombreContacto);
        $client = new \App\ContactosCuentas();
        $client->cuenta_id = $cuenta->id;
        $client->nombre_contacto = $nombreContacto;
        $client->cargo_contacto = $cargos_empresa[$i];
        $client->celular_contacto = $numeros_celular_bolivia[$i];
        $client->email_contacto = $emailContacto;
        $client->save();
    }

    dd("FIN");
});

Route::get('/createChoferesX', function () {
    abort(403);

    $choferes = [
        "Juan Carlos Mamani",
        "José Luis Condori",
        "Carlos Alberto Huanca",
        "Miguel Ángel Cusi",
        "Luis Fernando Callisaya",
        "Oscar René Copa",
        "Walter Freddy Quispe",
        "Víctor Hugo Calisaya",
        "Hugo Francisco Nina",
        "Ramiro René Llanque",
        "Roberto Carlos Apaza",
        "Alberto Felipe Choque",
        "Pablo Andrés Quispe",
        "Javier Luis Mamani",
        "Sergio Enrique Condori",
        "Fernando Alfredo Cusi",
        "Mauricio Iván Huanca",
        "Raúl Hernán Callisaya",
        "Arturo Javier Nina",
        "Jorge Luis Mamani"
    ];

    $numeros_celulares = [
        "767123456",
        "712345678",
        "684567123",
        "799876543",
        "711234567",
        "678912345",
        "764321098",
        "719876543",
        "690123456",
        "787654321",
        "721345678",
        "691234567",
        "776543210",
        "703456789",
        "684321987",
        "754321098",
        "713456789",
        "672345678",
        "761234567",
        "789012345"
    ];

    $vehiculos = \App\Vehiculos::get();
    foreach ($vehiculos as $vehiculo) {
        $i = rand(0, 19);
        $nombreContacto = $choferes[$i];
        $conductor = new \App\ConductoresVehiculos();
        $conductor->vehiculo_id = $vehiculo->id;
        $conductor->nombre_conductor = $nombreContacto;
        $conductor->celular_conductor = $numeros_celulares[$i];
        $conductor->save();
    }

    dd("FIN");
});
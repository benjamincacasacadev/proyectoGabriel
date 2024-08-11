<?php
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
//                                      CUENTAS
// ========================================================================================
Route::get('/cuentas', 'CuentasController@index')->name('cuentas.index');
Route::post('/table_cuentas', 'CuentasController@tableCuentas')->name('cuentas.table');
Route::get('/cuentas/modalCreate', 'CuentasController@modalCreate')->name('cuentas.createmodal');
Route::post('/store_cuentas', 'CuentasController@store')->name('cuentas.store');
Route::get('/cuentas/modalEdit/{id}', 'CuentasController@modalEdit')->name('cuentas.editmodal');
Route::post('/cuentas/update/{id}', 'CuentasController@update')->name('cuentas.update');
Route::get('/cuentas/modalDelete/{id}', 'CuentasController@modalDelete')->name('cuentas.deletemodal');
Route::post('/cuentas/delete/{id}','CuentasController@destroy')->name('cuentas.destroy');
Route::get('/cuentas/estado/{id}/{estado}', 'CuentasController@changeEstado')->name('cuentas.cambioEstado');

// ========================================================================================
//                                      VEHICULOS
// ========================================================================================
Route::get('/vehiculos', 'VehiculosController@index')->name('vehiculos.index');
Route::post('/table_vehiculos', 'VehiculosController@tableVehiculos')->name('vehiculos.table');
Route::get('/vehiculos/modalCreate', 'VehiculosController@modalCreate')->name('vehiculos.createmodal');
Route::post('/store_vehiculos', 'VehiculosController@store')->name('vehiculos.store');
Route::get('/vehiculos/modalEdit/{id}', 'VehiculosController@modalEdit')->name('vehiculos.editmodal');
Route::post('/vehiculos/update/{id}', 'VehiculosController@update')->name('vehiculos.update');
Route::get('/vehiculos/modalDelete/{id}', 'VehiculosController@modalDelete')->name('vehiculos.deletemodal');
Route::post('/vehiculos/delete/{id}','VehiculosController@destroy')->name('vehiculos.destroy');
Route::get('/vehiculos/estado/{id}/{estado}', 'VehiculosController@changeEstado')->name('vehiculos.cambioEstado');

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
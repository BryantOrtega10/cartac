<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get("storage-link", function(){
    File::link(
        storage_path('app/public'), public_path('storage')
    );	
});

Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate:fresh');
    $exitCode2 = Artisan::call('db:seed');
    return '<h3>Migraci&oacute;n completada '.$exitCode.' '.$exitCode2.'</h3>';
});

Route::get('/cache', function() {
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h3>Cache eliminado</h3>';
});


Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'App\Http\Controllers\Auth\LoginController@login');
Route::get('/user', 'App\Http\Controllers\Auth\LoginController@showUpdateForm')->name('user.update');

Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

Route::get('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');

Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

//Auth::routes();
Route::group(['prefix' => 'peaje'],function(){
    Route::get('/', 'App\Http\Controllers\PeajeController@index')->name('peajes.index');
    Route::get('agregar', 'App\Http\Controllers\PeajeController@mostrarFormAgregar')->name('peajes.agregar');
    Route::post('agregar', 'App\Http\Controllers\PeajeController@agregar');

    Route::get('modificar/{id}', 'App\Http\Controllers\PeajeController@mostrarFormModificar')->name('peajes.modificar');
    Route::post('modificar/{id}', 'App\Http\Controllers\PeajeController@modificar');
    Route::post('eliminar/{id}', 'App\Http\Controllers\PeajeController@eliminar')->name('peajes.eliminar');
});

Route::group(['prefix' => 'categoria'],function(){
    Route::get('/', 'App\Http\Controllers\CategoriaController@index')->name('categorias.index');
    Route::get('agregar', 'App\Http\Controllers\CategoriaController@mostrarFormAgregar')->name('categorias.agregar');
    Route::post('agregar', 'App\Http\Controllers\CategoriaController@agregar');

    Route::get('modificar/{id}', 'App\Http\Controllers\CategoriaController@mostrarFormModificar')->name('categorias.modificar');
    Route::post('modificar/{id}', 'App\Http\Controllers\CategoriaController@modificar');
    Route::post('eliminar/{id}', 'App\Http\Controllers\CategoriaController@eliminar')->name('categorias.eliminar');

    Route::group(['prefix' => 'subcategoria'],function(){
        Route::get('/{categoria}', 'App\Http\Controllers\CategoriaController@indexSubCategoria')->name('categorias.subcategoria.index');
        Route::get('/{categoria}/agregar', 'App\Http\Controllers\CategoriaController@mostrarFormAgregarSubCategoria')->name('categorias.subcategoria.agregar');
        Route::post('/{categoria}/agregar', 'App\Http\Controllers\CategoriaController@agregarSubCategoria');    
        Route::get('/{categoria}/modificar/{id}', 'App\Http\Controllers\CategoriaController@mostrarFormModificarSubCategoria')->name('categorias.subcategoria.modificar');
        Route::post('/{categoria}/modificar/{id}', 'App\Http\Controllers\CategoriaController@modificarSubCategoria');
        Route::post('/{categoria}/eliminar/{id}', 'App\Http\Controllers\CategoriaController@eliminarSubCategoria')->name('categorias.subcategoria.eliminar');
    });
    
});
Route::group(['prefix' => 'conductores'],function(){
    Route::get('/', 'App\Http\Controllers\ConductorController@index')->name('conductores.index');
    Route::get('verificar/{id}', 'App\Http\Controllers\ConductorController@mostrarFormVerificar')->name('conductores.verificar');
    Route::post('responder/{id}', 'App\Http\Controllers\ConductorController@responder')->name('conductores.responder');
});

Route::group(['prefix' => 'configuracion'],function(){
    Route::get('/', 'App\Http\Controllers\ConfiguracionController@index')->name('configuracion.index');
    Route::get('agregar', 'App\Http\Controllers\ConfiguracionController@mostrarFormAgregar')->name('configuracion.agregar');
    Route::post('agregar', 'App\Http\Controllers\ConfiguracionController@agregar');

    Route::get('modificar/{id}', 'App\Http\Controllers\ConfiguracionController@mostrarFormModificar')->name('configuracion.modificar');
    Route::get('modificar_gen', 'App\Http\Controllers\ConfiguracionController@mostrarFormModificarGen')->name('configuracion.modificar_gen');
    Route::post('modificar_gen', 'App\Http\Controllers\ConfiguracionController@modificar_gen');

    Route::post('modificar/{id}', 'App\Http\Controllers\ConfiguracionController@modificar');
    Route::post('eliminar/{id}', 'App\Http\Controllers\ConfiguracionController@eliminar')->name('configuracion.eliminar');
});


Route::group(['prefix' => 'bonos'],function(){
    Route::get('/', 'App\Http\Controllers\BonoController@index')->name('bonos.index');
    Route::get('agregar', 'App\Http\Controllers\BonoController@mostrarFormAgregar')->name('bonos.agregar');
    Route::post('agregar', 'App\Http\Controllers\BonoController@agregar');

    Route::get('modificar/{id}', 'App\Http\Controllers\BonoController@mostrarFormModificar')->name('bonos.modificar');
    Route::post('modificar/{id}', 'App\Http\Controllers\BonoController@modificar');
    Route::post('eliminar/{id}', 'App\Http\Controllers\BonoController@eliminar')->name('bonos.eliminar');
});

Route::group(['prefix' => 'tipo-vehiculo'],function(){
    Route::get('/', 'App\Http\Controllers\TipoVehiculoController@index')->name('tipos_de_vehiculo.index');
    Route::get('agregar', 'App\Http\Controllers\TipoVehiculoController@mostrarFormAgregar')->name('tipos_de_vehiculo.agregar');
    Route::post('agregar', 'App\Http\Controllers\TipoVehiculoController@agregar');

    Route::get('modificar/{id}', 'App\Http\Controllers\TipoVehiculoController@mostrarFormModificar')->name('tipos_de_vehiculo.modificar');
    Route::post('modificar/{id}', 'App\Http\Controllers\TipoVehiculoController@modificar');
    Route::post('eliminar/{id}', 'App\Http\Controllers\TipoVehiculoController@eliminar')->name('tipos_de_vehiculo.eliminar');
});



Route::group(['prefix' => 'servicios'],function(){
    Route::get('/', 'App\Http\Controllers\ServicioController@index')->name('servicios.index');
    Route::get('ver_detalle/{id}', 'App\Http\Controllers\ServicioController@mostrarFormDetalle')->name('servicios.ver_detalle');
    Route::post('cancelar/{id}', 'App\Http\Controllers\ServicioController@cancelar')->name('servicios.cancelar');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/rutas', 'App\Http\Controllers\InfoController@index');

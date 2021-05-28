<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'conductor'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\ConductorController@agregar");
    Route::post("login", "App\Http\Controllers\Api\ConductorController@login");
    Route::middleware('auth:api')->get("/", "App\Http\Controllers\Api\ConductorController@datos_conductor");    
    Route::middleware('auth:api')->post("datosErroneos", "App\Http\Controllers\Api\ConductorController@datosErroneos");    
    Route::middleware('auth:api')->post("resubir", "App\Http\Controllers\Api\ConductorController@resubir");    
    Route::middleware('auth:api')->post("conectar", "App\Http\Controllers\Api\ConductorController@conectar");    
    Route::middleware('auth:api')->post("actualizarUbicacion", "App\Http\Controllers\Api\ConductorController@actualizarUbicacion");    
    
});

Route::group(['prefix' => 'cliente'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\ClienteController@registro_cliente");
    Route::post("login", "App\Http\Controllers\Api\ClienteController@login");
});


Route::group(['prefix' => 'propietario'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\PropietarioController@agregar");
});

Route::group(['prefix' => 'vehiculo'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\VehiculoController@agregar");
});

Route::group(['prefix' => 'servicio'],function(){
    Route::middleware('auth:api')->post("cotizar", "App\Http\Controllers\Api\ServicioController@cotizar");
    Route::middleware('auth:api')->post("crear", "App\Http\Controllers\Api\ServicioController@crear");
    Route::middleware('auth:api')->post("aceptar", "App\Http\Controllers\Api\ServicioController@aceptar");
    
});

Route::get("color_vehiculo", "App\Http\Controllers\Api\ColorVehiculoController@index");
Route::get("marca_vehiculo", "App\Http\Controllers\Api\MarcaVehiculoController@index");
Route::get("dimension_vehiculo", "App\Http\Controllers\Api\DimensionVehiculoController@index");
Route::get("tipo_vehiculo", "App\Http\Controllers\Api\TipoVehiculoController@index");
Route::get("categoria", "App\Http\Controllers\Api\CategoriaController@index");
Route::get("sub_categoria", "App\Http\Controllers\Api\CategoriaController@indexSubCategoria");


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

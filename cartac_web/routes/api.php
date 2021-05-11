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
    Route::post("agregar", "App\Http\Controllers\ConductorController@agregar");
});

Route::group(['prefix' => 'propietario'],function(){
    Route::post("agregar", "App\Http\Controllers\PropietarioController@agregar");
});

Route::group(['prefix' => 'vehiculo'],function(){
    Route::post("agregar", "App\Http\Controllers\VehiculoController@agregar");
});

Route::get("color_vehiculo", "App\Http\Controllers\ColorVehiculoController@index");
Route::get("marca_vehiculo", "App\Http\Controllers\MarcaVehiculoController@index");
Route::get("dimension_vehiculo", "App\Http\Controllers\DimensionVehiculoController@index");
Route::get("tipo_vehiculo", "App\Http\Controllers\TipoVehiculoController@index");



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

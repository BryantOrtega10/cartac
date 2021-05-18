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
});

Route::group(['prefix' => 'propietario'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\PropietarioController@agregar");
});

Route::group(['prefix' => 'vehiculo'],function(){
    Route::post("agregar", "App\Http\Controllers\Api\VehiculoController@agregar");
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

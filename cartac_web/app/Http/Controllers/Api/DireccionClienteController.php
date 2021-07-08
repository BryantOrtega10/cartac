<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgregarDireccionesClienteRequest;
use App\Http\Requests\DireccionesClienteRequest;
use App\Http\Requests\EliminarDireccionesClienteRequest;
use App\Http\Requests\ModificarDireccionesClienteRequest;
use App\Models\ClienteModel;
use App\Models\DireccionClienteModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DireccionClienteController extends Controller
{
    /**
     * Consultar direcciones
     * Permite consultar direcciones de los clientes
     * 
	 * @group  v 1.0.4
     * 
     * @authenticated
     * 
	 */  
    public function consultar(){
        $usuario = auth()->user();
        $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
        $direcciones = DireccionClienteModel::selectRaw("ST_X(dir_ubicacion) as dir_lat, ST_Y(dir_ubicacion) as dir_lng, 
        dir_id, dir_direccion, dir_icono")
        ->where("dir_fk_cli", "=", $cliente->cli_id)->get();


        return response()->json([
            "success" => true,
            "data" => [
                "direcciones" => $direcciones
            ]
        ],200);        
    }

    /**
     * Agregar dirección
     * Permite agregar una dirección a un cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam direccion String required Dirección en texto.
     * @bodyParam lat Double required latitud de la dirección
     * @bodyParam lng Double required longitud de la dirección
     * 
     * 
     * @authenticated
     * 
	 */  

    public function agregar(AgregarDireccionesClienteRequest $request){
        $usuario = auth()->user();
        $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
        
        $direccion = new DireccionClienteModel();
        $direccion->dir_direccion = $request->direccion;
        $direccion->dir_ubicacion = DB::raw('POINT('.$request->lat.', '.$request->lng.')');
        $direccion->dir_fk_cli = $cliente->cli_id;
        $direccion->save();

        return response()->json([
            "success" => true,
            "message" => "Dirección agregada correctamente"
        ],200);        
    }


     /**
     * Modificar dirección
     * Permite modificar una dirección a un cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam direccion String required Dirección en texto.
     * @bodyParam lat Double required latitud de la dirección
     * @bodyParam lng Double required longitud de la dirección
     * @bodyParam dir_id Integer required id de la dirección que se quiere modificar
     * 
     * @authenticated
     * 
	 */  

    public function modificar(ModificarDireccionesClienteRequest $request){

        $usuario = auth()->user();
        $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
        
        $direccion = DireccionClienteModel::findOrFail($request->dir_id);
        $direccion->dir_direccion = $request->direccion;
        $direccion->dir_ubicacion = DB::raw('POINT('.$request->lat.', '.$request->lng.')');
        $direccion->dir_fk_cli = $cliente->cli_id;
        $direccion->save();

        return response()->json([
            "success" => true,
            "message" => "Dirección modificada correctamente"
        ],200);        
    }

    /**
     * Eliminar dirección
     * Permite eliminar una dirección a un cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam dir_id Integer required id de la dirección que se quiere eliminar
     * 
     * @authenticated
     * 
	 */ 
    public function eliminar(EliminarDireccionesClienteRequest $request){

        $direccion = DireccionClienteModelo::findOrFail($request->dir_id);
        $direccion->delete();

        return response()->json([
            "success" => true,
            "message" => "Dirección eliminada correctamente"
        ],200);        
    }

    

    

  
}

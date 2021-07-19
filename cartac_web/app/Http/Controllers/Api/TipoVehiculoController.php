<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\TipoVehiculoModel;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{
    /**
     * Tipos vehiculos
     * 
	 * @group  v 1.0.5
     * @bodyParam categoria Integer Id de la categoria.
     * 
     * */
    public function index(Request $request){
        $tipos = TipoVehiculoModel::select("tip_id as id", "tip_name as name", "tip_foto as foto", "tip_foto as foto");
        if($request->has("categoria")){
            $tipos = $tipos->join("dimension_tipo_veh","fk_tip","=","tip_id")
                            ->join("vehiculo","veh_fk_dim_tip","=","id")
                            ->join("vehiculo_categoria","fk_veh_id","=","veh_id")                            
                            ->where("fk_cat_id","=",$request->categoria);
        }

        $tipos = $tipos->get();

        
        return response()->json([
            "success" => true,
            "data" => $tipos
        ]);
    }
}

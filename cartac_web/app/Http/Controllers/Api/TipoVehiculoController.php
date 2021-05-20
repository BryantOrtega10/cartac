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
	 * @group  v 1.0
     * 
     * */
    public function index(){
        
        $tipos = TipoVehiculoModel::select("tip_id as id", "tip_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $tipos
        ]);
    }
}

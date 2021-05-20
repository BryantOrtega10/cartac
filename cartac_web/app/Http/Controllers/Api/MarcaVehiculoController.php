<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarcaVehiculoModel;
use Illuminate\Http\Request;

class MarcaVehiculoController extends Controller
{
    /**
     * Marcas vehiculos
     * 
	 * @group  v 1.0
     * 
     * */
    public function index(){
        $marcas = MarcaVehiculoModel::select("mar_id as id", "mar_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $marcas
        ]);
    }
}

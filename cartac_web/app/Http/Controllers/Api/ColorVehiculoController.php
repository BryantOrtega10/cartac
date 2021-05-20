<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ColorVehiculoModel;
use Illuminate\Http\Request;

class ColorVehiculoController extends Controller
{
    /**
     * Colores vehiculos
     * 
	 * @group  v 1.0
     * 
     * */
    public function index(){
        $colores = ColorVehiculoModel::select("col_id as id", "col_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $colores
        ]);
    }
}

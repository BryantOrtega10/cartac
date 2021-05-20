<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\DimensionVehiculoModel;
use Illuminate\Http\Request;

class DimensionVehiculoController extends Controller
{
    /**
     * Dimensiones vehiculos
     * 
	 * @group  v 1.0
     * 
     * */
    public function index(){
        return response()->json([
            "success" => true,
            "data" => DimensionVehiculoModel::all()
        ]);
    }
}

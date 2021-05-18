<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ColorVehiculoModel;
use Illuminate\Http\Request;

class ColorVehiculoController extends Controller
{
    public function index(){
        $colores = ColorVehiculoModel::select("col_id as id", "col_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $colores
        ]);
    }
}

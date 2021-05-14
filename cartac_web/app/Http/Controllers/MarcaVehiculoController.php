<?php

namespace App\Http\Controllers;

use App\Models\MarcaVehiculoModel;
use Illuminate\Http\Request;

class MarcaVehiculoController extends Controller
{
    public function index(){
        $marcas = MarcaVehiculoModel::select("mar_id as id", "mar_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $marcas
        ]);
    }
}

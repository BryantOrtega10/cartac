<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculoModel;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{
    public function index(){
        
        $tipos = TipoVehiculoModel::select("tip_id as id", "tip_name as name")->get();

        return response()->json([
            "success" => true,
            "data" => $tipos
        ]);
    }
}

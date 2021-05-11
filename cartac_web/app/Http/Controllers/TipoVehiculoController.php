<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculoModel;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{
    public function index(){
        return response()->json([
            "success" => true,
            "data" => TipoVehiculoModel::all()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\MarcaVehiculoModel;
use Illuminate\Http\Request;

class MarcaVehiculoController extends Controller
{
    public function index(){
        return response()->json([
            "success" => true,
            "data" => MarcaVehiculoModel::all()
        ]);
    }
}

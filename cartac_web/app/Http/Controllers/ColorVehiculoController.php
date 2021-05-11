<?php

namespace App\Http\Controllers;

use App\Models\ColorVehiculoModel;
use Illuminate\Http\Request;

class ColorVehiculoController extends Controller
{
    public function index(){
        return response()->json([
            "success" => true,
            "data" => ColorVehiculoModel::all()
        ]);
    }
}

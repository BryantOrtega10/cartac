<?php

namespace App\Http\Controllers;

use App\Models\DimensionVehiculoModel;
use Illuminate\Http\Request;

class DimensionVehiculoController extends Controller
{
    public function index(){
        return response()->json([
            "success" => true,
            "data" => DimensionVehiculoModel::all()
        ]);
    }
}

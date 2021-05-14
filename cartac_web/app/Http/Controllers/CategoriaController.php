<?php

namespace App\Http\Controllers;

use App\Models\CategoriaModel;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(){

        $categorias = CategoriaModel::select("cat_id as id", "cat_name as name", "cat_icono as imagen");
        $categorias = $categorias->whereNull("cat_fk_cat");      
        $categorias= $categorias->get();

        
        return response()->json([
            "success" => true,
            "data" => $categorias,
            "pathImage" => ""
        ]);
    }

    public function indexSubCategoria(Request $request){

        $categorias = CategoriaModel::select("cat_id as id", "cat_name as name", "cat_icono as imagen");
        $categorias = $categorias->where("cat_fk_cat","=",$request->categoryFk);
        $categorias= $categorias->get();
        return response()->json([
            "success" => true,
            "data" => $categorias,
            "pathImage" => ""
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaModel;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Categorias vehiculos
     * 
	 * @group  v 1.0
     * 
     * */
    public function index(){

        $categorias = CategoriaModel::select("cat_id as id", "cat_name as name", "cat_icono as imagen")->whereNull("cat_fk_cat")->get();
        return response()->json([
            "success" => true,
            "data" => $categorias,
            "pathImage" => ""
        ]);
    }

    /**
     * Sub-Categorias vehiculos
     * 
	 * @group  v 1.0
     * 
     * @urlParam categoryFk required Id de la categoria superior
     * 
     * */
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

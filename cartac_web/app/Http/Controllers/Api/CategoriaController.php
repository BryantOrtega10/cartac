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
    public function index(Request $request){

        $categorias = CategoriaModel::select("cat_id as id", "cat_name as name", "cat_icono as imagen")->whereNull("cat_fk_cat")->get();

        if($request->has("completo")){
            foreach ($categorias as $row => $categoria){
                $subCategorias = CategoriaModel::select("cat_id as id", "cat_name as name", "cat_icono as imagen");
                $subCategorias = $subCategorias->where("cat_fk_cat","=",$categoria->id);
                $subCategorias= $subCategorias->get();
                $categorias[$row]->sub_categorias = $subCategorias;
            }
        }

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\CategoriaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        
        $categorias = CategoriaModel::select("categoria.cat_id","categoria.cat_name", "categoria.cat_icono", DB::raw("count(c2.cat_id) as sub_categorias"))
        ->leftJoin("categoria as c2", "c2.cat_fk_cat", "=","categoria.cat_id")
        ->whereNull("categoria.cat_fk_cat")->groupBy("categoria.cat_id", "categoria.cat_name","categoria.cat_icono")->get();
        
        return view('categorias/lista',[
            "categorias" => $categorias
        ]);
    }

    public function mostrarFormAgregar(){
        return view('categorias/agregar');
    }
    public function mostrarFormModificar($id){
        
        $categoria = CategoriaModel::findOrFail($id);
        
        return view('categorias/modificar',[
            "categoria" => $categoria
        ]);
    }
    public function eliminar($idCategoria){
        
        $categoria = CategoriaModel::findOrFail($idCategoria);
        if(isset($categoria->cat_icono) && !empty($categoria->cat_icono)){
            Storage::delete($categoria->cat_icono);
        }
        $categoria->delete();
        return redirect()->route('categorias.index')->with('mensaje', 'Categoria eliminada correctamente');
    }
    protected function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }
    public function agregar(CategoriaRequest $request){        
        
        $categoria = new CategoriaModel();
        $categoria->cat_name = $request->nombre;
        if ($request->hasFile('foto')) {

            $directorio = "imgs/categorias/";
            $fotoNom =  time()."_categoria.png";
            $request->file("foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 50, 50);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $categoria->cat_icono = $directorio.$pathFinal;
        }
        $categoria->save();
        
        return redirect()->route('categorias.index')->with('mensaje', 'Categoria creada correctamente');
        
        
    }
    public function modificar($idCategoria, CategoriaRequest $request){        
        

        $categoria = CategoriaModel::findOrFail($idCategoria);
        $categoria->cat_name = $request->nombre;
        if ($request->hasFile('foto')) {
            if(isset($categoria->cat_icono) && !empty($categoria->cat_icono)){
                Storage::delete($categoria->cat_icono);
            }
            $directorio = "imgs/categorias/";
            $fotoNom =  time()."_categoria.png";
            $request->file("foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 50, 50);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $categoria->cat_icono = $directorio.$pathFinal;
        }
        $categoria->save();
        return redirect()->route('categorias.index')->with('mensaje', 'Categoria modificada correctamente');
        
        
    }

    public function indexSubCategoria($cat_fk_cat){
        $categoria_sup = CategoriaModel::findOrFail($cat_fk_cat);
        $categorias = CategoriaModel::where("categoria.cat_fk_cat", "=", $cat_fk_cat)->get();
        return view('sub_categorias/lista',[
            "categorias" => $categorias,
            "categoria_sup" => $categoria_sup
        ]);
    }
    public function mostrarFormAgregarSubCategoria($cat_fk_cat){
        $categoria_sup = CategoriaModel::findOrFail($cat_fk_cat);
        return view('sub_categorias/agregar',[
            "categoria_sup" => $categoria_sup
        ]);
    }

    public function mostrarFormModificarSubCategoria($cat_fk_cat,$id){

        $categoria_sup = CategoriaModel::findOrFail($cat_fk_cat);
        $categoria = CategoriaModel::findOrFail($id);
        
        return view('sub_categorias/modificar',[
            "categoria" => $categoria,
            "categoria_sup" => $categoria_sup
        ]);
    }

    public function agregarSubCategoria($cat_fk_cat, CategoriaRequest $request){        
        
        $categoria = new CategoriaModel();
        $categoria->cat_name = $request->nombre;
        if ($request->hasFile('foto')) {

            $directorio = "imgs/categorias/";
            $fotoNom =  time()."_categoria.png";
            $request->file("foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 50, 50);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $categoria->cat_icono = $directorio.$pathFinal;
        }
        $categoria->cat_fk_cat = $cat_fk_cat;
        $categoria->save();
        
        return redirect()->route('categorias.subcategoria.index',['categoria' => $cat_fk_cat])->with('mensaje', 'Sub-categoria creada correctamente');
        
        
    }
    public function modificarSubCategoria($cat_fk_cat, $idCategoria, CategoriaRequest $request){        
        

        $categoria = CategoriaModel::findOrFail($idCategoria);
        $categoria->cat_name = $request->nombre;
        if ($request->hasFile('foto')) {
            if(isset($categoria->cat_icono) && !empty($categoria->cat_icono)){
                Storage::delete($categoria->cat_icono);
            }
            $directorio = "imgs/categorias/";
            $fotoNom =  time()."_categoria.png";
            $request->file("foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 50, 50);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $categoria->cat_icono = $directorio.$pathFinal;
        }
        $categoria->cat_fk_cat = $cat_fk_cat;
        $categoria->save();
        return redirect()->route('categorias.subcategoria.index',['categoria' => $cat_fk_cat])->with('mensaje', 'Sub-categoria modificada correctamente');
    }
    public function eliminarSubCategoria($cat_fk_cat, $idCategoria){
        
        $categoria = CategoriaModel::findOrFail($idCategoria);
        if(isset($categoria->cat_icono) && !empty($categoria->cat_icono)){
            Storage::delete($categoria->cat_icono);
        }
        $categoria->delete();
        return redirect()->route('categorias.subcategoria.index',['categoria' => $cat_fk_cat])->with('mensaje', 'Sub-categoria eliminada correctamente');
    }
}

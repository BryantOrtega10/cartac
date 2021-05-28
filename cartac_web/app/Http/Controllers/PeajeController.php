<?php

namespace App\Http\Controllers;

use App\Http\Requests\PeajeRequest;
use App\Models\CategoriaPeajeModel;
use App\Models\PeajeCatPeajeModel;
use App\Models\PeajeModel;
use \Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class PeajeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $peajes = PeajeModel::all();
        return view('peaje/lista',[
            "peajes" => $peajes
        ]);
    }

    public function mostrarFormAgregar(){
        $categorias = CategoriaPeajeModel::where("ctp_id",">=","2")->get();

        return view('peaje/agregar',[
            "categorias" => $categorias
        ]);
    }
    public function mostrarFormModificar($id){
        
        $peaje = PeajeModel::selectRaw("pea_id ,pea_nombre, pea_radio, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng")
        ->where("pea_id",$id)->first();
        

        $categorias = CategoriaPeajeModel::select("categoria_peaje.*","pcp.pcp_valor")
        ->join("peaje_categoria_peaje as pcp","pcp.pcp_fk_ctp","=","categoria_peaje.ctp_id")
        ->where("pcp.pcp_fk_pea", "=", $id)
        ->where("ctp_id",">=","2")->get();

        return view('peaje/modificar',[
            "categorias" => $categorias,
            "peaje" => $peaje
        ]);
    }
    public function eliminar($idPeaje){
        
        $peaje = PeajeModel::findOrFail($idPeaje);
        $peaje->delete();
        return redirect()->route('peajes.index')->with('mensaje', 'Peaje eliminado correctamente');
    }
    protected function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }
    public function agregar(PeajeRequest $request){        
        if($request->map_select == "0"){
            return $this->sendFailedResponse(["map_select" => "Debe seleccionar la ubicación del peaje"]);
        }

        $peaje = new PeajeModel();
        $peaje->pea_nombre = $request->nombre;
        
        $peaje->pea_ubic = DB::raw('POINT('.$request->lat.', '.$request->lng.')');
        $peaje->pea_radio = $request->radio;
        $peaje->save();

        $categorias = CategoriaPeajeModel::where("ctp_id",">=","2")->get();
        foreach($categorias as $categoria){
            
            $peaje_cat_peaje = new PeajeCatPeajeModel();
            $peaje_cat_peaje->pcp_fk_ctp = $categoria->ctp_id;
            $peaje_cat_peaje->pcp_fk_pea = $peaje->pea_id;
            $peaje_cat_peaje->pcp_valor = $request->input('cat_'.$categoria->ctp_id);
            $peaje_cat_peaje->save();
            
        } 

        return redirect()->route('peajes.index')->with('mensaje', 'Peaje creado correctamente');
        
        
    }
    public function modificar($idPeaje, PeajeRequest $request){        
        if($request->map_select == "0"){
            return $this->sendFailedResponse(["map_select" => "Debe seleccionar la ubicación del peaje"]);
        }

        $peaje = PeajeModel::findOrFail($idPeaje);
        $peaje->pea_nombre = $request->nombre;        
        $peaje->pea_ubic = DB::raw('POINT('.$request->lat.', '.$request->lng.')');
        $peaje->pea_radio = $request->radio;
        $peaje->save();

        $categorias = CategoriaPeajeModel::where("ctp_id",">=","2")->get();
        foreach($categorias as $categoria){
            
            $peaje_cat_peaje = PeajeCatPeajeModel::where("pcp_fk_ctp","=", $categoria->ctp_id)
            ->where("pcp_fk_pea","=",$idPeaje)->first();
            if(!isset($peaje_cat_peaje)){
                $peaje_cat_peaje = new PeajeCatPeajeModel();
            }
            $peaje_cat_peaje->pcp_fk_ctp = $categoria->ctp_id;
            $peaje_cat_peaje->pcp_fk_pea = $peaje->pea_id;
            $peaje_cat_peaje->pcp_valor = $request->input('cat_'.$categoria->ctp_id);
            $peaje_cat_peaje->save();            
        } 

        return redirect()->route('peajes.index')->with('mensaje', 'Peaje modificado correctamente');
        
        
    }
    /*
    SET @point = ST_Buffer(POINT(1,1), 2);
SET @route = ST_GeomFromText('LineString(0 0,-1 -1,-2 -1)');
SELECT ST_Crosses(@point, @route);
    */
}

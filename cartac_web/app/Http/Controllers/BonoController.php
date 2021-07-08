<?php

namespace App\Http\Controllers;

use App\Models\BonoModel;
use Illuminate\Http\Request;

class BonoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $bonos = BonoModel::all();
        return view('bonos/lista',[
            "bonos" => $bonos
        ]);
    }

    public function mostrarFormAgregar(){

        return view('bonos/agregar',[]);
    }

    public function agregar(BonoRequest $request){        
        if($request->tipo == "1"){
            if(empty($request->valor) || intval($request->valor) == "0"){
                return $this->sendFailedResponse(["valor" => $request->valor]);
            }             
        }
        else if($request->tipo == "2"){
            if(empty($request->porcentaje) || intval($request->porcentaje) == "0"){
                return $this->sendFailedResponse(["porcentaje" => $request->porcentaje]);
            }          
        }

        $bono = new BonoModel();
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
}

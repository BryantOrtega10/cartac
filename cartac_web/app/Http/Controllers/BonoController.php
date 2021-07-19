<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonoRequest;
use App\Models\BonoModel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BonoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $bonos = BonoModel::where("bon_fk_est","1")->get();
        return view('bonos/lista',[
            "bonos" => $bonos
        ]);
    }

    public function mostrarFormAgregar(){

        return view('bonos/agregar',[]);
    }

    protected function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }
    
    public function agregar(BonoRequest $request){        
        if($request->tipo == "1"){
            if(empty($request->valor) || intval($request->valor) <= "0"){
                return $this->sendFailedResponse(["valor" => "El valor deber mayor a 0"]);
            }             
        }
        else if($request->tipo == "2"){
            if(empty($request->porcentaje) || intval($request->porcentaje) <= "0" || intval($request->porcentaje) > "100"){
                return $this->sendFailedResponse(["porcentaje" => "El porcentaje deber mayor a 0 y menor a 100"]);
            }          
        }

        
        $bono = new BonoModel();
        $bono->bon_codigo = $request->codigo;
        $bono->bon_fecha_ini = $request->fecha_inicio;
        $bono->bon_fecha_fin = $request->fecha_fin;
        $bono->bon_disponibles = $request->disponibles;
        if($request->tipo == "1"){
            $bono->bon_valor = $request->valor;
        }
        else if($request->tipo == "2"){
            $bono->bon_porcentaje = $request->porcentaje;
        }
        $bono->bon_fk_est = 1;
        $bono->save();

        return redirect()->route('bonos.index')->with('mensaje', 'Bono creado correctamente');        
        
    }
    public function mostrarFormModificar($id){

        $bono = BonoModel::findOrFail($id);
        $tipo = null;
        if(isset($bono->bon_valor)){
            $bono->tipo = 1;
        }        
        if(isset($bono->bon_porcentaje)){
            $bono->tipo = 2;
        }
        

        return view('bonos/modificar',[
            "bono" => $bono
        ]);
    }
    public function modificar($id, BonoRequest $request){        
        if($request->tipo == "1"){
            if(empty($request->valor) || intval($request->valor) <= "0"){
                return $this->sendFailedResponse(["valor" => "El valor deber mayor a 0"]);
            }             
        }
        else if($request->tipo == "2"){
            if(empty($request->porcentaje) || intval($request->porcentaje) <= "0" || intval($request->porcentaje) > "100"){
                return $this->sendFailedResponse(["porcentaje" => "El porcentaje deber mayor a 0 y menor a 100"]);
            }          
        }

        
        $bono = BonoModel::findOrFail($id);
        $bono->bon_codigo = $request->codigo;
        $bono->bon_fecha_ini = $request->fecha_inicio;
        $bono->bon_fecha_fin = $request->fecha_fin;
        $bono->bon_disponibles = $request->disponibles;
        if($request->tipo == "1"){
            $bono->bon_valor = $request->valor;
            $bono->bon_porcentaje = null;
        }
        else if($request->tipo == "2"){
            $bono->bon_porcentaje = $request->porcentaje;
            $bono->bon_valor = null;
        }
        
        $bono->bon_fk_est = 1;
        
        $bono->save();

        return redirect()->route('bonos.index')->with('mensaje', 'Bono modificado correctamente');        
        
    }
    
    public function eliminar($id){
        
        $bono = BonoModel::findOrFail($id);
        $bono->bon_fk_est = 14;//ELIMINADO        
        $bono->save();

        return redirect()->route('bonos.index')->with('mensaje', 'Bono eliminado correctamente');
    }
}

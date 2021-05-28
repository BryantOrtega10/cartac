<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfiguracionRequest;
use App\Http\Requests\MultiplicadorRequest;
use App\Models\ConfiguracionModel;
use App\Models\MultiplicadorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PhpParser\Node\Expr\AssignOp\Mul;

class ConfiguracionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    protected function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }

    public function index(){
        $multiplicador = MultiplicadorModel::all();

        return view('configuracion/lista',[
            "multiplicadores" => $multiplicador
        ]);
    }
    public function mostrarFormAgregar(){
        return view('configuracion/agregar');
    }
    
    public function agregar(MultiplicadorRequest $request){
        $sqlWhere = "( 
            ('".$request->hora_inicio."' BETWEEN cfm_hora_inicio AND cfm_hora_fin) OR
            ('".$request->hora_fin."' BETWEEN cfm_hora_inicio AND cfm_hora_fin) OR
            (cfm_hora_inicio BETWEEN '".$request->hora_inicio."' AND '".$request->hora_fin."') OR
            (cfm_hora_fin BETWEEN '".$request->hora_inicio."' AND '".$request->hora_fin."')
        )";

        $multiplicador = MultiplicadorModel::whereRaw($sqlWhere)
        ->first();
        

        if(isset($multiplicador)){
            return $this->sendFailedResponse(["hora_inicio" => "El multiplicador comparte hora con otro"]);
        }
        $multiplicador = new MultiplicadorModel();
        $multiplicador->cfm_hora_inicio = $request->hora_inicio;
        $multiplicador->cfm_hora_fin = $request->hora_fin;
        $multiplicador->cfm_multiplicador = $request->multiplicador;  
        $multiplicador->cfm_fk_cfg = 1;  
        $multiplicador->save();
        return redirect()->route('configuracion.index')->with('mensaje', 'Configuración creada correctamente');
    }

    public function mostrarFormModificar($id){
        $multiplicador = MultiplicadorModel::findOrFail($id);

        return view('configuracion/modificar', [
            'multiplicador' => $multiplicador
        ]);
    }

    public function mostrarFormModificarGen(){
        $configuracion = ConfiguracionModel::findOrFail(1);

        return view('configuracion/modificar_gen', [
            'configuracion' => $configuracion
        ]);
    }
    public function modificar_gen(ConfiguracionRequest $request){
        $configuracion = ConfiguracionModel::findOrFail(1);
        $configuracion->cfg_distancia = $request->distancia;
        $configuracion->cfg_tiempo = $request->tiempo;
        $configuracion->cfg_peso = $request->peso;
        $configuracion->cfg_porcentaje_seguro = $request->porcentaje_seguro;
        $configuracion->save();
        return redirect()->route('configuracion.index')->with('mensaje', 'Configuración modificada correctamente');
    }
    
    
    public function modificar($id, MultiplicadorRequest $request){

        $sqlWhere = "( 
            ('".$request->hora_inicio."' BETWEEN cfm_hora_inicio AND cfm_hora_fin) OR
            ('".$request->hora_fin."' BETWEEN cfm_hora_inicio AND cfm_hora_fin) OR
            (cfm_hora_inicio BETWEEN '".$request->hora_inicio."' AND '".$request->hora_fin."') OR
            (cfm_hora_fin BETWEEN '".$request->hora_inicio."' AND '".$request->hora_fin."')
        )";

        $multiplicador = MultiplicadorModel::whereRaw($sqlWhere)
        ->where("cfm_id","<>",$id)
        ->first();
        
        if(isset($multiplicador)){
            return $this->sendFailedResponse(["hora_inicio" => "El multiplicador comparte hora con otro"]);
        }

        $multiplicador = MultiplicadorModel::findOrFail($id);
        $multiplicador->cfm_hora_inicio = $request->hora_inicio;
        $multiplicador->cfm_hora_fin = $request->hora_fin;
        $multiplicador->cfm_multiplicador = $request->multiplicador;  
        $multiplicador->cfm_fk_cfg = 1;  
        $multiplicador->save();
        return redirect()->route('configuracion.index')->with('mensaje', 'Multiplicador modificado correctamente');
    }

    public function eliminar($id){
        $multiplicador = MultiplicadorModel::findOrFail($id);
        $multiplicador->delete();
        return redirect()->route('configuracion.index')->with('mensaje', 'Configuración eliminada correctamente');
    }
    
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoVehiculoRequest;
use App\Models\CategoriaPeajeModel;
use App\Models\DimensionTipoVehiculoModel;
use App\Models\TipoVehiculoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TipoVehiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $tipos = TipoVehiculoModel::all();
        return view('tipos_de_vehiculo/lista',[
            "tipos" => $tipos
        ]);
    }

    public function mostrarFormAgregar(){

        $categoriasPeaje = CategoriaPeajeModel::all();
        return view('tipos_de_vehiculo/agregar',[
            "categoriasPeaje" => $categoriasPeaje
        ]);
    }

    protected function sendFailedResponse($errors)
    {
        throw ValidationException::withMessages($errors);
    }
    
    public function agregar(TipoVehiculoRequest $request){        
        
        $tipoVehiculo = new TipoVehiculoModel();
        $tipoVehiculo->tip_name = $request->nombre;

        if ($request->hasFile('imagen')) {

            $directorio = "imgs/tipos_vehiculos/";
            $fotoNom =  time()."_tipo_vehiculo.png";
            $request->file("imagen")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 200, 200);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $tipoVehiculo->tip_foto = $directorio.$pathFinal;
        }

        $tipoVehiculo->tip_alquiler = $request->alquiler;
        $tipoVehiculo->tip_combustible = $request->tipo_combustible;
        $tipoVehiculo->tip_rendimiento = $request->rendimiento;
        $tipoVehiculo->tip_tiempo_cargue = $request->tiempo_cargue;
        $tipoVehiculo->tip_fk_ctp = $request->categoria_peaje;
        $tipoVehiculo->save();

        return redirect()->route('tipos_de_vehiculo.index')->with('mensaje', 'Tipo de vehiculo creado correctamente');        
        
    }
    public function mostrarFormModificar($id){

        $tipoVehiculo = TipoVehiculoModel::findOrFail($id);

        $categoriasPeaje = CategoriaPeajeModel::all();

        return view('tipos_de_vehiculo/modificar',[
            "tipoVehiculo" => $tipoVehiculo,
            "categoriasPeaje" => $categoriasPeaje
        ]);
    }
    public function modificar($id, TipoVehiculoRequest $request){        
        
        $tipoVehiculo = TipoVehiculoModel::findOrFail($id);
        $tipoVehiculo->tip_name = $request->nombre;

        if ($request->hasFile('imagen')) {
            if(isset($tipoVehiculo->tip_foto) && !empty($tipoVehiculo->tip_foto)){
                Storage::delete($tipoVehiculo->tip_foto);
            }
            $directorio = "imgs/tipos_vehiculos/";
            $fotoNom =  time()."_tipo_vehiculo.png";
            $request->file("imagen")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $path = explode($fotoNom,Storage::path($foto));
            $pathFinal = Funciones::resizeImage($path[0], $fotoNom, "r", 200, 200);
            $pathFinal = explode("/",$pathFinal);
            $pathFinal = last($pathFinal);
            $tipoVehiculo->tip_foto = $directorio.$pathFinal;
        }

        $tipoVehiculo->tip_alquiler = $request->alquiler;
        $tipoVehiculo->tip_combustible = $request->tipo_combustible;
        $tipoVehiculo->tip_rendimiento = $request->rendimiento;
        $tipoVehiculo->tip_tiempo_cargue = $request->tiempo_cargue;
        $tipoVehiculo->tip_fk_ctp = $request->categoria_peaje;
        $tipoVehiculo->save();

    
        return redirect()->route('tipos_de_vehiculo.index')->with('mensaje', 'Tipo de vehiculo modificado correctamente');        
        
    }
    
    public function eliminar($id){
        
        $vehiculos_con_tipo = DimensionTipoVehiculoModel::where("fk_tip","=",$id)->first();
        if(isset($vehiculos_con_tipo)){
            return $this->sendFailedResponse(["tipo" => "El tipo de vehiculo ya se encuentra relacionado"]);    
        }
        

        $tipoVehiculo = TipoVehiculoModel::findOrFail($id);
        $tipoVehiculo->delete();

        return redirect()->route('tipos_de_vehiculo.index')->with('mensaje', 'Tipo de vehiculo eliminado correctamente');
    }
}

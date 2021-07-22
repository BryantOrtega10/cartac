<?php

namespace App\Http\Controllers;

use App\Models\ConductorModel;
use App\Models\ConductorRespuestaModel;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\VehiculoModel;
use App\Models\VehiculoConductorModel;

use Illuminate\Http\Request;

class ConductorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conductores = ConductorModel::join("estado", "estado.est_id", "=", "conductor.con_fk_est")
            ->orderBy("con_id", "desc")->get();
        return view('conductores/lista', [
            "conductores" => $conductores
        ]);
    }
    public function mostrarFormVerificar($con_id)
    {

        $conductor = ConductorModel::findOrFail($con_id);

        $vehiculo = VehiculoModel::join("vehiculo_conductor", "fk_veh_id", "=", "veh_id")
            ->join("color_veh", "col_id", "=", "veh_fk_col")
            ->join("marca_veh", "mar_id", "=", "veh_fk_mar")
            ->join("dimension_tipo_veh", "dimension_tipo_veh.id", "=", "veh_fk_dim_tip")
            ->join("tipo_veh", "dimension_tipo_veh.fk_tip", "=", "tip_id")
            ->join("dimension_veh", "dimension_tipo_veh.fk_dim", "=", "dim_id")
            ->where("vehiculo_conductor.fk_con_id", "=", $con_id)
            ->first();
        
        if(isset($vehiculo)){
            $propietario = PropietarioModel::where("pro_id", "=", $vehiculo->veh_fk_pro)->first();

            $documentacionPropietario = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
            ->leftjoin("vehiculo_conductor", "veh_con_id", "=", "doc_fk_veh_con")
            ->where("vehiculo_conductor.fk_con_id", "=", $con_id)
            ->where("vehiculo_conductor.fk_veh_id", "=", $vehiculo->veh_id)
            ->get();

            $documentacionConductor = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
            ->where("doc_fk_con", "=", $con_id)
            ->get();

            $documentacionVehiculo = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
                ->where("doc_fk_veh", "=", $vehiculo->veh_id)
                ->get();
        }
        else{
            $propietario = null;
            $documentacionPropietario = null;
            $documentacionConductor = null;
            $documentacionVehiculo = null;

        }
        return view('conductores/verificar', [
            "conductor" => $conductor,
            "vehiculo" => $vehiculo,
            "propietario" => $propietario,
            "documentacionConductor" => $documentacionConductor,
            "documentacionPropietario" => $documentacionPropietario,
            "documentacionVehiculo" => $documentacionVehiculo
        ]);
    }
    public function responder($con_id, Request $request)
    {
        $conductor = ConductorModel::findOrFail($con_id);
        $vehiculo = VehiculoModel::join("vehiculo_conductor", "fk_veh_id", "=", "veh_id")
            ->join("color_veh", "col_id", "=", "veh_fk_col")
            ->join("marca_veh", "mar_id", "=", "veh_fk_mar")
            ->join("dimension_tipo_veh", "dimension_tipo_veh.id", "=", "veh_fk_dim_tip")
            ->join("tipo_veh", "dimension_tipo_veh.fk_tip", "=", "tip_id")
            ->join("dimension_veh", "dimension_tipo_veh.fk_dim", "=", "dim_id")
            ->where("vehiculo_conductor.fk_con_id", "=", $con_id)
            ->where("vehiculo_conductor.fk_est_id", "=", "2")
            ->first();

        $documentacionConductor = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
            ->where("doc_fk_con", "=", $con_id)
            ->get();
        $documentacionPropietario = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
            ->leftjoin("vehiculo_conductor", "veh_con_id", "=", "doc_fk_veh_con")
            ->where("vehiculo_conductor.fk_con_id", "=", $con_id)
            ->where("vehiculo_conductor.fk_veh_id", "=", $vehiculo->veh_id)
            ->where("vehiculo_conductor.fk_est_id", "=", "2")
            ->get();
        $documentacionVehiculo = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")
            ->where("doc_fk_veh", "=", $vehiculo->veh_id)
            ->get();
        
        if(!isset($request->validar_campos_conductor)){
            $conductor->con_fk_est = 1;
            $conductor->save();
            
            foreach($documentacionConductor as $doc){
                $doc->doc_fk_est = 1;
                $doc->save();
            }
            foreach($documentacionPropietario as $doc){
                $doc->doc_fk_est = 1;
                $doc->save();
            }
            foreach($documentacionVehiculo as $doc){
                $doc->doc_fk_est = 1;
                $doc->save();
            }
            $vehiculo->veh_fk_est = 1;
            $vehiculo->save();
            $vehiculo_conductor = VehiculoConductorModel::where("fk_veh_id","=",$vehiculo->veh_id)->where("fk_con_id","=", $conductor->con_id)->first();
            $vehiculo_conductor->fk_est_id = 1;
            $vehiculo_conductor->save();
            //Apruebo el vehiculo, el conductor y la documentacion
        }
        else{
            //Verificar request y aprobar
            $conductor->con_fk_est = 3;
            $conductor->save();
            $campos_validar = array();
            foreach($request->validar_campos_conductor as $validar){
                array_push($campos_validar, $validar);
            }
            $campos_validar = implode(",",$campos_validar);
            $conductor_respuesta = ConductorRespuestaModel::where("cnr_fk_con","=",$conductor->con_id)->first();
            if(!isset($conductor_respuesta)){
                $conductor_respuesta = new ConductorRespuestaModel();
            }
            
            $conductor_respuesta->cnr_campos = $campos_validar;
            $conductor_respuesta->cnr_mensaje = $request->mensaje_adicional;
            $conductor_respuesta->cnr_fk_con = $conductor->con_id;
            $conductor_respuesta->cnr_fk_est = 4;
            $conductor_respuesta->save();
            
        }
        return redirect()->route('conductores.index')->with('mensaje', 'Conductor modificado correctamente');
    }
}

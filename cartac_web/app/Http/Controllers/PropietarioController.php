<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarPropietarioRequest;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\VehiculoConductorModel;
use App\Models\VehiculoModel;
use Illuminate\Http\Request;

class PropietarioController extends Controller
{
    //Agrega propietarios
    public function agregar(AgregarPropietarioRequest $request)
    {  
        $propietario = PropietarioModel::where("pro_email","=",$request->email)->first();
        
        if(!isset($propietario)){
            $propietario = new PropietarioModel();
            $propietario->pro_documento = $request->cedula;
            $propietario->pro_nombres = $request->name;
            //$propietario->pro_apellidos = $request->apellidos;
            $propietario->pro_apellidos = "";
            $propietario->pro_email = $request->email;
            $propietario->pro_fk_tpd = 1;
            $propietario->save();            
        }
        //$vehiculo_conductor = VehiculoConductorModel::where("veh_con_id","=",$request->veh_con)->first();        
        $vehiculo_conductor = VehiculoConductorModel::where("fk_con_id","=",$request->fk_user_conductor)
                                                     ->whereIsNull("fk_veh_id")->first();

        if(!isset($vehiculo_conductor)){
            $vehiculo_conductor = new VehiculoConductorModel();
            $vehiculo_conductor->fk_con_id = $request->fk_user_conductor;
            $vehiculo_conductor->fk_veh_id = null;
            $vehiculo_conductor->fk_est_id = 2;
            $vehiculo_conductor->save();
        }        
        //$vehiculo->veh_fk_pro = $propietario->pro_id;
        $response["data"] = $propietario;

        $cedula_f = Funciones::imagenBase64($request->cedula_f, "imgs/documentacion/".time()."_cedula_f_".$request->cedula.".png");
        $documentacion_cedula_f = new DocumentacionModel();
        $documentacion_cedula_f->doc_ruta = $cedula_f;
        $documentacion_cedula_f->doc_fk_tdo = 5;
        $documentacion_cedula_f->doc_fk_veh_con = $vehiculo_conductor->veh_con_id;
        $documentacion_cedula_f->doc_fk_est = 2;
        $documentacion_cedula_f->save();

        $cedula_r = Funciones::imagenBase64($request->cedula_r, "imgs/documentacion/".time()."_cedula_r_".$request->cedula.".png");
        $documentacion_cedula_r = new DocumentacionModel();
        $documentacion_cedula_r->doc_ruta = $cedula_r;
        $documentacion_cedula_r->doc_fk_tdo = 6;
        $documentacion_cedula_r->doc_fk_veh_con = $vehiculo_conductor->veh_con_id;
        $documentacion_cedula_r->doc_fk_est = 2;
        $documentacion_cedula_r->save();

        $carta_auto = Funciones::imagenBase64($request->carta_auto, "imgs/documentacion/".time()."_carta_auto_".$request->cedula.".png");
        $documentacion_carta_auto = new DocumentacionModel();
        $documentacion_carta_auto->doc_ruta = $carta_auto;
        $documentacion_carta_auto->doc_fk_tdo = 7;
        $documentacion_carta_auto->doc_fk_veh_con = $vehiculo_conductor->veh_con_id;
        $documentacion_carta_auto->doc_fk_est = 2;
        $documentacion_carta_auto->save();

        return response()->json([
            "success" => true,
            "data" => [
                "sesionUsr" => [
                    "id_owner" => $propietario->pro_id
                ]
            ]
        ]);
    }
    
}

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
            $propietario->pro_documento = $request->documento;
            $propietario->pro_nombres = $request->nombres;
            $propietario->pro_apellidos = $request->apellidos;
            $propietario->pro_email = $request->email;
            $propietario->pro_fk_tpd = 1;
            $propietario->save();            
        }

        $vehiculo_conductor = VehiculoConductorModel::where("veh_con_id","=",$request->veh_con)->first();
        
        $vehiculo = VehiculoModel::findOrFail($vehiculo_conductor->fk_veh_id);
        $vehiculo->veh_fk_pro = $propietario->pro_id;
        $vehiculo->save();

        $response["data"] = $propietario;

        $cedula_f = Funciones::imagenBase64($request->cedula_f, "imgs/documentacion/".time()."_cedula_f_".$request->documento.".png");
        $documentacion_cedula_f = new DocumentacionModel();
        $documentacion_cedula_f->doc_ruta = $cedula_f;
        $documentacion_cedula_f->doc_fk_tdo = 5;
        $documentacion_cedula_f->doc_fk_veh_con = $request->veh_con;
        $documentacion_cedula_f->doc_fk_est = 2;
        $documentacion_cedula_f->save();

        $cedula_r = Funciones::imagenBase64($request->cedula_r, "imgs/documentacion/".time()."_cedula_r_".$request->documento.".png");
        $documentacion_cedula_r = new DocumentacionModel();
        $documentacion_cedula_r->doc_ruta = $cedula_r;
        $documentacion_cedula_r->doc_fk_tdo = 6;
        $documentacion_cedula_r->doc_fk_veh_con = $request->veh_con;
        $documentacion_cedula_r->doc_fk_est = 2;
        $documentacion_cedula_r->save();

        $carta_auto = Funciones::imagenBase64($request->carta_auto, "imgs/documentacion/".time()."_carta_auto_".$request->documento.".png");
        $documentacion_carta_auto = new DocumentacionModel();
        $documentacion_carta_auto->doc_ruta = $carta_auto;
        $documentacion_carta_auto->doc_fk_tdo = 7;
        $documentacion_carta_auto->doc_fk_veh_con = $request->veh_con;
        $documentacion_carta_auto->doc_fk_est = 2;
        $documentacion_carta_auto->save();

        return response()->json($response);
    }
    
}

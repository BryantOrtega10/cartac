<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarConductorRequest;
use App\Models\ConductorModel;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\UsuarioModel;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    
    //Trae los datos de un conductor por id
    public function datos_conductor($id)
    {
        $conductor = ConductorModel::where("con_id",$id)->first();

        return response()->json([
            "success" => true,
            "data" => $conductor
        ], 200);
    }

    //Agrega conductores
    public function agregar(AgregarConductorRequest $request)
    {   
        $usuario = new UsuarioModel();
        $usuario->usr_email = $request->email;
        $usuario->setPasswordAttribute($request->pass);
        $usuario->usr_fk_rol = 1;
        $save_usuario = $usuario->save();

        $conductor = new ConductorModel();
        $conductor->con_documento = $request->cedula;
        $conductor->con_nombres = $request->name;
        //$conductor->con_apellidos = $request->apellidos;
        $conductor->con_apellidos = "";
        $conductor->con_email = $request->email;
        if($request->has("phone")){
            $conductor->con_celular = $request->phone;
        }
        $conductor->con_direccion = $request->address;
        $foto = Funciones::imagenBase64($request->photo, "imgs/users/".time()."_usuario_".$request->cedula.".png");
        $conductor->con_foto = $foto;
        $conductor->con_fk_tpd = 1;
        $conductor->con_fk_usr = $usuario->usr_id;
        $conductor->con_fk_est = 2;
       

        if($request->has("wallet_type") && $request->has("wallet_number")){
            $conductor->con_billetera = $request->wallet_type;
            $conductor->con_numero_billetera = $request->wallet_number;
        }
        
        $save_conductor = $conductor->save();

        $cedula_f = Funciones::imagenBase64($request->cedula_f, "imgs/documentacion/".time()."_cedula_f_".$request->cedula.".png");
        $documentacion_cedula_f = new DocumentacionModel();
        $documentacion_cedula_f->doc_ruta = $cedula_f;
        $documentacion_cedula_f->doc_fk_tdo = 1;
        $documentacion_cedula_f->doc_fk_con = $conductor->con_id;
        $documentacion_cedula_f->doc_fk_est = 2;
        $documentacion_cedula_f->save();

        $cedula_r = Funciones::imagenBase64($request->cedula_r, "imgs/documentacion/".time()."_cedula_r_".$request->cedula.".png");
        $documentacion_cedula_r = new DocumentacionModel();
        $documentacion_cedula_r->doc_ruta = $cedula_r;
        $documentacion_cedula_r->doc_fk_tdo = 2;
        $documentacion_cedula_r->doc_fk_con = $conductor->con_id;
        $documentacion_cedula_r->doc_fk_est = 2;
        $documentacion_cedula_r->save();

        $licencia_c = Funciones::imagenBase64($request->licencia_c, "imgs/documentacion/".time()."_licencia_c_".$request->cedula.".png");
        $documentacion_licencia_c = new DocumentacionModel();
        $documentacion_licencia_c->doc_ruta = $licencia_c;
        $documentacion_licencia_c->doc_fk_tdo = 3;
        $documentacion_licencia_c->doc_fk_con = $conductor->con_id;
        $documentacion_licencia_c->doc_fk_est = 2;
        $documentacion_licencia_c->save();

        if($request->has("cert_banc")){
            $cert_banc = Funciones::imagenBase64($request->cert_banc, "imgs/documentacion/".time()."_cert_banc_".$request->cedula.".png");
            $documentacion_cert_banc = new DocumentacionModel();
            $documentacion_cert_banc->doc_ruta = $cert_banc;
            $documentacion_cert_banc->doc_fk_tdo = 4;
            $documentacion_cert_banc->doc_fk_con = $conductor->con_id;
            $documentacion_cert_banc->doc_fk_est = 2;
            $documentacion_cert_banc->save();
        }

        if(isset($request->esPropietario) && $request->esPropietario == "1"){
            $propietario = new PropietarioModel();
            $propietario->pro_documento = $request->cedula;
            $propietario->pro_nombres = $request->nombres;
            $propietario->pro_apellidos = $request->apellidos;
            $propietario->pro_email = $request->email;
            $propietario->pro_fk_tpd = 1;
            $propietario->save();
        }


        if($save_conductor && $save_usuario){
            return response()->json([
                "success" => true,
                "data" => [
                    "sesionUsr" => [
                        "id" => $conductor->con_id
                    ]   
                ]
            ]);
        }
        else{
            return response()->json([
                "success" => false,
                "data" => []
            ], 406);
        }

    }

    
}

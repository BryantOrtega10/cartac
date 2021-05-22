<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Http\Requests\AgregarConductorRequest;
use App\Http\Requests\ResubirRequest;
use App\Models\ConductorModel;
use App\Models\ConductorRespuestaModel;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\User;
use App\Models\VehiculoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConductorController extends Controller
{
     
    /**
     * Login de conductor
     * 
	 * @group  v 1.0
     * 
     * @bodyParam email String required Email del conductor.
     * @bodyParam pass String required Contraseña del conductor.
     * 
     * */
    public function login(Request $request){
        $usuario = User::whereEmail($request->email)->first();
        if(!is_null($usuario) && Hash::check($request->pass, $usuario->password)){
            $usuario->api_token = Str::random(100);
            $usuario->save();
            if($usuario->fk_rol == "1"){
                $conductor = ConductorModel::where("con_fk_usr",$usuario->id)->first();
                $respuesta = null;
                $documentos = null;
                $vehiculo = VehiculoModel::join("vehiculo_conductor", "fk_veh_id", "=", "veh_id")
                ->join("color_veh", "col_id", "=", "veh_fk_col")
                ->join("marca_veh", "mar_id", "=", "veh_fk_mar")
                ->join("dimension_tipo_veh", "dimension_tipo_veh.id", "=", "veh_fk_dim_tip")
                ->join("tipo_veh", "dimension_tipo_veh.fk_tip", "=", "tip_id")
                ->join("dimension_veh", "dimension_tipo_veh.fk_dim", "=", "dim_id")
                ->where("vehiculo_conductor.fk_est_id", "=", "2")
                ->first();
                if($conductor->con_fk_est == "3"){
                    $respuesta = ConductorRespuestaModel::where("cnr_fk_con","=",$conductor->con_id)->first();
                    $respuesta->cnr_campos = explode(",",$respuesta->cnr_campos);
                    $arrDoc = array();
                    foreach ($respuesta->cnr_campos as $campo){
                        if(is_numeric($campo)){
                            array_push($arrDoc, $campo);
                        }
                    }
                    $documentos = DocumentacionModel::join("tipo_documentacion", "tdo_id", "=", "doc_fk_tdo")->whereIn("doc_id",$arrDoc)->get();

                }
                
                return response()->json([
                    "success" => true,
                    "data" => [
                        "token" => $usuario->api_token,
                        "conductor" => $conductor,
                        "respuesta" => $respuesta,
                        "documentos" => $documentos,
                        "vehiculo" => $vehiculo
                    ]                    
                ], 200);
            }
            else{
                return response()->json([
                    "success" => false,
                    "mensaje" => "El usuario no es conductor"
                ], 406);
            }
            
        }
        else{
            return response()->json([
                "success" => false,
                "mensaje" => "Usuario o contraseña incorrectos"
            ], 406);
        }
    }
    
    /**
     * Datos conductor
     * Trae los datos de un conductor segun el token del login
     * 
	 * @group  v 1.0
     * 
     * @authenticated
     * 
	 */
    public function datos_conductor()
    {
        $usuario = auth()->user();

        $conductor = ConductorModel::where("con_fk_usr",$usuario->id)->first();
        
        return response()->json([
            "success" => true,
            "data" => $conductor
        ], 200);
    }


    
    /**
     * Crear conductores
     * 
	 * @group  v 1.0
     * 
     * @bodyParam email String required email del conductor.
     * @bodyParam pass String required contraseña para el conductor.
     * @bodyParam cedula Integer required cedula del conductor.
     * @bodyParam name String required nombres del conductor.
     * @bodyParam apellidos String required apellidos del conductor.
     * @bodyParam phone Integer  Teléfono del conductor.
     * @bodyParam con_hora_trabajo Integer Valor hora de trabajo del conductor.
     * @bodyParam address String required Dirección del conductor.
     * @bodyParam photo String required Foto del conductor en base 64.
     * @bodyParam wallet_type Integer Tipo de billetera virtual 0-Nequi, 1-Daviplata.
     * @bodyParam wallet_number Integer Numero celular de billetera virtual.
     * @bodyParam cedula_f String required Foto de la cedula frontal del conductor en base 64.
     * @bodyParam cedula_r String required Foto de la cedula respaldo del conductor en base 64.
     * @bodyParam licencia_c String required Foto de la licencia de conducción del conductor en base 64.
     * @bodyParam cert_banc String Foto de la certificación bancaria del conductor en base 64.
     * @bodyParam esPropietario Integer Si se envia en 1 el conductor es propietario.
     * 
	 */
    public function agregar(AgregarConductorRequest $request)
    {   
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->pass);
        $usuario->fk_rol = 1;
        $save_usuario = $usuario->save();

        $conductor = new ConductorModel();
        $conductor->con_documento = $request->cedula;
        $conductor->con_nombres = $request->name;
        $conductor->con_apellidos = $request->apellidos;
        $conductor->con_email = $request->email;
        if($request->has("phone")){
            $conductor->con_celular = $request->phone;
        }
        if($request->has("con_hora_trabajo")){
            $conductor->con_hora_trabajo = $request->con_hora_trabajo;
        }
        $conductor->con_direccion = $request->address;
        $foto = Funciones::imagenBase64($request->photo, "imgs/users/".time()."_usuario_".$request->cedula.".png");
        $conductor->con_foto = $foto;
        $conductor->con_fk_tpd = 1;
        $conductor->con_fk_usr = $usuario->id;
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
            $propietario->pro_nombres = $request->name;
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

    /**
     * Resubir datos conductor
     * 
     * La autorizacion es una variable header -> Authorization : Bearer token
     * 
	 * @group  v 1.0.1
     * 
     * @bodyParam parametro_respuesta String Dato errado.
     * @bodyParam id_documentos [Array] Id del documento en orden.
     * @bodyParam documentos [Array] Documento en base 64 que coincida con el orden del campo anterior.
     * 
     * 
     * @authenticated
     * */
    public function resubir(Request $request){
        $usuario = auth()->user();
        $conductor = ConductorModel::where("con_fk_usr",$usuario->id)->first();
        $vehiculo = VehiculoModel::join("vehiculo_conductor", "fk_veh_id", "=", "veh_id")
            ->join("color_veh", "col_id", "=", "veh_fk_col")
            ->join("marca_veh", "mar_id", "=", "veh_fk_mar")
            ->join("dimension_tipo_veh", "dimension_tipo_veh.id", "=", "veh_fk_dim_tip")
            ->join("tipo_veh", "dimension_tipo_veh.fk_tip", "=", "tip_id")
            ->join("dimension_veh", "dimension_tipo_veh.fk_dim", "=", "dim_id")
            ->where("vehiculo_conductor.fk_con_id", "=", $conductor->con_id)
            ->first();
        $propietario = PropietarioModel::where("pro_id", "=", $vehiculo->veh_fk_pro)->first();

        if($request->has("con_email")){
            $usuario_ver = User::where("email","=",$request->con_email)->where("id","<>",$usuario->id)->first();
            if(isset($usuario_ver)){
                return response()->json([
                    "success" => false,
                    "mensaje" => "El nombre de usuario ya esta registrado"
                ]);
            }
            $usuario->email = $request->con_email;            
            $conductor->con_email = $request->con_email;            
        }
        if($request->has("con_documento")){
            $conductor_ver = ConductorModel::where("con_documento","=",$request->con_documento)->where("con_id","<>",$conductor->con_id)->first();
            if(isset($conductor_ver)){
                return response()->json([
                    "success" => false,
                    "mensaje" => "El documento ya esta registrado"
                ]);
            }
            $conductor->con_documento = $request->con_documento;
        }
        if($request->has("con_nombres")){
            $conductor->con_nombres = $request->con_nombres;
        }
        if($request->has("con_apellidos")){
            $conductor->con_apellidos = $request->con_apellidos;
        }
        if($request->has("con_apellidos")){
            $conductor->con_apellidos = $request->con_apellidos;
        }
        if($request->has("con_celular")){
            $conductor->con_celular = $request->con_celular;
        }
        if($request->has("con_direccion")){
            $conductor->con_direccion = $request->con_direccion;
        }
        if($request->has("con_foto")){
            Storage::delete($conductor->con_foto);
            $con_foto = Funciones::imagenBase64($request->con_foto, "imgs/users/".time()."_usuario_".$conductor->con_documento.".png");
            $conductor->con_foto = $con_foto;
        }
        if($request->has("con_billetera")){
            $conductor->con_billetera = $request->con_billetera;
        }
        if($request->has("con_numero_billetera")){
            $conductor->con_numero_billetera = $request->con_numero_billetera;
        }
        if($request->has("con_hora_trabajo")){
            $conductor->con_hora_trabajo = $request->con_hora_trabajo;
        }
        
        if($request->has("pro_documento")){
            $propietario->pro_documento = $request->pro_documento;
        }
        if($request->has("pro_nombres")){
            $propietario->pro_nombres = $request->pro_nombres;
        }
        if($request->has("pro_apellidos")){
            $propietario->pro_apellidos = $request->pro_apellidos;
        }
        if($request->has("pro_email")){
            $propietario->pro_email = $request->pro_email;
        }


        if($request->has("veh_placa")){
            $vehiculo->veh_placa = $request->veh_placa;
        }

        if($request->has("veh_fk_col")){
            $vehiculo->veh_fk_col = $request->veh_fk_col;
        }
        if($request->has("veh_fk_mar")){
            $vehiculo->veh_fk_mar = $request->veh_fk_mar;
        }
        if($request->has("veh_tip")){
            $vehiculo->veh_tip = $request->veh_tip;
        }
        if($request->has("veh_dim")){
            $vehiculo->veh_dim = $request->veh_dim;
        }
        if($request->has("veh_rendimiento")){
            $vehiculo->veh_rendimiento = $request->veh_rendimiento;
        }
        if($request->has("veh_foto")){
            $vehiculo->veh_foto = $request->veh_foto;
        }


        
        if($request->has("id_documentos")){
            foreach($request->id_documentos as $key => $id_documento){
                $docu = DocumentacionModel::findOrFail($id_documento);
                Storage::delete($docu->doc_ruta);
                $doc_ruta = Funciones::imagenBase64($request->documentos[$key], "imgs/documentacion/".time()."_resubida_".$conductor->con_documento.".png");
                $docu->doc_ruta = $doc_ruta;
                $docu->save();
            }
        }

        $conductor->con_fk_est = 2;
        $propietario->save();
        $vehiculo->save();
        $conductor->save();
        return response()->json([
            "success" => true,
            "mensaje" => "Datos reenviados"
        ]);
    }
    /**
     * Conectar al conductor
     * Permite que el conductor pueda aceptar viajes
     * 
	 * @group  v 1.0.2
     * 
     * @authenticated
     * 
	 */
    public function conectar(){
        $usuario = auth()->user();

        $conductor = ConductorModel::where("con_fk_usr",$usuario->id)->first();
        if($conductor->con_fk_est == "2" || $conductor->con_fk_est == "3"){
            return response()->json([
                "success" => true,
                "mensaje" => "El conductor no ha sido activado por el administrador"
            ], 406);
        }
        $conductor->con_fk_est = 5;
        $conductor->save();
        return response()->json([
            "success" => true
        ], 200);
    }

    
}

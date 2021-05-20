<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Http\Requests\AgregarConductorRequest;
use App\Models\ConductorModel;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
                return response()->json([
                    "success" => true,
                    "token" => $usuario->api_token
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

    
}

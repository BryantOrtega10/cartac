<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Http\Requests\AgregarClienteRequest;
use App\Http\Requests\ModificarClienteRequest;
use App\Models\ClienteModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClienteController extends Controller
{

    /**
     * Registrar cliente
     * 
	 * @group  v 1.0.1
     * 
     * @bodyParam cli_nombres String required Nombres del cliente.
     * @bodyParam cli_apellidos String required Apellidos del cliente.
     * @bodyParam cli_email String required Email del cliente.
     * @bodyParam cli_pass String Password del cliente.
     * @bodyParam cli_foto String/File required Puede ser un archivo o una imagen en base 64 de la foto del cliente.
     * @bodyParam cli_red String required FACEBOOK, GOOGLE, APPLE, etc.
     * @bodyParam cli_id_red String required id de la red social.
     * 
     * */
    public function registro_cliente(AgregarClienteRequest $request){

        $usuario = new User();
        $usuario->name = $request->cli_nombres." ".$request->cli_apellidos;
        $usuario->email = $request->cli_email;
        if($request->has("cli_pass")){
            $usuario->password = Hash::make($request->cli_pass);
        }else if($request->has("cli_red") && $request->has("cli_id_red")){
            $usuario->password = Hash::make($request->cli_id_red);
        }        
        else{
            return response()->json([
                "success" => false,
                "mensaje" => "Debe enviar cli_pass o la red social"
            ], 406);
        }
        $usuario->fk_rol = 2;
        $save_usuario = $usuario->save();


        $cliente = new ClienteModel();
        $cliente->cli_nombres = $request->cli_nombres;
        $cliente->cli_apellidos = $request->cli_apellidos;
        $cliente->cli_email = $request->cli_email;
        if($request->hasFile("cli_foto")){
            $directorio = "imgs/users/";
            $fotoNom =  time()."_usuario_cliente.png";
            $request->file("cli_foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $cliente->cli_foto = $foto;
        }
        else{
            if($request->has("cli_foto")){
                $foto = Funciones::imagenBase64($request->cli_foto, "imgs/users/".time()."_usuario_cliente.png");
                $cliente->cli_foto = $foto;
            }
        }
        if($request->has("cli_red")){
            $cliente->cli_red = $request->cli_red;
        }
        if($request->has("cli_red")){
            $cliente->cli_id_red = $request->cli_id_red;
        }     

        $cliente->cli_fk_usr = $usuario->id;
        $save_cliente = $cliente->save();

        if($save_cliente && $save_usuario){
            $usuario->api_token = Str::random(100);
            $usuario->save();

            return response()->json([
                "success" => true,
                "data" => [
                    "cliente" => $cliente,
                    "token" => $usuario->api_token
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
     * Login de cliente
     * 
	 * @group  v 1.0.1
     * 
     * @bodyParam email String Email del cliente.
     * @bodyParam pass String Contraseña del cliente o id de la red social.
     * 
     * */
    public function login(Request $request){

        $usuario = User::whereEmail($request->email)->first();
        if(!is_null($usuario) && Hash::check($request->pass, $usuario->password)){
            $usuario->api_token = Str::random(100);
            $usuario->save();
            if($usuario->fk_rol == "2"){
                $cliente = ClienteModel::where("cli_fk_usr","=",$usuario->id)->first();
                return response()->json([
                    "success" => true,
                    "data" => [
                        "token" => $usuario->api_token,
                        "cliente" => $cliente
                    ]                    
                ], 200);
            }
            else{
                return response()->json([
                    "success" => false,
                    "mensaje" => "El usuario no es cliente"
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
     * Modificar cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam cli_nombres String required Nombres del cliente.
     * @bodyParam cli_apellidos String required Apellidos del cliente.
     * @bodyParam cli_email String required Email del cliente.
     * @bodyParam cli_pass String Password del cliente.
     * @bodyParam cli_foto String/File Puede ser un archivo o una imagen en base 64 de la foto del cliente.
     * 
     * @authenticated
     * 
     * */
    public function modificar(ModificarClienteRequest $request){
        $userBd = auth()->user();

        $usuario = User::findOrFail($userBd->id);
        $usuario->name = $request->cli_nombres." ".$request->cli_apellidos;
        $usuario->email = $request->cli_email;
        if($request->has("cli_pass")){
            $usuario->password = Hash::make($request->cli_pass);
        }
        $usuario->fk_rol = 2;
        $save_usuario = $usuario->save();


        $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
        $cliente->cli_nombres = $request->cli_nombres;
        $cliente->cli_apellidos = $request->cli_apellidos;
        $cliente->cli_email = $request->cli_email;
        if($request->hasFile("cli_foto")){
            Storage::delete($cliente->cli_foto);
            $directorio = "imgs/users/";
            $fotoNom =  time()."_usuario_cliente.png";
            $request->file("cli_foto")->storeAs($directorio, $fotoNom, "local");
            $foto = $directorio.$fotoNom;
            $cliente->cli_foto = $foto;
        }
        $save_cliente = $cliente->save();

        return response()->json([
            "success" => true,
            "message" => "Cliente actualizado correctamente"
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AceptarServicioRequest;
use App\Http\Requests\CalificarServicioRequest;
use App\Http\Requests\CambiarEstadoServicioRequest;
use App\Http\Requests\CancelarServicioRequest;
use App\Http\Requests\CotizarServicioRequest;
use App\Http\Requests\CrearServicioRequest;
use App\Http\Requests\VerDatosServicioRequest;
use App\Models\ClienteModel;
use App\Models\ConductorModel;
use App\Models\ConfiguracionModel;
use App\Models\MultiplicadorModel;
use App\Models\PeajeModel;
use App\Models\PeajeServicioModel;
use App\Models\ServicioModel;
use App\Models\VehiculoConductorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class ServicioController extends Controller
{
    /**
     * Cotizar servicio
     * Permite conocer el valor del servicio antes de generarlo
     * 
	 * @group  v 1.0.3
     * 
     * @bodyParam lat_ini Double required latitud de la ubicacion inicial.
     * @bodyParam lng_ini Double required longitud de la ubicacion inicial.
     * @bodyParam lat_fin Double required latitud de la ubicacion final.
     * @bodyParam lng_fin Double required longitud de la ubicacion final.
     * @bodyParam tipo_veh Integer required Id del tipo de vehiculo.
     * 
     * @authenticated
     * 
	 */
    public function cotizar(CotizarServicioRequest $request){
        
        $responseDistance = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json",[
            "origins" => $request->lat_ini.",".$request->lng_ini,
            "destinations" =>  $request->lat_fin.",".$request->lng_fin,
            "key" => Config::get('services.google.key')
        ]);

        $responseDirectionsIda = Http::get("https://maps.googleapis.com/maps/api/directions/json",[
            "origin" => $request->lat_ini.",".$request->lng_ini,
            "destination" =>  $request->lat_fin.",".$request->lng_fin,
            "key" => Config::get('services.google.key')
        ]);

        $responseDirectionsVuelta = Http::get("https://maps.googleapis.com/maps/api/directions/json",[
            "origin" =>  $request->lat_fin.",".$request->lng_fin,
            "destination" =>  $request->lat_ini.",".$request->lng_ini,
            "key" => Config::get('services.google.key')
        ]);

        if($responseDistance["status"] == "OK" && $responseDirectionsIda["status"] == "OK" && $responseDirectionsVuelta["status"] == "OK"){
            $distancia = $responseDistance["rows"][0]["elements"][0]["distance"]["value"] / 1000; 
            $tiempo = $responseDistance["rows"][0]["elements"][0]["duration"]["value"] / 60;

            $encodedIda = $responseDirectionsIda["routes"][0]["overview_polyline"]["points"];
            $encodedVuelta = $responseDirectionsVuelta["routes"][0]["overview_polyline"]["points"];

            $pointsIda = \Polyline::decode($encodedIda);
            $pointsIda = \Polyline::pair($pointsIda);

            $pointsVuelta = \Polyline::decode($encodedVuelta);
            $pointsVuelta = \Polyline::pair($pointsVuelta);

            $lineStringIda = array();
            foreach($pointsIda as $punto){
                array_push($lineStringIda, $punto[0]." ".$punto[1]);
            }
            $lineStringIda = implode(",",$lineStringIda);

            $lineStringVuelta = array();
            foreach($pointsVuelta as $punto){
                array_push($lineStringVuelta, $punto[0]." ".$punto[1]);
            }
            $lineStringVuelta = implode(",",$lineStringVuelta);

            $configuracion_defecto = ConfiguracionModel::findOrFail(1);
            
            $sqlWhere = "('".date("H:i:s")."' BETWEEN cfm_hora_inicio AND cfm_hora_fin)";
            $multiplicador = MultiplicadorModel::whereRaw($sqlWhere)->first();

            if(isset($multiplicador)){
                $configuracion_defecto->cfg_distancia = $configuracion_defecto->cfg_distancia*$multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_tiempo = $configuracion_defecto->cfg_tiempo*$multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_peso = $configuracion_defecto->cfg_peso*$multiplicador->cfm_multiplicador;                
            }

            $distancia = round($distancia, 2);
            $tiempo = round($tiempo, 2);
            $valorDistancia = $distancia*$configuracion_defecto->cfg_distancia;
            $valorTiempo = $tiempo*$configuracion_defecto->cfg_tiempo;
            
            $sqlIda = "ST_Crosses(ST_Buffer(pea_ubic, (360*pea_radio)/40000000), ST_GeomFromText('LineString(".$lineStringIda.")'))";
            $sqlVuelta = "ST_Crosses(ST_Buffer(pea_ubic, (360*pea_radio)/40000000), ST_GeomFromText('LineString(".$lineStringVuelta.")'))";

            $peajesIda = PeajeModel::selectRaw("pea_id,pea_nombre,pcp_valor, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng")
            ->join("peaje_categoria_peaje","pcp_fk_pea","=","pea_id")
            ->whereRaw($sqlIda)
            ->where("pcp_fk_ctp","=",$request->tipo_veh)
            ->get();

            $peajesVuelta = PeajeModel::selectRaw("pea_id,pea_nombre,pcp_valor, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng")
            ->join("peaje_categoria_peaje","pcp_fk_pea","=","pea_id")
            ->whereRaw($sqlVuelta)
            ->where("pcp_fk_ctp","=",$request->tipo_veh)
            ->get();

            $valorPeajes = 0;
            foreach($peajesIda as $peajeIda){
                $valorPeajes+=$peajeIda->pcp_valor;
            }
            foreach($peajesVuelta as $peajeVuelta){
                $valorPeajes+=$peajeVuelta->pcp_valor;
            }

            $subTotal = $valorDistancia + $valorTiempo + $valorPeajes;
            $seguro = round($subTotal*($configuracion_defecto->cfg_porcentaje_seguro/100),2);
            $ganancia = round($subTotal*($configuracion_defecto->cfg_porcentaje_ganancia/100),2);
            $total = $subTotal + $seguro + $ganancia;
            
            return response()->json([
                "success" => true,
                "data" => [
                    "distancia" => $distancia,
                    "tiempo" => $tiempo,
                    "peajesIda" => $peajesIda,
                    "peajesVuelta" => $peajesVuelta,
                    "valorDistancia" => $valorDistancia,
                    "valorTiempo" => $valorTiempo,
                    "valorPeajes" => $valorPeajes,
                    "valorSeguro" => $seguro,
                    "valorGanancia" => $ganancia,
                    "total" => $total                    
                ]
            ],200);

        }
        else{
            return response()->json([
                "success" => false,
                "mensaje" => "Error en servicio de google"
            ],406);
        }             
    }

    /**
     * Crear servicio
     * Permite crear el servicio
     * 
	 * @group  v 1.0.3
     * 
     * @bodyParam lat_ini Double required latitud de la ubicacion inicial.
     * @bodyParam lng_ini Double required longitud de la ubicacion inicial.
     * @bodyParam lat_fin Double required latitud de la ubicacion final.
     * @bodyParam lng_fin Double required longitud de la ubicacion final.
     * @bodyParam direccion_inicio String required Dirección inicial que el cliente escribió.
     * @bodyParam direccion_fin String required Dirección final que el cliente escribió.
     * @bodyParam tipo_veh Integer required Id del tipo de vehiculo.
     * @bodyParam dimension Integer required Id dimension del vehiculo.
     * @bodyParam categoria Integer required Id de la categoria del vehiculo.
     * 
     * @authenticated
     * 
	 */
    public function crear(CrearServicioRequest $request){
        
        
        $responseDistance = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json",[
            "origins" => $request->lat_ini.",".$request->lng_ini,
            "destinations" =>  $request->lat_fin.",".$request->lng_fin,
            "key" => Config::get('services.google.key')
        ]);

        $responseDirectionsIda = Http::get("https://maps.googleapis.com/maps/api/directions/json",[
            "origin" => $request->lat_ini.",".$request->lng_ini,
            "destination" =>  $request->lat_fin.",".$request->lng_fin,
            "key" => Config::get('services.google.key')
        ]);

        $responseDirectionsVuelta = Http::get("https://maps.googleapis.com/maps/api/directions/json",[
            "origin" =>  $request->lat_fin.",".$request->lng_fin,
            "destination" =>  $request->lat_ini.",".$request->lng_ini,
            "key" => Config::get('services.google.key')
        ]);

        if($responseDistance["status"] == "OK" && $responseDirectionsIda["status"] == "OK" && $responseDirectionsVuelta["status"] == "OK"){
            $distancia = $responseDistance["rows"][0]["elements"][0]["distance"]["value"] / 1000; 
            $tiempo = $responseDistance["rows"][0]["elements"][0]["duration"]["value"] / 60;

            $encodedIda = $responseDirectionsIda["routes"][0]["overview_polyline"]["points"];
            $encodedVuelta = $responseDirectionsVuelta["routes"][0]["overview_polyline"]["points"];

            $pointsIda = \Polyline::decode($encodedIda);
            $pointsIda = \Polyline::pair($pointsIda);

            $pointsVuelta = \Polyline::decode($encodedVuelta);
            $pointsVuelta = \Polyline::pair($pointsVuelta);

            $lineStringIda = array();
            foreach($pointsIda as $punto){
                array_push($lineStringIda, $punto[0]." ".$punto[1]);
            }
            $lineStringIda = implode(",",$lineStringIda);

            $lineStringVuelta = array();
            foreach($pointsVuelta as $punto){
                array_push($lineStringVuelta, $punto[0]." ".$punto[1]);
            }
            $lineStringVuelta = implode(",",$lineStringVuelta);

            $configuracion_defecto = ConfiguracionModel::findOrFail(1);
            
            $sqlWhere = "('".date("H:i:s")."' BETWEEN cfm_hora_inicio AND cfm_hora_fin)";
            $multiplicador = MultiplicadorModel::whereRaw($sqlWhere)->first();

            if(isset($multiplicador)){
                $configuracion_defecto->cfg_distancia = $configuracion_defecto->cfg_distancia*$multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_tiempo = $configuracion_defecto->cfg_tiempo*$multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_peso = $configuracion_defecto->cfg_peso*$multiplicador->cfm_multiplicador;                
            }

            $distancia = round($distancia, 2);
            $tiempo = round($tiempo, 2);
            $valorDistancia = $distancia*$configuracion_defecto->cfg_distancia;
            $valorTiempo = $tiempo*$configuracion_defecto->cfg_tiempo;
            
            $sqlIda = "ST_Crosses(ST_Buffer(pea_ubic, (360*pea_radio)/40000000), ST_GeomFromText('LineString(".$lineStringIda.")'))";
            $sqlVuelta = "ST_Crosses(ST_Buffer(pea_ubic, (360*pea_radio)/40000000), ST_GeomFromText('LineString(".$lineStringVuelta.")'))";

            $peajesIda = PeajeModel::selectRaw("pea_id,pea_nombre,pcp_valor, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng")
            ->join("peaje_categoria_peaje","pcp_fk_pea","=","pea_id")
            ->whereRaw($sqlIda)
            ->where("pcp_fk_ctp","=",$request->tipo_veh)
            ->get();

            $peajesVuelta = PeajeModel::selectRaw("pea_id,pea_nombre,pcp_valor, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng")
            ->join("peaje_categoria_peaje","pcp_fk_pea","=","pea_id")
            ->whereRaw($sqlVuelta)
            ->where("pcp_fk_ctp","=",$request->tipo_veh)
            ->get();

            $valorPeajes = 0;
            foreach($peajesIda as $peajeIda){
                $valorPeajes+=$peajeIda->pcp_valor;
            }
            foreach($peajesVuelta as $peajeVuelta){
                $valorPeajes+=$peajeVuelta->pcp_valor;
            }

            $subTotal = $valorDistancia + $valorTiempo + $valorPeajes;
            $seguro = round($subTotal*($configuracion_defecto->cfg_porcentaje_seguro/100),2);
            $ganancia = round($subTotal*($configuracion_defecto->cfg_porcentaje_ganancia/100),2);
            
            $total = $subTotal + $seguro + $ganancia;

            
            $servicio = new ServicioModel();
            $usuario = auth()->user();
            $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();

            $servicio->ser_fk_cli = $cliente->cli_id;
            $servicio->ser_ubicacion_ini = DB::raw('POINT('.$request->lat_ini.', '.$request->lng_ini.')');
            $servicio->ser_ubicacion_fin = DB::raw('POINT('.$request->lat_fin.', '.$request->lng_fin.')');
            $servicio->ser_direccion_ini = $request->direccion_inicio;
            $servicio->ser_direccion_fin = $request->direccion_fin;
            $servicio->ser_distancia = $valorDistancia;
            $servicio->ser_tiempo = $valorTiempo;
            $servicio->ser_peajes = $valorPeajes;
            $servicio->ser_seguro = $seguro;
            $servicio->ser_ganancia = $ganancia;
            $servicio->ser_valor_final = $total;
            $servicio->ser_fk_cat = $request->categoria;
            $servicio->ser_fk_dim = $request->dimension;
            $servicio->ser_fk_tip = $request->tipo_veh;
            if(isset($multiplicador)){
                $servicio->ser_fk_cfm = $request->cfm_id; 
            }
            $servicio->ser_fk_est = 8; //BUSCANDO CONDUCTOR
            $servicio->ser_ruta_cotizada = DB::raw('ST_GeomFromText("LINESTRING('.$lineStringIda.')")');
            //FALTA EL METODO DE PAGO
            $servicio->save();
            

            foreach($peajesIda as $peajeIda){
                PeajeServicioModel::insert([
                    "pjs_valor_cobrado" => $peajeIda->pcp_valor,
                    "pjs_fk_pea_id" => $peajeIda->pea_id,
                    "pjs_fk_ser_id" => $servicio->ser_id
                ]);                
            }
            foreach($peajesVuelta as $peajeVuelta){
                PeajeServicioModel::insert([
                    "pjs_valor_cobrado" => $peajeIda->pcp_valor,
                    "pjs_fk_pea_id" => $peajeIda->pea_id,
                    "pjs_fk_ser_id" => $servicio->ser_id
                ]);
            }



            return response()->json([
                "success" => true,
                "mensaje" => "Estamos buscando al conductor",
                "data" => [
                    "servicio" => $servicio
                ]
            ],200);

        }
        else{
            return response()->json([
                "success" => false,
                "mensaje" => "Error en servicio de google"
            ],406);
        }             
    }


    /**
     * Aceptar servicio
     * Permite Aceptar el servicio por parte del conductor, el id del servicio llega por una notificacion push
     * 
	 * @group  v 1.0.3
     * 
     * @bodyParam ser_id Integer required Id del servicio.
     * @bodyParam veh_id Integer required Id del vehiculo.
     * 
     * @authenticated
     * 
	 */    
    public function aceptar(AceptarServicioRequest $request){
        $usuario = auth()->user();
        $conductor = ConductorModel::where("con_fk_usr",$usuario->id)->first();
        $servicio = ServicioModel::findOrFail($request->ser_id);
        $servicio->ser_fk_con = $conductor->con_id;
        $servicio->ser_fk_veh = $request->veh_id;
        $servicio->ser_aceptado_at = date("Y-m-d H:i:s");
        $servicio->ser_fk_est = 9;
        $servicio->save();       
        //PUSH: Enviar al cliente del servicio el conductor y el vehiculo 
        return response()->json([
            "success" => true,
            "mensaje" => "Servicio aceptado correctamente",
            "data" => [
                "servicio" => [
                    "ser_id" => $servicio->ser_id
                ]                
            ]
        ],200);        
    }

    /**
     * Ver datos del servicio
     * Permite ver la ubicación del vehiculo que presta el servicio por parte del cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam ser_id Integer required Id del servicio.
     * 
     * @authenticated
     * 
	 */    
    public function ver_datos(VerDatosServicioRequest $request){

        $servicio = ServicioModel::findOrFail($request->ser_id);
        $arrEstadosValidos = [9,10,7];
        $data = array();
        $data["ser_direccion_ini"] = $servicio->ser_direccion_ini;
        $data["ser_direccion_fin"] = $servicio->ser_direccion_fin;
        $data["ser_distancia"] = $servicio->ser_distancia;
        $data["ser_tiempo"] = $servicio->ser_tiempo;
        $data["ser_peajes"] = $servicio->ser_peajes;
        $data["ser_seguro"] = $servicio->ser_seguro;
        $data["ser_ganancia"] = $servicio->ser_ganancia;
        $data["ser_valor_final"] = $servicio->ser_valor_final;
        $data["cli_nombres"] = $servicio->cliente->cli_nombres;
        $data["cli_apellidos"] = $servicio->cliente->cli_apellidos;
        $data["cli_email"] = $servicio->cliente->cli_email;
        $data["cli_foto"] = $servicio->cliente->cli_foto;
        $data["veh_placa"] = $servicio->vehiculo->veh_placa;
        $data["veh_foto"] = $servicio->vehiculo->veh_foto;
        $data["con_documento"] = $servicio->conductor->con_documento;
        $data["con_nombres"] = $servicio->conductor->con_nombres;
        $data["con_apellidos"] = $servicio->conductor->con_apellidos;
        $data["con_email"] = $servicio->conductor->con_email;
        $data["con_celular"] = $servicio->conductor->con_celular;
        $data["con_direccion"] = $servicio->conductor->con_direccion;
        $data["con_foto"] = $servicio->conductor->con_foto;

        if(in_array($servicio->ser_fk_est, $arrEstadosValidos)){
            $vehiculo_conductor = VehiculoConductorModel::selectRaw("ST_X(veh_con_ubicacion) as lat, ST_Y(veh_con_ubicacion) as lng")
            ->where("fk_con_id",$servicio->ser_fk_con)
            ->where("fk_veh_id",$servicio->ser_fk_veh)
            ->first();
            $data["lat_conductor"] = $vehiculo_conductor->lat;
            $data["lng_conductor"] = $vehiculo_conductor->lng;

        }
        

        return response()->json([
            "success" => true,
            "data" => $data
        ],200);   
    }

    

    /**
     * Cambiar estado servicio
     * Permite cambiar el estado del servicio por parte del conductor, Estados: 10 - CONDUCTOR ESPERANDO, 11 - TERMINADO, 7 - EN VIAJE
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam ser_id Integer required Id del servicio.
     * @bodyParam est_id Integer required Id del estado.
     * 
     * @authenticated
     * 
	 */    
    public function cambiar_estado(CambiarEstadoServicioRequest $request){
        
        $servicio = ServicioModel::findOrFail($request->ser_id);
        
        $servicio->ser_fk_est = $request->est_id;
        $servicio->save();


        if($request->est_id == 10){
            //PUSH: Enviar al cliente del servicio la notificacion de que el conductor ya llego
        }
        else if($request->est_id == 7){
            //PUSH: Enviar al cliente del servicio la notificacion de que el conductor ya empezo el viaje para cambiar la ventana del cliente
        }
        else if($request->est_id == 11){
            //PUSH: Enviar al cliente del servicio la notificacion de que el servicio terminó
        }


        return response()->json([
            "success" => true,
            "mensaje" => "Servicio modificado correctamente",
            "data" => [
                "servicio" => [
                    "ser_id" => $servicio->ser_id
                ]                
            ]
        ],200);        
    }

    /**
     * Cancelar servicio
     * Permite cancelar el servicio por parte del cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam ser_id Integer required Id del servicio.
     * @bodyParam motivo String required Motivo por el  que cancela
     * 
     * @authenticated
     * 
	 */  
    public function cancelar(CancelarServicioRequest $request){
        $servicio = ServicioModel::findOrFail($request->ser_id);        
        $servicio->ser_motivo_cancelacion = $request->motivo;
        $servicio->ser_fk_est = 12;
        $servicio->save();
        //PUSH: Enviar al conductor del servicio la notificacion de que el servicio se cancelo
        return response()->json([
            "success" => true,
            "mensaje" => "Servicio cancelado correctamente"            
        ],200);        
    }

    /**
     * Calificar servicio
     * Permite calificar el servicio por parte del cliente
     * 
	 * @group  v 1.0.4
     * 
     * @bodyParam ser_id Integer required Id del servicio.
     * @bodyParam calificacion Integer required Número del 0 al 5 que indica la calificación del servicio.
     * @bodyParam opinion String Opinion acerca del servicio.
     * 
     * @authenticated
     * 
	 */  
    public function calificar(CalificarServicioRequest $request){
        $servicio = ServicioModel::findOrFail($request->ser_id);        
        $servicio->ser_calificacion = floatval($request->calificacion);
        $servicio->ser_opinion = $request->opinion;
        $servicio->ser_fk_est = 13;
        $servicio->save();
        //PUSH: Enviar al conductor del servicio la notificacion de que el servicio se cancelo
        return response()->json([
            "success" => true,
            "mensaje" => "Servicio calificado correctamente"            
        ],200);        
    }

    
}

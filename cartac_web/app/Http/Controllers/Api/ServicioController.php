<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AceptarServicioRequest;
use App\Http\Requests\CotizarServicioRequest;
use App\Http\Requests\CrearServicioRequest;
use App\Models\ClienteModel;
use App\Models\ConductorModel;
use App\Models\ConfiguracionModel;
use App\Models\MultiplicadorModel;
use App\Models\PeajeModel;
use App\Models\PeajeServicioModel;
use App\Models\ServicioModel;
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

    
}

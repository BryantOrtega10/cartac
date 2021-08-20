<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
use App\Http\Requests\AceptarServicioRequest;
use App\Http\Requests\CalificarServicioRequest;
use App\Http\Requests\CambiarEstadoServicioRequest;
use App\Http\Requests\CancelarServicioRequest;
use App\Http\Requests\CotizarServicioRequest;
use App\Http\Requests\CrearServicioRequest;
use App\Http\Requests\VerDatosServicioRequest;
use App\Models\BonoModel;
use App\Models\ClienteBonoModel;
use App\Models\ClienteModel;
use App\Models\ConductorModel;
use App\Models\ConfiguracionModel;
use App\Models\MultiplicadorModel;
use App\Models\PeajeModel;
use App\Models\PeajeServicioModel;
use App\Models\ServicioModel;
use App\Models\TipoVehiculoModel;
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
            $tiempoRecorrido = $responseDistance["rows"][0]["elements"][0]["duration"]["value"] / 60;
            
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
                $configuracion_defecto->cfg_hora_hombre = $configuracion_defecto->cfg_hora_hombre * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_gasolina = $configuracion_defecto->cfg_gasolina * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_gas = $configuracion_defecto->cfg_gas * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_acpm = $configuracion_defecto->cfg_acpm * $multiplicador->cfm_multiplicador;
            }

            $distancia = round($distancia, 2);
            $tiempoRecorrido = round($tiempoRecorrido, 2);


            $tipo_vehiculo = TipoVehiculoModel::findOrFail($request->tipo_veh);
            $alquiler = $tipo_vehiculo->tip_alquiler;
            $distanciaxKm = 0;
            if($tipo_vehiculo->tip_combustible == "GASOLINA"){
                $distanciaxKm = $configuracion_defecto->cfg_gasolina / $tipo_vehiculo->tip_rendimiento;
            }
            else if($tipo_vehiculo->tip_combustible == "GAS"){
                $distanciaxKm = $configuracion_defecto->cfg_gas / $tipo_vehiculo->tip_rendimiento;
            }
            else if($tipo_vehiculo->tip_combustible == "ACPM"){
                $distanciaxKm = $configuracion_defecto->cfg_acpm / $tipo_vehiculo->tip_rendimiento;
            }
            $tiempoCargue = $tipo_vehiculo->tip_tiempo_cargue;

            $valorDistancia = $distancia * $distanciaxKm;
            $tiempoTotal = $tiempoRecorrido + $tiempoCargue;
            

            $valorTiempo = ($configuracion_defecto->cfg_hora_hombre/60) * $tiempoTotal;
            
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

            $subTotal = round($alquiler + $valorDistancia + $valorTiempo, 0);
            $total = round($subTotal / (1 - ($configuracion_defecto->cfg_porcentaje_ganancia/100)),0 );
            $ganancia = $total - $subTotal;
            
            return response()->json([
                "success" => true,
                "data" => [
                    "alquiler" => $alquiler,
                    "distancia" => $distancia,
                    "tiempoCargue" => $tiempoCargue,
                    "tiempoRecorrido" => $tiempoRecorrido,
                    "peajesIda" => $peajesIda,
                    "peajesVuelta" => $peajesVuelta,
                    "valorDistancia" => $valorDistancia,
                    "valorTiempo" => $valorTiempo,
                    "valorPeajes" => $valorPeajes,
                    "valorGanancia" => $ganancia,
                    "subTotal" => $subTotal,
                    "total" => $total,
                    "porcentajeSeguro" => $configuracion_defecto->cfg_porcentaje_seguro    
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
	 * @group  v 1.0.5
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
     * @bodyParam aplica_seguro Integer required 0 o 1 si aplica el seguro.
     * @bodyParam bono String optional Bono de descuento.
     * 
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
            $tiempoRecorrido = $responseDistance["rows"][0]["elements"][0]["duration"]["value"] / 60;

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
                $configuracion_defecto->cfg_hora_hombre = $configuracion_defecto->cfg_hora_hombre * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_gasolina = $configuracion_defecto->cfg_gasolina * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_gas = $configuracion_defecto->cfg_gas * $multiplicador->cfm_multiplicador;
                $configuracion_defecto->cfg_acpm = $configuracion_defecto->cfg_acpm * $multiplicador->cfm_multiplicador;
            }

            $distancia = round($distancia, 2);
            $tiempoRecorrido = round($tiempoRecorrido, 2);


            $tipo_vehiculo = TipoVehiculoModel::findOrFail($request->tipo_veh);
            $alquiler = $tipo_vehiculo->tip_alquiler;
            $distanciaxKm = 0;
            if($tipo_vehiculo->tip_combustible == "GASOLINA"){
                $distanciaxKm = $configuracion_defecto->cfg_gasolina / $tipo_vehiculo->tip_rendimiento;
            }
            else if($tipo_vehiculo->tip_combustible == "GAS"){
                $distanciaxKm = $configuracion_defecto->cfg_gas / $tipo_vehiculo->tip_rendimiento;
            }
            else if($tipo_vehiculo->tip_combustible == "ACPM"){
                $distanciaxKm = $configuracion_defecto->cfg_acpm / $tipo_vehiculo->tip_rendimiento;
            }
            $tiempoCargue = $tipo_vehiculo->tip_tiempo_cargue;

            $valorDistancia = $distancia * $distanciaxKm;
            $tiempoTotal = $tiempoRecorrido + $tiempoCargue;
            

            $valorTiempo = ($configuracion_defecto->cfg_hora_hombre/60) * $tiempoTotal;
            
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

            $seguro = 0;
            if($request->aplica_seguro == "1"){
                $seguro = round(($configuracion_defecto->cfg_porcentaje_seguro/100)*($request->valor_carga), 0);
            }
            


            $subTotal = round($alquiler + $valorDistancia + $valorTiempo + $seguro + $valorPeajes, 0);
            $total = round($subTotal / (1 - ($configuracion_defecto->cfg_porcentaje_ganancia/100)),0 );
            $ganancia = $total - $subTotal;
            $descuento = 0;
            $usuario = auth()->user();
            $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
            $servicio = new ServicioModel();
            $servicio->ser_fk_cli = $cliente->cli_id;
            $servicio->ser_ubicacion_ini = DB::raw('POINT('.$request->lat_ini.', '.$request->lng_ini.')');
            $servicio->ser_ubicacion_fin = DB::raw('POINT('.$request->lat_fin.', '.$request->lng_fin.')');
            $servicio->ser_direccion_ini = $request->direccion_inicio;
            $servicio->ser_direccion_fin = $request->direccion_fin;
            $servicio->ser_distancia = round($valorDistancia);
            $servicio->ser_tiempo = round($valorTiempo);
            $servicio->ser_peajes = round($valorPeajes);
            $servicio->ser_seguro = $seguro;
            $servicio->ser_ganancia = $ganancia;
            $servicio->ser_subtotal = $subTotal;

            if($request->has("bono")){
                if(!empty($request->bono)){
                    $bono = BonoModel::where("bon_codigo","=",$request->bono)
                    ->where("bon_fecha_ini","<=", date("Y:m:d H:i:s"))
                    ->where("bon_fecha_fin",">=", date("Y:m:d H:i:s"))
                    ->where("bon_disponibles",">", "0")
                    ->where("bon_fk_est","=","1")
                    ->first();
                    if(isset($bono)){
                        if(isset($bono->bon_valor)){
                            $descuento = $bono->bon_valor;

                            $clienteBono = new ClienteBonoModel();
                            $clienteBono->clb_fk_cli_id = $cliente->cli_id;
                            $clienteBono->clb_fk_bon_id = $bono->bon_id;
                            $clienteBono->clb_fk_est = "11"; //TERMINADO
                            $clienteBono->save();
                            $servicio->ser_fk_bon = $bono->bon_id;
                            $bono->bon_disponibles = $bono->bon_disponibles - 1;
                            $bono->save();
                        }
                        else if(isset($bono->bon_porcentaje)){
                            $descuento = ($bono->bon_porcentaje/100)*$total;

                            $clienteBono = new ClienteBonoModel();
                            $clienteBono->clb_fk_cli_id = $cliente->cli_id;
                            $clienteBono->clb_fk_bon_id = $bono->bon_id;
                            $clienteBono->clb_fk_est = "11"; //TERMINADO
                            $clienteBono->save();
                            $servicio->ser_fk_bon = $bono->bon_id;
                            $bono->bon_disponibles = $bono->bon_disponibles - 1;
                            $bono->save();
                        }
                    }
                    else{
                        return response()->json([
                            "success" => false,
                            "mensaje" => "No se encontró ese bono o ya venció"
                        ],403);
                    }
                }
            }
            
            $total = $total - round($descuento,0);
            if($total < 0){
                $total = 0;
            }

            
            $servicio->ser_descuento = $descuento;
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
        $data = array("ser_id" => $servicio->ser_id);
        Funciones::sendPushTo("Servicio aceptado", "El servicio ha sido aceptado", $servicio->cliente->usuario->push_token, $data, "cliente");

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
        $data["ser_descuento"] = $servicio->ser_descuento;
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

        $data = array("ser_id" => $servicio->ser_id);

        if($request->est_id == 10){
            //PUSH: Enviar al cliente del servicio la notificacion de que el conductor ya llego            
            Funciones::sendPushTo("Conductor llegó", "El conductor ha llegado a tu ubicación", $servicio->cliente->usuario->push_token, $data, "cliente");
            
        }
        else if($request->est_id == 7){
            //PUSH: Enviar al cliente del servicio la notificacion de que el conductor ya empezo el viaje para cambiar la ventana del cliente
            Funciones::sendPushTo("Conductor inicio el viaje", "El conductor ha iniciado el viaje", $servicio->cliente->usuario->push_token, $data, "cliente");
        }
        else if($request->est_id == 11){
            //PUSH: Enviar al cliente del servicio la notificacion de que el servicio terminó
            Funciones::sendPushTo("Su viaje terminó", "Su viaje terminó", $servicio->cliente->usuario->push_token, $data, "cliente");
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
        $data = array("ser_id" => $servicio->ser_id);
        Funciones::sendPushTo("Servicio cancelado", "El cliente canceló el servicio", $servicio->conductor->usuario->push_token, $data, "conductor");
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
        return response()->json([
            "success" => true,
            "mensaje" => "Servicio calificado correctamente"            
        ],200);        
    }



    /**
     * Historial de servicios
     * Permite ver los servicios que han sido calificados por parte del cliente
     * 
	 * @group  v 1.0.5
     * 
     * 
     * @authenticated
     * 
	 */  
    public function historial(){
        $usuario = auth()->user();
        
        $cliente = ClienteModel::where("cli_fk_usr", "=",$usuario->id)->first();
        
        $servicios = ServicioModel::selectRaw("ST_X(ser_ubicacion_ini) as lat_ini, ST_Y(ser_ubicacion_ini) as lng_ini,
            ST_X(ser_ubicacion_fin) as lat_fin, ST_Y(ser_ubicacion_fin) as lng_fin, ST_AsText(ser_ruta_cotizada) as ruta,
            `ser_direccion_ini`, `ser_direccion_fin`, `ser_distancia`, `ser_tiempo`, `ser_peajes`, `ser_seguro`, 
            `ser_ganancia`, `ser_subtotal`, `ser_descuento`, `ser_valor_final`, `ser_calificacion`, `ser_opinion`,
            `est_name`, `ser_motivo_cancelacion`
        ")
        ->join("estado", "est_id", "=", "ser_fk_est")
        ->where("ser_fk_cli","=",$cliente->cli_id)
        ->whereIn("ser_fk_est",[13,12])->get();
        
        
        return response()->json([
            "success" => true,
            "data" => [
                "servicios" => $servicios
            ]  
        ],200);        
    }
    


    /**
     * buscar_conductor
     * Busca conductores y envia push segun la ubicacion de estos en un radio de 2,5,10 km a la redonda, si no aceptan envia push a cliente informando, se debe usar cada 5 mins para dar tiempo a los conductores de responder
     * 
	 * @group  v 1.0.6
     * 
     * 
     * 
	 */
    public function buscar_conductor(){
        $servicios = ServicioModel::selectRaw('ST_X(ser_ubicacion_ini) as lat_ini, ST_Y(ser_ubicacion_ini) as lng_ini,
        ser_busqueda_distancia_km, ser_fk_est, ser_id')
        ->where("ser_fk_est","=","8")->get();
        foreach ($servicios as $servicio){
            
            
            $sqlUbicacion = "ST_Contains(ST_Buffer(ST_GeomFromText('POINT(".$servicio->lat_ini." ".$servicio->lng_ini.")'), (360*".$servicio->ser_busqueda_distancia_km.")/40000), 
            veh_con_ubicacion)";

            $conductores_veh = VehiculoConductorModel::whereRaw($sqlUbicacion)
            ->where("fk_est_id","=","5")//CONECTADO
            ->get();

            
            foreach ($conductores_veh as $conductor_veh){
                $data = array("ser_id" => $servicio->ser_id);
                Funciones::sendPushTo("Nuevo servicio", "¿Deseas aceptar este servicio?", $conductor_veh->conductor->usuario->push_token, $data, "conductor");
                //PUSH a conductor
            }
            
            $servicioBD = ServicioModel::findOrFail($servicio->ser_id); 
            if($servicioBD->ser_busqueda_distancia_km == 2){
                $servicioBD->ser_busqueda_distancia_km = 5;
            }
            else if($servicioBD->ser_busqueda_distancia_km == 5){
                $servicioBD->ser_busqueda_distancia_km = 10;
            }
            else if($servicioBD->ser_busqueda_distancia_km == 10){
                //PUSH a cliente informando
                $data = array("ser_id" => $servicio->ser_id);
                Funciones::sendPushTo("Ningun Conductor encontrado", "Ningun conductor encontrado", $conductor_veh->cliente->usuario->push_token, $data, "cliente");
                $servicioBD->ser_fk_est = 15;
            }
            
            $servicioBD->save();
            
        }

        
    }

    /**
     * testPush
     * Probar Push de cliente y conductor
     * 
	 * @group  v 1.0.6
     * @bodyParam tipo Integer required 1 para conductor, 2 para cliente.
     * @bodyParam push_token String required Token de firebase.
     * 
     * 
     * 
	 */
    public function testPush(Request $request){
        //dd("hola");
        $type = "conductor";
        if($request->tipo == "2"){
            $type = "cliente";
        }

        $res = Funciones::sendPushArr("test", "cuerpo de prueba", array($request->push_token),
         array("data" => ["infoprueba" => 123, "msj" => "hola"]), $type);

        $res2 = Funciones::sendPushTo("test_to", "cuerpo de prueba to", $request->push_token,
         array("data" => ["infoprueba" => 123, "msj" => "hola"]), $type);

        return response()->json([
            "res" => $res,
            "res2" => $res2
        ]);
    }

    
}

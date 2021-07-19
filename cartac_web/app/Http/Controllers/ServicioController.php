<?php

namespace App\Http\Controllers;

use App\Models\ServicioModel;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $servicios = ServicioModel::all();
        //dd($servicios);
        return view('servicios/lista',[
            "servicios" => $servicios
        ]);
    }

    public function mostrarFormDetalle($id){

        $servicio = ServicioModel::selectRaw("*, 
                ST_X(ser_ubicacion_ini) as lat_ini, 
                ST_Y(ser_ubicacion_ini) as lng_ini,
                ST_X(ser_ubicacion_fin) as lat_fin, 
                ST_Y(ser_ubicacion_fin) as lng_fin,                
                ST_AsText(ser_ruta_cotizada) as ruta")
        ->where("ser_id","=",$id)
        ->first();
        
        
        $ruta = substr($servicio->ruta, 11);
        $ruta = substr($ruta, 0,-1);
       

        foreach ($servicio->peajes_servicio as $row => $peaje_servicio){
            $servicio->peajes_servicio[$row]->peaje = $peaje_servicio->peaje::selectRaw('*, ST_X(pea_ubic) as lat, ST_Y(pea_ubic) as lng')->first();
        }
        return view('servicios/ver_detalle',[
            "servicio" => $servicio,
            "ruta" => $ruta
        ]);
    }


    public function cancelar($id){

        $servicio = ServicioModel::findOrFail($id);
        $servicio->ser_fk_est = 12;
        $servicio->ser_motivo_cancelacion = "CANCELADO POR EL ADMINISTRADOR";
        $servicio->save();

        return redirect()->route('servicios.index')->with('mensaje', 'Servicio cancelado correctamente');
    }

}

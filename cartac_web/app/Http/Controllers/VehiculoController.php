<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarVehiculoRequest;
use App\Models\VehiculoModel;
use App\Models\DimensionTipoVehiculoModel;
use App\Models\DocumentacionModel;
use App\Models\VehiculoCategoriaModel;
use App\Models\VehiculoConductorModel;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    //Agrega vehiculos
    public function agregar(AgregarVehiculoRequest $request){  

        $dim_tip = DimensionTipoVehiculoModel::where("fk_dim",$request->dimension)->where("fk_tip", $request->tipo)->first();

        if(!isset($dim_tip)){
            $dim_tip = new DimensionTipoVehiculoModel();
            $dim_tip->fk_dim = $request->dimension;
            $dim_tip->fk_tip = $request->tipo;
            $dim_tip->save();
        }

        $vehiculo = new VehiculoModel();
        $foto = Funciones::imagenBase64($request->foto, "imgs/vehiculos/".time()."_vehiculo_".$request->documento.".png");
        $vehiculo->veh_foto = $foto;
        $vehiculo->veh_placa = $request->placa;
        $vehiculo->veh_fk_col = $request->color;
        $vehiculo->veh_fk_mar = $request->marca;
        $vehiculo->veh_fk_dim_tip = $dim_tip->id;
        $vehiculo->veh_fk_est = 2;
        $vehiculo->save();

        //Agregar categorias
        $categorias = explode(",",$request->categorias);
        foreach($categorias as $categoria){
            VehiculoCategoriaModel::insert([
                "fk_veh_id" => $vehiculo->veh_id,
                "fk_cat_id" => $categoria
            ]);
        }

        $vehiculo_conductor = new VehiculoConductorModel();
        $vehiculo_conductor->fk_veh_id = $vehiculo->veh_id;
        $vehiculo_conductor->fk_con_id = $request->con_id;
        $vehiculo_conductor->fk_est_id = 2;
        $vehiculo_conductor->save();

        $tarjeta_prop = Funciones::imagenBase64($request->tarjeta_prop, "imgs/documentacion/".time()."_tarjeta_prop.png");
        $documentacion_tarjeta_prop = new DocumentacionModel();
        $documentacion_tarjeta_prop->doc_ruta = $tarjeta_prop;
        $documentacion_tarjeta_prop->doc_fk_tdo = 8;
        $documentacion_tarjeta_prop->doc_fk_veh = $vehiculo->veh_id;
        $documentacion_tarjeta_prop->doc_fk_est = 2;
        $documentacion_tarjeta_prop->save();

        $soat = Funciones::imagenBase64($request->soat, "imgs/documentacion/".time()."_soat.png");
        $documentacion_soat = new DocumentacionModel();
        $documentacion_soat->doc_ruta = $soat;
        $documentacion_soat->doc_fk_tdo = 9;
        $documentacion_soat->doc_fk_veh = $vehiculo->veh_id;
        $documentacion_soat->doc_fk_est = 2;
        $documentacion_soat->save();

        $tecno = Funciones::imagenBase64($request->tecno, "imgs/documentacion/".time()."_tecno.png");
        $documentacion_tecno = new DocumentacionModel();
        $documentacion_tecno->doc_ruta = $tecno;
        $documentacion_tecno->doc_fk_tdo = 10;
        $documentacion_tecno->doc_fk_veh = $vehiculo->veh_id;
        $documentacion_tecno->doc_fk_est = 2;
        $documentacion_tecno->save();

        return response()->json([
            "success" => true,
            "data" => [
                "veh_id" => $vehiculo->veh_id,
                "veh_con" => $vehiculo_conductor->veh_con_id
            ]
        ]);
        

        //$grupoConcepto = GrupoConcepto::findOrFail($id);
        
    }
}

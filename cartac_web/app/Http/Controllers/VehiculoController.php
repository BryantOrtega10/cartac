<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgregarVehiculoRequest;
use App\Models\ConductorModel;
use App\Models\VehiculoModel;
use App\Models\DimensionTipoVehiculoModel;
use App\Models\DocumentacionModel;
use App\Models\PropietarioModel;
use App\Models\VehiculoCategoriaModel;
use App\Models\VehiculoConductorModel;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    //Agrega vehiculos
    public function agregar(AgregarVehiculoRequest $request){  

        $request->dimension = 1;
        $dim_tip = DimensionTipoVehiculoModel::where("fk_dim",$request->dimension)->where("fk_tip", $request->typeFk)->first();

        if(!isset($dim_tip)){
            $dim_tip = new DimensionTipoVehiculoModel();
            $dim_tip->fk_dim = $request->dimension;
            $dim_tip->fk_tip = $request->typeFk;
            $dim_tip->save();
        }

        
        $vehiculo = new VehiculoModel();
        $foto = Funciones::imagenBase64($request->image, "imgs/vehiculos/".time()."_vehiculo_".$request->documento.".png");
        $vehiculo->veh_foto = $foto;
        $vehiculo->veh_placa = $request->placa;
        $vehiculo->veh_fk_col = $request->fkCarColor;
        $vehiculo->veh_fk_mar = $request->fkCarBrand;
        $vehiculo->veh_fk_dim_tip = $dim_tip->id;
        $vehiculo->veh_fk_est = 2;
        if($request->has("id_owner")){
            $vehiculo->veh_fk_pro = $request->id_owner;
        }
        else{
            $conductor = ConductorModel::where("con_id", "=", $request->fkUserConductor)->first();
            $propietario = PropietarioModel::where("pro_documento","=",$conductor->documento)->first();
            if(isset($propietario)){
                $vehiculo->veh_fk_pro = $propietario->pro_id;
            }
        }
        $vehiculo->save();

        


        //Agregar categorias
        $categorias = explode(",",$request->subCategoryFk);
        foreach($categorias as $categoria){
            VehiculoCategoriaModel::insert([
                "fk_veh_id" => $vehiculo->veh_id,
                "fk_cat_id" => $categoria
            ]);
        }

        $vehiculo_conductor = VehiculoConductorModel::where("fk_con_id","=",$request->fkUserConductor)
                                                     ->whereIsNull("fk_veh_id")->first();
        if(!isset($vehiculo_conductor)){
            $vehiculo_conductor = new VehiculoConductorModel();
            $vehiculo_conductor->fk_con_id = $request->fkUserConductor;
            $vehiculo_conductor->fk_veh_id = null;
            $vehiculo_conductor->fk_est_id = 2;
            $vehiculo_conductor->save();
        }


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
                "sesionUsr" => [
                    "id_car" => $vehiculo->veh_id
                ]                
            ]
        ]);
        //$grupoConcepto = GrupoConcepto::findOrFail($id);        
    }
}

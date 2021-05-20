<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones;
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
    /**
     * Agregar vehiculos
     * 
	 * @group  v 1.0
     * 
     * @bodyParam dimension Integer required Id de la dimensión del vehiculo se obtiene en: api/dimension_vehiculo.
     * @bodyParam typeFk Integer required Id del tipo del vehiculo se obtiene en: api/tipo_vehiculo.
     * @bodyParam placa String required Placa del vehiculo (Formato recomendado AAA-000).
     * @bodyParam image String required Foto del vehiculo en base 64.
     * @bodyParam fkCarColor Integer required Id del color del vehiculo se obtiene en: api/color_vehiculo.     
     * @bodyParam fkCarBrand Integer required Id de la marca del vehiculo se obtiene en: api/marca_vehiculo.
     * @bodyParam veh_rendimiento String  Rendimiento del vehiculo por galón.
     * @bodyParam id_owner Integer  Id del propietario en caso de que no sea el conductor.
     * @bodyParam fkUserConductor Integer required Id del conductor.
     * @bodyParam subCategoryFk String required Categorias y sub-categorias separadas por comas.
     * @bodyParam tarjeta_prop String required Foto de la tarjeta de propiedad del vehiculo en base 64.
     * @bodyParam soat String required Foto del Soat del vehiculo en base 64.
     * @bodyParam tecno String required Foto de la tecnomecanica del vehiculo en base 64.
     * */
    public function agregar(AgregarVehiculoRequest $request){  

        $request->dimension = 1;
        $dim_tip = DimensionTipoVehiculoModel::where("fk_dim",$request->dimension)->where("fk_tip", $request->typeFk)->first();

        if(!isset($dim_tip)){
            $dim_tip = new DimensionTipoVehiculoModel();
            $dim_tip->fk_dim = $request->dimension;
            $dim_tip->fk_tip = $request->typeFk;
            $dim_tip->save();
        }

        $request->placa = str_replace('-',"",$request->placa);
        $request->placa = str_replace('_',"",$request->placa);
        $request->placa = str_replace(' ',"",$request->placa);


        $vehiculo = new VehiculoModel();
        $foto = Funciones::imagenBase64($request->image, "imgs/vehiculos/".time()."_vehiculo_".$request->placa.".png");
        $vehiculo->veh_foto = $foto;
        $vehiculo->veh_placa = $request->placa;
        $vehiculo->veh_fk_col = $request->fkCarColor;
        $vehiculo->veh_fk_mar = $request->fkCarBrand;
        $vehiculo->veh_fk_dim_tip = $dim_tip->id;
        if($request->has("veh_rendimiento")){
            $vehiculo->veh_rendimiento = $request->veh_rendimiento;
        }
        $vehiculo->veh_fk_est = 2;
        if($request->has("id_owner") && !empty($request->id_owner)){
            
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
                                                     ->whereNull("fk_veh_id")->first();
        if(!isset($vehiculo_conductor)){
            $vehiculo_conductor = new VehiculoConductorModel();
            $vehiculo_conductor->fk_con_id = $request->fkUserConductor;
        }
        $vehiculo_conductor->fk_veh_id = $vehiculo->veh_id;
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
                "sesionUsr" => [
                    "id_car" => $vehiculo->veh_id
                ]                
            ]
        ]);
        //$grupoConcepto = GrupoConcepto::findOrFail($id);        
    }
}

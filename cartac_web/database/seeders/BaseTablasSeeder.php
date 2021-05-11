<?php

namespace Database\Seeders;

use App\Models\CategoriaModel;
use App\Models\ColorVehiculoModel;
use App\Models\DimensionTipoVehiculoModel;
use App\Models\EstadoModel;
use App\Models\RolModel;
use App\Models\TipoDocumentacionModel;
use App\Models\TipoDocumentoModel;
use App\Models\TipoVehiculoModel;
use App\Models\DimensionVehiculoModel;
use App\Models\MarcaVehiculoModel;
use Illuminate\Database\Seeder;

class BaseTablasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVehiculoModel::insert([
            [
            'tip_name' => "CATEGORÍA 1",
            'tip_alias' => "Automóviles, camperos y camionetas"
            ],[
            'tip_name' => "CATEGORÍA 2",
            'tip_alias' => "Buses"
            ],[
            'tip_name' => "CATEGORÍA 3 y 4",
            'tip_alias' => "Camiones de dos ejes"
            ],[
            'tip_name' => "CATEGORÍA 5",
            'tip_alias' => "Camiones de tres y cuatro ejes"
            ],[
            'tip_name' => "CATEGORÍA 6",
            'tip_alias' => "Camiones de cinco ejes"
            ]
        ]);

        EstadoModel::insert([
            [
                'est_name' => 'ACTIVO',
                'est_clase' => 'activo',
            ],[
                'est_name' => 'POR APROBAR',
                'est_clase' => 'por_aprobar',
            ],[
                'est_name' => 'RECHAZADO',
                'est_clase' => 'rechazado',
            ]
        ]);
        
        TipoDocumentoModel::insert([
            [
                'tpd_nombre' => "Cédula de ciudadania"
            ]
        ]);

        RolModel::insert([
            [
                'rol_name' => "Conductor"
            ]
        ]);

        TipoDocumentacionModel::insert([
            [
                "tdo_name" => "Cedula frente conductor"
            ],[
                "tdo_name" => "Cedula respaldo conductor"
            ],[
                "tdo_name" => "Licencia de conducción"
            ],[
                "tdo_name" => "Certificación bancaria"
            ],[
                "tdo_name" => "Cedula frente propietario"
            ],[
                "tdo_name" => "Cedula respaldo propietario"
            ],[
                "tdo_name" => "Carta autorización propietario"
            ],[
                "tdo_name" => "Tarjeta propiedad vehiculo"
            ],[
                "tdo_name" => "SOAT vehiculo"
            ],[
                "tdo_name" => "Tecnomecanica vehiculo"
            ]
        ]);

        DimensionVehiculoModel::insert([
            [
                "dim_name" => "Grande"
            ],[
                "dim_name" => "Mediano"
            ],[            
                "dim_name" => "Pequeño"
            ]            
        ]);

        DimensionTipoVehiculoModel::insert([
            [
                "fk_dim" => "1",
                "fk_tip" => "1"
            ],[
                "fk_dim" => "1",
                "fk_tip" => "2"
            ],
        ]);

        CategoriaModel::insert([
            [
                "cat_name" => "Empresas y Negocios",
            ],
            [
                "cat_name" => "Hogar",
            ],
            [
                "cat_name" => "Alimentos",
            ],
            [
                "cat_name" => "Carga especial"
            ]            
        ]);
        
        CategoriaModel::insert([
            [
                "cat_name" => "Refrigerados",
                "cat_fk_cat" => "3"
            ],
            [
                "cat_name" => "Animales",
                "cat_fk_cat" => "3"
            ],
            [
                "cat_name" => "Frutas y Verduras",
                "cat_fk_cat" => "3"
            ],
            [
                "cat_name" => "Helados",
                "cat_fk_cat" => "3"
            ]
        ]);

        ColorVehiculoModel::insert([
            [
                "col_name" => "NEGRO"
            ],
            [
                "col_name" => "Azul"
            ]
        ]);

        MarcaVehiculoModel::insert([
            [
                "mar_name" => "Renault"
            ],[
                "mar_name" => "Mazda"
            ]
        ]);

    }
}

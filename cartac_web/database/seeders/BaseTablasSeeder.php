<?php

namespace Database\Seeders;

use App\Models\CategoriaModel;
use App\Models\CategoriaPeajeModel;
use App\Models\ColorVehiculoModel;
use App\Models\ConfiguracionModel;
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
        ConfiguracionModel::insert([
            [
                'cfg_distancia' => "10",
                'cfg_tiempo' => "20",
                'cfg_peso' => "50",
                'cfg_porcentaje_seguro' => "10.5",
                'cfg_porcentaje_ganancia' => "5"
            ]
        ]);
        CategoriaPeajeModel::insert([
            [
                'ctp_name' => "No aplica"
            ],
            [
                'ctp_name' => "CATEGORÍA 1"
            ],
            [
                'ctp_name' => "CATEGORÍA 2"
            ],
            [
                'ctp_name' => "CATEGORÍA 3"
            ],
            [
                'ctp_name' => "CATEGORÍA 4"
            ],
            [
                'ctp_name' => "CATEGORÍA 5"
            ],
            [
                'ctp_name' => "CATEGORÍA 6"
            ],
            [
                'ctp_name' => "CATEGORÍA 7"
            ]
        ]);

        TipoVehiculoModel::insert([
            [
                "tip_name" => "MOTOCARRO",
                "tip_fk_ctp" => "1"
            ], [
                "tip_name" => "CAMIONETA PLATON",
                "tip_fk_ctp" => "2"
            ], [
                "tip_name" => "VANS DE CARGA",
                "tip_fk_ctp" => "4"
            ], [
                "tip_name" => "REMOLQUE ABIERTO",
                "tip_fk_ctp" => "4"
            ], [
                "tip_name" => "FURGON",
                "tip_fk_ctp" => "5"
            ], [
                "tip_name" => "FURGON GRANDE TURBO",
                "tip_fk_ctp" => "5"
            ], [
                "tip_name" => "TRACTOCAMION 4 EJES",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "TRACTOCAMION 6 EJES",
                "tip_fk_ctp" => "8"
            ], [
                "tip_name" => "VOLQUETA",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "CAMION TRANS CONTAINER (PLANCHON CON UÑAS)",
                "tip_fk_ctp" => "8"
            ], [
                "tip_name" => "CAMION CISTERNA",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "CAMION FRIGORIFICO",
                "tip_fk_ctp" => "5"
            ], [
                "tip_name" => "CAMION PLANCHA",
                "tip_fk_ctp" => "5"
            ], [
                "tip_name" => "CAMION NINERA",
                "tip_fk_ctp" => "8"
            ], [
                "tip_name" => "CAMION GRUA",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "CAMION CAMA BAJA",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "CAMION CON ESTACAS",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "CAMION CON CARPA",
                "tip_fk_ctp" => "6"
            ], [
                "tip_name" => "GRUA PARA VEHICULO",
                "tip_fk_ctp" => "5"
            ], [
                "tip_name" => "GRUA PARA MOTO",
                "tip_fk_ctp" => "5"
            ]
        ]);



        EstadoModel::insert([
            [
                'est_name' => 'ACTIVO',
                'est_clase' => 'activo',
            ], [
                'est_name' => 'POR APROBAR',
                'est_clase' => 'por_aprobar',
            ], [
                'est_name' => 'RECHAZADO',
                'est_clase' => 'rechazado',
            ]
            , [
                'est_name' => 'ENVIADO',
                'est_clase' => 'enviado',
            ]
            , [
                'est_name' => 'CONECTADO',
                'est_clase' => 'conectado',
            ],[
                'est_name' => 'DESCONECTADO',
                'est_clase' => 'desconectado',
            ],[
                'est_name' => 'EN VIAJE',
                'est_clase' => 'en_viaje',
            ],[
                'est_name' => 'BUSCANDO CONDUCTOR',
                'est_clase' => 'buscando_conductor',
            ],[
                'est_name' => 'CONDUCTOR EN CAMINO',
                'est_clase' => 'conductor_en_camino',
            ],[
                'est_name' => 'CONDUCTOR ESPERANDO',
                'est_clase' => 'conductor_esperando',
            ],[
                'est_name' => 'TERMINADO',
                'est_clase' => 'terminado',
            ],[
                'est_name' => 'CANCELADO',
                'est_clase' => 'cancelado',
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
            ],
            [
                'rol_name' => "Cliente"
            ]
        ]);

        TipoDocumentacionModel::insert([
            [
                "tdo_name" => "Cedula frente conductor"
            ], [
                "tdo_name" => "Cedula respaldo conductor"
            ], [
                "tdo_name" => "Licencia de conducción"
            ], [
                "tdo_name" => "Certificación bancaria"
            ], [
                "tdo_name" => "Cedula frente propietario"
            ], [
                "tdo_name" => "Cedula respaldo propietario"
            ], [
                "tdo_name" => "Carta autorización propietario"
            ], [
                "tdo_name" => "Tarjeta propiedad vehiculo"
            ], [
                "tdo_name" => "SOAT vehiculo"
            ], [
                "tdo_name" => "Tecnomecanica vehiculo"
            ]
        ]);

        DimensionVehiculoModel::insert([
            [
                "dim_name" => "Grande"
            ], [
                "dim_name" => "Mediano"
            ], [
                "dim_name" => "Pequeño"
            ]
        ]);

        DimensionTipoVehiculoModel::insert([
            [
                "fk_dim" => "1",
                "fk_tip" => "1"
            ], [
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
            ["col_name" => "Negro"],
            ["col_name" => "Rojo"],
            ["col_name" => "Verde"],
            ["col_name" => "Morado"],
            ["col_name" => "Gris"],
            ["col_name" => "Gris plateado"],
            ["col_name" => "Plateado"],
            ["col_name" => "Azul"],
            ["col_name" => "Azul plateado"],
            ["col_name" => "Cafe"],
            ["col_name" => "Marron"],
            ["col_name" => "Lila"],
            ["col_name" => "amarillo"],
            ["col_name" => "Blanco"],
            ["col_name" => "Blanco abano"],
            ["col_name" => "Blanco Perla"],
            ["col_name" => "Dorado"],
            ["col_name" => "Naranja"]
        ]);

        MarcaVehiculoModel::insert([
            ["mar_name" => "Renault"],
            ["mar_name" => "Chevrolet"],
            ["mar_name" => "Mazda"],
            ["mar_name" => "Nissan"],
            ["mar_name" => "Kia"],
            ["mar_name" => "Toyota"],
            ["mar_name" => "Volkswagen"],
            ["mar_name" => "Suzuki"],
            ["mar_name" => "Toyota"],
            ["mar_name" => "Mercedes-Benz"],
            ["mar_name" => "Fiat"],
            ["mar_name" => "Dodge"],
            ["mar_name" => "Honda"],
            ["mar_name" => "Jeep"],
            ["mar_name" => "Mini"],
            ["mar_name" => "Peugeot"],
            ["mar_name" => "Skoda"]
        ]);
    }
}

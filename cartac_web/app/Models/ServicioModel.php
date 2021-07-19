<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioModel extends Model
{
    use HasFactory;

    protected $table = "servicio";

    protected $primaryKey = "ser_id";

    protected $fillable = [
        "ser_fk_cli",
        "ser_fk_con",
        "ser_fk_veh",
        "ser_ubicacion_ini",
        "ser_ubicacion_fin",
        "ser_ruta_cotizada",
        "ser_direccion_ini",
        "ser_direccion_fin",
        "ser_busqueda_distancia_km",
        "ser_distancia",
        "ser_tiempo",
        "ser_peajes",
        "ser_seguro",
        "ser_ganancia",
        "ser_subtotal",
        "ser_descuento",
        "ser_valor_final",
        "ser_calificacion",
        "ser_opinion",
        "ser_fk_bon",
        "ser_fk_cat",
        "ser_fk_dim",
        "ser_fk_tip",
        "ser_fk_cfm",
        "ser_fk_tpg",
        "ser_fk_clb",
        "ser_created_at",
        "ser_aceptado_at",
        "ser_motivo_cancelacion",
        "ser_fk_est"
    ];

    public $timestamps = false;    

    public function cliente()
    {
        return $this->belongsTo(ClienteModel::class, 'ser_fk_cli', 'cli_id');
    }
    public function conductor()
    {
        return $this->belongsTo(ConductorModel::class, 'ser_fk_con', 'con_id');
    }
    public function vehiculo()
    {
        return $this->belongsTo(VehiculoModel::class, 'ser_fk_veh', 'veh_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'ser_fk_est', 'est_id');
    } 

    public function peajes_servicio()
    {
        return $this->hasMany(PeajeServicioModel::class, 'pjs_fk_ser_id', 'ser_id');
    } 

    
}

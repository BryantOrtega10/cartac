<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoConductorModel extends Model
{
    use HasFactory;

    protected $table = "vehiculo_conductor";
    
    protected $primaryKey = "veh_con_id";

    protected $fillable = [
        "veh_con_ubicacion",
        "fk_veh_id",
        "fk_con_id",
        "fk_est_id"
    ];

    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(VehiculoModel::class, 'fk_veh_id', 'veh_id');
    }

    public function conductor()
    {
        return $this->belongsTo(ConductorModel::class, 'fk_con_id', 'con_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'fk_est_id', 'est_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionTipoVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "dimension_tipo_veh";

    protected $primaryKey = "id";

    protected $fillable = [
        "fk_dim",
        "fk_tip"
    ];

    public $timestamps = false;

    public function dimension()
    {
        return $this->belongsTo(DimensionModel::class, 'fk_dim', 'dim_id');
    }

    public function tipo_vehiculo()
    {
        return $this->belongsTo(TipoVehiculoModel::class, 'fk_tip', 'tip_id');
    }
    

}

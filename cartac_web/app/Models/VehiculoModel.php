<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoModel extends Model
{
    use HasFactory;

    protected $table = "vehiculo";
    
    protected $primaryKey = 'veh_id';

    protected $fillable = [
        'veh_placa',
        'veh_foto',
        'veh_fk_col',
        'veh_fk_mar',
        'veh_fk_dim_tip',
        'veh_fk_pro',
        'veh_created_at',
        'veh_updated_at',
        'veh_fk_est'
    ];

    public $timestamps = false;

    public function color()
    {
        return $this->belongsTo(ColorVehiculoModel::class, 'veh_fk_col', 'col_id');
    }

    public function marca()
    {
        return $this->belongsTo(MarcaVehiculoModel::class, 'veh_fk_mar', 'mar_id');
    }

    public function dimension_tipo_veh()
    {
        return $this->belongsTo(DimensionTipoVehiculoModel::class, 'veh_fk_dim_tip', 'id');
    }

    public function propietario()
    {
        return $this->belongsTo(PropietarioModel::class, 'veh_fk_pro', 'pro_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'veh_fk_est', 'est_id');
    }
}

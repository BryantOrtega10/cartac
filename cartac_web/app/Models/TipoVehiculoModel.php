<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "tipo_veh";
    
    protected $primaryKey = 'tip_id';

    protected $fillable = [
        "tip_name",
        "tip_foto",
        "tip_alquiler",
        "tip_combustible",
        "tip_rendimiento",
        "tip_tiempo_cargue",
        "tip_fk_ctp"
    ];

    

    public $timestamps = false;

    public function categoria_peaje()
    {
        return $this->belongsTo(CategoriaPeajeModel::class, 'tip_fk_ctp', 'ctp_id');
    }
}

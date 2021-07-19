<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoModel extends Model
{
    use HasFactory;

    protected $table = "bono";

    protected $primaryKey = "bon_id";
    
    protected $fillable = [
        "bon_codigo",
        "bon_fecha_ini",
        "bon_fecha_fin",
        "bon_valor",
        "bon_porcentaje",
        "bon_disponibles",
        "bon_fk_est"
    ];

    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'bon_fk_est', 'est_id');
    }
}

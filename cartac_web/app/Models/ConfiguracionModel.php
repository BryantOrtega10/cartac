<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionModel extends Model
{
    use HasFactory;

    protected $table = "configuracion";

    protected $primaryKey = "cfg_id";

    protected $fillable = [
        "cfg_distancia",
        "cfg_tiempo",
        "cfg_peso",
        "cfg_porcentaje_seguro",
        "cfg_porcentaje_ganancia"
    ];    
    public $timestamps = false;
}

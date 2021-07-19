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
        "cfg_hora_hombre",
        "cfg_gasolina",
        "cfg_gas",
        "cfg_acpm",
        "cfg_porcentaje_seguro",
        "cfg_porcentaje_ganancia"
    ];    
    public $timestamps = false;
}

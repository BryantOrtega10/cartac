<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeajeServicioModel extends Model
{
    use HasFactory;

    protected $table = "peaje_servicio";

    protected $primaryKey = "pjs_id";

    protected $fillable = [
        "pjs_valor_cobrado",
        "pjs_fk_pea_id",
        "pjs_fk_ser_id"
    ];

    public $timestamps = false;

    	
    
}

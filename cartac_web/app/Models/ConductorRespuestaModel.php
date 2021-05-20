<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorRespuestaModel extends Model
{
    use HasFactory;

    protected $table = "conductor_respuesta";

    protected $primaryKey = "cnr_id";

    protected $fillable = [
        "cnr_campos",
        "cnr_mensaje",
        "cnr_fk_est"
    ];

    public $timestamps = false;
}

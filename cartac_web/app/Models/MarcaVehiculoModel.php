<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarcaVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "marca_veh";

    protected $primaryKey = "mar_id";

    protected $fillable = [
        "mar_name"
    ];

    public $timestamps = false;
}

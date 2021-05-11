<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensionVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "dimension_veh";

    protected $primaryKey = "dim_id";

    protected $fillable = [
        "dim_name"
    ];

    public $timestamps = false;
}

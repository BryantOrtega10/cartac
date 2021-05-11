<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "color_veh";

    protected $primaryKey = "col_id";

    protected $fillable = [
        "col_name"
    ];

    public $timestamps = false;
}

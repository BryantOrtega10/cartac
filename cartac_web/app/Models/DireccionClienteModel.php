<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionClienteModel extends Model
{
    use HasFactory;

    protected $table = "direccion";

    protected $primaryKey = "dir_id";

    protected $fillable = [
        "dir_direccion",
        "dir_ubicacion",
        "dir_fk_cli"
    ];

    public $timestamps = false;

}

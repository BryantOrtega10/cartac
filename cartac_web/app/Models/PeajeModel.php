<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeajeModel extends Model
{
    use HasFactory;

    protected $table = "peaje";

    protected $primaryKey = "pea_id";

    protected $fillable = [
        "pea_nombre",
        "pea_ubic",
        "pea_ini",
        "pea_fin",
        "pea_radio"
    ];
    
    public $timestamps = false;
}

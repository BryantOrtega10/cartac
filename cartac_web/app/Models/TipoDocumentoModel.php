<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoModel extends Model
{
    use HasFactory;

    protected $table = "tipo_documento";

    protected $primaryKey = "tpd_id";

    protected $fillable = [
        "tpd_nombre"
    ];

    public $timestamps = false;
}

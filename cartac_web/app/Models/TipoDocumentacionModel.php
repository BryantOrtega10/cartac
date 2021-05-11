<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentacionModel extends Model
{
    use HasFactory;

    protected $table = "tipo_documentacion";

    protected $primaryKey = "tdo_id";

    protected $fillable = [
        "tdo_name"
    ];

    public $timestamps = false;
}

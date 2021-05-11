<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropietarioModel extends Model
{
    use HasFactory;

    protected $table = "propietario";

    protected $primaryKey = "pro_id";

    protected $fillable = [
        "pro_documento",
        "pro_nombres",
        "pro_apellidos",
        "pro_email",
        "pro_fk_tpd"
    ];

    public $timestamps = false;

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumentoModel::class, 'pro_fk_tpd', 'tpd_id');
    }

}

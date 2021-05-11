<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentacionModel extends Model
{
    use HasFactory;

    protected $table = "documentacion";

    protected $primaryKey = "doc_id";

    protected $fillable = [
        "doc_ruta",
        "doc_fk_tdo",
        "doc_fk_veh",
        "doc_fk_con",
        "doc_fk_veh_con",
        "doc_fk_est"
    ];
	
    public $timestamps = false;

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'doc_fk_est', 'est_id');
    }

    public function tipo_documentacion()
    {
        return $this->belongsTo(TipoDocumentacionModel::class, 'doc_fk_tdo', 'tdo_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(VehiculoModel::class, 'doc_fk_veh', 'veh_id');
    }

    public function conductor()
    {
        return $this->belongsTo(ConductorModel::class, 'doc_fk_con', 'con_id');
    }

    public function vehiculo_conductor()
    {
        return $this->belongsTo(VehiculoConductorModel::class, 'doc_fk_veh_con', 'veh_con_id');
    }
}

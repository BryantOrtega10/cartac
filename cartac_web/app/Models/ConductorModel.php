<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorModel extends Model
{
    use HasFactory;

    protected $table = "conductor";
    protected $primaryKey = 'con_id';
    protected $fillable = [
        'con_documento',
        'con_nombres',
        'con_apellidos',
        'con_email',
        'con_celular',
        'con_direccion',
        'con_foto',
        'con_fk_tpd',
        'con_fk_usr',
        'con_fk_est',
        'con_billetera',
        'con_numero_billetera'
    ];
    

    public $timestamps = false;

    

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumentoModel::class, 'con_fk_tpd', 'tpd_id');
    }
    
    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'con_fk_usr', 'usr_id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'con_fk_est', 'est_id');
    }
}

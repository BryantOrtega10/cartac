<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVehiculoModel extends Model
{
    use HasFactory;

    protected $table = "tipo_veh";
    
    protected $primaryKey = 'tip_id';

    protected $fillable = [
        'tip_name',
        'tip_alias'
    ];

    public $timestamps = false;
}

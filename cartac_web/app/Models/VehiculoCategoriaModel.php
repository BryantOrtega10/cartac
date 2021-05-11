<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculoCategoriaModel extends Model
{
    use HasFactory;

    protected $table = "vehiculo_categoria";

    protected $fillable = [
        "fk_veh_id",
        "fk_cat_id"
    ];

    public $timestamps = false;

    public function vehiculo()
    {
        return $this->belongsTo(VehiculoModel::class, 'fk_veh_id', 'veh_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'fk_cat_id', 'cat_id');
    }
    
}

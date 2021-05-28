<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiplicadorModel extends Model
{
    use HasFactory;

    protected $table = "config_multiplicador";

    protected $primaryKey = "cfm_id";    

    protected $fillable = [
        "cfm_hora_inicio",
        "cfm_hora_fin",
        "cfm_multiplicador",
        "cfm_fk_cfg"
    ];    
    
    public $timestamps = false;
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeajeCatPeajeModel extends Model
{
    use HasFactory;

    protected $table = "peaje_categoria_peaje";

    protected $primaryKey = "pcp_id";

    protected $fillable = [
        "pcp_valor",
        "pcp_fk_ctp",
        "pcp_fk_pea"
    ];
    
    public $timestamps = false;
}

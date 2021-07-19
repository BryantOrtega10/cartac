<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteBonoModel extends Model
{
    use HasFactory;

    protected $table = "cliente_bono";

    protected $primaryKey = "clb_id";
    
    protected $fillable = [
        "clb_fk_cli_id",
        "clb_fk_bon_id",
        "clb_usado",
        "clb_fk_est"
    ];

    public $timestamps = false;
}

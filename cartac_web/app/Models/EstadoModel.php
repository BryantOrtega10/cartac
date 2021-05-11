<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoModel extends Model
{
    use HasFactory;

    protected $table = "estado";

    protected $primaryKey = "est_id";

    protected $fillable = [
        "est_name",
        "est_clase"
    ];

    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    use HasFactory;

    protected $table = "categoria";

    protected $primaryKey = "cat_id";

    protected $fillable = [
        "cat_name",
        "cat_icono",
        "cat_fk_cat"
    ];

    public $timestamps = false;
}

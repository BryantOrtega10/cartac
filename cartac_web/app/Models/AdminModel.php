<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    protected $table = "admin";

    protected $primaryKey = "adm_id";

    protected $fillable = [
        "adm_nombre",
        "adm_foto",
        "adm_fk_usr"
    ];

    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(User::class, 'adm_fk_usr', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteModel extends Model
{
    use HasFactory;
    protected $table = "cliente";
    protected $primaryKey = 'cli_id';
    protected $fillable = [
        'cli_nombres',
        'cli_apellidos',
        'cli_email',
        'cli_foto',
        'cli_red',
        'cli_id_red',
        'cli_fk_usr',
    ];
    

    public $timestamps = false;    

    public function usuario()
    {
        return $this->belongsTo(User::class, 'cli_fk_usr', 'id');
    }

}

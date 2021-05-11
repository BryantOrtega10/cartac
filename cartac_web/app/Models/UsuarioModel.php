<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioModel extends Model
{
    use HasFactory;
    protected $table = "usuario";
    protected $primaryKey = 'usr_id';
    
    protected $fillable = [
        'usr_email',
        'usr_password',
        'usr_remember_token',
        'usr_token',
        'usr_created_at',
        'usr_updated_at',
        'usr_fk_rol	'
    ];
    

    public $timestamps = false;

    public function rol()
    {
        return $this->belongsTo(RolModel::class, 'usr_fk_rol', 'rol_id');
    }

    public function SetPasswordAttribute($value){
        $this->attributes['usr_password'] = bcrypt($value);
    }
}
<?php

namespace Database\Seeders;

use App\Models\RolModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $rol = new RolModel();
        $rol->rol_name = "Super Administrador";
        $rol->save();

        $usuario = new User();
        $usuario->password = Hash::make('1900');
        $usuario->name = "Administrador CARTAC";
        $usuario->email = "bryant@mdccolombia.com";
        $usuario->fk_rol = $rol->rol_id;
        $usuario->save();

        

    }
}

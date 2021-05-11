<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Funciones extends Controller
{
    public static function imagenBase64($base64_string, $output_file){
        $base64_string = str_replace('data:image/png;base64,', '', $base64_string);
        $base64_string = str_replace(' ', '+', $base64_string);
        Storage::disk('local')->put($output_file, base64_decode($base64_string));
        return $output_file;
    }
}

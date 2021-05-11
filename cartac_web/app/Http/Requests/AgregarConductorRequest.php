<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarConductorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'documento' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|unique:usuario,usr_email',
            'direccion' => 'required',
            'foto' => 'required',
            'password' => 'required',
            'cedula_f' => 'required',
            'cedula_r' => 'required',
            'licencia_c' => 'required',
            'esPropietario' => 'required'            
        ];
    }
   
}

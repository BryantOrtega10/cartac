<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarPropietarioRequest extends FormRequest
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
            'cedula' => 'required',
            'name' => 'required',
            //'apellidos' => 'required',
            'email' => 'required',
            'fk_user_conductor' => 'required',
            'cedula_f' => 'required',
            'cedula_r' => 'required',
            'carta_auto' => 'required',
        ];
    }
}

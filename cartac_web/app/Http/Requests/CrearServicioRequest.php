<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearServicioRequest extends FormRequest
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
            "lat_ini" => 'required',
            "lng_ini" => 'required',
            "lat_fin" => 'required',
            "lng_fin" => 'required',
            "direccion_inicio" => 'required',
            "direccion_fin" => 'required',
            "tipo_veh" => 'required',
            "dimension" => 'required',
            "categoria" => 'required'
        ];
    }
}

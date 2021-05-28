<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfiguracionRequest extends FormRequest
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
            'distancia' => 'required|numeric|min:0',
            'tiempo' => 'required|numeric|min:0',
            'peso' => 'required|numeric|min:0',
            'porcentaje_seguro' => 'required|numeric|min:0'
        ];
    }
}

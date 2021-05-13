<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarVehiculoRequest extends FormRequest
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
            'placa' => 'required',
            'fkCarColor' => 'required',
            'fkCarBrand' => 'required',
            //'dimension' => 'required',
            'typeFk' => 'required',
            'image' => 'required',
            'fkUserConductor' => 'required',
            'tarjeta_prop' => 'required',
            'soat' => 'required',
            'tecno' => 'required',
            'subCategoryFk' => 'required'
        ];
    }
}

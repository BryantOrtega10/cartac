<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeajeRequest extends FormRequest
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
        $nombreRule = ['required'];
        if($this->route('id') !== null){
            array_push($nombreRule, Rule::unique('peaje','pea_nombre')->ignore($this->route('id'), 'pea_id'));
        }
        else{
            array_push($nombreRule, Rule::unique('peaje','pea_nombre'));
        }

        return [
            'nombre' => $nombreRule,
            'lat' => 'required',
            'lng' => 'required',
            'cat_2' => 'required',
            'cat_3' => 'required',
            'cat_4' => 'required',
            'cat_5' => 'required',
            'cat_6' => 'required',
            'cat_7' => 'required',
            'cat_8' => 'required'            
        ];
    }
}

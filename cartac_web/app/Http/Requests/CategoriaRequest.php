<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            array_push($nombreRule, Rule::unique('categoria','cat_name')->ignore($this->route('id'), 'cat_id'));
        }
        else{
            array_push($nombreRule, Rule::unique('categoria','cat_name'));
        }

        return [
            'nombre' => $nombreRule
        ];
    }
}

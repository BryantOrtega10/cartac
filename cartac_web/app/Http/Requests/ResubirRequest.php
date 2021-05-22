<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResubirRequest extends FormRequest
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
        $con_email = ['nullable', Rule::unique('users','email')->ignore($this->route('id'), 'id')];
        $con_documento = ['nullable', Rule::unique('conductor','con_documento')->ignore($this->route('id'), 'id')];
        
        return [
            'con_email' => $con_email
        ];
    }
}

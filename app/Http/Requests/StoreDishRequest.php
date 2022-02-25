<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
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
            'name' => 'required',
            'tipo' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debes ingresar el nombre del Sorteo',
            'tipo.required' => 'Seleccione uno de los tipos',
        ];
    }
}

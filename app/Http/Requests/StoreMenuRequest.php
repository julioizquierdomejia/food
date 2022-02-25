<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'image' => 'required',
            'date' => 'required',
            'cant' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'description' => 'required',
            'type' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Debes ingresar el nombre del Sorteo',
            'image.required' => 'Seleccione una imagen',
            'date.required' => 'Seleccione una fecha',
            'cant.required' => 'Seleccione una cantidad',
            'cost.required' => 'Seleccione un costo',
            'price.required' => 'Seleccione un precio',
            'description.required' => 'Escriba una Descripción',
            'type.required' => 'Seleccione uno de los tipos',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRaffleRequest extends FormRequest
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
            'ofertas_array' => 'required',
            'description' => 'required',
            'goal' => 'required',
            'prize' => 'required',
            'start_date'  => 'required|date',
            'income_limit' => 'required|date|after:start_date',
            'end_date' => 'required|date|after:income_limit',
        ];
    }

    public function messages()
    {
        return [
            'ofertas_array.required' => 'Debe elegir al menos una oferta',
            'name.required' => 'Debes ingresar el nombre del Sorteo',
            'image.required' => 'Seleccione una Imagen para el Sorteo',

            'prize.required' => 'Debe ingresar el premio',
            'goal.required' => 'Debe ingresa La meta',

            'description.required' => 'La descripción es obligatoria',
            'start_date.required' => 'Indique una fecha de Inicio del sorteo',
            'income_limit.required' => 'Indique una fecha Límite del sorteo',
            'end_date.required' => 'Indique una fecha Final del sorteo',

            'income_limit.after' => 'Elegir fecha posterior a la fecha de inicio',
            'end_date.after' => 'Elegir fecha posterior a la fecha de Límite',
        ];
    }

}

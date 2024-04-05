<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpHeaterRequest extends FormRequest
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
            'nozzle_set' => ['required','numeric'],
            'front_set' => ['required','numeric'],
            'mid_set' => ['required','numeric'],
            'rear_set' => ['required','numeric'],
            'nozzle_actual' => ['required','numeric'],
            'front_actual' => ['required','numeric'],
            'mid_actual' => ['required','numeric'],
            'rear_actual' => ['required','numeric'],
        ];
    }
}

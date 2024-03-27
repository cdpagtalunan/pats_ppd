<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MachineParameterRequest extends FormRequest
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
            'machine_id' => 'required',
            'is_accumulator' => 'required',
            'device_name' => 'required',
            'no_of_cavity' => ['required','integer'],
            'material_mixing_ratio_v' => 'required',
            'material_mixing_ratio_r' => 'required',
            'material_name' => 'required',
            'color' => 'required',
            'dryer_used' => 'required',
            'machine_no' => 'required',
            'shot_weight' => 'required',
            'unit_weight' => 'required',
        ];
    }
}

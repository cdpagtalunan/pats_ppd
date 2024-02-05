<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstMoldingStationRequest extends FormRequest
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
            'first_molding_id' => 'required',
            'station' => 'required',
            'date' => 'required',
            'operator_name' => 'required',
            'input' => 'required',
            'ng_qty' => 'required',
            'output' => 'required',
        ];
    }
}

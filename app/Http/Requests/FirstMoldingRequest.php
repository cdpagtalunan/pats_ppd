<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FirstMoldingRequest extends FormRequest
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
            'first_molding_device_id'=>'required',
            'contact_lot_number'=>'required',
            'production_lot'=>'required',
            'contact_name'=>'required',
        ];
    }
}

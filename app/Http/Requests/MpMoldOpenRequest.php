<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpMoldOpenRequest extends FormRequest
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
            'open_end_v' => ['required','numeric'],
            'hi_velocity_2_percent' => ['required','numeric'],
            'hi_velocity_1_percent' => ['required','numeric'],
            'open_v' => ['required','numeric'],
            'mold_rotation' => ['required','numeric'],
            'open_stop' => ['required','numeric'],
            'low_distance' => ['required','numeric'],
            'hi_velocity_1mm' => ['required','numeric'],
            'hi_velocity_2mm' => ['required','numeric'],
        ];
    }
}

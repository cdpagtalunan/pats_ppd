<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpSetupRequest extends FormRequest
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
            'setup_close_v' => ['required','numeric'],
            'setup_close_p' => ['required','numeric'],
            'setup_open_v' => ['required','numeric'],
            'setup_rot_v' => ['required','numeric'],
            'setup_ejt_v' => ['required','numeric'],
            'setup_ejt_p' => ['required','numeric'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpMoldCloseRequest extends FormRequest
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
            'hi_v' => ['required','numeric'],
            'mid_slow' => ['required','numeric'],
            'low_v' => ['required','numeric'],
            'close_monitor_tm' => ['required','numeric'],
            'slow_start' => ['required','numeric'],
            'slow_end' => ['required','numeric'],
            'lvlp' => ['required','numeric'],
            'hpcl' => ['required','numeric'],
            'mid_sl_p' => ['required','numeric'],
            'low_p' => ['required','numeric'],
            'hi_p' => ['required','numeric'],
        ];
    }
}

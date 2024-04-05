<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpSupportRequest extends FormRequest
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
            'noz_bwd_tm_1' => ['required','numeric'],
            'inj_st_tmg_1' => ['required','numeric'],
            'noz_bwd_tmg_2' => ['required','numeric'],
            'inj_st_tmg_2' => ['required','numeric'],
            'support_tempo' => ['required'],
        ];
    }
}

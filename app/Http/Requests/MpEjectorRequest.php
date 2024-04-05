<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpEjectorRequest extends FormRequest
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
            "pattern" => ['required','numeric'],
            "ej_pres" => ['required','numeric'],
            "fwd_ev1" => ['required','numeric'],
            "fwd_ev2" => ['required','numeric'],
            "stop_tm" => ['required','numeric'],
            "count" => ['required','numeric'],
            "ejt_tmg" => ['required','numeric'],
            "ev2_chg" => ['required','numeric'],
            "fwd_stop" => ['required','numeric'],
            "bwd_ev4" => ['required','numeric'],
            "bwd_prs" => ['required','numeric'],
            "repeat_bwd_stop" => ['required','numeric'],
            "repeat_ejt_ev3" => ['required','numeric'],
            "repeat_fwd_stop" => ['required','numeric'],
        ];
    }
}

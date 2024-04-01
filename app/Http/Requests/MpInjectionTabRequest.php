<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpInjectionTabRequest extends FormRequest
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
            'inj_tab_plastic_time' => ['required','numeric'],
            'inj_tab_fill_time' => ['required','numeric'],
            'inj_tab_cycle_time' => ['required','numeric'],
            'inj_tab_spray_type' => ['required'],
            'inj_tab_spray' => ['required','numeric'],
            'inj_tab_spray_mode' => ['required'],
            'inj_tab_spray_side' => ['required'],
            'inj_tab_spray_tm' => ['required','numeric'],
            'inj_tab_screw_most_fwd' => ['required','numeric'],
            'inj_tab_enj_end_pos' => ['required','numeric'],
            'inj_tab_airblow_start_time' => ['required','numeric'],
            'inj_tab_airblow_blow_time' => ['required','numeric'],
            'inj_tab_ccd' => ['required'],
            'inj_tab_esc' => ['required'],
            'inj_tab_punch' => ['required'],
            'inj_tab_spray_portion' => ['required'],
            'inj_tab_punch_applcn' => ['required','numeric'],
            'inj_tab_md_temp_requirement' => ['required','numeric'],
            'inj_tab_md_time_requirement' => ['required','numeric'],
            'inj_tab_md_temp_actual' => ['required','numeric'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpInjectionTabListRequest extends FormRequest
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
            'inj_tab_list_mo_day'    => ['required'],
            // 'inj_tab_list_operator_name'  => ['required'],
            'inj_tab_list_shot_count'    => ['required'],
            'inj_tab_list_mat_time_in'   => ['required'],
            'inj_tab_list_prond_time_start'  => ['required'],
            'inj_tab_list_prond_time_end'    => ['required'],
            'inj_tab_list_mat_lot_num_virgin'    => ['required'],
            'inj_tab_list_mat_lot_num_recycle'   => ['required'],
            'inj_tab_list_total_mat_dring_time'  => ['required'],
            'inj_tab_list_remarks'   => ['required'],
        ];
    }
}

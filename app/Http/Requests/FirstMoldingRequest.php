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
            'contact_lot_qty'=>'required',
            'production_lot'=>'required',
            'production_lot_extension'=>'required',
            // 'contact_name'=>'required',
            'shift'=>'required',
            'revision_no'=>'required',
            'drawing_no'=>'required',
            'machine_no'=>'required',
            'dieset_no'=>'required',
            'target_shots'=>'required',
            'adjustment_shots'=>'required',
            'qc_samples'=>'required',
            'pmi_po_no'=>'required',
            'prod_samples'=>'required',
            "po_no" => 'required',
            // "ng_count" => 'required',
            "item_code" => 'required',
            "total_machine_output" => 'required',
            "item_name" => 'required',
            // "shipment_output" => 'required',
            "po_qty" => 'required',
            // "material_yield" =>'required',
            "required_output" => 'required',
            // "recycle_material" => 'required',
            // "po_target" => 'required',
            // "po_balance" => 'required',
        ];
    }
}

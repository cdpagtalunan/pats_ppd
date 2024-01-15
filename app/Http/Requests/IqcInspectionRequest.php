<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IqcInspectionRequest extends FormRequest
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
        /**{
            "whs_trasaction_id": "19928",
            "iqc_inspection_id": null,
            "invoice_no": "0092449618",
            "partcode": "108032201",
            "partname": "CN171S-05#ME-VE",
            "supplier": "YEC",
            "family": "2",
            "app_no": "PPS-2401-",
            "die_no": "4",
            "total_lot_qty": "321",
            "iqc_inspection_id": "",
            "type_of_inspection": "3",
            "severity_of_inspection": "2",
            "inspection_lvl": "3",
            "aql": "0.04",
            "accept": "1",
            "reject": "0",
            "date_inspected": "2024-01-10",
            "shift": "2",
            "time_ins_from": "15:08",
            "time_ins_to": "15:08",
            "inspector": "mclegaspi",
            "submission": "2",
            "category": "1",
            "target_lar": "1.19",
            "target_dppm": "1.19",
            "remarks": "dsa",
            "lot_inspected": "1",
            "accepted": "1",
            "sampling_size": "50",
            "no_of_defects": "21",
            "judgement": "1"
        }
        */
        // 'iqc_inspection_id'=>'required',
        // 'no_of_defects'=>'required',
        // 'remarks'=>'required',

        return [
            'whs_transaction_id'=>'required',
            'invoice_no'=>'required',
            'partcode'=>'required',
            'partname'=>'required',
            'supplier'=>'required',
            'family'=>'required',
            'app_no'=>'required',
            'app_no_extension'=>'required',
            'die_no'=>'required',
            'total_lot_qty'=>'required',
            'type_of_inspection'=>'required',
            'severity_of_inspection'=>'required',
            'inspection_lvl'=>'required',
            'aql'=>'required',
            'accept'=>'required',
            'reject'=>'required',
            'shift'=>'required',
            'date_inspected'=>'required',
            'time_ins_from'=>'required',
            'time_ins_to'=>'required',
            'inspector'=>'required',
            'submission'=>'required',
            'category'=>'required',
            'target_lar'=>'required',
            'target_dppm'=>'required',
            'sampling_size'=>'required',
            'lot_inspected'=>'required',
            'accepted'=>'required',
            'judgement'=>'required',
        ];
        /*
    "invoice_no": "14662",
    "partcode": "105959201",
    "partname": "Duranex 3316 PLTG71834 SC BLUE",
    "supplier": "MORIMURA",
    "family": "1",
    "app_no": "PPS-2401-",
    "die_no": "2",
    "total_lot_qty": "200.00",
    "type_of_inspection": "2",
    "severity_of_inspection": "2",
    "inspection_lvl": "1",
    "aql": "1",
    "accept": "1",
    "reject": "0",
    "shift": "1",
    "time_ins_from": "18:55",
    "time_ins_to": "18:54",
    "inspector": "mclegaspi",
    "submission": "1",
    "category": "1",
    "target_lar": "1.19",
    "target_dppm": "1.19",
    "sampling_size": "3",
    "lot_inspected": "1",
    "accepted": "2",
    "judgement": "1"

        */
    }
}

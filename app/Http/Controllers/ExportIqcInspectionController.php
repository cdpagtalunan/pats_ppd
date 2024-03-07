<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\IqcInspection;
use App\Exports\ExportIqcInspectionData;

class ExportIqcInspectionController extends Controller
{
    public function exportIqcInspection($materialName,$processType,$from,$to){
        date_default_timezone_set('Asia/Manila');

        if($processType == 1){
            $where = 'whs_transaction_id';
            $stamping = 'First Stamping';
        }else{
            $where = 'receiving_detail_id';
            $stamping = 'Second Stamping';
        }

        $search_material_name = IqcInspection::with(['iqc_inspection_mods_info', 'iqc_inspection_level_info', 'user_iqc'])
        ->where('partname', $materialName)
        ->where($where, '!=', 0)
        ->whereDate('created_at','>=',$from)
        ->whereDate('created_at','<=',$to)
        ->whereNull('deleted_at')
        // ->orWhereBetween('created_at', ['like', '%' . $from, $to . '%'])
        ->get();
        // return $search_material_name;
        if(count($search_material_name) > 0){
            return Excel::download(new ExportIqcInspectionData($search_material_name,$stamping), $stamping.' IQC Inspection Report.xlsx');
        }else{
            return redirect()->back()->with('message', 'There are no data for the chosen date.');
        }
    }

    public function searchIqcInspectionMaterialName(Request $request){
        $get_iqc_inspection_material_name = IqcInspection::whereNull('deleted_at')->distinct()->get('partname');
        
        return response()->json(['getIqcInspectionMaterialName' => $get_iqc_inspection_material_name]);
    }
}

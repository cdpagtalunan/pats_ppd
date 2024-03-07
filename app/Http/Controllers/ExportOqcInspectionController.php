<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\OQCInspection;
use App\Exports\ExportOqcInspectionData;

class ExportOqcInspectionController extends Controller
{
    public function exportOqcInspection($po,$processType,$from,$to){
        date_default_timezone_set('Asia/Manila');

        $search_po = OQCInspection::with([
            'oqc_inspection_aql_info',
            'oqc_inspection_type_info',
            'oqc_inspection_level_info',
            'stamping_production_info.user',
            'oqc_inspection_severity_inspection_info',
            'mod_oqc_inspection_details.oqc_info_mod_info'
        ])
        ->where('po_no', $po)
        ->where('status', $processType)
        ->where('logdel', 0)
        ->whereDate('created_at','>=',$from)
        ->whereDate('created_at','<=',$to)
        // ->orWhereBetween('created_at', ['like', '%' . $from, $to . '%'])
        ->get();
        // return $search_po;
        if(count($search_po) > 0){
            if($processType == 1){
                $stamping = 'First Stamping';
            }else{
                $stamping = 'Second Stamping';
            }
            return Excel::download(new ExportOqcInspectionData($search_po,$stamping), $stamping.' OQC Inspection Report.xlsx');
        }else{
            return redirect()->back()->with('message', 'There are no data for the chosen date.');
        }
    }

    public function searchOqcInspectionPoNo(Request $request){
        $get_oqc_inspection_po_no = OQCInspection::where('logdel', 0)->distinct()->get('po_no');
        
        return response()->json(['getOqcInspectionPoNo' => $get_oqc_inspection_po_no]);
    }
}

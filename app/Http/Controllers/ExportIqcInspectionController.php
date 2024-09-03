<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\IqcInspection;
use App\Exports\ExportIqcInspectionData;

class ExportIqcInspectionController extends Controller
{
    public function exportIqcInspection($request){
        date_default_timezone_set('Asia/Manila');
        $arr_data = explode('+',$request);
        $arr_download_data = [
            'materialName'=>urldecode($arr_data[0]), //NOTE: URL Decode from request data
            'processType'=>$arr_data[1],
            'from'=>$arr_data[2],
            'to'=>$arr_data[3],
        ];
        $object = (object) $arr_download_data; //NOTE: convert array to object

        if($object->processType == 1 || $object->processType == 3){
            $where = 'whs_transaction_id';
            $stamping = 'First Stamping';
        }else{
            $where = 'receiving_detail_id';
            $stamping = 'Second Stamping';
        }
        if($object->materialName == 'CT 6009-VE'){
            $object->materialName = substr($object->materialName, -7);
        }
        if($object->materialName == 'CT 5869-VE'){
            $object->materialName = substr($object->materialName, -7);
        }

        $search_material_name = IqcInspection::with(['iqc_inspection_mods_info', 'iqc_inspection_level_info', 'user_iqc'])
        ->where('partname', 'like', '%' . $object->materialName.'%')
        ->where($where, '!=', 0)
        ->whereBetween('date_inspected', [$object->from, $object->to])
        ->whereNull('deleted_at')
        ->get();
        // ->toSql();

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

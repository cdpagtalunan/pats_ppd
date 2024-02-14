<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Auth;
use DataTables;

use App\Models\User;
use App\Models\StampingHistory;
use App\Models\FirstStampingProduction;

class StampingHistoryController extends Controller
{
    public function getStampingProdnMaterialName(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $stamping_prodn_material_name = FirstStampingProduction::select('material_name')->whereNull('deleted_at')->distinct()->get();
        return response()->json(['getPrdnMaterialName'  => $stamping_prodn_material_name]);
    }

    public function viewStampingHistory(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_stamping_history = StampingHistory::where('part_name', $request->materialName)->where('logdel', 0)->get();

        return DataTables::of($get_stamping_history)
        ->addColumn('action', function($get_stamping_info){
            $result = '<center>';
            $result .= '
                <button class="btn btn-dark btn-sm text-center 
                    actionEditMimf" 
                    stamping_history-id="'. $get_stamping_info->id .'" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalMimf" 
                    data-bs-keyboard="false" title="View">
                    <i class="nav-icon fa fa-edit"></i>
                </button>';
            $result .= '</center>';
            return $result;
        })
        ->rawColumns([
            'action',
        ])
        ->make(true);
    }

    // public function getControlNo(){
    //     date_default_timezone_set('Asia/Manila');

    //     $get_last_control_no = Mimf::orderBy('id', 'DESC')->where('logdel', 0)->first();
    //     $control_no_format = "MIMF-".NOW()->format('ym')."-";

    //     if ($get_last_control_no == null){
    //         $new_control_no = $control_no_format.'001';
    //     }elseif(explode('-',$get_last_control_no->control_no)[1] != NOW()->format('ym')){
    //         $new_control_no = $control_no_format.'001';
    //     }else{
    //         $explode_control_no = explode("-",  $get_last_control_no->control_no);
    //         // $increment_control_number = $explode_control_no[2]+1;
    //         // $string_pad = str_pad($increment_control_number,3,"0",STR_PAD_LEFT);
    //         $string_pad = str_pad($explode_control_no[2]+1,3,"0",STR_PAD_LEFT);
    //         $new_control_no = $control_no_format.$string_pad;
    //     }
    //     return response()->json(['newControlNo' => $new_control_no]);
    // }

    // public function employeeID(Request $request){
    //     date_default_timezone_set('Asia/Manila');

    //     $user_details = User::where('employee_id', $request->user_id)->where('position', [0,7,8,10])->first();
    //     return response()->json(['userDetails' => $user_details]);
    // }

    // public function updateMimf(Request $request){
    //     date_default_timezone_set('Asia/Manila');
    //     $data = $request->all();

    //     $validator = Validator::make($data, [
    //         'mimf_control_no'               => 'required',
    //         'mimf_pmi_po_no'                => 'required',
    //         'mimf_date_issuance'            => 'required',
    //         'mimf_prodn_quantity'           => 'required',
    //         'mimf_device_code'              => 'required',
    //         'mimf_device_name'              => 'required',
    //         'mimf_material_code'            => 'required',
    //         'mimf_material_type'            => 'required',
    //         'mimf_quantity_from_inventory'  => 'required',
    //         'mimf_needed_kgs'               => 'required',
    //         'mimf_virgin_material'          => 'required',
    //         'mimf_recycled'                 => 'required',
    //         'mimf_prodn'                    => 'required',
    //         'mimf_delivery'                 => 'required',
    //         'mimf_remark'                   => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
    //     }else{
    //         DB::beginTransaction();
    //         try {
    //             $check_existing_record = Mimf::where('control_no', $request->mimf_control_no)->where('logdel', 0)->get();
    //             $mimf = [
    //                 'pps_po_rcvd_id'    => $request->pps_po_rcvd_id,
    //                 'pps_dieset_id'     => $request->pps_dieset_id,
    //                 'pps_whse_id'       => $request->pps_whse_id,
    //                 'ppd_matrix_id'     => $request->ppd_matrix_id,
    //                 'control_no'        => $request->mimf_control_no,
    //                 'date_issuance'     => $request->mimf_date_issuance,
    //                 'pmi_po_no'         => $request->mimf_pmi_po_no,
    //                 'prodn_qty'         => $request->mimf_prodn_quantity,
    //                 'device_code'       => $request->mimf_device_code,
    //                 'device_name'       => $request->mimf_device_name,
    //                 'material_code'     => $request->mimf_material_code,
    //                 'material_type'     => $request->mimf_material_type,
    //                 'qty_invt'          => $request->mimf_quantity_from_inventory,
    //                 'needed_kgs'        => $request->mimf_needed_kgs,
    //                 'virgin_material'   => $request->mimf_virgin_material,
    //                 'recycled'          => $request->mimf_recycled,
    //                 'prodn'             => $request->mimf_prodn,
    //                 'delivery'          => $request->mimf_delivery,
    //                 'remarks'           => $request->mimf_remark,
    //                 'scan_by'           => $request->employee_no,
    //             ];   
                
    //             if(count($check_existing_record) != 1){
    //                 $mimf['created_by']  = $request->created_by;
    //                 $mimf['created_at']  = date('Y-m-d H:i:s');
    //                 Mimf::insert(
    //                     $mimf
    //                 );
    //             }else{
    //                 if($request->mimf_id != ''){
    //                     $mimf['updated_by']  = $request->updated_by;
    //                     $mimf['updated_at']  = date('Y-m-d H:i:s');
    //                     Mimf::where('id', $request->mimf_id)
    //                     ->update(
    //                         $mimf
    //                     );
    //                 }else{
    //                     return response()->json(['result' => 1]);
    //                 }
    //             }

    //             DB::commit();
    //             return response()->json(['hasError' => 0]);
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
    //         }
    //     }
    // }

    // public function getMimfById(Request $request){
    //     date_default_timezone_set('Asia/Manila');
        
    //     $get_mimf_to_edit = Mimf::where('id', $request->mimfID)->get();
    //     return response()->json(['getMimfToEdit'  => $get_mimf_to_edit]);
    // }

}

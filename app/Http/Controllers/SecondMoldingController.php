<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecondMoldingController extends Controller
{
    public function getSearchPoForMolding(Request $request){
        return DB::connection('mysql_rapid_pps')->select("
            SELECT * FROM tbl_POReceived WHERE OrderNo = '$request->po'
        ");
    }
    
    public function checkMaterialLotNumber(Request $request){
        return DB::connection('mysql_rapid_pps')->select("
            SELECT a.Lot_number AS machine_lot_number, b.MaterialType AS machine_name FROM tbl_WarehouseTransaction AS a 
                INNER JOIN tbl_Warehouse as b
                    ON b.id = a.fkid
                WHERE Lot_number = '$request->material_lot_number'
        ");
    }

    public function getRevisionNumberBasedOnDrawingNumber(Request $request){
        return DB::connection('mysql_rapid_acdcs')->select("
            SELECT * FROM tbl_active_docs
                WHERE doc_no = '$request->doc_number'
                AND doc_title = '$request->doc_title'
                AND doc_type = '$request->doc_type'
        ");
    }

    public function functionName(Request $request){
        
    }
    
    public function saveSecondMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        return $_SESSION['rapidx_user_id'];
        $data = $request->all();
        /* For Insert */
        if(!isset($request->id)){
            $rules = [
                'device_name' => 'required',
                'parts_code' => 'required',
                'po_number' => 'required',
                'po_quantity' => 'required',
                'machine_number' => 'required',
                'machine_lot_number' => 'required',
                'machine_name' => 'required',
                'drawing_number' => 'required',
                'revision_number' => 'required',
                'production_lot' => 'required',
            ];

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $changeRequestId = ChangeRequest::insertGetId([
                        /** Requestor's info */
                        'control_number' => $request->control_number,
                        'requestor_change_initiator' => json_encode($request->requestor_change_initiator),
                        'requestor_position' => $request->requestor_position,
                        'requestor_department' => $request->requestor_department,
                        'requestor_section' => $request->requestor_section,
                        'requestor_request_date' => $request->requestor_request_date,
                        'requestor_section_head_approver' => json_encode($request->requestor_section_head_approver),
                        'requestor_department_head_approver' => json_encode($request->requestor_department_head_approver),
                        
                        /** Request Details */
                        'priority_level' => $request->priority_level,
                        'project_name' => $request->project_name,
                        'project_reason' => $request->project_reason,
                        'project_changes' => $request->project_changes,
                        'project_benefits' => $request->project_benefits,
                        'project_users' => $request->project_users,
                        
                        /** ISS Assessment */
                        'assigned_programmer' => json_encode($request->assigned_programmer),
                        'development_schedule' => $request->development_schedule,
                        'change_implementation_date' => $request->change_implementation_date,
                        'downtime_required' => $request->downtime_required,
                        'downtime_required_remarks' => $request->downtime_required_remarks,
                        'it_specialist_approver' => json_encode($request->it_specialist_approver),
                        'software_unit_head_approver' => json_encode($request->software_unit_head_approver),
                        'iss_head_approver' => json_encode($request->iss_head_approver),
                        'division_head_approver' => json_encode($request->division_head_approver),
                        'project_status' => $request->project_status,
                        'project_risk_and_impacts' => $request->project_risk_and_impacts,

                        'created_by' => $_SESSION['rapidx_user_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'is_deleted' => 0
                    ]);
                    $this->sendEmail($changeRequestId);

                    DB::commit();
                    return response()->json(['hasError' => false]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
                }
            }
        }
        // else{ /** For edit */
        //     $validator = Validator::make($data, $rules);
        //     if ($validator->fails()) {
        //         return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
        //     } else {
        //         DB::beginTransaction();
        //         try {
        //             ChangeRequest::where('id', $request->change_request_id)->update([
        //                 /** Requestor's info */
        //                 'control_number' => $request->control_number,
        //                 'requestor_change_initiator' => json_encode($request->requestor_change_initiator),
        //                 'requestor_position' => $request->requestor_position,
        //                 'requestor_department' => $request->requestor_department,
        //                 'requestor_section' => $request->requestor_section,
        //                 'requestor_request_date' => $request->requestor_request_date,
        //                 'requestor_section_head_approver' => json_encode($request->requestor_section_head_approver),
        //                 'requestor_department_head_approver' => json_encode($request->requestor_department_head_approver),

        //                 'last_updated_by' => $_SESSION['rapidx_user_id'],
        //                 'updated_at' => date('Y-m-d H:i:s'),
        //             ]);
        //             DB::commit();
        //             return response()->json(['hasError' => false]);
        //         } catch (\Exception $e) {
        //             DB::rollback();
        //             return response()->json(['hasError' => true, 'exceptionError' => $e]);
        //         }
        //     }
        // }
    }
}

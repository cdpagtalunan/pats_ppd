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

use App\Models\Mimf;
use App\Models\User;

class MimfController extends Controller
{
    public function viewMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimfs = Mimf::all();

        return DataTables::of($get_mimfs)
        ->addColumn('action', function($get_mimf){
            $result = '<center>';
            $result .= '
                <button class="btn btn-info btn-sm text-center 
                    actionOqcInspectionView" 
                    mimf-id="'. $get_mimf->id .'" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalMimf" 
                    data-bs-keyboard="false" title="View">
                    <i class="nav-icon fa fa-eye"></i>
                </button>';
            $result .= '</center>';
            return $result;
        })
        ->rawColumns([
            'action',
        ])
        ->make(true);
    }

    public function EmployeeID(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user_details = User::where('employee_id', $request->user_id)->first();
        return response()->json(['userDetails' => $user_details]);
    }

    public function updateMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $validator = Validator::make($data, [
            // 'mimf_control_no'               => 'required',
            // 'mimf_pmi_po_no'                => 'required',
            // 'mimf_date_issuance'            => 'required',
            // 'mimf_prodn_quantity'           => 'required',
            // 'mimf_device_code'              => 'required',
            // 'mimf_device_name'              => 'required',
            // 'mimf_material_code'            => 'required',
            // 'mimf_material_type'            => 'required',
            // 'mimf_quantity_from_inventory'  => 'required',
            // 'mimf_needed_kgs'               => 'required',
            // 'mimf_virgin_material'          => 'required',
            // 'mimf_recycled'                 => 'required',
            // 'mimf_prodn'                    => 'required',
            // 'mimf_delivery'                 => 'required',
            // 'mimf_remark'                   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                $mimf =[
                    'control_no'        => $request->mimf_control_no,
                    'date_issuance'     => $request->mimf_date_issuance,
                    'po_no'             => $request->mimf_pmi_po_no,
                    'prodn_qty'         => $request->mimf_prodn_quantity,
                    'device_code'       => $request->mimf_device_code,
                    'device_name'       => $request->mimf_device_name,
                    'material_code'     => $request->mimf_material_code,
                    'material_type'     => $request->mimf_material_type,
                    'qty_invt'          => $request->mimf_quantity_from_inventory,
                    'needed_kgs'        => $request->mimf_needed_kgs,
                    'virgin_material'   => $request->mimf_virgin_material,
                    'recycled'          => $request->mimf_recycled,
                    'prodn'             => $request->mimf_prodn,
                    'delivery'          => $request->mimf_delivery,
                    'remarks'           => $request->mimf_remark,
                    'scan_by'           => $request->employee_no,
                    'created_by'        => $request->created_by,
                    'created_at'        => date('Y-m-d H:i:s'),
                ];   
                
                Mimf::insert(
                    $mimf
                );

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }
}

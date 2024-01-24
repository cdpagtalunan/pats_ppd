<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\FirstStampingProduction;
use App\Models\OQCInspection;
use App\Models\User;
use App\Models\PackingDetails;
use App\Models\PreliminaryPacking;

class PackingDetailsController extends Controller
{
    public function viewPackingDetailsData(Request $request){
        // $packing_details = OQCInspection::with(['stamping_production_info', 'packing_info'])
        // ->where('po_no', 'like', '%' . $request->po_no . '%')
        // ->where('lot_accepted', 1)
        // ->get();

        $packing_details = PreliminaryPacking::with(['oqc_info.stamping_production_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('status', 1)
        ->get();

        // return $packing_details;
        // return $packing_details[3]->packing_info->status;

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($packing_details)
            ->addColumn('action', function($packing_details){
                $result = "";
                $result .= "<center>";
                    $result .= "<button class='btn btn-primary btn-sm btnEditPackingDetails' data-id='$packing_details->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";

                if( $packing_details->packing_info != null){
                    if($packing_details->packing_info->status == 0){
                        $result .= '<span class="badge bg-info">For QC Inspection</span>';
                    }else{
                        $result .= '<span class="badge bg-success">Completed</span>';
                    }
                }else{
                    $result .= '---';
                }
        
                // if($test == 2){
                //     $result .= '<span class="badge bg-success">Active</span>';
                // }
                // else{
                //     $result .= '<span class="badge bg-danger">Disabled</span>';
                // }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
        }
    }

    public function viewPrelimDetailsData(Request $request){
        $preliminary_packing_data = OQCInspection::with(['stamping_production_info', 'prelim_packing_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('lot_accepted', 1)
        ->get();

        // return $preliminary_packing_data;
        // return $preliminary_packing_data[3]->packing_info->status;

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($preliminary_packing_data)
            ->addColumn('action', function($preliminary_packing_data){
                $result = "";
                $result .= "<center>";
                if( $preliminary_packing_data->prelim_packing_info == null){

                    $result .= "<button class='btn btn-primary btn-sm btnValidatePrelimPackingDetails' po-no='$preliminary_packing_data->po_no' data-id='$preliminary_packing_data->id'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                }else{

                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($preliminary_packing_data){
                $result = "";
                $result .= "<center>";

                if( $preliminary_packing_data->prelim_packing_info == null){
                    $result .= '<span class="badge bg-info">OQC PASSED</span>';
                }else{
                    $result .= '<span class="badge bg-info">For Packing List</span>';
                }
        
                // if($test == 2){
                //     $result .= '<span class="badge bg-success">Active</span>';
                // }
                // else{
                //     $result .= '<span class="badge bg-danger">Disabled</span>';
                // }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
        }
    }

    public function getOqcDetailsForPacking(Request $request){
        $oqc_data = OQCInspection::with(['stamping_production_info'])
        ->where('id', $request->oqc_details_id)
        ->where('lot_accepted', 1)
        ->first();
        
        // return $oqc_data;

        return response()->json(['oqcData' => $oqc_data]);
    }

    public function addPackingDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'                => $request->packing_details_id,
                            'delivery_balance'      => $request->delivery_balance,
                            'no_of_cuts'            => $request->number_of_cuts,
                            'material_quality'      => $request->material_quality,
                            'status'                => 1,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];
                        
                        PackingDetails::insert($array);
                        
        
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function updatePrelimDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'                => $request->oqc_details_id,
                            'po_no'                 => $request->po_no,
                            'validated_by'          => $request->scan_id,
                            'validated_date'          => date('Y-m-d H:i:s'),
                            'status'                => 1,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];

                        PreliminaryPacking::insert($array);

            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }

    }
}

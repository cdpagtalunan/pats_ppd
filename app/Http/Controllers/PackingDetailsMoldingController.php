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
use App\Models\PackingDetailsMolding;

class PackingDetailsMoldingController extends Controller
{
    public function viewPackingDetailsFE(Request $request){
        $packing_details = OQCInspection::with(['stamping_production_info', 'packing_info', 'first_molding_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('lot_accepted', 1)
        ->where('status', 2)
        ->get();

        // return $packing_details;

        if(!isset($request->po_no)){
            return [];
        }else{

            return DataTables::of($packing_details)

            ->addColumn('action', function($packing_details){
                $result = "";

                if( $packing_details->first_molding_info != null){
                    if($packing_details->first_molding_info->status == 0){
                        $result .= "<button class='btn btn-warning btn-sm btnScanMoldingID' data-id='".$packing_details->first_molding_info->id."'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                    }else{
                        $result .= '<span class="badge bg-success">Received</span>';
                    }
                }else{
                    $result .= "<button class='btn btn-primary btn-sm btnScanPackingID' data-id='$packing_details->id' po-no='$packing_details->po_no'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                }
                return $result;
            })

            ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";

                if( $packing_details->first_molding_info != null){
                    if($packing_details->first_molding_info->status == 0){
                        $result .= '<span class="badge bg-success">For QC Checking</span>';
                    }else if($packing_details->first_molding_info->status == 1){
                        $result .= '<span class="badge bg-success">To Receive</span>';
                    }else{
                        $result .= '<span class="badge bg-success">Received</span>';
                    }
                }else{
                    $result .= '<span class="badge bg-success">For Packing Checking</span>';
                }

                $result .= "</center>";
                return $result;
            })

            ->addColumn('fs_lot_no', function($packing_details){
                $fs_lot_no = explode('/', $packing_details->stamping_production_info->material_lot_no);

                $result = $fs_lot_no[0];
               
                return $result;
            })

            ->addColumn('plating_lot_no', function($packing_details){
                $plating_lot_no = explode('/', $packing_details->stamping_production_info->material_lot_no);

                $result = $plating_lot_no[1];
               
                return $result;
            })

            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            ->make(true);
        }
    }

    public function viewPackingDetailsE(Request $request){
        $packing_details = PackingDetailsMolding::with(['oqc_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('status', 2)
        ->get();

        // return $packing_details;

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

            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action'])
            ->make(true);
        }
    }

     public function updatePackingDetailsMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $rules = [
            // 'control_no'                 => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'               => $request->oqc_details_id,
                            'po_no'                => $request->po_no,
                            'countedby'            => $request->scan_id,
                            'date_counted'         => date('Y-m-d H:i:s'),
                            'status'               => 0,
                            'created_at'           => date('Y-m-d H:i:s'),
                        ];

                        PackingDetailsMolding::insert($array);

            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }

    }
    
}

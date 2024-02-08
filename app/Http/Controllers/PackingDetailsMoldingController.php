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
use App\Models\StampingProductionSublot;

class PackingDetailsMoldingController extends Controller
{
    public function viewPackingDetailsFE(Request $request){

        // return $request->po_no;

        $packing_details = OQCInspection::with([
        'stamping_production_info',
        'stamping_production_info.second_stamping_sublots',
        'packing_info',
        'first_molding_info',
        'first_molding_info.user_validated_by_info',
        'first_molding_info.user_checked_by_info'
        ])
        ->where('po_no', $request->po_no)
        ->where('lot_accepted', 1)
        ->where('status', 2)
        ->get();

        // return $packing_details;

            return DataTables::of($packing_details)

            ->addColumn('action', function($packing_details){
                $result = "";

                if( $packing_details->first_molding_info != null){
                    $status = $packing_details->first_molding_info->status;
                    $id = $packing_details->first_molding_info->id;
                    if($packing_details->first_molding_info->status == 0){
                        // $result .= "<button class='btn btn-warning btn-sm btnQCScanMoldingID' style='display: none;' data-id='".$packing_details->first_molding_info->id."'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                        $result .= "<button class='btn btn-warning btn-sm btnViewSublotForScanning' style='display: none;' molding-id='$id' data-status='$status' oqc-id='$packing_details->id' po-no='$packing_details->po_no' data-id='".$packing_details->stamping_production_info->id."'><i class='fa-solid fa-eye'></i></button>&nbsp";
                    }else if($packing_details->first_molding_info->status == 1){
                        $result .= "<button class='btn btn-warning btn-sm btnViewSublotForScanning' molding-id='$id' data-status='$status' oqc-id='$packing_details->id' po-no='$packing_details->po_no' data-id='".$packing_details->stamping_production_info->id."'><i class='fa-solid fa-eye'></i></button>&nbsp";
                    }
                }else{
                    $result .= "<button class='btn btn-warning btn-sm btnViewSublotForScanning' style='display: none;' oqc-id='$packing_details->id' po-no='$packing_details->po_no' data-id='".$packing_details->stamping_production_info->id."'><i class='fa-solid fa-eye'></i></button>&nbsp";

                }
                return $result;
            })

            ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";

                if( $packing_details->first_molding_info != null){
                    if($packing_details->first_molding_info->status == 0){
                        $result .= '<span class="badge bg-warning">For QC Checking</span>';
                    }else if($packing_details->first_molding_info->status == 1){
                        $result .= '<span class="badge bg-success">Checked by QC</span>';
                    }else{
                        $result .= '---';
                    }
                }else{
                    $result .= '<span class="badge bg-primary">For Packing Checking</span>';
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

    public function viewSublotDetails(Request $request){
        $sublot_details = StampingProductionSublot::with(['stamping_info'])
            ->where('stamp_prod_id', $request->stamping_details_id)
            ->get();

        // return $sublot_details;

        return DataTables::of($sublot_details)
        ->make(true);

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


    //UPDATE Packing CHECKING
    public function updatePackingDetailsMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $array = [
            'oqc_id'               => $request->oqc_details_id,
            'po_no'                => $request->po_no,
            'countedby'            => $request->scanned_emp_id,
            'date_counted'         => date('Y-m-d H:i:s'),
            'status'               => 0,
            'created_at'           => date('Y-m-d H:i:s'),
        ];

        PackingDetailsMolding::insert($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);

    }

    //UPDATE QC CHECKING

    public function updateCheckByDetailsMolding(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;

        $array = [
            'checkedby'             => $request->scanned_emp_id,
            'date_checked'          => date('Y-m-d H:i:s'),
            'status'                => 1,
        ];

        PackingDetailsMolding::where('id', $request->molding_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

}

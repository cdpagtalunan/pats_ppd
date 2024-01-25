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
                $result .= "<center>";
                    $result .= "<button class='btn btn-primary btn-sm btnScanPackingID' data-id='$packing_details->id'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                $result .= "</center>";
                return $result;
            })

             ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";

                if( $packing_details->first_molding_info != null){
                    if($packing_details->first_molding_info->status == 0){
                        $result .= '<span class="badge bg-success">For Receiving</span>';
                    }else{
                        $result .= '<span class="badge bg-success">Received</span>';
                    }
                }else{
                    $result .= '<span class="badge bg-success">For Endorsement</span>';
                }

                $result .= "</center>";
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
}

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

class PackingDetailsController extends Controller
{
    public function viewPackingDetailsData(Request $request){
        $packing_details = PackingDetails::
        where('po_no', $request->po_no)
        ->get();

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($packing_details)
            ->addColumn('action', function($packing_details){
                $result = "";
                $result .= "<center>";
            
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";
        
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
        $production_data = OQCInspection::with(['stamping_production_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('status', 2)
        ->get();

    }
}

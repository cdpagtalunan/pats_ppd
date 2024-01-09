<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Auth;
use DataTables;

use App\Models\StampingIpqc;

class OQCInspectionController extends Controller
{
    //============================== VIEW ==============================
    public function viewOqcInspection(Request $request){
        date_default_timezone_set('Asia/Manila');

        $oqc_inspections = StampingIpqc::with(['first_stamping_production'])->where('po_number', $request->poNo)->where('status', 1)->get();
        return DataTables::of($oqc_inspections)
        
        ->addColumn('action', function($oqc_packing_instections){
            $result = '<center>';
            // $result .= '<button class="btn btn-dark btn-sm text-center action mr-2" oqc_inspection-id="' . $ . '" oqc_packing_instection-packing_code="' . $oqc_packing_instections->packing_code . '" data-toggle="modal" data-target="#modalOqcPackingInspectionResultHistory" data-keyboard="false" title="OQC Packing Inspection History"><i class="nav-icon fa fa-history"></i></button>&nbsp;';
            $result .= '</center>';
            return $result;   
        })

        ->addColumn('fy_ww', function($oqc_packing_instections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->rawColumns(['action', 'fy_ww'])
        ->make(true);  
    }
}

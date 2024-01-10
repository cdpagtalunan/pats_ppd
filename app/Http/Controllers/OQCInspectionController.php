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
use App\Models\OQCInspection;

class OQCInspectionController extends Controller
{
    //============================== VIEW ==============================
    public function viewOqcInspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        $qwe = StampingIpqc::where('po_number', $request->poNo)->get();
        $oqc_inspections = OQCInspection::with(['ipqc_info'])->where('po_no', $request->poNo)->get();
        
        return DataTables::of($qwe)
        ->addColumn('action', function($qwe){
            $result = '<center>';
            $result .= '<button class="btn btn-dark btn-sm text-center action mr-2" oqc_inspection-id="' . $qwe . '" data-toggle="modal" data-target="#modalOqcPackingInspectionResultHistory" data-keyboard="false" title="OQC Packing Inspection Edit"><i class="nav-icon fa fa-edit"></i></button>&nbsp;';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_no', function($qwe) use($oqc_inspections){
            $result = '<center>';
            $result .= $qwe->po_number;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('fy_ww', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('date_inspected', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('device_name', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_from', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_to', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('submission', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })
        ->addColumn('lot_qty', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('sample_size', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('num_of_defects', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('lot_no', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('mod', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_qty', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('judgement', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('inspector', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('remarks', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('family', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('update_user', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('updated_at', function($oqc_inspections){
            $result = '<center>';
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
            'po_no',
            'fy_ww',
            'date_inspected',
            'device_name',
            'time_ins_from',
            'time_ins_to',
            'submission',
            'lot_qty',
            'sample_size',
            'num_of_defects',
            'lot_no',
            'mod',
            'po_qty',
            'judgement',
            'inspector',
            'remarks',
            'family',
            'update_user',
            'updated_at',
        ])
        ->make(true);
    }
}

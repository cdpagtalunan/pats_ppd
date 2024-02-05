<?php

namespace App\Http\Controllers;

use App\Exports\ExportCN171TraceabilityReport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\FirstStampingProduction;
use App\Models\ReceivingDetails;



class ExportTraceabilityReportController extends Controller
{
    public function exportCN171TraceabilityReport(Request $request){
        $first_stamping_data = FirstStampingProduction::with([
        'stamping_ipqc', 
        'stamping_ipqc.ipqc_insp_name', 
        'oqc_details', 
        'oqc_details.packing_info',
        'oqc_details.packing_info.user_validated_by_info'
        ])
        ->where('po_num', $request->po_number)
        ->where('stamping_cat', 1)
        ->get();

        $receiving_data = ReceivingDetails::with([
            'iqc_info',
            'iqc_info.user_iqc'
            ])
        ->where('po_no', $request->po_number)
        ->where('status', 2 )
        ->get();

        $second_stamping_data = FirstStampingProduction::with([
            'stamping_ipqc', 
            'stamping_ipqc.ipqc_insp_name', 
            'oqc_details', 
            'oqc_details.packing_info',
            'oqc_details.packing_info.user_validated_by_info'
            ])
            ->where('po_num', $request->po_number)
            ->where('stamping_cat', 2)
            ->get();

        // return $second_stamping_data;

        // for ($i=0; $i < count($first_stamping_data); $i++) { 
        //         # code...
        //     return ($first_stamping_data[$i]->stamping_ipqc->id);
        // }

    
        return Excel::download(new ExportCN171TraceabilityReport(
            $first_stamping_data,
            $receiving_data
        ), 
        'CN171 Traceability.xlsx');

    }
}

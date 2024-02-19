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
        $stamping_data = FirstStampingProduction::with([
            'receiving_info',
            'receiving_info.iqc_info',
            'receiving_info.iqc_info.user_iqc',
            'stamping_ipqc', 
            'user', 
            'stamping_ipqc.ipqc_insp_name', 
            'oqc_details', 
            'oqc_details.packing_info',
            'oqc_details.packing_info.user_validated_by_info',
            'oqc_details.first_molding_info',
            'oqc_details.first_molding_info.user_validated_by_info'
            ])
            ->where('po_num', $request->po_number)
            ->whereBetween('prod_date', [$request->date_from,$request->date_to])
            ->get();
        
        // return $stamping_data;

        // $receiving_data = ReceivingDetails::with([
        //     'iqc_info',
        //     'iqc_info.user_iqc'
        //     ])
        // ->where('po_no', $request->po_number)
        // ->where('status', 2 )
        // ->get();

        // return $receiving_data;
    
        return Excel::download(new ExportCN171TraceabilityReport(
            $stamping_data,
            // $receiving_data
        ), 
        'CN171 Traceability.xlsx');

    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\ExportCN171TraceabilityReport;
use App\Exports\ExportMoldingTraceabilityReport;

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

        // return $request->date_from; 
        // return $request->date_to;

        $material_name = strtoupper($request->material_name);

        $stamping_data_1 = FirstStampingProduction::with([
        'receiving_info',
        'receiving_info.iqc_info',
        'receiving_info.iqc_info.user_iqc',
        'stamping_ipqc', 
        'user', 
        'packing_list_details',
        'stamping_ipqc.ipqc_insp_name', 
        'oqc_details', 
        'oqc_details.packing_info',
        'oqc_details.packing_info.user_validated_by_info',
        'oqc_details.first_molding_info',
        'oqc_details.first_molding_info.user_validated_by_info'
        ])
        // ->where('po_num', $po_number)
        ->where('material_name', $material_name)
        ->where('stamping_cat', 1)
        ->whereBetween('prod_date', [$request->date_from,$request->date_to])
        ->get();

        // return $stamping_data_1;

        $stamping_data_2 = FirstStampingProduction::with([
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
                // ->where('po_num', $po_number)
                ->where('material_name', $material_name)
                ->where('stamping_cat', 2)
                ->whereBetween('prod_date', [$request->date_from,$request->date_to])
                ->get();
        
        // return $stamping_data_1;

        // $receiving_data = ReceivingDetails::with([
        //     'iqc_info',
        //     'iqc_info.user_iqc'
        //     ])
        // ->where('po_no', $request->po_number)
        // ->where('status', 2 )
        // ->get();

        // return $receiving_data;

        return Excel::download(new ExportCN171TraceabilityReport(
        $stamping_data_1,
        $stamping_data_2
        // $receiving_data
        ), 
        'CN171 Traceability.xlsx');

}

public function exportMoldingTraceabilityReport(Request $request){

        $device_name = $request->device_name.'#IN-VE';

        //QUERY BUILDER
        $secondMoldingData = DB::connection('mysql')
        ->table('sec_molding_runcards as a')
        ->join('users as b', 'a.created_by', 'b.id',)
        ->where('pmi_po_number', $request->po_number)
        ->where('device_name', $device_name)
        ->whereBetween('a.created_at', [$request->date_from, $request->date_to])
        ->select(
                'a.id as id',
                'a.production_lot as production_lot',
                'a.material_name as material_name',
                'a.material_lot_number as material_lot_number',
                'a.drawing_number as drawing_number',
                'a.revision_number as revision_number',
                'a.lot_number_eight as lot_number_eight',
                'a.lot_number_nine as lot_number_nine',
                'a.lot_number_ten as lot_number_ten',
                'a.me_name_lot_number_one as me_name_lot_number_one',
                'a.me_name_lot_number_second as me_name_lot_number_second',
                'a.created_at as created_at',
                'b.firstname as r_machine_operator'
                )
        ->groupBy('a.id')
        ->get();

        // return $secondMoldingData;

        $secondMoldingInitialData = DB::connection('mysql')
        ->table('sec_molding_runcard_stations as a')
        ->join('users as b', 'a.operator_name', 'b.id')
        ->where('station', 1)
        ->select(
                'a.sec_molding_runcard_id as sec_molding_runcard_id',
                'b.firstname as r_machine_operator',
                DB::raw('SUM(a.input_quantity) as initial_sum'),
                DB::raw('SUM(a.station_yield)/COUNT(a.station_yield) as initial_yield')
                )
        ->groupBy('a.sec_molding_runcard_id','b.firstname')
        ->get();

        // return $secondMoldingInitialData;

        $secondMoldingCameraData = DB::connection('mysql')
        ->table('sec_molding_runcard_stations as a')
        ->join('users as b', 'a.operator_name', 'b.id')
        ->where('station', 5)
        ->select(
                'a.sec_molding_runcard_id as sec_molding_runcard_id',
                'b.firstname as camera_operator',
                DB::raw('SUM(a.input_quantity) as camera_sum'),
                DB::raw('SUM(a.station_yield)/COUNT(a.station_yield) as camera_yield')
                )
        ->groupBy('a.sec_molding_runcard_id','b.firstname')
        ->get();

        // return $secondMoldingCameraData;

        $secondMoldingVisualData = DB::connection('mysql')
        ->table('sec_molding_runcard_stations as a')
        ->join('users as b', 'a.operator_name', 'b.id')
        ->where('station', 4)
        ->select(
                'a.sec_molding_runcard_id as sec_molding_runcard_id',
                'b.firstname as visual_operator',
                DB::raw('SUM(a.input_quantity) as visual_sum'),
                DB::raw('SUM(a.station_yield)/COUNT(a.station_yield) as visual_yield')
                )
        ->groupBy('a.sec_molding_runcard_id','b.firstname')
        ->get();

        $secondMoldingFirstOqcData = DB::connection('mysql')
        ->table('sec_molding_runcard_stations as a')
        ->join('users as b', 'a.operator_name', 'b.id')
        // ->where('station', 4) live
        ->where('station', 10)
        ->select(
                'a.sec_molding_runcard_id as sec_molding_runcard_id',
                'b.firstname as first_oqc_operator',
                'a.sample_size as sample_size',
                'a.ng_quantity as no_of_defects',
                'a.lot_accepted  as lot_accepted',
                'a.lot_inspected as lot_inspected',
                DB::raw('SUM(a.input_quantity) as first_oqc_sum'),
                DB::raw('SUM(a.station_yield)/COUNT(a.station_yield) as first_oqc_yield')
                )
        ->groupBy('a.sec_molding_runcard_id','b.firstname')
        ->get();

        // return $secondMoldingFirstOqcData;

        $assemblyMarkingData = DB::connection('mysql')
        ->table('assembly_runcard_stations as a')
        ->join('assembly_runcards as b', 'a.assembly_runcards_id', 'b.id')
        ->join('users as c', 'a.operator_name', 'c.id')
        ->where('station', 9)
        ->select(
                'a.assembly_runcards_id as assembly_runcards_id',
                'b.s_zero_seven_prod_lot as s_lot_no',
                'b.p_zero_two_prod_lot as p_lot_no',
                'c.firstname as marking_operator',
                DB::raw('SUM(a.input_quantity) as marking_sum'),
                DB::raw('SUM(a.station_yield) as marking_yield')
        )
        ->groupBy('assembly_runcards_id','s_lot_no','p_lot_no','marking_operator')
        ->get();

        // return $assemblyMarkingData;

        $assemblyMOData = DB::connection('mysql')
        ->table('assembly_runcard_stations as a')
        ->join('assembly_runcards as b', 'a.assembly_runcards_id', 'b.id')
        ->join('users as c', 'a.operator_name', 'c.id')
        ->where('station', 7)
        ->select(
                'a.assembly_runcards_id as assembly_runcards_id',
                'b.s_zero_seven_prod_lot as s_lot_no',
                'b.p_zero_two_prod_lot as p_lot_no',
                'c.firstname as mo_operator',
                DB::raw('SUM(a.input_quantity) as mo_assembly_sum'),
                DB::raw('SUM(a.station_yield) as mo_assembly_yield')
        )
        ->groupBy('assembly_runcards_id','s_lot_no','p_lot_no','mo_operator')
        ->get();

        // return $assemblyMOData;

        $assemblyVisualData = DB::connection('mysql')
        ->table('assembly_runcard_stations as a')
        ->join('assembly_runcards as b', 'a.assembly_runcards_id', 'b.id')
        ->join('users as c', 'a.operator_name', 'c.id')
        ->where('station', 4)
        ->select(
                'a.assembly_runcards_id as assembly_runcards_id',
                'b.s_zero_seven_prod_lot as s_lot_no',
                'b.p_zero_two_prod_lot as p_lot_no',
                'c.firstname as visual_operator',
                DB::raw('SUM(a.input_quantity) as visual_sum'),
                DB::raw('SUM(a.station_yield) as visual_yield')
        )
        ->groupBy('assembly_runcards_id','s_lot_no','p_lot_no','visual_operator')
        ->get();
        // return $assemblyVisualData;

        // QUERY BUILDER END

        // SUPER RAW QUERY 

        // $secondMoldingData = DB::connection('mysql')
        // ->select("SELECT sec_molding_runcards.*,
        // b.firstname as r_machine_operator,
        // sec_molding_runcards.total_machine_output as prod_qty
        // FROM sec_molding_runcards
        // INNER JOIN sec_molding_runcard_stations as a ON sec_molding_runcards.id = a.id
        // INNER JOIN users as b ON sec_molding_runcards.created_by = b.id
        // WHERE sec_molding_runcards.pmi_po_number = '$request->po_number' 
        // AND sec_molding_runcards.device_name = '$device_name'
        // AND sec_molding_runcards.created_at BETWEEN '$request->date_from'AND '$request->date_to'
        // ");

        // $secondMoldingInitialData = DB::connection('mysql')
        // ->select("SELECT sec_molding_runcard_id, b.firstname as r_machine_operator,
        //     SUM(input_quantity) as initial_sum,
        //     SUM(station_yield)/COUNT(station_yield) as initial_yield
        //     FROM sec_molding_runcard_stations
        //     INNER JOIN users as b ON operator_name = b.id
        //     WHERE station = 1
        //     GROUP BY sec_molding_runcard_id,b.firstname
        // ");

        // return $secondMoldingInitialData;

        // $secondMoldingCameraData = DB::connection('mysql')
        // ->select("SELECT sec_molding_runcard_id, b.firstname as camera_operator,
        //     SUM(input_quantity) as camera_sum,
        //     SUM(station_yield)/COUNT(station_yield) as camera_yield
        //     FROM sec_molding_runcard_stations
        //     INNER JOIN users as b ON operator_name = b.id
        //     WHERE station = 7
        //     GROUP BY sec_molding_runcard_id,b.firstname
        // ");

        // return $secondMoldingCameraData;

        // $secondMoldingVisualData = DB::connection('mysql')
        // ->select("SELECT sec_molding_runcard_id, b.firstname as visual_operator,
        //     SUM(input_quantity) as visual_sum,
        //     SUM(station_yield)/COUNT(station_yield) as visual_yield
        //     FROM sec_molding_runcard_stations
        //     INNER JOIN users as b ON operator_name = b.id
        //     WHERE station = 4
        //     GROUP BY sec_molding_runcard_id,b.firstname
        // ");

        // return $secondMoldingVisualData;

        // $assemblyMarkingData = DB::connection('mysql')
        //     ->select("SELECT 
        //     assembly_runcards_id,
        //     a.s_zero_seven_prod_lot as s_lot_no,
        //     a.p_zero_two_prod_lot as p_lot_no,
        //     b.firstname as marking_operator,
        //     SUM(input_quantity) as marking_sum,
        //     SUM(station_yield) as marking_yield
        //     FROM assembly_runcard_stations
        //     INNER JOIN assembly_runcards as a ON assembly_runcard_stations.assembly_runcards_id = a.id
        //     INNER JOIN users as b ON assembly_runcard_stations.operator_name = b.id
        //     WHERE station = 5
        //     GROUP BY assembly_runcards_id,s_lot_no,p_lot_no,marking_operator
        // ");

        // return $assemblyMarkingData;

        // $assemblyMOData = DB::connection('mysql')
        //     ->select("SELECT 
        //     assembly_runcards_id,
        //     a.s_zero_seven_prod_lot as s_lot_no,
        //     a.p_zero_two_prod_lot as p_lot_no,
        //     b.firstname as mo_operator,
        //     SUM(input_quantity) as mo_assembly_sum,
        //     SUM(station_yield) as mo_assembly_yield
        //     FROM assembly_runcard_stations
        //     INNER JOIN assembly_runcards as a ON assembly_runcard_stations.assembly_runcards_id = a.id
        //     INNER JOIN users as b ON assembly_runcard_stations.operator_name = b.id
        //     WHERE station = 3
        //     GROUP BY assembly_runcards_id,s_lot_no,p_lot_no,mo_operator
        // ");

        // return $assemblyMOData;

        // $assemblyVisualData = DB::connection('mysql')
        //     ->select("SELECT 
        //     assembly_runcards_id,
        //     a.s_zero_seven_prod_lot as s_lot_no,
        //     a.p_zero_two_prod_lot as p_lot_no,
        //     b.firstname as visual_operator,
        //     SUM(input_quantity) as visual_sum,
        //     SUM(station_yield) as visual_yield
        //     FROM assembly_runcard_stations
        //     INNER JOIN assembly_runcards as a ON assembly_runcard_stations.assembly_runcards_id = a.id
        //     INNER JOIN users as b ON assembly_runcard_stations.operator_name = b.id
        //     WHERE station = 6
        //     GROUP BY assembly_runcards_id,s_lot_no,p_lot_no,visual_operator
        // ");

        // return $assemblyVisualData;

        return Excel::download(new ExportMoldingTraceabilityReport(
                $device_name,
                $secondMoldingData,
                $secondMoldingInitialData,
                $secondMoldingCameraData,
                $secondMoldingVisualData,
                $secondMoldingFirstOqcData,
                $assemblyMarkingData,
                $assemblyMOData,
                $assemblyVisualData
        ), 
        'Traceability Report.xlsx');
}
}

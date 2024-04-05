<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use QrCode;
use DataTables;

/**
 * Import Models
 */
use App\Models\StampingWorkingReport;

class StampingWorkingReportController extends Controller
{
    public function saveMachineNumber(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        
        /* For Insert */
        if(!isset($request->id)){
            $rules = [
                'control_number' => 'required',
                'machine_number' => 'required',
                'year' => 'required',
                'month' => 'required',
                'day' => 'required',
            ];
            
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validatorHasError' => true, 'validatorMessages' => $validator->messages()]);
            }else {
                DB::beginTransaction();
                try {
                    $id = DB::table('stamping_working_reports')->insertGetId([
                        'control_number' => $request->control_number,
                        'machine_number' => $request->machine_number,
                        'year' => $request->year,   
                        'month' => $request->month,
                        'day' => $request->day,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    DB::commit();
                    return response()->json(['hasError' => false, 'id'=> $id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
                }
            }
        }else{ /* For Edit */
            $rules = [
                'id' => 'required',
            ];
            
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validatorHasError' => true, 'validatorMessages' => $validator->messages()]);
            }else {
                DB::beginTransaction();
                try {
                    DB::table('stamping_working_reports')->update([
                        
                        'last_updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    DB::commit();
                    return response()->json(['hasError' => false]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
                }
            }
        }
    }

    public function viewStampingWorkingReport(Request $request){
        $stampingWorkingReportResult = DB::connection('mysql')
            ->table('stamping_working_reports')
            ->whereNull('stamping_working_reports.deleted_at')
            ->select(
                'stamping_working_reports.*',
            )->get();
            // return $stampingWorkingReportResult;

        return DataTables::of($stampingWorkingReportResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button type='button' class='btn btn-info btn-sm mr-1 actionViewStampingWorkingReport' data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReport' stamping-working-report-id='$row->id'><i class='fa-solid fa-eye'></i></button>
                    <button type='button' class='btn btn-primary btn-sm mr-1 actionEditStampingWorkingReport' data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReport' stamping-working-report-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                </center>
            ";
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getStampingWorkingReportById(Request $request){
        $getStampingWorkingReportByIdResult = DB::table('stamping_working_reports')
        ->where('stamping_working_reports.id', $request->id)
        ->where('stamping_working_reports.deleted_at', '=', NULL)
        ->select(
            'stamping_working_reports.id',
            'stamping_working_reports.control_number',
            'stamping_working_reports.machine_number',
            'stamping_working_reports.year',
            'stamping_working_reports.month',
            'stamping_working_reports.day',
            // 'stamping_working_report_work_details.*'
        )
        ->get();
        return response()->json(['data' => $getStampingWorkingReportByIdResult]);
    }

    public function viewStampingWorkingReportWorkDetails(Request $request){
        $stampingWorkingReportWorkDetailsResult = DB::connection('mysql')
            ->table('stamping_working_report_work_details')
            ->whereNull('stamping_working_report_work_details.deleted_at')
            ->select(
                'stamping_working_report_work_details.*',
            )->get();
            // return $stampingWorkingReportWorkDetailsResult;

        return DataTables::of($stampingWorkingReportWorkDetailsResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button type='button' class='btn btn-info btn-sm mr-1 actionViewStampingWorkingReportWorkDetails' data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReportWorkDetails' stamping-working-report-work-details-id='$row->id'><i class='fa-solid fa-eye'></i></button>
                    <button type='button' class='btn btn-primary btn-sm mr-1 actionEditStampingWorkingReportWorkDetails' data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReportWorkDetails' stamping-working-report-work-details-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                </center>
            ";
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function saveStampingWorkingReportWorkDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        // return $data;
        /* For Insert */
        if(!isset($request->stamping_working_report_work_details_id)){
            $rules = [
                'stamping_working_report_id' => 'required',
                'time_start' => 'required',
                'time_end' => 'required',
                'total_minutes' => 'required',
                'work_details' => 'required',
                'sequence_number' => 'required',
            ];
            
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validatorHasError' => true, 'validatorMessages' => $validator->messages()]);
            }else {
                DB::beginTransaction();
                try {
                    $id = DB::table('stamping_working_report_work_details')->insertGetId([
                        'stamping_working_report_id' => $request->stamping_working_report_id,
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'total_minutes' => $request->total_minutes,
                        'work_details' => $request->work_details,
                        'sequence_number' => $request->sequence_number,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    DB::commit();
                    return response()->json(['hasError' => false]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
                }
            }
        }else{ /* For Edit */
            $rules = [
                'stamping_working_report_id' => 'required',
                'stamping_working_report_work_details_id' => 'required',
                'time_start' => 'required',
                'time_end' => 'required',
                'total_minutes' => 'required',
                'work_details' => 'required',
                'sequence_number' => 'required',
            ];
            
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validatorHasError' => true, 'validatorMessages' => $validator->messages()]);
            }else {
                DB::beginTransaction();
                try {
                    DB::table('stamping_working_report_work_details')->where('id', $request->stamping_working_report_work_details_id)->update([
                        'stamping_working_report_id' => $request->stamping_working_report_id,
                        'time_start' => $request->time_start,
                        'time_end' => $request->time_end,
                        'total_minutes' => $request->total_minutes,
                        'work_details' => $request->work_details,
                        'sequence_number' => $request->sequence_number,
                        'last_updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    
                    DB::commit();
                    return response()->json(['hasError' => false]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
                }
            }
        }
    }

    public function getStampingWorkingReportWorkDetailsById(Request $request){
        $getStampingWorkingReportByIdResult = DB::table('stamping_working_report_work_details')
        ->leftJoin('stamping_working_reports', 'stamping_working_report_work_details.stamping_working_report_id', '=', 'stamping_working_reports.id')
        ->where('stamping_working_report_work_details.id', $request->id)
        ->where('stamping_working_report_work_details.deleted_at', '=', NULL)
        ->select(
            'stamping_working_report_work_details.id',
            'stamping_working_report_work_details.stamping_working_report_id',
            'stamping_working_report_work_details.time_start',
            'stamping_working_report_work_details.time_end',
            'stamping_working_report_work_details.total_minutes',
            'stamping_working_report_work_details.work_details',
            'stamping_working_report_work_details.sequence_number',
        )
        ->get();
        // return $getStampingWorkingReportByIdResult;
        return response()->json(['data' => $getStampingWorkingReportByIdResult]);
    }
}

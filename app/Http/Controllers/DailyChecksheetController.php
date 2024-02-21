<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\DailyChecksheet;
use App\Models\WeeklyChecksheet;
use App\Models\User;

class DailyChecksheetController extends Controller
{
    public function viewDailyChecksheet(Request $request){
        $daily_checksheet_details = DailyChecksheet::with(['machine_details'])
        // ->where('status', 0)
        ->get();

        return DataTables::of($daily_checksheet_details)
        ->addColumn('action', function($daily_checksheet_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-primary btn-sm btnView' data-status='$daily_checksheet_details->status' data-id='$daily_checksheet_details->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";
            
            // if($daily_checksheet_details->status == 0 && in_array( session()->get('position'), [0,1,2])){
            //     $result .= "<button class='btn btn-secondary btn-sm ml-1 btnCheck' data-status='$daily_checksheet_details->status' data-id='$daily_checksheet_details->id'><i class='fas fa-tools'></i></button>";
            // }
            // else if($daily_checksheet_details->status == 1){
            //     $result .= "<button class='btn btn-info btn-sm ml-1 btnConform' data-id='$daily_checksheet_details->id'  data-function='1'><i class='fa-solid fa-pen-to-square'></i></button>";
            // }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($daily_checksheet_details){
            $result = "";
            $result .= "<center>";
            if($daily_checksheet_details->status == 0){
                $result .= "<span class='badge bg-secondary text-light'>For Engineer Verification</span>";
            }
            else if($daily_checksheet_details->status == 1){
                $result .= "<span class='badge bg-info text-light'>For QC Verification</span><br>";
            }else{
                $result .= "<span class='badge bg-success text-light'>Done</span>";
            }
            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function viewWeeklyChecksheet(Request $request){
        $weekly_checksheet_details = WeeklyChecksheet::with(['machine_details'])
        // ->where('status', 0)
        ->get();

        return DataTables::of($weekly_checksheet_details)
        ->addColumn('action', function($weekly_checksheet_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-primary btn-sm btnViewWeeklyChecksheet' data-status='$weekly_checksheet_details->status' data-id='$weekly_checksheet_details->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";
            
            // if($weekly_checksheet_details->status == 0 && in_array( session()->get('position'), [0,1,2])){
            //     $result .= "<button class='btn btn-secondary btn-sm ml-1 btnCheck' data-status='$weekly_checksheet_details->status' data-id='$weekly_checksheet_details->id'><i class='fas fa-tools'></i></button>";
            // }
            // else if($weekly_checksheet_details->status == 1){
            //     $result .= "<button class='btn btn-info btn-sm ml-1 btnConform' data-id='$weekly_checksheet_details->id'  data-function='1'><i class='fa-solid fa-pen-to-square'></i></button>";
            // }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($weekly_checksheet_details){
            $result = "";
            $result .= "<center>";
            if($weekly_checksheet_details->status == 0){
                $result .= "<span class='badge bg-secondary text-light'>For Engineer Verification</span>";
            }
            else if($weekly_checksheet_details->status == 1){
                $result .= "<span class='badge bg-info text-light'>For QC Verification</span><br>";
            }else{
                $result .= "<span class='badge bg-success text-light'>Done</span>";
            }
            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function addDailyChecksheet(Request $request){
        $mutable = Carbon::now()->format('Y-m-d');
        $user_details = User::where('employee_id', $request->scanned_id)->first();

        $data = $request->all();

        // return $mutable;

        $daily_checksheet_array = array(
            'unit_no'    => $request->unit_no,
            'machine_id'             => $request->machine,
            'date'         => $request->date,
            'time'              => $request->time,
            'division'             => $request->division,
            'area'             => $request->machine_area,
            'month'       => $request->month,
            'conformed_by'     => $request->conformed_by,
            'actual_measurement_d1'            => $request->actual_measurement,
            'result_d1'          => $request->result_1,
            'actual_measurement_d2'       => $request->actual_measurement2,
            'result_d2' => $request->result_2,
            'result_d3' => $request->result_3,
            'result_d4' => $request->result_4,
            'result_d5' => $request->result_5,
            'result_d6' => $request->result_6,
            'result_d7' => $request->result_7,
            'result_d8' => $request->result_8,
            'result_d9' => $request->result_9,
            'result_d10' => $request->result_10,
            'result_d11' => $request->result_11,
            'result_d12' => $request->result_12,
            'result_d13' => $request->result_13,
            'conducted_by_operator'       => $user_details->firstname." ".$user_details->lastname,
            'created_by'       => session()->get('user_id'),
            'created_at'       => NOW()
        );

        if(isset($request->checksheet_id)){ // EDIT
            DB::beginTransaction();
            try{
                $daily_checksheet_array['status'] = 0;


                DailyChecksheet::where('id', $request->daily_checksheet_id)
                ->update($daily_checksheet_array);
                DB::commit();
                return response()->json([
                    'result' => true
                ]);
            }
            catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }
        else{ // ADD
            if( $mutable == $request->date){ // check if data exist on today's date

                $check_checklist_exist = DB::connection('mysql')
                ->table('daily_checksheets')
                ->select('*')
                ->where('date', $request->date)
                ->where('machine_id', $request->machine)
                ->first();
                
                if(!isset($check_checklist_exist)){
                    $insert = $this->insert_daily_chksheet_data($request, $daily_checksheet_array);

                    if($insert == true){
                        return response()->json([
                            'result' => true
                        ]);
                    }
                }
                else{
                    return response()->json([
                        "result" => false,
                        "msg"   => "Data already exist for today's date."
                    ], 409);
                }
            }
        }

    }

    function insert_daily_chksheet_data($request, $daily_checksheet_array){
        DB::beginTransaction();

        try{
            
            DailyChecksheet::insert($daily_checksheet_array);
            DB::commit();

            return true;

        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
        
    }

    public function getDailyChecksheetData(Request $request){
        $daily_checksheet_data = DB::connection('mysql')
        ->table('daily_checksheets AS a')
        ->leftJoin('users AS b', 'a.created_by', '=', 'b.id')
        ->select('a.*', 'b.firstname', 'b.lastname')
        ->where('a.id', $request->id)
        ->first();

        return $daily_checksheet_data;
    }

    public function updateStatusCheckedBy(Request $request){
        date_default_timezone_set('Asia/Manila');
        $user_details = User::where('employee_id', $request->scanned_emp_id)->first();

        $data = $request->all();

        // return $data;

        $array = [
            'checked_by_engineer'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 1,
        ];

        DailyChecksheet::where('id', $request->daily_checksheet_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function updateStatusConformedBy(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;
        $user_details = User::where('employee_id', $request->scanned_qc_id)->first();

        $array = [
            'conformed_by_qc'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 2,
        ];

        DailyChecksheet::where('id', $request->daily_checksheet_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function addWeeklyChecksheet(Request $request){
        $user_details = User::where('employee_id', $request->scanned_id)->first();

        $week_now = Carbon::now()->weekOfMonth;

        // return $week_now;
        // return $request->week;

        $data = $request->all();

        $weekly_checksheet_array = array(
            'unit_no'    => $request->weekly_unit_no,
            'machine_id'             => $request->machine_weekly,
            'date'         => $request->date_weekly,
            'time'              => $request->time_weekly,
            'division'             => $request->weekly_division,
            'area'             => $request->machine_area_weekly,
            'month'       => $request->weekly_month,
            'conformed_by'     => $request->conformed_by_weekly,
            'week'          => $request->week,
            'result_w1'          => $request->result_w1,
            'result_w2'          => $request->result_w2,
            'result_w3'          => $request->result_w3,
            'conducted_by_operator'       => $user_details->firstname." ".$user_details->lastname,
            'created_by'       => session()->get('user_id'),
            'created_at'       => NOW()
        );

        if(isset($request->checksheet_id)){ // EDIT
            DB::beginTransaction();
            try{
                $weekly_checksheet_array['status'] = 0;

                WeeklyChecksheet::where('id', $request->weekly_checksheet_id)
                ->update($weekly_checksheet_array);
                DB::commit();
                return response()->json([
                    'result' => true
                ]);
            }
            catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }
        else{ // ADD
            if($week_now == $request->week){ // check if data exist on today's week

                $check_checklist_exist = DB::connection('mysql')
                ->table('weekly_checksheets')
                ->select('*')
                // ->where('date', $request->date)
                ->where('week', $request->week)
                ->where('machine_id', $request->machine_weekly)
                ->first();

                // return $check_checklist_exist;
                
                if(!isset($check_checklist_exist)){
                    $insert = $this->insert_weekly_chksheet_data($request, $weekly_checksheet_array);

                    if($insert == true){
                        return response()->json([
                            'result' => true
                        ]);
                    }
                }
                else{
                    return response()->json([
                        "result" => false,
                        "msg"   => "Data already exist for today's date."
                    ], 409);
                }
            }
        }
    }

    function insert_weekly_chksheet_data($request, $weekly_checksheet_array){
        DB::beginTransaction();

        try{
            
            WeeklyChecksheet::insert($weekly_checksheet_array);
            DB::commit();

            return true;

        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
        
    }

    public function getWeeklyChecksheetData(Request $request){
        $weekly_checksheet_data = DB::connection('mysql')
        ->table('weekly_checksheets AS a')
        ->leftJoin('users AS b', 'a.created_by', '=', 'b.id')
        ->select('a.*', 'b.firstname', 'b.lastname')
        ->where('a.id', $request->id)
        ->first();

        return $weekly_checksheet_data;
    }

    
    public function updateWeeklyStatusCheckedBy(Request $request){
        date_default_timezone_set('Asia/Manila');
        $user_details = User::where('employee_id', $request->engineering_scanned_id)->first();

        $data = $request->all();

        // return $data;

        $array = [
            'checked_by_engineer'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 1,
        ];

        WeeklyChecksheet::where('id', $request->weekly_checksheet_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function updateWeeklyStatusConformedBy(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;
        $user_details = User::where('employee_id', $request->qc_scanned_weekly_id)->first();

        $array = [
            'conformed_by_qc'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 2,
        ];

        WeeklyChecksheet::where('id', $request->weekly_checksheet_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    // 

    // 

    // public function getWeeklyMachine(Request $request){
    //     return DB::connection('mysql')
    //     ->table('stamping_checksheet_machine_dropdowns')
    //     ->get();
    // }
    
}

<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stamping5sChecksheet;
use Illuminate\Support\Facades\Auth;
use App\Models\StampingChecksheetMachineDropdown;


class StampingChecksheetController extends Controller
{
    public function view_checksheet(Request $request){
        session_start();

        $five_s_checksheet = DB::connection('mysql')
        ->table('stamping5s_checksheets AS a')
        ->join('stamping_checksheet_machine_dropdowns AS b', 'a.machine_id', '=', 'b.id')
        ->select('a.*', 'b.machine_name')
        ->whereNull('deleted_at')
        ->get();

        return DataTables::of($five_s_checksheet)
        ->addColumn('action', function($five_s_checksheet){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-primary btn-sm btnView' data-id='$five_s_checksheet->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";
            
            if($five_s_checksheet->status == 0 && in_array( $_SESSION['position'], [0,1,2])){
                $result .= "<button class='btn btn-success btn-sm ml-1 btnCheck' data-id='$five_s_checksheet->id'><i class='fa-solid fa-list-check'></i></button>";
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($five_s_checksheet){
            $result = "";
            $result .= "<center>";
            if($five_s_checksheet->status == 0){
                $result .= "<span class='badge bg-info text-light'>For Approval</span>";
            }
            else if($five_s_checksheet->status == 1){
                $result .= "<span class='badge bg-success text-light'>Approved</span><br>";
                $result .= "<span class='badge bg-success text-light'>Done</span>";

            }
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    public function save_checksheet(Request $request){
        
            $mutable = Carbon::now()->format('Y-m-d');

            if( $mutable == $request->date && $request->shift == "A" ){ // check if data exist on shift A

                $check_checklist_exist = DB::connection('mysql')
                ->table('stamping5s_checksheets')
                ->select('*')
                ->where('date', $request->date)
                ->where('machine_id', $request->machine)
                ->where('shift', "A")
                ->first();
                
                if(!isset($check_checklist_exist)){
                    $insert = $this->insert_check_data($request);

                    if($insert == true){
                        return response()->json([
                            'result' => true
                        ]);
                    }
                }
                else{
                    return response()->json([
                        "result" => false,
                        "msg"   => "Data already exist for today's shift."
                    ], 409);
                }
            }
            else{
                $dt = Carbon::create($request->date);
                $dt->addDay();
                $eto = $dt->format('Y-m-d');  

                return $eto;
            }
    }

    function insert_check_data($request){
        DB::beginTransaction();

        try{
            $user_details = User::where('employee_id', $request->scanned_id)->first();

            $stamping_5s_checksheet_array = array(
                'assembly_line'    => $request->asmbly_line,
                'dept'             => $request->dept_sect,
                'division'         => $request->division,
                'oic'              => $request->oic,
                'date'             => $request->date,
                'time'             => $request->time,
                'checked_by'       => $request->check_by,
                'conducted_by'     => $user_details->firstname." ".$user_details->lastname,
                'shift'            => $request->shift,
                'machine_id'       => $request->machine,
                'remarks'          => $request->remarks,
                'checksheet_A_1_1' => $request->checkA1_1,
                'checksheet_A_1_2' => $request->checkA1_2,
                'checksheet_A_1_3' => $request->checkA1_3,
                'checksheet_A_1_4' => $request->checkA1_4,
                'checksheet_A_1_5' => $request->checkA1_5,
                'checksheet_A_1_6' => $request->checkA1_6,
                'checksheet_A_2_1' => $request->checkA2_1,
                'checksheet_A_2_2' => $request->checkA2_2,
                'checksheet_A_2_3' => $request->checkA2_3,
                'checksheet_A_2_4' => $request->checkA2_4,
                'checksheet_A_3_1' => $request->checkA3_1,
                'created_by'       => Auth::user()->id,
                'created_at'       => NOW()
            );

            Stamping5sChecksheet::insert($stamping_5s_checksheet_array);
            DB::commit();

            return true;

        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
        
    }
    
    public function get_machine_dropdown(Request $request){
        return DB::connection('mysql')
        ->table('stamping_checksheet_machine_dropdowns')
        ->get();
    }

    public function change_status(Request $request){
        session_start();

        DB::beginTransaction();
        try{
            Stamping5sChecksheet::where('id', $request->id)
            ->update([
                'status' => $request->status,
                'checked_by' => $_SESSION['user_id']
            ]);

            DB::commit();
            return response()->json(['result' => true]);

        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    public function get_checksheet_data(Request $request){
        $checksheet_details = DB::connection('mysql')
        ->table('stamping5s_checksheets AS a')
        ->leftJoin('users AS b', 'a.checked_by', '=', 'b.id')
        ->select('a.*', 'b.firstname', 'b.lastname')
        ->where('a.id', $request->id)
        ->first();

        return $checksheet_details;
    }
}

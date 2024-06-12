<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\IssueLog;
use Illuminate\Http\Request;
use App\Models\AssemblyPreProd;


use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssemblyPreProdController extends Controller
{
    public function viewAssemblyPreProd(Request $request){
        $assembly_pre_prod_details = AssemblyPreProd::get();

        return DataTables::of($assembly_pre_prod_details)
        ->addColumn('action', function($assembly_pre_prod_details){
            $result = "";
            $result .= "<center>";
            
            $result .= "<button class='btn btn-primary btn-sm btnView' assembly-status='$assembly_pre_prod_details->status' data-id='$assembly_pre_prod_details->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";
            
            // if($assembly_pre_prod_details->status == 0 && in_array( session()->get('position'), [0,1,2])){
            //     $result .= "<button class='btn btn-secondary btn-sm ml-1 btnCheck' data-status='$assembly_pre_prod_details->status' data-id='$assembly_pre_prod_details->id'><i class='fas fa-tools'></i></button>";
            // }
            // else if($assembly_pre_prod_details->status == 1){
            //     $result .= "<button class='btn btn-info btn-sm ml-1 btnConform' data-id='$assembly_pre_prod_details->id'  data-function='1'><i class='fa-solid fa-pen-to-square'></i></button>";
            // }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($assembly_pre_prod_details){
            $result = "";
            $result .= "<center>";
            if($assembly_pre_prod_details->status == 0){
                $result .= "<span class='badge bg-secondary text-light'>For Engineer Verification</span>";
            }
            else if($assembly_pre_prod_details->status == 1){
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

    public function addAssemblyPreProd(Request $request){
        date_default_timezone_set('Asia/Manila');
        $mutable = Carbon::now()->format('Y-m-d');
        $user_details = User::where('employee_id', $request->scanned_id)->first();

        $data = $request->all();

        // return $data;

        $validate_array = [
        'equipment_name' => 'required', 
        'machine_code' => 'required', 
        'remarks' => 'required',
        'shift' => 'required',
        'check_1' => 'required',
        'check_2' => 'required',
        'check_3' => 'required',
        'value_1' => 'required',
        'judgement_1' => 'required',
        'value_2' => 'required',
        'judgement_2' => 'required',
        'value_3' => 'required',
        'judgment_3' => 'required',
        'value_4' => 'required',
        'value_5' => 'required',
        'judgment_5' => 'required',
        'judgment_6' => 'required',
        'value_6' => 'required'
    ];
        

        $validator = Validator::make($data, $validate_array);

        if ($validator->fails()) {
            return response()->json([
                "result" => false,
                "msg"   => "Please fill-up all data!"
            ], 409);
        }else {
                $assembly_pre_prod_array = array(
                    'status'            => 0,
                    'equipment_name'    => $request->equipment_name,
                    'machine_code'      => $request->machine_code,
                    'date'              => $request->date,
                    'time'              => $request->time,
                    'month'             => $request->month,
                    'remarks'           => $request->remarks,
                    'shift'             => $request->shift,
                    'check_1'           => $request->check_1,
                    'check_2'           => $request->check_2,
                    'check_3'           => $request->check_3,
                    'value_1'           => $request->value_1,
                    'judgment_1'        => $request->judgement_1,
                    'value_2'           => $request->value_2,
                    'judgment_2'        => $request->judgement_2,
                    'value_3'           => $request->value_3,
                    'judgment_3'        => $request->judgment_3,
                    'value_4'           => $request->value_4,
                    'value_5'           => $request->value_5,
                    'judgment_5'        => $request->judgment_5,
                    'value_6'           => $request->value_6,
                    'judgment_6'        => $request->judgment_6,
                    'logdel'            => 0,
                    'conducted_by_operator'       => $user_details->firstname." ".$user_details->lastname,
                    'created_by'       => session()->get('user_id'),
                    'created_at'       => NOW()
                );
            
            if(isset($request->assembly_pre_prod_id)){ // EDIT
                DB::beginTransaction();
                try{
                    $assembly_pre_prod_array['status'] = 0;

                    AssemblyPreProd::where('id', $request->assembly_pre_prod_id)
                    ->update($assembly_pre_prod_array);
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

                    $check_assembly_pre_prod_exist = DB::connection('mysql')
                    ->table('assembly_pre_prods')
                    ->select('*')
                    ->where('date', $request->date)
                    ->where('logdel', 0)
                    ->first();
                    
                    if(!isset($check_assembly_pre_prod_exist)){
                        $insert = $this->insert_assembly_pre_prod_data($request, $assembly_pre_prod_array);

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
            
    }

    function insert_assembly_pre_prod_data($request, $assembly_pre_prod_array){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try{
            
            AssemblyPreProd::insert($assembly_pre_prod_array);
            DB::commit();
            return true;
        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
        
    }

    public function getAssemblyPreProdData(Request $request){
        $assembly_pre_prod_data = DB::connection('mysql')
        ->table('assembly_pre_prods AS a')
        ->leftJoin('users AS b', 'a.created_by', '=', 'b.id')
        ->select('a.*', 'b.firstname', 'b.lastname')
        ->where('a.id', $request->id)
        ->where('logdel', 0)
        ->first();

        return $assembly_pre_prod_data;
    }

    public function updateAssemblyCheckedByStatus(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $user_details = User::where('employee_id', $request->scanned_emp_id)->first();

        $array = [
            'checked_by_engineer'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 1,
        ];

        AssemblyPreProd::where('id', $request->assembly_checked_pre_prod_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    
    public function updateAssemblyConformedByStatus(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $user_details = User::where('employee_id', $request->scanned_emp_id)->first();

        $array = [
            'conformed_by_qc'   => $user_details->firstname." ".$user_details->lastname,
            'status'                => 2,
        ];

        AssemblyPreProd::where('id', $request->assembly_conformed_pre_prod_id)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function viewIssueLogs(Request $request){
        $issue_log_details = IssueLog::get();

        return DataTables::of($issue_log_details)
        ->addColumn('action', function($issue_log_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-primary btn-sm btnViewLogs' data-status='$issue_log_details->status' data-id='$issue_log_details->id' data-function='0'><i class='fa-solid fa-edit'></i></button>";
            
            // if($issue_log_details->status == 0 && in_array( session()->get('position'), [0,1,2])){
            //     $result .= "<button class='btn btn-secondary btn-sm ml-1 btnCheck' data-status='$issue_log_details->status' data-id='$issue_log_details->id'><i class='fas fa-tools'></i></button>";
            // }
            // else if($issue_log_details->status == 1){
            //     $result .= "<button class='btn btn-info btn-sm ml-1 btnConform' data-id='$issue_log_details->id'  data-function='1'><i class='fa-solid fa-pen-to-square'></i></button>";
            // }
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);
    }

    public function addIssue(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        if(!isset($request->issue_id)){

            $array = [
                'issue'                 => $request->issue,
                'date'                  => $request->issue_date,
                'created_at'            => date('Y-m-d H:i:s'),
                'created_by'            => Auth::user()->id,
            ];
            // return $oqc_id;
            
            IssueLog::insert($array);

            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }else{
            IssueLog::where('id', $request->issue_id)
            ->update([
                    'issue'              => $request->issue,
                    'date'               => $request->issue_date,
                    'updated_at'         => date('Y-m-d H:i:s'),
            ]);

            return response()->json(['result' => 0, 'message' => "Edit SuccessFully Saved!"]);
        }
    }

    public function getIssueLogs(Request $request){
        $issue_logs = DB::connection('mysql')
        ->table('issue_logs AS a')
        ->where('a.id', $request->id)
        ->first();

        return $issue_logs;
    }


}

<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProcessController extends Controller
{
    public function view_process(Request $request){
        $process_details = Process::where('status', 0)->get();

        return DataTables::of($process_details)
        ->addColumn('action', function($process_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-secondary btn-sm btnEdit mr-1' data-id='$process_details->id'><i class='fa-solid fa-pen-to-square'></i></button>";
            if($process_details->status == 0){
                $result .= "<button class='btn btn-danger btn-sm btnDisable' data-id='$process_details->id'><i class='fa-solid fa-ban'></i></button>";
            }
            else{
                $result .= "<button class='btn btn-success btn-sm btnEnable' data-id='$process_details->id'><i class='fa-solid fa-rotate-left'></i></button>";
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('label', function($process_details){
            $result = "";
            $result .= "<center>";

            if($process_details->status == 0){
                $result .= "<span class='badge rounded-pill bg-success'>Active</span>";
            }
            else{
                $result .= "<span class='badge rounded-pill bg-danger'>Inactive</span>";

            }
            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['action', 'label'])
        ->make(true);
    }

    public function add_process(Request $request){

        if(!isset($request->id)){
            $validation = array(
                'process_name' => ['required', 'string', 'max:255', 'unique:processes']
            );
        }
        else{
            $validation = array(
                // 'name' => ['required', 'string', 'max:255', 'unique:devices'],
                'process_name' => ['required', 'string', 'max:255']
            );
        }

        $data = $request->all();
        $validator = Validator::make($data, $validation);
        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();

            try{
                $process_array = array(
                    'process_name' => $request->process_name
                );
                if(isset($request->id)){ // EDIT
                    Process::where('id', $request->id)
                    ->update($process_array);
                }
                else{ // ADD
                    Process::insert($process_array);
                }

                DB::commit();

                return response()->json(['result' => 1, 'msg' => 'Transaction Succesful']);
            }
            catch(Exemption $e){
                DB::rollback();
                return $e;
            }

            

        }
    }

    public function get_process_by_id(Request $request){
        return Process::where('id', $request->id)->first();
    }

    public function update_status(Request $request){
        
        // DB::beginTransaction();
        // try{
        //     // Device::where('id', )
        // }catch(Exemption $e){
        //     DB::rollback();
        //     return $e;
        // }
    }
}

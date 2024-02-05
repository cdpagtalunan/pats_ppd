<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\defectsInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DefectsInfoController extends Controller
{
    public function view_defectsinfo(Request $request){
        $defect_details = defectsInfo::where('status', 0)->get();

        return DataTables::of($defect_details)
        ->addColumn('action', function($defect_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-secondary btn-sm btnEdit mr-1' data-id='$defect_details->id'><i class='fa-solid fa-pen-to-square'></i></button>";
            if($defect_details->status == 0){
                $result .= "<button class='btn btn-danger btn-sm btnDisable' data-id='$defect_details->id'><i class='fa-solid fa-ban'></i></button>";
            }
            else{
                $result .= "<button class='btn btn-success btn-sm btnEnable' data-id='$defect_details->id'><i class='fa-solid fa-rotate-left'></i></button>";
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('label', function($defect_details){
            $result = "";
            $result .= "<center>";

            if($defect_details->status == 0){
                $result .= "<span class='badge rounded-pill bg-success'>Active</span>";
            }
            else{
                $result .= "<span class='badge rounded-pill bg-danger'>Inactive</span>";

            }
            $result .= "</center>";

            return $result;
        })
        ->addColumn('station', function($defect_details){
            $result = "";
            $result .= "<center>";

            if($defect_details->station == 0){
                $result .= "Camera NG";
            }
            else{
                $result .= "Visual Defect";

            }
            $result .= "</center>";

            return $result;
        })
        ->rawColumns(['action', 'label', 'station'])
        ->make(true);
    }

    public function add_defects(Request $request){

        if(!isset($request->id)){
            $validation = array(
                'station' => ['required', 'string', 'max:255'],
                'defects' => ['required', 'string', 'max:255']
            );
        }
        else{
            $validation = array(
                'station' => ['required', 'string', 'max:255'],
                'defects' => ['required', 'string', 'max:255']
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
                    'station' => $request->station,
                    'defects' => $request->defects
                );
                if(isset($request->id)){ // EDIT
                    defectsInfo::where('id', $request->id)
                    ->update($process_array);
                }
                else{ // ADD
                    defectsInfo::insert($process_array);
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

    public function get_defects_by_id(Request $request){
        return defectsInfo::where('id', $request->id)->first();
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

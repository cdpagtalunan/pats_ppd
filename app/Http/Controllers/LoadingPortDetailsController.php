<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\LoadingPortDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoadingPortDetailsController extends Controller
{
    public function viewLoadingPortDetails(Request $request){
        $loading_port_data = LoadingPortDetails::all();

        return DataTables::of($loading_port_data)
        ->addColumn('action', function($loading_port_data){
            $result = "";
            $result .= "<center>";
            if($loading_port_data->status == 0){
                $result .= "<button class='btn btn-info btn-sm btnEditLoadingPortDetails' data-id='$loading_port_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                $result .= "<button class='btn btn-danger btn-sm btnEditLoadingPortDetailsStatus' data-id='$loading_port_data->id'><i class='fa-solid fa-x'></i></button>";
            }else{
                $result .= "<button class='btn btn-info btn-sm btnRestoreLoadingPortDetailsStatus' data-id='$loading_port_data->id'><i class='fa-solid fa-undo'></i></button>";
            }   
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($loading_port_data){
            $result = "";
            $result .= "<center>";

            if($loading_port_data->status == 0){
                $result .= '<span class="badge bg-success">Active</span>';
            }
            else{
                $result .= '<span class="badge bg-danger">Disabled</span>';
            }
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function addLoadingPortDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // return $data;

        $rules = [
            'loading_port'                 => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                $array = [
                    'loading_port'     => $request->loading_port,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
                if(isset($request->loading_port_details_id)){ // edit
                    LoadingPortDetails::where('id', $request->loading_port_details_id)
                    ->update($array);
                }
                else{ // insert
                    LoadingPortDetails::insert($array);
                }

                return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function getLoadingPortDetailsById(Request $request){
        
        $loading_port_details = LoadingPortDetails::
        where('id', $request->loading_port_details_id)
        ->get();

        return response()->json(['loadingPortDetails' => $loading_port_details]);
    }

    public function editLoadingPortDetailsStatus(Request $request){
        LoadingPortDetails::where('id', $request->loading_port_details_id)
        ->update([
            'status' => 1,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function restoreLoadingPortDetailsStatus(Request $request){
        LoadingPortDetails::where('id', $request->loading_port_details_id)
        ->update([
            'status' => 0,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }
}

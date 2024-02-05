<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\DestinationPortDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DestinationPortDetailsController extends Controller
{
    public function viewDestinationPortDetails(Request $request){
        $destination_port_data = DestinationPortDetails::all();

        return DataTables::of($destination_port_data)
        ->addColumn('action', function($destination_port_data){
            $result = "";
            $result .= "<center>";
            if($destination_port_data->status == 0){
                $result .= "<button class='btn btn-info btn-sm btnEditDestinationPortDetails' data-id='$destination_port_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                $result .= "<button class='btn btn-danger btn-sm btnEditDestinationPortDetailsStatus' data-id='$destination_port_data->id'><i class='fa-solid fa-x'></i></button>";
            }else{
                $result .= "<button class='btn btn-info btn-sm btnRestoreDestinationPortDetailsStatus' data-id='$destination_port_data->id'><i class='fa-solid fa-undo'></i></button>";
            }   
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($destination_port_data){
            $result = "";
            $result .= "<center>";

            if($destination_port_data->status == 0){
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

    public function addDestinationPortDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // return $data;

        $rules = [
            'destination_port'                 => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                $array = [
                    'destination_port'     => $request->destination_port,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
                if(isset($request->destination_port_details_id)){ // edit
                    DestinationPortDetails::where('id', $request->destination_port_details_id)
                    ->update($array);
                }
                else{ // insert
                    DestinationPortDetails::insert($array);
                }

                return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function getDestinationPortDetailsById(Request $request){
        $destination_port_details = DestinationPortDetails::
        where('id', $request->destination_port_details_id)
        ->get();

        // return $CarrierDetails;

        return response()->json(['destinationPortDetails' => $destination_port_details]);
    }

    public function editDestinationPortDetailsStatus(Request $request){
        date_default_timezone_set('Asia/Manila');
        DestinationPortDetails::where('id', $request->destination_port_details_id)
        ->update([
            'status' => 1,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function restoreDestinationPortDetailsStatus(Request $request){
        date_default_timezone_set('Asia/Manila');
        DestinationPortDetails::where('id', $request->destination_port_details_id)
        ->update([
            'status' => 0,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }
    
}

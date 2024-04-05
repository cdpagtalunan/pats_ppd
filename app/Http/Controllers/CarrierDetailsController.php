<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\CarrierDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarrierDetailsController extends Controller
{
    public function viewCarrierDetails(Request $request){
        $carrier_data = CarrierDetails::all();

        return DataTables::of($carrier_data)
        ->addColumn('action', function($carrier_data){
            $result = "";
            $result .= "<center>";
            if($carrier_data->status == 0){
                $result .= "<button class='btn btn-info btn-sm btnEditCarrierDetails' data-id='$carrier_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                $result .= "<button class='btn btn-danger btn-sm btnEditCarrierDetailsStatus' data-id='$carrier_data->id'><i class='fa-solid fa-x'></i></button>";
            }else{
                $result .= "<button class='btn btn-info btn-sm btnRestoreCarrierDetailsStatus' data-id='$carrier_data->id'><i class='fa-solid fa-undo'></i></button>";
            }   
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($carrier_data){
            $result = "";
            $result .= "<center>";

            if($carrier_data->status == 0){
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

    public function addCarrierDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        // return $data;

        $rules = [
            'carrier_name'                 => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                $array = [
                    'carrier_name'     => $request->carrier_name,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                ];
                if(isset($request->carrier_details_id)){ // edit
                    // return 'if';
                    CarrierDetails::where('id', $request->carrier_details_id)
                    ->update($array);
                }
                else{ // insert
                    // return 'else';
                    CarrierDetails::insert($array);
                }

                return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function getCarrierDetailsById(Request $request){
        $carrier_details = CarrierDetails::
        where('id', $request->carrier_details_id)
        ->get();

        // return $CarrierDetails;

        return response()->json(['carrierDetails' => $carrier_details]);
    }

    public function editCarrierDetailsStatus(Request $request){
        date_default_timezone_set('Asia/Manila');
        CarrierDetails::where('id', $request->carrier_details_id)
        ->update([
            'status' => 1,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function restoreCarrierDetailsStatus(Request $request){
        CarrierDetails::where('id', $request->carrier_details_id)
        ->update([
            'status' => 0,
        ]);
        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }
}
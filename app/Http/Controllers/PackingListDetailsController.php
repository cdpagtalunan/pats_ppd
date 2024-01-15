<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\PackingListDetails;
use App\Models\CustomerDetails;
use App\Models\CarrierDetails;
use App\Models\LoadingPortDetails;
use App\Models\DestinationPortDetails;
use App\Models\FirstStampingProduction;
use App\Models\User;

class PackingListDetailsController extends Controller
{
    public function getCustomerDetails(Request $request){
        $customer_details = CustomerDetails::
        where('status',0)
        ->get();
        
        return response()->json(['customerDetails' => $customer_details]);
    }
    public function getCarrierDetails(Request $request){
        $carrier_details = CarrierDetails::
        where('status',0)
        ->get();

        return response()->json(['carrierDetails' => $carrier_details]);
    }

    public function getLoadingPortDetails(Request $request){
        $loading_port_details = LoadingPortDetails::
        where('status', 0)
        ->get();

        return response()->json(['loadingPortDetails' => $loading_port_details]);
    }

    public function getDestinationPortDetails(Request $request){
        $destination_port_details = DestinationPortDetails::
        where('status',0)
        ->get();

        return response()->json(['destinationPortDetails' => $destination_port_details]);
    }

    public function getPpcClerk(Request $request){
        $user_details = User::
        where('status',1)
        // ->where('position', 10)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    public function getPpcSrPlanner(Request $request){
        $user_details = User::
        where('status',1)
        // ->where('position', 8)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    public function carbonCopyUser(Request $request){
        $user_details = User::
        where('status',1)
        // ->where('position', 8)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    

    public function viewPackingListData(Request $request){
        $packing_list_data = PackingListDetails::
        where('status', 0)
        ->get();

        return DataTables::of($packing_list_data)
            ->addColumn('action', function($packing_list_data){
                $result = "";
                $result .= "<center>";
                if($packing_list_data->status == 0 ){
                    // $result .= "<input class='test d-none packing_$packing_list_data->id' data-packing-id='$packing_list_data->id' type'text' style='width: 30px; text-align: center;' id='boxNoId' name='box_no[]' disabled>";
                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($packing_list_data){
                $result = "";
                $result .= "<center>";

                if($packing_list_data->status == 0){
                    $result .= '<span class="badge bg-success">Active</span>';
                }
                else{
                    $result .= '<span class="badge bg-danger">Disabled</span>';
                }
                $result .= "</center>";
                return $result;
            })
            // ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
    }


    public function viewProductionData(Request $request){
        $production_data = FirstStampingProduction::
        where('status', 2)
        ->get();

        // return $production_data;
        if(!isset($request->search_data)){
            return [];
        }else{
            
            return DataTables::of($production_data)
            ->addColumn('action', function($production_data){
                $result = "";
                $result .= "<center>";
                if($production_data->status == 2 ){
                    $result .= "<input class='test d-none packing_$production_data->id' data-packing-id='$production_data->id' type'text' style='width: 30px; text-align: center;' id='boxNoId' name='box_no[]' disabled>";
                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($production_data){
                $result = "";
                $result .= "<center>";

                if($production_data->status == 2){
                    $result .= '<span class="badge bg-success">Active</span>';
                }
                else{
                    $result .= '<span class="badge bg-danger">Disabled</span>';
                }
                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
        }
    }

    public function getDataFromProduction(Request $request){
        $get_production_data = FirstStampingProduction::
        where('po_num', 'like', '%' . $request->search_data . '%')->get();

        // return $request->search_data;

        return response()->json(['productionData' => $get_production_data]);
    }

    public function addPackingListData(Request $request){

        $data = $request->all();

        $prod_id = [
            "prod_id" => [],
        ];

        // $box_no = implode(',',$request->box_no);

        // $date_time = $request->pickup_date_and_time;

        // return $request->pickup_date_and_time;

        // return 
        $date = substr($request->pickup_date_and_time,0,10);
        $time = substr($request->pickup_date_and_time,11,16);

        // return gettype($box_no);
       
        
        if(count($request->packing_list_data_array) > 0){
            for ($i=0; $i < count($request->packing_list_data_array); $i++) { 
                array_push($prod_id['prod_id'], $request->packing_list_data_array);
            }
        }

        $prod_data = FirstStampingProduction::
        whereIn('id', $prod_id['prod_id'])
        ->get();

        // return $prod_data;

        // return gettype($prod_data);
        $material_name = "";
        $prod_lot_no = "";
        $qty = "";
        $prod_id = "";
        $imploded_cc = implode($request->carbon_copy, ', ');


        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            for ($i=0; $i <count($prod_data) ; $i++) { 
                $prod_id = $prod_data[$i]->id;
                $material_name = $prod_data[$i]->material_name;
                $prod_lot_no = $prod_data[$i]->prod_lot_no;
                $qty = $prod_data[$i]->ship_output;

            
                        $array = [
                            'control_no'     => $request->ctrl_num,
                            'prod_id'     => $prod_id,
                            'po_no' => $request->search_packing_list_details,
                            'box_no' => $request->box_no[$i],
                            'mat_name' => $material_name,
                            'lot_no' => $prod_lot_no,
                            'quantity' => $qty,
                            'pick_up_date' => $date,
                            'pick_up_time' => $time,
                            'product_from' => $request->ship_from,
                            'product_to' => $request->ship_to,
                            'port_of_loading' => $request->loading_port,
                            'port_of_destination' => $request->destination_port,
                            'prepared_by' => $request->prepared_by,
                            'checked_by' => $request->checked_by,
                            'cc_personnel' => $imploded_cc,
                            'status'        => 0,
                            'created_at'    => date('Y-m-d H:i:s'),
                        ];
                        if(isset($request->packing_list_id)){ // edit
                            PackingListDetails::where('id', $request->packing_list_id)
                            ->update($array);
                        }
                        else{ // insert
                            PackingListDetails::insert($array);
                        }
        
                
            }
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }

        
    }
}

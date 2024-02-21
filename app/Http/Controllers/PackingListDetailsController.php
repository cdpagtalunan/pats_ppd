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
use App\Models\OQCInspection;
use App\Models\ReceivingDetails;
use App\Models\User;
use App\Models\PreliminaryPacking;
use App\Models\PackingDetails;

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
        ->where('position', 10)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    public function getPpcSrPlanner(Request $request){
        $user_details = User::
        where('status',1)
        ->where('position', 8)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    public function carbonCopyUser(Request $request){
        $user_details = User::
        where('status',1)
        ->where('position', 4)
        ->get();

        // return $user_details;

        return response()->json(['userDetails' => $user_details]);
    }

    public function viewPackingListData(Request $request){
        // $packing_list_data = PackingListDetails::
        // where('shipment_status', 1)
        // ->select('control_no', 'any_value(`po_no`) AS po')
        // ->groupBy('control_no')
        // ->get();

        $packing_list_data = DB::connection('mysql')
        ->select("SELECT `control_no`, any_value(`po_no`) AS po FROM `packing_list_details` WHERE `shipment_status` = 1 GROUP BY `control_no`");

        // return $packing_list_data;

        return DataTables::of($packing_list_data)
        ->addColumn('action', function($packing_list_data){
            $result = "";
            $result .= "<center>";

            $result .= "<button class='btn btn-primary btn-sm btnEditPackingListDetails' data-ctrl-no='$packing_list_data->control_no'><i class='fa-solid fa-eye'></i></button>&nbsp";


            $result .= "</center>";
            return $result;
        })
            ->addColumn('status', function($packing_list_data){
                $result = "";
                $result .= "<center>";

                // if($packing_list_data->shipment_status == 1){
                    $result .= '<span class="badge bg-success">Completed</span>';
                // }
                // else{
                    // $result .= '<span class="badge bg-danger">Cancelled</span>';
                // }
                $result .= "</center>";
                return $result;
            })
            // ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            ->make(true);
    }

    public function viewProductionData(Request $request){
        // $production_data = OQCInspection::with(['stamping_production_info'])
        // ->where('po_no', 'like', '%' . $request->search_data . '%')
        // ->where('lot_accepted', 1)
        // ->get();

        $prelim_packing_data = PreliminaryPacking::with(['oqc_info.stamping_production_info'])
        ->where('po_no', $request->search_data)
        ->where('status', 1)
        ->get();

        // return $prelim_packing_data;

            return DataTables::of($prelim_packing_data)
            ->addColumn('action', function($prelim_packing_data){
                $result = "";
                $result .= "<center>";
                if($prelim_packing_data->status == 1 ){
                    $result .= "<input class='test d-none packing_$prelim_packing_data->id' data-packing-id='$prelim_packing_data->id' type'text' style='width: 30px; text-align: center;' id='boxNoId' name='box_no[]' disabled>";
                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($prelim_packing_data){
                $result = "";
                $result .= "<center>";

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
    }

    public function getDataFromProduction(Request $request){
        $get_production_data = OQCInspection::with(['stamping_production_info'])
        ->where('po_no', 'like', '%' . $request->search_data . '%')
        ->where('lot_accepted', 1)
        ->get();

        // return $request->search_data;

        return response()->json(['productionData' => $get_production_data]);
    }

    public function addPackingListData(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();


        $prod_id = [
            "prod_id" => [],
        ];

        $date = substr($request->pickup_date_and_time,0,10);
        $time = substr($request->pickup_date_and_time,11,16);

        if(count($request->packing_list_data_array) > 0){
            for ($i=0; $i < count($request->packing_list_data_array); $i++) {
                array_push($prod_id['prod_id'], $request->packing_list_data_array);
            }
        }

        // return $request->packing_list_data_array;

        $prod_data = OQCInspection::
        with(['stamping_production_info'])
        ->whereIn('id', $prod_id['prod_id'])
        ->get();

        // return $prod_data;

        $material_name = "";
        $prod_lot_no = "";
        $qty = "";
        $prod_id = "";
        $imploded_cc = implode($request->carbon_copy, ',');

        // return $prod_data;

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
            for ($i=0; $i <count($prod_data); $i++) {
                    $oqc_id = $prod_data[$i]->id;
                    $prod_id = $prod_data[$i]->stamping_production_info->id;
                    $po_no = $prod_data[$i]->po_no;
                    $part_code = $prod_data[$i]->stamping_production_info->part_code;
                    $material_name = $prod_data[$i]->stamping_production_info->material_name;
                    $prod_lot_no = $prod_data[$i]->stamping_production_info->prod_lot_no;
                    $drawing_no = $prod_data[$i]->stamping_production_info->drawing_no;
                    $no_of_cuts = $prod_data[$i]->stamping_production_info->no_of_cuts;
                    $qty = $prod_data[$i]->stamping_production_info->ship_output;
                    $po_qty = $prod_data[$i]->stamping_production_info->po_qty;

                        $array = [
                            'control_no'            => $request->ctrl_num,
                            'prod_id'               => $prod_id,
                            'po_no'                 => $request->search_packing_list_details,
                            'box_no'                => $request->box_no[$i],
                            'mat_name'              => $material_name,
                            'lot_no'                => $prod_lot_no,
                            'quantity'              => $qty,
                            'pick_up_date'          => $date,
                            'pick_up_time'          => $time,
                            'product_from'          => $request->ship_from,
                            'product_to'            => $request->ship_to,
                            'carrier'               => $request->carrier,
                            'port_of_loading'       => $request->loading_port,
                            'port_of_destination'   => $request->destination_port,
                            'prepared_by'           => $request->prepared_by,
                            'checked_by'            => $request->checked_by,
                            'cc_personnel'          => $imploded_cc,
                            'shipment_status'       => 0,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];

                        $array_for_final_packing = [
                            'oqc_id'                => $oqc_id,
                            'packing_ctrl_no'       => $request->ctrl_num,
                            'po_no'                 => $po_no,
                            'lot_qty'               => $qty,
                            'shipment_qty'          => $po_qty,
                            'material_name'         => $material_name,
                            'material_lot_no'       => $prod_lot_no,
                            'drawing_no'            => $drawing_no,
                            'no_of_cuts'            => $no_of_cuts,
                            'print_count'           => 0,
                        ];


                        $array_for_preliminary = [
                            'status' => 2,
                        ];

                        // return $oqc_id;

                        PackingListDetails::insert($array);
                        PackingDetails::insert($array_for_final_packing); // FINAL PACKING DETAILS

                        PreliminaryPacking::where('oqc_id', $oqc_id)
                        ->update($array_for_preliminary);

                        // ReceivingDetails::insert($array_for_final_packing);

            }
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }


    }

    public function getPackingListDetailsbyCtrl(Request $request){
        $packing_list_data_by_ctrl = PackingListDetails::
        where('control_no', $request->packing_list_ctrl_no)
        ->get();

        return DataTables::of($packing_list_data_by_ctrl)
            ->addColumn('action', function($packing_list_data_by_ctrl){
                $result = "";
                $result .= "<center>";

                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($packing_list_data_by_ctrl){
                $result = "";
                $result .= "<center>";

                $result .= '<span class="badge bg-success">Completed</span>';

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
    }

    public function getPackingListDetails(Request $request){
        $packing_list_details = PackingListDetails::
        where('control_no', $request->packing_list_ctrl_no)
        ->get();

        return response()->json(['packingListDetails' => $packing_list_details]);
    }
}

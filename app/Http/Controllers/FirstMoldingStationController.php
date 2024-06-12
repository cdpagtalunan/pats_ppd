<?php

namespace App\Http\Controllers;


use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Station;
use App\Models\FirstMolding;
use App\Models\FirstMoldingDetail;
use App\Models\FirstMoldingStation;
use App\Models\FirstMoldingDetailMod;
use App\Http\Requests\FirstMoldingStationRequest;




class FirstMoldingStationController extends Controller
{
    public function loadFirstMoldingStationDetails(Request $request)
    {
        $first_molding_id= isset($request->first_molding_id) ? $request->first_molding_id : 0;
        // $first_molding_station_details = FirstMoldingDetail::where('first_molding_id',$first_molding_id)->whereNull('deleted_at')->get();
        $first_molding_station_details = FirstMoldingDetail::with('belongsToFirstMolding')->where('first_molding_id',$first_molding_id)->whereNull('deleted_at')->get();
        return DataTables::of($first_molding_station_details)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            if($row->belongsToFirstMolding['status'] != 3){
                $result .= '<button type="button" class="btn btn-outline-info btn-sm mb-1" first-molding-station-id='.$row->id.' view-data="true" id="btnViewFirstMoldingStation"><i class="fa-solid fa-eye"></i></button>';
                $result .= '<button type="button" class="btn btn-outline-danger btn-sm mb-1" first-molding-station-id='.$row->id.' id="btnDeleteFirstMoldingStation"><i class="fa-solid fa-times"></i></button>';
                // $result .= '';
            }else{
                if($row->belongsToFirstMolding['first_molding_device_id'] == 1 && $row->size_category != ""){
                    $result .= "<button class='btn btn-success btn-sm mr-1'  first-molding-station-id=".$row->id." id='btnPrintFirstMoldingStation'><i class='fa-solid fa-print' disabled></i></button>";
                }else{
                    $result .= '';
                }
            }
            $result .= '</center>';
            return $result;
        })
        ->addColumn('stations', function($row){
            $stations = Station::where('id',$row->station)->get();
            $result = '';
            $result .= '<center>';
            $result .= $stations[0]->station_name;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('operator_names', function($row){
            $user = User::where('id',$row->operator_name)->get();
            $result = '';
            $result .= '<center>';
            $result .= $user[0]->firstname . ' ' .$user[0]->lastname;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('date_created', function($row){
            $result = $row->created_at;
            return $result;
        })
        ->rawColumns(['action','stations','operator_names','date_created'])
        ->make(true);

    }

// public function saveFirstMoldingStation(FirstMoldingStationRequest $request)
    // {
    //     date_default_timezone_set('Asia/Manila');
    //     // return $request->is_partial;
    //     try{
    //         $is_exist_first_molding_detail_station = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
    //         ->where('station',$request->station)
    //         ->where('is_partial',0)
    //         ->whereNull('deleted_at')
    //         ->exists();
    //         if($is_exist_first_molding_detail_station == 1){
    //             return response()->json( [ 'result' => 2,'error_msg' => 'Station is already exists' ] ,409);
    //         }
    //         if( isset($request->first_molding_detail_id) ){
    //             $first_molding_detail_id = FirstMoldingDetail::where('id',$request->first_molding_detail_id)
    //             ->update([
    //                 'first_molding_id' => $request->first_molding_id,
    //                 'station' => $request->station,
    //                 'date' => $request->date,
    //                 'operator_name' => $request->operator_name,
    //                 'input' => $request->input,
    //                 'ng_qty' => $request->ng_qty,
    //                 'output' => $request->output,
    //                 'yield' => $request->station_yield,
    //                 'is_partial'=> isset($request->is_partial) ? $request->is_partial : 0 ,
    //                 'remarks' => $request->remarks,
    //                 'updated_at' => date('Y-m-d H:i:s'),
    //             ]);
    //             $first_molding_detail_id = $request->first_molding_detail_id;
    //         }else{
    //             // return 'add';
    //             $get_first_molding_detail_id = FirstMoldingDetail::insertGetId([
    //                 'first_molding_id' => $request->first_molding_id,
    //                 'station' => $request->station,
    //                 'date' => $request->date,
    //                 'operator_name' => $request->operator_name,
    //                 'input' => $request->input,
    //                 'ng_qty' => $request->ng_qty,
    //                 'output' => $request->output,
    //                 'yield' => $request->station_yield,
    //                 'is_partial'=> isset($request->is_partial) ? $request->is_partial : 0 ,
    //                 'remarks' => $request->remarks,
    //                 'created_at' => date('Y-m-d H:i:s'),
    //             ]);
    //             $first_molding_detail_id = $get_first_molding_detail_id;
    //         }

    //         // $is_first_molding_station = FirstMoldingDetail::where('id',$first_molding_detail_id)->where(['station',8])->count();

    //         return response()->json( [ 'result' => 1 ] );
    //         /*
    //             TODO: Save Auto Prod Lot
    //             TODO: Multiple Resin Lot Number Virgin at Recycle
    //         */
    //         if(isset($request->mod_id)){
    //             // FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->update([
    //             //     'deleted_at' => date('Y-m-d H:i:s')
    //             // ]);
    //             $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false

    //             foreach ( $request->mod_id as $key => $value_mod_id) {
    //                 FirstMoldingDetailMod::insert([
    //                     'first_molding_detail_id'   => $first_molding_detail_id,
    //                     'defects_info_id'           => $request->mod_id[$key],
    //                     'mod_quantity'              => $request->mod_quantity[$key],
    //                     // 'last_updated_by'           => $request->mod_quantity[$key],
    //                     'created_at'                => date('Y-m-d H:i:s')
    //                 ]);
    //             }
    //         }else{
    //             if(FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->exists()){
    //                 // FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->update([
    //                 //     'deleted_at' => date('Y-m-d H:i:s')
    //                 // ]);
    //                 $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false
    //             }
    //         }
    //     } catch (\Throwable $th) {
    //         return $th;
    //     }
// }

    public function saveFirstMoldingStation(FirstMoldingStationRequest $request)
    {
        // return $request->station;

        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try{
            $arr_ng_qty = [];
            $arr_output = [];
            $arr_input = [];
            $arr_visual_output = [];
            $arr_total_machine_output = [];

            //get the Station that is not partial. It cannot save duplicate data if partial
            $is_exist_first_molding_detail_station = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
            ->where('station',$request->station)
            ->where('is_partial',0)
            ->whereNull('deleted_at')
            ->exists();
            //If the station is partial, the rest of following same station will automatically save as partial.
            //Ex: Visual 500 is partial, the next saving is partial.
            $is_partial_first_molding_detail_station = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
            ->where('station',$request->station)
            ->where('is_partial',1)
            ->whereNull('deleted_at')
            ->exists();

            if($is_exist_first_molding_detail_station == 1){
                return response()->json( [ 'result' => 2,'error_msg' => 'Station is already exists' ] ,409);
            }

            //TODO: if($request->station == 7 ){ //nmodify Camera Inspection TEST
            //TODO:  Size category is for CN171S-08#IN-VE
            $get_first_molding_by_id = FirstMolding::with('firstMoldingDevice')->where('id',$request->first_molding_id)->whereNull('deleted_at')->get('first_molding_device_id');
            // $get_first_molding_by_id[0]->first_molding_device_id;
            // DB::rollback();
            // $device_name = $get_first_molding_by_id[0]->firstMoldingDevice['device_name'];
            if($get_first_molding_by_id[0]->first_molding_device_id == 1 && $request->station == 5 ){ //nmodify Camera Inspection LIVE
                $validation = array(
                    'size_category' => ['required'],
                );

                $validator = Validator::make($request->all(), $validation);

                if ($validator->fails()) {
                    return response()->json(['result' => '0', 'errors' => $validator->messages()],422);
                }
            }

            if( isset($request->first_molding_detail_id) ){ //Edit
                $first_molding_detail_id = FirstMoldingDetail::where('id',$request->first_molding_detail_id)
                ->update([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'size_category' => $request->size_category,
                    'input' => $request->input,
                    'ng_qty' => $request->ng_qty,
                    'output' => $request->output,
                    'yield' => $request->station_yield,
                    'is_partial'=> ( isset($request->is_partial) || $is_partial_first_molding_detail_station ) ? 1 : 0 ,
                    'remarks' => $request->remarks,
                    'last_updated_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $first_molding_detail_id = $request->first_molding_detail_id; //get first molding detail id that can use below
            }else{ //Insert
                $get_first_molding_detail_id = FirstMoldingDetail::insertGetId([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'size_category' => $request->size_category,
                    'input' => $request->input,
                    'ng_qty' => $request->ng_qty,
                    'output' => $request->output,
                    'yield' => $request->station_yield,
                    'is_partial'=> ( isset( $request->is_partial ) || $is_partial_first_molding_detail_station ) ? 1 : 0 ,
                    'remarks' => $request->remarks,
                    'last_updated_by' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $first_molding_detail_id = $get_first_molding_detail_id; //get first molding detail id that can use below
            }

            /*
                TODO: Save Auto Prod Lot
                TODO: Multiple Resin Lot Number Virgin at Recycle
            */

            if(isset($request->mod_id)){
                if(FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->exists()){
                    $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false
                }
                foreach ( $request->mod_id as $key => $value_mod_id) {
                    FirstMoldingDetailMod::insert([
                        'first_molding_detail_id'   => $first_molding_detail_id,
                        'defects_info_id'           => $request->mod_id[$key],
                        'mod_quantity'              => $request->mod_quantity[$key],
                        // 'last_updated_by'           => $request->mod_quantity[$key],
                        'created_at'                => date('Y-m-d H:i:s')
                    ]);
                }
            }else{
                if(FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->exists()){
                    $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false
                }
            }


            //TODO: Get the Step Number to Matrix Table
            $get_first_molding_by_id = FirstMolding::with('firstMoldingDevice')->where('id',$request->first_molding_id)->whereNull('deleted_at')->get();
            $device_name = $get_first_molding_by_id[0]->firstMoldingDevice['device_name'];
            $material_processes_by_device_name = DB::connection('mysql')
            ->select("  SELECT material_processes.step
                        FROM material_processes
                        INNER JOIN devices ON devices.id = material_processes.device_id
                        INNER JOIN material_process_stations ON material_process_stations.mat_proc_id = material_processes.id
                        INNER JOIN stations ON stations.id = material_process_stations.station_id
                        WHERE devices.name = '".$device_name."' AND stations.id = $request->station
                        AND material_processes.process = 4 AND material_processes.status = 0
            ");

            //TODO: If material_processes_by_device_name == 0 please check the matrix then add the process
            if( count($material_processes_by_device_name) == 0 ){
                DB::rollback();
                return response()->json([
                    "result" => 0,
                    "error_msg" => "Please check the matrix, then add or edit the process !",
                ]);
            }
            $station_step = $material_processes_by_device_name[0]->step;

            $first_molding_detail_id = FirstMoldingDetail::where('id',$first_molding_detail_id)
            ->update([
                'step' => $station_step
            ]);

            $previous_step = $station_step - 1;
            $first_molding_detail_count = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)->whereNull('deleted_at')->count();
            $is_previous_station_exist = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)->where('step',$previous_step)->whereNull('deleted_at')->count();

            //This station after the Machine 1st Overmold. Ex. Visual Inpection & Camera Inspector
            if($station_step > 1){
                //Machine 1st Overmold Station is the first station
                if($first_molding_detail_count <= 1){
                    DB::rollback();
                    return response()->json([
                        "result" => 0,
                        "error_msg" => "Please Add Machine 1st Overmold Station !",
                    ]);
                }
                //Check if the Previous Station is not exist.
                if($is_previous_station_exist == 0){
                    DB::rollback();
                    return response()->json([
                        "result" => 0,
                        "error_msg" => "You can not proceed to this Station. Please Check the Step to Matrix Module !",
                    ]);
                }

                //Read all NG QTY from First Molding Details Table
                $arr_first_molding_station_ng_qty = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
                                                                        ->whereNull('deleted_at')->get(['ng_qty']);
                foreach ($arr_first_molding_station_ng_qty as $key => $value_first_molding_station_ng_qty) {
                    $arr_ng_qty [] = $value_first_molding_station_ng_qty->ng_qty;
                }
                //Read all Output and Input even partial Output Qty
                $arr_first_molding_station_current_data = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
                                                                            ->where('step',$station_step)
                                                                            ->whereNull('deleted_at')->get(['output','input']);
                foreach ($arr_first_molding_station_current_data as $key => $value) {
                    $arr_output [] = $value->output;
                    $arr_input [] = $value->input;
                }
                //Calculate the  NG, Output and Input QTY then save to First Molding Table
                $sum_ng_qty = array_sum($arr_ng_qty);
                $sum_output = array_sum($arr_output);
                $sum_input = array_sum($arr_input);

                $arr_output_of_previous_station = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
                                                                                            ->where('step',$previous_step)
                                                                                            ->whereNull('deleted_at')->get(['output']);
                foreach ($arr_output_of_previous_station as $key => $value_output_of_previous_station) {
                    $arr_visual_output [] = $value_output_of_previous_station->output;
                }
                $sum_visual_output = array_sum($arr_visual_output);
                //Check if the input of the Sum Camera Inspection Input is greater than Ouput of the Visual Inspection
                if($sum_input > $sum_visual_output){
                    DB::rollback();
                    return response()->json([
                        "result" => 0,
                        "error_msg" => "Then Current Station Input is greater than Previous Station Output",
                        "shipment_output" => $sum_output,
                    ]);
                }
                //if Sum Camera Inspection Input is equal Ouput of the Visual Inspection, Save the Shipment out, ng count, total machine code to First Molding Table
                $update_first_molding = FirstMolding::where('id',$request->first_molding_id)->update([
                    'shipment_output' => $sum_output,
                    'ng_count' => $sum_ng_qty
                ]);

                // Calculate the total machine output then update to First Molding Table
                $get_first_molding_by_id = FirstMolding::findOrFail($request->first_molding_id);
                $arr_total_machine_output = [
                    $get_first_molding_by_id['target_shots'],
                    $get_first_molding_by_id['adjustment_shots'],
                    $get_first_molding_by_id['ng_count'],
                    $get_first_molding_by_id['qc_samples'],
                    $get_first_molding_by_id['prod_samples'],
                    $get_first_molding_by_id['shipment_output'],
                ];
                $sum_total_machine_output =array_sum($arr_total_machine_output);

                $update_first_molding_total_machine_output = FirstMolding::where('id',$request->first_molding_id)->update([
                    'total_machine_output' => $sum_total_machine_output,
                ]);
                DB::commit();
                return response()->json([
                    "result" => 1,
                    "step" => $station_step,
                    "shipment_output" => $sum_output,
                    "ng_count" => $sum_ng_qty,
                    "total_machine_output" => $sum_total_machine_output,
                ]);
            }

            DB::commit();
            return response()->json( [
                'result' => 1,
                "step" => $station_step,
                "shipment_output" => 0,
                "ng_count" => 0,
                "total_machine_output" => "0%",
            ] );
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }
    }

    public function getFirstMoldingStationDetails(Request $request)
    {
        $first_molding_detail_mod = FirstMoldingDetailMod::where('first_molding_detail_id',$request->first_molding_station_id)->whereNull('deleted_at')
        ->with('belongsToFirstMoldingDetail','defectsInfo')->get();
        if(count($first_molding_detail_mod) == 0 ){
            $first_molding_detail = FirstMoldingDetail::where('id',$request->first_molding_station_id)->whereNull('deleted_at')->get();
            return response()->json( [ 'first_molding_detail' => $first_molding_detail ] );

        }
        return response()->json( [ 'first_molding_detail_mod' => $first_molding_detail_mod ] );

    }

    public function getFirstMoldingStationLastOuput (Request $request){
        $arr_output_qty= [];
        $first_molding_detail = FirstMoldingDetail::where('first_molding_id',$request->first_molding_station_last_ouput)
                                                    ->whereNull('deleted_at')
                                                    ->orderBy('id','DESC')->get(['id','station','first_molding_id','output','is_partial']);
        $is_exist = count($first_molding_detail);
        if(  $is_exist > 0 ){
            if($first_molding_detail[0]->is_partial == 1){
                $first_molding_detail = FirstMoldingDetail::where('first_molding_id',$request->first_molding_station_last_ouput)
                                                            ->where('station',$first_molding_detail[0]->station)
                                                            ->whereNull('deleted_at')->get(['id','station','first_molding_id','output','is_partial']);
                foreach ($first_molding_detail as $key => $value) {
                    $arr_output_qty[] = $value->output;
                }
                $last_output = array_sum($arr_output_qty);
            }else{
                $first_molding_detail = FirstMoldingDetail::where('first_molding_id',$request->first_molding_station_last_ouput)
                                                        ->whereNull('deleted_at')
                                                        ->orderBy('id','DESC')->get(['id','station','first_molding_id','output','is_partial']);
                $last_output = $first_molding_detail[0]->output;
            }
            return response()->json( [
                'first_molding_station_id' => $first_molding_detail[0]->id,
                'first_molding_id' => $first_molding_detail[0]->first_molding_id,
                'first_molding_station_last_output' => $last_output,
                'first_molding_detail_count' => $is_exist,
                'is_partial' => ($first_molding_detail[0]->is_partial) == 0 ? 'false' : 'true', //0- False | 1- True
            ] );
        }else{
            return response()->json( [
                'first_molding_detail_count' => $is_exist,
                'first_molding_station_last_output' => 0,
            ] );
        }

    }

    public function getStations(Request $request) //omodify
    {
        $material_station_by_device_name = DB::connection('mysql')
        ->select("  SELECT material_processes.*, devices.*, material_process_stations.*, stations.id AS station_id, stations.station_name AS station_name FROM material_processes
                    INNER JOIN devices
                    ON devices.id = material_processes.device_id
                    INNER JOIN material_process_stations
                    ON material_process_stations.mat_proc_id = material_processes.id
                    INNER JOIN stations
                    ON stations.id = material_process_stations.station_id
                    WHERE devices.name = '$request->device_name' AND material_processes.status = 0
        ");

        foreach ($material_station_by_device_name as $key => $value_material_station_by_device_name) {

            $arr_material_station_by_device_name_id[] = $value_material_station_by_device_name->station_id;
            $arr_material_station_by_device_name_value[] = $value_material_station_by_device_name->station_name;
        }

        return response()->json([
            'id'    =>  $arr_material_station_by_device_name_id,
            'value' =>  $arr_material_station_by_device_name_value,
        ]);
    }

    public function deleteFirstMoldingDetail(Request $request){
        date_default_timezone_set('Asia/Manila');
        $request->first_molding_detail_id;
        $first_molding_detail_id = FirstMoldingDetail::where('id',$request->first_molding_detail_id)
            ->update([
                'deleted_at' => date('Y-m-d H:i:s')
        ]);
        return response()->json([
            'result'    =>  1,
        ]);
    }

    public function getOperatioNames(){
        //TODO: nmodify Filter Section
        // $arr_data = User::where('section',2)->get();
        $arr_data = User::all();
        foreach ($arr_data as $key => $value_data) {
            $arr_value_id[] =$value_data['id'];
            $arr_value_name[] =$value_data['firstname'] .' '.$value_data['lastname'];
        }

        return response()->json([
            'id'    =>  $arr_value_id,
            'value' =>  $arr_value_name
        ]);
    }

    public function index(Request $request){
        return 'true';
        try {
            return response()->json(['is_success' => "true"]);
        } catch (Exception $e) {
            return response()->json(['is_success' => "false", 'exceptionError' => $e->getMessage()]);
        }
    }

    public function dasd(Request $request){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            DB::commit();
            return response()->json(['hasError' => 0]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
        }
    }

    public function getFirstMoldingStationQrCode (Request $request)
    {
        $first_molding = FirstMoldingDetail::rightJoin('first_moldings', function($join) {
            $join->on('first_moldings.id', '=', 'first_molding_details.first_molding_id');
        })
        ->leftJoin('first_molding_devices', function($join) {
            $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        })
        ->where('first_molding_details.id',$request->first_molding_detail_id)
        ->whereNull('first_moldings.deleted_at')
        // ->get();
        ->first([
        'pmi_po_no AS pmi_po','item_name AS name',
        'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
        'first_molding_details.output AS output_qty','first_molding_devices.device_name AS device_name',
        'first_molding_details.size_category AS size',
        ]);
        // ->first([
        // 'pmi_po_no AS pmi_po','po_no AS po','item_code AS code','item_name AS name',
        // 'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
        // 'po_qty AS qty','first_molding_details.output AS output_qty','first_molding_devices.device_name AS device_name',
        // 'first_molding_details.size_category AS size',
        // ]);

        $first_molding_label = FirstMoldingDetail::rightJoin('first_moldings', function($join) {
            $join->on('first_moldings.id', '=', 'first_molding_details.first_molding_id');
        })->leftJoin('first_molding_devices', function($join) {
            $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        })->where('first_molding_details.id',$request->first_molding_detail_id)
        ->whereNull('first_moldings.deleted_at')
        // ->get();
        ->first(['po_no AS po','po_qty AS qty']);

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate($first_molding);

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $qr_code,
            'text' =>  "
            <strong>1st Molding</strong><br>
            <strong>$first_molding->pmi_po</strong><br>
            <strong>$first_molding->device_name</strong><br>
            <strong>".$first_molding->lot_no."".$first_molding->lot_no_ext."</strong><br>
            <strong>$first_molding_label->qty</strong><br>
            <strong>$first_molding->output_qty</strong><br>
            <strong>$first_molding->size</strong><br>
            "
        );
        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>1st Molding</td>
                </tr>
                <tr>
                    <td>PMI PO No.:</td>
                    <td>$first_molding->pmi_po</td>
                </tr>
                <tr>
                    <td>PO No.:</td>
                    <td>$first_molding_label->po</td>
                </tr>
                <tr>
                    <td>Material Name:</td>
                    <td>$first_molding->device_name</td>
                </tr>
                <tr>
                    <td>Production Lot #:</td>
                    <td>".$first_molding->lot_no."".$first_molding->lot_no_ext."</td>
                </tr>
                <tr>
                    <td>Shipment Output:</td>
                    <td>$first_molding->output_qty</td>
                </tr>
                <tr>
                    <td>PO Quantity:</td>
                    <td>$first_molding_label->qty</td>
                </tr>
                <tr>
                    <td>Size</td>
                    <td>$first_molding->size</td>
                </tr>
            </table>
        ";

        return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'first_molding_data' => $first_molding]);
    }


}

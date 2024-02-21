<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\Station;
use App\Models\FirstMolding;
use Illuminate\Http\Request;
use App\Models\FirstMoldingDetail;
use Illuminate\Support\Facades\DB;
use App\Models\FirstMoldingStation;
use Illuminate\Support\Facades\Auth;
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
                // $result .= '<button type="button" class="btn btn-info btn-sm mr-1" first-molding-station-id='.$row->id.' id="btnEditFirstMoldingStation"><i class="fa-solid fa-pen-to-square"></i></button>';
                $result .= '<button type="button" class="btn btn-outline-info btn-sm mb-1" first-molding-station-id='.$row->id.' test-data='.$row->belongsToFirstMolding['status'].' view-data="true" id="btnViewFirstMoldingStation"><i class="fa-solid fa-eye"></i></button>';
                $result .= '<button type="button" class="btn btn-outline-danger btn-sm mb-1" first-molding-station-id='.$row->id.' id="btnDeleteFirstMoldingStation"><i class="fa-solid fa-times"></i></button>';
                // $result .= '';
            }else{
                $result .= '';
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
        ->rawColumns(['action','stations','operator_names'])
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
        date_default_timezone_set('Asia/Manila');
        // return $request->is_partial;
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

            if( isset($request->first_molding_detail_id) ){ //Edit
                $first_molding_detail_id = FirstMoldingDetail::where('id',$request->first_molding_detail_id)
                ->update([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
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

            /*
                TODO: Save the Step Number to First Molding Detail Table
            */
            $get_first_molding_by_id = FirstMolding::with('firstMoldingDevice')->where('id',$request->first_molding_id)->whereNull('deleted_at')->get();
            $device_name = $get_first_molding_by_id[0]->firstMoldingDevice['device_name'];
            $material_processes_by_device_name = DB::connection('mysql')
            ->select("  SELECT material_processes.step
                        FROM material_processes
                        INNER JOIN devices ON devices.id = material_processes.device_id
                        INNER JOIN material_process_stations ON material_process_stations.mat_proc_id = material_processes.id
                        INNER JOIN stations ON stations.id = material_process_stations.station_id
                        WHERE devices.name = '$device_name' AND stations.id = $request->station
                        AND material_processes.process = 4 AND material_processes.status = 0
            ");

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
                $arr_first_molding_station_current_data = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)
                                                                                            ->where('step',$station_step)
                                                                                            ->whereNull('deleted_at')->get(['ng_qty','output','input']);
                foreach ($arr_first_molding_station_ng_qty as $key => $value_first_molding_station_ng_qty) {
                    $arr_ng_qty [] = $value_first_molding_station_ng_qty->ng_qty;
                }
                foreach ($arr_first_molding_station_current_data as $key => $value) {
                    $arr_output [] = $value->output;
                    $arr_input [] = $value->input;
                }
                //Calculate the NG QTY then save to First Molding Table
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
        // $arr_data = User::where('position',4)->get();
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Query\JoinClause;
use DataTables;

/**
 * Import Models
 */
use App\Models\SecMoldingRuncard;
use App\Models\SecMoldingRuncardStation;
use App\Models\SecMoldingRuncardStationMod;

class SecondMoldingStationController extends Controller
{
    public function viewSecondMoldingStation(Request $request){
        // $secMoldingRuncardId = isset($request->sec_molding_runcard_id) ? $request->sec_molding_runcard_id : '';
        // $secondMoldingResult = DB::connection('mysql')
        //     ->select("SELECT 
        //                 sec_molding_runcard_stations.*, 
        //                 CONCAT(users.firstname, ' ', users.lastname) AS operator_name, 
        //                 stations.station_name AS station_name  
        //             FROM sec_molding_runcard_stations
        //             INNER JOIN users
        //                 ON users.id = sec_molding_runcard_stations.operator_name
        //             INNER JOIN stations
        //                 ON stations.id = sec_molding_runcard_stations.station
        //             WHERE sec_molding_runcard_stations.sec_molding_runcard_id = '$request->sec_molding_runcard_id'
        //             -- AND deleted_at IS NULL
        // ");

        $secondMoldingResult = DB::connection('mysql')
            ->table('sec_molding_runcard_stations')
            ->join('users', 'sec_molding_runcard_stations.operator_name', '=', 'users.id')
            ->join('stations', 'sec_molding_runcard_stations.station', '=', 'stations.id')
            ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->sec_molding_runcard_id)
            ->where('sec_molding_runcard_stations.deleted_at', '=', NULL)
            ->select(
                'users.firstname',
                'users.lastname',
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS concatted_operator_name'),
                'sec_molding_runcard_stations.*', 
                'stations.station_name AS station_name')
            ->get();
            // return $secondMoldingResult;

        return DataTables::of($secondMoldingResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button type='button' class='btn btn-primary btn-sm mr-1 actionEditSecondMoldingStation d-none' data-bs-toggle='modal' data-bs-target='#modalSecondMoldingStation' second-molding-station-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                    <button type='button' class='btn btn-info btn-sm mr-1 actionViewSecondMoldingStation' data-bs-toggle='modal' data-bs-target='#modalSecondMoldingStation' second-molding-station-id='$row->id'><i class='fa-solid fa-eye'></i></button>
                </center>
            ";
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function saveSecondMoldingStation(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        $data = $request->all();

        if(!isset($request->second_molding_station_id)){
            // return 'insert';
            $rules = [
                'second_molding_id' => 'required',
                'station' => 'required',
                'date' => 'required',
                'operator_name' => 'required',
                'input_quantity' => 'required',
                'ng_quantity' => 'required',
                'output_quantity' => 'required',
                'station_yield' => 'required',
                'remarks' => '',
            ];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $checkIfStationExist = SecMoldingRuncardStation::where('sec_molding_runcard_id', $request->second_molding_id)
                    ->where('station', $request->station)
                    ->exists();

                    /**
                     * If Station is 1-Machine Final Overmold or 7-Camera Inspection
                     * already exist then return hasError to true
                     */
                    if($request->station != 6 && $checkIfStationExist){ // 1-Machine Final Overmold, 7-Camera Inspection, 6-Visual Inspection
                        DB::rollback();
                        return response()->json(['hasError' => true, 'checkIfStationExist' => $checkIfStationExist]);
                    }
                    
                    /**
                     * If Station is 6-Visual Inspection or checkIfStationExist 
                     * is false execute the query and return hasError for every condition
                     */
                    if($request->station == 6 || !$checkIfStationExist){ // 6-Visual Inspection
                        /* Validation of input quantity(current) and output quantity(last station) */
                        $getOutputQtyOfLastStationNonVisual = DB::connection('mysql')
                            ->table('sec_molding_runcard_stations')
                            ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                            ->whereIn('sec_molding_runcard_stations.station', [1, 7]) // 1-Machine Final Overmold or 7-Camera Inspection
                            ->orderBy('id', 'desc')
                            ->select(
                                'sec_molding_runcard_stations.station',
                                'sec_molding_runcard_stations.output_quantity',
                            )
                            ->get();
                        // return response()->json(['getOutputQtyOfLastStationNonVisual' => $getOutputQtyOfLastStationNonVisual]);

                        if(count($getOutputQtyOfLastStationNonVisual) > 0){
                            if((int)$request->input_quantity > (int)$getOutputQtyOfLastStationNonVisual[0]->output_quantity){
                                DB::rollback();
                                return response()->json(['hasError' => true, 'stationOutputQuantityIsHigher' => $getOutputQtyOfLastStationNonVisual]);
                            }
                        }

                        /**
                         * Insert Station
                         */
                        $secondMoldingStationId = SecMoldingRuncardStation::insertGetId([
                            'sec_molding_runcard_id' => $request->second_molding_id,
                            'station' => $request->station,
                            'date' => $request->date,
                            'operator_name' => $request->operator_name,
                            'input_quantity' => $request->input_quantity,
                            'partial' => $request->partial,
                            'ng_quantity' => $request->ng_quantity,
                            'output_quantity' => $request->output_quantity,
                            'station_yield' => $request->station_yield,
                            'remarks' => $request->remarks,
                            'created_by' => Auth::user()->id,
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);

                        /**
                         * Multiple insert of MOD
                         */
                        if(isset($request->mod_id)){
                            for ($i=0; $i < count($request->mod_id); $i++) { 
                                SecMoldingRuncardStationMod::insert([
                                    'sec_molding_runcard_id' => $request->second_molding_id,
                                    'sec_molding_runcard_station_id' => $secondMoldingStationId,
                                    'mod_id' => $request->mod_id[$i],
                                    'mod_quantity' => $request->mod_quantity[$i],
                                    'created_by' => Auth::user()->id,
                                    'created_at' => date('Y-m-d H:i:s'),
                                ]);
                            }
                        }

                        $getComputedOutputQtyOfVisual = DB::connection('mysql')
                            ->table('sec_molding_runcard_stations')
                            ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                            ->where('sec_molding_runcard_stations.station', 6) // 6-Visual Inspection
                            ->select(
                                DB::raw('SUM(output_quantity) AS computed_output_quantity'),
                            )
                            ->get();
                            // return response()->json(['getComputedOutputQtyOfVisual' => $getComputedOutputQtyOfVisual[0]->computed_output_quantity, 'lastStation' => (int)$getOutputQtyOfLastStationNonVisual[0]->output_quantity]);

                        if($getComputedOutputQtyOfVisual[0]->computed_output_quantity != null){
                            if((int)$getComputedOutputQtyOfVisual[0]->computed_output_quantity > (int)$getOutputQtyOfLastStationNonVisual[0]->output_quantity){
                                DB::rollback();
                                return response()->json(['hasError' => true, 'stationOutputQuantityIsHigher' => $getComputedOutputQtyOfVisual]);
                            }
                        }

                        /**
                         * Computation of last station(Visual Inspection)
                         */
                        if($request->station == 6){
                            $computedShipmentOutput = DB::connection('mysql')
                                ->table('sec_molding_runcard_stations')
                                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                                ->where('sec_molding_runcard_stations.station', 6)
                                ->select(
                                    DB::raw('SUM(input_quantity) AS shipmentOutput'),
                                )
                                ->first();

                            $computedNGCount = DB::connection('mysql')
                                ->table('sec_molding_runcard_stations')
                                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                                ->select(
                                    DB::raw('SUM(ng_quantity) AS ngCount'),
                                )
                                ->first();
                            // return response()->json(['computedShipmentOutput' => $computedShipmentOutput, 'computedNGCount' => $computedNGCount]);

                            $updateNGCountAndShipmentOutput = DB::connection('mysql')
                                ->table('sec_molding_runcards')
                                ->where('sec_molding_runcards.id', $request->second_molding_id)->update([
                                    'shipment_output' => $computedShipmentOutput->shipmentOutput,
                                    'ng_count' => $computedNGCount->ngCount,
                                ]);

                            $getSecondMoldingRuncardDetails = DB::connection('mysql')
                                ->table('sec_molding_runcards')
                                // ->join('sec_molding_runcard_stations', 'sec_molding_runcards.id', '=', 'sec_molding_runcard_stations.sec_molding_runcard_id')
                                ->where('sec_molding_runcards.id', $request->second_molding_id)
                                ->whereNull('sec_molding_runcards.deleted_at')
                                ->select(
                                    'sec_molding_runcards.id',
                                    'sec_molding_runcards.target_shots',
                                    'sec_molding_runcards.adjustment_shots',
                                    'sec_molding_runcards.qc_samples',
                                    'sec_molding_runcards.prod_samples',
                                    'sec_molding_runcards.ng_count',
                                    'sec_molding_runcards.total_machine_output',
                                    'sec_molding_runcards.shipment_output',
                                    'sec_molding_runcards.material_yield',
                                    // 'sec_molding_runcard_stations.*'
                                )
                                ->get();
                                // return response()->json(['getSecondMoldingRuncardDetails' => $getSecondMoldingRuncardDetails]);

                            $totalMachineOutput = $getSecondMoldingRuncardDetails[0]->target_shots 
                                + $getSecondMoldingRuncardDetails[0]->adjustment_shots 
                                + $getSecondMoldingRuncardDetails[0]->qc_samples
                                + $getSecondMoldingRuncardDetails[0]->ng_count
                                + $getSecondMoldingRuncardDetails[0]->prod_samples
                                + $getSecondMoldingRuncardDetails[0]->shipment_output;
                            $materialYield = ($getSecondMoldingRuncardDetails[0]->shipment_output / $totalMachineOutput * 100);

                            $updateTotalMachineOutputAndMaterialYield = DB::connection('mysql')
                                ->table('sec_molding_runcards')
                                ->where('sec_molding_runcards.id', $request->second_molding_id)->update([
                                    'total_machine_output' => $totalMachineOutput,
                                    'material_yield' => $materialYield,
                                ]);
                        }
                        
                        DB::commit();
                        return response()->json(['hasError' => false, 'second_molding_id' => $request->second_molding_id]);
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage(), 'sessionError' => true]);
                }
            }
        }else{
            // return 'update';
            $rules = [
                'second_molding_station_id' => 'required',
                'second_molding_id' => 'required',
                'station' => 'required',
                'date' => 'required',
                'operator_name' => 'required',
                'input_quantity' => 'required',
                'ng_quantity' => 'required',
                'output_quantity' => 'required',
                'station_yield' => 'required',
                'remarks' => '',
            ];
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    SecMoldingRuncardStation::where('id', $request->second_molding_station_id)->update([
                        'sec_molding_runcard_id' => $request->second_molding_id,
                        'station' => $request->station,
                        'date' => $request->date,
                        'operator_name' => $request->operator_name,
                        'input_quantity' => $request->input_quantity,
                        'partial' => $request->partial,
                        'ng_quantity' => $request->ng_quantity,
                        'output_quantity' => $request->output_quantity,
                        'station_yield' => $request->station_yield,
                        'remarks' => $request->remarks,
    
                        'last_updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if($request->station == 6){ // 6-Visual Inspection
                        $updateNGAndOutputQuantity = DB::connection('mysql')
                            ->table('sec_molding_runcards')
                            ->where('sec_molding_runcards.id', $request->second_molding_id)->update([
                                'ng_count' => $request->ng_quantity,
                                'shipment_output' => $request->output_quantity,
                            ]);

                        $getSecondMoldingRuncardDetails = DB::connection('mysql')
                            ->table('sec_molding_runcards')
                            ->join('sec_molding_runcard_stations', 'sec_molding_runcards.id', '=', 'sec_molding_runcard_stations.sec_molding_runcard_id')
                            ->where('sec_molding_runcards.id', $request->second_molding_id)
                            ->whereNull('sec_molding_runcards.deleted_at')
                            ->select(
                                'sec_molding_runcards.target_shots',
                                'sec_molding_runcards.adjustment_shots',
                                'sec_molding_runcards.qc_samples',
                                'sec_molding_runcards.prod_samples',
                                'sec_molding_runcards.ng_count',
                                'sec_molding_runcards.total_machine_output',
                                'sec_molding_runcards.shipment_output',
                                'sec_molding_runcards.material_yield',
                                // 'sec_molding_runcard_stations.*'
                            )
                            ->get();
                            // return response()->json(['getSecondMoldingRuncardDetails' => $getSecondMoldingRuncardDetails]);

                        $totalMachineOutput = $getSecondMoldingRuncardDetails[0]->target_shots 
                            + $getSecondMoldingRuncardDetails[0]->adjustment_shots 
                            + $getSecondMoldingRuncardDetails[0]->qc_samples
                            + $getSecondMoldingRuncardDetails[0]->ng_count
                            + $getSecondMoldingRuncardDetails[0]->prod_samples
                            + $getSecondMoldingRuncardDetails[0]->shipment_output;
                        $materialYield = ($getSecondMoldingRuncardDetails[0]->shipment_output / $totalMachineOutput * 100);

                        $updateTotalMachineOutputAndMaterialYield = DB::connection('mysql')
                            ->table('sec_molding_runcards')
                            ->where('sec_molding_runcards.id', $request->second_molding_id)->update([
                                'total_machine_output' => $totalMachineOutput,
                                'material_yield' => $materialYield,
                            ]);
                    }
                    
                    SecMoldingRuncardStationMod::where('sec_molding_runcard_station_id', $request->second_molding_station_id)->delete();
                    if(isset($request->mod_id)){
                        for ($i=0; $i < count($request->mod_id); $i++) { 
                            SecMoldingRuncardStationMod::insert([
                                'sec_molding_runcard_id' => $request->second_molding_id,
                                'sec_molding_runcard_station_id' => $request->second_molding_station_id,
                                'mod_id' => $request->mod_id[$i],
                                'mod_quantity' => $request->mod_quantity[$i],
                                'created_by' => Auth::user()->id,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    
                    DB::commit();
                    return response()->json(['hasError' => false, 'second_molding_id' => $request->second_molding_id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage(), 'sessionError' => true]);
                }
            }
        }
        
    }

    public function getSecondMoldingStationById(Request $request){
        // $secondMoldingStationResult = SecMoldingRuncardStation::with('sec_molding_runcard_station_mods')
        // ->get();

        // $secondMoldingStationResult = DB::connection('mysql')
        // ->select("SELECT 
        //                 sec_molding_runcard_stations.*,
        //                 sec_molding_runcard_station_mods.id AS sec_molding_runcard_station_mod_id,
        //                 sec_molding_runcard_station_mods.mod_id AS mod_id,
        //                 sec_molding_runcard_station_mods.mod_quantity AS mod_quantity
        //             FROM sec_molding_runcard_stations
        //             INNER JOIN sec_molding_runcard_station_mods
        //                 ON sec_molding_runcard_station_mods.sec_molding_runcard_station_id = sec_molding_runcard_stations.id
        //             WHERE sec_molding_runcard_stations.id = $request->second_molding_station_id
        //             AND sec_molding_runcard_stations.deleted_at IS NULL
        // ");
        
        $secondMoldingStationResult = DB::connection('mysql')
        ->table('sec_molding_runcard_stations')
        ->leftJoin('sec_molding_runcard_station_mods', 'sec_molding_runcard_stations.id', '=', 'sec_molding_runcard_station_mods.sec_molding_runcard_station_id')
        ->where('sec_molding_runcard_stations.id', $request->second_molding_station_id)
        ->where('sec_molding_runcard_stations.deleted_at', '=', NULL)
        ->select(
            'sec_molding_runcard_stations.*',
            'sec_molding_runcard_station_mods.id AS sec_molding_runcard_station_mod_id',
            'sec_molding_runcard_station_mods.mod_id AS mod_id',
            'sec_molding_runcard_station_mods.mod_quantity AS mod_quantity'
        )
        ->get();
        return response()->json(['data' => $secondMoldingStationResult]);

        // $secondMoldingStationResult = DB::connection('mysql')
        // ->table('sec_molding_runcards')
        // ->leftJoin('sec_molding_runcard_stations', 'sec_molding_runcards.id', '=', 'sec_molding_runcard_stations.sec_molding_runcard_id')
        // ->where('sec_molding_runcards.id', 1)
        // ->groupBy('sec_molding_runcards.id')
        // ->select(
        //     'sec_molding_runcards.id',
        //     'sec_molding_runcards.device_name',
        //     DB::raw("CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id', sec_molding_runcard_stations.id, 'date', sec_molding_runcard_stations.date, 'station_yield', sec_molding_runcard_stations.station_yield) ORDER BY sec_molding_runcards.id separator ','), ']') AS sec_molding_runcard_stations"),
        // )
        // ->get();    
        // return response()->json(['data' => $secondMoldingStationResult]);

        // $stations = DB::table('sec_molding_runcard_stations')
        //     ->select('sec_molding_runcard_id')
        //     ->groupBy('sec_molding_runcard_id');

        // $secondMoldingStationResult = DB::table('sec_molding_runcards')
        //     ->joinSub($stations, 'stations', function (JoinClause $join) {
        //         $join->on('sec_molding_runcards.id', '=', 'stations.sec_molding_runcard_id');
        //     })->get();
        // return response()->json(['data' => $secondMoldingStationResult]);
    }
}

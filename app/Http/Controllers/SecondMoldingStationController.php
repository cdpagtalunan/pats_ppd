<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        $secMoldingRuncardId = isset($request->sec_molding_runcard_id) ? $request->sec_molding_runcard_id : 0;
        // return $secMoldingRuncardId;
        $secondMoldingResult = DB::connection('mysql')
            ->select("SELECT 
                        sec_molding_runcard_stations.*, 
                        CONCAT(users.firstname, ' ', users.lastname) AS operator_name, 
                        stations.station_name AS station_name  
                    FROM sec_molding_runcard_stations
                    INNER JOIN users
                        ON users.id = sec_molding_runcard_stations.operator_name
                    INNER JOIN stations
                        ON stations.id = sec_molding_runcard_stations.station
                    WHERE sec_molding_runcard_stations.sec_molding_runcard_id = '$request->sec_molding_runcard_id'
        ");

        return DataTables::of($secondMoldingResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button type='button' class='btn btn-primary btn-sm mr-1 actionEditSecondMoldingStation' data-bs-toggle='modal' data-bs-target='#modalSecondMoldingStation' second-molding-station-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
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
        // return $data;

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
                    // SecMoldingRuncardStation::where('sec_molding_runcard_id', $request->second_molding_id)->delete();
                    $secondMoldingStationId = SecMoldingRuncardStation::insertGetId([
                        'sec_molding_runcard_id' => $request->second_molding_id,
                        'station' => $request->station,
                        'date' => $request->date,
                        'operator_name' => $request->operator_name,
                        'input_quantity' => $request->input_quantity,
                        'ng_quantity' => $request->ng_quantity,
                        'output_quantity' => $request->output_quantity,
                        'station_yield' => $request->station_yield,
                        'remarks' => $request->remarks,
    
                        // 'status' => 1,
                        'created_by' => $_SESSION['user_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);
    
                    if($request->ng_quantity > 0){
                        SecMoldingRuncardStationMod::where('sec_molding_runcard_station_id', $secondMoldingStationId)->delete();
                        for ($i=0; $i < count($request->mod_id); $i++) { 
                            SecMoldingRuncardStationMod::insert([
                                'sec_molding_runcard_id' => $request->second_molding_id,
                                'sec_molding_runcard_station_id' => $secondMoldingStationId,
                                'mod_id' => $request->mod_id[$i],
                                'mod_quantity' => $request->mod_quantity[$i],
                                'created_by' => $_SESSION['user_id'],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    
    
                    DB::commit();
                    return response()->json(['hasError' => false]);
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
                    // SecMoldingRuncardStation::where('sec_molding_runcard_id', $request->second_molding_id)->delete();
                    SecMoldingRuncardStation::where('id', $request->second_molding_station_id)->update([
                        'sec_molding_runcard_id' => $request->second_molding_id,
                        'station' => $request->station,
                        'date' => $request->date,
                        'operator_name' => $request->operator_name,
                        'input_quantity' => $request->input_quantity,
                        'ng_quantity' => $request->ng_quantity,
                        'output_quantity' => $request->output_quantity,
                        'station_yield' => $request->station_yield,
                        'remarks' => $request->remarks,
    
                        'last_updated_by' => $_SESSION['user_id'],
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
    
                    if($request->ng_quantity > 0){
                        SecMoldingRuncardStationMod::where('sec_molding_runcard_station_id', $request->second_molding_station_id)->delete();
                        for ($i=0; $i < count($request->mod_id); $i++) { 
                            SecMoldingRuncardStationMod::insert([
                                'sec_molding_runcard_id' => $request->second_molding_id,
                                'sec_molding_runcard_station_id' => $request->second_molding_station_id,
                                'mod_id' => $request->mod_id[$i],
                                'mod_quantity' => $request->mod_quantity[$i],
                                'created_by' => $_SESSION['user_id'],
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    
    
                    DB::commit();
                    return response()->json(['hasError' => false]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage(), 'sessionError' => true]);
                }
            }
        }
        
    }

    public function getSecondMoldingStationById(Request $request){
        $secondMoldingStationResult = DB::connection('mysql')
        ->select("SELECT 
                        sec_molding_runcard_stations.*,
                        sec_molding_runcard_station_mods.id AS sec_molding_runcard_station_mod_id,
                        sec_molding_runcard_station_mods.mod_id AS mod_id,
                        sec_molding_runcard_station_mods.mod_quantity AS mod_quantity
                    FROM sec_molding_runcard_stations
                    INNER JOIN sec_molding_runcard_station_mods
                        ON sec_molding_runcard_station_mods.sec_molding_runcard_station_id = sec_molding_runcard_stations.id
                    WHERE sec_molding_runcard_stations.id = '$request->second_molding_station_id'
        ");
        return response()->json(['data' => $secondMoldingStationResult]);
    }
}

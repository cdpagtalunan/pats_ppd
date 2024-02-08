<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\FirstMoldingDetail;
use App\Models\FirstMolding;
use App\Models\FirstMoldingDetailMod;
use App\Models\FirstMoldingStation;
use App\Models\Station;
use App\Models\User;
use App\Http\Requests\FirstMoldingStationRequest;

class FirstMoldingStationController extends Controller
{
    public function loadFirstMoldingStationDetails(Request $request)
    {
        $first_molding_id= isset($request->first_molding_id) ? $request->first_molding_id : 0;
        $first_molding_station_details = FirstMoldingDetail::where('first_molding_id',$first_molding_id)->whereNull('deleted_at')->get();
        return DataTables::of($first_molding_station_details)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            $result .= '<button type="button" class="btn btn-info btn-sm mr-1" first-molding-station-id='.$row->id.' id="btnEditFirstMoldingStation"><i class="fa-solid fa-pen-to-square"></i></button>';
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

    // public function getStations(Request $request)
    // {
    //     try{
    //         $station = Station::get();
    //         foreach ($station as $key => $value_station) {
    //             $arr_station_id[] =$value_station['id'];
    //             $arr_station_value[] =$value_station['station_name'];
    //         }
    //         return response()->json([
    //             'id'    =>  $arr_station_id,
    //             'value' =>  $arr_station_value
    //         ]);
    //     } catch (\Throwable $th) {
    //         return $th;
    //     }
    // }

    public function saveFirstMoldingStation(FirstMoldingStationRequest $request)
    {
        date_default_timezone_set('Asia/Manila');
        try{
            // return $request->all();

            if( isset($request->first_molding_detail_id) ){
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
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $first_molding_detail_id = $request->first_molding_detail_id;
            }else{
                // return 'add';
                $get_first_molding_detail_id = FirstMoldingDetail::insertGetId([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'input' => $request->input,
                    'ng_qty' => $request->ng_qty,
                    'output' => $request->output,
                    'yield' => $request->station_yield,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $first_molding_detail_id = $get_first_molding_detail_id;
            }
        
            // $is_first_molding_station = FirstMoldingDetail::where('id',$first_molding_detail_id)->where(['station',8])->count();
            
            return response()->json( [ 'result' => 1 ] );
            /*
                TODO: Save Auto Prod Lot
                TODO: Multiple Resin Lot Number Virgin at Recycle
            */
            if(isset($request->mod_id)){
                // FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->update([
                //     'deleted_at' => date('Y-m-d H:i:s')
                // ]);
                $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false

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
                    // FirstMoldingDetailMod::where('first_molding_detail_id', $first_molding_detail_id)->update([
                    //     'deleted_at' => date('Y-m-d H:i:s')
                    // ]);
                    $is_first_molding_deleted=FirstMoldingDetailMod::find($first_molding_detail_id)->delete(); //returns true/false
                }
            }
        } catch (\Throwable $th) {
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
        $first_molding_detail = FirstMoldingDetail::where('first_molding_id',$request->first_molding_station_last_ouput)->orderBy('id','DESC')->get(['id','first_molding_id','output']);
        $is_exist = count($first_molding_detail);
        if(  $is_exist > 0 ){
            return response()->json( [
                'first_molding_station_id' => $first_molding_detail[0]->id,
                'first_molding_id' => $first_molding_detail[0]->first_molding_id,
                'first_molding_station_last_output' => $first_molding_detail[0]->output,
                'first_molding_detail_count' => $is_exist,
            ] );
        }else{
            return response()->json( [
                'first_molding_detail_count' => $is_exist,
            ] );
        }

    }

    public function getStations(Request $request)
    {
        $material_station_by_device_name = DB::connection('mysql')
        ->select("  SELECT material_processes.*, devices.*, material_process_stations.*, stations.id AS station_id, stations.station_name AS station_name FROM material_processes
                    INNER JOIN devices
                    ON devices.id = material_processes.device_id
                    INNER JOIN material_process_stations
                    ON material_process_stations.mat_proc_id = material_processes.id
                    INNER JOIN stations
                    ON stations.id = material_process_stations.station_id
                    WHERE devices.name = '$request->device_name'
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




}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\FirstMoldingDetail;
use App\Models\Station;
use App\Models\User;
use App\Http\Requests\FirstMoldingStationRequest;

class FirstMoldingStationController extends Controller
{
    public function loadFirstMoldingStationDetails(Request $request){
        // return 'true';
        $first_molding_id= isset($request->first_molding_id) ? $request->first_molding_id : 0;
        $first_molding_station_details = FirstMoldingDetail::where('first_molding_id',$first_molding_id)->get();
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

    public function getStations(Request $request)
    {
        // return 'true';
        try{
            $station = Station::get();
            foreach ($station as $key => $value_station) {
                $arr_station_id[] =$value_station['id'];
                $arr_station_value[] =$value_station['station_name'];
            }
            return response()->json([
                'id'    =>  $arr_station_id,
                'value' =>  $arr_station_value
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function saveFirstMoldingStation(FirstMoldingStationRequest $request)
    {
        date_default_timezone_set('Asia/Manila');
        try{
            if( isset($request->first_molding_detail_id) ){
                // return 'edit';
                FirstMoldingDetail::where('id',$request->first_molding_detail_id)
                ->update([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'input' => $request->input,
                    'ng_qty' => $request->ng_qty,
                    'output' => $request->output,
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }else{
                // return 'add';
                FirstMoldingDetail::insert([
                    'first_molding_id' => $request->first_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'input' => $request->input,
                    'ng_qty' => $request->ng_qty,
                    'output' => $request->output,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getFirstMoldingStationDetails(Request $request)
    {
        $first_station_molding = FirstMoldingDetail::where('id',$request->first_molding_station_id)->get();
        return response()->json( [ 'first_station_molding' => $first_station_molding ] );
    }


}

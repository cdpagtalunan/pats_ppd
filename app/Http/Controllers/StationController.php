<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Station;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StationController extends Controller
{
    public function view_station(Request $request){
        $stations = Station::all();

        return DataTables::of($stations)
        ->addColumn('action', function($stations){
            $result = "";
            $result .= "<center>";

            if($stations->status == 0){
                $result .= "<button class='btn btn-sm btn-secondary ml-1 btnEditStation' data-id='$stations->id'><i class='fa-solid fa-pen-to-square'></i></button>";
                $result .= "<button class='btn btn-sm btn-danger ml-1 btnDeactivateStation' data-id='$stations->id' data-status='1'><i class='fa-solid fa-ban'></i></button>";
            }
            else{
                $result .= "<button class='btn btn-sm btn-success ml-1 btnActivateStation' data-id='$stations->id' data-status='0'><i class='fa-solid fa-rotate-left'></i></button>";
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('label', function($stations){
            $result = "";

            if($stations->status == 0){
                $result .= "<span class='badge bg-success'>Active</span>";
            }
            else{
                $result .= "<span class='badge bg-danger'>Diactivated</span>";
            }

            return $result;
        })
        ->rawColumns(['label', 'action'])
        ->make(true);
    }

    public function save_station(Request $request){

        DB::beginTransaction();
        
        try{
            if(isset($request->id)){
                Station::where('id', $request->id)
                ->update([
                    'station_name' => $request->station_name,
                    'updated_by' => Auth::user()->id
                ]);
                
            }
            else{
                Station::insert([
                    'station_name' => $request->station_name,
                    'created_by' => Auth::user()->id,
                    'created_at' => NOW()
                ]);
            }

            DB::commit();

            return response()->json(['result' => 1, 'msg' => 'Successfully Transacted']);
            
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    public function get_station_details_by_id(Request $request){
        return Station::where('id', $request->id)->first();
    }

    public function update_status(Request $request){
        DB::beginTransaction();
        try{
            Station::where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);
            DB::commit();

            return response()->json(['result' => 1, 'msg' => 'Successfully Saved']);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }
}

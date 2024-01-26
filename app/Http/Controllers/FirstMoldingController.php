<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\FirstMolding;
use Illuminate\Http\Request;
use App\Models\FirstMoldingDevice;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FirstMoldingRequest;

class FirstMoldingController extends Controller
{
    public function getFirstMoldingDevices(Request $request)
    {
        $first_molding_device = FirstMoldingDevice::get();
        foreach ($first_molding_device as $key => $value_first_molding_device) {
            $arr_first_molding_device_id[] =$value_first_molding_device['id'];
            $arr_first_molding_device_value[] =$value_first_molding_device['device_name'];
        }
        return response()->json([
            'id'    =>  $arr_first_molding_device_id,
            'value' =>  $arr_first_molding_device_value
        ]);
    }

    public function getFirstMoldingDevicesById(Request $request)
    {
        return $first_molding_device = FirstMoldingDevice::where('id',$request->first_molding_device_id)->get();
    }
    public function loadFirstMoldingDetails(Request $request)
    {
        $first_molding_device_id= isset($request->first_molding_device_id) ? $request->first_molding_device_id : 0;
        $first_molding_device = DB::connection('mysql')
        ->select('
                SELECT  first_moldings.*,devices.*
                FROM first_moldings first_moldings
                RIGHT JOIN first_molding_devices devices ON devices.id = first_moldings.first_molding_device_id
                WHERE first_moldings.first_molding_device_id = '.$first_molding_device_id.'
                ORDER BY first_moldings.created_at DESC
        ');
        return DataTables::of($first_molding_device)
        ->addColumn('action', function($row){
            $result = '1';
            return $result;
        })
        ->addColumn('status', function($row){
            $result = '1';
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function saveFirstMolding(FirstMoldingRequest $request){
        if( isset( $request->first_molding_id )){ //Edit
            return 'edit';

        }else{ //Add
            FirstMolding::insert([
                'first_molding_device_id' => $request->first_molding_device_id,
                'contact_lot_number' => $request->contact_lot_number,
                'production_lot' => $request->production_lot,
                'remarks' => $request->remarks,
            ]);
        }
        return response()->json( [ 'result' => 1 ] );
    }

}

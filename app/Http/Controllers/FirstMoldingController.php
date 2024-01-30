<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Models\Station;
use App\Models\FirstMolding;
use App\Models\FirstMoldingDevice;
use App\Models\FirstMoldingDetail;
use App\Http\Requests\FirstMoldingRequest;
use App\Http\Requests\FirstMoldingStationRequest;

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
        $first_molding = DB::connection('mysql')
        ->select('
                SELECT  first_moldings.*,first_moldings.id as "first_molding_id",devices.*
                FROM first_moldings first_moldings
                RIGHT JOIN first_molding_devices devices ON devices.id = first_moldings.first_molding_device_id
                WHERE first_moldings.first_molding_device_id = '.$first_molding_device_id.'
                ORDER BY first_moldings.created_at DESC
        ');
        return DataTables::of($first_molding)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            switch ($row->status) {
                case 0:
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    break;
                case 1:
                    $result .= "<button class='btn btn-success btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnPrintFirstMolding'><i class='fa-solid fa-print' disabled></i></button>";
                    break;
                default:
                    $result .= "";
                    break;
            }
            $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($row){

            $result = '';
            $result .= '<center>';
            switch ($row->status) {
                case 0:
                    $result .= '<span class="badge rounded-pill bg-primary"> On-going </span>';
                    break;
                case 1:
                    $result .= '<span class="badge rounded-pill bg-success"> Done </span>';
                    break;
                default:
                    $result .= '<span class="badge rounded-pill bg-success"> Unknown Status </span>';
                    break;
            }
            $result .= '</center>';
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function saveFirstMolding(FirstMoldingRequest $request)
    {
        date_default_timezone_set('Asia/Manila');
        try{
            if( isset( $request->first_molding_id )){ //Edit
                // return 'edit';
                // return $request->first_molding_id;
                FirstMolding::where('id',$request->first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'contact_lot_number' => $request->contact_lot_number,
                    'production_lot' => $request->production_lot,
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }else{ //Add
                FirstMolding::insert([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'contact_lot_number' => $request->contact_lot_number,
                    'production_lot' => $request->production_lot,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getMoldingDetails(Request $request)
    {
        try{
            $first_molding = FirstMolding::with('firstMoldingDevice')
            ->where('id',$request->first_molding_id)
            ->get();
            // $first_molding = FirstMolding::
            // where('id',$request->first_molding_id)
            // ->get();
            return response()->json( [ 'first_molding' => $first_molding ] );

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function firstMoldingUpdateStatus(Request $request)
    {
        FirstMolding::where('id',$request->first_molding_id)->update(['status' => 1]);
        return response()->json( [ 'result' => 1 ] );
    }




}

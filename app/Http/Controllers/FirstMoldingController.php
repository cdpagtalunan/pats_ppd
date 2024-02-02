<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\Station;
use App\Models\FirstMolding;
use App\Models\FirstMoldingDevice;
use App\Models\FirstMoldingDetail;
use App\Models\TblPoReceived;
use App\Models\TblDieset;
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
        // return $request->all();

        date_default_timezone_set('Asia/Manila');
        try{
            $data = $request->all();
            $validation = array(
                'production_lot' => ['required'],
                'production_lot_extension' => ['required'],
                'contact_name' => ['required'],
                'contact_lot_number' => ['required'],
            );

            $validator = Validator::make($data, $validation);

            if ($validator->fails()) {
                return response()->json(['result' => '0', 'error' => $validator->messages()]);
            }

            if( isset( $request->first_molding_id )){ //Edit
                FirstMolding::where('id',$request->first_molding_id)->update($request->validated());
                FirstMolding::where('id',$request->first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'contact_lot_number' => $request->contact_lot_number,
                    'production_lot' => $request->production_lot . $request->production_lot_extension ,
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            }else{ //Add
                $first_molding_id = FirstMolding::insertGetId($request->validated());
                FirstMolding::where('id',$first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'production_lot' => $request->production_lot . $request->production_lot_extension ,
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
        try{
            FirstMolding::where('id',$request->first_molding_id)->update(['status' => 1]);
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function getPmiPoReceivedDetails (Request $request)
    {
        try{
            $tbl_po_received = TblPoReceived::where('OrderNo',$request->pmi_po_no)->get();

            if( count($tbl_po_received) == 1){
                return response()->json( [
                    'result_count' => count($tbl_po_received),
                    'po_no' => $tbl_po_received[0]->ProductPONo ,
                    'order_qty' => $tbl_po_received[0]->OrderQty ,
                    'po_balance' => $tbl_po_received[0]->POBalance ,
                    'item_code' => $tbl_po_received[0]->ItemCode ,
                    'item_name' => $tbl_po_received[0]->ItemName ,
                ] );
            }else{
                return response()->json( [
                    'result_count' => 0,
                ] );
            }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getDiesetDetailsByDeviceName (Request $request){
        $tbl_dieset =  TblDieset::where('DeviceName',$request->device_name)->get();
        return response()->json( [
             'dieset_no' => $tbl_dieset[0]->DieNo,
             'drawing_no' => $tbl_dieset[0]->DrawingNo,
             'rev_no' => $tbl_dieset[0]->Rev,
        ] );

    }




}

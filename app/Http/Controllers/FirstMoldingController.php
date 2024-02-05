<?php

namespace App\Http\Controllers;
use DataTables;
use App\Models\Station;
use App\Models\TblDieset;
use App\Models\FirstMolding;
use Illuminate\Http\Request;
use App\Models\TblPoReceived;
use App\Models\FirstMoldingDetail;
use App\Models\FirstMoldingDevice;
use Illuminate\Support\Facades\DB;
use App\Models\FirstMoldingMaterialList;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\FirstMoldingRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
                case 2:
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    break;
                case 3:
                    $result .= "";
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
                    $result .= '<span class="badge rounded-pill bg-info"> For Mass Prod </span>';
                    break;
                case 2:
                    $result .= '<span class="badge rounded-pill bg-warning"> Re set-up </span>';
                    break;
                case 3:
                    $result .= '<span class="badge rounded-pill bg-success"> Done </span>';
                    break;
                default:
                    $result .= '<span class="badge rounded-pill bg-secondary"> Unknown Status </span>';
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
            $data = $request->all();
            $virgin_material = $request->virgin_material;
            $recycle_material = $request->recycle_material;

            $validation = array(
                // 'production_lot' => ['required'],
                // 'production_lot_extension' => ['required'],
                'contact_name' => ['required'],
                'contact_lot_number' => ['required'],
                // 'recycle_material' => ['required'],
                // 'virgin_material' => ['required'],
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
                    // 'contact_lot_number' => $request->contact_lot_number,
                    // 'production_lot_extension' => $request->production_lot_extension,
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $get_first_molding_id = $request->first_molding_id;

            }else{ //Add
                $first_molding_id = FirstMolding::insertGetId($request->validated());
                FirstMolding::where('id',$first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    // 'production_lot' => $request->production_lot,
                    // 'production_lot_extension' => $request->production_lot_extension,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $get_first_molding_id = $first_molding_id;
            }

            if(isset($virgin_material)){
                FirstMoldingMaterialList::where('first_molding_id', $get_first_molding_id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);

                foreach ( $virgin_material as $key => $value_virgin_material) {
                    FirstMoldingMaterialList::insert([
                        'first_molding_id'   => $get_first_molding_id,
                        'virgin_material'           => $virgin_material[$key],
                        'recycle_material'              => $request->recycle_material[$key],
                        'created_at'                => date('Y-m-d H:i:s')
                    ]);
                }
            }else{
                if(FirstMoldingMaterialList::where('first_molding_id', $get_first_molding_id)->exists()){
                    FirstMoldingMaterialList::where('first_molding_id', $get_first_molding_id)->update([
                        'deleted_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getMoldingDetails(Request $request)
    {
        try{
            /*
                TODO: Save Auto Prod Lot
                TODO: Multiple Resin Lot Number Virgin at Recycle
                TODO: Show Variance
            */
            $first_molding = FirstMolding::with('firstMoldingDevice','firstMoldingMaterialLists')
            ->where('id',$request->first_molding_id)
            ->get();
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
    public function getFirstMoldingQrCode (Request $request){
        // return $request->all();
        return $first_molding = FirstMolding::with('firstMoldingDevice')
        ->where('id',$request->first_molding_id)
        // ->get(['first_molding_device']);
        ->first([
            'po_no AS po','item_code AS code','item_name AS name',
            'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
            'po_qty AS qty','shipment_output AS output_qty'
        ]);

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate($first_molding);

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);
    
        $data[] = array(
            'img' => $qr_code, 
            'text' =>  "<strong>$first_molding->po</strong><br>
            <strong>$first_molding->code</strong><br>
            <strong>$first_molding->name</strong><br>
            <strong>".$first_molding->lot_no."".$first_molding->lot_no_ext."</strong><br>
            <strong>$first_molding->qty</strong><br>
            <strong>$first_molding->output_qty</strong><br>
            "
        );
        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'> 
                <tr>
                    <td>PO No.:</td>
                    <td>$first_molding->po</td>
                </tr>
                <tr>
                    <td>Material Code:</td>
                    <td>$first_molding->code</td>
                </tr>
                <tr>
                    <td>Material Name:</td>
                    <td>$first_molding->name</td>
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
                    <td>$first_molding->qty</td>
                </tr>
            </table>
        ";

        return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'first_molding_data' => $first_molding]);
    }
    



}

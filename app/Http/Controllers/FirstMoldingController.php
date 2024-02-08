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
                WHERE first_moldings.first_molding_device_id = '.$first_molding_device_id.' AND first_moldings.deleted_at IS NULL
                AND devices.deleted_at IS NULL
                ORDER BY first_moldings.created_at DESC
        ');
        return DataTables::of($first_molding)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            switch ($row->status) {
                case 0:
                    // $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    $result .= "<button class='btn btn-outline-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' view-data='true' id='btnViewFirstMolding'><i class='fa-solid fa-eye'></i></button>";
                    break;
                case 1:
                    // $result .= "<button class='btn btn-success btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnPrintFirstMolding'><i class='fa-solid fa-print' disabled></i></button>";
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    // $result .= "<button class='btn btn-outline-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' view-data='true' id='btnViewFirstMolding'><i class='fa-solid fa-eye'></i></button>";
                    break;
                case 2:
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    break;
                case 3:
                    // $result .= "";
                    $result .= "<button class='btn btn-outline-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' view-data='true' id='btnViewFirstMolding'><i class='fa-solid fa-eye'></i></button>";
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
                    $result .= '<span class="badge rounded-pill bg-info"> For Quali </span>';
                    break;
                case 1:
                    $result .= '<span class="badge rounded-pill bg-primary"> For Mass Prod </span>';
                    break;
                case 2:
                    $result .= '<span class="badge rounded-pill bg-warning"> Re-quali </span>';
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
        ->addColumn('prodn_lot_number', function($row){
            $result = '';
            return $result = $row->production_lot . $row->production_lot_extension;
        })
        ->rawColumns(['action','status','prodn_lot_number'])
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
                'contact_name' => ['required'],
                'contact_lot_number' => ['required'],
            );

            $validator = Validator::make($data, $validation);

            if ($validator->fails()) {
                return response()->json(['result' => '0', 'error' => $validator->messages()]);
            }
            if( isset( $request->first_molding_id )){ //Edit
                $first_molding_status = FirstMolding::where('id',$request->first_molding_id)->get(['status']);
                if($first_molding_status[0]->status == 2){ // if status is 2 or re set up change the status into 0 - For Quali
                    FirstMolding::where('id',$request->first_molding_id)
                    ->update([
                        'deleted_at' => date('Y-m-d H:i:s'),
                    ]);
                    $first_molding_id = FirstMolding::insertGetId($request->validated());
                    FirstMolding::where('id',$first_molding_id)
                        ->update([
                            'first_molding_device_id' => $request->first_molding_device_id,
                            'remarks' => $request->remarks,
                            'created_at' => date('Y-m-d H:i:s'),
                    ]);
                    $get_first_molding_id = $first_molding_id;
                }else{
                    FirstMolding::where('id',$request->first_molding_id)->update($request->validated());
                    FirstMolding::where('id',$request->first_molding_id)
                    ->update([
                        'first_molding_device_id' => $request->first_molding_device_id,
                        'remarks' => $request->remarks,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    $get_first_molding_id = $request->first_molding_id;
                }

            }else{ //Add
                $first_molding_id = FirstMolding::insertGetId($request->validated());
                FirstMolding::where('id',$first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'remarks' => $request->remarks,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                $get_first_molding_id = $first_molding_id;
            }

            /* Save Resin  Materials */
            if(isset($virgin_material)){
                FirstMoldingMaterialList::where('first_molding_id', $get_first_molding_id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);

                foreach ( $virgin_material as $key => $value_virgin_material) {
                    FirstMoldingMaterialList::insert([
                        'first_molding_id'   => $get_first_molding_id,
                        'virgin_material'    => $virgin_material[$key],
                        'virgin_qty'         => $request->virgin_qty[$key],
                        'recycle_material'   => $request->recycle_material[$key],
                        'recycle_qty'        => $request->recycle_qty[$key],
                        'created_at'         => date('Y-m-d H:i:s'),
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

    public function getDiesetDetailsByDeviceName (Request $request)
    {
        // $tbl_dieset =  TblDieset::where('DeviceName',$request->device_name)->get();
        // return $request->device_name;
        return $tbl_dieset = DB::connection('mysql_rapid_stamping_dmcms')
        ->select('SELECT * FROM `tbl_device` WHERE `device_name` LIKE "'.$request->device_name.'" ');

        // if(count($get_drawing) > 0){
        //     return $get_drawing[0];
        // }
        // else{
        //     // return "No Data on Stamping DMCMS";
        //     return response()->json(['msg' => 'No Data on Stamping DMCMS'], 400);
        // }
        return response()->json( [
            //  'dieset_no' => $tbl_dieset[0]->DieNo,
             'drawing_no' => $tbl_dieset[0]->drawing_no,
             'rev_no' => $tbl_dieset[0]->rev,
        ] );

    }

    public function getFirstMoldingQrCode (Request $request)
    {

        $first_molding = FirstMolding::leftJoin('first_molding_devices', function($join) {
            $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        })
        ->where('first_moldings.id',$request->first_molding_id)
        ->whereNull('first_moldings.deleted_at')
        ->first([
        'po_no AS po','item_code AS code','item_name AS name',
        'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
        'po_qty AS qty','shipment_output AS output_qty','first_molding_devices.device_name AS device_name'
        ]);

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate($first_molding);

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $qr_code,
            'text' =>  "<strong>$first_molding->po</strong><br>
            <strong>$first_molding->code</strong><br>
            <strong>$first_molding->device_name</strong><br>
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
                    <td>$first_molding->device_name</td>
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

    public function updateFirstMoldingShipmentMachineOuput (Request $request)
    {

        $save_first_molding = FirstMolding::where('id',$request->first_molding_id)->update([
            'shipment_output' => $request->shipment_output,
            'ng_count' => $request->ng_count,
            'total_machine_output' => $request->total_machine_output,
        ]);

    }





}

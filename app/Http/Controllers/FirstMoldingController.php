<?php

namespace App\Http\Controllers;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Http\Requests\FirstMoldingStationRequest;
use App\Http\Requests\FirstMoldingRequest;
use App\Models\Mimf;
use App\Models\Station;
use App\Models\TblDieset;
use App\Models\FirstMolding;
use App\Models\TblPoReceived;
use App\Models\FirstMoldingDetail;
use App\Models\FirstMoldingDevice;
use App\Models\FirstStampingProduction;
use App\Models\FirstMoldingMaterialList;




class FirstMoldingController extends Controller
{
    public function getFirstMoldingDevices(Request $request) //FirstMoldingDevice::
    {
        $first_molding_device = FirstMoldingDevice::where('process_type',1)->whereNull('deleted_at')->get();
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
        date_default_timezone_set('Asia/Manila');
        $first_molding_device_id= isset($request->first_molding_device_id) ? $request->first_molding_device_id : 0;
        $global_po_no= isset($request->global_po_no) ? $request->global_po_no : 0;
        $first_molding = DB::connection('mysql')
        ->select('
                SELECT  first_moldings.*,first_moldings.id as "first_molding_id",devices.*,first_moldings.created_at as date_created
                FROM first_moldings first_moldings
                RIGHT JOIN first_molding_devices devices ON devices.id = first_moldings.first_molding_device_id
                WHERE first_moldings.first_molding_device_id = '.$first_molding_device_id.' AND first_moldings.pmi_po_no = "'.$global_po_no.'" AND first_moldings.deleted_at IS NULL
                AND devices.deleted_at IS NULL
                ORDER BY first_moldings.created_at DESC
        ');
        return DataTables::of($first_molding)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            switch ($row->status) {
                case 0:
                    $result .= "<button class='btn btn-outline-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' view-data='true' id='btnViewFirstMolding'><i class='fa-solid fa-eye'></i></button>";
                    break;
                case 1:
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    $result .= "<button class='btn btn-warning btn-sm mr-1' first-molding-id='".$row->first_molding_id."' id='btnPrintFirstMolding'><i class='fa-solid fa-print' disabled></i></button>";
                    break;
                case 2:
                    $result .= "<button class='btn btn-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnEditFirstMolding'><i class='fa-solid fa-pen-to-square'></i></button>";
                    break;
                case 3:
                    $result .= "<button class='btn btn-outline-info btn-sm mr-1'first-molding-id='".$row->first_molding_id."' view-data='true' id='btnViewFirstMolding'><i class='fa-solid fa-eye'></i></button>";
                    if($row->first_molding_device_id > 1){
                        $result .= "<button class='btn btn-success btn-sm mr-1'first-molding-id='".$row->first_molding_id."' id='btnPrintFirstMolding'><i class='fa-solid fa-print' disabled></i></button>";
                    }
                    break;
                default:
                    $result .= "";
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
        ->addColumn('prodn_output', function($row){
            $result = '';
            switch ($row->status) {
                case 3:
                    $result .= $row->date_created;
                    break;
                default:
                    $result .= 0;
                    break;
            }
            return $result;
        })
        ->addColumn('date_created', function($row){
            $result = $row->date_created;
            // $result = date('Y-m-d H:i:s', $row->created_by);
            return $result;
        })
        ->rawColumns(['action','status','prodn_lot_number','prodn_output','date_created'])
        ->make(true);
    }

    public function saveFirstMolding(FirstMoldingRequest $request)
    {
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
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
                FirstMolding::where('id',$request->first_molding_id)->update($request->validated());
                FirstMolding::where('id',$request->first_molding_id)
                ->update([
                    'first_molding_device_id' => $request->first_molding_device_id,
                    'status' => 1,
                    'remarks' => $request->remarks,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $get_first_molding_id = $request->first_molding_id;

                /*
                    TODO:if status is 2 or re set up change the status into 0 - For Quali
                    $first_molding_status = FirstMolding::where('id',$request->first_molding_id)->get(['status']);

                    if($first_molding_status[0]->status == 2){
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
                */
            }else{ //Add
                /*
                    //TODO: Check if Production Lot is exist
                        $first_molding = DB::connection('mysql')
                        ->select('SELECT * FROM `first_moldings`
                        WHERE `production_lot` = "'.$request->production_lot.'"
                        AND `production_lot_extension` = "'.$request->production_lot_extension.'"
                        AND `deleted_at` IS NULL
                    ');
                    if( count($first_molding) > 1 ){
                        DB::rollback();
                        return response()->json(['result' => '0', 'error' => 'Saving Failed. Production Lot already exists'],500);
                    }
                */
                $is_exist_first_molding = FirstMolding::where('production_lot',$request->production_lot)
                                                    ->where('production_lot_extension',$request->production_lot_extension)
                                                    ->whereNull('deleted_at')->exists();
                if( $is_exist_first_molding == 1 ){
                    DB::rollback();
                    return response()->json(['result' => '0', 'error' => 'Saving Failed. Production Lot already exists'],500);
                }

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
            // DB::rollback();
            DB::commit();
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;

        }
    }

    public function getMoldingDetails(Request $request)
    {
        try{
            date_default_timezone_set('Asia/Manila');
            /*
                TODO: Save Auto Prod Lot
                TODO: Multiple Resin Lot Number Virgin at Recycle
                TODO: Show Variance
            */
            $first_molding = FirstMolding::with('firstMoldingDevice','firstMoldingMaterialLists')
            ->where('id',$request->first_molding_id)
            ->get();
            return response()->json( [ 'first_molding' => $first_molding , 'created_at' => Carbon::parse($first_molding[0]['created_at'])->format('Y-m-d H:i:s') ]);

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function firstMoldingUpdateStatus(Request $request)
    {
        try{
            FirstMolding::where('id',$request->first_molding_id)->update(['status' => 3]);
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function getPmiPoReceivedDetails (Request $request)
    {
        try{
            $tbl_po_received = TblPoReceived::where('OrderNo',$request->pmi_po_no)->get();
            $tbl_milf = Mimf::where('pmi_po_no',$request->pmi_po_no)->get();
            if( count ($tbl_po_received) == 0 || count($tbl_milf) == 0){
                return response()->json( [
                        'result' => 0,
                        'result_count' => 0,
                        'error_msg' => "PO not Found. Please check this PO Number to MIMF Module !",
                    ]
                );
            }
            if( count($tbl_po_received) > 0 && count($tbl_milf) > 0 ){
                return response()->json( [
                    'result_count' => count($tbl_po_received),
                    'pmi_po_no' => $tbl_po_received[0]->OrderNo ,
                    'po_no' => $tbl_po_received[0]->ProductPONo ,
                    'order_qty' => $tbl_po_received[0]->OrderQty ,
                    'po_balance' => $tbl_po_received[0]->POBalance ,
                    'item_code' => $tbl_po_received[0]->ItemCode ,
                    'item_name' => $tbl_po_received[0]->ItemName ,
                    'material_type' => $tbl_milf[0]->material_type ,
                    'virgin_qty' => $tbl_milf[0]->virgin_material ,
                    'recycled_qty' => $tbl_milf[0]->recycled ,
                ] );
            }
            //tbl_milf[0]->control_no;
            //tbl_milf[0]->date_issuance;
            //tbl_milf[0]->material_type;
            //tbl_milf[0]->needed_kgs;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getDiesetDetailsByDeviceName (Request $request)
    {
        // $tbl_dieset =  TblDieset::where('DeviceName',$request->device_name)->get();
        // return $request->device_name;
        if($request->device_name == "CN171S-09#IN-R-VE" || $request->device_name == "CN171S-10#IN-L-VE"){
            $device_name = "CN171S-09/10#IN-VE";
        }else{
            $device_name = $request->device_name;
        }
        $tbl_dieset = DB::connection('mysql_rapid_stamping_dmcms')
        ->select('SELECT * FROM `tbl_device` WHERE `device_name` LIKE "'.$device_name.'" ');


        return response()->json( [
            //  'dieset_no' => $tbl_dieset[0]->DieNo,
             'drawing_no' => $tbl_dieset[0]->drawing_no,
             'rev_no' => $tbl_dieset[0]->rev,
        ] );

    }

    // public function getFirstMoldingQrCode (Request $request)
    // {

    //     $first_molding = FirstMolding::leftJoin('first_molding_devices', function($join) {
    //         $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
    //     })
    //     ->where('first_moldings.id',$request->first_molding_id)
    //     ->whereNull('first_moldings.deleted_at')
    //     ->first([
    //     'pmi_po_no AS pmi_po','po_no AS po','item_code AS code','item_name AS name',
    //     'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
    //     'po_qty AS qty','shipment_output AS output_qty','first_molding_devices.device_name AS device_name'
    //     ]);

    //     $qrcode = QrCode::format('png')
    //     ->size(250)->errorCorrection('H')
    //     ->generate( $first_molding );

    //     $qr_code = "data:image/png;base64," . base64_encode($qrcode);

    //     $data[] = array(
    //         'img' => $qr_code,
    //         'text' =>  "<strong>$first_molding->po</strong><br>
    //         <strong>$first_molding->code</strong><br>
    //         <strong>$first_molding->device_name</strong><br>
    //         <strong>".$first_molding->lot_no."".$first_molding->lot_no_ext."</strong><br>
    //         <strong>$first_molding->qty</strong><br>
    //         <strong>$first_molding->output_qty</strong><br>
    //         "
    //     );
    //     $label = "
    //         <table class='table table-sm table-borderless' style='width: 100%;'>
    //             <tr>
    //                 <td>PO No.:</td>
    //                 <td>$first_molding->po</td>
    //             </tr>
    //             <tr>
    //                 <td>Material Code:</td>
    //                 <td>$first_molding->code</td>
    //             </tr>
    //             <tr>
    //                 <td>Material Name:</td>
    //                 <td>$first_molding->device_name</td>
    //             </tr>
    //             <tr>
    //                 <td>Production Lot #:</td>
    //                 <td>".$first_molding->lot_no."".$first_molding->lot_no_ext."</td>
    //             </tr>
    //             <tr>
    //                 <td>Shipment Output:</td>
    //                 <td>$first_molding->output_qty</td>
    //             </tr>
    //             <tr>
    //                 <td>PO Quantity:</td>
    //                 <td>$first_molding->qty</td>
    //             </tr>
    //         </table>
    //     ";

    //     return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'first_molding_data' => $first_molding]);
    // }
    public function getFirstMoldingQrCode (Request $request)
    {

        $first_molding = FirstMolding::leftJoin('first_molding_devices', function($join) {
            $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        })
        ->where('first_moldings.id',$request->first_molding_id)
        ->whereNull('first_moldings.deleted_at')
        // ->get();
        ->first([
        'po_no AS po','item_code AS code','item_name AS name',
        'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
        'po_qty AS qty','shipment_output AS output_qty','first_molding_devices.device_name AS device_name'
        ]);

        $first_molding_label = FirstMolding::leftJoin('first_molding_devices', function($join) {
            $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        })
        ->where('first_moldings.id',$request->first_molding_id)
        ->whereNull('first_moldings.deleted_at')
        ->first(['pmi_po_no AS pmi_po']);

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate($first_molding);

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);
            //<strong>$first_molding->code</strong><br>
            // <tr>
            //     <td>Material Code:</td>
            //     <td>$first_molding->code</td>
            // </tr>

        $data[] = array(
            'img' => $qr_code,
            'text' =>  "
            <strong>1st Molding</strong><br>
            <strong>$first_molding_label->pmi_po</strong><br>
            <strong>$first_molding->po</strong><br>
            <strong>$first_molding->device_name</strong><br>
            <strong>".$first_molding->lot_no."".$first_molding->lot_no_ext."</strong><br>
            <strong>$first_molding->qty</strong><br>
            <strong>$first_molding->output_qty</strong><br>
        ");

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>1st Molding</td>
                </tr>
                <tr>
                    <td>PMI PO No.:</td>
                    <td>$first_molding_label->pmi_po</td>
                </tr>
                <tr>
                    <td>PO No.:</td>
                    <td>$first_molding->po</td>
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
        $arr_ng_qty = [];
        $arr_total_machine_output = [];
        // Read all NG QTY from First Molding Details Table
        $arr_ng_qty_first_molding_station_by_first_molding_id = FirstMoldingDetail::where('first_molding_id',$request->first_molding_id)->whereNull('deleted_at')->get(['ng_qty']);
        foreach ($arr_ng_qty_first_molding_station_by_first_molding_id as $key => $value) {
            $arr_ng_qty [] = $value->ng_qty;
        }
        // Calculate the NG QTY then save to First Molding Table
        $sum_ng_qty = array_sum($arr_ng_qty);

        $update_first_molding = FirstMolding::where('id',$request->first_molding_id)->update([
            'shipment_output' => $request->shipment_output,
            'ng_count' => $sum_ng_qty
        ]);
        // Calculate the total machine output then save to First Molding Table
        $get_first_molding_by_id = FirstMolding::findOrFail($request->first_molding_id);

        $arr_total_machine_output = [
            $get_first_molding_by_id['target_shots'],
            $get_first_molding_by_id['adjustment_shots'],
            $get_first_molding_by_id['ng_count'],
            $get_first_molding_by_id['qc_samples'],
            $get_first_molding_by_id['prod_samples'],
            $get_first_molding_by_id['shipment_output'],
        ];
        $sum_total_machine_output =array_sum($arr_total_machine_output);

        $update_first_molding_total_machine_output = FirstMolding::where('id',$request->first_molding_id)->update([
            'total_machine_output' => $sum_total_machine_output,
        ]);

        return response()->json([
            "result" => 1,
            "shipment_output" => $request->shipment_output,
            "ng_count" => $sum_ng_qty,
            "total_machine_output" => $sum_total_machine_output,
        ]);
    }

    public function validateScanFirstMoldingContactLotNum (Request $request){
        /*
            {
                "po": "450244133600010",
                "code": "108321601",
                "name": "CT 6009-VE",
                "production_lot_no": "D240202-01-1",
                "qty": 88000,
                "output_qty": 2223,
                "cat": 2,
                "sublot_qty": 2223,
                "sublot_counter": "1/1"
            }
            return $material_station_by_device_name = DB::connection('mysql')
            ->select("  SELECT material_processes.*, devices.*, stations.station_name AS 'station_name',material.material_type,material.id as 'material_id' FROM material_processes
                        INNER JOIN devices
                        ON devices.id = material_processes.device_id
                        INNER JOIN material_process_materials material
                        ON material.mat_proc_id = material_processes.id
                        WHERE devices.name = '$request->device_name' AND material_processes.status = 0
                        ORDER BY material.id ASC
            ");

        */
        try{
            $get_first_molding_device =  FirstMoldingDevice::where('id',$request->first_molding_device_id)->get(['contact_name']);
            $stamping_prod = FirstStampingProduction::where('prod_lot_no',$request->contact_lot_num)->whereNull('deleted_at')->get(['status','material_name']);
            $current_status = $stamping_prod[0]->status;

            if( count($get_first_molding_device) == 0 ){
                return response()->json([
                    "result" => 0,
                    "error_msg" => "First Molding Device Name does not exist.",
                ],500);
            }

            if( count($stamping_prod) == 0 ){
                return response()->json([
                    "result" => 0,
                    "error_msg" => "Prodn Lot Number does not exist.",
                ],500);
            }

            if($get_first_molding_device[0]->contact_name != $stamping_prod[0]->material_name ){
                return response()->json([
                    "result" => 0,
                    "error_msg" => "2nd Stamping Material Name and First Molding Contact Name not match. Please check the Matrix !",
                ],500);
            }
        /*    */

            if($current_status == 2 || $current_status == 4){
                return response()->json([
                    "result" => 1,
                    "stamping_prodn_status" => $current_status,
                ]);
            }else{
                return response()->json([
                    "result" => 2,
                    "stamping_prodn_status" => $current_status,
                ]);
            }

        }catch(Exemption $e){
            return $e;
        }
    }


    public function getDatalistMimfPoNum (Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            $first_molding = DB::connection('mysql')
            ->select('
                    SELECT  pmi_po_no
                    FROM mimfs
                    WHERE pmi_po_no LIKE "%'.$request->pmi_po_no.'%"
                    LIMIT 0,20
            ');
            if(count ($first_molding)  == 0 ){
                return response()->json(['is_success' => 'false', 'exceptionError' => 'First Molding not exists']);
            }
            foreach ($first_molding as $key => $value) {
                $arr_first_molding[] = $value->pmi_po_no;
            }
            return response()->json(['is_success'=>'true','pmi_po_num' => $arr_first_molding]);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }
    public function validateMaterialLotNo(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            // 3918K56 Lot_number 3707K30
            // return $request->first_molding_material_lot_no;
            $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
            ->select('
                SELECT  whs_transaction.Lot_number
                FROM tbl_WarehouseTransaction whs_transaction
                INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
                WHERE whs_transaction.Lot_number = "'.$request->first_molding_material_lot_no.'"
                ORDER BY whs.PartNumber DESC
            ');
            return response()->json(['is_success' => 'true', 'is_exist_lot_no' => count($tbl_whs_trasanction)]);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }


}

<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Auth;
use DataTables;

use App\Models\User;
use App\Models\MimfV2;
use App\Models\Device;
use App\Models\TblDieset;
use App\Models\PPSRequest;
use App\Models\PPSItemList;
use App\Models\TblWarehouse;
use App\Models\TblPoReceived;
use App\Models\MimfV2PpsRequest;
use App\Models\MimfV2StampingMatrix;
use App\Models\MimfV2PpsRequestAllowedQuantity;

class MimfV2Controller extends Controller
{
    public function viewMimfV2(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimfs = MimfV2::with([
            'pps_po_received_info.po_received_to_pps_whse_info.stamping_info',
        ])
        ->where('logdel', 0)
        ->where('status', $request->mimfCategory)
        ->orderBy('control_no', 'DESC')
        ->get();
        return DataTables::of($get_mimfs)
        ->addColumn('action', function($get_mimf) use($request){
            $mimf_stamping_matrix_id = "";
            $result = '<center>';
                if($get_mimf->pps_po_received_info->POBalance != 0){
                    $balance = '';
                    $result .= '
                    <button class="btn btn-dark btn-sm text-center mr-2
                    actionEditMimf"
                    mimf-id="'. $get_mimf->id .'"
                    mimf-status="'. $get_mimf->status .'"
                    po_received-id="'. $get_mimf->pps_po_received_info->id .'"
                    data-bs-toggle="modal"
                    data-bs-target="#modalMimf"
                    data-bs-keyboard="false" title="Edit">
                    <i class="nav-icon fa fa-edit"></i>
                    </button>';
                }else{
                    $balance = '0';
                    $result .= '<span class="badge badge-pill badge-success"> COMPLETED! </span><br>';
                }

                if($get_mimf->pps_po_received_info->po_received_to_pps_whse_info != null){
                    if($get_mimf->pps_po_received_info->po_received_to_pps_whse_info->stamping_info != null){
                        $mimf_stamping_matrix_id = $get_mimf->pps_po_received_info->po_received_to_pps_whse_info->stamping_info->id;
                    }else{
                        $result .= '<h5 class="badge text-dark"> Device Name <br> is not found in <br> MIMF Stamping Setting </h5>';
                    }
                }

                $result .= '
                <button class="btn btn-warning btn-sm text-center
                    actionMimfPpsRequest"
                    mimf-id="'. $get_mimf->id .'"
                    device_name-id="'. $get_mimf->device_name .'"
                    mimf-status="'. $get_mimf->status .'"
                    mimf-category="'. $get_mimf->category .'"
                    mimf_stamping_matrix-id="'. $mimf_stamping_matrix_id .'"
                    balance="'. $balance .'"
                    data-bs-toggle="modal"
                    data-bs-target="#modalMimf"
                    data-bs-keyboard="false" title="PPS Request">
                    <i class="nav-icon fa fa-history"></i>
                </button><br>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('category', function($get_mimf){
            $result = '';
            $get_category = $get_mimf->category;
            if($get_category == 1){
                $category = 'First';
            }else{
                $category = 'Second';
            }
            if($get_mimf->status == 1){
                $result .= $category.' <br>Stamping';
            }else{
                $result .= $category.' <br>Molding';
            }
            return $result;
        })

        ->addColumn('yec_po_no', function($get_mimf){
            $result = $get_mimf->pps_po_received_info->ProductPONo;
            return $result;
        })

        ->addColumn('po_balance', function($get_mimf){
            $result = $get_mimf->pps_po_received_info->POBalance;
            return $result;
        })

        ->rawColumns([
            'action',
            'category',
            'yec_po_no',
            'po_balance'
        ])
        ->make(true);
    }

    public function getControlNoV2(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_last_control_no = MimfV2::orderBy('id', 'DESC')->where('status', $request->status)->where('logdel', 0)->first();
        if($request->status == 1){
            $control_no_format = "MIMF-STAMPING-".NOW()->format('ym')."-";
        }else{
            $control_no_format = "MIMF-MOLDING-".NOW()->format('ym')."-";
        }
        if ($get_last_control_no == null){
            $new_control_no = $control_no_format.'001';
        }elseif(explode('-',$get_last_control_no->control_no)[2] != NOW()->format('ym')){
            $new_control_no = $control_no_format.'001';
        }else{
            $explode_control_no = explode("-",  $get_last_control_no->control_no);
            // $increment_control_number = $explode_control_no[2]+1;
            // $string_pad = str_pad($increment_control_number,3,"0",STR_PAD_LEFT);
            $string_pad = str_pad($explode_control_no[3]+1,3,"0",STR_PAD_LEFT);
            $new_control_no = $control_no_format.$string_pad;
        }
        return response()->json(['newControlNo' => $new_control_no]);
    }

    public function employeeID(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user_details = User::where('employee_id', $request->user_id)->where('position', [0,7,8,10])->get();
        return response()->json(['userDetails' => $user_details]);
    }

    public function updateMimfV2(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validator = Validator::make($data, [
            'mimf_status'                   => 'required',
            'mimf_control_no'               => 'required',
            'mimf_pmi_po_no'                => 'required',
            'mimf_date_issuance'            => 'required',
            'mimf_prodn_quantity'           => 'required',
            'mimf_device_code'              => 'required',
            'mimf_device_name'              => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                $check_existing_po = MimfV2::where('pmi_po_no', $request->mimf_pmi_po_no)
                    ->where('status', $request->mimf_status)
                    ->where('category', $request->category)
                    ->where('logdel', 0)
                    ->exists();

                $check_existing_control_no = MimfV2::where('control_no', $request->mimf_control_no)->where('logdel', 0)->exists();

                $mimf = [
                    'status'                => $request->mimf_status,
                    'category'              => $request->category,
                    'pps_po_rcvd_id'        => $request->pps_po_rcvd_id,
                    'control_no'            => $request->mimf_control_no,
                    'date_issuance'         => $request->mimf_date_issuance,
                    'pmi_po_no'             => $request->mimf_pmi_po_no,
                    'prodn_qty'             => $request->mimf_prodn_quantity,
                    'device_code'           => $request->mimf_device_code,
                    'device_name'           => $request->mimf_device_name,
                ];

                if(Device::where('name', $request->mimf_device_name)->where('status', 1)->exists()){
                    if($check_existing_control_no != 1){
                        $mimf['created_by']  = $request->mimf_created_by;
                        $mimf['created_at']  = date('Y-m-d H:i:s');
                        if($check_existing_po != 1){
                            if($request->create_edit == 'create'){
                                MimfV2::insert(
                                    $mimf
                                );
                            }else{
                                return response()->json(['result' => 2]);
                            }
                        }else{
                            return response()->json(['result' => 3]);
                        }
                    }else{
                        if($request->create_edit == 'create'){
                            return response()->json(['result' => 1]);
                        }else{
                            $mimf['updated_by']  = $request->mimf_created_by;
                            $mimf['updated_at']  = date('Y-m-d H:i:s');
                            if($check_existing_po == 1 ){
                                MimfV2::where('id', $request->mimf_id)
                                ->update(
                                    $mimf
                                );
                            }else{
                                return response()->json(['result' => 2]);
                            }
                        }
                    }
                }else{
                    return response()->json(['result' => 0]);
                }

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function getMimfByIdV2(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimf_to_edit = MimfV2::where('id', $request->mimfID)->get();
        return response()->json(['getMimfToEdit'  => $get_mimf_to_edit]);
    }

    public function getPmiPoFromPoReceived(Request $request){
        date_default_timezone_set('Asia/Manila');

        if($request->mimfCategory != 1){
            $get_po_received_pmi_po_for_molding = TblPoReceived::with([
                'matrix_info',
            ])
            ->where('OrderNo',$request->getValue)
            ->where('logdel', 0)
            ->get();

            return response()->json(['getPoReceivedPmiPoForMolding' => $get_po_received_pmi_po_for_molding]);
        }else{
            $get_po_received_pmi_po_for_stamping = TblPoReceived::where('OrderNo',$request->getValue)
            ->where('logdel', 0)
            ->get();

            return response()->json([
                'getPoReceivedPmiPoForStamping' => $get_po_received_pmi_po_for_stamping,
            ]);
        }
    }

    public function viewMimfStampingMatrixV2(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimf_stamping_matrices = MimfV2StampingMatrix::with(['stamping_pps_whse_info'])->where('logdel', 0)->orderBy('id', 'DESC')->get();
        return DataTables::of($get_mimf_stamping_matrices)
        ->addColumn('action', function($get_mimf_stamping_matrix){
            $result = '<center>';
            $result .= '
                <button class="btn btn-dark btn-sm text-center
                    actionEditMimfStampingMatrix"
                    mimf_stamping_matrix-id="'. $get_mimf_stamping_matrix->id .'"
                    data-bs-toggle="modal"
                    data-bs-target="#modalMimfStampingMatrix"
                    data-bs-keyboard="false" title="Edit">
                    <i class="nav-icon fa fa-edit"></i>
                </button>';
            $result .= '</center>';
            return $result;
        })
        ->addColumn('item_code', function($get_mimf_stamping_matrix){
            $result = '<center>';
            $result .= $get_mimf_stamping_matrix->stamping_pps_whse_info->PartNumber;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('item_name', function($get_mimf_stamping_matrix){
            $result = '<center>';
            $result .= $get_mimf_stamping_matrix->stamping_pps_whse_info->MaterialType;
            $result .= '</center>';
            return $result;
        })
        ->rawColumns([
            'action',
            'item_code',
            'item_name',
        ])
        ->make(true);
    }


    public function checkRequestQtyForIssuance(Request $request){
        $allowed_quantity = MimfV2PpsRequestAllowedQuantity::where('mimf_id', $request->getMimfId)->where('pps_whse_partnumber', $request->getPartnumber)->get();
        // return $allowed_quantity;
        // if($allowed_quantity->isNotEmpty()){
        //     $check_request_qty = MimfV2PpsRequest::where('mimf_id',$allowed_quantity[0]->mimf_id)->where('material_code',$allowed_quantity[0]->pps_whse_partnumber)->where('logdel', 0)->get();
        //     $total_request_qty = 0;
        //     // return $check_request_qty;
        //     if($check_request_qty != ''){
        //         for ($i=0; $i < count($check_request_qty); $i++) {
        //             if($check_request_qty[0]->product_category == 1){
        //                 $total_request_qty += $check_request_qty[$i]->virgin_material;
        //             }else{
        //                 $total_request_qty += $check_request_qty[$i]->mimf_needed_kgs;
        //             }
        //         }
        //     }

        // return response()->json(['allowedQuantity' => $allowed_quantity, 'checkRequestQty' => $check_request_qty,'checkTotalRequestQty'  => $total_request_qty]);
        // }
            return response()->json(['allowedQuantity' => $allowed_quantity]);
    }

    public function getPpsPoReceivedItemCode(Request $request){
        if($request->poReceivedDb == ''){
            // $get_itemname = TblPoReceived::select('ItemName')
            // ->where('logdel', 0)
            // ->orderBy('id', 'DESC')
            // ->distinct()
            // ->get();

            // $get_itemname = DB::connection('mysql_rapid_pps')
            // ->table('tbl_POReceived')
            // ->select('ItemName')
            // ->distinct()
            // ->orderBy('id', 'DESC')
            // ->get();

            $get_itemCode = DB::connection('mysql_rapid_pps')
            ->select("SELECT DISTINCT ItemCode
                FROM tbl_POReceived
                WHERE logdel = '0'
            ");
            return response()->json(['getItemCode'  => $get_itemCode]);
        }else{
            $get_ItemName = TblPoReceived::with('po_received_to_pps_whse_info')->where('ItemCode', $request->poReceivedDb)->where('logdel', 0)->select('ItemCode','ItemName')->first();
            return response()->json(['getItemName'  => $get_ItemName]);
        }
    }

    public function getPpdMaterialType(Request $request){
        if($request->getMimfStatus == 1){
            if($request->getMimfCategory == 1){
                $get_category = '1';
            }else{
                $get_category = '3';
            }
        }else{
            if($request->getMimfCategory == 1){
                $get_category = '4';
            }else{
                $get_category = '6';
            }
        }

        $get_device = Device::with(
            'material_process.material_details.stamping_pps_warehouse_info'
        )
        ->where('name', $request->getMimfDeviceName)
        ->get();

        for ($i=0; $i < count($get_device[0]->material_process); $i++) {
            if($get_device[0]->material_process[$i]->process == $get_category){
                return response()->json(['getDeviceName'  => $get_device[0]->material_process[$i]]);
            }
        }
    }

    public function getPpsWarehouseInventory(Request $request){
        $get_inventory = TblWarehouse::with(['pps_warehouse_transaction_info'])
        ->where('MaterialType', $request->ppsWarehouseInventory)
        ->where('Factory', 3)
        ->get();
        // return     $arr_in; array_sum( $arr_in[0]->pps_warehouse_transaction_info['In']);
        if($get_inventory->isNotEmpty()){
            $in = 0;
            $out = 0;
            $total_balanace = 0;
            if($get_inventory[0]->pps_warehouse_transaction_info != null){
                $boh = $get_inventory[0]->pps_warehouse_transaction_info[0]->Boh;
                for ($i=0; $i < count($get_inventory[0]->pps_warehouse_transaction_info); $i++) {
                    $in += $get_inventory[0]->pps_warehouse_transaction_info[$i]->In;
                    // $arr_in[]= $get_inventory[0]->pps_warehouse_transaction_info[$i]->In;
                    $out += $get_inventory[0]->pps_warehouse_transaction_info[$i]->Out;
                    // $arr_out[]= $get_inventory[0]->pps_warehouse_transaction_info[$i]->Out;
                }
                // $sum_arr_in = array_sum($arr_in);
                // $sum_arr_out = array_sum($arr_out);
                $total_balanace = number_format($boh+$in-$out, 2, '.', '');
            }
            // return response()->json(['getInventory'  => $get_inventory, 'totalBalanace' => $total_balanace,'$arr_out'=>$sum_arr_in,'$arr_in'=>$sum_arr_out]);
            return response()->json(['getInventory'  => $get_inventory, 'totalBalanace' => $total_balanace]);
        }else{
            return response()->json(['result'  => '0']);
        }
    }

    // public function getAllowedQuantity(Request $request){
    //     $allowed_quantity = MimfV2PpsRequestAllowedQuantity::where('mimf_id', $request->getMimfID)
    //     ->where('pps_whse_partnumber', $request->getMimfMaterialCode)
    //     ->where('logdel', '0')
    //     ->get();

    //     return response()->json(['allowedQuantity'  => $allowed_quantity]);
    // }

    public function getPpsRequestPartialQuantity(Request $request){ //nmodify
        if($request->getStatus == 1){
            $check_stamping_info = TblWarehouse::with(['stamping_info'])->where('PartNumber', $request->getMimfMatrixItemCode)->get();
            $calculate = $request->getPartialQuantity / $check_stamping_info[0]->stamping_info->pin_kg + .10;

            return response()->json(['calculate' => $calculate]);
        }else{
            if($request->getMoldingProductCategory == 1){
                $calcualate_dieset = TblDieset::with(['ppd_matrix_info'])->where('R3Code', $request->getMimfMatrixItemCode)->get();
                $calculate = $request->getPartialQuantity*$calcualate_dieset[0]->ShotWgt/$calcualate_dieset[0]->NoOfCav/1000;

                return response()->json(['calculate' => $calculate, 'calcualateDieset' => $calcualate_dieset]);
            }else{
                $get_device_code = Device::where('code', $request->getMimfMatrixItemCode)->where('status', '1')->get();
                return response()->json(['getDeviceCode' => $get_device_code]);
            }
        }
    }

    public function createUpdateMimfPpsRequest(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
    
        $get_control_no = PPSRequest::orderBy('pkid', 'DESC')
        ->where('deleted', 0)
        ->first();

        $get_ids =  TblDieset::with(['ppd_matrix_info'])->where('R3Code', $request->get_device_code)->get();

        $get_itemlist_id = PPSItemList::where('partcode', $request->mimf_material_code)
        ->where('partname', $request->mimf_material_type)
        ->where('Factory', 3)
        ->first();
        if($request->get_request_status == 1 && $request->mimf_matrix_for_stamping_issuance != ''){
            $dieset_id = null;
            $multiplier = null;
            $product_category = null;
            $mimf_matrix_id = $request->mimf_matrix_for_stamping_issuance;

            if($request->get_request_category == 1){
                $request_qty = $request->mimf_needed_kgs;
                $required = 'mimf_needed_kgs';
            }else{
                $request_qty = $request->mimf_request_pins_pcs;
                $required = 'mimf_request_pins_pcs';
            }
        }else{
            $required = 'mimf_needed_kgs';
            $mimf_matrix_id = null;
            $multiplier = null;
            $product_category = $request->molding_product_category;
            if($request->molding_product_category == 1){
                $request_qty = $request->mimf_virgin_material;
            }else{
                $request_qty = $request->mimf_needed_kgs;
            }

            if($request->molding_product_category == 1){
                if($get_ids->isNotEmpty()){
                    $dieset_id = $get_ids[0]->id;
                }else{
                    return response()->json(['result' => 0]);
                }
            }else{
                $dieset_id = null;
                $multiplier = $request->multiplier;
            }
        }

        if($get_itemlist_id != null){
            $pps_item_list_id = $get_itemlist_id->pkid_itemlist;
            $pps_item_list_matls_cat = $get_itemlist_id->matls_cat;
        }else{
            return response()->json(['result' => 1]);
        }

        $validator = Validator::make($data, [
            $required                       => 'required',
            'pps_whse_id'                   => 'required',
            'mimf_material_code'            => 'required',
            'mimf_material_type'            => 'required',
            'mimf_quantity_from_inventory'  => 'required',
            'date_mimf_prodn'               => 'required',
            'mimf_delivery'                 => 'required',
            'mimf_remark'                   => 'required',
        ]);

        $explode_pps_request_control_no = explode("-",  $get_control_no->control_number);
        $control_no_format = "PPS-".NOW()->format('ym')."-";

        if(explode('-',$get_control_no->control_number)[1] != NOW()->format('ym')){
            $pps_request_new_control_no = $control_no_format.'001';
        }else{
            $string_pad = str_pad($explode_pps_request_control_no[2]+1,3,"0",STR_PAD_LEFT);
            $pps_request_new_control_no = $control_no_format.$string_pad;
        }

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                if($request->molding_product_category == 1){
                    $virgin_material = $request->mimf_virgin_material;
                    $recycled = $request->mimf_recycled;
                }else{
                    $virgin_material = null;
                    $recycled = null;
                }
                $mimf_pps_request = [
                    'mimf_id'               => $request->get_mimf_id,
                    'pps_whse_id'           => $request->pps_whse_id,
                    'pps_dieset_id'         => $dieset_id,
                    'ppd_mimf_matrix_id'    => $mimf_matrix_id,
                    'product_category'      => $product_category,
                    'material_code'         => $request->mimf_material_code,
                    'material_type'         => $request->mimf_material_type,
                    'qty_invt'              => $request->mimf_quantity_from_inventory,
                    'request_qty'           => $request->request_quantity,
                    'multiplier'            => $multiplier,
                    'request_pins_pcs'      => $request->mimf_request_pins_pcs,
                    'needed_kgs'            => $request->mimf_needed_kgs,
                    'virgin_material'       => $virgin_material,
                    'recycled'              => $recycled,
                    'prodn'                 => $request->date_mimf_prodn,
                    'delivery'              => $request->mimf_delivery,
                    'remarks'               => $request->mimf_remark,
                ];

                $mimf_pps_request_allowed_qty = [
                    'mimf_id'               => $request->get_mimf_id,
                    'pps_whse_partnumber'   => $request->mimf_material_code,
                    'allowed_quantity'      => $request->mimf_molding_allowed_quantity,
                ];

                $pps_request = [
                    'created_on'        => date('Y-m-d H:i:s'),
                    'created_by'        => Auth::user()->username,
                    'updated_by'        => '',
                    'deleted'           => '0',
                    'fk_itemlist'       => $pps_item_list_id,
                    'matls_cat'         => $pps_item_list_matls_cat,
                    'qty'               => $request_qty,
                    'destination'       => $request->mimf_remark,
                    'fk_issuance'       => '0',
                    'r_remarks'         => '',
                    'i_remarks'         => '',
                    'cancelled'         => '0',
                    'acknowledgedby'    => '',
                    'acknowledged'      => '0',
                    'receive_date'      => '',
                ];

                $allowed_qty = MimfV2PpsRequestAllowedQuantity::where('mimf_id', $request->get_mimf_id)
                    ->where('pps_whse_partnumber', $request->mimf_material_code)
                    ->where('logdel', '0')
                    ->get();

                if($request->mimf_pps_request_id == ''){

                    $mimf_pps_request['created_by']  = $request->created_by;
                    $mimf_pps_request['created_at']  = date('Y-m-d H:i:s');
                    
                    $mimf_request_id = MimfV2PpsRequest::insertGetId(
                        $mimf_pps_request
                    );

                    $pps_request['mimf_pps_request_id'] =  $mimf_request_id;
                    $pps_request['control_number']      =  $pps_request_new_control_no;
                    PPSRequest::insert(
                        $pps_request
                    );

                    if($request->get_request_status != 1){

                        if(count($allowed_qty) == 0){
                            if($request->molding_product_category == 1){
                                $insert_balanace = $request->mimf_molding_allowed_quantity - $request->mimf_needed_kgs;
                            }else{
                                $insert_balanace = $request->mimf_molding_allowed_quantity - $request->request_quantity;
                            }

                            $mimf_pps_request_allowed_qty['balance']  = $insert_balanace ;
                            $mimf_pps_request_allowed_qty['created_by']  = $request->created_by;
                            $mimf_pps_request_allowed_qty['created_at']  = date('Y-m-d H:i:s');
                            MimfV2PpsRequestAllowedQuantity::insert(
                                $mimf_pps_request_allowed_qty
                            );
                        }else{
                            $mimf_pps_request_allowed_qty['balance']  = $request->left_quantity;
                            $mimf_pps_request_allowed_qty['updated_by']  = $request->created_by;
                            $mimf_pps_request_allowed_qty['updated_at']  = date('Y-m-d H:i:s');
                            MimfV2PpsRequestAllowedQuantity::where('id', $allowed_qty[0]->id)->update(
                                $mimf_pps_request_allowed_qty
                            );
                        }
                    }
                }else{

                    $mimf_pps_request['updated_by']  = $request->created_by;
                    $mimf_pps_request['updated_at']  = date('Y-m-d H:i:s');
                    MimfV2PpsRequest::where('id', $request->mimf_pps_request_id)->update(
                        $mimf_pps_request
                    );
                    PPSRequest::where('mimf_pps_request_id', $request->mimf_pps_request_id)->update(
                        $pps_request
                    );

                    if($request->get_request_status != 1){
                        $mimf_pps_request_allowed_qty['balance']  = $request->left_quantity;
                        $mimf_pps_request_allowed_qty['updated_by']  = $request->created_by;
                        $mimf_pps_request_allowed_qty['updated_at']  = date('Y-m-d H:i:s');
                        MimfV2PpsRequestAllowedQuantity::where('id', $allowed_qty[0]->id)->update(
                            $mimf_pps_request_allowed_qty
                        );
                    }
                }

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function viewMimfPpsRequest(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimf_pps_requests = MimfV2PpsRequest::with([
            'rapid_pps_request_info'
        ])
        ->where('logdel', 0)
        ->where('mimf_id', $request->mimfID)
        ->orderBy('created_at', 'DESC')
        ->get();

        return DataTables::of($get_mimf_pps_requests)
        ->addColumn('action', function($get_mimf_pps_request) use($request){
            if($get_mimf_pps_request->rapid_pps_request_info != null){
                $pps_request_id = $get_mimf_pps_request->rapid_pps_request_info->pkid;
            }else{
                $pps_request_id = '';
            }
            $result = '<center>';
            $result .= '
                <button class="btn btn-dark btn-sm text-center
                    actionEditMimfPpsRequest"
                    mimf_pps_request-id="'. $get_mimf_pps_request->id .'"
                    rapid_pps_request-id="'. $pps_request_id .'"
                    data-bs-toggle="modal"
                    data-bs-target="#modalMimfPpsRequest"
                    data-bs-keyboard="false" title="Edit PPS Request">
                    <i class="nav-icon fa fa-edit"></i>
                </button>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('pps_control_no', function($get_mimf_pps_request) use($request){
            $result = '<center>';
                if($get_mimf_pps_request->rapid_pps_request_info != null){
                    $result .= $get_mimf_pps_request->rapid_pps_request_info->control_number;
                }else{
                    $result .= '<span class="badge text-dark"> No Data <br> in Rapid <br> PPS Request </span>';
                    // $result .= '<span class="badge badge-pill badge-success"> No Data in Rapid PPS Request </span><br>';

                }
            $result .= '</center>';
            return $result;
        })


        ->rawColumns([
            'action',
            'pps_control_no'
        ])
        ->make(true);
    }

    public function getMimfPpsRequestById(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimf_pps_request_to_edit =  MimfV2PpsRequest::with([
            'rapid_pps_request_info'
        ])
        ->where('id', $request->mimfPpsRequestID)
        ->get();

        $get_mimf_pps_request_allowed_qty_to_edit = MimfV2PpsRequestAllowedQuantity::where('mimf_id', $get_mimf_pps_request_to_edit[0]->mimf_id)
        ->where('pps_whse_partnumber', $get_mimf_pps_request_to_edit[0]->material_code)
        ->where('logdel', '0')
        ->get();

        return response()->json(['getMimfPpsRequestToEdit'  => $get_mimf_pps_request_to_edit, 'getMimfPpsRequestAllowedQtyToEdit' => $get_mimf_pps_request_allowed_qty_to_edit]);
    }

    public function updateMimfStampingMatrixV2(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $validator = Validator::make($data, [
            'mimf_stamping_matrix_item_code'    => 'required',
            'mimf_stamping_matrix_pin_kg'       => 'required',
            'mimf_stamping_matrix_created_by'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                $avoid_duplicate_records_by_using_add = MimfV2StampingMatrix::where('stamping_pps_whse_id', $request->pps_warehouse_id)->where('logdel',0)->get();
                $avoid_duplicate_records_by_using_edit = MimfV2StampingMatrix::where('id', $request->mimf_stamping_matrix_id)->where('stamping_pps_whse_id', $request->pps_warehouse_id)->where('logdel',0)->get();

                $mimf_stamping_matrices = [
                    'stamping_pps_whse_id'  => $request->pps_warehouse_id,
                    'pin_kg'                => $request->mimf_stamping_matrix_pin_kg,
                ];

                if($request->pps_warehouse_id != ''){
                    if($request->mimf_for_stamping == '1'){
                        if(count($avoid_duplicate_records_by_using_add) == 0){
                            $mimf_stamping_matrices['created_by']  = $request->mimf_stamping_matrix_created_by;
                            $mimf_stamping_matrices['created_at']  = date('Y-m-d H:i:s');

                            MimfV2StampingMatrix::insert(
                                $mimf_stamping_matrices
                            );
                        }else{
                            return response()->json(['result' => 1]);
                        }
                    }else{
                        if(count($avoid_duplicate_records_by_using_edit) > 0){
                            $mimf_stamping_matrices['updated_by']  = $request->mimf_stamping_matrix_created_by;
                            $mimf_stamping_matrices['updated_at']  = date('Y-m-d H:i:s');

                            MimfV2StampingMatrix::where('id', $request->mimf_stamping_matrix_id)
                            ->update(
                                $mimf_stamping_matrices
                            );
                        }else{
                            return response()->json(['result' => 2]);
                        }
                    }
                }else{
                    return response()->json(['result' => 0]);
                }

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function getMimfStampingMatrixById(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_mimf_stamping_matrix_to_edit = MimfV2StampingMatrix::with(['stamping_pps_whse_info'])->where('id', $request->mimfStampingMatrixID)->get();
        return response()->json(['getMimfStampingMatrixToEdit'  => $get_mimf_stamping_matrix_to_edit]);
    }
}


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

use App\Models\Mimf;
use App\Models\User;
use App\Models\PPSRequest;
use App\Models\PPSItemList;
use App\Models\TblWarehouse;
use App\Models\TblPoReceived;
use App\Models\MimfStampingMatrix;

class MimfController extends Controller
{
    public function viewMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimfs = Mimf::with([
            'pps_po_received_info',
            'pps_request_info',
            // 'pps_po_received_info.matrix_info',
            'pps_po_received_info.mimf_stamping_matrix_info.pps_whse_info',
            'pps_po_received_info.pps_dieset_info.pps_warehouse_info',
        ])
        ->where('logdel', 0)
        ->where('status', $request->mimfCategory)
        ->orderBy('control_no', 'DESC')
        ->get();
        // return  $get_mimfs;
        // return PPSRequest::orderBy('control_number', 'DESC')->get();

        return DataTables::of($get_mimfs)
        ->addColumn('action', function($get_mimf) use($request){
            $result = '<center>';
            if($request->mimfCategory == 1){
                $matrix = ' mimf_matrix-id="'. $get_mimf->pps_po_received_info->mimf_stamping_matrix_info->id .'" '; 
                $dieset  = '';
                $whse = ' whse-id="'. $get_mimf->pps_po_received_info->mimf_stamping_matrix_info->pps_whse_info->id .'" ';
            }
            else{ 
                $matrix = ' matrix-id="'. $get_mimf->pps_po_received_info->matrix_info->id .'"  ';
                $dieset  = ' dieset-id="'. $get_mimf->pps_po_received_info->pps_dieset_info->id .'" ';
                $whse = '  whse-id="'. $get_mimf->pps_po_received_info->pps_dieset_info->pps_warehouse_info->id .'"  ';
            }

            if($get_mimf->pps_po_received_info->POBalance != 0){
                // if($get_mimf->pps_request_info != null && $get_mimf->pps_request_info->updated_by == ''){
                    $result .= '
                    <button class="btn btn-dark btn-sm text-center 
                        actionEditMimf" 
                        mimf-id="'. $get_mimf->id .'" 
                        mimf-status="'. $get_mimf->status .'" 
                        po_received-id="'. $get_mimf->pps_po_received_info->id .'" 
                        '.$matrix.'
                        '.$dieset.'
                        '.$whse.'
                        data-bs-toggle="modal" 
                        data-bs-target="#modalMimf"
                        data-bs-keyboard="false" title="Edit">
                        <i class="nav-icon fa fa-edit"></i>
                    </button>';
                // }
            }else{
                $result .= '<span class="badge badge-pill badge-success"> COMPLETED! </span>';
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('category', function($get_mimf){
            $result = '<center>';
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
            $result .= '</center>';
            return $result;
        })

        ->addColumn('yec_po_no', function($get_mimf){
            $result = '<center>';
            $result .= $get_mimf->pps_po_received_info->ProductPONo;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_balance', function($get_mimf){
            $result = '<center>';
            $result .= $get_mimf->pps_po_received_info->POBalance;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('yec_po_no', function($get_mimf){
            $result = '<center>';
            $result .= $get_mimf->pps_po_received_info->ProductPONo;
            $result .= '</center>';
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

    public function getControlNo(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_last_control_no = Mimf::orderBy('id', 'DESC')->where('status', $request->category)->where('logdel', 0)->first();
        if($request->category == 1){
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

    public function updateMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        // return $request->mimf_status;
        if($request->mimf_status == 1){
            if($request->category == 1){
                $request_qty = $request->mimf_needed_kgs;
            }else{
                $request_qty = $request->mimf_request_pins_pcs;
            }
            $test = 'ppd_mimf_stamping_matrix_id';
            $tist = 'created_by';
        }else{
            $test = 'ppd_matrix_id';
            $tist = 'pps_dieset_id';
            // $request_qty = $request->mimf_needed_kgs;
            $request_qty = $request->mimf_virgin_material;
        }
        $validator = Validator::make($data, [
            $test                           => 'required',
            $tist                           => 'required',
            'mimf_status'                   => 'required',
            'pps_whse_id'                   => 'required',
            'pps_po_rcvd_id'                => 'required',
            'mimf_control_no'               => 'required',
            'mimf_pmi_po_no'                => 'required',
            'mimf_date_issuance'            => 'required',
            'mimf_prodn_quantity'           => 'required',
            'mimf_device_code'              => 'required',
            'mimf_device_name'              => 'required',
            'mimf_material_code'            => 'required',
            'mimf_material_type'            => 'required',
            'mimf_quantity_from_inventory'  => 'required',
            'mimf_needed_kgs'               => 'required',
            'date_mimf_prodn'               => 'required',
            'mimf_delivery'                 => 'required',
            'mimf_remark'                   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            // DB::beginTransaction();
            // try {
                $check_existing_control_no = Mimf::where('control_no', $request->mimf_control_no)
                    ->where('pmi_po_no', $request->mimf_pmi_po_no)
                    ->where('status', $request->mimf_status)
                    ->where('logdel', 0)
                    ->get();

                $check_existing_po = Mimf::where('pmi_po_no', $request->mimf_pmi_po_no)
                    ->where('status', $request->mimf_status)
                    ->where('category', $request->category)
                    ->where('logdel', 0)
                    ->exists();

                $get_control_no = PPSRequest::orderBy('pkid', 'DESC')
                    ->where('deleted', 0)
                    ->first();

                $get_last_request_per_id = PPSRequest::where('mimf_id', $request->mimf_id)
                    ->orderBy('created_on', 'DESC')
                    ->first();

                if($request->mimf_status == 1 && $request->category == 2){
                    $get_itemlist_id = PPSItemList::where('partcode', $request->mimf_device_code)
                    ->where('Factory', 3)
                    ->first();
                }else{
                    $get_itemlist_id = PPSItemList::where('partcode', $request->mimf_material_code)
                        ->where('partname', $request->mimf_material_type)
                        ->where('Factory', 3)
                        ->first();
                } 

                $explode_pps_request_control_no = explode("-",  $get_control_no->control_number);
                $control_no_format = "PPS-".NOW()->format('ym')."-";
                if(explode('-',$get_control_no->control_number)[1] != NOW()->format('ym')){
                    $pps_request_new_control_no = $control_no_format.'001';
                }else{
                    $string_pad = str_pad($explode_pps_request_control_no[2]+1,3,"0",STR_PAD_LEFT);
                    $pps_request_new_control_no = $control_no_format.$string_pad;
                }

                $mimf = [
                    'status'                => $request->mimf_status,
                    'category'              => $request->category,
                    'pps_po_rcvd_id'        => $request->pps_po_rcvd_id,
                    'pps_dieset_id'         => $request->pps_dieset_id,
                    'pps_whse_id'           => $request->pps_whse_id,
                    'ppd_matrix_id'         => $request->ppd_matrix_id,
                    'ppd_mimf_matrix_id'    => $request->ppd_mimf_stamping_matrix_id,
                    'control_no'            => $request->mimf_control_no,
                    'date_issuance'         => $request->mimf_date_issuance,
                    'pmi_po_no'             => $request->mimf_pmi_po_no,
                    'prodn_qty'             => $request->mimf_prodn_quantity,
                    'device_code'           => $request->mimf_device_code,
                    'device_name'           => $request->mimf_device_name,
                    'material_code'         => $request->mimf_material_code,
                    'material_type'         => $request->mimf_material_type,
                    'qty_invt'              => $request->mimf_quantity_from_inventory,
                    'request_pins_pcs'      => $request->mimf_request_pins_pcs,
                    'needed_kgs'            => $request->mimf_needed_kgs,
                    'virgin_material'       => $request->mimf_virgin_material,
                    'recycled'              => $request->mimf_recycled,
                    'prodn'                 => $request->date_mimf_prodn,
                    'delivery'              => $request->mimf_delivery,
                    'remarks'               => $request->mimf_remark,
                    'scan_by'               => $request->employee_no,
                ];

                $pps_request = [
                    'created_on'        => date('Y-m-d H:i:s'),
                    'created_by'        => Auth::user()->username,
                    'updated_by'        => '',
                    'deleted'           => '0',
                    'control_number'    => $pps_request_new_control_no,
                    'fk_itemlist'       => $get_itemlist_id->pkid_itemlist,
                    'matls_cat'         => $get_itemlist_id->matls_cat,
                    'qty'               => $request_qty,
                    'destination'       => 'PPD-CN',
                    'fk_issuance'       => '0',
                    'r_remarks'         => '',
                    'i_remarks'         => '',
                    'cancelled'         => '0',
                    'acknowledgedby'    => '',
                    'acknowledged'      => '0',
                    'receive_date'      => '',
                ];

                if($check_existing_po != 1){
                    if(count($check_existing_control_no) != 1){
                        // return 'ADD / MIMF / PPS REQUEST';
                        $mimf['created_by']  = $request->created_by;
                        $mimf['created_at']  = date('Y-m-d H:i:s');

                        $get_mimf_id = Mimf::insertGetId(
                            $mimf
                        );
                        
                        $pps_request['mimf_id']  = $get_mimf_id;
                        PPSRequest::insert(
                            $pps_request
                        );
                    }else{
                        if($request->mimf_id != ''){
                            $mimf['updated_by']  = $request->created_by;
                            $mimf['updated_at']  = date('Y-m-d H:i:s');
                            Mimf::where('id', $request->mimf_id)
                            ->update(
                                $mimf
                            );

                            if($request->update_mimf_and_pps_request == 1){
                                // return 'EDIT PPS REQUEST';
                                PPSRequest::where('mimf_id', $request->mimf_id)->where('pkid', $get_last_request_per_id->pkid)
                                ->update([
                                    'fk_itemlist'   => $get_itemlist_id->pkid_itemlist,
                                    'qty'           => $request_qty
                                ]);
                            }else{
                                // return '1ST ELSE ADD PPS REQUEST';
                                $pps_request['mimf_id']  = $request->mimf_id;
                                PPSRequest::insert(
                                    $pps_request
                                );
                            }
                        }else{
                            return response()->json(['result' => 1]);
                        }
                    }
                }else{
                    if($request->mimf_id != ''){
                        $mimf['updated_by']  = $request->created_by;
                        $mimf['updated_at']  = date('Y-m-d H:i:s');
                        Mimf::where('id', $request->mimf_id)
                        ->update(
                            $mimf
                        );
                        if($request->update_mimf_and_pps_request == 1){
                            // return 'EDIT / MIMF / PPS REQUEST';
                            PPSRequest::where('mimf_id', $request->mimf_id)->where('pkid', $get_last_request_per_id->pkid)
                            ->update([
                                'fk_itemlist'   => $get_itemlist_id->pkid_itemlist,
                                'qty'           => $request_qty
                            ]);
                        }else{
                            // return '2ND ELSE ADD PPS REQUEST';
                            $pps_request['mimf_id']  = $request->mimf_id;
                            PPSRequest::insert(
                                $pps_request
                            );
                        }

                    }else{
                        return response()->json(['result' => 2]);
                    }
                }

                // DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }

    public function getMimfById(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimf_to_edit = Mimf::with(['pps_request_info'])->where('id', $request->mimfID)->get();
        // return $get_mimf_to_edit;
        return response()->json(['getMimfToEdit'  => $get_mimf_to_edit]);
    }

    public function getPmiPoFromPoReceived(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        // $get_po_received_pmi_po = TblPoReceived::where('OrderNo','LIKE','%'.$request->getValue.'%')->where('logdel', 0)->get();
        if($request->mimfCategory != 1){
            $get_po_received_pmi_po_for_molding = TblPoReceived::with([
                'matrix_info',
                'pps_dieset_info.pps_warehouse_info.pps_warehouse_transaction_info'
            ])
            ->where('OrderNo',$request->getValue)
            ->where('logdel', 0)
            ->get();
            // return  $get_po_received_pmi_po_for_molding;
            $in = 0;
            $out = 0;
            $total_balanace_for_molding = 0;
            if(count($get_po_received_pmi_po_for_molding) > 0){
                if($get_po_received_pmi_po_for_molding[0]->pps_dieset_info != null){
                    if ($get_po_received_pmi_po_for_molding[0]->pps_dieset_info->pps_warehouse_info != null){
                        for($i=0; $i < count($get_po_received_pmi_po_for_molding[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info); $i++) {
                            $in += $get_po_received_pmi_po_for_molding[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info[$i]->In;
                            $out += $get_po_received_pmi_po_for_molding[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info[$i]->Out;
                        }
                        $total_balanace_for_molding = number_format($in-$out, 2, '.', '');
                        // $total_balanace_for_molding = filter_var($in-$out, FILTER_SANITIZE_NUMBER_INT);
                    }
                }
            }
            return response()->json(['getPoReceivedPmiPoForMolding' => $get_po_received_pmi_po_for_molding, 'totalBalanceForMolding' => $total_balanace_for_molding]);
        }else{
            $get_po_received_pmi_po_for_stamping = TblPoReceived::with([
                'mimf_stamping_matrix_info.pps_whse_info.pps_warehouse_transaction_info',
            ])
            ->where('OrderNo',$request->getValue)
            ->where('logdel', 0)
            ->get();

            $in = 0;
            $out = 0;
            $total_balanace_for_stamping = 0;
            if(count($get_po_received_pmi_po_for_stamping) > 0){
                if ($get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info != null){
                    if ($get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info->pps_whse_info != null){
                        for($i=0; $i < count($get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info->pps_whse_info->pps_warehouse_transaction_info); $i++) {
                            $in += $get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info->pps_whse_info->pps_warehouse_transaction_info[$i]->In;
                            $out += $get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info->pps_whse_info->pps_warehouse_transaction_info[$i]->Out;
                        }
                        $total_balanace_for_stamping = number_format($in-$out, 2, '.', '');
                        // $total_balanace_for_stamping = filter_var($in-$out, FILTER_SANITIZE_NUMBER_INT);
                    }
                }
            }
            return response()->json([
                'getPoReceivedPmiPoForStamping' => $get_po_received_pmi_po_for_stamping, 
                'totalBalanceForStamping' => $total_balanace_for_stamping
            ]);
        }
    }

    public function viewMimfStampingMatrix(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimf_stamping_matrices = MimfStampingMatrix::with(['pps_whse_info'])->where('logdel', 0)->orderBy('id', 'DESC')->get();

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
        ->addColumn('part_number', function($get_mimf_stamping_matrix){
            $result = '<center>';
            $result .= $get_mimf_stamping_matrix->pps_whse_info->PartNumber;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('material_type', function($get_mimf_stamping_matrix){
            $result = '<center>';
            $result .= $get_mimf_stamping_matrix->pps_whse_info->MaterialType ;
            $result .= '</center>';
            return $result;
        })
        ->rawColumns([
            'action',
            'part_number',
            'material_type'
        ])
        ->make(true);
    }
    

    public function getPpsWarehouse(Request $request){
        if($request->ppsWhseDb == ''){
            $get_partnumber = TblWarehouse::orderBy('id', 'DESC')->get(['id','PartNumber', 'MaterialType']);
            return response()->json(['getPartNumber'  => $get_partnumber]);
        }else{
            $get_materialtype = TblWarehouse::where('id', $request->ppsWhseDb)->get();
            return response()->json(['getMaterialType'  => $get_materialtype]);
        }
        // return $get_partnumber;
    }

    public function getPpsPoReceivedItemName(Request $request){
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
            // ->orderBy('id', 'DESC')-
            // >get();

            $get_itemname = DB::connection('mysql_rapid_pps')
            ->select("SELECT DISTINCT ItemName
                FROM tbl_POReceived
                WHERE logdel = '0'
                -- ORDER BY tbl_POReceived.ItemName ASC
            ");

            return response()->json(['getItemName'  => $get_itemname]);
        }else{
            $get_ItemCode = TblPoReceived::where('ItemName', $request->poReceivedDb)->where('logdel', 0)->first();
            return response()->json(['getItemCode'  => $get_ItemCode]);
        }
    }

    public function updateMimfStampingMatrix(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $validator = Validator::make($data, [
            'mimf_stamping_matrix_item_code'        => 'required',
            'mimf_stamping_matrix_item_name'        => 'required',
            'mimf_stamping_matrix_pin_kg'           => 'required',
            'mimf_stamping_matrix_part_number'      => 'required',
            'mimf_stamping_matrix_material_type'    => 'required',
            'mimf_stamping_matrix_created_by'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                $check_existing_record = MimfStampingMatrix::where('id', $request->mimf_stamping_matrix_id)->where('logdel', 0)->get();
                $mimf_stamping_matrix = [
                    'pps_whse_id'   => $request->mimf_stamping_matrix_part_number,
                    'item_code'     => $request->mimf_stamping_matrix_item_code,
                    'item_name'     => $request->mimf_stamping_matrix_item_name,
                    'pin_kg'        => $request->mimf_stamping_matrix_pin_kg,
                ];   
                
                if(count($check_existing_record) != 1){
                    $mimf_stamping_matrix['created_by']  = $request->mimf_stamping_matrix_created_by;
                    $mimf_stamping_matrix['created_at']  = date('Y-m-d H:i:s');

                    MimfStampingMatrix::insert(
                        $mimf_stamping_matrix
                    );
                }else{
                    $mimf_stamping_matrix['updated_by']  = $request->mimf_stamping_matrix_created_by;
                    $mimf_stamping_matrix['updated_at']  = date('Y-m-d H:i:s');

                    MimfStampingMatrix::where('id', $request->mimf_stamping_matrix_id)
                    ->update(
                        $mimf_stamping_matrix
                    );
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
        
        $get_mimf_stamping_matrix_to_edit = MimfStampingMatrix::with(['pps_whse_info'])->where('id', $request->mimfStampingMatrixID)->get();
        return response()->json(['getMimfStampingMatrixToEdit'  => $get_mimf_stamping_matrix_to_edit]);
    }
}

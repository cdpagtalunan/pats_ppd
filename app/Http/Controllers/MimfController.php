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
use App\Models\TblPoReceived;
use App\Models\TblWarehouse;
use App\Models\MimfStampingMatrix;

class MimfController extends Controller
{
    public function viewMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimfs = Mimf::with([
            'pps_po_received_info.matrix_info',
            'pps_po_received_info.mimf_stamping_matrix_info.pps_whse_info',
            'pps_po_received_info.pps_dieset_info.pps_warehouse_info',
        ])
        ->where('logdel', 0)
        ->where('status', $request->mimfCategory)
        ->orderBy('control_no', 'DESC')
        ->get();
        // return $get_mimfs;
        return DataTables::of($get_mimfs)
        ->addColumn('action', function($get_mimf) use($request){
            $result = '<center>';
            if($request->mimfCategory == 1){
                $matrix = ' mimf_matrix-id="'. $get_mimf->pps_po_received_info->mimf_stamping_matrix_info->id .'" '; 
                $dieset  = '  ';
                $whse = ' whse-id="'. $get_mimf->pps_po_received_info->mimf_stamping_matrix_info->pps_whse_info->id .'" ';
            }
            else{ 
                $matrix = ' matrix-id="'. $get_mimf->pps_po_received_info->matrix_info->id .'"  ';
                $dieset  = ' dieset-id="'. $get_mimf->pps_po_received_info->pps_dieset_info->id .'" ';
                $whse = '  whse-id="'. $get_mimf->pps_po_received_info->pps_dieset_info->pps_warehouse_info->id .'"  ';
            }

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
            $result .= '</center>';
            return $result;
        })
        ->addColumn('po_balance', function($get_mimf){
            $result = '<center>';
            $result .= $get_mimf->pps_po_received_info->POBalance;
            $result .= '</center>';
            return $result;
        })
        // ->addColumn('qty_invt', function($get_mimf){
        //     $in = 0;
        //     $out = 0;
        //     $total_balanace = 0;
        //     // if($get_mimf->pps_po_received_info->pps_dieset_info->pps_warehouse_info != null){
        //     //     for($i=0; $i < count($get_mimf[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info); $i++) {
        //     //         $in += $get_mimf[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info[$i]->In;
        //     //         $out += $get_mimf[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info[$i]->Out;
        //     //     }
        //     //     $total_balanace = number_format($in-$out, 2, '.', '');
        //     // //             // $total_balanace_for_molding = filter_var($in-$out, FILTER_SANITIZE_NUMBER_INT);
        //     // }
        //     $result = '<center>';
        //     $result .= $get_mimf->pps_po_received_info->pps_dieset_info;
        //     $result .= '</center>';
        //     return $result;
        // })
        ->rawColumns([
            'action',
            // 'qty_invt',
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
            $control_no_format = "MIMF-".NOW()->format('ym')."-";
        }

        if ($get_last_control_no == null){
            $new_control_no = $control_no_format.'001';
        }elseif(explode('-',$get_last_control_no->control_no)[1] != NOW()->format('ym')){
            $new_control_no = $control_no_format.'001';
        }else{
            $explode_control_no = explode("-",  $get_last_control_no->control_no);
            // $increment_control_number = $explode_control_no[2]+1;
            // $string_pad = str_pad($increment_control_number,3,"0",STR_PAD_LEFT);
            $string_pad = str_pad($explode_control_no[2]+1,3,"0",STR_PAD_LEFT);
            $new_control_no = $control_no_format.$string_pad;
        }
        return response()->json(['newControlNo' => $new_control_no]);
    }

    public function employeeID(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user_details = User::where('employee_id', $request->user_id)->where('position', [0,7,8,10])->first();
        return response()->json(['userDetails' => $user_details]);
    }

    public function updateMimf(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        // return $request->mimf_stamping_matrix_status;

        if($request->mimf_stamping_matrix_status == 1){
            $test = 'ppd_mimf_stamping_matrix_id';
            $tist = 'created_by';
        }else{
            $test = 'ppd_matrix_id';
            $tist = 'pps_dieset_id';
        }
        $validator = Validator::make($data, [
            $test                           => 'required',
            $tist                           => 'required',
            'mimf_stamping_matrix_status'   => 'required',
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
        // return $validator;

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            // DB::beginTransaction();
            // try {
                $check_existing_record = Mimf::where('control_no', $request->mimf_control_no)->where('status', $request->mimf_stamping_matrix_status)->where('logdel', 0)->get();
                // return count($check_existing_record);
                $mimf = [
                    'status'            => $request->mimf_stamping_matrix_status,
                    'pps_po_rcvd_id'    => $request->pps_po_rcvd_id,
                    'pps_dieset_id'     => $request->pps_dieset_id,
                    'pps_whse_id'       => $request->pps_whse_id,
                    'ppd_matrix_id'     => $request->ppd_matrix_id,
                    'control_no'        => $request->mimf_control_no,
                    'date_issuance'     => $request->mimf_date_issuance,
                    'pmi_po_no'         => $request->mimf_pmi_po_no,
                    'prodn_qty'         => $request->mimf_prodn_quantity,
                    'device_code'       => $request->mimf_device_code,
                    'device_name'       => $request->mimf_device_name,
                    'material_code'     => $request->mimf_material_code,
                    'material_type'     => $request->mimf_material_type,
                    'qty_invt'          => $request->mimf_quantity_from_inventory,
                    'needed_kgs'        => $request->mimf_needed_kgs,
                    'virgin_material'   => $request->mimf_virgin_material,
                    'recycled'          => $request->mimf_recycled,
                    'prodn'             => $request->date_mimf_prodn,
                    'delivery'          => $request->mimf_delivery,
                    'remarks'           => $request->mimf_remark,
                    'scan_by'           => $request->employee_no,
                ];   
                
                if(count($check_existing_record) != 1){
                    $mimf['created_by']  = $request->created_by;
                    $mimf['created_at']  = date('Y-m-d H:i:s');
                    Mimf::insert(
                        $mimf
                    );
                }else{
                    if($request->mimf_id != ''){
                        $mimf['updated_by']  = $request->created_by;
                        $mimf['updated_at']  = date('Y-m-d H:i:s');
                        Mimf::where('id', $request->mimf_id)
                        ->update(
                            $mimf
                        );
                    }else{
                        return response()->json(['result' => 1]);
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
        
        $get_mimf_to_edit = Mimf::where('id', $request->mimfID)->get();
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
            // return count($get_po_received_pmi_po_for_molding[0]->pps_dieset_info->pps_warehouse_info->pps_warehouse_transaction_info);
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
            // return $get_po_received_pmi_po_for_stamping[0]->mimf_stamping_matrix_info->pps_whse_info;
            // return $get_po_received_pmi_po_for_stamping;
            return response()->json(['getPoReceivedPmiPoForStamping' => $get_po_received_pmi_po_for_stamping, 'totalBalanceForStamping' => $total_balanace_for_stamping]);

        }
    }

    public function viewMimfStampingMatrix(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_mimf_stamping_matrices = MimfStampingMatrix::where('logdel', 0)->orderBy('id', 'DESC')->get();

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
        ->rawColumns([
            'action',
        ])
        ->make(true);
    }

    public function getPpsWarehouse(){
        $get_partname = TblWarehouse::get('PartNumber');
        return response()->json(['getPartName'  => $get_partname]);
    }

    public function updateMimfStampingMatrix(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $validator = Validator::make($data, [
            'mimf_stamping_matrix_item_code'        => 'required',
            'mimf_stamping_matrix_item_name'        => 'required',
            'mimf_stamping_matrix_pin_kg'           => 'required',
            'mimf_stamping_matrix_part_code'        => 'required',
            'mimf_stamping_matrix_material_name'    => 'required',
            'mimf_stamping_matrix_created_by'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                $check_existing_record = MimfStampingMatrix::where('id', $request->mimf_stamping_matrix_id)->where('logdel', 0)->get();
                $mimf_stamping_matrix = [
                    'item_code'     => $request->mimf_stamping_matrix_item_code,
                    'item_name'     => $request->mimf_stamping_matrix_item_name,
                    'part_code'     => $request->mimf_stamping_matrix_part_code,
                    'material_name' => $request->mimf_stamping_matrix_material_name,
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
        
        $get_mimf_stamping_matrix_to_edit = MimfStampingMatrix::where('id', $request->mimfStampingMatrixID)->get();
        return response()->json(['getMimfStampingMatrixToEdit'  => $get_mimf_stamping_matrix_to_edit]);
    }


}

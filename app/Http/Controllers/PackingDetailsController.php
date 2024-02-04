<?php

namespace App\Http\Controllers;

use QrCode;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\FirstStampingProduction;
use App\Models\OQCInspection;
use App\Models\User;
use App\Models\PackingDetails;
use App\Models\PackingListDetails;
use App\Models\PreliminaryPacking;
use App\Models\ReceivingDetails;

class PackingDetailsController extends Controller
{
    public function viewPrelimDetailsData(Request $request){
        $preliminary_packing_data = OQCInspection::with(['stamping_production_info', 'prelim_packing_info', 'prelim_packing_info.user_info_prelim'])
        ->where('po_no', $request->po_no )
        ->where('lot_accepted', 1)
        ->orderBy('status', 'DESC')
        ->get();

        // return $preliminary_packing_data;
        // return $preliminary_packing_data[3]->packing_info->status;

        // if(!isset($request->po_no)){
        //     return [];
        // }else{
            
            return DataTables::of($preliminary_packing_data)
            ->addColumn('action', function($preliminary_packing_data){
                $result = "";
                $result .= "<center>";
                if( $preliminary_packing_data->prelim_packing_info == null){

                    $result .= "<button class='btn btn-primary btn-sm btnValidatePrelimPackingDetails' style='display: none;' po-no='$preliminary_packing_data->po_no' data-id='$preliminary_packing_data->id'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                }else{

                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($preliminary_packing_data){
                $result = "";
                $result .= "<center>";

                if( $preliminary_packing_data->prelim_packing_info == null){
                    $result .= '<span class="badge bg-info">OQC PASSED</span>';
                    $result .= '<br>';
                    $result .= '<span class="badge bg-info">For Packing Validation</span>';
                }else{
                    if($preliminary_packing_data->prelim_packing_info->status == 1){
                        $result .= '<span class="badge bg-info">For Packing List</span>';
                    }else{
                        $result .= '<span class="badge bg-success">Completed</span>';
                    }
                }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
        // }
    }

    public function viewFinalPackingDetailsData(Request $request){

        // $prelim_packing_details = PreliminaryPacking::with
        // (['oqc_info.stamping_production_info', 
        // 'final_packing_info', 
        // 'final_packing_info.user_validated_by_info',
        // 'final_packing_info.user_checked_by_info'
        // ])
        // ->where('po_no', 'like', '%' . $request->po_no . '%')
        // ->where('status', 2)
        // ->get();

        $final_packing_data = DB::connection('mysql')
        ->select("SELECT 
        `packing_ctrl_no`, 
        any_value(`po_no`) AS po, 
        MIN(`status`) as stat
        FROM `packing_details`
        WHERE `status` <= 3
        GROUP BY `packing_ctrl_no`
        ORDER BY `stat` ASC");


        // return $final_packing_data[0]->p_status;

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($final_packing_data)
            ->addColumn('action', function($final_packing_data){
                $result = "";
                $result .= "<center>";
                if($final_packing_data->stat != 3){
                    $result .= "<button class='btn btn-primary btn-sm btnViewFinalPackingDetails' data-status='$final_packing_data->stat' data-ctrl-no='$final_packing_data->packing_ctrl_no'><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                }
                // else{
                //     $count = $final_packing_data->final_packing_info->print_count;
                //     $id = $final_packing_data->final_packing_info->id;
                //     // return $id;
                //     if($final_packing_data->final_packing_info->status == 1){
                        // $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-id='$id' data-printCount='$count'><i class='fa-solid fa-print'></i></button>&nbsp";
                //     }else if ($final_packing_data->final_packing_info->status == 2 ){
                //         $result .= "<button class='btn btn-primary btn-sm btnScanQrCode' style='display: none;' data-id='$id' ><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                //         // $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$count' data-id='$id'><i class='fa-solid fa-print'></i></button>&nbsp";

                //     }else if ($final_packing_data->final_packing_info->status == 3 ){
                //         $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$count' data-id='$id'><i class='fa-solid fa-print'></i></button>&nbsp";
                //     }
                // }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($final_packing_data){
                $result = "";
                $result .= "<center>";

                    if($final_packing_data->stat == 0){
                        $result .= '<span class="badge bg-info">For Packing Validation</span>';
                    }else if($final_packing_data->stat == 1){
                        $result .= '<span class="badge bg-info">For Printing</span>';
                    }else if($final_packing_data->stat == 2){
                        $result .= '<span class="badge bg-info">For QC Validation</span>';
                    }else{
                        $result .= '<span class="badge bg-success">Completed</span>';
                    }
                    // else{
                    //     if($final_packing_data->final_packing_info->status == 1){
                    //         $result .= '<span class="badge bg-info">For Printing</span>';
                    //     }
                    //     else if($final_packing_data->final_packing_info->status == 2){
                    //         $result .= '<span class="badge bg-info">For QC Validation</span>';
                    //     }else if ($final_packing_data->final_packing_info->status == 3 ){
                    //         $result .= '<span class="badge bg-success">Completed</span>';
                    //     }
                    // }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            ->make(true);
        }
    }

    public function getOqcDetailsForPacking(Request $request){
        $oqc_data = OQCInspection::with(['stamping_production_info'])
        ->where('id', $request->oqc_details_id)
        ->where('lot_accepted', 1)
        ->first();
        
        // return $oqc_data;

        // return $request->oqc_details_id;

        return response()->json(['oqcData' => $oqc_data]);
    }

    public function validateFinalPackingDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $fin_packing_details_data = PackingDetails::with(['oqc_data_info', 'oqc_data_info.stamping_production_info'])
        ->where('packing_ctrl_no', $request->packing_list_ctrl_no)
        ->get();

        // return $request->packing_list_ctrl_no;

        // return $fin_packing_details_data;

        
        for ($i=0; $i <count($request->scanned_packing_id); $i++) { 
            $id_to_update =  $request->scanned_packing_id[$i];

            // return $id_to_update;
            if($request->status_to_validate == 0){
                $array = [
                    'validated_by_packer'          => $request->scan_packer_id,
                    'validated_date_packer'          => date('Y-m-d H:i:s'),
                    'status'                => 1,
                    'created_at'            => date('Y-m-d H:i:s'),
                ];
                // return 'dito';
            }else{
                $array = [
                    'validated_by_qc'          => $request->scan_packer_id,
                    'validated_date_qc'          => date('Y-m-d H:i:s'),
                    'status'                => 3,
                    'created_at'            => date('Y-m-d H:i:s'),
                ];
                    $part_code = $fin_packing_details_data[$i]->oqc_data_info->stamping_production_info->part_code;
                    $prod_id = $fin_packing_details_data[$i]->oqc_data_info->stamping_production_info->id;
        
                    $array_for_receiving = [
                        'po_no'                 => $fin_packing_details_data[$i]->po_no, 
                        'control_no'            => $fin_packing_details_data[$i]->packing_ctrl_no, 
                        'part_code'             => $part_code, 
                        'prod_id'               => $prod_id, 
                        'mat_name'              => $fin_packing_details_data[$i]->material_name, 
                        'lot_no'                => $fin_packing_details_data[$i]->material_lot_no, 
                        'quantity'              => $fin_packing_details_data[$i]->lot_qty,  
                        'status'                => 0,
                        'created_at'            => date('Y-m-d H:i:s'),
                    ];
                    ReceivingDetails::insert($array_for_receiving);
                // }
                
            }
            
            PackingDetails::where('id', $id_to_update)
            ->update($array);

        }


        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function updatePrelimDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

                // return $id_to_update;
                $array = [
                    'oqc_id'                => $request->oqc_details_id,
                    'po_no'                 => $request->po_no,
                    'validated_by'          => $request->scan_packer_id,
                    'validated_date'          => date('Y-m-d H:i:s'),
                    'status'                => 1,
                    'created_at'            => date('Y-m-d H:i:s'),
                ];

                PreliminaryPacking::insert($array);
            
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);


    }

    public function generatePackingDetailsQr(Request $request){

        $packing_data = PackingDetails::where('id', $request->id)
        ->first(['po_no AS po_no', 'shipment_qty as shipment_qty', 'material_name as mat_name', 'material_lot_no as lot_no', 'drawing_no as drawing_no', 'no_of_cuts as no_of_cuts', 'material_quality as mat_quality']);
        // ->first();
        // return $packing_data;
        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($packing_data);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $QrCode,
            'text' =>  "<strong>$packing_data->po_no</strong><br>
                        <strong>$packing_data->shipment_qty</strong><br>
                        <strong>$packing_data->mat_name</strong><br>
                        <strong>$packing_data->lot_no</strong><br>
                        <strong>$packing_data->drawing_no</strong><br>
                        <strong>$packing_data->no_of_cuts</strong><br>
                        <strong>$packing_data->mat_quality</strong><br>
                        "
        );

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>PO #:</td>
                    <td>$packing_data->po_no</td>
                </tr>
                <tr>
                    <td>PO Qty:</td>
                    <td>$packing_data->shipment_qty</td>
                </tr>
                <tr>
                    <td>Material Name:</td>
                    <td>$packing_data->mat_name</td>
                </tr>
                <tr>
                    <td>Lot #:</td>
                    <td>$packing_data->lot_no</td>
                </tr>
                <tr>
                    <td>Drawing #:</td>
                    <td>$packing_data->drawing_no</td>
                </tr>
                <tr>
                    <td>No of Cuts:</td>
                    <td>$packing_data->no_of_cuts</td>
                </tr>
                <tr>
                    <td>Material Quality:</td>
                    <td>$packing_data->mat_quality</td>
                </tr>

            </table>
        ";

        return response()->json(['qrCode' => $QrCode, 'label_hidden' => $data, 'label' => $label, 'prodData' => $packing_data]);
    }
    
    public function changePrintingStatus(Request $request){
        PackingDetails::where('id', $request->id)
        ->update([
            'print_count' => 1,
            'status' => 2,
        ]);

    }
    
    public function updateQcDetails(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;

        $array = [
            // 'oqc_id'                => $request->oqc_details_id,
            'validated_by_qc'          => $request->scan_id,
            'validated_date_qc'          => date('Y-m-d H:i:s'),
            'status'                => 3,
            // 'created_at'            => date('Y-m-d H:i:s'),
        ];

        PackingDetails::where('id', $request->packing_details_id_qc)->update($array);

        return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
    }

    public function viewFinalPackingDataForValidation(Request $request){
        $final_packing_data_by_ctrl = PackingDetails::with(['user_validated_by_info', 'user_checked_by_info'])
        ->where('packing_ctrl_no', $request->final_packing_details_ctrl_no)
        ->get();

        // return $final_packing_data_by_ctrl;
        
        return DataTables::of($final_packing_data_by_ctrl)
            ->addColumn('action', function($final_packing_data_by_ctrl){
                $result = "";
                $result .= "<center>";
                if($final_packing_data_by_ctrl->status == 0){
                    // $result .= "";
                }else if ($final_packing_data_by_ctrl->status == 1 || $final_packing_data_by_ctrl->status == 3){
                    $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$final_packing_data_by_ctrl->print_count' data-id='$final_packing_data_by_ctrl->id'><i class='fa-solid fa-print'></i></button>&nbsp";
                }else{
                    // $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$final_packing_data_by_ctrl->print_count' data-id='$final_packing_data_by_ctrl->id'><i class='fa-solid fa-print'></i></button>&nbsp";
                }
                $result .= "</center>";
                return $result;

            })
            ->addColumn('status', function($final_packing_data_by_ctrl){
                $result = "";
                $result .= "<center>";
                if($final_packing_data_by_ctrl->status == 0){
                    $result .= '<span class="badge bg-info">For PACKER Validation</span>';                 
                }else if($final_packing_data_by_ctrl->status == 1){
                    $result .= '<span class="badge bg-info">For PACKER Printing</span>';  
                }
                else if($final_packing_data_by_ctrl->status == 2){
                    $result .= '<span class="badge bg-info">For QC Validation</span>';  
                }else{
                    $result .= '<span class="badge bg-success">Validated</span>';  
                }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
    }
}

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
use App\Models\PreliminaryPacking;

class PackingDetailsController extends Controller
{
    public function viewPrelimDetailsData(Request $request){
        $preliminary_packing_data = OQCInspection::with(['stamping_production_info', 'prelim_packing_info', 'prelim_packing_info.user_info_prelim'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('lot_accepted', 1)
        ->get();
        // ->orderBy('prelim_packing_info.status', 'DESC');

        // return $preliminary_packing_data;
        // return $preliminary_packing_data[3]->packing_info->status;

        if(!isset($request->po_no)){
            return [];
        }else{
            
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
        }
    }

    public function viewFinalPackingDetailsData(Request $request){

        $prelim_packing_details = PreliminaryPacking::with
        (['oqc_info.stamping_production_info', 
        'final_packing_info', 
        'final_packing_info.user_validated_by_info',
        'final_packing_info.user_checked_by_info'
        
        ])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('status', 2)
        ->get();

        // return $prelim_packing_details;

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($prelim_packing_details)
            ->addColumn('action', function($prelim_packing_details){
                $result = "";
                $result .= "<center>";
                if($prelim_packing_details->final_packing_info == null){
                    $result .= "<button class='btn btn-primary btn-sm btnEditPackingDetails' style='display: none;' oqc-id='$prelim_packing_details->oqc_id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                }else{
                    $count = $prelim_packing_details->final_packing_info->print_count;
                    $id = $prelim_packing_details->final_packing_info->id;
                    // return $id;
                    if($prelim_packing_details->final_packing_info->status == 1){
                        $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-id='$id' data-printCount='$count'><i class='fa-solid fa-print'></i></button>&nbsp";
                    }else if ($prelim_packing_details->final_packing_info->status == 2 ){
                        $result .= "<button class='btn btn-primary btn-sm btnScanQrCode' style='display: none;' data-id='$id' ><i class='fa-solid fa-qrcode'></i></button>&nbsp";
                        $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$count' data-id='$id'><i class='fa-solid fa-print'></i></button>&nbsp";

                    }else if ($prelim_packing_details->final_packing_info->status == 3 ){
                        $result .= "<button class='btn btn-primary btn-sm btnGeneratePackingQr' data-printCount='$count' data-id='$id'><i class='fa-solid fa-print'></i></button>&nbsp";
                    }
                }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($prelim_packing_details){
                $result = "";
                $result .= "<center>";

                    if($prelim_packing_details->final_packing_info == null){
                        $result .= '<span class="badge bg-info">For Packing Validation</span>';
                    }else{
                        if($prelim_packing_details->final_packing_info->status == 1){
                            $result .= '<span class="badge bg-info">For Printing</span>';
                        }
                        else if($prelim_packing_details->final_packing_info->status == 2){
                            $result .= '<span class="badge bg-info">For QC Validation</span>';
                        }else if ($prelim_packing_details->final_packing_info->status == 3 ){
                            $result .= '<span class="badge bg-success">Completed</span>';
                        }
                    }

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

    public function addPackingDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'                => $request->packing_details_id,
                            'po_no'                 => $request->po_no,
                            'po_qty'                => $request->po_quantity,
                            'material_name'         => $request->parts_name,
                            'material_lot_no'       => $request->prod_lot_no,
                            'drawing_no'            => $request->drawing_no,
                            // 'delivery_balance'      => $request->delivery_balance,
                            'no_of_cuts'            => $request->number_of_cuts,
                            'material_quality'      => $request->material_quality,
                            'validated_by_packer'   => $request->scan_packer_id,
                            'validated_date_packer' => date('Y-m-d H:i:s'),
                            'material_quality'      => $request->material_quality,
                            'print_count'           => 0,
                            'status'                => 1,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];
                        
                        PackingDetails::insert($array);
                        
        
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function updatePrelimDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'                => $request->oqc_details_id,
                            'po_no'                 => $request->po_no,
                            'validated_by'          => $request->scan_opeator_id,
                            'validated_date'          => date('Y-m-d H:i:s'),
                            'status'                => 1,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];

                        PreliminaryPacking::insert($array);

            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }

    }

    public function generatePackingDetailsQr(Request $request){

        $packing_data = PackingDetails::where('id', $request->id)
        ->first(['po_no AS po_no', 'po_qty as po_qty', 'material_name as mat_name', 'material_lot_no as lot_no', 'drawing_no as drawing_no', 'no_of_cuts as no_of_cuts', 'material_quality as mat_quality']);
        // ->first();
        // return $packing_data;
        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($packing_data);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $QrCode,
            'text' =>  "<strong>$packing_data->po_no</strong><br>
                        <strong>$packing_data->po_qty</strong><br>
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
                    <td>$packing_data->po_qty</td>
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
}

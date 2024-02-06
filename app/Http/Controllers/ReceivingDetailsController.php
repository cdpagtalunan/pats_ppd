<?php

namespace App\Http\Controllers;

use QrCode;
use DataTables;
use Illuminate\Http\Request;
use App\Models\PackingListDetails;
use App\Models\ReceivingDetails;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceivingDetailsController extends Controller
{
    public function viewReceivingListDetailsByCtrl(Request $request){
        // $sanno_receiving_data = ReceivingDetails::where('status', 0)
        // ->orWhere('status', 1)
        // ->groupBy('control_no')
        // ->get();
        $sanno_receiving_data = DB::connection('mysql')
        ->select("SELECT 
        `control_no`, 
        any_value(`po_no`) AS po, 
        MIN(`status`) as stat,
        MIN(`printing_status`) as print_stat
        FROM `receiving_details`
        WHERE `status` <= 2
        GROUP BY `control_no`
        ORDER BY `stat` ASC");

        // return $sanno_receiving_data;

        return DataTables::of($sanno_receiving_data)
        ->addColumn('action', function($sanno_receiving_data){
            $result = "";
            $result .= "<center>";
            if($sanno_receiving_data->stat != 2){
                $result .= "<button class='btn btn-primary btn-sm btnViewReceivingDetails' data-ctrl-no='$sanno_receiving_data->control_no'><i class='fa-solid fa-edit'></i></button>&nbsp";
            }else{
                $result .= "<button class='btn btn-primary btn-sm btnViewReceivingDetails' data-ctrl-no='$sanno_receiving_data->control_no'><i class='fa-solid fa-eye'></i></button>&nbsp";  
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($sanno_receiving_data){
            $result = "";
            $result .= "<center>";

            if($sanno_receiving_data->stat == 0){
                $result .= '<span class="badge bg-primary">For WHSE Receive</span>';
            }
            else if($sanno_receiving_data->stat == 1){
                $result .= '<span class="badge bg-info">For IQC Inspection</span>';
                $result .= '<br>';
                if($sanno_receiving_data->print_stat == 0) {
                    $result .= '<span class="badge bg-primary">For Printing</span>';
                }else{
                    $result .= '<span class="badge bg-primary">Reprinting</span>';
                }
            }else{
                $result .= '<span class="badge bg-success">Accepted</span>';
            }

            $result .= "</center>";
            return $result;
        })
        // ->addIndexColumn(['DT_RowIndex'])
        ->rawColumns(['action','status'])
        // ->rawColumns(['action','status','test'])
        ->make(true);
    }

    public function viewReceivingListDetails(Request $request){

        // return $request->receving_details_ctrl_no;

        $receiving_details_data = ReceivingDetails::
        where('status', '!=', 3)
        ->where('control_no', $request->receving_details_ctrl_no)
        ->get();
        
        return DataTables::of($receiving_details_data)
        ->addColumn('action', function($receiving_details_data){
            $result = "";
            $result .= "<center>";
            if($receiving_details_data->status == 0){
                $result .= "<button class='btn btn-primary btn-sm btnEditReceivingDetails' data-id='$receiving_details_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
            }else if($receiving_details_data->status == 1){
                $result .= "<button class='btn btn-primary btn-sm btnPrintReceivingData' data-id='$receiving_details_data->id' data-printcount='$receiving_details_data->printing_status'><i class='fa-solid fa-qrcode'></i></button>";
            }else{
                $result .= "<button class='btn btn-primary btn-sm btnPrintReceivingData' data-id='$receiving_details_data->id' data-printcount='$receiving_details_data->printing_status'><i class='fa-solid fa-qrcode'></i></button>";

            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($receiving_details_data){
            $result = "";
            $result .= "<center>";

            if($receiving_details_data->status == 0){
                $result .= '<span class="badge bg-primary">For WHSE Receive</span>';
            }
            else if($receiving_details_data->status == 1){
                $result .= '<span class="badge bg-info">For IQC Inspection</span>';
                $result .= '<br>';
                if($receiving_details_data->printing_status == 0) {
                    $result .= '<span class="badge bg-primary">For Printing</span>';
                }else{
                    $result .= '<span class="badge bg-primary">Reprinting</span>';
                }
            }else{
                $result .= '<span class="badge bg-success">Accepted</span>';
            }

            $result .= "</center>";
            return $result;
        })
        ->addIndexColumn(['DT_RowIndex'])
        ->rawColumns(['action','status'])
        // ->rawColumns(['action','status','test'])
        ->make(true);
    }

    // public function viewReceivingListDetailsAccepted(Request $request){
    //     $sanno_receiving_data = ReceivingDetails::where('status', 2)
    //     ->get();

    //     return DataTables::of($sanno_receiving_data)
    //     ->addColumn('action', function($sanno_receiving_data){
    //         $result = "";
    //         $result .= "<center>";
    //         if($sanno_receiving_data->status == 0){
    //             $result .= "<button class='btn btn-primary btn-sm btnEditReceivingDetails' data-id='$sanno_receiving_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
    //         }else if($sanno_receiving_data->status == 1){
    //             $result .= "<button class='btn btn-primary btn-sm btnPrintReceivingData' data-id='$sanno_receiving_data->id' data-printcount='$sanno_receiving_data->printing_status'><i class='fa-solid fa-qrcode'></i></button>";

    //         }
    //         $result .= "</center>";
    //         return $result;
    //     })
    //     ->addColumn('status', function($sanno_receiving_data){
    //         $result = "";
    //         $result .= "<center>";

    //         if($sanno_receiving_data->status == 0){
    //             $result .= '<span class="badge bg-primary">For WHSE Receive</span>';
    //         }
    //         else if($sanno_receiving_data->status == 1){
    //             $result .= '<span class="badge bg-info">For IQC Inspection</span>';
    //             $result .= '<br>';
    //             if($sanno_receiving_data->printing_status == 0) {
    //                 $result .= '<span class="badge bg-primary">For Printing</span>';
    //             }else{
    //                 $result .= '<span class="badge bg-primary">Reprinting</span>';
    //             }
    //         }else{
    //             $result .= '<span class="badge bg-success">Accepted</span>';
    //         }

    //         $result .= "</center>";
    //         return $result;
    //     })
    //     // ->addIndexColumn(['DT_RowIndex'])
    //     ->rawColumns(['action','status'])
    //     // ->rawColumns(['action','status','test'])
    //     ->make(true);
    // }

    public function getReceivingListdetails(Request $request){
        $receiving_details = ReceivingDetails::
        where('id', $request->receiving_details_id)
        ->get();

        // return $receiving_details;

        return response()->json(['receivingDetails' => $receiving_details]);
    }

    public function updateReceivingDetails(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;

        // return $request->scan_id;

        $pmi_supplier_lot_no = $request->pmi_lot_no .'/'. $request->supplier_lot_no;

        $rules = [
            'supplier_name'      => 'required',
            'supplier_lot_no'   => 'required',
            'supplier_qty'      => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
        // return 'update';
        ReceivingDetails::where('id', $request->receiving_details_id)
            ->update([
                'supplier_name' => $request->supplier_name,
                'supplier_lot_no' => $request->supplier_lot_no,
                'invoice_no'     => $request->invoice_no,
                'supplier_quantity' => $request->supplier_qty,
                'supplier_pmi_lot_no' => $pmi_supplier_lot_no,
                'status' => 1,
                'updated_by' => $request->scan_id,
            ]);
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function printReceivingQrCode(Request $request){
        $receiving_data = ReceivingDetails::where('id', $request->id)
        ->first(['po_no AS po_no','supplier_pmi_lot_no AS new_lot_no']);


        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($receiving_data);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $QrCode,
            'text' =>  "<strong>$receiving_data->po_no</strong><br>
            <strong>$receiving_data->new_lot_no</strong><br>"
        );

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>PO #:</td>
                    <td>$receiving_data->po_no</td>
                </tr>

                <tr>
                    <td>Lot #:</td>
                    <td>$receiving_data->new_lot_no</td>
                </tr>
            </table>
        ";

        return response()->json(['qrCode' => $QrCode, 'label_hidden' => $data, 'label' => $label, 'prodData' => $receiving_data]);
    }

    public function changePrintStatus(Request $request){
            ReceivingDetails::where('id', $request->id)
            ->update([
                'printing_status' => 1
            ]);

    }

}

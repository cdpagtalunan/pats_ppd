<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use App\Models\PackingListDetails;
use App\Models\ReceivingDetails;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceivingDetailsController extends Controller
{
    public function viewReceivingListDetails(Request $request){
        $sanno_receiving_data = ReceivingDetails::all();

        return DataTables::of($sanno_receiving_data)
        ->addColumn('action', function($sanno_receiving_data){
            $result = "";
            $result .= "<center>";
            if($sanno_receiving_data->status == 0){
                $result .= "<button class='btn btn-info btn-sm btnEditReceivingDetails' data-id='$sanno_receiving_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
            }else{

            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($sanno_receiving_data){
            $result = "";
            $result .= "<center>";
    
            if($sanno_receiving_data->status == 0){
                $result .= '<span class="badge bg-info">For WHSE Receive</span>';
            }
            else{
                $result .= '<span class="badge bg-success">For IQC Inspection</span>';
            }

            $result .= "</center>";
            return $result;
        })
        // ->addIndexColumn(['DT_RowIndex'])
        ->rawColumns(['action','status'])
        // ->rawColumns(['action','status','test'])
        ->make(true);
    }

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

        // return $request->scan_id;

        $pmi_sanno_lot_no = $request->pmi_lot_no .'/'. $request->sanno_lot_no;

        $rules = [
            'sanno_lot_no'                 => 'required',
            'sanno_qty'      => 'required',
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
        // return 'update';
        ReceivingDetails::where('id', $request->receiving_details_id)
            ->update([
                'sanno_lot_no' => $request->sanno_lot_no,
                'sanno_quantity' => $request->sanno_qty,
                'sanno_pmi_lot_no' => $pmi_sanno_lot_no,
                'status' => 1,
                'updated_by' => $request->scan_id,
            ]);
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }



    }
    
}

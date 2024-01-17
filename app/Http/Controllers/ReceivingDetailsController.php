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
    public function viewPackingListDetails(Request $request){
        $sanno_receiving_data = ReceivingDetails::all();

        return DataTables::of($sanno_receiving_data)
        ->addColumn('action', function($sanno_receiving_data){
            $result = "";
            $result .= "<center>";
            if($sanno_receiving_data->status == 0){
                $result .= "<button class='btn btn-dark btn-sm btnEditReceivingDetails' data-id='$sanno_receiving_data->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
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
                $result .= '<span class="badge bg-danger">For IQC Inspection</span>';
            }

            $result .= "</center>";
            return $result;
        })
        // ->addIndexColumn(['DT_RowIndex'])
        ->rawColumns(['action','status'])
        // ->rawColumns(['action','status','test'])
        ->make(true);
    }
}

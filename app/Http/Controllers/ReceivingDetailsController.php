<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PackingListDetails;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReceivingDetailsController extends Controller
{
    public function viewPackingListDetails(Request $request){
        $get_packing_list_details = PackingListDetails::where('shipment_status', 2)
        ->get();

        // return $get_packing_list_details;
    }
}

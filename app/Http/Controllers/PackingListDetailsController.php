<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarrierDetails;

class PackingListDetailsController extends Controller
{
    public function getCarrierDetails(Request $request){
        $carrier_details = CarrierDetails::
        where('status',0)
        ->get();

        // return $carrier_details;

        return response()->json(['carrierDetails' => $carrier_details]);

        // return $machine_details;
    }
}

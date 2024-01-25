<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FirstMoldingDevice;

class FirstMoldingController extends Controller
{
    public function getFirstMoldingDevices(Request $request){
        $first_molding_device = FirstMoldingDevice::get();
        foreach ($first_molding_device as $key => $value_first_molding_device) {
            $arr_first_molding_device_id[] =$value_first_molding_device['id'];
            $arr_first_molding_device_value[] =$value_first_molding_device['device_name'];
        }
        return response()->json([
            'id'    =>  $arr_first_molding_device_id,
            'value' =>  $arr_first_molding_device_value
        ]);
    }
}

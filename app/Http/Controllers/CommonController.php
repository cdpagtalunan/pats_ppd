<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\MaterialProcess;
use App\Models\MaterialProcessMaterial;
use App\Models\MaterialProcessStation;
use App\Models\Process;
use App\Models\Device;

class CommonController extends Controller
{
    public function get_search_po(Request $request){
        return DB::connection('mysql_rapid_pps')
        ->select("
            SELECT * FROM tbl_POReceived WHERE OrderNo = '$request->po'
        ");
    }

    public function validate_user(Request $request){
        $user = User::where('employee_id', $request->id)
        ->where('status', 1)
        ->whereIn('position', $request->pos)
        ->first();

        if(isset($user)){
            return response()->json(['result' => 1]);
        }
        else{
            return response()->json(['result' => 2]);
        }
    }

    public function get_data_from_matrix(Request $request){
        $material_name = [];
        $matrix_data = Device::with(['material_process.material_details'])->where('name', $request->series_name)->where('status', 1)->get();
        foreach($matrix_data[0]->material_process[0]->material_details as $material_details){
            $material_name[] = $material_details->material_type;
        }
        $material_type = implode(',',$material_name);
        return response()->json(['material_details' => $material_type]);
    }
}

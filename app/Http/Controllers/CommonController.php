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

    public function get_mode_of_defect_frm_defect_infos(Request $request){
        $modeOfDefectResult = DB::connection('mysql')
        ->select("SELECT defects_infos.* FROM defects_infos
        ");
        return response()->json(['data' => $modeOfDefectResult]);
    }

    public function get_data_from_acdcs(Request $request){
        $acdcs_data = DB::connection('mysql_rapid_acdcs')
        ->select("SELECT DISTINCT `doc_no`,`doc_type` FROM tbl_active_docs WHERE `doc_type` = '".$request->doc_type."' AND `doc_title` LIKE '%".$request->doc_title."%'");
        return response()->json(['acdcs_data' => $acdcs_data]);
    }


}
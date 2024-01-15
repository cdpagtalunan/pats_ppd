<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function get_search_po(Request $request){
        return DB::connection('mysql_rapid_pps')
        ->select("
            SELECT * FROM tbl_POReceived WHERE OrderNo = $request->po
        ");
    }

    public function validate_user(Request $request){
        $user = User::where('employee_id', $request->id)
        ->where('status', 1)
        ->where('position', $request->pos)
        ->first();
    
        if(isset($user)){
            return response()->json(['result' => 1]);
        }
        else{
            return response()->json(['result' => 2]);

        }
    }
}

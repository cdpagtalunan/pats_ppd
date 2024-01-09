<?php

namespace App\Http\Controllers;

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
}

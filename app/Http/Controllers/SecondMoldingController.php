<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecondMoldingController extends Controller
{
    public function getSearchPoForMolding(Request $request){
        return DB::connection('mysql_rapid_pps')->select("
            SELECT * FROM tbl_POReceived WHERE OrderNo = '$request->po'
        ");
    }
    
    public function checkMaterialLotNumber(Request $request){
        return DB::connection('mysql_rapid_pps')->select("
            SELECT * FROM tbl_WarehouseTransaction AS a 
                INNER JOIN tbl_Warehouse as b
                    ON b.id = a.fkid
                WHERE Lot_number = '$request->material_lot_number'
        ");
    }
}

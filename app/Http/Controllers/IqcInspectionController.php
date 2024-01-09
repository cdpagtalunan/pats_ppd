<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\TblWarehouse;
use Illuminate\Http\Request;
use App\Models\DropdownIqcAql;
use App\Models\DropdownIqcFamily;
use Illuminate\Support\Facades\DB;
use App\Models\TblWarehouseTransaction;
use App\Models\DropdownIqcInspectionLevel;

class IqcInspectionController extends Controller
{
    //
    public function loadWhsTransaction(){
        // return TblWarehouseTransaction::select('*')->limit(10)->get();
        // return TblWarehouse::select('*')->limit(10)->get();

        $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
        ->select('
            SELECT whs_trasaction.*,whs_trasaction.pkid as "whs_trasaction_id",whs_trasaction.Username as "whs_trasaction_username",
            whs_trasaction.LastUpdate as "whs_trasaction_lastupdate",whs_trasaction.inspection_class,
            whs.*,whs.id as "whs_id",whs.Username as "whs_username",whs.LastUpdate as "whs_lastupdate"
            FROM tbl_WarehouseTransaction whs_trasaction
            INNER JOIN tbl_Warehouse whs on whs.id = whs_trasaction.fkid
            WHERE whs.MaterialType LIKE "%CN171S%"
            ORDER BY whs.PartNumber DESC
            LIMIT 0,100
        ');
        //WHERE whs_trasaction.inspection_class = 1
        //WHERE whs.PartNumber = 103587401 CN171S
        //ORDER BY whs_trasaction.LastUpdate DESC inspection_class 1-Fo


        return DataTables::of($tbl_whs_trasanction)
        //<th>App Ctrl No.</th>
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            $result .= "<button class='btn btn-info btn-sm mr-1' whs-trasaction-id='".$row->whs_trasaction_id."' id='btnEditIqcInspection'><i class='fa-solid fa-pen-to-square'></i></button>";
            $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($row){
            $result = '';
            $result .= '<center>';
                $result .= "<span class='badge rounded-pill bg-primary'>On going</span>";
            $result .= '</center>';

            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
        return $tbl_whs_trasanction;
        return $tbl_whs_trasanction[0]->InvoiceNo;
        return $tbl_whs_trasanction[0]->PartNumber;
        return $tbl_whs_trasanction[0]->MaterialType;
        return $tbl_whs_trasanction[0]->Supplier; //Application Ctrl. No

        return $tbl_whs_trasanction[0]->TransferSlipNo; //Application Ctrl. No

        return $tbl_whs_trasanction[0]->whs_trasaction_id;
        return $tbl_whs_trasanction[0]->whs_trasaction_lastupdate;
        return $tbl_whs_trasanction[0]->whs_trasaction_username;
        return $tbl_whs_trasanction[0]->whs_id;
        return $tbl_whs_trasanction[0]->whs_lastupdate;
        return $tbl_whs_trasanction[0]->whs_username;


        /*
            InvoiceNo
            whs_trasaction_username,whs_username
            whs_trasaction_lastupdate,whs_lastupdate
            whs_trasaction_lastupdate,whs_lastupdate
            *Inspection Times*
            *Application Ctrl. No*
            *FY#*
            *WW#*
            *Sub*
            PartNumber
            ProductLine,MaterialType
            Supplier
            Lot_number


        */
    }

    public function getWhsTransactionById(Request $request){
        // return $request->whs_trasaction_id;
        return $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
        ->select('
            SELECT whs_trasaction.*,whs_trasaction.pkid as "whs_trasaction_id",whs_trasaction.Username as "whs_trasaction_username",
            whs_trasaction.LastUpdate as "whs_trasaction_lastupdate",whs_trasaction.inspection_class,
            whs.*,whs.id as "whs_id",whs.Username as "whs_username",whs.LastUpdate as "whs_lastupdate"
            FROM tbl_WarehouseTransaction whs_trasaction
            INNER JOIN tbl_Warehouse whs on whs.id = whs_trasaction.fkid
            WHERE whs_trasaction.pkid = '.$request->whs_trasaction_id.'
            LIMIT 0,1
        ');
    }

    public function getFamily(){
        $dropdown_iqc_family =  DropdownIqcFamily::get();
        foreach ($dropdown_iqc_family as $key => $value_dropdown_iqc_family) {
            $arr_dropdown_iqc_family_id[] =$value_dropdown_iqc_family['id'];
            $arr_dropdown_iqc_family_value[] =$value_dropdown_iqc_family['family_name'];
        }
        return response()->json([
            'id'    =>  $arr_dropdown_iqc_family_id,
            'value' =>  $arr_dropdown_iqc_family_value
        ]);
    }
    public function getInspectionLevel(){
        $dropdown_inspection_level =  DropdownIqcInspectionLevel::get();
        foreach ($dropdown_inspection_level as $key => $value_dropdown_inspection_level) {
            $arr_dropdown_inspection_level_id[] =$value_dropdown_inspection_level['id'];
            $arr_dropdown_inspection_level_value[] =$value_dropdown_inspection_level['inspection_level'];
        }
        return response()->json([
            'id'    =>  $arr_dropdown_inspection_level_id,
            'value' =>  $arr_dropdown_inspection_level_value
        ]);
    }
    public function getAql(){
        $dropdown_aql =  DropdownIqcAql::get();
        foreach ($dropdown_aql as $key => $value_dropdown_aql) {
            $arr_dropdown_aql_id[] =$value_dropdown_aql['id'];
            $arr_dropdown_aql_value[] =$value_dropdown_aql['aql_percentage'];
        }
        return response()->json([
            'id'    =>  $arr_dropdown_aql_id,
            'value' =>  $arr_dropdown_aql_value
        ]);
    }
}

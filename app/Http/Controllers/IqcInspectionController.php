<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\TblWarehouse;
use Illuminate\Http\Request;
use App\Models\DropdownIqcAql;
use App\Models\DropdownIqcFamily;
use Illuminate\Support\Facades\DB;
use App\Models\DropdownIqcTargetLar;
use App\Models\DropdownIqcTargetDppm;
use App\Models\TblWarehouseTransaction;
use App\Models\DropdownIqcModeOfDefect;
use App\Models\DropdownIqcInspectionLevel;
use App\Http\Requests\IqcInspectionRequest;

class IqcInspectionController extends Controller
{
    //
    public function loadWhsTransaction(){
        // return TblWarehouseTransaction::select('*')->limit(10)->get();
        // return TblWarehouse::select('*')->limit(10)->get();

        $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
        ->select('
            SELECT whs_transaction.*,whs_transaction.pkid as "whs_transaction_id",whs_transaction.Username as "whs_transaction_username",
            whs_transaction.LastUpdate as "whs_transaction_lastupdate",whs_transaction.inspection_class,
            whs.*,whs.id as "whs_id",whs.Username as "whs_username",whs.LastUpdate as "whs_lastupdate"
            FROM tbl_WarehouseTransaction whs_transaction
            INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
            WHERE whs_transaction.inspection_class = 0
            ORDER BY whs.PartNumber DESC
            LIMIT 0,100
        ');
        //WHERE whs_transaction.inspection_class = 1
        //WHERE whs.PartNumber = 103587401 CN171S
        //ORDER BY whs_transaction.LastUpdate DESC inspection_class 1-Fo


        return DataTables::of($tbl_whs_trasanction)
        //<th>App Ctrl No.</th>
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            $result .= "<button class='btn btn-info btn-sm mr-1' whs-trasaction-id='".$row->whs_transaction_id."' id='btnEditIqcInspection'><i class='fa-solid fa-pen-to-square'></i></button>";
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

        return $tbl_whs_trasanction[0]->whs_transaction_id;
        return $tbl_whs_trasanction[0]->whs_transaction_lastupdate;
        return $tbl_whs_trasanction[0]->whs_transaction_username;
        return $tbl_whs_trasanction[0]->whs_id;
        return $tbl_whs_trasanction[0]->whs_lastupdate;
        return $tbl_whs_trasanction[0]->whs_username;


        /*
            InvoiceNo
            whs_transaction_username,whs_username
            whs_transaction_lastupdate,whs_lastupdate
            whs_transaction_lastupdate,whs_lastupdate
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
        // return $request->whs_transaction_id;
        return $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
        ->select('
            SELECT whs_transaction.*,whs_transaction.pkid as "whs_transaction_id",whs_transaction.Username as "whs_transaction_username",
            whs_transaction.LastUpdate as "whs_transaction_lastupdate",whs_transaction.inspection_class,
            whs.*,whs.id as "whs_id",whs.Username as "whs_username",whs.LastUpdate as "whs_lastupdate"
            FROM tbl_WarehouseTransaction whs_transaction
            INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
            WHERE whs_transaction.pkid = '.$request->whs_transaction_id.'
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

    public function getLotNumberByWhsTransactionId(){
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

    public function getLarDppm(){
        $dropdown_iqc_target_lar =  DropdownIqcTargetLar::where('status','1')->get();
        $dropdown_iqc_target_dppm =  DropdownIqcTargetDppm::where('status','1')->get();

        foreach ($dropdown_iqc_target_lar as $key => $value_dropdown_iqc_target_lar) {
            $arr_dropdown_iqc_target_lar_id[] =$value_dropdown_iqc_target_lar['id'];
            $arr_dropdown_iqc_target_lar_value[] =$value_dropdown_iqc_target_lar['lar'];
        }

        foreach ($dropdown_iqc_target_dppm as $key => $value_dropdown_iqc_target_dppm) {
            $arr_dropdown_target_dppm_id[] =$value_dropdown_iqc_target_dppm['id'];
            $arr_dropdown_target_dppm_value[] =$value_dropdown_iqc_target_dppm['dppm'];
        }

        return response()->json([
            'lar_id'    =>  $arr_dropdown_iqc_target_lar_id,
            'lar_value' =>  $arr_dropdown_iqc_target_lar_value,
            'dppm_id'    =>  $arr_dropdown_target_dppm_id,
            'dppm_value' =>  $arr_dropdown_target_dppm_value
        ]);
    }


    public function saveIqcInspection(IqcInspectionRequest $request){
        // return $request->all();
        // return 'true';
        return $attr = $request->validated();

        /**{
            "whs_transaction_id": "19928",
            "iqc_inspection_id": null,
            "invoice_no": "0092449618",
            "partcode": "108032201",
            "partname": "CN171S-05#ME-VE",
            "supplier": "YEC",
            "family": "2",
            "app_no": "PPS-2401-",
            "die_no": "4",
            "total_lot_qty": "321",
            "iqc_inspection_id": "",
            "type_of_inspection": "3",
            "severity_of_inspection": "2",
            "inspection_lvl": "3",
            "aql": "0.04",
            "accept": "1",
            "reject": "0",
            "date_inspected": "2024-01-10",
            "shift": "2",
            "time_ins_from": "15:08",
            "time_ins_to": "15:08",
            "inspector": "mclegaspi",
            "submission": "2",
            "category": "1",
            "target_lar": "1.19",
            "target_dppm": "1.19",
            "remarks": "dsa",
            "lot_inspected": "1",
            "accepted": "1",
            "sampling_size": "50",
            "no_of_defects": "21",
            "judgement": "1"
        }
        */
    }

    public function getModeOfDefect(){
        // return 'true';
        $dropdown_iqc_mode_of_defect = DropdownIqcModeOfDefect::get();
        foreach ($dropdown_iqc_mode_of_defect as $key => $value_dropdown_iqc_mode_of_defect) {
            $arr_dropdown_iqc_mode_of_defect_id[] = $value_dropdown_iqc_mode_of_defect['id'];
            $arr_dropdown_iqc_mode_of_defect_value[] = $value_dropdown_iqc_mode_of_defect['mode_of_defects'];
        }
        return response()->json([
            'id'    =>  $arr_dropdown_iqc_mode_of_defect_id,
            'value' =>  $arr_dropdown_iqc_mode_of_defect_value
        ]);
    }

}

<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\TblWarehouse;
use Illuminate\Http\Request;
use App\Models\IqcInspection;
use App\Models\DropdownIqcAql;
use App\Models\DropdownIqcFamily;
use App\Models\IqcInspectionsMod;
use Illuminate\Support\Facades\DB;
use App\Models\DropdownIqcTargetLar;
use App\Models\DropdownIqcTargetDppm;
use App\Models\DropdownIqcModeOfDefect;
use App\Models\TblWarehouseTransaction;
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
            $result .= "<button class='btn btn-info btn-sm mr-1' whs-trasaction-id='".$row->whs_transaction_id."'id='btnEditIqcInspection'><i class='fa-solid fa-pen-to-square'></i></button>";
            $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($row){
            $iqc_inspection_by_whs_trasaction_id = IqcInspection::where('whs_transaction_id',$row->whs_transaction_id)->get();
            $result = '';
            $backgound = '';
            $judgement = '';
            $result .= '<center>';

            if( count($iqc_inspection_by_whs_trasaction_id) != 0 ){
                foreach ($iqc_inspection_by_whs_trasaction_id as $key => $value){
                    switch ($value['judgement']) {
                        case 1:
                            $judgement = 'Accepted';
                            $backgound = 'bg-success';

                            break;
                        case 2:
                            $judgement = 'Reject';
                            $backgound = 'bg-danger';
                            break;

                        default:
                            $judgement = 'On-going';
                            $backgound = 'bg-primary';
                            break;
                    }
                }
                $result .= '<span class="badge rounded-pill '.$backgound.' ">'.$judgement.'</span>';
            }else{
                $result .= '<span class="badge rounded-pill bg-primary"> On-going </span>';
            }
            $result .= '</center>';
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
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

        $is_exist_iqc_inspection_by_whs_trasaction_id = IqcInspection::where('whs_transaction_id',$request->whs_transaction_id)->exists();

        if($is_exist_iqc_inspection_by_whs_trasaction_id == 1){
            return $tbl_whs_trasanction = IqcInspection::with('IqcInspectionsMods')
            ->where('whs_transaction_id',$request->whs_transaction_id)
            ->get(['iqc_inspections.id as iqc_inspection_id','iqc_inspections.*']);

        }else{
            return $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
            ->select('
                SELECT whs_transaction.*,whs_transaction.pkid as "whs_transaction_id",whs_transaction.Username as "whs_transaction_username",
                whs_transaction.LastUpdate as "whs_transaction_lastupdate",whs_transaction.inspection_class,
                whs_transaction.InvoiceNo as "invoice_no",whs_transaction.Lot_number as "lot_no",whs_transaction.In as "total_lot_qty",
                whs.PartNumber as "partcode",whs.MaterialType as "partname",whs.Supplier as supplier,
                whs.*,whs.id as "whs_id",whs.Username as "whs_username",whs.LastUpdate as "whs_lastupdate"
                FROM tbl_WarehouseTransaction whs_transaction
                INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
                WHERE whs_transaction.pkid = '.$request->whs_transaction_id.'
                LIMIT 0,1
            ');
        }

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
        date_default_timezone_set('Asia/Manila');
        try {
            if(isset($request->iqc_inspection_id)){ /* Edit */

                $update_iqc_inspection = IqcInspection::where('id', $request->iqc_inspection_id)->update($request->validated());
                IqcInspection::where('id', $request->iqc_inspection_id)
                ->update([
                    'no_of_defects' => $request->no_of_defects,
                    'remarks' => $request->remarks
                ]);

                $iqc_inspections_id = $request->iqc_inspection_id;

            }else{ /* Add */

                /* All required fields is the $request validated, check the column is IqcInspectionRequest
                    NOTE: the name of fields must be match in column name
                */
                $create_iqc_inspection = IqcInspection::create($request->validated());
                /*  All not required fields should to be inside the update method below
                    NOTE: the name of fields must be match in column name
                */
                IqcInspection::where('id', $create_iqc_inspection->id)
                ->update([
                    'no_of_defects' => $request->no_of_defects,
                    'remarks' => $request->remarks
                ]);

                $iqc_inspections_id = $create_iqc_inspection->id;

            }

            // return $iqc_inspections_id;
            /* Get iqc_inspections_id, delete the previos MOD then  save new MOD*/
            if(isset($request->modeOfDefects)){
                IqcInspectionsMod::where('iqc_inspection_id', $iqc_inspections_id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
                foreach ($request->lotQty as $key => $mod_lot_qty) {

                    IqcInspectionsMod::insert([
                        'iqc_inspection_id'    => $iqc_inspections_id,
                        'lot_no'                => $request->lotNo[$key],
                        'mode_of_defects'       => $request->modeOfDefects[$key],
                        'quantity'              => $request->lotQty[$key],
                        'created_at'            => date('Y-m-d H:i:s'),
                    ]);
                }
            }
            return response()->json( [ 'result' => 1 ] );
        } catch (\Throwable $th) {
            throw $th;
        }


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

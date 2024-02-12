<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Models\TblWarehouse;
use Illuminate\Http\Request;
use App\Models\IqcInspection;
use App\Models\DropdownIqcAql;
use App\Models\ReceivingDetails;
use App\Models\DropdownIqcFamily;
use App\Models\IqcInspectionsMod;
use Illuminate\Support\Facades\DB;
use App\Models\DropdownIqcTargetLar;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DropdownIqcTargetDppm;
use App\Models\DropdownIqcModeOfDefect;
use App\Models\TblWarehouseTransaction;
use Illuminate\Support\Facades\Storage;
use App\Models\DropdownIqcInspectionLevel;
use App\Http\Requests\IqcInspectionRequest;

class IqcInspectionController extends Controller
{
    public function getIqcInspectionByJudgement(Request $request)
    {
        return $iqc_inspection_by = IqcInspection::where('judgement',1)->get();
    }

    public function loadWhsTransaction(Request $request)
    {
        /*  Get the data only withwhs_transaction.inspection_class = 1 - For Inspection, while
            Transfer the data with whs_transaction.inspection_class = 3 to Inspected Tab
        */

        // return $request->lotNum;
        if( isset( $request->lotNum ) ){
            $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
            ->select('
                SELECT  whs.*,whs_transaction.*,whs_transaction.pkid as "whs_transaction_id",whs_transaction.inspection_class
                FROM tbl_WarehouseTransaction whs_transaction
                INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
                WHERE whs_transaction.inspection_class = 1 AND whs_transaction.Lot_number = "'.$request->lotNum.'"
                ORDER BY whs.PartNumber DESC
            ');
        }else{
            $tbl_whs_trasanction = DB::connection('mysql_rapid_pps')
            ->select('
                SELECT  whs.*,whs_transaction.*,whs_transaction.pkid as "whs_transaction_id",whs_transaction.inspection_class
                FROM tbl_WarehouseTransaction whs_transaction
                INNER JOIN tbl_Warehouse whs on whs.id = whs_transaction.fkid
                WHERE whs_transaction.inspection_class = 1
                ORDER BY whs.PartNumber DESC
            ');
        }

        return DataTables::of($tbl_whs_trasanction)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            $result .= "<button class='btn btn-info btn-sm mr-1' whs-trasaction-id='".$row->whs_transaction_id."'id='btnEditIqcInspection'><i class='fa-solid fa-pen-to-square'></i></button>";
            $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($row){
            $result = '';
            $result .= '<center>';
            $result .= '<span class="badge rounded-pill bg-primary"> On-going </span>';
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


    public function loadWhsDetails(Request $request)
    {
        if( isset( $request->lotNum ) ){
            $tbl_whs_trasanction = DB::connection('mysql')
            ->select('
                SELECT id as "receiving_detail_id",supplier_name as "Supplier",part_code as "PartNumber",
                        mat_name as"MaterialType",supplier_pmi_lot_no as "Lot_number",po_no
                FROM receiving_details
                WHERE status = 1 AND supplier_pmi_lot_no = "'.$request->lotNum.'"
                ORDER BY created_at DESC
            ');
        }else{
            $tbl_whs_trasanction = DB::connection('mysql')
            ->select('
                SELECT id as "receiving_detail_id",supplier_name as "Supplier",part_code as "PartNumber",
                        mat_name as"MaterialType",supplier_pmi_lot_no as "Lot_number",po_no
                FROM receiving_details
                WHERE status = 1
                ORDER BY created_at DESC
            ');
        }
        
        
        
        return DataTables::of($tbl_whs_trasanction)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            $result .= "<button class='btn btn-info btn-sm mr-1' receiving-detail-id='".$row->receiving_detail_id."'id='btnEditIqcInspection'><i class='fa-solid fa-pen-to-square'></i></button>";
            $result .= '</center>';
            return $result;
        })
        ->addColumn('status', function($row){
            $result = '';
            $result .= '<center>';
            $result .= '<span class="badge rounded-pill bg-primary"> On-going </span>';
            $result .= '</center>';
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function loadIqcInspection(Request $request)
    {
        /*  Transfer the data with whs_transaction.inspection_class = 3 to Inspected Tab
            NOTE: If the data exist to iqc_inspections it means the data is already inspected
        */

        if( isset( $request->lotNum ) ){
            $tbl_iqc_inspected = DB::connection('mysql')
            ->select('
                SELECT *
                FROM iqc_inspections
                WHERE deleted_at IS NULL AND judgement >= 1 AND lot_no = "'.$request->lotNum.'"
                ORDER BY created_at DESC
            ');
        }else{
            $tbl_iqc_inspected = DB::connection('mysql')
            ->select('
                SELECT *
                FROM iqc_inspections
                WHERE deleted_at IS NULL AND judgement >= 1
                ORDER BY created_at DESC
            ');
        }

        return DataTables::of($tbl_iqc_inspected)
        ->addColumn('action', function($row){
            $result = '';
            $result .= '<center>';
            if($row->inspector == Auth::user()->id || Auth::user()->username =='mclegaspi'){
                $result .= "<button class='btn btn-info btn-sm mr-1' iqc-inspection-id='".$row->id."'id='btnEditIqcInspection' inspector='".$row->inspector."'><i class='fa-solid fa-pen-to-square'></i></button>";
            }
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
        ->addColumn('app_ctrl_no', function($row){
            $result = '';
            $result .= $row->app_no . $row->app_no_extension;
            return $result;
        })
        ->addColumn('time_inspected', function($row){
            $result = '';
            $result .= '<center>';
            $result .= $row->time_ins_from.'-'.$row->time_ins_to;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('qc_inspector', function($row){
            $qc_inspector = User::where('id',$row->inspector)->get();
            $result = '';
            $result .= $qc_inspector[0]->firstname .' '. $qc_inspector[0]->lastname;
            return $result;
        })
        ->rawColumns(['action','status','app_ctrl_no','qc_inspector','time_inspected',])
        ->make(true);

    }

    public function getIqcInspectionById(Request $request)
    {
        // return $tbl_whs_trasanction = IqcInspection::where('id',$request->iqc_inspection_id)
        // ->get(['iqc_inspections.id as iqc_inspection_id','iqc_inspections.*']);
        return $tbl_whs_trasanction = IqcInspection::with('IqcInspectionsMods')
        ->where('id',$request->iqc_inspection_id)
        ->get(['iqc_inspections.id as iqc_inspection_id','iqc_inspections.*']);
    }

    public function getWhsReceivingById(Request $request)
    {
        if($request->whs_transaction_id != 0){
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
        if($request->receiving_detail_id != 0){
            return $tbl_whs_trasanction = ReceivingDetails::where('id',$request->receiving_detail_id)->get([
                'id as receiving_detail_id','supplier_pmi_lot_no as lot_no','supplier_quantity as total_lot_qty','part_code as partcode',
                'mat_name as partname','supplier_name as supplier',
            ]);
        }
    }

    public function getFamily()
    {
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

    public function getInspectionLevel()
    {
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

    public function getAql()
    {
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

    public function getLotNumberByWhsTransactionId()
    {
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

    public function getLarDppm()
    {
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

    public function saveIqcInspection(IqcInspectionRequest $request)
    {
        date_default_timezone_set('Asia/Manila');

        try {
            $mod_lot_no = explode(',',$request->lotNo);
            $mod_defects = explode(',',$request->modeOfDefects);
            $mod_lot_qty = explode(',',$request->lotQty);
            $arr_sum_mod_lot_qty = array_sum($mod_lot_qty);

            if(isset($request->iqc_inspection_id)){ //Edit

                $update_iqc_inspection = IqcInspection::where('id', $request->iqc_inspection_id)->update($request->validated());

                IqcInspection::where('id', $request->iqc_inspection_id)
                ->update([
                    'no_of_defects' => $arr_sum_mod_lot_qty,
                    'remarks' => $request->remarks,
                    'inspector' => Auth::user()->id,
                ]);

                $iqc_inspections_id = $request->iqc_inspection_id;
            }else{ //Add
                /* All required fields is the $request validated, check the column is IqcInspectionRequest
                    NOTE: the name of fields must be match in column name
                */
                $create_iqc_inspection = IqcInspection::create($request->validated());
                /*  All not required fields should to be inside the update method below
                    NOTE: the name of fields must be match in column name
                */
                // return 'true';
                IqcInspection::where('id', $create_iqc_inspection->id)
                ->update([
                    'no_of_defects' => $arr_sum_mod_lot_qty,
                    'remarks' => $request->remarks,
                    'inspector' => Auth::user()->id,
                ]);

                /* Update rapid/db_pps TblWarehouseTransaction, set inspection_class to 3 */
                if($request->whs_transaction_id != 0){
                    TblWarehouseTransaction::where('pkid', $request->whs_transaction_id)
                    ->update([
                        'inspection_class' => 3,
                    ]);
                }
                /* Update status ReceivingDetails into 2*/
                if($request->receiving_detail_id != 0){
                    ReceivingDetails::where('id', $request->receiving_detail_id)
                    ->update([
                        'status' => 2,
                    ]);
                }
                $iqc_inspections_id = $create_iqc_inspection->id;
            }
            /* Uploading of file if checked & iqc_coc_file is exist*/
            if(isset($request->iqc_coc_file) ){
                $original_filename = $request->file('iqc_coc_file')->getClientOriginalName(); //'/etc#hosts/@Álix Ãxel likes - beer?!.pdf';
                $filtered_filename = '_'.$this->Slug($original_filename, '_', '.');	 // _etc_hosts_alix_axel_likes_beer.pdf
                Storage::putFileAs('public/iqc_inspection_coc', $request->iqc_coc_file,  $iqc_inspections_id . $filtered_filename);

                IqcInspection::where('id', $iqc_inspections_id)
                ->update([
                    'iqc_coc_file' => $filtered_filename,
                    'iqc_coc_file_name' => $original_filename
                ]);
            }

            /* Get iqc_inspections_id, delete the previos MOD then  save new MOD*/
            if(isset($request->modeOfDefects)){
                IqcInspectionsMod::where('iqc_inspection_id', $iqc_inspections_id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
                foreach ( $mod_lot_no as $key => $value) {
                    IqcInspectionsMod::insert([
                        'iqc_inspection_id'    => $iqc_inspections_id,
                        'lot_no'                => $mod_lot_no[$key],
                        'mode_of_defects'       => $mod_defects[$key],
                        'quantity'              => $mod_lot_qty[$key],
                        'created_at'            => date('Y-m-d H:i:s')
                    ]);
                }
            }else{
                if(IqcInspectionsMod::where('iqc_inspection_id', $iqc_inspections_id)->exists()){
                    IqcInspectionsMod::where('iqc_inspection_id', $iqc_inspections_id)->update([
                        'deleted_at' => date('Y-m-d H:i:s')
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

    public function viewCocFileAttachment(Request $request,$iqc_inspection_id)
    {
        $iqc_coc_file_name = IqcInspection::where('id',$iqc_inspection_id)->get('iqc_coc_file');
        return Storage::response( 'public/iqc_inspection_coc/' . $iqc_inspection_id . $iqc_coc_file_name[0][ 'iqc_coc_file' ] );
    }

    public function Slug($string, $slug = '-', $extra = null)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z' . preg_quote($extra, '~') . ']+~i', $slug, $this->Unaccent($string)), $slug));
	}

	public function Unaccent($string) // normalizes (romanization) accented chars
	{
		if (strpos($string = htmlentities($string, ENT_QUOTES, 'UTF-8'), '&') !== false)
		{
			$string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $string), ENT_QUOTES, 'UTF-8');
		}
		return $string;
	}

}

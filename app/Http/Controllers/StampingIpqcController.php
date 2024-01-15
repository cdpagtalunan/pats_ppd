<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use DataTables;
use App\Models\StampingIpqc;
use App\Models\FirstStampingProduction;

use App\Exports\Export;
use Maatwebsite\Excel\Facades\Excel;

class StampingIpqcController extends Controller
{
    public function view_stamping_ipqc_data(Request $request){
        if(!isset($request->po_number)){
            return [];
        }else{
            // if(StampingIpqc::where('po_number', $request->po_number)->where('logdel', 0)->exists()){
            //     $ipqc_data = StampingIpqc::where('po_number', $request->po_number)->where('logdel', 0)->get();
            // }else{
            //     $ipqc_data = [];
            // }
            // return $ipqc_data;
            $first_stamping_data = FirstStampingProduction::whereNull('deleted_at')
                                    ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'firstname', 'lastname', 'username'); }])
                                    ->where('po_num', $request->po_number)
                                    // ->when($ipqc_data != [], function ($query){
                                    //     return $query ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'firstname', 'lastname', 'username'); }]);
                                    // })
                                    // ->when($ipqc_data != [], function ($query) use ($ipqc_data){
                                    //     return $query ->where('prod_lot_no', $ipqc_data->prod_lot_no);
                                    // })
                                    ->get();

            // mapping
            // if($ipqc_data == []){
            //     $first_stamping_data = $first_stamping_data->map(function ($item){
            //         $item->stamping_ipqc_data = 0;
            //         return $item;
            //     });
            // }
            // return $first_stamping_data;
            //mapping
            // $first_stamping_data_mapped = $first_stamping_data->map(function ($item){
            //     $item->stamping_ipqc = {};

            //     // $item->stamping_ipqc['test1'] = 1;
            //     // $item->stamping_ipqc->status = 0;
            //         $item->stamping_ipqc->map(function ($nestedItem) {
            //             $nestedItem->id = 0;
            //             return $nestedItem;
            //         });
            //     return $item;
            // });

            return DataTables::of($first_stamping_data)
            ->addColumn('action', function($first_stamping_data){
                if(!isset($first_stamping_data->stamping_ipqc)){
                    $stamping_ipqc_id = 0;
                }else{
                    $stamping_ipqc_id = $first_stamping_data->stamping_ipqc->id;
                }
                // $stamping_ipqc = $first_stamping_data->stamping_ipqc;
                // $stamping_ipqc_id = 0;
                $result = "";
                $result .= "<center>";
                if($stamping_ipqc_id != 0 && $first_stamping_data->stamping_ipqc->status != 0){ //Exsisting IPQC ID: Ready to view
                    $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-eye' data-bs-html='true' title='View IPQC Inspection'></i></button>";
                }
                if($stamping_ipqc_id == 0 || $first_stamping_data->stamping_ipqc->status != 3){
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-microscope' data-bs-html='true' title='Proceed to IPQC Inspection'></i></button>";
                }
                if($stamping_ipqc_id != 0 && $first_stamping_data->stamping_ipqc->status != 3 && $first_stamping_data->stamping_ipqc->judgement == "Accepted"){ //Exsisting IPQC ID: Ready to Submit
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-success btn-sm btnSubmitIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-circle-check' data-bs-html='true' title='Proceed to Mass Production'></i></button>";
                }
                // else if($stamping_ipqc_id != 0 && $first_stamping_data->stamping_ipqc->status != 3 && $first_stamping_data->stamping_ipqc->judgement == "Rejected"){
                //     $result .= "&nbsp";
                //     $result .= "<button class='btn btn-warning btn-sm btnSubmitIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                //                 <i class='fa-solid fa-triangle-exclamation' data-bs-html='true' title='Save Rejected QC Sample'></i></button>";
                // }
                $result .= "</center>";
                return $result;
            })
            ->addColumn('ipqc_status', function ($first_stamping_data) {
                $result = "";
                if(!isset($first_stamping_data->stamping_ipqc->status)){
                    $status = 0;
                }else{
                    $status = $first_stamping_data->stamping_ipqc->status;
                }
                switch($status){
                    case 0: //Default Value: Not Yet Inpected or Inserted Data But Not Updated = Not Ready
                        $result .= '<center><span class="badge badge-pill badge-info">For IPQC Inspection</span></center>';
                        break;
                    case 1: //Updated:(J)Accepted
                        $result .= '<center><span class="badge badge-pill badge-primary">Accepted QC Sample</span></center>';
                        break;
                    case 2: //Updated:(J)Rejected
                        $result .= '<center><span class="badge badge-pill badge-warning">Rejected QC Sample</span></center>';
                        break;
                    case 3: //Completed IPQC Inspection
                        $result .= '<center><span class="badge badge-pill badge-success">Done IPQC Inspection</span></center>';
                        break;
                }
                return $result;
            })
            ->addColumn('ipqc_judgement', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->judgement)){
                    $stamping_ipqc = $first_stamping_data->stamping_ipqc;
                    if($stamping_ipqc->judgement == 'Accepted'){
                        $result .= "<center><span class='badge badge-pill badge-success'>$stamping_ipqc->judgement</span></center>";
                    }else if($stamping_ipqc->judgement == 'Rejected'){
                        $result .= "<center><span class='badge badge-pill badge-warning'>$stamping_ipqc->judgement</span></center>";
                    }
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })
            ->addColumn('ipqc_inspector_name', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->ipqc_insp_name)){
                    $result = $first_stamping_data->stamping_ipqc->ipqc_insp_name->firstname.' '.$first_stamping_data->stamping_ipqc->ipqc_insp_name->lastname;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })
            ->addColumn('ipqc_document_no', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->ipqc_insp_name)){
                    $result = $first_stamping_data->stamping_ipqc->document_no;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })
            ->addColumn('ipqc_measdata_attachment', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->ipqc_insp_name)){
                    $result = $first_stamping_data->stamping_ipqc->measdata_attachment;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })
            ->addColumn('ipqc_inspected_date', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->updated_at)){
                    $result = $first_stamping_data->stamping_ipqc->updated_at;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })

            ->rawColumns(['action','ipqc_status','ipqc_judgement','ipqc_inspector_name','ipqc_document_no','ipqc_measdata_attachment','ipqc_inspected_date'])
            ->make(true);
        }
    }
    public function get_data_from_fs_production(Request $request){
        // return $request->all();
        $data = FirstStampingProduction::select('id','po_num','part_code','material_name','material_lot_no','prod_lot_no','qc_samp','status')
                                        ->whereNull('deleted_at')
                                        // ->where('status', 0)
                                        ->when($request->po_number, function ($query) use ($request){
                                            return $query ->where('po_num', $request->po_number);
                                        })
                                        ->when($request->fs_prod_id, function ($query) use ($request){
                                                return $query ->where('id', $request->fs_prod_id);
                                        })
                                        ->when($request->stamping_ipqc_id, function ($query) use ($request){
                                            return $query ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'firstname', 'lastname', 'username'); }]);
                                        })
                                        ->get();

        // mapping
        if($request->stamping_ipqc_id == 0){
            $data_mapped = $data->map(function ($item){
                $item->stamping_ipqc_data = 0;
                $item->ipqc_inspector_id = Auth::user()->id;
                $item->ipqc_inspector_name = Auth::user()->firstname.' '.Auth::user()->lastname;
                return $item;
            });
        }else{
            $data_mapped = $data;
        }

        // return $first_stamping_data_mapped;

        return response()->json(['fs_production_data' => $data_mapped]);
    }
    // public function get_po_from_pps_db(Request $request){

    //     // $po_receive_data = DB::connection('mysql_rapid_pps')
    //     // ->select("
    //     //     SELECT * FROM tbl_POReceived WHERE OrderNo = $request->po
    //     // ");
    //     // if($po_receive_data == ""){
    //     //     return response()->json([
    //     //         'msg' => 'No Data for selected PO'
    //     //     ]);
    //     // }

    //     $get_drawing = DB::connection('mysql_rapid_stamping_dmcms')
    //     ->select("SELECT * FROM tbl_device WHERE `device_code` = '".$request->item_code."'");

    //     // return response()->json([
    //     //     // 'poReceiveData' => $po_receive_data,
    //     //     'drawings'      => $get_drawing[0]
    //     // ]);
    //     return $get_drawing[0];
    // }

    public function add_ipqc_inspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        // return $request->all();
        $data = $request->all();
        // $password = "pmi12345";
        // return $request->uploaded_file;
        $validator = Validator::make($data, [
            'document_no' => 'required',
            'uploaded_file' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        } else {
                $original_filename = $request->file('uploaded_file')->getClientOriginalName();
            // if(isset($_SESSION["rapidx_user_id"])){
                if($request->stamping_ipqc_id == 0){

                    if(StampingIpqc::where('measdata_attachment', $original_filename)->where('logdel', 0)->exists()){
                        return response()->json(['result' => 'File Name Already Exists']);
                    }else{
                        // return $original_filename;
                        Storage::putFileAs('public/stamping_ipqc_inspection_attachments', $request->uploaded_file,  $original_filename);
                        StampingIpqc::insert(['fs_productions_id'     => $request->first_stamping_prod_id,
                                                'po_number'           => $request->po_number,
                                                'part_code'           => $request->part_code,
                                                'material_name'       => $request->material_name,
                                                'prod_lot_no'         => $request->production_lot,
                                                'judgement'           => $request->judgement,
                                                'input'               => $request->input,
                                                'output'              => $request->output,
                                                'ipqc_inspector_name' => $request->inspector_id,
                                                'document_no'         => $request->document_no,
                                                'measdata_attachment' => $original_filename,
                                                'created_by'          => Auth::user()->id,
                                                'last_updated_by'     => Auth::user()->id,
                                                'created_at'          => date('Y-m-d H:i:s'),
                                                'updated_at'          => date('Y-m-d H:i:s'),
                        ]);

                        DB::commit();
                        return response()->json(['result' => 'Insert Successful']);
                    }
                }else{
                    Storage::putFileAs('public/stamping_ipqc_inspection_attachments', $request->uploaded_file,  $original_filename);
                    if($request->judgement == "Accepted"){
                        $status = 1;
                    }else if($request->judgement == "Rejected"){
                        $status = 2;
                    }
                    StampingIpqc::where('id', $request->stamping_ipqc_id)
                            ->update([
                                'judgement'           => $request->judgement,
                                'input'               => $request->input,
                                'output'              => $request->output,
                                'ipqc_inspector_name' => $request->inspector_id,
                                'document_no'         => $request->document_no,
                                'measdata_attachment' => $original_filename,
                                'status'              => $status,
                                'last_updated_by'     => Auth::user()->id,
                                'updated_at'          => date('Y-m-d H:i:s'),
                            ]);

                        DB::commit();
                        return response()->json(['result' => 'Update Successful']);
                }
            // }else{
            //     return response()->json(['result' => 'Session Expired']);
            // }
        }
    }

    public function update_status_of_ipqc_inspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        // session_start();
            StampingIpqc::where('id', $request->stamping_ipqc_insp_id)
                    ->update([
                        'status'              => 3,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

            // if($request->status == 1){
                FirstStampingProduction::where('id', $request->fs_productions_id)
                ->update(['status' => 1]);
            // }

                    DB::commit();
        return response()->json(['result' => 'Successful']);
    }

    public function get_data_from_acdcs(Request $request){
        $acdcs_data = DB::connection('mysql_rapid_acdcs')
        ->select("SELECT * FROM tbl_active_docs WHERE `model` LIKE '%".$request->model."%' AND `doc_type` = '".$request->doc_type."'");
        // doc_no
        // return $acdcs_data;
        return response()->json(['acdcs_data' => $acdcs_data]);
    }

    //====================================== DOWNLOAD FILE ======================================
    public function download_file(Request $request, $id){
        $ipqc_data_for_download = StampingIpqc::where('id', $id)->first();
        $file =  storage_path() . "/app/public/stamping_ipqc_inspection_attachments/" . $ipqc_data_for_download->measdata_attachment;
        // $headers = array(
        //     'Content-Type: application/octet-stream',
        //   );
        return Response::download($file, $ipqc_data_for_download->measdata_attachment);
    }

    public function excel(Request $month)
    {
    //   //16.123 GET PAPER PAST FY TARGET FOR SG
    //   $Paper_PastFyTarget_SG = MonthlyTargetPaperConsumption::where('fiscal_year_id', $CurrentFY)->sum('data_monthly_target');
    //   $Paper_PastFyTarget_SG_Ream = $Paper_PastFyTarget_SG / 500;

    //   //1.123 GET ENERGY PAST FY TARGET ALL ==================
    //   $Energy_PastFyTarget = EnergyConsumption::where('fiscal_year_id', $pastFy)->avg('target');
    //   // $Energy_PastFyActual_ave = $Energy_PastFyActual->avg('actual');
    //   $Energy_PastFyTarget_Average = number_format((float)$Energy_PastFyTarget, 2, '.', '');

    //   //6 - 6.a GET WATER PAST FY TARGET ALL ==================
    //   $Water_PastFyTarget_Total = WaterConsumption::where('fiscal_year_id', $pastFy)->get();
    //   $Water_PastFyTarget_Average = $Water_PastFyTarget_Total->avg('target');
    //   $Water_PastFyTarget_Average = number_format((float)$Water_PastFyTarget_Average, 2, '.', '');

    //   $ActionPlan_array = array();
    //   for($i = 0; $i < count(ActionPlan::where('fiscal_year_id', $CurrentFY)->get()) ; $i++) {
    //   $ActionPlan[$i] = ActionPlan::where('fiscal_year_id', $CurrentFY)->where('logdel', 0)->get();
    //   $ActionPlan_array = $ActionPlan[$i];

    //   // return $ActionPlan_array;
    //   }

        // $packing_list = ;
      return Excel::download(new Export(

        //   $pastFy_year,
        //   $Paper_PastFyTarget_Prod_Ream,
        //   $Paper_PastFyTarget_SG_Ream,
        //   $Energy_PastFyTarget_Average,
        //   $Water_PastFyTarget_Average,
        //   $ActionPlan_array

          ),
          'Packing List.xlsx');
    }
}

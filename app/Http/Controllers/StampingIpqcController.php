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
use Carbon\Carbon;
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
            $first_stamping_data = FirstStampingProduction::whereNull('deleted_at')
                                    ->whereIn('status', $request->fs_prod_status)
                                    ->where('stamping_cat', $request->fs_prod_stamping_cat)
                                    ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'firstname', 'lastname', 'username'); },
                                            'stamping_ipqc' => function($query) use ($request) { $query->whereIn('status', $request->ipqc_status); }])
                                    ->where('po_num', $request->po_number)
                                    ->get();

            return DataTables::of($first_stamping_data)
            ->addColumn('action', function($first_stamping_data){
                if(!isset($first_stamping_data->stamping_ipqc)){
                    $stamping_ipqc_id = 0;
                    $stamping_ipqc_status = 0;
                }else{
                    $stamping_ipqc_id = $first_stamping_data->stamping_ipqc->id;
                    $stamping_ipqc_status = $first_stamping_data->stamping_ipqc->status;
                }
                $result = "";
                $result .= "<center>";
                if($stamping_ipqc_id != 0){ //Exsisting IPQC ID: Ready to view
                    $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-eye' data-bs-html='true' title='View IPQC Inspection'></i></button>";
                }

                if($stamping_ipqc_id == 0 || $stamping_ipqc_status < 3){ //Not Exsisting IPQC ID or Status less than 3(0 - Pending, 1,2 - Updated): Enabled Updating
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' ipqc_data-status='$stamping_ipqc_status' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-microscope' data-bs-html='true' title='Proceed to IPQC Inspection'></i></button>";
                }else if($stamping_ipqc_id != 0 && $stamping_ipqc_status == 5){ //Exsisting IPQC ID & Status 5(For Resetup): Enabled Updating
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' ipqc_data-status='$stamping_ipqc_status' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-microscope' data-bs-html='true' title='Proceed to Re-Inspection'></i></button>";
                }

                if($stamping_ipqc_id != 0 && $stamping_ipqc_status == 1 ){ //Exsisting IPQC ID & Status 1(Accepted): Ready to Submit
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-success btn-sm btnSubmitIPQCData' ipqc_data-status='$stamping_ipqc_status' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-circle-check' data-bs-html='true' title='Proceed to Mass Production'></i></button>";
                }
                else if($stamping_ipqc_id != 0 && $stamping_ipqc_status == 2){ //Exsisting IPQC ID & Status 2(Rejected): Ready to Submit
                    $result .= "&nbsp";
                    $result .= "<button class='btn btn-warning btn-sm btnSubmitIPQCData' ipqc_data-status='$stamping_ipqc_status' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc_id'>
                                <i class='fa-solid fa-triangle-exclamation' data-bs-html='true' title='Save Rejected QC Sample'></i></button>";
                }
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
                    case 4: //Completed IPQC Inspection
                        $result .= '<center><span class="badge badge-pill badge-warning">For Re-Setup</span></center>';
                        break;
                    case 5: //Completed IPQC Inspection
                        $result .= '<center><span class="badge badge-pill badge-info">For Re-Inspection</span></center>';
                        break;
                }
                return $result;
            })
            ->addColumn('fs_prod_created_at', function ($first_stamping_data) {
                $result = "";
                $result = Carbon::parse($first_stamping_data->created_at);
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
            // $result = Carbon::parse($ink_consumption->created_at)->year;
            ->addColumn('ipqc_inspected_date', function ($first_stamping_data) {
                $result = "";
                if(isset($first_stamping_data->stamping_ipqc->updated_at)){
                    $result = $first_stamping_data->stamping_ipqc->updated_at;
                }else{
                    $result .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result;
            })

            ->rawColumns(['action','ipqc_status','fs_prod_created_at','ipqc_judgement','ipqc_inspector_name','ipqc_document_no','ipqc_measdata_attachment','ipqc_inspected_date'])
            ->make(true);
        }
    }

    public function get_po_from_fs_production(Request $request){
        $fs_production_po = FirstStampingProduction::select('po_num')
                                        ->whereNull('deleted_at')
                                        ->where('stamping_cat', $request->stamping_cat)
                                        ->distinct()
                                        ->get();

        return response()->json(['fs_production_po' => $fs_production_po]);
    }

    public function get_data_from_fs_production(Request $request){
        $data = FirstStampingProduction::select('id','stamping_cat','po_num','part_code','material_name','material_lot_no','prod_lot_no','qc_samp','status')
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
                                        ->when($request->stamping_cat, function ($query) use ($request){ //parameter for PO selection
                                            return $query ->where('stamping_cat', $request->stamping_cat)->distinct();
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

        return response()->json(['fs_production_data' => $data_mapped]);
    }

    public function add_ipqc_inspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();
        // $password = "pmi12345";
        // return $data;

                if($request->stamping_ipqc_id == 0){

                    $validator = Validator::make($data, [

                        'doc_no_b_drawing' => 'required',
                        'doc_no_inspection_standard' => 'required',
                        'doc_no_ud' => 'required',
                        'uploaded_file' => 'required',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
                    }else {
                        $original_filename = $request->file('uploaded_file')->getClientOriginalName();
                            if($request->judgement == "Accepted"){
                                $status = 1;
                            }else if($request->judgement == "Rejected"){
                                $status = 2;
                            }
                            Storage::putFileAs('public/stamping_ipqc_inspection_attachments', $request->uploaded_file,  $original_filename);
                            StampingIpqc::insert(['fs_productions_id'         => $request->first_stamping_prod_id,
                                                    'stamping_cat'            => $request->stamping_category,
                                                    'po_number'               => $request->po_number,
                                                    'part_code'               => $request->part_code,
                                                    'material_name'           => $request->material_name,
                                                    'prod_lot_no'             => $request->production_lot,
                                                    'judgement'               => $request->judgement,
                                                    'input'                   => $request->input,
                                                    'output'                  => $request->output,
                                                    'ipqc_inspector_name'     => $request->inspector_id,
                                                    'keep_sample'             => $request->keep_sample,
                                                    'doc_no_b_drawing'        => $request->doc_no_b_drawing,
                                                    'doc_no_insp_standard'    => $request->doc_no_inspection_standard,
                                                    'doc_no_urgent_direction' => $request->doc_no_ud,
                                                    'measdata_attachment'     => $original_filename,
                                                    'status'                  => $status,
                                                    'created_by'              => Auth::user()->id,
                                                    'last_updated_by'         => Auth::user()->id,
                                                    'created_at'              => date('Y-m-d H:i:s'),
                                                    'updated_at'              => date('Y-m-d H:i:s'),
                            ]);

                            DB::commit();
                            return response()->json(['result' => 'Insert Successful']);
                    }
                }else{
                    if(isset($request->uploaded_file)){
                        $original_filename = $request->file('uploaded_file')->getClientOriginalName();
                            Storage::putFileAs('public/stamping_ipqc_inspection_attachments', $request->uploaded_file,  $original_filename);
                    }else{
                        $original_filename = $request->re_uploaded_file;
                    }

                    if($request->judgement == "Accepted"){
                        $status = 1;
                    }else if($request->judgement == "Rejected"){
                        $status = 2;
                    }

                    StampingIpqc::where('id', $request->stamping_ipqc_id)
                            ->update([
                                'judgement'               => $request->judgement,
                                'input'                   => $request->input,
                                'output'                  => $request->output,
                                'ipqc_inspector_name'     => $request->inspector_id,
                                'keep_sample'             => $request->keep_sample,
                                'doc_no_b_drawing'        => $request->doc_no_b_drawing,
                                'doc_no_insp_standard'    => $request->doc_no_inspection_standard,
                                'doc_no_urgent_direction' => $request->doc_no_ud,
                                'measdata_attachment'     => $original_filename,
                                'status'                  => $status,
                                'last_updated_by'         => Auth::user()->id,
                                'updated_at'              => date('Y-m-d H:i:s'),
                            ]);

                        DB::commit();
                        return response()->json(['result' => 'Update Successful']);
                        // }
                }

    }

    public function update_status_of_ipqc_inspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        // session_start();
            if($request->stamping_ipqc_status == 1){
                //For Mass Production
                $fs_prod_status = 1;
                $ipqc_status = 3;

            }else if($request->stamping_ipqc_status == 2){
                //For Re-Setup
                $fs_prod_status = 3;
                $ipqc_status = 4;
            }
            StampingIpqc::where('id', $request->stamping_ipqc_id)
                    ->update([
                        'status'              => $ipqc_status,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

            // if($request->status == 1){
                FirstStampingProduction::where('id', $request->fs_productions_id)
                ->update(['status' => $fs_prod_status]);
            // }

                    DB::commit();
        return response()->json(['result' => 'Successful']);
    }

    public function get_data_from_acdcs(Request $request){
        $acdcs_data = DB::connection('mysql_rapid_acdcs')
        // ->select("SELECT * FROM tbl_active_docs WHERE `model` LIKE '%".$request->model."%' AND `doc_type` = '".$request->doc_type."'");
        // ->select("SELECT * FROM tbl_active_docs WHERE `model` LIKE '%".$request->model."%' AND `doc_type` = '".$request->doc_type."' AND `originator_code` = 'PPS'");
        ->select("SELECT `doc_no`,`doc_type` FROM tbl_active_docs WHERE `doc_type` = '".$request->doc_type."' AND `doc_title` LIKE '%".$request->doc_title."%'");
        // ->select("SELECT * FROM tbl_active_docs WHERE `model` LIKE '%".$request->model."%' AND `doc_type` IN ('B Drawing', 'Inspection Standard', 'Urgent Direction') AND `originator_code` = 'PPS'");
        // doc_no
        // return $acdcs_data;
        return response()->json(['acdcs_data' => $acdcs_data]);
    }

    //====================================== DOWNLOAD FILE ======================================
    public function download_file(Request $request, $id){
        $ipqc_data_for_download = StampingIpqc::where('id', $id)->first();
        $file =  storage_path() . "/app/public/stamping_ipqc_inspection_attachments/" . $ipqc_data_for_download->measdata_attachment;
        return Response::download($file, $ipqc_data_for_download->measdata_attachment);
    }

    public function excel(Request $month)
    {
      return Excel::download(new Export(

          ),
          'Packing List.xlsx');
    }

}

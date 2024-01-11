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

class StampingIpqcController extends Controller
{
    public function view_stamping_ipqc_data(Request $request){
        // $ipqc_data = StampingIpqc::with('first_stamping_production')->select('fs_productions_id','ipqc_inspector_name','status')
        //                             ->where('fs_productions_id', $first_stamping_data_orig[0]->id )
        //                             ->where('logdel', 0)
        //                             ->get();
        if(!isset($request->po_number)){
            return [];
        }else{
            // if(StampingIpqc::where('po_number', $request->po_number)->exists`)
            $ipqc_data = StampingIpqc::when($request->po_number, function ($query) use ($request){
                return $query ->where('po_number', $request->po_number);
            })
            ->where('logdel', 0)->get();

            // return $ipqc_data;

            // if($ipqc_data == ''){
                // $ipqc_data = '1';
            // }

            // return $ipqc_data;

            $first_stamping_data = FirstStampingProduction::when($ipqc_data, function ($query){
                return $query ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'firstname', 'lastname', 'username'); }]);
            })
            ->when($ipqc_data, function ($query) use ($ipqc_data){
                return $query ->where('id', $ipqc_data[0]->fs_productions_id);
            })
            ->whereNull('deleted_at')
            ->when($request->po_number, function ($query) use ($request){
                    return $query ->where('po_num', $request->po_number);
            })
            ->get();

            // $first_stamping_data['add_data'] = '1';
            return $first_stamping_data;

            return DataTables::of($first_stamping_data)
            ->addColumn('action', function($first_stamping_data){
                // if($first_stamping_data->stamping_ipqc){

                // }
                $stamping_ipqc = $first_stamping_data->stamping_ipqc;
                $result = "";
                $result .= "<center>";
                $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc->id'><i class='fa-solid fa-eye'></i></button>";
                $result .= "&nbsp;";
                // $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' data-bs-toggle='modal' data-bs-target='#modalIpqcInspection' data-id='$stamping_ipqc->id'><i class='fa-solid fa-file-pen'></i></button>";
                $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' fs_prod_data-id='$first_stamping_data->id' ipqc_data-id='$stamping_ipqc->id'><i class='fa-solid fa-file-pen'></i></button>";
                $result .= "</center>";
                return $result;
            })

            ->addColumn('ipqc_status', function ($first_stamping_data) {
                $result1 = "";
                switch($first_stamping_data->stamping_ipqc->status){
                    case 0: //Pending
                        $result1 .= '<center><span class="badge badge-pill badge-warning">Pending</span></center>';
                        break;
                    case 1: //Completed
                        $result1 .= '<center><span class="badge badge-pill badge-success">Completed</span></center>';
                        break;
                }
                return $result1;
            })
            ->addColumn('ipqc_inspector_name', function ($first_stamping_data) {
                $result2 = "";
                if(isset($first_stamping_data->stamping_ipqc)){
                    $result2 = $first_stamping_data->stamping_ipqc->ipqc_insp_name->firstname.' '.$first_stamping_data->stamping_ipqc->ipqc_insp_name->lastname;
                }else{
                    $result2 .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result2;
            })
            ->addColumn('ipqc_inspected_date', function ($first_stamping_data) {
                $result3 = "";
                if(isset($first_stamping_data->stamping_ipqc)){
                    $result3 = $first_stamping_data->stamping_ipqc->updated_at;
                }else{
                    $result3 .= '<center><span class="badge badge-pill badge-secondary">Not Yet Inspected</span></center>';
                }
                return $result3;
            })

            ->rawColumns(['action','ipqc_status','ipqc_inspector_name','ipqc_inspected_date'])
            ->make(true);
        }
    }

    public function get_po_from_pps_db(Request $request){

        // $po_receive_data = DB::connection('mysql_rapid_pps')
        // ->select("
        //     SELECT * FROM tbl_POReceived WHERE OrderNo = $request->po
        // ");
        // if($po_receive_data == ""){
        //     return response()->json([
        //         'msg' => 'No Data for selected PO'
        //     ]);
        // }

        $get_drawing = DB::connection('mysql_rapid_stamping_dmcms')
        ->select("SELECT * FROM tbl_device WHERE `device_code` = '".$request->item_code."'");

        // return response()->json([
        //     // 'poReceiveData' => $po_receive_data,
        //     'drawings'      => $get_drawing[0]
        // ]);
        return $get_drawing[0];
    }

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
            // if(isset($_SESSION["rapidx_user_id"])){
                if(!isset($request->id)){
                    $original_filename = $request->file('uploaded_file')->getClientOriginalName();

                    if(StampingIpqc::where('measdata_attachment', $original_filename)->exists()){
                        return response()->json(['result' => 'File Name Already Exists']);
                    }else{
                        // return $original_filename;
                        Storage::putFileAs('public/stamping_ipqc_inspection_attachments', $request->uploaded_file,  $original_filename);
                        StampingIpqc::insert(['fs_production_id'      => $request->first_stamping_prod_id,
                                                'po_number'           => $request->po_num,
                                                'part_code'           => $request->part_code,
                                                'material_name'       => $request->material_name,
                                                'ipqc_inspector_name' => $request->inspector_id,
                                                'document_no'         => $request->document_no,
                                                'measdata_attachment' => $original_filename,
                                                'created_by'          => Auth::user()->id,
                                                'last_updated_by'     => Auth::user()->id,
                                                'created_at'          => date('Y-m-d H:i:s'),
                                                'updated_at'          => date('Y-m-d H:i:s'),
                        ]);

                        DB::commit();
                        return response()->json(['result' => 'Success']);
                    }
                }else{
                    StampingIpqc::where('id', $request->stamping_ipqc_id)
                            ->update([
                                'ipqc_inspector_name' => $request->inspector_id,
                                'document_no'         => $request->document_no,
                                'measdata_attachment' => $request->uploaded_file,
                                'status'              => 1,
                                'last_updated_by'     => Auth::user()->id,
                                'updated_at'          => date('Y-m-d H:i:s'),
                            ]);

                        DB::commit();
                        return response()->json(['result' => 'Success']);
                }
            // }else{
            //     return response()->json(['result' => 'Session Expired']);
            // }
        }
    }

    public function get_data_from_acdcs(Request $request){
        $acdcs_data = DB::connection('mysql_rapid_acdcs')
        ->select("SELECT * FROM tbl_active_docs WHERE `model` LIKE '%".$request->model."%' AND `doc_type` = '".$request->doc_type."'");
        // doc_no
        // return $acdcs_data;
        return response()->json(['acdcs_data' => $acdcs_data]);
    }
}

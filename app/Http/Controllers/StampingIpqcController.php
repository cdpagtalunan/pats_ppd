<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            $ipqc_data = StampingIpqc::when($request->po_number, function ($query) use ($request){
                return $query ->where('po_number', $request->po_number);
            })
            ->where('logdel', 0)->get();

            $first_stamping_data = FirstStampingProduction::when($ipqc_data, function ($query){
                return $query ->with(['stamping_ipqc.ipqc_insp_name' => function($query) { $query->select('id', 'name'); }]);
            })
            ->when($ipqc_data, function ($query) use ($ipqc_data){
                return $query ->where('id', $ipqc_data[0]->fs_productions_id);
            })
            ->whereNull('deleted_at')
            ->when($request->po_number, function ($query) use ($request){
                    return $query ->where('po_num', $request->po_number);
            })
            ->get();

            return DataTables::of($first_stamping_data)
            ->addColumn('action', function($first_stamping_data){
                $stamping_ipqc = $first_stamping_data->stamping_ipqc;
                $result = "";
                $result .= "<center>";
                $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' data-id='$stamping_ipqc->id'><i class='fa-solid fa-eye'></i></button>";
                $result .= "&nbsp;";
                $result .= "<button class='btn btn-primary btn-sm btnUpdateIPQCData' data-bs-toggle='modal' data-bs-target='#modalIpqcInspection' data-id='$stamping_ipqc->id'><i class='fa-solid fa-file-pen'></i></button>";
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
                    $result2 = $first_stamping_data->stamping_ipqc->ipqc_insp_name->name;
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
}

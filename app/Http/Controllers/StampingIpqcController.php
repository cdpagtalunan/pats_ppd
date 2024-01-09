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
        $first_stamping_data_orig = FirstStampingProduction::
                            // with('first_stamping_production')
                            whereNull('deleted_at')
                            ->where('po_num', $request->po_number)
                            // ->when($request->po_number, function ($query) use ($request) {
                            //     return $query ->where('po_num', 'like', '%-'.$request->po_number.'-%');
                            // })
                            ->get();

                            // return $first_stamping_data_orig;

        if(isset($first_stamping_data_orig)){
            $ipqc_data = StampingIpqc::select('fs_productions_id','ipqc_inspector_name','status')->where('fs_productions_id', $first_stamping_data_orig[0]->id )->where('logdel', 0)->get();
            // $first_stamping_data = $first_stamping_data->concat;
            // return $ipqc_data[0]->fs_productions_id;
            // $first_stamping_data_orig.push()
            // for($i = 0; $i < $ipqc_data->count(); $i++){
                array_push($first_stamping_data_orig, $ipqc_data[0]->fs_productions_id);
                array_push($first_stamping_data_orig, $ipqc_data[0]->ipqc_inspector_name);
                array_push($first_stamping_data_orig, $ipqc_data[0]->status);

                $first_stamping_data_orig = $first_stamping_data_orig->push(new Game(['fs_productions_id' => $ipqc_data[0]->fs_productions_id,
                                                                                      'ipqc_inspector_name' => $ipqc_data[0]->ipqc_inspector_name,
                                                                                      'status' => $ipqc_data[0]->status]));
            // }
            // array_push($first_stamping_data_orig, $ipqc_data);
            // $first_stamping_data = $first_stamping_data_orig->merge($ipqc_data);
        }
        return $first_stamping_data_orig;

        return DataTables::of($first_stamping_data)
        ->addColumn('action', function($first_stamping_data){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' data-id='$first_stamping_data->id'><i class='fa-solid fa-eye'></i></button>";
            $result .= "&nbsp;";
            $result .= "<button class='btn btn-info btn-sm btnUpdateIPQCData' data-id='$first_stamping_data->id'><i class='fa-solid fa-file-pen'></i></button>";
            $result .= "</center>";
            return $result;
        })
        // ->addColumn('status', function($first_stamping_data){
        //     $result = "";
        //     $result .= "<center>";
        //     $result .= "<button class='btn btn-info btn-sm btnViewIPQCData' data-id='$first_stamping_data->id'><i class='fa-solid fa-eye'></i></button>";
        //     $result .= "&nbsp;";
        //     $result .= "<button class='btn btn-info btn-sm btnUpdateIPQCData' data-id='$first_stamping_data->id'><i class='fa-solid fa-file-pen'></i></button>";
        //     $result .= "</center>";
        //     return $result;
        // })
        ->rawColumns(['action'])
        ->make(true);
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

<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use QrCode;
use DataTables;
use App\Models\AssemblyOqcLotApp;
use App\Models\AssemblyOqcLotAppSummary;
use App\Models\AssemblyFvi;
use App\Models\Device;
use App\Models\User;

class AssemblyOqcLotAppController extends Controller
{
    public function get_user_name(Request $request){
        $user = User::where('employee_id', $request->user_id)
                    ->where('status', 1)
                    ->first();

        // return $user;
        return response()->json(['user' => $user]);
    }

    public function get_data_from_assy_fvi(Request $request){

        // $matrix_data = AssemblyFvi::with(['material_process.material_details', 'material_process.station_details.stations'])->where('name', $request->device_name)->where('status', 1)->get();
        $fvi_details = AssemblyFvi::where('po_no', $request->po_number)
                                    // when($request->po_number, function ($query) use ($request){
                                    //     return $query ->where('po_no', $request->po_number);
                                    // })
                                    ->when($request->fvi_id, function ($query) use ($request){
                                        return $query ->with(['fvi_runcards.assy_runcard_station_details', 'oqc_lot_app.user', 
                                                                'oqc_lot_app.oqc_lot_app_summ' => function ($query) use ($request){
                                                                    return $query ->where('submission', $request->sub_count);
                                                                },
                                    ])->where('id', $request->fvi_id);
                                    })
                                    ->whereNull('deleted_at')->get();

        // return $fvi_details;

        if(count($fvi_details) > 0){
            $device = Device::where('name', $fvi_details[0]->device_name)->get();
        }else{
            $device = null;
        }

        if(isset($request->fvi_id)){
            $total_qty_output = 0;
            for ($i = 0; $i < count($fvi_details[0]->fvi_runcards); $i++){
                $total_qty_output = $total_qty_output + $fvi_details[0]->fvi_runcards[$i]->assy_runcard_station_details->output_quantity;
            }
        }else{
            $total_qty_output = '';
        }
            
        // return $fvi_details;

        // mapping
        // if($request->stamping_ipqc_id == 0){
        //     $data_mapped = $data->map(function ($item){
        //         $item->stamping_ipqc_data = 0;
        //         $item->ipqc_inspector_id = Auth::user()->id;
        //         $item->ipqc_inspector_name = Auth::user()->firstname.' '.Auth::user()->lastname;
        //         return $item;
        //     });
        // }else{
        //     $data_mapped = $data;
        // }

        return response()->json(['assy_fvi_details' => $fvi_details, 'devices' => $device, 'total_qty_output' => $total_qty_output]);
    }

    public function view_assy_oqc_lot_app(Request $request){
        date_default_timezone_set('Asia/Manila');

        $fvi_inspections = AssemblyFvi::with(['oqc_lot_app.user','fvi_runcards.assy_runcard_station_details'])
                                        ->where('po_no', $request->po_no)
                                        // ->whereIn('status', [3,4])
                                        ->get();
        // return $fvi_inspections;

        if( count($fvi_inspections) > 0 )
            $device = Device::where('name', $request->device_name)->get();
        else
            $device = null;
        return DataTables::of($fvi_inspections)

        ->addColumn('action', function($fvi_inspection){
            $result = "";

            $result.='<button type="button" class="btn btn-sm btn-success btn_update_lot" id="btn_update" data-toggle="modal" sub_count="'.$fvi_inspection->oqc_lot_app->submission.'" value="'.$fvi_inspection->id.'" title="View/Update Details"><i class="fa fa-pencil-alt fa-sm"></i></button>';
            
            if ($fvi_inspection->oqc_lot_app != null){
              $result.=' <button type="button" class="btn btn-sm btn-primary btn_print_lot" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print Lot Tray QR Sticker"><i class="fa fa-print fa-sm"></i></button>';
              $result.=' <button type="button" class="btn btn-sm btn-warning btn_print_lotapp" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print OQC Lot Application QR STICKER"><i class="fa fa-print fa-sm"></i></button>';
            }else{
              $result.=' <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" title="No Lot App Details" disabled><i class="fa fa-print fa-sm"></i></button>';
            }

            return $result;
        })
        ->addColumn('lot_qty', function($fvi_inspection) use ($device){
            if( isset($device[0]->qty_per_box) )
                return $device[0]->qty_per_box;
            else
                return 0;
        })
        ->addColumn('output_qty_raw', function($fvi_inspection){
            $total_qty_output = 0;
            for ($i = 0; $i < count($fvi_inspection->fvi_runcards); $i++)
                $total_qty_output = $total_qty_output + $fvi_inspection->fvi_runcards[$i]->assy_runcard_station_details->output_quantity;
            return $total_qty_output;
        })
        ->addColumn('status_raw', function($fvi_inspection){
            $result = "";
            return $result;
        })
        ->addColumn('submission_raw', function($fvi_inspection){
            $result = "";

            // COMMENT FOR NOW
            if ($fvi_inspection->oqc_lot_app != null){
                switch ($fvi_inspection->oqc_lot_app->submission){
                    case 1:
                        $result ='<span class="badge badge-pill s1 badge-success">1st Sub</span>';
                        break;
                    case 2:
                        $result ='<span class="badge badge-pill s2 badge-warning">2nd Sub</span>';
                        break;
                    case 3:
                        $result ='<span class="badge badge-pill s3 badge-danger">3rd Sub</span>';
                        break;
                }

            }else{
                $result ='---';
            }
            return $result;
        })
        ->addColumn('lot_applied_by', function($fvi_inspection){
            $result = null;
            $result .= '<span class="badge badge-pill badge-info">'.$fvi_inspection->oqc_lot_app->user->firstname.' '.$fvi_inspection->oqc_lot_app->user->lastname.'</span> ';
            
            return $result;
        })
        ->rawColumns(['action','lot_qty','output_qty_raw','status_raw','submission_raw','lot_applied_by'])
        ->make(true);
    }

    public function view_assy_oqc_lot_app_summary(Request $request){

        $oqc_inspections = AssemblyOqcLotAppSummary::with(['oqc_lot_app_summ.user','oqc_lot_app_summ' => function ($query) use ($request){
                                                            return $query ->where('assy_fvi_id', $request->assy_fvi_id);
                                                        }])->orderBy('submission','asc')->get();

        // $oqc_lot_app_summ = $oqc_inspections[0]->oqc_lot_app_summ;
        // return $oqc_inspections;
        // $oqc_inspections = AssemblyOqcLotApp::where( 'fkid_runcard', $request['lot_batch_no'] )
        // ->orderBy('submission','asc')->get();

        return DataTables::of($oqc_inspections)
        ->addColumn('sub_raw', function($oqc_inspection){
            $result = "";

                switch ($oqc_inspection->submission) {
                    case 1:
                        $result ='<span class="badge badge-pill s1 badge-success">1st Sub</span>';
                        break;
                    case 2:
                        $result ='<span class="badge badge-pill s2 badge-warning">2nd Sub</span>';
                        break;
                    case 3:
                        $result ='<span class="badge badge-pill s3 badge-danger">3rd Sub</span>';
                        break;
                }

            return $result;
        })
        ->addColumn('guar_lot_raw', function($oqc_inspection){
            $result = "";

                switch ($oqc_inspection->guaranteed_lot) {
                    case 1:
                        $result = '<font color="red">With</font>';
                        break;
                    case 2:
                        $result = '<font color="black">Without</font>';
                        break;
                }

            return $result;
        })
        ->addColumn('fvo_raw', function($oqc_inspection){
            $result = null;
            $result .= '<span class="badge badge-pill badge-info">'.$oqc_inspection->user->firstname.' '.$oqc_inspection->user->lastname.'</span> ';
            
            return $result;
        })
        ->addColumn('app_date_raw', function($oqc_inspection){
            $result = "";
                $result = date('F j, Y, h:i a', strtotime($oqc_inspection->app_date));
            return $result;
        })
        // ->addColumn('app_time_raw', function($oqc_inspection){
        //     $result = "";
        //         $result .= date('h:i a',strtotime('2001-01-01'.$oqc_inspection->app_time));
        //     return $result;
        // })
        ->addColumn('action', function($oqc_inspection){
            $result = "";
            return $result;
        })
        ->rawColumns(['action','guar_lot_raw','sub_raw','fvo_raw','app_date_raw'])
        ->make(true);
    }

    public function add_oqc_lot_app(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        try{
            if($request->submission_count > 3 ){
                return response()->json(['result' => "3"]); // more than 3rd sub
            }

                if(!isset($request->oqc_lot_app_id)){
                    $assy_oqc_lot_app_id = AssemblyOqcLotApp::insertGetId([
                                        'assy_fvi_id'      => $request->assy_fvi_id,
                                        'submission'       => $request->submission_count,
                                        'po_no'            => $request->po_number,
                                        'lot_batch_no'     => $request->lot_no,
                                        'print_lot'        => $request->print_lot_no,
                                        'lot_qty'          => $request->output_quantity,
                                        'app_date'         => date('Y-m-d H:i:s'),
                                        'device_cat'       => $request->device_cat,
                                        'cert_lot'         => $request->cert_lot,
                                        'guaranteed_lot'   => $request->guaranteed_lot,
                                        // 'problem'          => $request->problem,
                                        // 'doc_no'           => $request->doc_no,
                                        // 'remarks'          => $request->oqc_remarks,
                                        'operator_name'    => $request->id_applied_by_operator_name,
                                        // 'created_by'      => Auth::user()->id,
                                        // 'last_updated_by' => Auth::user()->id,
                                        'created_at'       => date('Y-m-d H:i:s'),
                                        'updated_at'       => date('Y-m-d H:i:s'),
                    ]);
                        AssemblyOqcLotAppSummary::insert([
                                'assy_oqc_lot_app_id'       => $assy_oqc_lot_app_id,
                                'guaranteed_lot'            => $request->guaranteed_lot,
                                'submission'                => $request->submission_count,
                                'problem'                   => $request->problem,
                                'doc_no'                    => $request->doc_no,
                                'remarks'                   => $request->oqc_remarks,
                                'operator_name'             => $request->id_applied_by_operator_name,
                                'created_at'                => date('Y-m-d H:i:s'),
                                'updated_at'                => date('Y-m-d H:i:s'),
                        ]);
    
                    DB::commit();
                    return response()->json(['result' => 1]);
                }else{
                    AssemblyOqcLotApp::where('id', $request->oqc_lot_app_id)
                        ->update([
                                'submission'       => $request->submission_count,
                                'app_date'         => $request->app_date,
                                'device_cat'       => $request->device_cat,
                                'cert_lot'         => $request->cert_lot,
                                'guaranteed_lot'   => $request->guaranteed_lot,
                                'problem'          => $request->problem,
                                'doc_no'           => $request->doc_no,
                                'remarks'          => $request->oqc_remarks,
                                'operator_name'    => $request->id_applied_by_operator_name,
                                // 'created_by'      => Auth::user()->id,
                                // 'last_updated_by' => Auth::user()->id,
                                'created_at'       => date('Y-m-d H:i:s'),
                                'updated_at'       => date('Y-m-d H:i:s'),
                    ]);

                    if($request->guaranteed_lot == 1){
                        AssemblyOqcLotAppSummary::insert([
                            'assy_oqc_lot_app_id'       => $request->oqc_lot_app_id,
                            'guaranteed_lot'            => $request->guaranteed_lot,
                            'submission'                => $request->submission_count,
                            'problem'                   => $request->problem,
                            'doc_no'                    => $request->doc_no,
                            'remarks'                   => $request->oqc_remarks,
                            'operator_name'             => $request->id_applied_by_operator_name,
                            'created_at'                => date('Y-m-d H:i:s'),
                            'updated_at'                => date('Y-m-d H:i:s'),
                        ]);
                    }
    
                    DB::commit();
                    return response()->json(['result' => 1]);
                }
            
            
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function generate_oqclotapp_qrsticker(Request $request){
        date_default_timezone_set('Asia/Manila');
        // $data = AssemblyOqcLotApp::with('assy_details')->where('fkid_runcard', $request->id)->get();

        $fvi_details = AssemblyFvi::with(['fvi_runcards.assy_runcard_station_details', 'oqc_lot_app.user', 'oqc_lot_app.oqc_lot_app_summ'])
                                    ->where('id', $request->fvi_id)
                                    ->whereNull('deleted_at')->get();
       
        $po_qrcode = "";
        $product_name = "";

        if($fvi_details->count() > 0){
            $po_qrcode = QrCode::format('png')
                        ->size(200)->errorCorrection('H')
                        ->generate($fvi_details[0]->po_no);
            
            $po_qrcode = "data:image/png;base64," . base64_encode($po_qrcode);
        }

        // $product_name = MaterialIssuanceSubSystem::where('po_no', $data[0]->po_no)->get();

        $device_name_print = 'not found';
        if(isset($product_name[0])){
            $device_name_print = $product_name[0]->device_name;
            if( strpos( $device_name_print, "Burn-in" ) !== false) {
                $temp = explode('-', $device_name_print);
                unset($temp[count($temp) - 1]);
                unset($temp[count($temp) - 1]);
                $device_name_print = implode('-', $temp);
                $device_name_print = trim($device_name_print);
            }
            if( strpos( $device_name_print, "Test" ) !== false) {
                $temp = explode('-', $device_name_print);
                unset($temp[count($temp) - 1]);
                $device_name_print = implode('-', $temp);
                $device_name_print = trim($device_name_print);
            }
        }

        $lbl = 'PO #: ' . $data[0]->po_no . '<br>Product Name: ' . $device_name_print. '<br>Lot #: ' . $data[0]->lot_batch_no . '<br>Lot Qty: ' . $data[0]->output_qty . '<br>Assy Line: ' . $data[0]->assy_details->name . '<br>Date/Time Applied: ' . $data[0]->created_at . '<br>WW: ' . $data[0]->ww;
        
        $lbl2 = '' . $data[0]->po_no . '<br>' . $device_name_print. '<br>' . $data[0]->lot_batch_no . '<br>' . $data[0]->output_qty . '<br>' . $data[0]->assy_details->name . '<br> ' . $data[0]->created_at . '<br>' . $data[0]->ww;


        return response()->json(['oqclot_details' => $data, 'lbl' => $lbl, 'lbl2' => $lbl2, 'po_qrcode' => $po_qrcode, 'device_name_print' => $device_name_print]);
    }

}
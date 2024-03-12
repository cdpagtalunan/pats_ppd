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

            if($fvi_inspection->oqc_lot_app != null){
                $submission = $fvi_inspection->oqc_lot_app->submission;
            }else{
                $submission = 0;
            }

            if($fvi_inspection->oqc_lot_app == null || $fvi_inspection->oqc_lot_app->status == 2){
                $result.='<button type="button" class="btn btn-sm btn-success btn_update_lot" id="btn_update" data-toggle="modal" sub_count="'.$submission.'" value="'.$fvi_inspection->id.'" title="View/Update Details"><i class="fa fa-pencil-alt fa-sm"></i></button>';
                $result.=' <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" title="No Lot App Details" disabled><i class="fa fa-print fa-sm"></i></button>';
            }
            // else if($fvi_inspection->oqc_lot_app->status > 0){

            if($fvi_inspection->oqc_lot_app->status == 2 && $fvi_inspection->oqc_lot_app->guaranteed_lot == 1){
                $result.='<button type="button" class="btn btn-sm btn-success btn_update_lot" id="btn_update" data-toggle="modal" sub_count="'.$submission.'" value="'.$fvi_inspection->id.'" title="View/Update Details"><i class="fa fa-pencil-alt fa-sm"></i></button>';

            }else if($fvi_inspection->oqc_lot_app->status == 1 && $fvi_inspection->oqc_lot_app->guaranteed_lot == 2){
                $result.=' <button type="button" class="btn btn-sm btn-primary btn_print_lotapp_inner_box" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print Lot Tray QR Sticker"><i class="fa fa-print fa-sm"></i></button>';
                $result.=' <button type="button" class="btn btn-sm btn-warning btn_print_lotapp" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print OQC Lot Application QR STICKER"><i class="fa fa-print fa-sm"></i></button>';
                $result .=' <button type="button" class="btn btn-sm btn-success btn_submit_lotapp" id="btnSubmitLotApp" value="'.$fvi_inspection->oqc_lot_app->id.'">
                                <i class="fa-solid fa-circle-check"></i>
                            </button>';
            }else if($fvi_inspection->oqc_lot_app->status == 3){

                $result .= '<button type="button" class="btn btn-sm btn-info btn_view_app_lot" value="'.$fvi_inspection->oqc_lot_app->id.'"><i class="fa-solid fa-eye" title="View Lot Application"></i></button>';
                $result.=' <button type="button" class="btn btn-sm btn-primary btn_print_lotapp_inner_box" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print Lot Tray QR Sticker"><i class="fa fa-print fa-sm"></i></button>';
                $result.=' <button type="button" class="btn btn-sm btn-warning btn_print_lotapp" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print OQC Lot Application QR STICKER"><i class="fa fa-print fa-sm"></i></button>';

            }else{
                $result .= '<button type="button" class="btn btn-sm btn-info btn_view_app_lot" value="'.$fvi_inspection->oqc_lot_app->id.'"><i class="fa-solid fa-eye" title="View Lot Application"></i></button>';
            }

                // $result.=' <button type="button" class="btn btn-sm btn-primary btn_print_lotapp_inner_box" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print Lot Tray QR Sticker"><i class="fa fa-print fa-sm"></i></button>';
                // $result.=' <button type="button" class="btn btn-sm btn-warning btn_print_lotapp" id="btn_print" data-toggle="modal" value="'.$fvi_inspection->oqc_lot_app->assy_fvi_id.'" title="Print OQC Lot Application QR STICKER"><i class="fa fa-print fa-sm"></i></button>';
                // $result .=' <button type="button" class="btn btn-sm btn-success btn_submit_lotapp" id="btnSubmitLotApp" value="'.$fvi_inspection->oqc_lot_app->id.'">
                //                 <i class="fa-solid fa-circle-check"></i>
                //             </button>';
            // }
            // else if($fvi_inspection->oqc_lot_app->status == 2){

            //     $result.='<button type="button" class="btn btn-sm btn-success btn_update_lot" id="btn_update" data-toggle="modal" sub_count="'.$submission.'" value="'.$fvi_inspection->id.'" title="View/Update Details"><i class="fa fa-pencil-alt fa-sm"></i></button>';

            // }
            // else if($fvi_inspection->oqc_lot_app->status > 2){
            //     $result .= '<button type="button" class="btn btn-sm btn-info btn_view_app_lot" value="'.$fvi_inspection->oqc_lot_app->id.'"><i class="fa-solid fa-eye" title="View Lot Application"></i></button>';
            // }

            return $result;
        })
        ->addColumn('status_raw', function($fvi_inspection){
            $result = "";
            if($fvi_inspection->oqc_lot_app != null){
                $status = $fvi_inspection->oqc_lot_app->status;
            }else{
                $status = 0;
            }

            switch ($status){
                case 0:
                    $result ='<span class="badge badge-pill badge-info">For Application</span>';
                    break;
                case 1:
                    $result ='<span class="badge badge-pill badge-primary">For OQC Submission</span>';
                    break;
                case 2:
                    $result ='<span class="badge badge-pill badge-success">Done</span>';
                    break;
                case 3:
                    $result ='<span class="badge badge-pill badge-warning">For Re-inspection</span>';
                    break;
                case 4:
                    $result ='<span class="badge badge-pill badge-danger">Lot App Rejected</span>';
                    break;
            }
            return $result;
        })
        ->addColumn('submission_raw', function($fvi_inspection){
            $result = "";

            // COMMENT FOR NOW
            if($fvi_inspection->oqc_lot_app != null || $fvi_inspection->oqc_lot_app != ''){
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
        ->addColumn('lot_applied_by', function($fvi_inspection){
            $result = null;

            if($fvi_inspection->oqc_lot_app != null){
                $result .= '<span class="badge badge-pill badge-info">'.$fvi_inspection->oqc_lot_app->user->firstname.' '.$fvi_inspection->oqc_lot_app->user->lastname.'</span> ';
            }else{
                $result ='---';
            }

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

    public function get_user_name(Request $request){
        $user = User::where('employee_id', $request->user_id)
                    ->where('status', 1)
                    ->first();

        // return $user;
        return response()->json(['user' => $user]);
    }

    public function get_po_number_from_assy_fvi(Request $request){
        $po_number = AssemblyFvi::select('po_no')->whereNull('deleted_at')->get();

        return response()->json(['po_number' => $po_number]);
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
                                                                    // return $query ->where('submission', $request->sub_count);
                                                                    return $query ->when($request->sub_count, function ($sub) use ($request){
                                                                        return $sub ->where('submission', $request->sub_count);
                                                                    });
                                                                },
                                    ])->where('id', $request->fvi_id);
                                    })
                                    ->whereNull('deleted_at')->first();

        // return $fvi_details;

        // if(count($fvi_details) > 0){
            $device = Device::where('name', $fvi_details->device_name)->first();
        // }else{
        //     $device = '';
        // }

        if(isset($request->fvi_id)){
            $total_qty_output = 0;
            for ($i = 0; $i < count($fvi_details->fvi_runcards); $i++){
                $total_qty_output = $total_qty_output + $fvi_details->fvi_runcards[$i]->assy_runcard_station_details->output_quantity;
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

    public function add_oqc_lot_app(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        try{
            // if($request->submission_count > 3 && $request->guaranteed_lot == 1){
            //     return response()->json(['result' => "3"]); // more than 3rd sub
            // }

            if($request->guaranteed_lot == 1){
                $status = 3; //for reinspection
            }else if($request->guaranteed_lot == 2){
                $status = 1; //for oqc submission
            }

            if($request->submission_count > 2 && $request->guaranteed_lot == 1){
                $status = 4; //lot app rejected
                // $submission_count = 3;
            }else{
                $submission_count = $request->submission_count;
            }

                if(!isset($request->oqc_lot_app_id)){
                        $assy_oqc_lot_app_id = AssemblyOqcLotApp::insertGetId([
                                        'assy_fvi_id'      => $request->assy_fvi_id,
                                        'submission'       => $submission_count,
                                        'po_no'            => $request->po_number,
                                        'status'           => $status,
                                        'lot_batch_no'     => $request->lot_no,
                                        'print_lot'        => $request->print_lot_no,
                                        'lot_qty'          => $request->lot_quantity,
                                        'output_quantity'  => $request->output_quantity,
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
                                'submission'                => $submission_count,
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
                    // if($request->guaranteed_lot == 1){
                        if($request->submission_count == 4 && $request->guaranteed_lot == 1){

                            return response()->json(['result' => 2]); // more than 3rd sub
                        }else{
                            AssemblyOqcLotApp::where('id', $request->oqc_lot_app_id)
                            ->update([
                                'submission'       => $submission_count,
                                'status'           => $status,
                                'app_date'         => date('Y-m-d H:i:s'),
                                'device_cat'       => $request->device_cat,
                                'cert_lot'         => $request->cert_lot,
                                'guaranteed_lot'   => $request->guaranteed_lot,
                                'problem'          => $request->problem,
                                'doc_no'           => $request->doc_no,
                                'remarks'          => $request->oqc_remarks,
                                'operator_name'    => $request->id_applied_by_operator_name,
                                'updated_at'       => date('Y-m-d H:i:s'),
                            ]);

                            AssemblyOqcLotAppSummary::insert([
                                'assy_oqc_lot_app_id'       => $request->oqc_lot_app_id,
                                'guaranteed_lot'            => $request->guaranteed_lot,
                                'submission'                => $submission_count,
                                'problem'                   => $request->problem,
                                'doc_no'                    => $request->doc_no,
                                'remarks'                   => $request->oqc_remarks,
                                'operator_name'             => $request->id_applied_by_operator_name,
                                'created_at'                => date('Y-m-d H:i:s'),
                                'updated_at'                => date('Y-m-d H:i:s'),
                            ]);

                            DB::commit();
                            return response()->json(['result' => 1]);
                        }

                    // }else{
                    //     AssemblyOqcLotApp::where('id', $request->oqc_lot_app_id)
                    //     ->update([
                    //             'app_date'         => date('Y-m-d H:i:s'),
                    //             'device_cat'       => $request->device_cat,
                    //             'cert_lot'         => $request->cert_lot,
                    //             'guaranteed_lot'   => $request->guaranteed_lot,
                    //             'problem'          => $request->problem,
                    //             'doc_no'           => $request->doc_no,
                    //             'remarks'          => $request->oqc_remarks,
                    //             'operator_name'    => $request->id_applied_by_operator_name,
                    //             'created_at'       => date('Y-m-d H:i:s'),
                    //             'updated_at'       => date('Y-m-d H:i:s'),
                    //     ]);
                    // }
                }
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update_lot_app_status(Request $request){
        date_default_timezone_set('Asia/Manila');
        // session_start();
        AssemblyOqcLotApp::where('id', $request->cnfrm_assy_id)
                    ->update([
                        'status'              => 2,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

                    DB::commit();
        return response()->json(['result' => 'Successful']);
    }

    public function gen_oqclotapp_qrsticker(Request $request){
        date_default_timezone_set('Asia/Manila');
        $fvi_details = AssemblyFvi::with(['fvi_runcards.assy_runcard_station_details.station_name', 'oqc_lot_app'])
                                    ->where('id', $request->fvi_id)
                                    ->whereNull('deleted_at')->first();

        $po_qrcode = "";
        $po_qrcode = QrCode::format('png')->size(200)->errorCorrection('H')->generate($fvi_details->po_no);
        $po_qrcode = "data:image/png;base64," . base64_encode($po_qrcode);

        $po_no        = $fvi_details->po_no;
        $product_name = $fvi_details->device_name;
        $lot_no       = $fvi_details->oqc_lot_app->lot_batch_no;
        $lot_qty      = $fvi_details->oqc_lot_app->output_quantity;
        $assy_line    = $fvi_details->fvi_runcards[0]->assy_runcard_station_details->station_name[0]->station_name;
        $applied_date = $fvi_details->oqc_lot_app->app_date;

        // $lbl = 'PO #: ' . $fvi_details[0]->po_no . '<br>Product Name: ' . $fvi_details[0]->device_name. '<br>Lot #: ' . $fvi_details[0]->lot_no . '<br>Lot Qty: ' . $fvi_details[0]->oqc_lot_app->output_qty . '<br> Assy Line: ' . $data[0]->assy_details->name . '<br>Date/Time Applied: ' . $data[0]->created_at . '<br>WW: ' . $data[0]->ww;
        $lbl = 'PO #: '.$po_no.'<br>Product Name: '.$product_name.'<br>Lot #: '.$lot_no.'<br>Lot Qty: '.$lot_qty.'<br> Assy Line: '.$assy_line.'<br>Date/Time Applied: '.$applied_date.'';
        $lbl2 = ''.$po_no.'<br>'.$product_name.'<br>'.$lot_no.'<br>'.$lot_qty.'<br> '.$assy_line.'<br> '.$applied_date.'';

        return response()->json(['oqclot_details' => $fvi_details, 'lbl' => $lbl, 'lbl2' => $lbl2, 'po_qrcode' => $po_qrcode]);
    }

    public function gen_oqclotapp_inner_box_qrsticker(Request $request){
        $fvi_to_lotapp_details = AssemblyFvi::with('oqc_lot_app.user')->where('id', $request->fvi_id)->whereNull('deleted_at')->first();
        $device = Device::where('name', $request->device_name)->first();

        // return $fvi_to_lotapp_details;

        $prd_runcards = AssemblyFvi::where('po_no', $fvi_to_lotapp_details->po_no)->orderBy('id')->get();
        $prd_runcards_counter = [];
        for ($i=0; $i < count($prd_runcards); $i++)
            $prd_runcards_counter[ $prd_runcards[$i]->id ] = ($i+1);
        // return $device;

        $img_po_no              = $fvi_to_lotapp_details->po_no;
        $img_product_name       = $fvi_to_lotapp_details->device_name;
        $img_lot_no             = $fvi_to_lotapp_details->lot_no;
        $img_print_lot          = $fvi_to_lotapp_details->oqc_lot_app->print_lot;
        $img_output_qty         = $fvi_to_lotapp_details->oqc_lot_app->output_quantity;
        $img_qty_inner_box      = $device->qty_per_reel;

        $QrCode = QrCode::format('png')->errorCorrection('H')->size(200)->generate($img_po_no.' '.$img_product_name.' '.$img_lot_no.' '.$img_print_lot.' '.$img_output_qty.' '.$img_qty_inner_box);
        $QrCode = "data:image/png;base64," . base64_encode($QrCode);

        // $po_no = ProductionRuncard::where('id', $request->id)->get()[0]->po_no;
        // $prd_runcards = ProductionRuncard::where('po_no', $po_no)->orderBy('id')->get();
        $no_of_inner_box = $device->qty_per_box / $device->qty_per_reel;
        // $lot_start_counter = 0;
        $inner_box_lbl = "";
        $data = [];

        for ($i= 1; $i <= $no_of_inner_box; $i++) {

            $no_of_inner_box = $device->qty_per_box / $device->qty_per_reel;
            $lot_start_counter = 0;

            $po_no              = $fvi_to_lotapp_details->po_no;
            $product_name       = $fvi_to_lotapp_details->device_name;
            $lot_no             = $fvi_to_lotapp_details->lot_no;
            $operator_name      = $fvi_to_lotapp_details->oqc_lot_app->user->firstname.' '.$fvi_to_lotapp_details->oqc_lot_app->user->lastname;
            $output_qty         = $fvi_to_lotapp_details->oqc_lot_app->output_quantity;
            $qty_inner_box      = $device->qty_per_reel;
            $lot_counter        = ($lot_start_counter + $i) .'/'. ($no_of_inner_box);

            $InnerBox_QrCode = QrCode::format('png')->errorCorrection('H')->size(200)->generate($po_no.' '.$product_name.' '.$lot_no.' '.$operator_name.' '.$output_qty.' '.$qty_inner_box.' '.($lot_start_counter + $i) .'/'. ($no_of_inner_box));
            $InnerBox_QrCode = "data:image/png;base64," . base64_encode($InnerBox_QrCode);

            $data[] = array('img' => $InnerBox_QrCode, 'text' => '<b><br>' .$po_no. '</b><br>'.'<b>' .$product_name.'</b><br>'.
                                    $lot_no.'</b><br>'.
                                    $operator_name .'<br>'.
                                    $output_qty.'</b><br>'.
                                    $qty_inner_box.'</b><br>'.
                                    ($lot_start_counter + $i) .'/'. ($no_of_inner_box).'</b>');

            $inner_box_lbl = 'PO no.: '.$po_no.'<br>Device name: '.$product_name.'<br>Lot no.: '.$lot_no.'<br>FVI name: '.$operator_name.'<br>Actual lot quantity: '.$output_qty.'<br>Quantity per tray: '.$qty_inner_box.'<br>Count of tray/total tray per lot: '. $prd_runcards_counter[$request->fvi_id] .'/'. ($no_of_inner_box);
        }

        return response()->json(['QrCode' => $QrCode, 'label' => $inner_box_lbl, 'label_hidden' => $data]);
    }

}

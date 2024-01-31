<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

use App\Models\SecMoldingRuncard;
use App\Models\AssemblyRuncard;
use App\Models\AssemblyRuncardStation;

class AssemblyRuncardController extends Controller
{
    public function get_data_from_2nd_molding(Request $request){
        $sec_molding_runcard_data = SecMoldingRuncard::whereNull('deleted_at')
                                            ->where('po_number', $request->po_number)
                                            ->get();

        return response()->json(['sec_molding_runcard_data' => $sec_molding_runcard_data]);
    }

    public function view_assembly_runcard(Request $request){
        if(!isset($request->series_name)){
            return [];
        }else{
            $AssemblyRuncardData = AssemblyRuncard::whereNull('deleted_at')
                                    // ->whereIn('status', $request->fs_prod_status)
                                    // ->where('stamping_cat', $request->fs_prod_stamping_cat)
                                    // ->with(['cn_assembly_runcard'])
                                    ->where('series_name', $request->series_name)
                                    ->get();

            // $AssemblyRuncardData = DB::connection('mysql')->select("SELECT a.* FROM cn_assembly_runcards AS a
            //          JOIN sec_molding_runcards AS b
            //                 ON b.id = a.sec_molding_runcard_id
            //             WHERE a.po_number = '$request->po_number'
            //             ORDER BY a.id ASC
            // ");

            return DataTables::of($AssemblyRuncardData)
            ->addColumn('action', function($row){
                $result = '';
                $result .= "
                    <center>
                        <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                    </center>
                ";
                return $result;
            })
            ->addColumn('status', function($row){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
            ->addColumn('runcard_no', function($row){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
            ->rawColumns(['action','status','runcard_no'])
            ->make(true);
        }
    }

    public function view_assembly_runcard_stations(Request $request){
        if(!isset($request->po_number)){
            return [];
        }else{
            $AssemblyRuncardData = SecMoldingRuncard::whereNull('deleted_at')
                                    // ->whereIn('status', $request->fs_prod_status)
                                    // ->where('stamping_cat', $request->fs_prod_stamping_cat)
                                    ->with(['cn_assembly_runcard'])
                                    ->where('po_number', $request->po_number)
                                    ->get();

            // $AssemblyRuncardData = DB::connection('mysql')->select("SELECT a.* FROM cn_assembly_runcards AS a
            //          JOIN sec_molding_runcards AS b
            //                 ON b.id = a.sec_molding_runcard_id
            //             WHERE a.po_number = '$request->po_number'
            //             ORDER BY a.id ASC
            // ");

            return DataTables::of($AssemblyRuncardData)
            ->addColumn('action', function($row){
                $result = '';
                $result .= "
                    <center>
                        <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                    </center>
                ";
                return $result;
            })
            ->addColumn('status', function($row){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
            ->addColumn('runcard_no', function($row){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
            ->rawColumns(['action','status','runcard_no'])
            ->make(true);
        }
    }

    public function add_assembly_runcard_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

                $data = $request->all();
                if(!isset($request->assy_runcard_id)){
                    $validator = Validator::make($data, [
                        'runcard_no' => 'required'
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
                    }else {
                            AssemblyRuncard::insert([
                                                        'series_name'             => $request->series_name,
                                                        'device_name'             => $request->device_name,
                                                        'po_number'               => $request->po_number,
                                                        'parts_code'              => $request->parts_code,
                                                        'po_quantity'             => $request->po_quantity,
                                                        'runcard_no'              => $request->runcard_no,
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

                FirstStampingProduction::where('id', $request->fs_productions_id)
                ->update(['status' => $fs_prod_status]);

                    DB::commit();
        return response()->json(['result' => 'Successful']);
    }
}

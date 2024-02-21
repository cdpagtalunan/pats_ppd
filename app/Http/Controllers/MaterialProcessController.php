<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Process;

use App\Models\Station;
use App\Models\EEDMSMachine;
use Illuminate\Http\Request;
use App\Models\MaterialProcess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\MaterialProcessMachine;
use App\Models\MaterialProcessStation;
use App\Models\MaterialProcessMaterial;
use Illuminate\Support\Facades\Validator;

class MaterialProcessController extends Controller
{
    public function view_material_process_by_device_id(Request $request){

        $material_process_details = MaterialProcess::with([
            'material_details'=> function($query){
                $query->where('status', 0);
            },
            'station_details'=> function($query){
                $query->where('status', 0);
            },
            'machine_details'=> function($query){
                $query->where('status', 0);
            },
            'station_details.stations',
            'process_details'
        ])
        ->where('device_id', $request->device_id)
        ->where('status', $request->status)
        ->get();

        return DataTables::of($material_process_details)
        ->addColumn('action', function($material_process_details){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-sm btn-info aEditMatProc mr-1' data-id='$material_process_details->id'><i class='fa-solid fa-pen-to-square'></i></button>";
            
            if($material_process_details->status == 0){
                $result .= "<button class='btn btn-sm btn-danger aChangeMatProcStat' data-id='$material_process_details->id' data-status='1'><i class='fa-solid fa-ban'></i></button>";
            }
            else{
                $result .= "<button class='btn btn-sm btn-success aChangeMatProcStat' data-id='$material_process_details->id' data-status='0'><i class='fa-solid fa-redo'></i></button>";
            }
            $result .= "</center>";
            return $result;
        })
        // ->addColumn('mat_status', function($material_process_details){
        //     $result = "";
        //     if($material_process_details->status == 0){
        //         $result .= "<span class='badge bg-success text-white'>Active</span>";

        //     }
        //     else{
        //         $result .= "<span class='badge bg-danger text-white'>Inactive</span>";

        //     }
        //     return $result;
        // })
        ->addColumn('mat_details', function($material_process_details){
            $result = "";
            if(count($material_process_details->material_details) > 0){
                for ($i=0; $i < count($material_process_details->material_details); $i++) {
                    $result .= "<span class='badge bg-info text-white'>".$material_process_details->material_details[$i]->material_type."</span>";
                }
            }
            else{
                $result .= "N/A";
            }
            return $result;
        })
        ->addColumn('stat_details', function($material_process_details){
            $result = "";
            if(count($material_process_details->station_details) > 0){
                for ($i=0; $i < count($material_process_details->station_details); $i++) {
                    $result .= "<span class='badge bg-info text-white'>".$material_process_details->station_details[$i]->stations->station_name."</span>";
                }
            }
            else{
                $result .= "N/A";
            }
            return $result;
        })
        ->addColumn('mach_details', function($material_process_details){
            $result = "";
            if(count($material_process_details->machine_details) > 0){
                for ($i=0; $i < count($material_process_details->machine_details); $i++) {
                    $result .= "<span class='badge bg-info text-white'>".$material_process_details->machine_details[$i]->machine_code."(".$material_process_details->machine_details[$i]->machine_name.")</span>";
                }
            }
            else{
                $result .= "N/A";
            }
            return $result;
        })
        ->rawColumns(['action', 'mat_details', 'stat_details', 'mach_details'])
        ->make(true);
    }

    public function get_mat_proc_for_add(Request $request){
        $machine_details = DB::connection('mysql_rapid_eedms')
        ->select('SELECT * FROM generallogistics WHERE machine_section = "PPS" AND machine_code = "MACHINE"');

        // $material_details_warehouse_data = DB::connection('mysql_rapid_pps')
        // ->select('SELECT PartNumber AS code, MaterialType AS name FROM tbl_Warehouse');

        // $material_details_dieset = DB::connection('mysql_rapid_pps')
        // ->select('SELECT R3Code AS code, DeviceName AS name FROM tbl_dieset');

        $material_details_warehouse_data = DB::connection('mysql_rapid_pps')
        ->table('tbl_Warehouse')
        ->select('PartNumber AS code', 'MaterialType AS name')
        ->get();

        $material_details_dieset = DB::connection('mysql_rapid_pps')
        ->table('tbl_dieset')
        ->select('R3Code AS code', 'DeviceName AS name')
        ->get();

        $material_stamping_dmcms = DB::connection('mysql_rapid_stamping_dmcms')
        ->table('tbl_device')
        ->select('device_code AS code', 'device_name AS name')
        ->where('logdel', 0)
        ->get();

        $material_stamping_dmcms = collect($material_stamping_dmcms)->unique('code')->flatten(0);

        foreach($material_stamping_dmcms as $dmcms){
            $new_name;
            if(str_contains($dmcms->name, '-X')){
                $new_name = str_replace("-X","",$dmcms->name);
            }
            else if(str_contains($dmcms->name, '-Y')){
                $new_name = str_replace("-Y","",$dmcms->name);
            }
            else{
                $new_name = $dmcms->name;
            }

            $dmcms->name = $new_name;
        }

        // return $material_stamping_dmcms;

        $result = $material_details_warehouse_data->toBase()->merge($material_details_dieset);
        $merged_materials = $result->toBase()->merge($material_stamping_dmcms);

        $process_details = Process::where('status', 0)->get();

        $stations = Station::where('status', 0)->get();
        
        return response()->json([
            'machine_details'  => $machine_details,
            'material_details' => $merged_materials,
            'process'          => $process_details,
            'stations'         => $stations
        ]);
    }

    public function get_step(Request $request){
        $step_count = MaterialProcess::where('device_id', $request->id)
        ->where('status', 0)
        ->max('step');
        if(isset($step_count)){
            $count = $step_count + 1;
        }
        else{
            $count = 1;
        }

        return response()->json([
            'count' => $count
        ]);
    }

    public function add_material_process(Request $request){

        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        // return $data;
        $validation = array(
                // 'name' => ['required', 'string', 'max:255', 'unique:devices'],
                'process' => ['required', 'string', 'max:255']
        );
        
        $validator = Validator::make($data, $validation);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();

            try{
                $mat_proc_array = array(
                    'step'      => $request->step,
                    'process'   => $request->process,
                    // 'device_id'   => $request->device_id,
                    // 'machine_code'   => $request->machine,
                    // 'created_by'    => Auth::user()->id
                );

                if(isset($request->mat_proc_id)){ // EDIT
                    $material_process_id = $request->mat_proc_id;
                    $mat_proc_array['last_updated_by'] = Auth::user()->id;

                    MaterialProcess::where('id', $request->mat_proc_id)
                    ->update($mat_proc_array);

                    MaterialProcessMaterial::where('mat_proc_id', $request->mat_proc_id)->delete();

                    MaterialProcessMachine::where('mat_proc_id', $request->mat_proc_id)->delete();
                    // if(isset($request->material_name)){
                    //     for ($i=0; $i < count($request->material_name); $i++) { 
                    //          $exploded_material = explode(' || ',$request->material_name[$i]);
                    //         MaterialProcessMaterial::insert([
                    //             'mat_proc_id'   => $request->mat_proc_id,
                    //             'material_code' => $exploded_material[0],
                    //             'material_type' => $exploded_material[1],
                    //             'created_by'    => Auth::user()->id
                    //         ]);
                    //     }
                    // }

                    MaterialProcessStation::where('mat_proc_id',  $request->mat_proc_id)->delete();
                    // if(isset($request->station)){
                    //     for ($j=0; $j < count($request->station); $j++) { 
                    //         MaterialProcessStation::insert([
                    //             'mat_proc_id'   => $request->mat_proc_id,
                    //             'station_id' => $request->station[$j]
                    //         ]);
                    //     }
                    // }
                }
                else{ // ADD
                    // return 'else';
                    $mat_proc_array['device_id'] = $request->device_id;
                    $mat_proc_array['created_by'] = Auth::user()->id;
                    $mat_proc_array['created_at'] = NOW();

                    // if(isset($request->machine)){
                    //     $machine_info = DB::connection('mysql_rapid_eedms')
                    //     ->select('SELECT machine_name FROM generallogistics WHERE machine_code_number = "'.$request->machine.'"');
    
                    //     $mat_proc_array['machine_name'] = $machine_info[0]->machine_name;
                    // }
    
                    $mat_proc_id = MaterialProcess::insertGetId($mat_proc_array);
                    $material_process_id = $mat_proc_id;
    

                }
                if(isset($request->machine)){
                    for ($h=0; $h < count($request->machine); $h++) { 
                        $exploded_machine = explode(' || ',$request->machine[$h]);
                        MaterialProcessMachine::insert([
                            'mat_proc_id'   => $material_process_id,
                            'machine_code' => $exploded_machine[0],
                            'machine_name' => $exploded_machine[1],
                            'created_by'    => Auth::user()->id,
                            'created_at'    => NOW()
                        ]);
                    }
                }

                if(isset($request->material_name)){
                    for ($i=0; $i < count($request->material_name); $i++) { 
                        $exploded_material = explode(' || ',$request->material_name[$i]);
                        MaterialProcessMaterial::insert([
                            'mat_proc_id'   => $material_process_id,
                            'material_code' => $exploded_material[0],
                            'material_type' => $exploded_material[1],
                            'created_by'    => Auth::user()->id,
                            'created_at'    => NOW()
                        ]);
                    }
                }

                if(isset($request->station)){
                    for ($j=0; $j < count($request->station); $j++) { 
                        MaterialProcessStation::insert([
                            'mat_proc_id'   => $material_process_id,
                            'station_id' => $request->station[$j],
                            'created_at'    => NOW()
                        ]);
                    }
                }
              

              
                DB::commit();

                return response()->json([
                    'result' => 1,
                    'msg'    => 'Transaction Successful'
                ]);
            }catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }

    }

    public function get_mat_proc_data(Request $request){
        $material_process_details = MaterialProcess::with([
            'material_details'=> function($query){
                $query->where('status', 0);
            },
            'station_details'=> function($query){
                $query->where('status', 0);
            },
            'machine_details'=> function($query){
                $query->where('status', 0);
            },
            'process_details'
        ])
        ->where('id', $request->id)
        ->where('status', 0)
        ->first();

        return response()->json(['matDetails' => $material_process_details]);

    }

    public function change_mat_proc_status(Request $request){
        DB::beginTransaction();
        
        try{
            MaterialProcess::where('id', $request->material_process_id)
            ->update([
                'status' => $request->status
            ]);
            DB::commit();

            return response()->json(['result' => 1, 'msg' => 'Transaction Success']);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

use App\Models\FirstMolding;
use App\Models\SecMoldingRuncard;
use App\Models\AssemblyRuncard;
use App\Models\AssemblyRuncardStation;
use App\Models\AssemblyRuncardStationsMods;
use App\Models\Station;

use App\Models\Process;
use App\Models\Device;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use QrCode;

class AssemblyRuncardController extends Controller
{
    public function get_data_from_matrix(Request $request){
        $material_name = [];
        $matrix_data = Device::with(['material_process.material_details', 'material_process.station_details.stations'])->where('name', $request->device_name)->where('status', 1)->get();
        foreach($matrix_data[0]->material_process[0]->material_details as $material_details){
            $material_name[] = $material_details->material_type;
        }
        $material_type = implode(',',$material_name);

        $station_details = $matrix_data[0]->material_process[0]->station_details;

        // return $matrix_data;
        return response()->json(['device_details' => $matrix_data, 'material_details' => $material_type]);
    }

    // COMMENTED CLARK FOR SEARCHING PO
    // public function get_data_from_2nd_molding(Request $request){
    //     $sec_molding_runcard_data = SecMoldingRuncard::whereNull('deleted_at')
    //                                         ->where('pmi_po_number', $request->po_number)
    //                                         ->get();
    //     return response()->json(['sec_molding_runcard_data' => $sec_molding_runcard_data]);
    // }

    public function chk_device_prod_lot_from_first_molding(Request $request){
        $device_name_by_prod_lot = FirstMolding::with('firstMoldingDevice')
                                            ->whereNull('deleted_at')
                                            ->where('production_lot', $request->production_lot)
                                            ->where('production_lot_extension', $request->production_lot_ext)
                                            ->get();
    // return $device_name_by_prod_lot;
        if($device_name_by_prod_lot->isEmpty()){
            $device_name      = '';
            $production_lot   = '';
            $device_id        = '';
            $yec_po_number    = '';
            $pmi_po_number    = '';
            $shipment_output  = '';
        }else{
            $device_name     = $device_name_by_prod_lot[0]->firstMoldingDevice->device_name;
            $production_lot  = $device_name_by_prod_lot[0]->production_lot .''. $device_name_by_prod_lot[0]->production_lot_extension;
            $device_id       = $device_name_by_prod_lot[0]->first_molding_device_id;
            $yec_po_number   = $device_name_by_prod_lot[0]->po_no;
            $pmi_po_number   = $device_name_by_prod_lot[0]->pmi_po_no;
            $shipment_output = $device_name_by_prod_lot[0]->shipment_output;
        }

        return response()->json(['device_name' => $device_name,
                                'production_lot'  => $production_lot,
                                'device_id'       => $device_id,
                                'yec_po_number'   => $yec_po_number,
                                'pmi_po_number'   => $pmi_po_number,
                                'shipment_output' => $shipment_output
        ]);
    }

    public function chk_device_prod_lot_from_sec_molding(Request $request){
        $device_name_by_prod_lot = SecMoldingRuncard::with('device_id')
                                            ->whereNull('deleted_at')
                                            ->where('production_lot', $request->production_lot)
                                            ->get();

                                            // return $device_name_by_prod_lot;
        if($device_name_by_prod_lot->isEmpty()){
            $device_name    = '';
            $production_lot = '';
            $device_id      = '';
            $yec_po_number  = '';
            $pmi_po_number  = '';
            $shipment_output  = '';
        }else{
            $device_name     = $device_name_by_prod_lot[0]->device_name;
            $production_lot  = $device_name_by_prod_lot[0]->production_lot;
            $device_id       = $device_name_by_prod_lot[0]->device_id->id;
            $yec_po_number   = $device_name_by_prod_lot[0]->pmi_po_number;
            $pmi_po_number   = $device_name_by_prod_lot[0]->po_number;
            $shipment_output = $device_name_by_prod_lot[0]->shipment_output;
        }

        return response()->json(['device_name'    => $device_name,
                                'production_lot'  => $production_lot,
                                'device_id'       => $device_id,
                                'yec_po_number'   => $yec_po_number,
                                'pmi_po_number'   => $pmi_po_number,
                                'shipment_output' => $shipment_output
        ]);
    }

    // public function connect_ypics(Request $request){
    //     // $test = YPICS::select('SELECT TOP 1 a.SORDER as PO, a.CODE, b.NAME FROM XRECE a
    //     // INNER JOIN XHEAD b on b.CODE = a.CODE')->get();

    //     $test = DB::connection('sqlsrv_1')
    //                 ->select("SELECT TOP 1 a.SORDER as PO, a.CODE, b.NAME FROM XRECE a
    //                             INNER JOIN XHEAD b on b.CODE = a.CODE'
    //                 ");

    //     return $test;
    // }

    public function get_assembly_runcard_data(Request $request){
        // $assembly_runcard_data = AssemblyRuncard::when($request->assy_runcard_station_id, function ($with_query) use ($request){
        //                                             return $with_query-> with(['assembly_runcard_station.station_name','assembly_runcard_station.user','assembly_runcard_station' => function($station_id_query) use ($request){
        //                                                     return $station_id_query->where('id', $request->assy_runcard_station_id);
        //                                                 }]);
        //                                         })
        //                                         ->whereNull('deleted_at')
        //                                         ->where('id', $request->assy_runcard_id)
        //                                         ->get();

        $assembly_runcard_data = AssemblyRuncard::with(['assembly_runcard_station.station_name' ,'assembly_runcard_station.user'])
                                                ->when($request->assy_runcard_station_id, function ($station_query) use ($request){
                                                    return $station_query ->with(['assembly_runcard_station' => function($station_id_query) use ($request){
                                                        return $station_id_query->where('id', $request->assy_runcard_station_id);
                                                    }]);
                                                })
                                                ->whereNull('deleted_at')
                                                ->when($request->assy_runcard_id, function ($query) use ($request){
                                                        return $query ->where('id', $request->assy_runcard_id);
                                                })
                                                ->when($request->po_number, function ($query) use ($request){
                                                        return $query ->where('po_number', $request->po_number);
                                                })
                                                // ->where('id', $request->assy_runcard_id)
                                                // ->where('po_number', $request->po_number)
                                                ->get();

        // $material_processes_by_device_name = DB::connection('mysql')
        //     ->select("  SELECT material_processes.step
        //                 FROM material_processes
        //                 INNER JOIN devices ON devices.id = material_processes.device_id
        //                 INNER JOIN material_process_stations ON material_process_stations.mat_proc_id = material_processes.id
        //                 INNER JOIN stations ON stations.id = material_process_stations.station_id
        //                 WHERE devices.name = '' AND stations.id = $request->station
        //                 AND material_processes.process = 4 AND material_processes.status = 0
        //     ");

        // return $material_processes_by_device_name;

        if(isset($request->assy_runcard_station_id)){
            $mode_of_defect_data =  AssemblyRuncardStationsMods::with(['mode_of_defect'])->where('assembly_runcard_stations_id', $request->assy_runcard_station_id)
            ->whereNull('deleted_at')
            ->get();

            // return $mode_of_defect_data;
        }else{
            $mode_of_defect_data = [];
        }

        return response()->json(['assembly_runcard_data' => $assembly_runcard_data, 'mode_of_defect_data' => $mode_of_defect_data]);
    }

    public function view_assembly_runcard(Request $request){
        // if(!isset($request->device_name)){
        //     return [];
        // }else{
            $AssemblyRuncardData = DB::connection('mysql')->select("SELECT a.* FROM assembly_runcards AS a
                                            WHERE a.device_name = '$request->device_name'
                                            ORDER BY a.id DESC
            ");

            return DataTables::of($AssemblyRuncardData)
            ->addColumn('action', function($row){
                $result = '';
                $result .= "<center>";

                if($row->status == 1 || $row->status == 3){
                    $result .= "<button class='btn btn-success btn-sm mr-1' assembly_runcard-id='".$row->id."' id='btnPrintAssemblyRuncard'>
                                    <i class='fa-solid fa-print' disabled></i>
                                </button>";
                }

                if($row->status == 0 ){
                    $result .= "<button class='btn btn-primary btn-sm mr-1 btnUpdateAssemblyRuncardData' assembly_runcard-id='$row->id'>
                                <i class='fa-solid fa-pen-to-square'></i>
                            </button>";
                }

                if($row->status == 1 || $row->status == 2 || $row->status == 3){
                    $result .= "<button class='btn btn-info btn-sm mr-1 btnViewAssemblyRuncardData' assembly_runcard-id='$row->id'>
                                    <i class='fa-solid fa-eye' title='View IPQC Inspection'></i>
                                </button>";
                }

                if($row->status == 1){
                    $result .= "<button class='btn btn-success btn-sm mr-1' assembly_runcard-id='".$row->id."' assembly_runcard-status='".$row->status."' id='btnSubmitIPQCData'>
                                    <i class='fa-solid fa-circle-check'></i>
                                </button>";
                }

                // if($row->status == 2){
                //     $result .= "<button class='btn btn-primary btn-sm mr-1 btnUpdateAssemblyRuncardData' assembly_runcard-id='$row->id'>
                //                     <i class='fa-solid fa-pen-to-square'></i>
                //                 </button>";

                //     $result .= "<button class='btn btn-success btn-sm mr-1' assembly_runcard-id='".$row->id."' assembly_runcard-status='".$row->status."' id='btnSubmitIPQCData'>
                //                     <i class='fa-solid fa-circle-check'></i>
                //                 </button>";
                // }


                $result .= "</center>";

                return $result;
            })
            ->addColumn('status', function ($row){
                $result = "";

                switch($row->status){
                    case 0: //Pending
                        $result .= '<center><span class="badge badge-pill badge-info">For Station Process</span></center>';
                        break;
                    case 1: //Mass Prod
                        $result .= '<center><span class="badge badge-pill badge-primary">For Mass Production</span></center>';
                        break;
                    case 2: //Resetup
                        $result .= '<center><span class="badge badge-pill badge-warning">For Re-setup</span></center>';
                        break;
                    case 3: //Done
                        $result .= '<center><span class="badge badge-pill badge-success">Done</span></center>';
                        break;
                }
                return $result;
            })
            ->rawColumns(['action','status'])
            ->make(true);
        // }
    }

    public function view_assembly_runcard_stations(Request $request){
        // if(!isset($request->assy_runcard_id)){
        //     return [];
        // }else{
            $AssemblyRuncardStationData = DB::connection('mysql')->select("SELECT runcard_station.*, sub.station_name, user.firstname, user.lastname FROM assembly_runcard_stations AS runcard_station
                        LEFT JOIN stations AS sub ON runcard_station.station = sub.id
                        LEFT JOIN users AS user ON runcard_station.operator_name = user.id
                        WHERE runcard_station.assembly_runcards_id = '$request->assy_runcard_id'
                        ORDER BY runcard_station.station_step ASC
            ");

            // return $AssemblyRuncardStationData;

            return DataTables::of($AssemblyRuncardStationData)
            ->addColumn('action', function($station){
                $result = '';

                //CLARK COMMENT TO DISABLE EDITING PER STATION
                // if($station->status == 0 || $station->status == 1){
                //     $result .= "<center>
                //                     <button class='btn btn-primary btn-sm mr-1 btnUpdateAssyRuncardStationData' assy_runcard_stations-id='$station->id'><i class='fa-solid fa-pen-to-square'></i></button>
                //                 </center>";
                // }

                //CLARK COMMENT TO DISABLE EDITING PER STATION
                // if($station->status == 2 || $station->status == 3){
                    $result .= "<center>
                                    <button class='btn btn-primary btn-sm mr-1 btnViewAssyRuncardStationData' assy_runcard_stations-id='$station->id'><i class='fa-solid fa-eye'></i></button>
                                </center>";
                // }

                return $result;
            })
            ->addColumn('status', function($station){
                $result = '';
                if($station->status == 0 || $station->status == 1 || $station->status == 2){
                    $result .= "<center>
                                    <span class='badge rounded-pill bg-info'>On-going</span>
                                </center>";
                }

                if($station->status == 3){
                    $result .= "<center>
                                    <span class='badge rounded-pill bg-info'>Done</span>
                                </center>";
                }
                return $result;
            })
            // ->addColumn('runcard_no', function($station){
            //     $result = '';
            //     $result .= "
            //         <center>
            //             <span class='badge rounded-pill bg-info'> On-going </span>
            //         </center>
            //     ";
            //     return $result;
            // })
            ->addColumn('operator', function($station){
                $result = '';
                $result .= $station->firstname.' '.$station->lastname;
                return $result;
            })
            ->rawColumns(['action','status','runcard_no','operator'])
            ->make(true);
        // }
    }

    public function add_assembly_runcard_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        if($request->device_name == 'CN171P-007-1002-VE(01)'){
            $validate_array = ['po_number' => 'required', 'p_zero_two_prod_lot' => 'required'];
        }else{
            $validate_array = ['po_number' => 'required', 's_zero_seven_prod_lot' => 'required', 's_zero_two_prod_lot' => 'required'];
        }

        $validator = Validator::make($data, $validate_array);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }else {
            try{
                if(!isset($request->assy_runcard_id)){
                    AssemblyRuncard::insert([
                                    'device_name'            => $request->device_name,
                                    'part_code'              => $request->device_code,
                                    'po_number'              => $request->po_number,
                                    'po_quantity'            => $request->po_quantity,
                                    'required_output'        => $request->required_output,
                                    'runcard_no'             => $request->runcard_no,
                                    'shipment_output'        => $request->shipment_output,
                                    'p_zero_two_prod_lot'    => $request->p_zero_two_prod_lot,
                                    'p_zero_two_device_id'   => $request->p_zero_two_device_id,
                                    's_zero_seven_prod_lot'  => $request->s_zero_seven_prod_lot,
                                    's_zero_seven_device_id' => $request->s_zero_seven_device_id,
                                    's_zero_two_prod_lot'    => $request->s_zero_two_prod_lot,
                                    's_zero_two_device_id'   => $request->s_zero_two_device_id,
                                    'total_assembly_yield'   => $request->total_assy_yield,
                                    'average_overall_yield'  => $request->ave_overall_yield,
                                    'created_by'             => Auth::user()->id,
                                    'last_updated_by'        => Auth::user()->id,
                                    'created_at'             => date('Y-m-d H:i:s'),
                                    'updated_at'             => date('Y-m-d H:i:s'),
                    ]);

                    DB::commit();
                    return response()->json(['result' => 1]);
                }else{
                    AssemblyRuncard::where('id', $request->assy_runcard_id)
                            ->update([
                                    'po_number'              => $request->po_number,
                                    'po_quantity'            => $request->po_quantity,
                                    'required_output'        => $request->required_output,
                                    'runcard_no'            => $request->runcard_no,
                                    'shipment_output'        => $request->shipment_output,
                                    'p_zero_two_prod_lot'    => $request->p_zero_two_prod_lot,
                                    'p_zero_two_device_id'   => $request->p_zero_two_device_id,
                                    's_zero_seven_prod_lot'  => $request->s_zero_seven_prod_lot,
                                    's_zero_seven_device_id' => $request->s_zero_seven_device_id,
                                    's_zero_two_prod_lot'    => $request->s_zero_two_prod_lot,
                                    's_zero_two_device_id'   => $request->s_zero_two_device_id,
                                    'total_assembly_yield'   => $request->total_assy_yield,
                                    'average_overall_yield'  => $request->ave_overall_yield,
                                    'last_updated_by'        => Auth::user()->id,
                                    'updated_at'             => date('Y-m-d H:i:s'),
                            ]);

                    DB::commit();
                    return response()->json(['result' => 1]);
                }
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    public function add_assembly_runcard_station_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        // return $data;
        $validator = Validator::make($data, [
            'runcard_station' => 'required'
        ]);

        // if($request->runcard_station == 4){ //Lubricant Coating
        //     $validate_array = ['runcard_station' => 'required', 'p_zero_two_prod_lot' => 'required'];
        // }else if($request->runcard_station == 5){//Lot Marking
        //     $validate_array = ['runcard_station' => 'required', 's_zero_seven_prod_lot' => 'required', 's_zero_two_prod_lot' => 'required'];
        // }else if($request->runcard_station == 6){//Visual Inspection
        //     $validate_array = ['runcard_station' => 'required', ];
        // }

        // $validator = Validator::make($data, $validate_array);

        if ($validator->fails()) {
            return response()->json(['validation' => 'hasError', 'error' => $validator->messages()]);
        }else {
            try{
                if(!isset($request->assy_runcard_station_id)){
                    if(AssemblyRuncardStation::where('assembly_runcards_id', $request->station_assy_runcard_id)->where('station', $request->runcard_station)->exists()){
                        return response()->json(['result' => 2]);
                    }else{
                        // $isFirstStationExist = AssemblyRuncardStation::where('')
                        // device_details[0].material_process[index].station_details[0].stations['id']

                        $assy_runcard_station_id = AssemblyRuncardStation::insertGetId([
                                            'assembly_runcards_id'  => $request->station_assy_runcard_id,
                                            'station'               => $request->runcard_station,
                                            'station_step'          => $request->step,
                                            'date'                  => $request->date,
                                            'operator_name'         => Auth::user()->id,
                                            'input_quantity'        => $request->input_qty,
                                            'ng_quantity'           => $request->ng_qty,
                                            'output_quantity'       => $request->output_qty,
                                            'station_yield'         => $request->station_yield,
                                            'mode_of_defect'         => $request->mode_of_defect,
                                            'defect_qty'            => $request->defect_quantity,
                                            'ml_per_shot'           => $request->ml_per_shot,
                                            'total_lubricant_usage' => $request->total_lubricant_usage,
                                            'doc_no_wi'             => $request->doc_no_work_i,
                                            'doc_no_r_drawing'      => $request->doc_no_r_drawing,
                                            'doc_no_a_drawing'      => $request->doc_no_a_drawing,
                                            'doc_no_g_drawing'      => $request->doc_no_g_drawing,
                                            // 'date_code'             => $request->date_code,
                                            // 'bundle_qty'            => $request->bundle_quantity,
                                            'remarks'               => $request->remarks,
                                            'created_by'            => Auth::user()->id,
                                            'last_updated_by'       => Auth::user()->id,
                                            'created_at'            => date('Y-m-d H:i:s'),
                                            'updated_at'            => date('Y-m-d H:i:s'),
                        ]);

                        AssemblyRuncard::where('id', $request->station_assy_runcard_id)
                            ->update([
                                    'shipment_output' => $request->output_qty,
                            ]);
                    }
                }else{
                    $assy_runcard_station_id = AssemblyRuncardStation::where('id', $request->assy_runcard_station_id)
                                        ->where('assembly_runcards_id', $request->station_assy_runcard_id)
                                        ->update([
                                            'date'                  => $request->date,
                                            'operator_name'         => Auth::user()->id,
                                            'input_quantity'        => $request->input_qty,
                                            'ng_quantity'           => $request->ng_qty,
                                            'output_quantity'       => $request->output_qty,
                                            'station_yield'         => $request->station_yield,
                                            'mode_of_defect'         => $request->mode_of_defect,
                                            'defect_qty'            => $request->defect_quantity,
                                            'ml_per_shot'           => $request->ml_per_shot,
                                            'total_lubricant_usage' => $request->total_lubricant_usage,
                                            'doc_no_wi'             => $request->doc_no_work_i,
                                            'doc_no_r_drawing'      => $request->doc_no_r_drawing,
                                            'doc_no_a_drawing'      => $request->doc_no_a_drawing,
                                            'doc_no_g_drawing'      => $request->doc_no_g_drawing,
                                            // 'date_code'             => $request->date_code,
                                            // 'bundle_qty'            => $request->bundle_quantity,
                                            'remarks'               => $request->remarks,
                                            'last_updated_by'       => Auth::user()->id,
                                            'updated_at'            => date('Y-m-d H:i:s'),
                                        ]);

                        AssemblyRuncard::where('id', $request->station_assy_runcard_id)
                            ->update([
                                    'shipment_output' => $request->output_qty,
                        ]);
                }

                if(isset($request->mod_id)){
                    $is_id_deleted = AssemblyRuncardStationsMods::where('assembly_runcard_stations_id', $assy_runcard_station_id)->delete();

                    // return $request->mod_id;
                    foreach ($request->mod_id as $key => $value) {
                        AssemblyRuncardStationsMods::insert([
                            'assembly_runcards_id'         => $request->station_assy_runcard_id,
                            'assembly_runcard_stations_id' => $assy_runcard_station_id,
                            'mod_id'                       => $request->mod_id[$key],
                            'mod_quantity'                 => $request->mod_quantity[$key],
                            'created_by'                   => Auth::user()->id,
                            'last_updated_by'              => Auth::user()->id,
                            'created_at'                   => date('Y-m-d H:i:s'),
                            'updated_at'                   => date('Y-m-d H:i:s'),
                        ]);
                    }

                }else{
                    if(AssemblyRuncardStationsMods::where('assembly_runcard_stations_id', $assy_runcard_station_id)->exists()){
                        $is_id_deleted = AssemblyRuncardStationsMods::where('assembly_runcard_stations_id', $assy_runcard_station_id)->delete(); //returns true/false
                    }
                }

                return response()->json(['result' => 1, 'station' => $request->runcard_station,  'shipment_output' => $request->output_qty]);
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    public function chck_existing_stations(Request $request){
        $assy_runcard_details = AssemblyRuncard::with('device_details.material_process')->where('id', $request->runcard_id)->first();
        $mat_process_steps = [];
        foreach ($assy_runcard_details->device_details->material_process as $processes){
            $mat_process_steps[] = $processes->step;
        }

        // $assy_runcard_details = $assy_runcard_details->
        $existing_station = AssemblyRuncardStation::whereNull('deleted_at')->where('assembly_runcards_id', $request->runcard_id)->get();
        $steps = [];
        foreach ($existing_station as $station){
            $steps[] = $station->station_step;
        }
        $mat_process_steps[] = $steps;

        // return $mat_process_steps;
        // return $steps;
        // situation #1 CN171P UPTO STEP 2 ONLY
        // situation #2 CN171S UPTO STEP 3
        // $current_step = 0;
        if(in_array($steps, $mat_process_steps)){
            // return 'dito';
            if(count($steps) < count($mat_process_steps) - 1){
                $current_step = count($steps)+1;
                $output_qty = AssemblyRuncardStation::whereNull('deleted_at')
                                                        ->where('assembly_runcards_id', $request->runcard_id)
                                                        ->where('station_step', count($steps))
                                                        ->first();

                if(isset($output_qty->output_quantity)){
                    $output_quantity = $output_qty->output_quantity;
                }else{
                    $output_quantity = '';
                }
                // return $output_qty;
            }else{
                $current_step = 0; //END STATION STEP
                $output_quantity = '';
            }
        }else{
            $current_step = 1; //END STATION STEP
            $output_quantity = '';
        }

        // if(in_array(1, $steps) && in_array(1, $mat_process_steps)){
        //     if(in_array(2, $steps)){
        //         if(in_array(3, $steps)){
        //             $current_step = 0; //END STATION STEP
        //         }else if(in_array(3, $mat_process_steps)){
        //             $current_step = 3; //STATION STEP 3
        //         }else{
        //             $current_step = 0; //END STATION STEP
        //         }
        //     }else if(in_array(2, $mat_process_steps)){
        //         $current_step = 2;
        //     }else{
        //         $current_step = 0; //END STATION STEP
        //     }
        // }else if(in_array(1, $mat_process_steps)){
        //     $current_step = 1;
        // }else{
        //     $current_step = 0; //END STATION STEP
        // }
        return response()->json(['current_step' => $current_step, 'output_quantity' => $output_quantity]);
    }

    public function update_assy_runcard_status(Request $request){
        date_default_timezone_set('Asia/Manila');
        // session_start();
        AssemblyRuncard::where('id', $request->runcard_id)
                    ->update([
                        'status'              => 1,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

        AssemblyRuncardStation::where('assembly_runcards_id', $request->runcard_id)
                    ->update([
                        'status'              => 1,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

                    DB::commit();
        return response()->json(['result' => 1]);
    }

    public function update_assembly_status(Request $request){
        date_default_timezone_set('Asia/Manila');
        // session_start();
        AssemblyRuncard::where('id', $request->cnfrm_assy_id)
                    ->update([
                        'status'              => 3,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

        AssemblyRuncardStation::where('assembly_runcards_id', $request->cnfrm_assy_id)
                    ->update([
                        'status'              => 3,
                        'last_updated_by'     => Auth::user()->id,
                        'updated_at'          => date('Y-m-d H:i:s'),
                    ]);

                    DB::commit();
        return response()->json(['result' => 'Successful']);
    }

    public function get_assembly_qr_code (Request $request)
    {
        // $first_molding = FirstMolding::leftJoin('first_molding_devices', function($join) {
        //     $join->on('first_moldings.first_molding_device_id', '=', 'first_molding_devices.id');
        // })
        // ->where('first_moldings.id',$request->first_molding_id)
        // ->whereNull('first_moldings.deleted_at')
        // ->first([
        // 'po_no AS po','item_code AS code','item_name AS name',
        // 'production_lot AS lot_no','production_lot_extension AS lot_no_ext',
        // 'po_qty AS qty','shipment_output AS output_qty','first_molding_devices.device_name AS device_name'
        // ]);

        $assembly = AssemblyRuncard::select('po_number',
                                            'po_quantity',
                                            'device_name',
                                            'part_code',
                                            'runcard_no',
                                            'shipment_output',
                                            DB::raw("CONCAT( firstname, ' ', lastname) AS operator_name"))
                                    ->leftJoin('assembly_runcard_stations', function($join) {
                                        $join->on('assembly_runcard_stations.assembly_runcards_id', '=' ,'assembly_runcards.id');
                                    })
                                    ->leftJoin('users', function($join) {
                                        $join->on('users.id', '=', 'assembly_runcard_stations.operator_name');
                                    })
                                    ->where('assembly_runcards.id', $request->runcard_id)
                                    ->whereNull('assembly_runcards.deleted_at')
                                    ->first();

        $qrcode = QrCode::format('png')
        ->size(300)->errorCorrection('H')
        ->generate(json_encode($assembly));

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $qr_code,
            'text' =>  "<strong>$assembly->po_number</strong><br>
            <strong>$assembly->po_quantity</strong><br>
            <strong>$assembly->device_name</strong><br>
            <strong>$assembly->part_code</strong><br>
            <strong>$assembly->runcard_no</strong><br>
            <strong>$assembly->shipment_output</strong><br>
            <strong>$assembly->operator_name</strong><br>
            "
        );
        // <strong>$assembly->qty</strong><br>
        // <strong>$assembly->output_qty</strong><br>

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>PO No:</td>
                    <td>$assembly->po_number</td>
                </tr>
                <tr>
                    <td>PO Quantity:</td>
                    <td>$assembly->po_quantity</td>
                </tr>
                <tr>
                    <td>Device Name:</td>
                    <td>$assembly->device_name</td>
                </tr>
                <tr>
                    <td>Part Code:</td>
                    <td>$assembly->part_code</td>
                </tr>
                <tr>
                    <td>Production Lot #:</td>
                    <td>$assembly->runcard_no</td>
                </tr>
                <tr>
                    <td>Shipment Output:</td>
                    <td>$assembly->shipment_output</td>
                </tr>
                <tr>
                    <td>Operator Name:</td>
                    <td>$assembly->operator_name</td>
                </tr>
            </table>
        ";
        // <tr>
        //     <td>Shipment Output:</td>
        //     <td>$assembly->output_qty</td>
        // </tr>
        // <tr>
        //     <td>PO Quantity:</td>
        //     <td>$assembly->qty</td>
        // </tr>

        return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'assembly_data' => $assembly]);
    }

    // public function get_total_yield(Request $request){
    //     $fmold_total_yield = FirstMolding::with('firstMoldingDevice')
    //                                         ->whereNull('deleted_at')
    //                                         ->where('production_lot', $request->production_lot)
    //                                         ->get();

    //         $TotalYield = DB::connection('mysql')->select("SELECT fmold.material_yield as fmold_mat_yield, smold.material_yield as smold_mat_yield, assy.total_assembly_yield as total_assy_yield FROM first_moldings as fmold
    //                     INNER JOIN sec_molding_runcards AS smold ON fmold.production_lot = sub.id
    //                     INNER JOIN assembly_runcards AS assy ON runcard_station.station = sub.id
    //                     WHERE runcard_station.assembly_runcards_id = '$request->assy_runcard_id'
    //                     ORDER BY runcard_station.id DESC
    //         ");
    //         // material_yield fmold, smold
    //         //total_assembly_yield
    // }
}

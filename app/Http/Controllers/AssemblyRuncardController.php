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

use App\Models\Process;
use App\Models\Device;

class AssemblyRuncardController extends Controller
{
    public function get_data_from_matrix(Request $request){
        $material_name = [];
        $matrix_data = Device::with(['material_process.material_details'])->with(['material_process.station_details.stations'])->where('name', $request->device_name)->where('status', 1)->get();
        foreach($matrix_data[0]->material_process[0]->material_details as $material_details){
            $material_name[] = $material_details->material_type;
        }
        $material_type = implode(',',$material_name);

        $station_details = $matrix_data[0]->material_process[0]->station_details;
        return response()->json(['material_details' => $material_type, 'station_details' => $station_details]);
    }

    public function get_data_from_2nd_molding(Request $request){
        $sec_molding_runcard_data = SecMoldingRuncard::whereNull('deleted_at')
                                            ->where('pmi_po_number', $request->po_number)
                                            ->get();
        return response()->json(['sec_molding_runcard_data' => $sec_molding_runcard_data]);
    }

    public function chk_device_prod_lot_from_first_molding(Request $request){
        $device_name_by_prod_lot = FirstMolding::with('firstMoldingDevice')
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
            $device_name     = $device_name_by_prod_lot[0]->firstMoldingDevice->device_name;
            $production_lot  = $device_name_by_prod_lot[0]->production_lot;
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

    public function get_assembly_runcard_data(Request $request){
        $assembly_runcard_data = AssemblyRuncard::when($request->assy_runcard_station_id, function ($with_query) use ($request){
                                                    return $with_query-> with(['assembly_runcard_station.station_name','assembly_runcard_station.user','assembly_runcard_station' => function($station_id_query) use ($request){
                                                            return $station_id_query->where('id', $request->assy_runcard_station_id); 
                                                        }]);
                                                })
                                                ->whereNull('deleted_at')
                                                ->where('id', $request->assy_runcard_id)
                                                ->get();

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
                $result .= "
                    <center>
                        <button class='btn btn-primary btn-sm mr-1 btnUpdateAssemblyRuncardData' assembly_runcard-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
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
                        ORDER BY runcard_station.id DESC
            ");

            // return $AssemblyRuncardStationData;

            return DataTables::of($AssemblyRuncardStationData)
            ->addColumn('action', function($station){
                $result = '';
                $result .= "
                    <center>
                        <button class='btn btn-primary btn-sm mr-1 btnUpdateAssyRuncardStationData' assy_runcard_stations-id='$station->id'><i class='fa-solid fa-pen-to-square'></i></button>
                    </center>
                ";
                return $result;
            })
            ->addColumn('status', function($station){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
            ->addColumn('runcard_no', function($station){
                $result = '';
                $result .= "
                    <center>
                        <span class='badge rounded-pill bg-info'> On-going </span>
                    </center>
                ";
                return $result;
            })
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
        
        if($request->series_name == 'CN171P-007-1002-VE(01)'){
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
                                    'po_number'              => $request->po_number,
                                    'po_quantity'            => $request->po_quantity,
                                    'required_output'        => $request->required_output,
                                    'runcard_no'            => $request->runcard_no,
                                    'production_lot'        => $request->production_lot,
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
                                    'production_lot'        => $request->production_lot,
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
                        $assy_runcard_station_id = AssemblyRuncardStation::insertGetId([
                                            'assembly_runcards_id'  => $request->station_assy_runcard_id,
                                            'station'               => $request->runcard_station,
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
                                            'date_code'             => $request->date_code,
                                            'bundle_qty'            => $request->bundle_quantity,
                                            'remarks'               => $request->remarks,
                                            'created_by'            => Auth::user()->id,
                                            'last_updated_by'       => Auth::user()->id,
                                            'created_at'            => date('Y-m-d H:i:s'),
                                            'updated_at'            => date('Y-m-d H:i:s'),
                        ]);
                    }
                }else{
                    $assy_runcard_station_id = AssemblyRuncardStation::where('id', $request->assy_runcard_station_id)
                                        ->where('assembly_runcards_id', $request->station_assy_runcard_id)
                                        ->update([
                                            'station'               => $request->runcard_station,
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
                                            'date_code'             => $request->date_code,
                                            'bundle_qty'            => $request->bundle_quantity,
                                            'remarks'               => $request->remarks,
                                            'last_updated_by'       => Auth::user()->id,
                                            'updated_at'            => date('Y-m-d H:i:s'),
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
                
                return response()->json(['result' => 1]);
            } catch (\Throwable $th) {
                return $th;
            }
        }
    }

    // public function chck_existing_stations(Request $request){
    //     $assembly_runcard_data = AssemblyRuncard::with(['assembly_runcard_station.station_name','assembly_runcard_station.user','assembly_runcard_station'])
    //                                             ->whereNull('deleted_at')
    //                                             ->where('id', $request->assy_runcard_id)
    //                                             ->get();
                                                
    //     return response()->json(['assembly_runcard_data' => $assembly_runcard_data]);
    // }

    // public function update_assy_runcard_status(Request $request){
    //     date_default_timezone_set('Asia/Manila');
    //     // session_start();
    //         if($request->stamping_ipqc_status == 1){
    //             //For Mass Production
    //             $fs_prod_status = 1;
    //             $ipqc_status = 3;

    //         }else if($request->stamping_ipqc_status == 2){
    //             //For Re-Setup
    //             $fs_prod_status = 3;
    //             $ipqc_status = 4;
    //         }
    //         StampingIpqc::where('id', $request->stamping_ipqc_id)
    //                 ->update([
    //                     'status'              => $ipqc_status,
    //                     'last_updated_by'     => Auth::user()->id,
    //                     'updated_at'          => date('Y-m-d H:i:s'),
    //                 ]);

    //             FirstStampingProduction::where('id', $request->fs_productions_id)
    //             ->update(['status' => $fs_prod_status]);

    //                 DB::commit();
    //     return response()->json(['result' => 'Successful']);
    // }
}

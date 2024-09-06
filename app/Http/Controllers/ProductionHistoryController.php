<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\FirstMolding;
use Illuminate\Http\Request;
use App\Models\ProductionHistory;
use App\Models\SecMoldingRuncard;
use App\Models\FirstMoldingDevice;
use Illuminate\Support\Facades\DB;
use App\Models\ProductionHistoryPartsMat;
use Illuminate\Support\Facades\Validator;

class ProductionHistoryController extends Controller
{
    protected $shots_accum = 0;
    public function load_prodn_history_details(Request $request){
        $dev_id;
        if($request->first_molding_device_id == 2 || $request->first_molding_device_id == 3){
            $dev_id = [2,3];
        }
        else{
            $dev_id = [$request->first_molding_device_id];
        }

        $prodn_history = ProductionHistory::with([
            'operator_info',
            'qc_info'
        ])
        ->whereIn('fkid_molding_devices', $dev_id)->get();

        return DataTables::of($prodn_history)
        ->addColumn('action', function($prodn_history){
            $result = "";
            $result .= "<center>";

            $result .= "<button class='btn btn-sm btn-primary btnView' data-id='$prodn_history->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";
            if($prodn_history->status == 1){

                $result .= "<button class='btn btn-secondary btn-sm btnEdit ml-1' data-id='$prodn_history->id' data-function='1'><i class='fa-solid fa-pen-to-square'></i></button>";
            }

            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($prodn_history){
            $result = "";
            $result .= "<center>";

            if($prodn_history->status == 0){
                $result .= "<span class='badge rounded-pill bg-warning'>For IPQC</span>";
            }else if($prodn_history->status == 1){
                $result .= "<span class='badge rounded-pill bg-primary'>Done IPQC</span>";
            }else if($prodn_history->status == 2){
                $result .= "<span class='badge rounded-pill bg-success'>Completed</span>";
            }
            $result .= "</center>";

            return $result;
        })
        ->addColumn('shots_accum', function($prodn_history){
            $result = "";

            $shots = $prodn_history->shots;
            $this->shots_accum = $this->shots_accum + $shots;

            $result .= $this->shots_accum;
            return $result;
        })
        ->addColumn('act_cycle_time', function($prodn_history){
            $result = "";
            $result .= $prodn_history->act_cycle_time.' s';
            return $result;
        })
        ->addColumn('shot_weight', function($prodn_history){
            $result = "";
            $result .= $prodn_history->shot_weight.' g';
            return $result;
        })
        ->addColumn('product_weight', function($prodn_history){
            $result = "";
            $result .= $prodn_history->product_weight.' g';
            return $result;
        })
        ->addColumn('screw_most_fwd', function($prodn_history){
            $result = "";
            $result .= $prodn_history->screw_most_fwd.' mm';
            return $result;
        })
        ->addColumn('remarks', function($prodn_history){
            $result = "";
            $result .= "<center>";

            if($prodn_history->remarks == 1){
                $result .= "<span class='badge rounded-pill bg-success'>Continuous Production</span>";
            }else if($prodn_history->remarks == 21){
                $result .= "<span class='badge rounded-pill bg-danger'>Temporary Stop</span>";
            }else if($prodn_history->remarks == 3){
                $result .= "<span class='badge rounded-pill bg-success'>Maintenance Cycle</span>";
            }else if($prodn_history->remarks == 4){
                $result .= "<span class='badge rounded-pill bg-danger'>Die-set/Machine Repair</span>";
            }else if($prodn_history->remarks == 5){
                $result .= "<span class='badge rounded-pill bg-success'>Evaluation</span>";
            }else if($prodn_history->remarks == 6){
                $result .= "<span class='badge rounded-pill bg-success'>Finish PO</span>";
            }else if($prodn_history->remarks == 7){
                $result .= "<span class='badge rounded-pill bg-warning'>Request for overhaul</span>";
            }
            $result .= "</center>";

            return $result;
        })
        ->addColumn('operator', function($prodn_history){
            $result = "";

            $firstname = $prodn_history->operator_info->firstname;
            $lastname = $prodn_history->operator_info->lastname;
            $operator = $firstname.' '.$lastname;

            $result .= $operator;
            return $result;
        })
        ->addColumn('qc', function($prodn_history){
            $result = "";
            if ($prodn_history->qc_info != null){
                $firstname = $prodn_history->qc_info->firstname;
                $lastname = $prodn_history->qc_info->lastname;
                $qc = $firstname.' '.$lastname;
            }else{
                $qc = '';
            }

            $result .= $qc;
            return $result;
        })

        ->rawColumns(['action', 'status', 'act_cycle_time', 'shot_weight', 'product_weight', 'screw_most_fwd', 'remarks', 'shots_accum', 'operator', 'qc'])
        ->make(true);
    }

    public function add_prodn_history(Request $request){
        try{
            date_default_timezone_set('Asia/Manila');
            $validation = array(
                'global_device_name_id' => ['required'],
                'prodn_date' => ['required'],
                'prodn_stime' => ['required'],
                'shift' => ['required'],
                'machine_no' => ['required'],
                'standard_para_date' => ['required'],
                'act_cycle_time' => ['required'],
                'shot_weight' => ['required'],
                'product_weight' => ['required'],
                'screw_most_fwd' => ['required'],
                'ccd_setting_s1' => ['required'],
                'ccd_setting_s2' => ['required'],
                'ccd_setting_ng' => ['required'],
                'remarks' => ['required'],
                'opt_id' => ['required'],
                'shots' => ['required'],
                'prodn_etime' => ['required'],
                'qc_id' => ['required'],
            );

        

            $data = $request->all();
            $validator = Validator::make($data, $validation);
            if ($validator->fails()) {
                return response()->json(['result' => '0', 'error' => $validator->messages()]);
            }else{
                DB::beginTransaction();
                    // $operator = implode($request->opt_name, ', ');
                    // return $request->all();
                    $add_process_array = array(
                        'fkid_molding_devices' => $request->global_device_name_id,
                        'status' => 2,
                        'prodn_date' => $request->prodn_date,
                        'prodn_stime' => $request->prodn_stime,
                        'shift' => $request->shift,
                        'machine_no' => $request->machine_no,
                        'standard_para_date' => $request->standard_para_date,
                        // 'standard_para_attach' => $request->standard_para_attach,
                        'act_cycle_time' => $request->act_cycle_time,
                        'shot_weight' => $request->shot_weight,
                        'product_weight' => $request->product_weight,
                        'screw_most_fwd' => $request->screw_most_fwd,
                        'ccd_setting_s1' => $request->ccd_setting_s1,
                        'ccd_setting_s2' => $request->ccd_setting_s2,
                        'ccd_setting_ng' => $request->ccd_setting_ng,
                        'changes_para' => $request->changes_para,
                        'remarks' => $request->remarks,
                        'opt_id' => $request->opt_id,
                        'shots' => $request->shots,
                        'prodn_etime' => $request->prodn_etime,
                        'qc_id' => $request->qc_id,

                    );
                    if(isset($request->prodn_history_id)){ // EDIT
                        ProductionHistory::where('id', $request->prodn_history_id)->update($add_process_array);
                        $production_history_id = $request->prodn_history_id;
                        // $is_first_molding_deleted = ProductionHistory::find($production_history_id)->delete();
                        ProductionHistoryPartsMat::where('prod_history_id', $production_history_id)->update([
                            'deleted_at'      => NOW()
                        ]);
                    }
                    else{ // ADD
                        // return $add_process_array;
                        $production_history_id = ProductionHistory::insertGetId($add_process_array);
                    }

                    if($request->pm_cat == 1){
                        /*
                            * pmaterial_code, pmaterial_name only
                            * pmat_lot_no only
                        */
                        $pm_code = $request->pmaterial_code;
                        $pm_name = $request->pmaterial_name;
                        foreach($request["firt_moldings_id"] as $key => $firt_moldings_id){
                                ProductionHistoryPartsMat::insert([
                                    'prod_history_id' => $production_history_id,
                                    'first_moldings_id' => $firt_moldings_id,
                                    'pm_group'        => 1,
                                    'pm_name'         => $pm_name,
                                    'pm_code'         => $pm_code,
                                    'created_by'      => session()->get('user_id'),
                                    'created_at'      => NOW()
                                ]);
                        }
                    }
                    else if($request->pm_cat == 2){
                        for ($i=0; $i < 3; $i++) {
                            $pm_name = $request["pmaterial_name2_$i"];
                            $pm_code = $request["pmaterial_code2_$i"];
                            $counter = 0;
                            foreach($request["sec_molding_runcards_id2_$i"] as $key => $sec_molding_runcards_id){
                                // echo json_encode($sec_molding_runcards_id);
                                ProductionHistoryPartsMat::insert([
                                    'prod_history_id' => $production_history_id,
                                    'sec_molding_runcards_id' => $sec_molding_runcards_id,
                                    'pm_group'        => "2_".$i,
                                    'pm_name'         => $pm_name,
                                    'pm_code'         => $pm_code,
                                    'created_by'      => session()->get('user_id'),
                                    'created_at'      => NOW()
                                ]);
                                $counter++;
                            }
                        }
                    }
                    else if($request->pm_cat == 3){
                        return $request->all();
                        for ($i=0; $i < 4; $i++) {
                            $pm_code = $request["pmaterial_code3_$i"];
                            $pm_name = $request["pmaterial_name3_$i"];
                            $counter = 0;
                            foreach($request["sec_molding_runcards_id"] AS $sec_molding_runcards_id){
                                ProductionHistoryPartsMat::insert([
                                    'prod_history_id' => $production_history_id,
                                    'sec_molding_runcards_id' => $sec_molding_runcards_id,
                                    'pm_group'        => "3_".$i,
                                    'pm_name'         => $pm_name,
                                    'pm_code'         => $pm_code,
                                    'created_by'      => session()->get('user_id'),
                                    'created_at'      => NOW()
                                ]);
                                $counter++;
                            }
                        }
                    }
                    DB::commit();
                    return response()->json(['result' => 1, 'msg' => 'Transaction Succesful']);
            }
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    public function get_optr_list(Request $request){
        return DB::connection('mysql')
        ->select("SELECT * FROM users WHERE position = 4");

    }

    public function get_material_list(Request $request){
        return DB::connection('mysql')
        ->select("SELECT a.material_code, a.material_type FROM material_process_materials a
            INNER JOIN devices b on b.id = a.mat_proc_id");
    }

    public function get_prodn_history_by_id(Request $request){
        $prod_history =  ProductionHistory::with([
            'operator_info',
            'qc_info',
            'first_molding_device'
        ])->whereNull('deleted_at')
        ->where('id', $request->id)->first();

        if($request->pm_cat == 1){
            $first_molding = FirstMolding::with('first_molding_material_list')
            ->whereNull('deleted_at')
            ->where('first_molding_device_id', $prod_history->fkid_molding_devices)
            ->whereDate('created_at', '=', $prod_history->prodn_date)
            ->get();
            return response()->json(['is_success' => 'true','prodHistory' => $prod_history,'first_molding'=>$first_molding]);
        }
        if($request->pm_cat == 2){
            $sec_molding_runcard = SecMoldingRuncard::whereNull('deleted_at')
            ->where('machine_number', $prod_history->machine_no)
            ->where('device_name', $prod_history->first_molding_device->device_name)
            ->whereDate('created_at', '=', $prod_history->prodn_date)
            ->get(['id','production_lot','contact_name_lot_number_one','contact_name_lot_number_second','me_name_lot_number_one','material_lot_number']);
            return response()->json(['is_success' => 'true','prodHistory' => $prod_history,'sec_molding_runcard'=>$sec_molding_runcard]);
        }
    }

    public function getMachine(Request $request){
        $machine = DB::connection('mysql')
        ->select("
            SELECT material_processes.id, material_processes.device_id, devices.*, material_process_machines.* FROM material_processes
            INNER JOIN devices
                ON devices.id = material_processes.device_id
            INNER JOIN material_process_machines
                ON material_process_machines.mat_proc_id = material_processes.id
            WHERE devices.name = '$request->material_name'
        ");

        return response()->json(['machine' => $machine]);
    }

    public function get_first_molding_devices_for_history(Request $request){
        $first_molding_device = FirstMoldingDevice::whereNull('deleted_at')
        ->where('device_name', '<>', 'CN171S-10#IN-L-VE')->get();
        // foreach ($first_molding_device as $key => $value_first_molding_device) {
        //     $arr_first_molding_device_id[] =$value_first_molding_device['id'];
        //     $arr_first_molding_device_value[] =$value_first_molding_device['device_name'];
        // }
        return response()->json([
            // 'id'    =>  $arr_first_molding_device_id,
            // 'value' =>  $arr_first_molding_device_value
            'data' => $first_molding_device
        ]);
    }
    public function get_first_molding_contact_lot_num_by_date_machine_num(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            $first_molding = FirstMolding::with('first_molding_material_list')
            ->whereNull('deleted_at')
            ->where('first_molding_device_id', $request->global_device_name_id)
            ->whereDate('created_at', '=', $request->prodn_date)
            ->get();
            if( count($first_molding) != 0 ){
                return response()->json(['is_success' => 'true','first_molding'=>$first_molding]);
            }else{
                $sec_molding_runcard = SecMoldingRuncard::whereNull('deleted_at')
                ->where('machine_number', $request->machine_no)
                ->where('device_name', $request->device_name)
                ->whereDate('created_at', '=', $request->prodn_date)
                ->get([ 'id','production_lot','contact_name_lot_number_one','contact_name_lot_number_second',
                        'me_name_lot_number_one','material_lot_number','lot_number_eight_first_molding_id',
                        'lot_number_nine_first_molding_id','lot_number_ten'
                ]);
                return response()->json(['is_success' => 'true','sec_molding_runcard'=>$sec_molding_runcard]);
            }


        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

}

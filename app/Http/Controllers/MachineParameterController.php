<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MpSetup;
use App\Models\MpHeater;
use App\Models\MpEjector;
use App\Models\MpSupport;
use App\Models\MpMoldOpen;
use App\Models\MpMoldClose;
use Illuminate\Http\Request;
use App\Models\MpInjectionTab;
use Illuminate\Support\Carbon;
use App\Models\InjectionTabList;
use App\Models\MachineParameter;
use Yajra\DataTables\DataTables;
use App\Models\MpInjectionTabList;
use Illuminate\Support\Facades\DB;
use App\Models\MpInjectionVelocity;
use App\Http\Requests\MpSetupRequest;
use App\Models\MpInjTabListLotNumber;
use App\Http\Requests\MpHeaterRequest;
use App\Http\Requests\MpEjectorRequest;
use App\Http\Requests\MpSupportRequest;
use App\Http\Requests\MpMoldOpenRequest;
use App\Http\Requests\MpMoldCloseRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\InjectionTabRequest;
use App\Http\Requests\MpInjectionTabRequest;
use App\Http\Requests\MpInjectionTabListRequest;
use App\Http\Requests\MachineParameterRequest;
use App\Http\Requests\MpInjectionVelocityRequest;


class MachineParameterController extends Controller
{
    public function loadMachineParameterOne(Request $request){
        // return 'true' ;
        date_default_timezone_set('Asia/Manila');
        try {
            $machine_parameter = DB::connection('mysql')
            ->select(' SELECT  parameters.*,machines.machine_name
                FROM machine_parameters AS parameters
                LEFT JOIN machines ON machines.id = parameters.machine_id
                WHERE machines.machine_category = 1 AND parameters.deleted_at IS NULL
                ORDER BY parameters.created_at DESC
            ');
            return DataTables::of($machine_parameter)
            ->addColumn('get_action', function($row){
                $result = '';
                $result .= '<center>';
                //<button type="button" class="btn btn-primary mb-3" machine-parameter-id='$row->id' id="btnAddMachine1" data-bs-toggle="modal" data-bs-target="#modalAddMachine1"><i class='fa-solid fa-pen-to-square'></i></button>
                $result .= "<button class='btn btn-info btn-sm mr-1' machine-parameter-id='$row->id' id='btnEditMachineParameter' data-bs-toggle='modal' data-bs-target='#modalAddMachine1'><i class='fa-solid fa-pen-to-square'></i></button>";
                $result .= '</center>';
                return $result;
            })
            ->addColumn('get_status', function($row){
                $result = '';
                $result .= "Status";
                return $result;
            })
            ->rawColumns(['get_action','get_status'])
            ->make(true);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function loadInjectionTabList(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            //machine_parameter_id
            // $machine_parameter_id= isset($request->machine_parameter_id) ? $request->machine_parameter_id : 0;
            if( isset( $request->machine_one_parameter_id )  ){
                $machine_parameter_id = $request->machine_one_parameter_id;
            }else if(    isset( $request->machine_two_parameter_id ) ){
                $machine_parameter_id = $request->machine_two_parameter_id;
            }else{
                $machine_parameter_id = 0;
            }

            $injection_tab_list = DB::connection('mysql')
            ->select('SELECT list.*,list.id as "injection_tab_list_id",parameter.id
                FROM mp_injection_tab_lists AS list
                LEFT JOIN machine_parameters parameter ON parameter.id = list.machine_parameter_id
                WHERE parameter.id ='.$machine_parameter_id.' AND  list.deleted_at IS NULL AND parameter.deleted_at IS NULL
                ORDER BY list.created_at DESC
            ');
            return DataTables::of($injection_tab_list)
            ->addColumn('get_action', function($row){
                $result = '';
                $result .= '<center>';
                //<button type="button" class="btn btn-primary mb-3" machine-parameter-id='$row->id' id="btnAddMachine1" data-bs-toggle="modal" data-bs-target="#modalAddMachine1"><i class='fa-solid fa-pen-to-square'></i></button>
                $result .= "<button type='button' class='btn btn-info btn-sm mr-1' injection-tab-list-id='$row->injection_tab_list_id' id='btnEditInjectionTabList' data-bs-toggle='modal' data-bs-target='#modalAddInjectionTabList'><i class='fa-solid fa-pen-to-square'></i></button>";
                $result .= '</center>';
                return $result;
            })
            ->addColumn('get_total_time', function($row){
                $result = '';
                $result .= '<center>';
                //<button type="button" class="btn btn-primary mb-3" machine-parameter-id='$row->id' id="btnAddMachine1" data-bs-toggle="modal" data-bs-target="#modalAddMachine1"><i class='fa-solid fa-pen-to-square'></i></button>
                $result .= "dsad";
                $result .= '</center>';
                return $result;
            })
            ->rawColumns(['get_action','get_total_time'])
            ->make(true);
        } catch (Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function getMachineDetailsForm1(Request $request){
        $machine_details_1 = Machine::where('status',1)
        ->where('machine_category', 1)
        ->get();
        return response()->json(['machine_details_1' => $machine_details_1]);
    }

    public function getMachineDetailsForm2(Request $request){
        $machine_details_2 = Machine::
        where('status',1)
        ->where('machine_category', 2)
        ->get();

        return response()->json(['machine_details_2' => $machine_details_2]);

        // return $machine_details;
    }
    public function saveMachineOne(
        Request $request,MachineParameterRequest $machine_parameter_request,
        MpMoldCloseRequest $mold_close_request,MpEjectorRequest $ejector_request,
        MpMoldOpenRequest $mold_open_request,MpHeaterRequest $heater_request,
        MpInjectionVelocityRequest $injection_velocity_request,MpSupportRequest $support_request,
        MpInjectionTabRequest $injection_tab_request,
        MpSetupRequest $mp_setup_request
    ){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try {
            if( isset($request->machine_parameter_id) || $request->machine_parameter_id != ''){ //Edit Machine Parameter
                MachineParameter::where('id',$request->machine_parameter_id)->whereNull('deleted_at')->update($machine_parameter_request->validated());
                MpMoldClose::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($mold_close_request->validated());
                MpMoldOpen::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($mold_open_request->validated());
                MpSetup::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($mp_setup_request->validated());
                MpHeater::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($heater_request->validated());
                MpInjectionVelocity::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($injection_velocity_request->validated());
                MpSupport::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($support_request->validated());
                //This InjectionTab Table is for Machine 1 Requirement Only
                MpInjectionTab::where('machine_parameter_id',$request->machine_parameter_id)->whereNull('deleted_at')->update($injection_tab_request->validated());
            }else{ //Add Machine Parameter
                // return 'false';

                // return $mold_open_request->validated();
                $machine_parameter_id = MachineParameter::insertGetId($machine_parameter_request->validated());
                MachineParameter::where('id',$machine_parameter_id)->whereNull('deleted_at')->update([
                    'created_at' => Carbon::now(),
                ]);

                $mold_close_id = MpMoldClose::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                ]);
                MpMoldClose::where('id',$mold_close_id)->update(
                    $mold_close_request->validated()
                );

                $ejector_lub_id = MpEjector::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpEjector::where('id',$ejector_lub_id)->update(
                    $ejector_request->validated()
                );
                $mold_open_id = MpMoldOpen::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);

                MpMoldOpen::where('id',$mold_open_id)->update(
                    $mold_open_request->validated()
                );
                $heater_id = MpHeater::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpHeater::where('id',$heater_id)->update(
                    $heater_request->validated()
                );

                $injection_velocity_id = MpInjectionVelocity::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpInjectionVelocity::where('id',$injection_velocity_id)->update(
                    $injection_velocity_request->validated()
                );
                $injection_tab_id = MpSupport::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpSupport::where('id',$injection_tab_id)->update(
                    $support_request->validated()
                );
                $injection_tab_id = MpInjectionTab::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpInjectionTab::where('id',$injection_tab_id)->update(
                    $injection_tab_request->validated()
                );
                $mp_setup_id = MpSetup::insertGetId([
                    'machine_parameter_id' => $machine_parameter_id,
                    'created_at' => Carbon::now(),
                ]);
                MpSetup::where('id',$mp_setup_id)->update(
                    $mp_setup_request->validated()
                );
                // DB::commit();
                // return 'add';
                /* */
            }
            // DB::rollback();
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function editMachineParameter(Request $request){
        // return $request->all();
        date_default_timezone_set('Asia/Manila');
        try {
            $machine_parameter_id = $request->machine_parameter_id;

            $machine_parameter_detail =  MachineParameter::with(
                'mold_close','ejector_lub','mold_open', 'setup',
                'heater','injection_velocity','support','injection_tab',
            )->where('id',$machine_parameter_id)->get();

            return response()->json([
                'is_success' => 'true',
                'machine_parameter_detail' => $machine_parameter_detail[0],
                'created_at' => Carbon::parse($machine_parameter_detail[0]->created_at)->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function getOperatorName(Request $request){

        date_default_timezone_set('Asia/Manila');
        try {
            $pats_ppd_user = DB::connection('mysql')
            ->select(" SELECT * FROM users ");
            foreach ($pats_ppd_user as $key => $value_pats_ppd_user) {
                $arr_pats_ppd_user_id[] =$value_pats_ppd_user->id;
                $arr_pats_ppd_user_value[] =$value_pats_ppd_user->firstname .' '. $value_pats_ppd_user->lastname;
            }
            return response()->json([
                'id'    =>  $arr_pats_ppd_user_id,
                'value' =>  $arr_pats_ppd_user_value
            ]);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function saveInjectionTabList(Request $request,MpInjectionTabListRequest $injection_tab_list_request){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();

        try {
            $validation = array(
                'inj_tab_list_operator_name' => ['required'],
            );
            $validator = Validator::make($request->all(), $validation);
            if ($validator->fails()) {
                return response()->json(['is_success' => 'false', 'errors' => $validator->messages()],422);
            }

            if( isset($request->injection_tab_list_id) || $request->injection_tab_list_id != ''){ //Edit Machine Parameter
                // MpInjectionTabList::where('id',$request->injection_tab_list_id)->whereNull('deleted_at')->update($injection_tab_list_request->validated());
                $injection_tab_list_id = MpInjectionTabList::where('id',$request->injection_tab_list_id)->whereNull('deleted_at')
                ->update([
                    'machine_parameter_id' => $request->machine_parameter_id,
                    'inj_tab_list_operator_name' => $request->inj_tab_list_operator_name,
                ]);
                $mp_injection_tab_list_id = $request->injection_tab_list_id;
            }else{
                $injection_tab_list_id = MpInjectionTabList::insertGetId([
                    'machine_parameter_id' => $request->machine_parameter_id,
                    'inj_tab_list_operator_name' => $request->inj_tab_list_operator_name,
                    'created_at' => Carbon::now(),
                ]);
                MpInjectionTabList::where('id',$injection_tab_list_id)->whereNull('deleted_at')->update(
                    $injection_tab_list_request->validated()
                );
                $mp_injection_tab_list_id = $injection_tab_list_id;
            }
            /* Get the lot number, delete the existing then insert new*/
            // $mp_injection_tab_list_id = 3;
            $inj_tab_lot_number = $request->inj_tab_lot_number;
            if(isset($inj_tab_lot_number)){
                MpInjTabListLotNumber::where('mp_injection_tab_list_id', $mp_injection_tab_list_id)->update([
                    'deleted_at' => date('Y-m-d H:i:s')
                ]);
                foreach ( $inj_tab_lot_number as $key => $value) {
                    MpInjTabListLotNumber::insert([
                        'mp_injection_tab_list_id'    => $mp_injection_tab_list_id,
                        'lot_number'              => $inj_tab_lot_number[$key],
                        'created_at'            => date('Y-m-d H:i:s')
                    ]);
                }

            }else{
                if(MpInjTabListLotNumber::where('mp_injection_tab_list_id', $mp_injection_tab_list_id)->exists()){
                    MpInjTabListLotNumber::where('mp_injection_tab_list_id', $mp_injection_tab_list_id)->update([
                        'deleted_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
            DB::commit();
            return response()->json(['is_success' => 'true']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

    public function editInjectionTabList(Request $request){
        date_default_timezone_set('Asia/Manila');
        try {
            $injection_tab_details = MpInjectionTabList::where('id',$request->injection_tab_list_id)->whereNull('deleted_at')->get();
            $inj_tab_list_lot_number = MpInjTabListLotNumber::where('mp_injection_tab_list_id',$request->injection_tab_list_id)->whereNull('deleted_at')->get();
            return response()->json(['is_success' => 'true',
            'injection_tab_details'=>$injection_tab_details,
            'inj_tab_list_lot_number_details' => $inj_tab_list_lot_number]);
        } catch (\Exception $e) {
            return response()->json(['is_success' => 'false', 'exceptionError' => $e->getMessage()]);
        }
    }

}

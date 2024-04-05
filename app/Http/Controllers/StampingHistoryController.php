<?php
namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Auth;
use DataTables;

use App\Models\User;
use App\Models\StampingHistory;
use App\Models\FirstStampingProduction;

class StampingHistoryController extends Controller
{
    public function getStampingProdnMaterialName(Request $request){
        date_default_timezone_set('Asia/Manila');

        $stamping_prodn_material_name = FirstStampingProduction::select('material_name')->whereNull('deleted_at')->distinct()->get();
        return response()->json(['getPrdnMaterialName'  => $stamping_prodn_material_name]);
    }

    public function getPatsPpdUser(Request $request){
        date_default_timezone_set('Asia/Manila');

        $users = User::where('status', 1)->whereIn('position',[0,1,4])->orderBy('firstname', 'ASC')->get();
        return response()->json(['users'  => $users]);
    }

    public function getPreviousShotAccumulatedByPartName(Request $request){
        date_default_timezone_set('Asia/Manila');

        $new_total_shot_accum = 0;
        $get_previous_shot_accumulated = StampingHistory::where('part_name', $request->materialName)->where('logdel', 0)->orderBy('id', 'DESC')->get();
        for($i=0; $i < count($get_previous_shot_accumulated); $i++) {
            $new_total_shot_accum += $get_previous_shot_accumulated[$i]->total_shot;
        }

        return response()->json(['newTotalShotAccum'  => $new_total_shot_accum]);
    }

    public function viewStampingHistory(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_stamping_history = StampingHistory::where('part_name', $request->materialName)->where('logdel', 0)->orderBy('id', 'DESC')->get();
        return DataTables::of($get_stamping_history)
        ->addColumn('action', function($get_stamping_info){
            $result = '<center>';
            $result .= '
                <button class="btn btn-dark btn-sm text-center
                    actionEditStampingHistory"
                    stamping_history-id="'. $get_stamping_info->id .'"
                    part_name="'. $get_stamping_info->part_name .'"
                    data-bs-toggle="modal"
                    data-bs-target="#modalStampingHistory"
                    data-bs-keyboard="false" title="View">
                    <i class="nav-icon fa fa-edit"></i>
                </button>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('total_shot_accumulated', function($get_stamping_info){
            $result = '<center>';

            $next_to_last_shot = StampingHistory::where('part_name', $get_stamping_info->part_name)
                ->where('id', '<=', $get_stamping_info->id)
                ->where('logdel', 0)
                ->orderBy('id', 'desc')
                ->get();

            $total_sum = 0;
            for ($i=0; $i < count($next_to_last_shot); $i++) {
                $total_sum += $next_to_last_shot[$i]->total_shot;
            }

            $result .= $total_sum;
            $result .= '</center>';
            return $result;
        })
        ->addColumn('operator', function($get_stamping_info){
            $explode_operator = explode(',',$get_stamping_info->operator);
            $result = '<center>';
            for($x=0; $x < count($explode_operator); $x++){
                $get_operator = user::where('employee_id', $explode_operator[$x])->get();
                $result .= $get_operator[0]->firstname.' '.$get_operator[0]->lastname."\n\n";
            }
            $result .= '</center>';
            return $result;
        })
        ->rawColumns([
            'action',
            'total_shot_accumulated',
            'operator'
        ])
        ->make(true);
    }

    public function employeeID(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user_details = User::where('employee_id', $request->user_id)->whereIn('position', [0,1,4])->where('status', 1)->first();
        return response()->json(['userDetails' => $user_details]);
    }

    public function updateStampingHistory (Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        $validator = Validator::make($data, [
            'stamping_history_part_name'                => 'required',
            'stamping_history_diecode_no'               => 'required',
            'date_stamping_history'                     => 'required',
            'stamping_history_total_shot'               => 'required',
            'stamping_history_prev_total_shot_accum'    => 'required',
            'stamping_history_new_total_shot_accum'     => 'required',
            'stamping_history_operator'                 => 'required',
            'stamping_history_machine_no'               => 'required',
            'stamping_history_die_height'               => 'required',
            'stamping_history_revolution_no'            => 'required',
            'stamping_history_neraiti'                  => 'required',
            'stamping_history_remark'                   => 'required',
            'stamping_history_created_by'               => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        }else{
            DB::beginTransaction();
            try {
                $check_existing_record = StampingHistory::where('id', $request->stamping_history_id)->where('logdel', 0)->get();
                $implode_operator =  implode(",", $request->stamping_history_operator);

                $stamping_history = [
                    'part_name'     =>  $request->stamping_history_part_name,
                    'die_code_no'   =>  $request->stamping_history_diecode_no,
                    'date'          =>  $request->date_stamping_history,
                    'total_shot'    =>  $request->stamping_history_total_shot,
                    'operator'      =>  $implode_operator,
                    'machine_no'    =>  $request->stamping_history_machine_no,
                    'die_height'    =>  $request->stamping_history_die_height,
                    'revolution_no' =>  $request->stamping_history_revolution_no,
                    'rev_no'        =>  $request->stamping_history_revision_no,
                    'neraiti'       =>  $request->stamping_history_neraiti,
                    'remarks'       =>  $request->stamping_history_remark,
                    'scan_by'       =>  $request->employee_no,
                ];
                if(count($check_existing_record) != 1){
                    $stamping_history['created_by']  = $request->stamping_history_created_by;
                    $stamping_history['created_at']  = date('Y-m-d H:i:s');

                    StampingHistory::insert(
                        $stamping_history
                    );
                }else{
                    $stamping_history['updated_by']  = $request->stamping_history_created_by;
                    $stamping_history['updated_at']  = date('Y-m-d H:i:s');

                    StampingHistory::where('id', $request->stamping_history_id)
                    ->update(
                        $stamping_history
                    );
                }

                DB::commit();
                return response()->json(['hasError' => 0]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            }
        }
    }

    public function getStampingHistoryById(Request $request){
        date_default_timezone_set('Asia/Manila');

        $get_operator_name = user::all();
        $get_stamping_history_to_edit = StampingHistory::where('id', $request->stampingHistoryID)->get();

        $next_to_last_shot = StampingHistory::where('part_name', $request->partName)
            ->where('id', '<', $get_stamping_history_to_edit[0]->id)
            ->where('logdel', 0)
            ->orderBy('id', 'desc')
            ->get();

        $total_sum = 0;
        for ($i=0; $i < count($next_to_last_shot); $i++) {
            $total_sum += $next_to_last_shot[$i]->total_shot;
        }

        return response()->json([
            'getStampingHistoryToEdit'  => $get_stamping_history_to_edit,
            'getOperatorName'           => $get_operator_name,
            'totalSum'                  =>  $total_sum
        ]);
    }
}

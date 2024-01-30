<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

/**
 * Import Models
 */
use App\Models\SecMoldingRuncard;
use App\Models\SecMoldingRuncardStation;

class SecondMoldingStationController extends Controller
{
    public function viewSecondMoldingStation(Request $request){
        $secMoldingRuncardId = isset($request->sec_molding_runcard_id) ? $request->sec_molding_runcard_id : 0;
        // return $secMoldingRuncardId;
        $secondMoldingResult = DB::connection('mysql')->select("SELECT a.* FROM sec_molding_runcard_stations AS a
                    WHERE a.sec_molding_runcard_id = '$request->sec_molding_runcard_id'
                    ORDER BY id ASC
        ");

        return DataTables::of($secondMoldingResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button class='btn btn-primary btn-sm mr-1 actionEditSecondMoldingStation' disabled data-bs-toggle='modal' data-bs-target='#modalSecondMoldingStation' second-molding-station-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                </center>
            ";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function saveSecondMoldingStation(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        session_start();

        $rules = [
            'second_molding_id' => 'required',
            'station' => 'required',
            'date' => 'required',
            'operator_name' => 'required',
            'input_quantity' => 'required',
            'ng_quantity' => 'required',
            'output_quantity' => 'required',
            'remarks' => '',
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
        } else {
            DB::beginTransaction();
            try {
                // SecMoldingRuncardStation::where('sec_molding_runcard_id', $request->second_molding_id)->delete();
                $secondMoldingStationId = SecMoldingRuncardStation::insertGetId([
                    'sec_molding_runcard_id' => $request->second_molding_id,
                    'station' => $request->station,
                    'date' => $request->date,
                    'operator_name' => $request->operator_name,
                    'input_quantity' => $request->input_quantity,
                    'ng_quantity' => $request->ng_quantity,
                    'output_quantity' => $request->output_quantity,
                    'remarks' => $request->remarks,

                    // 'status' => 1,
                    'created_by' => $_SESSION['user_id'],
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                DB::commit();
                return response()->json(['hasError' => false]);
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
            }
        }
    }
}

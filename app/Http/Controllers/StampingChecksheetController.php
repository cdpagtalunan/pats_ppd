<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Stamping5sChecksheet;
use Illuminate\Support\Facades\Auth;
use DataTables;
class StampingChecksheetController extends Controller
{
    public function view_checksheet(Request $request){
        $five_s_checksheet = DB::connection('mysql')
        ->table('stamping5s_checksheets')
        ->select('*')
        ->whereNull('deleted_at')
        ->get();

        return DataTables::of($five_s_checksheet)
        ->addColumn('action', function($five_s_checksheet){
            $result = "";

            return $result;
        })
        ->addColumn('status', function($five_s_checksheet){
            $result = "";

            return $result;
        })
        ->rawColumns(['action', 'status'])
        ->make(true);

    }

    public function save_checksheet(Request $request){
        DB::beginTransaction();
        
        try{
            $stamping_5s_checksheet_array = array(
                'assembly_line'    => $request->asmbly_line,
                'dept'             => $request->dept_sect,
                'division'         => $request->division,
                'oic'              => $request->oic,
                'date_time'        => $request->date_time,
                'checked_by'       => $request->check_by,
                'conducted_by'     => $request->conduct_by,
                'shift'            => $request->shift,
                'machine_id'       => $request->machine,
                'remarks'          => $request->remarks,
                'checksheet_A_1_1' => $request->checkA1_1,
                'checksheet_A_1_2' => $request->checkA1_2,
                'checksheet_A_1_3' => $request->checkA1_3,
                'checksheet_A_1_4' => $request->checkA1_4,
                'checksheet_A_1_5' => $request->checkA1_5,
                'checksheet_A_1_6' => $request->checkA1_6,
                'checksheet_A_2_1' => $request->checkA2_1,
                'checksheet_A_2_2' => $request->checkA2_2,
                'checksheet_A_2_3' => $request->checkA2_3,
                'checksheet_A_2_4' => $request->checkA2_4,
                'checksheet_A_3_1' => $request->checkA3_1,
                'created_by'       => Auth::user()->id,
                'created_at'       => NOW()
            );

            Stamping5sChecksheet::insert($stamping_5s_checksheet_array);

            DB::commit();

            return response()->json([
                'result' => true
            ]);
        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }
    
    public function get_machine_dropdown(Request $request){
        return DB::connection('mysql')
        ->table('stamping_checksheet_machine_dropdowns')
        ->get();
    }
}

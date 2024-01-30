<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;

use App\Models\SecMoldingRuncard;

class CnAssemblyRuncardController extends Controller
{
    public function get_data_from_2nd_molding(Request $request){
        $sec_molding_runcard_data = SecMoldingRuncard::whereNull('deleted_at')
                                            ->where('po_number', $request->po_number)
                                            ->get();

        return response()->json(['sec_molding_runcard_data' => $sec_molding_runcard_data]);
    }

    public function view_cn_assembly_runcard(Request $request){
        // return $request->po_number;

        if(!isset($request->po_number)){
            return [];
        }else{
            $AssemblyRuncardData = DB::connection('mysql')->select("SELECT a.* FROM cn_assembly_runcards AS a 
                    INNER JOIN sec_molding_runcards AS b
                            ON b.id = a.sec_molding_runcards_id
                        WHERE a.po_number = '$request->po_number'
                        ORDER BY a.id ASC
            ");

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
}

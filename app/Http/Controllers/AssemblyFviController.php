<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\AssemblyFvi;
use Illuminate\Http\Request;
use App\Models\AssemblyRuncard;
use Illuminate\Support\Facades\DB;
use App\Models\AssemblyFvisRuncard;
use Illuminate\Support\Facades\Validator;
use App\Models\AssemblyRuncardStationsMods;

class AssemblyFviController extends Controller
{
    public function view_visual_inspection(Request $request){
        $fvi_data = DB::connection('mysql')
        ->table('assembly_fvis')
        ->whereNull('deleted_at')
        ->where('po_no', $request->po)
        ->get();

        return DataTables::of($fvi_data)
        ->addColumn('action', function($fvi_data){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-sm btn-info btnViewFvi' data-id='$fvi_data->id' data-status='$fvi_data->status'><i class='fa-solid fa-eye'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->addColumn('ttlLotQty', function($fvi_data){
            $result = "";

            $fvi_runcards = DB::connection('mysql')
            ->table('assembly_fvis_runcards')
            ->join('assembly_runcards', 'assembly_fvis_runcards.prod_runcard_id', '=', 'assembly_runcards.id')
            ->join('assembly_runcard_stations', 'assembly_fvis_runcards.prod_runcard_station_id', '=', 'assembly_runcard_stations.id')
            ->select(
                DB::raw('SUM(assembly_runcard_stations.output_quantity) as ttl_output'),
                DB::raw('SUM(assembly_runcard_stations.ng_quantity) as ttl_ng'),
            )
            ->where('assembly_fvis_runcards.assembly_fvis_id', $fvi_data->id)
            ->get();

            return $fvi_runcards;

        })
        ->addColumn('lot_status', function($fvi_data){
            $result = "";
            $result .= "<center>";
            if($fvi_data->status == 0){
                
                $result .='<span class="badge badge-pill badge-info">For Lot Application</span>';
            }
            else if($fvi_data->status == 1){
                $result .='<span class="badge badge-pill badge-success">Done</span>';
                
            }
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action', 'ttlLotQty', 'lot_status'])
        ->make('true');
    }

    public function view_fvi_runcards(Request $request){

        $fvi_runcards = DB::connection('mysql')
        ->table('assembly_fvis_runcards')
        ->join('assembly_runcards', 'assembly_fvis_runcards.prod_runcard_id', '=', 'assembly_runcards.id')
        ->join('assembly_runcard_stations', 'assembly_fvis_runcards.prod_runcard_station_id', '=', 'assembly_runcard_stations.id')
        ->select(
            'assembly_fvis_runcards.*',
            'assembly_runcards.id AS fk_runcard_id',
            'assembly_runcards.runcard_no AS fk_runcard_runcard_no',
            'assembly_runcard_stations.input_quantity AS fk_runcard_station_input_quantity',
            'assembly_runcard_stations.output_quantity AS fk_runcard_station_output_quantity',
            'assembly_runcard_stations.ng_quantity AS fk_runcard_station_ng_quantity',
        )
        ->where('assembly_fvis_runcards.assembly_fvis_id', $request->fvi_id)
        ->get();

        return DataTables::of($fvi_runcards)
        ->addColumn('action', function($fvi_runcards){
            $result = "";

            return $result;
        })
        ->addColumn('mods', function($fvi_runcards){
            $result = "";

            $runcard_mod = DB::connection('mysql')
            ->table('assembly_runcard_stations_mods')
            ->join('defects_infos', 'assembly_runcard_stations_mods.mod_id', '=', 'defects_infos.id')
            ->select(
                'assembly_runcard_stations_mods.*',
                'defects_infos.defects AS fk_defect_name'
            )
            ->where('assembly_runcard_stations_mods.assembly_runcards_id', $fvi_runcards->prod_runcard_id)
            ->where('assembly_runcard_stations_mods.assembly_runcard_stations_id', $fvi_runcards->prod_runcard_station_id)
            ->whereNull('assembly_runcard_stations_mods.deleted_at')
            ->get();
            
            foreach( $runcard_mod as $mod ){
                $result .= "$mod->fk_defect_name <br>";
            }
            return $result;
        })
        ->rawColumns(['action', 'mods'])
        ->make('true');
    }

    public function get_fvi_doc(Request $request){
        $document = DB::connection('mysql_rapid_acdcs')
        ->table('tbl_active_docs')
        ->where('doc_title', 'LIKE', "%$request->device_name%")
        ->where('originator_code',"CN")
        ->select('*')
        ->get();

        $a_drawing = $document->filter(
            function($item){
                return ($item->doc_type == 'A Drawing');
            })
        ->flatten(1);

        $g_drawing = $document->filter(
            function($item){
                return ($item->doc_type == 'G Drawing');
            })
        ->flatten(1);

        return response()->json([
            'aDrawing' => $a_drawing,
            'gDrawing' => $g_drawing
        ]);
    }

    public function get_assembly_line(Request $request){
        $assembly_line = DB::connection('mysql')
        ->table('stations')
        ->where('status', 0)
        ->get();

        return response()->json([
            'details' => $assembly_line
        ]);
    }

    public function save_visual_details(Request $request){
        date_default_timezone_set('Asia/Manila');

        $data = $request->all();

        $rules = [
            'txt_remarks'                 => 'required',
            // 'company_contact_no'      => 'required',
            'sel_assembly_line'      => 'required'
        ];

        $validator = Validator::make($data, $rules);

        if($validator->passes()){
            DB::beginTransaction();
             
            try{
                $lot_ext;
                $bundle_ext;

                $get_lot_extension = DB::connection('mysql')
                ->table('assembly_fvis')
                ->where('po_no', $request->txt_po_number)
                ->whereNull('deleted_at')
                ->get()
                ->count('po_no');

                if($get_lot_extension == 0){
                    $lot_ext = 1;
                }
                else{
                    $lot_ext = $get_lot_extension + 1;
                }

                $get_bundle_lot = DB::connection('mysql')
                ->table('assembly_fvis')
                ->where('created_at', 'LIKE', "2024-02-23%")
                ->whereNull('deleted_at')
                ->get()
                ->count('id');

                if($get_bundle_lot == 0){
                    $bundle_ext = 1;
                }
                else{
                    $bundle_ext = $get_bundle_lot + 1;
                }

                $dt = Carbon::now();

                $year = $dt->year;
                
                $substr_year = substr(strval($year), 3, 4);
                $month = $dt->month;
                if($month == 10){
                    $month = "X";
                }
                else if($month == 11){
                    $month = "Y";
                }
                else if($month == 12){
                    $month = "Z";
                }

                $day = $dt->day;
                $bundle_lot_no = $substr_year.$month.str_pad($day, 2, '0', STR_PAD_LEFT)."-".str_pad($bundle_ext, 3, '0', STR_PAD_LEFT);

                $fvi_lot_no = substr($request->txt_po_number, 5, -5) ." LOT-".str_pad($lot_ext, 3, '0', STR_PAD_LEFT);

                // $fvi_details_array = array(
                //     'po_no'         => $request->txt_po_number,
                //     'device_name'   => $request->txt_use_for_device,
                //     'device_code'   => $request->txt_device_code,
                //     'po_qty'        => $request->txt_po_qty,
                //     'lot_no'        => $fvi_lot_no,
                //     'bundle_no'     => $bundle_lot_no,
                //     'remarks'       => $request->txt_remarks,
                //     'assembly_line' => $request->sel_assembly_line,
                //     'a_drawing_no'  => $request->a_drawing,
                //     'a_drawing_rev' => $request->a_revision,
                //     'g_drawing_rev' => $request->g_drawing,
                //     'g_drawing_no'  => $request->g_revision,
                //     'created_by'    => session()->get('user_id'),
                //     'created_at'    => NOW()
                // );

                // $id = AssemblyFvi::insertGetId($fvi_details_array);

                $data = new AssemblyFvi;
                $data->po_no         = $request->txt_po_number;
                $data->device_name   = $request->txt_use_for_device;
                $data->device_code   = $request->txt_device_code;
                $data->po_qty        = $request->txt_po_qty;
                $data->lot_no        = $fvi_lot_no;
                $data->bundle_no     = $bundle_lot_no;
                $data->remarks       = $request->txt_remarks;
                $data->assembly_line = $request->sel_assembly_line;
                $data->a_drawing_no  = $request->a_drawing;
                $data->a_drawing_rev = $request->a_revision;
                $data->g_drawing_no  = $request->g_drawing;
                $data->g_drawing_rev = $request->g_revision;
                $data->created_by    = session()->get('user_id');
                $data->created_at    = NOW();

                $data->save();

                DB::commit();

                return response()->json([
                    'result'     => true,
                    'id'         => $data->id,
                    'lot_no'     => $data->lot_no,
                    'bundle_no'  => $data->bundle_no,
                    'created_at' => $data->created_at,
                    'msg'        => 'Successfully Saved!'
                ]);

            }
            catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()], 422);
        }
    }

    public function get_runcard_details(Request $request){

        $runcard_details = DB::connection('mysql')
        ->table('assembly_runcards')
        ->join('assembly_runcard_stations', 'assembly_runcards.id', '=', 'assembly_runcard_stations.assembly_runcards_id')
        ->join('stations', 'assembly_runcard_stations.station', '=', 'stations.id')
        ->select(
            'assembly_runcards.*', 
            'assembly_runcard_stations.id AS fk_station_id', 
            'assembly_runcard_stations.station AS fk_station_station', 
            'assembly_runcard_stations.input_quantity AS fk_station_input_quantity', 
            'assembly_runcard_stations.output_quantity AS fk_station_output_quantity', 
            'stations.station_name AS fk_station_name'
        )
        ->where('assembly_runcards.runcard_no', $request->runcard_no)
        ->where('stations.station_name', "Visual Inspection")
        ->whereNull('assembly_runcards.deleted_at')
        ->first();

        $runcard_mod = DB::connection('mysql')
        ->table('assembly_runcard_stations_mods')
        ->join('defects_infos', 'assembly_runcard_stations_mods.mod_id', '=', 'defects_infos.id')
        ->select(
            'assembly_runcard_stations_mods.*',
            'defects_infos.defects AS fk_defect_name'
        )
        ->where('assembly_runcard_stations_mods.assembly_runcards_id', $runcard_details->id)
        ->where('assembly_runcard_stations_mods.assembly_runcard_stations_id', $runcard_details->fk_station_id)
        ->whereNull('assembly_runcard_stations_mods.deleted_at')
        ->get();

        return response()->json([
            'runcard'    => $runcard_details,
            'runcardMod' => $runcard_mod
        ]);
        // return $runcard_details[0]['assembly_runcard_station'];

    }

    public function save_runcard(Request $request){
        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        try{
            $check = AssemblyFvisRuncard::where('prod_runcard_id',  $request->runcard_id)->exists();

            if(!$check){
                $runcard_array = array(
                    'assembly_fvis_id'        => $request->fvi_id,
                    'prod_runcard_id'         => $request->runcard_id,
                    'prod_runcard_station_id' => $request->runcard_station_id,
                    'operator_name'           => $request->operator_name,
                    'date'                    => $request->date,
                    // 'ng_qty'                  => $request->qty_ng,
                    'remarks'                 => $request->remarks,
                    'created_by'              => session()->get('user_id'),
                    'created_at'              => NOW()
                );
    
                AssemblyFvisRuncard::insert($runcard_array);
            }
            else{
                return response()->json([
                    'msg' => "Runcard Already Exist!"
                ], 422);
            }
           

            DB::commit();
            
            return response()->json([
                'result' => true,
                'msg' => 'successfully Added'
            ]);
        }
        catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    public function get_fvi_details_by_id(Request $request){
        // return $request->all();

        return DB::connection('mysql')
        ->table('assembly_fvis')
        ->where('id', $request->id)
        ->first();

    }

    public function validate_runcard_output(Request $request){
        // return $request->all();

        $device = DB::connection('mysql')
        ->table('devices')
        ->where('code', $request->device_code)
        ->where('name', $request->device_name)
        ->where('status', 1)
        ->first();

        return response()->json([
            'device' => $device
        ]);

    }

    public function submit_to_oqc_lot_app(Request $request){

        date_default_timezone_set('Asia/Manila');
        DB::beginTransaction();
        
        try{
            AssemblyFvi::where('id', $request->id)
            ->update([
                'status' => 1,
                'updated_by' => session()->get('user_id')
            ]);

            DB::commit();

            return response()->json([
                'result' => true
            ]);

        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }

     
    }

    public function search_po(Request $request){
        // return $request->all();

        $details = DB::connection('mysql')
        ->table('assembly_runcards')
        ->where('po_number', $request->po_number)
        ->whereNull('deleted_at')
        ->first();

        return response()->json([
            'details' => $details
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use QrCode;
use DataTables;
use App\Models\User;
use App\Models\Device;

use App\Models\StampingIpqc;
use Illuminate\Http\Request;

use App\Models\MaterialProcess;
use App\Models\SecMoldingRuncard;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FirstStampingProduction;
use App\Models\StampingProductionSublot;
use App\Models\StampingProductionHistory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StampingController extends Controller
{
    public function view_stamp_prod(Request $request){

        // return $request_po;

        $stamping_data = FirstStampingProduction::with([
            'first_stamping_history',
            'oqc_details'
        ])
        ->whereNull('deleted_at')
        ->where('po_num', $request->po)
        ->where('stamping_cat', $request->stamp_cat)
        ->get();


        return DataTables::of($stamping_data)
        ->addColumn('action', function($stamping_data){
            $result = "";
            $result .= "<center>";
            /*
                * data-function on buttons will be the trigger point for viewing and editing for mass production
                * 0 => viewing only, 1 => for mass production entry of data, 2 => for re-setup, 3 => Edit data
            */
            $result .= "<button class='btn btn-dark btn-sm btnViewProdData' title='View Data'  data-id='$stamping_data->id' data-function='0' data-stampcat='$stamping_data->stamping_cat'><i class='fa-solid fa-eye'></i></button>";

            if($stamping_data->status == 0){
                $result .= "<button class='btn btn-primary btn-sm btnPrintIPQC ml-1' title='Print QR Code'
                data-id='$stamping_data->id'
                data-stampcat='$stamping_data->stamping_cat'>
                    <i class='fa-solid fa-print'></i>
                    </button>";
            }
            else if($stamping_data->status == 1){
                $result .= "<button class='btn btn-warning btn-sm btnMassProd ml-1' title='Proceed Mass Production'
                data-id='$stamping_data->id'
                data-function='1'
                data-stampcat='$stamping_data->stamping_cat'>
                    <i class='fa-solid fa-up-right-from-square'></i>
                </button>";
                $result .= "<button class='btn btn-secondary btn-sm btnEditProdData ml-1' title='Edit'
                data-id='$stamping_data->id' data-function='3'
                data-stampcat='$stamping_data->stamping_cat'>
                    <i class='fa-solid fa-pen-to-square'></i>
                </button>";

            }
            else if($stamping_data->status == 2){ // DONE; For Printing of sticker
                $result .= "<button class='btn btn-primary btn-sm btnPrintProdData ml-1' title='Print QR Code'
                data-id='$stamping_data->id'
                data-printcount='$stamping_data->print_count'
                data-stampcat='$stamping_data->stamping_cat'>
                    <i class='fa-solid fa-print'></i>
                    </button>";
            }
            else if ($stamping_data->status == 3){ // For Resetup
                $result .= "<button class='btn btn-danger btn-sm btnViewResetup ml-1' title='See Re-setup'
                data-id='$stamping_data->id' data-function='2'
                data-stampcat='$stamping_data->stamping_cat'>
                    <i class='fa-solid fa-repeat'></i>
                </button>";
            }
            else if ($stamping_data->status == 4){ // For Batching; For 2nd Stamping only
                $result .= "<button class='btn btn-success btn-sm ml-1 btnAddBatch' title='Add Sublot'
                data-id='$stamping_data->id'
                data-po='$stamping_data->po_num'
                data-lotno='$stamping_data->prod_lot_no'
                data-shipout='$stamping_data->ship_output'>
                    <i class='fa-solid fa-layer-group'></i>
                </button>";
            }

            if(count($stamping_data->first_stamping_history) > 0){
                $result .= "<button class='btn btn-info btn-sm btnViewHistory ml-1'
                data-id='$stamping_data->id'
                data-po='$stamping_data->po_num'
                title='See History'>
                    <i class='fa-solid fa-clock-rotate-left'></i>
                </button>";
            }
            $result .= "</center>";
            return $result;
        })
        ->addColumn('label', function($stamping_data){
            $result = "";
            if($stamping_data->status == 0){
                $result = "<span class='badge bg-warning'>For IPQC Inspection</span>";

            }
            else if($stamping_data->status == 1){
                $result = "<span class='badge bg-info'>Ready for mass production</span>";

            }
            else if($stamping_data->status == 2){
                $result = "<span class='badge bg-success'>Done</span>";
            }
            else if($stamping_data->status == 3){
                $result = "<span class='badge bg-danger'>Lot Rejected</span>";
            }
            else if($stamping_data->status == 4){
                $result = "<span class='badge bg-warning'>For Sublot Input</span>";
            }

            return $result;
        })
        ->addColumn('material', function($stamping_data){
            $result = "";
            $result .= "<center>";
            $exploded_mat_no = explode(', ', $stamping_data->material_lot_no);

            for ($i=0; $i <  count($exploded_mat_no); $i++) {
                $result .= "$exploded_mat_no[$i]";
            }

            $result .= "</center>";
            return $result;
        })
        ->addColumn('overall_yield', function($stamping_data){
            $result = "---";
            if($stamping_data->oqc_details != null){
                $result = $stamping_data->oqc_details->yield;
            }
            return $result;
        })
        ->rawColumns(['action', 'material', 'label', 'overall_yield'])
        ->make(true);
    }

    public function save_prod_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();

        if(isset($request->id)){
            if($request->status == 2){
                $validation = array(
                    'ng_count'        => ['required'],
                    'qc_samp'        => ['required'],
                    'adj_pins'        => ['required'],
                    'setup_pins'        => ['required'],
                    'remarks'        => ['required'],
                );
            }
            else{
                $validation = array(
                    // 'mat_lot_no'       => ['required'],
                    'prod_date'        => ['required'],
                    // 'prod_lot_no'      => ['required'],
                    'prod_samp'        => ['required'],
                    'ttl_mach_output'  => ['required'],
                    'ship_output'      => ['required'],
                    'mat_yield'        => ['required'],
                );
            }

        }
        else{
            if($request->stamp_cat == 1){
                $validation = array(
                    'po_num'           => ['required'],
                    'po_qty'           => ['required'],
                    'part_code'        => ['required'],
                    'mat_name'         => ['required'],
                    'drawing_no'       => ['required'],
                    'drawing_rev'      => ['required'],
                    'opt_name'         => ['required'],
                    'opt_shift'        => ['required'],
                    'inpt_coil_weight' => ['required'],
                    'target_output'    => ['required'],
                    'target_output'    => ['required'],
                    'planned_loss'     => ['required'],
                    'setup_pins'       => ['required'],
                    'adj_pins'         => ['required'],
                    'qc_samp'          => ['required'],
                    'material_no'       => ['required'],
                );
            }
            else{
                $validation = array(
                    'po_num'        => ['required'],
                    'po_qty'        => ['required'],
                    'part_code'     => ['required'],
                    'mat_name'      => ['required'],
                    'drawing_no'    => ['required'],
                    'drawing_rev'   => ['required'],
                    'opt_name'      => ['required'],
                    'opt_shift'     => ['required'],
                    // 'act_qty'       => ['required'],
                    'inpt_pins'     => ['required'],
                    'target_output' => ['required'],
                    'planned_loss'  => ['required'],
                    'setup_pins'    => ['required'],
                    'adj_pins'      => ['required'],
                    'qc_samp'       => ['required'],
                    'material_no'       => ['required'],

                );
            }

        }


        $validator = Validator::make($data, $validation);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();
            try{

                $user_id = User::where('employee_id', $request->scanned_id)
                ->first('id');

                if(isset($request->id)){
                    if($request->status == 2){ // FOR RESETUP
                        $id = $request->id;
                        FirstStampingProduction::query()
                        ->where('id', $request->id)
                        ->each(function ($oldRecord) use ($id, $request, $user_id) {
                            $newRecord                         = new StampingProductionHistory();
                            $newRecord->set_up_pins            = $oldRecord->set_up_pins;
                            $newRecord->adj_pins               = $oldRecord->adj_pins;
                            $newRecord->qc_samp                = $oldRecord->qc_samp;
                            $newRecord->ng_count               = $oldRecord->ng_count;
                            $newRecord->stamping_production_id = $id;
                            $newRecord->remarks                = $request->remarks;
                            $newRecord->save();

                            $oldRecord->status      = 0;
                            $oldRecord->set_up_pins = $request->setup_pins;
                            $oldRecord->adj_pins    = $request->adj_pins;
                            $oldRecord->qc_samp     = $request->qc_samp;
                            $oldRecord->ng_count    = $request->ng_count;
                            $oldRecord->updated_at  = NOW();
                            $oldRecord->updated_by  = $user_id->id;
                            $oldRecord->save();
                        });
                        // ->update([
                        //     'status'            => 0,
                        //     'set_up_pins'       => $request->setup_pins,
                        //     'adj_pins'          => $request->adj_pins,
                        //     'qc_samp'           => $request->qc_samp,
                        //     'ng_count'          => $request->ng_count,
                        //     'updated_at'        => NOW(),
                        //     'updated_by'        => $user_id->id
                        // ]);

                        // FirstStampingProduction::where('id', $request->id)
                        // ->update([
                        //     'status'            => 0,
                        //     'set_up_pins'       => $request->setup_pins,
                        //     'adj_pins'          => $request->adj_pins,
                        //     'qc_samp'           => $request->qc_samp,
                        //     'ng_count'          => $request->ng_count,
                        //     'updated_at'        => NOW(),
                        //     'updated_by'        => $user_id->id
                        // ]);

                        StampingIpqc::where('fs_productions_id', $request->id)
                        ->update([
                            'status'            => 5,
                        ]);
                    }
                    else{ // FOR MASS PRODUCTION
                        // $prod_array['trays'] = $request->tray;

                        $insert_array_mass_prod = array(
                            // 'status'            => 4,
                            'prod_date'         => $request->prod_date,
                            'prod_samp'         => $request->prod_samp,
                            'total_mach_output' => $request->ttl_mach_output,
                            'ship_output'       => $request->ship_output,
                            'mat_yield'         => $request->mat_yield,
                            'updated_at'        => NOW(),
                            'updated_by'        => $user_id->id
                        );
                        if($request->stamp_cat == 1){
                            $insert_array_mass_prod['trays'] = $request->tray;
                            $insert_array_mass_prod['status'] = 2;
                        }
                        else{
                            $insert_array_mass_prod['status'] = 4;
                        }
                        FirstStampingProduction::where('id', $request->id)
                        ->update($insert_array_mass_prod);
                    }

                    DB::commit();
                }
                else{

                    $imploded_operator = implode($request->opt_name, ', ');

                    $prod_array = array(
                        'stamping_cat'     => $request->stamp_cat,
                        'ctrl_counter'     => $request->ctrl_counter,
                        'po_num'           => $request->po_num,
                        'po_qty'           => $request->po_qty,
                        'part_code'        => $request->part_code,
                        'material_name'    => $request->mat_name,
                        'material_lot_no'  => $request->material_no,
                        'material_lot_qty' => $request->material_no_qty,
                        'drawing_no'       => $request->drawing_no,
                        'drawing_rev'      => $request->drawing_rev,
                          // 'cut_off_point'     => $request->cut_point,
                          // 'no_of_cuts'        => $request->no_cut,
                        'prod_lot_no' => $request->prod_log_no_auto."".$request->prod_log_no_ext_1."-".$request->prod_log_no_ext_2,
                          // 'input_coil_weight' => $request->inpt_coil_weight,
                          // 'ppc_target_output' => $request->target_output,
                        'planned_loss'      => $request->planned_loss,
                        'set_up_pins'       => $request->setup_pins,
                        'adj_pins'          => $request->adj_pins,
                        'qc_samp'           => $request->qc_samp,
                        'total_mach_output' => $request->ttl_mach_output,
                        'ship_output'       => $request->ship_output,
                          // 'mat_yield'         => $request->mat_yield,
                        'shift'      => $request->opt_shift,
                        'operator'   => $imploded_operator,
                        'created_by' => $user_id->id,
                        'created_at' => NOW()
                    );
                    if($request->stamp_cat == 1){
                        $prod_array['cut_off_point'] = $request->cut_point;
                        $prod_array['no_of_cuts'] = $request->no_cut;
                        $prod_array['input_coil_weight'] = $request->inpt_coil_weight;
                        $prod_array['ppc_target_output'] = $request->target_output;
                    }
                    else{
                        // $prod_array['trays'] = $request->tray;
                        $prod_array['no_of_trays'] = $request->no_tray;
                        $prod_array['input_pins'] = $request->inpt_pins;
                        // $prod_array['actual_qty'] = $request->act_qty;
                        $prod_array['target_output'] = $request->target_output;
                    }

                    FirstStampingProduction::insert($prod_array);
                    DB::commit();
                }


                return response()->json([
                    'result' => 1,
                    'msg'    => 'Trasaction Successful'
                ]);

            }catch(Exemption $e){
                DB::rollback();
                return $e;
            }
        }
    }

    public function get_data_req_for_prod_by_po(Request $request){

        $get_drawing = DB::connection('mysql_rapid_stamping_dmcms')
        ->select("SELECT * FROM tbl_device WHERE `device_code` = '".$request->item_code."' AND logdel = 0");

        if(count($get_drawing) > 0){
            return $get_drawing[0];
        }
        else{
            // return "No Data on Stamping DMCMS";
            return response()->json(['msg' => 'Item code on this PO not found in Stamping DMCMS'], 400);
        }
    }

    public function get_prod_data_view(Request $request){
        return FirstStampingProduction::with([
            'user',
            'oqc_details'
        ])
        ->where('id', $request->id)
        ->where('stamping_cat', $request->stamp_cat)
        ->first();
    }

    public function print_qr_code(Request $request){
        $prod_data = FirstStampingProduction::where('id', $request->id)
        ->first(['po_num AS po', 'part_code AS code', 'material_name AS name' , 'prod_lot_no AS production_lot_no', 'po_qty AS qty', 'ship_output AS output_qty', 'stamping_cat AS cat']);

        $no_sub_lot = 'N/A';
        if($request->stamp_cat == 1){
            $prod_name = "$prod_data->name-X";

            $qrcode = QrCode::format('png')
            ->size(250)->errorCorrection('H')
            ->generate($prod_data);

            $QrCode = "data:image/png;base64," . base64_encode($qrcode);

            $data[] = array(
                'img' => $QrCode,
                'text' =>  "
                <strong>1st Stamping</strong><br>
                <strong>$prod_data->po</strong><br>
                <strong>$prod_data->code</strong><br>
                <strong>$prod_name</strong><br>
                <strong>$prod_data->production_lot_no</strong><br>
                <strong>$prod_data->output_qty</strong><br>
                <strong>$prod_data->qty</strong><br>"
            );
        }
        else{
            $prod_name = "$prod_data->name-Y";

            $sublot = StampingProductionSublot::where('stamp_prod_id', $request->id)
            ->get(['batch_qty', 'counter']);
            $data = [];
            for ($x=0; $x < count($sublot); $x++) {
                $prod_data['sublot_qty'] = $sublot[$x]->batch_qty;
                $prod_data['sublot_counter'] = $sublot[$x]->counter."/".count($sublot);

                $qrcode = QrCode::format('png')
                ->size(250)->errorCorrection('H')
                ->generate(json_encode($prod_data));

                $QrCode = "data:image/png;base64," . base64_encode($qrcode);

                $data[] = array(
                    'img' => $QrCode,
                    'text' =>  "
                    <strong>2nd Stamping</strong><br>
                    <strong>$prod_data->po</strong><br>
                    <strong>$prod_data->qty</strong><br>
                    <strong>$prod_data->code</strong><br>
                    <strong>$prod_name</strong><br>
                    <strong>$prod_data->production_lot_no</strong><br>
                    <strong>$prod_data->output_qty</strong><br>
                    <strong>$prod_data->sublot_qty</strong><br>
                    <strong>".$sublot[$x]->counter."/".count($sublot)."</strong><br>
                    "
                );
            }
            $no_sub_lot = count($sublot);

            // return $data;
        }

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>PO No.:</td>
                    <td>$prod_data->po</td>
                </tr>
                <tr>
                    <td>Material Code:</td>
                    <td>$prod_data->code</td>
                </tr>
                <tr>
                    <td>Material Name:</td>
                    <td>$prod_name</td>
                </tr>
                <tr>
                    <td>Production Lot #:</td>
                    <td>$prod_data->production_lot_no</td>
                </tr>
                <tr>
                    <td>Shipment Output:</td>
                    <td>$prod_data->output_qty</td>
                </tr>
                <tr>
                    <td>PO Quantity:</td>
                    <td>$prod_data->qty</td>
                </tr>
                <tr>
                    <td>No. of Sublot:</td>
                    <td>$no_sub_lot</td>
                </tr>

            </table>
        ";

        return response()->json(['qrCode' => $QrCode, 'label_hidden' => $data, 'label' => $label, 'prodData' => $prod_data]);
    }

    public function check_matrix(Request $request){
        // return $request->all();

        $device =  Device::where('code', $request->code)
        ->where('name', $request->name)
        ->where('status', 1)
        ->first();

        if(isset($device)){

            $mat_process = MaterialProcess::with([
                'process_details'
            ])
            ->where('status', 0)
            ->get();

            $collection = collect($mat_process)->where('process_details.process_name', $request->process)->pluck('process_details.process_name')->toArray();

            // return $collection;
            if(in_array("1st Stamping", $collection)){
                return response()->json([
                    'result' => 1,
                    'msg' => 'Material is registered on matrix.'
                ]);
            }
            if(in_array("2nd Stamping", $collection)){
                return response()->json([
                    'result' => 2,
                    'msg' => 'Material is registered on matrix.'
                ]);
            }
            else{
                return response()->json([
                    'result' => 3,
                    'msg' => 'Material dont stamping on process.'
                ]);
            }

        }
        else{
            return response()->json([
                'result' => 3,
                'msg' => 'Material not registered on matrix.'
            ]);
        }

    }

    public function get_prod_lot_no_ctrl(Request $request){
        date_default_timezone_set('Asia/Manila');

        $date  = date('Y-m-d');
        $year  = date('y');
        $month = date('m');
        $day   = date('d');

        $ctrl_count = DB::connection('mysql')
        ->select("SELECT MAX(ctrl_counter) as ctrl FROM stamping_productions WHERE `created_at` LIKE '%$date%' AND `stamping_cat` = 1");

        $ctrl_counter = $ctrl_count[0]->ctrl + 1;
        return response()->json([
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'ctrl'  => str_pad($ctrl_counter, 2, '0', STR_PAD_LEFT)

        ]);
    }

    public function get_operator_list(Request $request){
        return DB::connection('mysql')
        ->select("SELECT * FROM users WHERE position = 4");

    }

    public function change_print_count(Request $request){
        FirstStampingProduction::where('id', $request->id)
        ->update([
            'print_count' => 1
        ]);
    }

    public function get_history_details(Request $request){
        $history = StampingProductionHistory::where('stamping_production_id', $request->id)
        ->get();

        return DataTables::of($history)
        ->make(true);

    }






    /*
        * SECOND STAMPING
    */

    public function get_2_stamp_reqs(Request $request){

        $data = json_decode($request->params);
        $po;
        if(isset($data->po_no)){
            $po = $data->po_no;
        }
        else{
            $po = $request->params;
        }

        // $po_details = DB::connection('mysql')
        // ->select("
        //     SELECT po_num,po_qty, part_code, material_name, drawing_no, drawing_rev FROM `stamping_productions` WHERE `stamping_cat` = 1 AND `po_num` = '$data->po_no' AND `status` = 2 LIMIT 0, 1
        // ");

        $po_details = DB::connection('mysql')
        ->select("
            SELECT
            a.po_num,
            a.po_qty,
            a.part_code,
            a.material_name,
            a.drawing_no,
            a.drawing_rev
            FROM `stamping_productions` as a
            INNER JOIN `receiving_details` as b ON a.id = b.prod_id
            WHERE b.status = 2
            AND a.stamping_cat = 1
            AND b.po_no = '$po'
            AND a.status = 2
            LIMIT 0, 1
        ");

        // return $po_details;

        if(count($po_details) == 0){
            return response()->json(['msg' => 'No Data Found'], 400);
        }

        $date  = date('Y-m-d');
        $year  = date('y');
        $month = date('m');
        $day   = date('d');

        $ctrl_count = DB::connection('mysql')
        ->select("SELECT MAX(ctrl_counter) as ctrl FROM stamping_productions WHERE `created_at` LIKE '%$date%' AND `stamping_cat` = 2");



        $ctrl_counter = $ctrl_count[0]->ctrl + 1;
        return response()->json([
            'year'      => $year,
            'month'     => $month,
            'day'       => $day,
            'ctrl'      => str_pad($ctrl_counter, 2, '0', STR_PAD_LEFT),
            'poDetails' => $po_details
        ]);

    }

    public function save_sublot(Request $request){
        DB::beginTransaction();

        try{
            for ($x=1; $x <= $request->sublot_counter; $x++) {
                StampingProductionSublot::insert([
                    'stamp_prod_id' => $request->stamping_id,
                    'counter' => $x,
                    'batch_qty' => $request['sublot_qty_'.$x]
                ]);
            }

            FirstStampingProduction::where('id', $request->stamping_id)
            ->update([
                'status' => 2
            ]);

            DB::commit();

            return response()->json(['result' => 1]);
        }catch(Exemption $e){
            DB::rollback();
            return $e;
        }
    }

    public function get_sublot_by_id(Request $request){
        // $stamping_sub_lots = StampingProductionSublot::where('stamp_prod_id', $request->id)->get();
        $stamping_sub_lots = FirstStampingProduction::with([
            'second_stamping_sublots'
        ])->where('id', $request->id)
        ->firstOrFail();

        return response()->json([
            'stampSubLot' => $stamping_sub_lots
        ]);
    }

    public function get_matrix_for_mat_validation(Request $request){
        $matrix_details = DB::connection('mysql')
        ->table('material_processes')
        ->join('devices', 'material_processes.device_id', '=', 'devices.id')
        ->join('processes', 'material_processes.process', '=', 'processes.id')
        ->join('material_process_materials', 'material_process_materials.mat_proc_id', '=', 'material_processes.id')
        ->select('material_process_materials.material_type', 'material_process_materials.material_code', 'devices.code', 'devices.name', 'processes.process_name')
        ->where('processes.process_name', $request->process_name)
        ->where('devices.name', $request->device_name)
        ->where('material_process_materials.material_type', $request->material_name)
        ->get();

        return response()->json(['data' => $matrix_details]);
    }

    public function print_qr_for_ipqc(Request $request){

        $stamping_details = FirstStampingProduction::where('id', $request->id)
        ->first(['po_num', 'part_code', 'material_name', 'prod_lot_no']);


        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        // ->mergeString(Storage::get('/public/Untitled-removebg-preview.png'), .5)
        ->generate($stamping_details);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $QrCode,
            'text' => "
            <strong>For IPQC</strong><br>
            <strong>$stamping_details->po_num</strong><br>
            <strong>$stamping_details->part_code</strong><br>
            <strong>$stamping_details->material_name</strong><br>
            <strong>$stamping_details->prod_lot_no</strong><br>"
        );

        $label = "
        <table class='table table-sm table-borderless' style='width: 100%;'>
            <tr>
                <td>PO No.:</td>
                <td>$stamping_details->po_num</td>
            </tr>
            <tr>
                <td>Material Code:</td>
                <td>$stamping_details->part_code</td>
            </tr>
            <tr>
                <td>Material Name:</td>
                <td>$stamping_details->material_name</td>
            </tr>
            <tr>
                <td>Production Lot #:</td>
                <td>$stamping_details->prod_lot_no</td>
            </tr>
        </table>
        ";

        return response()->json(['qrCode' => $QrCode, 'label_hidden' => $data, 'label' => $label, 'stampingDetails' => $stamping_details]);
    }
}

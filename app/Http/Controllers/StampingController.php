<?php

namespace App\Http\Controllers;

use QrCode;
use DataTables;
use App\Models\User;
use App\Models\Device;

use App\Models\StampingIpqc;
use Illuminate\Http\Request;

use App\Models\MaterialProcess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\FirstStampingProduction;
use App\Models\StampingProductionHistory;
use Illuminate\Support\Facades\Validator;

class StampingController extends Controller
{
    public function view_first_stamp_prod(Request $request){
        $stamping_data = FirstStampingProduction::with([
            'first_stamping_history'
        ])
        ->whereNull('deleted_at')
        ->where('po_num', $request->po)
        ->where('stamping_cat', $request->stamp_cat)
        ->get();

        // $stamping_data = DB::connection('mysql')
        // ->select("SELECT a.*, b.set_up_pins as history_stup, b.adj_pins FROM `stamping_productions` AS a
        // LEFT OUTER JOIN `stamping_production_histories` AS b ON a.id = b.stamping_production_id 
        // WHERE a.deleted_at IS NULL 
        // AND a.po_num = '$request->po'");

        return DataTables::of($stamping_data)
        ->addColumn('action', function($stamping_data){
            $result = "";
            $result .= "<center>";
            /*
                * data-function on buttons will be the trigger point for viewing and editing for mass production
                * 0 => viewing only, 1 => for mass production entry of data
            */
            $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$stamping_data->id' data-function='0' data-stampcat='$stamping_data->stamping_cat'><i class='fa-solid fa-eye'></i></button>";

            if($stamping_data->status == 1){
                $result .= "<button class='btn btn-warning btn-sm btnMassProd' data-id='$stamping_data->id' data-function='1' data-stampcat='$stamping_data->stamping_cat'><i class='fa-solid fa-up-right-from-square'></i></button>";
            }
            else if($stamping_data->status == 2){
                $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$stamping_data->id' data-printcount='$stamping_data->print_count' data-stampcat='$stamping_data->stamping_cat'><i class='fa-solid fa-qrcode'></i></button>";
            }
            else if ($stamping_data->status == 3){
                $result .= "<button class='btn btn-danger btn-sm btnViewResetup' data-id='$stamping_data->id' data-function='2'><i class='fa-solid fa-repeat'></i></button>";
            }


            if(count($stamping_data->first_stamping_history) > 0){
                $result .= "<button class='btn btn-secondary btn-sm btnViewHistory' data-id='$stamping_data->id' data-po='$stamping_data->po_num' title='See History'><i class='fa-solid fa-clock-rotate-left'></i></button>";
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

            return $result;
        })
        ->addColumn('material', function($stamping_data){
            $result = "";
            $result .= "<center>";
            $exploded_mat_no = explode(', ', $stamping_data->material_lot_no);

            for ($i=0; $i <  count($exploded_mat_no); $i++) { 
                $result .= "<span class='badge bg-primary mr-1'>$exploded_mat_no[$i]</span>";
            }

            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action', 'material', 'label'])
        ->make(true);
    }

    public function save_prod_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
     
        if(isset($request->id)){
            if($request->status == 2){
                $validation = array(
                    'ng_count'        => ['required'],
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
                    'act_qty'       => ['required'],
                    'inpt_pins'     => ['required'],
                    'target_output' => ['required'],
                    'planned_loss'  => ['required'],
                    'setup_pins'    => ['required'],
                    'adj_pins'      => ['required'],
                    'qc_samp'       => ['required'],
                   
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
                            $newRecord = new StampingProductionHistory();
                            $newRecord->set_up_pins = $oldRecord->set_up_pins;
                            $newRecord->adj_pins = $oldRecord->adj_pins;
                            $newRecord->qc_samp = $oldRecord->qc_samp;
                            $newRecord->ng_count = $oldRecord->ng_count;
                            $newRecord->stamping_production_id = $id;
                            $newRecord->save();

                            $oldRecord->status = 0;
                            $oldRecord->set_up_pins = $request->setup_pins;
                            $oldRecord->adj_pins = $request->adj_pins;
                            $oldRecord->qc_samp = $request->qc_samp;
                            $oldRecord->ng_count = $request->ng_count;
                            $oldRecord->updated_at = NOW();
                            $oldRecord->updated_by = $user_id->id;
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
                        FirstStampingProduction::where('id', $request->id)
                        ->update([
                            'status'            => 2,
                            'prod_date'         => $request->prod_date,
                            'prod_samp'         => $request->prod_samp,
                            'total_mach_output' => $request->ttl_mach_output,
                            'ship_output'       => $request->ship_output,
                            'mat_yield'         => $request->mat_yield,
                            'updated_at'        => NOW(),
                            'updated_by'        => $user_id->id
                        ]);
                    }
                    
                    DB::commit();
                }
                else{
                    // return $request->all();

                    $imploded_mat_no = implode($request->material_no, ', ');
                    $imploded_operator = implode($request->opt_name, ', ');
                    $prod_array = array(
                        'stamping_cat'      => $request->stamp_cat,
                        'ctrl_counter'      => $request->ctrl_counter,
                        'po_num'            => $request->po_num,
                        'po_qty'            => $request->po_qty,
                        'part_code'         => $request->part_code,
                        'material_name'     => $request->mat_name,
                        'material_lot_no'   => $imploded_mat_no,
                        'drawing_no'        => $request->drawing_no,
                        'drawing_rev'       => $request->drawing_rev,
                        // 'cut_off_point'     => $request->cut_point,
                        // 'no_of_cuts'        => $request->no_cut,
                        'prod_lot_no'       => $request->prod_log_no_auto."".$request->prod_log_no_ext_1."-".$request->prod_log_no_ext_2,
                        // 'input_coil_weight' => $request->inpt_coil_weight,
                        // 'ppc_target_output' => $request->target_output,
                        'planned_loss'      => $request->planned_loss,
                        'set_up_pins'       => $request->setup_pins,
                        'adj_pins'          => $request->adj_pins,
                        'qc_samp'           => $request->qc_samp,
                        'total_mach_output' => $request->ttl_mach_output,
                        'ship_output'       => $request->ship_output,
                        'mat_yield'         => $request->mat_yield,
                        'shift'             => $request->opt_shift,
                        'operator'          => $imploded_operator,
                        'created_by'        => $user_id->id,
                        'created_at'        => NOW()
                    );

                    if($request->stamp_cat == 1){
                        $prod_array['cut_off_point'] = $request->cut_point;
                        $prod_array['no_of_cuts'] = $request->no_cut;
                        $prod_array['input_coil_weight'] = $request->inpt_coil_weight;
                        $prod_array['ppc_target_output'] = $request->target_output;
                    }
                    else{
                        $prod_array['trays'] = $request->tray;
                        $prod_array['no_of_trays'] = $request->no_tray;
                        $prod_array['input_pins'] = $request->inpt_pins;
                        $prod_array['actual_qty'] = $request->act_qty;
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
        ->select("SELECT * FROM tbl_device WHERE `device_code` = '".$request->item_code."'");

        if(count($get_drawing) > 0){
            return $get_drawing[0];
        }
    }

    public function get_prod_data_view(Request $request){
        return FirstStampingProduction::with([
            'user'
        ])
        ->where('id', $request->id)
        ->where('stamping_cat', $request->stamp_cat)
        ->first();
    }

    public function print_qr_code(Request $request){
        $prod_data = FirstStampingProduction::where('id', $request->id)
        ->first(['po_num AS po', 'part_code AS code', 'material_name AS name' , 'prod_lot_no AS production_lot_no', 'po_qty AS qty', 'ship_output AS output_qty']);

        // $prod_data = DB::connection('mysql')
        // ->select("SELECT po_num AS po, part_code AS code, material_name AS name, prod_lot_no AS production_lot_no, po_qty AS qty, ship_output AS output_qty FROM stamping_productions WHERE id = '".$request->id."'");
        
        // return $prod_data[0];
        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($prod_data);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        if($request->stamp_cat == 1){
            $prod_name = "$prod_data->name-X";
        }
        else{
            $prod_name = "$prod_data->name-Y";
        }

        $data[] = array(
            'img' => $QrCode, 
            'text' =>  "<strong>$prod_data->po</strong><br>
            <strong>$prod_data->code</strong><br>
            <strong>$prod_name</strong><br>
            <strong>$prod_data->production_lot_no</strong><br>
            <strong>$prod_data->output_qty</strong><br>
            <strong>$prod_data->qty</strong><br>"
        );

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

        $po_details = DB::connection('mysql')
        ->select("
            SELECT po_num,po_qty, part_code, material_name, drawing_no, drawing_rev FROM `stamping_productions` WHERE `stamping_cat` = 1 AND `po_num` = $data->po LIMIT 0, 1
        ");

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
}

<?php

namespace App\Http\Controllers;

use QrCode;
use DataTables;
use App\Models\Device;
use Illuminate\Http\Request;

use App\Models\MaterialProcess;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use App\Models\FirstStampingProduction;
use Illuminate\Support\Facades\Validator;

class FirstStampingController extends Controller
{
    public function view_first_stamp_prod(Request $request){
        // $stamping_data = FirstStampingProduction::whereNull('deleted_at')
        // ->where('po_num', $request->po)
        // ->get();

        $stamping_data = DB::connection('mysql')
        ->select("SELECT * FROM first_stamping_productions WHERE deleted_at IS NULL AND po_num = '$request->po'");

        return DataTables::of($stamping_data)
        ->addColumn('action', function($stamping_data){
            $result = "";
            $result .= "<center>";
            /*
                * data-function on buttons will be the trigger point for viewing and editing for mass production
                * 0 => viewing only, 1 => for mass production entry of data
            */
            $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$stamping_data->id' data-function='0'><i class='fa-solid fa-eye'></i></button>";

            if($stamping_data->status == 1){
                $result .= "<button class='btn btn-warning btn-sm btnMassProd' data-id='$stamping_data->id' data-function='1'><i class='fa-solid fa-up-right-from-square'></i></button>";
            }
            else if($stamping_data->status == 2){
                $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$stamping_data->id'><i class='fa-solid fa-qrcode'></i></button>";

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
        // return $request->all();
        $data = $request->all();
     
        if(isset($request->id)){
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
        else{
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
                'planned_loss'     => ['required'],
                'setup_pins'       => ['required'],
                'adj_pins'         => ['required'],
                'qc_samp'          => ['required'],
               
            );
        }
        

        $validator = Validator::make($data, $validation);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();
            try{

                // return $request->all();
                if(isset($request->id)){
                    FirstStampingProduction::where('id', $request->id)
                    ->update([
                        'status'            => 2,
                        'prod_date'         => $request->prod_date,
                        'prod_samp'         => $request->prod_samp,
                        'total_mach_output' => $request->ttl_mach_output,
                        'ship_output'       => $request->ship_output,
                        'mat_yield'         => $request->mat_yield,
                        
                    ]);

                    DB::commit();
                }
                else{

                    $imploded_mat_no = implode($request->material_no, ', ');
                    $imploded_operator = implode($request->opt_name, ', ');
                    $prod_array = array(
                        'ctrl_counter'      => $request->ctrl_counter,
                        'po_num'            => $request->po_num,
                        'po_qty'            => $request->po_qty,
                        'part_code'         => $request->part_code,
                        'material_name'     => $request->mat_name,
                        'material_lot_no'   => $imploded_mat_no,
                        'drawing_no'        => $request->drawing_no,
                        'drawing_rev'       => $request->drawing_rev,
                        // 'prod_date'         => $request->prod_date,
                        'cut_off_point'     => $request->cut_point,
                        'no_of_cuts'        => $request->no_cut,
                        'prod_lot_no'       => $request->prod_log_no_auto."".$request->prod_log_no_ext_1."-".$request->prod_log_no_ext_2,
                        'input_coil_weight' => $request->inpt_coil_weight,
                        'ppc_target_output' => $request->target_output,
                        'planned_loss'      => $request->planned_loss,
                        'set_up_pins'       => $request->setup_pins,
                        'adj_pins'          => $request->adj_pins,
                        'qc_samp'           => $request->qc_samp,
                        // 'prod_samp'         => $request->prod_samp,
                        'total_mach_output' => $request->ttl_mach_output,
                        'ship_output'       => $request->ship_output,
                        'mat_yield'         => $request->mat_yield,
                        'shift'             => $request->opt_shift,
                        'operator'          => $imploded_operator,
                        'created_by'        => Auth::user()->id,
                        'created_at'        => NOW()
                    );
    
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
        ->where('id', $request->id)->first();
    }

    public function print_qr_code(Request $request){
        $prod_data = FirstStampingProduction::where('id', $request->id)
        ->first(['po_num AS po', 'part_code AS code', 'material_name AS name' , 'prod_lot_no AS production_lot_no', 'po_qty AS qty', 'ship_output AS output_qty']);

        // return $prod_data;
        $qrcode = QrCode::format('png')
        ->size(200)->errorCorrection('H')
        ->generate($prod_data);

        $QrCode = "data:image/png;base64," . base64_encode($qrcode);

        $data[] = array(
            'img' => $QrCode, 
            'text' =>  "<strong>$prod_data->po</strong><br>
            <strong>$prod_data->code</strong><br>
            <strong>$prod_data->name</strong><br>
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
                    <td>$prod_data->name</td>
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

        return response()->json(['qrCode' => $QrCode, 'label_hidden' => $data, 'label' => $label]);
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

            $collection = collect($mat_process)->pluck('process_details.process_name')->toArray();

            if(!in_array("1st Stamping", $collection)){
                return response()->json([
                    'result' => 2,
                    'msg' => 'Material dont have 1st stamping on material process.'
                ]);
            }
            else{
                return response()->json([
                    'result' => 1,
                    'msg' => 'Material is registered on matrix.'
                ]);
            }

        }
        else{
            return response()->json([
                'result' => 2,
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
        ->select("SELECT MAX(ctrl_counter) as ctrl FROM first_stamping_productions WHERE `created_at` LIKE '%$date%'");

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
}

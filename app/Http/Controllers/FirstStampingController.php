<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\FirstStampingProduction;
use Illuminate\Support\Facades\Validator;

class FirstStampingController extends Controller
{
    public function view_first_stamp_prod(Request $request){
        $stamping_data = FirstStampingProduction::whereNull('deleted_at')
        ->get();

        return DataTables::of($stamping_data)
        ->addColumn('action', function($stamping_data){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$stamping_data->id'><i class='fa-solid fa-eye'></i></button>";
            $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$stamping_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function save_prod_data(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        $validation = array(
            'po_num'           => ['required'],
            'po_qty'           => ['required'],
            'part_code'        => ['required'],
            'mat_name'         => ['required'],
            'mat_lot_no'       => ['required'],
            'drawing_no'       => ['required'],
            'drawing_rev'      => ['required'],
            'opt_name'         => ['required'],
            'opt_shift'        => ['required'],
            'prod_date'        => ['required'],
            'prod_lot_no'      => ['required'],
            'inpt_coil_weight' => ['required'],
            'target_output'    => ['required'],
            'planned_loss'     => ['required'],
            'setup_pins'       => ['required'],
            'adj_pins'         => ['required'],
            'qc_samp'          => ['required'],
            'prod_samp'        => ['required'],
            'ttl_mach_output'  => ['required'],
            'ship_output'      => ['required'],
            'mat_yield'        => ['required'],
        );

        $validator = Validator::make($data, $validation);

        if ($validator->fails()) {
            return response()->json(['result' => '0', 'error' => $validator->messages()]);
        }
        else{
            DB::beginTransaction();
            try{
                $prod_array = array(
                    'po_num'            => $request->po_num,
                    'po_qty'            => $request->po_qty,
                    'part_code'         => $request->part_code,
                    'material_name'     => $request->mat_name,
                    'material_lot_no'   => $request->mat_lot_no,
                    'drawing_no'        => $request->drawing_no,
                    'drawing_rev'       => $request->drawing_rev,
                    'prod_date'         => $request->prod_date,
                    'prod_lot_no'       => $request->prod_lot_no,
                    'input_coil_weight' => $request->inpt_coil_weight,
                    'ppc_target_output' => $request->target_output,
                    'planned_loss'      => $request->planned_loss,
                    'set_up_pins'       => $request->setup_pins,
                    'adj_pins'          => $request->adj_pins,
                    'qc_samp'           => $request->qc_samp,
                    'prod_samp'         => $request->prod_samp,
                    'total_mach_output' => $request->ttl_mach_output,
                    'ship_output'       => $request->ship_output,
                    'mat_yield'         => $request->mat_yield,
                    'created_by'        => Auth::user()->id,
                    'created_at'        => NOW()
                );

                FirstStampingProduction::insert($prod_array);
                DB::commit();

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

        // return $request->all();
        // $po_receive_data = DB::connection('mysql_rapid_pps')
        // ->select("
        //     SELECT * FROM tbl_POReceived WHERE OrderNo = $request->po
        // ");
        // if($po_receive_data == ""){
        //     return response()->json([
        //         'msg' => 'No Data for selected PO'
        //     ]);
        // }

        $get_drawing = DB::connection('mysql_rapid_stamping_dmcms')
        ->select("SELECT * FROM tbl_device WHERE `device_code` = '".$request->item_code."'");

        // return response()->json([
        //     // 'poReceiveData' => $po_receive_data,
        //     'drawings'      => $get_drawing[0]
        // ]);

        return $get_drawing[0];
    }

    public function get_prod_data_view(Request $request){
        return FirstStampingProduction::with([
            'user'
        ])
        ->where('id', $request->id)->first();
    }
}

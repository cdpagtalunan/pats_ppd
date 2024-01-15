<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Auth;
use DataTables;

use App\Models\User;
use App\Models\ReelLot;
use App\Models\PrintLot;
use App\Models\ModeOfDefect;
use App\Models\OQCInspection;
use App\Models\DropdownOqcAql;
use App\Models\AcdcsActiveDocs;
use App\Models\DropdownOqcFamily;
use App\Models\DropdownOqcAssemblyLine;
use App\Models\FirstStampingProduction;
use App\Models\DropdownOqcInspectionMod;
use App\Models\DropdownOqcInspectionType;
use App\Models\DropdownOqcInspectionLevel;
use App\Models\DropdownOqcSeverityInspection;

class OQCInspectionController extends Controller
{
    //============================== VIEW ==============================
    public function viewOqcInspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $prod_details = FirstStampingProduction::with([
            'oqc_inspection_info',
            'oqc_inspection_info.reel_lot_oqc_inspection_info',
            'oqc_inspection_info.print_lot_oqc_inspection_info',
            'oqc_inspection_info.mod_oqc_inspection_info'
        ])
        ->where('po_num', $request->poNo)
        ->where('status', '2')
        ->get();

        // $prod_details = collect($prod_details)->whereIn('oqc_inspection_info.logdel', 0);
            // return  $prod_details;
        // $prod_details = StampingIpqc::with(['oqc_inspection_info'])->where('po_number', $request->poNo)->where('status', 1)->get();
        // $prod_details = StampingIpqcTest::with(['oqc_inspection_info'])->where('po_number', $request->poNo)->where('status', 1)->get();
        // $prod_details = DB::select(DB::raw("SELECT * FROM stamping_prods WHERE po_number = $request->poNo AND status = 1"));
        // $prod_details  =   DB::select(
        //                 DB::raw("SELECT * 
        //                     FROM stamping_prods a
        //                     LEFT JOIN oqc_inspections b 
        //                     ON b.stamping_prods_id = a.id
        //                     WHERE a.po_number = $request->poNo 
        //                     "
        //                 ));
        
        // return $prod_details;
        return DataTables::of($prod_details)
        ->addColumn('action', function($prod_info){
            $result = '<center>';
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            if(count($test) == 1){
                $oqc_id = $test[0]->id;
            }else{
                $oqc_id = '0';
            }

            $result .= '<button class="btn btn-dark btn-sm text-center actionOqcInspection mr-2" oqc_inspection-id="' . $oqc_id . '"prod-id="' . $prod_info->id . '" prod-po="' . $prod_info->po_num . '" prod-device-name="' . $prod_info->material_name . '" prod-po-qty="' . $prod_info->po_qty . '" data-toggle="modal" data-target="#modalOqcInspection" data-keyboard="false" title="Edit"><i class="nav-icon fa fa-edit"></i></button>';
            // $result .= '<button class="btn btn-dark btn-sm text-center actionOqcInspection mr-2" oqc_inspection-id="' . $oqc_id . '"prod-id="' . $prod_info->id . '"data-toggle="modal" data-target="#modalOqcInspection" data-keyboard="false" title="Print Lot & Reel Lots"><i class="fas fa-sticky-note"></i></button>';
            // $result .= '<button class="btn btn-dark btn-sm text-center actionOqcInspection mr-2" oqc_inspection-id="' . $oqc_id . '"prod-id="' . $prod_info->id . '"data-toggle="modal" data-target="#modalOqcInspection" data-keyboard="false" title="Defectives"><i class="fas fa-ban"></i></i></button>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_no', function($prod_info){
            $result = '<center>';
            $result .= $prod_info->po_num;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_qty', function($prod_info){
            // $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            // if(count($test) == 1){
                // $result .= $prod_info->oqc_inspection_info->po_qty;
                // }
                $result .= $prod_info->po_qty;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('prod_lot', function($prod_info){
            $result = '<center>';
            $result .= $prod_info->prod_lot_no;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('material_name', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->material_name;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('fy_ww', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->fy.'-'.$test[0]->ww;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('date_inspected', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->date_inspected;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_from', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->time_ins_from;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_to', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->time_ins_to;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('submission', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->submission;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('lot_no', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->lot_no;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('lot_qty', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->lot_qty;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('sample_size', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->sample_size;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('mod', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->mod;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('num_of_defects', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->num_of_defects;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('judgement', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->judgement;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('inspector', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->inspector;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('remarks', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->remarks;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('family', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->family;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('update_user', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->update_user;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('updated_at', function($prod_info){
            $test = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($test) == 1){
                $result .= $test[0]->updated_at;
            }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
            'po_no',
            'prod_lot',
            'po_qty',
            'material_name',
            'fy_ww',
            'date_inspected',
            'time_ins_from',
            'time_ins_to',
            'submission',
            'lot_no',
            'lot_qty',
            'sample_size',
            'mod',
            'num_of_defects',
            'judgement',
            'inspector',
            'remarks',
            'family',
            'update_user',
            'updated_at',
        ])
        ->make(true);
    }

    public function updateOqcInspection(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();
        $data = $request->all();
        $validator = Validator::make($data, [
            'oqc_inspection_assembly_line'          => 'required',
            'oqc_inspection_lot_no'                 => 'required', 
            'oqc_inspection_application_date'       => 'required',
            'oqc_inspection_application_time'       => 'required',
            'oqc_inspection_product_category'       => 'required',
            'oqc_inspection_po_no'                  => 'required',
            // 'oqc_inspection_material_name'           => 'required',
            // 'oqc_inspection_customer'               => 'required',
            'oqc_inspection_po_qty'                 => 'required',
            'oqc_inspection_family'                 => 'required',
            'oqc_inspection_inspection_type'        => 'required',
            'oqc_inspection_inspection_severity'    => 'required',
            'oqc_inspection_inspection_level'       => 'required',
            'oqc_inspection_lot_qty'                => 'required',
            'oqc_inspection_aql'                    => 'required',
            'oqc_inspection_sample_size'            => 'required',
            // 'oqc_inspection_accept'                 => 'required',
            // 'oqc_inspection_reject'                 => 'required',
            'oqc_inspection_date_inspected'         => 'required',
            'oqc_inspection_work_week'              => 'required',
            'oqc_inspection_fiscal_year'            => 'required',
            'oqc_inspection_time_inspected_from'    => 'required',
            'oqc_inspection_time_inspected_to'      => 'required',
            'oqc_inspection_shift'                  => 'required',
            // 'oqc_inspection_inspector'              => 'required',
            'oqc_inspection_submission'             => 'required',
            'oqc_inspection_coc_requirement'        => 'required',
            'oqc_inspection_judgement'              => 'required',
            'oqc_inspection_lot_inspected'          => 'required',
            'oqc_inspection_lot_accepted'           => 'required',
            // 'oqc_inspection_defective_num'          => 'required',
            'oqc_inspection_remarks'                => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            // DB::beginTransaction();
            // try {
                $check_existing_record = OQCInspection::where('id', $request->oqc_inspection_id)->where('logdel', 0)->get();
                $add_update_oqc_inspection =[
                    'fs_productions_id'         => $request->prod_id,
                    'lot_qty'                   => $request->oqc_inspection_lot_qty,
                    'lot_no'                    => $request->oqc_inspection_lot_no,
                    'po_qty'                    => $request->oqc_inspection_po_qty,
                    'po_no'                     => $request->oqc_inspection_po_no,
                    'ww'                        => $request->oqc_inspection_work_week,
                    'fy'                        => $request->oqc_inspection_fiscal_year,
                    'date_inspected'            => $request->oqc_inspection_date_inspected,
                    'material_name'               => $request->oqc_inspection_material_name,
                    'time_ins_from'             => $request->oqc_inspection_time_inspected_from,
                    'time_ins_to'               => $request->oqc_inspection_time_inspected_to,
                    'submission'                => $request->oqc_inspection_submission,
                    'sample_size'               => $request->oqc_inspection_sample_size,
                    'num_of_defects'            => $request->oqc_inspection_defective_num,
                    'judgement'                 => $request->oqc_inspection_judgement,
                    'inspector'                 => $request->oqc_inspection_inspector,
                    'remarks'                   => $request->oqc_inspection_remarks,
                    'shift'                     => $request->oqc_inspection_shift,
                    'assembly_line'             => $request->oqc_inspection_assembly_line,
                    'app_date'                  => $request->oqc_inspection_application_date,
                    'app_time'                  => $request->oqc_inspection_application_time,
                    'prod_category'             => $request->oqc_inspection_product_category,
                    'customer'                  => $request->oqc_inspection_customer,
                    'family'                    => $request->oqc_inspection_family,
                    'type_of_inspection'        => $request->oqc_inspection_inspection_type,
                    'severity_of_inspection'    => $request->oqc_inspection_inspection_severity,
                    'inspection_lvl'            => $request->oqc_inspection_inspection_level,
                    'aql'                       => $request->oqc_inspection_aql,
                    'accept'                    => $request->oqc_inspection_accept,
                    'reject'                    => $request->oqc_inspection_reject,
                    'coc_req'                   => $request->oqc_inspection_coc_requirement,
                    'lot_inspected'             => $request->oqc_inspection_lot_inspected,
                    'lot_accepted'              => $request->oqc_inspection_lot_accepted,
                    'update_user'               => $request->employee_no,
                    'created_at'                => date('Y-m-d H:i:s'),
                ];    
                
                if($request->oqc_inspection_id == 0){
                    $getID = OQCInspection::insertGetId(
                        $add_update_oqc_inspection
                    );
                }else{
                    $getID = $request->oqc_inspection_id;
                    OQCInspection::where('id', $request->oqc_inspection_id)
                    ->update(
                        $add_update_oqc_inspection
                    );
                }
    
                PrintLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                ReelLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                ModeOfDefect::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();

                for($print_lot_counter = 0; $print_lot_counter <= $request->print_lot_counter; $print_lot_counter++) { 
                    $add_print_lot['oqc_inspection_id'] = $getID;
                    $add_print_lot['counter']  = $print_lot_counter;
                    $add_print_lot['print_lot_no']  = $request->input("print_lot_no_$print_lot_counter");
                    $add_print_lot['print_lot_qty'] = $request->input("print_lot_qty_$print_lot_counter");
                    PrintLot::insert(
                        $add_print_lot
                    );
                }

                for($reel_lot_counter = 0; $reel_lot_counter <= $request->reel_lot_counter; $reel_lot_counter++) { 
                    $add_reel_lot['oqc_inspection_id'] = $getID;
                    $add_reel_lot['counter']  = $reel_lot_counter;
                    $add_reel_lot['reel_lot_no']  = $request->input("reel_lot_no_$reel_lot_counter");
                    $add_reel_lot['reel_lot_qty'] = $request->input("reel_lot_qty_$reel_lot_counter");
                    ReelLot::insert(
                        $add_reel_lot
                    );
                }

                for($mod_counter = 0; $mod_counter <= $request->mod_counter; $mod_counter++) { 
                    $add_mod['oqc_inspection_id'] = $getID;
                    $add_mod['counter']  = $mod_counter;
                    $add_mod['mod']  = $request["mod_$mod_counter"];
                    $add_mod['mod_qty'] = $request->input("mod_qty_$mod_counter");
                    ModeOfDefect::insert(
                        $add_mod
                    );
                }

                // DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }

    public function scanUserId(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $user_details = User::where('employee_id', $request->user_id)->first();
        // return $user_details;
        return response()->json(['userDetails' => $user_details]);
    }

    public function getOqcInspectionById(Request $request){
        $get_oqc_inspection_data = OQCInspection::with([
            'reel_lot_oqc_inspection_info',
            'print_lot_oqc_inspection_info',
            'mod_oqc_inspection_info'
        ])
        ->where('id', $request->getOqcId)
        ->where('logdel', 0)
        ->get();

        $active_doc = FirstStampingProduction::with(['acdcs_active_doc_info'])->get();
        // return $active_doc;
        return response()->json(['getOqcInspectionData' => $get_oqc_inspection_data, 'activeDoc' => $active_doc]);
    }

    public function getAssemblyLine(){
        $collect_assembly_line = DropdownOqcAssemblyLine::orderBy('assembly_line', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectAssemblyLine' => $collect_assembly_line]);
    }

    public function getFamily(){
        $collect_family = DropdownOqcFamily::orderBy('family', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectFamily' => $collect_family]);
    }

    public function getInspectionType(){
        $collect_inspection_type = DropdownOqcInspectionType::orderBy('inspection_type', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectInspectionType' => $collect_inspection_type]);
    }

    public function getInspectionLevel(){
        $collect_inspection_level = DropdownOqcInspectionLevel::orderBy('inspection_level', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectInspectionLevel' => $collect_inspection_level]);
    }

    public function getSeverityInspection(){
        $collect_severity_inspection = DropdownOqcSeverityInspection::orderBy('severity_inspection', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectSeverityInspection' => $collect_severity_inspection]);
    }

    public function getAQL(){
        $collect_aql = DropdownOqcAql::orderBy('aql', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectAql' => $collect_aql]);
    }

    public function getMOD(){
        $collect_mod = DropdownOqcInspectionMod::orderBy('mode_of_defect', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectMod' => $collect_mod]);
    }

}

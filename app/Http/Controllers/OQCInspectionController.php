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
use App\Models\DropdownOqcStampingLine;
use App\Models\FirstStampingProduction;
use App\Models\DropdownOqcInspectionMod;
use App\Models\DropdownOqcInspectionType;
use App\Models\DropdownOqcInspectionLevel;
use App\Models\DropdownOqcSeverityInspection;
use App\Models\DropdownOqcInspectionCustomer;

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
        ->where('stamping_cat', '1')
        ->orderBy('id', 'DESC')
        ->get();

        return DataTables::of($prod_details)
        ->addColumn('action', function($prod_info){
            $result = '<center>';
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            
            if(count($get_oqc_inspection_per_row) > 1){
                $result .= '
                    <button class="btn btn-warning btn-sm text-center 
                        actionOqcInspectionHistory" 
                        oqc_inspection-id="' . $get_oqc_inspection_per_row[0]->id . '" 
                        prod-id="' . $prod_info->id . '" 
                        prod-po="' . $prod_info->po_num . '" 
                        prod-material-name="' . $prod_info->material_name . '" 
                        prod-po-qty="' . $prod_info->po_qty . '" 
                        prod-lot-no="' . $prod_info->prod_lot_no . '" 
                        prod-ship-output="' . $prod_info->ship_output . '" 
                        data-toggle="modal" 
                        data-target="#mdlOqcInspectionHistory" 
                        data-keyboard="false" 
                        title="History">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </button>&nbsp;';
            }else{
                if(count($get_oqc_inspection_per_row) != 0){
                    $result .= '
                        <button class="btn btn-info btn-sm text-center 
                            actionOqcInspectionView" 
                            first-stamping="1" 
                            oqc_inspection-id="' . $get_oqc_inspection_per_row[0]->id . '"
                            prod-id="' . $prod_info->id . '" prod-po="' . $prod_info->po_num . '" 
                            prod-material-name="' . $prod_info->material_name . '" 
                            prod-po-qty="' . $prod_info->po_qty . '" 
                            prod-lot-no="' . $prod_info->prod_lot_no . '" 
                            prod-ship-output="' . $prod_info->ship_output . '" 
                            data-toggle="modal" 
                            data-target="#modalOqcInspection" 
                            data-keyboard="false" 
                            title="View">
                            <i class="nav-icon fa fa-eye"></i>
                        </button>&nbsp;';
                }
            }

            if(count($get_oqc_inspection_per_row) > 0){
                if($get_oqc_inspection_per_row[0]->lot_accepted == 0){
                    $result .= '
                        <button class="btn btn-dark btn-sm text-center 
                            actionOqcInspectionFirstStamping"
                            first-stamping="1" 
                            oqc_inspection-id="' . $get_oqc_inspection_per_row[0]->id . '" 
                            prod-id="' . $prod_info->id . '" 
                            prod-po="' . $prod_info->po_num . '" 
                            prod-material-name="' . $prod_info->material_name . '" 
                            prod-po-qty="' . $prod_info->po_qty . '" 
                            prod-lot-no="' . $prod_info->prod_lot_no . '" 
                            prod-ship-output="' . $prod_info->ship_output . '" 
                            data-toggle="modal" 
                            data-target="#modalOqcInspection"
                            data-keyboard="false" 
                            title="Edit">
                            <i class="nav-icon fa fa-edit"></i>
                        </button>&nbsp;';
                }
            }else{
                $result .= '
                <button class="btn btn-dark btn-sm text-center 
                    actionOqcInspectionFirstStamping" 
                    first-stamping="1" 
                    oqc_inspection-id="0" 
                    prod-id="' . $prod_info->id . '" 
                    prod-po="' . $prod_info->po_num . '" 
                    prod-material-name="' . $prod_info->material_name . '" 
                    prod-po-qty="' . $prod_info->po_qty . '" 
                    prod-lot-no="' . $prod_info->prod_lot_no . '"
                    prod-ship-output="' . $prod_info->ship_output . '" 
                    data-toggle="modal" 
                    data-target="#modalOqcInspection" 
                    data-keyboard="false" 
                    title="Edit">
                    <i class="nav-icon fa fa-edit"></i>
                </button>&nbsp;';
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('status', function($prod_info){
            $result = '<center>';
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            if(count($get_oqc_inspection_per_row) > 0){
                switch($get_oqc_inspection_per_row[0]->lot_accepted)
                {
                    case 0: // LOT ACCEPTED
                    {   
                        $result .= '<span class="badge badge-pill badge-danger"> Lot <br> Rejected</span>';
                        break;
                    }
                    case 1:  // LOT REJECTED
                    {   
                        $result .= '<span class="badge badge-pill badge-success"> Lot <br> Accepted</span>';
                        break;
                    }
                    default:
                    {
                        $result .= 'N/A';
                        break;
                    }
                }
            }else{
                $result .= '<span class="badge badge-pill badge-info"> For <br> Inspection</span>';
            }
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
            $result = '<center>';
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

        ->addColumn('prod_lot_qty', function($prod_info){
            $result = '<center>';
            $result .= $prod_info->ship_output;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('material_name', function($prod_info){
            $result = '<center>';
            $result .= $prod_info->material_name;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('fy_ww', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->fy.'-'.$get_oqc_inspection_per_row[0]->ww;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('date_inspected', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->date_inspected;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_from', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->time_ins_from;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_to', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->time_ins_to;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('submission', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->submission;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('sample_size', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->sample_size;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('mod', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::with(['mod_oqc_inspection_info'])->where('fs_productions_id', $prod_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                if($get_oqc_inspection_per_row[0]->judgement == 'Reject'){
                    for ($i=0; $i < count($get_oqc_inspection_per_row[0]->mod_oqc_inspection_info); $i++) { 
                        $result .= $get_oqc_inspection_per_row[0]->mod_oqc_inspection_info[$i]->mod." \n ";
                    }
                }else{
                    $result .= 'N/A';
                }
            }
            // $result .= $get_oqc_inspection_per_row[0]->mod_oqc_inspection_info;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('num_of_defects', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                if($get_oqc_inspection_per_row[0]->judgement == 'Reject'){
                    $result .= $get_oqc_inspection_per_row[0]->num_of_defects;
                }else{
                    $result .= 'N/A';
                }
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('judgement', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->judgement;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('inspector', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->inspector;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('remarks', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->remarks;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('family', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->family;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('update_user', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->update_user;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('updated_at', function($prod_info){
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_per_row) > 0){
                $result .= $get_oqc_inspection_per_row[0]->updated_at;
            }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
            'status',
            'po_no',
            'po_qty',
            'prod_lot',
            'prod_lot_qty',
            'material_name',
            'fy_ww',
            'date_inspected',
            'time_ins_from',
            'time_ins_to',
            'submission',
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

    //============================== VIEW ==============================
    public function viewOqcInspectionHistory(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $oqc_details = OQCInspection::with([
            'stamping_production_info',
            'mod_oqc_inspection_info'
        ])
        ->where('fs_productions_id', $request->poNoById)
        ->where('logdel', 0)
        ->orderBy('id', 'DESC')
        ->get();

        return DataTables::of($oqc_details)
        ->addColumn('action', function($oqc_info){
            $result = '<center>';
            $result .= '<button class="btn btn-info btn-sm text-center actionOqcInspectionView" oqc_inspection-id="'. $oqc_info->id .'" prod-id="'. $oqc_info->stamping_production_info->id .'" prod-po="'. $oqc_info->stamping_production_info->po_num .'" prod-material-name="'. $oqc_info->stamping_production_info->material_name .'" prod-po-qty="'. $oqc_info->stamping_production_info->po_qty .'" prod-lot-no="'. $oqc_info->stamping_production_info->prod_lot_no .'" prod-ship-output="'. $oqc_info->stamping_production_info->ship_output .'" data-toggle="modal" data-target="#modalOqcInspection" data-keyboard="false" title="View"><i class="nav-icon fa fa-eye"></i></button>';
            $result .= '</center>';
            return $result;
        })

        ->addColumn('fy_ww', function($oqc_info){
            $result = '<center>';
            $result .= $oqc_info->fy.'-'.$oqc_info->ww;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('mod', function($oqc_info){
            $result = '<center>';
                if($oqc_info->judgement == 'Reject'){
                    for ($i=0; $i < count($oqc_info->mod_oqc_inspection_info); $i++) { 
                        $result .= $oqc_info->mod_oqc_inspection_info[$i]->mod." \n ";
                    }
                }else{
                    $result .= 'N/A';
                }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
            'fy_ww',
            'mod',
        ])
        ->make(true);
    }

    //============================== VIEW ==============================
    public function viewOqcInspectionSecondStamping(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $prod_second_stamping_details = FirstStampingProduction::with([
            'oqc_inspection_info',
            'oqc_inspection_info.reel_lot_oqc_inspection_info',
            'oqc_inspection_info.print_lot_oqc_inspection_info',
            'oqc_inspection_info.mod_oqc_inspection_info'
        ])
        ->where('po_num', $request->poNo)
        ->where('status', '2')
        ->where('stamping_cat', '2')
        ->orderBy('id', 'DESC')
        ->get();

        return DataTables::of($prod_second_stamping_details)
        ->addColumn('action', function($prod_second_stamping_info){
            $result = '<center>';
            $get_oqc_inspection_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)
                ->where('logdel', 0)
                ->orderBy('id', 'DESC')
                ->get();
            
            if(count($get_oqc_inspection_per_row) > 1){
                $result .= '
                    <button class="btn btn-warning btn-sm text-center 
                        actionOqcInspectionSecondStampingHistory" 
                        second-stamping="2" 
                        oqc_inspection_second_stamping-id="' . $get_oqc_inspection_per_row[0]->id . '" 
                        prod_second_stamping-id="' . $prod_second_stamping_info->id . '" 
                        prod_second_stamping-po="' . $prod_second_stamping_info->po_num . '" 
                        prod_second_stamping-material_name="' . $prod_second_stamping_info->material_name . '" 
                        prod_second_stamping-po_qty="' . $prod_second_stamping_info->po_qty . '" 
                        prod_second_stamping-lot_no="' . $prod_second_stamping_info->prod_lot_no . '" 
                        prod_second_stamping-ship_output="' . $prod_second_stamping_info->ship_output . '" 
                        data-toggle="modal" 
                        data-target="#mdlOqcInspectionHistory" 
                        data-keyboard="false" 
                        title="History">
                        <i class="fa-solid fa-book-bookmark"></i>
                    </button>&nbsp;';
            }else{
                if(count($get_oqc_inspection_per_row) != 0){
                    $result .= '
                        <button class="btn btn-info btn-sm text-center 
                            actionOqcInspectionSecondStampingView" 
                            oqc_inspection_second_stamping-id="' . $get_oqc_inspection_per_row[0]->id . '"
                            prod_second_stamping-id="' . $prod_second_stamping_info->id . '" 
                            prod_second_stamping-po="' . $prod_second_stamping_info->po_num . '" 
                            prod_second_stamping-material_name="' . $prod_second_stamping_info->material_name . '" 
                            prod_second_stamping-po_qty="' . $prod_second_stamping_info->po_qty . '" 
                            prod_second_stamping-lot_no="' . $prod_second_stamping_info->prod_lot_no . '" 
                            prod_second_stamping-ship_output="' . $prod_second_stamping_info->ship_output . '" 
                            data-toggle="modal" 
                            data-target="#modalOqcInspectionSecondStamping" 
                            data-keyboard="false" 
                            title="View">
                            <i class="nav-icon fa fa-eye"></i>
                        </button>&nbsp;';
                }
            }

            if(count($get_oqc_inspection_per_row) > 0){
                if($get_oqc_inspection_per_row[0]->lot_accepted == 0){
                    $result .= '
                        <button class="btn btn-dark btn-sm text-center 
                            actionOqcInspectionSecondStamping"
                            second-stamping="2"
                            oqc_inspection_second_stamping-id="' . $get_oqc_inspection_per_row[0]->id . '" 
                            prod_second_stamping-id="' . $prod_second_stamping_info->id . '" 
                            prod_second_stamping-po="' . $prod_second_stamping_info->po_num . '" 
                            prod_second_stamping-material_name="' . $prod_second_stamping_info->material_name . '" 
                            prod_second_stamping-po_qty="' . $prod_second_stamping_info->po_qty . '" 
                            prod_second_stamping-lot_no="' . $prod_second_stamping_info->prod_lot_no . '" 
                            prod_second_stamping-ship_output="' . $prod_second_stamping_info->ship_output . '" 
                            data-toggle="modal" 
                            data-target="#modalOqcInspectionSecondStamping"
                            data-keyboard="false" 
                            title="Edit">
                            <i class="nav-icon fa fa-edit"></i>
                        </button>&nbsp;';
                }
            }else{
                $result .= '
                <button class="btn btn-dark btn-sm text-center 
                    actionOqcInspectionSecondStamping" 
                    second-stamping="2" 
                    oqc_inspection_second_stamping-id="0" 
                    prod_second_stamping-id="' . $prod_second_stamping_info->id . '" 
                    prod_second_stamping-po="' . $prod_second_stamping_info->po_num . '" 
                    prod_second_stamping-material_name="' . $prod_second_stamping_info->material_name . '" 
                    prod_second_stamping-po_qty="' . $prod_second_stamping_info->po_qty . '" 
                    prod_second_stamping-lot_no="' . $prod_second_stamping_info->prod_lot_no . '"
                    prod_second_stamping-ship_output="' . $prod_second_stamping_info->ship_output . '" 
                    data-toggle="modal" 
                    data-target="#modalOqcInspectionSecondStamping" 
                    data-keyboard="false" 
                    title="Edit">
                    <i class="nav-icon fa fa-edit"></i>
                </button>&nbsp;';
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('status', function($prod_second_stamping_info){
            $result = '<center>';
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                switch($get_oqc_inspection_per_row[0]->lot_accepted)
                {
                    case 0: // LOT ACCEPTED
                    {   
                        $result .= '<span class="badge badge-pill badge-success"> Lot <br> Accepted</span>';
                        break;
                    }
                    case 1:  // LOT REJECTED
                    {   
                        $result .= '<span class="badge badge-pill badge-danger"> Lot <br> Rejected</span>';
                        break;
                    }
                    default:
                    {
                        $result .= 'N/A';
                        break;
                    }
                }
            }else{
                $result .= '<span class="badge badge-pill badge-info"> For <br> Inspection</span>';
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_no', function($prod_second_stamping_info){
            $result = '<center>';
            $result .= $prod_second_stamping_info->po_num;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('po_qty', function($prod_second_stamping_info){
            $result = '<center>';
            $result .= $prod_second_stamping_info->po_qty;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('prod_lot', function($prod_second_stamping_info){
            $result = '<center>';
            $result .= $prod_second_stamping_info->material_lot_no.'/'.$prod_second_stamping_info->prod_lot_no;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('prod_lot_qty', function($prod_second_stamping_info){
            $result = '<center>';
            $result .= $prod_second_stamping_info->ship_output;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('material_name', function($prod_second_stamping_info){
            $result = '<center>';
            $result .= $prod_second_stamping_info->material_name;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('fy_ww', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->fy.'-'.$get_oqc_inspection_second_stamping_per_row[0]->ww;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('date_inspected', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->date_inspected;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_from', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->time_ins_from;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('time_ins_to', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->time_ins_to;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('submission', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->submission;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('sample_size', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->sample_size;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('mod', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::with(['mod_oqc_inspection_info'])->where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                if($get_oqc_inspection_second_stamping_per_row[0]->judgement == 'Reject'){
                    for ($i=0; $i < count($get_oqc_inspection_second_stamping_per_row[0]->mod_oqc_inspection_info); $i++) { 
                        $result .= $get_oqc_inspection_second_stamping_per_row[0]->mod_oqc_inspection_info[$i]->mod." \n ";
                    }
                }else{
                    $result .= 'N/A';
                }
            }
            // $result .= $get_oqc_inspection_second_stamping_per_row[0]->mod_oqc_inspection_info;
            $result .= '</center>';
            return $result;
        })

        ->addColumn('num_of_defects', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                if($get_oqc_inspection_second_stamping_per_row[0]->judgement == 'Reject'){
                    $result .= $get_oqc_inspection_second_stamping_per_row[0]->num_of_defects;
                }else{
                    $result .= 'N/A';
                }
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('judgement', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->judgement;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('inspector', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->inspector;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('remarks', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->remarks;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('family', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->family;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('update_user', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->update_user;
            }
            $result .= '</center>';
            return $result;
        })

        ->addColumn('updated_at', function($prod_second_stamping_info){
            $get_oqc_inspection_second_stamping_per_row = OQCInspection::where('fs_productions_id', $prod_second_stamping_info->id)->where('logdel', 0)->orderBy('id', 'DESC')->get();
            $result = '<center>';
            if(count($get_oqc_inspection_second_stamping_per_row) > 0){
                $result .= $get_oqc_inspection_second_stamping_per_row[0]->updated_at;
            }
            $result .= '</center>';
            return $result;
        })

        ->rawColumns([
            'action',
            'status',
            'po_no',
            'po_qty',
            'prod_lot',
            'prod_lot_qty',
            'material_name',
            'fy_ww',
            'date_inspected',
            'time_ins_from',
            'time_ins_to',
            'submission',
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
        $data = $request->all();
        $defect_count = 0;
        if($request->oqc_inspection_lot_accepted == 1){
            $yield = '100%';
        }else{
            $tist = FirstStampingProduction::where('id', $request->prod_id)->get();
            for($mod_counter = 0; $mod_counter <= $request->mod_counter; $mod_counter++) { 
                $add_mod_quantity = $request->input("mod_qty_$mod_counter");
                $defect_count += $add_mod_quantity;
            }
            // $yield = (($tist[0]->ship_output-$defect_count)/$tist[0]->ship_output*100).'%';
            $yield = number_format((($tist[0]->ship_output-$defect_count)/$tist[0]->ship_output*100),2).'%';
            // return $yield;
        }
        $validator = Validator::make($data, [
            'oqc_inspection_stamping_line'          => 'required',
            'oqc_inspection_application_date'       => 'required',
            'oqc_inspection_application_time'       => 'required',
            'oqc_inspection_product_category'       => 'required',
            'oqc_inspection_po_no'                  => 'required',
            'oqc_inspection_material_name'          => 'required',
            'oqc_inspection_customer'               => 'required',
            'oqc_inspection_po_qty'                 => 'required',
            'oqc_inspection_family'                 => 'required',
            'oqc_inspection_inspection_type'        => 'required',
            'oqc_inspection_inspection_severity'    => 'required',
            'oqc_inspection_inspection_level'       => 'required',
            'oqc_inspection_aql'                    => 'required',
            'oqc_inspection_sample_size'            => 'required',
            'oqc_inspection_accept'                 => 'required',
            'oqc_inspection_reject'                 => 'required',
            'oqc_inspection_date_inspected'         => 'required',
            'oqc_inspection_work_week'              => 'required',
            'oqc_inspection_fiscal_year'            => 'required',
            'oqc_inspection_time_inspected_from'    => 'required',
            'oqc_inspection_time_inspected_to'      => 'required',
            'oqc_inspection_shift'                  => 'required',
            'oqc_inspection_inspector'              => 'required',
            'oqc_inspection_submission'             => 'required',
            'oqc_inspection_coc_requirement'        => 'required',
            'oqc_inspection_judgement'              => 'required',
            'oqc_inspection_lot_inspected'          => 'required',
            'oqc_inspection_lot_accepted'           => 'required',
            // 'oqc_inspection_remarks'                => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['validationHasError' => 1, 'error' => $validator->messages()]);
        } else {
            // DB::beginTransaction();
            // try {
                $check_existing_record = OQCInspection::with(['stamping_production_info'])->where('id', $request->oqc_inspection_id)->where('logdel', 0)->get();
                // return $check_existing_record;

                $add_update_oqc_inspection =[
                    'fs_productions_id'         => $request->prod_id,
                    'status'                    => $request->status,
                    'po_no'                     => $request->oqc_inspection_po_no,
                    'ww'                        => $request->oqc_inspection_work_week,
                    'fy'                        => $request->oqc_inspection_fiscal_year,
                    'date_inspected'            => $request->oqc_inspection_date_inspected,
                    'time_ins_from'             => $request->oqc_inspection_time_inspected_from,
                    'time_ins_to'               => $request->oqc_inspection_time_inspected_to,
                    'submission'                => $request->oqc_inspection_submission,
                    'sample_size'               => $request->oqc_inspection_sample_size,
                    'num_of_defects'            => $defect_count,
                    'yield'                     => $yield,
                    'judgement'                 => $request->oqc_inspection_judgement,
                    'inspector'                 => $request->oqc_inspection_inspector,
                    'remarks'                   => $request->oqc_inspection_remarks,
                    'shift'                     => $request->oqc_inspection_shift,
                    'stamping_line'             => $request->oqc_inspection_stamping_line,
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
                    'created_at'               => date('Y-m-d H:i:s'),
                ];    
                // return $oqc_status;
                // if($request->oqc_inspection_id == 0 || $request->oqc_inspection_lot_accepted = 1){
                    // $add_update_oqc_inspection['created_at']  = date('Y-m-d H:i:s');
                    $getID = OQCInspection::insertGetId(
                        $add_update_oqc_inspection
                    );
                // }else{
                //     $add_update_oqc_inspection['updated_at']  = date('Y-m-d H:i:s');
                //     $getID = $request->oqc_inspection_id;
                //     OQCInspection::where('id', $request->oqc_inspection_id)
                //     ->update(
                //         $add_update_oqc_inspection
                //     );
                // }

                if ($request->print_lot_no_0 != null && $request->print_lot_qty_0 != null) {
                    // PrintLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                    for($print_lot_counter = 0; $print_lot_counter <= $request->print_lot_counter; $print_lot_counter++) { 
                        $add_print_lot['oqc_inspection_id'] = $getID;
                        $add_print_lot['counter']  = $print_lot_counter;
                        $add_print_lot['print_lot_no']  = $request->input("print_lot_no_$print_lot_counter");
                        $add_print_lot['print_lot_qty'] = $request->input("print_lot_qty_$print_lot_counter");

                        PrintLot::insert(
                            $add_print_lot
                        );
                    }
                }else{
                    // PrintLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                }

                if ($request->reel_lot_no_0 != null && $request->reel_lot_qty_0 != null) {
                    // ReelLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                    for($reel_lot_counter = 0; $reel_lot_counter <= $request->reel_lot_counter; $reel_lot_counter++) { 
                        $add_reel_lot['oqc_inspection_id'] = $getID;
                        $add_reel_lot['counter']  = $reel_lot_counter;
                        $add_reel_lot['reel_lot_no']  = $request->input("reel_lot_no_$reel_lot_counter");
                        $add_reel_lot['reel_lot_qty'] = $request->input("reel_lot_qty_$reel_lot_counter");

                        ReelLot::insert(
                            $add_reel_lot
                        );
                    }
                }else{
                    // ReelLot::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                }

                if ($request->mod_0 != null && $request->mod_qty_0 != null) {
                    // ModeOfDefect::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                    for($mod_counter = 0; $mod_counter <= $request->mod_counter; $mod_counter++) { 
                        $add_mod['oqc_inspection_id'] = $getID;
                        $add_mod['counter']  = $mod_counter;
                        $add_mod['mod']  = $request["mod_$mod_counter"];
                        $add_mod['mod_qty'] = $request->input("mod_qty_$mod_counter");

                        ModeOfDefect::insert(
                            $add_mod
                        );
                    }
                }else{
                    // ModeOfDefect::where('oqc_inspection_id', $request->oqc_inspection_id)->delete();
                }

            //     DB::commit();
                return response()->json(['hasError' => 0]);
            // } catch (\Exception $e) {
            //     DB::rollback();
            //     return response()->json(['hasError' => 1, 'exceptionError' => $e->getMessage()]);
            // }
        }
    }

    public function getStampingLine(){
        $collect_stamping_line = DropdownOqcStampingLine::orderBy('stamping_line', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectStampingLine' => $collect_stamping_line]);
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

    public function getCustomer(){
        $collect_customer = DropdownOqcInspectionCustomer::orderBy('customer', 'ASC')->where('logdel', 0)->get();
        return response()->json(['collectCustomer' => $collect_customer]);
    }

    public function getOqcInspectionById(Request $request){
        date_default_timezone_set('Asia/Manila');
        
        $get_inspector = Auth::user();  
        $first_stamping_production = FirstStampingProduction::with([
            'stamping_ipqc', 
            'stamping_ipqc.bdrawing_active_doc_info', 
            'stamping_ipqc.ud_drawing_active_doc_info', 
            'stamping_ipqc.insp_std_drawing_active_doc_info', 
        ])
        ->where('id', $request->getProdId)
        ->get();
        $get_oqc_inspection_data = OQCInspection::with([
            'reel_lot_oqc_inspection_info',
            'print_lot_oqc_inspection_info',
            'mod_oqc_inspection_info'
        ])
        ->where('id', $request->getOqcId)
        ->where('logdel', 0)
        ->get();

        return response()->json([
            'getInspector'              => $get_inspector,
            'getOqcInspectionData'      => $get_oqc_inspection_data,
            'firstStampingProduction'   => $first_stamping_production
        ]);
    }

    public function scanUserId(Request $request){
        date_default_timezone_set('Asia/Manila');

        $user_details = User::where('employee_id', $request->user_id)->first();
        // return $user_details;
        return response()->json(['userDetails' => $user_details]);
    }

}

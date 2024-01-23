<?php

namespace App\Http\Controllers;

use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\FirstStampingProduction;
use App\Models\OQCInspection;
use App\Models\User;
use App\Models\PackingDetails;

class PackingDetailsController extends Controller
{
    public function viewPackingDetailsData(Request $request){
        $packing_details = OQCInspection::with(['stamping_production_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        ->where('lot_accepted', 1)
        ->get();

        if(!isset($request->po_no)){
            return [];
        }else{
            
            return DataTables::of($packing_details)
            ->addColumn('action', function($packing_details){
                $result = "";
                $result .= "<center>";
                    $result .= "<button class='btn btn-primary btn-sm btnEditPackingDetails' data-id='$packing_details->id'><i class='fa-solid fa-edit'></i></button>&nbsp";
                $result .= "</center>";
                return $result;
            })
            ->addColumn('status', function($packing_details){
                $result = "";
                $result .= "<center>";
        
                // if($test == 2){
                //     $result .= '<span class="badge bg-success">Active</span>';
                // }
                // else{
                //     $result .= '<span class="badge bg-danger">Disabled</span>';
                // }

                $result .= "</center>";
                return $result;
            })
            ->addIndexColumn(['DT_RowIndex'])
            ->rawColumns(['action','status'])
            // ->rawColumns(['action','status','test'])
            ->make(true);
        }
    }

    public function getOqcDetailsForPacking(Request $request){
        $oqc_data = OQCInspection::with(['stamping_production_info'])
        ->where('po_no', 'like', '%' . $request->po_no . '%')
        // ->where('id', $request->oqc_details_id)
        ->where('lot_accepted', 1)
        ->get();

        return response()->json(['oqcData' => $oqc_data]);
        // return $oqc_data;
    }

    public function addPackingDetails(Request $request){
        $data = $request->all();

        $rules = [
            // 'control_no'                 => 'required',
            // // 'company_contact_no'      => 'required',
            // 'company_address'      => 'required',
            // 'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                        $array = [
                            'oqc_id'                => $request->packing_details_id,
                            'po_no'                 => $request->po_no,
                            'material_name'         => $request->parts_name,
                            'po_qty'                => $request->po_quantity,
                            'delivery_balance'      => $request->delivery_balance,
                            'drawing_no'            => $request->drawing_no,
                            'lot_no'                => $request->prod_lot_no,
                            'no_of_cuts'            => $request->number_of_cuts,
                            'material_quality'      => $request->material_quality,
                            'status'                => 0,
                            'created_at'            => date('Y-m-d H:i:s'),
                        ];
                        if(isset($request->packing_list_id)){ // edit
                            PackingDetails::where('id', $request->packing_list_id)
                            ->update($array);
                        }
        
            return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }
}

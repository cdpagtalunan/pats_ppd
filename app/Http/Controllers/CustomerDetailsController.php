<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\CustomerDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerDetailsController extends Controller
{
    public function viewCompanyDetails(Request $request){
        $customer_data = CustomerDetails::all();

        return DataTables::of($customer_data)
        ->addColumn('action', function($customer_data){
            $result = "";
            $result .= "<center>";
            $result .= "<button class='btn btn-primary btn-sm btnEditCustomerDetails' data-id='$customer_data->id'><i class='fa-solid fa-edit'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($customer_data){
            $result = "";
            $result .= "<center>";

            if($customer_data->status == 0){
                $result .= '<span class="badge bg-info">Active</span>';
            }
            else{
                $result .= '<span class="badge bg-danger">Disabled</span>';
            }
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function addCustomerDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        session_start();

        $data = $request->all();

        // return $data;

        $rules = [
            'company_name'                 => 'required',
            // 'company_contact_no'      => 'required',
            'company_address'      => 'required',
            'company_contact_person'      => 'required'
        ];

        $validator = Validator::make($data, $rules);
        if($validator->passes()){
                $array = [
                    'company'     => $request->company_name,
                    'company_address' => $request->company_address,
                    'company_contact_no' => $request->company_contact_no,
                    'contact_person' => $request->company_contact_person,
                    'status'        => 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                    // 'created_by' => $_SESSION['rapidx_username'],
                ];
                if(isset($request->customer_details_id)){ // edit
                    CustomerDetails::where('id', $request->customer_details_id)
                    ->update($array);
                }
                else{ // insert
                    CustomerDetails::insert($array);
                }

                return response()->json(['result' => 0, 'message' => "SuccessFully Saved!"]);
        }
        else{
            return response()->json(['validation' => 1, "hasError", 'error' => $validator->messages()]);
        }
    }

    public function getCustomerDetailsById(Request $request){
        $customerDetails = CustomerDetails::
        where('id', $request->customer_details_id)
        ->get();

        // return $customerDetails;

        return response()->json(['customerDetails' => $customerDetails]);
    }
}

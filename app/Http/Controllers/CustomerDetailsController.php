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
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$customer_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$customer_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($customer_data){
            $result = "";
            $result .= "<center>";
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$customer_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$customer_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);

    }
}

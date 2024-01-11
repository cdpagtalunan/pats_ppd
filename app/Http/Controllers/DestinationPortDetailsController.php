<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\DestinationPortDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DestinationPortDetailsController extends Controller
{
    public function viewDestinationPortDetails(Request $request){
        $destination_port_data = DestinationPortDetails::all();

        return DataTables::of($destination_port_data)
        ->addColumn('action', function($destination_port_data){
            $result = "";
            $result .= "<center>";
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$destination_port_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$destination_port_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($destination_port_data){
            $result = "";
            $result .= "<center>";
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$destination_port_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$destination_port_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }
    
    
}

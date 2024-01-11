<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\LoadingPortDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoadingPortDetailsController extends Controller
{
    public function viewLoadingPortDetails(Request $request){
        $loading_port_data = LoadingPortDetails::all();

        return DataTables::of($loading_port_data)
        ->addColumn('action', function($loading_port_data){
            $result = "";
            $result .= "<center>";
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$loading_port_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$loading_port_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->addColumn('status', function($loading_port_data){
            $result = "";
            $result .= "<center>";
            // $result .= "<button class='btn btn-info btn-sm btnViewProdData mr-1' data-id='$loading_port_data->id'><i class='fa-solid fa-eye'></i></button>";
            // $result .= "<button class='btn btn-primary btn-sm btnPrintProdData' data-id='$loading_port_data->id'><i class='fa-solid fa-qrcode'></i></button>";
            $result .= "</center>";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }
}

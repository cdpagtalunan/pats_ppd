<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use QrCode;
use DataTables;

/**
 * Import Models
 */
use App\Models\StampingWorkingReport;

class StampingWorkingReportController extends Controller
{
    public function saveStampingWorkingReportDetails(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        return $data;
    }
}

<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PackingListDetails;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Response;

class PdfController extends Controller
{
    public function get_packing_list_data(){
        $packing_list_data = PackingListDetails::select('control_no')->distinct()->get();
        return response()->json(['packing_list_data' => $packing_list_data]);
    }

    public function print($control_no)
    {

        $path = storage_path('app/public/packing_list_format.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // return $path;

        $packing_list_details = PackingListDetails::where('control_no', $control_no)->orderBy('box_no', 'asc')->get();
        // $packing_list_details_count = $packing_list_details->count('mat_name');
        $packing_list_details_mat_count = PackingListDetails::select('mat_name')->where('control_no', $control_no)->distinct()->get();
        // $packing_list_details_count = $packing_list_details->count('mat_name');

        $pdf = PDF::loadView('view_packing_list_pdf', compact('packing_list_details','packing_list_details_mat_count', 'base64'))
                    ->setPaper('A4', 'portrait');

        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}

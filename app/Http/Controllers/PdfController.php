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

        // return $packing_list_details_mat_count;
        // $packing_list_details = PackingListDetails::where('mat_name', $control_no)->orderBy('box_no', 'asc')->get();
        // $material_name = PackingListDetails::selectwhere('control_no', $control_no)->get();
        // return $packing_list_details;

        // $invoiceItems = [
        //     ['item' => 'Website Design', 'amount' => 50.50],
        //     ['item' => 'Hosting (3 months)', 'amount' => 80.50],
        //     ['item' => 'Domain (1 year)', 'amount' => 10.50]
        // ];
        // $invoiceData = [
        //     'invoice_id' => 123,
        //     'transaction_id' => 1234567,
        //     'payment_method' => 'Paypal',
        //     'creation_date' => date('M d, Y'),
        //     'total_amount' => 141.50
        // ];

        $pdf = PDF::loadView('view_packing_list_pdf', compact('packing_list_details','packing_list_details_mat_count', 'base64'))
                    ->setPaper('A4', 'portrait');

        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}

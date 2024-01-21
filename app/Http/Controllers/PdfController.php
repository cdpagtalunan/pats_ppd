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
        $packing_list_details = PackingListDetails::where('control_no', $control_no)->orderBy('box_no', 'asc')->get();

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

        $pdf = PDF::loadView('view_packing_list_pdf', compact('packing_list_details'))
                    ->setPaper('A4', 'portrait');

        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}

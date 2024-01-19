<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PackingListDetails;

class PdfController extends Controller
{
    public function print($control_no)
    {
        $test = PackingListDetails::where('control_no', $control_no)->get();
        // return $test;

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

        $pdf = PDF::loadView('view_packing_list_pdf', compact('test'))
                    ->setPaper('A4', 'portrait');

        // return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }
}

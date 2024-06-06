<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PackingListDetails;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function get_packing_list_data(){
        // $packing_list_data = PackingListDetails::select('control_no')->distinct()->get(); //CLARK MODIFIED
        // return response()->json(['packing_list_data' => $packing_list_data]); //CLARK MODIFIED

        $packing_list_data = PackingListDetails::select('control_no')->distinct()->get();
        $control_no_arr = [];
        foreach ($packing_list_data as $packing_list) {
            $control_no = substr($packing_list->control_no, 0, 11);
            array_push($control_no_arr, $control_no);
        }
        return response()->json(['packing_list_data' => $control_no_arr]);
    }

    public function print($control_no)
    {
        //include image for format guide
        $path = storage_path('app/public/packing_list_format_blank2.jpg');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        //include image for format guide

        // $packing_list_details = PackingListDetails::where('control_no', $control_no)->orderBy('box_no', 'asc')->get();

        // return $packing_list_details;
        // $packing_list_details_mat_count = PackingListDetails::select('mat_name')->where('control_no', $control_no)->distinct()->get();

        $packing_list = [];
        $packing_list_details_mat_count = [];
        $control_no_id_arr = [];

        $packing_list_details = PackingListDetails::where('control_no', 'LIKE', '%'.$control_no.'%')->orderBy('control_no', 'asc')->orderBy('box_no', 'asc')->get();
        $packing_list_control_no = PackingListDetails::select('control_no')->where('control_no', 'LIKE', '%' . $control_no . '%')->distinct()->orderBy('control_no', 'asc')->get();

        foreach ($packing_list_control_no as $control_no){
            $mat_name_per_control = PackingListDetails::select('mat_name')->where('control_no', $control_no->control_no)->distinct()->orderBy('control_no', 'asc')->get();
            $control_no_id = PackingListDetails::where('control_no', $control_no->control_no)->distinct()->orderBy('control_no', 'asc')->max('id');
            $packing_list_details_mat_count[] = $mat_name_per_control;
            $control_no_id_arr[] = $control_no_id;
        }
        array_push($packing_list, $packing_list_control_no);
        array_push($packing_list, $packing_list_details_mat_count);
        array_push($packing_list, $control_no_id_arr);
        array_push($packing_list, $packing_list_details);

        $pdf = PDF::loadView('view_packing_list_pdf', compact('packing_list', 'packing_list_details', 'packing_list_control_no', 'packing_list_details_mat_count', 'control_no_id_arr', 'base64'))
                    ->setPaper('A4', 'portrait');
        return $pdf->stream();
    }
}

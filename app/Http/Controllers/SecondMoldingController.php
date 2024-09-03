<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use QrCode;
use DataTables;

/**
 * Import Models
 */
use App\Models\SecMoldingRuncard;

class SecondMoldingController extends Controller
{
    public function getPOReceivedByPONumber(Request $request){
        return DB::connection('mysql_rapid_pps')->select("
            SELECT * FROM tbl_POReceived WHERE OrderNo = '$request->po_number'
        ");
    }

    public function checkMaterialLotNumber(Request $request){
        return DB::connection('mysql_rapid_pps')->select("SELECT a.Lot_number AS material_lot_number, b.MaterialType AS material_name FROM tbl_WarehouseTransaction AS a
                INNER JOIN tbl_Warehouse AS b
                    ON b.id = a.fkid
                WHERE Lot_number = '$request->material_lot_number'
        ");
    }

    public function checkMaterialLotNumberOfFirstMolding(Request $request){
        $isProductionLotNumberSizeExisted = isset($request->production_lot_number_size) ? true : false;
        if($isProductionLotNumberSizeExisted){
            $result = DB::select("SELECT
                        CONCAT(first_moldings.production_lot, first_moldings.production_lot_extension) AS production_lot,
                        first_moldings.id AS first_molding_id,
                        first_moldings.first_molding_device_id AS first_molding_device_id,
                        first_moldings.shipment_output AS first_molding_shipment_output,
                        first_molding_details.size_category AS first_molding_size_category,
                        first_molding_details.output AS first_molding_output,
                        stations.station_name AS station
                    FROM first_moldings
                    INNER JOIN first_molding_devices
                        ON first_molding_devices.id = first_moldings.first_molding_device_id
                    INNER JOIN first_molding_details
                        ON first_molding_details.first_molding_id = first_moldings.id
                    INNER JOIN stations
                        ON stations.id = first_molding_details.station
                    WHERE first_moldings.production_lot = '$request->production_lot_number'
                    AND first_moldings.production_lot_extension = '$request->production_lot_number_extension'
                    AND stations.station_name = 'Camera Inspection'
                    AND first_moldings.status = 3 -- Done
                    AND first_molding_details.size_category = '$request->production_lot_number_size'
                    AND first_moldings.deleted_at IS NULL
                    AND first_molding_details.deleted_at IS NULL
                    -- LIMIT 1
            ");
        }else{
            $result = DB::select("SELECT
                        CONCAT(first_moldings.production_lot, first_moldings.production_lot_extension) AS production_lot,
                        first_moldings.id AS first_molding_id,
                        first_moldings.first_molding_device_id AS first_molding_device_id
                    FROM first_moldings
                    INNER JOIN first_molding_devices
                        ON first_molding_devices.id = first_moldings.first_molding_device_id
                    WHERE first_moldings.production_lot = '$request->production_lot_number'
                    AND first_moldings.production_lot_extension = '$request->production_lot_number_extension'
                    AND first_moldings.status = 3 -- Done
                    AND first_moldings.deleted_at IS NULL
                    LIMIT 1
            ");
        }

        $cameraInspectionCountResult = DB::select("SELECT COUNT(first_molding_details.id) AS camera_inspection_count
                FROM first_moldings
                INNER JOIN first_molding_details
                    ON first_molding_details.first_molding_id = first_moldings.id
                INNER JOIN stations
                    ON stations.id = first_molding_details.station
                WHERE first_moldings.production_lot = '$request->production_lot_number'
                AND first_moldings.production_lot_extension = '$request->production_lot_number_extension'
                AND stations.station_name = 'Camera Inspection'
                AND first_moldings.status = 3 -- Done
                AND first_moldings.deleted_at IS NULL
                AND first_molding_details.deleted_at IS NULL
                -- LIMIT 1
        ");

        return response()->json(['data' => $result, 'cameraInspectionCountResult' => $cameraInspectionCountResult]);
    }

    public function getRevisionNumberBasedOnDrawingNumber(Request $request){
        if($request->doc_title == 'CN171S-07#IN-VE' || $request->doc_title == 'CN171P-02#IN-VE'){
            $query = "AND doc_title = '$request->doc_title'";
        }
        else if($request->doc_title == 'CN171S-02#MO-VE'){
            $query = "LIKE '%$request->doc_title%'";
        }

        return DB::connection('mysql_rapid_acdcs')->select("SELECT * FROM tbl_active_docs
                WHERE doc_no = '$request->doc_number'
                AND doc_type = '$request->doc_type'
                $query
        ");
    }

    // Orig Code, commented as of 08-23-2024
    // public function viewSecondMolding(Request $request){
    //     $secondMoldingResult = DB::connection('mysql')
    //                 ->select("SELECT
    //                         sec_molding_runcards.*
    //                     FROM sec_molding_runcards
    //                     -- INNER JOIN first_moldings
    //                     --     ON first_moldings.id = sec_molding_runcards.lot_number_eight_first_molding_id
    //                     WHERE sec_molding_runcards.pmi_po_number = '$request->pmi_po_number '
    //                     AND deleted_at IS NULL
    //                     ORDER BY sec_molding_runcards.id ASC
    //     ");
    //     // return $secondMoldingResult;

    //     return DataTables::of($secondMoldingResult)
    //     ->addColumn('action', function($row){
    //         $result = '';
    //         switch ($row->status) {
    //             case 1:
    //                 $result .= "
    //                     <center>
    //                         <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
    //                     </center>
    //                 ";
    //                 break;
    //             case 2:
    //                 $result .= "
    //                     <center>
    //                         <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
    //                     </center>
    //                 ";
    //                 break;
    //             case 3:
    //                 $result .= "
    //                     <center>
    //                         <button class='btn btn-info btn-sm mr-1 actionViewSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-eye'></i></button>
    //                         <button class='btn btn-primary btn-sm mr-1 buttonPrintSecondMolding'second-molding-id='".$row->id."'><i class='fa-solid fa-print' disabled></i></button>
    //                     </center>
    //                 ";
    //                 break;
    //             default:
    //                 # code...
    //                 break;
    //         }

    //         return $result;
    //     })
    //     ->addColumn('status', function($row){
    //         $result = '';
    //         switch ($row->status) {
    //             case 1:
    //                 $result .= "
    //                     <center>
    //                         <span class='badge rounded-pill bg-primary'> For Mass Production </span>
    //                     </center>
    //                 ";
    //                 break;
    //             case 2:
    //                 $result .= "
    //                     <center>
    //                         <span class='badge rounded-pill bg-warning'> For Re-setup </span>
    //                     </center>
    //                 ";
    //                 break;
    //             case 3:
    //                 $result .= "
    //                     <center>
    //                         <span class='badge rounded-pill bg-success'> For Assembly </span>
    //                     </center>
    //                 ";
    //                 break;
    //             default:
    //                 # code...
    //                 break;
    //         }

    //         return $result;
    //     })
    //     ->rawColumns(['action','status'])
    //     ->make(true);
    // }

    public function viewSecondMolding(Request $request){
        $secondMoldingResult = DB::connection('mysql')
                    ->select("SELECT
                            sec_molding_runcards.*
                        FROM sec_molding_runcards
                        -- INNER JOIN first_moldings
                        --     ON first_moldings.id = sec_molding_runcards.lot_number_eight_first_molding_id
                        WHERE sec_molding_runcards.pmi_po_number = '$request->pmi_po_number '
                        AND deleted_at IS NULL
                        ORDER BY sec_molding_runcards.id ASC
        ");
        // return $secondMoldingResult;
        
        return DataTables::of($secondMoldingResult)
        ->addColumn('action', function($row){
            $result = '';

            // Add QR Code printing for Material Drying
            $materialDryingQRCodeButton = '';
            if($row->part_name && $row->lubricant != null){
                $materialDryingQRCodeButton .= "<button class='btn btn-success btn-sm mr-1 buttonPrintMaterialDrying' second-molding-id='".$row->id."' title='Print Material Drying'><i class='fa-solid fa-print' disabled></i></button>";
            }

            switch ($row->status) {
                case 1:
                    $result .= "
                        <center>
                            <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                        </center>
                    ";
                    break;
                case 2:
                    $result .= "
                        <center>
                            <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                        </center>
                    ";
                    break;
                case 3:
                    $result .= "
                        <center>
                            <button class='btn btn-info btn-sm mr-1 actionViewSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id' title='View details'><i class='fa-solid fa-eye'></i></button>
                            <button class='btn btn-primary btn-sm mr-1 buttonPrintSecondMolding'second-molding-id='".$row->id."' title='Print Second Molding Details'><i class='fa-solid fa-print' disabled></i></button>
                            $materialDryingQRCodeButton
                        </center>
                    ";
                    break;
                default:
                    # code...
                    break;
            }

            return $result;
        })
        ->addColumn('status', function($row){
            $result = '';
            switch ($row->status) {
                case 1:
                    $result .= "
                        <center>
                            <span class='badge rounded-pill bg-primary'> For Mass Production </span>
                        </center>
                    ";
                    break;
                case 2:
                    $result .= "
                        <center>
                            <span class='badge rounded-pill bg-warning'> For Re-setup </span>
                        </center>
                    ";
                    break;
                case 3:
                    $result .= "
                        <center>
                            <span class='badge rounded-pill bg-success'> For Assembly </span>
                        </center>
                    ";
                    break;
                default:
                    # code...
                    break;
            }

            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function saveSecondMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        session_start();
        // return $data;

        /* For Insert */
        if(!isset($request->second_molding_id)){
            $rules = [
                'device_name' => 'required',
                'parts_code' => 'required',
                'pmi_po_number' => 'required',
                'po_number' => 'required',
                'required_output' => '',
                'po_quantity' => 'required',
                'machine_number' => '',
                'material_lot_number' => 'required',
                'material_name' => 'required',
                'drawing_number' => 'required',
                'revision_number' => 'required',
                'production_lot' => '',
                'lot_number_eight' => '',
                'lot_number_eight_first_molding_id' => '',
                'lot_number_nine' => '',
                'lot_number_nine_first_molding_id' => '',
                'lot_number_ten' => '',
                'lot_number_ten_first_molding_id' => '',
                'contact_name_lot_number_one' => '',
                'contact_name_lot_number_second' => '',
                'me_name_lot_number_one' => '',
                'me_name_lot_number_second' => '',
            ];

            if($request->material_lot_number_checking == 1){
                $rules['lot_number_eight'] = 'required';
                $rules['lot_number_eight_first_molding_id'] = 'required';
                $rules['lot_number_nine'] = 'required';
                $rules['lot_number_nine_first_molding_id'] = 'required';
                $rules['lot_number_ten'] = 'required';
                $rules['lot_number_ten_first_molding_id'] = 'required';
            }else if($request->material_lot_number_checking == 2){
                $rules['lot_number_eight'] = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine'] = '';
                $rules['lot_number_nine_first_molding_id'] = '';
                $rules['lot_number_ten'] = '';
                $rules['lot_number_ten_first_molding_id'] = '';
            }else{
                $rules['lot_number_eight']                  = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine']                   = '';
                $rules['lot_number_nine_first_molding_id']  = '';
                $rules['lot_number_ten']                    = '';
                $rules['lot_number_ten_first_molding_id']   = '';
                $rules['contact_name_lot_number_one']       = '';
                $rules['contact_name_lot_number_second']    = '';
            }

            /**
             * Additional validation for Material Drying
             */
            if($request->device_name == 'CN171P-02#IN-VE'){
                $rules['part_name'] = 'required';
                $rules['lubricant'] = 'required';
                $rules['applied_date'] = 'required';
                $rules['drying_time_start'] = 'required';
                $rules['drying_time_end'] = 'required';
                $rules['operator_id'] = 'required';
            }else{
                $rules['part_name'] = '';
                $rules['lubricant'] = '';
                $rules['applied_date'] = '';
                $rules['drying_time_start'] = '';
                $rules['drying_time_end'] = '';
                $rules['operator_id'] = '';
            }

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $implodedMachine = implode($request->machine_number, ' , '); // chris
                    $implodedLotNumberEight = implode($request->lot_number_eight, ', ');
                    $implodedLotNumberEightQuantity = implode($request->lot_number_eight_quantity, ', ');
                    $implodedLotNumberEightCategory = implode($request->lot_number_eight_size_category, ', ');
                    $secondMoldingId = SecMoldingRuncard::insertGetId([
                        'device_name' => $request->device_name,
                        'parts_code' => $request->parts_code,
                        'po_number' => $request->po_number,
                        'pmi_po_number' => $request->pmi_po_number,
                        'required_output' => $request->required_output,
                        'po_quantity' => $request->po_quantity,
                        'machine_number' => $implodedMachine,  // chris
                        'material_lot_number' => $request->material_lot_number,
                        'material_name' => $request->material_name,
                        'drawing_number' => $request->drawing_number,
                        'revision_number' => $request->revision_number,
                        'production_lot' => $request->production_lot,
                        'lot_number_eight' => $implodedLotNumberEight,
                        'lot_number_eight_quantity' => $implodedLotNumberEightQuantity,
                        'lot_number_eight_size_category' => $implodedLotNumberEightCategory,
                        'lot_number_eight_first_molding_id' => $request->lot_number_eight_first_molding_id,
                        'lot_number_nine' => $request->lot_number_nine,
                        'lot_number_nine_first_molding_id' => $request->lot_number_nine_first_molding_id,
                        'lot_number_ten' => $request->lot_number_ten,
                        'lot_number_ten_first_molding_id' => $request->lot_number_ten_first_molding_id,
                        'contact_name_lot_number_one' => $request->contact_name_lot_number_one,
                        'contact_name_lot_number_second' => $request->contact_name_lot_number_second,
                        'me_name_lot_number_one' => $request->me_name_lot_number_one,
                        'me_name_lot_number_second' => $request->me_name_lot_number_second,

                        'target_shots' => $request->target_shots,
                        'adjustment_shots' => $request->adjustment_shots,
                        'qc_samples' => $request->qc_samples,
                        'prod_samples' => $request->prod_samples,
                        'ng_count' => $request->ng_count,
                        'total_machine_output' => $request->total_machine_output,
                        'shipment_output' => $request->shipment_output,
                        'material_yield' => $request->material_yield,
                        
                        'part_name'         => $request->part_name,
                        'lubricant'         => $request->lubricant,
                        'applied_date'      => $request->applied_date,
                        'drying_time_start' => $request->drying_time_start,
                        'drying_time_end' => $request->drying_time_end,
                        'operator_id'       => $request->operator_id,

                        'status' => 1,
                        'created_by' => Auth::user()->id,
                        'created_at' => date('Y-m-d H:i:s'),
                    ]);

                    DB::commit();
                    return response()->json(['hasError' => false, 'second_molding_id' => $secondMoldingId]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage(), 'sessionError' => true]);
                }
            }
        }
        else{ /** For edit */
            // return $data;
            $rules = [
                'second_molding_id' => 'required',
                'device_name' => 'required',
                'parts_code' => 'required',
                'pmi_po_number' => 'required',
                'po_number' => 'required',
                'required_output' => '',
                'po_quantity' => 'required',
                'machine_number' => '',
                'material_lot_number' => 'required',
                'material_name' => 'required',
                'drawing_number' => 'required',
                'revision_number' => 'required',
                'production_lot' => '',
                'lot_number_eight' => '',
                'lot_number_eight_first_molding_id' => '',
                'lot_number_nine' => '',
                'lot_number_nine_first_molding_id' => '',
                'lot_number_ten' => '',
                'lot_number_ten_first_molding_id' => '',
                'contact_name_lot_number_one' => '',
                'contact_name_lot_number_second' => '',
                'me_name_lot_number_one' => '',
                'me_name_lot_number_second' => '',
            ];

            if($request->material_lot_number_checking == 1){
                $rules['lot_number_eight'] = 'required';
                $rules['lot_number_eight_first_molding_id'] = 'required';
                $rules['lot_number_nine'] = 'required';
                $rules['lot_number_nine_first_molding_id'] = 'required';
                $rules['lot_number_ten'] = 'required';
                $rules['lot_number_ten_first_molding_id'] = 'required';
            }else if($request->material_lot_number_checking == 2){
                $rules['lot_number_eight'] = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine'] = '';
                $rules['lot_number_nine_first_molding_id'] = '';
                $rules['lot_number_ten'] = '';
                $rules['lot_number_ten_first_molding_id'] = '';
            }else{
                $rules['lot_number_eight']                  = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine']                   = '';
                $rules['lot_number_nine_first_molding_id']  = '';
                $rules['lot_number_ten']                    = '';
                $rules['lot_number_ten_first_molding_id']   = '';
                $rules['contact_name_lot_number_one']       = '';
                $rules['contact_name_lot_number_second']    = '';
            }

            /**
             * Additional validation for Material Drying
             */
            if($request->device_name == 'CN171P-02#IN-VE'){
                $rules['part_name'] = 'required';
                $rules['lubricant'] = 'required';
                $rules['applied_date'] = 'required';
                $rules['drying_time_start'] = 'required';
                $rules['drying_time_end'] = 'required';
                $rules['operator_id'] = 'required';
            }else{
                $rules['part_name'] = '';
                $rules['lubricant'] = '';
                $rules['applied_date'] = '';
                $rules['drying_time_start'] = '';
                $rules['drying_time_end'] = '';
                $rules['operator_id'] = '';
            }

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $implodedMachine = implode($request->machine_number, ' , '); // Chris
                    $implodedLotNumberEight = implode($request->lot_number_eight, ', ');
                    $implodedLotNumberEightQuantity = implode($request->lot_number_eight_quantity, ', ');
                    $implodedLotNumberEightCategory = implode($request->lot_number_eight_size_category, ', ');
                    SecMoldingRuncard::where('id', $request->second_molding_id)->update([
                        'device_name' => $request->device_name,
                        'parts_code' => $request->parts_code,
                        'pmi_po_number' => $request->pmi_po_number,
                        'po_number' => $request->po_number,
                        'required_output' => $request->required_output,
                        'po_quantity' => $request->po_quantity,
                        'machine_number' => $implodedMachine, // chris
                        'material_lot_number' => $request->material_lot_number,
                        'material_name' => $request->material_name,
                        'drawing_number' => $request->drawing_number,
                        'revision_number' => $request->revision_number,
                        'production_lot' => $request->production_lot,
                        'lot_number_eight' => $implodedLotNumberEight,
                        'lot_number_eight_quantity' => $implodedLotNumberEightQuantity,
                        'lot_number_eight_size_category' => $implodedLotNumberEightCategory,
                        'lot_number_eight_first_molding_id' => $request->lot_number_eight_first_molding_id,
                        'lot_number_nine' => $request->lot_number_nine,
                        'lot_number_nine_first_molding_id' => $request->lot_number_nine_first_molding_id,
                        'lot_number_ten' => $request->lot_number_ten,
                        'lot_number_ten_first_molding_id' => $request->lot_number_ten_first_molding_id,
                        'contact_name_lot_number_one' => $request->contact_name_lot_number_one,
                        'contact_name_lot_number_second' => $request->contact_name_lot_number_second,
                        'me_name_lot_number_one' => $request->me_name_lot_number_one,
                        'me_name_lot_number_second' => $request->me_name_lot_number_second,

                        'target_shots' => $request->target_shots,
                        'adjustment_shots' => $request->adjustment_shots,
                        'qc_samples' => $request->qc_samples,
                        'prod_samples' => $request->prod_samples,
                        'ng_count' => $request->ng_count,
                        'total_machine_output' => $request->total_machine_output,
                        'shipment_output' => $request->shipment_output,
                        'material_yield' => $request->material_yield,
                        'status' => 1,

                        'part_name'         => $request->part_name,
                        'lubricant'         => $request->lubricant,
                        'applied_date'      => $request->applied_date,
                        'drying_time_start' => $request->drying_time_start,
                        'drying_time_end' => $request->drying_time_end,
                        'operator_id'       => $request->operator_id,

                        'last_updated_by' => Auth::user()->id,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    DB::commit();
                    return response()->json(['hasError' => false, 'second_molding_id' => $request->second_molding_id]);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage(), 'sessionError' => true]);
                }
            }
        }
    }

    public function getSecondMoldingById(Request $request){
        $secondMoldingResult = DB::connection('mysql')
        ->select("SELECT * FROM sec_molding_runcards
                    WHERE id = '$request->second_molding_id'
                    AND deleted_at IS NULL
                    LIMIT 1
        ");

        // For Clark confirmation
        // $moldingAssyIpqcInspectionResult = DB::connection('mysql')
        // ->select("SELECT * FROM molding_assy_ipqc_inspections
        //             WHERE fk_molding_assy_id = '$request->second_molding_id'
        //             AND process_category = '2'
        //             AND status = '3'
        //             LIMIT 1
        // ");
        return response()->json(['data' => $secondMoldingResult]);
    }

    public function getMaterialProcessStation(Request $request){
        if($request->device_name == 'CN171S-07#IN-VE'){
            $materialProcessStationResult = DB::connection('mysql')
            ->select("SELECT material_processes.*, devices.*, material_process_stations.*, stations.id AS station_id, stations.station_name AS station_name FROM material_processes
                        INNER JOIN devices
                            ON devices.id = material_processes.device_id
                        INNER JOIN material_process_stations
                            ON material_process_stations.mat_proc_id = material_processes.id
                        INNER JOIN stations
                            ON stations.id = material_process_stations.station_id
                        WHERE material_processes.step IN (1,2,3)
                        AND material_processes.status = 0
                        AND devices.name = '$request->device_name'
                        ORDER BY material_processes.step ASC
            ");
            return response()->json(['data' => $materialProcessStationResult]);
        }else if($request->device_name == 'CN171P-02#IN-VE'){
            $materialProcessStationResult = DB::connection('mysql')
            ->select("SELECT material_processes.*, devices.*, material_process_stations.*, stations.id AS station_id, stations.station_name AS station_name FROM material_processes
                        INNER JOIN devices
                            ON devices.id = material_processes.device_id
                        INNER JOIN material_process_stations
                            ON material_process_stations.mat_proc_id = material_processes.id
                        INNER JOIN stations
                            ON stations.id = material_process_stations.station_id
                        WHERE material_processes.step IN (1,2)
                        AND material_processes.status = 0
                        AND devices.name = '$request->device_name'
                        ORDER BY material_processes.step ASC
            ");
            return response()->json(['data' => $materialProcessStationResult]);
        }
    }

    public function getModeOfDefectForSecondMolding(Request $request){
        $modeOfDefectResult = DB::connection('mysql')
        ->select("SELECT defects_infos.* FROM defects_infos
        ");
        return response()->json(['data' => $modeOfDefectResult]);
    }

    public function getMachine(Request $request){ // Added by Chris to get machine on matrix
        $machine = DB::connection('mysql')
        ->select("SELECT material_processes.id, material_processes.device_id, devices.*, material_process_machines.* FROM material_processes
            INNER JOIN devices
                ON devices.id = material_processes.device_id
            INNER JOIN material_process_machines
                ON material_process_machines.mat_proc_id = material_processes.id
            WHERE devices.name = '".$request->material_name."'
        ");

        return response()->json(['machine' => $machine]);
    }

    public function completeSecondMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        // return $data;

        DB::beginTransaction();
        try {
            SecMoldingRuncard::where('id', $request->second_molding_id)->update([
                'status'=> 3
            ]);
            DB::commit();
            return response()->json(['hasError' => false]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['hasError' => true, 'exceptionError' => $e->getMessage()]);
        }

    }

    public function getSecondMoldingQrCode(Request $request){
        $secondMoldingResult = DB::connection('mysql')
        ->table('sec_molding_runcards')
        ->where('sec_molding_runcards.id',$request->second_molding_id)
        ->whereNull('sec_molding_runcards.deleted_at')
        ->first([
            'po_number',
            'parts_code',
            'device_name',
            'machine_number',
            'production_lot',
            'po_quantity',
        ]);
        // return $secondMoldingResult;

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate(json_encode($secondMoldingResult));
        // return $qrcode;

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);
        // return $qr_code;

        $data[] = array(
            'img' => $qr_code,
            'text' =>  "<strong>$secondMoldingResult->po_number</strong><br>
            <strong>$secondMoldingResult->parts_code</strong><br>
            <strong>$secondMoldingResult->device_name</strong><br>
            <strong>$secondMoldingResult->machine_number</strong><br>
            <strong>$secondMoldingResult->production_lot</strong><br>
            <strong>$secondMoldingResult->po_quantity</strong><br>
            "
        );

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>PO No.:</td>
                    <td>$secondMoldingResult->po_number</td>
                </tr>
                <tr>
                    <td>Material Code:</td>
                    <td>$secondMoldingResult->parts_code</td>
                </tr>
                <tr>
                    <td>Material Name:</td>
                    <td>$secondMoldingResult->device_name</td>
                </tr>
                <tr>
                    <td>Machine No:</td>
                    <td>$secondMoldingResult->machine_number</td>
                </tr>
                <tr>
                    <td>Production Lot #:</td>
                    <td>".$secondMoldingResult->production_lot."</td>
                </tr>
                <tr>
                    <td>PO Quantity:</td>
                    <td>$secondMoldingResult->po_quantity</td>
                </tr>
            </table>
        ";
        return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'second_molding_data' => $secondMoldingResult]);
    }

    public function getMaterialDryingQrCode(Request $request){
        $secondMoldingResult = DB::connection('mysql')
        ->table('sec_molding_runcards')
        ->where('sec_molding_runcards.id',$request->second_molding_id)
        ->whereNull('sec_molding_runcards.deleted_at')
        ->first([
            'part_name',
            'lubricant',
            'applied_date',
            'drying_time_start',
            'drying_time_end',
        ]);
        // return $secondMoldingResult;

        $qrcode = QrCode::format('png')
        ->size(250)->errorCorrection('H')
        ->generate(json_encode($secondMoldingResult));
        // return $qrcode;

        $qr_code = "data:image/png;base64," . base64_encode($qrcode);
        // return $qr_code;

        $data[] = array(
            'img'  => $qr_code,
            'text' => "
                <strong>$secondMoldingResult->part_name</strong><br>
                <strong>$secondMoldingResult->lubricant</strong><br>
                <strong>$secondMoldingResult->applied_date</strong><br>
                <strong>$secondMoldingResult->drying_time_start</strong><br>
                <strong>$secondMoldingResult->drying_time_end</strong><br>
            "
        );

        $label = "
            <table class='table table-sm table-borderless' style='width: 100%;'>
                <tr>
                    <td>Part Name:</td>
                    <td>$secondMoldingResult->part_name</td>
                </tr>
                <tr>
                    <td>Lubricant:</td>
                    <td>$secondMoldingResult->lubricant</td>
                </tr>
                <tr>
                    <td>Applied Date:</td>
                    <td>$secondMoldingResult->applied_date</td>
                </tr>
                <tr>
                    <td>Drying Time Start:</td>
                    <td>$secondMoldingResult->drying_time_start</td>
                </tr>
                <tr>
                    <td>Drying Time End:</td>
                    <td>".$secondMoldingResult->drying_time_end."</td>
                </tr>
            </table>
        ";
        return response()->json(['qr_code' => $qr_code, 'label_hidden' => $data, 'label' => $label, 'second_molding_data' => $secondMoldingResult]);
    }

    /**
     * Old code
     * commented on 04-09-2024
     */
    // public function getLastShipmentOuput(Request $request){
    //     date_default_timezone_set('Asia/Manila');
    //     $data = $request->all();
    //     // $getShipmentOuput = SecMoldingRuncard::where('id', $request->second_molding_id)->get();

    //     $getDeviceName = DB::table('sec_molding_runcards')
    //         ->where('sec_molding_runcards.id', $request->second_molding_id)
    //         ->select(
    //             'sec_molding_runcards.device_name',
    //         )
    //         ->first();

    //     $getDeviceIdByDeviceName = DB::table('devices')
    //         ->where('devices.name', $getDeviceName->device_name)
    //         ->select(
    //             'devices.id',
    //         )
    //         ->first();
    //     /**
    //      * Step 1 - Machine Final Overmold
    //      * Step 2 - Camera Inspection
    //      * Step 3 - Visual Inspection
    //      * Step 4 - 1st OQC Inspection
    //      */
    //     $getStationIdByStepThree = DB::table('material_processes')
    //             ->where('material_processes.device_id', $getDeviceIdByDeviceName->id)
    //             ->where('material_processes.step', 3)
    //             ->join('material_process_stations', 'material_processes.id', '=', 'material_process_stations.mat_proc_id')
    //             ->pluck('station_id');
    //     // return response()->json(['getStationIdByStepThree' => $getStationIdByStepThree]);

    //     $getShipmentOuputOfNonVisualInspection = DB::connection('mysql')
    //         ->table('sec_molding_runcard_stations')
    //         ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
    //         ->whereNotIn('station', $getStationIdByStepThree)
    //         ->orderBy('id', 'desc') // get last station
    //         ->select(
    //             'sec_molding_runcard_stations.output_quantity',
    //             'sec_molding_runcard_stations.station'
    //             )
    //         ->get();

    //     $checkIfVisualInspectionIsExist = DB::table('sec_molding_runcard_stations')
    //         ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
    //         ->whereIn('sec_molding_runcard_stations.station', $getStationIdByStepThree)
    //         ->exists();

    //     $disabledInputQuantity = false;
    //     if(!$checkIfVisualInspectionIsExist){
    //         $getShipmentOuputOfVisualInspection = DB::table('sec_molding_runcard_stations')
    //             ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
    //             ->whereIn('station', $getStationIdByStepThree)
    //             ->orderBy('id', 'desc') // get last station
    //             ->select(
    //                 'sec_molding_runcard_stations.output_quantity',
    //                 'sec_molding_runcard_stations.station'
    //                 )
    //             ->get();
    //     }else{
    //         $getShipmentOuputOfVisualInspection = DB::table('sec_molding_runcard_stations')
    //             ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
    //             ->whereIn('station', $getStationIdByStepThree)
    //             ->orderBy('id', 'desc') // get last station
    //             // ->groupBy('sec_molding_runcard_stations.id')
    //             ->select(
    //                 DB::raw('SUM(sec_molding_runcard_stations.output_quantity) AS output_quantity'),
    //                 'sec_molding_runcard_stations.station'
    //                 )
    //             ->get();
    //         if((int)$getShipmentOuputOfVisualInspection[0]->output_quantity == (int)$getShipmentOuputOfNonVisualInspection[0]->output_quantity){
    //             $disabledInputQuantity = true;
    //         }

    //     }
    //     return response()->json(['data' => $getShipmentOuputOfNonVisualInspection, 'getShipmentOuputOfVisualInspection' => $getShipmentOuputOfVisualInspection, 'disabledInputQuantity'=>$disabledInputQuantity]);
    // }

    public function getStationIdByStepNumber($second_molding_id = '', $step = []){
        $getDeviceName = DB::table('sec_molding_runcards')
            ->where('sec_molding_runcards.id', $second_molding_id)
            ->select(
                'sec_molding_runcards.device_name',
            )
            ->first();
        // return response()->json(['getDeviceName'=>$getDeviceName]);

        $getDeviceIdByDeviceName = DB::table('devices')
            ->where('devices.name', $getDeviceName->device_name)
            ->select(
                'devices.id',
            )
            ->first();
        // return response()->json(['getDeviceIdByDeviceName'=>$getDeviceIdByDeviceName]);

        /**
         * Step 1 - Machine Final Overmold
         * Step 2 - Camera Inspection
         *
         * This will check if step number is in correct order
         */
        $getStationIdFromMaterialProcessStations = DB::table('material_processes')
            ->where('material_processes.device_id', $getDeviceIdByDeviceName->id)
            ->whereIn('material_processes.step', $step)
            ->where('material_processes.status', '!=', 1)
            ->join('material_process_stations', 'material_processes.id', '=', 'material_process_stations.mat_proc_id')
            ->pluck('station_id');
        // return response()->json(['getStationIdFromMaterialProcessStations'=>$getStationIdFromMaterialProcessStations]);
        return $getStationIdFromMaterialProcessStations;
    }

    public function getLastShipmentOuput(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        if($request->material_name == 'CN171S-07#IN-VE'){
            /**
             * Step 1 - Machine Final Overmold
             * Step 2 - Camera Inspection
             * Step 3 - Visual Inspection
             * Step 4 - 1st OQC Inspection
             */
            $getStationIdByStepThree = $this->getStationIdByStepNumber($request->second_molding_id, [3]);
            // return $getStationIdByStepThree;

            $getShipmentOuputOfNonVisualInspection = DB::connection('mysql')
                ->table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->whereNotIn('station', $getStationIdByStepThree)
                ->orderBy('id', 'desc') // get last station
                ->select(
                    'sec_molding_runcard_stations.output_quantity',
                    'sec_molding_runcard_stations.station'
                    )
                ->get();

            $checkIfVisualInspectionIsExist = DB::table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->whereIn('sec_molding_runcard_stations.station', $getStationIdByStepThree)
                ->exists();

            $disabledInputQuantity = false;
            if(!$checkIfVisualInspectionIsExist){
                $getShipmentOuputOfVisualInspection = DB::table('sec_molding_runcard_stations')
                    ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                    ->whereIn('station', $getStationIdByStepThree)
                    ->orderBy('id', 'desc') // get last station
                    ->select(
                        'sec_molding_runcard_stations.output_quantity',
                        'sec_molding_runcard_stations.station'
                        )
                    ->get();
            }else{
                $getShipmentOuputOfVisualInspection = DB::table('sec_molding_runcard_stations')
                    ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                    ->whereIn('station', $getStationIdByStepThree)
                    ->orderBy('id', 'desc') // get last station
                    // ->groupBy('sec_molding_runcard_stations.id')
                    ->select(
                        DB::raw('SUM(sec_molding_runcard_stations.output_quantity) AS output_quantity'),
                        'sec_molding_runcard_stations.station'
                        )
                    ->get();

                if((int)$getShipmentOuputOfVisualInspection[0]->output_quantity == (int)$getShipmentOuputOfNonVisualInspection[0]->output_quantity){
                    $disabledInputQuantity = true;
                }

            }
            return response()->json(['data' => $getShipmentOuputOfNonVisualInspection, 'getShipmentOuputOfVisualInspection' => $getShipmentOuputOfVisualInspection, 'disabledInputQuantity'=>$disabledInputQuantity]);
        }else if($request->material_name == 'CN171P-02#IN-VE'){
            /**
             * Step 1 - Machine Final Overmold
             * Step 2 - Camera Inspection
             */
            $getStationIdByStepOne = $this->getStationIdByStepNumber($request->second_molding_id, [1]);
            // return $getStationIdByStepOne;


            $checkIfStepOneIsExist = DB::table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->whereIn('sec_molding_runcard_stations.station', $getStationIdByStepOne)
                ->exists();
            // return response()->json(['checkIfStepOneIsExist' => $checkIfStepOneIsExist]);

            $disabledInputQuantity = false;
            if($checkIfStepOneIsExist){
                $disabledInputQuantity = true;
            }

            $getLastOutputQuantity = DB::connection('mysql')
                ->table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                // ->whereNotIn('station', $getStationIdByStepOne)
                ->join('stations', 'sec_molding_runcard_stations.station', '=', 'stations.id')
                ->orderBy('id', 'desc') // get last station
                ->select(
                    'sec_molding_runcard_stations.output_quantity',
                    'sec_molding_runcard_stations.station',
                    'stations.*',
                    )
                ->get();
            // return response()->json(['getLastOutputQuantity' => $getLastOutputQuantity]);
            return response()->json(['data' => $getLastOutputQuantity, 'disabledInputQuantity'=>$disabledInputQuantity]);
        }
    }

    public function checkIfLastStepByMaterialName(Request $request){
        if($request->material_name == 'CN171S-07#IN-VE'){
            $getStationIdByStepOneAndTwo = $this->getStationIdByStepNumber($request->second_molding_id, [2]);
            $getLastOutputQuantityOfStepTwo = DB::table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->whereIn('sec_molding_runcard_stations.station', $getStationIdByStepOneAndTwo)
                ->join('stations', 'sec_molding_runcard_stations.station', '=', 'stations.id')
                ->orderBy('id', 'desc') // get last station
                ->select(
                    'sec_molding_runcard_stations.output_quantity',
                    'sec_molding_runcard_stations.station',
                    'stations.*',
                    )
                ->get();
            // return response()->json(['getLastOutputQuantityOfStepTwo' => $getLastOutputQuantityOfStepTwo[0]->output_quantity]);


            $getStationIdByStepThreeAsVisualInspection = $this->getStationIdByStepNumber($request->second_molding_id, [3]);
            $getComputedInputQuantityOfVisualInspection = DB::connection('mysql')
                ->table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->where('sec_molding_runcard_stations.station', $getStationIdByStepThreeAsVisualInspection)
                ->select(
                    DB::raw('SUM(input_quantity) AS computed_input_quantity'),
                )
                ->get();

            if($getComputedInputQuantityOfVisualInspection[0]->computed_input_quantity != null){
                if((int)$getComputedInputQuantityOfVisualInspection[0]->computed_input_quantity >= (int)$getLastOutputQuantityOfStepTwo[0]->output_quantity){
                    return response()->json(['checkIfLastStepByMaterialName' => true]);
                }
            }
            return response()->json(['checkIfLastStepByMaterialName' => false]);

        }else if($request->material_name == 'CN171P-02#IN-VE'){
            $getStationIdByStepTwo = $this->getStationIdByStepNumber($request->second_molding_id, [2]);
            $checkIfLastStepByMaterialName = DB::table('sec_molding_runcard_stations')
                ->where('sec_molding_runcard_stations.sec_molding_runcard_id', $request->second_molding_id)
                ->whereIn('sec_molding_runcard_stations.station', $getStationIdByStepTwo)
                ->exists();
            return response()->json(['checkIfLastStepByMaterialName' => $checkIfLastStepByMaterialName]);
        }
    }

    public function getUser(){
        $getUser = DB::connection('mysql')
            ->table('users')
            ->select(
                'users.id',
                DB::raw('CONCAT(users.firstname, " ", users.lastname) AS operator')
            )
            ->whereIn('position',[2,4,9])
            ->where('section', 2)
            ->get();
        return response()->json(['data' => $getUser]);
    }

    public function getDiesetDetailsByDeviceNameSecondMolding (Request $request){
        try {
            $device_name = $request->device_name;
            $tbl_dieset = DB::connection('mysql_rapid_stamping_dmcms')
            ->select('SELECT * FROM `tbl_device` WHERE `device_name` LIKE "'.$device_name.'" ');

            return response()->json( [
                'is_success' => 'true',
                'drawing_no' => $tbl_dieset[0]->drawing_no,
                'rev_no' => $tbl_dieset[0]->rev,
            ] );
        } catch (\Throwable $th) {
            return response()->json( [
                'is_success' => 'false',
            ] );
        }
    }
}

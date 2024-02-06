<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        return DB::select("SELECT 
                    CONCAT(first_moldings.production_lot, first_moldings.production_lot_extension) AS production_lot, first_moldings.id AS first_molding_id, first_moldings.first_molding_device_id AS first_molding_device_id 
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

    public function getRevisionNumberBasedOnDrawingNumber(Request $request){
        return DB::connection('mysql_rapid_acdcs')->select("SELECT * FROM tbl_active_docs
                WHERE doc_no = '$request->doc_number'
                AND doc_title = '$request->doc_title'
                AND doc_type = '$request->doc_type'
        ");
    }

    public function viewSecondMolding(Request $request){
        $secondMoldingResult = DB::connection('mysql')
                    ->select("SELECT 
                            sec_molding_runcards.* 
                        FROM sec_molding_runcards
                        -- INNER JOIN first_moldings
                        --     ON first_moldings.id = sec_molding_runcards.lot_number_eight_first_molding_id
                        WHERE sec_molding_runcards.po_number = '$request->po_number'
                        AND deleted_at IS NULL
                        ORDER BY sec_molding_runcards.id ASC
        ");
        // return $secondMoldingResult;

        return DataTables::of($secondMoldingResult)
        ->addColumn('action', function($row){
            $result = '';
            $result .= "
                <center>
                    <button class='btn btn-primary btn-sm mr-1 actionEditSecondMolding' data-bs-toggle='modal' data-bs-target='#modalSecondMolding' second-molding-id='$row->id'><i class='fa-solid fa-pen-to-square'></i></button>
                </center>
            ";
            return $result;
        })
        ->addColumn('status', function($row){
            $result = '';
            $result .= "
                <center>
                    <span class='badge rounded-pill bg-info'> On-going </span>
                </center>
            ";
            return $result;
        })
        ->rawColumns(['action','status'])
        ->make(true);
    }

    public function saveSecondMolding(Request $request){
        date_default_timezone_set('Asia/Manila');
        $data = $request->all();
        session_start();

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
            }else{
                $rules['lot_number_eight'] = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine'] = '';
                $rules['lot_number_nine_first_molding_id'] = '';
                $rules['lot_number_ten'] = '';
                $rules['lot_number_ten_first_molding_id'] = '';
            }

            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $imploded_machine = implode($request->machine_number, ' , '); // chris

                    $secondMoldingId = SecMoldingRuncard::insertGetId([
                        'device_name' => $request->device_name,
                        'parts_code' => $request->parts_code,
                        'po_number' => $request->po_number,
                        'pmi_po_number' => $request->pmi_po_number,
                        'required_output' => $request->required_output,
                        'po_quantity' => $request->po_quantity,
                        // 'machine_number' => $request->machine_number,
                        'machine_number' => $imploded_machine,  // chris
                        'material_lot_number' => $request->material_lot_number,
                        'material_name' => $request->material_name,
                        'drawing_number' => $request->drawing_number,
                        'revision_number' => $request->revision_number,
                        'production_lot' => $request->production_lot,
                        'lot_number_eight' => $request->lot_number_eight,
                        'lot_number_eight_first_molding_id' => $request->lot_number_eight_first_molding_id,
                        'lot_number_nine' => $request->lot_number_nine,
                        'lot_number_nine_first_molding_id' => $request->lot_number_nine_first_molding_id,
                        'lot_number_ten' => $request->lot_number_ten,
                        'lot_number_ten_first_molding_id' => $request->lot_number_ten_first_molding_id,
                        'contact_name_lot_number_one' => $request->contact_name_lot_number_one,
                        'contact_name_lot_number_second' => $request->contact_name_lot_number_second,
                        'me_name_lot_number_one' => $request->me_name_lot_number_one,
                        'me_name_lot_number_second' => $request->me_name_lot_number_second,

                        // 'status' => 1,
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
            }else{
                $rules['lot_number_eight'] = '';
                $rules['lot_number_eight_first_molding_id'] = '';
                $rules['lot_number_nine'] = '';
                $rules['lot_number_nine_first_molding_id'] = '';
                $rules['lot_number_ten'] = '';
                $rules['lot_number_ten_first_molding_id'] = '';
            }
            $validator = Validator::make($data, $rules);
            if ($validator->fails()) {
                return response()->json(['validationHasError' => true, 'error' => $validator->messages()]);
            } else {
                DB::beginTransaction();
                try {
                    $imploded_machine = implode($request->machine_number, ' , '); // Chris

                    SecMoldingRuncard::where('id', $request->second_molding_id)->update([
                        'device_name' => $request->device_name,
                        'parts_code' => $request->parts_code,
                        'pmi_po_number' => $request->pmi_po_number,
                        'po_number' => $request->po_number,
                        'required_output' => $request->required_output,
                        'po_quantity' => $request->po_quantity,
                        // 'machine_number' => $request->machine_number,
                        'machine_number' => $imploded_machine, // chris
                        'material_lot_number' => $request->material_lot_number,
                        'material_name' => $request->material_name,
                        'drawing_number' => $request->drawing_number,
                        'revision_number' => $request->revision_number,
                        'production_lot' => $request->production_lot,
                        'lot_number_eight' => $request->lot_number_eight,
                        'lot_number_eight_first_molding_id' => $request->lot_number_eight_first_molding_id,
                        'lot_number_nine' => $request->lot_number_nine,
                        'lot_number_nine_first_molding_id' => $request->lot_number_nine_first_molding_id,
                        'lot_number_ten' => $request->lot_number_ten,
                        'lot_number_ten_first_molding_id' => $request->lot_number_ten_first_molding_id,
                        'contact_name_lot_number_one' => $request->contact_name_lot_number_one,
                        'contact_name_lot_number_second' => $request->contact_name_lot_number_second,
                        'me_name_lot_number_one' => $request->me_name_lot_number_one,
                        'me_name_lot_number_second' => $request->me_name_lot_number_second,

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
        return response()->json(['data' => $secondMoldingResult]);
    }

    public function getMaterialProcessStation(Request $request){
        $materialProcessStationResult = DB::connection('mysql')
        ->select("SELECT material_processes.*, devices.*, material_process_stations.*, stations.id AS station_id, stations.station_name AS station_name FROM material_processes
                    INNER JOIN devices
                        ON devices.id = material_processes.device_id
                    INNER JOIN material_process_stations
                        ON material_process_stations.mat_proc_id = material_processes.id
                    INNER JOIN stations
                        ON stations.id = material_process_stations.station_id
                    WHERE devices.name = '$request->device_name'
        ");
        return response()->json(['data' => $materialProcessStationResult]);
    }
    
    public function getModeOfDefectForSecondMolding(Request $request){
        $modeOfDefectResult = DB::connection('mysql')
        ->select("SELECT defects_infos.* FROM defects_infos
        ");
        return response()->json(['data' => $modeOfDefectResult]);
    }

    public function getMachine(Request $request){ // Added Chris to get machine on matrix
        $machine = DB::connection('mysql')
        ->select("
            SELECT material_processes.id, material_processes.device_id, devices.*, material_process_machines.* FROM material_processes
            INNER JOIN devices
                ON devices.id = material_processes.device_id
            INNER JOIN material_process_machines
                ON material_process_machines.mat_proc_id = material_processes.id
            WHERE devices.name = '$request->material_name'
        ");

        return response()->json(['machine' => $machine]);
    }
}

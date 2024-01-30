<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\StampingController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\FirstMoldingController;
use App\Http\Controllers\FirstMoldingStationController;
use App\Http\Controllers\StampingIpqcController;
use App\Http\Controllers\IqcInspectionController;
// use App\Http\Controllers\SecondStampingController;
use App\Http\Controllers\OQCInspectionController;
use App\Http\Controllers\CarrierDetailsController;
use App\Http\Controllers\PackingDetailsController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\MaterialProcessController;
use App\Http\Controllers\ReceivingDetailsController;
use App\Http\Controllers\LoadingPortDetailsController;
use App\Http\Controllers\PackingListDetailsController;
use App\Http\Controllers\PackingDetailsMoldingController;
use App\Http\Controllers\DestinationPortDetailsController;
use App\Http\Controllers\SecondMoldingController;
use App\Http\Controllers\SecondMoldingStationController;
use App\Http\Controllers\CnAssemblyRuncardController;
use App\Http\Controllers\DefectsInfoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/link', function () {
    return 'link';
})->name('link');

Route::view('/','index')->name('login');

Route::view('/login','index')->name('login');

Route::view('/ilqcm','ilqcm/admin_layout')->name('ilqcm');

Route::view('/dashboard','dashboard')->name('dashboard');
// * ADMIN VIEW
Route::view('/user','user')->name('user');
Route::view('/defectsinfo','defectsinfo')->name('defectsinfo');
Route::view('/change_pass_view','change_password')->name('change_pass_view');
Route::view('/materialprocess','materialprocess')->name('materialprocess');
Route::view('/process','process')->name('process');

/* MIGZ IQC INSPECTION VIEW */

Route::view('/first_stamping_iqc_inspection','first_stamping_iqc_inspection')->name('first_stamping_iqc_inspection');
Route::view('/second_stamping_iqc_inspection','second_stamping_iqc_inspection')->name('second_stamping_iqc_inspection');


// Route::post('/edit_user_authentication', [UserController::class, 'editUserAuthentication'])->name('edit_user_authentication');

// * STAMPING VIEW
Route::view('/first_stamping_prod','first_stamping_prod')->name('first_stamping_prod');
Route::view('/second_stamping_prod','second_stamping_prod')->name('second_stamping_prod');

/* STAMPING VIEW - IPQC Inspectin */
Route::view('/ipqc_inspection_1st_stamping','ipqc_inspection_1st_stamping')->name('ipqc_inspection_1st_stamping');
Route::view('/ipqc_inspection_2nd_stamping','ipqc_inspection_2nd_stamping')->name('ipqc_inspection_2nd_stamping');


/* STAMPING VIEW - OQC Inspection */
Route::view('/first_stamping_oqc_inspection','first_stamping_oqc_inspection')->name('first_stamping_oqc_inspection');
Route::view('/second_stamping_oqc_inspection','second_stamping_oqc_inspection')->name('second_stamping_oqc_inspection');
Route::view('/oqc_inspection_molding','oqc_inspection_molding')->name('oqc_inspection_molding');

/* PACKING  */
Route::view('/packing_details','packing_details')->name('packing_details');
Route::view('/packing_details_molding','packing_details_molding')->name('packing_details_molding');


/* PACKING LIST */
Route::view('/packing_list','packing_list')->name('packing_list');
Route::view('/packing_list_settings','packing_list_settings')->name('packing_list_settings');
Route::view('/receiving','receiving')->name('receiving');

/* MOLDING */
Route::view('/second_molding','second_molding')->name('second_molding');
Route::view('/first_molding','first_molding')->name('first_molding');

/* CN ASSEMBLY */
Route::view('/cn_assembly','cn_assembly')->name('cn_assembly');

// USER CONTROLLER
Route::controller(UserController::class)->group(function () {
    Route::get('/load_whs_transaction', 'loadWhsTransaction')->name('load_whs_transaction');
    Route::post('/sign_in', 'sign_in')->name('sign_in');
    Route::post('/rapidx_sign_in_admin', 'rapidx_sign_in_admin')->name('rapidx_sign_in_admin');
    Route::post('/sign_out', 'sign_out')->name('sign_out');
    Route::post('/change_pass', 'change_pass')->name('change_pass');
    Route::post('/change_user_stat', 'change_user_stat')->name('change_user_stat');
    Route::get('/view_users', 'view_users');
    Route::post('/add_user', 'add_user');
    Route::get('/get_user_by_id', 'get_user_by_id');
    Route::get('/get_user_list', 'get_user_list');
    Route::get('/get_user_by_batch', 'get_user_by_batch');
    Route::get('/get_user_by_stat', 'get_user_by_stat');
    Route::post('/edit_user', 'edit_user');
    Route::post('/reset_password', 'reset_password');
    Route::get('/generate_user_qrcode', 'generate_user_qrcode');
    Route::post('/import_user', 'import_user');

    Route::get('/get_emp_details_by_id', 'get_emp_details_by_id')->name('get_emp_details_by_id');
});

// USER LEVEL CONTROLLER
Route::get('/get_user_levels',  [UserLevelController::class, 'get_user_levels']);

// COMMON CONTROLLER
Route::controller(CommonController::class)->group(function () {
    Route::get('/get_search_po', 'get_search_po')->name('get_search_po');
    Route::get('/validate_user', 'validate_user')->name('validate_user');
});

// DEVICE CONTROLLER
Route::controller(DeviceController::class)->group(function () {
    Route::get('/view_devices','view_devices');
    Route::post('/add_device','add_device');
    Route::get('/get_device_by_id','get_device_by_id');
    Route::post('/change_device_stat','change_device_stat');
});

// DEVICE CONTROLLER
Route::controller(StationController::class)->group(function () {
    Route::get('view_station', 'view_station')->name('view_station');
    Route::post('save_station', 'save_station')->name('save_station');
    Route::get('get_station_details_by_id', 'get_station_details_by_id')->name('get_station_details_by_id');
    Route::get('update_status', 'update_status')->name('update_status');

});

// MATERIAL PROCESS CONTROLLER
Route::controller(MaterialProcessController::class)->group(function () {

    Route::get('/view_material_process_by_device_id', 'view_material_process_by_device_id');
    Route::get('/get_mat_proc_for_add', 'get_mat_proc_for_add');
    Route::get('/get_step', 'get_step');
    Route::get('/get_mat_proc_data', 'get_mat_proc_data');
    Route::post('/add_material_process', 'add_material_process');
    Route::post('/change_mat_proc_status', 'change_mat_proc_status');

});

// PROCESS CONTROLLER
Route::controller(ProcessController::class)->group(function () {

    Route::get('/view_process', 'view_process');
    Route::post('/add_process', 'add_process');
    Route::post('/update_status', 'update_status');
    Route::get('/get_process_by_id', 'get_process_by_id');
});

// FIRST STAMPING CONTROLLER
Route::controller(StampingController::class)->group(function () {
    Route::post('/save_prod_data', 'save_prod_data')->name('save_prod_data');
    Route::get('/view_first_stamp_prod', 'view_first_stamp_prod')->name('view_first_stamp_prod');
    Route::get('/get_data_req_for_prod_by_po', 'get_data_req_for_prod_by_po')->name('get_data_req_for_prod_by_po');
    Route::get('/get_prod_data_view', 'get_prod_data_view')->name('get_prod_data_view');
    Route::get('/print_qr_code', 'print_qr_code')->name('print_qr_code');
    Route::get('/check_matrix', 'check_matrix')->name('check_matrix');
    Route::get('/get_prod_lot_no_ctrl', 'get_prod_lot_no_ctrl')->name('get_prod_lot_no_ctrl');
    Route::get('/get_operator_list', 'get_operator_list')->name('get_operator_list');
    Route::get('/change_print_count', 'change_print_count')->name('change_print_count');
    Route::get('/get_history_details', 'get_history_details')->name('get_history_details');


    // SECON STAMPING
    Route::get('/get_2_stamp_reqs', 'get_2_stamp_reqs')->name('get_2_stamp_reqs');

});

// STAMPING -> IPQC CONTROLLER
Route::controller(StampingIpqcController::class)->group(function () {
    Route::get('/view_stamping_ipqc_data', 'view_stamping_ipqc_data')->name('view_stamping_ipqc_data');
    // Route::get('/get_po_from_pps_db', 'get_po_from_pps_db')->name('get_po_from_pps_db');
    Route::get('/get_po_from_fs_production', 'get_po_from_fs_production')->name('get_po_from_fs_production');
    Route::get('/get_data_from_fs_production', 'get_data_from_fs_production')->name('get_data_from_fs_production');
    Route::get('/get_data_from_acdcs', 'get_data_from_acdcs')->name('get_data_from_acdcs');
    Route::post('/add_ipqc_inspection', 'add_ipqc_inspection')->name('add_ipqc_inspection');
    Route::post('/update_status_of_ipqc_inspection', 'update_status_of_ipqc_inspection')->name('update_status_of_ipqc_inspection');
    Route::get('/download_file/{id}', 'download_file')->name('download_file');

    //REPORT FOR PACKING LIST
    Route::get('/export/{CtrlNo}', 'excel')->name('export');
});

Route::controller(PdfController::class)->group(function () {
    Route::get('/view_pdf/{control_no}', 'print')->name('print');
    Route::get('/get_packing_list_data', 'get_packing_list_data')->name('get_packing_list_data');
});


//IQC Inspection
Route::controller(IqcInspectionController::class)->group(function () {
    Route::get('/load_iqc_inspection', 'loadIqcInspection')->name('load_iqc_inspection');
    Route::get('/get_iqc_inspection_by_judgement', 'getIqcInspectionByJudgement')->name('get_iqc_inspection_by_judgement');
    Route::get('/load_whs_transaction', 'loadWhsTransaction')->name('load_whs_transaction');
    Route::get('/load_whs_details', 'loadWhsDetails')->name('load_whs_details');
    Route::get('/get_iqc_inspection_by_id', 'getIqcInspectionById')->name('get_iqc_inspection_by_id');
    Route::get('/get_whs_receiving_by_id', 'getWhsReceivingById')->name('get_whs_receiving_by_id');
    Route::get('/get_family', 'getFamily')->name('get_family');
    Route::get('/get_inspection_level', 'getInspectionLevel')->name('get_inspection_level');
    Route::get('/get_aql', 'getAql')->name('get_aql');
    Route::get('/get_lar_dppm', 'getLarDppm')->name('get_lar_dppm');
    Route::get('/get_mode_of_defect', 'getModeOfDefect')->name('get_mode_of_defect');
    Route::get('/view_coc_file_attachment/{id}', 'viewCocFileAttachment')->name('view_coc_file_attachment');

    Route::post('/save_iqc_inspection', 'saveIqcInspection')->name('save_iqc_inspection');

});


//OQC Inspection
Route::controller(OQCInspectionController::class)->group(function () {
    Route::get('/view_oqc_inspection_first_stamping', 'viewOqcInspectionFirstStamping')->name('view_oqc_inspection_first_stamping');
    Route::get('/view_oqc_inspection_history', 'viewOqcInspectionHistory')->name('view_oqc_inspection_history');
    Route::get('/view_oqc_inspection_second_stamping', 'viewOqcInspectionSecondStamping')->name('view_oqc_inspection_second_stamping');
    Route::post('/update_oqc_inspection', 'updateOqcInspection')->name('update_oqc_inspection');
    Route::get('/get_oqc_inspection_by_id', 'getOqcInspectionById')->name('get_oqc_inspection_by_id');
    Route::get('/get_oqc_stamping_line', 'getStampingLine')->name('get_oqc_stamping_line');
    Route::get('/get_oqc_family', 'getFamily')->name('get_oqc_family');
    Route::get('/get_oqc_inspection_type', 'getInspectionType')->name('get_oqc_inspection_type');
    Route::get('/get_oqc_inspection_level', 'getInspectionLevel')->name('get_oqc_inspection_level');
    Route::get('/get_oqc_severity_inspection', 'getSeverityInspection')->name('get_oqc_severity_inspection');
    Route::get('/get_oqc_aql', 'getAQL')->name('get_oqc_aql');
    Route::get('/get_oqc_inspection_customer', 'getCustomer')->name('get_oqc_inspection_customer');
    Route::get('/get_oqc_inspection_mod', 'getMOD')->name('get_oqc_inspection_mod');
    Route::get('/scan_user_id', 'scanUserId')->name('scan_user_id');
});

// Packing List
Route::controller(CustomerDetailsController::class)->group(function () {
    Route::get('/view_company_details', 'viewCompanyDetails')->name('view_company_details');
    Route::post('/add_customer_details', 'addCustomerDetails')->name('add_customer_details');
    Route::get('/get_customer_details', 'getCustomerDetailsById')->name('get_customer_details');
    Route::get('/edit_company_details_status', 'editCompanyDetailsStatus')->name('edit_company_details_status');
    Route::get('/restore_company_status', 'restoreCompanyDetailsStatus')->name('restore_company_status');
});
Route::controller(CarrierDetailsController::class)->group(function () {
    Route::get('/view_carrier_details', 'viewCarrierDetails')->name('view_carrier_details');
    Route::post('/add_carrier_details', 'addCarrierDetails')->name('add_carrier_details');
    Route::get('/get_carrier_details', 'getCarrierDetailsById')->name('get_carrier_details');
    Route::get('/edit_carrier_details_status', 'editCarrierDetailsStatus')->name('edit_carrier_details_status');
    Route::get('/restore_carrier_status', 'restoreCarrierDetailsStatus')->name('restore_carrier_status');
});
Route::controller(LoadingPortDetailsController::class)->group(function () {
    Route::get('/view_loading_port_details', 'viewLoadingPortDetails')->name('view_loading_port_details');
    Route::post('add_loading_port_details', 'addLoadingPortDetails')->name('add_loading_port_details');
    Route::get('/get_loading_port_details', 'getLoadingPortDetailsById')->name('get_loading_port_details');
    Route::get('/edit_loading_port_details_status', 'editLoadingPortDetailsStatus')->name('edit_loading_port_details_status');
    Route::get('/restore_loading_port_status', 'restoreLoadingPortDetailsStatus')->name('restore_loading_port_status');
});
Route::controller(DestinationPortDetailsController::class)->group(function () {
    Route::get('/view_destination_port_details', 'viewDestinationPortDetails')->name('view_destination_port_details');
    Route::post('/add_destination_port_details', 'addDestinationPortDetails')->name('add_destination_port_details');
    Route::get('/get_destination_port_details', 'getDestinationPortDetailsById')->name('get_destination_port_details');
    Route::get('/edit_destination_port_details_status', 'editDestinationPortDetailsStatus')->name('edit_destination_port_details_status');
    Route::get('/restore_destination_port_status', 'restoreDestinationPortDetailsStatus')->name('restore_destination_port_status');
});

Route::controller(PackingListDetailsController::class)->group(function () {
    Route::get('/view_packing_list_data', 'viewPackingListData')->name('view_packing_list_data');
    Route::get('/view_production_data', 'viewProductionData')->name('view_production_data');
    Route::get('/get_customer_data', 'getCustomerDetails')->name('get_customer_data');
    Route::get('/get_carrier_data', 'getCarrierDetails')->name('get_carrier_data');
    Route::get('/get_loading_port_data', 'getLoadingPortDetails')->name('get_loading_port_data');
    Route::get('/get_destination_port_data', 'getDestinationPortDetails')->name('get_destination_port_data');
    Route::get('/get_data_from_production', 'getDataFromProduction')->name('get_data_from_production');
    Route::post('/add_packing_list_details', 'addPackingListData')->name('add_packing_list_details');
    Route::get('/get_ppc_clerk_details', 'getPpcClerk')->name('get_ppc_clerk_details');
    Route::get('/get_ppc_sr_planner', 'getPpcSrPlanner')->name('get_ppc_sr_planner');
    Route::get('/get_carbon_copy_user', 'carbonCopyUser')->name('get_carbon_copy_user');
});

Route::controller(ReceivingDetailsController::class)->group(function () {
    Route::get('/view_receiving_details', 'viewReceivingListDetails')->name('view_receiving_details');
    Route::get('/view_receiving_details_accepted', 'viewReceivingListDetailsAccepted')->name('view_receiving_details_accepted'); // by nessa
    Route::get('/get_receiving_details', 'getReceivingListdetails')->name('get_receiving_details');
    Route::post('/update_receiving_details', 'updateReceivingDetails')->name('update_receiving_details');
    Route::get('/print_receiving_qr_code', 'printReceivingQrCode')->name('print_receiving_qr_code');
    Route::get('/change_print_status', 'changePrintStatus')->name('change_print_status');
});

Route::controller(PackingDetailsController::class)->group(function () {
    Route::get('/view_final_packing_details_data', 'viewFinalPackingDetailsData')->name('view_final_packing_details_data');
    Route::get('/view_preliminary_packing_details', 'viewPrelimDetailsData')->name('view_preliminary_packing_details');
    Route::get('/get_oqc_details', 'getOqcDetailsForPacking')->name('get_oqc_details');
    Route::post('/add_packing_details', 'addPackingDetails')->name('add_packing_details');
    Route::post('/updated_validated_by', 'updatePrelimDetails')->name('updated_validated_by');
    Route::get('/generate_packing_qr', 'generatePackingDetailsQr')->name('generate_packing_qr');
    Route::get('/change_printing_status', 'changePrintingStatus')->name('change_printing_status');
    Route::post('/update_qc_details', 'updateQcDetails')->name('update_qc_details');
});

Route::controller(PackingDetailsMoldingController::class)->group(function () {
    Route::get('/view_packing_details_fe', 'viewPackingDetailsFE')->name('view_packing_details_fe');
    Route::get('/view_packing_details_e', 'viewPackingDetailsE')->name('view_packing_details_e');
    Route::post('/updated_counted_by', 'updatePackingDetailsMolding')->name('updated_counted_by');
    Route::post('/update_checked_by', 'updateCheckByDetailsMolding')->name('update_checked_by');


});




/* First Molding Process */
Route::controller(FirstMoldingController::class)->group(function () {
    Route::get('/get_first_molding_devices', 'getFirstMoldingDevices')->name('get_first_molding_devices');
    Route::get('/get_first_molding_devices_by_id', 'getFirstMoldingDevicesById')->name('get_first_molding_devices_by_id');
    Route::get('/load_first_molding_details', 'loadFirstMoldingDetails')->name('load_first_molding_details');
    Route::get('/get_molding_details', 'getMoldingDetails')->name('get_molding_details');
    Route::get('/first_molding_update_status', 'firstMoldingUpdateStatus')->name('first_molding_update_status');

    Route::post('/save_first_molding', 'saveFirstMolding')->name('save_first_molding');
});
/* First Molding Station Process */
Route::controller(FirstMoldingStationController::class)->group(function () {
    Route::get('/get_stations', 'getStations')->name('get_stations');
    Route::get('/load_first_molding_station_details', 'loadFirstMoldingStationDetails')->name('load_first_molding_station_details');
    Route::get('/get_first_molding_station_details', 'getFirstMoldingStationDetails')->name('get_first_molding_station_details');
    
    Route::post('/save_first_molding_station', 'saveFirstMoldingStation')->name('save_first_molding_station');
});

/* Second Molding Controller */
Route::controller(SecondMoldingController::class)->group(function () {
    Route::get('/get_search_po_for_molding', 'getSearchPoForMolding')->name('get_search_po_for_molding');
    Route::get('/get_revision_number_based_on_drawing_number', 'getRevisionNumberBasedOnDrawingNumber')->name('get_revision_number_based_on_drawing_number');
    Route::get('/check_machine_lot_number', 'checkMachineLotNumber')->name('check_machine_lot_number');
    Route::get('/check_material_lot_number', 'checkMaterialLotNumber')->name('check_material_lot_number');
    Route::post('/save_second_molding', 'saveSecondMolding')->name('save_second_molding');
    Route::get('/view_second_molding', 'viewSecondMolding')->name('view_second_molding');
    Route::get('/get_second_molding_by_id', 'getSecondMoldingById')->name('get_second_molding_by_id');
});
/* Second Molding Station Controller */
Route::controller(SecondMoldingStationController::class)->group(function () {
    Route::get('/view_second_molding_station', 'viewSecondMoldingStation')->name('view_second_molding_station');
    Route::post('/save_second_molding_station', 'saveSecondMoldingStation')->name('save_second_molding_station');
});

/* CN Assembly Controller */
Route::controller(CnAssemblyRuncardController::class)->group(function(){
    Route::get('/get_data_from_2nd_molding', 'get_data_from_2nd_molding')->name('get_data_from_2nd_molding');
    Route::get('/view_cn_assembly_runcard', 'view_cn_assembly_runcard')->name('view_cn_assembly_runcard');
});

// MODE OF DEFECTS CONTROLLER
Route::controller(DefectsInfoController::class)->group(function () {

    Route::get('/view_defectsinfo', 'view_defectsinfo')->name('view_defectsinfo');
    Route::post('/add_defects', 'add_defects')->name('add_defects');
    // Route::post('/update_status', 'update_status');
    // Route::get('/get_process_by_id', 'get_process_by_id');
});


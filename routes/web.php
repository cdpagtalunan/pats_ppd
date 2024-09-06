<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\PdfController;
use App\Http\Controllers\MimfController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\StampingController;
use App\Http\Controllers\OQCLotAppController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\AssemblyFviController;
use App\Http\Controllers\DefectsInfoController;
use App\Http\Controllers\FirstMoldingController;
use App\Http\Controllers\StampingIpqcController;
use App\Http\Controllers\IqcInspectionController;
use App\Http\Controllers\OQCInspectionController;
use App\Http\Controllers\SecondMoldingController;
use App\Http\Controllers\CarrierDetailsController;
use App\Http\Controllers\PackingDetailsController;
use App\Http\Controllers\AssemblyRuncardController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\DailyChecksheetController;
use App\Http\Controllers\MaterialProcessController;
use App\Http\Controllers\MoldingAssyIpqcController;
use App\Http\Controllers\StampingHistoryController;
use App\Http\Controllers\ReceivingDetailsController;
use App\Http\Controllers\ProductionHistoryController;
use App\Http\Controllers\LoadingPortDetailsController;
use App\Http\Controllers\PackingListDetailsController;
use App\Http\Controllers\StampingChecksheetController;
use App\Http\Controllers\FirstMoldingStationController;
use App\Http\Controllers\SecondMoldingStationController;
use App\Http\Controllers\StampingWorkingReportController;
use App\Http\Controllers\MoldingIpqcInspectionController;
use App\Http\Controllers\AssemblyOqcLotAppController;
// use App\Http\Controllers\IpqcFirstMoldingController;
// use App\Http\Controllers\IpqcSecondMoldingController;
// use App\Http\Controllers\IpqcAssemblyController;
use App\Http\Controllers\PackingDetailsMoldingController;
use App\Http\Controllers\DestinationPortDetailsController;
use App\Http\Controllers\ExportTraceabilityReportController;
use App\Http\Controllers\ExportOqcInspectionController;
use App\Http\Controllers\ExportIqcInspectionController;
use App\Http\Controllers\MachineParameterController;


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
Route::view('/export_iqc_inspection_data','export_iqc_inspection_data')->name('export_iqc_inspection_data');

// Route::post('/edit_user_authentication', [UserController::class, 'editUserAuthentication'])->name('edit_user_authentication');

// * STAMPING VIEW
Route::view('/first_stamping_prod','first_stamping_prod')->name('first_stamping_prod');
Route::view('/second_stamping_prod','second_stamping_prod')->name('second_stamping_prod');
Route::view('/stamping_history','stamping_history')->name('stamping_history');

/* STAMPING VIEW - IPQC Inspectin */
Route::view('/ipqc_inspection_1st_stamping','ipqc_inspection_1st_stamping')->name('ipqc_inspection_1st_stamping');
Route::view('/ipqc_inspection_2nd_stamping','ipqc_inspection_2nd_stamping')->name('ipqc_inspection_2nd_stamping');

/* STAMPING VIEW - OQC Inspection */
Route::view('/first_stamping_oqc_inspection','first_stamping_oqc_inspection')->name('first_stamping_oqc_inspection');
Route::view('/second_stamping_oqc_inspection','second_stamping_oqc_inspection')->name('second_stamping_oqc_inspection');
Route::view('/export_oqc_inspection_data','export_oqc_inspection_data')->name('export_oqc_inspection_data');

/* PACKING  */
Route::view('/packing_details','packing_details')->name('packing_details');
Route::view('/packing_details_molding','packing_details_molding')->name('packing_details_molding');

/* PACKING LIST */
Route::view('/packing_list','packing_list')->name('packing_list');
Route::view('/packing_list_settings','packing_list_settings')->name('packing_list_settings');
Route::view('/receiving','receiving')->name('receiving');

/* MIMF */
Route::view('/Material_Issuance_Monitoring_Form','mimf')->name('Material_Issuance_Monitoring_Form');

/* MOLDING */
Route::view('/second_molding','second_molding')->name('second_molding');
Route::view('/second_molding_test','second_molding_test')->name('second_molding_test');
Route::view('/first_molding','first_molding')->name('first_molding');
Route::view('/first_molding_ipqc_inspection','first_molding_ipqc_inspection')->name('first_molding_ipqc_inspection'); //clark comment 02042024
Route::view('/ipqc_inspection_1st_molding','ipqc_inspection_1st_molding')->name('ipqc_inspection_1st_molding');
Route::view('/ipqc_inspection_2nd_molding','ipqc_inspection_2nd_molding')->name('ipqc_inspection_2nd_molding');
Route::view('/ipqc_inspection_assembly','ipqc_inspection_assembly')->name('ipqc_inspection_assembly');
Route::view('/mprs','mprs')->name('mprs');

/* CN ASSEMBLY */
Route::view('/assembly','assembly')->name('assembly');

/* * PPTS VIEW */
Route::view('/ppts_user','ppts_user')->name('ppts_user');
Route::view('/ppts_matrix','ppts_matrix')->name('ppts_matrix');
Route::view('/ppts_oqc_inspection','ppts_oqc_inspection')->name('ppts_oqc_inspection');
Route::view('/ppts_packing_and_shipping','ppts_packing_and_shipping')->name('ppts_packing_and_shipping');
Route::view('/ppts_export_packing_and_shipping','ppts_export_packing_and_shipping')->name('ppts_export_packing_and_shipping');

/* *PATS SHIPMENT CONFIRMATION */
Route::view('/pats_shipment_con','pats_shipment_confirmation')->name('pats_shipment_con');

/* TRACEABILITY REPORT */
Route::view('/cn171_traceability_report','cn171_traceability_report')->name('cn171_traceability_report');
Route::view('/molding_traceability_report','molding_traceability_report')->name('molding_traceability_report');

/* 5S CHECKSHEET VIEW */
Route::view('/5s_checksheet','5s_checksheet')->name('5s_checksheet');

/* PRESS STAMPING MACHINE CHHECKSHEET VIEW */
Route::view('/press_stamping_machine_checksheet','press_stamping_machine_checksheet')->name('press_stamping_machine_checksheet');

/* OQC LOT APPLICATION VIEW */
Route::view('/assy_oqc_lot_app','assembly_oqc_lot_app')->name('assy_oqc_lot_app');

/* FINAL VISUAL VIEW */
Route::view('/assy_fvi','assembly_fvi')->name('assy_fvi');
Route::view('/stamping_working_report','stamping_working_report')->name('stamping_working_report');

/* MACHINE PARAMETER */
Route::view('/machine_parameter','machine_parameter')->name('machine_parameter');

/* CASEMARK VIEW */
Route::view('/casemark_sticker','casemark_sticker')->name('casemark_sticker');

// USER CONTROLLER
Route::controller(UserController::class)->group(function () {
    // Route::get('/load_whs_transaction', 'loadWhsTransaction')->name('load_whs_transaction');
    Route::post('/sign_in', 'sign_in')->name('sign_in');
    Route::post('/rapidx_sign_in_admin', 'rapidx_sign_in_admin')->name('rapidx_sign_in_admin');
    Route::post('/sign_out', 'sign_out')->name('sign_out');
    Route::post('/change_pass', 'change_pass')->name('change_pass');
    Route::post('/change_user_stat', 'change_user_stat')->name('change_user_stat');
    Route::get('/view_users', 'view_users');
    Route::post('/add_user', 'add_user');
    Route::get('/get_user_by_id', 'get_user_by_id');
    Route::get('/get_user_by_en', 'get_user_by_en');
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
    Route::get('/get_mode_of_defect_frm_defect_infos', 'get_mode_of_defect_frm_defect_infos')->name('get_mode_of_defect_frm_defect_infos');
    Route::get('/get_data_from_acdcs', 'get_data_from_acdcs')->name('get_data_from_acdcs');

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
    Route::get('/view_stamp_prod', 'view_stamp_prod')->name('view_stamp_prod');
    Route::get('/get_data_req_for_prod_by_po', 'get_data_req_for_prod_by_po')->name('get_data_req_for_prod_by_po');
    Route::get('/get_prod_data_view', 'get_prod_data_view')->name('get_prod_data_view');
    Route::get('/print_qr_code', 'print_qr_code')->name('print_qr_code');
    Route::get('/check_matrix', 'check_matrix')->name('check_matrix');
    Route::get('/get_prod_lot_no_ctrl', 'get_prod_lot_no_ctrl')->name('get_prod_lot_no_ctrl');
    Route::get('/get_operator_list', 'get_operator_list')->name('get_operator_list');
    Route::get('/change_print_count', 'change_print_count')->name('change_print_count');
    Route::get('/get_history_details', 'get_history_details')->name('get_history_details');

    Route::get('/print_qr_for_ipqc', 'print_qr_for_ipqc')->name('print_qr_for_ipqc');
    Route::get('/get_matrix_for_mat_validation', 'get_matrix_for_mat_validation')->name('get_matrix_for_mat_validation');
    // SECON STAMPING
    Route::get('/get_2_stamp_reqs', 'get_2_stamp_reqs')->name('get_2_stamp_reqs');
    Route::post('/save_sublot', 'save_sublot')->name('save_sublot');
    Route::get('/get_sublot_by_id', 'get_sublot_by_id')->name('get_sublot_by_id');
});

Route::middleware('CheckSessionExist')->group(function(){

    // STAMPING CHECKSHEET
    Route::controller(StampingChecksheetController::class)->group(function () {

        // 5S CHECKSHEET
        Route::post('/save_checksheet', 'save_checksheet')->name('save_checksheet');
        Route::get('/get_machine_dropdown', 'get_machine_dropdown')->name('get_machine_dropdown');
        Route::get('/view_checksheet', 'view_checksheet')->name('view_checksheet');
        Route::post('/change_status', 'change_status')->name('change_status');
        Route::get('/get_checksheet_data', 'get_checksheet_data')->name('get_checksheet_data');

    });
});

Route::get('/get_session', [StampingChecksheetController::class, 'get_session'])->name('get_session');


// STAMPING -> IPQC CONTROLLER
Route::controller(StampingIpqcController::class)->group(function () {
    Route::get('/view_stamping_ipqc_data', 'view_stamping_ipqc_data')->name('view_stamping_ipqc_data');
    // Route::get('/get_po_from_pps_db', 'get_po_from_pps_db')->name('get_po_from_pps_db');
    Route::get('/get_po_from_fs_production', 'get_po_from_fs_production')->name('get_po_from_fs_production');
    Route::get('/get_data_from_first_stamping_by_po', 'get_data_from_first_stamping_by_po')->name('get_data_from_first_stamping_by_po');
    Route::get('/get_data_from_fs_production', 'get_data_from_fs_production')->name('get_data_from_fs_production');
    Route::post('/add_stamping_ipqc_inspection', 'add_stamping_ipqc_inspection')->name('add_stamping_ipqc_inspection');
    Route::post('/update_status_of_ipqc_inspection', 'update_status_of_ipqc_inspection')->name('update_status_of_ipqc_inspection');
    Route::get('/download_file_stamping/{id}', 'download_file')->name('download_file');

    //REPORT FOR PACKING LIST
    Route::get('/export/{CtrlNo}', 'excel')->name('export');
});

//FIRST MOLDING -> SECOND MOLDING -> ASSEMBLY IPQC CONTROLLER
Route::controller(MoldingAssyIpqcController::class)->group(function () {
    Route::get('/get_devices_from_ipqc', 'get_devices_from_ipqc')->name('get_devices_from_ipqc');
    Route::get('/verify_production_lot', 'verify_production_lot')->name('verify_production_lot');
    Route::get('/view_ipqc_data', 'view_ipqc_data')->name('view_ipqc_data');
    Route::get('/get_ipqc_data', 'get_ipqc_data')->name('get_ipqc_data');
    Route::post('/add_molding_assy_ipqc_inspection', 'add_molding_assy_ipqc_inspection')->name('add_molding_assy_ipqc_inspection');
    Route::post('/update_ipqc_inspection_status', 'update_ipqc_inspection_status')->name('update_ipqc_inspection_status');
    Route::get('/download_file_molding/{id}', 'download_file')->name('download_file');
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
    Route::get('/get_po_from_production', 'getPoFromProduction')->name('get_po_from_production'); //Clark Modified
    Route::get('/get_data_from_production', 'getDataFromProduction')->name('get_data_from_production');
    Route::post('/add_packing_list_details', 'addPackingListData')->name('add_packing_list_details');
    Route::get('/get_ppc_clerk_details', 'getPpcClerk')->name('get_ppc_clerk_details');
    Route::get('/get_ppc_sr_planner', 'getPpcSrPlanner')->name('get_ppc_sr_planner');
    Route::get('/get_carbon_copy_user', 'carbonCopyUser')->name('get_carbon_copy_user');
    Route::get('/get_packing_list_details_by_ctrl', 'getPackingListDetailsbyCtrl')->name('get_packing_list_details_by_ctrl');
    Route::get('/get_packing_list_details', 'getPackingListDetails')->name('get_packing_list_details');
});

Route::controller(ReceivingDetailsController::class)->group(function () {
    Route::get('/view_receiving_details_by_ctrl', 'viewReceivingListDetailsByCtrl')->name('view_receiving_details_by_ctrl');
    Route::get('/view_receiving_details', 'viewReceivingListDetails')->name('view_receiving_details');
    // Route::get('/view_receiving_details_accepted', 'viewReceivingListDetailsAccepted')->name('view_receiving_details_accepted'); // by nessa
    Route::get('/get_receiving_details', 'getReceivingListdetails')->name('get_receiving_details');
    Route::post('/update_receiving_details', 'updateReceivingDetails')->name('update_receiving_details');
    Route::get('/print_receiving_qr_code', 'printReceivingQrCode')->name('print_receiving_qr_code');
    Route::get('/change_print_status', 'changePrintStatus')->name('change_print_status');
});

Route::controller(PackingDetailsController::class)->group(function () {
    Route::get('/view_final_packing_details_data', 'viewFinalPackingDetailsData')->name('view_final_packing_details_data');
    Route::get('/view_preliminary_packing_details', 'viewPrelimDetailsData')->name('view_preliminary_packing_details');
    Route::get('/get_oqc_details', 'getOqcDetailsForPacking')->name('get_oqc_details');
    Route::get('/view_final_packing_details_for_validation', 'viewFinalPackingDataForValidation')->name('view_final_packing_details_for_validation');
    Route::post('/validate_prelim_details', 'updatePrelimDetails')->name('validate_prelim_details');
    Route::get('/generate_packing_qr', 'generatePackingDetailsQr')->name('generate_packing_qr');
    Route::get('/change_printing_status', 'changePrintingStatus')->name('change_printing_status');
    Route::post('/update_qc_details', 'updateQcDetails')->name('update_qc_details');
    Route::post('/validate_final_packing_details', 'validateFinalPackingDetails')->name('validate_final_packing_details');
    // viewFinalPackingData
});

Route::controller(PackingDetailsMoldingController::class)->group(function () {
    Route::get('/view_packing_details_fe', 'viewPackingDetailsFE')->name('view_packing_details_fe');
    Route::get('/view_packing_details_e', 'viewPackingDetailsE')->name('view_packing_details_e');
    Route::post('/updated_counted_by', 'updatePackingDetailsMolding')->name('updated_counted_by');
    Route::post('/update_checked_by', 'updateCheckByDetailsMolding')->name('update_checked_by');
    Route::get('/view_sublot_details', 'viewSublotDetails')->name('view_sublot_details');
    Route::get('/get_sublot_qty', 'getSublotQty')->name('get_sublot_qty');
});




/* First Molding Process */
Route::controller(FirstMoldingController::class)->group(function () {
    Route::get('/get_first_molding_devices', 'getFirstMoldingDevices')->name('get_first_molding_devices');
    Route::get('/get_first_molding_devices_by_id', 'getFirstMoldingDevicesById')->name('get_first_molding_devices_by_id');
    Route::get('/load_first_molding_details', 'loadFirstMoldingDetails')->name('load_first_molding_details');
    Route::get('/get_molding_details', 'getMoldingDetails')->name('get_molding_details');
    Route::get('/first_molding_update_status', 'firstMoldingUpdateStatus')->name('first_molding_update_status');
    Route::get('/get_pmi_po_received_details', 'getPmiPoReceivedDetails')->name('get_pmi_po_received_details');
    Route::get('/get_dieset_details_by_device_name', 'getDiesetDetailsByDeviceName')->name('get_dieset_details_by_device_name');
    Route::get('/get_first_molding_qr_code', 'getFirstMoldingQrCode')->name('get_first_molding_qr_code');
    Route::get('/get_machine_from_material_process', 'getMachineFromMaterialProcess')->name('get_machine_from_material_process');
    Route::get('/update_first_molding_shipment_machine_ouput', 'updateFirstMoldingShipmentMachineOuput')->name('update_first_molding_shipment_machine_ouput');
    Route::get('/validate_scan_first_molding_contact_lot_num', 'validateScanFirstMoldingContactLotNum')->name('validate_scan_first_molding_contact_lot_num');
    Route::get('/get_datalist_mimf_po_num', 'getDatalistMimfPoNum')->name('get_datalist_mimf_po_num');
    Route::get('/validate_material_lot_no', 'validateMaterialLotNo')->name('validate_material_lot_no');

    Route::post('/save_first_molding', 'saveFirstMolding')->name('save_first_molding');
});
/* First Molding Station Process */
Route::controller(FirstMoldingStationController::class)->group(function () {
    Route::get('/get_stations', 'getStations')->name('get_stations');
    Route::get('/load_first_molding_station_details', 'loadFirstMoldingStationDetails')->name('load_first_molding_station_details');
    Route::get('/get_first_molding_station_details', 'getFirstMoldingStationDetails')->name('get_first_molding_station_details');
    Route::get('/get_first_molding_station_last_ouput', 'getFirstMoldingStationLastOuput')->name('get_first_molding_station_last_ouput');
    Route::get('/delete_first_molding_detail', 'deleteFirstMoldingDetail')->name('delete_first_molding_detail');
    Route::get('/get_operation_names', 'getOperatioNames')->name('get_operation_names');
    Route::get('/get_first_molding_station_qr_code', 'getFirstMoldingStationQrCode')->name('get_first_molding_station_qr_code');

    Route::post('/save_first_molding_station', 'saveFirstMoldingStation')->name('save_first_molding_station');
});

Route::controller(MoldingIpqcInspectionController::class)->group(function () {
    Route::get('/view_first_molding_ipqc_Inspection', 'viewFirstMoldingIpqcInspection')->name('view_first_molding_ipqc_Inspection');
    Route::get('/get_molding_pmi_po', 'getMoldingPmiPo')->name('get_molding_pmi_po');
    Route::get('/get_molding_ipqc_inspection_by_id', 'getMoldingIpqcInspectionById')->name('get_molding_ipqc_inspection_by_id');
    Route::get('/scan_user_id', 'scanUserId')->name('scan_user_id');
    Route::post('/update_molding_ipqc_inspection', 'updateMoldingIpqcInspection')->name('update_molding_ipqc_inspection');
});

/* Second Molding Controller */
Route::controller(SecondMoldingController::class)->group(function () {
    Route::get('/get_po_received_by_po_number', 'getPOReceivedByPONumber')->name('get_po_received_by_po_number');
    Route::get('/get_revision_number_based_on_drawing_number', 'getRevisionNumberBasedOnDrawingNumber')->name('get_revision_number_based_on_drawing_number');
    Route::get('/check_material_lot_number', 'checkMaterialLotNumber')->name('check_material_lot_number');
    Route::get('/check_material_lot_number_of_first_molding', 'checkMaterialLotNumberOfFirstMolding')->name('check_material_lot_number_of_first_molding');
    Route::post('/save_second_molding', 'saveSecondMolding')->name('save_second_molding');
    Route::get('/view_second_molding', 'viewSecondMolding')->name('view_second_molding');
    Route::get('/get_second_molding_by_id', 'getSecondMoldingById')->name('get_second_molding_by_id');
    Route::get('/get_material_process_station', 'getMaterialProcessStation')->name('get_material_process_station');
    Route::get('/get_mode_of_defect_for_second_molding', 'getModeOfDefectForSecondMolding')->name('get_mode_of_defect_for_second_molding');
    Route::post('/complete_second_molding', 'completeSecondMolding')->name('complete_second_molding');
    Route::get('/get_second_molding_qr_code', 'getSecondMoldingQrCode')->name('get_second_molding_qr_code');
    Route::get('/get_material_drying_qr_code', 'getMaterialDryingQrCode')->name('get_material_drying_qr_code');
    Route::get('/get_last_shipment_output', 'getLastShipmentOuput')->name('get_last_shipment_output');
    Route::get('/get_user_for_second_molding', 'getUser')->name('get_user_for_second_molding');
    Route::get('/get_machine', 'getMachine')->name('get_machine');
    Route::get('/get_dieset_details_by_device_name_second_molding', 'getDiesetDetailsByDeviceNameSecondMolding')->name('get_dieset_details_by_device_name_second_molding');
    Route::get('/get_count_of_station', 'getCountOfStation')->name('get_count_of_station');
    Route::get('/check_if_last_step_by_material_name', 'checkIfLastStepByMaterialName')->name('check_if_last_step_by_material_name');
    Route::post('/save_material_drying', 'saveMaterialDrying')->name('save_material_drying');
});
/* Second Molding Station Controller */
Route::controller(SecondMoldingStationController::class)->group(function () {
    Route::get('/view_second_molding_station', 'viewSecondMoldingStation')->name('view_second_molding_station');
    Route::post('/save_second_molding_station', 'saveSecondMoldingStation')->name('save_second_molding_station');
    Route::get('/get_second_molding_station_by_id', 'getSecondMoldingStationById')->name('get_second_molding_station_by_id');
});

/* Stamping Working Report Controller */
Route::controller(StampingWorkingReportController::class)->group(function () {
    Route::get('/view_stamping_working_report', 'viewStampingWorkingReport')->name('view_stamping_working_report');
    Route::get('/view_stamping_working_report_work_details', 'viewStampingWorkingReportWorkDetails')->name('view_stamping_working_report_work_details');
    Route::post('/save_machine_number', 'saveMachineNumber')->name('save_machine_number');
    Route::post('/save_stamping_working_report_work_details', 'saveStampingWorkingReportWorkDetails')->name('save_stamping_working_report_work_details');
    Route::get('/get_stamping_working_report_by_id', 'getStampingWorkingReportById')->name('get_stamping_working_report_by_id');
    Route::get('/get_stamping_working_report_work_details_by_id', 'getStampingWorkingReportWorkDetailsById')->name('get_stamping_working_report_work_details_by_id');
});


/* CN Assembly Controller */
Route::controller(AssemblyRuncardController::class)->group(function(){
    Route::get('/get_data_from_2nd_molding', 'get_data_from_2nd_molding')->name('get_data_from_2nd_molding');
    Route::get('/get_station_from_mat_process', 'get_station_from_mat_process')->name('get_station_from_mat_process');
    Route::get('/view_assembly_runcard', 'view_assembly_runcard')->name('view_assembly_runcard');
    Route::get('/view_assembly_runcard_stations', 'view_assembly_runcard_stations')->name('view_assembly_runcard_stations');
    Route::post('/add_assembly_runcard_data', 'add_assembly_runcard_data')->name('add_assembly_runcard_data');
    Route::post('/add_assembly_runcard_station_data', 'add_assembly_runcard_station_data')->name('add_assembly_runcard_station_data');
    Route::get('/get_assembly_runcard_data', 'get_assembly_runcard_data')->name('get_assembly_runcard_data');
    Route::get('/get_data_from_matrix', 'get_data_from_matrix')->name('get_data_from_matrix');
    Route::get('/chk_device_prod_lot_from_first_molding', 'chk_device_prod_lot_from_first_molding')->name('chk_device_prod_lot_from_first_molding');
    Route::get('/chk_device_prod_lot_from_sec_molding', 'chk_device_prod_lot_from_sec_molding')->name('chk_device_prod_lot_from_sec_molding');
    Route::post('/update_assy_runcard_status', 'update_assy_runcard_status')->name('update_assy_runcard_status');
    Route::get('/get_assembly_qr_code', 'get_assembly_qr_code')->name('get_assembly_qr_code');
    Route::get('/get_total_yield', 'get_total_yield')->name('get_total_yield');
    Route::get('/connect_ypics', 'connect_ypics')->name('connect_ypics');
    Route::get('/chck_existing_stations', 'chck_existing_stations')->name('chck_existing_stations');
    Route::post('/update_assembly_status', 'update_assembly_status')->name('update_assembly_status');
});

// MODE OF DEFECTS CONTROLLER
Route::controller(DefectsInfoController::class)->group(function () {
    Route::get('/view_defectsinfo', 'view_defectsinfo')->name('view_defectsinfo');
    Route::post('/add_defects', 'add_defects')->name('add_defects');
    Route::get('/get_defects_by_id', 'get_defects_by_id')->name('get_defects_by_id');
});

Route::controller(ProductionHistoryController::class)->group(function () {
    Route::post('/add_prodn_history', 'add_prodn_history')->name('add_prodn_history');
    Route::get('/load_prodn_history_details', 'load_prodn_history_details')->name('load_prodn_history_details');
    Route::get('/get_first_molding_contact_lot_num_by_date_machine_num', 'get_first_molding_contact_lot_num_by_date_machine_num')->name('get_first_molding_contact_lot_num_by_date_machine_num');
    // Route::get('/get_optr_list', 'get_optr_list')->name('get_optr_list');
    // Route::get('/get_material_list', 'get_material_list')->name('get_material_list');
    // Route::get('/check_material_details', 'check_material_details')->name('check_material_details');
    Route::get('/get_prodn_history_by_id', 'get_prodn_history_by_id')->name('get_prodn_history_by_id');
    Route::get('/get_first_molding_devices_for_history', 'get_first_molding_devices_for_history')->name('get_first_molding_devices_for_history');
});

Route::view('/production_history','production_history')->name('production_history');
// <<<<<<< HEAD
// <<<<<<< HEAD

// =======
// >>>>>>> parent of c94e5b5 (01/30/24 6:55pm Before merge)
// =======
// /* Warehouse iframe */
Route::view('/warehouse_resin','warehouse_resin')->name('warehouse_resin');
Route::view('/production_history','production_history')->name('production_history');

// >>>>>>> parent of e42c11b (Before merging main)

//EXPORT CN171 REPORT
Route::controller(ExportTraceabilityReportController::class)->group(function () {
    Route::get('/export_cn171_traceability_report/{date_from}/{date_to}/{material_name}', 'exportCN171TraceabilityReport')->name('export_cn171_traceability_report');
    Route::get('/export_molding_traceability_report/{po_number}/{date_from}/{date_to}/{device_name}', 'exportMoldingTraceabilityReport')->name('export_molding_traceability_report');
});
// Route::get('/export_cn171_traceability_report/{po_number}', 'ExportTraceabilityReportController@export_cn171_traceability_report');3

Route::controller(MimfController::class)->group(function () {
    Route::get('/view_mimf', 'viewMimf')->name('view_mimf');
    Route::get('/employee_id', 'employeeID')->name('employee_id');
    Route::post('/update_mimf', 'updateMimf')->name('update_mimf');
    Route::get('/get_mimf_by_id', 'getMimfById')->name('get_mimf_by_id');
    Route::get('/get_control_no', 'getControlNo')->name('get_control_no');
    Route::get('/get_pmi_po', 'getPmiPoFromPoReceived')->name('get_pmi_po');

    Route::get('/view_mimf_stamping_matrix', 'viewMimfStampingMatrix')->name('view_mimf_stamping_matrix');
    Route::post('/update_mimf_stamping_matrix', 'updateMimfStampingMatrix')->name('update_mimf_stamping_matrix');
    Route::get('/get_mimf_stamping_matrix_by_id', 'getMimfStampingMatrixById')->name('get_mimf_stamping_matrix_by_id');
    Route::get('/get_pps_warehouse', 'getPpsWarehouse')->name('get_pps_warehouse');
    Route::get('/get_pps_po_recveived_item_name', 'getPpsPoReceivedItemName')->name('get_pps_po_recveived_item_name');
});

Route::controller(StampingHistoryController::class)->group(function () {
    Route::get('/view_stamping_history', 'viewStampingHistory')->name('view_stamping_history');
    Route::get('/get_stamping_prodn_material_name', 'getStampingProdnMaterialName')->name('get_stamping_prodn_material_name');
    Route::get('/get_user', 'getPatsPpdUser')->name('get_user');
    Route::get('/get_previous_shot_accumulated_by_partname', 'getPreviousShotAccumulatedByPartName')->name('get_previous_shot_accumulated_by_partname');
    Route::get('/employee_id', 'employeeID')->name('employee_id');
    Route::post('/update_stamping_history', 'updateStampingHistory')->name('update_stamping_history');
    Route::get('/get_stamping_history_by_id', 'getStampingHistoryById')->name('get_stamping_history_by_id');
});

/* PRESS STAMPING MACHINE CHHECKSHEET */
Route::controller(DailyChecksheetController::class)->group(function () {
    Route::get('/view_daily_checksheet', 'viewDailyChecksheet')->name('view_daily_checksheet');
    Route::get('/get_daily_checksheet_data', 'getDailyChecksheetData')->name('get_daily_checksheet_data');
    Route::post('/add_daily_checksheet', 'addDailyChecksheet')->name('add_daily_checksheet');
    Route::post('/update_status_checked_by', 'updateStatusCheckedBy')->name('update_status_checked_by');
    Route::post('/update_status_conformed_by', 'updateStatusConformedBy')->name('update_status_conformed_by');

    //WEEKLY
    Route::get('/view_weekly_checksheet', 'viewWeeklyChecksheet')->name('view_weekly_checksheet');
    Route::post('/add_weekly_checksheet', 'addWeeklyChecksheet')->name('add_weekly_checksheet');
    Route::get('/get_weekly_checksheet_data', 'getWeeklyChecksheetData')->name('get_weekly_checksheet_data');
    Route::post('/update_status_weekly_check', 'updateWeeklyStatusCheckedBy')->name('update_status_weekly_check');
    Route::post('/update_status_weekly_conformed', 'updateWeeklyStatusConformedBy')->name('update_status_weekly_conformed');

    //MONTHLY
    Route::get('/view_monthly_checksheet', 'viewMonthlyChecksheet')->name('view_monthly_checksheet');
    Route::post('/add_monthly_checksheet', 'addMonthlyChecksheet')->name('add_monthly_checksheet');
    Route::get('/get_monthly_checksheet_data', 'getMonthlyChecksheetData')->name('get_monthly_checksheet_data');

    //MAINTENANCE/REPAIR HIGHLIGHTS
    Route::get('/view_maintenance_repair_highlights', 'viewMonthlyRepairHighlights')->name('view_maintenance_repair_highlights');
    Route::get('/get_technician_repair_highlights', 'getTechnicianRepairHighlights')->name('get_technician_repair_highlights');
    Route::post('/add_maintenance_highlights', 'addMaintenanceHighlights')->name('add_maintenance_highlights');
});

// ASSEMBLY FVI
Route::controller(AssemblyFviController::class)->group(function () {
    Route::get('/view_visual_inspection', 'view_visual_inspection')->name('view_visual_inspection');
    Route::get('/view_fvi_runcards', 'view_fvi_runcards')->name('view_fvi_runcards');
    Route::get('/get_fvi_doc', 'get_fvi_doc')->name('get_fvi_doc');
    Route::get('/get_assembly_line', 'get_assembly_line')->name('get_assembly_line');
    Route::post('/save_visual_details', 'save_visual_details')->name('save_visual_details');
    Route::get('/get_visual_details', 'get_visual_details')->name('get_visual_details');
    Route::get('/get_runcard_details', 'get_runcard_details')->name('get_runcard_details');
    Route::post('/save_runcard', 'save_runcard')->name('save_runcard');
    Route::get('/get_fvi_details_by_id', 'get_fvi_details_by_id')->name('get_fvi_details_by_id');
    Route::get('/validate_runcard_output', 'validate_runcard_output')->name('validate_runcard_output');
    Route::post('/submit_to_oqc_lot_app', 'submit_to_oqc_lot_app')->name('submit_to_oqc_lot_app');
    Route::get('/search_po', 'search_po')->name('search_po');


});

// ASSEMBLY OQC LOT APP
Route::controller(AssemblyOqcLotAppController::class)->group(function () {
    Route::get('/get_po_number_from_assy_fvi', 'get_po_number_from_assy_fvi')->name('get_po_number_from_assy_fvi');
    Route::get('/get_data_from_assy_fvi', 'get_data_from_assy_fvi')->name('get_data_from_assy_fvi');
    Route::get('/view_assy_oqc_lot_app', 'view_assy_oqc_lot_app')->name('view_assy_oqc_lot_app');
    Route::get('/view_assy_oqc_lot_app_summary', 'view_assy_oqc_lot_app_summary')->name('view_assy_oqc_lot_app_summary');
    Route::post('/add_oqc_lot_app', 'add_oqc_lot_app')->name('add_oqc_lot_app');
    Route::post('/update_lot_app_status', 'update_lot_app_status')->name('update_lot_app_status');
    Route::get('/get_user_name', 'get_user_name')->name('get_user_name');
    Route::get('/gen_oqclotapp_qrsticker', 'gen_oqclotapp_qrsticker')->name('gen_oqclotapp_qrsticker');
    Route::get('/gen_oqclotapp_inner_box_qrsticker', 'gen_oqclotapp_inner_box_qrsticker')->name('gen_oqclotapp_inner_box_qrsticker');
});

// EXPORT OQC Inspection DATA
Route::controller(ExportOqcInspectionController::class)->group(function () {
    Route::get('/search_oqc_inspection_po_no', 'searchOqcInspectionPoNo')->name('search_oqc_inspection_po_no');
    Route::get('/export_oqc_inspection/{po}/{processType}/{from}/{to}', 'exportOqcInspection');
});

// EXPORT IQC Inspection DATA
Route::controller(ExportIqcInspectionController::class)->group(function () {
    Route::get('/search_iqc_inspection_material_name', 'searchIqcInspectionMaterialName')->name('search_iqc_inspection_material_name');
    Route::get('/export_iqc_inspection/{any}', 'exportIqcInspection')->where('any', '.*');
});

// MachineParameter Controller
Route::controller(MachineParameterController::class)->group(function () {
    Route::post('/save_machine_one', 'saveMachineOne')->name('save_machine_one');
    Route::post('/save_injection_tab_list','saveInjectionTabList')->name('save_injection_tab_list');

    Route::get('/edit_machine_parameter','editMachineParameter')->name('edit_machine_parameter');
    Route::get('/load_machine_parameter_one','loadMachineParameterOne')->name('load_machine_parameter_one');
    Route::get('/get_machine_name_form1','getMachineDetailsForm1')->name('get_machine_name_form1');
    Route::get('/get_machine_name_form2','getMachineDetailsForm2')->name('get_machine_name_form2');
    Route::get('/get_operator_name','getOperatorName')->name('get_operator_name');
    Route::get('/load_injection_tab_list','loadInjectionTabList')->name('load_injection_tab_list');
    Route::get('/edit_injection_tab_list', 'editInjectionTabList')->name('edit_injection_tab_list');
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



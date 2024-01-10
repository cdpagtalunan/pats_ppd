<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\StampingIpqcController;
use App\Http\Controllers\FirstStampingController;
use App\Http\Controllers\IqcInspectionController;
use App\Http\Controllers\OQCInspectionController;
use App\Http\Controllers\MaterialProcessController;
use App\Http\Controllers\CustomerDetailsController;

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

Route::view('/','index')->name('login');

Route::view('/login','index')->name('login');

Route::view('/dashboard','dashboard')->name('dashboard');
// * ADMIN VIEW
Route::view('/user','user')->name('user');
Route::view('/change_pass_view','change_password')->name('change_pass_view');
Route::view('/materialprocess','materialprocess')->name('materialprocess');
Route::view('/process','process')->name('process');

/* MIGZ IQC INSPECTION VIEW */
Route::view('/iqc_inspection','iqc_inspection')->name('iqc_inspection');


// Route::post('/edit_user_authentication', [UserController::class, 'editUserAuthentication'])->name('edit_user_authentication');

// * STAMPING VIEW
Route::view('/first_stamping_prod','first_stamping_prod')->name('first_stamping_prod');

// * STAMPING VIEW - IPQC Inspectin */
Route::view('/ipqc_inspection','ipqc_inspection')->name('ipqc_inspection');

/* STAMPING VIEW - OQC Inspection */
Route::view('/oqc_inspection','oqc_inspection')->name('oqc_inspection');


/* PACKING LIST */
Route::view('/packing_list','packing_list')->name('packing_list');
Route::view('/packing_list_settings','packing_list_settings')->name('packing_list_settings');

// USER CONTROLLER
Route::controller(UserController::class)->group(function () {
    Route::get('/load_whs_transaction', 'loadWhsTransaction')->name('load_whs_transaction');
    Route::post('/sign_in', 'sign_in')->name('sign_in');
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

});

// DEVICE CONTROLLER
Route::controller(DeviceController::class)->group(function () {
    Route::get('/view_devices','view_devices');
    Route::post('/add_device','add_device');
    Route::get('/get_device_by_id','get_device_by_id');
    Route::post('/change_device_stat','change_device_stat');
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
Route::controller(FirstStampingController::class)->group(function () {
    Route::post('/save_prod_data', 'save_prod_data')->name('save_prod_data');
    Route::get('/view_first_stamp_prod', 'view_first_stamp_prod')->name('view_first_stamp_prod');
    Route::get('/get_data_req_for_prod_by_po', 'get_data_req_for_prod_by_po')->name('get_data_req_for_prod_by_po');
    Route::get('/get_prod_data_view', 'get_prod_data_view')->name('get_prod_data_view');
    Route::get('/print_qr_code', 'print_qr_code')->name('print_qr_code');
});

// STAMPING -> IPQC CONTROLLER
Route::controller(StampingIpqcController::class)->group(function () {
    Route::get('/view_stamping_ipqc_data', 'view_stamping_ipqc_data')->name('view_stamping_ipqc_data');
    Route::get('/get_po_from_pps_db', 'get_po_from_pps_db')->name('get_po_from_pps_db');
});



//IQC Inspection
Route::controller(IqcInspectionController::class)->group(function () {
    Route::get('/load_whs_transaction', 'loadWhsTransaction')->name('load_whs_transaction');
    Route::get('/get_whs_transaction_by_id', 'getWhsTransactionById')->name('get_whs_transaction_by_id');
    //http://192.168.3.246/pmi-subsystem/iqcdbgetitemdetails
    //http://192.168.3.246/pmi-subsystem/iqcdbgetongoing
});

//OQC Inspection
Route::controller(OQCInspectionController::class)->group(function () {
    Route::get('/view_oqc_inspection', 'viewOqcInspection')->name('view_oqc_inspection');
});

// Packing List 
Route::controller(CustomerDetailsController::class)->group(function () {
    Route::get('/view_company_details', 'viewCompanyDetails')->name('view_company_details');
});

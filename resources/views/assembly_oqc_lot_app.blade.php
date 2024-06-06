@php $layout = 'layouts.admin_layout'; @endphp

@auth
@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
    {{-- <style>
        table.table tbody td{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 13px;
            /* text-align: center; */
            vertical-align: middle;
        }

        table.table thead th{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 15px;
            text-align: center;
            vertical-align: middle;
        }
    </style> --}}
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>OQC Lot Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">OQC Lot Application</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">1. Scan PO Number</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-sm-3">
                                        <label>PO Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-primary" id="btnScanPo" data-bs-toggle="modal" data-bs-target="#mdlScanQrCode">
                                                    <i class="fa-solid fa-qrcode"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control" id="txtSearchPONum" readonly placeholder="Search PO Number">
                                        </div>
                                    </div> --}}
                                    <div class="col-sm-2">
                                            <label class="form-label">PO Number:</label>
                                        <div class="input-group mb-3">
                                            <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Select PO"></i>
                                            <select class="form-control select2bs5" id="txtSelectFVIPoNumber" name="sel_po_number" placeholder="Select PO"></select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Device Name</label>
                                        <input type="text" class="form-control" id="txtSearchDeviceName" name="" readonly placeholder="Device Name">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Device Code</label>
                                        <input type="text" class="form-control" id="txtSearchDeviceCode" readonly placeholder="Device Code">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>PO Qty</label>
                                        <input type="text" class="form-control" id="txtSearchPoQty" readonly placeholder="PO Qty">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">2. Application of Lot</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover w-100" id="tblAssyOQCLotApp">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                {{-- <th>Sub Lot #</th> --}}
                                                <th>Lot #</th>
                                                <th>Sub Lot #</th>
                                                <th>Required Lot Qty</th>
                                                <th>Lot Qty Applied</th>
                                                <th>Applied By</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Start Scan QR Modal -->
    <div class="modal fade" id="mdlScanQrCode" data-formid="" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pt-0">
                    {{-- hidden_scanner_input --}}
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQrCode" name="scan_qr_code" autocomplete="off">
                    <div class="text-center text-secondary">Please scan the code.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.End Scan QR Modal -->

    <div class="modal fade" id="modalScan_PO" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <div class="text-center text-secondary">
                        Please scan the PO number.
                        <br><br>
                        <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                    </div>
                    <input type="text" id="txt_search_po_number" class="hidden_scanner_input">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_OQCLotApp_QRcode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Outer Box - QR Sticker</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                    ->size(150)->margin(5)->errorCorrection('H')
                                    ->generate('0')) !!}" id="img_barcode_PONum" style="max-width: 200px;">
                            <br>
                            </center>

                            <label id="img_barcode_details"></label>
                            <label id="lbl_PO_num"></label>
                            <label id="lbl_prod_name"></label>
                            <label id="lbl_lot_num"></label>
                            <label id="lbl_lot_qty"></label>
                            <label id="lbl_line_num"></label>
                            <label id="lbl_datetime_applied"></label>
                            <label id="lbl_ww"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_print_lot_app_barcode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal_LotApp_InnerBox_QRcode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Inner Box - QR Sticker</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')
                                        ->size(150)->margin(5)->errorCorrection('H')
                                        ->generate('0')) !!}" id="img_barcode_PO" style="max-width: 200px;">
                                <br>
                            </center>
                            <label id="img_barcode_PO_text"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_print_inner_box_barcode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- CONFIRM SUBMIT MODAL START -->
    <div class="modal fade" id="modalConfirmSubmit">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title"><i class="fa-solid fa-file-circle-check"></i>&nbsp;&nbsp;Confirmation</h4>
                    <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="FrmConfirmSubmit">
                    @csrf
                    <div class="modal-body">
                        <div class="row d-flex justify-content-center">
                            <label class="text-secondary mt-2">Are you sure you want to proceed?</label>
                            <input type="hidden" class="form-control" name="cnfrm_assy_id" id="cnfrmtxtId">
                            {{-- <input type="hidden" class="form-control" name="cnfrm_ipqc_production_lot" id="cnfrmtxtIPQCProdLot">
                            <input type="hidden" class="form-control" name="cnfrm_ipqc_process_category" id="cnfrmtxtIPQCProcessCat"> --}}
                            <input type="hidden" class="form-control" name="cnfrm_ipqc_status" id="cnfrmtxtStatus">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnConfirmSubmit" class="btn btn-primary"><i id="ConfirmSubmitIcon"
                                class="fa fa-check"></i> Proceed</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- CONFIRM SUBMIT MODAL END -->

    <!-- MODALS -->
    <div class="modal fade" id="modalOQCLotApp" style="overflow-y: auto;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">OQC Lot Application</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formOQCLotApp">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 p-2">
                                <input type="hidden" class="form-control" id="OQCLotAppId" name="oqc_lot_app_id">
                                <input type="hidden" class="form-control" id="AssyFviId" name="assy_fvi_id">

                                <input type="hidden" class="form-control" id="hidden_position" value="{{ Auth::user()->position }}">
                                <input type="hidden" class="form-control" id="SubmissionCount" name="submission_count">
                                <input type="hidden" class="form-control" id="hidden_runcard_id" name="hidden_runcard_id">
                                <input type="hidden" class="form-control" id="hidden_status" name="hidden_status">
                                <input type="hidden" class="form-control" id="hidden_require_oqc_before_emboss" name="hidden_require_oqc_before_emboss">
                                <input type="hidden" class="form-control" id="hidden_runcard_status" name="hidden_runcard_status">
                                <input type="hidden" class="form-control" id="hidden_sub_lot" name="hidden_sub_lot">

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Current PO Number</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmCurrentPo" name="po_number" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Qty</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmPoQty" name="po_qty" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmDeviceName" name="device_name" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Device Code</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmDeviceCode" name="device_code" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot No.</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmLotNo" name="lot_no" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot Quantity</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmLotQuantity" name="lot_quantity" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Output Quantity</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmOutputQuantity" name="output_quantity" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Application Date</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmAppDate" name="app_date" value="<?php date_default_timezone_set('Asia/Manila'); echo date("Y-m-d h:i a");?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Print Lot No.</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmPrintLotNo" name="print_lot_no" readonly autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">A Drawing No. / Rev</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmADrawing" name="a_drawing" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">G Drawing No. / Rev</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="FrmGDrawing" name="g_drawing" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 p-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Device Category</span>
                                            </div>
                                            <select class="form-control form-control-sm selectDevice" name="device_cat" id="FrmSelectDeviceCat">
                                                <option value = "0" selected disabled>---</option>
                                                <option value = "1">Automotive</option>
                                                <option value = "2">Non-Automotive</option>
                                                <option value = "3">Regular Device</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Certification Lot</span>
                                            </div>
                                            <select class="form-control form-control-sm selectCertLot" name="cert_lot" id="FrmCertLot">
                                                <option value = "0" selected disabled>---</option>
                                                <option value = "6">N/A</option>
                                                <option value = "1">New Operator</option>
                                                <option value = "2">New product/model</option>
                                                <option value = "3">Evaluation lot</option>
                                                <option value = "4">Re-inspection</option>
                                                <option value = "5">Flexibility</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            {{-- </div>
                            <div class="col-sm-4 p-2"> --}}
                                <div class="row">
                                    <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-100">
                                            <span class="input-group-text w-100" id="basic-addon1">Guaranteed Lot (Containtment actions from in-process defects, OQC lot-out, <br> internal & customer claim)</span>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input class="form-control-sm" type="radio" id="FrmGuaranteedLotWith" name="guaranteed_lot" value="1"> &nbsp; WITH &nbsp;&nbsp;
                                        <input class="form-control-sm" type="radio" id="FrmGuaranteedLotWO" name="guaranteed_lot" value="2"> &nbsp; WITHOUT
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Problem</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="FrmProblem" name="problem" autocomplete="off" readonly>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Document No.</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="FrmDocNo" name="doc_no" autocomplete="off" readonly>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Lot Applied By</span>
                                            </div>
                                            <input type="text" class="form-control" id="AppliedByOperatorName" name="applied_by_operator_name" readonly>
                                            <input type="hidden" id="idAppliedByOperatorName" name="id_applied_by_operator_name">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-info btn-sm" id="btnSearchInspector" data-bs-toggle="modal" data-bs-target="#modalScanQRSave" title="Scan Employee ID"><i class="fa fa-barcode"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" id="btnPopLastOperator" title="Remove Last Operator"><i class="fa fa-retweet"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                        </div>
                                        <textarea class="form-control form-control-sm" rows="3" id="FrmOQCRemarks" name="oqc_remarks"></textarea>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-2">
                                <span class="fa fa-list"></span> OQC Lot Application Summary
                                <br><br>
                                <div class="table-responsive">
                                    <table id="tblLotAppSummary" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                        <thead style="font-size:85%;">
                                            <tr align="center">
                                            <th>Submission</th>
                                            <th>Guaranteed Lot</th>
                                            <th>Problem</th>
                                            <th>Document No.</th>
                                            <th>App. Date</th>
                                            {{-- <th>App. Time</th> --}}
                                            <th>Lot Applied By</th>
                                            <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:85%;"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="id_btn_AddOQCLotApp" class="btn btn-primary btn-sm"><i class="fa fa-check fa-xs"></i> Save</button>
                        <button type="button" id="id_btn_close_oqcla" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js_content')
<script>
    $(document).ready(function(){

        GetPOFromFVI($("#txtSelectFVIPoNumber"));

        function GetPOFromFVI(cboElement){
            let result = '<option value="" disabled selected>--Select PO Number--</option>';

            $.ajax({
                    type: "get",
                    url: "get_po_number_from_assy_fvi",
                    data: {
                        // "process_category": 3 //Process Category : Assembly
                    },
                    dataType: "json",
                    beforeSend: function() {
                        result = '<option value="0" disabled selected> -- Loading -- </option>';
                        cboElement.html(result);
                    },
                    success: function(response) {
                        let fvi_po_number = response['po_number'];
                        if (fvi_po_number.length > 0) {
                                result = '<option value="0" disabled selected>--Select PO Number--</option>';
                            for (let index = 0; index < fvi_po_number.length; index++) {
                                result += '<option value="' + fvi_po_number[index].po_no + '">'+fvi_po_number[index].po_no+'</option>';
                            }
                        } else {
                            result = '<option value="0" selected disabled> -- No record found -- </option>';
                        }
                        cboElement.html(result);
                    },
                    error: function(data, xhr, status) {
                        result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                        cboElement.html(result);
                        console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
            });
        }

        $('#txtSelectFVIPoNumber').on('change', function(e){
            // if(e.keyCode == 13){
                const PoNum = $('#txtSelectFVIPoNumber').val();
                // try {
                    // let ScanQrCodeVal = JSON.parse(ScanQrCode)
                    //     getPoNum =  ScanQrCodeVal.po
                        $.ajax({
                            type: "get",
                            url: "get_data_from_assy_fvi",
                            data: {
                                'po_number' : PoNum
                            },
                            dataType: "json",
                            success: function (response) {
                                let assy_fvi_details = response['assy_fvi_details'];
                                if(assy_fvi_details == '' || assy_fvi_details == undefined){
                                    toastr.error('PO does not exists')
                                    $('#txtScanQrCode').val('');
                                }else{
                                    $('#txtSelectFVIPoNumber').val(PoNum);
                                    // $('#txtSearchPONum').val(assy_fvi_details[0]['po_no']);
                                    $('#txtSearchDeviceName').val(assy_fvi_details.device_name);
                                    $('#txtSearchDeviceCode').val(assy_fvi_details.device_code);
                                    $('#txtSearchPoQty').val(assy_fvi_details.po_qty);
                                    $('#txtScanQrCode').val('');
                                    $('#mdlScanQrCode').modal('hide');
                                    dtOQCLotApp.draw();
                                }
                            }
                        });
                // }catch (error) {
                //     toastr.error('Please Scan QR Code')
                //     $('#txtScanQrCode').val('');
                // }
            // }
        });

        // $('#txtSelectAssemblyDevice').on('change', function(e){
        //                 let searchMatNameFrmSecondMolding = $('#txtSelectAssemblyDevice').val();
        //                 $.ajax({
        //                     type: "get",
        //                     url: "get_ipqc_data",
        //                     data: {
        //                         "device_id" : searchMatNameFrmSecondMolding
        //                     },
        //                     dataType: "json",
        //                     success: function (response) {
        //                         const IpqcData = response['ipqc_data'];
        //                         $('#txtSelectAssemblyDevice').val(searchMatNameFrmSecondMolding);
        //                         $('#txtSearchPartCode').val(IpqcData[0].part_code);

        //                         dtAssemblyIpqcInspPending.draw();
        //                         dtAssemblyIpqcInspCompleted.draw();
        //                         dtAssemblyIpqcInspResetup.draw();
        //                     }
        //                 });
        //             // }
        //         });

        // $('#btnScanPo').on('click', function(e){
        //     e.preventDefault();
        //     // $('#mdlScanQrCode').modal('show');
        //     $('#mdlScanQrCode').on('shown.bs.modal', function () {
        //         $('#txtScanQrCode').focus();
        //         const mdlScanQrCode = document.querySelector("#mdlScanQrCode");
        //         const inptQrCode = document.querySelector("#txtScanQrCode");
        //         let focus = false;

        //         mdlScanQrCode.addEventListener("mouseover", () => {
        //             if (inptQrCode === document.activeElement) {
        //                 focus = true;
        //             } else {
        //                 focus = false;
        //             }
        //         });

        //         mdlScanQrCode.addEventListener("click", () => {
        //             if (focus) {
        //                 inptQrCode.focus()
        //             }
        //         });
        //     });
        // });

        // btn_view_app_lot
        $(document).on('click', '.btn_view_app_lot', function(){
            let id = $(this).val();
            let sub_count = $(this).attr('sub_count');
            $.ajax({
                type: "get",
                url: "get_data_from_assy_fvi",
                data: {
                    "fvi_id" : id,
                    "sub_count" : sub_count,
                    "po_number" : $('#txtSelectFVIPoNumber').val()
                },
                dataType: "json",
                success: function (response){
                    let assy_fvi_details = response['assy_fvi_details'];

                    let oqc_lot_app = response['assy_fvi_details'].oqc_lot_app;
                    let oqc_lot_app_summ = response['assy_fvi_details'].oqc_lot_app.oqc_lot_app_summ[0];

                    let devices = response['devices'];
                    let total_qty_output = response['total_qty_output'];

                    $('#FrmSelectDeviceCat').prop('disabled', true)
                    $('#FrmCertLot').prop('disabled', true)

                    if(oqc_lot_app.guaranteed_lot == 1){
                        $('#FrmGuaranteedLotWith').prop('checked', true);
                        $('#FrmGuaranteedLotWO').prop('checked', false);
                    }else if(oqc_lot_app.guaranteed_lot == 2){
                        $('#FrmGuaranteedLotWith').prop('checked', false);
                        $('#FrmGuaranteedLotWO').prop('checked', true);
                    }

                    $('#FrmGuaranteedLotWith').prop('disabled', true)
                    $('#FrmGuaranteedLotWO').prop('disabled', true)

                    $('#FrmProblem').prop('disabled', true)
                    $('#FrmDocNo').prop('disabled', true)

                    $('#btnSearchInspector').prop('disabled', true)
                    $('#btnPopLastOperator').prop('disabled', true)
                    $('#FrmOQCRemarks').prop('disabled', true)
                    $('#id_btn_AddOQCLotApp').prop('hidden', true)

                    $('#AssyFviId').val(assy_fvi_details.id); //from fvi
                    $('#FrmCurrentPo').val(assy_fvi_details.po_no); //from fvi
                    $('#FrmPoQty').val(assy_fvi_details.po_qty); //from fvi
                    $('#FrmDeviceName').val(assy_fvi_details.device_name); //from fvi
                    $('#FrmDeviceCode').val(assy_fvi_details.device_code); //from fvi
                    $('#FrmLotNo').val(assy_fvi_details.lot_no); //from fvi
                    $('#FrmLotQuantity').val(devices.qty_per_box); //from matrix
                    $('#FrmOutputQuantity').val(total_qty_output); //from matrix
                    $('#FrmADrawing').val(assy_fvi_details.a_drawing_no +'-'+ assy_fvi_details.a_drawing_rev); //from fvi
                    $('#FrmGDrawing').val(assy_fvi_details.g_drawing_no +'-'+ assy_fvi_details.g_drawing_rev); //from fvi

                    $('#OQCLotAppId').val(oqc_lot_app.id);
                    $('#FrmSelectDeviceCat').val(oqc_lot_app.device_cat);
                    $('#FrmCertLot').val(oqc_lot_app.cert_lot);
                    $('#idAppliedByOperatorName').val(oqc_lot_app.user.id);
                    $('#AppliedByOperatorName').val(oqc_lot_app.user.firstname +' '+ oqc_lot_app.user.lastname);
                    $('#FrmProblem').val(oqc_lot_app_summ.problem);
                    $('#FrmDocNo').val(oqc_lot_app_summ.doc_no);
                    $('#FrmOQCRemarks').val(oqc_lot_app_summ.remarks);
                    $('#FrmPrintLotNo').val(oqc_lot_app.print_lot);

                    dtOQCLotAppSummary.draw();
                    $('#modalOQCLotApp').modal('show');
                }
            });
        });

        $(document).on('click', '.btn_update_lot', function(){
            let id = $(this).val();
            let sub_count = $(this).attr('sub_count');
            $.ajax({
                type: "get",
                url: "get_data_from_assy_fvi",
                data: {
                    "fvi_id" : id,
                    "sub_count" : sub_count,
                    "po_number" : $('#txtSelectFVIPoNumber').val()
                },
                dataType: "json",
                success: function (response){
                    let assy_fvi_details = response['assy_fvi_details'];
                    let devices = response['devices'];
                    let total_qty_output = response['total_qty_output'];

                    $('#AssyFviId').val(assy_fvi_details.id); //from fvi
                    $('#FrmCurrentPo').val(assy_fvi_details.po_no); //from fvi
                    $('#FrmPoQty').val(assy_fvi_details.po_qty); //from fvi
                    $('#FrmDeviceName').val(assy_fvi_details.device_name); //from fvi
                    $('#FrmDeviceCode').val(assy_fvi_details.device_code); //from fvi
                    $('#FrmLotNo').val(assy_fvi_details.lot_no); //from fvi
                    // $('#FrmPrintLotNo').val(assy_fvi_details.bundle_no); //from fvi
                    $('#FrmLotQuantity').val(devices.qty_per_box); //from matrix
                    $('#FrmOutputQuantity').val(total_qty_output); //from matrix
                    $('#FrmADrawing').val(assy_fvi_details.a_drawing_no +'-'+ assy_fvi_details.a_drawing_rev); //from fvi
                    $('#FrmGDrawing').val(assy_fvi_details.g_drawing_no +'-'+ assy_fvi_details.g_drawing_rev); //from fvi
                    $('#SubmissionCount').val(1);

                    // $('#FrmPrintLotNo').val(year + month + date);
                    if(assy_fvi_details.oqc_lot_app != undefined){
                        let oqc_lot_app = response['assy_fvi_details'].oqc_lot_app;
                        let oqc_lot_app_summ = response['assy_fvi_details'].oqc_lot_app.oqc_lot_app_summ[0];

                        $('#FrmPrintLotNo').val(oqc_lot_app.print_lot);

                        submission_count = (oqc_lot_app.submission * 1 + 1);
                        $('#SubmissionCount').val('');
                        $('#SubmissionCount').val(submission_count);
                        $('#OQCLotAppId').val(oqc_lot_app.id);

                        if(oqc_lot_app.guaranteed_lot == 1){ //With Guaranteed Lot

                            //Attributes
                            $('#FrmGuaranteedLotWith').prop('checked', true);
                            $('#FrmGuaranteedLotWO').prop('checked', false);
                            $('#FrmProblem').prop('required', true)
                            $('#FrmProblem').removeAttr('readonly')
                            $('#FrmDocNo').prop('required', true)
                            $('#FrmDocNo').removeAttr('readonly')

                            //Values
                            $('#FrmCertLot').val(0);
                            $('#FrmSelectDeviceCat').val(0);
                            $('#idAppliedByOperatorName').val('');
                            $('#AppliedByOperatorName').val('');
                            $('#FrmProblem').val('');
                            $('#FrmDocNo').val('');
                            $('#FrmOQCRemarks').val('');

                        }else if(oqc_lot_app.guaranteed_lot == 2){ //Without Guaranteed Lot

                            //Attributes
                            $('#FrmGuaranteedLotWith').prop('checked', false);
                            $('#FrmGuaranteedLotWO').prop('checked', true);

                            $('#FrmGuaranteedLotWith').prop('disabled', true);
                            $('#FrmGuaranteedLotWO').prop('disabled', true);

                            $('#FrmProblem').prop('required', false)
                            $('#FrmProblem').prop('readonly', true)
                            $('#FrmDocNo').prop('required', false)
                            $('#FrmDocNo').prop('readonly', true)

                            //Values
                            $('#FrmSelectDeviceCat').val(oqc_lot_app.device_cat);
                            $('#FrmCertLot').val(oqc_lot_app.cert_lot);
                            $('#idAppliedByOperatorName').val(oqc_lot_app.user.id);
                            $('#AppliedByOperatorName').val(oqc_lot_app.user.firstname +' '+ oqc_lot_app.user.lastname);
                            $('#FrmProblem').val(oqc_lot_app_summ.problem);
                            $('#FrmDocNo').val(oqc_lot_app_summ.doc_no);
                            $('#FrmOQCRemarks').val(oqc_lot_app_summ.remarks);
                        }


                        // $('#FrmPrintLotNo').val(oqc_lot_app.print_lot);

                        // submission_count = (oqc_lot_app.submission * 1 + 1);
                        // $('#SubmissionCount').val('');
                        // $('#SubmissionCount').val(submission_count);

                        // $('#OQCLotAppId').val(oqc_lot_app.id);

                        // $('#FrmCertLot').val(oqc_lot_app.device_cat);
                        // $('#FrmSelectDeviceCat').val(oqc_lot_app.cert_lot);

                        // $('#idAppliedByOperatorName').val(oqc_lot_app.user.id);
                        // $('#AppliedByOperatorName').val(oqc_lot_app.user.firstname +' '+ oqc_lot_app.user.lastname);

                        // $('#FrmProblem').val(oqc_lot_app_summ.problem);
                        // $('#FrmDocNo').val(oqc_lot_app_summ.doc_no);
                        // $('#FrmOQCRemarks').val(oqc_lot_app_summ.remarks);

                        // if(oqc_lot_app.guaranteed_lot == 1){
                        //     $('#FrmGuaranteedLotWith').prop('checked', true);

                        //     $('#FrmProblem').prop('required', true)
                        //     $('#FrmProblem').removeAttr('readonly')
                        //     $('#FrmDocNo').prop('required', true)
                        //     $('#FrmDocNo').removeAttr('readonly')

                        // }else if(oqc_lot_app.guaranteed_lot == 2){
                        //     $('#FrmGuaranteedLotWO').prop('checked', true);

                        //     $('#FrmProblem').prop('required', false)
                        //     $('#FrmProblem').prop('readonly', true)
                        //     $('#FrmDocNo').prop('required', false)
                        //     $('#FrmDocNo').prop('readonly', true)
                        // }
                    }else{
                        let year = moment().format('YY');
                            year = year.substr(1);

                        let month = moment().format('M');

                        if(month == 10){
                            month = 'X'
                        }else if(month == 11){
                            month = 'Y'
                        }else if(month == 12){
                            month = 'Z'
                        }

                        let date = moment().format('DD');
                        $('#FrmPrintLotNo').val(year + month + date);
                    }

                    dtOQCLotAppSummary.draw();

                    $('#modalOQCLotApp').modal('show');
                }
            });
        });

        $(document).on('click', '#btnSubmitLotApp', function(e){
            // let ipqc_id = $(this).attr('ipqc_data-id');
            let id = $(this).val();
            $("#cnfrmtxtId").val(id);

            // let assy_runcard_id = $(this).attr('assembly_runcard-id');
            // let assy_runcard_status = $(this).attr('assembly_runcard-status');

            // $("#cnfrmtxtStatus").val(assy_runcard_status);
            // $.ajax({
            //     type: "get",
            //     url: "get_assembly_data",
            //     data: {
            //         runcard_id: assy_runcard_id,
            //     },
            //     dataType: "json",
            //     success: function (response) {
            //         let ipqc_data = response['ipqc_data'][0];
            //         $("#cnfrmtxtId").val(ipqc_data.id);
            //         // $("#cnfrmtxtIPQCProdLot").val(ipqc_data.production_lot);
            //         $("#cnfrmtxtStatus").val(ipqc_data.status);
            //         // $("#cnfrmtxtIPQCProcessCat").val(ipqc_data.process_category);
            //     }
            // });
            $("#modalConfirmSubmit").modal('show');
        });

        $("#FrmConfirmSubmit").submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: "update_lot_app_status",
                method: "post",
                data: $('#FrmConfirmSubmit').serialize(),
                dataType: "json",
                success: function (response) {
                    let result = response['result'];
                    if (result == 'Successful') {
                        dtOQCLotApp.draw();
                        toastr.success('Successful!');
                        $("#modalConfirmSubmit").modal('hide');
                    }else{
                        toastr.error('Error!, Please Contanct ISS Local 208');
                    }
                }
            });
        });

        $('#FrmGuaranteedLotWith').click(function (e){
            // e.preventDefault();
            // $(this).prop('checked', true);
            // $('#FrmGuaranteedLotWO').prop('checked', false);
            $('#FrmProblem').prop('required', true)
            $('#FrmProblem').removeAttr('readonly')
            $('#FrmDocNo').prop('required', true)
            $('#FrmDocNo').removeAttr('readonly')
        });

        $('#FrmGuaranteedLotWO').click(function (e) {
            // e.preventDefault();
            // $(this).prop('checked', true);
            // $('#FrmGuaranteedLotWith').prop('checked', false);
            $('#FrmProblem').prop('required', false)
            $('#FrmProblem').prop('readonly', true)
            $('#FrmDocNo').prop('required', false)
            $('#FrmDocNo').prop('readonly', true)

            $('#FrmProblem').val('');
            $('#FrmDocNo').val('');
        });

        $('#btnPopLastOperator').click(function(){
            $('#AppliedByOperatorName').val('');
        });

        $(document).on('keyup','#txtScanUserId', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val(), [0, 1, 4], function(result){
                    if(result == 1){
                        GetUserName($('#txtScanUserId').val());
                    }else{ // Error Handler
                        toastr.error('User not authorize!');
                        $('#txtScanUserId').val('');
                    }
                });
            }
        });

        function GetUserName(UserId){
            $.ajax({
                type: "get",
                url: "get_user_name",
                data: {
                    "user_id": UserId,
                },
                dataType: "json",
                success: function (response) {
                    // console.log('gagaga');
                    $('#AppliedByOperatorName').val(response['user'].firstname+' '+response['user'].lastname);
                    $('#idAppliedByOperatorName').val(response['user'].id);
                    $('#txtScanUserId').val('');
                    $('#modalScanQRSave').modal('hide');
                }
            });
        }

        // TODO
        // VALIDATE QR SCANNING BUKAS

        $('#formOQCLotApp').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "add_oqc_lot_app",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response['result'] == 1 ) {
                        toastr.success('Successful!');
                        $('#modalOQCLotApp').modal('hide');
                    }else if(response['result'] == 2){
                        toastr.error('Lot Application Rejected!');
                        $('#modalOQCLotApp').modal('hide');
                    }else if(response['validation'] == 'hasError'){
                        toastr.error('Applied By is Required!');
                    }
                    dtOQCLotApp.draw();
                }
            });
        });

        const dtOQCLotApp = $("#tblAssyOQCLotApp").DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url: "view_assy_oqc_lot_app",
                data: function (param){
                    param.po_no       = $("#txtSelectFVIPoNumber").val();
                    param.device_name = $("#txtSearchDeviceName").val();
                },
            },
            fixedHeader: true,
            "columns":[
                { "data" : "action", orderable:false, searchable:false },
                { "data" : "status_raw" },
                { "data" : "lot_no" },
                // { "data" : "sub_lot_raw" },
                { "data" : "submission_raw" },
                { "data" : "lot_qty" },
                { "data" : "output_qty_raw" },
                { "data" : "lot_applied_by" },
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": "_all"},
                {
                    "targets": [2],
                    "data": null,
                    "defaultContent": "---"
                },
            ],
        });

        const dtOQCLotAppSummary = $("#tblLotAppSummary").DataTable({
            "processing"  : false,
            "serverSide"  : true,
            "ajax"        : {
                url: "view_assy_oqc_lot_app_summary",
                data: function (param){
                    param.assy_fvi_id = $("#AssyFviId").val();
                }
            },
            "columns":[
                { "data" : "sub_raw" },
                { "data" : "guar_lot_raw" },
                { "data" : "problem" },
                { "data" : "doc_no" },
                { "data" : "app_date_raw" },
                // { "data" : "app_time_raw" },
                { "data" : "fvo_raw" },
                { "data" : "remarks" }
            ],

            order:[[0,'asc']]
        }); //end of dataTable

        $('#btnSearchInspector').on('click', function(e){
            e.preventDefault();
            // $('#modalScanQRSave').modal('show');
            $('#modalScanQRSave').on('shown.bs.modal', function () {
                $('#txtScanUserId').focus();
                const modalScanQRSave = document.querySelector("#modalScanQRSave");
                const inptQrCode = document.querySelector("#txtScanUserId");
                let focus = false;

                modalScanQRSave.addEventListener("mouseover", () => {
                    if (inptQrCode === document.activeElement) {
                        focus = true;
                    } else {
                        focus = false;
                    }
                });

                modalScanQRSave.addEventListener("click", () => {
                    if (focus) {
                        inptQrCode.focus()
                    }
                });
            });
        });

        // $('#txtScanQrCode').on('keypress', function(e){
        //     if(e.keyCode == 13){
        //         const ScanQrCode = $('#txtScanQrCode').val();
        //         try {
        //             let ScanQrCodeVal = JSON.parse(ScanQrCode)
        //                 getPoNum =  ScanQrCodeVal.po
        //                 $.ajax({
        //                     type: "get",
        //                     url: "get_data_from_assy_fvi",
        //                     data: {
        //                         "po_number" : getPoNum
        //                     },
        //                     dataType: "json",
        //                     success: function (response) {
        //                         let assy_fvi_details = response['assy_fvi_details'];
        //                         if(assy_fvi_details == '' || assy_fvi_details == undefined){
        //                             toastr.error('PO does not exists')
        //                             $('#txtScanQrCode').val('');
        //                         }else{
        //                             $('#txtSearchPONum').val(assy_fvi_details[0]['po_no']);
        //                             $('#txtSearchDeviceName').val(assy_fvi_details[0]['device_name']);
        //                             $('#txtSearchDeviceCode').val(assy_fvi_details[0]['device_code']);
        //                             $('#txtSearchPoQty').val(assy_fvi_details[0]['po_qty']);
        //                             $('#txtScanQrCode').val('');
        //                             $('#mdlScanQrCode').modal('hide');
        //                             dtOQCLotApp.draw();
        //                         }
        //                     }
        //                 });
        //         }catch (error) {
        //             toastr.error('Please Scan QR Code')
        //             $('#txtScanQrCode').val('');
        //         }
        //     }
        // });

        //- Print OQC lot Application
        $(document).on('click', '.btn_print_lotapp', function(){
            let id = $(this).val();
            let data = {
                "fvi_id" : id,
                "device_name" : $('#txtSearchDeviceName').val(),
            }

            data = $.param(data);
            $.ajax({
                data        : data,
                type        : 'get',
                dataType    : 'json',
                url         : "gen_oqclotapp_qrsticker",
                success     : function (data) {
                    $("#img_barcode_PONum").attr('src', data['po_qrcode']);
                    imgResulOQCPOCode   = data['po_qrcode'];
                    img_barcode_details = data['lbl'];
                    img_barcode_details2 = data['lbl2'];
                    $("#img_barcode_details").html(data['lbl']);
                    $("#modal_OQCLotApp_QRcode").modal('show');
                }, error : function (data) {
                    alert('ERROR: '+data);
                }
            });
        });

        let img_barcode_PO_text_hidden;
        $(document).on('click', '.btn_print_lotapp_inner_box', function(){
            let id = $(this).val();
            let data = {
                "fvi_id" : id,
                "device_name" : $('#txtSearchDeviceName').val(),
            }
            data = $.param(data);
            $.ajax({
                data        : data,
                type        : 'get',
                dataType    : 'json',
                url         : "gen_oqclotapp_inner_box_qrsticker",
                success     : function (data) {
                    $("#img_barcode_PO").attr('src', data['QrCode']);
                    $("#img_barcode_PO_text").html(data['label']);
                    // $("#img_barcode_PO_text_hidden").html(data['label_hidden']);
                        img_barcode_PO_text_hidden = data['label_hidden']
                    $("#modal_LotApp_InnerBox_QRcode").modal('show');
                }, error    : function (data) {
                    alert('ERROR: '+data);
                }
            });
        });

        $("#btn_print_lot_app_barcode").click(function(){
            popup = window.open();
            let content = '';

            content += '<html>';
            content += '<head>';
            content += '<title></title>';
            content += '<style type="text/css">';

            content += '@media print { .pagebreak { page-break-before: always; } }';

            content += '.rotated {';
            content += 'width: 290px;';
            content += '}';

            content += '</style>';
            content += '</head>';
            content += '<body>';

            content += '<table style="margin-top: 15px;>';
            content += '<tr style="width: 288px;">';
                content += '<td>';
                content += '<img src="' + imgResulOQCPOCode + '" style="min-width: 60px; max-width: 60px;">';
                content += '</td>';
                content += '<td style="font-size: 9px; font-family: Calibri;">'+img_barcode_details2+'</td>';
            content += '</tr>';
            content += '</table>';

            content += '</body>';
            content += '</html>';
            popup.document.write(content);

            popup.focus(); //required for IE
            popup.print();
            popup.close();
        });

        $("#btn_print_inner_box_barcode").click(function(){
            popup = window.open();
            let content = '';

            content += '<html>';
            content += '<head>';
            content += '<title></title>';
            content += '<style type="text/css">';

            content += '@media print { .pagebreak { page-break-before: always; } }';

            content += '.rotated {';
            content += 'width: 290px;';
            content += '}';
            content += '</style>';
            content += '</head>';
            content += '<body>';

            for (var i = 0; i < img_barcode_PO_text_hidden.length; i++) {
            content += '<table style="margin-left: -5px;>';
            content += '<tr style="width: 288px;">';
                content += '<td style="vertical-align: bottom;">';
                content += '<img src="' + img_barcode_PO_text_hidden[i]['img'] + '" style="min-width: 60px; max-width: 60px;">';
                content += '</td>';
                content += '<td style="font-size: 8.5px; font-family: Calibri;">' + img_barcode_PO_text_hidden[i]['text'] + '</td>';
            content += '</tr>';
            content += '</table>';
            content += '<br>';
            if( i < img_barcode_PO_text_hidden.length-1 )
                content += '<div class="pagebreak"> </div>';
            // content += '</div>';
            }

            content += '</body>';
            content += '</html>';
            popup.document.write(content);

            popup.focus(); //required for IE
            popup.print();
            popup.close();
        });
    });
</script>
@endsection
@endauth

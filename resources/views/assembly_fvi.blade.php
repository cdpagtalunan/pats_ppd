@php $layout = 'layouts.admin_layout'; @endphp

@auth
@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
    <style>
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

        table#tblFVIRuncards thead th{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
                font-size: .85rem;
                padding: .0em 0.55vmax;
                margin-bottom: 0px;
            }

            .select2-container--bootstrap-5 .select2-selection--multiple{
                pointer-events: none;
            }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Visual Inspection</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Visual Inspection</li>
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
                                    <div class="col-sm-3">
                                        <label>PO Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-primary" id="btnSearchPO"
                                                    title="Click to Scan PO Code"><i
                                                        class="fa fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="form-control" id="txtSearchPO" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Device Name</label>
                                        <input type="text" class="form-control" id="txtDeviceName" name=""
                                            readonly="">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Device Code</label>
                                        <input type="text" class="form-control" id="txtDeviceCode"
                                            readonly="">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>PO Qty</label>
                                        <input type="text" class="form-control" id="txtPoQty" readonly="">
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
                                <h3 class="card-title">2. Document Reference Check / Visual Inspection</h3>
                                <button class="btn btn-primary btn-sm" style="float: right;" id="btnAddFVI"><i class="fa fa-plus"></i> Add Visual Inspection</button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover w-100" id="tblVisualInspection">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Lot #</th>
                                                <th>Total Lot Qty</th>
                                                <th>FVI - Total NG</th>
                                                <th>Remarks</th>
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


    <div class="modal fade" id="modalFVI" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true" data-bs-backdrop="static" style="overflow-y: auto;">
        <div class="modal-dialog modal-xl modal-xl-custom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-info-circle text-info"></i> Visual Inspection Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 border px-4">
                            <form id="formEditFVIDetails">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="txtHiddenFviId" name="fvi_id">
                                    <div class="col pt-3">
                                        <span class="badge badge-secondary">1.</span> Visual Inspection Details
                                        <button type="button" id="btnEditFviDetails" class="btn btn-sm btn-link float-right"><i class="fa fa-edit"></i> Edit</button>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO #</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIPoNum" name="txt_po_number" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Qty</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtFVIPoQTy"
                                                    readonly name="txt_po_qty">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <br> -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device
                                                        Name</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIDevName" readonly name="txt_use_for_device">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device
                                                        Code</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIDevCode" name="txt_device_code" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lot
                                                        No.</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtFVILotNo"
                                                    name="txt_lot_no" placeholder="Auto generated" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Bundle No.</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtFVIBundleNo"
                                                    name="txt_bundle_no" placeholder="Auto generated" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100"
                                                        id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control form-control-sm" id="txtFVIRemarks"
                                                    name="txt_remarks" rows="5" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100">Assembly Line</span>
                                                </div>
                                                <select class="form-control select2 select2bs4 sel-assembly-lines"
                                                    id="selFVIAssLine" name="sel_assembly_line" disabled>
                                                    <option value=""> N/A </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row_container">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <button style="width:30px" type="button"
                                                        class="btn btn-sm py-0 btn-info table-btns btnViewDocuments"
                                                        id="btnViewADrawing" data-input-id="selADrawing">
                                                        <i class="fa fa-file" title="View"></i>
                                                    </button>
                                                    <span class="input-group-text w-100">A Drawing</span>
                                                </div>
                                                {{-- <input type="text" class="form-control" id="txtADrawingNo"
                                                    name="txt_Adrawing_no" readonly=""> --}}
                                                    <select class="form-control" name="a_drawing" id="selADrawing">
                                                        
                                                    </select>
                                                <input type="text" value="N/A" class="form-control form-control-sm"
                                                    id="txtARevNo" name="a_revision" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row_container">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <button style="width:30px" type="button"
                                                        class="btn btn-sm py-0 btn-info table-btns btnViewDocuments"
                                                        id="btnViewGDrawing" data-input-id="selGDrawing">
                                                        <i class="fa fa-file" title="View"></i>
                                                    </button>
                                                    <span class="input-group-text w-100">G Drawing</span>
                                                </div>
                                                {{-- <input type="text" class="form-control" id="txtGDrawingNo"
                                                    name="txt_Gdrawing_no" readonly=""> --}}
                                                    <select class="form-control" name="g_drawing" id="selGDrawing">

                                                    </select>
                                                <input type="text" value="N/A" class="form-control form-control-sm"
                                                    id="txtGRevNo" name="g_revision" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Created
                                                        At</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVICreatedAt" name="txt_created_at" readonly="true"
                                                    placeholder="Auto generated">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100">Application Date/Time</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIAppDT" name="application_datetime"
                                                    readonly="true" placeholder="Auto generated">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-none mb-3" id="divBtnVisualDetails">
                                        <div class="col text-right">
                                            <button type="button" class="btn btn-sm btn-success" id="btnSaveVisualDetails">Save</button>
                                            <button type="button" class="btn btn-sm btn-secondary" id="btnCancelVisualDetails">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col border py-3 px-4 border-left-0 border-bottom-0">
                                    <div class="mb-3">
                                        <span class="badge badge-secondary">2.</span> Runcards
                                        <button class="btn btn-primary btn-sm float-right" id="btnAddFVIRuncard" disabled><i class="fa fa-plus" ></i> Add Runcard</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm small table-bordered table-hover" id="tblFVIRuncards" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Runcard #</th>
                                                    <th>Date Time</th>
                                                    <th>Operator Name</th>
                                                    <th>Input</th>
                                                    <th>Output</th>
                                                    <th>NG QTY</th>
                                                    <th>Runcard MOD</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="border-top: 1px solid #dee2e6"></th>
                                                    <th style="border-top: 1px solid #dee2e6"></th>
                                                    <th style="border-top: 1px solid #dee2e6">Total Count:</th>
                                                    <th style="border-top: 1px solid #dee2e6;" title="Total Input Quantity" class="text-primary text-center"></th>
                                                    <th style="border-top: 1px solid #dee2e6;" title="Total Output Quantity" class="text-success text-center"></th>
                                                    <th style="border-top: 1px solid #dee2e6" title="Total NG Quantity" class="text-danger text-center"></th>
                                                    <th style="border-top: 1px solid #dee2e6" ></th>
                                                    <th style="border-top: 1px solid #dee2e6"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" id="btnSubmitToLotApp">Submit to OQC Lot App</button>
                    <button type="button" class="btn btn-default btn-sm" data-bs-dismiss="modal" aria-label="Close">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFVIRuncard" tabindex="-1" role="dialog"
        aria-labelledby="cnptsmodal" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <br> -->
                    <!-- <h5 class="modal-title h5OIHeaderTitle">Overall Inspection - <span>0</span> Selected Runcards</h5> -->
                </div>
                <form id="formFVIRuncard">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" id="txtRuncardId" name="runcard_id">
                                <input type="hidden" id="txtRuncardStationId" name="runcard_station_id">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Process</span>
                                    </div>
                                    <input type="text" name="process_name" class="form-control form-control-sm"
                                        id="txtRuncardProcess" readonly value="Final Visual">
                                </div>
                                <div class="row" style="display: block;">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Runcard</span>
                                            </div>

                                            <input class="form-control" id="txtRuncardNumber" readonly>

                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code"
                                                    id="btnScanQrRuncardNumber"><i class="fa fa-qrcode"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                            </div>
                                            <input type="date" class="form-control form-control-sm" id="txtRuncardDate"
                                                name="date" readonly value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display: block;">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Operator
                                                    Name</span>
                                            </div>
                                            {{-- <select class="form-control selectUser select2"
                                                id="sel_edit_prod_runcard_terminal_area" name="terminal_area" readonly>
                                                <option value=""> N/A </option>
                                            </select> --}}
                                            <input type="text" class="form-control form-control-sm" id="txtRuncardOperatorName"
                                                name="operator_name" readonly>
                                            <!-- <div class="input-group-append">
                                          <button class="btn btn-info" type="button" title="Scan code" id="btn_scan_add_runcard_operator_code"><i class="fa fa-qrcode"></i></button>
                                        </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txtRuncardInput" name="qty_input" readonly
                                                required min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txtRuncardOutput" name="qty_output" readonly
                                                required min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txtRuncardNg" name="qty_ng" min="0" value="0"
                                                readonly="true" required>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Type of NG</span>
                                            </div>
                                            <!-- <input type="number" class="form-control form-control-sm" id="txt_edit_prod_runcard_station_ng" name="qty_ng" min="0" value="0" readonly="true" required> -->
                                            <select class="form-control" id="selEdit_type_of_ng" name="type_of_ng">
                                                <option value="0">_</option>
                                                <option value="1">Rework</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                            </div>
                                            <textarea class="form-control form-control-sm" id="txtRuncardRemarks"
                                                name="remarks" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <div style="float: left;">
                                        <label>Total No. of NG: <span id="pRCStatTotNoOfNG"
                                                style="color: green;">0</span></label>
                                    </div>
                                    {{-- <div style="float: right;">
                                        <button type="button" id="btnAddMODTable" class="btn btn-xs btn-info"
                                            title="Add MOD"><i class="fa fa-plus"></i> Add MOD</button>
                                    </div> --}}
                                    <br><br>
                                    <table class="table table-sm small table-bordered table-hover w-100" id="tblRunStaMOD">
                                        <thead>
                                            <tr>
                                                <th style="width: 70%;">MOD</th>
                                                <th style="width: 20%;">QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <tr>
                                          <td>
                                            <select class="form-control select2 select2bs4 selectMOD" id="selEditProdRunMod" name="mod[]">
                                              <option value="">N/A</option>
                                            </select>
                                          </td>
                                          <td>
                                            <input type="number" class="form-control txtEditProdRunStaMODQty" name="mod_qty[]">
                                          </td>
                                          <td></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button type="button" class="btn btn-success" id="btnSaveRuncardDetails">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalScanning" tabindex="-1" role="dialog"  data-form-function="" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-top" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body pt-0">
                    <input type="text" class="w-100 hidden_scanner_input" id="txtScannedItem" name="" autocomplete="off">
                    {{-- <input type="text" class="w-100" id="txtScannedItem" name="" autocomplete="off"> --}}
                    {{-- <input type="text" class="w-100" id="txtScannedItem" name="" autocomplete="off" value='{"po_number":"450238368400010","po_quantity":"500","device_name":"CN171S-007-1002-VE(01)","part_code":"107976201","runcard_no":"83684-3","shipment_output":"10","insp_name":"Michael Legaspi"}'> --}}
                    <div class="text-center text-secondary">
                        <span id="modalTitle">Please scan operator ID.</span>
                        <br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js_content')
<script>
    var dtVisualInspection;
    var dtFVIRuncards;
    let dtRuncardStationMod;
    let runcardModList = [];
    var checked_draw_count = [];
    let outputQty = 0;
    var token = "{{ csrf_token() }}";
    var scanningFunction = "";

    $(document).ready(function(){

        getAssemblyLine();

        

        dtVisualInspection = $("#tblVisualInspection").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_visual_inspection",
                data: function (param) {
                    param.po = $("#txtSearchPO").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { data: "action", orderable:false, searchable:false },
                { data: "lot_status" },
                { data: "lot_no" },
                { data: "ttlLotQty" },
                { data: "ttlLotQty" },
                { data: "remarks" }
            ],
            "columnDefs": [
                {
                    "targets": [3,4],
                    "data": null,
                    "defaultContent": "---"
                },
            ],
            "rowCallback": function(row,data,index ){
                let json = jQuery.parseJSON( data['ttlLotQty'] )
                console.log('data',typeof json);
                console.log('json', json[0]);
                $("td:eq(3)",row).html(json[0]['ttl_output']);
                $("td:eq(4)",row).html(json[0]['ttl_ng']);
            },
        }); //end of dataTableDevices

        dtFVIRuncards = $("#tblFVIRuncards").DataTable({
            "processing": true,
            "serverSide": true,
            "paging": false,
            "ajax": {
                url: "view_fvi_runcards",
                data: function (param) {
                    param.fvi_id = $("#txtHiddenFviId").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { data: "fk_runcard_runcard_no"},
                { data: "created_at" },
                { data: "operator_name" },
                { data: "fk_runcard_station_input_quantity" },
                { data: "fk_runcard_station_output_quantity" },
                { data: "fk_runcard_station_ng_quantity" },
                { data: "mods" },
                { data: "remarks" }
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0,1,2,3,4,5]},
            ],
            'drawCallback': function( settings ) {
                let dtApi = this.api();
                let dtDatas = dtApi.rows( {page:'current'} ).data();
                let totalNGQty = 0;
                let totalOutput = 0;
                let totalInput = 0;
                if(dtDatas.length>0){
                    for(let x = 0; x < dtDatas.length; x++){
                        let ngQty = dtDatas[x]['fk_runcard_station_ng_quantity'];
                        let input = dtDatas[x]['fk_runcard_station_input_quantity'];
                        let output = dtDatas[x]['fk_runcard_station_output_quantity'];
                        totalNGQty = Number(totalNGQty) + Number(ngQty)
                        totalOutput = Number(totalOutput) + Number(output)
                        totalInput = Number(totalInput) + Number(input)
                    }
                    console.log('totalNGQty', totalNGQty);
                    console.log('totalOutput', totalOutput);

                  
                }
                $(dtApi.column(3).footer()).html(`${totalInput}`)
                $(dtApi.column(4).footer()).html(`${totalOutput}`)
                $(dtApi.column(5).footer()).html(`${totalNGQty}`)
                // else{
                //     $(dtApi.column(3).footer()).html(`${totalInput}`)
                //     $(dtApi.column(4).footer()).html(`${totalOutput}`)
                //     $(dtApi.column(5).footer()).html(`${totalNGQty}`)
                // }

                outputQty = totalOutput;

            }
        }); //end of dataTableDevices

		dtRuncardStationMod = $('#tblRunStaMOD').DataTable({
			"ordering": false,
            "paging": false,
			"columns": [
				{ "data": "mod" },
				{ "data": "qty" },
			],
		});

        

        $('#btnAddFVI').on('click', function(){
            if(
                $('#txtSearchPO').val() == "" ||
                $('#txtPoQty').val() == "" ||
                $('#txtDeviceCode').val() == "" ||
                $('#txtDeviceName').val() == ""
            ){
                toastr.error('Please Scan PO Number!');
                return;
            }
            $('#txtFVIPoNum').val($('#txtSearchPO').val());
            $('#txtFVIPoQTy').val($('#txtPoQty').val());
            $('#txtFVIDevCode').val($('#txtDeviceCode').val());
            $('#txtFVIDevName').val($('#txtDeviceName').val());

            getDocumentRequirement($('#txtDeviceName').val());
            // getAssemblyLine();
            $('#modalFVI').modal('show');
            
        });

        $('#btnAddFVIRuncard').on('click', function(e){
            e.preventDefault();
            validateRuncardOutput($('#txtFVIDevName').val(), $('#txtFVIDevCode').val(), "btnAdd");
            // $('#modalFVIRuncard').modal('show');
        });

        $('#btnSearchPO').on('click', function(){
            $('#modalScanning').modal('show');
            $('#modalScanning').attr('data-form-function', "searchPO");
            $('#modalTitle').html("Please Scan PO Number");
        });

        $('#modalScanning').on('shown.bs.modal', function () {
            $('#txtScannedItem').focus();
        });

        $('#btnEditFviDetails').on('click', function(e){
            e.preventDefault();
            $('#txtFVIRemarks').prop('readonly', false);
            $('#selFVIAssLine').prop('disabled', false);
            $('#divBtnVisualDetails').removeClass('d-none');
        });

        $('#btnCancelVisualDetails').on('click', function(e){
            e.preventDefault();
            $('#txtFVIRemarks').prop('readonly', true);
            $('#selFVIAssLine').prop('disabled', true);
            $('#divBtnVisualDetails').addClass('d-none');
        });

        checkDrawing();
        function checkDrawing(){
            $('.btnViewDocuments').each(function(e){
                checked_draw_count[$(this).data('inputId')] = false;
            });
            console.log(checked_draw_count);
        }

        $('.btnViewDocuments').on('click', function(e){
            e.preventDefault();
            let inputId = $(this).data('inputId');
            let selVal = $(`#${inputId}`).val();

            console.log('inputId', inputId);
            console.log('inputVal', selVal);

            redirect_to_req_drawing( inputId, selVal );
        });

        $('#btnSaveVisualDetails').on('click', function(e){
            e.preventDefault();
            let dataProceed = false;
            $('.btnViewDocuments').each(function(e){
                $(this).data('inputId');

                console.log(checked_draw_count[$(this).data('inputId')]);
                if(checked_draw_count[$(this).data('inputId')] == false){
                    alert('Please check all drawings first.')
                    return false;
                }
                else{
                    dataProceed = true;
                }

            });
            if(dataProceed){
                saveVisualDetails($('#formEditFVIDetails'));
            }
        });

        $('#btnScanQrRuncardNumber').on('click', function(e){
            e.preventDefault();
            $('#modalScanning').modal('show');
            $('#modalScanning').attr('data-form-function', "scanRuncard");
            $('#modalTitle').html("Please Scan Runcard");
            runcardModList = [];
			dtRuncardStationMod.clear().draw();

        });

        $('#btnSaveRuncardDetails').on('click', function(e){
            e.preventDefault();
            validateRuncardOutput($('#txtFVIDevName').val(), $('#txtFVIDevCode').val(), "btnSaveRuncard");

            // saveRuncard($('#formFVIRuncard'));
        });

        $(document).on('click', '.btnViewFvi', function(e){
            let fviId = $(this).data('id');
            let fviStatus = $(this).data('status');

            getFviDetailsById(fviId, fviStatus);
        });


        $("#modalFVI").on('hidden.bs.modal', function () {
            console.log('hidden.bs.modal modalFVI');
            $('#formEditFVIDetails')[0].reset();
            $('#txtHiddenFviId').val('')
            $('#txtFVIRemarks').prop('readonly', true);
            $('#selFVIAssLine').prop('disabled', true);
            $('#btnEditFviDetails').prop('disabled', false);
            $('#btnAddFVIRuncard').prop('disabled', true);
            $('#divBtnVisualDetails').addClass('d-none');
            $('textarea', $('#formEditFVIDetails')).removeClass('is-invalid')
            $('select', $('#formEditFVIDetails')).removeClass('is-invalid')
            dtFVIRuncards.draw();
        });
        $("#modalFVIRuncard").on('hidden.bs.modal', function () {
            console.log('hidden.bs.modal modalFVIRuncard');
            $('#formFVIRuncard')[0].reset();
            $('#txtRuncardId').val('')
            $('#txtRuncardStationId').val('')
            runcardModList = [];
			dtRuncardStationMod.clear().draw();
            
        });

        $('#btnSubmitToLotApp').on('click', function(e){
            e.preventDefault();
            validateRuncardOutput($('#txtFVIDevName').val(), $('#txtFVIDevCode').val(), "btnSubmitToLotApp");
        });
    });

    //   $('#txtScannedItem').on('keyup', function (e) {
    $(document).on('keyup', '#txtScannedItem', function (e) {
        if (e.keyCode == 13) {
            $('#txtScannedItem').prop('disabled', true);
            let modalVal = $('#modalScanning').attr('data-form-function');
            console.log(modalVal);
            if (modalVal == "searchPO") {
                try {
                    scannedItem = JSON.parse($('#txtScannedItem').val());
                    console.log(scannedItem);
                    loadSearchPo(scannedItem['po_number']);
                    // $('#txtSearchPO').val(scannedItem['po_number'])
                    // $('#txtDeviceName').val(scannedItem['device_name'])
                    // $('#txtDeviceCode').val(scannedItem['part_code'])
                    // $('#txtPoQty').val(scannedItem['po_quantity'])

                    // dtVisualInspection.draw();
                    $('#modalScanning').modal('hide');
                } catch (e) {
                    toastr.error('Invalid Sticker');
                }
            } 
            else if (modalVal == "scanRuncard") {
                try {
                    scannedItem = JSON.parse($('#txtScannedItem').val());
                    loadRuncardInfo(scannedItem);
                } catch (e) {
                    toastr.error('Invalid Sticker');
                }
            }
            $('#txtScannedItem').prop('disabled', false);
            $('#txtScannedItem').val('');
        }
    });

    $(document).on('keyup', '#txtScanUserId', function(e){
        if(e.keyCode == 13){

            if(scanningFunction == "partialSupervisor"){
                validateUser($('#txtScanUserId').val().toUpperCase(), [0,2], function(result){
                    if(result == true){
                        $('#modalScanQRSave').modal('hide');
                        SubmitToLotApp($('#txtScanUserId').val().toUpperCase());
                        scanningFunction = "";
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                        console.log('scanning please use QC Supervisor Only');
                    }

                });

            }
            else{
                validateUser($('#txtScanUserId').val().toUpperCase(), [0,2,5], function(result){
                    if(result == true){
                        $('#modalScanQRSave').modal('hide');
                        SubmitToLotApp($('#txtScanUserId').val().toUpperCase());
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }

                });

            }
           
            setTimeout(() => {
                $('#txtScanUserId').val('');
            }, 500);
        }
    });

    
</script>
@if (in_array(Auth::user()->position, [0,2]) || in_array(Auth::user()->user_level_id, [1,2]))
<script>
    $('#txtSearchPO').prop('readonly', false);
    $('#txtSearchPO').on('keyup', function(e){
        if(e.keyCode == 13){
            loadSearchPo($(this).val());
        }
    });
</script>
@endif
@endsection
@endauth

@php $layout = 'layouts.admin_layout'; @endphp
{{-- @auth
  @php
    if(Auth::user()->user_level_id == 1){
      $layout = 'layouts.super_user_layout';
    }
    else if(Auth::user()->user_level_id == 2){
      $layout = 'layouts.admin_layout';
    }
    else if(Auth::user()->user_level_id == 3){
      $layout = 'layouts.user_layout';
    }
  @endphp
@endauth --}}

@auth
    @extends($layout)

    @section('title', 'Second Stamping')

    @section('content_page')

        <style type="text/css">
            .hidden_scanner_input{
                position: absolute;
                opacity: 0;
            }
            textarea{
                resize: none;
            }

            #colDevice, #colMaterialProcess{
                transition: .5s;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Stamping</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">Production</li>
                                <li class="breadcrumb-item active">Second Stamping</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Number</label>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalScanPO"><i class="fa-solid fa-qrcode"></i></button>
                                                {{-- <input type="text" class="form-control" placeholder="PO Number" id="txtSearchPONum" value="450244133600010"> --}}
                                                <input type="search" class="form-control" placeholder="PO Number" id="txtSearchPONum" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Code" id="txtSearchMatCode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Quantity" id="txtSearchPO" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Production</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        {{-- @if(Auth::user()->user_level_id == 1)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @else
                                        @if(Auth::user()->position == 7 || Auth::user()->position == 8)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @endif
                                        @endif --}}

                                        <button class="btn btn-dark" id="btnAddProdData">
                                            <i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblProdSecondStamp" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 14%">Action</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>Production Lot No.</th>
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
                                                    <th>Shipment Output</th>
                                                    <th>Material Lot #</th>
                                                    <th>Overall Yield</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- !-- End Page Content -->

                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- MODALS -->
        {{-- * ADD --}}
        <div class="modal fade" id="modalProdSecondStamp" data-bs-backdrop="static">
            <div class="modal-dialog modal-sm-xl" style="min-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Production Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="stamp_cat" id="txtStampCat2" value="2">

                    <form method="post" id="formProdDataSecondStamp" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="txtProdDataId" name="id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <input type="hidden" name="ctrl_counter" id="txtCtrlCounter">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="radioIQC" value="0" disabled>
                                                <label class="form-check-label" for="radioIQC">For IPQC</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="radioMassProd" value="1" disabled>
                                                <label class="form-check-label" for="radioMassProd">For Mass Production</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="radioResetup" value="2" disabled>
                                                <label class="form-check-label" for="radioResetup">For Re-Setup</label>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">PO Number:</label>
                                                <input type="text" class="form-control form-control-sm" name="po_num" id="txtPoNumber" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">PO Quantity:</label>
                                                <input type="text" class="form-control form-control-sm" name="po_qty" id="txtPoQty" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Part Code:</label>
                                                <input type="text" class="form-control form-control-sm" name="part_code" id="txtPartCode" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Material Name:</label>
                                                <input type="text" class="form-control form-control-sm" name="mat_name" id="txtMatName" readonly>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="form-label">Material Lot No.:</label>
                                                <input type="text" class="form-control form-control-sm" name="mat_lot_no" id="txtMatLotNo">
                                            </div> --}}
                                            <div class="form-group">
                                                <label class="form-label">Drawing No.:</label>
                                                <input type="text" class="form-control form-control-sm" name="drawing_no" id="txtDrawingNo" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Drawing Revision:</label>
                                                <input type="text" class="form-control form-control-sm" name="drawing_rev" id="txtDrawingRev" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Operator Name:</label>
                                                <select name="opt_name[]" id="selOperator" class="form-control select2bs4 selOpName" disabled multiple>
                                                </select>
                                                <button class="btn btn-primary btn-sm w-100" type="button" id="btnScanOperator" title="Scan Operator Name">
                                                    <i class="fa-solid fa-qrcode"></i>
                                                </button>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Shift:</label>
                                                <input type="text" class="form-control form-control-sm" name="opt_shift" id="txtOptShift" readonly>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-group d-md-inline-flex">
                                                <div class="form-check form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tray" id="radioTrayWithout" value="0" checked>
                                                    <label class="form-check-label" for="radioTrayWithout">w/o Tray</label>
                                                </div>
                                                <div class="form-check form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="tray" id="radioTrayWith" value="1">
                                                    <label class="form-check-label" for="radioTrayWith">w/ Tray</label>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm" name="no_tray" id="txtNoTray" placeholder="No. of Tray" readonly>
                                                </div>
                                            </div>

                                            <label class="form-label">Material Lot No.:</label>
                                            <div class="input-group mb-1">
                                                <input type="text" class="form-control form-control-sm matNo" aria-describedby="button-addon2" name="material_no" id="txtMaterialLot" readonly required>
                                                <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Input Pins:</label>
                                                <input type="number" class="form-control form-control-sm" name="inpt_pins" id="txtInptPins" readonly>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="form-label">Actual Quantity:</label>
                                                <input type="number" class="form-control form-control-sm" name="act_qty" id="txtActQty">
                                            </div> --}}
                                            <div class="form-group">
                                                <label class="form-label">Target Output</label>
                                                {{-- <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Input Coil Weight / 0.005)"></i> --}}

                                                <input type="number" class="form-control form-control-sm" name="target_output" id="txtTargetOutput">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Planned Loss (10%) (Pins):</label>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(PPC Target Output * 0.1)"></i>
                                                <input type="number" class="form-control form-control-sm" placeholder="Auto Compute" name="planned_loss" id="txtPlannedLoss" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Set-up Pins:</label>
                                                <input type="number" class="form-control form-control-sm" name="setup_pins" id="txtSetupPin">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Adjustment Pins:</label>
                                                <input type="number" class="form-control form-control-sm" name="adj_pins" id="txtAdjPin">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">QC Samples:</label>
                                                <input type="number" class="form-control form-control-sm" name="qc_samp" id="txtQcSamp">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Prod. Samples:</label>
                                                <input type="number" class="form-control form-control-sm" name="prod_samp" id="txtProdSamp">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">NG Count:</label>
                                                <input type="number" class="form-control form-control-sm" name="ng_count" id="txtNGCount">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Production Date:</label>
                                                <input type="date" class="form-control form-control-sm" name="prod_date" id="txtProdDate">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Total Machine Output:</label>
                                                <input type="number" class="form-control form-control-sm" name="ttl_mach_output" id="txtTtlMachOutput">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Shipment Output:</label>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Total Machine Output - Set-up Pins + Adjustment Pins + QC Samples + Prod. Samples + NG Count)"></i>
                                                <input type="number" class="form-control form-control-sm" placeholder="Auto Compute" name="ship_output" id="txtShipOutput" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Material Yield:</label>
                                                {{-- <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="This data is from OQC Inspection"></i> --}}
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Shipment Output / Total Machine Output) Percent"></i>
                                                <input type="text" class="form-control form-control-sm" placeholder="---" name="mat_yield" id="txtMatYield" readonly>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="form-label">Production Lot #:</label>
                                                <input type="text" class="form-control form-control-sm" name="prod_lot_no" id="txtProdLotNo">
                                            </div> --}}

                                            <label class="form-label">Production Lot #:</label>
                                            <div class="input-group input-group-sm mb-3" id="divProdLotInput">
                                                <input type="text" class="form-control w-25" id="prodLotNoAuto" name="prod_log_no_auto" oninput="this.value = this.value.toUpperCase()" readonly>
                                                {{-- <span class="input-group-text">-</span> --}}
                                                <input type="text" class="form-control" id="prodLotNoExt1" name="prod_log_no_ext_1" oninput="this.value = this.value.toUpperCase()">
                                                <span class="input-group-text">-</span>
                                                <input type="text" class="form-control" id="prodLotNoExt2" name="prod_log_no_ext_2" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                            <div class="input-group input-group-sm mb-3 d-none" id="divProdLotView">
                                                <input type="text" class="form-control" id="txtProdLotView" readonly>
                                            </div>

                                            {{-- <label class="form-label">Material Lot No.:</label>
                                            <div class="input-group mb-1">
                                                <input type="text" class="form-control form-control-sm matNo" aria-describedby="button-addon2" name="material_no" id="txtMaterialLot" readonly required>
                                                <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
                                            </div> --}}

                                            <div class="form-group d-none" id="divRemarks">
                                                <label class="form-label">Remarks:</label>
                                                <textarea rows='5' name="remarks" id="txtRemarks" class="form-control form-control-sm"></textarea>
                                            </div>

                                            <div class="mt-4">
                                                <button type="button" class="btn btn-info w-100 btn-sm" id="btnViewSublot">See Sub-lots</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="card ">
                                        <div class="card-body">
                                            <div class="float-end">
                                                <button class="btn btn-danger btn-sm d-none" id="btnRemoveMatNo">Remove</button>
                                                <button class="btn btn-info btn-sm d-none" id="btnAddMatNo">Add</button>
                                            </div>
                                            <br>
                                            <label class="form-label">Material Lot No.:</label>

                                            <div class="input-group mb-1">
                                                <input type="text" class="form-control form-control-sm matNo" aria-describedby="button-addon2" name="material_no[]" id="txtTtlMachOutput_0" readonly>
                                                <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="hidden_scanner_input" id="multipleCounter" value="0">
                                            <div id="divMultipleMatLot">
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="saveProdData" class="btn btn-primary"><i
                                    class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

           {{-- MODAL FOR PRINTING  --}}
        <div class="modal fade" id="modalPrintQr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Production - QR Code</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- PO 1 -->
                            <div class="col-sm-12">
                                <div class="d-none" id="hiddenPreview">

                                </div>
                                <center>
                                    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->margin(5)->errorCorrection('H')->generate('0')) !!}" id="img_barcode_PO" style="max-width: 200px;"><br>
                                </center>
                                <label id="img_barcode_PO_text"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnPrintQrCode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>


        <div class="modal fade" id="modalScanQr" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-top" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        {{-- hidden_scanner_input --}}
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQrCode" name="scan_qr_code" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100" id="txtScanQrCode" name="scan_qr_code" autocomplete="off"> --}}
                        <div class="text-center text-secondary">Please scan the material lot #.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalScanPO" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-top" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                    </div>
                    <div class="modal-body pt-2">
                        {{-- hidden_scanner_input --}}
                        {{-- <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanPO" name="" autocomplete="off"> --}}
                        <input type="text" class="w-100 hidden_scanner_input" id="txtScanPO"  autocomplete="off">
                        {{-- <input type="text" class="scanner w-100" id="txtScanPO"  autocomplete="off"> --}}
                        {{-- <input type="text" class="scanner w-100" id="txtScanQrCode" name="scan_qr_code" autocomplete="off"> --}}
                        <div class="text-center text-secondary">Please scan PO Number.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalHistorySecondStamp" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa-solid fa-circle-exclamation"></i> NG History</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tblHistorySecondStamp" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PO Number</th>
                                        <th>Set-up Pins</th>
                                        <th>Adjustment Pins</th>
                                        <th>QC Samples</th>
                                        <th>NG Count</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalMultipleSublot" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa-solid fa-circle-exclamation"></i> Sub-lot Input</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form id="formSublot">
                            @csrf
                            <input type="hidden" id="txtSublotStampingId" name="stamping_id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>PO No.:</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtSubLotPoNumber" name="sublot_po" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><strong>Lot No.:</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtSubLotLotNo" name="sublot_lotno" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><strong>Shipment Output:</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtSubLotShipOutput" name="sublot_shipout" readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="float-end" id="buttons">
                                        <button type="button" class="btn btn-sm btn-danger d-none" id="btnRemoveSublot">Remove</button>
                                        <button type="button" class="btn btn-sm btn-success" id="btnAddSublot">Add</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="txtSublotMultipleCounter" name="sublot_counter" value="1">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div>
                                        <label class="form-label">Sub-lot #</label>
                                        <input type="number" class="form-control form-control-sm" id="txtSublotNo_1" value="1" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div>
                                        <label class="form-label">Sub-lot Quantity</label>
                                        <input type="number" class="form-control form-control-sm" name="sublot_qty_1" id="txtSublotQty_1">
                                    </div>
                                </div>

                            </div>
                            <div id="divMultipleSublot">

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btnSaveSublot">Save</button>
                    </div>
                </div>
            </div>
        </div>

         {{-- MODAL FOR SCANNING MATERIAL LOT # --}}
         <div class="modal fade" id="modalScanSelOp" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-top" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" class="w-100 hidden_scanner_input" id="txtScanOpId" name="" autocomplete="off">
                        {{-- <input type="text" class="w-100" id="txtScanOpId" name="" autocomplete="off"> --}}
                        <div class="text-center text-secondary">Please scan operator ID.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js_content')
        <script>
            var poDetails;
            var stampCat;
            var autogenLotNum
            var btnFunction;

            var img_barcode_PO_text_hidden;
            // var multipleMatId;
            // var printId;
            // var scanningFunction;

            $(document).ready(function(){
                // getOperatorList($('.selOpName'));

                // $('.select2').select2();

                // //Initialize Select2 Elements
                // $('.select2bs4').select2({
                //     theme: 'bootstrap-5'
                // });

                dtDatatableProdSecondStamp = $("#tblProdSecondStamp").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_stamp_prod",
                        data: function (param){
                            param.po = $("#txtSearchPONum").val();
                            param.stamp_cat = 2;
                        }
                    },
                    fixedHeader: true,
                    "columns":[

                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "label" },
                        { "data" : "po_num" },
                        { "data" : "prod_lot_no" },
                        { "data" : "part_code" },
                        { "data" : "material_name" },
                        { "data" : "po_qty" },
                        { "data" : "ship_output" },
                        { "data" : "material" },
                        { "data" : "overall_yield" },
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [7],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });//end of dataTableDevices

                $('#formProdDataSecondStamp').submit(function(e){
                    e.preventDefault();
                    $('#modalScanQRSave').modal('show');
                    $('#modalScanQRSaveText').html('Please Scan Employee ID.')
                    scanningFunction = "prodData";

                    // $('input[name="scan_id"]').attr('id', 'txtScanUserId');
                });
                $('#modalScanPO').on('shown.bs.modal', function () {
                    $('#txtScanPO').focus();
                    const mdlScanPoNo = document.querySelector("#modalScanPO");
                    const inptScanPoNo = document.querySelector("#txtScanPO");
                    let focus = false

                    mdlScanPoNo.addEventListener("mouseover", () => {
                        if (inptScanPoNo === document.activeElement) {
                            focus = true
                        } else {
                            focus = false
                        }
                    });

                    mdlScanPoNo.addEventListener("click", () => {
                        if (focus) {
                            inptScanPoNo.focus()
                        }
                    });
                });

                $('#txtScanPO').on('keyup', function(e){
                    if(e.keyCode == 13){
                        getSecondStampReq($(this).val());

                        // scannedItem = JSON.parse($(this).val());
                        $('#txtScanPO').val('');

                    }
                });

                $('#txtTargetOutput').on('keyup', function(e){
                    // Computation for PPC Target Output (Pins) and Planned Loss (10%) (Pins)
                    // let ppcTargtOut = 0;
                    let planLoss = 0;
                    let ppcTargtOut = $(this).val();

                    // ppcTargtOut = inputCoilWeight/0.005;
                    planLoss = ppcTargtOut*0.1;

                    // $('#txtTargetOutput').val(ppcTargtOut);
                    $('#txtPlannedLoss').val(planLoss.toFixed(2));
                });

                $('#txtTtlMachOutput, #txtProdSamp, #txtNGCount').on('keyup', function(e){
                    // * computation for Shipment Output and Material Yield
                    let sum = Number($('#txtSetupPin').val()) + Number($('#txtAdjPin').val()) + Number($('#txtQcSamp').val()) + Number($('#txtProdSamp').val()) + Number($('#txtNGCount').val());
                    let ttlMachOutput = $('#txtTtlMachOutput').val();

                    let shipmentOutput = ttlMachOutput - sum;
                    let matYieldComp = shipmentOutput/ttlMachOutput;
                    let matYield =  matYieldComp * 100;
                    if(Number.isFinite(matYield)){
                        $('#txtShipOutput').val(shipmentOutput);
                        $('#txtMatYield').val(`${matYield.toFixed(2)}%`);
                    }
                    else{
                        $('#txtShipOutput').val('');
                        $('#txtMatYield').val('');
                    }
                });

                // $(document).on('keypress', '#txtSearchPONum', function(e){
                //     if(e.keyCode == 13){
                //         $.ajax({
                //             type: "get",
                //             url: "get_search_po",
                //             data: {
                //                 "po" : $(this).val()
                //             },
                //             dataType: "json",
                //             beforeSend: function(){
                //                 prodData = {};
                //             },
                //             success: function (response) {
                //                 console.log(response);
                //                 if(response.length > 0){
                //                     prodData['poReceiveData'] = response[0];
                //                     console.log(response);
                //                     $.ajax({
                //                         type: "get",
                //                         url: "get_data_req_for_prod_by_po",
                //                         data: {
                //                             "item_code" : response[0]['ItemCode']
                //                         },
                //                         dataType: "json",
                //                         success: function (result) {
                //                             $('#txtSearchMatName').val(response[0]['ItemName']);
                //                             $('#txtSearchPO').val(response[0]['OrderQty']);
                //                             prodData['drawings'] = result
                //                             console.log(prodData);
                //                             dtDatatableProd.draw();
                //                         }
                //                     });
                //                 }
                //             }
                //         });
                //     }
                // });

                $('#btnAddProdData').on('click', function(e){
                    if($('#txtSearchPONum').val() != "" && $('#txtSearchMatName').val() != ""){
                        console.log(poDetails);
                        checkMatrix(poDetails['part_code'], poDetails['material_name'], '2nd Stamping')
                        // getProdLotNoCtrl();
                        $('#prodLotNoAuto').val(autogenLotNum);

                        // OPERATOR SHIFT
                        // $time_now = moment().format('LT');
                        $time_now = moment().format('HH:mm:ss');
                        if($time_now >= '7:30:00' || $time_now <= '19:29:00'){
                            $('#txtOptShift').val('A');
                        }
                        else{
                            $('#txtOptShift').val('B');
                        }

                        // console.log(prodData);
                        // $('#txtPoNumber').val(prodData['poReceiveData']['OrderNo']);
                        // $('#txtPoQty').val(prodData['poReceiveData']['OrderQty']);
                        // $('#txtPartCode').val(prodData['poReceiveData']['ItemCode']);
                        // $('#txtMatName').val(prodData['poReceiveData']['ItemName']);
                        // $('#txtDrawingNo').val(prodData['drawings']['drawing_no']);
                        // $('#txtDrawingRev').val(prodData['drawings']['rev']);
                        // // $('#txtOptName').val($('#globalSessionName').val());
                        // $('#modalProdData').modal('show');
                        $('#txtProdSamp').prop('readonly', true);
                        $('#txtNGCount').prop('readonly', true);
                        $('#txtTtlMachOutput').prop('readonly', true);
                        $('#txtProdDate').prop('readonly', true);
                        $('#radioIQC').prop('checked', true);
                        $('#radioMassProd').prop('checked', false);
                        $('input[name="tray"]',  $('#formProdDataSecondStamp')).prop('disabled', true);

                    }
                    else{
                        toastr.error('Please input PO.')
                    }

                });

                $(document).on('click', '.btnViewProdData', function(e){
                    let id = $(this).data('id');
                    let btnFunction = $(this).data('function');
                    let stampCategory = $(this).data('stampcat');
                    // getProdDataToView(id);
                    getProdDataById(id, btnFunction, stampCategory);
                });

                $(document).on('click', '.btnPrintProdData', function(e){
                    printId = $(this).data('id');
                    let printCount = $(this).data('printcount');
                    stampCat = $(this).data('stampcat');
                    if(printCount > 0){
                        Swal.fire({
                            // title: "Are you sure?",
                            html: "Data already printed. <br> Do you want to reprint this data?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#modalScanQRSave').modal('show');
                                $('#modalScanQRSaveText').html('Please Scan Supervisor ID.')
                                scanningFunction = "reprintStamping"
                            }
                        });
                    }
                    else{
                        printProdData(printId, stampCat);
                    }
                });

                $('#btnPrintQrCode').on('click', function(){

                    popup = window.open();
                    let content = '';

                    content += '<html>';
                    content += '<head>';
                    content += '<title></title>';
                    content += '<style type="text/css">';
                    content += '@media print { .pagebreak { page-break-before: always; } }';
                    content += '</style>';
                    content += '</head>';
                    content += '<body>';
                    for (let i = 0; i < img_barcode_PO_text_hidden.length; i++) {
                        content += '<table style="margin-left: -5px; margin-top: 10px;">';
                            content += '<tr style="width: 290px;">';
                                content += '<td>';
                                    content += '<img src="' + img_barcode_PO_text_hidden[i]['img'] + '" style="min-width: 100px; max-width: 100px;">';
                                content += '</td>';
                                content += '<td style="font-size: 10px; font-family: Calibri;">' + img_barcode_PO_text_hidden[i]['text'] + '</td>';
                            content += '</tr>';
                        content += '</table>';
                        content += '<br>';
                        if( i < img_barcode_PO_text_hidden.length-1 ){
                            content += '<div class="pagebreak"> </div>';
                        }
                    }
                    content += '</body>';
                    content += '</html>';
                    popup.document.write(content);

                    popup.focus(); //required for IE
                    popup.print();

                    /*
                        * this event will trigger after closing the tab of printing
                    */
                    popup.addEventListener("beforeunload", function (e) {
                        if(img_barcode_PO_text_hidden[0]['stampCat'] == undefined){

                            changePrintCount(img_barcode_PO_text_hidden[0]['id']);
                        }
                    });

                    popup.close();

                });

                // $('#btnAddMatNo').on('click', function(e){
                //     e.preventDefault();
                //     let newCount = Number($('#multipleCounter').val()) + Number(1);
                //     if(newCount > 0){
                //         $('#btnRemoveMatNo').removeClass('d-none');
                //     }
                //     $('#multipleCounter').val(newCount);
                //     let inputGroup = `
                //             <div class='input-group mb-1 appendDiv' id="divInput_${newCount}">
                //                 <input type='text' class='form-control form-control-sm matNo' name='material_no[]' id='txtTtlMachOutput_${newCount}' required readonly>
                //                 <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
                //             </div>
                //     `;
                //     $('#divMultipleMatLot').append(inputGroup)
                // });

                // $('#btnRemoveMatNo').on('click', function(e){
                //     e.preventDefault();
                //     let counter = $('#multipleCounter').val();

                //     $(`#divInput_${counter}`).remove();

                //     let newCount = $('#multipleCounter').val() - 1;
                //     $('#multipleCounter').val(newCount)

                //     if(newCount == 0){
                //         $('#btnRemoveMatNo').addClass('d-none');
                //     }
                // });

                $(document).on('click', '.btnQr', function(){
                    // multipleMatId = $(this).offsetParent().children().attr('id');
                    // console.log($(this).offsetParent().children().attr('id'));
                    $('#modalScanQr').modal('show');
                    $('#modalScanQr').on('shown.bs.modal', function () {
                        $('#txtScanQrCode').focus();
                    });
                });

                $('#txtScanQrCode').on('keyup', function(e){
                    let scannedItem
                    if(e.keyCode == 13){
                        try{
                            scannedItem = JSON.parse($(this).val());
                            $(`#txtMaterialLot`).val(scannedItem['new_lot_no']);
                            $(`#txtInptPins`).val(scannedItem['qty']);
                            $('#modalScanQr').modal('hide');
                        }
                        catch (e){
                            toastr.error('Invalid Sticker');
                        }
                        $(this).val('');
                    }
                });

                $(document).on('click', '.btnMassProd', function(e){
                    let id = $(this).data('id');
                    let btnFunction = $(this).data('function');
                    let stampCategory = $(this).data('stampcat');

                    getProdDataById(id, btnFunction, stampCategory);
                });

                $('input[name="tray"]').on('change', function(){
                    if($(this).val() == 0){
                        $('#txtNoTray').prop('readonly', true);

                    }
                    else{
                        $('#txtNoTray').prop('readonly', false);
                    }
                });

                $(document).on('click', '.btnViewResetup', function(e){
                    let id = $(this).data('id');
                    let btnFunction = $(this).data('function');
                    let stampCategory = $(this).data('stampcat');

                    getProdDataById(id, btnFunction, stampCategory);
                });


                $(document).on('click', '.btnViewHistory', function(e){
                    historyId = $(this).data('id');
                    let po = $(this).data('po');
                    dtDatatableHistory = $("#tblHistorySecondStamp").DataTable({
                        "processing" : true,
                        "serverSide" : true,
                        "paging": false,
                        "searching": false,
                        "info": false,
                        "destroy": true,
                        "ordering": false,
                        "ajax" : {
                            url: "get_history_details",
                            data: function (param){
                                param.id = historyId;
                            }
                        },
                        fixedHeader: true,
                        "columns":[
                            {
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                render: function (data, type, row, meta) {
                                    return po;
                                }
                            },
                            // { "data" : "id" },
                            { "data" : "set_up_pins" },
                            { "data" : "adj_pins" },
                            { "data" : "qc_samp" },
                            { "data" : "ng_count" },
                            { "data" : "remarks" },
                        ],
                    });//end of dataTableDevices

                    $('#modalHistorySecondStamp').modal('show');

                })

                $(document).on('click', '.btnEditProdData', function(e){
                    printId = $(this).data('id');
                    printStampCat = $(this).data('stampcat');
                    btnFunction = $(this).data('function');


                    Swal.fire({
                        // title: "Are you sure?",
                        html: "Data already for mass production. <br> Do you want to re-setup this lot?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#modalScanQRSave').modal('show');
                            $('#modalScanQRSaveText').html('Please Scan Supervisor ID.')
                            scanningFunction = "editProdData";
                        }
                    });

                });

                $(document).on('click', '.btnAddBatch', function(e){
                    let id = $(this).data('id');
                    let po = $(this).data('po');
                    let lotno = $(this).data('lotno');
                    let shipout = $(this).data('shipout');

                    $('#txtSublotStampingId', $('#formSublot')).val(id);
                    $('input[name="sublot_po"]', $('#formSublot')).val(po)
                    $('input[name="sublot_lotno"]', $('#formSublot')).val(lotno)
                    $('input[name="sublot_shipout"]', $('#formSublot')).val(shipout)

                    $('#modalMultipleSublot').modal('show');
                });

                $('#btnAddSublot').on('click', function(e){
                    e.preventDefault();
                    let newCount = Number($('#txtSublotMultipleCounter').val()) + Number(1);

                    if(newCount > 1){
                        $('#btnRemoveSublot').removeClass('d-none');
                    }
                    $('#txtSublotMultipleCounter').val(newCount);
                    let inputGroup = `
                        <div class="row mt-1 subLotMultiple" id="divMultiple_${newCount}">
                            <div class="col-sm-6">
                                <div>
                                    <input type="number" class="form-control form-control-sm" value="${newCount}" id="txtSublotNo_${newCount}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <input type='text' class='form-control form-control-sm' name='sublot_qty_${newCount}' id='txtSublotQty_${newCount}' required>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#divMultipleSublot').append(inputGroup)

                });

                $('#btnRemoveSublot').on('click', function(e){
                    e.preventDefault();

                    let counter = $('#txtSublotMultipleCounter').val();
                    $(`#divMultiple_${counter}`).remove();

                    let newCount = counter - 1;

                    $('#txtSublotMultipleCounter').val(newCount);

                    if(newCount == 1){
                        $(this).addClass('d-none');
                    }

                })

                $('#btnSaveSublot').on('click', function(e){
                    let counter = $('#txtSublotMultipleCounter').val();
                    let shipmentOutput = $('#txtSubLotShipOutput').val();
                    let total = 0;
                    console.log('counter', counter);
                    for(let x = 1; x <= counter; x++){
                        console.log('forloop counter', x);
                        total = Number($(`#txtSublotQty_${x}`).val())+Number(total);
                    }
                    console.log(total);
                    if(total > shipmentOutput){
                        toastr.error('Sub-lot quantity is greater than shipment output');
                        return;
                    }
                    if(shipmentOutput != total){
                        toastr.error('Sub-lot quantity is not equal to shipment output');
                        return;
                    }
                    if(shipmentOutput == total){
                        // saveSublot();
                        $('#modalScanQRSave').modal('show');
                        $('#modalScanQRSaveText').html('Please Scan Employee ID.')
                        scanningFunction = "saveSublot";
                    }
                });

                $('#btnViewSublot').on('click', function(e){
                    e.preventDefault();
                    let stampingId = $('#txtProdDataId', $('#formProdDataSecondStamp')).val();

                    getSublotById(stampingId);
                });

            });

            $(document).on('keyup','#txtScanUserId', function(e){

                if(e.keyCode == 13){

                    if(scanningFunction === "prodData"){ // TO SAVE STAMPING
                        validateUser($(this).val().toUpperCase(), [0,4,1,9], function(result){
                            if(result == true){

                                // console.log($('#formProdDataSecondStamp').serialize())
                                submitProdData($('#txtScanUserId').val().toUpperCase(), $('#formProdDataSecondStamp'), $('#txtStampCat2').val());
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                    }
                    else if(scanningFunction === "editProdData"){ // FOR EDIT TO RESETUP
                        validateUser($(this).val().toUpperCase(), [0,1,9], function(result){
                            if(result == true){
                                $('#modalScanQRSave').modal('hide');
                                getProdDataById(printId, btnFunction, printStampCat);

                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }

                        });
                    }
                    else if(scanningFunction === "saveSublot"){ // FOR SAVE SUBLOT
                        validateUser($(this).val().toUpperCase(), [0,4,1,9], function(result){
                            if(result == true){
                                saveSublot();
                                $('#modalScanQRSave').modal('hide');

                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                    }
                    else{ // * FOR REPRINTING
                        validateUser($(this).val().toUpperCase(), [0,1,9], function(result){
                            if(result == true){
                                $('#modalScanQRSave').modal('hide');
                                printProdData(printId);
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }

                        });

                    }

                    setTimeout(() => {
                        $(this).val('');

                    }, 500);
                }
            });

            $("#modalPrintQr").on('hidden.bs.modal', function () {
                console.log('hidden.bs.modal');
                $('.hiddnQr').remove();
            });
        </script>

        @if (in_array(Auth::user()->position, [0,1,9]) || in_array(Auth::user()->user_level_id, [1]))
            <script>
                $('#txtSearchPONum').prop('readonly', false);
                $('#txtSearchPONum').on('keyup', function(e){
                    if(e.keyCode == 13){
                        getSecondStampReq($(this).val());
                        console.log($('#txtSearchPONum').val());
                    }
                });
            </script>
        @endif
    @endsection
@endauth

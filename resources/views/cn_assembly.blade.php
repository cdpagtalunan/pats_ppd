@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Material Process')
    @section('content_page')
        <style type="text/css">
            .hidden_scanner_input{
                position: absolute;
                left: 15%;
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
                            <h1>CN Assembly</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">CN Assembly</li>
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
                                            <label class="form-label">Series Name</label>
                                            <div class="input-group mb-3">
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Select Series Name"></i>
                                                {{-- <select class="form-control select2bs5" id="txtSelectPONo" name="series_name" placeholder="Select PO Number"></select> --}}
                                                <select class="form-control" type="text" name="series_name" id="txtSelectSeriesName" required>
                                                    <option value="" disabled selected>Select Series Name</option>
                                                    <option value="CN171P-007-1002-VE(01)">CN171P-007-1002-VE(01)</option>
                                                    <option value="CN171S-007-1002-VE(01)">CN171S-007-1002-VE(01)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Device Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Device Name" id="txtSearchDeviceName" readonly>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-2">
                                            <label class="form-label">Part Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Part Code" id="txtSearchPartCode" readonly>
                                            </div>
                                        </div> --}}
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
                                    <h3 class="card-title">CN Assembly</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="btnAddCnAssemblyRuncard"><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblAssemblyRuncard" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>Device Name</th>
                                                    <th>Parts Code</th>
                                                    {{-- <th>Runcard #</th> --}}
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
        <div class="modal fade" id="modalCNAssembly" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formCNAssemblyRuncard" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            {{-- <input type="text" id="textSecondMoldingId" class="d-none" name="id"> --}}
                            <div class="row">
                                <div class="col-sm-4 border px-4">
                                    <div class="py-3">
                                        <span class="badge badge-secondary">1.</span> Runcard Details
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Assembly Runcard ID</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtAssyRuncardId" name="assy_runcard_id" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Series Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtSeriesName" name="series_name" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtDeviceName" name="device_name" placeholder="Auto generated" readonly>
                                    </div>
                                    {{-- <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Number</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtPONumber" name="po_number" placeholder="Search PO">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Parts Code</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtPartsCode" name="parts_code" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Quantity</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtPoQuantity" name="po_quantity" placeholder="Auto generated" readonly>
                                    </div>
                                    --}}

                                    <div id="pSeriesName" style="border:2px; border-style:dashed; padding:2px;">
                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CN171P-02#IN-VE - Lot No</span>
                                            </div>
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code" id="btnScanPZeroTwoProdLot" form-value="ScanPZeroTwoProdLot">
                                                    <i class="fa fa-qrcode"></i>
                                                </button>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtPZeroTwoProdLot" name="p_zero_two_prod_lot" placeholder="Scan Production Lot" readonly>
                                                <input type="hidden" class="form-control form-control-sm" id="txtPZeroTwoDeviceId" name="p_zero_two_device_id" placeholder="Device ID">
                                        </div>

                                        <div class="input-group input-group-sm mb-2">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">P-02#IN - PO No</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePO" name="po_quantity" placeholder="Auto generated" readonly>
                                        </div>

                                        <div class="input-group input-group-sm mb-1">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">P-02#IN - PMI PO No</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                        </div>
                                    </div>


                                    <div id="sSeriesName">
                                        <div style="border: 2px; border-style:dashed; padding:2px;">
                                            <div class="input-group input-group-sm mt-1 mb-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">CN171S-07#IN-VE - Lot No</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="btnScanSZeroSevenProdLot" form-value="ScanSZeroSevenProdLot">
                                                        <i class="fa fa-qrcode"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtSZeroSevenProdLot" name="s_zero_seven_prod_lot" placeholder="Scan Production Lot" readonly>
                                                <input type="hidden" class="form-control form-control-sm" id="txtSZeroSevenDeviceId" name="s_zero_seven_device_id" placeholder="Device ID">
                                            </div>

                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">S-07#IN - PO No</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtSZeroSevenDevicePO" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>

                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">S-07#IN - PMI PO No</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>
                                        </div>

                                        <div style="border: 2px; border-style:dashed; padding:2px;" class="border-top-0">
                                            <div class="input-group input-group-sm mt-1 mb-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">CN171S-02#MO-VE - Lot No</span>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="btnScanSZeroTwoProdLot" form-value="ScanSZeroTwoProdLot">
                                                        <i class="fa fa-qrcode"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtSZeroTwoProdLot" name="s_zero_two_prod_lot" placeholder="Scan Production Lot" readonly>
                                                <input type="hidden" class="form-control form-control-sm" id="txtSZeroTwoDeviceId" name="s_zero_two_device_id" placeholder="Device ID">
                                            </div>

                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">S-02#MO - PO No</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtSZeroTwoDevicePO" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>

                                            <div class="input-group input-group-sm mb-1">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">S-02#MO - PMI PO No</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="input-group input-group-sm mt-2 mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Total Assembly Yield</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtTotalAssyYield" name="total_assy_yield" placeholder="Auto generated" readonly>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Average Overall Yield</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtAveOveallYield" name="ave_overall_yield" placeholder="Auto generated" readonly>
                                    </div>

                                    <div class="input-group input-group-sm mb-3 justify-content-end align-items-center">
                                        <button class="btn btn-sm btn-success" type="button" id="btnRuncardDetails">
                                            <i class="fa-solid fa-floppy-disk"></i> Save
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col border px-4 border">
                                        <div class="py-3">
                                            <div style="float: left;">
                                                <span class="badge badge-secondary">2.</span> Stations
                                            </div>
                                            <div style="float: right;">
                                                <button class="btn btn-primary btn-sm" id="btnAddRuncardStation" runcard_id="" type="button" style="margin-bottom: 5px;">
                                                    <i class="fa fa-plus"></i> Add Station
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm small table-bordered table-hover" id="tblAssemblyRuncardStation" style="width: 100%;">
                                                    <thead>
                                                        <tr class="bg-light">
                                                            <th></th>
                                                            <!-- <th></th> -->
                                                            <th>Station</th>
                                                            <th>Date</th>
                                                            <th>Name</th>
                                                            <th>Input</th>
                                                            <th>NG Qty</th>
                                                            <th>Output</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="btnSubmitAssemblyRuncardData" class="btn btn-primary" disabled><i class="fa fa-check"></i> Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

        <div class="modal fade" id="modalQrScanner" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrScanner" class="hidden_scanner_input" class="" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan Material Lot #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAddStation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAddAssemblyRuncardStation">
                            @csrf
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                    <span class="input-group-text w-100" id="basic-addon1">Assembly Runcard ID</span>
                                </div>
                                    <input type="text" class="form-control form-control-sm" id="txtStationAssyRuncardId" name="station_assy_runcard_id" readonly>
                            </div>

                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend w-50">
                                    <span class="input-group-text w-100" id="basic-addon1">Assembly Runcard Station ID</span>
                                </div>
                                    <input type="text" class="form-control form-control-sm" id="txtAssyRuncardStationId" name="assy_runcard_station_id" readonly>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station</span>
                                        </div>
                                        <select class="form-control" type="text" name="runcard_station" id="txtSelectRuncardStation" placeholder="Station" required>
                                        </select>
                                        {{-- <input type="text" class="form-control form-control-sm" id="txtSelectRuncardStation" name="runcard_station" placeholder="Station"> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                        </div>
                                            <input type="date" class="form-control form-control-sm" id="txtDate" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                        </div>
                                            <input type="text" class="form-control form-control-sm" id="txtOperatorName" name="operator_name" placeholder="Auto Generate" readonly>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                        </div>
                                            <input type="number" class="form-control form-control-sm" id="txtInputQuantity" name="input_qty" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                        </div>
                                            <input type="text" class="form-control form-control-sm" id="txtNgQuantity" name="ng_qty"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                        </div>
                                            <input type="number" class="form-control form-control-sm" id="txtOutputQuantity" name="output_qty" min="0" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station Yield</span>
                                        </div>
                                            <input type="text" class="form-control form-control-sm" placeholder="0%" id="txtStationYield" name="station_yield" onkeypress="return event.charCode >= 48 && event.charCode <= 57" readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Mode of Defect</span>
                                        </div>
                                            <input type="text" class="form-control form-control-sm" id="txtModeOfDefect" name="mode_of_defect">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Defect Qty</span>
                                        </div>
                                            <input type="number" class="form-control form-control-sm" id="txtDefectQuantity" name="defect_quantity" min="0">
                                    </div>
                                </div>
                            </div> --}}

                            {{-- P SERIES Lubricant Coating Add Fields START --}}
                            <div id="LubricantCoatingDiv">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">mL per Shot</span>
                                            </div>
                                                <input type="number" class="form-control form-control-sm" id="txtMlPerShot" name="ml_per_shot" min="0">
                                            <div class="input-group-append w-25">
                                                <span class="input-group-text w-100" id="basic-addon1">mL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Total Lubricant Usage</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" placeholder="0" id="txtTotalLubricantUsage" name="total_lubricant_usage" readonly>
                                            <div class="input-group-append w-25">
                                                <span class="input-group-text w-100" id="basic-addon1">mL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- P SERIES Lubricant Coating Add Fields END --}}

                            {{-- Visual Inspection Add Fields START --}}
                            <div id="VisualInspDocNoDiv">
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (WI)</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDocNoWorkI" name="doc_no_work_i">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (R Drawing)</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDocNoRDrawing" name="doc_no_r_drawing">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (A Drawing)</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDocNoADrawing" name="doc_no_a_drawing">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (G Drawing)</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDocNoGDrawing" name="doc_no_g_drawing">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date Code</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDateCode" name="date_code">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Bundle Qty</span>
                                            </div>
                                                <input type="number" class="form-control form-control-sm" id="txtBundleQuantity" name="bundle_quantity" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Visual Inspection Add Fields END --}}

                            {{-- MODE OF DEFECTS START --}}
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between">

                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <label>Total No. of NG: <span id="labelTotalNumberOfNG" style="color: red;">0</span>
                                                <label>
                                                    &nbsp;<li class="fa-solid fa-thumbs-down" id="labelIsTally" style="color: red;"></li>
                                                </label>
                                            </label>
                                            <button type="button" id="buttonAddAssemblyModeOfDefect" class="btn btn-sm btn-info" title="Add MOD"><i class="fa fa-plus"></i> Add MOD</button>
                                        </div>
                                        <br>
                                        <table class="table table-sm" id="tableAssemblyStationMOD">
                                            <thead>
                                                <tr>
                                                    <th style="width: 55%;">Mode of Defect</th>
                                                    <th style="width: 15%;">QTY</th>
                                                    <th style="width: 10%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{-- MODE OF DEFECTS END --}}

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                        </div>
                                            <input type="text" class="form-control form-control-sm" id="txtRemarks" name="remarks">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="btnSaveNewAssemblyRuncardStation">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){

                $( '.select2bs5' ).select2( {
                    theme: 'bootstrap-5'
                } );

                // PACOPYA BOSS MIGZ
                // let totalNumberOfMOD = 0;
                $("#buttonAddAssemblyModeOfDefect").click(function(){
                    let totalNumberOfMOD = 0;
                    // totalNumberOfMOD = 0;
                    let ngQty = $('#formAddAssemblyRuncardStation #txtNgQuantity').val();
                    let rowModeOfDefect = `
                        <tr>
                            <td>
                                <select class="form-control select2 select2bs4 selectMOD" name="mod_id[]">
                                    <option value="0">N/A</option>
                                </select>
                            </td>
                            <td id=textMODQuantity>
                                <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="1" min="1">
                            </td>
                            <td id="buttonRemoveMOD">
                                <center><button class="btn btn-md btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                            </td>
                        </tr>
                    `;
                    $("#tableAssemblyStationMOD tbody").append(rowModeOfDefect);
                    // $('.select2bs5').select2({
                    //     theme: 'bootstrap-5'
                    // });
                    getModeOfDefect($("#tableAssemblyStationMOD tr:last").find('.selectMOD'));
                    getValidateTotalNgQty (ngQty,totalNumberOfMOD);
                });

                const getModeOfDefect = (elementId, modeOfDefectId = null) => {
                    let result = `<option value="0" selected> N/A </option>`;
                    $.ajax({
                        url: 'get_mode_of_defect_frm_defect_infos',
                        method: 'get',
                        dataType: 'json',
                        beforeSend: function(){
                            result = `<option value="0" selected disabled> - Loading - </option>`;
                            elementId.html(result);
                        },
                        success: function(response){
                            result = '';
                            // console.log('ggg',response['data']);
                            if(response['data'].length > 0){
                                for(let index = 0; index < response['data'].length; index++){
                                    result += `<option value="${response['data'][index].id}">${response['data'][index].defects}</option>`;
                                }
                            }
                            else{
                                result = `<option value="0" selected disabled> - No data found - </option>`;
                            }
                            elementId.html(result);
                            if(modeOfDefectId != null){
                                elementId.val(modeOfDefectId).trigger('change');
                            }
                        },
                        error: function(data, xhr, status){
                            result = `<option value="0" selected disabled> - Reload Again - </option>`;
                            elementId.html(result);
                            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }

                const getValidateTotalNgQty = function (ngQty,totalNumberOfMOD){
                    $('#tableAssemblyStationMOD .textMODQuantity').each(function() {
                        if($(this).val() === null || $(this).val() === ""){
                            $("#tableAssemblyStationMOD tbody").empty();
                            $("#labelTotalNumberOfNG").text(parseInt(0));
                        }
                        totalNumberOfMOD += parseInt($(this).val());
                    });

                    if(parseInt(ngQty) === totalNumberOfMOD){
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $('#labelIsTally').css({color: 'green'})
                        $('#labelIsTally').addClass('fa-thumbs-up')
                        $('#labelIsTally').removeClass('fa-thumbs-down')
                        $('#labelIsTally').attr('title','')
                        $("#btnAddRuncardStation").prop('disabled', false);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', false);
                    }else if(parseInt(ngQty) <= totalNumberOfMOD){
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Defect Quantity cannot be more than the NG Quantity!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#tableAssemblyStationMOD .textMODQuantity').val(0);
                        $('#tableAssemblyStationMOD tbody').find('tr').remove();
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', false);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', true);
                    }else{
                        console.log('Mode of Defect & NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $('#labelIsTally').css({color: 'red'})
                        $('#labelIsTally').addClass('fa-thumbs-down')
                        $('#labelIsTally').removeClass('fa-thumbs-up')
                        $('#labelIsTally').attr('title','Mode of Defect & NG Qty are not tally!')
                        $("#btnAddRuncardStation").prop('disabled', true);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', false);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', true);
                    }
                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                }

                $("#tableAssemblyStationMOD").on('click', '.buttonRemoveMOD', function(){
                    // let row_defect_qty = $(this).attr(); //clarkkkkkk
                    // let row_defect_qty = $(this).closest('tr').find('td#textMODQuantity input').val();
                    // console.log('sibling', row_defect_qty);
                    // $(this).closest ('tr').remove();
                    let totalNumberOfMOD = 0;
                    let ngQty = $('#txtNgQuantity').val();

                    $(this).closest ('tr').remove();
                    getValidateTotalNgQty (ngQty,totalNumberOfMOD);
                });
                $(document).on('keyup','.textMODQuantity', function (e) {
                    let totalNumberOfMOD = 0;
                    let ngQty = $('#txtNgQuantity').val();
                    let defectQty = $('.textMODQuantity').val();
                    // console.log('defectQty', defectQty);

                    getValidateTotalNgQty (ngQty,totalNumberOfMOD);
                });

                $('#txtNgQuantity').keyup(function (e) {
                    let ngQty = $(this).val();
                    let totalNumberOfMOD = 0;
                    /**
                     * Auto compute NG Quantity onkeyup
                     * Start
                    */

                    if(parseInt(ngQty) > 0){
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', false);
                    }
                    else{
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                    }

                    if(parseInt(ngQty) === parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $('#labelIsTally').css({color: 'green'})
                        $('#labelIsTally').addClass('fa-thumbs-up')
                        $('#labelIsTally').removeClass('fa-thumbs-down')
                        $("#btnAddRuncardStation").prop('disabled', false);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', false);
                    }else{
                        console.log('Mode of Defect NG is greater than NG qty');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $('#labelIsTally').css({color: 'red'})
                        $('#labelIsTally').addClass('fa-thumbs-down')
                        $('#labelIsTally').removeClass('fa-thumbs-up')

                        $("#btnAddRuncardStation").prop('disabled', true);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', false);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', true);
                    }

                });

                // PACOPYA BOSS MIGZ END

                dtAssemblyRuncard = $("#tblAssemblyRuncard").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_assembly_runcard",
                        data: function (param){
                            param.series_name = $("#txtSeriesName").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "parts_code" },
                        { "data" : "series_name" },
                        // { "data" : "runcard_no" },
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

                dtAssemblyRuncardStation = $("#tblAssemblyRuncardStation").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_assembly_runcard_stations",
                        data: function (param){
                            param.assy_runcard_id = $("#txtAssyRuncardId").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "station_name" },
                        { "data" : "date" },
                        { "data" : "operator" },
                        { "data" : "input_quantity" },
                        { "data" : "ng_quantity" },
                        { "data" : "output_quantity" },
                        { "data" : "remarks" },
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

                // NEW CODE TESTIN
                $('#btnScanPZeroTwoProdLot, #btnScanSZeroSevenProdLot, #btnScanSZeroTwoProdLot').each(function(e){
                    $(this).on('click',function (e) {
                        let formValue = $(this).attr('form-value');
                        $('#modalQrScanner').attr('data-form-id', formValue).modal('show');
                        $('#textQrScanner').val('');
                        setTimeout(() => {
                            $('#textQrScanner').focus();
                        }, 500);
                    });
                });

                $('#textQrScanner').keyup(delay(function(e){
                    let qrScannerValue = $('#textQrScanner').val();
                    let formId = $('#modalQrScanner').attr('data-form-id');
                    if( e.keyCode == 13 ){
                        $('#textQrScanner').val(''); // Clear after enter
                        switch (formId) {
                            case 'ScanPZeroTwoProdLot':
                                verifyProdLotfromMolding(qrScannerValue, formId, 'txtPZeroTwoProdLot', 'txtPZeroTwoDeviceId', 'CN171P-02#IN-VE', 'txtPZeroTwoDevicePO', 'txtPZeroTwoDevicePMIPO');
                                break;
                            case 'ScanSZeroSevenProdLot':
                                verifyProdLotfromMolding(qrScannerValue, formId, 'txtSZeroSevenProdLot', 'txtSZeroSevenDeviceId', 'CN171S-07#IN-VE', 'txtSZeroSevenDevicePMIPO');
                                break;
                            case 'ScanSZeroTwoProdLot':
                                verifyProdLotfromMolding(qrScannerValue, formId, 'txtSZeroTwoProdLot', 'txtSZeroTwoDeviceId', 'CN171S-02#MO-VE', 'txtSZeroTwoDevicePMIPO');
                                break;
                            default:
                                break;
                        }
                    }
                }, 100));
                // NEW CODE TESTIN

                const verifyProdLotfromMolding = (qrScannerValue, ScanProdLotValue, textLotNumberValue, textLotNumberIdValue, SecondMoldingDeviceName, DevicePO, DevicePMIPO) => {
                    let route;
                    if(ScanProdLotValue == 'ScanSZeroTwoProdLot'){ //
                        route = 'chk_device_prod_lot_from_first_molding';
                    }else if(ScanProdLotValue == 'ScanPZeroTwoProdLot' || ScanProdLotValue == 'ScanSZeroSevenProdLot'){
                        route = 'chk_device_prod_lot_from_sec_molding';
                    }

                    $.ajax({
                        type: "get",
                        url: route,
                        data: {
                            production_lot: qrScannerValue,
                        },
                        dataType: "json",
                        success: function (response) {
                            $(`#${textLotNumberValue}`).val('');
                            $(`#${textLotNumberIdValue}`).val('');
                            $(`#${DevicePO}`).val('');

                            if(response['device_name'] == SecondMoldingDeviceName){
                                $(`#${textLotNumberValue}`).val(response['production_lot']);
                                $(`#${textLotNumberIdValue}`).val(response['device_id']);
                                $(`#${DevicePO}`).val(response['yec_po_number']);
                                $(`#${DevicePMIPO}`).val(response['pmi_po_number']);
                                $('#modalQrScanner').modal('hide');
                            }else{
                                toastr.error('Incorrect Production Lot Number.')
                            }
                        }
                    });
                }

                $('#txtSelectRuncardStation').on('change', function(e){
                    if($(this).val() == 4){//Lubricant Coating Station
                        $('#LubricantCoatingDiv').prop('hidden', false);
                        $('#VisualInspDocNoDiv').prop('hidden', true);
                    }else if($(this).val() == 5){// Visual Inspection
                        $('#LubricantCoatingDiv').prop('hidden', true);
                        $('#VisualInspDocNoDiv').prop('hidden', true);
                    }else if($(this).val() == 6){// Visual Inspection
                        $('#LubricantCoatingDiv').prop('hidden', true);
                        $('#VisualInspDocNoDiv').prop('hidden', false);
                    }
                });

                $('#txtSelectSeriesName').on('change', function(e){
                    let seriesName = $('#txtSelectSeriesName').val();
                    $.ajax({
                        type: "get",
                        url: "get_data_from_matrix",
                        data: {
                            "series_name" : seriesName
                        },
                        dataType: "json",
                        beforeSend: function(){
                            // prodData = {};
                        },
                        success: function (response) {
                            let material_details = response['material_details'];
                            let station_details = response['station_details'];
                            console.log(station_details);

                            $('#txtSearchDeviceName').val(material_details);
                            $('#txtSeriesName', $('#formCNAssemblyRuncard')).val($('#txtSelectSeriesName').val());
                            $('#txtDeviceName', $('#formCNAssemblyRuncard')).val(material_details);

                            if(seriesName == 'CN171P-007-1002-VE(01)'){
                                $('#sSeriesName').prop('hidden', true);
                                $('#pSeriesName').prop('hidden', false);
                            }else if(seriesName == 'CN171S-007-1002-VE(01)'){
                                $('#sSeriesName').prop('hidden', false);
                                $('#pSeriesName').prop('hidden', true);
                            }

                            //STATIONS
                            let result = '<option value="" disabled selected>-- Select Station --</option>';
                            if (response['station_details'].length > 0) {
                                    result = '<option value="" disabled selected>-- Select Station --</option>';
                                for (let index = 0; index < response['station_details'].length; index++) {
                                    result += '<option value="' + response['station_details'][index].stations['id'] + '">' + response['station_details'][index].stations['station_name'] + '</option>';
                                }
                            } else {
                                result = '<option value="0" selected disabled> -- No record found -- </option>';
                            }
                            $('#txtSelectRuncardStation').html(result);
                            //STATIONS

                            dtAssemblyRuncard.draw();
                        }
                    });
                });

                $('#formCNAssemblyRuncard').keyup('#txtPONumber', delay(function(e){
                        let search_po_number_val = $('#txtPONumber').val();
                        $.ajax({
                            type: "get",
                            url: "get_data_from_2nd_molding",
                            data: {
                                "po_number" : search_po_number_val
                            },
                            dataType: "json",
                            success: function (response) {
                                let sm_runcard_data = response['sec_molding_runcard_data'];
                                // console.log(sm_runcard_data);
                                if(sm_runcard_data[0] == undefined){
                                    toastr.error('PO does not exists')
                                }else{
                                    $('#txtPartsCode', $('#formCNAssemblyRuncard')).val(sm_runcard_data[0]['parts_code']);
                                    $('#txtPoQuantity', $('#formCNAssemblyRuncard')).val(sm_runcard_data[0]['po_quantity']);
                                }
                            }
                        });
                }, 500));

                $('#btnAddCnAssemblyRuncard').on('click', function(e){
                    if($('#txtSelectSeriesName').val() != "" && $('#txtSearchDeviceName').val() != ""){
                        $('#modalCNAssembly').modal('show');

                        if($('#txtAssyRuncardId').val() == ''){
                            $('#btnAddRuncardStation').prop('disabled', true);
                        }else{
                            $('#btnAddRuncardStation').prop('disabled', false);
                        }
                    }
                    else{
                        toastr.error('Please Select Series Name')
                    }
                });

                $('#btnAddRuncardStation').on('click', function(e){
                     $('#modalAddStation').modal('show');
                     let runcard_id = $(this).attr('runcard_id');
                     $('#txtStationAssyRuncardId').val(runcard_id);
                });

                $("#modalCNAssembly").on('hidden.bs.modal', function () {
                    // Reset form values
                    $("#formCNAssemblyRuncard")[0].reset();

                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                });

                $("#modalAddStation").on('hidden.bs.modal', function () {
                    // Reset form values
                    $("#formAddAssemblyRuncardStation")[0].reset();

                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                });

                $('#btnRuncardDetails').click( function(e){
                    e.preventDefault();
                    // let data = $('#formCNAssemblyRuncard').serialize();
                    $.ajax({
                        type:"POST",
                        url: "add_assembly_runcard_data",
                        data: $('#formCNAssemblyRuncard').serialize(),
                        dataType: "json",
                        success: function(response){
                            if (response['result'] == 1 ) {
                                toastr.success('Successful!');
                                $("#modalCNAssembly").modal('hide');
                                dtAssemblyRuncard.draw();
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                            // console.log('success');
                        }
                    });
                });

                $('#btnSaveNewAssemblyRuncardStation').click( function(e){
                    e.preventDefault();
                    $.ajax({
                        type:"POST",
                        url: "add_assembly_runcard_station_data",
                        data: $('#formAddAssemblyRuncardStation').serialize(),
                        dataType: "json",
                        success: function(response){
                            if (response['result'] == 1) {
                                toastr.success('Successful!');
                                $("#modalAddStation").modal('hide');
                                dtAssemblyRuncardStation.draw();
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                            // console.log('station success');
                        }
                    });
                });

                $(document).on('click', '.btnUpdateAssemblyRuncardData',function(e){
                    e.preventDefault();
                    let assembly_runcard_id = $(this).attr('assembly_runcard-id');
                    $.ajax({
                        url: "get_assembly_runcard_data",
                        type: "get",
                        data: {
                            assy_runcard_id: assembly_runcard_id
                        },
                        dataType: "json",
                        beforeSend: function(){
                        },
                        success: function(response){
                            const assy_runcard_data = response['assembly_runcard_data'];
                            $('#modalCNAssembly').modal('show');

                            $('#formCNAssemblyRuncard #txtAssyRuncardId').val(assy_runcard_data[0].id);
                            $('#formCNAssemblyRuncard #txtSeriesName').val(assy_runcard_data[0].series_name);
                            $('#formCNAssemblyRuncard #txtDeviceName').val(assy_runcard_data[0].device_name);
                            $('#formCNAssemblyRuncard #txtPONumber').val(assy_runcard_data[0].po_number);
                            $('#formCNAssemblyRuncard #txtPartsCode').val(assy_runcard_data[0].parts_code);
                            $('#formCNAssemblyRuncard #txtPoQuantity').val(assy_runcard_data[0].po_quantity);
                            $('#formCNAssemblyRuncard #txtPZeroTwoProdLot').val(assy_runcard_data[0].p_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtPZeroTwoDeviceId').val(assy_runcard_data[0].p_zero_two_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroSevenProdLot').val(assy_runcard_data[0].s_zero_seven_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroSevenDeviceId').val(assy_runcard_data[0].s_zero_seven_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroTwoProdLot').val(assy_runcard_data[0].s_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroTwoDeviceId').val(assy_runcard_data[0].s_zero_two_device_id);
                            $('#formCNAssemblyRuncard #txtTotalAssyYield').val(assy_runcard_data[0].total_assembly_yield);
                            $('#formCNAssemblyRuncard #txtAveOveallYield').val(assy_runcard_data[0].average_overall_yield);

                            $('#btnAddRuncardStation').attr('runcard_id', assy_runcard_data[0].id);
                            //Enable Adding of Runcard Station
                            $('#btnAddRuncardStation').prop('disabled', false);

                            dtAssemblyRuncardStation.draw();
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }

                    });
                });

                $(document).on('click', '.btnUpdateAssyRuncardStationData',function(e){
                    e.preventDefault();
                    let assembly_runcard_id = $('#txtAssyRuncardId').val();
                    let assy_runcard_stations_id = $(this).attr('assy_runcard_stations-id');
                    $.ajax({
                        url: "get_assembly_runcard_data",
                        type: "get",
                        data: {
                            assy_runcard_id: assembly_runcard_id,
                            assy_runcard_station_id: assy_runcard_stations_id
                        },
                        dataType: "json",
                        beforeSend: function(){
                        },
                        success: function(response){
                            const assy_runcard_station_data = response['assembly_runcard_data'][0].assembly_runcard_station[0];
                            const mode_of_defect_data = response['mode_of_defect_data'];
                            console.log('log data', assy_runcard_station_data);

                            if(assy_runcard_station_data.station == 4 ){//Lubricant Coating Station
                                $('#LubricantCoatingDiv').prop('hidden', false);
                                $('#VisualInspDocNoDiv').prop('hidden', true);
                            }else if(assy_runcard_station_data.station == 5){// Visual Inspection
                                $('#LubricantCoatingDiv').prop('hidden', true);
                                $('#VisualInspDocNoDiv').prop('hidden', true);
                            }else if(assy_runcard_station_data.station == 6){// Visual Inspection
                                $('#LubricantCoatingDiv').prop('hidden', true);
                                $('#VisualInspDocNoDiv').prop('hidden', false);
                            }

                            $('#modalAddStation').modal('show');

                            //Stations Forms
                            $('#formAddAssemblyRuncardStation #txtStationAssyRuncardId').val(assy_runcard_station_data.assembly_runcards_id);
                            $('#formAddAssemblyRuncardStation #txtAssyRuncardStationId').val(assy_runcard_station_data.id);
                            $('#formAddAssemblyRuncardStation #txtSelectRuncardStation').val(assy_runcard_station_data.station);
                            $('#formAddAssemblyRuncardStation #txtDate').val(assy_runcard_station_data.date);
                            $('#formAddAssemblyRuncardStation #txtOperatorName').val(assy_runcard_station_data.user.firstname+' '+assy_runcard_station_data.user.firstname);
                            $('#formAddAssemblyRuncardStation #txtInputQuantity').val(assy_runcard_station_data.input_quantity);
                            $('#formAddAssemblyRuncardStation #txtNgQuantity').val(assy_runcard_station_data.ng_quantity);
                            $('#formAddAssemblyRuncardStation #txtOutputQuantity').val(assy_runcard_station_data.output_quantity);

                            $('#formAddAssemblyRuncardStation #txtStationYield').val(assy_runcard_station_data.station_yield);
                            $('#formAddAssemblyRuncardStation #txtModeOfDefect').val(assy_runcard_station_data.mode_of_defect);
                            $('#formAddAssemblyRuncardStation #txtDefectQuantity').val(assy_runcard_station_data.defect_qty);
                            $('#formAddAssemblyRuncardStation #txtMlPerShot').val(assy_runcard_station_data.ml_per_shot);
                            $('#formAddAssemblyRuncardStation #txtTotalLubricantUsage').val(assy_runcard_station_data.total_lubricant_usage);
                            $('#formAddAssemblyRuncardStation #txtDocNoWorkI').val(assy_runcard_station_data.doc_no_wi);
                            $('#formAddAssemblyRuncardStation #txtDocNoRDrawing').val(assy_runcard_station_data.doc_no_r_drawing);
                            $('#formAddAssemblyRuncardStation #txtDocNoADrawing').val(assy_runcard_station_data.doc_no_a_drawing);
                            $('#formAddAssemblyRuncardStation #txtDocNoGDrawing').val(assy_runcard_station_data.doc_no_g_drawing);
                            $('#formAddAssemblyRuncardStation #txtDateCode').val(assy_runcard_station_data.date_code);
                            $('#formAddAssemblyRuncardStation #txtBundleQuantity').val(assy_runcard_station_data.bundle_qty);

                            $('#formAddAssemblyRuncardStation #txtRemarks').val(assy_runcard_station_data.remarks);


                            for(let index = 0; index < mode_of_defect_data.length; index++){
                                let rowModeOfDefect = `
                                    <tr>
                                        <td>
                                            <select class="form-control select2bs5 selectMOD" name="mod_id[${mode_of_defect_data[index].mod_id}]" id="a">
                                                <option value="${mode_of_defect_data[index].mod_id}">${mode_of_defect_data[index].mode_of_defect[0].defects}</option>
                                            </select>
                                        </td>
                                        <td id=textMODQuantity>
                                            <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="${mode_of_defect_data[index].mod_quantity}" min="1">
                                        </td>
                                        <td id="buttonRemoveMOD">
                                            <center><button class="btn btn-md btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                                        </td>
                                    </tr>
                                `;
                                $("#tableAssemblyStationMOD tbody").append(rowModeOfDefect);
                                console.log('mod_id',mode_of_defect_data[index].mod_id);

                                //CLARK KULANG KAPA DITO

                                getModeOfDefect($("#tableAssemblyStationMOD tr:last").find('.selectMOD'), mode_of_defect_data[index].mod_id);
                                // console.log('test log',$('#tableAssemblyStationMOD .selectMOD option[value="'+mode_of_defect_data[index].mod_id+'"]]').attr('selected'));
                                // $('#tableAssemblyStationMOD .selectMOD select[name="mod_id[2]"]').find('option').val(mode_of_defect_data[index].mod_id);
                                // $('#tableAssemblyStationMOD tbody .selectMOD #a').val(3);

                                // $('#tableAssemblyStationMOD #a').val('3');
                            }
                            $("#labelTotalNumberOfNG").text(parseInt(0));
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });

                // $('#txtInputQuantity').keyup(function(e){
                //     // console.log('keyiup');
                //     let output_value = $('#txtInputQuantity').val() - $('#txtNgQuantity').val();
                //     $('#txtOutputQuantity').val(output_value);
                // });

                $('#txtNgQuantity, #txtInputQuantity, #txtMlPerShot').each(function(e){
                    $(this).keyup(function(e){
                        let input_val = parseFloat($('#txtInputQuantity').val());
                        let ng_val = parseFloat($('#txtNgQuantity').val());
                        CalculateTotalOutputandYield(input_val,ng_val);
                    });
                });

                $('#txtMlPerShot').keyup(function(e){
                    let input_val = parseFloat($('#txtInputQuantity').val());
                    let ng_val = parseFloat($('#txtNgQuantity').val());
                    let ml_per_shot = parseFloat($('#txtMlPerShot').val());
                    let output_value = input_val - ng_val;
                    let total_lube_usage = (output_value + ng_val) * ml_per_shot;
                    $('#txtTotalLubricantUsage').val(`${total_lube_usage.toFixed(2)}mL`);
                });

                const CalculateTotalOutputandYield = function (input_val,ng_val){
                    let output_value = input_val - ng_val;
                    let station_yield = (output_value / input_val) * 100;

                    if(input_val === "" || ng_val === "" || output_value < 0){
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Output Quantity cannot be less than Zero!",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#txtInputQuantity').val('');
                        $('#txtNgQuantity').val('');
                        $('#txtOutputQuantity').val(0);
                        $('#txtStationYield').val('0%');
                        return;
                    }
                    $('#txtOutputQuantity').val(output_value);
                    $('#txtStationYield').val(`${station_yield.toFixed(2)}%`);



                };
            });
        </script>
    @endsection
@endauth

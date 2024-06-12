@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Assembly Runcard')
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
                            <h1>Assembly Runcard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Assembly Runcard</li>
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
                                            <label class="form-label">Device Name</label>
                                            <div class="input-group mb-3">
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Select Device Name"></i>
                                                {{-- <select class="form-control select2bs5" id="txtSelectPONo" name="device_name" placeholder="Select PO Number"></select> --}}
                                                <select class="form-control" type="text" name="device_name" id="txtSelectDeviceName" required>
                                                    <option value="" disabled selected>Select Device Name</option>
                                                    <option value="CN171P-007-1002-VE(01)">CN171P-007-1002-VE(01)</option>
                                                    <option value="CN171S-007-1002-VE(01)">CN171S-007-1002-VE(01)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <label class="form-label">Device Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Device Code" id="txtSearchDeviceCode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="txtSearchMaterialName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <label class="form-label">Qty / Box</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Qty per Box" id="txtSearchReqOutput" readonly>
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
                                    <h3 class="card-title">CN Assembly</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="btnAddAssemblyRuncard"><i class="fa-solid fa-plus"></i> Add Assembly Runcard</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblAssemblyRuncard" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Device Name</th>
                                                    <th>PO Number</th>
                                                    <th>Runcard #</th>
                                                    <th>Lot Qty</th>
                                                    {{-- <th>Required Output</th> --}}
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
                                    {{-- <div class="row">
                                        <div class="col-sm-6 pl-4"> --}}
                                            <div class="py-3">
                                                <span class="badge badge-secondary">1.</span> Runcard Details
                                            </div>
                                            <div class="input-group input-group-sm mb-3 d-none">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Assembly Runcard ID</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtAssyRuncardId" name="assy_runcard_id" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDeviceName" name="device_name" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device Code</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDeviceCode" name="device_code" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Number</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtPONumber" name="po_number" placeholder="Search PO"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                            <div class="input-group input-group-sm mb-2">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Quantity</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtPoQuantity" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Required Qty</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtRequiredOutput" name="required_output" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Runcard No.</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtRuncardNo" name="runcard_no" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Shipment Output</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtShipmentOutput" name="shipment_output" placeholder="Auto generated" readonly>
                                            </div>

                                            <div id="pSeriesName" style="border:2px; border-style:dashed; padding:2px;">
                                                <div class="input-group input-group-sm mb-2">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="txtPZeroTwoMatName" name="p_zero_two_material_name" value="CN171P-02#IN-VE" readonly>
                                                </div>

                                                <div class="input-group input-group-sm mb-2">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Lot No</span>
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
                                                        <span class="input-group-text w-100" id="basic-addon1">PO No</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePO" name="p_zero_two_po_no" placeholder="Auto generated" readonly>
                                                </div>

                                                {{-- <div class="input-group input-group-sm mb-1">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">P-02#IN - PMI PO No</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                                </div> --}}

                                                <div class="input-group input-group-sm mb-2">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Material Qty</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="txtPZeroTwoDeviceQty" name="p_zero_two_dev_qty" placeholder="Auto generated" readonly>
                                                </div>
                                            </div>


                                            <div id="sSeriesName">
                                                <div style="border: 2px; border-style:dashed; padding:2px;">
                                                    <div class="input-group input-group-sm mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroSevenMatName" name="s_zero_seven_material_name" value="CN171S-07#IN-VE" readonly>
                                                    </div>

                                                    <div class="input-group input-group-sm mt-1 mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Lot No</span>
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
                                                            <span class="input-group-text w-100" id="basic-addon1">PO No</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroSevenDevicePO" name="s_zero_seven_po_no" placeholder="Auto generated" readonly>
                                                    </div>

                                                    {{-- <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">S-07#IN - PMI PO No</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroSevenDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                                    </div> --}}

                                                    <div class="input-group input-group-sm mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Material Qty</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroSevenDeviceQty" name="s_zero_seven_dev_qty" placeholder="Auto generated" readonly>
                                                    </div>
                                                </div>

                                                <div style="border: 2px; border-style:dashed; padding:2px;" class="border-top-0">
                                                    <div class="input-group input-group-sm mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroTwoMatName" name="s_zero_two_material_name" value="CN171S-02#MO-VE" readonly>
                                                    </div>

                                                    <div class="input-group input-group-sm mt-1 mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Lot No</span>
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
                                                            <span class="input-group-text w-100" id="basic-addon1">PO No</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroTwoDevicePO" name="s_zero_two_po_no" placeholder="Auto generated" readonly>
                                                    </div>

                                                    {{-- <div class="input-group input-group-sm mb-1">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">PMI PO No</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroTwoDevicePMIPO" name="po_quantity" placeholder="Auto generated" readonly>
                                                    </div> --}}

                                                    <div class="input-group input-group-sm mb-2">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Material Qty</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtSZeroTwoDeviceQty" name="s_zero_two_dev_qty" placeholder="Auto generated" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div> --}}
                                        {{-- <div class="col-sm-6 pr-4"> --}}
                                            {{-- <div class="py-3">
                                                <span>&nbsp;</span>
                                            </div> --}}
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
                                        {{-- </div>
                                    </div>   --}}
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
                            <button type="button" id="btnSubmitAssemblyRuncardData" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
                                        <select class="form-control" type="text" id="txtSelectRuncardStation" placeholder="Station" disabled>
                                        </select>
                                        <input type="text" class="form-control form-control-sm" id="txtRuncardStation" name="runcard_station" placeholder="Station" hidden>
                                        <input type="text" class="form-control form-control-sm" id="txtStep" name="step" placeholder="Station Step" hidden>
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
                                            <input type="date" class="form-control form-control-sm" id="txtDate" name="date" value="<?php echo date('Y-m-d'); ?>" readonly>
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
                            <div id="LubricantCoatingDiv" class="d-none">
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
                            <div id="VisualInspDocNoDiv" class="d-none">
                                {{-- <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (WI)</span>
                                            </div>
                                                <input type="text" class="form-control form-control-sm" id="txtDocNoWorkI" name="doc_no_work_i">
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- DROPDOWN --}}
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <div id="BDrawingDiv" class="input-group-prepend">
                                                </div>
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (R Drawing):</span>
                                            </div>
                                            <select class="form-control form-control-sm" id="txtSelectDocNoRDrawing" name="doc_no_r_drawing"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <div id="InspStandardDiv" class="input-group-prepend">
                                                </div>
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (A Drawing):</span>
                                            </div>
                                            <select class="form-control form-control-sm" id="txtSelectDocNoADrawing" name="doc_no_a_drawing"></select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <div id="UDDiv" class="input-group-prepend">
                                                </div>
                                                <span class="input-group-text w-100" id="basic-addon1">Doc No. (G Drawing):</span>
                                            </div>
                                            <select class="form-control form-control-sm" id="txtSelectDocNoGDrawing" name="doc_no_g_drawing"></select>
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

        {{-- MODAL FOR PRINTING  --}}
        <div class="modal fade" id="modalAssemblyPrintQr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Assembly - QR Code</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- PO 1 -->
                            <div class="col-sm-12">
                                <center><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->errorCorrection('H')->generate('0')) !!}" id="img_barcode_PO" style="max-width: 200px;"><br></center>
                                <label id="img_barcode_PO_text"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnAssemblyPrintQrCode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
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

    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){

                $('.select2bs5').select2( {
                    theme: 'bootstrap-5'
                });

                $('#txtSelectDocNoRDrawing').on('change', function() {
                    if($('#txtSelectDocNoRDrawing').val() === null || $('#txtSelectDocNoRDrawing').val() === undefined){
                        console.log('b drawing', 'disabled');
                        $("#btnViewBDrawings").prop('disabled', true);
                    }else{
                        console.log('b drawing', 'enabled');
                        $("#btnViewBDrawings").prop('disabled', false);
                    }
                });

                $('#txtSelectDocNoADrawing').on('change', function() {
                    if($('#txtSelectDocNoADrawing').val() === null || $('#txtSelectDocNoADrawing').val() === undefined){
                        console.log('b drawing', 'disabled');
                        $("#btnViewInspStdDrawings").prop('disabled', true);
                    }else{
                        console.log('b drawing', 'enabled');
                        $("#btnViewInspStdDrawings").prop('disabled', false);
                    }
                });

                $('#txtSelectDocNoGDrawing').on('change', function() {
                    if($('#txtSelectDocNoGDrawing').val() === null || $('#txtSelectDocNoGDrawing').val() === undefined){
                        console.log('b drawing', 'disabled');
                        $("#btnViewUdDrawings").prop('disabled', true);
                    }else{
                        console.log('b drawing', 'enabled');
                        $("#btnViewUdDrawings").prop('disabled', false);
                    }
                });

                ViewDocument($('#txtSelectDocNoRDrawing').val(), $('#BDrawingDiv'), 'btnViewBDrawings');
                ViewDocument($('#txtSelectDocNoADrawing').val(), $('#InspStandardDiv'), 'btnViewInspStdDrawings');
                ViewDocument($('#txtSelectDocNoGDrawing').val(), $('#UDDiv'), 'btnViewUdDrawings');

                $('#btnViewBDrawings').on('click', function(){
                    redirect_to_drawing($('#txtSelectDocNoRDrawing').val());
                });
                $('#btnViewInspStdDrawings').on('click', function(){
                    redirect_to_drawing($('#txtSelectDocNoADrawing').val());
                });
                $('#btnViewUdDrawings').on('click', function(){
                    redirect_to_drawing($('#txtSelectDocNoGDrawing').val());
                });

                function ViewDocument(document_no, div_id, btn_id){
                    // let doc_no ='<a href="download_file/'+document_no+'">';
                    let doc_no ='<button type="button" id="'+btn_id+'" class="btn btn-sm btn-primary">';
                        doc_no +=     '<i class="fa fa-file" data-bs-toggle="tooltip" data-bs-html="true" title="See Document in ACDCS"></i>';
                        doc_no +='</button>';
                        // doc_no +='</a>';
                        // <button type="button" class="btn btn-dark" id="btnViewRDrawings"><i class="fa fa-file" title="View"></i></button>
                    div_id.append(doc_no);
                }

                function redirect_to_drawing(drawing) {
                    console.log('Drawing No.:',drawing)
                    if( drawing  == 'N/A'){
                        alert('Document No does not exist')
                    }
                    else{
                        window.open("http://rapid/ACDCS/prdn_home_pats_ppd?doc_no="+drawing)
                    }
                }

                function GetRDrawingFromACDCS(doc_title, doc_type, cboElement, DocumentNo){
                    GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, DocumentNo);
                };

                function GetADrawingFromACDCS(doc_title, doc_type, cboElement, DocumentNo){
                    GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, DocumentNo);
                };

                function GetGDrawingFromACDCS(doc_title, doc_type, cboElement, DocumentNo){
                    GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, DocumentNo);
                };

                function GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, DocumentNo = null){
                    let result = '<option value="" disabled selected>--Select Document No.--</option>';

                    $.ajax({
                        url: 'get_data_from_acdcs',
                        method: 'get',
                        data: {
                            'doc_title': doc_title,
                            'doc_type': doc_type
                        },
                        dataType: 'json',
                        beforeSend: function() {
                                result = '<option value="0" disabled selected>--Loading--</option>';
                                cboElement.html(result);
                        },
                        success: function(response) {
                            if (response['acdcs_data'].length > 0) {

                                    result = '<option value="" disabled selected>--Select Document No.--</option>';
                                if(response['acdcs_data'][0].doc_type != 'B Drawing'){
                                    result += '<option value="N/A"> N/A </option>';
                                }

                                // result = '<option value="" selected>-- N/A --</option>';
                                for (let index = 0; index < response['acdcs_data'].length; index++) {
                                    result += '<option value="' + response['acdcs_data'][index].doc_no + '">' + response['acdcs_data'][index].doc_no + '</option>';
                                }
                            } else {
                                result = '<option value="0" selected disabled> -- No record found -- </option>';
                            }
                            cboElement.html(result);
                            if(DocumentNo != null){
                                cboElement.val(DocumentNo).trigger('change');
                            }
                        },
                        error: function(data, xhr, status) {
                            result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                            cboElement.html(result);
                            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }

                dtAssemblyRuncard = $("#tblAssemblyRuncard").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_assembly_runcard",
                        data: function (param){
                            param.device_name = $("#txtSelectDeviceName").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "po_number" },
                        // { "data" : "required_output" },
                        { "data" : "runcard_no" },
                        { "data" : "shipment_output" },
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
                        },
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

                    // $('#tableAssemblyStationMOD .textMODQuantity').each(function() {
                    //     if($(this).val() === null || $(this).val() === ""){
                    //         $("#tableAssemblyStationMOD tbody").empty();
                    //         $("#labelTotalNumberOfNG").text(parseInt(0));
                    //     }
                    //     totalNumberOfMOD += parseInt($(this).val());
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
                            // result = '';
                            result = `<option value="0" selected disabled> Please Select Mode of Defect </option>`;
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
                    $('#tableAssemblyStationMOD .textMODQuantity').each(function(){
                        totalNumberOfMOD += parseInt($(this).val());
                        if(totalNumberOfMOD > ngQty){
                            $("#tableAssemblyStationMOD tbody").empty();
                            $("#labelTotalNumberOfNG").text(parseInt(0));
                        }
                    });

                    if(parseInt(ngQty) === totalNumberOfMOD){
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $('#labelIsTally').css({color: 'green'})
                        $('#labelIsTally').addClass('fa-thumbs-up')
                        $('#labelIsTally').removeClass('fa-thumbs-down')
                        $('#labelIsTally').attr('title','')
                        // $("#btnAddRuncardStation").prop('disabled', false);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', false);
                    }else if(parseInt(ngQty) < totalNumberOfMOD){
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
                    }else if(parseInt(ngQty) > totalNumberOfMOD){
                        console.log('Mode of Defect & NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $('#labelIsTally').css({color: 'red'})
                        $('#labelIsTally').addClass('fa-thumbs-down')
                        $('#labelIsTally').removeClass('fa-thumbs-up')
                        $('#labelIsTally').attr('title','Mode of Defect & NG Qty are not tally!')
                        // $("#btnAddRuncardStation").prop('disabled', true);
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

                $(document).on('keyup','.textMODQuantity', function (e){
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
                        $('#tableAssemblyStationMOD tbody').empty();
                        $('#buttonAddAssemblyModeOfDefect').prop('disabled', true);
                        $("#labelTotalNumberOfNG").text(parseInt(0));
                    }

                    if(parseInt(ngQty) === parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $('#labelIsTally').css({color: 'green'})
                        $('#labelIsTally').addClass('fa-thumbs-up')
                        $('#labelIsTally').removeClass('fa-thumbs-down')
                        // $("#btnAddRuncardStation").prop('disabled', false);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', false);
                    }else if(parseInt(ngQty) > parseInt($('#labelTotalNumberOfNG').text())){
                        console.log('Mode of Defect NG is greater than NG qty');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $('#labelIsTally').css({color: 'red'})
                        $('#labelIsTally').addClass('fa-thumbs-down')
                        $('#labelIsTally').removeClass('fa-thumbs-up')

                        // $("#btnAddRuncardStation").prop('disabled', true);
                        $("#buttonAddAssemblyModeOfDefect").prop('disabled', false);
                        $("#btnSaveNewAssemblyRuncardStation").prop('disabled', true);
                    }

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
                    const qrScannerValue = $('#textQrScanner').val();
                    let ScanQrCodeVal = JSON.parse(qrScannerValue)
                            // getLotNo =  ScanQrCodeVal.lot_no
                        // qrScannerValue = qrScannerValue.lot_no;
                        // console.log(qrScannerValue.lot_no);
                    let formId = $('#modalQrScanner').attr('data-form-id');
                    if( e.keyCode == 13 ){
                        $('#textQrScanner').val(''); // Clear after enter
                        switch (formId) {
                            case 'ScanPZeroTwoProdLot':
                                production_lot_no = ScanQrCodeVal.production_lot;
                                verifyProdLotfromMolding(production_lot_no, '', formId, 'txtPZeroTwoProdLot', 'txtPZeroTwoDeviceId', 'CN171P-02#IN-VE', 'txtPZeroTwoDevicePO','txtPZeroTwoDeviceQty');
                                break;
                            case 'ScanSZeroSevenProdLot':
                                production_lot_no = ScanQrCodeVal.production_lot;
                                verifyProdLotfromMolding(production_lot_no, '', formId, 'txtSZeroSevenProdLot', 'txtSZeroSevenDeviceId', 'CN171S-07#IN-VE', 'txtSZeroSevenDevicePO','txtSZeroSevenDeviceQty');
                                break;
                            case 'ScanSZeroTwoProdLot':
                                production_lot_no = ScanQrCodeVal.lot_no;
                                production_lot_ext = ScanQrCodeVal.lot_no_ext;
                                verifyProdLotfromMolding(production_lot_no, production_lot_ext, formId, 'txtSZeroTwoProdLot', 'txtSZeroTwoDeviceId', 'CN171S-02#MO-VE', 'txtSZeroTwoDevicePO', 'txtSZeroTwoDeviceQty');
                                break;
                            default:
                                break;
                        }
                    }
                }, 100));
                // NEW CODE TESTIN

                const verifyProdLotfromMolding = (production_lot_no, production_lot_ext, ScanProdLotValue, textLotNumberValue, textLotNumberIdValue, SecondMoldingDeviceName, DevicePO, DeviceQty) => {
                    let route;
                    if(ScanProdLotValue == 'ScanSZeroTwoProdLot'){ //
                        route = 'chk_device_prod_lot_from_first_molding';
                        // production_lot_no = ScanQrCodeVal.lot_no;
                    }else if(ScanProdLotValue == 'ScanPZeroTwoProdLot' || ScanProdLotValue == 'ScanSZeroSevenProdLot'){
                        route = 'chk_device_prod_lot_from_sec_molding';
                        // production_lot_no = ScanQrCodeVal.production_lot;
                    }

                    $.ajax({
                        type: "get",
                        url: route,
                        data: {
                            production_lot: production_lot_no,
                            production_lot_ext: production_lot_ext,
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response['device_id'] == '' && response['production_lot'] == ''){
                                toastr.error('Production Lot Does Not Exists.')
                            }else{
                                $(`#${textLotNumberValue}`).val('');
                                $(`#${textLotNumberIdValue}`).val('');
                                $(`#${DevicePO}`).val('');
                                $(`#${DeviceQty}`).val('');

                                if(response['device_name'] == SecondMoldingDeviceName){
                                    $(`#${textLotNumberValue}`).val(response['production_lot']);
                                    $(`#${textLotNumberIdValue}`).val(response['device_id']);
                                    $(`#${DevicePO}`).val(response['yec_po_number']);
                                    $(`#${DeviceQty}`).val(response['shipment_output']);
                                    $('#modalQrScanner').modal('hide');
                                }else{
                                    toastr.error('Production Lot Does Not Match to Material Name')
                                }
                            }
                        }
                    });
                }

                // $('#txtSelectRuncardStation').on('change', function(e){
                //     if($(this).val() == 4){//Lubricant Coating Station
                //         $('#LubricantCoatingDiv').removeClass('d-none');
                //         $('#VisualInspDocNoDiv').addClass('d-none');
                //     }else if($(this).val() == 6){// Visual Inspection
                //         $('#LubricantCoatingDiv').addClass('d-none');
                //         $('#VisualInspDocNoDiv').removeClass('d-none');
                //     }else{
                //         $('#LubricantCoatingDiv').addClass('d-none');
                //         $('#VisualInspDocNoDiv').addClass('d-none');
                //     }
                //     // // if(assy_runcard_station_data.station == 4){
                //     // if(assy_runcard_station_data.station_name.station_name == 'Lot Marking'){//Lubricant Coating Station
                //     //     $('#LubricantCoatingDiv').removeClass('d-none');
                //     //     $('#VisualInspDocNoDiv').addClass('d-none');
                //     // }else if(assy_runcard_station_data.station_name.station_name == 'Visual Inspection'){// Visual Inspection
                //     // // }else if(assy_runcard_station_data.station_step == 6){// Visual Inspection
                //     //     $('#LubricantCoatingDiv').addClass('d-none');
                //     //     $('#VisualInspDocNoDiv').removeClass('d-none');
                //     // }else{
                //     //     $('#LubricantCoatingDiv').addClass('d-none');
                //     //     $('#VisualInspDocNoDiv').addClass('d-none');
                //     // }
                // });

                $('#txtSelectDeviceName').on('change', function(e){
                    let deviceName = $('#txtSelectDeviceName').val();
                    $.ajax({
                        type: "get",
                        url: "get_data_from_matrix",
                        data: {
                            "device_name" : deviceName
                        },
                        dataType: "json",
                        beforeSend: function(){
                            // prodData = {};
                        },
                        success: function (response) {
                            let device_details = response['device_details'];
                            let material_details = response['material_details'];
                            // let station_details = response['station_details'];
                            // console.log(station_details);

                            $('#txtSearchDeviceCode').val(device_details[0].code);
                            $('#txtSearchMaterialName').val(material_details);
                            $('#txtSearchReqOutput').val(device_details[0].qty_per_reel);

                            // $('#txtDeviceName', $('#formCNAssemblyRuncard')).val($('#txtSelectDeviceName').val());
                            // $('#txtMaterialName', $('#formCNAssemblyRuncard')).val(material_details);

                            if(deviceName == 'CN171P-007-1002-VE(01)'){
                                $('#sSeriesName').prop('hidden', true);
                                $('#pSeriesName').prop('hidden', false);
                            }else if(deviceName == 'CN171S-007-1002-VE(01)'){
                                $('#sSeriesName').prop('hidden', false);
                                $('#pSeriesName').prop('hidden', true);
                            }

                            //STATIONS
                            let result = '<option value="" disabled selected>-- Select Station --</option>';
                            if (device_details[0].material_process.length > 0) {
                                    result = '<option value="" disabled selected>-- Select Station --</option>';
                                for (let index = 0; index < device_details[0].material_process.length; index++) {
                                    result += '<option value="' + device_details[0].material_process[index].station_details[0].stations['id'] + '">' + device_details[0].material_process[index].station_details[0].stations['station_name'] + '</option>';
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

                /* SEARCH PO COMMENTED BY CLARK */
                // $('#formCNAssemblyRuncard').keyup('#txtPONumber', delay(function(e){
                //         let search_po_number_val = $('#txtPONumber').val();
                //         $.ajax({
                //             type: "get",
                //             url: "get_data_from_2nd_molding",
                //             data: {
                //                 "po_number" : search_po_number_val
                //             },
                //             dataType: "json",
                //             success: function (response) {
                //                 let sm_runcard_data = response['sec_molding_runcard_data'];
                //                 // console.log(sm_runcard_data);
                //                 if(sm_runcard_data[0] == undefined){
                //                     toastr.error('PO does not exists')
                //                 }else{
                //                     $('#txtPartsCode', $('#formCNAssemblyRuncard')).val(sm_runcard_data[0]['parts_code']);
                //                     $('#txtPoQuantity', $('#formCNAssemblyRuncard')).val(sm_runcard_data[0]['po_quantity']);
                //                 }
                //             }
                //         });
                // }, 500));
                /* SEARCH PO COMMENTED BY CLARK END*/

                // CREATE RUNCARD BASED ON PO
                $('#formCNAssemblyRuncard #txtPONumber').keyup(delay(function(e){
                    let txtPONumber = $('#formCNAssemblyRuncard').find('#txtPONumber').val();
                    let txtDeviceName = $('#formCNAssemblyRuncard').find('#txtDeviceName').val();

                    // $.ajax({
                    //     type: "get",
                    //     // url: "http://rapidx/rapidx-api/api/ypics_clark.php",
                    //     url: "http://rapid/NAAYES/api/ypics.php",
                    //     data: {
                    //         po_number : txtPONumber,
                    //     },
                    //     dataType: "json",
                    //     success: function (response) {
                    //         console.log(response);
                    //     }
                    // });
                    data = {
                        'po_no'        : txtPONumber,
                        'device_name'  : txtDeviceName,
                    };
                    $.ajax({
                        'data'      : data,
                        'type'      : 'get',
                        'dataType'  : 'json',
                        'url'       : 'http://rapid/NAAYES/api/ypics_ppd.php',
                        success : function(data){
                            console.log('ypics',data);
                            if(data == ""){
                                toastr.error("No Data Found");
                                $('#formCNAssemblyRuncard').find('#txtRuncardNo').val('');
                                $('#formCNAssemblyRuncard').find('#txtPoQuantity').val('');
                            }else{
                                $('#formCNAssemblyRuncard').find('#txtPoQuantity').val(data['PO_QTY']);
                                let txtRuncard = txtPONumber.slice(5,10);

                                $.ajax({
                                    type: "get",
                                    url: "get_assembly_runcard_data",
                                    data: {
                                        po_number: txtPONumber,
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        let result = response['assembly_runcard_data'];
                                        runcardCount = result.length;

                                        if(result.length == 0){
                                            runcardCount = 1;
                                        }else{
                                            runcardCount = (result.length + 1);
                                        }
                                        $('#txtRuncardNo').val(txtRuncard +'-'+ runcardCount);
                                    }
                                });
                            }
                        }
                    });
                }, 700));
                // CREATE RUNCARD BASED ON PO END

                $('#btnAddAssemblyRuncard').on('click', function(e){
                    if($('#txtSelectDeviceName').val() != "" && $('#txtSearchMaterialName').val() != ""){

                        $('#modalCNAssembly').modal('show');
                        $('#txtDeviceName').val($('#txtSelectDeviceName').val());
                        $('#txtDeviceCode').val($('#txtSearchDeviceCode').val());

                        if($('#txtAssyRuncardId').val() == ''){
                            $('#btnAddRuncardStation').prop('disabled', true);
                        }else{
                            $('#btnAddRuncardStation').prop('disabled', false);
                        }

                        $('#txtRequiredOutput').val($('#txtSearchReqOutput').val());

                        GetRDrawingFromACDCS($('#txtDeviceName').val(), 'R Drawing', $("#txtSelectDocNoRDrawing"));
                        GetADrawingFromACDCS($('#txtDeviceName').val(), 'A Drawing', $("#txtSelectDocNoADrawing"));
                        GetGDrawingFromACDCS($('#txtDeviceName').val(), 'G Drawing', $("#txtSelectDocNoGDrawing"));

                        // $.ajax({
                        //     type: "get",
                        //     url: "get_total_yield",
                        //     data: "data",
                        //     dataType: "json",
                        //     success: function (response) {

                        //     }
                        // });
                    }
                    else{
                        toastr.error('Please Select Device Name')
                    }
                });


                $(document).on('click', '#btnSubmitAssemblyRuncardData',function(e){
                    let _token = '{{ csrf_token() }}';
                    let runcard_id = $('#txtAssyRuncardId').val();
                    $.ajax({
                        type: "post",
                        url: "update_assy_runcard_status",
                        data: {
                            '_token': _token,
                            'runcard_id': runcard_id
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response['result'] == 1 ) {
                                toastr.success('Successful!');
                                $("#modalCNAssembly").modal('hide');
                                dtAssemblyRuncard.draw();
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                        }
                    });
                });

                // clark ongoing
                $('#btnAddRuncardStation').on('click', function(e){
                    $('#modalAddStation').modal('show');
                    let runcard_id = $(this).attr('runcard_id');

                    $('#txtInputQuantity').prop('disabled', false);
                    $('#txtNgQuantity').prop('disabled', false);
                    $('#txtDocNoRDrawing').prop('disabled', false);
                    $('#txtDocNoADrawing').prop('disabled', false);
                    $('#txtDocNoGDrawing').prop('disabled', false);
                    $('#txtRemarks').prop('disabled', false);
                    $('#buttonAddAssemblyModeOfDefect').prop('hidden', false);
                    $('.buttonRemoveMOD').prop('disabled', false);
                    $('#btnSaveNewAssemblyRuncardStation').prop('hidden', false);

                    CheckExistingStations(runcard_id);
                    // $.ajax({
                    //     type: "get",
                    //     url: "chck_existing_stations",
                    //     data: {
                    //         "runcard_id" : runcard_id,
                    //     },
                    //     dataType: "json",
                    //     success: function (response){
                    //         GetStations($('#txtSelectRuncardStation'), response['current_step']);
                    //         $('#txtStep').val(response['current_step']);
                    //         if(response['output_quantity'] != ''){
                    //             $('#txtInputQuantity').val(response['output_quantity']);
                    //             $('#txtInputQuantity').prop('readonly', true);
                    //         }
                    //     }
                    // });

                     $('#txtStationAssyRuncardId').val(runcard_id);
                     $("#buttonAddAssemblyModeOfDefect").prop('disabled', true);
                });

                function GetStations(cboElement, step = null){
                    let result = '<option value="" disabled selected>-- Select Station --</option>';
                    let deviceName = $('#txtSelectDeviceName').val();
                    $.ajax({
                        type: "get",
                        url: "get_data_from_matrix",
                        data: {
                            "device_name" : deviceName
                        },
                        dataType: "json",
                        beforeSend: function(){
                            result = '<option value="0" disabled selected>--Loading--</option>';
                            // cboElement.html(result);
                        },
                        success: function (response) {
                            let device_details = response['device_details'];

                            if (device_details[0].material_process.length > 0) {
                                    result = '<option value="" disabled selected>-- Select Station --</option>';
                                    // result += '<option step="0" value="">-- CLARK --</option>';
                                for (let index = 0; index < device_details[0].material_process.length; index++) {
                                    result += '<option step="'+ device_details[0].material_process[index].step +'" value="' + device_details[0].material_process[index].station_details[0].stations['id'] + '">' + device_details[0].material_process[index].station_details[0].stations['station_name'] + '</option>';
                                }
                            } else {
                                result = '<option value="0" selected disabled> -- No record found -- </option>';
                            }
                            cboElement.html(result);

                            $("#txtSelectRuncardStation option[step='"+step+"']").attr('selected', true);
                            $("#txtRuncardStation").val($("#txtSelectRuncardStation option[step='"+step+"']").val());

                            if(deviceName == 'CN171P-007-1002-VE(01)'){
                                if(step == 1){//Lubricant Coating Station
                                    // $('#LubricantCoatingDiv').removeClass('d-none');
                                    $('#LubricantCoatingDiv').addClass('d-none');
                                    $('#VisualInspDocNoDiv').addClass('d-none');
                                }else{
                                    $('#LubricantCoatingDiv').addClass('d-none');
                                    $('#VisualInspDocNoDiv').removeClass('d-none');
                                }
                            }else if(deviceName == 'CN171S-007-1002-VE(01)'){
                                if(step == 3){// Visual Inspection
                                    $('#LubricantCoatingDiv').addClass('d-none');
                                    $('#VisualInspDocNoDiv').removeClass('d-none');
                                }else{
                                    $('#LubricantCoatingDiv').addClass('d-none');
                                    $('#VisualInspDocNoDiv').addClass('d-none');
                                }
                            }
                        },
                        error: function(data, xhr, status) {
                            result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                            cboElement.html(result);
                            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }

                $("#modalCNAssembly").on('hidden.bs.modal', function () {
                    // Reset form values
                    $("#formCNAssemblyRuncard")[0].reset();
                    dtAssemblyRuncardStation.draw();
                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                });

                $("#modalAddStation").on('hidden.bs.modal', function () {
                    // Reset form values
                    $("#formAddAssemblyRuncardStation")[0].reset();
                    $("#tableAssemblyStationMOD tbody").empty();
                    $("#labelTotalNumberOfNG").text(parseInt(0));
                    $('#LubricantCoatingDiv').addClass('d-none', true);
                    $('#VisualInspDocNoDiv').addClass('d-none', true);

                    // $("#labelTotalNumberOfNG").val('');
                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                });

                // CLARK TO BE CONTINUED

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

                //clark ongoing
                function CheckExistingStations(runcard_id){
                    $.ajax({
                        type: "get",
                        url: "chck_existing_stations",
                        data: {
                            "runcard_id" : runcard_id,
                        },
                        dataType: "json",
                        success: function (response){
                            GetStations($('#txtSelectRuncardStation'), response['current_step']);
                            $('#txtStep').val(response['current_step']);

                            if(response['output_quantity'] != ''){
                                $('#txtInputQuantity').val(response['output_quantity']);
                                $('#txtInputQuantity').prop('readonly', true);
                            }

                            if(response['current_step'] == 0){
                                $('#btnAddRuncardStation').prop('disabled', true);
                            }else{
                                $('#btnAddRuncardStation').prop('disabled', false);
                            }
                        }
                    });
                    // let runcard_id = $('#txtAssyRuncardId').val();
                    // $.ajax({
                    //     type: "get",
                    //     url: "chck_existing_stations",
                    //     data: {
                    //         "runcard_id" : runcard_id,
                    //     },
                    //     dataType: "json",
                    //     success: function (response){
                    //         if(response['current_step'] == 0){
                    //             $('#btnAddRuncardStation').prop('disabled', true);
                    //         }else{
                    //             $('#btnAddRuncardStation').prop('disabled', false);
                    //         }
                    //     }
                    // });
                }

                $(document).on('click', '#btnSaveNewAssemblyRuncardStation',function(e){
                    e.preventDefault();
                    $.ajax({
                        type:"POST",
                        url: "add_assembly_runcard_station_data",
                        data: $('#formAddAssemblyRuncardStation').serialize(),
                        dataType: "json",
                        success: function(response){
                            if (response['result'] == 1) {
                                toastr.success('Successful!');
                                $('#txtShipmentOutput').val(response['shipment_output']);
                                $("#modalAddStation").modal('hide');
                                dtAssemblyRuncardStation.draw();

                                CheckExistingStations($('#txtAssyRuncardId').val());

                                // if($('#txtAssyRuncardId').val() == ''){
                                //     $('#btnAddRuncardStation').prop('disabled', true);
                                // }else{
                                //     $('#btnAddRuncardStation').prop('disabled', false);
                                // }
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
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
                            // $('#btnSubmitAssemblyRuncardData').prop('disabled', true);
                        },
                        success: function(response){
                            const assy_runcard_data = response['assembly_runcard_data'];
                            // if(assy_runcard_data[0].assembly_runcard_station.length > 2){
                            //     // $('#btnSubmitAssemblyRuncardData').prop('disabled', false);
                            //     $('#btnAddRuncardStation').prop('disabled', true);
                            // }else{
                            //     //Enable Adding of Runcard Station
                            //     // $('#btnSubmitAssemblyRuncardData').prop('disabled', true);
                            //     $('#btnAddRuncardStation').prop('disabled', false);
                            // }
                            CheckExistingStations(assembly_runcard_id);

                            $('#txtSelectDocNoRDrawing').prop('disabled', false);
                            $('#txtSelectDocNoADrawing').prop('disabled', false);
                            $('#txtSelectDocNoGDrawing').prop('disabled', false);

                            $('#btnRuncardDetails').prop('hidden', false);
                            $('#txtPONumber').prop('disabled', false);
                            $('#btnScanSZeroSevenProdLot').prop('disabled', false);
                            $('#btnScanSZeroTwoProdLot').prop('disabled', false);
                            $('#btnAddRuncardStation').prop('hidden', false);
                            $('#btnSubmitAssemblyRuncardData').prop('hidden', false);

                            $('#modalCNAssembly').modal('show');
                            $('#formCNAssemblyRuncard #txtAssyRuncardId').val(assy_runcard_data[0].id);
                            $('#formCNAssemblyRuncard #txtDeviceCode').val(assy_runcard_data[0].part_code);
                            $('#formCNAssemblyRuncard #txtDeviceName').val(assy_runcard_data[0].device_name);
                            $('#formCNAssemblyRuncard #txtMaterialName').val(assy_runcard_data[0].material_name);
                            $('#formCNAssemblyRuncard #txtPONumber').val(assy_runcard_data[0].po_number);
                            // $('#formCNAssemblyRuncard #txtPartsCode').val(assy_runcard_data[0].parts_code);
                            $('#formCNAssemblyRuncard #txtPoQuantity').val(assy_runcard_data[0].po_quantity);
                            $('#formCNAssemblyRuncard #txtRequiredOutput').val(assy_runcard_data[0].required_output);
                            $('#formCNAssemblyRuncard #txtRuncardNo').val(assy_runcard_data[0].runcard_no);
                            $('#formCNAssemblyRuncard #txtShipmentOutput').val(assy_runcard_data[0].shipment_output);
                            $('#formCNAssemblyRuncard #txtPZeroTwoProdLot').val(assy_runcard_data[0].p_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtPZeroTwoDeviceId').val(assy_runcard_data[0].p_zero_two_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroSevenProdLot').val(assy_runcard_data[0].s_zero_seven_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroSevenDeviceId').val(assy_runcard_data[0].s_zero_seven_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroTwoProdLot').val(assy_runcard_data[0].s_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroTwoDeviceId').val(assy_runcard_data[0].s_zero_two_device_id);
                            // $('#formCNAssemblyRuncard #txtTotalAssyYield').val(assy_runcard_data[0].total_assembly_yield);

                            let total_assy_yield = 0;
                            for (let index = 0; index < assy_runcard_data[0].assembly_runcard_station.length; index++) {
                                let output = assy_runcard_data[0].assembly_runcard_station[index].output_quantity;
                                let input = assy_runcard_data[0].assembly_runcard_station[index].input_quantity;
                                let station_yield = ( output / input ) * 100;
                                total_assy_yield += station_yield;
                            }

                            $('#formCNAssemblyRuncard #txtTotalAssyYield').val(`${total_assy_yield.toFixed(2)}%`);
                            // `${station_yield.toFixed(2)}%`
                            // $('#formCNAssemblyRuncard #txtAveOveallYield').val(assy_runcard_data[0].average_overall_yield);

                            $('#btnAddRuncardStation').attr('runcard_id', assy_runcard_data[0].id);

                            let s_zero_two_prod_lot = assy_runcard_data[0].s_zero_two_prod_lot;

                            s_zero_two_prod_lot_split = s_zero_two_prod_lot.split('-');
                            s_zero_two_prod_lot = s_zero_two_prod_lot_split[0] +'-'

                            // s_zero_two_prod_lot_ext = s_zero_two_prod_lot.split('-');
                            if(s_zero_two_prod_lot_split.length > 3){
                                s_zero_two_prod_lot_ext = s_zero_two_prod_lot_split[1] +'-'+ s_zero_two_prod_lot_split[2] +'-'+ s_zero_two_prod_lot_split[3];
                            }else{
                                s_zero_two_prod_lot_ext = s_zero_two_prod_lot_split[1] +'-'+ s_zero_two_prod_lot_split[2];
                            }
                            // s_zero_two_prod_lot_ext = s_zero_two_prod_lot_split[1] +'-'+ s_zero_two_prod_lot_split[2] +'-'+ s_zero_two_prod_lot_split[3];

                            verifyProdLotfromMolding(assy_runcard_data[0].s_zero_seven_prod_lot, '', 'ScanSZeroSevenProdLot', 'txtSZeroSevenProdLot', 'txtSZeroSevenDeviceId', 'CN171S-07#IN-VE', 'txtSZeroSevenDevicePO' ,'txtSZeroSevenDeviceQty');
                            verifyProdLotfromMolding(s_zero_two_prod_lot, s_zero_two_prod_lot_ext, 'ScanSZeroTwoProdLot', 'txtSZeroTwoProdLot', 'txtSZeroTwoDeviceId', 'CN171S-02#MO-VE', 'txtSZeroTwoDevicePO', 'txtSZeroTwoDeviceQty');


                            dtAssemblyRuncardStation.draw();
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }

                    });
                });

                $(document).on('click', '.btnViewAssemblyRuncardData',function(e){
                    e.preventDefault();
                    let assembly_runcard_id = $(this).attr('assembly_runcard-id');
                    $.ajax({
                        url: "get_assembly_runcard_data",
                        type: "get",
                        data: {
                            assy_runcard_id: assembly_runcard_id
                        },
                        dataType: "json",
                        success: function(response){
                            const assy_runcard_data = response['assembly_runcard_data'];
                            $('#btnAddRuncardStation').prop('disabled', true);
                            $('#btnRuncardDetails').prop('hidden', true);
                            $('#txtPONumber').prop('disabled', true);
                            $('#btnScanSZeroSevenProdLot').prop('disabled', true);
                            $('#btnScanSZeroTwoProdLot').prop('disabled', true);
                            $('#btnAddRuncardStation').prop('hidden', true);
                            $('#btnSubmitAssemblyRuncardData').prop('hidden', true);

                            $('#txtSelectDocNoRDrawing').prop('disabled', true);
                            $('#txtSelectDocNoADrawing').prop('disabled', true);
                            $('#txtSelectDocNoGDrawing').prop('disabled', true);

                            $('#modalCNAssembly').modal('show');
                            $('#formCNAssemblyRuncard #txtAssyRuncardId').val(assy_runcard_data[0].id);
                            $('#formCNAssemblyRuncard #txtDeviceCode').val(assy_runcard_data[0].part_code);
                            $('#formCNAssemblyRuncard #txtDeviceName').val(assy_runcard_data[0].device_name);
                            $('#formCNAssemblyRuncard #txtMaterialName').val(assy_runcard_data[0].material_name);
                            $('#formCNAssemblyRuncard #txtPONumber').val(assy_runcard_data[0].po_number);
                            // $('#formCNAssemblyRuncard #txtPartsCode').val(assy_runcard_data[0].parts_code);
                            $('#formCNAssemblyRuncard #txtPoQuantity').val(assy_runcard_data[0].po_quantity);
                            $('#formCNAssemblyRuncard #txtRequiredOutput').val(assy_runcard_data[0].required_output);
                            $('#formCNAssemblyRuncard #txtRuncardNo').val(assy_runcard_data[0].runcard_no);
                            $('#formCNAssemblyRuncard #txtShipmentOutput').val(assy_runcard_data[0].shipment_output);
                            $('#formCNAssemblyRuncard #txtPZeroTwoProdLot').val(assy_runcard_data[0].p_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtPZeroTwoDeviceId').val(assy_runcard_data[0].p_zero_two_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroSevenProdLot').val(assy_runcard_data[0].s_zero_seven_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroSevenDeviceId').val(assy_runcard_data[0].s_zero_seven_device_id);
                            $('#formCNAssemblyRuncard #txtSZeroTwoProdLot').val(assy_runcard_data[0].s_zero_two_prod_lot);
                            $('#formCNAssemblyRuncard #txtSZeroTwoDeviceId').val(assy_runcard_data[0].s_zero_two_device_id);
                            // $('#formCNAssemblyRuncard #txtTotalAssyYield').val(assy_runcard_data[0].total_assembly_yield);

                            let total_assy_yield = 0;
                            for (let index = 0; index < assy_runcard_data[0].assembly_runcard_station.length; index++) {
                                let output = assy_runcard_data[0].assembly_runcard_station[index].output_quantity;
                                let input = assy_runcard_data[0].assembly_runcard_station[index].input_quantity;
                                let station_yield = ( output / input ) * 100;
                                total_assy_yield += station_yield;
                            }
                            total_assy_yield = total_assy_yield / assy_runcard_data[0].assembly_runcard_station.length;

                            $('#formCNAssemblyRuncard #txtTotalAssyYield').val(`${total_assy_yield.toFixed(2)}%`);
                            $('#formCNAssemblyRuncard #txtAveOveallYield').val(assy_runcard_data[0].average_overall_yield);

                            $('#btnAddRuncardStation').attr('runcard_id', assy_runcard_data[0].id);

                            let s_zero_two_prod_lot = assy_runcard_data[0].s_zero_two_prod_lot;
                                s_zero_two_prod_lot_split = s_zero_two_prod_lot.split('-');
                                s_zero_two_prod_lot = s_zero_two_prod_lot_split[0] +'-'
                                if(s_zero_two_prod_lot_split.length > 3){
                                    s_zero_two_prod_lot_ext = s_zero_two_prod_lot_split[1] +'-'+ s_zero_two_prod_lot_split[2] +'-'+ s_zero_two_prod_lot_split[3];
                                }else{
                                    s_zero_two_prod_lot_ext = s_zero_two_prod_lot_split[1] +'-'+ s_zero_two_prod_lot_split[2];
                                }
                            verifyProdLotfromMolding(assy_runcard_data[0].s_zero_seven_prod_lot, '', 'ScanSZeroSevenProdLot', 'txtSZeroSevenProdLot', 'txtSZeroSevenDeviceId', 'CN171S-07#IN-VE', 'txtSZeroSevenDevicePO' ,'txtSZeroSevenDeviceQty');
                            verifyProdLotfromMolding(s_zero_two_prod_lot, s_zero_two_prod_lot_ext, 'ScanSZeroTwoProdLot', 'txtSZeroTwoProdLot', 'txtSZeroTwoDeviceId', 'CN171S-02#MO-VE', 'txtSZeroTwoDevicePO', 'txtSZeroTwoDeviceQty');

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

                    GetAssemblyRuncardData(assembly_runcard_id, assy_runcard_stations_id);

                    $('#txtInputQuantity').prop('disabled', false);
                    $('#txtNgQuantity').prop('disabled', false);
                    $('#txtDocNoRDrawing').prop('disabled', false);
                    $('#txtDocNoADrawing').prop('disabled', false);
                    $('#txtDocNoGDrawing').prop('disabled', false);
                    $('#txtRemarks').prop('disabled', false);
                    $('#buttonAddAssemblyModeOfDefect').prop('hidden', false);
                    $('.buttonRemoveMOD').prop('disabled', false);
                    $('#btnSaveNewAssemblyRuncardStation').prop('hidden', false);
                    $('#modalAddStation').modal('show');

                    $('#tableAssemblyStationMOD .selectMOD').prop('disabled', false);
                    $('#tableAssemblyStationMOD .textMODQuantity').prop('disabled', false);
                    $('#tableAssemblyStationMOD .buttonRemoveMOD').prop('disabled', false);

                    // $.ajax({
                    //     url: "get_assembly_runcard_data",
                    //     type: "get",
                    //     data: {
                    //         assy_runcard_id: assembly_runcard_id,
                    //         assy_runcard_station_id: assy_runcard_stations_id
                    //     },
                    //     dataType: "json",
                    //     beforeSend: function(){
                    //     },
                    //     success: function(response){
                    //         const assy_runcard_station_data = response['assembly_runcard_data'][0].assembly_runcard_station[0];
                    //         const mode_of_defect_data = response['mode_of_defect_data'];

                    //         GetRDrawingFromACDCS($('#txtDeviceName').val(), 'R Drawing', $("#txtSelectDocNoRDrawing"), assy_runcard_station_data.doc_no_r_drawing);
                    //         GetADrawingFromACDCS($('#txtDeviceName').val(), 'A Drawing', $("#txtSelectDocNoADrawing"), assy_runcard_station_data.doc_no_a_drawing);
                    //         GetGDrawingFromACDCS($('#txtDeviceName').val(), 'G Drawing', $("#txtSelectDocNoGDrawing"), assy_runcard_station_data.doc_no_g_drawing);

                    //         //Stations Forms
                    //         $('#formAddAssemblyRuncardStation #txtStationAssyRuncardId').val(assy_runcard_station_data.assembly_runcards_id);
                    //         $('#formAddAssemblyRuncardStation #txtAssyRuncardStationId').val(assy_runcard_station_data.id);
                    //         // $('#formAddAssemblyRuncardStation #txtSelectRuncardStation').val(assy_runcard_station_data.station);
                    //         GetStations($('#txtSelectRuncardStation'), assy_runcard_station_data.station_step);
                    //         $('#formAddAssemblyRuncardStation #txtStep').val(assy_runcard_station_data.station_step);

                    //         $('#formAddAssemblyRuncardStation #txtDate').val(assy_runcard_station_data.date);
                    //         $('#formAddAssemblyRuncardStation #txtOperatorName').val(assy_runcard_station_data.user.firstname+' '+assy_runcard_station_data.user.lastname);
                    //         $('#formAddAssemblyRuncardStation #txtInputQuantity').val(assy_runcard_station_data.input_quantity);
                    //         $('#formAddAssemblyRuncardStation #txtNgQuantity').val(assy_runcard_station_data.ng_quantity);
                    //         $('#formAddAssemblyRuncardStation #txtOutputQuantity').val(assy_runcard_station_data.output_quantity);

                    //         $('#formAddAssemblyRuncardStation #txtStationYield').val(assy_runcard_station_data.station_yield);
                    //         $('#formAddAssemblyRuncardStation #txtModeOfDefect').val(assy_runcard_station_data.mode_of_defect);
                    //         $('#formAddAssemblyRuncardStation #txtDefectQuantity').val(assy_runcard_station_data.defect_qty);
                    //         $('#formAddAssemblyRuncardStation #txtMlPerShot').val(assy_runcard_station_data.ml_per_shot);
                    //         $('#formAddAssemblyRuncardStation #txtTotalLubricantUsage').val(assy_runcard_station_data.total_lubricant_usage);
                    //         $('#formAddAssemblyRuncardStation #txtDocNoWorkI').val(assy_runcard_station_data.doc_no_wi);
                    //         // $('#formAddAssemblyRuncardStation #txtDocNoRDrawing').val(assy_runcard_station_data.doc_no_r_drawing);
                    //         // $('#formAddAssemblyRuncardStation #txtDocNoADrawing').val(assy_runcard_station_data.doc_no_a_drawing);
                    //         // $('#formAddAssemblyRuncardStation #txtDocNoGDrawing').val(assy_runcard_station_data.doc_no_g_drawing);
                    //         // $('#formAddAssemblyRuncardStation #txtDateCode').val(assy_runcard_station_data.date_code);
                    //         // $('#formAddAssemblyRuncardStation #txtBundleQuantity').val(assy_runcard_station_data.bundle_qty);

                    //         $('#formAddAssemblyRuncardStation #txtRemarks').val(assy_runcard_station_data.remarks);


                    //         // <option value="${mode_of_defect_data[index].mod_id}">${mode_of_defect_data[index].mode_of_defect[0].defects}</option>

                    //         for(let index = 0; index < mode_of_defect_data.length; index++){
                    //             let rowModeOfDefect = `
                    //                 <tr>
                    //                     <td>
                    //                         <select class="form-control select2bs5 selectMOD" name="mod_id[]">
                    //                         </select>
                    //                     </td>
                    //                     <td id=textMODQuantity>
                    //                         <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="${mode_of_defect_data[index].mod_quantity}" min="1">
                    //                     </td>
                    //                     <td id="buttonRemoveMOD">
                    //                         <center><button class="btn btn-md btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                    //                     </td>
                    //                 </tr>
                    //             `;
                    //             $("#tableAssemblyStationMOD tbody").append(rowModeOfDefect);
                    //             // console.log('mod_id',mode_of_defect_data[index].mod_id);

                    //             getModeOfDefect($("#tableAssemblyStationMOD tr:last").find('.selectMOD'), mode_of_defect_data[index].mod_id);
                    //         }
                    //         $("#labelTotalNumberOfNG").text(parseInt(0));
                    //     },
                    //     error: function(data, xhr, status){
                    //         toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    //     }
                    // });
                });

                $(document).on('click', '.btnViewAssyRuncardStationData',function(e){
                    e.preventDefault();
                    let assembly_runcard_id = $('#txtAssyRuncardId').val();
                    let assy_runcard_stations_id = $(this).attr('assy_runcard_stations-id');

                    GetAssemblyRuncardData(assembly_runcard_id, assy_runcard_stations_id);

                    $('#txtInputQuantity').prop('disabled', true);
                    $('#txtNgQuantity').prop('disabled', true);
                    $('#txtDocNoRDrawing').prop('disabled', true);
                    $('#txtDocNoADrawing').prop('disabled', true);
                    $('#txtDocNoGDrawing').prop('disabled', true);
                    $('#txtRemarks').prop('disabled', true);
                    $('#buttonAddAssemblyModeOfDefect').prop('hidden', true);
                    $('.buttonRemoveMOD').prop('disabled', true);
                    $('#btnSaveNewAssemblyRuncardStation').prop('hidden', true);
                    $('#modalAddStation').modal('show');
                });

                function GetAssemblyRuncardData(assembly_runcard_id, assy_runcard_stations_id){
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

                            GetRDrawingFromACDCS($('#txtDeviceName').val(), 'R Drawing', $("#txtSelectDocNoRDrawing"), assy_runcard_station_data.doc_no_r_drawing);
                            GetADrawingFromACDCS($('#txtDeviceName').val(), 'A Drawing', $("#txtSelectDocNoADrawing"), assy_runcard_station_data.doc_no_a_drawing);
                            GetGDrawingFromACDCS($('#txtDeviceName').val(), 'G Drawing', $("#txtSelectDocNoGDrawing"), assy_runcard_station_data.doc_no_g_drawing);

                            //Stations Forms
                            $('#formAddAssemblyRuncardStation #txtStationAssyRuncardId').val(assy_runcard_station_data.assembly_runcards_id);
                            $('#formAddAssemblyRuncardStation #txtAssyRuncardStationId').val(assy_runcard_station_data.id);

                            GetStations($('#txtSelectRuncardStation'), assy_runcard_station_data.station_step);
                            $('#formAddAssemblyRuncardStation #txtStep').val(assy_runcard_station_data.station_step);

                            $('#formAddAssemblyRuncardStation #txtDate').val(assy_runcard_station_data.date);
                            $('#formAddAssemblyRuncardStation #txtOperatorName').val(assy_runcard_station_data.user.firstname+' '+assy_runcard_station_data.user.lastname);
                            $('#formAddAssemblyRuncardStation #txtInputQuantity').val(assy_runcard_station_data.input_quantity);
                            $('#formAddAssemblyRuncardStation #txtNgQuantity').val(assy_runcard_station_data.ng_quantity);
                            $('#formAddAssemblyRuncardStation #txtOutputQuantity').val(assy_runcard_station_data.output_quantity);

                            $('#formAddAssemblyRuncardStation #txtStationYield').val(assy_runcard_station_data.station_yield);
                            $('#formAddAssemblyRuncardStation #txtModeOfDefect').val(assy_runcard_station_data.mode_of_defect);
                            $('#formAddAssemblyRuncardStation #txtDefectQuantity').val(assy_runcard_station_data.defect_qty);
                            $('#formAddAssemblyRuncardStation #txtMlPerShot').val(assy_runcard_station_data.ml_per_shot);
                            $('#formAddAssemblyRuncardStation #txtTotalLubricantUsage').val(assy_runcard_station_data.total_lubricant_usage);
                            // $('#formAddAssemblyRuncardStation #txtDocNoWorkI').val(assy_runcard_station_data.doc_no_wi);
                            // $('#formAddAssemblyRuncardStation #txtDocNoRDrawing').val(assy_runcard_station_data.doc_no_r_drawing);
                            // $('#formAddAssemblyRuncardStation #txtDocNoADrawing').val(assy_runcard_station_data.doc_no_a_drawing);
                            // $('#formAddAssemblyRuncardStation #txtDocNoGDrawing').val(assy_runcard_station_data.doc_no_g_drawing);

                            $('#formAddAssemblyRuncardStation #txtRemarks').val(assy_runcard_station_data.remarks);
                            for(let index = 0; index < mode_of_defect_data.length; index++){
                                let rowModeOfDefect = `
                                    <tr>
                                        <td>
                                            <select class="form-control select2bs5 selectMOD" name="mod_id[]">
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
                                getModeOfDefect($("#tableAssemblyStationMOD tr:last").find('.selectMOD'), mode_of_defect_data[index].mod_id);
                            }
                            $("#labelTotalNumberOfNG").text(parseInt(0));

                            if(assy_runcard_station_data.status == 2 || assy_runcard_station_data.status == 3){
                                $('#tableAssemblyStationMOD .selectMOD').prop('disabled', true);
                                $('#tableAssemblyStationMOD .textMODQuantity').prop('disabled', true);
                                $('#tableAssemblyStationMOD .buttonRemoveMOD').prop('disabled', true);
                            }else{
                                $('#tableAssemblyStationMOD .selectMOD').prop('disabled', false);
                                $('#tableAssemblyStationMOD .textMODQuantity').prop('disabled', false);
                                $('#tableAssemblyStationMOD .buttonRemoveMOD').prop('disabled', false);
                            }
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }

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

                $(document).on('click', '#btnSubmitIPQCData', function(e){
                    // let ipqc_id = $(this).attr('ipqc_data-id');
                    let assy_runcard_id = $(this).attr('assembly_runcard-id');
                    let assy_runcard_status = $(this).attr('assembly_runcard-status');
                    $("#cnfrmtxtId").val(assy_runcard_id);
                    $("#cnfrmtxtStatus").val(assy_runcard_status);
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
                        url: "update_assembly_status",
                        method: "post",
                        data: $('#FrmConfirmSubmit').serialize(),
                        dataType: "json",
                        success: function (response) {
                            let result = response['result'];
                            if (result == 'Successful') {
                                toastr.success('Successful!');
                                dtAssemblyRuncard.draw();
                                $("#modalConfirmSubmit").modal('hide');
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                        }
                    });
                });

                $(document).on('click', '#btnPrintAssemblyRuncard', function(e){
                    e.preventDefault();
                    let assy_runcard_id = $(this).attr('assembly_runcard-id');
                    // $('#hiddenPreview').append(dataToAppend)
                    $.ajax({
                        type: "get",
                        url: "get_assembly_qr_code",
                        data: {
                            runcard_id: assy_runcard_id
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            // response['label_hidden'][0]['id'] = id;
                            // console.log(response['label_hidden']);
                            // for(let x = 0; x < response['label_hidden'].length; x++){
                            //     let dataToAppend = `
                            //     <img src="${response['label_hidden'][x]['img']}" style="max-width: 200px;"></img>
                            //     `;
                            //     $('#hiddenPreview').append(dataToAppend)
                            // }

                            $("#img_barcode_PO").attr('src', response['qr_code']);
                            $("#img_barcode_PO_text").html(response['label']);
                            img_barcode_PO_text_hidden = response['label_hidden'];
                            $('#modalAssemblyPrintQr').modal('show');
                        }
                    });
                });

                $('#btnAssemblyPrintQrCode').on('click', function(){
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
                    // for (let i = 0; i < img_barcode_PO_text_hidden.length; i++) {
                        content += '<table style="margin-left: -5px; margin-top: 18px;">';
                            content += '<tr style="width: 290px;">';
                                content += '<td style="vertical-align: bottom;">';
                                    content += '<img src="' + img_barcode_PO_text_hidden[0]['img'] + '" style="min-width: 75px; max-width: 75px;">';
                                content += '</td>';
                                content += '<td style="font-size: 10px; font-family: Calibri;">' + img_barcode_PO_text_hidden[0]['text'] + '</td>';
                            content += '</tr>';
                        content += '</table>';
                        content += '<br>';
                        // if( i < img_barcode_PO_text_hidden.length-1 ){
                        //     content += '<div class="pagebreak"> </div>';
                        // }
                    // }
                    content += '</body>';
                    content += '</html>';
                    popup.document.write(content);

                    popup.focus(); //required for IE
                    popup.print();

                    /*
                        * this event will trigger after closing the tab of printing
                    */
                    // popup.addEventListener("beforeunload", function (e) {
                    //     changePrintCount(img_barcode_PO_text_hidden[0]['id']);
                    // });

                    popup.close();

                });
            });
        </script>
    @endsection
@endauth

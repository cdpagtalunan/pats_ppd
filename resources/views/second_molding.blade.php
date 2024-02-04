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
                            <h1>Second Molding</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Second Molding</li>
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
                                                <input type="text" class="form-control" placeholder="PO Number" id="textSearchPONumber">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="textSearchMaterialName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Quantity" id="textSearchPOQuantity" readonly>
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
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Second Molding</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="buttonAddSecondMolding"><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tableSecondMolding" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Device Name</th>
                                                    <th>Parts Code</th>
                                                    <th>PO Number</th>
                                                    <th>PO Quantity</th>
                                                    <th>Machine #</th>
                                                    <th>Material Name</th>
                                                    <th>Material Lot #</th>
                                                    <th>MATL Drawing #</th>
                                                    <th>Revision #</th>
                                                    <th>Production Lot #</th>
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
        <div class="modal fade" id="modalSecondMolding" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info-circle text-info"></i> Second Molding Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formSecondMolding" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textSecondMoldingId" name="second_molding_id">
                            <div class="row">
                                <div class="col-sm-4 border px-4">
                                    <div class="py-3 d-flex align-items-center">
                                        <span class="badge badge-secondary">1.</span> Second Molding Details
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textDeviceName" name="device_name" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Parts Code</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textPartsCode" name="parts_code" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PMI PO Number</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textPMIPONumber" name="pmi_po_number" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Number</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textPONumber" name="po_number" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Quantity</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textPoQuantity" name="po_quantity" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">PO Quantity</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textRequiredOutput" name="required_output" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Machine #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMachineNumber" name="machine_number" placeholder="Machine #">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Material Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMaterialLotNumber" name="material_lot_number" placeholder="Scan Machine Lot #" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumber" form-value="formMaterialLotNumber"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMaterialName" readonly name="material_name" placeholder="Auto Generated">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">MATL Drawing # on Rapid</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textDrawingNumber" name="drawing_number" value="B137229-001" placeholder="Auto generated" readonly>
                                        <button style="width:30px" type="button" class="btn btn-sm py-0 btn-info table-btns" id="buttonViewBDrawing">
                                            <i class="fa fa-file" title="View"></i>
                                        </button>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Revision # on Rapid</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textRevisionNumber" name="revision_number" placeholder="Auto generated" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Production Lot</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textProductionLot" name="production_lot" placeholder="Production Lot">
                                    </div>
                                    <div id="divMaterialLotNumbers">
                                        <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CN171S-08#IN-VE - Lot #</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="textLotNumberEight" name="lot_number_eight" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                            <input type="hidden" class="form-control form-control-sm" id="textLotNumberEightFirstMoldingId" name="lot_number_eight_first_molding_id" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberEight" form-value="formProductionLotNumberEight"><i class="fa fa-qrcode"></i></button>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CN171S-09#IN-VE - Lot #</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="textLotNumberNine" name="lot_number_nine" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                            <input type="hidden" class="form-control form-control-sm" id="textLotNumberNineFirstMoldingId" name="lot_number_nine_first_molding_id" readonly placeholder="CN171S-09#IN-VE - Lot #">
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberNine" form-value="formProductionLotNumberNine"><i class="fa fa-qrcode"></i></button>
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CN171S-10#IN-VE - Lot #</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="textLotNumberTen" name="lot_number_ten" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                            <input type="hidden" class="form-control form-control-sm" id="textLotNumberTenFirstMoldingId" name="lot_number_ten_first_molding_id" readonly placeholder="CN171S-10#IN-VE - Lot #">
                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberTen" form-value="formProductionLotNumberTen"><i class="fa fa-qrcode"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">C/T Name/Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textContactLotNumberOne" value="N/A" readonly name="contact_name_lot_number_one" placeholder="C/T Name/Lot #">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanContactLotNumberOne" form-value="formContactLotNumberOne"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">C/T Name/Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textContactLotNumberSecond" value="N/A" readonly name="contact_name_lot_number_second" placeholder="C/T Name/Lot #">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanContactLotNumberSecond" form-value="formContactLotNumberSecond"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">ME Name/Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMELotNumberOne" value="N/A" readonly name="me_name_lot_number_one" placeholder="ME Name/Lot #">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMELotNumberOne" form-value="formMELotNumberOne"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">ME Name/Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMELotNumberSecond" value="N/A" readonly name="me_name_lot_number_second" placeholder="ME Name/Lot #">
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMELotNumberSecond" form-value="formMELotNumberSecond"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-sm btn-success" id="buttonSaveSecondMoldingData"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col border px-4 border">
                                        <div class="py-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center"><span class="badge badge-secondary">2.</span> Second Molding Stations</div>
                                            <button type="button" class="btn btn-primary btn-sm" disabled data-bs-toggle="modal" id="buttonAddStation" data-bs-target="#modalSecondMoldingStation" style="margin-bottom: 5px;">
                                                <i class="fa fa-plus" ></i> Add Station
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm small table-bordered table-hover" id="tableStation" style="width: 100%;">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th>Action</th>
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
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

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

        <div class="modal fade" id="modalSecondMoldingStation" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formAddStation">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textSecondMoldingId" name="second_molding_id">
                            <input type="text" class="d-none" id="textSecondMoldingStationId" name="second_molding_station_id">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station</span>
                                        </div>
                                        <select type="text" class="form-control form-control-sm" id="textStation" name="station" placeholder="Station">
                                            {{-- <option value="{{ Auth::user()->id }}">{{ Auth::user()->firstname  .' '. Auth::user()->lastname }}</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="textDate" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                        </div>
                                        <select type="text" class="form-control form-control-sm" id="textOperatorName" name="operator_name" placeholder="Operator Name">
                                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->firstname  .' '. Auth::user()->lastname }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="textInputQuantity" name="input_quantity" min="0" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="textOutputQuantity" name="output_quantity" min="0" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="textNGQuantity" name="ng_quantity" readonly min="0" value="0" oninput="this.value = Math.abs(this.value)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                    </div>
                                    <textarea type="text" class="form-control form-control-sm" rows="2" id="textRemarks" name="remarks"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between">
                                            <label>Total No. of NG: <span id="labelTotalNumberOfNG" style="color: green;">0</span></label>
                                            <button type="button" id="buttonAddModeOfDefect" disabled class="btn btn-sm btn-info" title="Add MOD"><i class="fa fa-plus"></i> Add MOD</button>
                                        </div>
                                        <br>
                                        <table class="table table-sm" id="tableSecondMoldingStationMOD">
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
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="buttonSecondMoldingStation"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){
                let dataTablesSecondMolding, dataTablesSecondMoldingStation;
                $(document).on('keypress', '#textSearchPONumber', function(e){
                    if(e.keyCode == 13){
                        getPOReceivedByPONumber($(this).val());
                        dataTablesSecondMolding.draw();
                    }
                });

                /**
                 * Validation for CN171S/CN171P
                 * Start
                */
                $('#buttonAddSecondMolding').on('click', function(e){
                    let poNumber = $('#textSearchPONumber').val();
                    let materialName = $('#textSearchMaterialName').val();
                    let materialNameSubstring = materialName.substring(0,6);
                    
                    if(poNumber != "" && materialName != ""){
                        getPOReceivedByPONumber(poNumber);
                        if(materialNameSubstring == 'CN171S'){
                            $('#divMaterialLotNumbers').removeClass('d-none');
                            $('#textMaterialLotNumberChecking').val(1);
                        }else if (materialNameSubstring == 'CN171P'){
                            $('#divMaterialLotNumbers').addClass('d-none');
                            $('#textMaterialLotNumberChecking').val(0);
                        }
                        $('#buttonAddStation').prop('disabled', true);
                        $('#modalSecondMolding').modal('show');
                        dataTablesSecondMoldingStation.draw();
                        getMaterialProcessStation();
                    }
                    else{
                        toastr.error('Please input PO.')
                    }
                });
                /**
                 * Validation for CN171S/CN171P
                 * End
                */

                /**
                 * View B Drawing
                 * Start
                */
                $("#buttonViewBDrawing").click(function(){
                    let docNo = $('#textDrawingNumber').val();
                    let docTitle = $('#textDeviceName').val();
                    let docType = "B Drawing";
                    $.ajax({
                        type: "GET",
                        url: "get_revision_number_based_on_drawing_number",
                        data: {
                            doc_number: docNo,
                            doc_title: docTitle,
                            doc_type: docType,
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response.length > 0){
                                $('#textRevisionNumber').val(response[0].rev_no);
                            }
                        }
                    });
                    redirectToACDCSDrawing(docNo, docTitle, docType)
                });
                /**
                 * View B Drawing
                 * End
                */

                /**
                 * QR Code Scanner
                 * Start
                */
                $('#buttonQrScanMaterialLotNumber, #buttonQrScanMaterialLotNumberEight, #buttonQrScanMaterialLotNumberNine, #buttonQrScanMaterialLotNumberTen, #buttonQrScanContactLotNumberOne, #buttonQrScanContactLotNumberSecond, #buttonQrScanMELotNumberOne, #buttonQrScanMELotNumberSecond').each(function(e){
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
                            case 'formMaterialLotNumber':
                                checkMaterialLotNumber(qrScannerValue);
                                break;
                            case 'formProductionLotNumberEight':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberEight');
                                break;
                            case 'formProductionLotNumberNine':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberNine');
                                break;
                            case 'formProductionLotNumberTen':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberTen');
                                break;
                            case 'formContactLotNumberOne':
                                if(qrScannerValue != ''){
                                    $('#textContactLotNumberOne').val(qrScannerValue);
                                }else{
                                    $('#textContactLotNumberOne').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formContactLotNumberSecond':
                                if(qrScannerValue != ''){
                                    $('#textContactLotNumberSecond').val(qrScannerValue);
                                }else{
                                    $('#textContactLotNumberSecond').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberOne':
                                if(qrScannerValue != ''){
                                    $('#textMELotNumberOne').val(qrScannerValue);
                                }else{
                                    $('#textMELotNumberOne').val('N/A');
                                    toastr.error('Please scan ME lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberSecond':
                                if(qrScannerValue != ''){
                                    $('#textMELotNumberSecond').val(qrScannerValue);
                                }else{
                                    $('#textMELotNumberSecond').val('N/A');
                                    toastr.error('Please scan ME lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            default:
                                break;
                        }

                    }
                }, 100));
                /**
                 * QR Code Scanner
                 * End
                */

                /**
                 * DataTables of Second Molding
                 * Start
                */
                dataTablesSecondMolding = $("#tableSecondMolding").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_second_molding",
                        data: function (param){
                            param.po_number = $("#textSearchPONumber").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "parts_code" },
                        { "data" : "po_number" },
                        { "data" : "po_quantity" },
                        { "data" : "machine_number" },
                        { "data" : "material_lot_number" },
                        { "data" : "material_name" },
                        { "data" : "drawing_number" },
                        { "data" : "revision_number" },
                        { "data" : "production_lot" },
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
                /**
                 * DataTables of Second Molding
                 * End
                */

                /**
                 * Form of Second Molding to be use in Insert
                 * Start
                */
                $('#formSecondMolding').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    console.log(`response ${response['second_molding_id']}`);
                                    toastr.success('Successfully saved');
                                    dataTablesSecondMolding.draw();
                                    $('#buttonAddStation').prop('disabled', false); // remove disabled after save
                                    getSecondMoldingById(response['second_molding_id']);
                                }else if(response['sessionError']){
                                    toastr.error('Session Expired. Please re-login again.');
                                }else{
                                    toastr.error('Saving failed');
                                }
                            }else{
                                toastr.error('Please input required fields');
                                if(response['error']['device_name'] === undefined){
                                    isResponseError('textDeviceName', false);
                                }
                                else{
                                    isResponseError('textDeviceName', true);
                                }

                                if(response['error']['parts_code'] === undefined){
                                    isResponseError('textPartsCode', false);
                                }
                                else{
                                    isResponseError('textPartsCode', true);
                                }

                                if(response['error']['pmi_po_number'] === undefined){
                                    isResponseError('textPMIPONumber', false);
                                }
                                else{
                                    isResponseError('textPONumber', true);
                                }

                                if(response['error']['po_number'] === undefined){
                                    isResponseError('textPONumber', false);
                                }
                                else{
                                    isResponseError('textPONumber', true);
                                }

                                if(response['error']['po_quantity'] === undefined){
                                    isResponseError('textPoQuantity', false);
                                }
                                else{
                                    isResponseError('textPoQuantity', true);
                                }

                                if(response['error']['machine_number'] === undefined){
                                    isResponseError('textMachineNumber', false);
                                }
                                else{
                                    isResponseError('textMachineNumber', true);
                                }

                                if(response['error']['material_lot_number'] === undefined){
                                    isResponseError('textMaterialLotNumber', false);
                                }
                                else{
                                    isResponseError('textMaterialLotNumber', true);
                                }

                                if(response['error']['material_name'] === undefined){
                                    isResponseError('textMaterialName', false);
                                }
                                else{
                                    isResponseError('textMaterialName', true);
                                }

                                if(response['error']['drawing_number'] === undefined){
                                    isResponseError('textDrawingNumber', false);
                                }
                                else{
                                    isResponseError('textDrawingNumber', true);
                                }

                                if(response['error']['revision_number'] === undefined){
                                    isResponseError('textRevisionNumber', false);
                                }
                                else{
                                    isResponseError('textRevisionNumber', true);
                                }

                                if(response['error']['production_lot'] === undefined){
                                    isResponseError('textProductionLot', false);
                                }
                                else{
                                    isResponseError('textProductionLot', true);
                                }

                                if(response['error']['lot_number_eight'] === undefined){
                                    isResponseError('textLotNumberEight', false);
                                }
                                else{
                                    isResponseError('textLotNumberEight', true);
                                }
                                if(response['error']['lot_number_nine'] === undefined){
                                    isResponseError('textLotNumberNine', false);
                                }
                                else{
                                    isResponseError('textLotNumberNine', true);
                                }
                                if(response['error']['lot_number_ten'] === undefined){
                                    isResponseError('textLotNumberTen', false);
                                }
                                else{
                                    isResponseError('textLotNumberTen', true);
                                }
                                if(response['error']['contact_name_lot_number_one'] === undefined){
                                    isResponseError('textContactLotNumberOne', false);
                                }
                                else{
                                    isResponseError('textContactLotNumberOne', true);
                                }
                                if(response['error']['contact_name_lot_number_second'] === undefined){
                                    isResponseError('textContactLotNumberSecond', false);
                                }
                                else{
                                    isResponseError('textContactLotNumberSecond', true);
                                }
                                if(response['error']['me_name_lot_number_one'] === undefined){
                                    isResponseError('textMELotNumberOne', false);
                                }
                                else{
                                    isResponseError('textMELotNumberOne', true);
                                }
                                if(response['error']['me_name_lot_number_second'] === undefined){
                                    isResponseError('textMELotNumberSecond', false);
                                }
                                else{
                                    isResponseError('textMELotNumberSecond', true);
                                }
                            }
                        }
                    });
                });
                resetFormValuesOnModalClose('modalSecondMolding', 'formSecondMolding');
                /**
                 * Form of Second Molding to be use in Insert
                 * End
                */

                /**
                 * Get Second Molding Data to be use in Edit
                 * Start
                */
                function getSecondMoldingById(id){
                    $.ajax({
                        type: "get",
                        url: "get_second_molding_by_id",
                        data: {
                            second_molding_id: id,
                        },
                        dataType: "json",
                        success: function (response) {
                            let responseData = response['data'];
                            if(response['data'].length > 0){
                                $('#textSecondMoldingId', $('#formSecondMolding')).val(responseData[0].id);
                                // $('#textSecondMoldingId', $('#formAddStation')).val(responseData[0].id); // Id from sec_molding_runcards(table)
                                $('#textDeviceName', $('#formSecondMolding')).val(responseData[0].device_name);
                                $('#textPartsCode', $('#formSecondMolding')).val(responseData[0].parts_code);
                                $('#textPMIPONumber', $('#formSecondMolding')).val(responseData[0].pmi_po_number);
                                $('#textPONumber', $('#formSecondMolding')).val(responseData[0].po_number);
                                $('#textPoQuantity', $('#formSecondMolding')).val(responseData[0].po_quantity);
                                $('#textMachineNumber', $('#formSecondMolding')).val(responseData[0].machine_number);
                                $('#textMaterialLotNumber', $('#formSecondMolding')).val(responseData[0].material_lot_number);
                                $('#textMaterialName', $('#formSecondMolding')).val(responseData[0].material_name);
                                $('#textDrawingNumber', $('#formSecondMolding')).val(responseData[0].drawing_number);
                                $('#textRevisionNumber', $('#formSecondMolding')).val(responseData[0].revision_number);
                                $('#textProductionLot', $('#formSecondMolding')).val(responseData[0].production_lot);
                                $('#textLotNumberEight', $('#formSecondMolding')).val(responseData[0].lot_number_eight);
                                $('#textLotNumberEightFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_eight_first_molding_id);
                                $('#textLotNumberNine', $('#formSecondMolding')).val(responseData[0].lot_number_nine);
                                $('#textLotNumberNineFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_nine_first_molding_id);
                                $('#textLotNumberTen', $('#formSecondMolding')).val(responseData[0].lot_number_ten);
                                $('#textLotNumberTenFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_ten_first_molding_id);
                                $('#textContactLotNumberOne', $('#formSecondMolding')).val(responseData[0].contact_name_lot_number_one);
                                $('#textContactLotNumberSecond', $('#formSecondMolding')).val(responseData[0].contact_name_lot_number_second);
                                $('#textMELotNumberOne', $('#formSecondMolding')).val(responseData[0].me_name_lot_number_one);
                                $('#textMELotNumberSecond', $('#formSecondMolding')).val(responseData[0].me_name_lot_number_second);
                                dataTablesSecondMoldingStation.draw();
                            }
                        }
                    });
                }
                /**
                 * Get Second Molding Data to be use in Edit
                 * End
                */

                /**
                 * Edit of Second Molding to be use in Update
                 * Start
                */
                let id;
                $("#tableSecondMolding").on('click', '.actionEditSecondMolding', function(){
                    id = $(this).attr('second-molding-id');
                    console.log(`id ${id}`)
                    $('#buttonAddStation').prop('disabled', false); // remove disabled for edit
                    getSecondMoldingById(id);
                    getMaterialProcessStation();
                });
                /**
                 * Edit of Second Molding to be use in Update
                 * End
                */

                /**
                 * DataTables of Second Molding Station
                 * Start
                */
                dataTablesSecondMoldingStation = $("#tableStation").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_second_molding_station",
                        data: function (param){
                            param.sec_molding_runcard_id = $("#textSecondMoldingId", $('#formSecondMolding')).val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "station" },
                        { "data" : "date" },
                        { "data" : "operator_name",},
                        { "data" : "input_quantity" },
                        { "data" : "ng_quantity" },
                        { "data" : "output_quantity" },
                        { "data" : "remarks" },
                    ],
                });
                /**
                 * DataTables of Second Molding Station
                 * End
                */

                /**
                 * Get Id of Second Molding after click 
                 * to be use in Second Molding Station
                 * Start
                */
                $('#buttonAddStation').click(function(){
                    let secondMoldingId = $('#textSecondMoldingId', $('#formSecondMolding')).val();
                    $('#textSecondMoldingId', $('#formAddStation')).val(secondMoldingId);
                });
                /**
                 * Get Id of Second Molding after click 
                 * to be use in Second Molding Station
                 * End
                */

                /**
                 * Form of Second Molding Station to be use in Insert
                 * Start
                */
                $('#formAddStation').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding_station",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    toastr.success('Successfully saved');
                                    dataTablesSecondMoldingStation.draw();
                                    $('#modalSecondMoldingStation').modal('hide');
                                }else if(response['sessionError']){
                                    toastr.error('Session Expired. Please re-login again.');
                                }
                                else{
                                    toastr.error('Saving failed');
                                }
                            }else{
                                toastr.error('Please input required fields');
                                if(response['error']['device_name'] === undefined){
                                    isResponseError('textDeviceName', false);
                                }
                                else{
                                    isResponseError('textDeviceName', true);
                                }
                            }
                        }
                    });
                });
                resetFormValuesOnModalClose('modalSecondMoldingStation', 'formAddStation');
                /**
                 * Form of Second Molding Station to be use in Insert
                 * End
                */

                /**
                 * Auto compute NG Quantity onkeyup
                 * Start
                */
                $("#textOutputQuantity").keyup(function(){
                    let inputQuantity = parseInt($("#textInputQuantity").val());
                    let outputQuantity = parseInt($('#textOutputQuantity').val());
                    let totalNGQuantity = Math.abs(inputQuantity - outputQuantity);
                    if(isNaN(totalNGQuantity)){
                        $("#textNGQuantity").val(inputQuantity);
                    }else{
                        $("#textNGQuantity").val(totalNGQuantity);
                    }

                    if(parseInt($("#textNGQuantity").val()) > 0){
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }
                    else{
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }

                    if(parseInt($('#textNGQuantity').val()) !== parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSecondMoldingStation").prop('disabled', true);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSecondMoldingStation").prop('disabled', false);
                    }
                }); 
                
                $("#textInputQuantity").keyup(function(){
                    let inputQuantity = parseInt($("#textInputQuantity").val());
                    let outputQuantity = parseInt($('#textOutputQuantity').val());
                    let totalNGQuantity = Math.abs(outputQuantity - inputQuantity);
                    if(isNaN(totalNGQuantity)){
                        $("#textNGQuantity").val(0);
                    }else{
                        $("#textNGQuantity").val(totalNGQuantity);
                    }

                    if(parseInt($("#textNGQuantity").val()) > 0){
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }
                    else{
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }

                    if(parseInt($('#textNGQuantity').val()) !== parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSecondMoldingStation").prop('disabled', true);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSecondMoldingStation").prop('disabled', false);
                    }
                });
                /**
                 * Auto compute NG Quantity onkeyup
                 * End
                */

                /**
                 * Add Mode Of Defect
                 * Start
                */
                $("#buttonAddModeOfDefect").click(function(){
                    let rowModeOfDefect = `
                        <tr>
                            <td>
                                <select class="form-control select2 select2bs5 selectMOD" name="mod_id[]">
                                    <option value="0">N/A</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="1" min="1">
                            </td>
                            <td>
                                <center><button class="btn btn-xs btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                            </td>
                        </tr>
                    `;
                    $("#tableSecondMoldingStationMOD tbody").append(rowModeOfDefect);
                    $('.select2bs5').select2({
                        theme: 'bootstrap-5'
                    });
                    getModeOfDefectForSecondMolding($("#tableSecondMoldingStationMOD tr:last").find('.selectMOD'));

                    let totalNumberOfMOD = 0;
                    $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                        if($(this).val() !== null || $(this).val() !== ""){
                            totalNumberOfMOD += parseInt($(this).val());
                        }
                    });

                    if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                        // toastr.warning('Mode of Defect NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSecondMoldingStation").prop('disabled', true);
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSecondMoldingStation").prop('disabled', false);
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }
                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                });

                $("#tableSecondMoldingStationMOD").on('click', '.buttonRemoveMOD', function(){
                    $(this).closest ('tr').remove();
                    let totalNumberOfMOD = 0;

                    $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                        if($(this).val() !== null || $(this).val() !== ""){
                            totalNumberOfMOD += parseInt($(this).val());
                        }
                    });

                    if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                        console.log('Mode of Defect NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSecondMoldingStation").prop('disabled', true);
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSecondMoldingStation").prop('disabled', false);
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }
                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                });
                /**
                 * Add Mode Of Defect
                 * End
                */

                /**
                 * Get Second Molding Data to be use in Edit
                 * Start
                */
                function getSecondMoldingStationById(id){
                    $.ajax({
                        type: "get",
                        url: "get_second_molding_station_by_id",
                        data: {
                            second_molding_station_id: id,
                        },
                        dataType: "json",
                        success: function (response) {
                            let responseData = response['data'];
                            if(response['data'].length > 0){
                                $('#textSecondMoldingStationId', $('#formAddStation')).val(responseData[0].id); // Id from sec_molding_runcards(table)
                                $('#textSecondMoldingId', $('#formAddStation')).val(responseData[0].sec_molding_runcard_id); // Id from sec_molding_runcards(table)
                                $('#textStation', $('#formAddStation')).val(responseData[0].station).trigger('change');
                                $('#textDate', $('#formAddStation')).val(responseData[0].date);
                                $('#textInputQuantity', $('#formAddStation')).val(responseData[0].input_quantity);
                                $('#textNGQuantity', $('#formAddStation')).val(responseData[0].ng_quantity);
                                $('#textOutputQuantity', $('#formAddStation')).val(responseData[0].output_quantity);
                                $('#textRemarks', $('#formAddStation')).val(responseData[0].remarks);
                                let rowModeOfDefect = '';
                                for (let i = 0; i < response['data'].length; i++) {
                                    rowModeOfDefect = `
                                        <tr>
                                            <td>
                                                <select class="form-control select2 select2bs5 selectMOD" name="mod_id[]">
                                                    <option value="0">N/A</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="${response['data'][i]['mod_quantity']}" min="1">
                                            </td>
                                            <td>
                                                <center><button class="btn btn-xs btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                                            </td>
                                        </tr>
                                    `;
                                    $("#tableSecondMoldingStationMOD tbody").append(rowModeOfDefect);
                                    $('.select2bs5').select2({
                                        theme: 'bootstrap-5'
                                    });
                                    getModeOfDefectForSecondMoldingEdit($("#tableSecondMoldingStationMOD tr:last").find('.selectMOD'), response['data'][i]['mod_id']);

                                    let totalNumberOfMOD = 0;
                                    $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                                        if($(this).val() !== null || $(this).val() !== ""){
                                            totalNumberOfMOD += parseInt($(this).val());
                                        }
                                    });

                                    if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                                        // toastr.warning('Mode of Defect NG Qty not tally!');
                                        $('#labelTotalNumberOfNG').css({color: 'red'})
                                        $("#buttonSecondMoldingStation").prop('disabled', true);
                                        $("#buttonAddModeOfDefect").prop('disabled', false);
                                    }else{
                                        $('#labelTotalNumberOfNG').css({color: 'green'})
                                        $("#buttonSecondMoldingStation").prop('disabled', false);
                                        $("#buttonAddModeOfDefect").prop('disabled', true);
                                    }
                                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                                }
                            }
                        }
                    });
                }
                /**
                 * Get Second Molding Data to be use in Edit
                 * End
                */
                
                /**
                 * Edit of Second Molding Station to be use in Update
                 * Start
                */
                let secondMoldingStationId;
                $("#tableStation").on('click', '.actionEditSecondMoldingStation', function(){
                    secondMoldingStationId = $(this).attr('second-molding-station-id');
                    getMaterialProcessStation();
                    getSecondMoldingStationById(secondMoldingStationId);
                });
                /**
                 * Edit of Second Molding Station to be use in Update
                 * End
                */
            });
        </script>
    @endsection
@endauth

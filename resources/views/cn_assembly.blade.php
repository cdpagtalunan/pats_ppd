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
                                            <label class="form-label">PO Number</label>
                                            <div class="input-group mb-3">
                                                {{-- <button class="btn btn-primary" id="btnScanPo" data-bs-toggle="modal" data-bs-target="#mdlScanQrCode"><i class="fa-solid fa-qrcode"></i></button> --}}
                                                {{-- <button type="button" class="btn btn-dark" id="btnScanPo" data-toggle="modal" data-target="#mdlScanQrCode"><i class="fa fa-qrcode w-100"></i></button> --}}
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Press Enter Key to Search PO Number"></i>
                                                <input type="text" class="form-control" placeholder="Search PO Number" aria-label="po_number" name="po_number" id="txtSearchPONum">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Part Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Part Code" id="txtSearchPartCode" readonly>
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
                                        <button class="btn btn-primary" id="btnAddCnAssemblyRuncard"><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblCnAssemblyRuncard" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>Device Name</th>
                                                    <th>Parts Code</th>
                                                    <th>Runcard #</th>
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
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formSecondMolding" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="textSecondMoldingId" class="d-none" name="id">
                            <div class="row">
                                <div class="col-sm-4 border px-4">
                                    <div class="py-3">
                                        <span class="badge badge-secondary">1.</span> Runcard Details
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
                                            <span class="input-group-text w-100" id="basic-addon1">Production Lot</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textProductionLot" name="production_lot" placeholder="Production Lot">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col border px-4 border">
                                        <div class="py-3">
                                            <div style="float: left;">
                                                <span class="badge badge-secondary">2.</span> Stations
                                            </div>
                                            <div style="float: right;">
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" type="button" data-bs-target="#modalAddStation" style="margin-bottom: 5px;">
                                                    <i class="fa fa-plus" ></i> Add Station
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm small table-bordered table-hover" id="tableStation" style="width: 100%;">
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
                        <form id="formAddStation">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="text_station" name="text_station" placeholder="Station">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="text_date" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="text_operator_name" name="operator_name">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_input" name="quantity_input" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_ng" name="quantity_ng" min="0" value="0"="true">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_input" name="quantity_output" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="text_remarks" name="remarks">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="buttonSecondMoldingStation" disabled="true">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){

                $('#btnScanPo').on('click', function(e){
                    e.preventDefault();
                    $('#mdlScanQrCode').on('shown.bs.modal', function () {
                        $('#txtScanQrCode').focus();
                        const mdlScanQrCode = document.querySelector("#mdlScanQrCode");
                        const inptQrCode = document.querySelector("#txtScanQrCode");
                        let focus = false;

                        mdlScanQrCode.addEventListener("mouseover", () => {
                            if (inptQrCode === document.activeElement) {
                                focus = true;
                            } else {
                                focus = false;
                            }
                        });

                        mdlScanQrCode.addEventListener("click", () => {
                            if (focus) {
                                inptQrCode.focus()
                            }
                        });
                    });
                });

                $('#txtSearchPONum').on('keypress', function(e){
                    // $('#txtScanQrCode').on('keypress', function(e){
                    if(e.keyCode == 13){
                        let search_po_number_val = $('#txtSearchPONum').val();
                        // let ScanQrCodeVal = jQuery.parseJSON($('#txtScanQrCode').val());
                        $.ajax({
                            type: "get",
                            url: "get_data_from_2nd_molding",
                            data: {
                                // "po_number" : ScanQrCodeVal.po_no
                                "po_number" : search_po_number_val
                            },
                            dataType: "json",
                            beforeSend: function(){
                                // prodData = {};
                            },
                            success: function (response) {
                                let sm_runcard_data = response['sec_molding_runcard_data'];
                                if(sm_runcard_data[0] == undefined){
                                    toastr.error('PO does not exists')
                                }else{
                                    $('#txtSearchPONum').val(sm_runcard_data[0]['po_number']);
                                    $('#txtSearchPartCode').val(sm_runcard_data[0]['parts_code']);
                                    $('#txtSearchMatName').val(sm_runcard_data[0]['device_name']);

                                    dtCnAssemblyRuncard.draw();
                                    // $('#txtScanQrCode').val('');
                                    // $('#mdlScanQrCode').modal('hide');
                                }
                            }
                        });
                    }
                });

                dtCnAssemblyRuncard = $("#tblCnAssemblyRuncard").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_cn_assembly_runcard",
                        data: function (param){
                            param.po_number = $("#txtSearchPONum").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "parts_code" },
                        { "data" : "po_number" },
                        { "data" : "runcard_no" },
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

                // CLARK CODE UNTIL HERE

                function getWarehouseTransactionByPONumber(poNumber){
                    $.ajax({
                        type: "get",
                        url: "get_search_po_for_molding",
                        data: {
                            "po_number" : poNumber
                        },
                        dataType: "json",
                        beforeSend: function(){},
                        success: function (response) {
                            if(response.length > 0){
                                $('#textSearchMaterialName').val(response[0]['ItemName']);
                                $('#textSearchPOQuantity').val(response[0]['OrderQty']);
                                $('#textDeviceName', $('#formSecondMolding')).val(response[0]['ItemName']);
                                $('#textPartsCode', $('#formSecondMolding')).val(response[0]['ItemCode']);
                                $('#textPONumber', $('#formSecondMolding')).val(response[0]['OrderNo']);
                                $('#textPoQuantity', $('#formSecondMolding')).val(response[0]['OrderQty']);
                            }
                            else{
                                toastr.error('No PO Found on Rapid PO Receive.')
                            }
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }
                $(document).on('keypress', '#textSearchPONumber', function(e){
                    if(e.keyCode == 13){
                        getWarehouseTransactionByPONumber($(this).val());
                        dataTablesSecondMolding.draw();
                    }
                });

                $('#buttonAddSecondMolding').on('click', function(e){
                    $('#modalSecondMolding').modal('show');
                    // let poNumber = $('#textSearchPONumber').val();
                    // let materialName = $('#textSearchMaterialName').val();
                    // let materialNameSubstring = materialName.substring(0,6);
                    // getWarehouseTransactionByPONumber(poNumber);

                    // if(poNumber != "" && materialName != ""){
                    //     if(materialNameSubstring == 'CN171S'){
                    //         $('#divMaterialLotNumbers').removeClass('d-none');
                    //         $('#textMaterialLotNumberChecking').val(1);
                    //     }else if (materialNameSubstring == 'CN171P'){
                    //         $('#divMaterialLotNumbers').addClass('d-none');
                    //         $('#textMaterialLotNumberChecking').val(0);
                    //     }
                    //     $('#modalSecondMolding').modal('show');
                    // }
                    // else{
                    //     toastr.error('Please input PO.')
                    // }
                });

                function redirectToACDCSDrawing(docNo, docTitle, docType) {
                    if (docTitle == '' )
                        alert('No Document')
                    else{
                        window.open(`http://rapid/ACDCS/prdn_home_pats_ppd_molding?doc_no=${docNo}&doc_title=${docTitle}&doc_type=${docType}`)
                    }
                }

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
                 * QR Code Scanner
                 * Start
                */
                $('#buttonQrScanMachineLotNumber, #buttonQrScanMaterialLotNumberEight, #buttonQrScanMaterialLotNumberNine, #buttonQrScanMaterialLotNumberTen, #buttonQrScanContactLotNumberOne, #buttonQrScanContactLotNumberSecond, #buttonQrScanMELotNumberOne, #buttonQrScanMELotNumberSecond').each(function(e){
                    $(this).on('click',function (e) {
                        let formValue = $(this).attr('form-value');
                        $('#modalQrScanner').attr('data-form-id', formValue).modal('show');
                        $('#textQrScanner').val('');
                        setTimeout(() => {
                            $('#textQrScanner').focus();
                        }, 500);
                    });
                });

                function delay(fn, ms) {
                    let timer = 0
                    return function(...args) {
                        clearTimeout(timer)
                        timer = setTimeout(fn.bind(this, ...args), ms || 0)
                    }
                }

                $('#textQrScanner').keyup(delay(function(e){
                    let valueQrScanner = $('#textQrScanner').val();
                    let formId = $('#modalQrScanner').attr('data-form-id');
                    if( e.keyCode == 13 ){
                        $('#textQrScanner').val(''); // Clear after enter
                        switch (formId) {
                            case 'formMachineLotNumber':
                                $.ajax({
                                    type: "get",
                                    url: "check_machine_lot_number",
                                    data: {
                                        machine_lot_number: valueQrScanner,
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        $('#textMaterialLotNumber').val('');
                                        $('#textMaterialName').val('');
                                        if(response[0] != undefined){
                                            $('#textMaterialLotNumber').val(response[0].machine_lot_number);
                                            $('#textMaterialName').val(response[0].machine_name);
                                            $('#modalQrScanner').modal('hide');
                                        }else{
                                            toastr.error('Incorrect machine lot number.')
                                        }
                                    }
                                });
                                break;
                            case 'formMaterialLotNumberEight':
                                $.ajax({
                                    type: "get",
                                    url: "check_material_lot_number",
                                    data: {
                                        material_lot_number: valueQrScanner,
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        let data = response;
                                        $('#textLotNumberEight').val('');
                                        $('#textLotNumberEightFirstMoldingId').val('');
                                        if(data.length > 0){
                                            if(data[0].first_molding_device_id == 1){
                                                $('#textLotNumberEight').val(data[0].contact_lot_number);
                                                $('#textLotNumberEightFirstMoldingId').val(data[0].first_molding_device_id);
                                                $('#modalQrScanner').modal('hide');
                                            }else{
                                                toastr.error('Incorrect machine lot number.')
                                            }
                                        }else{
                                            toastr.error('Incorrect machine lot number.')
                                        }
                                    }
                                });
                                break;
                            case 'formMaterialLotNumberNine':
                                $.ajax({
                                    type: "get",
                                    url: "check_material_lot_number",
                                    data: {
                                        material_lot_number: valueQrScanner,
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        let data = response;
                                        $('#textLotNumberNine').val('');
                                        $('#textLotNumberNineFirstMoldingId').val('');
                                        if(data.length > 0){
                                            if(data[0].first_molding_device_id == 2){
                                                $('#textLotNumberNine').val(data[0].contact_lot_number);
                                                $('#textLotNumberNineFirstMoldingId').val(data[0].first_molding_device_id);
                                                $('#modalQrScanner').modal('hide');
                                            }else{
                                                toastr.error('Incorrect machine lot number.')
                                            }
                                        }else{
                                            toastr.error('Incorrect machine lot number.')
                                        }
                                    }
                                });
                                break;
                            case 'formMaterialLotNumberTen':
                                $.ajax({
                                    type: "get",
                                    url: "check_material_lot_number",
                                    data: {
                                        material_lot_number: valueQrScanner,
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        let data = response;
                                        $('#textLotNumberTen').val('');
                                        $('#textLotNumberTenFirstMoldingId').val('');
                                        if(data.length > 0){
                                            if(data[0].first_molding_device_id == 3){
                                                $('#textLotNumberTen').val(data[0].contact_lot_number);
                                                $('#textLotNumberTenFirstMoldingId').val(data[0].first_molding_device_id);
                                                $('#modalQrScanner').modal('hide');
                                            }else{
                                                toastr.error('Incorrect machine lot number.')
                                            }
                                        }else{
                                            toastr.error('Incorrect machine lot number.')
                                        }
                                    }
                                });
                                break;
                            case 'formContactLotNumberOne':
                                if(valueQrScanner != ''){
                                    $('#textContactLotNumberOne').val(valueQrScanner);
                                }else{
                                    $('#textContactLotNumberOne').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formContactLotNumberSecond':
                                if(valueQrScanner != ''){
                                    $('#textContactLotNumberSecond').val(valueQrScanner);
                                }else{
                                    $('#textContactLotNumberSecond').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberOne':
                                if(valueQrScanner != ''){
                                    $('#textMELotNumberOne').val(valueQrScanner);
                                }else{
                                    $('#textMELotNumberOne').val('N/A');
                                    toastr.error('Please scan ME lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberSecond':
                                if(valueQrScanner != ''){
                                    $('#textMELotNumberSecond').val(valueQrScanner);
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
                 * Form of Second Molding
                 * Start
                */
                function isResponseError(elementId, boolean){
                    if(boolean == true){
                        $(`#${elementId}`).addClass('is-invalid');
                        $(`#${elementId}`).attr('title', '');
                    }else{
                        $(`#${elementId}`).removeClass('is-invalid');
                        $(`#${elementId}`).attr('title', '');
                    }
                }

                $('#formSecondMolding').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    console.log('data ', data);
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    toastr.success('Successfully saved');
                                    dataTablesSecondMolding.draw();
                                    $('#modalSecondMolding').modal('hide');
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

                $("#modalSecondMolding").on('hidden.bs.modal', function () {
                    // Reset form values
                    $("#formSecondMolding")[0].reset();

                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                });
                /**
                 * Form of Second Molding
                 * End
                */

                $("#tableSecondMolding").on('click', '.actionEditSecondMolding', function(){
                    let id = $(this).attr('second-molding-id');
                    console.log(`id ${id}`)
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
                                $('#textSecondMoldingId').val(responseData[0].id);
                                $('#textDeviceName').val(responseData[0].device_name);
                                $('#textPartsCode').val(responseData[0].parts_code);
                                $('#textPONumber').val(responseData[0].po_number);
                                $('#textPoQuantity').val(responseData[0].po_quantity);
                                $('#textMachineNumber').val(responseData[0].machine_number);
                                $('#textMaterialLotNumber').val(responseData[0].material_lot_number);
                                $('#textMaterialName').val(responseData[0].material_name);
                                $('#textDrawingNumber').val(responseData[0].drawing_number);
                                $('#textRevisionNumber').val(responseData[0].revision_number);
                                $('#textProductionLot').val(responseData[0].production_lot);
                                $('#textLotNumberEight').val(responseData[0].lot_number_eight);
                                $('#textLotNumberNine').val(responseData[0].lot_number_nine);
                                $('#textLotNumberTen').val(responseData[0].lot_number_ten);
                                $('#textContactLotNumberOne').val(responseData[0].contact_name_lot_number_one);
                                $('#textContactLotNumberSecond').val(responseData[0].contact_name_lot_number_second);
                                $('#textMELotNumberOne').val(responseData[0].me_name_lot_number_one);
                                $('#textMELotNumberSecond').val(responseData[0].me_name_lot_number_second);
                            }else{
                                toastr.error('No data found');
                            }
                        }
                    });
                });
            });
        </script>
    @endsection
@endauth

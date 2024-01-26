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

    @section('title', 'Packing')

    @section('content_page')

        <style type="text/css">
            .hidden_scanner_input{
                position: absolute;
                opacity: 0;
            }
            textarea{
                resize: none;
            }

            .center {
                position: absolute;
                float: left;
                left: 45%;
                top: 35%;
                transform: translate(-50%, -50%);
            }

            #colDevice, #colMaterialProcess{
                transition: .5s;
            }

            .checked-ok { background: #5cec4c!important; }

        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Packing Details</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Packing Details</li>
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
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalScanPO"><i class="fa-solid fa-qrcode"></i></button>
                                                {{-- <input type="text" class="form-control" placeholder="PO Number" id="txtSearchPONum" value="450244133600010"> --}}
                                                <input type="text" class="form-control" placeholder="PO Number" id="txtSearchPONum" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Quantity" id="txtSearchPOQty" readonly>
                                            </div>
                                        </div>
                                        {{-- <div hidden class="col-sm-2">
                                            <label class="form-label">Production Lot #</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Production Lot #" id="txtSearchLotNo" readonly>
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
                                    <h3 class="card-title">Packing Table</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Prelim-tab" data-bs-toggle="tab" href="#prelimTab" role="tab" aria-controls="prelimTab" aria-selected="true">Preliminary Packing</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Completed-tab" data-bs-toggle="tab" href="#finalPacking" role="tab" aria-controls="finalPacking" aria-selected="false">Final Packing</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="prelimTab" role="tabpanel" aria-labelledby="prelimTab-tab"><br>

                                            <div class="table-responsive">
                                                <table id="tblPreliminaryPackingDetails" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                        <th>PO #</th>
                                                        <th>Parts Code</th>
                                                        <th>Parts Name</th>
                                                        <th>Production Lot #</th>
                                                        <th>Shipment Qty</th>
                                                        <th>Validated By</th>
                                                        <th>Validated Date</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade show" id="finalPacking" role="tabpanel" aria-labelledby="finalPacking-tab"><br>
                                            {{-- <div style="float: right;"> --}}
                                                <button class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalScanLotNumber" id="btnScanLotNumber"><i
                                                        class="fa-solid fa-qrcode"></i>  Validate Lot #
                                                </button><br><br>
                                            {{-- </div> --}}
                                            <div class="table-responsive">
                                                <table id="tblFinalPackingDetails" class="table table-sm table-bordered table-striped table-hover"
                                                style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Parts Name</th>
                                                            <th>PO #</th>
                                                            <th>Quantity</th>
                                                            <th>Delivery Balance</th>
                                                            <th>Drawing #</th>
                                                            <th>Lot #</th>
                                                            <th>No. of Cuts</th>
                                                            <th>Material Quality</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

         <!-- MODALS -->
    <div class="modal fade" id="modalScanPO">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanPO" name="po_scan" autocomplete="off">
                    <div class="text-center text-secondary"><span id="modalScanQRSaveText">Please scan PO Number</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalEditPackingDetails" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Packing Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formEditPackingDetails" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtPackingDetailsId" name="packing_details_id">

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">PO #</label>
                                    <input type="text" class="form-control form-control-sm" name="po_no" id="txtPONumber" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">PO Quantity</label>
                                    <input type="text" class="form-control form-control-sm" name="po_quantity" id="txtPOQuantity" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Parts Name</label>
                                    <input type="text" class="form-control form-control-sm" name="parts_name" id="txtPartsName" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Production Lot #</label>
                                    <input type="text" class="form-control form-control-sm" name="prod_lot_no" id="txtProdLotNumber" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Drawing #</label>
                                    <input type="text" class="form-control form-control-sm" name="drawing_no" id="txtDrawingNumber" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Delivery Balance</label>
                                    <input type="text" class="form-control form-control-sm" name="delivery_balance" id="txtDeliveryBalance" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">No. of Cuts</label>
                                    <input type="text" class="form-control form-control-sm" name="number_of_cuts" id="txtNumberOfCuts" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Material Quality</label>
                                    <input type="text" class="form-control form-control-sm" name="material_quality" id="txtMaterialQuality" autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditPackingDetails" class="btn btn-primary"><i id="btnEditPackingDetailsIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

     <!-- MODALS -->
    <div class="modal fade" id="modalScanEmpId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formOqcDetails">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtOqcDetailsId" name="oqc_details_id">
                        <input type="hidden" id="txtScanPONumber" name="po_no">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanEmpId" name="scan_id" autocomplete="off">
                        <div class="text-center text-secondary"><span id="modalScanEmpIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

       {{-- MODAL FOR PRINTING  --}}
       <div class="modal fade" id="modalGeneratePackingDetailsQr">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Packing - QR Code</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- PO 1 -->
                        <div class="col-sm-12">
                            <center><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->margin(5)->errorCorrection('H')->generate('0')) !!}" id="img_barcode_PO" style="max-width: 200px;"><br></center>
                            <label id="img_barcode_PO_text"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnGeneratePackingDetailsQr" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <!-- MODALS -->
    <div class="modal fade" id="modalScanQRtoReprint">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserIdtoReprint" name="scan_id_to_reprint" autocomplete="off">
                    <div class="text-center text-secondary"><span id="modalScanQRReprintText"></span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- /.modal -->

    <!-- MODALS -->
    <div class="modal fade" id="modalScanLotNumber">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanLotNumber" name="scan_lot_number" autocomplete="off" value='{"po_no":"450244133600010","po_qty":"2400","mat_name":"CT 6009-VE","lot_no":"C240123-0101MZ-2","drawing_no":"B139312-001","del_bal":"2500","no_of_cuts":"1","mat_quality":"test"}'>
                    {{-- <input type="text" class="w-100 " id="txtScanLotNumber" name="scan_lot_number" autocomplete="off"> --}}
                    <div class="text-center text-secondary"><span id="modalScanLotNumber">Scan Lot Number</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->



    @endsection

    @section('js_content')
        <script type="text/javascript">

                $('.select2').select2({
                    theme: 'bootstrap-5'
                });

            let scannedPO;
            let ParseScannedPo;
            let img_barcode_PO_text_hidden;

            $(document).ready(function(){

                $('#modalScanPO').on('shown.bs.modal', function () {
                    $('#txtScanPO').focus();
                    $('#txtScanPO').on('keyup', function(e){
                        if(e.keyCode == 13){
                            scannedPO = $('#txtScanPO').val();
                            ParseScannedPo = JSON.parse(scannedPO);
                            console.log(ParseScannedPo);
                            // alert('heey');
                            $('#txtSearchPONum').val(ParseScannedPo['po']);
                            $('#txtSearchMatName').val(ParseScannedPo['name']);
                            $('#txtSearchPOQty').val(ParseScannedPo['qty']);

                            $('#modalScanPO').modal('hide');
                            dtFinalPackingDetails.draw();
                            dtPrelimPackingDetails.draw();
                        }
                    });
                });

                dtPrelimPackingDetails = $("#tblPreliminaryPackingDetails").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_preliminary_packing_details",
                        data: function (param){
                            param.po_no = $("#txtSearchPONum").val();
                        },
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "po_no"},
                        { "data" : "stamping_production_info.part_code" },
                        { "data" : "stamping_production_info.material_name"},
                        { "data" : "stamping_production_info.prod_lot_no" },
                        { "data" : "stamping_production_info.ship_output"},
                        { "data" : "prelim_packing_info.validated_by"},
                        { "data" : "prelim_packing_info.validated_date"},
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [7,8],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });

                dtFinalPackingDetails = $("#tblFinalPackingDetails").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_final_packing_details_data",
                        data: function (param){
                            param.po_no = $("#txtSearchPONum").val();
                        },
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "oqc_info.stamping_production_info.material_name"},
                        { "data" : "po_no"},
                        { "data" : "oqc_info.stamping_production_info.ship_output"},
                        { "data" : "final_packing_info.delivery_balance" },
                        { "data" : "oqc_info.stamping_production_info.drawing_no"},
                        { "data" : "oqc_info.stamping_production_info.prod_lot_no"},
                        { "data" : "final_packing_info.no_of_cuts"},
                        { "data" : "final_packing_info.material_quality" },
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [1,5,8,9],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });


                $(document).on('click', '.btnEditPackingDetails', function(e){
                    e.preventDefault();
                    let oqcDetailsId =  $(this).attr('oqc-id');

                    $('#txtPackingDetailsId').val(oqcDetailsId);
                    console.log(oqcDetailsId);

                    $('#modalEditPackingDetails').modal('show');

                    getOqcDetailsbyId(oqcDetailsId);

                });

                $(document).on('click', '.btnValidatePrelimPackingDetails', function(e){
                    e.preventDefault();
                    let oqcDetailsId =  $(this).attr('data-id');
                    let poNumber =  $(this).attr('po-no');
                    $('#txtOqcDetailsId').val(oqcDetailsId);
                    $('#txtScanPONumber').val(poNumber);
                    // console.log(poNumber);
                    // console.log(oqcDetailsId);
                    $('#modalScanEmpId').modal('show');

                });

                $('#modalScanEmpId').on('shown.bs.modal', function () {
                    $('#txtScanEmpId').focus();
                    $('#txtScanEmpId').on('keyup', function(e){
                        if(e.keyCode == 13){
                            // console.log('keyCode called');
                            scanEmpId = $('#txtScanEmpId').val();
                            // console.log(scanEmpId);
                            // console.log(txtOqcDetailsId);
                            // $('#formOqcDetails').trigger('submit');
                        }
                    });
                });


                $('#formOqcDetails').submit(function(e){
                    e.preventDefault();
                    let data1 = $('#formOqcDetails').serialize();
                    $.ajax({
                        type: "post",
                        url: "updated_validated_by",
                        data: data1,
                        dataType: "json",
                        success: function (response) {
                            if(response['validation'] == 1){
                                toastr.error('Saving data failed!');

                            }else if(response['result'] == 0){
                                toastr.success('Validation Succesful!');
                                $("#formOqcDetails")[0].reset();
                                $('#modalScanEmpId').modal('hide');
                                dtPrelimPackingDetails.draw();
                            }
                        }
                    });
                });

                $('#formEditPackingDetails').submit(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "add_packing_details",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function (response) {
                            if(response['validation'] == 1){
                                toastr.error('Saving data failed!');
                                // if(response['error']['loading_port'] === undefined){
                                //     $("#txtDestinationPort").removeClass('is-invalid');
                                //     $("#txtDestinationPort").attr('title', '');
                                // }
                                // else{
                                //     $("#txtDestinationPort").addClass('is-invalid');
                                //     $("#txtDestinationPort").attr('title', response['error']['loading_port']);
                                // }
                            }else if(response['result'] == 0){
                                $("#formEditPackingDetails")[0].reset();
                                toastr.success('Succesfully saved!');
                                $('#modalEditPackingDetails').modal('hide');
                                dtFinalPackingDetails.draw();
                            }
                            $("#btnEditPackingDetailsIcon").removeClass('spinner-border spinner-border-sm');
                            $("#btnEditPackingDetails").removeClass('disabled');
                            $("#btnEditPackingDetailsIcon").addClass('fa fa-check');
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });

                let printId;

                $(document).on('click', '.btnGeneratePackingQr', function(e){
                    e.preventDefault();
                // $('#modalScanQRtoSave').modal('show');
                    printId = $(this).data('id');
                    let printCount = $(this).data('printcount');
                    console.log(`id`, printId);
                    console.log(`printCount`, printCount);
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
                                $('#modalScanQRtoReprint').modal('show');
                                $('#modalScanQRReprintText').html('Please Scan Supervisor ID.')
                                scanningFunction = "reprintStamping"
                            }
                        });
                    }
                    else{
                        generatePackingQr(printId);
                        dtFinalPackingDetails.draw();
                        dtPrelimPackingDetails.draw();
                    }
                });

                $('#btnGeneratePackingDetailsQr').on('click', function(){
                        popup = window.open();
                        // console.log(img_barcode_PO_text_hidden);
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

                        console.log(`id`, img_barcode_PO_text_hidden[0]['id']);

                        /*
                            * this event will trigger after closing the tab of printing
                        */
                        popup.addEventListener("beforeunload", function (e) {
                            changePrintingStatus(img_barcode_PO_text_hidden[0]['id']);
                        });

                        popup.close();

                });

                $(document).on('keyup','#txtScanUserIdtoReprint', function(e){
                    if(e.keyCode == 13){
                        if(scanningFunction === "reprintStamping"){
                            validateUser($(this).val().toUpperCase(), [0,1,9], function(result){
                                console.log(result);
                                if(result == true){
                                    $('#modalScanQRtoReprint').modal('hide');
                                    generatePackingQr(printId);
                                    dtFinalPackingDetails.draw();
                                    dtPrelimPackingDetails.draw();
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

                $('#modalScanLotNumber').on('shown.bs.modal', function () {
                    $('#txtScanLotNumber').focus();
                });

                $('#txtScanLotNumber').on('keyup', function(e){
                    if(e.keyCode == 13){
                        // alert('chris');
                        try{
                            scannedItem = JSON.parse($(this).val());
                            $('#tblFinalPackingDetails tbody tr').each(function(index, tr){
                                let lot_no = $(tr).find('td:eq(7)').text().trim().toUpperCase();

                                // console.log('this ', $(this).find('td:nth-child(1)').children().children().removeAttr('style'));
                                let powerOff = $(this).find('td:nth-child(1)').children().children();

                                console.log('tblFinalPackingDetails', lot_no);
                                console.log('scannedItem', scannedItem['lot_no']);
                               
                                if(scannedItem['lot_no'] === lot_no){
                                    $(tr).addClass('checked-ok');
                                    powerOff.removeAttr('style');

                                    $('#modalScanLotNumber').modal('hide');
                                }
                                // console.log(lot_no);
                            })
                        }
                        catch (e){
                            toastr.error('Invalid Sticker');
                            console.log(e);
                        }
                        $(this).val('');
                    }
                });

            });

        </script>
    @endsection
@endauth

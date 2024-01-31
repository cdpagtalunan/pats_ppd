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

    @section('title', 'Receiving')

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
            /* .pmi_color{
                background: #c0c0aa;
                background: -webkit-linear-gradient(to right, #c0c0aa, #1cefff);
                background: linear-gradient(to right, #c0c0aa, #1cefff);
            } */

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
                            <h1>Receiving</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Receiving</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Receiving List Table</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalExportPackingList" id="btnExportPackingList">
                                                <i class="fa-solid fa-plus"></i> Export Packing List
                                        </button>

                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalAddPackingList" id="btnShowAddPackingList"><i
                                                class="fas fa-clipboard-list"></i> Add Packing List
                                        </button> --}}
                                    </div> <br><br>

                                     <ul class="nav nav-tabs" id="myTab" role="tablist"> {{-- by nessa --}}
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Pending-tab" data-bs-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="true">For Receive</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Completed-tab" data-bs-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">Accepted</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="menu1" role="tabpanel" aria-labelledby="menu1-tab"><br>
                                            <div class="table-responsive">
                                                {{-- <!-- style="max-height: 600px; overflow-y: auto;" --> --}}
                                                <table id="tblReceivingDetails" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" class="text-center pl-5 pr-5">Action</th>
                                                            <th rowspan="2" class="text-center pl-5 pr-5">Status</th>
                                                            <th rowspan="2" class="text-center pl-5 pr-5">New Lot #</th>
                                                            <th colspan="4" style="text-align: center;">PMI Details</th>
                                                            <th colspan="3" style="text-align: center;">Supplier Details</th>
                                                        </tr>

                                                        <tr>
                                                            <th>Packing List Ctrl #</th>
                                                            <th>Material name</th>
                                                            <th>Production Lot #</th>
                                                            <th>Shipment Qty</th>

                                                            <th>Name</th>
                                                            <th>Lot #</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="menu2" role="tabpanel" aria-labelledby="menu2-tab"><br>
                                            <div class="table-responsive">
                                                {{-- <!-- style="max-height: 600px; overflow-y: auto;" --> --}}
                                                <table id="tblReceivingDetailsAccepted" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>

                                                            <th rowspan="2" class="text-center pl-5 pr-5">New Lot #</th>
                                                            <th colspan="4" style="text-align: center;">PMI Details</th>
                                                            <th colspan="3" style="text-align: center;">Supplier Details</th>
                                                        </tr>

                                                        <tr>
                                                            <th>Packing List Ctrl #</th>
                                                            <th>Material name</th>
                                                            <th>Production Lot #</th>
                                                            <th>Shipment Qty</th>

                                                            <th>Name</th>
                                                            <th>Lot #</th>
                                                            <th>Qty</th>
                                                        </tr>
                                                    </thead>
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
     {{-- * ADD --}}
     <div class="modal fade" id="modalEditReceivingDetails" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-edit"></i> WHSE Receiving From SANNO Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formAddReceivingDetails">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtReceivingDetailsId" name="receiving_details_id">

                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Packing List Ctrl #</label>
                                    <input type="text" class="form-control form-control-sm" name="packing_ctrl_no" id="txtPackingCtrlNo" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Shipment Qty</label>
                                    <input type="text" class="form-control form-control-sm" name="pmi_qty" id="txtPmiQty" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Material Name</label>
                                    <input type="text" class="form-control form-control-sm" name="pmi_material_name" id="txtPmiMaterialName" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Lot #</label>
                                    <input type="text" class="form-control form-control-sm" name="pmi_lot_no" id="txtPmiLotNo" readonly>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control form-control-sm" name="supplier_name" id="txtSupplierName" readonly value="SMPC">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Invoice #</label>
                                    <input type="text" class="form-control form-control-sm" name="invoice_no" id="txtInvoiceNo" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Supplier Lot #</label>
                                    <input type="text" class="form-control form-control-sm" name="supplier_lot_no" id="txtSupplierLotNo" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Supplier Qty</label>
                                    <input type="text" class="form-control form-control-sm" name="supplier_qty" id="txtSupplierQty" autocomplete="off">
                                </div>
                            </div>







                            {{-- <div hidden class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">PO #</label>
                                    <input type="text" class="form-control form-control-sm" name="po_no" id="txtPmiPo" readonly>
                                </div>
                            </div> --}}

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnEditReceivingDetails" class="btn btn-dark"><i id="btnEditReceivingDetailsIcon"
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
    <div class="modal fade" id="modalScanQRtoSave">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserId" name="scan_id" autocomplete="off">
                    <div class="text-center text-secondary"><span id="modalScanQRSaveText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

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

            {{-- MODAL FOR PRINTING  --}}
        <div class="modal fade" id="modalPrintQr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Receiving - QR Code</h4>
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
                        <button type="submit" id="btnPrintQrCode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    @endsection

    @section('js_content')
        <script type="text/javascript">

        $(document).ready(function(){
                dtReceivingDetails = $("#tblReceivingDetails").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_receiving_details",
                },
                fixedHeader: true,
                "columns":[
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "status"},
                    { "data" : "supplier_pmi_lot_no"},
                    { "data" : "control_no"},
                    { "data" : "mat_name"},
                    { "data" : "lot_no"},
                    { "data" : "quantity"},
                    { "data" : "supplier_name"},
                    { "data" : "supplier_lot_no"},
                    { "data" : "supplier_quantity"},
                ],
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"},
                    {
                        "targets": [2,7,8,9],
                        "data": null,
                        "defaultContent": "---"
                    },
                ],
            });

            dtReceivingDetailsAccepted = $("#tblReceivingDetailsAccepted").DataTable({ // by nessa
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_receiving_details_accepted",
                },
                fixedHeader: true,
                "columns":[
                    { "data" : "supplier_pmi_lot_no"},
                    { "data" : "control_no"},
                    { "data" : "mat_name"},
                    { "data" : "lot_no"},
                    { "data" : "quantity"},
                    { "data" : "supplier_name"},
                    { "data" : "supplier_lot_no"},
                    { "data" : "supplier_quantity"},
                ],
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"},
                    {
                        "targets": [2,5,6,7],
                        "data": null,
                        "defaultContent": "---"
                    },
                ],
            });

            $(document).on('click', '.btnEditReceivingDetails', function(e){
                // alert('pumasok na dito');
                $('#modalEditReceivingDetails').modal('show');
                let receivingDetailsId = $(this).attr('data-id');
                $('#txtReceivingDetailsId').val(receivingDetailsId);
                console.log(receivingDetailsId);

                getReceivingDetailsId(receivingDetailsId);
            });

            $('#formAddReceivingDetails').submit(function(e){
                e.preventDefault();
                $('#modalScanQRtoSave').modal('show');
            });

            $('#modalScanQRtoSave').on('shown.bs.modal', function () {
                $('#txtScanUserId').focus();
            });

            $(document).on('keypress', '#txtScanUserId', function(e){
                let toScanId =  $('#txtScanUserId').val();
                let scanId = {
                    'scan_id' : toScanId
                }
                if(e.keyCode == 13){
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "update_receiving_details",
                        data: $('#formAddReceivingDetails').serialize() + '&' + $.param(scanId),
                        dataType: "json",
                        success: function (response) {
                            if(response['validation'] == 1){
                                toastr.error('Saving data failed!');
                                    if(response['error']['supplier_name'] === undefined){
                                        $("#txtSupplierName").removeClass('is-invalid');
                                        $("#txtSupplierName").attr('title', '');
                                    }
                                    else{
                                        $("#txtSupplierName").addClass('is-invalid');
                                        $("#txtSupplierName").attr('title', response['error']['supplier_name']);
                                    }
                                    if(response['error']['supplier_lot_no'] === undefined){
                                        $("#txtSupplierLotNo").removeClass('is-invalid');
                                        $("#txtSupplierLotNo").attr('title', '');
                                    }
                                    else{
                                        $("#txtSupplierLotNo").addClass('is-invalid');
                                        $("#txtSupplierLotNo").attr('title', response['error']['supplier_lot_no']);
                                    }
                                    if(response['error']['supplier_qty'] === undefined){
                                        $("#txtSupplierQty").removeClass('is-invalid');
                                        $("#txtSupplierQty").attr('title', '');
                                    }
                                    else{
                                        $("#txtSupplierQty").addClass('is-invalid');
                                        $("#txtSupplierQty").attr('title', response['error']['supplier_qty']);
                                    }

                            }else if(response['result'] == 0){
                                toastr.success('Receiving Details Updated!');
                                $('#modalEditReceivingDetails').modal('hide');
                                $('#modalScanQRtoSave').modal('hide');
                                dtReceivingDetails.draw();
                            }
                        }
                    });
                }
            });

            $("#modalEditReceivingDetails").on('hide.bs.modal', function(){
                $("#formAddReceivingDetails").trigger("reset");
                dtReceivingDetails.draw();
            });

            $(document).on('click', '.btnPrintReceivingData', function(e){
                e.preventDefault();
                // $('#modalScanQRtoSave').modal('show');
                printId = $(this).data('id');
                let printCount = $(this).data('printcount');
                // console.log(printCount);
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
                    printReceivingData(printId);
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
                    popup.addEventListener("beforeunload", function (e) {
                        changePrintStatus(img_barcode_PO_text_hidden[0]['id']);
                    });

                    popup.close();

            });

            $('#modalScanQRtoReprint').on('shown.bs.modal', function () {
                $('#txtScanUserIdtoReprint').focus();
            });


            $(document).on('keyup','#txtScanUserIdtoReprint', function(e){
                if(e.keyCode == 13){
                    if(scanningFunction === "reprintStamping"){
                        validateUser($(this).val().toUpperCase(), [0,1,9], function(result){
                            console.log(result);
                            if(result == true){
                                $('#modalScanQRtoReprint').modal('hide');
                                printReceivingData(printId);
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

        });


        </script>
    @endsection
@endauth

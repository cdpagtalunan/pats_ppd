@php $layout = 'layouts.admin_layout'; @endphp

@auth
    @extends($layout)

    @section('title', 'Material Process')

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
                            <h1>Packing Details to Molding</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Packing Details to Molding</li>
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
                                    <div style="float: right;">
                                    </div>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Packing-tab" data-bs-toggle="tab" href="#packingTab" role="tab" aria-controls="packingTab" aria-selected="true">Packing Data</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" id="Received-tab" data-bs-toggle="tab" href="#moldingReceived" role="tab" aria-controls="moldingReceived" aria-selected="false">Molding Received</a>
                                        </li> --}}
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="packingTab" role="tabpanel" aria-labelledby="packingTab-tab"><br>
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalPackingScanLotNumber" id="btnPackingScanLotNumber"><i
                                                class="fa-solid fa-qrcode"></i>&nbsp; Validation of Lot #
                                            </button><br><br>
                                            <div class="table-responsive">
                                                <table id="tblPackingDetailsForEndorsement" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Part Code</th>
                                                            <th>Part Name</th>
                                                            <th>1st Press Lot #</th>
                                                            <th>Plating Lot #</th>
                                                            <th>2nd Press Lot #</th>
                                                            <th>Lot Qty</th>
                                                            <th>Counted By</th>
                                                            <th>Checked By</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade show" id="moldingReceived" role="tabpanel" aria-labelledby="moldingReceived-tab"><br>

                                            <div class="table-responsive">
                                                <table id="tblPackingDetailsEndorsed" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Part Code</th>
                                                            <th>Part Name</th>
                                                            <th>Lot #</th>
                                                            <th>Lot Qty</th>
                                                            <th>Endorsed By</th>
                                                            <th>Date</th>
                                                            <th>Received By</th>
                                                            <th>Date</th>
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
     <div class="modal fade" id="modalPackingScanLotNumber">
        <div class="modal-dialog modal-dialog-center">
            <div class="modal-content modal-sm">
                <div class="modal-body">
                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanPackingLotNumber" name="scan_packing_lot_number" autocomplete="off">
                    <div class="text-center text-secondary"><span id="modalScanPackingIdText">Scan Lot Number</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                </div>
            </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- MODALS -->
    <div class="modal fade" id="modalScanQCId">
        <div class="modal-dialog">
            <div class="modal-content modal-sm">
                <form id="formScanQCId">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtPackingMoldingDetailsId" name="molding_packing_details_id">
                        {{-- <input type="hidden" id="txtScanPONumber" name="po_no"> --}}
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQcId" name="scan_id" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanQcId" name="qc_scan_id" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalScanQCIdText">Please scan QC ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    {{-- * view --}}
    <div class="modal fade" id="modalViewSubLotDetails" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Sub Lot Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtStampingDetailsId" name="stamping_details_id">
                        <div class="col-sm-12">
                            <strong>Sub Lot Details</strong>
                            <button disabled class="btn btn-primary" data-bs-toggle="modal" style="float: right;"
                                data-bs-target="#modalVerifyData" id="btnVerifyScanLotNumber"><i
                                    class="fa-solid fa-qrcode"></i>&nbsp; Validation of Lot #
                            </button>
                        </div>
                        <hr>

                            <div class="table-responsive">
                                <table id="tblViewSublotDetails" class="table table-sm table-bordered table-striped table-hover"style="width: 100%;">
                                    <thead>
                                        <tr>
                                            {{-- <th>Action</th> --}}
                                            {{-- <th>Status</th> --}}
                                            <th>Sub Lot #</th>
                                            <th>PO</th>
                                            <th>Material Name</th>
                                            <th>Production Lot #</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button disabled type="submit" id="btnSaveSubLotDetails" class="btn btn-primary"><i id="btnSaveSubLotDetailsIcon"class="fa fa-check"></i> Save</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

        <!-- MODALS -->
        <div class="modal fade" id="modalVerifyData">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content modal-sm">
                    <div class="modal-body">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanVerifyData" name="scan_packing_lot_number" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanVerifyData" name="scan_packing_lot_number" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalScanPackingIdText">Scan Lot Number</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="modalScanEmpId">
            <div class="modal-dialog center">
                <div class="modal-content modal-sm">
                    <form id="formOqcDetails">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="txtOqcDetailsId" name="oqc_details_id">
                            <input type="hidden" id="txtPMId" name="PM_details_id">
                            <input type="hidden" id="txtScanPONumber" name="po_no">
                            <input type="hidden" id="txtMoldingId" name="molding_id">
                            <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanPackerId" name="packer_scan_id" autocomplete="off">
                            {{-- <input type="text" class="scanner w-100 " id="txtScanPackerId" name="packer_scan_id" autocomplete="off"> --}}
                            <div class="text-center text-secondary"><span id="modalScanEmpIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                        </div>
                    </form>

                </div>
            <!-- /.modal-content -->
            </div>
                <!-- /.modal-dialog -->
        </div>

    @endsection

    @section('js_content')
        <script type="text/javascript">

                $('.select2').select2({
                    theme: 'bootstrap-5'
                });

            let scannedPO;
            let ParseScannedPo;
            let PackingMoldingId;

            $(document).ready(function(){

                $('#modalScanPO').on('shown.bs.modal', function () {
                    $('#txtScanPO').focus();
                    $('#txtScanPO').on('keyup', function(e){
                        if(e.keyCode == 13){

                            scannedPO = $('#txtScanPO').val();
                            ParseScannedPo = JSON.parse(scannedPO);
                            // console.log(ParseScannedPo['cat']);
                            if(ParseScannedPo['cat'] != 1){
                                // alert('heey');
                                $('#txtSearchPONum').val(ParseScannedPo['po']);
                                $('#txtSearchMatName').val(ParseScannedPo['name']);
                                $('#txtSearchPOQty').val(ParseScannedPo['qty']);

                                $('#modalScanPO').modal('hide');
                                dtPackingDetailsFE.draw()
                            }else{

                                toastr.error('Invalid Sticker');
                            }

                        }
                    });
                });

                dtPackingDetailsFE = $("#tblPackingDetailsForEndorsement").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_packing_details_fe",
                        data: function (param){
                            param.po_no = $("#txtSearchPONum").val();
                        },
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status"},
                        { "data" : "stamping_production_info.part_code"},
                        { "data" : "stamping_production_info.material_name"},
                        { "data" : "fs_lot_no"},
                        { "data" : "plating_lot_no"},
                        { "data" : "stamping_production_info.prod_lot_no"},
                        { "data" : "stamping_production_info.ship_output"},
                        { "data" : "first_molding_info.user_validated_by_info.firstname"},
                        { "data" : "first_molding_info.user_checked_by_info.firstname" },
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [8,9],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });

                //  dtPackingDetailsE = $("#tblPackingDetailsEndorsed").DataTable({
                //     "processing"    : false,
                //     "serverSide"    : true,
                //     "destroy"       : true,
                //     "ajax" : {
                //         url: "view_packing_details_e",
                //         data: function (param){
                //             param.po_no = $("#txtSearchPONum").val();
                //         },
                //     },

                //     "columns":[
                //         { "data" : "action", orderable:false, searchable:false },
                //         { "data" : "stamping_production_info.part_code"},
                //         { "data" : "stamping_production_info.material_name"},
                //         { "data" : "stamping_production_info.prod_lot_no"},
                //         { "data" : "stamping_production_info.ship_output"},
                //         { "data" : "first_molding_info.endorsedby" },
                //         { "data" : "first_molding_info.date_endorsed"},
                //         { "data" : "first_molding_info.receivedby"},
                //         { "data" : "first_molding_info.date_received" },
                //     ],
                //     "columnDefs": [
                //         {"className": "dt-center", "targets": "_all"},
                //         {
                //             "targets": [5,6,7,8],
                //             "data": null,
                //             "defaultContent": "---"
                //         },
                //     ],
                // });

                let rowCount;
                let dataStatus;
                let moldingId;
                $(document).on('click', '.btnViewSublotForScanning', function(e){
                    let stampingDetailsId =  $(this).attr('data-id');
                    moldingId = $(this).attr('molding-id');
                    // console.log(moldingId);
                    dataStatus =  $(this).attr('data-status');

                    console.log(dataStatus);

                    if(dataStatus == 0 || dataStatus == null){
                        $('#btnVerifyScanLotNumber').removeAttr('disabled');
                    }

                    let oqcDetailsId =  $(this).attr('oqc-id');
                    let poNumber =  $(this).attr('po-no');
                    $('#txtMoldingId').val(moldingId)
                    $('#txtOqcDetailsId').val(oqcDetailsId);
                    $('#txtScanPONumber').val(poNumber);
                    $('#txtStampingDetailsId').val(stampingDetailsId);

                    $('#modalViewSubLotDetails').modal('show');
                    dtViewSublotDetails.draw();
                    setTimeout(() => {
                        rowCount = $('#tblViewSublotDetails tbody tr').length;
                        // rowCount = rowCount - 1;
                        // console.log('rowCount', rowCount);
                    }, 500);
                });

                let dtViewSublotDetails = $("#tblViewSublotDetails").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "info"       : false,
                    "ordering"   : false,
                    "paging"     : false,
                    "bFilter"     : false,
                    "ajax" : {
                        url: "view_sublot_details",
                        data: function(param){
                        param.stamping_details_id =  $("#txtStampingDetailsId").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        // { "data"  : 'DT_RowIndex'},
                        // { "data" : "action", orderable:false, searchable:false },
                        // { "data" : "status"},
                        { "data" : "counter"},
                        { "data" : "stamping_info.po_num"},
                        { "data" : "stamping_info.material_name"},
                        { "data" : "stamping_info.prod_lot_no"},
                        { "data" : "batch_qty"},
                    ],
                });

                $('#modalPackingScanLotNumber').on('shown.bs.modal', function () {
                    $('#txtScanPackingLotNumber').focus();
                });

                $('#txtScanPackingLotNumber').on('keyup', function(e){
                    if(e.keyCode == 13){
                        try{
                            scannedItem = JSON.parse($(this).val());
                            // console.log('scannedItem', scannedItem);
                            $('#tblPackingDetailsForEndorsement tbody tr').each(function(index, tr){
                                let lot_no = $(tr).find('td:eq(6)').text().trim().toUpperCase();

                                let powerOff = $(this).find('td:nth-child(1)').children();

                                console.log('scannedItem', scannedItem['production_lot_no']);
                                console.log('lot_no', lot_no);
                                console.log('powerOff', powerOff);

                                if(scannedItem['production_lot_no'] === lot_no){
                                    $(tr).addClass('checked-ok');
                                    powerOff.removeAttr('style');
                                    $('#modalPackingScanLotNumber').modal('hide');
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


                $('#modalVerifyData').on('shown.bs.modal', function () {
                    $('#txtScanVerifyData').focus();
                });

                let idsOfSubLotDetails = [];
                $('#txtScanVerifyData').on('keyup', function(e){
                    if(e.keyCode == 13){
                        try{
                            // alert('hehe');
                            scannedItem = JSON.parse($(this).val());
                            console.log('scannedItem', scannedItem);
                            if(scannedItem['cat'] == 2){
                                $('#tblViewSublotDetails tbody tr').each(function(index, tr){
                                    let second_stamping_sub_lot = $(tr).find('td:eq(0)').text().trim().toUpperCase();
                                    let second_stamping_prod_lot = $(tr).find('td:eq(3)').text().trim().toUpperCase();
                                    // let 2nd_stamping_lot_no = $(tr).find('td:eq(6)').text().trim().toUpperCase();

                                    let powerOff = $(this).find('td:nth-child(1)').children();

                                    // 

                                    if(scannedItem['sublot_counter'].substring(0,1) == second_stamping_sub_lot && scannedItem['production_lot_no'] === second_stamping_prod_lot){
                                        $(tr).addClass('checked-ok');
                                        let id = $(this).attr('id');
                                        if(!idsOfSubLotDetails.includes(id)){
                                            idsOfSubLotDetails.push(id);
                                        }
                                    }

                                    let scannedRow = dtViewSublotDetails.$('tr.checked-ok');
                                    // If some rows are selected
                                    if(scannedRow.length){
                                        // console.log('selectedCount', scannedRow.length);
                                        if (scannedRow.length == rowCount) {
                                            $('#btnSaveSubLotDetails').removeAttr('disabled');
                                            $('#modalVerifyData').modal('hide');

                                        }
                                    // Otherwise, if no rows are selected
                                    }

                                    console.log(`scannedItemSublot`, scannedItem['sublot_counter']);
                                    console.log(`tblSubLot`, second_stamping_sub_lot);
                                })
                            }else{
                                toastr.error('Invalid Sticker');
                            }
                        }
                        catch (e){
                            toastr.error('Invalid Sticker');
                            // console.log(e);
                        }
                        $(this).val('');
                    }
                });

                $('#btnSaveSubLotDetails').on('click', function(e){
                    $('#modalScanEmpId').modal('show');
                    // alert('hehe');
                });

                $('#modalScanEmpId').on('shown.bs.modal', function () {
                    $('#txtScanPackerId').focus();
                });

                $('#formOqcDetails').submit(function(e){
                    e.preventDefault();
                });

                $('#txtScanPackerId').on('keyup', function(e){
                    let toScanEmpId =  $('#txtScanPackerId').val();
                    let toScanMoldingId   =  $('#txtMoldingId').val();
                    let stampingDetailsId   =  $('#txtStampingDetailsId').val();
                    let scannedEmpId = {
                    'scanned_emp_id' : toScanEmpId,
                    'molding_id'     : toScanMoldingId,
                    'stamping_details_id'     : stampingDetailsId
                    }
                    if(e.keyCode == 13){
                        if(moldingId != null){
                            validateUser($(this).val().toUpperCase(), [2,5], function(result){
                                if(result == true){
                                    let data2 = $('#formOqcDetails').serialize()+ '&' + $.param(scannedEmpId);
                                    // console.log(data2);
                                    $.ajax({
                                        type: "post",
                                        url: "update_checked_by",
                                        data: data2,
                                        dataType: "json",
                                        success: function (response) {
                                            if(response['validation'] == 1){
                                                toastr.error('Saving data failed!');

                                            }else if(response['result'] == 0){
                                                toastr.success('Validation Succesful!');
                                                $("#formOqcDetails")[0].reset();
                                                $('#modalScanEmpId').modal('hide');
                                                $('#modalViewSubLotDetails').modal('hide');
                                                dtPackingDetailsFE.draw();
                                            }
                                        }
                                    });
                                }
                                else{ // Error Handler
                                    toastr.error('User not authorize!');
                                }

                            });
                        }else{
                            validateUser($(this).val().toUpperCase(), [4,9], function(result){
                            if(result == true){
                                    e.preventDefault();
                                    let data1 = $('#formOqcDetails').serialize() + '&' + $.param(scannedEmpId);
                                    $.ajax({
                                        type: "post",
                                        url: "updated_counted_by",
                                        data: data1,
                                        dataType: "json",
                                        success: function (response) {
                                            if(response['validation'] == 1){
                                                toastr.error('Saving data failed!');
                                            }else if(response['result'] == 0){
                                                toastr.success('Validation Succesful!');
                                                $("#formOqcDetails")[0].reset();
                                                $('#modalScanEmpId').modal('hide');
                                                $('#modalViewSubLotDetails').modal('hide');
                                                dtPackingDetailsFE.draw();
                                            }
                                        }
                                    });
                                }
                                else{ // Error Handler
                                    toastr.error('User not authorize!');
                                }

                            });
                        }

                        $(this).val('');
                    }
                });

                // $('#txtScanQcId').on('keyup', function(e){
                //     let toScanQcId =  $('#txtScanQcId').val();
                //     let scannedQcId = {
                //     'qc_scan_id' : toScanQcId
                //     }
                //         if(e.keyCode == 13){

                //             $(this).val('');
                //         }
                // });

            });

        </script>
    @endsection
@endauth

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
                                <li class="breadcrumb-item active">First Stamping</li>
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
                                                {{-- <button class="btn btn-primary"><i class="fa-solid fa-qrcode"></i></button> --}}
                                                {{-- <input type="text" class="form-control" placeholder="PO Number" id="txtSearchPONum" value="450244133600010"> --}}
                                                <input type="text" class="form-control" placeholder="PO Number" id="txtSearchPONum">
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

                                        <button class="btn btn-primary" id="btnAddProdData">
                                            <i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblProd" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>Production Lot No.</th>
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
                                                    <th>Shipment Output</th>
                                                    <th>Material Lot #</th>
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
        <div class="modal fade" id="modalProdData" data-bs-backdrop="static">
            <div class="modal-dialog modal-sm-xl" style="min-width: 80% !important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Production Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" name="stamp_cat" id="txtStampCat" value="1">

                    <form method="post" id="formProdData" autocomplete="off">
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
                                                {{-- <input type="hidden" class="form-control form-control-sm" name="opt_id" id="txtOptID" readonly value="@php echo Auth::user()->id; @endphp"> --}}
                                                {{-- <input type="text" class="form-control form-control-sm select2bs4" name="opt_name[]" id="txtOptName" readonly> --}}
                                                <select name="opt_name[]" id="selOperator" class="form-control select2bs4 selOpName" multiple>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Shift:</label>
                                                <input type="text" class="form-control form-control-sm" name="opt_shift" id="txtOptShift" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Production Date:</label>
                                                <input type="date" class="form-control form-control-sm" name="prod_date" id="txtProdDate">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="form-group d-md-inline-flex">
                                                <div class="form-check form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cut_point" id="radioCutPointWithout" value="0" checked>
                                                    <label class="form-check-label" for="radioCutPointWithout">w/o Cut Points</label>
                                                </div>
                                                <div class="form-check form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="cut_point" id="radioCutPointWith" value="1">
                                                    <label class="form-check-label" for="radioCutPointWith">w/ Cut Points</label>
                                                </div>
                                                <div>
                                                    <input type="number" class="form-control form-control-sm" name="no_cut" id="txtNoCut" placeholder="No. of Cut" readonly>
                                                </div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label class="form-label">Input Coil Weight (kg):</label>
                                                <input type="number" class="form-control form-control-sm" name="inpt_coil_weight" id="txtInptCoilWeight">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">PPC Target Output (Pins):</label>
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
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="This data is from OQC Inspection"></i>
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

                                            <label class="form-label">Material Lot No.:</label>
                                            <div class="input-group mb-1">
                                                <input type="text" class="form-control form-control-sm matNo" aria-describedby="button-addon2" name="material_no[]" id="txtTtlMachOutput_0" readonly>
                                                <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
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


        <div class="modal fade" id="modalScanQr" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-top" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQrCode" name="scan_qr_code" autocomplete="off">
                        <div class="text-center text-secondary">Please scan the material lot #.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalHistory" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa-solid fa-circle-exclamation"></i> NG History</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table id="tblHistory" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>PO Number</th>
                                        <th>Set-up Pins</th>
                                        <th>Adjustment Pins</th>
                                        <th>QC Samples</th>
                                        <th>NG Count</th>
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


    @endsection

    @section('js_content')
        <script>
            var prodData = {};
            var img_barcode_PO_text_hidden;
            var multipleMatId;
            var printId;
            var printStampCat;
            var scanningFunction;
            var historyId = 0;
            $(document).ready(function(){
                // getOperatorList($('.selOpName'));

                dtDatatableProd = $("#tblProd").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_first_stamp_prod",
                         data: function (param){
                            param.po = $("#txtSearchPONum").val();
                            param.stamp_cat = 1;
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

                $('#formProdData').submit(function(e){
                    e.preventDefault();
                    $('#modalScanQRSave').modal('show');
                    $('#modalScanQRSaveText').html('Please Scan Employee ID.')
                    scanningFunction = "prodData";

                    // $('input[name="scan_id"]').attr('id', 'txtScanUserId');
                });

                // $('#txtScanUserId').on('keyup', function(e){
                //     if(e.keyCode == 13){
                //         validateUser($(this).val().toUpperCase(), [0,4], function(result){
                //             if(result == true){

                //                 submitProdData($('#txtScanUserId').val().toUpperCase());
                //             }
                //             else{ // Error Handler
                //                 toastr.error('User not authorize!');
                //             }

                //         });
                //         setTimeout(() => {
                //             $(this).val('');
                            
                //         }, 500);
                //     }
                // });
                $('#txtTargetOutput').on('keyup', function(e){
                    // Computation for PPC Target Output (Pins) and Planned Loss (10%) (Pins)
                    // let ppcTargtOut = 0;
                    let planLoss = 0;
                    let ppcTargtOut = $(this).val();

                    // ppcTargtOut = inputCoilWeight/0.005;
                    planLoss = ppcTargtOut*0.1;

                    // $('#txtTargetOutput').val(ppcTargtOut);
                    $('#txtPlannedLoss').val(planLoss);
                });

                $('#txtTtlMachOutput').on('keyup', function(e){
                    // * computation for Shipment Output and Material Yield
                    let sum = Number($('#txtSetupPin').val()) + Number($('#txtAdjPin').val()) + Number($('#txtQcSamp').val()) + Number($('#txtProdSamp').val()) + Number($('#txtNGCount').val());
                    let ttlMachOutput = $(this).val();

                    let shipmentOutput = ttlMachOutput - sum;
                    // let matYieldComp = shipmentOutput/ttlMachOutput;
                    // let matYield =  matYieldComp * 100;
                    // if(Number.isFinite(matYield)){
                        $('#txtShipOutput').val(shipmentOutput);
                        // $('#txtMatYield').val(`${matYield.toFixed(2)}%`);
                    // }
                    // else{
                    //     $('#txtShipOutput').val('');
                    //     $('#txtMatYield').val('');
                    // }
                });

                $(document).on('keypress', '#txtSearchPONum', function(e){
                    if(e.keyCode == 13){
                        $.ajax({
                            type: "get",
                            url: "get_search_po",
                            data: {
                                "po" : $(this).val()
                            },
                            dataType: "json",
                            beforeSend: function(){
                                prodData = {};
                            },
                            success: function (response) {
                                console.log(response);
                                if(response.length > 0){
                                    prodData['poReceiveData'] = response[0];
                                    console.log(response);
                                    $.ajax({
                                        type: "get",
                                        url: "get_data_req_for_prod_by_po",
                                        data: {
                                            "item_code" : response[0]['ItemCode']
                                        },
                                        dataType: "json",
                                        success: function (result) {
                                            $('#txtSearchMatName').val(response[0]['ItemName']);
                                            $('#txtSearchPO').val(response[0]['OrderQty']);
                                            prodData['drawings'] = result
                                            console.log(prodData);
                                            dtDatatableProd.draw();
                                        },
                                        error: function(data, xhr, status){
                                            // console.log(data.responseJSON.msg);
                                            toastr.error(data.responseJSON.msg)
                                            // toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                                            
                                        }
                                    });
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
                });

                $('#btnAddProdData').on('click', function(e){
                    if($('#txtSearchPONum').val() != "" && $('#txtSearchMatName').val() != ""){
                        checkMatrix(prodData['poReceiveData']['ItemCode'], prodData['poReceiveData']['ItemName'], '1st Stamping')
                        getProdLotNoCtrl();

                        // OPERATOR SHIFT
                        $time_now = moment().format('LT');
                        if($time_now >= '7:30 AM' || $time_now <= '7:29 PM'){
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
                    printStampCat = $(this).data('stampcat');
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
                                $('#modalScanQRSave').modal('show');
                                $('#modalScanQRSaveText').html('Please Scan Supervisor ID.')
                                scanningFunction = "reprintStamping"
                            }
                        });
                    }
                    else{
                        printProdData(printId, printStampCat);
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
                        changePrintCount(img_barcode_PO_text_hidden[0]['id']);
                    });

                    popup.close();

                });

                $('#btnAddMatNo').on('click', function(e){
                    e.preventDefault();
                    let newCount = Number($('#multipleCounter').val()) + Number(1);
                    if(newCount > 0){
                        $('#btnRemoveMatNo').removeClass('d-none');
                    }
                    $('#multipleCounter').val(newCount);
                    let inputGroup = `
                            <div class='input-group mb-1 appendDiv' id="divInput_${newCount}">
                                <input type='text' class='form-control form-control-sm matNo' name='material_no[]' id='txtTtlMachOutput_${newCount}' required readonly>
                                <button class="btn btn-primary btn-sm btnQr" type="button" id="button-addon2"><i class="fa-solid fa-qrcode"></i></button>
                            </div>
                    `;
                    $('#divMultipleMatLot').append(inputGroup)
                });

                $('#btnRemoveMatNo').on('click', function(e){
                    e.preventDefault();
                    let counter = $('#multipleCounter').val();

                    $(`#divInput_${counter}`).remove();

                    let newCount = $('#multipleCounter').val() - 1;
                    $('#multipleCounter').val(newCount)

                    if(newCount == 0){
                        $('#btnRemoveMatNo').addClass('d-none');
                    }
                });

                $(document).on('click', '.btnQr', function(){
                    multipleMatId = $(this).offsetParent().children().attr('id');
                    console.log($(this).offsetParent().children().attr('id'));
                    $('#modalScanQr').modal('show');
                    $('#modalScanQr').on('shown.bs.modal', function () {
                        $('#txtScanQrCode').focus();
                    });
                });

                $('#txtScanQrCode').on('keyup', function(e){
                    if(e.keyCode == 13){
                        $(`#${multipleMatId}`).val($(this).val());
                        $(this).val('');
                        $('#modalScanQr').modal('hide');
                    }
                });

                $(document).on('click', '.btnMassProd', function(e){
                    let id = $(this).data('id');
                    let btnFunction = $(this).data('function');
                    let stampCategory = $(this).data('stampcat');
                    
                    // console.log(btnFunction);
                    getProdDataById(id, btnFunction, stampCategory);
                });

                $('input[name="cut_point"]').on('change', function(){
                    if($(this).val() == 0){
                        $('#txtNoCut').prop('readonly', true);

                    }
                    else{
                        $('#txtNoCut').prop('readonly', false);
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
                    dtDatatableHistory = $("#tblHistory").DataTable({
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
                        ],
                    });//end of dataTableDevices

                    $('#modalHistory').modal('show');

                })


            });

            $(document).on('keyup','#txtScanUserId', function(e){
                
                if(e.keyCode == 13){
                    
                    if(scanningFunction === "prodData"){
                        validateUser($(this).val().toUpperCase(), [0,4], function(result){
                            if(result == true){

                                submitProdData($('#txtScanUserId').val().toUpperCase(), $('#formProdData'), $('#txtStampCat').val());
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                    }
                    else{
                        validateUser($(this).val().toUpperCase(), [0,1,9], function(result){
                            if(result == true){
                                $('#modalScanQRSave').modal('hide');
                                printProdData(printId, printStampCat);
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
        </script>
    @endsection
@endauth

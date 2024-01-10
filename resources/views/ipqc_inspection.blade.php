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
                            <h1>In-Process Quality Control</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">First Stamping</li>
                                <li class="breadcrumb-item active">In-Process Quality Control</li>
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
                                                <button class="btn btn-primary" id="btnScanPo" data-bs-toggle="modal" data-bs-target="#mdlScanQrCode"><i class="fa-solid fa-qrcode"></i></button>
                                                {{-- <button type="button" class="btn btn-dark" id="btnScanPo" data-toggle="modal" data-target="#mdlScanQrCode"><i class="fa fa-qrcode w-100"></i></button> --}}
                                                <input type="text" class="form-control" placeholder="PO Number" aria-label="Username" name="po_number" id="txtSearchPONum">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" aria-label="Username" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Scan QR Modal -->
                    <div class="modal fade" id="mdlScanQrCode" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body pt-0">
                                    <input type="text" class="scanner w-100" id="txtScanQrCode" name="scan_qr_code" autocomplete="off">
                                    <div class="text-center text-secondary">Please scan the code.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.End Scan QR Modal -->

                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">In-Process Quality Control</h3>
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

                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalIpqcInspection" id="btnAddProdData">
                                            <i class="fa-solid fa-plus"></i> Add IPQC Inspection</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblIpqcInspection" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>IPQC Status</th>
                                                    <th>PO Number</th>
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
                                                    <th>Material Lot #</th>
                                                    <th>Inspector Name</th>
                                                    {{-- <th>IPQC Status</th> --}}
                                                    {{-- <th>Measdata Attachment</th> --}}
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
        <div class="modal fade" id="modalIpqcInspection" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Production Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formProdData" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="txtProcessId" name="id">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
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
                                            <div class="form-group">
                                                <label class="form-label">Material Lot No.:</label>
                                                <input type="text" class="form-control form-control-sm" name="mat_lot_no" id="txtMatLotNo">
                                            </div>
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
                                                <input type="hidden" class="form-control form-control-sm" name="opt_id" id="txtOptID" readonly value="@php echo Auth::user()->id; @endphp">
                                                <input type="text" class="form-control form-control-sm" name="opt_name" id="txtOptName" readonly value="@php echo Auth::user()->name; @endphp">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Shift:</label>
                                                <input type="text" class="form-control form-control-sm" name="opt_shift" id="txtOptShift">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Production Date:</label>
                                                <input type="date" class="form-control form-control-sm" name="prod_date" id="txtProdDate">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Production Lot #:</label>
                                                <input type="text" class="form-control form-control-sm" name="prod_lot_no" id="txtProdLotNo">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Input Coil Weight (kg):</label>
                                                <input type="number" class="form-control form-control-sm" name="inpt_coil_weight" id="txtInptCoilWeight">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">PPC Target Output (Pins):</label>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Input Coil Weight / 0.005)"></i>

                                                <input type="number" class="form-control form-control-sm" placeholder="Auto Compute" name="target_output" id="txtTargetOutput" readonly>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Total Machine Output:</label>
                                                <input type="number" class="form-control form-control-sm" name="ttl_mach_output" id="txtTtlMachOutput">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Shipment Output:</label>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Set-up Pins + Adjustment Pins + QC Samples + Prod. Samples / Total Machin Output)"></i>
                                                <input type="number" class="form-control form-control-sm" placeholder="Auto Compute" name="ship_output" id="txtShipOutput" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Material Yield:</label>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Auto Compute &#013;(Total Machine Output / Shipment Output) Percent"></i>
                                                <input type="text" class="form-control form-control-sm" placeholder="Auto Compute" name="mat_yield" id="txtMatYield" readonly>
                                            </div>
                                        </div>
                                    </div>
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

    @endsection

    @section('js_content')
        <script type="text/javascript">
            var prodData;
            $(document).ready(function(){
                let dtIpqcInspection;

                $('#formProdData').submit(function(e){
                    e.preventDefault();
                    submitProdData();
                });

                // $('#txtInptCoilWeight').on('keyup', function(e){
                //     // Computation for PPC Target Output (Pins) and Planned Loss (10%) (Pins)
                //     let ppcTargtOut = 0;
                //     let planLoss = 0;
                //     let inputCoilWeight = $(this).val();

                //     ppcTargtOut = inputCoilWeight/0.005;
                //     planLoss = ppcTargtOut*0.1;

                //     $('#txtTargetOutput').val(ppcTargtOut);
                //     $('#txtPlannedLoss').val(planLoss);
                // });

                // $('#txtTtlMachOutput').on('keyup', function(e){
                //     // * computation for Shipment Output and Material Yield
                //     let sum = Number($('#txtSetupPin').val()) + Number($('#txtAdjPin').val()) + Number($('#txtQcSamp').val()) + Number($('#txtProdSamp').val());
                //     let ttlMachOutput = $(this).val();

                //     let shipmentOutput = ttlMachOutput - sum;
                //     let matYieldComp = shipmentOutput/ttlMachOutput;
                //     let matYield =  Math.round(matYieldComp * 100)
                //     if(Number.isFinite(matYield)){
                //         $('#txtShipOutput').val(shipmentOutput);
                //         $('#txtMatYield').val(`${matYield}%`);
                //     }
                //     else{
                //         $('#txtShipOutput').val('');
                //         $('#txtMatYield').val('');
                //     }
                // });

                // $(document).on('keypress', '#txtSearchPONum', function(e){
                //     if(e.keyCode == 13){
                //         $.ajax({
                //             type: "get",
                //             url: "get_search_po",
                //             data: {
                //                 "po" : $(this).val()
                //             },
                //             dataType: "json",
                //             success: function (response) {
                //                 prodData = response;
                //                 $('#txtSearchMatName').val(response['poReceiveData'][0]['ItemName']);
                //                 dtIpqcInspection.draw();
                //             }
                //         });
                //     }
                // });

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
                                // prodData['result'] = response[0]
                                if(response[0] == undefined){
                                    toastr.error('PO does not exists')
                                }else{
                                    // console.log('otid');
                                    $.ajax({
                                    type: "get",
                                    url: "get_po_from_pps_db",
                                    data: {
                                        "item_code" : response[0]['ItemCode']
                                    },
                                    dataType: "json",
                                    success: function (result) {
                                        $('#txtSearchMatName').val(response[0]['ItemName']);
                                        // prodData['drawings'] = result
                                        dtIpqcInspection = $("#tblIpqcInspection").DataTable({
                                            "processing" : true,
                                            "serverSide" : true,
                                            "ajax" : {
                                                url: "view_stamping_ipqc_data",
                                                data: function(param){
                                                param.po_number =  $("input[name='po_number']").val();
                                            }
                                            },
                                            fixedHeader: true,
                                            "columns":[

                                                { "data" : "action", orderable:false, searchable:false },
                                                { "data" : "stamping_ipqc[0].status" },
                                                { "data" : "po_num" },
                                                { "data" : "part_code" },
                                                { "data" : "material_name" },
                                                { "data" : "po_qty" },
                                                { "data" : "material_lot_no" },
                                                { "data" : "stamping_ipqc[0].inspector_name" },
                                                // { "data" : "inspector_name" },
                                                // { "data" : "document_no" },
                                                // { "data" : "measdata_attachment" },
                                            ],
                                        });
                                        // dtIpqcInspection.draw();
                                        // console.log(prodData);
                                        }
                                    });
                                }
                            }
                        });
                    }
                });

                // $('#btnAddProdData').on('click', function(e){
                //     // console.log(prodData);
                //     $('#txtPoNumber').val(prodData['poReceiveData'][0]['OrderNo']);
                //     $('#txtPoQty').val(prodData['poReceiveData'][0]['OrderQty']);
                //     $('#txtPartCode').val(prodData['poReceiveData'][0]['ItemCode']);
                //     $('#txtMatName').val(prodData['poReceiveData'][0]['ItemName']);
                //     $('#txtDrawingNo').val(prodData['drawings']['drawing_no']);
                //     $('#txtDrawingRev').val(prodData['drawings']['rev']);
                // });

                // gg

                // $('#btnScanPo').on('click', function(e){
                //     e.preventDefault();
                //     $('#mdlScanQrCode').modal('show');
                //     $('#mdlScanQrCode').on('shown.bs.modal', function () {
                //         $('#txtScanQrCode').focus();
                //         const mdlScanQrCodeOqcInspection = document.querySelector("#mdlScanQrCode");
                //         const inptQrCodeOqcInspection = document.querySelector("#txtScanQrCode");
                //         let focus = false;

                //         mdlScanQrCodeOqcInspection.addEventListener("mouseover", () => {
                //             if (inptQrCodeOqcInspection === document.activeElement) {
                //                 focus = true;
                //             } else {
                //                 focus = false;
                //             }
                //         });

                //         mdlScanQrCodeOqcInspection.addEventListener("click", () => {
                //             if (focus) {
                //                 inptQrCodeOqcInspection.focus()
                //             }
                //         });
                //     });
                // });
            });
        </script>
    @endsection
@endauth

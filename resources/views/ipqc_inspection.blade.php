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
                                                <input type="text" class="form-control" placeholder="PO Number" aria-label="Username" name="po_number" id="txtSearchPONum" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Part Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Product Code" aria-label="Partcode" id="txtSearchPartCode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" aria-label="Materialname" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                    {{-- <div style="float: right;">
                                        @if(Auth::user()->user_level_id == 1)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @else
                                        @if(Auth::user()->position == 7 || Auth::user()->position == 8)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @endif
                                        @endif

                                        ##CLARK NOTE##
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalIpqcInspection" id="btnAddProdData">
                                            <i class="fa-solid fa-plus"></i> Add IPQC Inspection</button>

                                    </div> --}}
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
                                                    <th>Inspector Name</th>
                                                    <th>Inspected Date</th>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add IPQC Inspection Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formIPQCInspectionData" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="txtProcessId" name="id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">PO Number:</label>
                                                <input type="text" class="form-control form-control-sm" name="po_num" id="txtPoNumber" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Part Code:</label>
                                                <input type="text" class="form-control form-control-sm" name="part_code" id="txtPartCode" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Material Name:</label>
                                                <input type="text" class="form-control form-control-sm" name="mat_name" id="txtMatName" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body"><div class="form-group">
                                                <label class="form-label">Inspector Name:</label>
                                                <input type="hidden" class="form-control form-control-sm" name="opt_id" id="txtOptID" readonly value="@php echo Auth::user()->id; @endphp">
                                                <input type="text" class="form-control form-control-sm" name="opt_name" id="txtOptName" readonly value="@php echo Auth::user()->name; @endphp">
                                            </div>
                                            {{-- DROPDOWN --}}
                                            <div class="form-group">
                                                <label class="form-label">Document No.:</label>
                                                <input type="text" class="form-control form-control-sm" name="document_no" id="txtDocumentNo" readonly>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="form-label">MeasData Attachment:</label>
                                                <input type="text" class="form-control form-control-sm" name="drawing_no" id="txtDrawingNo" readonly>
                                            </div> --}}
                                            {{-- ATTACHMENT --}}
                                            <div class="form-group">
                                                <div id="AttachmentDiv">
                                                    <label class="form-control-label">MeasData Attachment:</label>
                                                </div>
                                                    <input type="file" class="" id="txtAddFile" name="uploaded_file" accept=".png, .jpg, .jpeg" style="width:100%;" required>
                                                    <input type="text" class="form-control d-none" name="uploaded_file" id="txtEditUploadedFile" disabled>
                                                <div class="form-group form-check d-none m-0" id="btnReuploadTriggerDiv">
                                                    <input type="checkbox" class="form-check-input d-none" id="btnReuploadTrigger">
                                                    <label class="d-none" id="btnReuploadTriggerLabel"> Re-upload Drawing</label>
                                                </div>
                                            </div>
                                            {{-- ATTACHMENT --}}
                                            <br>
                                            <div class="form-group text-center">
                                                {{-- <label class="form-label">ILQCM Link:</label> --}}
                                                <a href="http://rapidx/ilqcm/dashboard" target="_blank">
                                                    <button type="button" class="btn btn-primary" id="btnilqcmlink">
                                                        <i class="fa-solid fa-pen"></i>Update In-Line QC Monitoring
                                                    </button>
                                                </a>
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Update In-Line QC Monitoring Thru our ILQCM System in RapidX"></i>
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

                $('#formIPQCInspectionData').submit(function(e){
                    e.preventDefault();
                    submitProdData();
                });

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
                        { "data" : "ipqc_status" },
                        { "data" : "po_num" },
                        { "data" : "part_code" },
                        { "data" : "material_name" },
                        // { "data" : "po_qty" },
                        // { "data" : "material_lot_no" },
                        { "data" : "ipqc_inspector_name" },
                        { "data" : "ipqc_inspected_date" },
                        // { "data" : "inspector_name" },
                        // { "data" : "document_no" },
                        // { "data" : "measdata_attachment" },
                    ],
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

                $('#btnScanPo').on('click', function(e){
                    e.preventDefault();
                    // $('#mdlScanQrCode').modal('show');
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

                $(document).on('keypress', function(e){
                        if(e.keyCode == 13){
                            $.ajax({
                                type: "get",
                                url: "get_search_po",
                                data: {
                                    "po" : $('#txtScanQrCode').val()
                                },
                                dataType: "json",
                                beforeSend: function(){
                                    prodData = {};
                                },
                                success: function (response) {
                                    if(response[0] == undefined){
                                        toastr.error('PO does not exists')
                                    }else{
                                        $.ajax({
                                        type: "get",
                                        url: "get_po_from_pps_db",
                                        data: {
                                            "item_code" : response[0]['ItemCode']
                                        },
                                        dataType: "json",
                                        success: function (result) {
                                            $('#txtSearchPONum').val(response[0]['ProductPONo']);
                                            $('#txtSearchPartCode').val(response[0]['ItemCode']);
                                            $('#txtSearchMatName').val(response[0]['ItemName']);
                                            $('#txtScanQrCode').val('');
                                            $('#mdlScanQrCode').modal('hide');
                                            dtIpqcInspection.draw();
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    // }
                });
            });
        </script>
    @endsection
@endauth

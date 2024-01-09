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
                            <h1>Production</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">First Stamping</li>
                                <li class="breadcrumb-item active">Production</li>
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
                                                <input type="text" class="form-control" placeholder="PO Number" aria-label="Username" id="txtSearchPONum">
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
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
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
        <div class="modal fade" id="modalMachineOp" data-bs-backdrop="static">
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
                                                {{-- <input type="hidden" class="form-control form-control-sm" name="opt_id" id="txtOptID" readonly value="@php echo Auth::user()->id; @endphp"> --}}
                                                <input type="text" class="form-control form-control-sm" name="opt_name" id="txtOptName" readonly>
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
            var prodData = {};
            $(document).ready(function(){
                dtDatatableProd = $("#tblProd").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_first_stamp_prod",
                    },
                fixedHeader: true,
                "columns":[
                
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "status" },
                    { "data" : "po_num" },
                    { "data" : "part_code" },
                    { "data" : "material_name" },
                    { "data" : "po_qty" },
                    { "data" : "material_lot_no" },
                ],
                });//end of dataTableDevices

                $('#formProdData').submit(function(e){
                    e.preventDefault();
                    submitProdData();
                });

                $('#txtInptCoilWeight').on('keyup', function(e){
                    // Computation for PPC Target Output (Pins) and Planned Loss (10%) (Pins)
                    let ppcTargtOut = 0;
                    let planLoss = 0;
                    let inputCoilWeight = $(this).val(); 

                    ppcTargtOut = inputCoilWeight/0.005;
                    planLoss = ppcTargtOut*0.1;

                    $('#txtTargetOutput').val(ppcTargtOut);
                    $('#txtPlannedLoss').val(planLoss);
                });

                $('#txtTtlMachOutput').on('keyup', function(e){
                    // * computation for Shipment Output and Material Yield
                    let sum = Number($('#txtSetupPin').val()) + Number($('#txtAdjPin').val()) + Number($('#txtQcSamp').val()) + Number($('#txtProdSamp').val());
                    let ttlMachOutput = $(this).val();

                    let shipmentOutput = ttlMachOutput - sum;
                    let matYieldComp = shipmentOutput/ttlMachOutput;
                    let matYield =  matYieldComp * 100;
                    if(Number.isFinite(matYield)){
                        $('#txtShipOutput').val(shipmentOutput);
                        $('#txtMatYield').val(`${matYield.toFixed(2)}%`);
                    }
                    else{
                        $('#txtShipOutput').val('');
                        $('#txtMatYield').val('');
                    }
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
                                prodData['poReceiveData'] = response[0]
                                $.ajax({
                                    type: "get",
                                    url: "get_data_req_for_prod_by_po",
                                    data: {
                                        "item_code" : response[0]['ItemCode']
                                    },
                                    dataType: "json",
                                    success: function (result) {
                                        $('#txtSearchMatName').val(response[0]['ItemName']);
                                        prodData['drawings'] = result
                                        console.log(prodData);
                                    }
                                });
                            }
                        });
                    }
                });

                $('#btnAddProdData').on('click', function(e){
                    if($('#txtSearchPONum').val() != "" && $('#txtSearchMatName').val() != ""){
                        // console.log(prodData);
                        $('#txtPoNumber').val(prodData['poReceiveData']['OrderNo']);
                        $('#txtPoQty').val(prodData['poReceiveData']['OrderQty']);
                        $('#txtPartCode').val(prodData['poReceiveData']['ItemCode']);
                        $('#txtMatName').val(prodData['poReceiveData']['ItemName']);
                        $('#txtDrawingNo').val(prodData['drawings']['drawing_no']);
                        $('#txtDrawingRev').val(prodData['drawings']['rev']);
                        $('#txtOptName').val($('#globalSessionName').val());
                        $('#modalMachineOp').modal('show');
                    }
                    else{
                        toastr.error('Please input PO.')
                    }
                 
                });

                $(document).on('click', '.btnViewProdData', function(e){
                    let id = $(this).data('id');
                    getProdDataToView(id);
                });

                $(document).on('click', '.btnPrintProdData', function(e){
                    let id = $(this).data('id');
                    printProdData(id);
                })
            });
        </script>
    @endsection
@endauth
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
                                    <div style="float: right;">
                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditPackingDetails" id="btnShowEditPackingDetails"><i
                                                class="fas fa-clipboard-list"></i> Edit Packing Details
                                        </button> --}}
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        {{-- <!-- style="max-height: 600px; overflow-y: auto;" --> --}}
                                        <table id="tblPackingDetails" class="table table-sm table-bordered table-striped table-hover"
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
                                        </table>
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

    @endsection

    @section('js_content')
        <script type="text/javascript">

                $('.select2').select2({
                    theme: 'bootstrap-5'
                });
            
            let scannedPO;
            let ParseScannedPo;

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
                            dtPackingDetails.draw()
                        }
                    });
                });

                dtPackingDetails = $("#tblPackingDetails").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_packing_details_data",
                        data: function (param){
                            param.po_no = $("#txtSearchPONum").val();
                        },
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "stamping_production_info.material_name"},
                        { "data" : "po_no" },
                        { "data" : "stamping_production_info.po_qty"},
                        { "data" : "delivery_balance" },
                        { "data" : "stamping_production_info.drawing_no"},
                        { "data" : "stamping_production_info.prod_lot_no"},
                        { "data" : "stamping_production_info.no_of_cuts"},
                        { "data" : "material_quality" },
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [5,8,9],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });

                $(document).on('click', '.btnEditPackingDetails', function(e){
                    e.preventDefault();
                    let oqcDetailsId =  $(this).attr('data-id');
                    $('#txtPackingDetailsId').val(oqcDetailsId);
                    console.log(oqcDetailsId);
                    $('#modalEditPackingDetails').modal('show');

                    getOqcDetailsbyId(oqcDetailsId);

                });
                // btnEditPackingDetails

                
            });
        
        </script>
    @endsection
@endauth

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
                                    <div class="table-responsive">
                                        {{-- <!-- style="max-height: 600px; overflow-y: auto;" --> --}}
                                        <table id="tblReceivingDetails" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><center><i class="fa fa-cog"></i></center></th>
                                                    <th>Status</th>
                                                    <th>Packing List Ctrl #</th>
                                                    <th>Material Name</th>
                                                    <th>Lot #</th>
                                                    <th>Shipment Qty</th>
                                                    <th>SANNO Lot #</th>
                                                    <th>SANNO Qty</th>
                                                    <th>New Lot #</th>
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
                                    <label class="form-label">SANNO Lot #</label>
                                    <input type="text" class="form-control form-control-sm" name="sanno_lot_no" id="txtSannoLotNo" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">SANNO Qty</label>
                                    <input type="text" class="form-control form-control-sm" name="sanno_qty" id="txtSannoQty" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Packing List Ctrl #</label>
                                    <input type="text" class="form-control form-control-sm" name="packing_ctrl_no" id="txtPackingCtrlNo" readonly>
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
                                    <label class="form-label">Shipment Qty</label>
                                    <input type="text" class="form-control form-control-sm" name="pmi_qty" id="txtPmiQty" readonly>
                                </div>
                            </div>

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
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content modal-sm ">
        {{-- <div class="modal-header">
          <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div> --}}
        <div class="modal-body">
          {{-- hidden_scanner_input --}}
          {{-- <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserId" name="scan_qr_code" autocomplete="off"> --}}
          <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserId" name="scan_id" autocomplete="off">
          <div class="text-center text-secondary"><span id="modalScanQRSaveText">Please scan employee ID.</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
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

        dtReceivingDetails = $("#tblReceivingDetails").DataTable({
            "processing" : true,
            "serverSide" : true,
            "ajax" : {
                url: "view_receiving_details",
                // data: function(param){
                // param.search_data =  $("#textSearchPackingListDetails").val();
                // }
            },
            fixedHeader: true,
            "columns":[
                { "data" : "action", orderable:false, searchable:false },
                { "data" : "status"},
                { "data" : "control_no"},
                { "data" : "mat_name"},
                { "data" : "lot_no"},
                { "data" : "quantity"},
                { "data" : "sanno_lot_no"},
                { "data" : "sanno_quantity"},
                { "data" : "sanno_pmi_lot_no"},
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

        // $('#btnEditReceivingDetails').click(function(e){
        //     $('#mdlScanQrCode').modal('show');
        // }); 

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
                                if(response['error']['sanno_lot_no'] === undefined){
                                    $("#txtSannoLotNo").removeClass('is-invalid');
                                    $("#txtSannoLotNo").attr('title', '');
                                }
                                else{
                                    $("#txtSannoLotNo").addClass('is-invalid');
                                    $("#txtSannoLotNo").attr('title', response['error']['sanno_lot_no']);
                                }
                                if(response['error']['sanno_qty'] === undefined){
                                    $("#txtSannoQty").removeClass('is-invalid');
                                    $("#txtSannoQty").attr('title', '');
                                }
                                else{
                                    $("#txtSannoQty").addClass('is-invalid');
                                    $("#txtSannoQty").attr('title', response['error']['sanno_qty']);
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

        </script>
    @endsection
@endauth

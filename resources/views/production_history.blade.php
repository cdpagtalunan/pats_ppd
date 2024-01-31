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
                            <h1>Production History</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Production History</li>
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
                                    <h3 class="card-title">Production History</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="card card-primary">
                                            <div class="card-body">
                                              <div class="row">
                                                <div class="col-sm-3">
                                                  <label>Device Name</label>
                                                  <div class="input-group">
                                                    <select class="form-select form-control" id="global_device_name" name="global_device_name" >
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="col-sm-3">
                                                  <label>STD Cycle Time:</label>
                                                    <input type="text" class="form-control" id="std_cycle_time" name="std_cycle_time" readonly>
                                                </div>
                                                <div class="col-sm-3">
                                                  <label>Maintenance Cycle:</label>
                                                    <input type="text" class="form-control" id="maintenance_cycle" name="maintenance_cycle" readonly>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="btnAddProductionHistory" disabled>
                                            <i class="fa-solid fa-plus"></i> Add History</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <table id="tblProductionHistoryDetails" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Production Date</th>
                                                    <th>Machine No.</th>
                                                    <th>Standard Parameter Date</th>
                                                    <th>Remarks</th>
                                                    <th>Created By</th>
                                                    <th>Confirm By</th>
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


    @include('component.modal')

    @endsection

    @section('js_content')
        <script>
            $(document).ready(function () {

                getFirstModlingDevices();

                // const getPmiPoReceivedDetails = function (pmiPoNo){
                //     $.ajax({
                //         type: "GET",
                //         url: "get_pmi_po_received_details",
                //         data: {"pmi_po_no" : pmiPoNo},
                //         dataType: "json",
                //         success: function (response) {
                //             if( response.result_count === 1 ){
                //                 formModal.ProductionHistory.find('#po_no').val(response.po_no);
                //                 formModal.ProductionHistory.find('#po_qty').val(response.order_qty);
                //                 formModal.ProductionHistory.find('#po_target').val(response.order_qty);
                //                 formModal.ProductionHistory.find('#po_balance').val(response.po_balance);
                //                 formModal.ProductionHistory.find('#item_code').val(response.item_code);
                //                 formModal.ProductionHistory.find('#item_name').val(response.item_name);
                //             }else{
                //                 formModal.ProductionHistory.find('#po_no').val('');
                //                 formModal.ProductionHistory.find('#po_qty').val('');
                //                 formModal.ProductionHistory.find('#po_balance').val('');
                //                 formModal.ProductionHistory.find('#po_balance').val('');
                //                 formModal.ProductionHistory.find('#item_code').val('');
                //                 formModal.ProductionHistory.find('#item_name').val('');

                //             }
                //         }
                //     });
                // }


                $('#modalProductionHistory').on('hidden.bs.modal', function() {
                    // formModal.ProductionHistory.find('#first_molding_id').val('');
                    // formModal.ProductionHistory.find('#contact_lot_number').val('');
                    // formModal.ProductionHistory.find('#production_lot').val('');
                    // formModal.ProductionHistory.find('#remarks').val('');
                    // formModal.ProductionHistory.find('#created_at').val('');
                    formModal.ProductionHistory.find('.form-control').removeClass('is-valid')
                    formModal.ProductionHistory.find('.form-control').removeClass('is-invalid');
                    formModal.ProductionHistory.find('.form-control').attr('title', '');
                })

                // $('#modalProductionHistoryStation').on('hidden.bs.modal', function() {
                //     formModal.ProductionHistoryStation.find('#first_molding_detail_id').val('');
                //     formModal.ProductionHistoryStation.find('#date').val('');
                //     formModal.ProductionHistoryStation.find('#operator_name').val('');
                //     formModal.ProductionHistoryStation.find('#input').val('');
                //     formModal.ProductionHistoryStation.find('#ng_qty').val(0);
                //     formModal.ProductionHistoryStation.find('#output').val('');
                //     formModal.ProductionHistoryStation.find('#remarks').val('');
                //     formModal.ProductionHistoryStation.find('.form-control').removeClass('is-valid')
                //     formModal.ProductionHistoryStation.find('.form-control').removeClass('is-invalid');
                //     formModal.ProductionHistoryStation.find('.form-control').attr('title', '');
                // })

                // $('#mdlScanQrCodeProductionHistory').on('shown.bs.modal', function () {
                //     $('#txtScanQrCodeProductionHistory').focus();
                //     const mdlScanQrCode = document.querySelector("#mdlScanQrCodeProductionHistory");
                //     const inptQrCode = document.querySelector("#txtScanQrCodeProductionHistory");
                //     let focus = false;

                //     mdlScanQrCode.addEventListener("mouseover", () => {
                //         if (inptQrCode === document.activeElement) {
                //             focus = true;
                //         } else {
                //             focus = false;
                //         }
                //     });

                //     mdlScanQrCode.addEventListener("click", () => {
                //         if (focus) {
                //             inptQrCode.focus()
                //         }
                //     });
                // });

                // dt.ProductionHistory = table.ProductionHistoryDetails.DataTable({
                //     "processing" : true,
                //     "serverSide" : true,
                //     "ajax" : {
                //         url: "load_first_molding_details",
                //         data: function (param){
                //             param.first_molding_device_id = $("#global_device_name").val();
                //         }
                //     },
                //     fixedHeader: true,
                //     "columns":[
                //         { "data" : "action", orderable:false, searchable:false },
                //         { "data" : "status" },
                //         { "data" : "device_name" },
                //         { "data" : "contact_name" },
                //         { "data" : "contact_lot_number" },
                //         { "data" : "production_lot" },
                //         { "data" : "remarks" },
                //         { "data" : "created_at" },
                //     ]
                // });

                // dt.ProductionHistoryStation = table.ProductionHistoryStationDetails.DataTable({
                //     "processing" : true,
                //     "serverSide" : true,
                //     "ajax" : {
                //         url: "load_first_molding_station_details",
                //         data: function (param){
                //             param.first_molding_id = formModal.ProductionHistory.find("#first_molding_id").val();
                //         }
                //     },
                //     fixedHeader: true,
                //     "columns":[
                //         { "data" : "action", orderable:false, searchable:false },
                //         // { "data" : "status" },
                //         { "data" : "stations" },
                //         { "data" : "date" },
                //         { "data" : "operator_names" },
                //         { "data" : "input" },
                //         { "data" : "ng_qty" },
                //         { "data" : "output" },
                //         { "data" : "remarks" },
                //         { "data" : "created_at" },
                //     ]
                // });

                // table.ProductionHistoryDetails.on('click','#btnEditProductionHistory', editProductionHistory);
                // table.ProductionHistoryStationDetails.on('click','#btnEditProductionHistoryStation', editProductionHistoryStation);

                $('#btnAddProductionHistory').click(function (e) {
                    e.preventDefault();
                    dt.ProductionHistoryStation.draw()
                    $('#modalProductionHistory').modal('show');
                    // $('#btnProductionHistoryStation').prop('disabled',true);
                    // $('#btnSubmitProductionHistoryStation').prop('disabled',true);
                    // $('#btnRuncardDetails').removeClass('d-none',true);
                });

                // $('#btnProductionHistoryStation').click(function (e) {
                //     e.preventDefault();
                //     getStation();
                //     $('#modalProductionHistoryStation').modal('show');
                //     formModal.ProductionHistoryStation.find('#first_molding_id').val( formModal.ProductionHistory.find('#first_molding_id').val() );
                // });

                // $('#btnSubmitProductionHistoryStation').click(function (e) {
                //     e.preventDefault();
                //     Swal.fire({
                //         // title: "Are you sure?",
                //         text: "Are you sure you want to submit this process",
                //         icon: "warning",
                //         showCancelButton: true,
                //         confirmButtonColor: "#3085d6",
                //         cancelButtonColor: "#d33",
                //         confirmButtonText: "Yes"
                //     }).then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //                 type: "GET",
                //                 url: "first_molding_update_status",
                //                 data: {
                //                     "first_molding_id" : formModal.ProductionHistory.find("#first_molding_id").val(),
                //                 },
                //                 dataType: "json",
                //                 success: function (response) {
                //                     if(response['result'] === 1){
                //                         $('#modalProductionHistory').modal('hide');
                //                         dt.ProductionHistory.draw();
                //                         Swal.fire({
                //                             position: "center",
                //                             icon: "success",
                //                             title: "Submitted Successfully !",
                //                             showConfirmButton: false,
                //                             timer: 1500
                //                         });
                //                     }
                //                 },error: function (data, xhr, status){
                //                     toastr.error(`Error: ${data.status}`);
                //                 }
                //             });
                //         }
                //     });
                // });

                $('#global_device_name').change(function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "get_first_molding_devices_by_id",
                        data: {"first_molding_device_id" : $(this).val()},
                        dataType: "json",
                        success: function (response) {
                            let first_molding_device_id = response[0].id
                            let std_cycle_time = response[0].std_cycle_time
                            let maintenance_cycle = response[0].maintenance_cycle
                            let device_name = response[0].device_name

                            $('#btnAddProductionHistory').prop('disabled',false);
                            $('#std_cycle_time').val(std_cycle_time);
                            $('#maintenance_cycle').val(maintenance_cycle);

                            formModal.ProductionHistory.find('#first_molding_device_id').html(`<option value="${first_molding_device_id}">${device_name}</option>`);
                            formModal.ProductionHistory.find('#std_cycle_time').val(std_cycle_time);
                            formModal.ProductionHistory.find('#maintenance_cycle').val(maintenance_cycle);

                            dt.ProductionHistory.draw();
                            console.log($("#global_device_name").val())
                        }
                    });
                });

                // formModal.ProductionHistory.find('#pmi_po_no').on('keyup',function (e) {
                //     e.preventDefault();
                //     // if(e.keyCode == 13){
                //         getPmiPoReceivedDetails( $(this).val() );
                //     // }
                // });


                // $('#btnScanQrProductionHistory').click(function (e) {
                //     $('#mdlScanQrCodeProductionHistory').modal('show');
                //     $('#mdlScanQrCodeProductionHistory').on('shown.bs.modal');

                // });

                // $('#txtScanQrCodeProductionHistory').on('keyup', function(e){
                //     if(e.keyCode == 13){
                //         console.log(($(this).val()));
                //         // let explodedMat = $(this).val().split(' $|| ');
                //         // $('#txtMaterialLot_0').val(explodedMat[0]);
                //         // $('#txtMaterialLotQty').val(explodedMat[1]);

                //         // // console.log(explodedMat);
                //         formModal.ProductionHistory.find('#contact_lot_number').val($(this).val());
                //         $(this).val('');
                //         $('#mdlScanQrCodeProductionHistory').modal('hide');
                //     }
                // });

                // formModal.ProductionHistoryStation.find('#input').keyup(function (e) {
                //     totalOutput($(this).val(),formModal.ProductionHistoryStation.find("#ng_qty").val());
                // });

                // formModal.ProductionHistoryStation.find('#ng_qty').keyup(function (e) {
                //     totalOutput(formModal.ProductionHistoryStation.find("#input").val(),$(this).val());
                // });

                // formModal.ProductionHistory.submit(function (e) {
                //     e.preventDefault();
                //     saveProductionHistory();
                // });

                // formModal.ProductionHistoryStation.submit(function (e) {
                //     e.preventDefault();
                //     saveProductionHistoryStation();
                // });




            });
        </script>
    @endsection
@endauth

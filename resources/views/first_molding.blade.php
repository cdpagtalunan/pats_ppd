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
                            <h1>First Molding</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">First Molding</li>
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
                                    <h3 class="card-title">First Molding</h3>
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
                                                  <label>Contact Name</label>
                                                    <input type="text" class="form-control" id="global_contact_name" name="global_contact_name" readonly>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    <div style="float: right;">
                                        {{-- @if(Auth::user()->user_level_id == 1)
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @else
                                        @if(Auth::user()->position == 7 || Auth::user()->position == 8)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#modalImportPackingMatrix" id="btnShowImport" title="Import Packing Matrix"><i class="fa fa-file-excel"></i> Import</button>
                                        @endif
                                        @endif --}}
                                        <button class="btn btn-primary" id="btnAddFirstMolding" disabled>
                                            <i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblFirstMoldingDetails" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Device Name</th>
                                                    <th>Contact Name</th>
                                                    <th>Contact Lot No.</th>
                                                    <th>Production Lot No.</th>
                                                    <th>Remarks</th>
                                                    <th>Created At</th>
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
    <!--- Go to component/modal.blade.php -->
    <!--- modalSaveIqcInspection formSaveIqcInspection -->
    <!--- modalFirstMolding formFirstMolding -->
    <!--- modalFirstMoldingStation formFirstMoldingStation -->

    @endsection

    @section('js_content')
        <script>
            $(document).ready(function () {

                getFirstModlingDevices();

                $('#modalFirstMolding').on('hidden.bs.modal', function() {
                    formModal.firstMolding.find('#first_molding_id').val('');
                    formModal.firstMolding.find('#contact_lot_number').val('');
                    formModal.firstMolding.find('#production_lot').val('');
                    formModal.firstMolding.find('#remarks').val('');
                    formModal.firstMolding.find('#created_at').val('');
                    formModal.firstMolding.find('.form-control').removeClass('is-valid')
                    formModal.firstMolding.find('.form-control').removeClass('is-invalid');
                    formModal.firstMolding.find('.form-control').attr('title', '');
                })

                $('#modalFirstMoldingStation').on('hidden.bs.modal', function() {
                    formModal.firstMoldingStation.find('#first_molding_detail_id').val('');
                    formModal.firstMoldingStation.find('#date').val('');
                    formModal.firstMoldingStation.find('#operator_name').val('');
                    formModal.firstMoldingStation.find('#input').val('');
                    formModal.firstMoldingStation.find('#ng_qty').val(0);
                    formModal.firstMoldingStation.find('#output').val('');
                    formModal.firstMoldingStation.find('#remarks').val('');
                    formModal.firstMoldingStation.find('.form-control').removeClass('is-valid')
                    formModal.firstMoldingStation.find('.form-control').removeClass('is-invalid');
                    formModal.firstMoldingStation.find('.form-control').attr('title', '');
                })

                $('#mdlScanQrCodeFirstMolding').on('shown.bs.modal', function () {
                    $('#txtScanQrCodeFirstMolding').focus();
                    const mdlScanQrCode = document.querySelector("#mdlScanQrCodeFirstMolding");
                    const inptQrCode = document.querySelector("#txtScanQrCodeFirstMolding");
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

                dt.firstMolding = table.FirstMoldingDetails.DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "load_first_molding_details",
                        data: function (param){
                            param.first_molding_device_id = $("#global_device_name").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "contact_name" },
                        { "data" : "contact_lot_number" },
                        { "data" : "production_lot" },
                        { "data" : "remarks" },
                        { "data" : "created_at" },
                    ]
                });

                dt.firstMoldingStation = table.FirstMoldingStationDetails.DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "load_first_molding_station_details",
                        data: function (param){
                            param.first_molding_id = formModal.firstMolding.find("#first_molding_id").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        // { "data" : "status" },
                        { "data" : "stations" },
                        { "data" : "date" },
                        { "data" : "operator_names" },
                        { "data" : "input" },
                        { "data" : "ng_qty" },
                        { "data" : "output" },
                        { "data" : "remarks" },
                        { "data" : "created_at" },
                    ]
                });

                table.FirstMoldingDetails.on('click','#btnEditFirstMolding', editFirstMolding);
                table.FirstMoldingStationDetails.on('click','#btnEditFirstMoldingStation', editFirstMoldingStation);

                $('#btnAddFirstMolding').click(function (e) {
                    e.preventDefault();
                    dt.firstMoldingStation.draw()
                    $('#modalFirstMolding').modal('show');
                    $('#btnFirstMoldingStation').prop('disabled',true);
                    $('#btnSubmitFirstMoldingStation').prop('disabled',true);
                    $('#btnRuncardDetails').removeClass('d-none',true);
                });

                $('#btnFirstMoldingStation').click(function (e) {
                    e.preventDefault();
                    getStation();
                    $('#modalFirstMoldingStation').modal('show');
                    formModal.firstMoldingStation.find('#first_molding_id').val( formModal.firstMolding.find('#first_molding_id').val() );
                });

                $('#btnSubmitFirstMoldingStation').click(function (e) {
                    e.preventDefault();
                    Swal.fire({
                        // title: "Are you sure?",
                        text: "Are you sure you want to submit this process",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "GET",
                                url: "first_molding_update_status",
                                data: {
                                    "first_molding_id" : formModal.firstMolding.find("#first_molding_id").val(),
                                },
                                dataType: "json",
                                success: function (response) {
                                    if(response['result'] === 1){
                                        $('#modalFirstMolding').modal('hide');
                                        dt.firstMolding.draw();
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            title: "Submitted Successfully !",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                },error: function (data, xhr, status){
                                    toastr.error(`Error: ${data.status}`);
                                }
                            });
                        }
                    });
                });

                $('#global_device_name').change(function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "get_first_molding_devices_by_id",
                        data: {"first_molding_device_id" : $(this).val()},
                        dataType: "json",
                        success: function (response) {
                            let first_molding_device_id = response[0].id
                            let contact_name = response[0].contact_name
                            let device_name = response[0].device_name

                            $('#btnAddFirstMolding').prop('disabled',false);
                            $('#global_contact_name').val(contact_name);
                            formModal.firstMolding.find('#first_molding_device_id').html(`<option value="${first_molding_device_id}">${device_name}</option>`);
                            formModal.firstMolding.find('#contact_name').val(contact_name);

                            dt.firstMolding.draw();
                            console.log($("#global_device_name").val())
                        }
                    });
                });
                const totalOutput = function (input_qty,ng_qty){
                    let totalOutputQty = input_qty - ng_qty;
                    if(totalOutputQty < 0 ){
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Output qty. cannot be negative value!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        formModal.firstMoldingStation.find('#output').val('');
                        return;
                    }
                    formModal.firstMoldingStation.find('#output').val(totalOutputQty);
                }

                $('#btnScanQrFirstMolding').click(function (e) {
                    $('#mdlScanQrCodeFirstMolding').modal('show');
                    $('#mdlScanQrCodeFirstMolding').on('shown.bs.modal');

                });

                $('#txtScanQrCodeFirstMolding').on('keyup', function(e){
                    if(e.keyCode == 13){
                        console.log(($(this).val()));
                        // let explodedMat = $(this).val().split(' $|| ');
                        // $('#txtMaterialLot_0').val(explodedMat[0]);
                        // $('#txtMaterialLotQty').val(explodedMat[1]);

                        // // console.log(explodedMat);
                        formModal.firstMolding.find('#contact_lot_number').val($(this).val());
                        $(this).val('');
                        $('#mdlScanQrCodeFirstMolding').modal('hide');
                    }
                });

                $('#input').keyup(function (e) {
                    totalOutput(formModal.firstMoldingStation.find(this).val(),formModal.firstMoldingStation.find("#ng_qty").val());
                });

                $('#ng_qty').keyup(function (e) {
                    totalOutput(formModal.firstMoldingStation.find("#input").val(),formModal.firstMoldingStation.find(this).val());
                });

                formModal.firstMolding.submit(function (e) {
                    e.preventDefault();
                    saveFirstMolding();
                });

                formModal.firstMoldingStation.submit(function (e) {
                    e.preventDefault();
                    savefirstMoldingStation();
                });




            });
        </script>
    @endsection
@endauth

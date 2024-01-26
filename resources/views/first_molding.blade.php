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

    <!--- Modal modalSaveIqcInspection formSaveIqcInspection-->
    @include('component.modal')

    @endsection

    @section('js_content')
        <script>
            $(document).ready(function () {
                const data = {
                device_name     : "",
                contact_name    : "",
                }

                const dt = {
                    firstMolding : "",
                }

                $('#btnAddFirstMolding').click(function (e) {
                    e.preventDefault();
                    $('#modalFirstMolding').modal('show');
                });

                dt.firstMolding = $("#tblFirstMoldingDetails").DataTable({
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
                getFirstModlingDevices();
                
                
                
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
                            formModal.modalFirstMolding.find('#first_molding_device_id').html(`<option value="${first_molding_device_id} selected">${device_name}</option>`);
                            formModal.modalFirstMolding.find('#contact_name').val(contact_name);

                            dt.firstMolding.draw();
                            console.log($("#global_device_name").val())
                        }
                    });
                });
            });
        </script>
    @endsection
@endauth

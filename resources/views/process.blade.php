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

    @section('title', 'Process')

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
                            <h1>Process</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Process</li>
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
                        <div class="col-sm-6">
                            <!-- general form elements -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Process Module</h3>
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

                                        <button class="btn btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalAddProcess" id="btnShowAddDevic"><i
                                                class="fa fa-initial-icon"></i> Add Module</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblProcess" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Module</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <!-- !-- End Page Content -->

                            </div>
                            <!-- /.card -->
                        </div>

                        <div class="col-sm-6">
                            <!-- general form elements -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Station</h3>
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

                                        <button class="btn btn-dark" data-bs-toggle="modal"
                                            data-bs-target="#modalAddStation" id="btnShowAddDevic"><i
                                                class="fa fa-initial-icon"></i> Add Station</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblStation" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Station</th>
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
        {{-- * ADD Module --}}
        <div class="modal fade" id="modalAddProcess">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Module</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formProcess" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" id="txtProcessId" name="id">

                                    <div class="form-group">
                                        <label>Module Name</label>
                                        <input type="text" class="form-control" name="process_name" id="txtProcessName">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnProcess" class="btn btn-dark"><i
                                    class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

          {{-- * ADD Station --}}
          <div class="modal fade" id="modalAddStation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Station</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formStation" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" id="txtStationId" name="id">

                                    <div class="form-group">
                                        <label>Station Name</label>
                                        <input type="text" class="form-control" name="station_name" id="txtStationName" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnStation" class="btn btn-dark"><i
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
            let datatableProcesss;
            let datatableStation;

            datatableProcesss = $("#tblProcess").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_process",
                    // data: function (param){
                    //     param.status = $("#selEmpStat").val();
                    // }
                },
                fixedHeader: true,
                "columns":[
                
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "label" },
                    { "data" : "process_name" }
                ],
            });//end of dataTableDevices


            datatableStation = $("#tblStation").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_station",
                    // data: function (param){
                    //     param.status = $("#selEmpStat").val();
                    // }
                },
                fixedHeader: true,
                "columns":[
                
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "label" },
                    { "data" : "station_name" }
                ],
            });//end of dataTableDevices


            /* *SCRIPT FOR MODULE */
            $('#formProcess').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "add_process",
                    data: $('#formProcess').serialize(),
                    dataType: "json",
                    success: function (response) {
                        if(response['result'] == 1){
                            datatableProcesss.draw();
                            $('#modalAddProcess').modal('hide');
                        }
                    }
                });
            });

            $(document).on('click', '.btnEdit', function(e){
                let pId = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: "get_process_by_id",
                    data: {
                        "id" : pId
                    },
                    dataType: "json",
                    success: function (response) {


                        $('#txtProcessId').val(response['id']);
                        $('#txtProcessName').val(response['process_name']);

                        $('#modalAddProcess').modal('show');

                    }
                });
            });

            $(document).on('click', '.btnDisable', function(e){
                let pId = $(this).data('id');

                Swal.fire({
                    // title: "Are you sure?",
                    text: "Are you sure you want to disable this process",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "post",
                            url: "update_status",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id" : pId,
                            },
                            dataType: "json",
                            success: function (response) {
                            }
                        });
                    }
                });
               
            })
            /* *END SCRIPT FOR MODULE */

            /* SCRIPT FOR STATION */

            $('#formStation').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "save_station",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        datatableStation.draw();
                        $('#modalAddStation').modal('hide');
                        $('#formStation')[0].reset();
                        toastr.success(response.msg);
                    }
                });
            })

            $(document).on('click', '.btnEditStation', function(e){
                let id = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: "get_station_details_by_id",
                    data: {
                        "id" : id
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#txtStationId').val(response['id']);
                        $('#txtStationName').val(response['station_name']);
                        $('#modalAddStation').modal('show');
                    }
                });
            });

            $(document).on('click', '.btnDeactivateStation', function(e){
                let id = $(this).data('id');
                let status = $(this).data('status');
                callPrompt(id, status);
            });

            $(document).on('click', '.btnActivateStation', function(e){
                let id = $(this).data('id');
                let status = $(this).data('status');
                callPrompt(id, status);
            })


            function callPrompt(id, status){
                Swal.fire({
                    // title: "Are you sure?",
                    html: "Do you want to deactivate this station?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "get",
                            url: "update_status",
                            data: {
                                "id" : id,
                                "status" : status
                            },
                            dataType: "json",
                            success: function (response) {
                                datatableStation.draw();
                                
                            }
                        });
                    }
                });
            }
            /* END SCRIPT FOR STATION */

        </script>
    @endsection
@endauth
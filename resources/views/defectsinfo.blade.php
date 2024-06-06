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

    @section('title', 'Defects')

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
                            <h1>Mode of Defects</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Mode of Defects</li>
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
                        <div class="col-sm-12">
                            <!-- general form elements -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Defects Module</h3>
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
                                            data-bs-target="#modalAddDefects" id="btnShowAddDevic"><i
                                                class="fa fa-initial-icon"></i> Add Defect</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblDefectsInfo" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Station</th>
                                                    <th>Defect</th>
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
        <div class="modal fade" id="modalAddDefects">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Defect Info</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formDefects" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" id="txtDefectsId" name="id">

                                    <div class="form-group">
                                        <label>Station</label>
                                         <select class="form-control select2bs4" name="station" style="width: 100%;" id="selStation">
                                            <option selected value="" disabled>-- Select --</option>
                                            <option value="0">Camera NG</option>
                                            <option value="1">Visual Defect</option>
                                            </select>
                                    </div>

                                     <div class="form-group">
                                        <label>Defect Name</label>
                                        <input type="text" class="form-control" name="defects" id="txtDefectName">
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

    @endsection

    @section('js_content')
        <script type="text/javascript">
            let datatableProcesss;
            let datatableStation;

            datatableProcesss = $("#tblDefectsInfo").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_defectsinfo",
                },
                fixedHeader: true,
                "columns":[

                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "label" },
                    { "data" : "station" },
                    { "data" : "defects" }
                ],
            });

            $('#formDefects').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "add_defects",
                    data: $('#formDefects').serialize(),
                    dataType: "json",
                    success: function (response) {
                        if(response['result'] == 1){
                            datatableProcesss.draw();
                            $('#modalAddDefects').modal('hide');
                        }
                    }
                });
            });

            $(document).on('click', '.btnEdit', function(e){
                let pId = $(this).data('id');
                $.ajax({
                    type: "get",
                    url: "get_defects_by_id",
                    data: {
                        "id" : pId
                    },
                    dataType: "json",
                    success: function (response) {


                        $('#txtDefectsId').val(response['id']);
                        $('#selStation').val(response['station']);
                        $('#txtDefectName').val(response['defects']);

                        $('#modalAddDefects').modal('show');

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


        </script>
    @endsection
@endauth


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
                                                    <select class="form-select form-control" id="first_molding_device_id" name="first_molding_device_id" >
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="col-sm-3">
                                                  <label>Contact Name</label>
                                                    <input type="text" class="form-control" id="contact_name" readonly>
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
                                        <button class="btn btn-primary" id="btnAddFirstMolding">
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
                                                    <th>Production Lot No.</th>
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
                                                    <th>Shipment Output</th>
                                                    <th>Material Lot #</th>
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
                $('#btnAddFirstMolding').click(function (e) {
                    e.preventDefault();
                    // console.log('dsadsa');
                    $('#modalRuncardDetails').modal('show');
                });
                $.ajax({
                    type: "GET",
                    url: "get_first_molding_devices",
                    data: "data",
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        result = '';
                        let first_molding_device_id = response['id'];
                        let device_name = response['value'];

                        if(response['id'].length > 0){
                            result = '<option selected disabled> --- Select --- </option>';
                            for(let index = 0; index < first_molding_device_id.length; index++){
                                result += '<option value="' +first_molding_device_id[index]+'">'+device_name[index]+'</option>';
                            }
                        }
                        else{
                            result = '<option value="0" selected disabled> No record found </option>';
                        }
                        $('select[name="first_molding_device_id"]').html(result);
                    }
                });
                $('#first_molding_device_id').change(function (e) { 
                    e.preventDefault();
                    
                });
            });
        </script>
    @endsection
@endauth

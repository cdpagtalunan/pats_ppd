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
                      <h1>Material Process</h1>
                  </div>
                  <div class="col-sm-6">
                      <ol class="breadcrumb float-sm-right">
                          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                          </li>
                          <li class="breadcrumb-item active">Material Process</li>
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
                  <div class="col-md-6" id="colDevice">
                      <!-- general form elements -->
                      <div class="card card-dark">
                          <div class="card-header">
                              <h3 class="card-title">Device (Packing Matrix)</h3>
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
                                      data-bs-target="#modalAddDevice" id="btnShowAddDeviceModal"><i
                                          class="fa fa-initial-icon"></i> Add Device</button>
                              </div> <br><br>
                              <div class="table-responsive">
                                  <!-- style="max-height: 600px; overflow-y: auto;" -->
                                  <table id="tblDevices" class="table table-sm table-bordered table-striped table-hover"
                                      style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th>Status</th>
                                              <th>Action</th>
                                              <th>Device Code</th>
                                              <th>Device Name</th>
                                              <th>Process</th>

                                          </tr>
                                      </thead>
                                  </table>
                              </div>
                          </div>
                          <!-- !-- End Page Content -->

                      </div>
                      <!-- /.card -->
                  </div>

                  <div class="col-md-6" id="colMaterialProcess">
                      <!-- general form elements -->
                      <div class="card card-dark">
                          <div class="card-header">
                              <button class="btn btn-sm btn-secondary float-right ml-3 py-0 px-1 " title="Maximize"
                                  id="btnMaximizeColMatProc"><i class="fas fa-arrows-alt-h"></i></button>
                              <button class="btn btn-sm btn-secondary float-right ml-3 py-0 px-1 " title="Minimize"
                                  id="btnMinimizeColMatProc" style="display: none;"><i
                                      class="fas fa-arrows-alt-h"></i></button>
                              <h3 class="card-title">Process</h3>
                          </div>

                          <!-- Start Page Content -->
                          <div class="card-body">
                              <div style="float: right;">
                                  <button class="btn btn-dark" id="btnShowAddMatProcModal"><i
                                          class="fa fa-initial-icon"></i> Add Process</button>
                              </div>
                              <div style="float: left;">
                                  <label>Device: <u id="uSelectedDeviceName">No Selected Device</u></label>
                              </div>
                              <br><br>
                              <div class="row">
                                  <div class="col-sm-4">
                                      <div class="input-group input-group-sm mb-3">
                                          <div class="input-group-prepend w-50">
                                              <span class="input-group-text w-100" id="basic-addon1">Status</span>
                                          </div>
                                          <select class="form-control select2 select2bs4 selectUser"
                                              id="selFilterMatProcStat">
                                              <option value="0"> Active </option>
                                              <option value="1"> Inactive </option>
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="table-responsive">
                                  <table id="tblMatProcesses"
                                      class="table table-sm table-bordered table-striped table-hover"
                                      style="width: 100%;">
                                      <thead>
                                          <tr>
                                              <th>Action</th>
                                              {{-- <th>Status</th> --}}
                                              <th>Step</th>
                                              <th>Process</th>
                                              <th>Material</th>
                                              <th>Machine</th>
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
  {{-- * ADD --}}
  <div class="modal fade" id="modalAddDevice">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-plus"></i> Add Device</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formAddDevice">
                  @csrf
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" id="txtDeviceId" name="id">
                              <div class="form-group">
                                  <label>Code</label>
                                  <input type="text" class="form-control" name="code" id="txtAddDeviceCode">
                              </div>

                              <div class="form-group">
                                  <label>Material Name</label>
                                  <input type="text" class="form-control" name="name" id="txtAddDeviceName">
                              </div>
                              {{-- <div class="form-group">
                                <label>Process</label>
                                <br>
                                <input type="radio" id="stamping" name="process">
                                <label for="stamping">Stamping</label>
                                <input type="radio" id="molding" name="process">
                                <label for="molding">Molding</label>
                              </div> --}}
                              <label>Process</label>

                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="process" id="stamping" value="0">
                                <label class="form-check-label" for="stamping">
                                  Stamping
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="process" id="molding" value="1">
                                <label class="form-check-label" for="molding">
                                  Molding/Assy
                                </label>
                              </div>
                              {{-- <div class="form-group">
                                <label>Stamping Process</label>
                                <select name="stamp_step" id="selStampStep" class="form-control">
                                  <option value="0" selected>N/A</option>
                                  <option value="1">1st Stamping only</option>
                                  <option value="2">1st Stamping->SANNNO</option>
                                  <option value="3">1st Stamping->SANNNO->2nd Stamping</option>
                                </select>
                              </div> --}}
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="btnAddDevice" class="btn btn-dark"><i id="iBtnAddDeviceIcon"
                              class="fa fa-check"></i> Save</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  {{-- * EDIT --}}
  {{-- <div class="modal fade" id="modalEditDevice">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-user"></i> Edit Device</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formEditDevice">
                  @csrf
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" class="form-control" name="device_id" id="txtEditDeviceId">
                              <div class="form-group">
                                  <label>Code</label>
                                  <input type="text" class="form-control" name="barcode" id="txtEditDeviceBarcode">
                              </div>

                              <div class="form-group">
                                  <label>Device Name</label>
                                  <input type="text" class="form-control" name="name" id="txtEditDeviceName">
                              </div>

                              <div class="form-group">
                                  <label>Huawei P/N</label>
                                  <input type="text" class="form-control" name="huawei_p_n" id="txtEditDeviceHuaweiPN">
                              </div>

                              <div class="form-group">
                                  <label>Lot No. Machine Code</label>
                                  <input type="text" class="form-control" name="lot_no_machine_code"
                                      id="txtEditDeviceLotNoMachineCode">
                              </div>

                              <div class="form-group">
                                  <label>MRP No.</label>
                                  <input type="text" class="form-control" name="mrp_no" id="txtEditDeviceMRPNo">
                              </div>

                              <div class="form-group">
                                  <label>Boxing</label>
                                  <input type="number" min="1" class="form-control" name="boxing"
                                      id="txtEditDeviceBoxing">
                              </div>

                              <div class="form-group">
                                  <label>Shipping Boxing</label>
                                  <input type="number" min="1" class="form-control" name="ship_boxing"
                                      id="txtEditDeviceShipBoxing">
                              </div>

                              <div class="form-group">
                                  <label>Product Type</label>
                                  <select class="form-control" name="product_type" id="selEditDeviceProductType">
                                      <option value="1">HUAWEI - PATS CN</option>
                                      <option value="2">HUAWEI - CN PTS</option>
                                      <option value="3">OTHERS - PATS CN</option>
                                      <option value="4">OTHERS - CN PTS</option>
                                  </select>
                              </div>

                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="btnEditDevice" class="btn btn-primary"><i id="iBtnEditDeviceIcon"
                              class="fa fa-check"></i> Save</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div> --}}
  <!-- /.modal -->

  <div class="modal fade" id="modalChangeDeviceStat">
      <div class="modal-dialog">
          <div class="modal-content modal-sm">
              <div class="modal-header">
                  <h4 class="modal-title" id="h4ChangeDeviceTitle"><i class="fa fa-user"></i> Change Status</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formChangeDeviceStat">
                  @csrf
                  <div class="modal-body">
                      <label id="lblChangeDeviceStatLabel">Are you sure to ?</label>
                      <input type="hidden" name="device_id" placeholder="Device Id" id="txtChangeDeviceStatDeviceId">
                      <input type="hidden" name="status" placeholder="Status" id="txtChangeDeviceStatDeviceStat">
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">No</button>
                      <button type="submit" id="btnChangeDeviceStat" class="btn btn-dark"><i
                              id="iBtnChangeDeviceStatIcon" class="fa fa-check"></i> Yes</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->


  <!-- MATERIAL PROCESS MODALS -->
  <div class="modal fade" id="modalAddMatProc">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-initial-icon"></i> Process</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formAddMatProc" autocomplete="off">
                  @csrf
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" name="device_id" id="txtAddMatProcDevId">
                              <input type="hidden" name="mat_proc_id" id="txtAddMatProcId">

                              <div class="form-group">
                                  <label>Device Name</label>
                                  <input type="text" class="form-control" name="device_name"
                                      id="txtAddMatProcDeviceName" readonly>
                              </div>

                              <div class="form-group">
                                <label>Step</label>
                                <input type="number" class="form-control" name="step"
                                    id="txtAddMatProcStep" readonly>
                              </div>

                              <div class="form-group">
                                <label>Process</label>
                                {{-- <input type="text" class="form-control" name="process"
                                    id="txtAddMatProcProcess"> --}}
                                  <select class="form-control select2bs4" id="selAddMatProcProcess" name="process">

                                  </select>
                              </div>
                              <div class="form-group">
                                <label>Machine</label>
                                <select class="form-control select2bs4" id="selAddMatProcMachine" name="machine[]" multiple>

                                </select>
                              </div>
                              <div class="form-group">
                                <label>Station</label>
                                <select class="form-control select2bs4" id="selAddMatStation" name="station[]" multiple>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Material Name</label>
                                <select class="form-control select2bs4" id="selAddMatProcMatName" name="material_name[]" multiple>

                                </select>
                              </div>
                             
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                      <button type="submit" id="btnAddMatProc" class="btn btn-dark"><i id="iBtnAddMatProcIcon"
                              class="fa fa-check"></i> Save</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- MATERIAL PROCESS MODALS -->
  {{-- <div class="modal fade" id="modalEditMatProc">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-initial-icon"></i> Edit Material Process</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formEditMatProc">
                  @csrf
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <input type="hidden" name="device_id" id="txtEditMatProcDevId">
                              <input type="hidden" name="material_process_id" id="txtEditMatProcId">

                              <div class="form-group">
                                  <label>Device Name</label>
                                  <input type="text" class="form-control" name="device_name"
                                      id="txtEditMatProcDeviceName" readonly>
                              </div>

                              <div class="form-group">
                                  <label>Step</label>
                                  <input type="text" min="1" class="form-control" name="step" id="txtEditMatProcStep">
                              </div>

                              <div class="form-group">
                                  <!-- <label>Process</label>
                  <div style="float: right">
                    <label><input type="checkbox" name="has_emboss" value="1" id="chkEditMatProcHasEmboss"> For Emboss</label>
                  </div>
                  <select class="form-control select2bs4 selectSubStation" name="station_sub_station_id" id="selEditMatProcSubStationId" style="width: 100%;">
                  </select> -->

                                  <div class="row">
                                      <div class="col-sm-4">
                                          <label>Process</label>
                                      </div>
                                      <div class="col-sm-3">
                                          <label><input type="checkbox" name="has_emboss" value="1"
                                                  id="chkEditMatProcHasEmboss"> For Emboss</label>
                                      </div>
                                      <div class="col-sm-5">
                                          <label><input type="checkbox" name="require_oqc_before_emboss" value="1"
                                                  id="chkEditMatProcReqOQCBeforeEmboss"> Require OQC Before
                                              Emboss</label>
                                      </div>
                                  </div>
                                  <select class="form-control select2bs4 selectSubStation" name="station_sub_station_id"
                                      id="selEditMatProcSubStationId" style="width: 100%;">
                                  </select>
                              </div>

                              <!-- <div class="form-group">
                  <label>Material</label>
                    <input type="text" class="form-control" name="material" id="txtEditMatProcMaterial">
                </div> -->

                              <div class="form-group">
                                  <label>Material Kitting & Issuance Item</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selWBSMatKitItem"
                                          id="selEditMatProcMatKitItem" name="material_kitting_item[]"
                                          multiple="multiple">
                                          <!-- <option value=""> N/A </option> -->
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label>Sakidashi Issuance Item</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selWBSSakIssuItem"
                                          id="selEditMatProcSakIssuItem" name="sakidashi_item[]" multiple="multiple">
                                          <!-- <option value=""> N/A </option> -->
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label>Emboss Item</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selWBSEmbossIssuItem"
                                          id="selEditMatProcEmbossItem" name="emboss_item[]" multiple="multiple">
                                          <!-- <option value=""> N/A </option> -->
                                      </select>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label>Machine</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selectMachine"
                                          id="selEditMatProcMachine" name="machine_id[]" multiple="multiple">
                                          <option value=""> N/A </option>
                                      </select>
                                      <div class="input-group-append">
                                          <button class="btn btn-info" type="button" title="Scan code"
                                              id="btnEditMatProcScanMachineCode"><i class="fa fa-qrcode"></i></button>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label>Certified Operator (A-Shift)</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selUser"
                                          id="selEditMatProcAShiftManpower" name="a_shift_user_id[]"
                                          multiple="multiple">
                                          <!-- <option value=""> N/A </option> -->
                                      </select>
                                      <div class="input-group-append">
                                          <button class="btn btn-info" type="button" title="Scan code"
                                              id="btnEditMatProcScanAUserCode"><i class="fa fa-qrcode"></i></button>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label>Certified Operator (B-Shift)</label>
                                  <div class="input-group input-group-sm mb-3">
                                      <select class="form-control select2 select2bs4 selUser"
                                          id="selEditMatProcBShiftManpower" name="b_shift_user_id[]"
                                          multiple="multiple">
                                          <!-- <option value=""> N/A </option> -->
                                      </select>
                                      <div class="input-group-append">
                                          <button class="btn btn-info" type="button" title="Scan code"
                                              id="btnEditMatProcScanBUserCode"><i class="fa fa-qrcode"></i></button>
                                      </div>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="btnEditMatProc" class="btn btn-primary"><i id="iBtnEditMatProcIcon"
                              class="fa fa-check"></i> Save</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div> --}}
  <!-- /.modal -->

  <div class="modal fade" id="modalImportPackingMatrix">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title"><i class="fa fa-file-excel"></i> Import Packing Matrix</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formImportPackingMatrix" enctype="multipart/form-data">
                  @csrf
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-sm-12">
                              <div class="form-group">
                                  <label>File</label>
                                  <input type="file" class="form-control" name="import_file"
                                      id="fileImportPackingMatrix">
                              </div>

                              <div class="table-responsive">
                                  <table class="table table-bordered" id="tblImportResult">
                                      <thead>
                                          <tr>
                                              <th>No. of Inserted</th>
                                              <th class="thNoOfInserted">0</th>
                                          </tr>
                                          <tr>
                                              <th>No. of Updated</th>
                                              <th class="thNoOfUpdated">0</th>
                                          </tr>
                                          <tr>
                                              <th>No. of Failed</th>
                                              <th class="thNoOfFailed">0</th>
                                          </tr>
                                          <tr>
                                              <th colspan="2">
                                                  <center>List of Failed Product Code</center>
                                              </th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" id="btnImportPackingMatrix" class="btn btn-dark"><i
                              id="iBtnImportPackingMatrixIcon" class="fa fa-check"></i> Import</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <div class="modal fade" id="modalChangeMatProcStat">
      <div class="modal-dialog">
          <div class="modal-content modal-sm">
              <div class="modal-header">
                  <h4 class="modal-title" id="h4ChangeMatProcTitle"><i class="fa fa-default"></i> Change Status</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form method="post" id="formChangeMatProcStat">
                  @csrf
                  <div class="modal-body">
                      <label id="lblChangeMatProcStatLabel">Are you sure to ?</label>
                      <input type="hidden" name="material_process_id" placeholder="Material Process Id"
                          id="txtChangeMatProcStatMatProcId">
                      <input type="hidden" name="status" placeholder="Status" id="txtChangeMatProcStatMatProcStat">
                  </div>
                  <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-bs-dismiss="modal">No</button>
                      <button type="submit" id="btnChangeMatProcStat" class="btn btn-dark"><i
                              id="iBtnChangeMatProcStatIcon" class="fa fa-check"></i> Yes</button>
                  </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
  <div class="modal fade" id="mdl_qrcode_scanner" data-formid="" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header border-bottom-0 pb-0">
                  <!-- <h5 class="modal-title" id="exampleModalLongTitle"></h5> -->
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body pt-0">
                  <div class="text-center text-secondary">
                      Please scan the code.
                      <br>
                      <br>
                      <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                  </div>
                  <input type="text" id="txt_qrcode_scanner" class="hidden_scanner_input">
              </div>
          </div>
      </div>
  </div>
  <!-- /.Modal -->
  @endsection

  @section('js_content')
  <script type="text/javascript">
    // Device
    let dataTableDevices;

    // Material Process
    let dataTableMatProcess;
    let selectedDeviceId = 0;
    let selectedDeviceName = '';

    $(document).ready(function () {


      // GetUserList($(".selUser"));

      // GetCboMachine($(".selectMachine"));

      // GetMaterialKittingList($(".selWBSMatKitItem"));
      // GetSakidashiList($(".selWBSSakIssuItem"));
      // GetEmbossList($(".selWBSEmbossIssuItem"));

      $(document).on('click','#tblDevices tbody tr',function(e){
        $(this).closest('tbody').find('tr').removeClass('table-active');
        $(this).closest('tr').addClass('table-active');
        selectedDeviceId = $(this).closest('tbody tr.table-active').find('.td_device_id').val();
        selectedDeviceName = $(this).closest('tbody tr.table-active').find('.td_device_name').val();

        $("#uSelectedDeviceName").text(selectedDeviceName);
        $("#txtAddSubDeviceDeviceId").val(selectedDeviceId);
        $("#txtAddSubDeviceDeviceName").val(selectedDeviceName);
        getMaterialProcessForInputs();

        dataTableMatProcess.draw();
      });

      $("#chkAddMatProcHasEmboss").click(function(){
        if($(this).prop('checked') == true){
          // $("#selAddMatProcEmbossItem").prop('disabled', false);
          // $("#selAddMatProcMatKitItem").prop('disabled', true);
          // $("#selAddMatProcSakIssuItem").prop('disabled', true);
          // alert('check');
          $("#chkAddMatProcReqOQCBeforeEmboss").prop('disabled', false);
          $("#chkAddMatProcReqOQCBeforeEmboss").prop('checked', false);
        }
        else{
          // $("#selAddMatProcEmbossItem").prop('disabled', true);
          // $("#selAddMatProcMatKitItem").prop('disabled', false);
          // $("#selAddMatProcSakIssuItem").prop('disabled', false);
          // alert('uncheck');
          $("#chkAddMatProcReqOQCBeforeEmboss").prop('disabled', true);
          $("#chkAddMatProcReqOQCBeforeEmboss").prop('checked', false);
        }
      });

      $("#chkEditMatProcHasEmboss").click(function(){
        if($(this).prop('checked') == true){
          $("#chkEditMatProcReqOQCBeforeEmboss").prop('disabled', false);
        }
        else{
          $("#chkEditMatProcReqOQCBeforeEmboss").prop('disabled', true);
        }
      });

      $("#chkEditMatProcHasEmboss").click(function(){
        if($(this).prop('checked') == true){
          // $("#selEditMatProcEmbossItem").prop('disabled', false);
          // $("#selEditMatProcMatKitItem").prop('disabled', true);
          // $("#selEditMatProcSakIssuItem").prop('disabled', true);
          // alert('check');
        }
        else{
          // $("#selEditMatProcEmbossItem").prop('disabled', true);
          // $("#selEditMatProcMatKitItem").prop('disabled', false);
          // $("#selEditMatProcSakIssuItem").prop('disabled', false);
          // alert('uncheck');
        }
      });

      $(document).on('click','#tblMatProcesses tbody tr',function(e){
        $(this).closest('tbody').find('tr').removeClass('table-active');
        $(this).closest('tr').addClass('table-active');
      });

      dataTableDevices = $("#tblDevices").DataTable({
        "processing" : true,
          "serverSide" : true,
          "ajax" : {
            url: "view_devices",
            // data: function (param){
            //     param.status = $("#selEmpStat").val();
            // }
          },
          fixedHeader: true,
          "columns":[

            { "data" : "action", orderable:false, searchable:false },
            { "data" : "label" },
            { "data" : "code" },
            { "data" : "name" },
            { "data" : "process_name" },
          ],
          // "columnDefs": [
          //   { className: "bg-info", "targets": [ 5 ] }
          // ],
          // "scrollY": "400px",
          // "scrollCollapse": true,
        });//end of dataTableDevices

        // Add Device
        $("#formAddDevice").submit(function(event){
          event.preventDefault();
          AddDevice();
        });

        $("#btnShowAddDeviceModal").click(function(){
          $("#txtAddDeviceName").removeClass('is-invalid');
          $("#txtAddDeviceName").attr('title', '');
          $("#txtAddDeviceBarcode").removeClass('is-invalid');
          $("#txtAddDeviceBarcode").attr('title', '');
        });

        $("#btnShowImport").click(function(){
          $(".thNoOfInserted").text('0');
          $(".thNoOfUpdated").text('0');
          $(".thNoOfFailed").text('0');
          $("#tblImportResult tbody").html('');
        });

        // Edit Device
        $(document).on('click', '.aEditDevice', function(){
          let deviceId = $(this).attr('device-id');
          $("#txtEditDeviceId").val(deviceId);
          GetDeviceByIdToEdit(deviceId);
          $("#txtEditDeviceName").removeClass('is-invalid');
          $("#txtEditDeviceName").attr('title', '');
          $("#txtEditDeviceBarcode").removeClass('is-invalid');
          $("#txtEditDeviceBarcode").attr('title', '');
        });

        $("#chkEditUserWithEmail").click(function(){
          if($(this).prop('checked')) {
            $("#txtEditUserEmail").removeAttr('disabled');
            $("#txtEditUserEmail").val($("#txtEditUserCurrEmail").val());
          }
          else{
            $("#txtEditUserEmail").prop('disabled', 'disabled');
            $("#txtEditUserEmail").val('');
          }
        });

        $("#formEditDevice").submit(function(event){
          event.preventDefault();
          EditDevice();
        });

        // Change Device Status
        $(document).on('click', '.aChangeDeviceStat', function(){
          let deviceStat = $(this).attr('status');
          let deviceId = $(this).attr('device-id');

          $("#txtChangeDeviceStatDeviceId").val(deviceId);
          $("#txtChangeDeviceStatDeviceStat").val(deviceStat);

          if(deviceStat == 1){
            $("#lblChangeDeviceStatLabel").text('Are you sure to activate?');
            $("#h4ChangeDeviceTitle").html('<i class="fa fa-user"></i> Activate Device');
          }
          else{
            $("#lblChangeDeviceStatLabel").text('Are you sure to deactivate?');
            $("#h4ChangeDeviceTitle").html('<i class="fa fa-user"></i> Deactivate Device');
          }

          $('#modalChangeDeviceStat').modal('show');
        });

        $("#formChangeDeviceStat").submit(function(event){
          event.preventDefault();
          ChangeDeviceStatus();
        });
      });


      // Material Process
      $(document).ready(function(){
        // GetCboStationSubStation($(".selectSubStation"), 1);
        let groupColumnMatProc = 2;
        dataTableMatProcess = $("#tblMatProcesses").DataTable({
          "processing" : true,
          "serverSide" : true,
          "ajax" : {
            url: "view_material_process_by_device_id",
            data: function (param){
                param.device_id = selectedDeviceId;
                param.status = $("#selFilterMatProcStat").val();
            }
          },

          "columns":[
            { "data" : "action" },
            // { "data" : "mat_status" },
            { "data" : "step" },
            { "data" : "process_details.process_name"},
            { "data" : "mat_details"},
            { "data" : "mach_details" },
            { "data" : "stat_details" },
          ],
          "columnDefs": [
              {
                "targets": [4],
                "data": null,
                "defaultContent": "N/A"
              }
          ],
          "order": [[ 1, 'asc' ]],
        });//end of dataTableSubStations

        // $(document).on('click', '.aShowDeviceDevProc', function(){
        //   let deviceId = $(this).attr('device-id');
        //   let deviceName = $(this).attr('device-name');

        //   $("#uSelectedDeviceName").text(deviceName);
        //   selectedDeviceId = deviceId;
        //   $("#txtAddSubDeviceDeviceId").val(selectedDeviceId);
        //   selectedDeviceName = deviceName;
        //   $("#txtAddSubDeviceDeviceName").val(selectedDeviceName);
        //   dataTableMatProcess.draw();
        // });

        $("#selFilterMatProcStat").change(function(){
          dataTableMatProcess.draw();
        });

        $("#btnShowAddMatProcModal").click(function(){

          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "3000",
            "timeOut": "3000",
            "extendedTimeOut": "3000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
          };

          if(selectedDeviceId != 0){
            $("#txtAddMatProcDevId").val(selectedDeviceId);
            $("#txtAddMatProcDeviceName").val(selectedDeviceName);

            $("#txtAddMatProcDevId").removeClass('is-invalid');
            $("#txtAddMatProcDevId").attr('title', '');
            $("#txtAddMatProcDeviceName").removeClass('is-invalid');
            $("#txtAddMatProcDeviceName").attr('title', '');


            // getMaterialProcessForAdd(selectedDeviceId);
            getStepCount(selectedDeviceId);
            $('#modalAddMatProc').modal('show');

          }
          else{
            toastr.warning('No Selected Device!');
          }
        });

        $(document).on('click', '.aEditMatProc', function(){
          let matProcId = $(this).data('id');

          if(selectedDeviceId != 0){
            $("#txtEditMatProcId").val(matProcId);
            // $("#modalEditMatProc").modal('show');
            $("#modalAddMatProc").modal('show');
            $("#txtEditMatProcDevId").val(selectedDeviceId);
            $("#txtEditMatProcDeviceName").val(selectedDeviceName);

            $("#txtEditMatProcDevId").removeClass('is-invalid');
            $("#txtEditMatProcDevId").attr('title', '');
            $("#txtEditMatProcDeviceName").removeClass('is-invalid');
            $("#txtEditMatProcDeviceName").attr('title', '');
            GetMatProcByIdToEdit(matProcId, selectedDeviceName);
          }
          else{
            toastr.warning('No Selected Device!');
          }
        });

        // Add Material Process
        $("#formAddMatProc").submit(function(event){
          event.preventDefault();
          // console.log($(this).serialize());
          AddMaterialProcess();
        });

        // Edit Material Process
        $("#formEditMatProc").submit(function(event){
          event.preventDefault();
          EditMaterialProcess();
        });

        $("#formChangeMatProcStat").submit(function(event){
          event.preventDefault();
          ChangeMatProcStat();
        });

        // Change MatProc Status
        $(document).on('click', '.aChangeMatProcStat', function(){
          let matProcStat = $(this).data('status');
          let matProcId = $(this).data('id');

          $("#txtChangeMatProcStatMatProcId").val(matProcId);
          $("#txtChangeMatProcStatMatProcStat").val(matProcStat);

          if(matProcStat == 0){
            $("#lblChangeMatProcStatLabel").text('Are you sure to activate?');
            $("#h4ChangeMatProcTitle").html('<i class="fa fa-default"></i> Activate Material Process');
          }
          else{
            $("#lblChangeMatProcStatLabel").text('Are you sure to deactivate?');
            $("#h4ChangeMatProcTitle").html('<i class="fa fa-default"></i> Deactivate Material Process');
          }

          $('#modalChangeMatProcStat').modal('show');
        });

        $("#formImportPackingMatrix").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: 'import_packing_matrix_updater',
                method: 'post',
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    // alert('Loading...');
                    $("#tblImportResult tbody").html('');
                },
                success: function(JsonObject){
                    if(JsonObject['result'] == 1){
                      // let importText = 'Importing Success!<br># of Inserted: ' + JsonObject['inserted_barcode'].length + '<br># of Updated: ' + JsonObject['updated_barcode'].length + '<br># of Failed: ' + JsonObject['failed_barcode'].length;
                      toastr.success('Importing Success!');
                      dataTableDevices.draw();
                      // $("#modalImportPackingMatrix").modal('hide');
                      $(".thNoOfInserted").text(JsonObject['inserted_barcode'].length);
                      $(".thNoOfUpdated").text(JsonObject['updated_barcode'].length);
                      $(".thNoOfFailed").text(JsonObject['failed_barcode'].length);

                      let trFailedResults = '';

                      for(let index = 0; index < JsonObject['failed_barcode'].length; index++){
                        trFailedResults += '<tr><td colspan="2" style="color: red;"><center>' + JsonObject['failed_barcode'][index] + '</center></td></tr>';
                      }

                      $("#tblImportResult tbody").html(trFailedResults);
                    }
                    else{
                      toastr.error('Importing Failed!');
                    }
                },
                error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        });

        // $(document).on('keypress',function(e){
        //   if( ($("#mdl_qrcode_scanner").data('bs.modal') || {})._isShown ){
        //     $('#txt_qrcode_scanner').focus();
        //     if( e.keyCode == 13 ){
        //       $('#mdl_qrcode_scanner').modal('hide');
        //       // alert($("#txt_qrcode_scanner").val());
        //       var formid = $("#mdl_qrcode_scanner").attr('data-formid');

        //       if ( ( formid ).indexOf('#') > -1){
        //         $( formid ).submit();
        //       }
        //       else{
        //         switch( formid ){
        //           case 'fn_scan_machine_code':
        //             var val = $('#txt_qrcode_scanner').val();
        //             if ($('#selAddMatProcMachine').find("option[data-code='" + val + "']").length) {
        //               $('#selAddMatProcMachine option[data-code="'+val+'"]').prop('selected', true).trigger('change');
        //             }
        //             else{
        //               $('#selAddMatProcMachine').val("").trigger('change');
        //               toastr.warning('Invalid Machine!');
        //             }
        //             $('#txt_qrcode_scanner').val("");
        //           break;

        //           case 'fn_scan_a_shift_user_code':
        //             var val = $('#txt_qrcode_scanner').val();

        //             if ($('#selAddMatProcAShiftManpower').find("option[data-code='" + val + "']").length) {
        //               $("#selAddMatProcAShiftManpower option[data-code="+val+"]").prop("selected", true).trigger("change");
        //             }
        //             else{
        //               toastr.warning('Invalid User!');
        //             }
        //             $('#txt_qrcode_scanner').val("0");
        //           break;

        //           case 'fn_scan_b_shift_user_code':
        //             var val = $('#txt_qrcode_scanner').val();

        //             if ($('#selAddMatProcBShiftManpower').find("option[data-code='" + val + "']").length) {
        //               $("#selAddMatProcBShiftManpower option[data-code="+val+"]").prop("selected", true).trigger("change");
        //             }
        //             else{
        //               toastr.warning('Invalid User!');
        //             }
        //             $('#txt_qrcode_scanner').val("0");
        //           break;

        //           default:
        //           break;
        //         }
        //       }
        //     }//key
        //   }
        // });

        $(document).on('click','#btnAddMatProcScanMachineCode',function(e){
          $('#txt_qrcode_scanner').val('');
          $('#mdl_qrcode_scanner').attr('data-formid','fn_scan_machine_code').modal('show');
        });

        $(document).on('click','#btnAddMatProcScanAShiftUserCode',function(e){
          $('#txt_qrcode_scanner').val('');
          $('#mdl_qrcode_scanner').attr('data-formid','fn_scan_a_shift_user_code').modal('show');
        });

        $(document).on('click','#btnAddMatProcScanBShiftUserCode',function(e){
          $('#txt_qrcode_scanner').val('');
          $('#mdl_qrcode_scanner').attr('data-formid','fn_scan_b_shift_user_code').modal('show');
        });

        $("#btnMaximizeColMatProc").click(function(){
          $("#colDevice").removeClass('col-md-6').addClass('col-md-2');
          $("#colMaterialProcess").removeClass('col-md-6').addClass('col-md-10');
          $(this).css({display: 'none'});
          $("#btnMinimizeColMatProc").css({display: 'block'});
        });

        $("#btnMinimizeColMatProc").click(function(){
          $("#colDevice").removeClass('col-md-2').addClass('col-md-6');
          $("#colMaterialProcess").removeClass('col-md-10').addClass('col-md-6');
          $(this).css({display: 'none'});
          $("#btnMaximizeColMatProc").css({display: 'block'});
        });



      });
  </script>
  @endsection
@endauth

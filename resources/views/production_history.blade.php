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
                                                    <input type="text" style="color:blue;" class="form-control" id="std_cycle_time" name="std_cycle_time" readonly>
                                                </div>
                                                <div class="col-sm-3">
                                                  <label>Maintenance Cycle:</label>
                                                    <input type="text" style="color:blue;" class="form-control" id="maintenance_cycle" name="maintenance_cycle" readonly>
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
                                                <tr style="text-align: center;">
                                                    <th rowspan="2">Action</th>
                                                    <th rowspan="2">Status</th>
                                                    <th rowspan="2">Production Date</th>
                                                    <th rowspan="2">Shift</th>
                                                    <th rowspan="2">Machine No.</th>
                                                    <th rowspan="2">Std Parameter Date</th>
                                                    <th rowspan="2">Shots</th>
                                                    <th rowspan="2">Shots Accum</th>
                                                    <th rowspan="2">Prod'n Start time</th>
                                                    <th rowspan="2">Prod'n End time</th>
                                                    <th rowspan="2">Act. Cycle Time</th>
                                                    <th rowspan="2">Shot Weight</th>
                                                    <th rowspan="2">Product Weight</th>
                                                    <th rowspan="2">Screw Most FWD</th>
                                                    <th colspan="3">CCD Setting</th>
                                                    <th rowspan="2">Changes Parameter</th>
                                                    <th rowspan="2">Remarks</th>
                                                    <th rowspan="2">Operator Name</th>
                                                    <th rowspan="2">Confirmed By</th>
                                                </tr>
                                                <tr>
                                                     <th>S1</th>
                                                     <th>S2</th>
                                                     <th>NG</th>
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

        <div class="modal fade" id="modalProductionHistory" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formProductionHistory" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6 border px-4">
                                    <div class="py-3">
                                        <span class="badge badge-secondary">1.</span> Production Details
                                    </div>
                                    <div class="input-group input-group-sm mb-3 d-none">
                                        <input class="form-control form-control-sm" type="text" id="global_device_name_id" name="global_device_name_id">
                                        <input class="form-control form-control-sm" type="text" id="prodn_history_id" name="prodn_history_id">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="device_name" name="device_name" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">STD Cycle Time</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="stdct" name="stdct" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Maintenance Cycle</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="main_cycle" name="main_cycle" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Production Date</span>
                                                </div>
                                                {{-- <input class="form-control form-control-sm" type="date" id="prodn_date" name="prodn_date" value="<?php echo date('Y-m-d'); ?>"> --}}
                                                <input class="form-control form-control-sm" type="date" id="prodn_date" name="prodn_date">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Production Start Time</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="time" id="prodn_stime" name="prodn_stime">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Shift</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="shift" name="shift" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Machine No.</span>
                                                </div>
                                                <select type="text" class="form-control form-control-sm select2bs4" id="machine_no" name="machine_no">
                                                </select>
                                                {{-- <input class="form-control form-control-sm" type="text" id="machine_no" name="machine_no" required readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="btnMachineNo" form-value="formMachineNo"><i class="fa fa-qrcode"></i></button>
                                                </div> --}}
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Standard Parameter Date</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="date" id="standard_para_date" name="standard_para_date">
                                            </div>
                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Standard Parameter Attachment</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="standard_para_attach" name="standard_para_attach">
                                            </div> --}}
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Actual Cycle Time</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="act_cycle_time" name="act_cycle_time" placeholder="s">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Shot Weight</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="shot_weight" name="shot_weight" placeholder="g">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Product Weight</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="product_weight" name="product_weight" placeholder="g">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Screw Most FWD</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="screw_most_fwd" name="screw_most_fwd" placeholder="mm">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">CCD Setting</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="ccd_setting_s1" name="ccd_setting_s1" placeholder="S1">
                                                <input class="form-control form-control-sm" type="text" id="ccd_setting_s2" name="ccd_setting_s2" placeholder="S2">
                                                <input class="form-control form-control-sm" type="text" id="ccd_setting_ng" name="ccd_setting_ng" placeholder="NG">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Changes in Parameters</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="changes_para" name="changes_para" placeholder="N/A">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                </div>
                                                <select class="form-control form-control-sm" id="remarks" name="remarks">
                                                    <option selected disabled>-- Select One --</option>
                                                    <option value="1">Continuous Production</option>
                                                    <option value="2">Temporary Stop</option>
                                                    <option value="3">Maintenance Cycle</option>
                                                    <option value="4">Die-set/Machine Repair</option>
                                                    <option value="5">Evaluation</option>
                                                    <option value="6">Finish PO</option>
                                                    <option value="7">Request for overhaul</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="opt_name" name="opt_name" readonly>
                                                <input class="form-control form-control-sm" type="text" id="opt_id" name="opt_id" readonly hidden>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="btnScanQrOptID" form-value="formOperatorName"><i class="fa fa-qrcode"></i></button>
                                                </div>
                                                {{-- <select name="opt_name[]" id="selOperator" class="form-control select2bs4 selOpName" multiple required>
                                                </select> --}}
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Shots</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="shots" name="shots">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Production End Time</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="time" id="prodn_etime" name="prodn_etime">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Confirm By</span>
                                                </div>
                                                <input class="form-control form-control-sm" type="text" id="qc_name" name="qc_name" placeholder="Tech/Engg" readonly>
                                                <input class="form-control form-control-sm" type="text" id="qc_id" name="qc_id" readonly hidden>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="btnScanQrQCID" form-value="formQCName"><i class="fa fa-qrcode"></i></button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 border px-4">
                                    <div class="col-sm-12">

                                        <div class="py-3">
                                            <span class="badge badge-secondary">2.</span> Materials
                                        </div>

                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                            </div>
                                            <input class="form-control form-control-sm" type="text" id="material_code" name="material_code" value="101862401" readonly>
                                            <input class="form-control form-control-sm" type="text" id="material_name" name="material_name" value="GENESTAR GN2450-1 BLK" readonly>
                                        </div>
                                        <div id="divMultipleMaterialLot">

                                        </div>
                                        {{-- <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-25">
                                                <span class="input-group-text w-100" id="basic-addon1">Material Lot No.</span>
                                            </div>
                                            <input class="form-control form-control-sm" type="text" id="material_lotno" name="material_lotno" readonly>
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-primary" id="btnScanQrMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                            </div>
                                        </div><br> --}}

                                        <input type="hidden" id="txtPMCat" name="pm_cat">
                                        <div class="py-3">
                                            <span class="badge badge-secondary">3.</span> Parts Materials
                                        </div>
                                        {{-- CN171S-08#IN-VE --}}

                                        <div class="row" id=divMaterialName>
                                            <input type="text" class="d-none" id="pmLot1Counter" value="0">
                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo1">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo1">Add</button>
                                            </div> --}}

                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name1</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode" type="text" id="pmaterial_code" name="pmaterial_code" value="108321601" readonly>
                                                <input class="form-control form-control-sm pmMatName" type="text" id="pmaterial_name" name="pmaterial_name" value="CT 6009-VE" readonly>
                                            </div>



                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.1</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum" type="text" id="pmat_lot_no_0" name="pmat_lot_no[]" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPMScanQR1" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo" disabled><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}
                                            <div id="divMultiplePartsLot1">

                                            </div>
                                        </div>

                                        {{-- CN171S-09R/10L#IN-VE --}}
                                        {{-- <div class="row" id=divMaterialName1>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name2</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode" type="text" id="pmaterial_code1" name="pmaterial_code1" value="108668401" readonly>
                                                <input class="form-control form-control-sm pmMatName" type="text" id="pmaterial_name1" name="pmaterial_name1" value="CT 6010R/L-VE" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.2</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum" type="text" id="pmat_lot_no1" name="pmat_lot_no1" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo" disabled><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div>
                                        </div> --}}

                                        {{-- CN171P-02#IN --}}
                                        <div class="row" id=divMaterialName2>
                                            <input type="text" class="d-none" id="pmLot2Counter" value="0">
                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo2_0">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo2_0">Add</button>
                                            </div> --}}
                                            <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name3</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode2" type="text" id="pmaterial_code2_0" name="pmaterial_code2_0" value="107977701" readonly>
                                                <input class="form-control form-control-sm pmMatName2" type="text" id="pmaterial_name2_0" name="pmaterial_name2_0" value="CT 5869-VE" readonly>
                                            </div>

                                            {{-- nmodify <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.0</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_0_0" name="pmat_lot_no2_0[]" data-ref="2_0" readonly>
                                                <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_prod_runcard-2_0_0" name="pmat_prod_runcard2_0[]" data-ref="2_0" disabled>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}
                                            <div id="divMultiplePartsLot2_0">

                                            </div>

                                            <input type="text" class="d-none" id="pmLot2_1Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo2_1">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo2_1">Add</button>
                                            </div> --}}

                                            <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name3</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode2" type="text" id="pmaterial_code2_1" name="pmaterial_code2_1" value="107977801" readonly>
                                                <input class="form-control form-control-sm pmMatName2" type="text" id="pmaterial_name2_1" name="pmaterial_name2_1" value="CT 5870-VE" readonly>
                                            </div>

                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.0</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_1_0" name="pmat_lot_no2_1[]"  data-ref="2_1" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}

                                            <div id="divMultiplePartsLot2_1">

                                            </div>

                                            <input type="text" class="d-none" id="pmLot2_2Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo2_2">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo2_2">Add</button>
                                            </div> --}}
                                            <div class="input-group input-group-sm mb-3 mt-3" >
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name3</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode2" type="text" id="pmaterial_code2_2" name="pmaterial_code2_2" value="107977901" readonly>
                                                <input class="form-control form-control-sm pmMatName2" type="text" id="pmaterial_name2_2" name="pmaterial_name2_2" value="CN171P-02#ME-VE" readonly>
                                            </div>

                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.0</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_2_0" name="pmat_lot_no2_2[]"  data-ref="2_2" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}

                                            <div id="divMultiplePartsLot2_2">

                                            </div>
                                        </div>

                                        {{-- * CN171P-07#IN --}}
                                        <div class="row" id=divMaterialName3>
                                            <input type="text" class="d-none" id="pmLot3Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo3_0">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo3_0">Add</button>
                                            </div> --}}
                                            <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode4" type="text" id="pmaterial_code3" name="pmaterial_code3_0" value="108666601" readonly>
                                                <input class="form-control form-control-sm pmMatName4" type="text" id="pmaterial_name3" name="pmaterial_name3_0" value="CN171S-08#IN-VE" readonly>
                                            </div>

                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum4" type="text" id="pmat_lot_no-3_0_0" name="pmat_lot_no3_0[]" data-ref="3" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}
                                            <div id="divMultiplePartsLot3">

                                            </div>

                                            <input type="text" class="d-none" id="pmLot3_1Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo3_1">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo3_1">Add</button>
                                            </div> --}}

                                            <div class="input-group input-group-sm mb-3 mt-3" >
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode4" type="text" id="pmaterial_code3_1" name="pmaterial_code3_1" value="107927202" readonly>
                                                <input class="form-control form-control-sm pmMatName4" type="text" id="pmaterial_name3_1" name="pmaterial_name3_1" value="CN171S-03#ME-VE" readonly>
                                            </div>


                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.0</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum4" type="text" id="pmat_lot_no-3_1_0" name="pmat_lot_no3_1[]" data-ref="3_1" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}
                                            <div id="divMultiplePartsLot3_1">

                                            </div>

                                            <input type="text" class="d-none" id="pmLot3_2Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo3_2">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo3_2">Add</button>
                                            </div> --}}

                                            <div class="input-group input-group-sm mb-3 mt-3" >
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode4" type="text" id="pmaterial_code3_2" name="pmaterial_code3_2" value="108032201" readonly>
                                                <input class="form-control form-control-sm pmMatName4" type="text" id="pmaterial_name3_2" name="pmaterial_name3_2" value="CN171S-05#ME-VE" readonly>
                                            </div>



                                            {{-- <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum4" type="text" id="pmat_lot_no-3_2_0" name="pmat_lot_no3_2[]" data-ref="3_2" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}

                                            <div id="divMultiplePartsLot3_2">

                                            </div>

                                            <input type="text" class="d-none" id="pmLot3_3Counter" value="0">

                                            {{-- <div class="d-flex justify-content-end mb-1 divBtnMultiples">
                                                <button type="button" class="btn btn-sm btn-danger d-none btnRemovePmLot" id="btnRemovePmLotNo3_3">Remove</button>
                                                <button type="button" class="btn btn-sm btn-success ml-1" id="btnAddPmLotNo3_3">Add</button>
                                            </div> --}}

                                            <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode4" type="text" id="pmaterial_code3_3" name="pmaterial_code3_3" value="xxx" readonly>
                                                <input class="form-control form-control-sm pmMatName4" type="text" id="pmaterial_name3_3" name="pmaterial_name3_3" value="CN171S-09/10#IN-VE" readonly>
                                            </div>


                                            {{-- <div class="input-group input-group-sm mb-3 mt-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.4</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum4" type="text" id="pmat_lot_no-3_3_0" name="pmat_lot_no3_3[]" data-ref="3_3" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div> --}}

                                            <div id="divMultiplePartsLot3_3">

                                            </div>

                                        </div>

                                         {{-- CN171S-02#MO-VE --}}
                                        {{-- <div class="row" id=divMaterialName4>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Name5</span>
                                                </div>
                                                <input class="form-control form-control-sm pmMatCode" type="text" id="pmaterial_code5" name="pmaterial_code5" value="107977401" readonly>
                                                <input class="form-control form-control-sm pmMatName" type="text" id="pmaterial_name5" name="pmaterial_name5" value="CN171S-04#ME-VE" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-25">
                                                    <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.5</span>
                                                </div>
                                                <input class="form-control form-control-sm pmLotNum" type="text" id="pmat_lot_no5" name="pmat_lot_no5" readonly>
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo" disabled><i class="fa fa-qrcode w-100"></i></button>
                                                </div>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" id="btnClose">Close</button>
                            <button type="button" id="btnSubmit" class="btn btn-primary"><i id="ibtnSubmitIcon" class="fa fa-check"></i> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalQrMachine" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrMachine" class="hidden_scanner_input" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan Machine #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalQrEmp" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrEmp" class="hidden_scanner_input" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan your ID
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAlert_notif" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="text-center text-secondary">
                        <div id="alert_notif"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalQrLotNo" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrLotNo" class="hidden_scanner_input" class="" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan the Material Lot #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalQrPLotNo" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrPLotNo" class="hidden_scanner_input" class="" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan the Parts Lot #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js_content')
    <script>
        let ProductionHistory;
        var first_molding_device_id;
        $(document).ready(function () { //nmodify GENESTAR GN2450-1 BLK
            const getFirstMoldingContactLotNumByDateMachineNum = function (prodnDate,machineNo,globalDeviceNameId,deviceName,pmCat){
                $.ajax({
                    type: "GET",
                    url: "get_first_molding_contact_lot_num_by_date_machine_num",
                    data: {
                        "prodn_date":prodnDate,
                        "machine_no":machineNo,
                        "global_device_name_id":globalDeviceNameId,
                        "device_name":deviceName,
                        "pm_cat":pmCat,
                    },
                    dataType: "json",
                    success: function (response) {
                        $(`#divMultiplePartsLot1`).empty();
                        $(`#divMultipleMaterialLot`).empty();
                        $(`#divMultiplePartsLot2_0`).empty();
                        $(`#divMultiplePartsLot2_1`).empty();
                        $(`#divMultiplePartsLot2_2`).empty();
                        if(pmCat == 1){
                            $.each(response.first_molding, function(index, data ) {
                                let  contact_lot_number = data['contact_lot_number'];
                                if(contact_lot_number =! null ){
                                    // divMultipleMaterialLot
                                    let result_material_lot =`
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-25">
                                                <span class="input-group-text w-100" id="basic-addon1">Material Lot No.${index}</span>
                                            </div>
                                            <input class="form-control form-control-sm" type="text" id="material_lotno_${index}" name="material_lotno[]" readonly>
                                        </div>
                                    `;
                                    $(`#divMultipleMaterialLot`).append(result_material_lot);
                                    let result_part_material_lot =
                                        `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot1_${index}">
                                            <div class="input-group-prepend w-25">
                                                <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${index}</span>
                                            </div>
                                            <input class="form-control form-control-sm pmLotNum2" type="hidden" id="firt_moldings_id_${index}" name="firt_moldings_id[]" readonly>
                                            <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no_${index}" name="pmat_lot_no[]" readonly>
                                            <input class="form-control form-control-sm pmLotNum2" type="text" id="prodn_runcard_${index}" name="prodn_runcard[]" readonly>
                                        </div>`;
                                    $(`#divMultiplePartsLot1`).append(result_part_material_lot);
                                    $(`#firt_moldings_id_${index}`).val(data['id']);
                                    $(`#pmat_lot_no_${index}`).val(data['contact_lot_number']);
                                    $(`#prodn_runcard_${index}`).val(data['production_lot']+data['production_lot_extension']);
                                    $(`#material_lotno_${index}`).val(data.first_molding_material_list.virgin_material);

                                }
                            });
                        }
                        if(pmCat == 2){
                            $.each(response.sec_molding_runcard, function(index, data) {
                                let  contact_name_lot_number_one = data['contact_name_lot_number_one'];
                                let  contact_name_lot_number_second = data['contact_name_lot_number_second'];
                                let  me_name_lot_number_one = data['me_name_lot_number_one'];
                                let result_material_lot =`
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100" id="basic-addon1">Material Lot No.${index}</span>
                                        </div>
                                        <input class="form-control form-control-sm" type="text" id="material_lotno_${index}" name="material_lotno[]" readonly>
                                    </div>
                                `;
                                $(`#divMultipleMaterialLot`).append(result_material_lot);
                                $(`#material_lotno_${index}`).val(data['material_lot_number']);
                                if(contact_name_lot_number_one =! null ){
                                    let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_${index}">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${index}</span>
                                        </div>
                                        <input class="form-control form-control-sm pmLotNum2" type="hidden" id="sec_molding_runcards_id-2_0_${index}" name="sec_molding_runcards_id2_0[]"  data-ref="2_0" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_0_${index}" name="pmat_lot_no2_0[]"  data-ref="2_0" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="prodn_runcard-2_0_${index}" name="prodn_runcard2_0[]"  data-ref="2_0" readonly>

                                    </div>`;
                                    $(`#divMultiplePartsLot2_0`).append(result);
                                    $(`#sec_molding_runcards_id-2_0_${index}`).val(data['id']);
                                    $(`#pmat_lot_no-2_0_${index}`).val(data['contact_name_lot_number_one']);
                                    $(`#prodn_runcard-2_0_${index}`).val(data['production_lot']);
                                }
                                if(contact_name_lot_number_second =! null ){
                                    let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_${index}">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${index}</span>
                                        </div>
                                        <input class="form-control form-control-sm pmLotNum2" type="hidden" id="sec_molding_runcards_id-2_1_${index}" name="sec_molding_runcards_id2_1[]"  data-ref="2_1" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_1_${index}" name="pmat_lot_no2_1[]"  data-ref="2_1" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="prodn_runcard-2_1_${index}" name="prodn_runcard2_1[]"  data-ref="2_1" readonly>
                                    </div>`;
                                    $(`#divMultiplePartsLot2_1`).append(result);
                                    $(`#sec_molding_runcards_id-2_1_${index}`).val(data['id']);
                                    $(`#pmat_lot_no-2_1_${index}`).val(data['contact_name_lot_number_second']);
                                    $(`#prodn_runcard-2_1_${index}`).val(data['production_lot']);
                                }
                                if(me_name_lot_number_one =! null ){
                                    let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_${index}">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${index}</span>
                                        </div>
                                        <input class="form-control form-control-sm pmLotNum2" type="hidden" id="sec_molding_runcards_id-2_2_${index}" name="sec_molding_runcards_id2_2[]"  data-ref="2_2" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_2_${index}" name="pmat_lot_no2_2[]"  data-ref="2_2" readonly>
                                        <input class="form-control form-control-sm pmLotNum2" type="text" id="prodn_runcard-2_2_${index}" name="prodn_runcard2_2[]"  data-ref="2_2" readonly>
                                    </div>`;
                                    $(`#divMultiplePartsLot2_2`).append(result);
                                    $(`#sec_molding_runcards_id-2_2_${index}`).val(data['id']);
                                    $(`#pmat_lot_no-2_2_${index}`).val(data['me_name_lot_number_one']);
                                    $(`#prodn_runcard-2_2_${index}`).val(data['production_lot']);
                                }
                            });
                        }
                        if(pmCat == 3){
                            alert('C171S Part Material Not Found!') //TODO: Ongoing Development
                        }
                    },error: function(data, xhr, status){
                        toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
                });
            }
            $('#formProductionHistory').find('#prodn_date').change(function (e) {
                e.preventDefault();
                let prodnDate = $(this).val();
                let machineNo = $('#formProductionHistory').find('#machine_no').val();
                let globalDeviceNameId = $('#formProductionHistory').find('#global_device_name_id').val();
                let deviceName = $('#formProductionHistory').find('#device_name').val();
                let pmCat = $('#formProductionHistory').find('#txtPMCat').val();

                getFirstMoldingContactLotNumByDateMachineNum(prodnDate,machineNo,globalDeviceNameId,deviceName,pmCat);
            });

            $('#formProductionHistory').find('#machine_no').change(function (e) {
                e.preventDefault();
                let prodnDate = $('#formProductionHistory').find('#prodn_date').val();
                // let machineNo = $('#formProductionHistory').find('#machine_no').val();
                let machineNo = $(this).val();
                let globalDeviceNameId = $('#formProductionHistory').find('#global_device_name_id').val();
                let deviceName = $('#formProductionHistory').find('#device_name').val();
                let pmCat = $('#formProductionHistory').find('#txtPMCat').val();
                getFirstMoldingContactLotNumByDateMachineNum(prodnDate,machineNo,globalDeviceNameId,deviceName,pmCat);
            });

            // getFirstModlingDevices();
            getFirstModlingDevicesForHistory();
            // getOperatorList($('.selOpName'));
            // getMaterialList($('.selMatName'));

            function number_with_comma(val) {
                if (val == null || val == NaN) {
                    return 0;
                }
                while (/(\d+)(\d{3})/.test(val.toString())) {
                    val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
                }
                return val;
            }
            var formModal = {
                ProdnHistory: $("#formProductionHistory"),
            }

            $('#global_device_name').change(function (e) {
                e.preventDefault();
                getFirstMoldingDeviceById($(this).val());
            });

            $('#btnAddProductionHistory').click(function (e) {
                e.preventDefault();
                let materialName= $('#device_name').val();
                console.log(materialName);

                $("#prodn_stime").val('');
                $("#machine_no").val('');
                $("#standard_para_date").val('');
                $("#standard_para_attach").val('');
                $("#act_cycle_time").val('');
                $("#shot_weight").val('');
                $("#product_weight").val('');
                $("#screw_most_fwd").val('');
                $("#ccd_setting_s1").val('');
                $("#ccd_setting_s2").val('');
                $("#ccd_setting_ng").val('');
                $("#changes_para").val('');
                $("#remarks").val('');
                $("#opt_id").val('');
                $("#opt_name").val('');
                $("#opt_name").val('');

                $('#modalProductionHistory').modal('show');

                $time_now = moment().format('HH:mm:ss');
                console.log($time_now);
                if ($time_now >= '7:30:00' || $time_now <= '19:29:00') {
                    $('#shift').val('A');
                }else {
                    $('#shift').val('B');
                }

                getMachineDropdown($('#machine_no'), materialName);

            });

            /*  Datatable */
            ProductionHistory = $("#tblProductionHistoryDetails").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "load_prodn_history_details",
                    data: function (param){
                        param.first_molding_device_id = $("#global_device_name").val();
                    }
                },
                fixedHeader: true,
                "columns":[
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "status" },
                    { "data" : "prodn_date" },
                    { "data" : "shift" },
                    { "data" : "machine_no" },
                    { "data" : "standard_para_date" },
                    { "data" : "shots" },
                    { "data" : "shots_accum" },
                    { "data" : "prodn_stime" },
                    { "data" : "prodn_etime" },
                    { "data" : "act_cycle_time" },
                    { "data" : "shot_weight" },
                    { "data" : "product_weight" },
                    { "data" : "screw_most_fwd" },
                    { "data" : "ccd_setting_s1" },
                    { "data" : "ccd_setting_s2" },
                    { "data" : "ccd_setting_ng" },
                    { "data" : "changes_para" },
                    { "data" : "remarks" },
                    { "data" : "operator" },
                    { "data" : "qc" },
                ]
            });

            /* Add */
            $("#btnSubmit").on('click', function(event){
                event.preventDefault();
                AddProdnHistory();
            });

            // $('#formProductionHistory').submit(function(e){
            //     e.preventDefault();
            //     $.ajax({
            //         type: "post",
            //         url: "add_prodn_history",
            //         data: $('#formProductionHistory').serialize(),
            //         dataType: "json",
            //         success: function (response) {
            //             if(response['result'] == 1){
            //                 ProductionHistory.draw();
            //                 $('#modalProductionHistory').modal('hide');
            //             }
            //         }
            //     });
            // });

            /* Edit */
            $(document).on('click', '.btnEdit', function(e){
                let pId = $(this).data('id');
                let btnFunction = $(this).data('function');
                // $.ajax({
                //     type: "get",
                //     url: "get_prodn_history_by_id",
                //     data: {
                //         "id" : pId
                //     },
                //     dataType: "json",
                //     success: function (data) {

                //         $('#prodn_history_id').val(pId);
                //         $('#prodn_date').val(data['prodn_date']);
                //         $('#prodn_stime').val(data['prodn_stime']);
                //         $('#shift').val(data['shift']);
                //         $('#machine_no').val(data['machine_no']);
                //         $('#standard_para_date').val(data['standard_para_date']);
                //         $('#standard_para_attach').val(data['standard_para_attach']);
                //         $('#act_cycle_time').val(data['act_cycle_time']);
                //         $('#shot_weight').val(data['shot_weight']);
                //         $('#product_weight').val(data['product_weight']);
                //         $('#screw_most_fwd').val(data['screw_most_fwd']);
                //         $('#ccd_setting_s1').val(data['ccd_setting_s1']);
                //         $('#ccd_setting_s2').val(data['ccd_setting_s2']);
                //         $('#ccd_setting_ng').val(data['ccd_setting_ng']);
                //         $('#changes_para').val(data['changes_para']);
                //         $("#remarks").val(data['remarks']).trigger('change');
                //         $('#opt_name').val(data['operator_info']['firstname']+' '+data['operator_info']['lastname']);
                //         $('#opt_id').val(data['opt_id']);

                //         if (data['qc_info'] != null){
                //             $('#qc_name').val(data['qc_info']['firstname']+' '+data['qc_info']['lastname']);
                //         }else{
                //             $('#qc_name').val('');
                //         }
                //         $('#qc_id').val(data['qc_id']);

                //         $('#shots').val(data['shots']);
                //         $('#prodn_etime').val(data['prodn_etime']);

                //         $('#shots').prop('readonly',false);
                //         $('#prodn_etime').prop('readonly',false);

                //         $('#btnScanQrQCID').prop('disabled',false);
                //         $('#btnScanQrMaterialLotNo').prop('disabled',false);
                //         $('#btnScanQrPMaterialLotNo').prop('disabled',false);

                //         $('#modalProductionHistory').modal('show');

                //     }
                // });
                let pmCat = $('#formProductionHistory').find('#txtPMCat').val();

                getProdHistoryById(pId, btnFunction,pmCat);
            });

            $(document).on('click', '.btnView', function(e){
                let pId = $(this).data('id');
                let btnFunction = $(this).data('function');
                let pmCat = $('#formProductionHistory').find('#txtPMCat').val();

                getProdHistoryById(pId, btnFunction, first_molding_device_id,pmCat);

            })

            /* QR Code Scanner */
            /* Machine No. */
            $('#btnMachineNo').each(function(e){
                $(this).on('click',function (e) {
                    let formValue = $(this).attr('form-value');
                    $('#modalQrMachine').attr('data-form-id', formValue).modal('show');
                    $('#textQrMachine').val('');
                    setTimeout(() => {
                        $('#textQrMachine').focus();
                    }, 500);
                });
            });

            $('#textQrMachine').keyup(delay(function(e){
                    let qrScannerValue = $('#textQrMachine').val();
                    let formId = $('#modalQrMachine').attr('data-form-id');
                    if( e.keyCode == 13 ){
                        $('#textQrMachine').val(''); // Clear after enter
                        switch (formId) {
                            case 'formMachineNo':
                                if(qrScannerValue != ''){
                                    $('#machine_no').val(qrScannerValue);
                                }else{
                                    $('#machine_no').val('N/A');
                                    toastr.error('Please scan Machine Number.')
                                }
                                $('#modalQrMachine').modal('hide');
                                break;
                        }

                    }
                }, 100));

                $('#btnMachineNo').each(function(e){
                $(this).on('click',function (e) {
                    let formValue = $(this).attr('form-value');
                    $('#modalQrMachine').attr('data-form-id', formValue).modal('show');
                    $('#textQrMachine').val('');
                    setTimeout(() => {
                        $('#textQrMachine').focus();
                    }, 500);
                });
            });

            /*  Opt/QC Name */
            $('#btnScanQrOptID').each(function(e){
                $(this).on('click',function (e) {
                    let formValue = $(this).attr('form-value');
                    $('#modalQrEmp').attr('data-form-id', formValue).modal('show');
                    $('#textQrEmp').val('');
                    setTimeout(() => {
                        $('#textQrEmp').focus();
                    }, 500);
                });
            });

            $('#btnScanQrQCID').each(function(e){
                $(this).on('click',function (e) {
                    let formValue = $(this).attr('form-value');
                    $('#modalQrEmp').attr('data-form-id', formValue).modal('show');
                    $('#textQrEmp').val('');
                    setTimeout(() => {
                        $('#textQrEmp').focus();
                    }, 500);
                });
            });

            $('#textQrEmp').keyup(delay(function(e){
                let qrScannerValue = $('#textQrEmp').val();
                let formId = $('#modalQrEmp').attr('data-form-id');
                if( e.keyCode == 13 ){
                    $('#textQrEmp').val(''); // Clear after enter
                    switch (formId) {
                        case 'formOperatorName':
                            $.ajax({
                                url: "get_user_by_en",
                                method: "get",
                                data: {
                                    employee_id: qrScannerValue
                                },
                                dataType: "json",
                                beforeSend: function(){

                                },
                                success: function(data){
                                    console.log(data)
                                    if(data['users'] != null){
                                        if(data['users']['position'] == 0 || data['users']['position'] == 4){
                                            $('input[name="opt_name"]', $("#formProductionHistory")).val(data['users']['firstname']+' '+data['users']['lastname']);
                                            $('input[name="opt_id"]', $("#formProductionHistory")).val(data['users']['id']);
                                            $('#modalQrEmp').modal('hide');
                                        }else{
                                            $('input[name="opt_name"]', $("#formProductionHistory")).val('');
                                            $('input[name="opt_id"]', $("#formProductionHistory")).val('');
                                            let notif_alert = `<p style="font-size:30px; color:red;"><i class="fa fa-exclamation-triangle text-danger"></i> OPERATOR not found, Please check!</p>`;
                                            $('#alert_notif').html(notif_alert);
                                            $('#modalAlert_notif').modal('show');
                                            $('#modalQrEmp').modal('hide');
                                        }
                                    }
                                },
                                error: function(data, xhr, status){
                                    toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                                }
                            });
                            break;
                        case 'formQCName':
                            $.ajax({
                                url: "get_user_by_en",
                                method: "get",
                                data: {
                                    employee_id: qrScannerValue
                                },
                                dataType: "json",
                                beforeSend: function(){

                                },
                                success: function(data){
                                    console.log(data)
                                    if(data['users'] != null){
                                        if(data['users']['position'] == 0 || data['users']['position'] == 9 || data['users']['position'] == 11){
                                            $('input[name="qc_name"]', $("#formProductionHistory")).val(data['users']['firstname']+' '+data['users']['lastname']);
                                            $('input[name="qc_id"]', $("#formProductionHistory")).val(data['users']['id']);
                                            $('#modalQrEmp').modal('hide');
                                        }else{
                                            $('input[name="qc_name"]', $("#formProductionHistory")).val('');
                                            $('input[name="qc_id"]', $("#formProductionHistory")).val('');
                                            let notif_alert = `<p style="font-size:30px; color:red;"><i class="fa fa-exclamation-triangle text-danger"></i> Technician / Engg not found, Please Check!</p>`;
                                            $('#alert_notif').html(notif_alert);
                                            $('#modalAlert_notif').modal('show');
                                            $('#modalQrEmp').modal('hide');
                                        }
                                    }
                                },
                                error: function(data, xhr, status){
                                    toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                                }
                            });
                            break;
                    }


                }
            }, 100));

            /* Material Lot */
            $('#btnScanQrMaterialLotNo').each(function(e){
                $(this).on('click',function (e) {
                    let formValue = $(this).attr('form-value');
                    $('#modalQrLotNo').attr('data-form-id', formValue).modal('show');
                    $('#textQrLotNo').val('');
                    setTimeout(() => {
                        $('#textQrLotNo').focus();
                    }, 500);
                });
            });

            $('#textQrLotNo').on('keyup', function(e){
                if(e.keyCode == 13){
                    let expMaterial = $(this).val().split(' | ');
                    console.log(expMaterial);
                    if(expMaterial.length != 4){
                        toastr.error('Invalid Sticker');
                        $(this).val('');
                        $('#modalQrLotNo').modal('hide');
                        return;
                    }
                    $material_code = $('#material_code').val();
                    $material_name = $('#material_name').val();

                    if (material_code == expMaterial[2] || $material_name == expMaterial[3]){
                        $('#material_lotno').val(expMaterial[0]);
                    }else{
                        let notif_alert = `<p style="font-size:30px; color:red;"><i class="fa fa-exclamation-triangle text-danger"></i> Invalid Material Lot Number, Please check!</p>`;
                        $('#alert_notif').html(notif_alert);
                        $('#modalAlert_notif').modal('show');
                        $('#modalQrLotNo').modal('hide');
                    }


                    $(this).val('');
                    $('#modalQrLotNo').modal('hide');
                }
            });

            // $('.btnPMScanQR1').each(function(e){
            // // $('.btnPMScanQR1').on('click', function(e){
            //     $(this).on('click',function (e) {
            //         let formValue = $(this).attr('form-value');
            //         $('#modalQrPLotNo').attr('data-form-id', formValue).modal('show');
            //         $('#modalQrPLotNo').val('');
            //         setTimeout(() => {
            //             $('#textQrPLotNo').focus();
            //         }, 500);
            //     });
            // });
            var scanningInput = null;
            $(document).on('click', '.btnPMScanQR1', function(e){
                e.preventDefault();
                let formValue = $(this).attr('form-value');
                $('#modalQrPLotNo').attr('data-form-id', formValue).modal('show');
                scanningInput = $(this).offsetParent().find('.pmLotNum').attr('id');

                $('#modalQrPLotNo').val('');
                setTimeout(() => {
                    $('#textQrPLotNo').focus();
                }, 500);
            })

            var otherScanningInputId = null;
            var otherScanningInputData;
            $(document).on('click','.btnPmScan', function(e){
                let formValue = $(this).attr('form-value');
                $('#modalQrPLotNo').attr('data-form-id', formValue).modal('show');
                $('#modalQrPLotNo').val('');
                setTimeout(() => {
                    $('#textQrPLotNo').focus();
                }, 500);
                otherScanningInputId = $(this).offsetParent().find('.pmLotNum2').attr('id');
                otherScanningInputData = $(this).offsetParent().find('.pmLotNum2').data('ref');
                if(otherScanningInputId == undefined){
                    otherScanningInputId = $(this).offsetParent().find('.pmLotNum4').attr('id');
                    otherScanningInputData = $(this).offsetParent().find('.pmLotNum4').data('ref');

                }
                // $(this).offsetParent().find('#pmat_lot_no2').attr('id');
                console.log('otherScanningInputId', otherScanningInputId);
            });

            $('#textQrPLotNo').on('keyup', function(e){
                if(e.keyCode == 13){
                    try{
                        scannedItem = JSON.parse($(this).val());
                        console.log(scannedItem)

                        // if ( $('#pmaterial_code1').val() == scannedItem['code'] || $('#pmaterial_name1').val() == scannedItem['name']){
                        //     $('#pmat_lot_no1').val(scannedItem['production_lot_no']);
                        //     $('#modalQrLotNo').modal('hide');
                        // }
                        if(otherScanningInputId != null){
                            // let splittedData = otherScanningInputData.split("-");

                            console.log('scanning input', otherScanningInputData);

                            // return;
                            let code = $(`#pmaterial_code${otherScanningInputData}`).val();
                            let name = $(`#pmaterial_name${otherScanningInputData}`).val();

                            console.log('if code ref for scan: ', code);
                            console.log('if name ref for scan: ', name);
                            if(code == scannedItem['code'] && name == scannedItem['name']){
                                console.log('input here ',otherScanningInputId);
                                // console.log();
                                $(`#${otherScanningInputId}`).val(scannedItem['production_lot_no'])
                            }
                            else{
                                let notif_alert = `<p style="font-size:30px; color:red;"><i class="fa fa-exclamation-triangle text-danger"></i> Invalid Parts Material Lot Number, Please check!</p>`;
                                $('#alert_notif').html(notif_alert);
                                $('#modalAlert_notif').modal('show');
                                $('#modalQrLotNo').modal('hide');
                            }
                        }
                        else if ( $('#pmaterial_code').val() == scannedItem['code'] && $('#pmaterial_name').val() == scannedItem['name']){
                            console.log('code ref for scan: ',  $('#pmaterial_code').val());
                            console.log('name ref for scan: ',  $('#pmaterial_name').val());
                            // console.log('else if');

                            $(`#${scanningInput}`).val(scannedItem['production_lot_no']);
                            // $('#modalQrLotNo').modal('hide');
                        }
                        else{
                            let notif_alert = `<p style="font-size:30px; color:red;"><i class="fa fa-exclamation-triangle text-danger"></i> Invalid Parts Material Lot Number, Please check!</p>`;
                            $('#alert_notif').html(notif_alert);
                            $('#modalAlert_notif').modal('show');
                            $('#modalQrLotNo').modal('hide');
                        }
                    }
                    catch (e){
                        toastr.error('Invalid Sticker');
                    }
                    otherScanningInputId = null;
                    otherScanningInputData= "";
                    $(this).val('');
                    $('#modalQrPLotNo').modal('hide');

                }
            });

            $('#btnAddPmLotNo1').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot1Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo1').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot1_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum" type="text" id="pmat_lot_no_${counter}" name="pmat_lot_no[]" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPMScanQR1" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot1Counter').val(counter);

                $('#divMultiplePartsLot1').append(result);

            });

            $('#btnRemovePmLotNo1').on('click', function(e){ //btnRemovePmLotNo2_0
                e.preventDefault();
                let counter = $('#pmLot1Counter').val();

                $(`#multiplePmLot1_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot1Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo1').addClass('d-none');
                }

            })

            /*
                * START OF MULTIPLE PM LOT FOR CN171P-02#IN-VE
            */
            $('#btnAddPmLotNo2_0').on('click', function(e){ //nmodify
                e.preventDefault();
                let counter = $('#pmLot2Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo2_0').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_0_${counter}" name="pmat_lot_no2_0[]"  data-ref="2_0" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot2Counter').val(counter);

                $('#divMultiplePartsLot2_0').append(result);
            });

            $('#btnRemovePmLotNo2_0').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot2Counter').val();

                $(`#multiplePmLot2_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot2Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo2_0').addClass('d-none');
                }

            })

            $('#btnAddPmLotNo2_1').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot2_1Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo2_1').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_1_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_1_${counter}" name="pmat_lot_no2_1[]" data-ref="2_1" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot2_1Counter').val(counter);

                $('#divMultiplePartsLot2_1').append(result);

            });

            $('#btnRemovePmLotNo2_1').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot2_1Counter').val();

                $(`#multiplePmLot2_1_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot2_1Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo2_1').addClass('d-none');
                }
            })


            $('#btnAddPmLotNo2_2').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot2_2Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo2_2').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot2_2_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-2_2_${counter}" name="pmat_lot_no2_2[]" data-ref="2_2" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot2_2Counter').val(counter);

                $('#divMultiplePartsLot2_2').append(result);

            });
            $('#btnRemovePmLotNo2_2').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot2_2Counter').val();

                $(`#multiplePmLot2_2_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot2_2Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo2_2').addClass('d-none');
                }
            })
            /*
                * END OF MULTIPLE PM LOT FOR CN171P-02#IN-VE
            */

            /*
                * START OF MULTIPLE PM LOT FOR CN171S-07#IN-VE
            */
            $('#btnAddPmLotNo3_0').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo3_0').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot3_0_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-3_0_${counter}" name="pmat_lot_no3_0[]" data-ref="3" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot3Counter').val(counter);

                $('#divMultiplePartsLot3').append(result);

            });
            $('#btnRemovePmLotNo3_0').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3Counter').val();

                $(`#multiplePmLot3_0_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot3Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo3_0').addClass('d-none');
                }
            })

            $('#btnAddPmLotNo3_1').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_1Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo3_1').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot3_1_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-3_1_${counter}" name="pmat_lot_no3_1[]" data-ref="3_1" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot3_1Counter').val(counter);

                $('#divMultiplePartsLot3_1').append(result);

            });
            $('#btnRemovePmLotNo3_1').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_1Counter').val();

                $(`#multiplePmLot3_1_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot3_1Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo3_1').addClass('d-none');
                }
            })

            $('#btnAddPmLotNo3_2').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_2Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo3_2').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot3_2_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-3_2_${counter}" name="pmat_lot_no3_2[]" data-ref="3_2" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot3_2Counter').val(counter);

                $('#divMultiplePartsLot3_2').append(result);

            });
            $('#btnRemovePmLotNo3_2').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_2Counter').val();

                $(`#multiplePmLot3_2_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot3_2Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo3_2').addClass('d-none');
                }
            })


            $('#btnAddPmLotNo3_3').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_3Counter').val();
                counter = Number(counter) + 1;
                $('#btnRemovePmLotNo3_3').removeClass('d-none');
                let result = `<div class="input-group input-group-sm mb-3 multiplePMLotDiv" id="multiplePmLot3_3_${counter}">
                    {{-- <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking"> --}}

                    <div class="input-group-prepend w-25">
                        <span class="input-group-text w-100" id="basic-addon1"> Parts Material Lot No.${counter}</span>
                    </div>
                    <input class="form-control form-control-sm pmLotNum2" type="text" id="pmat_lot_no-3_3_${counter}" name="pmat_lot_no3_3[]" data-ref="3_3" readonly>
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-primary btnPmScan" id="btnScanQrPMaterialLotNo" form-value="formMaterialLotNo"><i class="fa fa-qrcode w-100"></i></button>
                    </div>
                </div>`;

                $('#pmLot3_3Counter').val(counter);

                $('#divMultiplePartsLot3_3').append(result);

            });
            $('#btnRemovePmLotNo3_3').on('click', function(e){
                e.preventDefault();
                let counter = $('#pmLot3_3Counter').val();

                $(`#multiplePmLot3_3_${counter}`).remove();
                counter = Number(counter) - 1;
                $('#pmLot3_3Counter').val(counter);

                if(counter == 0){
                    $('#btnRemovePmLotNo3_3').addClass('d-none');
                }
            })

            /*
                * END OF MULTIPLE PM LOT FOR CN171S-07#IN-VE
            */
            $("#modalProductionHistory").on('hidden.bs.modal', function () {
                console.log('hidden.bs.modal');
                $('.multiplePMLotDiv').remove();
                $('#formProductionHistory')[0].reset();
                $('.btnRemovePmLot').addClass('d-none');
                $('#btnSubmit',  $('#formProductionHistory')).show();
                getFirstMoldingDeviceById($('#global_device_name').val())

                $('#prodn_stime', $('#formProductionHistory')).prop('readonly', false);
                $('#standard_para_date', $('#formProductionHistory')).prop('readonly', false);
                $('#act_cycle_time', $('#formProductionHistory')).prop('readonly', false);
                $('#shot_weight', $('#formProductionHistory')).prop('readonly', false);
                $('#product_weight', $('#formProductionHistory')).prop('readonly', false);
                $('#screw_most_fwd', $('#formProductionHistory')).prop('readonly', false);
                $('#ccd_setting_s1', $('#formProductionHistory')).prop('readonly', false);
                $('#ccd_setting_s2', $('#formProductionHistory')).prop('readonly', false);
                $('#ccd_setting_ng', $('#formProductionHistory')).prop('readonly', false);
                $('#changes_para', $('#formProductionHistory')).prop('readonly', false);
                $('#shots', $('#formProductionHistory')).prop('readonly', false);
                $('#remarks', $('#formProductionHistory')).prop('readonly', false);
                $('#machine_no', $('#formProductionHistory')).prop('readonly', false);
                $('#prodn_etime', $('#formProductionHistory')).prop('readonly', false);
                $('#btnScanQrMaterialLotNo', $('#formProductionHistory')).prop('readonly', false);
                $('#btnScanQrPMaterialLotNo', $('#formProductionHistory')).prop('disabled', false);
                $('.divBtnMultiples').attr('style', '');
                $(`#divMultiplePartsLot1`).empty();
                $(`#divMultipleMaterialLot`).empty();
                $(`#divMultiplePartsLot2_0`).empty();
                $(`#divMultiplePartsLot2_1`).empty();
                $(`#divMultiplePartsLot2_2`).empty(); //shift
            });

            const getFirstMoldingDeviceById = (firstMoldingDeviceId) => {
                $.ajax({
                    type: "GET",
                    url: "get_first_molding_devices_by_id",
                    data: {
                        "first_molding_device_id": firstMoldingDeviceId
                    },
                    dataType: "json",
                    success: function (response) {
                        first_molding_device_id = response[0].id
                        let std_cycle_time = response[0].std_cycle_time
                        let maintenance_cycle = response[0].maintenance_cycle
                        let device_name = response[0].device_name
                        let materialNameSubstring = device_name.substring(0, 12);
                        console.log(materialNameSubstring)

                        $('#btnAddProductionHistory').prop('disabled', false);
                        $('#std_cycle_time').val(std_cycle_time);
                        $('#maintenance_cycle').val(number_with_comma(maintenance_cycle));

                        $('#stdct').val(std_cycle_time);
                        $('#main_cycle').val(maintenance_cycle);
                        $('#device_name').val(device_name);
                        $('#global_device_name_id').val(first_molding_device_id);

                        formModal.ProdnHistory.find('#first_molding_device_id').html(`<option value="${first_molding_device_id}">${device_name}</option>`);
                        formModal.ProdnHistory.find('#std_cycle_time').val(std_cycle_time);
                        formModal.ProdnHistory.find('#maintenance_cycle').val(number_with_comma(maintenance_cycle));

                        ProductionHistory.draw();
                        console.log($("#global_device_name").val())

                        $('#divMaterialName').addClass('d-none');
                        $('#divMaterialName2').addClass('d-none');
                        $('#divMaterialName3').addClass('d-none');

                        if (first_molding_device_id == 1) {
                            $('#txtPMCat').val(1);
                            console.log('pmaterial_code ', "108321601");
                            console.log('pmaterial_name ', "CT 6009-VE");

                            $('#divMaterialName').removeClass('d-none');
                            $('#pmaterial_code').val('108321601')
                            $('#pmaterial_name').val('CT 6009-VE')

                        } else if (first_molding_device_id == 2 || first_molding_device_id == 3) {
                            $('#txtPMCat').val(1);

                            console.log('pmaterial_code ', "108668401");
                            console.log('pmaterial_name ', "CT 6010R/L-VE");

                            $('#divMaterialName').removeClass('d-none');

                            $('#pmaterial_code').val('108668401')
                            $('#pmaterial_name').val('CT 6010R/L-VE')
                        } else if (first_molding_device_id == 4) { // CN171P-02#IN-VE
                            $('#txtPMCat').val(2);

                            console.log('remove class d-none of: ', "$('#divMaterialName2')");
                            $('#divMaterialName2').removeClass('d-none');
                        } else if (first_molding_device_id == 5) { //CN171S-07#IN
                            $('#txtPMCat').val(3);

                            console.log('remove class d-none of: ', "$('#divMaterialName3')");

                            $('#divMaterialName3').removeClass('d-none');
                        } else if (first_molding_device_id == 6) {
                            $('#txtPMCat').val(1);

                            console.log('pmaterial_code ', "107977401");
                            console.log('pmaterial_name ', "CN171S-04#ME-VE");

                            $('#divMaterialName').removeClass('d-none');
                            $('#pmaterial_code').val('107977401')
                            $('#pmaterial_name').val('CN171S-04#ME-VE')
                        }
                    }
                });
            }
        });





    </script>
    @endsection
@endauth

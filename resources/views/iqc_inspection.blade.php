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
                            <h1>IQC Inspection</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">IQC Inspection</li>
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
                                    <h3 class="card-title">IQC Inspection Table</h3>
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

                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalAddProcess" id="btnShowAddDevic"><i
                                                class="fa fa-initial-icon"></i> Add Device
                                        </button> --}}
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblIqcInspection" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th><center><i  class="fa fa-cog"></i></center></th>
                                                    <th>Status</th>
                                                    {{-- <th>Date Inspected</th> --}}
                                                    {{-- <th>Time Inspected</th> --}}
                                                    {{-- <th>App Ctrl No.</th> --}}
                                                    <th>Invoice No.</th>
                                                    {{-- <th>Classification</th> --}}
                                                    {{-- <th>Family</th> --}}
                                                    {{-- <th>Category</th> --}}
                                                    <th>Supplier</th>
                                                    <th>Part Code</th>
                                                    <th>Part Name</th>
                                                    <th>Lot No.</th>
                                                    {{-- <th>Lot Qty.</th> --}}
                                                    {{-- <th>Total Lot Size</th> --}}
                                                    {{-- <th>AQL</th> --}}
                                                    <th>Date Created</th>
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
        <div class="modal fade" id="modalSaveIqcInspection" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> IQC Inspection</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formSaveIqcInspection" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">WHS ID</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="whs_transaction_id" name="whs_transaction_id">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">IQC Inspection ID</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="iqc_inspection_id" name="iqc_inspection_id">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="Visual Inspection">
                                <div class="row">
                                    <hr>
                                    <div class="col-sm-12">
                                        <strong>Visual Inspection</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Invoice No.</span>
                                        </div>
                                            {{-- <input type="text" class="form-control form-control-sm" id="txtInput" name="input" min="0" value="0"> --}}
                                        <input type="text" class="form-control form-control-sm" id="invoice_no" name="invoice_no" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Part Code</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="partcode" name="partcode" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Part Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="partname" name="partname" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Supplier</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="supplier" name="supplier" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Family</span>
                                        </div>
                                        <select class="form-select form-control" id="family" name="family">
                                            {{-- <option value="" selected disabled>-Select-</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Application Ctrl. No.</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="app_no" name="app_no">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Die No.</span>
                                        </div>
                                        {{-- <input type="text" class="form-control form-control-sm" id="die_no" name="die_no"> --}}
                                        <select class="form-select form-control-sm" id="die_no" name="die_no">

                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Quantity</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="total_lot_qty" name="total_lot_qty">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot No.</span>
                                        </div>
                                        <button type="button" class="form-control form-control-sm bg-info" id="btnLotNo">Lot Number</button>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Inspection Classification</span>
                                        </div>
                                        <!--NOTE: Get all classification in Rapid/Warehouse Transaction, this field must be the same-->
                                        <select class="form-select form-control-sm" id="classification" name="classification">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">PPS-Molding Plastic Resin</option>
                                            <option value="2">PPS-Molding Metal Parts</option>
                                            <option value="3">For grinding</option>
                                            <option value="4">PPS-Stamping</option>
                                            <option value="5">YEC - Stock</option>
                                        </select>
                                        {{-- <select class="form-select form-control-sm" id="classification" name="classification"></select> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt" id="Sampling Plan">
                                <div class="row">
                                    <hr>
                                    <div class="col-sm-12">
                                        <strong>Sampling Plan</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Type of Inspection</span>
                                        </div>
                                            {{-- <input type="text" class="form-control form-control-sm" id="txtInput" name="input" min="0" value="0"> --}}
                                            <select class="form-select form-control-sm" id="type_of_inspection" name="type_of_inspection">
                                                <option value="" selected disabled>-Select-</option>
                                                <option value="1">Single</option>
                                                <option value="2">Double</option>
                                                <option value="3">Label Check</option>
                                            </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Severity of Inspection</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="severity_of_inspection" name="severity_of_inspection">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">Normal</option>
                                            <option value="2">Tightened</option>
                                            <option value="3">Label Check</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Inspection Level</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="inspection_lvl" name="inspection_lvl"></select>

                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">AQL</span>
                                        </div>
                                            {{-- <input type="text" class="form-control form-control-sm" id="txtInput" name="input" min="0" value="0"> --}}
                                        <select class="form-select form-control-sm" id="aql" name="aql"></select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Accept</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="accept" name="accept">

                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Reject</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="reject" name="reject">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt" id="Sampling Plan">
                                <div class="row">
                                    <hr>
                                    <div class="col-sm-12">
                                        <strong>Visual Inspection Result</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date Inspected</span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="date_inspected" name="date_inspected">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Shift</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="shift" name="shift">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100" id="basic-addon1">Time Inspected</span>
                                        </div>
                                        <input type="time" class="form-control form-control-sm" id="time_ins_from" name="time_ins_from">
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100" id="basic-addon1">-</span>
                                        </div>
                                        <input type="time" class="form-control form-control-sm" id="time_ins_to" name="time_ins_to">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Inspector</span>
                                        </div>
                                        <select class="form-select" name="inspector" id="inspector">
                                            <option value="{{ Auth::user()->username }}">{{Auth::user()->firstname.' '.Auth::user()->lastname}}</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Submission</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="submission" name="submission">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">1st</option>
                                            <option value="2">2nd</option>
                                            <option value="3">3rd</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Category</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="category" name="category">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">Old</option>
                                            <option value="2">New</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Target LAR</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="target_lar" name="target_lar" min="0" readonly>

                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Target DPPM</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="target_dppm" name="target_dppm" min="0" readonly>

                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot Inspected</span>
                                        </div>
                                            {{-- <input type="text" class="form-control form-control-sm" id="txtInput" name="input" min="0" value="0"> --}}
                                        <input type="number" class="form-control form-control-sm" id="lot_inspected" name="lot_inspected" min="0">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot Accepted</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="accepted" name="accepted" min="0">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Sampling Size</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="sampling_size" name="sampling_size" min="0">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">No. of Defectives</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="no_of_defects" name="no_of_defects" min="0">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Judgement</span>
                                        </div>
                                        <select class="form-select form-control-sm" id="judgement" name="judgement">
                                            <option value="" selected disabled>-Select-</option>
                                            <option value="1">Accept</option>
                                            <option value="2">Reject</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Mode of Defect</span>
                                        </div>
                                        <button type="button" class="form-control form-control-sm bg-warning" id="btnMod">Mode of Defects</button>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col">
                                  <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                      <span class="input-group-text w-100" id="basic-addon1">Final Visual Operator</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="operator_name" name="operator_name" readonly="true">
                                    <input type="text" class="form-control form-control-sm" id="txtOperatorId" name="operator_id" readonly="" style="display: none;">
                                    <button class="btn btn-xs btn-primary input-group-append btnScanOperator" type="button" style="padding: 5px 8px; padding-top: 8px;"><i class="fa fa-qrcode"></i></button>
                                  </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnProcess" class="btn btn-primary"><i
                                    class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalLotNo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> Lot Details</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formSaveIqcInspection" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 mt-3">
                                    <table  id="tblLotNumber" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th style="width: 80%;">Lot No.</th>
                                            <th style="width: 20%;">Lot Qty.</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalModeOfDefect" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> Mode of Defects Details</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mt-2">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Lot No.</span>
                                    </div>
                                    <select class="form-control select2bs4" name="mod_lot_no" id="mod_lot_no" style="width: 50%;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Mode of Defect</span>
                                    </div>
                                    <select class="form-control select2bs4" name="mode_of_defect" id="mode_of_defect" style="width: 50%;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Quantity</span>
                                    </div>
                                    <input class="form-control" type="number" name="mod_quantity" id="mod_quantity" value="0" min =0>
                                    {{-- <select class="form-control select2bs4" name="mod_quantity" id="mod_quantity" style="width: 50%;">
                                    </select> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-sm btn-danger" id="btnRemoveModLotNumber" disabled><i class="fas fa-trash-alt"></i> Remove </a></button>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-primary" id="btnAddModLotNumber"><i class="fas fa-plus"></i>Add</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mt-3">

                                <table id="tblModeOfDefect" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Lot No.</th>
                                            <th>Mode of Defects</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function () {

                const tbl = {
                    iqcInspection:'#tblIqcInspection'
                };
                const dt = {};
                const form = {
                    iqcInspection : $('#formSaveIqcInspection')
                };
                const strDate = {
                    dateToday : new Date() // By default Date empty constructor give you Date.now
                }
                
                const arrCounter= {
                    ctr : 0
                }

                const btn = {
                    removeModLotNumber : $('#btnRemoveModLotNumber')
                }

                const arrTableMod = {
                    lotNo : [],
                    modeOfDefects : [],
                    lotQty : []
                };


                /**
                    *TODO: Get data only for Applied Inspection
                    *TODO: Save Data
                    *TODO: Auto Time
                    *TODO: AQL
                    *TODO: Lot Number and QTY
                    *TODO: No of Defects based on MOD total qty
                */
                dt.iqcInspection = $(tbl.iqcInspection).DataTable({
                        "processing" : true,
                        "serverSide" : true,
                        "ajax" : {
                            url: "load_whs_transaction",
                            data: function (param){
                                param.status = $("#selEmpStat").val();
                            }
                        },
                        fixedHeader: true,
                        "columns":[

                            { "data" : "action", orderable:false, searchable:false },
                            { "data" : "status", orderable:false, searchable:false },
                            { "data" : "InvoiceNo" },
                            { "data" : "Supplier" },
                            { "data" : "PartNumber" },
                            { "data" : "MaterialType" },
                            { "data" : "Lot_number" },
                            { "data" : "whs_transaction_lastupdate" },

                        ],
                });

                const getWhsTransactionById = function (whs_transaction_id) {
                    $.ajax({
                        type: "GET",
                        url: "get_whs_transaction_by_id",
                        data: {"whs_transaction_id" : whs_transaction_id},
                        dataType: "json",
                        success: function (response) {
                            let lotNo = response[0]['Lot_number'];
                            let lotQty = response[0]['In'];

                            $('#modalSaveIqcInspection').modal('show');
                            form.iqcInspection.find('#invoice_no').val(response[0]['InvoiceNo']);
                            form.iqcInspection.find('#partcode').val(response[0]['PartNumber']);
                            form.iqcInspection.find('#partname').val(response[0]['MaterialType']);
                            form.iqcInspection.find('#supplier').val(response[0]['Supplier']);

                            /*Mode of Defects Modal*/
                            $('#mod_lot_no').empty().prepend(`<option value="" selected disabled>-Select-</option>`)
                            $('#mod_quantity').empty().prepend(`<option value="" selected disabled>-Select-</option>`)
                            for (let i = 0; i < response.length; i++) {
                                let optLotNo = `<option value="${lotNo}">${lotNo}</option>`;
                                let optLotQty = `<option value="${lotQty}">${lotQty}</option>`;
                                $('#mod_lot_no').append(optLotNo);
                                $('#mod_quantity').append(optLotQty);
                                console.log(optLotQty);
                            }

                            /*Lot Number*/
                            
                            // $('#tblLotNumber tbody').empty();
                            // var html_body  = '<tr>';
                            //     html_body += '<td>'+lotNo+'</td>';
                            //     html_body += '<td>'+lotQty+'</td>';
                            //     html_body += '</tr>';
                            // $('#tblLotNumber tbody').append(html_body);
                            
                        }
                    });
                }
                const getFamily = function () {
                    $.ajax({
                        type: "GET",
                        url: "get_family",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            let families_id = response['id'];
                            let families_name = response['value'];
                            form.iqcInspection.find('#family').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            for (let i = 0; i < families_id.length; i++) {
                                let opt = `<option value="${families_id[i]}">${families_name[i]}</option>`;
                                form.iqcInspection.find('#family').append(opt);
                            }
                        }
                    });
                }
                const getInspectionLevel = function () {
                    $.ajax({
                        type: "GET",
                        url: "get_inspection_level",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            let dropdown_inspection_level_id = response['id'];
                            let dropdown_inspection_level_name = response['value'];
                            form.iqcInspection.find('#inspection_lvl').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            for (let i = 0; i < dropdown_inspection_level_id.length; i++) {
                                let opt = `<option value="${dropdown_inspection_level_id[i]}">${dropdown_inspection_level_name[i]}</option>`;
                                form.iqcInspection.find('#inspection_lvl').append(opt);
                            }
                        }
                    });
                }
                const getAql = function () {
                    $.ajax({
                        type: "GET",
                        url: "get_aql",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            let dropdown_aql_id = response['id'];
                            let dropdown_aql_name = response['value'];
                            form.iqcInspection.find('#aql').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            for (let i = 0; i < dropdown_aql_id.length; i++) {
                                let opt = `<option value="${dropdown_aql_name[i]}">${dropdown_aql_name[i]}</option>`;
                                form.iqcInspection.find('#aql').append(opt);
                            }
                        }
                    });
                }
                const getDieNo = function () {

                    form.iqcInspection.find('#die_no').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                    for (let i = 0; i < 15; i++) {
                        let opt = `<option value="${i+1}">${i+1}</option>`;
                        form.iqcInspection.find('#die_no').append(opt);
                    }
                }
                const getLarDppm = function (){
                    $.ajax({
                        type: "GET",
                        url: "get_lar_dppm",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            console.log(response['lar_value'][0]);
                            console.log(response['dppm_value'][0]);
                            form.iqcInspection.find('#target_dppm').val(response['lar_value'][0]);
                            form.iqcInspection.find('#target_lar').val(response['dppm_value'][0]);
                            // let dropdown_aql_id = response['id'][];
                            // let dropdown_aql_name = response['value'][];
                            // form.iqcInspection.find('#aql').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            // for (let i = 0; i < dropdown_aql_id.length; i++) {
                            //     let opt = `<option value="${dropdown_aql_name[i]}">${dropdown_aql_name[i]}</option>`;
                            //     form.iqcInspection.find('#aql').append(opt);
                            // }
                        }
                    });
                }
                const getModeOfDefect = function (){
                    $.ajax({
                        type: "GET",
                        url: "get_mode_of_defect",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            let dropdown_iqc_mode_of_defect_id = response['id'];
                            let dropdown_iqc_mode_of_defect = response['value'];
                            $('#mode_of_defect').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            for (let i = 0; i < dropdown_iqc_mode_of_defect_id.length; i++) {
                                let opt = `<option value="${dropdown_iqc_mode_of_defect[i]}">${dropdown_iqc_mode_of_defect[i]}</option>`;
                                $('#mode_of_defect').append(opt);
                            }
                        }
                    });
                }

                const disabledEnabledButton = function(arrCounter){
                    if(arrCounter === 0 ){
                        btn.removeModLotNumber.prop('disabled',true);
                    }else{
                        btn.removeModLotNumber.prop('disabled',false);
                    }
                }

                $(tbl.iqcInspection).on('click','#btnEditIqcInspection', function () {
                    let whs_transaction_id = $(this).attr('whs-trasaction-id')
                    let twoDigitYear = strDate.dateToday.getFullYear().toString().substr(-2);
                    let twoDigitMonth = (strDate.dateToday.getMonth() + 1).toString().padStart(2, "0");
                    let arr_data = {
                        'whs_transaction_id': whs_transaction_id
                    }
                    arrTableMod.lotNo =[];
                    arrTableMod.modeOfDefects =[];
                    arrTableMod.lotQty =[];

                    $('#tblModeOfDefect tbody').empty();
                    getWhsTransactionById(whs_transaction_id);
                    getFamily();
                    getInspectionLevel();
                    getAql();
                    getDieNo();
                    getLarDppm();
                    getModeOfDefect();
                    form.iqcInspection.find('#whs_transaction_id').val(whs_transaction_id);
                    form.iqcInspection.find('#app_no').val(`PPS-${twoDigitYear}${twoDigitMonth}-`);
                });
                $('#btnLotNo').click(function (e) {
                    e.preventDefault();
                    $('#modalLotNo').modal('show');
                });
                $('#btnMod').click(function (e) {
                    e.preventDefault();
                    $('#modalModeOfDefect').modal('show');
                });

                $('#btnAddModLotNumber').click(function (e) {
                    e.preventDefault();

                    /* Selected Value */
                    let selectedLotNo = $('#mod_lot_no').val();
                    let selectedMod = $('#mode_of_defect').val();
                    let selectedLotQty = $('#mod_quantity').val();

                    if(selectedLotNo === null || selectedMod === null || selectedLotQty <= 0){
                        toastr.error('Error: Please Fill up all fields !');
                        return false;
                    }
                    
                    /* Counter and Disabled Removed Button */
                    arrCounter.ctr++;
                    disabledEnabledButton(arrCounter.ctr)

                    /* Get selected array to the table */
                    var html_body  = '<tr>';
                        html_body += '<td>'+arrCounter.ctr+'</td>';
                        html_body += '<td>'+selectedLotNo+'</td>';
                        html_body += '<td>'+selectedMod+'</td>';
                        html_body += '<td>'+selectedLotQty+'</td>';
                        html_body += '</tr>';
                    $('#tblModeOfDefect tbody').append(html_body);

                    arrTableMod.lotNo.push(selectedLotNo);
                    arrTableMod.modeOfDefects.push(selectedMod);
                    arrTableMod.lotQty.push(selectedLotQty);
                    console.log('check',arrTableMod);
                });

                btn.removeModLotNumber.click(function() {
                    arrCounter.ctr --;
                    disabledEnabledButton(arrCounter.ctr)
                    
                    $('#tblModeOfDefect tr:last').remove();
                    arrTableMod.lotNo.splice(arrCounter.ctr, 1);
                    arrTableMod.modeOfDefects.splice(arrCounter.ctr, 1);
                    arrTableMod.lotQty.splice(arrCounter.ctr, 1);
                    console.log(arrTableMod);
                });


                $(form.iqcInspection).submit(function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: "GET",
                        url: "save_iqc_inspection",
                        data: $(this).serialize() + '&' +$.param(arrTableMod),
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                        }
                    });
                });

                // $(form.iqcInspection).submit(function (e) {
                //     e.preventDefault();
                //     console.log(e);
                //     $.ajax({
                //         type: "GET",
                //         url: "save_iqc_inspection",
                //         data: $(this).serialize() + '&' +$.param(arrTableMod),
                //         dataType: "json",
                //         success: function (response) {
                //             console.log(response);
                //         }
                //     });
                // });
            

                
                
            });

        </script>
    @endsection
@endauth

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
        <div class="modal fade" id="modalSaveIqcInspection" tabindex="-1" role="dialog" aria-hidden="true"  data-bs-backdrop="static">
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
                                        <select class="form-select form-control" id="family" name="family" >
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Application Ctrl. No.</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="app_no" name="app_no" readonly>
                                        <input type="text" class="form-control form-control-sm" id="app_no_extension" name="app_no_extension">
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
                                        <input type="number" class="form-control form-control-sm" id="total_lot_qty" name="total_lot_qty"  min="0" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Lot No.</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="lot_no" name="lot_no" readonly>

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
                                        <input type="number" class="form-control form-control-sm" id="accept" name="accept" min="0">

                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Reject</span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="reject" name="reject" min="0">
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
                                        <input type="date" class="form-control form-control-sm" id="date_inspected" name="date_inspected" readonly>
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
                                        <input type="time" class="form-control form-control-sm" id="time_ins_from" name="time_ins_from" readonly>
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100" id="basic-addon1">-</span>
                                        </div>
                                        <input type="time" class="form-control form-control-sm" id="time_ins_to" name="time_ins_to">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Inspector</span>
                                        </div>
                                        {{-- <input class="form-control" value="{{ Auth::user()->username }}" readonly> --}}
                                        <select class="form-select" name="inspector" id="inspector">
                                            <option value="{{ Auth::user()->username }}" selected>{{Auth::user()->firstname.' '.Auth::user()->lastname}}</option>
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
                                        <input type="number" class="form-control form-control-sm" id="no_of_defects" name="no_of_defects" min="0" placeholder="auto-compute" readonly>
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
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">COC File</span>
                                        </div>
                                        <input type="file" class="form-control form-control-sm" id="iqc_coc_file" name="iqc_coc_file" accept=".pdf">
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
                                            <th>Counter</th>
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
                        <button type="button" class="btn btn-sm btn-primary" id="btnSaveComputation" disabled><i class="fas fa-save"></i> Compute</button>
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
                const dt = {
                    iqcInspection:''
                };
                const form = {
                    iqcInspection : $('#formSaveIqcInspection')
                };
                const strDatTime = {
                    dateToday : new Date(), // By default Date empty constructor give you Date.now
                    currentDate : new Date().toJSON().slice(0, 10),
                    currentTime : new Date().toLocaleTimeString('en-GB', { hour: "numeric",minute: "numeric"}),
                    currentHours : new Date().getHours(),
                    currentMinutes : new Date().getMinutes(),

                }
                const arrCounter= {
                    ctr : 0
                }
                const btn = {
                    removeModLotNumber : $('#btnRemoveModLotNumber'),
                    saveComputation : $('#btnSaveComputation')
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

                const getFamily = function () {
                    $.ajax({
                        url: "get_family",
                        method: "get",
                        dataType: "json",

                        beforeSend: function(){
                            result = '<option value="" selected disabled> -- Loading -- </option>';
                            form.iqcInspection.find('select[name=family]').html(result);
                        },
                        success: function(response){
                            result = '';
                            let families_id = response['id'];
                            let families_name = response['value'];

                            if(response['id'].length > 0){
                                result = '<option selected disabled> --- Select --- </option>';
                                for(let index = 0; index < response['id'].length; index++){
                                    result += '<option value="' + response['id'][index]+'">'+ response['value'][index]+'</option>';
                                }
                            }
                            else{
                                result = '<option value="0" selected disabled> No record found </option>';
                            }
                            form.iqcInspection.find('select[name="family"]').html(result);
                        }
                    });
                }

                const getWhsTransactionById = function (whs_transaction_id) {
                    $.ajax({
                        type: "GET",
                        url: "get_whs_transaction_by_id",
                        data: {"whs_transaction_id" : whs_transaction_id},
                        dataType: "json",
                        success: function (response) {
                            let twoDigitYear = strDatTime.dateToday.getFullYear().toString().substr(-2);
                            let twoDigitMonth = (strDatTime.dateToday.getMonth() + 1).toString().padStart(2, "0");
                            let lotNo = response[0]['lot_no'];
                            let lotQty = response[0]['total_lot_qty'];
                            let iqcInspectionId = response[0]['iqc_inspection_id'];
                            let iqcInspectionsMods = response[0].iqc_inspections_mods;

                            console.log('currentMinutes.currentTime',strDatTime.currentTime);
                            $('#modalSaveIqcInspection').modal('show');
                            if(iqcInspectionId === undefined){
                                form.iqcInspection.find('#app_no').val(`PPS-${twoDigitYear}${twoDigitMonth}-`);
                                form.iqcInspection.find('#date_inspected').val(strDatTime.currentDate);
                                form.iqcInspection.find('#time_ins_from').val(strDatTime.currentTime);

                            }else{
                                form.iqcInspection.find('#app_no').val(response[0]['app_no']);
                                form.iqcInspection.find('#date_inspected').val(response[0]['date_inspected']);
                                console.log(response[0]['date_inspected']);
                                form.iqcInspection.find('#time_ins_from').val(response[0]['time_ins_from']);

                            }

                            form.iqcInspection.find('#whs_transaction_id').val(whs_transaction_id);
                            form.iqcInspection.find('#iqc_inspection_id').val(iqcInspectionId);
                            form.iqcInspection.find('#invoice_no').val(response[0]['invoice_no']);
                            form.iqcInspection.find('#partcode').val(response[0]['partcode']);
                            form.iqcInspection.find('#partname').val(response[0]['partname']);
                            form.iqcInspection.find('#supplier').val(response[0]['supplier']);
                            form.iqcInspection.find('#total_lot_qty').val(lotQty);
                            form.iqcInspection.find('#lot_no').val(lotNo);
                            form.iqcInspection.find('#app_no_extension').val(response[0]['app_no_extension']);

                            form.iqcInspection.find('#die_no').val(response[0]['die_no']);
                            form.iqcInspection.find('#classification').val(response[0]['classification']);

                            form.iqcInspection.find('#type_of_inspection').val(response[0]['type_of_inspection']);
                            form.iqcInspection.find('#severity_of_inspection').val(response[0]['severity_of_inspection']);
                            form.iqcInspection.find('#accept').val(response[0]['accept']);
                            form.iqcInspection.find('#reject').val(response[0]['reject']);
                            form.iqcInspection.find('#shift').val(response[0]['shift']);
                            form.iqcInspection.find('#time_ins_to').val(response[0]['time_ins_to']);
                            form.iqcInspection.find('#inspector').val(response[0]['inspector']).trigger('change');
                            form.iqcInspection.find('#submission').val(response[0]['submission']);
                            form.iqcInspection.find('#category').val(response[0]['category']);
                            form.iqcInspection.find('#target_lar').val(response[0]['target_lar']);
                            form.iqcInspection.find('#target_dppm').val(response[0]['target_dppm']);
                            form.iqcInspection.find('#sampling_size').val(response[0]['sampling_size']);
                            form.iqcInspection.find('#no_of_defects').val(response[0]['no_of_defects']);
                            form.iqcInspection.find('#lot_inspected').val(response[0]['lot_inspected']);
                            form.iqcInspection.find('#accepted').val(response[0]['accepted']);
                            form.iqcInspection.find('#judgement').val(response[0]['judgement']);
                            form.iqcInspection.find('#remarks').val(response[0]['remarks']);

                            setTimeout(() => {
                                form.iqcInspection.find('#family').val(response[0]['family']).trigger("change");
                                form.iqcInspection.find('#inspection_lvl').val(response[0]['inspection_lvl']).trigger("change");
                                form.iqcInspection.find('#aql').val(response[0]['aql']).trigger("change");

                            }, 300);

                            console.log(iqcInspectionsMods);
                            $('#tblModeOfDefect tbody').empty();
                            arrTableMod.lotNo = [];
                            arrTableMod.modeOfDefects = [];
                            arrTableMod.lotQty = [];
                            if(iqcInspectionsMods === undefined){
                                arrCounter.ctr = 0;
                            }else{
                                btn.removeModLotNumber.prop('disabled',false);
                                for (let i = 0; i < iqcInspectionsMods.length; i++) {
                                    let selectedLotNo = iqcInspectionsMods[i].lot_no
                                    let selectedMod = iqcInspectionsMods[i].mode_of_defects
                                    let selectedLotQty = iqcInspectionsMods[i].quantity
                                    arrCounter.ctr = i+1;
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
                                }
                                console.log('arrTableMod',arrTableMod.lotNo);
                            }
                            /*Mode of Defects Modal*/
                            $('#mod_lot_no').empty().prepend(`<option value="" selected disabled>-Select-</option>`)
                            $('#mod_quantity').empty().prepend(`<option value="" selected disabled>-Select-</option>`)
                            for (let i = 0; i < response.length; i++) {
                                let optLotNo = `<option value="${lotNo}">${lotNo}</option>`;
                                let optLotQty = `<option value="${lotQty}">${lotQty}</option>`;
                                $('#mod_lot_no').append(optLotNo);
                                $('#mod_quantity').append(optLotQty);

                            }
                            console.log('show_edit',arrTableMod.lotQty);
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
                            form.iqcInspection.find('#inspection_lvl').empty();
                            form.iqcInspection.find('#inspection_lvl').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                            for (let i = 0; i < dropdown_inspection_level_id.length; i++) {
                                let opt = `<option value="${dropdown_inspection_level_id[i]}">${dropdown_inspection_level_name[i]}</option>`;
                                form.iqcInspection.find('#inspection_lvl').append(opt);
                            }
                        }
                    });
                }
                const getAql = function () {
                    form.iqcInspection.find('#aql').empty().prepend(`<option value="0" selected disabled>-Select-</option>`)
                    $.ajax({
                        type: "GET",
                        url: "get_aql",
                        data: "data",
                        dataType: "json",
                        success: function (response) {
                            let dropdown_aql_id = response['id'];
                            let dropdown_aql_name = response['value'];
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
                            // console.log(response['lar_value'][0]);
                            // console.log(response['dppm_value'][0]);
                            form.iqcInspection.find('#target_dppm').val(response['lar_value'][0]);
                            form.iqcInspection.find('#target_lar').val(response['dppm_value'][0]);
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
                        btn.saveComputation.prop('disabled',true);
                    }else{
                        btn.removeModLotNumber.prop('disabled',false);
                        btn.saveComputation.prop('disabled',false);
                    }
                }
                const getSum = function (total, num) {
                    return total + Math.round(num);
                }

                $(tbl.iqcInspection).on('click','#btnEditIqcInspection', function () {
                    let whs_transaction_id = $(this).attr('whs-trasaction-id')

                    let arr_data = {
                        'whs_transaction_id': whs_transaction_id
                    }
                    getWhsTransactionById(whs_transaction_id);
                    getFamily();
                    getAql();
                    getInspectionLevel();
                    getDieNo();
                    getLarDppm();
                    getModeOfDefect();

                    form.iqcInspection.find('input').removeClass('is-invalid')
                    form.iqcInspection.find('input').attr('title', '')
                    form.iqcInspection.find('select').removeClass('is-invalid')
                    form.iqcInspection.find('select').attr('title', '')
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
                    console.log('click',arrTableMod.lotQty);
                    // console.log('check',arrTableMod);
                });

                btn.saveComputation.click(function (e) {
                    e.preventDefault();
                    $('#modalModeOfDefect').modal('hide');
                    form.iqcInspection.find('#no_of_defects').val(arrTableMod.lotQty.reduce(getSum, 0));
                });

                btn.removeModLotNumber.click(function() {
                    arrCounter.ctr --;
                    disabledEnabledButton(arrCounter.ctr)

                    $('#tblModeOfDefect tr:last').remove();
                    arrTableMod.lotNo.splice(arrCounter.ctr, 1);
                    arrTableMod.modeOfDefects.splice(arrCounter.ctr, 1);
                    arrTableMod.lotQty.splice(arrCounter.ctr, 1);
                    console.log('deleted',arrTableMod.lotQty);
                    // console.log(arrTableMod);
                });
                $(form.iqcInspection).submit(function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "GET",
                        url: "save_iqc_inspection",
                        data: $(this).serialize() + '&' +$.param(arrTableMod),
                        dataType: "json",
                        success: function (response) {
                            if (response['result'] === 1){
                                $('#modalSaveIqcInspection').modal('hide');
                                dt.iqcInspection.draw();
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Your work has been saved",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },error: function (data, xhr, status){
                            let errors = data.responseJSON.errors ;
                            console.log(data.status);
                            if(data.status === 422){
                                errorHandler(errors.accept,form.iqcInspection.find('#accept'));
                                errorHandler(errors.family,form.iqcInspection.find('#family'));
                                errorHandler(errors.app_no_extension,form.iqcInspection.find('#app_no_extension'));
                                errorHandler(errors.die_no,form.iqcInspection.find('#die_no'));
                                errorHandler(errors.lot_no,form.iqcInspection.find('#lot_no'));
                                errorHandler(errors.classification,form.iqcInspection.find('#classification'));
                                errorHandler(errors.type_of_inspection,form.iqcInspection.find('#type_of_inspection'));
                                errorHandler(errors.severity_of_inspection,form.iqcInspection.find('#severity_of_inspection'));
                                errorHandler(errors.inspection_lvl,form.iqcInspection.find('#inspection_lvl'));
                                errorHandler(errors.aql,form.iqcInspection.find('#aql'));
                                errorHandler(errors.accept,form.iqcInspection.find('#accept'));
                                errorHandler(errors.reject,form.iqcInspection.find('#reject'));
                                errorHandler(errors.shift,form.iqcInspection.find('#shift'));
                                errorHandler(errors.date_inspected,form.iqcInspection.find('#date_inspected'));
                                errorHandler(errors.time_ins_from,form.iqcInspection.find('#time_ins_from'));
                                errorHandler(errors.time_ins_to,form.iqcInspection.find('#time_ins_to'));
                                errorHandler(errors.inspector,form.iqcInspection.find('#inspector'));
                                errorHandler(errors.submission,form.iqcInspection.find('#submission'));
                                errorHandler(errors.category,form.iqcInspection.find('#category'));
                                errorHandler(errors.sampling_size,form.iqcInspection.find('#sampling_size'));
                                errorHandler(errors.lot_inspected,form.iqcInspection.find('#lot_inspected'));
                                errorHandler(errors.accepted,form.iqcInspection.find('#accepted'));
                                errorHandler(errors.judgement,form.iqcInspection.find('#judgement'));
                            }else{
                                toastr.error('Error');
                            }
                        }
                    });
                });

                const errorHandler = function (errors,formInput){
                    if(errors === undefined){
                        formInput.removeClass('is-invalid')
                        formInput.attr('title', '')
                    }else {
                        formInput.addClass('is-invalid');
                        formInput.attr('title', errors[0])
                    }
                }
            });

        </script>
    @endsection
@endauth

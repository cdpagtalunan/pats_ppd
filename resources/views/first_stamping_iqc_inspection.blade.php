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
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">1st Stamping Table</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <br><br>
                                    {{-- TABS --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Pending-tab" data-bs-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="true">On-going</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Completed-tab" data-bs-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">Inspected</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        {{-- Pending Tab --}}
                                        <div class="tab-pane fade show active" id="menu1" role="tabpanel" aria-labelledby="menu1-tab">
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
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="menu2-tab">
                                            <div class="table-responsive">
                                                <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                <table id="tblIqcInspected" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><center><i  class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Date Inspected</th>
                                                            <th>Time Inspected</th>
                                                            {{-- <th>App Ctrl No.</th> --}}
                                                            {{-- <th>Classification</th> --}}
                                                            {{-- <th>Family</th> --}}
                                                            {{-- <th>Category</th> --}}
                                                            <th>Supplier</th>
                                                            <th>Part Code</th>
                                                            <th>Part Name</th>
                                                            <th>Lot No.</th>
                                                            <th>Lot Qty.</th>
                                                            {{-- <th>AQL</th> --}}
                                                            <th>Date Created</th>
                                                            <th>Date Updated</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
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
                            <div class="row d-none">
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
                                    <div class="input-group input-group-sm mb-3 d-none divMod">
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
                                    <div class="input-group input-group-sm mb-3 d-none divMod">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Mode of Defect</span>
                                        </div>
                                        <button type="button" class="form-control form-control-sm bg-warning" id="btnMod">Mode of Defects</button>
                                    </div>
                                    <div class="input-group input-group-sm mb-3 none" id="fileIqcCocUpload">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">COC File</span>
                                        </div>
                                        <input type="file" class="form-control form-control-sm" id="iqc_coc_file" name="iqc_coc_file" accept=".pdf">
                                        {{-- &nbsp;&nbsp; <a href="#" id="iqc_coc_file_download" class="link-primary"> <i class="fas fa-file"></i> Click to download attachment</a> --}}
                                    </div>
                                    <div class="input-group input-group-sm mb-3 none" id="fileIqcCocDownload">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Attachment</span>
                                        </div>
                                        &nbsp;&nbsp; <a href="#" id="iqc_coc_file_download" class="link-primary"> <i class="fas fa-file"></i> Click to download attachment</a>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="isUploadCoc" name="isUploadCoc">
                                        <label class="form-check-label" for="isUploadCoc">
                                            Click to upload new attachment
                                        </label>
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
                                    </select>
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
                        {{-- <button type="button" class="btn btn-sm btn-primary" id="btnSaveComputation"><i class="fas fa-save"></i> Compute</button> --}}
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function () {

                /**
                    *TODO: Get data only for Applied Inspection
                    *TODO: Save Data
                    *TODO: Auto Time
                    *TODO: AQL
                    *TODO: Lot Number and QTY
                    *TODO: No of Defects based on MOD total qty
                */
               console.log(dataTable);
               dataTable.iqcInspection = $(tbl.iqcInspection).DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "load_whs_transaction",
                        data: function (param){
                            param.firstStamping = "true" //DT for 1st Stamping
                        },
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status", orderable:false, searchable:false },
                        { "data" : "Supplier" },
                        { "data" : "PartNumber" },
                        { "data" : "MaterialType" },
                        { "data" : "Lot_number" },
                    ],
                });
                // $.ajax({
                //     type: "GET",
                //     url: "load_iqc_inspection",
                //     data: "data",
                //     dataType: "JSON",
                //     success: function (response) {
                //         console.log(response);
                //     }
                // });
                
                const editIqcInspection = function () {
                    let whs_transaction_id = $(this).attr('whs-trasaction-id')
                    let arr_data = {
                        'whs_transaction_id': whs_transaction_id
                    }
                    console.log(whs_transaction_id);
                    getWhsTransactionById(whs_transaction_id);
                    getFamily();
                    getAql();
                    getInspectionLevel();
                    getDieNo();
                    getLarDppm();
                    getModeOfDefect();

                    form.iqcInspection.find('input').removeClass('is-invalid');
                    form.iqcInspection.find('input').attr('title', '');
                    form.iqcInspection.find('select').removeClass('is-invalid');
                    form.iqcInspection.find('select').attr('title', '');

                    /*Upload and Download file*/
                    $('#isUploadCoc').prop('checked',false);
                    form.iqcInspection.find('#fileIqcCocUpload').addClass('d-none',true);
                }
                $(tbl.iqcInspection).on('click','#btnEditIqcInspection', editIqcInspection);
                $(tbl.iqcInspected).on('click','#btnEditIqcInspection', editIqcInspection);

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

                form.iqcInspection.find('#accepted').keyup(function() {
                    divDisplayNoneClass($(this).val());
                });

                form.iqcInspection.find('#iqc_coc_file_download').click(function (e) {
                    e.preventDefault();
                    let iqc_inspection_id = form.iqcInspection.find('#iqc_inspection_id').val();
                    window.open('view_coc_file_attachment/'+iqc_inspection_id);
                
                });

                form.iqcInspection.find('#isUploadCoc').change(function (e) { 
                    e.preventDefault();
                    $('#iqc_coc_file').val('');
                    if ($(this).is(':checked')) {
                        form.iqcInspection.find('#fileIqcCocUpload').removeClass('d-none',true);
                        form.iqcInspection.find('#fileIqcCocDownload').addClass('d-none',true);
                    }else{
                        form.iqcInspection.find('#fileIqcCocUpload').addClass('d-none',true);
                        form.iqcInspection.find('#fileIqcCocDownload').removeClass('d-none',true);
                    }
                });
                $('#txtScanUserId').on('keyup', function(e){
                    if(e.keyCode == 13){
                        // console.log($(this).val());
                        validateUser($(this).val(), [2,5], function(result){
                            if(result == true){
                                // console.log('true');
                                // submitProdData($(this).val());
                                // console.log('', $('#txtKeepSample1').val());
                                saveIqcInspection();
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                        $(this).val('');
                    }
                });
                /*Submit*/
                $(form.iqcInspection).submit(function (e) {
                    e.preventDefault();
                    saveIqcInspection();
                    // $('#modalScanQRSave').modal('show');
                });
            });

        </script>
    @endsection
@endauth

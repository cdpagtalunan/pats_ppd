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
@endauth--}}

@auth
@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
{{-- <meta name="csrf-token" content="{{ csrf_token() }}" />  --}}

    <style>
        table.table tbody td{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 13px;
            /* text-align: center; */
            vertical-align: middle;
        }

        table.table thead th{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stamping</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Press Stamping Machine Checksheet</li>
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
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                                <div class="card-header">
                                    <div class="col-sm-4 d-flex flex-row">
                                        <div class="input-group">
                                            <div class="input-group-prepend w-25">
                                                <span class="input-group-text w-100" id="basic-addon1">Date:</span>
                                            </div>
                                            <input type="text" id="selMonth" name="" class="datepicker form-control" />

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary float-end" id="addChecksheet" >Add Daily Checksheet</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                <table id="tblDailyChecksheet" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th>Machine</th>
                                                            {{-- <th>Shift</th> --}}
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <div class="modal fade" id="modalAddChecksheet" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Press Stamping Machine Checksheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddDailyChecksheet">
                    @csrf
                    <input type="hidden" id="txtDailyCheckSheetId" name="daily_checksheet_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">UNIT NO</span>
                                            </div>
                                            {{-- <input type="text" class="form-control form-control-sm" value="3" id="txtUnitNo" name="unit_no" readonly> --}}
                                            <select class="form-control form-control-sm" name="unit_no" id="txtunitNo">
                                                <option value="" selected disabled>--Select--</option>
                                                <option value="01">01</option>
                                                <option value="02">02</option>
                                                <option value="03">03</option>
                                                <option value="04">04</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Division</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckDiv" name="division" value="Operations Division" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Month</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonth" name="month" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Machine</span>
                                            </div>
                                            <select class="form-control select2bs4" id="selMachine" name="machine" required></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">AREA</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtArea" name="machine_area" value="Stamping" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtConformedBy" name="conformed_by" value="H. De Guzman" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONDUCTED BY (OPERATOR)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtConductedBy" name="conducted_by" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CHECKED BY (ENGINEER)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckedBy" name="checked_by" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY (QC)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtConformedBy" name="conformed_by" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date/Time</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckDate" name="date" readonly>
                                            <input type="hidden" class="form-control form-control-sm" id="txtCheckTime" name="time" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <b>
                                            GENERAL INSTRUCTION : <br>
                                            1. CONDUCT CHECKING BASED ON REQUIRED FREQUENCY INDICATED HEREIN.<br>
                                            2. REFER TO POINT PANEL FOR PARTS IDENTIFICATION.<br>
                                            3. DAILY CHECKING MUST BE CONDUCTED EVERY START OF THE MORNING SHIFT.<br>
                                            4. REPORT IMMEDIATELY TO EQUIPMENT MAINTENANCE SECTION ANY ABNORMALITY FOUND DURING CHECKING.<br>
                                            5. WEEKLY CHECKING SHALL BE CONDUCTED DURING THE FIRST WORKING DAY OF THE WEEK.<br>
                                            6. MONTHLY CHECKING SHALL BE CONDUCTED ON THE FIRST WORKING DAY OF THE CALENDAR MONTH.
                                            </b>
                                        </div>
                                        <div class="col-sm-1">
                                            <b>
                                            Legend :
                                            </b>
                                        </div>
                                        <div class="col-sm-3">
                                            <b>
                                            ✓ = OK <br> X = NG <br> NP = NO PRODUCTION <br> N/A = NOT APPLICABLE
                                            </b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            {{-- <div class="card-header p-2">
                                                <h6>A.1 Machines & Equipments</h6>
                                            </div> --}}
                                            <div class="card-body" >
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>D1</label> <br>
                                                        <label>STD MEAS.</label> <br>
                                                        <label>ACTUAL MEAS.</label> <br>
                                                        <label>RESULT</label> <br><br>

                                                        <label>D2</label> <br>
                                                        <label>STD MEAS.</label> <br>
                                                        <label>ACTUAL MEAS.</label> <br>
                                                        <label>RESULT</label> <br><br>

                                                        <label>D3</label><br>
                                                        <label>D4</label><br>
                                                        <label>D5</label><br><br>
                                                        <label>D6</label><br>
                                                        <label>D7</label><br><br>
                                                        <label>D8</label><br>
                                                        <label>D9</label><br><br><br>
                                                        <label>D10</label><br>
                                                        <label>D11</label><br>
                                                        <label>D12</label><br>
                                                        <label>D13</label>

                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label> </label><br>
                                                        <label>0.4 ~ 0.6</label>
                                                        <div class="form-group">
                                                            <input type="text" name="actual_measurement" id="txtActualMeasurement">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <label> </label><br>
                                                        <label>1.7 ~ 2.5</label>
                                                        <div class="form-group">
                                                            <input type="text" name="actual_measurement2" id="txtActualMeasurement2">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">DAILY CHECKPOINTS</label>
                                                        D1. AIR PRESSURE (STD PRESSURE = 0.40~0.60MPa)<br>
                                                        D2. OIL PRESSURE (STD PRESSURE = 1.7~2.5MPa)<br>
                                                        D3. AIR LEAKAGE (NO AIR LEAKAGE ON AIR PIPING)<br>
                                                        D4. LUBE OIL LEVEL (WITHIN THE RANGE)<br>
                                                        D5. POWER SUPPLY (FUNCTION AND LAMP LIGHT ON)<br>
                                                        D6. DEPRESS MOTOR START BUTTON (GREEN LIGHT ON)<br>
                                                        D7. V BELT AND MOTOR (ABNORMAL SOUND/VIBRATION)<br>
                                                        D8. CLUTCH ACTION (FUNCTION)<br>
                                                        D9. EMERGENCY STOP OPERATION (BUTTON FUNCTION)<br>
                                                        D10. STOCK END STOP (CLUTCH ACTUATION)<br>
                                                        D11. SAFETY DOOR(FUNCTION)<br>
                                                        D12. BUY-OFF STICKER<br>
                                                        D13. PREVENTIVE MAINTENANCE (PM) STICKER<br><br><br>

                                                        {{-- <label style="display: flex; justify-content: center; align-items: center;">WEEKLY CHECKPOINTS</label>
                                                        W1. PRESSURE SWITCH FOR PNEUMATICS<br>
                                                        W2. PRESSURE SWITCH FOR LUBE OIL<br>
                                                        W3. PRESSURE SWITCH FOR DIE HEIGHT LOCK <br><br><br> --}}

                                                        {{-- <label style="display: flex; justify-content: center; align-items: center;">MONTHLY CHECKPOINTS</label>
                                                        M1. SUCTION FILTER (NO CLOGGED IN OIL TANK)<br>
                                                        M2. HYDRAULIC SYSTEM (NO OIL LEAKAGE)<br>
                                                        M3. WIRING CONNECTIONS (FIRMLY TIGHTENED)<br>
                                                        M4. ELECTRICAL BOX (NO INGRESS OF OIL,WATER,DUST)<br>
                                                        M5. LIMIT SWITCH (NO DEFORMATION) --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnSave" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js_content')

<script>
    var dtDailyChecksheet;
    var checkSheetfunction;
    

    $(document).ready(function(e){
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth());
        $(".datepicker").datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months",
            // startDate: today,
        }).datepicker("setDate", "now");
        
        dtDailyChecksheet = $("#tblDailyChecksheet").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_daily_checksheet",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                { "data": "status" },
                { "data": "date" },
                { "data": "machine_id" },
            ],
           
        });

        $(".datepicker").on('change', function(){
            dtDailyChecksheet.draw();
        });
        $('#addChecksheet').on('click', function(){
            // let date = moment().format('MM-DD-YYYY');
            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            let month = moment().format('MM');
            getMachineForChecksheet($('#selMachine'));

            if(time >= "07:00" && time <= "19:29"){
                $('#txtShift').val('A')
            }
            else{
                $('#txtShift').val('B')
            }
            $('#txtCheckDate').val(date)
            $('#txtCheckTime').val(time)
            $('#txtMonth').val(month)
            

            $('#modalAddChecksheet').modal('show');
            
        });

        $('#formAddDailyChecksheet').submit(function(e){
            e.preventDefault();
            // saveChecksheet('Q121');

            $('#modalScanQRSave').modal('show');
            $('#modalScanQRSaveText').html('Please Scan Employee ID.')

        //    saveChecksheet();
        })

        $(document).on('keyup','#txtScanUserId', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,1,4,9,11], function(result){
                    if(result == true){
                        console.log('dito');
                        saveDailyChecksheet($('#txtScanUserId').val());
                    }
                    else{ // Error Handler
                        console.log('tanga');
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanUserId').val('');
                });
            }

        });

        $(document).on('click', '.btnCheck', function(e){
            let id = $(this).data('id');
            let tokin = "{{ csrf_token() }}";

            Swal.fire({
                title: "Do you want to approve this checklist?",
                icon: "question",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Approve",
                confirmButtonColor: "#17bf39",
                denyButtonText: `Disapprove`
            }).then((result) => {

                if (result.isConfirmed) {
                    changeStatusChecksheet(1, id, tokin);
                }
                else if (result.isDenied) {
                    Swal.fire({
                        title: 'Input Remarks',
                        html: '<textarea id="disapproveRemarks" rows="5" class="form-control" placeholder="Enter text here..."></textarea>',
                        showCancelButton: true,
                        confirmButtonText: 'Submit',
                        preConfirm: () => {
                            const textareaValue = $.trim($('#disapproveRemarks').val());
                            if (!textareaValue) {
                                Swal.showValidationMessage('Remarks cannot be empty!');
                            }
                            return textareaValue;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const remarks = result.value;
                            changeStatusChecksheet(2, id, tokin, remarks);

                        }
                    });
                    
                }
            });
        });

        $(document).on('click', '.btnView', function(e){
            let id = $(this).data('id');
            checkSheetfunction = $(this).data('function');

            console.log(checkSheetfunction);

            getChecksheet(id, checkSheetfunction);
        });

        $(document).on('click', '.btnEdit', function(e){
            let id = $(this).data('id');
            checkSheetfunction = $(this).data('function');
            console.log(checkSheetfunction);
            
            getChecksheet(id, checkSheetfunction);
        });

        $("#modalAddChecksheet").on('hidden.bs.modal', function () {
            console.log('hidden.bs.modal');
            $('#formAddDailyChecksheet')[0].reset();
            $('#txtDailyCheckSheetId').val('');
            $('input', $('#formAddDailyChecksheet')).prop('disabled', false);
            $('select', $('#formAddDailyChecksheet')).prop('disabled', false);
            $('#btnSave').show();
        });

    })
</script>

@endsection
@endauth
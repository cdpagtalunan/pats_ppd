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

        .text-block-header {
            display: none;
        }

        .hidden_scanner_input{
                position: absolute;
                opacity: 0;
            }
            textarea{
                resize: none;
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
                                    <div>
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="Daily-tab" data-bs-toggle="tab" href="#dailyChecksheetTab" role="tab" aria-controls="dailyChecksheetTab" aria-selected="true">Daily Checksheet</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="Weekly-tab" data-bs-toggle="tab" href="#weeklyChecksheet" role="tab" aria-controls="weeklyChecksheet" aria-selected="false">Weekly Checksheet</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="Monthky-tab" data-bs-toggle="tab" href="#monthlyChecksheet" role="tab" aria-controls="monthlyChecksheet" aria-selected="false">Monthly Checksheet</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="dailyChecksheetTab" role="tabpanel" aria-labelledby="dailyChecksheetTab-tab"><br>
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary float-end" id="addDailyCheckSheet" >Add Daily Checksheet</button>
                                            </div><br><br>
                                            <div class="table-responsive">
                                                <table id="tblDailyChecksheet" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                        <th>Date</th>
                                                        <th>Machine</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show" id="weeklyChecksheet" role="tabpanel" aria-labelledby="weeklyChecksheet-tab"><br>
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary float-end" id="addWeeklyChecksheet" >Add Weekly Checksheet</button>
                                            </div><br><br>
                                            <div class="table-responsive">
                                                <table id="tblWeeklyChecksheet" class="table table-sm table-bordered table-striped table-hover"
                                                style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Month</th>
                                                            <th>Week</th>
                                                            <th>Machine</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show" id="monthlyChecksheet" role="tabpanel" aria-labelledby="monthlyChecksheet-tab"><br>
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary float-end" id="addMonthlyChecksheet" >Add Monthly Checksheet</button>
                                            </div><br><br>
                                            <div class="table-responsive">
                                                <table id="tblMonthlyChecksheet" class="table table-sm table-bordered table-striped table-hover"
                                                style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Month</th>
                                                            <th>Machine</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
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

    <div class="modal fade" id="modalAddDailyChecksheet" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Press Stamping Machine Checksheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddDailyChecksheet">
                    @csrf
                    <input type="hidden" id="txtDailyChkSheetId" name="daily_checksheet_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">UNIT NO</span>
                                            </div>
                                            <select class="form-control form-control-sm dailyUnitClass"  id="txtunitNo" name="unit_no" required>
                                                <option value="" selected disabled>--Select--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
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
                                            <input type="text" class="form-control form-control-sm" id="txtConformedByQC" name="conformed_by_qc" readonly>
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
                            <div id="KyoriHeaderId" class="card-header text-block-header">
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
                            <div id="kyoriBodyId" class="card-body p-2 text-block-header">
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
                                                            <input type="text" name="actual_measurement" id="txtActualMeasurement" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <label> </label><br>
                                                        <label>1.7 ~ 2.5</label>
                                                        <div class="form-group">
                                                            <input type="text" name="actual_measurement2" id="txtActualMeasurement2" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="result_13" id="">
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
                        <div class="card">
                            <div id="komatsuHeaderId" class="card-header text-block-header">
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
                            <div id="komatsuBodyId" class="card-body p-2 text-block-header">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            {{-- <div class="card-header p-2">
                                                <h6>A.1 Machines & Equipments</h6>
                                            </div> --}}
                                            <div class="card-body" >
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <label>D1</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <label>D1.1</label> <br><br>

                                                        <label>D2</label> <br>
                                                        <label>STD MEAS.</label> <br>
                                                        <label>ACTUAL MEAS.</label> <br>
                                                        <label>RESULT</label> <br><br>

                                                        <label>D3</label><br>
                                                        <label>STD MEAS.</label> <br>
                                                        <label>ACTUAL MEAS.</label> <br>
                                                        <label>RESULT</label> <br><br><br>

                                                        <label>D4</label><br>
                                                        <label>D5</label><br><br>
                                                        <label>D6</label><br><br>
                                                        <label>D7</label><br>
                                                        <label>D8</label><br>
                                                        <label>D9</label><br><br>
                                                        <label>D10</label><br>
                                                        <label>D11</label><br>
                                                        <label>D12</label><br>
                                                        <label>D13</label>

                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <label> </label><br><br>
                                                        <label>500 ~ 2000</label>
                                                        <div class="form-group">
                                                            <input type="text" name="komatsu_actual_measurement2" id="txtKomatsuActualMeasurement2" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>


                                                        <label> </label><br>
                                                        <label>0.4 ~ 0.6</label>
                                                        <div class="form-group">
                                                            <input type="text" name="komatsu_actual_measurement3" id="txtKomatsuActualMeasurement3" autocomplete="off">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div><br>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_7" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_8" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_9" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_10" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_11" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_12" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" name="komatsu_result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    NP
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" name="komatsu_result_13" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">DAILY CHECKPOINTS</label>
                                                        D1. OPERATIONAL PANEL<br>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D1.1. BUTTONS AND SWITCHES (FUNCTION/FREE FROM DUST)<br>
                                                        D2. MATERIAL OIL LEVEL GAUGE (STD LEVEL= 500~2000)<br>
                                                        D3. AIR PRESSURE GAUGE (STD PRESSURE = 0.4 ~ 0.6)<br>
                                                        D4. OIL PRESSURE VALVE (ON MODE)<br>
                                                        D5. SET-UP LAMP (FUNCTION)<br>
                                                        D6. SCRAP BOX (APPEARANCE)<br>
                                                        D7. SAFETY DOOR (FUNCTION / CONDITION)<br>
                                                        D8. ABNORMAL SOUND / VIBRATION<br>
                                                        D9. BOLSTER <br>
                                                        D10. GIVE OIL BOX<br>
                                                        D11. RAY TYPE SAFETY DEVICE<br>
                                                        D12. BUY-OFF STICKER<br>
                                                        D13. PREVENTIVE MAINTENANCE (PM) STICKER<br><br><br>
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
                        <button hidden type="button" id="btnCheck" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Check
                        </button>
                        <button hidden type="button" id="btnConform" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Conform
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalScanEngineeringId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formUpdateEngineeringStatus">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtDailyChkSheetId" name="daily_checksheet_id">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanEngineeringId" name="engineering_scanned_id" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanEngineeringId" name="engineering_scanned_id" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalScanEngineeringIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalScanQcId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formUpdateQcStatus">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtDailyChkSheetId" name="daily_checksheet_id">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQcId" name="qc_scanned_id" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanQcId" name="qc_scanned_id" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalScanQcIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

    
    <div class="modal fade" id="modalAddWeeklyChecksheet" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Press Stamping Machine Checksheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddWeeklyChecksheet">
                    @csrf
                    <input type="hidden" id="txtWeeklyChkSheetId" name="weekly_checksheet_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">UNIT NO</span>
                                            </div>
                                            <select class="form-control form-control-sm weeklyUnitClass" id="txtWeeklyUnitNo" name="weekly_unit_no">
                                                <option value="" selected disabled>--Select--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Division</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyCheckDiv" name="weekly_division" value="Operations Division" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Month</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyMonth" name="weekly_month" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Machine</span>
                                            </div>
                                            <select class="form-control select2bs4" id="selWeeklyMachine" name="machine_weekly" required></select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">AREA</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyArea" name="machine_area_weekly" value="Stamping" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyConformedBy" name="conformed_by_weekly" value="H. De Guzman" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONDUCTED BY (OPERATOR)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyConductedBy" name="conducted_by_weekly" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CHECKED BY (ENGINEER)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyCheckedBy" name="checked_by_weekly" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY (QC)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyConformedByQC" name="conformed_by_qc_weekly" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date/Time</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeeklyCheckDate" name="date_weekly" readonly>
                                            <input type="hidden" class="form-control form-control-sm" id="txtWeeklyCheckTime" name="time_weekly" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Week</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtWeek" name="week" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            {{-- <div class="card-header">
                            </div> --}}
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            {{-- <div class="card-header p-2">
                                                <h6>A.1 Machines & Equipments</h6>
                                            </div> --}}
                                            <div id="kyoriWeeklyDivId" class="card-body text-block-header">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>W1</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>W2</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>W3</label> 
                                                        </div>  
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_w1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_w1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_w2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_w2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="result_w3" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="result_w3" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">WEEKLY CHECKPOINTS</label>
                                                        W1. PRESSURE SWITCH FOR PNEUMATICS<br>
                                                        W2. PRESSURE SWITCH FOR LUBE OIL<br>
                                                        W3. PRESSURE SWITCH FOR DIE HEIGHT LOCK <br><br><br>

                                                        {{-- <label style="display: flex; justify-content: center; align-items: center;">MONTHLY CHECKPOINTS</label>
                                                        M1. SUCTION FILTER (NO CLOGGED IN OIL TANK)<br>
                                                        M2. HYDRAULIC SYSTEM (NO OIL LEAKAGE)<br>
                                                        M3. WIRING CONNECTIONS (FIRMLY TIGHTENED)<br>
                                                        M4. ELECTRICAL BOX (NO INGRESS OF OIL,WATER,DUST)<br>
                                                        M5. LIMIT SWITCH (NO DEFORMATION) --}}

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="komatsuWeeklyDivId" class="card-body text-block-header">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>W1</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>W2</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>W3</label> 
                                                        </div>  
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_w1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_w1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_w2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_w2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_w3" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_w3" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">WEEKLY CHECKPOINTS</label>
                                                        W1. MATERIAL FELT (CONDITION / APPEARANCE)<br>
                                                        W2. SOUND PROOF BOX (APPEARANCE / FUNCTION)<br>
                                                        W3. AIR TANK FILTER (CONDITION / APPEARANCE)<br><br><br>

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
                        <button type="submit" id="btnWeeklySave" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Save
                        </button>
                        <button hidden type="button" id="btnWeeklyCheck" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Check
                        </button>
                        <button hidden type="button" id="btnWeeklyConform" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Conform
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalScanQrSaveWeekly">
        <div class="modal-dialog modal-dialog-center">
          <div class="modal-content modal-sm ">
            {{-- <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> --}}
            <div class="modal-body">
              {{-- hidden_scanner_input --}}
              {{-- <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserId" name="scan_qr_code" autocomplete="off"> --}}
              <input type="text" class="w-100 hidden_scanner_input" id="txtScanUserIdWeekly" name="scan_id_weekly" autocomplete="off">
              <div class="text-center text-secondary"><span id="modalScanQrSaveWeeklyText">Please scan employee ID.</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
          </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

      <div class="modal fade" id="modalWeeklyScanEngineeringId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formUpdateWeeklyEngineeringStatus">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtWeeklyChkSheetId" name="weekly_checksheet_id">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtWeeklyScanEngineeringId" name="engineering_scanned_id" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtWeeklyScanEngineeringId" name="engineering_scanned_id" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalWeeklyScanEngineeringIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modalWeeklylScanQcId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formUpdateWeeklyQcStatus">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtWeeklyChkSheetId" name="weekly_checksheet_id">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQcWeeklyId" name="qc_scanned_weekly_id" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanQcWeeklyId" name="qc_scanned_weekly_id" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalWeeklylScanQcIdText">Please scan Employee ID</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </form>

            </div>
        <!-- /.modal-content -->
        </div>
            <!-- /.modal-dialog -->
    </div>

        
    <div class="modal fade" id="modalAddMonthlyChecksheet" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Press Stamping Machine Checksheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddMonthlyChecksheet">
                    @csrf
                    <input type="hidden" id="txtMonthlyChkSheetId" name="monthly_checksheet_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">UNIT NO</span>
                                            </div>
                                            <select class="form-control form-control-sm monthlyUnitClass" id="txtMonthlyUnitNo" name="monthly_unit_no">
                                                <option value="" selected disabled>--Select--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Division</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyCheckDiv" name="monthly_division" value="Operations Division" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Month</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyMonth" name="monthly_month" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-40">
                                                <span class="input-group-text w-100" id="basic-addon1">Machine</span>
                                            </div>
                                            <select class="form-control form-control-sm select2bs4" id="selMonthlyMachine" name="machine_monthly" required></select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">AREA</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyArea" name="machine_area_monthly" value="Stamping" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyConformedBy" name="conformed_by_monthly" value="H. De Guzman" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-60">
                                                <span class="input-group-text w-100" id="basic-addon1">CONDUCTED BY (OPERATOR)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyConductedBy" name="conducted_by_monthly" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CHECKED BY (ENGINEER)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyCheckedBy" name="checked_by_monthly" readonly>
                                        </div>
                                    </div>
                                </div> 

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">CONFORMED BY (QC)</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyConformedByQC" name="conformed_by_qc_monthly" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date/Time</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtMonthlyCheckDate" name="date_monthly" readonly>
                                            <input type="hidden" class="form-control form-control-sm" id="txtMonthlyCheckTime" name="time_monthly" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Monthly Checksheet
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            {{-- <div id="kyoriMonthlyDivId" class="card-body text-block-header"> --}}
                                            <div id="kyoriMonthlyDivId" class="card-body">
                                                {{-- <div class="row">
                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">MONTHLY CHECKPOINTS</label>
                                                        M1. SUCTION FILTER (NO CLOGGED IN OIL TANK)<br>
                                                        M2. HYDRAULIC SYSTEM (NO OIL LEAKAGE)<br>
                                                        M3. WIRING CONNECTIONS (FIRMLY TIGHTENED)<br>
                                                        M4. ELECTRICAL BOX (NO INGRESS OF OIL,WATER,DUST)<br>
                                                        M5. LIMIT SWITCH (NO DEFORMATION)
                                                    </div>
                                                </div> --}}
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>M1</label>
                                                            <label style="margin-left: 120px;">Remarks</label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="1" name="result_m1" id="">
                                                            <label class="form-check-label" for="">
                                                                ✓
                                                            </label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="2" name="result_m1" id="">
                                                            <label class="form-check-label" for="">
                                                                X
                                                            </label>

                                                        </div>
                                                            <input type="text" name="monthly_remarks1" id="txtMonthlyRemarks1">

                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label style="display: flex; justify-content: center; align-items: center;">MONTHLY CHECKPOINTS</label>
                                                        M1. SUCTION FILTER (NO CLOGGED IN OIL TANK)<br>
                                                        M2. HYDRAULIC SYSTEM (NO OIL LEAKAGE)<br>
                                                        M3. WIRING CONNECTIONS (FIRMLY TIGHTENED)<br>
                                                        M4. ELECTRICAL BOX (NO INGRESS OF OIL,WATER,DUST)<br>
                                                        M5. LIMIT SWITCH (NO DEFORMATION)
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>M2</label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="2" name="result_m2" id="">
                                                            <label class="form-check-label" for="">
                                                                ✓
                                                            </label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="2" name="result_m2" id="">
                                                            <label class="form-check-label" for="">
                                                                X
                                                            </label>

                                                        </div>
                                                            <input type="text" name="monthly_remarks2" id="txtMonthlyRemarks2">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>M3</label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="3" name="result_m3" id="">
                                                            <label class="form-check-label" for="">
                                                                ✓
                                                            </label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="3" name="result_m3" id="">
                                                            <label class="form-check-label" for="">
                                                                X
                                                            </label>

                                                        </div>
                                                            <input type="text" name="monthly_remarks3" id="txtMonthlyRemarks3">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>M4</label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="4" name="result_m4" id="">
                                                            <label class="form-check-label" for="">
                                                                ✓
                                                            </label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="4" name="result_m4" id="">
                                                            <label class="form-check-label" for="">
                                                                X
                                                            </label>

                                                        </div>
                                                            <input type="text" name="monthly_remarks4" id="txtMonthlyRemarks4">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>M5</label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="5" name="result_m5" id="">
                                                            <label class="form-check-label" for="">
                                                                ✓
                                                            </label>
                                                        </div>

                                                        <div class="form-check  form-check-inline">
                                                            <input class="form-check-input" type="radio" value="5" name="result_m5" id="">
                                                            <label class="form-check-label" for="">
                                                                X
                                                            </label>

                                                        </div>
                                                            <input type="text" name="monthly_remarks5" id="txtMonthlyRemarks5">
                                                    </div>

                                                </div>

                                            </div>

                                            <div id="komatsuMonthlyDivId" class="card-body text-block-header">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label>M1</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>M2</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_m1" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_m1" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" name="komatsu_result_m2" id="">
                                                                <label class="form-check-label" for="">
                                                                    ✓
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" name="komatsu_result_m2" id="">
                                                                <label class="form-check-label" for="">
                                                                    X
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <div>
                                                                <label>Remarks</label>
                                                                <input type="text" name="komatsu_monthly_remarks1" id="txtKomatsuRemarksId1">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div>
                                                                <label>Remarks</label>
                                                                <input type="text" name="komatsu_monthly_remarks2" id="txtKomatsuRemarksId2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label style="display: flex; justify-content: center; align-items: center;">MONTHLY CHECKPOINTS</label>
                                                        M1. GIB LUBRICATION OIL (NORMAL LEVEL)<br>
                                                        M2. GEAR CHAMBER OIL LEVEL GAUGE (NORMAL LEVEL)<br>
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
                        <button type="submit" id="btnMonthlySave" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Save
                        </button>
                        <button hidden type="button" id="btnMonthlyCheck" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Check
                        </button>
                        <button hidden type="button" id="btnMonthlyConform" class="btn btn-primary">
                            <i class="fa fa-check"></i>
                            Conform
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalScanQrSaveMonthly">
        <div class="modal-dialog modal-dialog-center">
          <div class="modal-content modal-sm ">
            {{-- <div class="modal-header">
              <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> --}}
            <div class="modal-body">
              {{-- hidden_scanner_input --}}
              {{-- <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanUserId" name="scan_qr_code" autocomplete="off"> --}}
              <input type="text" class="w-100 hidden_scanner_input" id="txtScanUserIdMonthly" name="scan_id_monthly" autocomplete="off">
              <div class="text-center text-secondary"><span id="modalScanQrSaveMonthlyText">Please scan employee ID.</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
          </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

@endsection

@section('js_content')

<script>
    var dtDailyChecksheet;
    var checkSheetfunction;
    var dtWeeklyChecksheet;
    var dtMonthlyChecksheet;
    

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
                { "data": "machine_details.machine_name" },
            ],
           
        });

        dtWeeklyChecksheet = $("#tblWeeklyChecksheet").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_weekly_checksheet",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                { "data": "status" },
                { "data": "month" },
                { "data": "week" },
                { "data": "machine_details.machine_name" },
            ],
        });

        dtMonthlyChecksheet = $("#tblMonthlyChecksheet").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_monthly_checksheet",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                { "data": "status" },
                { "data": "month" },
                { "data": "machine_details.machine_name" },
            ],
        });


        $(".datepicker").on('change', function(){
            dtDailyChecksheet.draw();
        });
        $('#addDailyCheckSheet').on('click', function(){
            // let date = moment().format('MM-DD-YYYY');
            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            let month = moment().format('MM');
            getMachineForChecksheet($('#selMachine'));

            $('#txtCheckDate').val(date)
            $('#txtCheckTime').val(time)
            $('#txtMonth').val(month)
            $('#modalAddDailyChecksheet').modal('show');
            
        });

        let dailyUnitValue;
        let dailyMachinevalue;
      
        
        $('.dailyUnitClass').change(function (e) { 
            e.preventDefault();
            dailyUnitValue = $(this).val();
            $('#selMachine').change(function (e) { 
                // e.preventDefault();
                dailyMachinevalue = $('#selMachine').val();
                if(dailyMachinevalue == 2 && dailyUnitValue == 4){
                    $('#KyoriHeaderId').removeClass('text-block-header')
                    $('#kyoriBodyId').removeClass('text-block-header')
                }else if(dailyMachinevalue == 4 && dailyUnitValue == 3){
                    $('#komatsuHeaderId').removeClass('text-block-header')
                    $('#komatsuBodyId').removeClass('text-block-header')
                }
                else{
                    $('#KyoriHeaderId').addClass('text-block-header')
                    $('#kyoriBodyId').addClass('text-block-header')
                    $('#komatsuHeaderId').addClass('text-block-header')
                    $('#komatsuBodyId').addClass('text-block-header')
                }
            });
        });

        $('#formAddDailyChecksheet').submit(function(e){
            e.preventDefault();

            $('#modalScanQRSave').modal('show');
            $('#modalScanQRSaveText').html('Please Scan Employee ID.')

        })

        $(document).on('keyup','#txtScanUserId', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,1,4,9,11], function(result){
                    if(result == true){
                        saveDailyChecksheet($('#txtScanUserId').val());
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanUserId').val('');
                });
            }

        });

        let dailyCheckSheetId;
        let dailyCheckSheetStatus;

        
        $(document).on('click', '.btnView', function(e){
            dailyCheckSheetStatus = $(this).data('status')
            dailyCheckSheetId = $(this).data('id');

            console.log(dailyCheckSheetId);

            $('#txtDailyChkSheetId').val(dailyCheckSheetId)
            setTimeout(() => {
                getDailyChecksheet(dailyCheckSheetId, dailyCheckSheetStatus);
            }, 500);

        });

        $(document).on('click', '#btnCheck', function(e){
            e.preventDefault();
            $('#modalScanEngineeringId').modal('show');
        });

        $('#modalScanEngineeringId').on('shown.bs.modal', function () {
            $('#txtScanEngineeringId').focus();
        });

        $('#formUpdateEngineeringStatus').submit(function(e){
            e.preventDefault();
        });

        $('#txtScanEngineeringId').on('keyup', function(e){
            e.preventDefault();
                let toScanEmpId =  $('#txtScanEngineeringId').val();
                let checksheetId   =  $('#txtDailyChkSheetId').val();
                let scannedEmpId = {
                'scanned_emp_id' : toScanEmpId,
                'daily_checksheet_id' : checksheetId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,9], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateEngineeringStatus').serialize()+ '&' + $.param(scannedEmpId);
                            $.ajax({
                                type: "post",
                                url: "update_status_checked_by",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateEngineeringStatus")[0].reset();
                                        $("#formAddDailyChecksheet")[0].reset();
                                        $('#modalAddDailyChecksheet').modal('hide');
                                        $('#modalScanEngineeringId').modal('hide');
                                        dtDailyChecksheet.draw();
                                    }
                                }
                            });
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanEngineeringId').val('');
                });
                $(this).val('');
            }
        });

        $(document).on('click', '#btnConform', function(e){
            e.preventDefault();
            $('#modalScanQcId').modal('show');
        });

        $('#modalScanQcId').on('shown.bs.modal', function () {
            $('#txtScanQcId').focus();
        });

        $('#formUpdateQcStatus').submit(function(e){
            e.preventDefault();
        });

        $('#txtScanQcId').on('keyup', function(e){
            e.preventDefault();
                let toScanEmpId =  $('#txtScanQcId').val();
                let checksheetId   =  $('#txtDailyChkSheetId').val();
                let scannedEmpId = {
                'scanned_qc_id' : toScanEmpId,
                'daily_checksheet_id' : checksheetId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,2,5], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateQcStatus').serialize()+ '&' + $.param(scannedEmpId);
                            $.ajax({
                                type: "post",
                                url: "update_status_conformed_by",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateQcStatus")[0].reset();
                                        $('#modalAddDailyChecksheet').modal('hide');
                                        $("#formAddDailyChecksheet")[0].reset();
                                        $('#modalScanQcId').modal('hide');
                                        dtDailyChecksheet.draw();
                                    }
                                }
                            });
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanQcId').val('');
                });
                $(this).val('');
            }
        });

        $("#modalAddDailyChecksheet").on('hidden.bs.modal', function () {
            // console.log('hidden.bs.modal');
            $('#KyoriHeaderId').addClass('text-block-header')
            $('#kyoriBodyId').addClass('text-block-header')
            $('#formAddDailyChecksheet')[0].reset();
            $('#txtDailyCheckSheetId').val('');
            $('input', $('#formAddDailyChecksheet')).prop('disabled', false);
            $('select', $('#formAddDailyChecksheet')).prop('disabled', false);
            $('#btnSave').show();
        });

        // WEEKLY
    
        let weeklyUnitValue;
        let weeklyMachinevalue;

        $('.weeklyUnitClass').change(function (e) { 
            e.preventDefault();
            weeklyUnitValue = $(this).val();
            $('#selWeeklyMachine').change(function (e) { 
                // e.preventDefault();
                weeklyMachinevalue = $('#selWeeklyMachine').val();
                if(weeklyMachinevalue == 2 && weeklyUnitValue == 4){
                    $('#kyoriWeeklyDivId').removeClass('text-block-header')
                }else if(weeklyMachinevalue == 4 && weeklyUnitValue == 3){
                    $('#komatsuWeeklyDivId').removeClass('text-block-header')
                }
                else{
                    $('#kyoriWeeklyDivId').addClass('text-block-header')
                    $('#komatsuWeeklyDivId').addClass('text-block-header')
                }
            });
        });

        $('#addWeeklyChecksheet').on('click', function(){
            // let date = moment().format('MM-DD-YYYY');
            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            let month = moment().format('MMMM');
            
            var dated = new Date();
            var weekOfMonth = (0 | dated.getDate() / 6)+1;
            
            // console.log(dated.getDate());

            getMachineForChecksheet($('#selWeeklyMachine'));

            $('#txtWeek').val(weekOfMonth)
            $('#txtWeeklyCheckDate').val(date)
            $('#txtWeeklyCheckTime').val(time)
            $('#txtWeeklyMonth').val(month)
            
            $('#modalAddWeeklyChecksheet').modal('show');
            
        });

        
        $('#formAddWeeklyChecksheet').submit(function(e){
            e.preventDefault();

            $('#modalScanQrSaveWeekly').modal('show');
            $('#modalScanQrSaveWeeklyText').html('Please Scan Employee ID.')
        })

        $(document).on('keyup','#txtScanUserIdWeekly', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,1,4,9,11], function(result){
                    if(result == true){
                        // console.log('pasok');
                        saveWeeklyChecksheet($('#txtScanUserIdWeekly').val());
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanUserIdWeekly').val('');
                });
            }
        });

        let weeklyChecksheetStatus;
        let weeklyChecksheetId

        $(document).on('click', '.btnViewWeeklyChecksheet', function(e){
            weeklyChecksheetStatus = $(this).data('status')
            weeklyChecksheetId = $(this).data('id');

            $('#txtWeeklyChkSheetId').val(weeklyChecksheetId)

            console.log('weeklyChecksheetStatus', weeklyChecksheetStatus);

            // setTimeout(() => {
            getWeeklyChecksheet(weeklyChecksheetId, weeklyChecksheetStatus);
            // }, 1000);

        });

        $(document).on('click', '#btnWeeklyCheck', function(e){
            e.preventDefault();
            $('#modalWeeklyScanEngineeringId').modal('show');
        });

        $('#modalWeeklyScanEngineeringId').on('shown.bs.modal', function () {
            $('#txtWeeklyScanEngineeringId').focus();
        });

        $('#formUpdateWeeklyEngineeringStatus').submit(function(e){
            e.preventDefault();
        });

        $('#txtWeeklyScanEngineeringId').on('keyup', function(e){
            e.preventDefault();
                let toScanWeeklyEmpId =  $('#txtWeeklyScanEngineeringId').val();
                let weeklyChecksheetId   =  $('#txtWeeklyChkSheetId').val();
                let scannedEmpWeekly = {
                'engineering_scanned_id' : toScanWeeklyEmpId,
                'weekly_checksheet_id' : weeklyChecksheetId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,9], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateWeeklyEngineeringStatus').serialize()+ '&' + $.param(scannedEmpWeekly);
                            $.ajax({
                                type: "post",
                                url: "update_status_weekly_check",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateWeeklyEngineeringStatus")[0].reset();
                                        $("#formAddWeeklyChecksheet")[0].reset();
                                        $('#modalAddWeeklyChecksheet').modal('hide');
                                        $('#modalWeeklyScanEngineeringId').modal('hide');
                                        dtWeeklyChecksheet.draw();
                                    }
                                }
                            });
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtWeeklyScanEngineeringId').val('');
                });
                $(this).val('');
            }
        });

        $(document).on('click', '#btnWeeklyConform', function(e){
            e.preventDefault();
            $('#modalWeeklylScanQcId').modal('show');
        });

        $('#modalWeeklylScanQcId').on('shown.bs.modal', function () {
            $('#txtScanQcWeeklyId').focus();
        });

        $('#formUpdateWeeklyQcStatus').submit(function(e){
            e.preventDefault();
        });

        $('#txtScanQcWeeklyId').on('keyup', function(e){
            e.preventDefault();
                let toScanEmpId =  $('#txtScanQcWeeklyId').val();
                let checksheetId   =  $('#txtWeeklyChkSheetId').val();
                let scannedEmpId = {
                'qc_scanned_weekly_id' : toScanEmpId,
                'weekly_checksheet_id' : checksheetId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,2,5], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateWeeklyQcStatus').serialize()+ '&' + $.param(scannedEmpId);
                            $.ajax({
                                type: "post",
                                url: "update_status_weekly_conformed",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateWeeklyQcStatus")[0].reset();
                                        $('#modalAddWeeklyChecksheet').modal('hide');
                                        $("#formAddWeeklyChecksheet")[0].reset();
                                        $('#modalWeeklylScanQcId').modal('hide');
                                        dtWeeklyChecksheet.draw();
                                    }
                                }
                            });
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanQcWeeklyId').val('');
                });
                $(this).val('');
            }
        });
        
        
        $("#modalAddWeeklyChecksheet").on('hidden.bs.modal', function () {
            // console.log('hidden.bs.modal');
            $('#kyoriWeeklyDivId').addClass('text-block-header')
            $('#komatsuWeeklyDivId').addClass('text-block-header')
            $('#formAddWeeklyChecksheet')[0].reset();
            $('#txtWeeklyCheckSheetId').val('');
            $('input', $('#formAddWeeklyChecksheet')).prop('disabled', false);
            $('select', $('#formAddWeeklyChecksheet')).prop('disabled', false);
            $('#btnWeeklySave').show();
        });

        // MONTHLY

        $('.monthlyUnitClass').change(function (e) { 
            e.preventDefault();
            MonthlyUnitValue = $(this).val();
            $('#selMonthlyMachine').change(function (e) { 
                // e.preventDefault();
                MonthlyMachinevalue = $('#selMonthlyMachine').val();
                if(MonthlyMachinevalue == 2 && MonthlyUnitValue == 4){
                    $('#kyoriMonthlyDivId').removeClass('text-block-header')
                }else if(MonthlyMachinevalue == 4 && MonthlyUnitValue == 3){
                    $('#komatsuMonthlyDivId').removeClass('text-block-header')
                }
                else{
                    $('#kyoriMonthlyDivId').addClass('text-block-header')
                    $('#komatsuMonthlyDivId').addClass('text-block-header')
                }
            });
        });

        $('#addMonthlyChecksheet').on('click', function(){
            // let date = moment().format('MM-DD-YYYY');
            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            let month = moment().format('MMMM');

            getMachineForChecksheet($('#selMonthlyMachine'));

            $('#txtMonth').val(month)
            $('#txtMonthlyCheckDate').val(date)
            $('#txtMonthlyCheckTime').val(time)
            $('#txtMonthlyMonth').val(month)
            
            $('#modalAddMonthlyChecksheet').modal('show');        
        });

        $('#formAddMonthlyChecksheet').submit(function(e){
            e.preventDefault();

            $('#modalScanQrSaveMonthly').modal('show');
            $('#modalScanQrSaveMonthlyText').html('Please Scan Employee ID.')
        })

        $(document).on('keyup','#txtScanUserIdMonthly', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,1,4,9,11], function(result){
                    if(result == true){
                        // console.log('pasok');
                        saveMonthlyChecksheet($('#txtScanUserIdMonthly').val());
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanUserIdMonthly').val('');
                });
            }
        });

        let monthlyChecksheetStatus;
        let monthlyChecksheetId

        $(document).on('click', '.btnViewMonthlyChecksheet', function(e){
            monthlyChecksheetStatus = $(this).data('status')
            monthlyChecksheetId = $(this).data('id');

            $('#txtmonthlyChkSheetId').val(monthlyChecksheetId)

            console.log('monthlyChecksheetStatus', monthlyChecksheetStatus);
            console.log('monthlyChecksheetId', monthlyChecksheetId);

            // setTimeout(() => {
            getMonthlyChecksheet(monthlyChecksheetId, monthlyChecksheetStatus);
            // }, 1000);

        });

        $("#modalAddMonthlyChecksheet").on('hidden.bs.modal', function () {
            // console.log('hidden.bs.modal');
            // $('#kyoriMonthlyDivId').addClass('text-block-header')
            $('#komatsuMonthlyDivId').addClass('text-block-header')
            $('#formAddMonthlyChecksheet')[0].reset();
            $('#txtmonthlyChkSheetId').val('');
            $('input', $('#formAddMonthlyChecksheet')).prop('disabled', false);
            $('select', $('#formAddMonthlyChecksheet')).prop('disabled', false);
            $('#btnMonthlySave').show();
        });

        // 

    })
</script>

@endsection
@endauth
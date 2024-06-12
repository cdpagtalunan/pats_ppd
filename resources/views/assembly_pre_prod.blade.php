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
                        <h1>Assembly Pre-Prod</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Assembly Pre-Prod</li>
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
                                        <input type="text" id="selMonth" name="" class="datepicker form-control"/>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-5">
                                        <span>NOTE:</span><br>
                                        <span>1. Production Operator in-charge shall perform the inspection items indicated</span><br>
                                        <span>2. Conduct pre-production inspection on the ff. machine activity</span><br>
                                        <span><b>SW - </b> Start of Work</span>&nbsp;&nbsp;&nbsp;
                                        <span><b>EW - </b>End of Work</span>&nbsp;&nbsp;&nbsp;
                                        <span><b>AA - </b>After Adjustment</span>&nbsp;&nbsp;&nbsp;
                                        <span><b>C - </b>Conversion</span><br>
                                        <span>3. If NO PRODUCTION, NP shall be written on issue log portion.</span><br>
                                    </div>
    
                                    <div style="text-align: left;" class="col-sm-7">
                                        <br>
                                        <span>4. If the item has a problem inform the Techinician or Engineer for counter check and corrective action.</span><br>
                                        <span>5. Repeat pre-production after corrective action was done.</span><br>
                                        <span>6. Record on the Equip't downtime report the specific problem (by Prod'n) and action conducted (by Eng'g).</span><br>
                                        <span>7. Refer to required product drawing for Dimension/Specification requirement.</span>
                                    </div>
                                </div>
                            </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Daily-tab" data-bs-toggle="tab" href="#assemblyPreProdTab" role="tab" aria-controls="assemblyPreProdTab" aria-selected="true">Assembly Pre-Prod Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Weekly-tab" data-bs-toggle="tab" href="#issueLog" role="tab" aria-controls="issueLog" aria-selected="false">Issue Log</a>
                                        </li>
                                        
                                    </ul>
                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="assemblyPreProdTab" role="tabpanel" aria-labelledby="assemblyPreProdTab-tab"><br>
                                            
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary float-end" id="addAssemblyPreProd" >Add Assembly Pre-Prod</button>
                                            </div><br><br>
                                            <div class="table-responsive">
                                                <table id="tblAssemblyPreProd" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                        <th>Equipment Name</th>
                                                        <th>Machine Code</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade show" id="issueLog" role="tabpanel" aria-labelledby="issueLog-tab"><br>
                                            <div class="col-sm-12">
                                                <button type="button" class="btn btn-primary float-end" id="addIssue" >Add Issue</button>
                                            </div><br><br>
                                            <div class="table-responsive">
                                                <table id="tblIssueLog" class="table table-sm table-bordered table-striped table-hover"
                                                style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            {{-- <th>Status</th> --}}
                                                            <th>Date</th>
                                                            <th>Issue</th>
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

    <div class="modal fade" id="modalAddAssemblyPreProd" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Assembly Pre-Prod</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddAssemblyPreProd">
                    @csrf
                    <input type="hidden" id="txtAssemblyPreProdId" name="assembly_pre_prod_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Equipment Name</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtEquipmentName" name="equipment_name" autocomplete="off">
                                        </div>
                                    </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Machine Code</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtMachineCode" name="machine_code" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Month</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtMonth" name="month" readonly>
                                            </div>
                                        </div>
{{-- 
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Creation Date</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtCreationDate" name="creation_date" readonly>
                                            </div>
                                        </div> --}}
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Conducted by Operator</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtConductedByOperator" name="conducted_by" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Checked by Tech/Eng</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckByTechEng" name="checked_by_tech_eng" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Conformed by QC</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtConformByQc" name="conform_by_qc" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    
                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Year</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtYear" name="year" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card">
                            <div id="preProdLegendHeader" class="card-header">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <b>
                                            LEGEND :
                                            </b> <br>
                                            <b>
                                                SW - Start of Work
                                            </b> <br>
                                            <b>
                                                EW - End of Work
                                            </b> <br>
                                            <b>
                                                AA - After Adjustment
                                            </b>
                                        </div>
                                        <div class="col-lg-2">
                                            <b>
                                            O = OK <br> X = NG <br> C = Conversion <br> N/A = NOT APPLICABLE
                                            </b>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtRemarks" name="remarks" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Date/Time</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtCheckDate" name="date">
                                                        <input type="text" class="form-control form-control-sm" id="txtCheckTime" name="time">
                                                    </div>
                                                </div>
                                                <div class="mt-1">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">Shift</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="txtShift" name="shift">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Daily Check
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck1 --}}
                                <div class="row">
                                    <div class="col-sm-2">
                                        {{-- <span>1</span> --}}
                                    </div>
                                    <div class="col-sm-3">
                                            <span>Clean the Lazer marker lense</span>
                                    </div>

                                    <div style="float: left;" class="col-sm-7">
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="check_1" id="txtCheckOkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="check_1" id="txtCheckXId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="check_1" id="txtCheckConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="check_1" id="txtCheckNaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>1</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <span>Clean the Loading Jig</span>
                                    </div>
                                    
                                    <div style="float: left;" class="col-sm-7">
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="check_2" id="txtCheck2OkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="check_2" id="txtCheck2XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="check_2" id="txtCheck2ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="check_2" id="txtCheck2NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-2">
                                        {{-- <span>1</span> --}}
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Clean the Application nozzle tip</span>
                                    </div>
                                    
                                    <div style="float: left;" class="col-sm-7">
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="check_3" id="txtCheck3ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="check_3" id="txtCheck3XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="check_3" id="txtCheck3ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="check_3" id="txtCheck3NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck2 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>2</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check and record Air Pressure</span><br>
                                        <span>Specs: 0.50 ± 0.05MPa</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <span>Value</span>
                                        <div>
                                        <input type="text" name="value_1" id="txtValue1Id" autocomplete="off">

                                        </div>
                                    </div>
                                    <div style="float: left;" class="col-sm-3">
                                        <span>Judgement</span>
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="judgement_1" id="txtJudgment1ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="judgement_1" id="txtJudgment1XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="judgement_1" id="txtJudgment1ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="judgement_1" id="txtJudgment1NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck3 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>3</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check and record Tank Pressure</span><br>
                                        <span>Settings: 0.04 - 0.05MPa</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <span>Value</span>
                                        <div>
                                        <input type="text" name="value_2" id="txtValue2Id" autocomplete="off">

                                        </div>
                                    </div>
                                    <div style="float: left;" class="col-sm-3">
                                        <span>Judgement</span>
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="judgement_2" id="txtJudgment2ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="judgement_2" id="txtJudgment2XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="judgement_2" id="txtJudgment2ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="judgement_2" id="txtJudgment2NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck4 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>4</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check and record Spray Air Pressure</span><br>
                                        <span>Settings: 0.07 - 0.08MPa</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <span>Value</span>
                                        <div>
                                        <input type="text" name="value_3" id="txtValue3Id" autocomplete="off">

                                        </div>
                                    </div>
                                    <div style="float: left;" class="col-sm-3">
                                        <span>Judgement</span>
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="judgment_3" id="txtJudgment3ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="judgment_3" id="txtJudgment3XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="judgment_3" id="txtJudgment3ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="judgment_3" id="txtJudgment3NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck5 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>5</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check the spray scale (fixed to 3.5)</span><br>
                                    </div>

                                    <div class="col-sm-3">
                                        <div>
                                        <input type="text" name="value_4" id="txtValue4Id" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck6 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>6</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check and record Spray flowmeter set value</span><br>
                                        <span>Application Amount: 0.15 +0.10/-0.05</span>
                                    </div>

                                    <div class="col-sm-3">
                                        <span>Value</span>
                                        <div>
                                        <input type="text" name="value_5" id="txtValue5Id" autocomplete="off">

                                        </div>
                                    </div>
                                    <div style="float: left;" class="col-sm-3">
                                        <span>Judgement</span>
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="judgment_5" id="txtJudgment5ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="judgment_5" id="txtJudgment5XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="judgment_5" id="txtJudgment5ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="judgment_5" id="txtJudgment5NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck7 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>7</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check the nozzle tip condition</span><br>
                                    </div>

                                    <div style="float: left;" class="col-sm-3">
                                        <span>Judgement</span>
                                        <div class="form-group">
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="judgment_6" id="txtJudgment6ChkId">
                                                <label class="form-check-label" for="">
                                                    O
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="judgment_6" id="txtJudgment6XId">
                                                <label class="form-check-label" for="">
                                                    X
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="judgment_6" id="txtJudgment6ConversionId">
                                                <label class="form-check-label" for="">
                                                    C
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="judgment_6" id="txtJudgment6NaId">
                                                <label class="form-check-label" for="">
                                                    N/A
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body p-2"> {{-- DailyCheck8 --}}
                                <div class="row">
                                    <div style="text-align: center;" class="col-sm-2">
                                        <span>8</span>
                                    </div>
                                    <div class="col-sm-3">
                                        <span>Check the print condition (N=5)</span><br>
                                    </div>

                                    <div class="col-sm-3">
                                        <div>
                                        <input type="text" name="value_6" id="txtValue6Id" autocomplete="off">
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

    <div class="modal fade" id="modalAddIssue" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Issue Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddIssue" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtIssueId" name="issue_id">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Issue</label>
                                    <input type="text" class="form-control form-control-sm" name="issue" id="txtIssue">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control form-control-sm" name="issue_date" id="txtIssueDate" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddIssue" class="btn btn-primary"><i id="btnAddIssueIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalScanEngineeringId">
        <div class="modal-dialog center">
            <div class="modal-content modal-sm">
                <form id="formUpdateEngineeringStatus">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtAssemblyCheckedPreProdId" name="assembly_checked_pre_prod_id">
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
                        <input type="hidden" id="txtAssemblyConformedPreProdId" name="assembly_conformed_pre_prod_id">
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

@endsection

@section('js_content')

<script>
    var dtAssemblyPreProd;
    var dtIssueLogs;

    $(document).ready(function(e){        

        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth());

        $(".datepicker").datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months",
            // startDate: today,
        }).datepicker("setDate", "now");

        dtAssemblyPreProd = $("#tblAssemblyPreProd").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_assembly_pre_prod",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                { "data": "status" },
                { "data": "equipment_name" },
                { "data": "machine_code" },
                { "data": "date" },
            ],
        
        });

        dtIssueLogs = $("#tblIssueLog").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_issue_logs",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                // { "data": "status" },
                { "data": "date" },
                { "data": "issue" },
            ],
        
        });

        $('#addAssemblyPreProd').on('click', function(){

            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            let year = moment().format('YYYY');
            let month = moment().format('MM');

            $('#txtCheckDate').val(date)
            $('#txtCheckTime').val(time)
            $('#txtMonth').val(month)
            $('#txtYear').val(year)
            $('#txtCreationDate').val(date)

            $('#modalAddAssemblyPreProd').modal('show');     
        });

        $('#formAddAssemblyPreProd').submit(function(e){
            e.preventDefault();

            $('#modalScanQRSave').modal('show');
            $('#modalScanQRSaveText').html('Please Scan Employee ID.')

        })

        $(document).on('keyup','#txtScanUserId', function(e){
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,1,4,9,11], function(result){
                    if(result == true){
                        saveAssemblyPreProdData($('#txtScanUserId').val());
                    }
                    else{ // Error Handler
                        toastr.error('User not authorize!');
                    }
                    $('#txtScanUserId').val('');
                });
            }

        });

        let assemblyPreProdStatus;
        let assemblyPreProdId

        $(document).on('click', '.btnView', function(e){
            assemblyPreProdStatus = $(this).attr('assembly-status')
            assemblyPreProdId = $(this).data('id');

            $('#txtAssemblyPreProdId').val(assemblyPreProdId)
            $('#txtAssemblyCheckedPreProdId').val(assemblyPreProdId)
            $('#txtAssemblyConformedPreProdId').val(assemblyPreProdId)

            setTimeout(() => {
                getAssemblyPreProd(assemblyPreProdId, assemblyPreProdStatus);
            }, 500);

        });

        $('#btnCheck').on('click', function(e){
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
                // let assemblyId   =  $('#txtAssemblyCheckedPreProdId').val();
                let scannedEmpId = {
                'scanned_emp_id' : toScanEmpId,
                // 'assembly_pre_prod_id' : assemblyId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,9], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateEngineeringStatus').serialize()+ '&' + $.param(scannedEmpId);
                            $.ajax({
                                type: "post",
                                url: "update_assembly_pre_prod_checked_status",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateEngineeringStatus")[0].reset();
                                        $("#formAddAssemblyPreProd")[0].reset();
                                        $('#modalAddAssemblyPreProd').modal('hide');
                                        $('#modalScanEngineeringId').modal('hide');
                                        dtAssemblyPreProd.draw();
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

        $('#btnConform').on('click', function(e){
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
                // let assemblyId   =  $('#txtAssemblyCheckedPreProdId').val();
                let scannedEmpId = {
                'scanned_emp_id' : toScanEmpId,
                // 'assembly_pre_prod_id' : assemblyId
                }
            if(e.keyCode == 13){
                validateUser($(this).val().toUpperCase(), [0,2,5], function(result){
                    // alert('asdasdasd');
                    if(result == true){
                        let data2 = $('#formUpdateQcStatus').serialize()+ '&' + $.param(scannedEmpId);
                            $.ajax({
                                type: "post",
                                url: "update_assembly_pre_prod_conform_status",
                                data: data2,
                                dataType: "json",
                                success: function (response) {
                                    if(response['validation'] == 1){
                                        toastr.error('Saving data failed!');

                                    }else if(response['result'] == 0){
                                        toastr.success('Validation Succesful!');
                                        $("#formUpdateQcStatus")[0].reset();
                                        $("#formAddAssemblyPreProd")[0].reset();
                                        $('#modalAddAssemblyPreProd').modal('hide');
                                        $('#modalScanQcId').modal('hide');
                                        dtAssemblyPreProd.draw();
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




        $('#addIssue').on('click', function(){

            let date = moment().format('YYYY-MM-DD');
            $('#txtIssueDate').val(date)

            $('#modalAddIssue').modal('show');     
        });

        $('#formAddIssue').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "add_issue",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response){
                        if(response['validation'] == 1){
                            toastr.error('Saving data failed!');
                            if(response['error']['issue'] === undefined){
                                $("#txtIssue").removeClass('is-invalid');
                                $("#txtIssue").attr('title', '');
                            }
                            else{
                                $("#txtIssue").addClass('is-invalid');
                                $("#txtIssue").attr('title', response['error']['issue']);
                            }
                            if(response['error']['issue_date'] === undefined){
                                $("#txtIssueDate").removeClass('is-invalid');
                                $("#txtIssueDate").attr('title', '');
                            }
                            else{
                                $("#txtIssueDate").addClass('is-invalid');
                                $("#txtIssueDate").attr('title', response['error']['issue_date']);
                            }

                        }else if(response['result'] == 0){
                            $("#formAddIssue")[0].reset();
                            toastr.success('Succesfully saved!');
                            $('#modalAddIssue').modal('hide');
                            dtIssueLogs.draw();
                        }

                        $("#btnAddIssueIcon").removeClass('spinner-border spinner-border-sm');
                        $("#btnAddIssue").removeClass('disabled');
                        $("#btnAddIssueIcon").addClass('fa fa-check');
                    },
                    error: function(data, xhr, status){
                        toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
                });

                
        });

        let issueLogsId

        $(document).on('click', '.btnViewLogs', function(e){
            issueLogsId = $(this).data('id');

            $('#txtIssueId').val(issueLogsId)

            // setTimeout(() => {
            getIssueLogs(issueLogsId);
            // }, 1000);

        });

        $("#modalAddAssemblyPreProd").on('hidden.bs.modal', function () {
            $('#formAddAssemblyPreProd')[0].reset();
            // alert('heeey');
        });

    });
</script>

@endsection
@endauth
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
                            <li class="breadcrumb-item active">5S Checksheet</li>
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
                                            <button type="button" class="btn btn-primary float-end" id="addChecksheet" >Add Checksheet</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                <table id="tblChecksheet" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th>Machine</th>
                                                            <th>Shift</th>
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
                    <h5 class="modal-title">5S - Checksheet - STAMPING</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddChecksheet">
                    @csrf
                    <input type="hidden" id="txtCheckId" name="checksheet_id">
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Assembly Line</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" value="Production Area" id="txtCheckAssLine" name="asmbly_line" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Dep't/Section</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtDeptSect" name="dept_sect"  value="PPS - Stamping Section" readonly>
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
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Over-all in Charge</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckOIC" name="oic" value="H. De Guzman" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date/Time</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckDate" name="date" readonly>
                                            <input type="hidden" class="form-control form-control-sm" id="txtCheckTime" name="time" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Checked By:</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckBy" name="check_by" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Conducted By</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtCheckCondBy" name="conduct_by" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Shift</span>
                                            </div>
                                            <input type="text" class="form-control form-control-sm" id="txtShift" name="shift" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Machine</span>
                                            </div>
                                            {{-- <input type="text" class="form-control form-control-sm" id="txtMachine" name="machine"> --}}
                                            <select class="form-control select2bs4" id="selMachine" name="machine" required></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend w-25">
                                                <span class="input-group-text w-100" id="basic-addon1" >Remarks</span>
                                            </div>
                                            <textarea class="form-control" id="txtRemarks" name="remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Checksheet
                            </div>
                            <div class="card-body p-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <h6>A.1 Machines & Equipments</h6>
                                            </div>
                                            <div class="card-body" >
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>A.1.1 Sound proof body surface</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA1_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA1_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA1_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA1_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>A.1.2 Clamping/ Purging Area (no purged naterials, product or scattered resin)</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA1_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA1_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA1_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA1_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>A.1.3 Product Drop (no oil,dust, and unrelated product)</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA1_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA1_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA1_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA1_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>A.1.4 Base Part (no dust and oil spills)</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="1" required name="checkA1_4">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="2" required name="checkA1_4">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="3" required name="checkA1_4">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" value="4" required name="checkA1_4">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label> A.1.5 Sorrounding of Machine Area (No dust, Oil stain/ Spill and scattered materials)</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA1_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA1_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA1_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA1_5" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>A.1.6 "NO" contact- units and correlation samples on top of machine, top of scope, sorrounding  and floor.</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA1_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA1_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA1_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA1_6" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <h6>A.2 Accessories (no dust, no scattered resin and products)</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>  A.2.1 Reel winding machine</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA2_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA2_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA2_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA2_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label> A.2.2 CCD Camera</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA2_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA2_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA2_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA2_2" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>  A.2.3  Turntable</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA2_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA2_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA2_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA2_3" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label> A.2.4  Oil matic - temp controller</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA2_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA2_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA2_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA2_4" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-header p-2">
                                                <h6>A.3 Others</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <label>  A.3.1  Vacuum machine</label>
                                                        <div class="form-group">
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="1" name="checkA3_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    Yes
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="2" name="checkA3_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Good
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="3" name="checkA3_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    N/A
                                                                </label>
                                                            </div>
                                                            <div class="form-check  form-check-inline">
                                                                <input class="form-check-input" type="radio" required value="4" name="checkA3_1" id="">
                                                                <label class="form-check-label" for="">
                                                                    NO Work
                                                                </label>
                                                            </div>
                                                        </div>
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
    var dtDatatableChecksheet;
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
        
        dtDatatableChecksheet = $("#tblChecksheet").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "view_checksheet",
                data: function (param) {
                    param.month = $("#selMonth").val();
                }
            },
            fixedHeader: true,
            "columns": [
                { "data": "action" },
                { "data": "status" },
                { "data": "date" },
                { "data": "machine_name" },
                { "data": "shift" },
            ],
           
        });

        $(".datepicker").on('change', function(){
            dtDatatableChecksheet.draw();
        });
        $('#addChecksheet').on('click', function(){
            // let date = moment().format('MM-DD-YYYY');
            let date = moment().format('YYYY-MM-DD');
            let time = moment().format('kk:mm');
            getMachineForChecksheet($('#selMachine'));

            if(time >= "07:00" && time <= "19:29"){
                $('#txtShift').val('A')
            }
            else{
                $('#txtShift').val('B')
            }
            $('#txtCheckDate').val(date)
            $('#txtCheckTime').val(time)
            

            $('#modalAddChecksheet').modal('show');
            
        });
        $('#formAddChecksheet').submit(function(e){
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
                        saveChecksheet($('#txtScanUserId').val());
                    }
                    else{ // Error Handler
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

            getChecksheet(id, checkSheetfunction);
        });

        $(document).on('click', '.btnEdit', function(e){
            let id = $(this).data('id');
            checkSheetfunction = $(this).data('function');

            getChecksheet(id, checkSheetfunction);
        });

        $("#modalAddChecksheet").on('hidden.bs.modal', function () {
            console.log('hidden.bs.modal');
            $('#formAddChecksheet')[0].reset();
            $('#txtCheckId').val('');
            $('input', $('#formAddChecksheet')).prop('disabled', false);
            $('#txtRemarks', $('#formAddChecksheet')).prop('disabled', false);
            $('select', $('#formAddChecksheet')).prop('disabled', false);
            $('#btnSave').show();

        });

    })
</script>

@endsection
@endauth
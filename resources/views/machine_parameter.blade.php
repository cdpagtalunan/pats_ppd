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
        .hidden_scanner_input {
            position: absolute;
            opacity: 0;
        }

        textarea {
            resize: none;
        }

        #colDevice,
        #colMaterialProcess {
            transition: .5s;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            font-size: .75rem;
            padding: .0em 0.55vmax;
            margin-bottom: 0px;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple {
            pointer-events: none;
        }
    </style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Machine Parameter</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active">Machine Parameter</li>
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
                                <h3 class="card-title">Machine Parameter</h3>
                            </div>
                            <!-- Start Page Content -->
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#MachineParameter" type="button" role="tab">Form
                                            1</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#machineParameterForm2" type="button" role="tab">Form
                                            2</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="MachineParameter" role="tabpanel">
                                        <div class="text-right mt-4">
                                            <button type="button" class="btn btn-primary mb-3" id="btnAddMachine1"
                                                data-bs-toggle="modal" data-bs-target="#modalAddMachine1"><i
                                                    class="fa fa-plus fa-md"></i> Add Machine Parameter</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="tableMachineParameter_form1"
                                                class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                        <th>Machine Name</th>
                                                        <th>Device Name</th>
                                                        <th>Material Name</th>
                                                        <th>Machine No.</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="machineParameterForm2" role="tabpanel"
                                        aria-labelledby="tabmachineParameterForm2">
                                        <div style="float: right;">
                                            <div class="text-right mt-4">
                                                <button type="button" class="btn btn-primary mb-3" id="btnAddMachine2"
                                                    data-bs-toggle="modal" data-bs-target="#modalAddMachine2"><i
                                                        class="fa fa-plus fa-md"></i> Add Machine Parameter</button>
                                            </div>
                                        </div> <br><br>
                                        <div class="table-responsive">
                                            <table id="tableMachineParameter_form2"
                                                class="table table-sm table-bordered table-striped table-hover"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr style="text-align:center">
                                                        <th>Action</th>
                                                        <th>Status</th>
                                                        <th>Machine Name</th>
                                                        <th>Device Name</th>
                                                        <th>Material Name</th>
                                                        <th>Machine No.</th>
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

    <!-- Add User Modal Start -->
    <div class="modal fade" id="modalAddMachine1" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl-custom">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Add Machine Parameter</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formAddMachine1" autocomplete="off">
                    @csrf
                    <div class="modal-body-custom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For User Id -->
                                    <input type="hidden" name="machine_parameter_id" id="machineParameterId">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <label for="selectMachine" class="form-label"> Machine<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <div>
                                                <select class="form-select select2" id="selectMachine1"
                                                    name="machine_id">
                                                    <!-- Auto Generated -->
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label class="form-label">Accumulator<span class="text-danger"
                                                    title="Required">*</span></label>
                                            <div>
                                                <input type="radio" id="with" name="is_accumulator"
                                                    value="1">
                                                <label for="with">With</label>
                                                <div style="display: inline-block; margin-left:103px;"></div>
                                                <input type="radio" id="without" name="is_accumulator"
                                                    value="2">
                                                <label for="without">Without</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textDateCreated" class="form-label">Date Created<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input type="text" class="form-control" name="date_created"
                                                id="textDateCreated" placeholder="Auto-generated" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textDeviceName" class="form-label">Device Name<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input type="text" class="form-control" name="device_name"
                                                id="textDeviceName" placeholder="Device Name">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textDeviceName" class="form-label">No. Of Cavity<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input min="0" type="number" class="form-control"
                                                name="no_of_cavity" id="textNoOfCavity" placeholder="No. Of Cavity">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textMaterialMixingRatio" class="form-label">Material Mixing
                                                Ratio<span class="text-danger" title="Required">*</span></label>
                                            <div class="d-flex">
                                                <input min="0" type="number" class="form-control"
                                                    name="material_mixing_ratio_v" id="textMaterialMixingRatio"
                                                    placeholder=" % V">
                                                <input min="0" type="number" class="form-control"
                                                    name="material_mixing_ratio_r" id="textMaterialMixingRatio"
                                                    placeholder=" % R">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textMaterialName" class="form-label">Material Name<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input type="text" class="form-control" name="material_name"
                                                id="textMaterialName" placeholder="Material Name">

                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textColor" class="form-label">Color<span class="text-danger"
                                                    title="Required">*</span></label>
                                            <input type="text" class="form-control" name="color" id="textColor"
                                                placeholder="Color">

                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label class="form-label">Dryer Used<span class="text-danger"
                                                    title="Required">*</span></label>
                                            <div>
                                                <input type="radio" id="dryerOven" name="dryer_used"
                                                    value="1">
                                                <label for="dryerOven">Oven</label>
                                                <div style="display: inline-block; margin-left:103px;"></div>
                                                <input type="radio" id="dryerDHD" name="dryer_used"
                                                    value="2">
                                                <label for="dryerDHD">DHD</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textMachineNo" class="form-label">Machine No.<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input min="0" type="number" class="form-control"
                                                name="machine_no" id="textMachineNo" placeholder="Machine No.">

                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textShotWeight" class="form-label">Shot Weight<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input type="number" min="0" class="form-control"
                                                name="shot_weight" id="textShotWeight" placeholder="Shot Weight">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label for="textUnitWeight" class="form-label">Unit Weight<span
                                                    class="text-danger" title="Required">*</span></label>
                                            <input min="0" type="number" class="form-control"
                                                name="unit_weight" id="textUnitWeight" placeholder="Unit Weight">
                                        </div>
                                    </div>

                                    <br>

                                    <div class="accordion" id="accordionExample">

                                        <div class="card" id="MoldClose">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button"
                                                        id="moldCloseId"data-bs-toggle="collapse"
                                                        data-bs-target="#moldClose" aria-expanded="true"
                                                        aria-controls="moldClose">
                                                        MOLD CLOSE
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="moldClose" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiV" class="form-label">HI V.<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control "name="hi_v" id="textHiV" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textMidSlow" class="form-label">MID SLOW<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="mid_slow" id="textMidSlow" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textLowL" class="form-label">LOW V<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="low_v" id="textLowV" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textObstacleCheckTm"
                                                                class="form-label">CLOSE MONITOR TM<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="close_monitor_tm" id="textCloseMonitorTm"
                                                                placeholder="">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textSlowStart" class="form-label">SlOW
                                                                START<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="slow_start" id="textSlowStart"
                                                                placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textSlowEnd" class="form-label">SLOW END<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="slow_end" id="textSlowEnd" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textLvlP" class="form-label">LVLP<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="lvlp" id="textLvlP" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHpcl" class="form-label">HPCL<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="hpcl" id="textHpcl" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textMidSlp" class="form-label">MID SL P.<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="mid_sl_p" id="textMidSlp" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textLowP" class="form-label">LOW P.<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                    name="low_p" id="textLowP" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiP" class="form-label">HI P.<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="hi_p" id="textHiP">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">kN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="Ejector">
                                            <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">
                                                        EJECTOR
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textPattern" class="form-label">PATTERN<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="pattern" id="textPattern" placeholder="">

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textEjPres" class="form-label">EJ PRES<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="ej_pres" id="textEjPres" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textFwdEv1" class="form-label">FWD EV1<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="fwd_ev1" id="textFwdEv1" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textFwdEv2" class="form-label">FWD EV2<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="fwd_ev2" id="textFwdEv2" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textStopTm" class="form-label">STOP TM<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="stop_tm" id="textStopTm" placeholder="s">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textCount" class="form-label">COUNT<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="count" id="textCount" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textEjtTmg" class="form-label">EJT TMG<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="ejt_tmg" id="textEjtTmg" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textEv2Chg" class="form-label">EV2 CHG<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="ev2_chg" id="textEv2Chg" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textFwdStop" class="form-label">FWD STOP<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="fwd_stop" id="textFwdStop" placeholder="">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textBwdEv4" class="form-label">BWD EV4<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="bwd_ev4" id="textBwdEv4" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textBwdPrs" class="form-label">BWD PRS<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="bwd_prs" id="textBwdPrs" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textRepeatBwdStop" class="form-label">REPEAT BWD STOP<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="repeat_bwd_stop" id="textRepeatBwdStop" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textRepeatEjtEv3" class="form-label">REPEAT EJT EV3<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="repeat_ejt_ev3" id="textRepeatEjtEv3" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textRepeatFwdStop" class="form-label">REPEAT FWD STOP<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="repeat_fwd_stop" id="textRepeatFwdStop" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id ="MoldOpen">
                                            <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree">
                                                        MOLD OPEN
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textOpenEndV" class="form-label">OPEN END
                                                                V.<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                    class="form-control" name="open_end_v"
                                                                    id="textOpenEndV" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiVelocity2" class="form-label">HI
                                                                VELOCITY 2<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                class="form-control" name="hi_velocity_2_percent"
                                                                id="textHiVelocity2" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiVelocity1Percent" class="form-label">HI
                                                                VELOCITY 1<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                    class="form-control" name="hi_velocity_1_percent"
                                                                    id="c" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textOpenV" class="form-label">OPEN ST V<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                    class="form-control" name="open_v" id="textOpenV"
                                                                    placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textTmpStopTime" class="form-label">MOLD ROTATION<span class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                    class="form-control" name="mold_rotation"
                                                                    id="textMoldRotation" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textOpenStop" class="form-label">OPEN STOP<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                class="form-control" name="open_stop"
                                                                id="textOpenStop" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textLowDistance" class="form-label">SLOW
                                                                DISTANCE<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                class="form-control" name="low_distance"
                                                                id="textLowDistance" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiVelocity1mm" class="form-label">HI
                                                                VELOCITY 1<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                class="form-control" name="hi_velocity_1mm"
                                                                id="textHiVelocity1mm" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiVelocity2mm" class="form-label">HI
                                                                VELOCITY 2<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" step="0.01"
                                                                class="form-control" name="hi_velocity_2mm"
                                                                id="textHiVelocity2mm" placeholder="mm">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="Heater">
                                            <div class="card-header" id="headingThree">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                        aria-expanded="false" aria-controls="collapseThree">
                                                        HEATER
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-2">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <label for="textNozzleSet" class="form-label">NOZZLE<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <label for="textFrontSet" class="form-label">FRONT<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <label for="textMidSet" class="form-label">MID<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <label for="textRearSet" class="form-label">REAR<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-2" id="setId"
                                                            style="font-weight: bold">
                                                            SET
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="nozzle_set"
                                                                id="textNozzleSet" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="front_set"
                                                                id="textFrontSet" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="mid_set" id="textMidSet"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="rear_set" id="textRearSet"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-2" id="setId"
                                                            style="font-weight: bold">
                                                            ACTUAL
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="nozzle_actual"
                                                                id="textNozzleActual" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="front_actual"
                                                                id="textFrontActual" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="mid_actual"
                                                                id="textMidActual" placeholder="">
                                                        </div>
                                                        <div class="col-md-6 col-lg-2">
                                                            <input min="0" type="number" step="0.01"
                                                                class="form-control" name="rear_actual"
                                                                id="textRearActual" placeholder="">
                                                        </div>
                                                    </div>
                                                    <br>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="InjectionVelocity">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button"
                                                        id="injectionVelocityId"data-bs-toggle="collapse"
                                                        data-bs-target="#injectionVelocity" aria-expanded="true"
                                                        aria-controls="injectionVelocity">
                                                        INJECTION VELOCITY
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="injectionVelocity" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numInjectionTime" class="form-label">INJECTION
                                                                TIME<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="injection_time"
                                                                    id="numInjectionTime">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numCoolingTime" class="form-label">COOLING
                                                                TIME<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="cooling_time"
                                                                    id="numCoolingTime">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numCycleStart" class="form-label">CYCLE
                                                                START<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="cycle_start"
                                                                    id="numCycleStart">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numV6" class="form-label">V6<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v6"
                                                                    id="numV6">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numV5" class="form-label">V5<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v5"
                                                                    id="numV5">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numV4" class="form-label">V4<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v4"
                                                                    id="numV4">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="nunumV3mLvlP" class="form-label">V3<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v3"
                                                                    id="numV3">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numV2" class="form-label">V2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v2"
                                                                    id="numV2">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numV1" class="form-label">V1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_v1"
                                                                    id="numV1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm/s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numFill" class="form-label">FILL<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_fill"
                                                                    id="numFill">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">STEP</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSv5" class="form-label">SV5<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sv5"
                                                                    id="numSv5">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSv4" class="form-label">SV4<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sv4"
                                                                    id="numSv4">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSv3" class="form-label">SV3<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sv3"
                                                                    id="numSv3">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSv2" class="form-label">SV2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sv2"
                                                                    id="numSv2">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSv1" class="form-label">SV1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sv1"
                                                                    id="numSv1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSM" class="form-label">SM<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sm"
                                                                    id="numSM">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSd" class="form-label">SC<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sd"
                                                                    id="numSd">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-3">
                                                        <label for="numMidSlp" class="form-label">HOLDING
                                                            PRESSURE</label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPp3" class="form-label">Pp3<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pp3"
                                                                    id="numPp3">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPp2" class="form-label">Pp2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pp2"
                                                                    id="numPp2">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPp1" class="form-label">Pp1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pp1"
                                                                    id="numPp1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">Mpa</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numHold" class="form-label">HOLD<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_hold"
                                                                    id="numHold">
                                                                    <div class="input-group-prepend w-30">
                                                                        <span class="input-group-text w-100"
                                                                        id="basic-addon1">step</span>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPtp2" class="form-label">Tp2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_tp2"
                                                                    id="numTp2">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">sec</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numTp1" class="form-label">Tp1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_tp1"
                                                                    id="numTp1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5 col-md-3">
                                                        </div>
                                                        <div class="col-md-5 col-md-3">
                                                            <label for="numMidSlp" class="form-label">POS</label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-5 col-md-3">
                                                        </div>
                                                        <div class="col-md-5 col-lg-3">
                                                            <label for="numChangeMode" class="form-label">CHANGE
                                                                MODE<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pos_change_mode"
                                                                    id="numChangeMode">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numVS" class="form-label">VS<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pos_vs"
                                                                    id="numVS">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numPosBp" class="form-label">BP<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pos_bp"
                                                                    id="numPosBp">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                    id="basic-addon1">Mpa</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPv3" class="form-label">Pv3<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pv3"
                                                                    id="numPv3">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPv2" class="form-label">Pv2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pv2"
                                                                    id="numPv2">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numPv1" class="form-label">Pv1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_pv1"
                                                                    id="numPv1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                    id="basic-addon1">Mpa</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSp2" class="form-label">Sp2<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sp2"
                                                                    id="numSp2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="numSp1" class="form-label">Sp1<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_sp1"
                                                                    id="numSp1">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="Support">
                                            <div class="card-header" id="headingInjectionVelocity">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseInjectionVelocity"
                                                        aria-expanded="false" aria-controls="collapseInjectionVelocity">
                                                        SUPPORT
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="collapseInjectionVelocity" class="collapse" aria-labelledby="headingInjectionVelocity"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textNozBwdTm_1" class="form-label">NOZ BWD TM<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="noz_bwd_tm_1" id="textNozBwdTm_1" placeholder="">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textInjStTmg_1" class="form-label">INJ ST TMG<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="inj_st_tmg_1" id="textInjStTmg_1" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textNozBwdTmg_2" class="form-label">NOZ BWD TMG<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="noz_bwd_tmg_2" id="textNozBwdTmg_2" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-3">
                                                            <label for="textInjStTmg2" class="form-label">INJ. ST TMG<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number" class="form-control"
                                                                name="inj_st_tmg_2" id="textInjStTmg2" placeholder="%">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">s</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5 col-md-3">
                                                            </div>
                                                            <div class="col-md-5 col-lg-3">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" index="1.8" id="supportTempoSlow" name="support_tempo" value="SLOW">
                                                                            &NonBreakingSpace;
                                                                            <label class="form-check-label dieset_condition_data"> SLOW</label>
                                                                        </div>
                                                                        <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" index="1.8" id="supportTempoMedium" name="support_tempo" value="MEDIUM">
                                                                            &NonBreakingSpace;
                                                                            <label class="form-check-label dieset_condition_data"> MEDIUM</label>
                                                                        </div>
                                                                        <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" index="1.8" id="supportTempoFast" name="support_tempo" value="FAST">
                                                                            &NonBreakingSpace;
                                                                            <label class="form-check-label dieset_condition_data"> FAST</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card" id="InjectionTab">
                                            <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" type="button"
                                                        id="injectionTabId"data-bs-toggle="collapse"
                                                        data-bs-target="#injectionTab" aria-expanded="true"
                                                        aria-controls="injectionTab">
                                                        EJECTION TAB
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="injectionTab" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">

                                                    <div class="row mt-5">
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="numInjTabFillTime" class="form-label">FILL
                                                                TIME<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <input min="0" type="number"
                                                                class="form-control" name="inj_tab_fill_time"
                                                                id="numInjTabFillTime" placeholder="%">

                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiP" class="form-label">PLAST TIME<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <input min="0" type="number"
                                                                class="form-control" name="inj_tab_plastic_time"
                                                                id="numInjTabPlasticTime">
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <label for="textHiP" class="form-label">CYCLE TIME<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <input min="0" type="number"
                                                                class="form-control" name="inj_tab_cycle_time"
                                                                id="numInjTabCycleTime">
                                                        </div>
                                                    </div>

                                                    <div class="row mt-4">
                                                        <div class="col-md-2 col-lg-4">
                                                            <label for="textHiP" class="form-label">SPRAY TYPE<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" index="1.8" id="radioInjTabSprayTypePower" name="inj_tab_spray_type" value="POWER">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSprayTypeYP">POWER</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" index="1.8" id="radioInjTabSprayTypeZ" name="inj_tab_spray_type" value="Z">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSprayTypeZ">Z</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" index="1.8" id="radioInjTabSprayTypeRF" name="inj_tab_spray_type" value="RF">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSprayTypeYP">RF</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" index="1.8" id="radioInjTabSprayTypeNO" name="inj_tab_spray_type" value="NO">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSprayTypeZ">NO</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="textHiP" class="form-label">SPRAY<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>

                                                            <input class="form-control" type="number" index="1.8" id="radioInjTabSprayYes" name="inj_tab_spray" value="YP">
                                                        </div>
                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="textHiP" class="form-label">SPRAY MODE<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="radioInjTabSprayModeManual"
                                                                            name="inj_tab_spray_mode" value="MANUAL">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabModeManual">MANUAL</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabSprayModeAuto"
                                                                            name="inj_tab_spray_mode" value="AUTO">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabModeAuto">AUTO</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="textHiP" class="form-label">SPRAY SIDE<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabSpraySideMove"
                                                                            name="inj_tab_spray_side" value="MOVE">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSideMove">MOVE</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabSpraySideFixed"
                                                                            name="inj_tab_spray_side" value="FIXED">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabSideFixed">FIXED</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="numInjTabSprayTm" class="form-label">SPRAY TM<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_tab_spray_tm"
                                                                    id="numInjTabSprayTm">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-md-2 col-lg-3">
                                                            <label for="textHiP" class="form-label">SCREW MOST
                                                                FWD<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control"
                                                                    name="inj_tab_screw_most_fwd"
                                                                    id="numInjTabScrewMostFwd">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-3">
                                                            <label for="textHiP" class="form-label">ENJ. END
                                                                POS.<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_tab_enj_end_pos"
                                                                    id="numInjTabEnjEndPos">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">mm</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-2 col-lg-6">
                                                                            <label for="textHiP" class="form-label">AIRBLOW(START
                                                                                TIME)<span class="text-danger"
                                                                                    title="Required">*</span></label>
                                                                            <div class="input-group input-group-sm mb-3">
                                                                                <input min="0" type="number"
                                                                                    class="form-control"
                                                                                    name="inj_tab_airblow_start_time"
                                                                                    id="numInjTabAirblowStartTimes">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2 col-lg-6">
                                                                            <label for="textHiP" class="form-label">AIRBLOW(BLOW
                                                                                TIME)<span class="text-danger"
                                                                                    title="Required">*</span></label>
                                                                            <div class="input-group input-group-sm mb-3">
                                                                                <input min="0" type="number"
                                                                                    class="form-control"
                                                                                    name="inj_tab_airblow_blow_time"
                                                                                    id="numInjTabAirblowBlowTime">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2">
                                                            <label for="textHiP" class="form-label">CCD<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabCcdYes"
                                                                            name="inj_tab_ccd" value="YES">
                                                                            &NonBreakingSpace;
                                                                        <label for="injTabCcdYes">YES</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabCcdNo"
                                                                            name="inj_tab_ccd" value="NO">
                                                                            &NonBreakingSpace;
                                                                        <label for="injTabCcdNo">NO</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-md-2 col-lg-2 mr-5">
                                                            <label for="textHiP" class="form-label">EJ. SPIN
                                                                CHECKER<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabEscYes"
                                                                            name="inj_tab_esc" value="YES">
                                                                        &NonBreakingSpace;
                                                                        <label for="injTabEscYes">YES</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabEscNo"
                                                                            name="inj_tab_esc" value="NO">
                                                                        &NonBreakingSpace;
                                                                        <label for="injTabEscNo">NO</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2 mr-5">
                                                            <label for="textHiP" class="form-label">PUNCH<span
                                                                class="text-danger"
                                                                title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabSprayPunchHard"
                                                                            name="inj_tab_punch" value="HARD">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabPunchHard">HARD</label>
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" id="radioInjTabSprayPunchSoft"
                                                                            name="inj_tab_punch" value="SOFT">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabPunchSoft">SOFT</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-3 mr-5">
                                                            <label for="textHiP" class="form-label">SPRAY
                                                                PORTION<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="radioInjTabSprayPortionCenter"
                                                                            name="inj_tab_spray_portion"
                                                                            value="CENTER ONLY">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabPortionCenter">CENTER
                                                                    </div>
                                                                    <div style="margin-left: 10%" class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            id="radioInjTabSprayPortionWhole"
                                                                            name="inj_tab_spray_portion" value="WHOLE AREA">
                                                                        &NonBreakingSpace;
                                                                        <label for="radioInjTabPortionWhole">WHOLE AREA
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-lg-2 mr-5">
                                                            <label for="numInjTabPunchApplcn" class="form-label">PUNCH APPLICATION<span
                                                                    class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control" name="inj_tab_punch_applcn"
                                                                    id="numInjTabPunchApplcn">
                                                                <div class="input-group-prepend w-30">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-md-4 col-lg-4">
                                                            <label for="textHiP" class="form-label">MATERIAL DRY
                                                                TEMP REQUIREMENT<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control"
                                                                    name="inj_tab_md_temp_requirement"
                                                                    id="numInjTabMdTempRequirement">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-lg-4">
                                                            <label for="textHiP" class="form-label">MATERIAL DRY
                                                                TIME REQUIREMENT<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control"
                                                                    name="inj_tab_md_time_requirement"
                                                                    id="numInjTabMdTimeRequirement">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">HRS</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-lg-4">
                                                            <label for="textHiP" class="form-label">MATERIAL DRY
                                                                TEMP ACTUAL<span class="text-danger"
                                                                    title="Required">*</span></label>
                                                            <div class="input-group input-group-sm mb-3">
                                                                <input min="0" type="number"
                                                                    class="form-control"
                                                                    name="inj_tab_md_temp_actual"
                                                                    id="numInjTabMdTempActual">
                                                                <div class="input-group-prepend w-30">
                                                                    <span class="input-group-text w-100"
                                                                        id="basic-addon1">°C</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    {{--     <div class="card" id="InjectionTabList">
                                            <div class="card-body">
                                                <div style="float: right;">
                                                    <div class="text-right mt-4">
                                                        <button type="button" class="btn btn-primary mb-3"
                                                            id="btnAddInjectionTabListOne" data-bs-toggle="modal"
                                                            data-bs-target="#modalAddInjectionTabList"><i
                                                                class="fa fa-plus fa-md"></i> Add </button>
                                                    </div>
                                                </div> <br><br>
                                                <div class="table-responsive">
                                                    <table id="tableInjectionTabListOne"
                                                        class="table table-sm table-bordered table-striped table-hover"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr align="center" style="text-align:center">
                                                                <th rowspan="2"><i class="fa fa-cogs"></i></th>
                                                                <th rowspan="2">MO DAY</th>
                                                                <th rowspan="2">SHOT COUNT</th>
                                                                <th rowspan="2">OPERATOR NAME</th>
                                                                <th rowspan="2">MATERIAL TIME "IN"</th>
                                                                <th colspan="3">PRODUCTION TIME</th>
                                                                <th colspan="2">MATERIAL LOT NO.</th>
                                                                <th rowspan="2">TOTAL MATERIAL DRING TIME</th>
                                                                <th rowspan="2">REMARKS</th>
                                                            </tr>
                                                            <tr align="center" style="text-align:center">
                                                                <th>Start</th>
                                                                <th>End</th>
                                                                <th>TOTAL TIME</th>
                                                                <th>Virgin</th>
                                                                <th>Recycled</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>     --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddMachine1" class="btn btn-primary"><i
                                id="ibtnAddMachine1Icon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add User Modal End -->
@endsection

@section('js_content')
    <script>
        $('[type=number]').val(7);
        $('[type=text]').val(3);
        const saveMachineOne = () => {
            $.ajax({
                type: 'POST',
                url: 'save_machine_one',
                data: $('#formAddMachine1').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#modal-loading').modal('show');
                },
                success: function (response) {
                    console.log(response);
                    return;
                    if(response['is_success'] == 'true'){
                        $('#modal-loading').modal('hide');
                        $('#modalAddMachine1').modal('hide');
                        $('#formAddMachine1')[0].reset();
                        toastr.success('Save Sucessfully');
                        dt.MachineParameter.draw();
                    }else{
                        toastr.error('Saving Failed');
                    }
                },error: function (data, xhr, status){
                    $('#modal-loading').modal('hide');
                    if(data.status === 422){
                        let errors = data.responseJSON.errors ;
                        toastr.error(`Saving Failed, Please fill up all required fields`);
                        //Machine Parameter
                        errorHandler( errors.machine_id,form.formAddMachine1.find('[name="machine_id"]') );
                        errorHandler( errors.device_name,form.formAddMachine1.find('[name="device_name"]') );
                        errorHandler( errors.no_of_cavity,form.formAddMachine1.find('[name="no_of_cavity"]') );
                        errorHandler( errors.material_mixing_ratio_v,form.formAddMachine1.find('[name="material_mixing_ratio_v"]') );
                        errorHandler( errors.material_mixing_ratio_r,form.formAddMachine1.find('[name="material_mixing_ratio_r"]') );
                        errorHandler( errors.material_name,form.formAddMachine1.find('[name="material_name"]') );
                        errorHandler( errors.color,form.formAddMachine1.find('[name="color"]') );
                        errorHandler( errors.machine_no,form.formAddMachine1.find('[name="machine_no"]') );
                        errorHandler( errors.shot_weight,form.formAddMachine1.find('[name="shot_weight"]') );
                        errorHandler( errors.unit_weight,form.formAddMachine1.find('[name="unit_weight"]') );
                        //Mold Close
                        errorHandler( errors.hi_v,form.formAddMachine1.find('[name="hi_v"]') );
                        errorHandler( errors.mid_slow,form.formAddMachine1.find('[name="mid_slow"]') );
                        errorHandler( errors.low_l,form.formAddMachine1.find('[name="low_l"]') ); //
                        errorHandler( errors.obstacle_check_tm,form.formAddMachine1.find('[name="obstacle_check_tm"]') ); //
                        errorHandler( errors.slow_start,form.formAddMachine1.find('[name="slow_start"]') );
                        errorHandler( errors.slow_end,form.formAddMachine1.find('[name="slow_end"]') );
                        errorHandler( errors.lvlp,form.formAddMachine1.find('[name="lvlp"]') );
                        errorHandler( errors.hpcl,form.formAddMachine1.find('[name="hpcl"]') );
                        errorHandler( errors.mid_sl_p,form.formAddMachine1.find('[name="mid_sl_p"]') );
                        errorHandler( errors.low_p,form.formAddMachine1.find('[name="low_p"]') );
                        errorHandler( errors.hi_p,form.formAddMachine1.find('[name="hi_p"]') );
                        //Ejector
                        errorHandler( errors.ej_pres,form.formAddMachine1.find('[name="ej_pres"]') );
                        errorHandler( errors.fwd_ev1,form.formAddMachine1.find('[name="fwd_ev1"]') );
                        errorHandler( errors.fwd_ev2,form.formAddMachine1.find('[name="fwd_ev2"]') );
                        errorHandler( errors.fwd_stop,form.formAddMachine1.find('[name="fwd_stop"]') );
                        errorHandler( errors.bwd_stop,form.formAddMachine1.find('[name="bwd_stop"]') );
                        errorHandler( errors.count,form.formAddMachine1.find('[name="count"]') );
                        errorHandler( errors.pattern,form.formAddMachine1.find('[name="pattern"]') );
                        //Mold Open
                        errorHandler( errors.open_end_v,form.formAddMachine1.find('[name="open_end_v"]') );
                        errorHandler( errors.hi_velocity_2,form.formAddMachine1.find('[name="hi_velocity_2"]') );
                        errorHandler( errors.hi_velocity_1_percent,form.formAddMachine1.find('[name="hi_velocity_1_percent"]') );
                        errorHandler( errors.open_v,form.formAddMachine1.find('[name="open_v"]') );
                        errorHandler( errors.tmp_stop_time,form.formAddMachine1.find('[name="tmp_stop_time"]') );
                        errorHandler( errors.open_stop,form.formAddMachine1.find('[name="open_stop"]') );
                        errorHandler( errors.low_distance,form.formAddMachine1.find('[name="low_distance"]') );
                        errorHandler( errors.hi_velocity_1mm,form.formAddMachine1.find('[name="hi_velocity_1mm"]') );
                        errorHandler( errors.tmp_stop_pos,form.formAddMachine1.find('[name="tmp_stop_pos"]') );
                        //Heater
                        errorHandler( errors.hot_sprue_set,form.formAddMachine1.find('[name="hot_sprue_set"]') );
                        errorHandler( errors.nozzle_set,form.formAddMachine1.find('[name="nozzle_set"]') );
                        errorHandler( errors.front_set,form.formAddMachine1.find('[name="front_set"]') );
                        errorHandler( errors.mid_set,form.formAddMachine1.find('[name="mid_set"]') );
                        errorHandler( errors.rear_set,form.formAddMachine1.find('[name="rear_set"]') );
                        errorHandler( errors.mold_set,form.formAddMachine1.find('[name="mold_set"]') );
                        errorHandler( errors.hot_sprue_actual,form.formAddMachine1.find('[name="hot_sprue_actual"]') );
                        errorHandler( errors.front_actual,form.formAddMachine1.find('[name="front_actual"]') );
                        errorHandler( errors.nozzle_actual,form.formAddMachine1.find('[name="nozzle_actual"]') );
                        errorHandler( errors.mid_actual,form.formAddMachine1.find('[name="mid_actual"]') );
                        errorHandler( errors.rear_actual,form.formAddMachine1.find('[name="rear_actual"]') );
                        errorHandler( errors.mold_one_set,form.formAddMachine1.find('[name="mold_one_set"]') );
                        errorHandler( errors.mold_two_set,form.formAddMachine1.find('[name="mold_two_set"]') );
                        errorHandler( errors.mold_one_actual,form.formAddMachine1.find('[name="mold_one_actual"]') );
                        errorHandler( errors.mold_two_actual,form.formAddMachine1.find('[name="mold_two_actual"]') );
                        //Injection Velocity
                        errorHandler( errors.cooling_time,form.formAddMachine1.find('[name="cooling_time"]') );
                        errorHandler( errors.cycle_start,form.formAddMachine1.find('[name="cycle_start"]') );
                        errorHandler( errors.inj_pp2,form.formAddMachine1.find('[name="inj_pp2"]') );
                        errorHandler( errors.inj_pp3,form.formAddMachine1.find('[name="inj_pp3"]') );
                        errorHandler( errors.inj_pp1,form.formAddMachine1.find('[name="inj_pp1"]') );
                        errorHandler( errors.inj_v1,form.formAddMachine1.find('[name="inj_v1"]') );
                        errorHandler( errors.inj_v2,form.formAddMachine1.find('[name="inj_v2"]') );
                        errorHandler( errors.inj_v3,form.formAddMachine1.find('[name="inj_v3"]') );
                        errorHandler( errors.inj_v4,form.formAddMachine1.find('[name="inj_v4"]') );
                        errorHandler( errors.inj_v6,form.formAddMachine1.find('[name="inj_v6"]') );
                        errorHandler( errors.inj_v5,form.formAddMachine1.find('[name="inj_v5"]') );
                        errorHandler( errors.inj_sv1,form.formAddMachine1.find('[name="inj_sv1"]') );
                        errorHandler( errors.inj_sv2,form.formAddMachine1.find('[name="inj_sv2"]') );
                        errorHandler( errors.inj_sv3,form.formAddMachine1.find('[name="inj_sv3"]') );
                        errorHandler( errors.inj_sv4,form.formAddMachine1.find('[name="inj_sv4"]') );
                        errorHandler( errors.inj_sv5,form.formAddMachine1.find('[name="inj_sv5"]') );
                        errorHandler( errors.inj_sm,form.formAddMachine1.find('[name="inj_sm"]') );
                        errorHandler( errors.inj_sd,form.formAddMachine1.find('[name="inj_sd"]') );
                        errorHandler( errors.inj_veloc_no,form.formAddMachine1.find('[name="inj_veloc_no"]') );
                        errorHandler( errors.inj_press_no,form.formAddMachine1.find('[name="inj_press_no"]') );
                        errorHandler( errors.inj_tp1,form.formAddMachine1.find('[name="inj_tp1"]') );
                        errorHandler( errors.inj_tp2,form.formAddMachine1.find('[name="inj_tp2"]') ); //NOTE: For Machine 1 only
                        errorHandler( errors.inj_pos_change_mode,form.formAddMachine1.find('[name="inj_pos_change_mode"]') );
                        errorHandler( errors.inj_pos_vs,form.formAddMachine1.find('[name="inj_pos_vs"]') );
                        errorHandler( errors.inj_pos_pb,form.formAddMachine1.find('[name="inj_pos_pb"]') );
                        errorHandler( errors.inj_pv1,form.formAddMachine1.find('[name="inj_pv1"]') );
                        errorHandler( errors.inj_pv2,form.formAddMachine1.find('[name="inj_pv2"]') );
                        errorHandler( errors.inj_pv3,form.formAddMachine1.find('[name="inj_pv3"]') );
                        errorHandler( errors.inj_sp1,form.formAddMachine1.find('[name="inj_sp1"]') );
                        errorHandler( errors.inj_sp2,form.formAddMachine1.find('[name="inj_sp2"]') );
                        //Injection Tab
                        errorHandler( errors.inj_tab_rv6,form.formAddMachine1.find('[name="inj_tab_rv6"') );
                        errorHandler( errors.inj_tab_rv5,form.formAddMachine1.find('[name="inj_tab_rv5"') );
                        errorHandler( errors.inj_tab_rv4,form.formAddMachine1.find('[name="inj_tab_rv4"') );
                        errorHandler( errors.inj_tab_rv3,form.formAddMachine1.find('[name="inj_tab_rv3"') );
                        errorHandler( errors.inj_tab_rv2,form.formAddMachine1.find('[name="inj_tab_rv2"') );
                        errorHandler( errors.inj_tab_rv1,form.formAddMachine1.find('[name="inj_tab_rv1"') );
                        errorHandler( errors.inj_tab_rp3,form.formAddMachine1.find('[name="inj_tab_rp3"') );
                        errorHandler( errors.inj_tab_rp2,form.formAddMachine1.find('[name="inj_tab_rp2"') );
                        errorHandler( errors.inj_tab_rp1,form.formAddMachine1.find('[name="inj_tab_rp1"') );
                        errorHandler( errors.inj_tab_fill_time,form.formAddMachine1.find('[name="inj_tab_fill_time"') );
                        errorHandler( errors.inj_tab_plastic_time,form.formAddMachine1.find('[name="inj_tab_plastic_time"') );
                        errorHandler( errors.inj_tab_cycle_time,form.formAddMachine1.find('[name="inj_tab_cycle_time"') );
                        errorHandler( errors.inj_tab_spray_tm,form.formAddMachine1.find('[name="inj_tab_spray_tm"') );
                        errorHandler( errors.inj_tab_screw_most_fwd,form.formAddMachine1.find('[name="inj_tab_screw_most_fwd"') );
                        errorHandler( errors.inj_tab_enj_end_pos,form.formAddMachine1.find('[name="inj_tab_enj_end_pos"') );
                        errorHandler( errors.inj_tab_airblow_start_time,form.formAddMachine1.find('[name="inj_tab_airblow_start_time"') );
                        errorHandler( errors.inj_tab_airblow_blow_time,form.formAddMachine1.find('[name="inj_tab_airblow_blow_time"') );
                        errorHandler( errors.inj_tab_md_temp_requirement,form.formAddMachine1.find('[name="inj_tab_md_temp_requirement"') );
                        errorHandler( errors.inj_tab_md_time_requirement,form.formAddMachine1.find('[name="inj_tab_md_time_requirement"') );
                        errorHandler( errors.inj_tab_md_temp_actual,form.formAddMachine1.find('[name="inj_tab_md_temp_actual"') );
                    }else{
                        toastr.error(`Error: ${data.status}`);
                    }
                }

            });
        }

        function getMachine1(cboElement){
            let result = '<option value="0" disabled selected>Select One</option>';
            $.ajax({
                url: 'get_machine_name_form1',
                method: 'get',
                dataType: 'json',
                beforeSend: function(){
                    result = '<option value="0" disabled>Loading</option>';
                    cboElement.html(result);
                },
                success: function(response){
                    let disabled = '';
                    if(response['machine_details_1'].length > 0){
                        result = '<option value="0" disabled selected>Select One</option>';
                        for(let index = 0; index < response['machine_details_1'].length; index++){
                            result += '<option value="' + response['machine_details_1'][index].id + '">' + response['machine_details_1'][index].machine_name + '</option>';
                        }
                    }
                    else{
                        result = '<option value="0" disabled>No User Role found</option>';
                    }
                    cboElement.html(result);
                },
                error: function(data, xhr, status){
                    result = '<option value="0" disabled>Reload Again</option>';
                    cboElement.html(result);
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        }

        function getMachine2(cboElement){
            let result = '<option value="0" disabled selected>Select One</option>';
            $.ajax({
                url: 'get_machine_name_form2',
                method: 'get',
                dataType: 'json',
                beforeSend: function(){
                    result = '<option value="0" disabled>Loading</option>';
                    cboElement.html(result);
                },
                success: function(response){
                    let disabled = '';
                    if(response['machine_details_2'].length > 0){
                        result = '<option value="0" disabled selected>Select One</option>';
                        for(let index = 0; index < response['machine_details_2'].length; index++){
                            result += '<option value="' + response['machine_details_2'][index].id + '">' + response['machine_details_2'][index].machine_name + '</option>';
                        }
                    }
                    else{
                        result = '<option value="0" disabled>No User Role found</option>';
                    }
                    cboElement.html(result);
                },
                error: function(data, xhr, status){
                    result = '<option value="0" disabled>Reload Again</option>';
                    cboElement.html(result);
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
            });
        }
        getMachine1($('#selectMachine1'));
        getMachine2($('#selectMachine2'));

        $('#formAddMachine1').submit(function(e) {
            e.preventDefault();
            saveMachineOne();
        });

    </script>
@endsection
@endauth

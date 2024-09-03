@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Stamping Working Report')
    @section('content_page')
        <style type="text/css">
            .hidden_scanner_input{
                position: absolute;
                left: 15%;
                opacity: 0;
            }
            textarea{
                resize: none;
            }
        </style>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Stamping Working Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Stamping Working Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Stamping Working Report</h3>
                                </div>
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="buttonOpenModalMachine" data-bs-toggle="modal" data-bs-target="#modalMachineNumber"><i class="fa-solid fa-plus"></i>
                                            Add New
                                        </button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tableStampingWorkingReport" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Control No.</th>
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
            </section>
        </div>

        <div class="modal fade" id="modalMachineNumber" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Add Machine Number</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formMachineNumber">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" style="width: 50%;">Control No.</span>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textControlNumber" name="control_number" placeholder="Ex: PPS-E01-066">
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" style="width: 50%;">Machine No.</span>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMachineNumber" name="machine_number" placeholder="Machine No.">
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" style="width: 50%;">Year</span>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textYear" readonly name="year" value="<?php echo date('Y'); ?>" placeholder="Year">
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text" style="width: 50%;">Month</span>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMonth" readonly name="month" value="<?php echo date('m'); ?>" placeholder="Month">
                                </div>
                                <div class="input-group input-group-sm mb-3 mr-1">
                                    <span class="input-group-text" style="width: 50%;">Day</span>
                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textDay" readonly name="day" value="<?php echo date('d'); ?>" placeholder="Day">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Save & Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalStampingWorkingReport" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info-circle"></i>&nbsp;Stamping Working Report</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formStampingWorkingReport" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textStampingWorkingReportId" name="work_details_id">
                            <div class="row">
                                <div class="col-lg-3 border px-4">
                                    <div class="py-3 d-flex align-items-center">
                                        <i class="fa fa-info-circle"></i>&nbsp;Work Details
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <span>A</span>
                                        </div>
                                        <div class="col-10">
                                            <div>Other Activities</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>A1</div>
                                        </div>
                                        <div class="col-10">
                                            <div>A1 - Meeting</div>
                                            <div>A2 - 7s</div>
                                            <div>A3 - Shipment preparation</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>B</div>
                                        </div>
                                        <div class="col-10">
                                            <div>B-1 Waiting for materials</div>
                                            <div>B-2 Machine for repair</div>
                                            <div>B-3 Power Failure</div>
                                            <div>B-4 Die-set for repair</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>C</div>
                                        </div>
                                        <div class="col-10">
                                            <div>Sample Production (Evaluation)</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>D</div>
                                        </div>
                                        <div class="col-10">
                                            <div>D Mold under maintenance (Overhaul)</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>E</div>
                                        </div>
                                        <div class="col-10">
                                            <div>E-1 Waiting for Operator</div>
                                            <div>E-2 Waiting for Engineering</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>F</div>
                                        </div>
                                        <div class="col-10">
                                            <div>F-1 Material Change</div>
                                            <div>F-2 Mold Pullout</div>
                                            <div>F-3 Mold set-up</div>
                                            <div>F-4 Lot Change</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>H</div>
                                        </div>
                                        <div class="col-10">
                                            <div>Production Time</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>G</div>
                                        </div>
                                        <div class="col-10">
                                            <div>G1 Machine adjustment</div>
                                            <div>G2 Product qualification</div>
                                            <div>G3 Projector checking</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>T</div>
                                        </div>
                                        <div class="col-10">
                                            <div>Machine test run</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 border">
                                        <div class="col-2">
                                            <div>K</div>
                                        </div>
                                        <div class="col-10">
                                            <div>Rewinding and Reel arrangement</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="row py-3 border">
                                        <div class="row justify-content-end mb-5">
                                            <div class="col-md-4">
                                                <div class="input-group input-group-sm" style="margin-left: -7px;">
                                                    <span class="input-group-text" style="width: 50%;">Control No.</span>
                                                    <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textControlNumber" name="control_number" placeholder="Control No.">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-xxl-5">
                                                <div class="d-flex align-items-center"><i class="fa fa-info-circle"></i>&nbsp;Stamping Working Report</div>
                                                <div class="fw-lighter fst-italic"><span class="text-danger">*</span>Put the complete details of activity / Do not leave empty space without details</div>
                                            </div>
                                            <div class="col-xxl-7">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" style="width: 50%;">Machine No.</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMachineNumber" name="machine_number" placeholder="Machine No.">
                                                    </div>
                                                    <div class="input-group input-group-sm" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Year</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textYear" readonly name="year" placeholder="Year">
                                                    </div>
                                                    <div class="input-group input-group-sm" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Month</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMonth" readonly name="month" placeholder="Month">
                                                    </div>
                                                    <div class="input-group input-group-sm mr-1" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Day</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textDay" readonly name="day" placeholder="Day">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row py-3 border">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary" id="buttonStampingWorkingReportWorkDetails" data-bs-toggle="modal" data-bs-target="#modalStampingWorkingReportWorkDetails" style="margin-bottom: 5px;">
                                                <i class="fa fa-plus" ></i> Add New
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm small table-bordered table-hover" id="tableStampingWorkingReportWorkDetails" style="width: 100%;">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th>Action</th>
                                                        <th>Time Start</th>
                                                        <th>Time End</th>
                                                        <th>Total Minutes</th>
                                                        <th>Work Details</th>
                                                        <th>Sequence No.</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="buttonSaveStampingWorkingReport">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modalStampingWorkingReportWorkDetails" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stamping Working Report Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formStampingWorkingReportWorkDetails">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textStampingWorkingReportId" name="stamping_working_report_id">
                            <input type="text" class="d-none" id="textStampingWorkingReportWorkDetailsId" name="stamping_working_report_work_details_id">

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Time</span>
                                        <div id="divTime" class="d-flex input-group" style="width: 50% !important;">
                                            <input type="text" class="form-control form-control-sm time start ui-timepicker-input" id="textTimeStart" name="time_start" placeholder="Start" autocomplete="off">
                                            <input type="text" class="form-control form-control-sm time end ui-timepicker-input" id="textTimeEnd" name="time_end" placeholder="End" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Total minutes</span>
                                        <input type="text" class="form-control form-control-sm" id="textTotalMinutes" style="width: 50% !important;" readonly name="total_minutes" placeholder="Total minutes (Auto Generated)" autocomplete="off">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Work Details</span>
                                        <select type="text" class="form-control form-control-sm" style="width: 50% !important;" id="selectWorkDetails" name="work_details" placeholder="Work Details">
                                            <option value="0" selected disabled>Select One</option>
                                            <option value="A">A</option>
                                            <option value="A1">A1</option>
                                            <option value="A2">A2</option>
                                            <option value="A3">A3</option>
                                            <option value="B1">B1</option>
                                            <option value="B2">B2</option>
                                            <option value="B3">B3</option>
                                            <option value="B4">B4</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E1">E1</option>
                                            <option value="E2">E2</option>
                                            <option value="F1">F1</option>
                                            <option value="F2">F2</option>
                                            <option value="F3">F3</option>
                                            <option value="F4">F4</option>
                                            <option value="H">H</option>
                                            <option value="G1">G1</option>
                                            <option value="G2">G2</option>
                                            <option value="G3">G3</option>
                                            <option value="T">T</option>
                                            <option value="K">K</option>
                                        </select>
                                    </div>

                                    {{-- <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Sequence No.</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textSequenceNumber" name="sequence_number" placeholder="Sequence No.">
                                    </div> --}}

                                    <div class="row">
                                        <div class="col">
                                            <div class="table-responsive">
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn btn-sm btn-info mb-2 mt-3"  data-bs-toggle="modal" data-bs-target="#modalAddSequenceNumber" title="Add Sequence No."><i class="fa fa-plus"></i> Add Sequence #</button>
                                                </div>
                                                <table class="table table-striped table-bordered table-condensed table-hover" id="tableSequenceNumber" style="min-width: 100%">
                                                    <thead>
                                                        <th style="width: 4%;">Action</th>
                                                        <th style="width: 16%;">C/T Name</th>
                                                        <th style="width: 16%;">Code No.</th>
                                                        <th style="width: 14%;">SPM</th>
                                                        <th style="width: 16%;">P.O. No.</th>
                                                        <th style="width: 18%;">Shipment Output</th>
                                                        <th style="width: 18%;">Machine Output</th>
                                                        <th style="width: 16%;">In-charge</th>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="buttonAddStampingWorkingReportWorkDetails"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAddSequenceNumber" role="dialog" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-plus text-info"></i> Add Sequence #</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formSequenceNumber">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">C/T Name</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textCTName" name="ct_name" placeholder="C/T Name">
                                    </div>
    
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Code No.</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textCodeNumber" name="code_number" placeholder="Code No.">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">SPM</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textSPM" name="spm" placeholder="SPM">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">PO Number</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textPONumber" name="po_number" placeholder="PO Number">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Produced Quantity</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 25%;" id="textShipmentOutput" name="shipment_output" placeholder="Shipment Output">
                                        <input type="text" class="form-control form-control-sm" style="width: 25%;" id="textMachineOutput" name="machine_output" placeholder="Machine Output">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">In-charge</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textProducedQuantity" name="in_charge" placeholder="In-charge">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info" id="buttonAddSequenceNumber"><i class="fa fa-plus"></i> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('js_content')
        <script>
            $(document).ready(function () {
                let divTimeEl = document.getElementById('divTime');
                let divTime = new Datepair(divTimeEl);
                $('#divTime #textTimeStart').timepicker({
                    'showDuration'  : true,
                    'minTime'       : '7:30am',
                    'maxTime'       : '12:00am',
                    'timeFormat'    : 'g:ia',
                    'forceRoundTime': true,
                    'step'          : 5,
                }).on('changeTime', function() {
                    let milliseconds = divTime.getTimeDiff();
                    let minutes = (milliseconds/1000)/60;
                });

                $('#divTime #textTimeEnd').timepicker({
                    'showDuration'  : true,
                    'minTime'       : '7:30am',
                    'maxTime'       : '12:00am',
                    'timeFormat'    : 'g:ia',
                    'forceRoundTime': true,
                    'step'          : 5,
                }).on('blur', function() {
                    let milliseconds = divTime.getTimeDiff();
                    let minutes = (milliseconds/1000)/60;
                    $('#textTotalMinutes').val(`${minutes} mins`);
                });

                dataTablesStampingWorkingReport = $("#tableStampingWorkingReport").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_stamping_working_report",
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "control_number" },
                        { "data" : "machine_number",},
                    ],
                });
                
                $('#formMachineNumber').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    console.log(`data ${data}`);

                    $.ajax({
                        type    : "POST",
                        url     : "save_machine_number",
                        data    : data,
                        dataType: "json",
                        success: function (response) {
                            console.log('response ', response);
                            if(response.validatorHasError){
                                toastr.error('Please input required fields');
                                if(response['validatorMessages']['machine_number'] === undefined){
                                    isResponseError('textMachineNumber', false);
                                }
                                else{
                                    isResponseError('textMachineNumber', true);
                                }

                                if(response['validatorMessages']['control_number'] === undefined){
                                    isResponseError('textControlNumber', false);
                                }
                                else{
                                    isResponseError('textControlNumber', true);
                                }
                            }else{
                                if(response.hasError){
                                    toastr.error('Saving failed');
                                }
                                else{
                                    toastr.success('Successfully saved');
                                    dataTablesStampingWorkingReport.draw();
                                    $('#modalMachineNumber').modal('hide');
                                    $('#modalStampingWorkingReport').modal('show');
                                    getStampingWorkingReport(response['id']);
                                }
                            }
                        }
                    });
                });
                resetFormValuesStampingWorkingReportOnModalClose('modalMachineNumber', 'formMachineNumber');
                
                $("#tableStampingWorkingReport").on('click', '.actionEditStampingWorkingReport', function(){
                    let stampingWorkingReportId = $(this).attr('stamping-working-report-id');
                    console.log('stampingWorkingReportId ', stampingWorkingReportId);
                    getStampingWorkingReport(stampingWorkingReportId);
                });

                /**
                 * Stamping Working Report Work Details
                */
                dataTablesStampingWorkingReportWorkDetails = $("#tableStampingWorkingReportWorkDetails").DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax"      : {
                        url : "view_stamping_working_report_work_details",
                        data: function (param){
                            param.stamping_working_report_id = $("#textStampingWorkingReportId").val();
                        }
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "time_start" },
                        { "data" : "time_end" },
                        { "data" : "total_minutes" },
                        { "data" : "work_details"},
                        { "data" : "sequence_number"},
                    ],
                });
                
                $('#formStampingWorkingReportWorkDetails').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    console.log(`data ${data}`);
                    $.ajax({
                        type: "POST",
                        url: "save_stamping_working_report_work_details",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validatorHasError){
                                if(!response.hasError){
                                    toastr.success('Successfully saved');
                                    // getSecondMoldingById(response['second_molding_id'], true);
                                    dataTablesStampingWorkingReportWorkDetails.draw();
                                    $('#modalStampingWorkingReportWorkDetails').modal('hide');
                                }
                                else{
                                    toastr.error('Saving failed');
                                }
                            }else{
                                toastr.error('Please input required fields');
                                if(response['validatorMessages']['time_start'] === undefined){
                                    isResponseError('textTimeStart', false);
                                }
                                else{
                                    isResponseError('textTimeStart', true);
                                }
                                if(response['validatorMessages']['time_end'] === undefined){
                                    isResponseError('textTimeEnd', false);
                                }
                                else{
                                    isResponseError('textTimeEnd', true);
                                }
                                if(response['validatorMessages']['total_minutes'] === undefined){
                                    isResponseError('textTotalMinutes', false);
                                }
                                else{
                                    isResponseError('textTotalMinutes', true);
                                }
                                if(response['validatorMessages']['work_details'] === undefined){
                                    isResponseError('selectWorkDetails', false);
                                }
                                else{
                                    isResponseError('selectWorkDetails', true);
                                }
                                if(response['validatorMessages']['sequence_number'] === undefined){
                                    isResponseError('textSequenceNumber', false);
                                }
                                else{
                                    isResponseError('textSequenceNumber', true);
                                }
                            }
                        }
                    });
                });
                resetFormValuesStampingWorkingReportOnModalClose('modalStampingWorkingReportWorkDetails', 'formStampingWorkingReportWorkDetails');
                
                $('#buttonStampingWorkingReportWorkDetails').click(function (e) { 
                    e.preventDefault();
                    let id = $('#textStampingWorkingReportId', $('#formStampingWorkingReport')).val();
                    console.log('id ', id);
                    $('#textStampingWorkingReportId', $('#formStampingWorkingReportWorkDetails')).val(id);
                });

                $("#tableStampingWorkingReportWorkDetails").on('click', '.actionEditStampingWorkingReportWorkDetails', function(){
                    let stampingWorkingReportWorkDetailsId = $(this).attr('stamping-working-report-work-details-id');
                    console.log('stampingWorkingReportWorkDetailsId ', stampingWorkingReportWorkDetailsId);
                    getStampingWorkingReportWorkDetails(stampingWorkingReportWorkDetailsId);
                });

                /**
                 * DataTables for Sequence Number
                */
                let sequenceNumberArray = [];
                let dataTablesSequenceNumber = $('#tableSequenceNumber').DataTable({
                    rowId: 'id',
                    "ordering": false,
                    "columns": [
                        { "data": "action" },
                        { "data": "ct_name" },
                        { "data": "code_number" },
                        { "data": "spm" },
                        { "data": "po_number" },
                        { "data" : "shipment_output" },
                        { "data" : "machine_output" },
                        { "data" : "in_charge" }
                    ],
                });

                /**
                 * Add/Remove Sequence Number
                 * Start
                */
                $("#buttonAddSequenceNumber").click(function(){
                    sequenceNumberArray = [];
                    let buttonAction = `
                        <center>
                            <button type='button' class='btn btn-primary btn-sm mr-1 actionEditSequenceNumber' data-bs-toggle='modal' data-bs-target='#modalAddSequenceNumber'><i class='fa-solid fa-pen-to-square'></i></button>
                        </center>
                    `;
                    sequenceNumberArray.push({
                        "action":               buttonAction,
                        "ct_name":              "0.00",
                        "code_number":	        "0.00",
                        "spm":			        "0.00",
                        "po_number":			"0.00",
                        "shipment_output":		"0.00",
                        "machine_output":	    "0.00",
                        "in_charge":	        "0.00",
                    });

                    dataTablesSequenceNumber.rows.add(
                        sequenceNumberArray
                    ).draw();
                });

                $(document).on('click', ".actionEditSequenceNumber", function(){
                    console.log(`${JSON.stringify(sequenceNumberArray)}`);
                });
                

                $("#tableSequenceNumber").on('click', '.buttonRemoveSequenceNumber', function(){
                    $(this).closest ('tr').remove();
                });
                /**
                 * Add/Remove Sequence Number
                 * End
                */
            }); // End Document Ready
        </script>
    @endsection
@endauth


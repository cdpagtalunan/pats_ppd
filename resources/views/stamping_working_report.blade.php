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
                                        <button class="btn btn-primary" id="buttonAddStampingWorkingReport" data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReport'><i class="fa-solid fa-plus"></i>
                                            New
                                        </button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tableStampingWorkingReport" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Machine No.</th>
                                                    <th>Time</th>
                                                    <th>Work Details</th>
                                                    <th>Sequence No.</th>
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

        <div class="modal fade" id="modalStampingWorkingReport" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info-circle"></i>&nbsp;Stamping Working Report Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formStampingWorkingReport" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textStampingWorkingReportId" name="stamping_working_report_id">
                            <div class="row">
                                <div class="col-3 border px-4">
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
                                            <div>F-3 Lot Change</div>
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
                                <div class="col-sm-9">
                                    <div class="col px-4">
                                        <div class="row py-3 border justify-content-between align-items-center">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center"><i class="fa fa-info-circle"></i>&nbsp;Stamping Working Report</div>
                                                <div class="fw-lighter fst-italic"><span class="text-danger">*</span>Put the complete details of activity / Do not leave empty space without details</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text" style="width: 50%;">Machine No.</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMachineNumber" name="machine_number" placeholder="Machine No.">
                                                    </div>
                                                    <div class="input-group input-group-sm" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Year</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textYear" readonly name="year" value="<?php echo date('Y'); ?>" placeholder="Year">
                                                    </div>
                                                    <div class="input-group input-group-sm" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Month</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textMonth" readonly name="month" value="<?php echo date('m'); ?>" placeholder="Month">
                                                    </div>
                                                    <div class="input-group input-group-sm mr-1" style="width: 50%;">
                                                        <span class="input-group-text" style="width: 50%;">Day</span>
                                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textDay" readonly name="day" value="<?php echo date('d'); ?>" placeholder="Day">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center">
                                                        <i class="fa fa-plus" ></i>&nbsp;Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-3 border">
                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStampingWorkingReportDetails" style="margin-bottom: 5px;">
                                                    <i class="fa fa-plus" ></i> Add
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm small table-bordered table-hover" id="tableStampingWorkingReportDetails" style="width: 100%;">
                                                    <thead>
                                                        <tr class="bg-light">
                                                            <th>Action</th>
                                                            <th>Time</th>
                                                            <th>Work Details</th>
                                                            <th>Sequence No.</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th style="border-top: 1px solid #dee2e6"></th>
                                                            <th style="border-top: 1px solid #dee2e6"></th>
                                                            <th style="border-top: 1px solid #dee2e6"></th>
                                                            <th style="border-top: 1px solid #dee2e6"></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
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

        <div class="modal fade" id="modalStampingWorkingReportDetails" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stamping Working Report Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formStampingWorkingReportDetails">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textStampingWorkingReportsId" name="stamping_working_report_id">
                            <input type="text" class="d-none" id="textStampingWorkingReportDetailsId" name="stamping_working_report_details_id">

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Time</span>
                                        <div id="divTime" class="d-flex" style="width: 50% !important;">
                                            <input type="text" class="time start ui-timepicker-input" id="textTimeStart" style="border: 1px solid #ced4da;" name="time_start" placeholder="Start" autocomplete="off">
                                            <input type="text" class="time end ui-timepicker-input" id="textTimeEnd" style="border: 1px solid #ced4da;" name="time_end" placeholder="End" autocomplete="off">
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
                                            <option value="1">A</option>
                                            <option value="2">A1</option>
                                            <option value="3">A2</option>
                                            <option value="4">A3</option>
                                            <option value="5">B1</option>
                                            <option value="6">B2</option>
                                            <option value="7">B3</option>
                                            <option value="8">B4</option>
                                            <option value="9">C</option>
                                            <option value="10">D</option>
                                            <option value="11">E1</option>
                                            <option value="12">E2</option>
                                            <option value="13">F1</option>
                                            <option value="14">F2</option>
                                            <option value="15">F3</option>
                                            <option value="16">F4</option>
                                            <option value="17">H</option>
                                            <option value="18">G1</option>
                                            <option value="19">G2</option>
                                            <option value="20">G3</option>
                                            <option value="21">T</option>
                                            <option value="22">K</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" style="width: 50%;">Sequence No.</span>
                                        <input type="text" class="form-control form-control-sm" style="width: 50%;" id="textSequenceNumber" name="sequence_number" placeholder="Sequence No.">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="buttonAddStampingWorkingReportDetails"><i class="fa-solid fa-floppy-disk"></i> Save</button>
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
                    'showDuration': true,
                    'minTime': '7:30am',
                    'maxTime': '12:00am',
                    'timeFormat': 'g:ia',
                    'forceRoundTime': true,
                    'step': 5,
                }).on('changeTime', function() {
                    let milliseconds = divTime.getTimeDiff();
                    let minutes = (milliseconds/1000)/60;
                });

                $('#divTime #textTimeEnd').timepicker({
                    'showDuration': true,
                    'minTime': '7:30am',
                    'maxTime': '12:00am',
                    'timeFormat': 'g:ia',
                    'forceRoundTime': true,
                    'step': 5,
                }).on('blur', function() {
                    let milliseconds = divTime.getTimeDiff();
                    let minutes = (milliseconds/1000)/60;
                    $('#textTotalMinutes').val(`${minutes} mins`);
                });

                // dataTables = $("#tableStation").DataTable({
                //     "processing" : true,
                //     "serverSide" : true,
                //     "ajax" : {
                //         url: "view_second_molding_station",
                //         data: function (param){
                //             param.sec_molding_runcard_id = $('#textSecondMoldingId', $('#formSecondMolding')).val();
                //         }
                //     },
                //     fixedHeader: true,
                //     "columns":[
                //         { "data" : "action", orderable:false, searchable:false },
                //         { "data" : "station_name" },
                //         { "data" : "date" },
                //         { "data" : "concatted_operator_name",},
                //         { "data" : "input_quantity" },
                //         { "data" : "ng_quantity" },
                //         { "data" : "output_quantity" },
                //         { "data" : "remarks" },
                //     ],
                //     footerCallback: function (row, data, start, end, display) {
                //         let api = this.api();

                //         let countNGQuantity = 0;
                //         let countVisualInspectionQuantity = 0;
                //         if(data.length > 0){
                //             for (let index = 0; index < data.length; index++) {
                //                 countNGQuantity += parseInt(data[index].ng_quantity);
                //                 if(data[index].station_name == "Visual Inspection"){
                //                     countVisualInspectionQuantity += parseInt(data[index].output_quantity);
                //                 }
                //             }
                //         }
                //         // console.log('countNGQuantity ', countNGQuantity);
                //         $(api.column(5).footer()).html(`${countNGQuantity}`)
                //         $(api.column(6).footer()).html(`${countVisualInspectionQuantity}`)
                //     }
                // });

                $('#formStampingWorkingReportDetails').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    console.log(`data ${data}`);
                    $.ajax({
                        type: "POST",
                        url: "save_stamping_working_report_details",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    toastr.success('Successfully saved');
                                    getSecondMoldingById(response['second_molding_id'], true);
                                    dataTablesSecondMoldingStation.draw();
                                    $('#modalStampingWorkingReportDetails').modal('hide');
                                }
                                else{
                                    toastr.error('Saving failed');
                                }
                            }else{
                                toastr.error('Please input required fields');
                                if(response['error']['device_name'] === undefined){
                                    isResponseError('textDeviceName', false);
                                }
                                else{
                                    isResponseError('textDeviceName', true);
                                }
                            }
                        }
                    });
                });
                resetFormValuesOnModalClose('modalSecondMoldingStation', 'formAddStation');
                
            }); // End Document Ready
        </script>
    @endsection
@endauth
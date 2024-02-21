@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Stamping History')
    @section('content_page')
        <style type="text/css">
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
            
            .scanQrBarCode{
                position: absolute;
                opacity: 0;
            }

            .slct{
                pointer-events: none;
            }

            .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered .select2-selection__choice{
                font-size: .75rem;                
                padding: .0em 0.55vmax;
                margin-bottom: 0px;
            }

            .select2-container--bootstrap-5 .select2-selection--multiple{
                pointer-events: none;
            }
        </style>
        @php
            date_default_timezone_set('Asia/Manila');
        @endphp

        <div class="content-wrapper"> <!-- Content Wrapper. Contains page content -->
            <section class="content-header"> <!-- Content Header (Page header) -->
                <div class="container-fluid"><!-- Container-fluid -->
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Stamping History</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Stamping History</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.Container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content"><!-- Content -->
                <div class="container-fluid"><!-- Container-fluid -->
                    <div class="row"><!-- Row -->
                        <div class="col-12"><!-- Col -->
                            <div class="card card-dark"><!-- General form elements -->
                                <div class="card-header">
                                    <h3 class="card-title">Stamping History Table</h3>
                                </div>

                                <div class="card-body"><!-- Start Page Content -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label class="form-label">Part Name:</label>
                                            <div class="input-group">
                                                <select class="form-control select2bs5 dataFromStampingProdnMaterialName" id="selectStampingProdnMaterialName"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Previous Total Shot Accumulated</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="txtStampingHistoryPrevTotalShotAccum" readonly>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-right p-3"> 
                                        <button button type="button" class="btn btn-dark d-none" id="buttonAddStampingHistory" data-bs-toggle="modal" data-bs-target="#modalStampingHistory" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Request</button>
                                    </div>
                                    <div class="table-responsive"><!-- Table responsive -->
                                        <table id="tblStampingHistory" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- &emsp; -->
                                                    <th>Action</th>
                                                    <th>&nbsp;Part Name&nbsp;</th>
                                                    <th>Die Code No.</th>
                                                    <th>&emsp;Date&emsp;</th>
                                                    <th>Shot</th>
                                                    <th>Shot Accum.</th>
                                                    <th>&emsp;Operator&emsp;</th>
                                                    <th>Machine No.</th>
                                                    <th>Die Height</th>
                                                    <th>SPM</th>
                                                    <th>Rev. No.</th>
                                                    <th>Neraiti</th>
                                                    <th>Remarks <br> Production Condition <br> (ACCIDENT - TROUBLE - PROBLEM)</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div><!-- /.Table responsive -->
                                </div><!-- /.End Page Content -->
                            </div><!-- /.Card -->
                        </div><!-- /.Col -->
                    </div><!-- /.Row -->
                </div><!-- /.Container-fluid -->
            </section><!-- /.Content -->
        </div><!-- /.Content-wrapper -->       
                
        <!-- Start Stamping History Modal -->
        <div class="modal fade" id="modalStampingHistory" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Stamping History</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formStampingHistory" autocomplete="off">
                        @csrf
                        <input type="hidden" class="col-2" id="txtStampingHistoryId" name="stamping_history_id">
                        <input type="hidden" class="col-2" id="txtPartName" name="partname">
                        <input type="hidden" class="col-2" id="txtEmployeeNo" name="employee_no">
                        
                        <div class="modal-body">
                            <div class="row"><!-- Start Row Stamping History -->
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Parts Name</strong></span>
                                        </div>
                                            <input type="text" class="form-control" id="txtStampingHistoryPartName" name="stamping_history_part_name" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Die Code No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryDieCodeNo" name="stamping_history_diecode_no">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Date</strong></span>
                                        </div>
                                        <input type="date" class="form-control" id="dateStampingHistory" name="date_stamping_history" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Prev. Total Shot Accumulated</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryPrevTotalShotAccumulated" name="stamping_history_prev_total_shot_accum" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Total Shot</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryTotalShot" name="stamping_history_total_shot">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>New Total Shot Accumulated</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryNewTotalShotAccumulated" name="stamping_history_new_total_shot_accum" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Machine No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryMachineNo" name="stamping_history_machine_no">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Die Height</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryDieHeight" name="stamping_history_die_height">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>SPM</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryRevolutionNo" name="stamping_history_revolution_no">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Revision No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryRevisionNo" name="stamping_history_revision_no">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Neraiti</strong></span>
                                        </div>
                                        <select class="form-control" id="txtStampingHistoryNeraiti" name="stamping_history_neraiti">
                                            <option selected disabled> --- Select ---</option>
                                            <option value="1">Yes</option>
                                            <option value="2">None</option>
                                        </select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Remarks</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryRemark" name="stamping_history_remark">
                                    </div>

                                    <div class="input-group mb-3 d-none">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Created By</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryCreatedBy" name="stamping_history_created_by" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row Stamping History -->
                            
                            <div class="input-group mb-3">
                                <div class="input-group-prepend w-25">
                                    <span class="input-group-text w-100"><strong>Operator</strong></span>
                                </div>
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-dark" id="btnScanOperatorId" data-bs-toggle="modal" data-bs-target="#mdlScanEmployeeID"><i class="fa fa-qrcode w-100"></i></button>
                                </div>
                                <select class="form-control select2bs5 getUsers" id="slctStampingHistoryOperator" name="stamping_history_operator[]" multiple required></select>
                            </div>

                            <div class="col-12 input-group border-top">
                                <div class="col-6 mt-3">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                </div>
                                <div class="col-6 d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnStampingHistory" class="btn btn-dark">
                                        <i id="iBtnStampingHistoryIcon" class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.End Stamping History Modal -->

        <!-- Start Scan Modal -->
        <div class="modal fade" id="mdlScanEmployeeID" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body mt-3">
                        <input type="hidden" id="txtScanOperatorID" name="scan_operator_id" autocomplete="off">
                        <input type="text" class="scanQrBarCode w-100" id="txtScanEmployeeID" name="scan_employee_id" autocomplete="off">
                        <div class="text-center text-secondary"><h1><i class="fa fa-qrcode fa-lg"></i></h1>Scan Employee ID</div>
                    </div>
                </div>
            </div>
        </div><!-- /.End Scan Modal -->        
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let materialName
            let dataTableStampingHistory

            $(document).ready(function() {
                $('.select2bs5').select2({
                    theme: 'bootstrap-5',
                    tags: 'true'
                })          

                setTimeout(() => {
                    GetStampingProdnMaterialName($('.dataFromStampingProdnMaterialName'))
                    GetPatsPpdUser($('.getUsers'))
                }, 500)
                
                // ======================= START DATA TABLE =======================
                dataTableStampingHistory = $("#tblStampingHistory").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_stamping_history",
                        data: function(param){
                            param.materialName  =  materialName
                        }
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "part_name" },
                        { "data" : "die_code_no" },
                        { "data" : "date" },
                        { "data" : "total_shot" },
                        { "data" : "total_shot_accumulated" },
                        { "data" : "operator" },
                        { "data" : "machine_no" },
                        { "data" : "die_height" },
                        { "data" : "revolution_no" },
                        { "data" : "rev_no" },
                        { "data" : "neraiti" },
                        { "data" : "remarks" }
                    ],
                    
                    "columnDefs": [
                        // { className: "", targets: 0 },
                    ],
                })
                
                $('#selectStampingProdnMaterialName').change(function (e){
                    e.preventDefault()
                    materialName = $('#selectStampingProdnMaterialName').val()
                    dataTableStampingHistory.draw()
                    $('#buttonAddStampingHistory').removeClass('d-none')
                    UpdateTotalShotAccumulatedOnTime()
                })
                
                $('#modalStampingHistory').on('hidden.bs.modal', function(event){
                    UpdateTotalShotAccumulatedOnTime()
                });

                $('#buttonAddStampingHistory').click(function (e) { 
                    e.preventDefault()
                    $('#txtStampingHistoryPartName').val(materialName)
                    $.ajax({
                        url: "get_previous_shot_accumulated_by_partname",
                        type: "get",
                        data: {
                            materialName : materialName,
                        },
                        dataType: "json",
                        success: function (response) {
                            let newTotalShotAccumulated = response['newTotalShotAccum']
                            if(newTotalShotAccumulated != null){
                                $('#txtStampingHistoryPrevTotalShotAccumulated').val(newTotalShotAccumulated)
                            }else{
                                $('#txtStampingHistoryPrevTotalShotAccumulated').val('0')
                            }
                        }
                    })
                })
                
                $('#modalStampingHistory').on('hidden.bs.modal', function() {
                    $('#formStampingHistory')[0].reset()
                    $('#slctStampingHistoryOperator').val('').trigger('change')
                })

                $('#txtStampingHistoryTotalShot').keyup(function (e) { 
                    let getValue = $('#txtStampingHistoryTotalShot').val()
                    let getPrevTotalValue = $('#txtStampingHistoryPrevTotalShotAccumulated').val()
                    $('#txtStampingHistoryNewTotalShotAccumulated').val(Number(getValue) + Number(getPrevTotalValue))
                });

                $(document).on('click', '.actionEditStampingHistory', function(e){
                    e.preventDefault()
                    stampingHistoryID = $(this).attr('stamping_history-id')
                    partName = $(this).attr('part_name')

                    $('#txtStampingHistoryId').val(stampingHistoryID)
                    $('#txtPartName').val(partName)

                    GetStampingHistoryById(stampingHistoryID,partName)
                })

                $('#formStampingHistory').submit(function (e) { 
                    e.preventDefault()
                    $('#mdlScanEmployeeID').modal('show')
                    $('#txtScanOperatorID').val('')
                })

                $('#mdlScanEmployeeID').on('shown.bs.modal', function () {
                    $('#txtScanEmployeeID').focus()
                    const mdlEmployeeId = document.querySelector("#mdlScanEmployeeID");
                    const inptScanEmployeeId = document.querySelector("#txtScanEmployeeID");
                    let focus = false

                    mdlEmployeeId.addEventListener("mouseover", () => {
                        if (inptScanEmployeeId === document.activeElement) {
                            focus = true
                        } else {
                            focus = false
                        }
                    })

                    mdlEmployeeId.addEventListener("click", () => {
                        if (focus) {
                            inptScanEmployeeId.focus()
                        }
                    })             
                })

                $('#btnScanOperatorId').click(function (e) { 
                    e.preventDefault();
                    $('#txtScanOperatorID').val('1')
                })

                $('#txtScanEmployeeID').on('keypress',function(e){
                    if( e.keyCode == 13 ){
                        $.ajax({
                            url: "employee_id",
                            type: "get",
                            data: {
                                user_id : $('#txtScanEmployeeID').val().toUpperCase(),
                            },
                            dataType: "json",
                            success: function (response) {
                                let userDetails = response['userDetails']
                                if(userDetails != null){
                                    if($('#txtScanOperatorID').val() != 1){
                                        $('#txtEmployeeNo').val(userDetails.employee_id)
                                        UpdateStampingHistory()
                                    }else{
                                        let selectedUser = '<option selected value="' + userDetails.employee_id + '">' + userDetails.firstname +" "+ userDetails.lastname + '</option>'
                                        if ($('select[name="stamping_history_operator[]"]').val().includes(userDetails.employee_id) != true) {
                                            $('#slctStampingHistoryOperator').append(selectedUser)
                                        }else{
                                            alert('Employee No. '+userDetails.employee_id+' is already scanned!')
                                            $('.select2-selection__choice__remove').click()
                                            $('.select2-results__options').hide()
                                        }
                                    }
                                }else{
                                    toastr.error('Employee ID is not registered!')
                                }
                            }
                        })
                        $('#txtScanEmployeeID').val('')
                        $('#mdlScanEmployeeID').modal('hide')
                    }
                })                
            })
        </script>
    @endsection
@endauth

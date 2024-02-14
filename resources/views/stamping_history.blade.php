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
                                            <div class="input-group mb-3">
                                                <select class="form-control select2bs5 dataFromStampingProdnMaterialName" id="selectStampingProdnMaterialName"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label class="form-label">Previous totals shot accum.</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="txtStampingHistoryPrevTotalShotAccum" readonly>
                                            </div>
                                        </div>    
                                        <div class="col-sm-3">
                                            <label class="form-label">Die Code No.</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="txtStampingHistoryDieCodeNo" readonly>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-right"> 
                                        <button button type="button" class="btn btn-dark mb-3" id="buttonAddStampingHistory" data-bs-toggle="modal" data-bs-target="#modalStampingHistory" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Request</button>
                                    </div>
                                    <div class="table-responsive"><!-- Table responsive -->
                                        <table id="tblStampingHistory" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- &emsp; -->
                                                    <th>Action</th>
                                                    <th>Part Name</th>
                                                    <th>Die Code No.</th>
                                                    <th>Date</th>
                                                    <th>Total Shot</th>
                                                    <th>Total Shot Accum.</th>
                                                    <th>Operator</th>
                                                    <th>Machine No.</th>
                                                    <th>Die Height</th>
                                                    <th>SPM</th>
                                                    <th>Rev. No.</th>
                                                    <th>Item</th>
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
                
        <!-- Start OQC Inspection Modal -->
        <div class="modal fade" id="modalStampingHistory" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Stamping History</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formMimf" autocomplete="off">
                        @csrf
                        <input type="hidden" class="col-2" id="txtStampingHistoryId" name="mimf_id">
                        <input type="hidden" class="col-2" id="txtEmployeeNo" name="employee_no">
                        
                        <div class="modal-body">
                            <div class="row"><!-- Start Row OQC Data -->
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
                                        <input type="text" class="form-control" id="txtStampingHistoryRackNo" name="stamping_history_rack_no" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Date</strong></span>
                                        </div>
                                        <input type="date" class="form-control" id="dateStampingHistory" name="date_stamping_history" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Total Shot Accumulated</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryTotalShotAccumulated" name="stamping_history_device_name" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Total Shot</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryTotalShot" name="stamping_history_device_code">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Operator</strong></span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-dark" id="btnScanEmpoloyeeId" data-toggle="modal" data-target="#mdlScanEmployeeId"><i class="fa fa-qrcode w-100"></i></button>
                                        </div>
                                        <select class="form-control slct" id="slctStampingHistoryOperator"></select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Machine No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryMaterialType" name="stamping_history_material_type">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Die Height</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryQuantityFromInventory" name="stamping_history_quantity_from_inventory">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>SPM</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryNeededKgs" name="stamping_history_needed_kgs">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Revision No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtStampingHistoryVirginMaterial" name="stamping_history_virgin_material">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Neraiti</strong></span>
                                        </div>
                                        <select class="form-control" id="txtStampingHistoryOperator">
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
                                </div>
                            </div><!-- /.End Row OQC Data -->

                            <div class="col-12 input-group border-top">
                                <div class="col-6 mt-3">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                </div>
                                <div class="col-6 d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnMimf" class="btn btn-dark">
                                        <i id="iBtnMimfIcon" class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.End OQC Inspection Modal -->

        <!-- Start Scan Modal -->
        <div class="modal fade" id="mdlScanEmployeeID" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body mt-3">
                        <input type="text" class="scanQrBarCode w-100" id="txtScanEmployeeID" name="scan_employee_id" autocomplete="off">
                        <div class="text-center text-secondary"><h1><i class="fa fa-qrcode fa-lg"></i></h1>Scan Employee ID</div>
                    </div>
                </div>
            </div>
        </div><!-- /.End Scan Modal -->        
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let dataTableStampingHistory
            let materialName
            $(document).ready(function() {
                $('.select2bs5').select2({
                    theme: 'bootstrap-5'
                })          

                setTimeout(() => {
                    GetStampingProdnMaterialName($('.dataFromStampingProdnMaterialName'));
                }, 500);

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
                        { "data" : "item" },
                        { "data" : "neraiti" },
                        { "data" : "remarks" }
                    ],
                    "columnDefs": [
                        // { className: "", targets: 0 },
                    ],
                })
                
                $('#selectStampingProdnMaterialName').change(function (e) { 
                    e.preventDefault();
                    materialName = $('#selectStampingProdnMaterialName').val();
                    dataTableStampingHistory.draw()
                });

                $('#buttonAddStampingHistory').click(function (e) { 
                    e.preventDefault();
                    $('#txtStampingHistoryPartName').val(materialName);
                    console.log('BUTTON CLICK');
                });
                // $(document).on('click', '.actionEditMimf', function(e){
                //     e.preventDefault()
                //     mimfID = $(this).attr('mimf-id')


                //     $('#txtStampingHistoryId').val(mimfID)

                //     GetMimfById(mimfID)
                // })

                // $('#formMimf').submit(function (e) { 
                //     e.preventDefault()
                //     $('#mdlScanEmployeeID').modal('show')
                //     $('#mdlScanEmployeeID').on('shown.bs.modal', function () {
                //         $('#txtScanEmployeeID').focus()
                //         const mdlEmployeeId = document.querySelector("#mdlScanEmployeeID");
                //         const inptScanEmployeeId = document.querySelector("#txtScanEmployeeID");
                //         let focus = false
    
                //         mdlEmployeeId.addEventListener("mouseover", () => {
                //             if (inptScanEmployeeId === document.activeElement) {
                //                 focus = true
                //             } else {
                //                 focus = false
                //             }
                //         })
    
                //         mdlEmployeeId.addEventListener("click", () => {
                //             if (focus) {
                //                 inptScanEmployeeId.focus()
                //             }
                //         })             
                //     })

                // })

                // $('#txtScanEmployeeID').on('keypress',function(e){
                //     if( e.keyCode == 13 ){
                //         $.ajax({
                //             url: "employee_id",
                //             type: "get",
                //             data: {
                //                 user_id : $('#txtScanEmployeeID').val().toUpperCase(),
                //             },
                //             dataType: "json",
                //             success: function (response) {
                //                 let userDetails = response['userDetails']
                //                 if(userDetails != null){
                //                     $('#txtEmployeeNo').val(userDetails.employee_id)
                //                     UpdateMimf()
                //                 }else{
                //                     toastr.error('Only PPC Sr. Planner, PPC Planner and PPC Clerk are authorized to save!')
                //                 }
                //             }
                //         })
                //         $('#txtScanEmployeeID').val('')
                //         $('#mdlScanEmployeeID').modal('hide')
                //     }
                // })
            })

        </script>
    @endsection
@endauth

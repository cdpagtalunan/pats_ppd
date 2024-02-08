@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'MIMF')
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
                            <h1>MIMF</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">MIMF</li>
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
                                    <h3 class="card-title">MIMF Table</h3>
                                </div>

                                <div class="card-body"><!-- Start Page Content -->
                                    <div class="text-right"> 
                                        <button button type="button" class="btn btn-dark mb-3" id="buttonAddForkliftRequest" data-bs-toggle="modal" data-bs-target="#modalMimf" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Request</button>
                                    </div>
                                    <div class="table-responsive"><!-- Table responsive -->
                                        <table id="tblMimf" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <!-- &emsp; -->
                                                    <th>Action</th>
                                                    <th>CTRL No.</th>
                                                    <th>Date Issuance</th>
                                                    <th>WO / P.O No</th>
                                                    <th>Prod'n Qty.</th>
                                                    <th>Device Code</th>
                                                    <th>Device Name</th>
                                                    <th>Material Code</th>
                                                    <th>Material Type</th>
                                                    <th>Qnty from Inventory</th>
                                                    <th>Needed KGS</th>
                                                    <th>Virgin Material</th>
                                                    <th>Recycled</th>
                                                    <th>Prod'n</th>
                                                    <th>Delivery</th>
                                                    <th>Remarks</th>
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
        <div class="modal fade" id="modalMimf" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> MIMF</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formMimf" autocomplete="off">
                        @csrf
                        <input type="hidden" class="form-control" id="txtMimfId" name="mimf_id">
                        <input type="hidden" class="form-control" id="txtEmployeeNo" name="employee_no">
                        
                        <div class="modal-body">
                            <div class="row"><!-- Start Row OQC Data -->
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Control No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfControlNo" name="mimf_control_no" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>PMI PO No.</strong></span>
                                        </div>
                                        <select class="form-select" id="slctMimfPmiPoNo" name="mimf_pmi_po_no">
                                            <option>
                                                
                                            </option>
                                        </select>    
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Date of Issuance</strong></span>
                                        </div>
                                        <input type="date" class="form-control" id="dateMimfDateOfInssuance" name="mimf_date_issuance" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Prod'n Quantity</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfProdnQuantity" name="mimf_prodn_quantity" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Device Code</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfDeviceCode" name="mimf_device_code" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Device Name</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfDeviceName" name="mimf_device_name" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Material Code</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfMaterialCode" name="mimf_material_code" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Material Type</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfMaterialType" name="mimf_material_type" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Quantity from Inventory</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfQuantityFromInventory" name="mimf_quantity_from_inventory" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Needed KGS</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfNeededKgs" name="mimf_needed_kgs" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Virgin Material</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfVirginMaterial" name="mimf_virgin_material">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Recycled</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfRecycled" name="mimf_recycled">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Prod'n</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfProdn" name="mimf_prodn">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Delivery</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfDelivery" name="mimf_delivery">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Remarks</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfRemark" name="mimf_remark">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Created By</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtCreatedBy" name="created_by" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row OQC Data -->

                            <div class="col-12 input-group">
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
            let getPoNo
            let checkedDrawCount
            let dataTableOQCInspectionFirstStamping
            $(document).ready(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap-5'
                })          

                // ======================= START DATA TABLE =======================
                dataTableOQCInspectionFirstStamping = $("#tblMimf").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_mimf",
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "control_no" },
                        { "data" : "date_issuance" },
                        { "data" : "po_no" },
                        { "data" : "prodn_qty" },
                        { "data" : "device_code" },
                        { "data" : "device_name" },
                        { "data" : "material_code" },
                        { "data" : "material_type" },
                        { "data" : "qty_invt" },
                        { "data" : "needed_kgs" },
                        { "data" : "virgin_material" },
                        { "data" : "recycled" },
                        { "data" : "prodn" },
                        { "data" : "delivery" },
                        { "data" : "remarks" }
                    ],
                    "columnDefs": [
                        // { className: "", targets: 0 },
                    ],
                })

                $('#formMimf').submit(function (e) { 
                    e.preventDefault()
                    $('#mdlScanEmployeeID').modal('show')
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
                                    $('#txtEmployeeNo').val(userDetails.employee_id)
                                    UpdateMimf()
                                }else{
                                    toastr.error('ID Number Not Registered!')
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

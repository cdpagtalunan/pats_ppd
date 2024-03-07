@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Material Issuance Monitoring Form')
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
                            <h1>Material Issuance Monitoring Form</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Material Issuance Monitoring Form</li>
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
                                <!-- <div class="card-header">
                                    <h3 class="card-title">Material Issuance Monitoring Table</h3> 
                                </div> -->
                                <ul class="nav nav-tabs p-2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mimfRequest" type="button" role="tab">Material Issuance Monitoring Table</button>
                                    </li>
                                    <li class="nav-item d-none navMimfStampingMatrix" role="presentation">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#mimfStampingMatrix" type="button" role="tab">MIMF Stamping Setting</button>
                                    </li>
                                </ul>

                                <div class="card-body"><!-- Start Page Content -->
                                    <div class="tab-content" id="myTabContent"> <!-- tab-content -->
                                        <div class="tab-pane fade show active" id="mimfRequest" role="tabpanel">
                                            <div class="col-12 input-group mb-3">
                                                <div class="col-5">
                                                    <label class="form-label">MIMF Category:</label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="selectCategory" name="category">
                                                            <option selected disabled>--- Select Category ---</option>
                                                            <option value="1">Stamping</option>    
                                                            <option value="2">Molding</option>    
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-7 d-flex justify-content-end mt-4">
                                                    <button button type="button" class="btn btn-dark mb-3 d-none" id="buttonAddMimf" data-bs-toggle="modal" data-bs-target="#modalMimf" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Request</button>
                                                </div>
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
                                                            <th>YEC P.O No</th>
                                                            <th>PMI P.O No</th>
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
                                                            <th>PO Bal.</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div><!-- /.Table responsive -->
                                        </div>

                                        <div class="tab-pane fade d-none navMimfStampingMatrix" id="mimfStampingMatrix" role="tabpanel">
                                            <div class="text-right"> 
                                                <button button type="button" class="btn btn-dark" id="buttonAddMimfStampingMatrix" data-bs-toggle="modal" data-bs-target="#modalMimfStampingMatrix" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Matrix</button>
                                            </div>        
                                            <div class="table-responsive mt-3">
                                                <table id="tableMimfStampingMatrix" class="table table-bordered table-hover nowrap" style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Item Code</th>
                                                            <th>Item Name</th>
                                                            <th>Part Number</th>
                                                            <th>Matrial Type</th>
                                                            <th>Pin / KG</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        
                                    </div> <!-- /.tab-content -->
                                </div><!-- /.End Page Content -->
                            </div><!-- /.Card -->
                        </div><!-- /.Col -->
                    </div><!-- /.Row -->
                </div><!-- /.Container-fluid -->
            </section><!-- /.Content -->
        </div><!-- /.Content-wrapper -->       
                
        <!-- Start MIMF Modal -->
        <div class="modal fade" id="modalMimf" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Material Issuance Monitoring Form</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formMimf" autocomplete="off">
                        @csrf
                        <input type="hidden" class="col-1 mimfClass" id="txtPpsDiesetId" name="pps_dieset_id" placeholder="For Molding">
                        <input type="hidden" class="col-1 mimfClass" id="txtPpdMatrixId" name="ppd_matrix_id" placeholder="For Molding">
                        <input type="hidden" class="col-1 mimfClass" id="MimfStampingMatrix" name="pps_whse_id">
                        <input type="hidden" class="col-1 mimfClass" id="txtPpsPoReceivedId" name="pps_po_rcvd_id">
                        <input type="hidden" class="col-1 mimfClass" id="txtMimfId" name="mimf_id">
                        <input type="hidden" class="col-1" id="txtMimfStampingMatrixStatus" name="mimf_stamping_matrix_status" required>
                        <input type="hidden" class="col-1 mimfClass" id="txtPpdMimfStampingMatrixId" name="ppd_mimf_stamping_matrix_id" placeholder="For Stamping">
                        <input type="hidden" class="col-1 mimfClass" id="txtEmployeeNo" name="employee_no">
                        
                        <div class="modal-body">
                            <div class="row"><!-- Start Row MIMF Data -->
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Date of Issuance</strong></span>
                                        </div>
                                        <input type="date" class="form-control" id="dateMimfDateOfInssuance" name="mimf_date_issuance" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Reset Every Month&#013;Format: Year-Month-000.">&nbsp;</i>
                                                <strong>
                                                    Control No.
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass" id="txtMimfControlNo" name="mimf_control_no" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PO Received Order No.">&nbsp;</i>
                                                    PMI PO No.
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass" id="txtMimfPmiPoNo" name="mimf_pmi_po_no">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PO Received Order Quantity.">&nbsp;</i>
                                                    Prod'n Quantity
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearReceivedPo" id="txtMimfProdnQuantity" name="mimf_prodn_quantity" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PO Received Item Code.">&nbsp;</i>
                                                    Device Code
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearReceivedPo" id="txtMimfDeviceCode" name="mimf_device_code" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PO Received Item Name.">&nbsp;</i>
                                                    Device Name
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearReceivedPo" id="txtMimfDeviceName" name="mimf_device_name" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PPS Warehouse Part Number.">&nbsp;</i>
                                                    Material Code
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearPPSMIS" id="txtMimfMaterialCode" name="mimf_material_code" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PPS Warehouse Material Type.">&nbsp;</i>
                                                    Material Type
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearPPSMIS" id="txtMimfMaterialType" name="mimf_material_type" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PPS Warehouse Transaction.">&nbsp;</i>
                                                    Quantity from Inventory
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearPPSMIS" id="txtMimfQuantityFromInventory" name="mimf_quantity_from_inventory" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question moldingOnly" data-bs-toggle="tooltip" data-bs-html="true" title="Prodn Qty(PO Received Order Quantity) * Shot Weight(Die-Set) / No. of Cavity(Die-Set) / 1000.">&nbsp;</i>
                                                    <i class="fa-solid fa-circle-question stampingOnly" data-bs-toggle="tooltip" data-bs-html="true" title="Prodn Qty(PO Received Order Quantity) / Pin KG(MIMF Stamping Setting) + 10%.">&nbsp;</i>
                                                    Needed KGS
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearDieSet" id="txtMimfNeededKgs" name="mimf_needed_kgs" readonly>
                                    </div>

                                    <div class="input-group mb-3 moldingOnly">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Needed KGS(MIMF) * Virgin Material(Matrix) .">&nbsp;</i>
                                                    Virgin Material
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearMatrix" id="txtMimfVirginMaterial" name="mimf_virgin_material" readonly>
                                    </div>

                                    <div class="input-group mb-3 moldingOnly">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Needed KGS(MIMF) * Recycle(Matrix) .">&nbsp;</i>
                                                    Recycled
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control mimfClass clearMatrix" id="txtMimfRecycled" name="mimf_recycled" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Prod'n</strong></span>
                                        </div>
                                        <input type="date" class="form-control mimfClass" id="dateMimfProdn" name="date_mimf_prodn">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Delivery</strong></span>
                                        </div>
                                        <input type="text" class="form-control mimfClass" id="txtMimfDelivery" name="mimf_delivery">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Remarks</strong></span>
                                        </div>
                                        <input type="text" class="form-control mimfClass" id="txtMimfRemark" name="mimf_remark">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Created By</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtCreatedBy" name="created_by" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row MIMF Data -->

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
        </div><!-- /.End MIMF Modal -->

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
        
        <!-- Start MIMF STAMPING MATRIX Modal -->
        <div class="modal fade" id="modalMimfStampingMatrix" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Material Issuance Monitoring Form Stamping Matrix</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formMimfStampingMatrix" autocomplete="off">
                        @csrf
                        <input type="hidden" class="col-2" id="txtMimfStampingMatrixId" name="mimf_stamping_matrix_id">                        
                        <div class="modal-body">
                            <div class="row"><!-- Start Row MIMF STAMPING MATRIX Data -->
                                <div class="col-6 mt-3">
                                    <div class="input-group mb-3 fixed">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Item Name</strong></span>
                                        </div>
                                        <select class="form-control select2bs5 ppsPoReceived selectValue" id="slctMimfStampingMatrixItemName" name="mimf_stamping_matrix_item_name"></select>    
                                    </div>          

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Item Code</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfStampingMatrixItemCode" name="mimf_stamping_matrix_item_code" readonly>
                                    </div>
                                    
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Pin / KG</strong></span>
                                        </div>
                                            <input type="text" class="form-control" id="txtMimfStampingMatrixPinkg" name="mimf_stamping_matrix_pin_kg">
                                    </div>     
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Part Number</strong></span>
                                        </div>
                                        <select class="form-control select2bs5 ppsWhse selectValue" id="slctMimfStampingMatrixPartNumber" name="mimf_stamping_matrix_part_number"></select>    
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Material Type</strong></span>
                                        </div>
                                        <input type="text" class="form-control clearDieSet" id="txtMimfStampingMatrixMaterialType" name="mimf_stamping_matrix_material_type" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Created By</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfStampingMatrixCreatedBy" name="mimf_stamping_matrix_created_by" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row MIMF STAMPING MATRIX Data -->

                            <div class="col-12 input-group">
                                <div class="col-6 mt-3">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                </div>
                                <div class="col-6 d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnMimfStampingMatrix" class="btn btn-dark">
                                        <i id="iBtnMimfStampingMatrixIcon" class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.End MIMF STAMPING MATRIX Modal -->
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let dataTableMimf
            let dataTableMimfStampingMatrix
            let mimfCategory
            $(document).ready(function() {
                $('.select2bs5').select2({
                    theme: 'bootstrap-5'
                })          

                setTimeout(() => {     
                    GetPpsWarehouse($('.ppsWhse'))
                    GetPpsPoReceivedItemName($('.ppsPoReceived'))
                }, 500);

                $('#selectCategory').change(function (e) { 
                    e.preventDefault();

                    mimfCategory = $('#selectCategory').val()
                    if($('#selectCategory').val() == 1){
                        $('#txtMimfStampingMatrixStatus').val('1')
                        $('.moldingOnly').addClass('d-none')
                        $('.stampingOnly').removeClass('d-none')
                        $('.clearMatrix').attr('required', false)
                        $('.navMimfStampingMatrix').removeClass('d-none')
                    }else{
                        $('#txtMimfStampingMatrixStatus').val('2')
                        $('.moldingOnly').removeClass('d-none')
                        $('.stampingOnly').addClass('d-none')
                        $('.clearMatrix').attr('required', true)
                        $('.navMimfStampingMatrix').addClass('d-none')
                    }
                    dataTableMimf.draw()
                    $('#buttonAddMimf').removeClass('d-none')
                })

                // ======================= START MIMF DATA TABLE =======================
                dataTableMimf = $("#tblMimf").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_mimf",
                        data: function(param){
                            param.mimfCategory  =  mimfCategory
                        }
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "control_no" },
                        { "data" : "date_issuance" },
                        { "data" : "yec_po_no" },
                        { "data" : "pmi_po_no" },
                        { "data" : "prodn_qty" },
                        { "data" : "device_code" },
                        { "data" : "device_name" },
                        { "data" : "material_code" },
                        { "data" : "material_type" },
                        { "data" : "qty_invt" },
                        { "data" : "needed_kgs" },
                        { "data" : "virgin_material"},
                        { "data" : "recycled" },
                        { "data" : "prodn" },
                        { "data" : "delivery" },
                        { "data" : "po_balance" },
                        { "data" : "remarks" }
                    ],
                    "columnDefs": [
                        // "targets": 'invis',
                    ],
                    drawCallback: function (data) {
                        const apiDataTable= this.api()
                        if(data.oAjaxData.mimfCategory == 1){
                            apiDataTable.columns([11,12]).visible(false)
                        }else{
                            apiDataTable.columns([11,12]).visible(true)
                        }
                    }
                })

                $('#buttonAddMimf').click(function(event){
                    event.preventDefault()
                    $.ajax({
                        url: 'get_control_no',
                        method: 'get',
                        data: {
                            'category': $('#txtMimfStampingMatrixStatus').val()
                        },

                        beforeSend: function(){
                        
                        },
                        success: function (response) {
                            let getNewControlNo = response['newControlNo'];
                            $('#txtMimfControlNo').val(getNewControlNo);

                        }
                    })
                })

                $("#txtMimfPmiPoNo").keypress(function(){
                    $(this).val($(this).val().toUpperCase())
                })

                $("#txtMimfPmiPoNo").keyup(function() {
                    let getValue = $(this).val()
                    $.ajax({
                        url: 'get_pmi_po',
                        method: 'get',
                        data: {
                            'getValue'      : getValue,
                            'mimfCategory'  : $('#txtMimfStampingMatrixStatus').val()
                        },
                        beforeSend: function(){
                        },
                        success: function(response){
                            if($('#txtMimfStampingMatrixStatus').val() != 1){
                                let getPoReceivedPmiPoForMolding = response['getPoReceivedPmiPoForMolding']
                                let totalBalanceForMolding = response['totalBalanceForMolding']
                                let kgs = 0
                                if(getPoReceivedPmiPoForMolding.length > 0){
                                    $('#txtPpsPoReceivedId').val(getPoReceivedPmiPoForMolding[0].id)
                                    $('#txtMimfProdnQuantity').val(getPoReceivedPmiPoForMolding[0].OrderQty)
                                    $('#txtMimfDeviceCode').val(getPoReceivedPmiPoForMolding[0].ItemCode)
                                    $('#txtMimfDeviceName').val(getPoReceivedPmiPoForMolding[0].ItemName)
                                    
                                    if(getPoReceivedPmiPoForMolding[0].pps_dieset_info != null){
                                        // kgs = (getPoReceivedPmiPoForMolding[0].OrderQty*getPoReceivedPmiPoForMolding[0].pps_dieset_info.ShotWgt*getPoReceivedPmiPoForMolding[0].pps_dieset_info.NoOfCav/1000).toFixed(2)
                                        kgs = (getPoReceivedPmiPoForMolding[0].OrderQty*getPoReceivedPmiPoForMolding[0].pps_dieset_info.ShotWgt/1000/getPoReceivedPmiPoForMolding[0].pps_dieset_info.NoOfCav).toFixed(2)
                                        $('#txtPpsDiesetId').val(getPoReceivedPmiPoForMolding[0].pps_dieset_info.id)
                                        $('#txtMimfNeededKgs').val(kgs)

                                        if(getPoReceivedPmiPoForMolding[0].pps_dieset_info.pps_warehouse_info != null){
                                            $('#MimfStampingMatrix').val(getPoReceivedPmiPoForMolding[0].pps_dieset_info.pps_warehouse_info.id)
                                            $('#txtMimfMaterialCode').val(getPoReceivedPmiPoForMolding[0].pps_dieset_info.pps_warehouse_info.PartNumber)
                                            $('#txtMimfMaterialType').val(getPoReceivedPmiPoForMolding[0].pps_dieset_info.pps_warehouse_info.MaterialType)
                                            $('#txtMimfQuantityFromInventory').val(totalBalanceForMolding)
                                        }else{
                                            console.log('tbl_dieset->Material != tbl_Warehouse->MaterialType')
                                            $('.clearPPSMIS').val('')
                                        }
                                    }else{
                                        // toastr.error('The device name "'+getPoReceivedPmiPoForMolding[0].ItemName+'" isn`t recognized in the PPS DieSet Module.')
                                        // toastr.error('The PPS Die-Set Module does not recognize the Device Name "'+getPoReceivedPmiPoForMolding[0].ItemName+'".')
                                        console.log('tbl_POReceived->ItemName != tbl_dieset->DeviceName')
                                        $('.clearDieSet').val('')
                                        $('.clearPPSMIS').val('')
                                    }

                                    if(getPoReceivedPmiPoForMolding[0].matrix_info != null){
                                        let virgin_computation = (kgs*getPoReceivedPmiPoForMolding[0].matrix_info.virgin_percent)/100
                                        let recyled_computation = (kgs*getPoReceivedPmiPoForMolding[0].matrix_info.recycle_percent)/100

                                        $('#txtPpdMatrixId').val(getPoReceivedPmiPoForMolding[0].matrix_info.id)
                                        $('#txtMimfVirginMaterial').val(virgin_computation.toFixed(2))
                                        $('#txtMimfRecycled').val(recyled_computation.toFixed(2))
                                    }else{
                                        console.log('PPD devices->name != tbl_POReceived->ItemName')
                                        $('.clearMatrix').val('')
                                    }
                                }else{
                                    $('.clearReceivedPo').val('')
                                    $('.clearPPSMIS').val('')
                                    $('.clearDieSet').val('')
                                    $('.clearPPSMIS').val('')
                                    $('.clearMatrix').val('')
                                }
                            }else{
                                let getPoReceivedPmiPoForStamping = response['getPoReceivedPmiPoForStamping']
                                let totalBalanceForStamping = response['totalBalanceForStamping']
                                let kgs = 0

                                if(getPoReceivedPmiPoForStamping.length > 0){
                                    $('#txtPpsPoReceivedId').val(getPoReceivedPmiPoForStamping[0].id)
                                    $('#txtMimfProdnQuantity').val(getPoReceivedPmiPoForStamping[0].OrderQty)
                                    $('#txtMimfDeviceCode').val(getPoReceivedPmiPoForStamping[0].ItemCode)
                                    $('#txtMimfDeviceName').val(getPoReceivedPmiPoForStamping[0].ItemName)
                                    
                                    if(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info != null){
                                        kgs = (getPoReceivedPmiPoForStamping[0].OrderQty/getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.pin_kg+.10).toFixed(2)
                                        $('#txtPpdMimfStampingMatrixId').val(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.id)
                                        $('#txtMimfNeededKgs').val(kgs)

                                        if(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.pps_whse_info != null){
                                            $('#MimfStampingMatrix').val(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.pps_whse_info.id)
                                            $('#txtMimfMaterialCode').val(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.pps_whse_info.PartNumber)
                                            $('#txtMimfMaterialType').val(getPoReceivedPmiPoForStamping[0].mimf_stamping_matrix_info.pps_whse_info.MaterialType)

                                            $('#txtMimfQuantityFromInventory').val(totalBalanceForStamping)
                                        }else{
                                            $('.clearPPSMIS').val('')
                                        }
                                    }else{
                                        console.log('tbl_POReceived->ItemCode != mimf_stamping_matrices->item_code')
                                        $('.clearDieSet').val('')
                                        $('.clearPPSMIS').val('')
                                        // toastr.error('The MIMF Stamping Setting Module does not recognize the Item Name: "'+getPoReceivedPmiPoForStamping[0].ItemName+'"')
                                    }
                                }else{
                                    $('.clearReceivedPo').val('')
                                    $('.clearPPSMIS').val('')
                                    $('.clearDieSet').val('')
                                    $('.clearPPSMIS').val('')
                                    $('.clearMatrix').val('')
                                }
                            }
                        }
                    })
                })

                $('#modalMimf').on('hidden.bs.modal', function() {
                    $('.mimfClass').val('')
                })

                $(document).on('click', '.actionEditMimf', function(e){
                    e.preventDefault()
                    mimfID = $(this).attr('mimf-id')
                    whseID = $(this).attr('whse-id')
                    matrixID = $(this).attr('matrix-id')
                    dieSetID = $(this).attr('dieset-id')
                    poReceivedID = $(this).attr('po_received-id')
                    mimfStatus = $(this).attr('mimf-status')
                    ppdMimfStampingMatrixID = $(this).attr('mimf_matrix-id')


                    $('#txtMimfId').val(mimfID)
                    $('#MimfStampingMatrix').val(whseID)
                    $('#txtPpdMatrixId').val(matrixID)
                    $('#txtPpsDiesetId').val(dieSetID)
                    $('#txtPpsPoReceivedId').val(poReceivedID)
                    $('#txtMimfStampingMatrixStatus').val(mimfStatus)
                    $('#txtPpdMimfStampingMatrixId').val(ppdMimfStampingMatrixID)

                    GetMimfById(mimfID,whseID,matrixID,dieSetID,poReceivedID,ppdMimfStampingMatrixID)
                })

                $('#formMimf').submit(function (e) { 
                    e.preventDefault()
                    UpdateMimf()
                    // $('#mdlScanEmployeeID').modal('show')
                    // $('#mdlScanEmployeeID').on('shown.bs.modal', function () {
                    //     $('#txtScanEmployeeID').focus()
                    //     const mdlEmployeeId = document.querySelector("#mdlScanEmployeeID");
                    //     const inptScanEmployeeId = document.querySelector("#txtScanEmployeeID");
                    //     let focus = false
    
                    //     mdlEmployeeId.addEventListener("mouseover", () => {
                    //         if (inptScanEmployeeId === document.activeElement) {
                    //             focus = true
                    //         } else {
                    //             focus = false
                    //         }
                    //     })
    
                    //     mdlEmployeeId.addEventListener("click", () => {
                    //         if (focus) {
                    //             inptScanEmployeeId.focus()
                    //         }
                    //     })             
                    // })
                })

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

                // ======================= START MIMF DATA TABLE =======================
                dataTableMimfStampingMatrix = $("#tableMimfStampingMatrix").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_mimf_stamping_matrix",
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "item_code" },
                        { "data" : "item_name" },
                        { "data" : "part_number" },
                        { "data" : "material_type" },
                        { "data" : "pin_kg" },
                    ],
                    "columnDefs": [
                        // { className: "", targets: 0 },
                    ],
                })

                $('#slctMimfStampingMatrixItemName').change(function (e) { 
                    e.preventDefault();
                    $.ajax({
                        url: "get_pps_po_recveived_item_name",
                        type: "get",
                        data: {
                            poReceivedDb : $('#slctMimfStampingMatrixItemName').val(),
                        },
                        dataType: "json",
                        success: function (response) {
                            let getItemCode = response['getItemCode']
                            console.log('getItemCode',getItemCode);
                            if(getItemCode != undefined){
                                $('#txtMimfStampingMatrixItemCode').val(getItemCode.ItemCode)
                            }
                        }
                    })
                })

                $('#slctMimfStampingMatrixPartNumber').on('change', function (e){ 
                    e.preventDefault();
                    // console.log('PART_NAME: ',$(this).val())
                    $.ajax({
                        url: "get_pps_warehouse",
                        type: "get",
                        data: {
                            ppsWhseDb : $('select[name="mimf_stamping_matrix_part_number"]').val(),
                        },
                        dataType: "json",
                        success: function (response) {
                            let getMaterialType = response['getMaterialType']
                            console.log('getMaterialType',getMaterialType);
                            if(getMaterialType != undefined){
                                $('#txtMimfStampingMatrixMaterialType').val(getMaterialType[0].MaterialType)
                            }
                        }
                    })
                })

                $('#formMimfStampingMatrix').submit(function (e) { 
                    e.preventDefault()
                    UpdateMimfStampignMatrix()
                })

                $(document).on('click', '.actionEditMimfStampingMatrix', function(e){
                    e.preventDefault()
                    mimfStampingMatrixID = $(this).attr('mimf_stamping_matrix-id')

                    $('#txtMimfStampingMatrixId').val(mimfStampingMatrixID)

                    GetMimfStampingMatrixById(mimfStampingMatrixID)
                })

                $('#modalMimfStampingMatrix').on('hidden.bs.modal', function() {
                    $('#formMimfStampingMatrix')[0].reset()
                    $('.selectValue').val('').trigger('change')
                })

            })
        </script>
    @endsection
@endauth

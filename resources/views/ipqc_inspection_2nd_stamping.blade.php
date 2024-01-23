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
            .hidden_scanner_input{
                position: absolute;
                opacity: 0;
            }
            textarea{
                resize: none;
            }

            #colDevice, #colMaterialProcess{
                transition: .5s;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>In-Process Quality Control</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">First Stamping</li>
                                <li class="breadcrumb-item active">In-Process Quality Control</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            {{-- <div class="card"> --}}
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Number</label>
                                            <div class="input-group mb-3">
                                                <button hidden class="btn btn-primary" id="btnScanPo" data-bs-toggle="modal" data-bs-target="#mdlScanQrCode"><i class="fa-solid fa-qrcode"></i></button>
                                                {{-- <button type="button" class="btn btn-dark" id="btnScanPo" data-toggle="modal" data-target="#mdlScanQrCode"><i class="fa fa-qrcode w-100"></i></button> --}}
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Press Enter Key to Search PO Number"></i>
                                                <input type="text" class="form-control" placeholder="Search PO Number" aria-label="Username" name="po_number" id="txtSearchPONum">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Part Code</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Product Code" aria-label="Partcode" id="txtSearchPartCode" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" aria-label="Materialname" id="txtSearchMatName" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Scan QR Modal -->
                    <div class="modal fade" id="mdlScanQrCode" data-formid="" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header border-bottom-0 pb-0">
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body pt-0">
                                    {{-- hidden_scanner_input --}}
                                    <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanQrCode" name="scan_qr_code" autocomplete="off">
                                    <div class="text-center text-secondary">Please scan the code.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.End Scan QR Modal -->

                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            {{-- <div class="card card-primary"> --}}
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">In-Process Quality Control</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    {{-- TABS --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Pending-tab" data-bs-toggle="tab" href="#Pending" role="tab" aria-controls="Pending" aria-selected="true">Pending</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Completed-tab" data-bs-toggle="tab" href="#Completed" role="tab" aria-controls="Completed" aria-selected="false">Completed</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Resetup-tab" data-bs-toggle="tab" href="#Resetup" role="tab" aria-controls="Resetup" aria-selected="false">For Re-Setup</a>
                                        </li>
                                    </ul>
                                    <br>
                                    <div class="tab-content" id="myTabContent">
                                        {{-- Pending Tab --}}
                                        <div class="tab-pane fade show active" id="Pending" role="tabpanel" aria-labelledby="Pending-tab">
                                            {{-- <div class="card-body"> --}}
                                                <div style="float: right;" class="mb-1">
                                                    {{-- ##CLARK NOTE##
                                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#modalIpqcInspection" id="btnAddProdData">
                                                        <i class="fa-solid fa-plus"></i> Add IPQC Inspection</button> --}}
                                                    {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalExport">Generate Excel Report</button> --}}
                                                    {{-- <div id="btnExportPDF"></div> --}}
                                                    <button class="btn btn-primary" id="btnExportPackingList">
                                                            <i class="fa-solid fa-file-export"></i> Export Packing List (PDF)
                                                        </a>
                                                    </button>

                                                    {{-- <button class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#modalExportPackingList" id="btnExportPackingList">
                                                            <i class="fa-solid fa-file-export"></i> Export Packing List
                                                    </button> --}}
                                                </div>

                                                <div class="table-responsive">
                                                    <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                    <table id="tblIpqcInspectionPending" class="table table-sm table-bordered table-striped table-hover text-center"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>IPQC Status</th>
                                                                <th>Created At</th>
                                                                <th>PO Number</th>
                                                                <th>Production Lot#</th>
                                                                <th>Judgement</th>
                                                                <th>QC Sample</th>
                                                                {{-- <th>Document No</th> --}}
                                                                <th>Inspected At</th>

                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        {{-- Completed Tab --}}
                                        <div class="tab-pane fade" id="Completed" role="tabpanel" aria-labelledby="Completed-tab">
                                            {{-- <div class="card-body"> --}}
                                                <div class="table-responsive">
                                                    <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                    <table id="tblIpqcInspectionCompleted" class="table table-sm table-bordered table-striped table-hover text-center"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>IPQC Status</th>
                                                                <th>Created At</th>
                                                                <th>PO Number</th>
                                                                <th>Production Lot#</th>
                                                                <th>Judgement</th>
                                                                <th>QC Sample</th>
                                                                {{-- <th>Document No</th> --}}
                                                                <th>Inspected At</th>

                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        {{-- For Re-Setup Tab --}}
                                        <div class="tab-pane fade" id="Resetup" role="tabpanel" aria-labelledby="Resetup-tab">
                                            {{-- <div class="card-body"> --}}
                                                <div class="table-responsive">
                                                    <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                    <table id="tblIpqcInspectionResetup" class="table table-sm table-bordered table-striped table-hover text-center"
                                                        style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Action</th>
                                                                <th>IPQC Status</th>
                                                                <th>Created At</th>
                                                                <th>PO Number</th>
                                                                <th>Production Lot#</th>
                                                                <th>Judgement</th>
                                                                <th>QC Sample</th>
                                                                {{-- <th>Document No</th> --}}
                                                                <th>Inspected At</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                    </div>
                                    {{-- TABS END --}}
                                </div>
                                <!-- !-- End Page Content -->

                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- PAST FY FOR REPORT MODAL START -->
        <div class="modal fade" id="modalExportPackingList">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title">Generate Packing List</h4>
                        <button type="button" style="color: #fff;" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form id="form_Export_Past_Fy" action="{{ route('export_past_fy') }}"> --}}
                    <form id="formGeneratePackingList">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Select Control # for Export</label>
                                        <select class="form-control selectControlNumber" name="ctrl_no" id="txtCtrlNo" style="width: 100%;"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button id="btnExportFile" class="btn btn-primary"><i id="iBtnDownloadPackingList" class="fas fa-file-download" ></i> Download</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- PAST FY FOR REPORT MODAL END -->

        <!-- CONFIRM SUBMIT MODAL START -->
        <div class="modal fade" id="modalConfirmSubmitIPQCInspection">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title"><i class="fa-solid fa-file-circle-check"></i>&nbsp;&nbsp;Confirmation</h4>
                        <button type="button" style="color: #fff" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="FrmConfirmSubmitIPQCInspection">
                        @csrf
                        <div class="modal-body">
                            <div class="row d-flex justify-content-center">
                                <label class="text-secondary mt-2">Are you sure you want to proceed?</label>
                                <input type="hidden" class="form-control" name="fs_productions_id" id="txtFsProductionsId">
                                <input type="hidden" class="form-control" name="stamping_ipqc_id" id="txtStampingIPQCId">
                                <input type="hidden" class="form-control" name="stamping_ipqc_status" id="txtStampingIPQCStatus">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnConfirmSubmitIPQCInspection" class="btn btn-primary"><i id="ConfirmSubmitIPQCInspectionIcon"
                                    class="fa fa-check"></i> Proceed</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- CONFIRM SUBMIT MODAL END -->

        <!-- MODALS -->
        {{-- * ADD --}}
        <div class="modal fade" id="modalIpqcInspection" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add IPQC Inspection Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="formIPQCInspectionData" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="txtStampingIpqcId" name="stamping_ipqc_id">
                            <input type="hidden" id="txtFirstStampingProdId" name="first_stamping_prod_id">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">PO Number:</label>
                                                <input type="text" class="form-control form-control-sm" name="po_number" id="txtPoNumber" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Part Code:</label>
                                                <input type="text" class="form-control form-control-sm" name="part_code" id="txtPartCode" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Material Name:</label>
                                                <input type="text" class="form-control form-control-sm" name="material_name" id="txtMaterialName" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Production Lot #:</label>
                                                <input type="text" class="form-control form-control-sm" name="production_lot" id="txtProductionLot" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Input:</label>
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="QC Sample Qty"></i>
                                                <input type="text" class="form-control form-control-sm" name="input" id="txtInput" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Output:</label>
                                                <input type="text" class="form-control form-control-sm" name="output" id="txtOutput"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">NG:</label>
                                                <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Input - Output = NG Qty"></i>
                                                <input type="text" class="form-control form-control-sm" name="ng_qty" id="txtNGQty" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body"><div class="form-group">
                                            <div class="form-group">
                                                <label class="form-label">Judgement:</label>
                                                {{-- <input type="text" class="form-control form-control-sm" name="judgement" id="txtJudgement"> --}}
                                                <select class="form-control" type="text" name="judgement" id="txtJudgement">
                                                    <option value="" disabled selected>Select Judgement</option>
                                                    <option value="Accepted" style="color:#008000">Accepted</option>
                                                    <option value="Rejected" style="color:#ff0000">Rejected</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Inspector Name:</label>
                                                <input type="hidden" class="form-control form-control-sm" name="inspector_id" id="txtInspectorID" readonly value="@php echo Auth::user()->id; @endphp" readonly>
                                                {{-- `${let name = response['users'][index].rapidx_user_details.firstname + response['users'][index].rapidx_user_details.lastname}` --}}
                                                <input type="text" class="form-control form-control-sm" name="inspector_name" id="txtInspectorName" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-check-label"> Keep Sample:</label>
                                                <div class="form-check form-check-inline ml-1">
                                                    <input class="form-check-input" type="radio" value="1" name="keep_sample" id="txtKeepSample1">
                                                    <label class="form-check-label" for="txtKeepSample1"> Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="2" name="keep_sample" id="txtKeepSample2">
                                                    <label class="form-check-label" for="txtKeepSample2"> No</label>
                                                </div>
                                            </div>
                                            {{-- DROPDOWN --}}
                                            <div class="form-group">
                                                <label class="form-label">Doc No.(B Drawing):</label>
                                                {{-- <input type="text" class="form-control form-control-sm" name="document_no" id="txtDocumentNo" readonly> --}}
                                                <div class="input-group input-group-sm">
                                                    <select class="form-control text-center" id="txtSelectDocNoBDrawing" name="doc_no_b_drawing" style="width: 100%;">
                                                        {{-- <option disabled selected>-- Document No. --</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Doc No.(Inspection Standard):</label>
                                                {{-- <input type="text" class="form-control form-control-sm" name="document_no" id="txtDocumentNo" readonly> --}}
                                                <div class="input-group input-group-sm">
                                                    <select class="form-control text-center" id="txtSelectDocNoInspStandard" name="doc_no_inspection_standard" style="width: 100%;">
                                                        {{-- <option disabled selected>-- Document No. --</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Doc No.(UD):</label>
                                                {{-- <input type="text" class="form-control form-control-sm" name="document_no" id="txtDocumentNo" readonly> --}}
                                                <div class="input-group input-group-sm">
                                                    <select class="form-control text-center" id="txtSelectDocNoUD" name="doc_no_ud" style="width: 100%;">
                                                        {{-- <option disabled selected>-- Document No. --</option> --}}
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- <div class="form-group">
                                                <label class="form-label">MeasData Attachment:</label>
                                                <input type="text" class="form-control form-control-sm" name="drawing_no" id="txtDrawingNo" readonly>
                                            </div> --}}
                                            {{-- ATTACHMENT --}}
                                            <div class="form-group">
                                                <div id="AttachmentDiv">
                                                    <label class="form-control-label">MeasData Attachment:</label>
                                                </div>
                                                    <input type="file" class="" id="txtAddFile" name="uploaded_file" accept=".xlsx, .xls, .csv" style="width:100%;" required>
                                                    <input type="text" class="form-control d-none" name="re_uploaded_file" id="txtEditUploadedFile" readonly>
                                                <div class="form-group form-check d-none m-0" id="btnReuploadTriggerDiv">
                                                    <input type="checkbox" class="form-check-input d-none" id="btnReuploadTrigger">
                                                    <label class="d-none" id="btnReuploadTriggerLabel"> Re-upload Attachment</label>
                                                </div>
                                            </div>
                                            {{-- ATTACHMENT --}}
                                            <br>
                                            <div class="form-group text-center">
                                                {{-- <label class="form-label">ILQCM Link:</label> --}}
                                                {{-- <a href="{{ route('ilqcm') }}" target="_blank"> --}}
                                                <a href="http://rapidx/ilqcm/dashboard" target="_blank">
                                                {{-- <a href="http://rapidx/cash_advance/" target="_blank"> --}}
                                                    <button type="button" class="btn btn-primary" id="btnilqcmlink">
                                                        <i class="fa-solid fa-pen"></i> Update In-Line QC Monitoring
                                                    </button>
                                                </a>
                                                <i class="fa-solid fa-circle-info fa-lg" data-bs-toggle="tooltip" data-bs-html="true" title="Update In-Line QC Monitoring Thru our ILQCM System in RapidX"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="frmSaveBtn"><i
                                    class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    @endsection

    @section('js_content')
        <script type="text/javascript">
            var prodData;
            $(document).ready(function(){
                // $('.select2').select2();

                // //Initialize Select2 Elements
                // $('.select2bs4').select2({
                //     theme: 'bootstrap4'
                // });

                dtIpqcInspectionPending = $("#tblIpqcInspectionPending").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_stamping_ipqc_data",
                        data: function(param){
                        param.po_number =  $("#txtSearchPONum").val();
                        param.ipqc_status =  [0,1,2,5]; //Status Pending, Updated (A) or (B), For Re-inspection
                        param.fs_prod_status = 0; // Stamping productions Status : For IPQC
                        }
                    },
                    fixedHeader: true,
                    // bAutoWidth: false,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "ipqc_status" },
                        { "data" : "fs_prod_created_at" },
                        { "data" : "po_num" },
                        { "data" : "prod_lot_no" },
                        { "data" : "ipqc_judgement" },
                        { "data" : "qc_samp" },
                        // { "data" : "ipqc_document_no" },
                        { "data" : "ipqc_inspected_date" },
                    ],
                    // "rowCallback" : function(row, data, index){
                        // if(data.stamping_ipqc != null){
                        //     if (data.stamping_ipqc.status == 3 && data.status == 1){
                        //         $("td",row).css("background-color","#80ffbf");
                        //     }else if(data.stamping_ipqc.status == 4 && data.stamping_ipqc.judgement == "Rejected"){
                        //         $("td",row).css("background-color","#ff6666");
                        //         $("td",row).css("color","#ffffff");
                        //     }
                        // }

                    // }
                });

                let dtIpqcInspectionCompleted = $("#tblIpqcInspectionCompleted").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_stamping_ipqc_data",
                        data: function(param){
                        param.po_number =  $("#txtSearchPONum").val();
                        // param.status = [3];
                        param.fs_prod_status = 1; //Stamping productions Status : For Mass Prod
                        param.ipqc_status = [3]; //Status 4 = Submitted: Judgement - Accepted
                        }
                    },
                    bAutoWidth: false,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "ipqc_status" },
                        { "data" : "fs_prod_created_at" },
                        { "data" : "po_num" },
                        { "data" : "prod_lot_no" },
                        { "data" : "ipqc_judgement" },
                        { "data" : "qc_samp" },
                        // { "data" : "ipqc_document_no" },
                        { "data" : "ipqc_inspected_date" },
                    ],
                    // "rowCallback" : function(row, data, index){
                    //     if(data.stamping_ipqc != null){
                    //         if (data.stamping_ipqc.status == 3 && data.status == 1){
                    //             $("td",row).css("background-color","#80ffbf");
                    //         }else if(data.stamping_ipqc.status == 4 && data.stamping_ipqc.judgement == "Rejected"){
                    //             $("td",row).css("background-color","#ff6666");
                    //             $("td",row).css("color","#ffffff");
                    //         }
                    //     }
                    // }
                });

                let dtIpqcInspectionResetup = $("#tblIpqcInspectionResetup").DataTable({
                    // GetDataTableData()
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_stamping_ipqc_data",
                        data: function(param){
                        param.po_number =  $("#txtSearchPONum").val();
                        param.fs_prod_status = 3; //Stamping productions Status : For Resetup
                        param.ipqc_status = [4]; //Status 4 = Submitted: Judgement - Rejected
                        }
                    },
                    bAutoWidth: false,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "ipqc_status" },
                        { "data" : "fs_prod_created_at" },
                        { "data" : "po_num" },
                        { "data" : "prod_lot_no" },
                        { "data" : "ipqc_judgement" },
                        { "data" : "qc_samp" },
                        // { "data" : "ipqc_document_no" },
                        { "data" : "ipqc_inspected_date" },
                    ],
                    // "rowCallback" : function(row, data, index){
                    //     if(data.stamping_ipqc != null){
                    //         if (data.stamping_ipqc.status == 3 && data.status == 1){
                    //             $("td",row).css("background-color","#80ffbf");
                    //         }else if(data.stamping_ipqc.status == 4 && data.stamping_ipqc.judgement == "Rejected"){
                    //             $("td",row).css("background-color","#ff6666");
                    //             $("td",row).css("color","#ffffff");
                    //         }
                    //     }
                    // }
                });

                $('#btnScanPo').on('click', function(e){
                    e.preventDefault();
                    // $('#mdlScanQrCode').modal('show');
                    $('#mdlScanQrCode').on('shown.bs.modal', function () {
                        $('#txtScanQrCode').focus();
                        const mdlScanQrCode = document.querySelector("#mdlScanQrCode");
                        const inptQrCode = document.querySelector("#txtScanQrCode");
                        let focus = false;

                        mdlScanQrCode.addEventListener("mouseover", () => {
                            if (inptQrCode === document.activeElement) {
                                focus = true;
                            } else {
                                focus = false;
                            }
                        });

                        mdlScanQrCode.addEventListener("click", () => {
                            if (focus) {
                                inptQrCode.focus()
                            }
                        });
                    });
                });

                $('#txtSearchPONum').on('keypress', function(e){
                    if(e.keyCode == 13){
                        let search_po_number_val = $('#txtSearchPONum').val();
                        // console.log('log1', $('#txtScanQrCode').val());
                        // let ScanQrCodeVal = jQuery.parseJSON($('#txtScanQrCode').val());
                        // console.log('log2', ScanQrCodeVal);
                        $.ajax({
                            type: "get",
                            url: "get_data_from_fs_production",
                            data: {
                                // "po_number" : ScanQrCodeVal.po
                                "po_number" : search_po_number_val
                            },
                            dataType: "json",
                            beforeSend: function(){
                                // prodData = {};
                            },
                            success: function (response) {
                                let fs_prod_data = response['fs_production_data'];
                                // console.log('log data', fs_prod_data);
                                if(fs_prod_data[0] == undefined){
                                    toastr.error('PO does not exists')
                                }else{
                                        $('#txtSearchPONum').val(fs_prod_data[0]['po_num']);
                                        $('#txtSearchPartCode').val(fs_prod_data[0]['part_code']);
                                        $('#txtSearchMatName').val(fs_prod_data[0]['material_name']);
                                        $('#txtScanQrCode').val('');
                                        $('#mdlScanQrCode').modal('hide');
                                        dtIpqcInspectionPending.draw();
                                        dtIpqcInspectionCompleted.draw();
                                        dtIpqcInspectionResetup.draw();
                                }
                            }
                        });
                    }
                });

                $('#txtOutput').keyup(function(e){
                    // console.log('keyiup');
                    // let input_value = $('#txtInput').val();
                    // let output_value = $('#txtOutput').val();
                    let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                    $('#txtNGQty').val(ng_value);
                });

                // UPDATE STATUS OF DIESET REQUEST
                $(document).on('click', '.btnSubmitIPQCData', function(e){
                    // e.preventDefault();
                    // console.log('sihehe');
                    let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                    let first_stamping_prod_id = $(this).attr('fs_prod_data-id');
                    let stamping_ipqc_status = $(this).attr('ipqc_data-status');
                    $("#txtFsProductionsId").val(first_stamping_prod_id);
                    $("#txtStampingIPQCId").val(stamping_ipqc_id);
                    $("#txtStampingIPQCStatus").val(stamping_ipqc_status);
                    $("#modalConfirmSubmitIPQCInspection").modal('show');
                    console.log('sihehe');
                });

                // btnViewIPQCData
                $(document).on('click', '.btnViewIPQCData',function(e){
                    console.log('view');
                    e.preventDefault();
                    let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                    let first_stamping_prod_id = $(this).attr('fs_prod_data-id');

                    $.ajax({
                        url: "get_data_from_fs_production",
                        type: "get",
                        data: {
                            stamping_ipqc_id: stamping_ipqc_id,
                            fs_prod_id: first_stamping_prod_id
                        },
                        dataType: "json",
                        beforeSend: function(){
                            // $('#formIPQCInspectionData').find('input').val('');
                            // $('#formIPQCInspectionData').find('select').val('');
                            $('#formIPQCInspectionData')[0].reset();
                        },
                        success: function(response){
                            $('#formIPQCInspectionData input[name="_token"]').val('{{ csrf_token() }}');
                            let fs_prod_data = response['fs_production_data'];

                            $('#txtStampingIpqcId').val(stamping_ipqc_id);
                            $('#txtFirstStampingProdId').val(first_stamping_prod_id);
                            $('#txtPoNumber').val(fs_prod_data[0]['po_num']);
                            $('#txtPartCode').val(fs_prod_data[0]['part_code']);
                            $('#txtMaterialName').val(fs_prod_data[0]['material_name']);
                            $('#txtProductionLot').val(fs_prod_data[0]['prod_lot_no']);
                            $('#txtInput').val(fs_prod_data[0]['qc_samp']);

                            let ipqc_data = response['fs_production_data'][0]['stamping_ipqc'];

                            $('#txtOutput').val(ipqc_data['output']);
                            $('#txtJudgement').val(ipqc_data['judgement']);
                            $('#txtInspectorID').val(ipqc_data['ipqc_insp_name']['id']);
                            $('#txtInspectorName').val(ipqc_data['ipqc_insp_name']['firstname'] +' '+ ipqc_data['ipqc_insp_name']['lastname']);

                            if(ipqc_data['keep_sample'] == 1){
                                $('#txtKeepSample1').prop('checked', true);
                            }else if(ipqc_data['keep_sample'] == 2){
                                $('#txtKeepSample2').prop('checked', true);
                            }else{
                                $('input[name="keep_sample"]').prop('checked', false);
                            }

                            let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                            $('#txtNGQty').val(ng_value);
                            GetBDrawingFromACDCS('CN171', 'B Drawing', $("#txtSelectDocNoBDrawing"), ipqc_data['doc_no_b_drawing']);
                            GetInspStandardFromACDCS('CN171', 'Inspection Standard', $("#txtSelectDocNoInspStandard"), ipqc_data['doc_no_insp_standard']);
                            GetUDFromACDCS('CN171', 'Urgent Direction', $("#txtSelectDocNoUD"), ipqc_data['doc_no_urgent_direction']);

                            // $("#btnReuploadTriggerDiv").removeClass('d-none');
                            // $("#btnReuploadTrigger").removeClass('d-none');
                            // $("#btnReuploadTrigger").prop('checked', false);
                            // $("#btnReuploadTriggerLabel").removeClass('d-none');
                            // }

                            //disabled and readonly
                            $("#frmSaveBtn").prop('hidden', true);
                            $("#txtOutput").prop('disabled', true);
                            $("#txtJudgement").prop('disabled', true);
                            $("#txtSelectDocNoBDrawing").prop('disabled', true);
                            $("#txtSelectDocNoInspStandard").prop('disabled', true);
                            $("#txtSelectDocNoUD").prop('disabled', true);
                            $("#btnilqcmlink").prop('disabled', true);
                            $('input[name="keep_sample"]').attr('disabled', true);

                            $("#txtEditUploadedFile").removeClass('d-none');
                            $("#txtAddFile").addClass('d-none');
                            $("#txtAddFile").removeAttr('required');
                            $('#txtEditUploadedFile').val(ipqc_data['measdata_attachment']);

                            let download ='<a href="download_file/'+ipqc_data['id']+'">';
                                download +='<button type="button" id="download_file" name="download_file" class="btn btn-primary btn-sm d-none">';
                                download +=     '<i class="fa-solid fa-file-arrow-down"></i>';
                                download +=         '&nbsp;';
                                download +=         'See Attachment';
                                download +='</button>';
                                download +='</a>';

                            $('#AttachmentDiv').append(download);
                            $("#download_file").removeClass('d-none');
                            $('#modalIpqcInspection').modal('show');
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }

                    });
                });

                $(document).on('click', '.btnUpdateIPQCData',function(e){
                    console.log('view');
                    e.preventDefault();
                    let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                    let first_stamping_prod_id = $(this).attr('fs_prod_data-id');

                    $.ajax({
                        url: "get_data_from_fs_production",
                        type: "get",
                        data: {
                            stamping_ipqc_id: stamping_ipqc_id,
                            fs_prod_id: first_stamping_prod_id
                        },
                        dataType: "json",
                        beforeSend: function(){
                            // $('#formIPQCInspectionData').find('input').val('');
                            // $('#formIPQCInspectionData').find('select').val('');
                            $('#formIPQCInspectionData')[0].reset();
                        },
                        success: function(response){
                            // let _token = "{{ csrf_token() }}";
                            $('#formIPQCInspectionData input[name="_token"]').val('{{ csrf_token() }}');
                            // console.log('token value', $('#formIPQCInspectionData input[name="_token"]').val('{{ csrf_token() }}'));
                            let fs_prod_data = response['fs_production_data'];

                            $('#txtStampingIpqcId').val(stamping_ipqc_id);
                            $('#txtFirstStampingProdId').val(first_stamping_prod_id);
                            $('#txtPoNumber').val(fs_prod_data[0]['po_num']);
                            $('#txtPartCode').val(fs_prod_data[0]['part_code']);
                            $('#txtMaterialName').val(fs_prod_data[0]['material_name']);
                            $('#txtProductionLot').val(fs_prod_data[0]['prod_lot_no']);
                            $('#txtInput').val(fs_prod_data[0]['qc_samp']);

                            //disabled and readonly
                            $("#frmSaveBtn").prop('hidden', false);
                            $("#txtOutput").prop('disabled', false);
                            $("#txtJudgement").prop('disabled', false);
                            $("#txtSelectDocNoBDrawing").prop('disabled', false);
                            $("#txtSelectDocNoInspStandard").prop('disabled', false);
                            $("#txtSelectDocNoUD").prop('disabled', false);
                            $("#btnilqcmlink").prop('disabled', false);
                            $('input[name="keep_sample"]').attr('disabled', false);

                            if(fs_prod_data[0]['stamping_ipqc_data'] == 0){ //when fs_prod_id && stamping_ipqc_id is not existing in StampingIpqc Table //For Insert to StampingIpqc Table


                                GetBDrawingFromACDCS('CN171', 'B Drawing', $("#txtSelectDocNoBDrawing"), '');
                                GetInspStandardFromACDCS('CN171', 'Inspection Standard', $("#txtSelectDocNoInspStandard"), '');
                                GetUDFromACDCS('CN171', 'Urgent Direction', $("#txtSelectDocNoUD"), '');

                                $('#txtInspectorID').val(fs_prod_data[0]['ipqc_inspector_id']);
                                // $('#txtInspectorName').val(fs_prod_data[0]['ipqc_inspector_name'] +' '+'(Auto Generate)');
                                $('#txtInspectorName').val(fs_prod_data[0]['ipqc_inspector_name']);
                                $("#btnReuploadTriggerDiv").addClass("d-none");
                                $("#btnPartsDrawingAddRow").addClass("d-none");

                                $("#txtAddFile").removeClass('d-none');
                                $("#txtAddFile").attr('required', true);
                                $("#txtEditUploadedFile").addClass('d-none');
                                $("#download_file").addClass('d-none');
                            }else{//For Update to StampingIpqc Table
                                let ipqc_data = response['fs_production_data'][0]['stamping_ipqc'];

                                // console.log('agaaagagaa', fs_prod_data);
                                $('#txtOutput').val(ipqc_data['output']);
                                $('#txtJudgement').val(ipqc_data['judgement']);
                                $('#txtInspectorID').val(ipqc_data['ipqc_insp_name']['id']);
                                // $('#txtKeepSample').val(ipqc_data['ipqc_insp_name']['id']);

                                if(ipqc_data['keep_sample'] == 1){
                                    $('#txtKeepSample1').prop('checked', true);
                                }else if(ipqc_data['keep_sample'] == 2){
                                    $('#txtKeepSample2').prop('checked', true);
                                }else{
                                    $('input[name="keep_sample"]').prop('checked', false);
                                }

                                $('#txtInspectorName').val(ipqc_data['ipqc_insp_name']['firstname'] +' '+ ipqc_data['ipqc_insp_name']['lastname']);

                                let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                                $('#txtNGQty').val(ng_value);
                                // GetDocumentNoFromACDCS('CN171', 'Urgent Direction', $("#txtSelectDocumentNo"), ipqc_data['document_no']);
                                GetBDrawingFromACDCS('CN171', 'B Drawing', $("#txtSelectDocNoBDrawing"), ipqc_data['doc_no_b_drawing']);
                                GetInspStandardFromACDCS('CN171', 'Inspection Standard', $("#txtSelectDocNoInspStandard"), ipqc_data['doc_no_insp_standard']);
                                GetUDFromACDCS('CN171', 'Urgent Direction', $("#txtSelectDocNoUD"), ipqc_data['doc_no_urgent_direction']);

                                $('input[name="keep_sample"]').attr('disabled', false);
                                $("#btnReuploadTriggerDiv").removeClass('d-none');
                                $("#btnReuploadTrigger").removeClass('d-none');
                                $("#btnReuploadTrigger").prop('checked', false);
                                $("#btnReuploadTriggerLabel").removeClass('d-none');
                                // }
                                $("#txtEditUploadedFile").removeClass('d-none');
                                $("#txtAddFile").addClass('d-none');
                                $("#txtAddFile").removeAttr('required');
                                $("#txtSelectDocumentNo").removeAttr('required');
                                $("#txtEditUploadedFile").removeAttr('required');
                                $('#txtEditUploadedFile').val(ipqc_data['measdata_attachment']);

                                let download ='<a href="download_file/'+ipqc_data['id']+'">';
                                    download +='<button type="button" id="download_file" name="download_file" class="btn btn-primary btn-sm d-none">';
                                    download +=     '<i class="fa-solid fa-file-arrow-down"></i>';
                                    download +=         '&nbsp;';
                                    download +=         'See Attachment';
                                    download +='</button>';
                                    download +='</a>';

                                $('#AttachmentDiv').append(download);
                                $("#download_file").removeClass('d-none');
                            }
                            $('#modalIpqcInspection').modal('show');
                            $('#txtScanQrCode').val('');
                            $('#mdlScanQrCode').modal('hide');
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });

                function GetBDrawingFromACDCS(model, doc_type, cboElement, IpqcDocumentNo){
                    GetDocumentNoFromACDCS(model, doc_type, cboElement, IpqcDocumentNo);
                };

                function GetInspStandardFromACDCS(model, doc_type, cboElement, IpqcDocumentNo){
                    GetDocumentNoFromACDCS(model, doc_type, cboElement, IpqcDocumentNo);
                };

                function GetUDFromACDCS(model, doc_type, cboElement, IpqcDocumentNo){
                    GetDocumentNoFromACDCS(model, doc_type, cboElement, IpqcDocumentNo);
                };

                function GetDocumentNoFromACDCS(model, doc_type, cboElement, IpqcDocumentNo){

                        let result = '<option value="" disabled selected>--Select Document No.--</option>';
                    // }
                        $.ajax({
                            url: 'get_data_from_acdcs',
                            method: 'get',
                            data: {
                                'model': model,
                                'doc_type': doc_type
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                    result = '<option value="0" disabled selected>--Loading--</option>';
                                    cboElement.html(result);
                            },
                            success: function(response) {
                                // console.log('test response', response['acdcs_data']);
                                if (response['acdcs_data'].length > 0) {

                                    if(IpqcDocumentNo != ''){ //when Editting: Document No
                                        // result = '<option value="" disabled selected>--Select Document No.--</option>';
                                        result = '<option selected readonly value="' + IpqcDocumentNo + '">' + IpqcDocumentNo + '</option>';
                                        // cboElement.html(result);
                                    }else{ //when Inserting: Document No
                                        result = '<option value="" disabled selected>--Select Document No.--</option>';
                                    }
                                    // if(response['acdcs_data']['users'][0].model == 1){


                                    // }
                                    result += '<option value="N/A"> N/A </option>';
                                    // result = '<option value="" selected>-- N/A --</option>';
                                    for (let index = 0; index < response['acdcs_data'].length; index++) {
                                        result += '<option value="' + response['acdcs_data'][index].doc_no + '">' + response['acdcs_data'][index].doc_no + '</option>';
                                        // console.log('test doc_no', response['acdcs_data'][index].doc_no);
                                    }
                                } else {
                                    result = '<option value="0" selected disabled> -- No record found -- </option>';
                                }
                                cboElement.html(result);
                                cboElement.select2();
                                // $("#txtSelectDocumentNo").select2();
                            },
                            error: function(data, xhr, status) {
                                result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                                cboElement.html(result);
                                console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                            }
                        });
                    // }else{
                        // result = '<option value="" disabled selected>--Select Document No.--</option>';
                        // result += '<option value="' + ipqc_data['document_no'] + '">' + ipqc_data['document_no'] + '</option>';
                        // cboElement.html(result);
                    // }
                }

                // ================================= RE-UPLOAD FILE =================================
                $('#btnReuploadTrigger').on('click', function() {
                    $('#btnReuploadTrigger').attr('checked', 'checked');
                    if($(this).is(":checked")){
                        $("#txtAddFile").removeClass('d-none');
                        $("#txtAddFile").attr('required', true);
                        $("#txtEditUploadedFile").addClass('d-none');
                        $("#download_file").addClass('d-none');
                    }
                    else{
                        $("#txtAddFile").addClass('d-none');
                        $("#txtAddFile").removeAttr('required');
                        $("#txtAddFile").val('');
                        $("#txtEditUploadedFile").removeClass('d-none');
                        $("#download_file").removeClass('d-none');
                    }
                });

                $("#FrmConfirmSubmitIPQCInspection").submit(function(event) {
                    event.preventDefault();
                    $.ajax({
                        url: "update_status_of_ipqc_inspection",
                        method: "post",
                        data: $('#FrmConfirmSubmitIPQCInspection').serialize(),
                        dataType: "json",
                        success: function (response) {
                            let result = response['result'];
                            if (result == 'Successful') {
                                dtIpqcInspectionPending.draw();
                                dtIpqcInspectionCompleted.draw();
                                dtIpqcInspectionResetup.draw();
                                toastr.success('Successful!');
                                $("#modalConfirmSubmitIPQCInspection").modal('hide');
                            }else{
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                        }
                    });
                });

                $('#formIPQCInspectionData').submit(function(e){
                    e.preventDefault();
                    $('#modalScanQRSave').modal('show');
                    // console.log('serialized', $('#formIPQCInspectionData').serialize());
                    // AddIpqcInspection();
                });

                $('#txtScanUserId').on('keyup', function(e){
                    if(e.keyCode == 13){
                        // console.log($(this).val());
                        validateUser($(this).val(), [0, 2, 5], function(result){
                            if(result == true){
                                // submitProdData($(this).val());
                                // console.log('', $('#txtKeepSample1').val());
                                AddIpqcInspection();
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                        $(this).val('');
                    }
                });

                function AddIpqcInspection(){
                    let formData = new FormData($('#formIPQCInspectionData')[0]);
                    console.log('formdata', formData);
                    $.ajax({
                        url: "add_ipqc_inspection",
                        method: "post",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        beforeSend: function(){
                        },
                        success: function (response) {
                            let result = response['result'];
                            if (result == 'Insert Successful' || result == 'Update Successful') {
                                // dataTableDmrpqc.draw();
                                toastr.success('Successful!');
                                $('#modalIpqcInspection').modal('hide');
                                $('#modalScanQRSave').modal('hide');
                                dtIpqcInspectionPending.draw();
                                dtIpqcInspectionCompleted.draw();
                                dtIpqcInspectionResetup.draw();
                                // $("#modalConfirmSubmitIPQCInspection").modal('hide');
                            }
                            else if(result == 'Duplicate'){
                                toastr.error('Request Already Submitted!');
                            }
                            else if(result == 'Session Expired') {
                                toastr.error('Session Expired!, Please Log-in again');
                            }else if(result == 'Error'){
                                toastr.error('Error!, Please Contanct ISS Local 208');
                            }
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                };

                $('#btnExportPackingList').click( function(e){
                    $('#modalExportPackingList').modal('show');
                    GetPackingListControlNo($(".selectControlNumber"));
                });

                function GetPackingListControlNo(cboElement){
                    let result = '<option value="" disabled selected>--Select Control No.--</option>';
                        $.ajax({
                            url: 'get_packing_list_data',
                            method: 'get',
                            dataType: 'json',
                            beforeSend: function() {
                                    result = '<option value="0" disabled selected>--Loading--</option>';
                                    cboElement.html(result);
                            },
                            success: function(response) {
                                if (response['packing_list_data'].length > 0) {

                                    // if(IpqcDocumentNo != ''){ //when Editting: Document No
                                    //     result = '<option selected readonly value="' + IpqcDocumentNo + '">' + IpqcDocumentNo + '</option>';
                                    // }else{ //when Inserting: Document No
                                        result = '<option value="" disabled selected>--Select Control No.--</option>';
                                    // }
                                    // result += '<option value="N/A"> N/A </option>';
                                    for (let index = 0; index < response['packing_list_data'].length; index++) {
                                        result += '<option value="' + response['packing_list_data'][index].control_no + '">' + response['packing_list_data'][index].control_no + '</option>';
                                    }
                                } else {
                                    result = '<option value="0" selected disabled> -- No record found -- </option>';
                                }
                                cboElement.html(result);
                                cboElement.select2();
                            },
                            error: function(data, xhr, status) {
                                result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                                cboElement.html(result);
                                console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                            }
                        });
                    }

                $('#formGeneratePackingList').submit(function (e){
                    e.preventDefault();
                    // let CtrlNo = 'ctrl-test-123';
                    let CtrlNo = $('#txtCtrlNo').val();
                    // console.log(test);
                    // window.location.href = "export/"+CtrlNo;
                    window.location.href = "view_pdf/"+CtrlNo;
                    $('#modalExportPackingList').modal('hide');
                });
            });
        </script>
    @endsection
@endauth

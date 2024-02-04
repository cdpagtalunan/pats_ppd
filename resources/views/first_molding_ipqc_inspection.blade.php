@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)

    @section('title', 'First Molding IPQC Inspection')

    @section('content_page')

        <style type="text/css">
            .scanQrBarCode{
                position: absolute;
                opacity: 0;
            }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>In-Process Quality Control (First Molding)</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item">First Molding</li>
                                <li class="breadcrumb-item active">In-Process Quality Control</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row"> <!-- row -->
                        <div class="col-12"> <!-- col -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">In-Process Quality Control</h3>
                                </div>
                                <div class="card-body"> <!-- card body -->
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label class="form-label">Category:</label>
                                            <div class="input-group">
                                                <select class="form-control" id="selectCategory" name="category">
                                                    <option selected>N/A</option>
                                                    <option value="0">Pending</option>
                                                    <option value="1">Completed</option>    
                                                    <option value="2">Reset-up</option>    
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <label class="form-label">PMI PO:</label>
                                            <div class="input-group mb-3">
                                                <select class="form-control select2bs5 dataFromMoldingPmiPo" id="selectMoldingPmiPoNo"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Device Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="txtMoldingDeviceName" readonly>
                                            </div>
                                        </div>    
                                        <div class="col-sm-2">
                                            <label class="form-label">Contact Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="txtMoldingContactName" readonly>
                                            </div>
                                        </div>    
                                        <div class="col-sm-2">
                                            <label class="form-label mb-4"></label>
                                            <div class="input-group">
                                                <button type="submit" id="btnFirstMoldingSearchIpqcInspection" class="btn btn-dark">
                                                    <i id="iBtnFirstMoldingSearchIpqcInspectionIcon" class="fa fa-search"></i> Search
                                                </button>            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="tblPendingFirstMoldingIpqcInspection" class="table table-sm table-bordered table-striped table-hover text-center"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>PO No.</th>
                                                    <th>Device Name</th>
                                                    <th>Contact Number</th>
                                                    <th>QC Sample</th>
                                                    <th>Judgement</th>
                                                    <th>Inspected At</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div> <!-- card body -->
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!-- /.row -->                    
                </div> <!-- /.container-fluid -->
                
                <!-- MODALS -->
                <div class="modal fade" id="modalMoldingIpqcInspection" data-bs-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-plus"></i>IPQC Inspection Molding</h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" id="formMoldingIpqcInspection" autocomplete="off">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" id="txtMoldingIpqcInspectionId" name="molding_ipqc_inspection_id">
                                    <input type="hidden" id="txtMoldingId" name="molding_id">
                                    <input type="hidden" class="form-control form-control-sm" id="txtEmployeeNo" name="employee_no">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label class="form-label">PMI PO Number:</label>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_po_number" id="txtMoldingIpqcInspectionPoNumber" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Part Code:</label>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_part_code" id="txtMoldingIpqcInspectionPartCode" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Device Name:</label>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_device_name" id="txtMoldingIpqcInspectionDeviceName" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Production Lot #:</label>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_production_lot" id="txtMoldingIpqcInspectionProductionLot" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">QC Sample:</label>
                                                        <i class="fa-solid fa-circle-info fa-lg mt-2 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="QC Sample Qty"></i>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_input" id="txtMoldingIpqcInspectionInput" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">OK:</label>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_output" id="txtMoldingIpqcInspectionOutput"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">NG:</label>
                                                        <i class="fa-solid fa-circle-info fa-lg mt-3 mr-2" data-bs-toggle="tooltip" data-bs-html="true" title="Input - Output = NG Qty"></i>
                                                        <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_ng_qty" id="txtMoldingIpqcInspectionNGQty" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card">
                                                <div class="card-body"><div class="form-group">
                                                    <div class="form-group">
                                                        <label class="form-label">Judgement:</label>
                                                        <select class="form-control form-control-sm" type="text" name="molding_ipqc_inspection_judgement" id="txtMoldingIpqcInspectionJudgement" required>
                                                            <option value="" disabled selected>Select Judgement</option>
                                                            <option value="Accepted" style="color:#008000">Accepted</option>
                                                            <option value="Rejected" style="color:#ff0000">Rejected</option>
                                                        </select>
                                                        <div class="form-group">
                                                            <label class="form-label">Inspector Name:</label>
                                                            <input type="hidden" class="form-control form-control-sm" name="molding_ipqc_inspection_inspector_id" id="txtMoldingIpqcInspectionInspectorID" readonly value="@php echo Auth::user()->id; @endphp" readonly>
                                                            <input type="text" class="form-control form-control-sm" name="molding_ipqc_inspection_inspector_name" id="txtMoldingIpqcInspectionInspectorName" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-label">Doc No.(B Drawing):</label>
                                                            <div class="input-group input-group-sm" style="width: 100%;">
                                                                <div id="BDrawingDiv" class="input-group-prepend">
                                                                </div>
                                                                <select class="form-control form-control-sm" id="txtMoldingIpqcInspectionSelectDocNoBDrawing" name="molding_ipqc_inspection_doc_no_b_drawing">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-label">Doc No.(Inspection Standard):</label>
                                                            <div class="input-group input-group-sm" style="width: 100%;">
                                                                <div id="InspStandardDiv" class="input-group-prepend">
                                                                </div>
                                                                <select class="form-control form-control-sm" id="txtMoldingIpqcInspectionSelectDocNoInspStandard" name="molding_ipqc_inspection_doc_no_inspection_standard">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                                <label class="form-label">Doc No.(UD):</label>
                                                            <div class="input-group input-group-sm" style="width: 100%;">
                                                                <div id="UDDiv" class="input-group-prepend">
                                                                </div>
                                                                <select class="form-control form-control-sm" id="txtMoldingIpqcInspectionSelectDocNoUD" name="molding_ipqc_inspection_doc_no_ud">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div id="AttachmentDiv">
                                                                <label class="form-control-label">MeasData Attachment:</label>
                                                            </div>
                                                                <input type="file" class="form-control form-control-sm" id="txtMoldingIpqcInspectionAddFile" name="molding_ipqc_inspection_uploaded_file" accept=".xlsx, .xls, .csv" style="width:100%;" required>
                                                                <input type="text" class="form-control form-control-sm d-none" name="molding_ipqc_inspection_re_uploaded_file" id="txtMoldingIpqcInspectionEditUploadedFile" readonly>
                                                            <div class="form-group form-check d-none m-0" id="btnReuploadTriggerDiv">
                                                                <input type="checkbox" class="form-check-input d-none" id="btnReuploadTrigger">
                                                                <label class="d-none" id="btnReuploadTriggerLabel"> Re-upload Attachment</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center mt-1">
                                                        <a href="http://rapidx/ilqcm/dashboard" target="_blank">
                                                            <button type="button" class="btn btn-dark" id="btnilqcmlink">
                                                                <i class="fa-solid fa-pen"></i> Update In-Line QC Monitoring
                                                            </button>
                                                        </a>
                                                        <i class="fa-solid fa-circle-info fa-lg" data-bs-toggle="tooltip" data-bs-html="true" title="Update In-Line QC Monitoring Thru our ILQCM System in RapidX"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ml-3">
                                                <label class="form-check-label"> Keep Sample:</label>
                                                <div class="form-check form-check-inline ml-1">
                                                    <input class="form-check-input" type="radio" value="1" name="keep_sample" id="txtMoldingIpqcInspectionKeepSample1">
                                                    <label class="form-check-label" for="txtKeepSample1"> Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="2" name="keep_sample" id="txtMoldingIpqcInspectionKeepSample2">
                                                    <label class="form-check-label" for="txtKeepSample2"> No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="btnOqcInspection" class="btn btn-dark">
                                        <i id="iBtnOqcInspectionIcon" class="fa fa-save"></i> Save
                                    </button>
                                    </div>
                            </form>
                        </div> <!-- /.modal-content -->
                    </div> <!-- /.modal-dialog -->
                </div> <!-- /.modal -->
            </section ><!-- /.content -->
        </div> <!-- /.content-wrapper -->

        <!-- Start Scan Modal -->
        <div class="modal fade" id="mdlScanEmployeeId" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body mt-3">
                            <input type="text" class="scanQrBarCode1 w-100" id="txtScanUserId" name="scan_user_id" autocomplete="off">
                        <div class="text-center text-secondary"><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div><!-- /.End Scan Modal -->        

        <!-- CONFIRM SUBMIT MODAL START -->
        {{-- <div class="modal fade" id="modalConfirmSubmitIPQCInspection">
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
        <!-- CONFIRM SUBMIT MODAL END --> --}}
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let getPmiPo;
            let selectCategory;
            let dt1stStampingIpqcInspectionPending;
            $(document).ready(function(){
                $( '.select2bs5' ).select2( {
                    theme: 'bootstrap-5'
                } );

                DataFromMoldingPmiPo($(".dataFromMoldingPmiPo"))
                
                $('#selectMoldingPmiPoNo').change(function (e) { 
                    e.preventDefault();
                    let getPmiPo =  $('#selectMoldingPmiPoNo').val()
                    $.ajax({
                        url: "get_molding_pmi_po",
                        method: "get",
                        data :  {
                            getPmiPo
                        },
                        dataType: "json",
                        success: function(response){
                                $('#txtMoldingDeviceName').val(response['getDataFromPmiPo'].first_molding_device.device_name)
                                $('#txtMoldingContactName').val(response['getDataFromPmiPo'].first_molding_device.contact_name)
                            }
                        })
                });

                $('#btnFirstMoldingSearchIpqcInspection').on('click', function (e) { 
                    e.preventDefault();
                    getPmiPo = $('#selectMoldingPmiPoNo').val()
                    selectCategory = $('#selectCategory').val()
                    console.log('getPmiPo :', getPmiPo)
                    console.log('selectCategory :', selectCategory)
                    dt1stStampingIpqcInspectionPending.draw()
                    
                });

                let dt1stStampingIpqcInspectionPending = $("#tblPendingFirstMoldingIpqcInspection").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_first_molding_ipqc_Inspection",
                        data: function(param){
                        param.getPmiPo          =  getPmiPo
                        param.selectCategory    =  selectCategory
                        }
                    },
                    fixedHeader: true,
                    // "order":[[7, 'asc']],
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "po_no" },
                        { "data" : "device_name" },
                        { "data" : "contact_lot_number" },
                        { "data" : "qc_samples" },
                        { "data" : "judgement" },
                        { "data" : "inspected_at" },
                    ],
                });
                $(document).on('click', '.actionFirstMoldingIpqcInspection', function(e){
                    e.preventDefault()
                    
                    getMoldingIpqcInspectionId      = $(this).attr('first_molding_ipqc-id')
                    getMoldingId                    = $(this).attr('first_molding-id')
                    
                    $('#txtMoldingId').val(getMoldingId)
                    $('#txtMoldingIpqcInspectionId').val(getMoldingIpqcInspectionId)
                    
                    GetMoldingIpqcInspection(getMoldingId, getMoldingIpqcInspectionId)
                });

                $('#formMoldingIpqcInspection').submit(function (e) { 
                    e.preventDefault()
                    console.log('Save IPQC Inspection')
                    $('#mdlScanEmployeeId').modal('show')
                    $('#mdlScanEmployeeId').on('shown.bs.modal', function () {
                        $('#txtScanUserId').focus()
                        const mdlScanUserId = document.querySelector("#mdlScanEmployeeId");
                        const inptScanUserId = document.querySelector("#txtScanUserId");
                        let focus = false

                        mdlScanUserId.addEventListener("mouseover", () => {
                            if (inptScanUserId === document.activeElement) {
                                focus = true
                            } else {
                                focus = false
                            }
                        });

                        mdlScanUserId.addEventListener("click", () => {
                            if (focus) {
                                inptScanUserId.focus()
                            }
                        });
                    });
                })

                $('#txtScanUserId').on('keypress',function(e){
                    if( e.keyCode == 13 ){
                        $.ajax({
                            url: "scan_user_id",
                            type: "get",
                            data: {
                                user_id : $('#txtScanUserId').val().toUpperCase(),
                            },
                            dataType: "json",
                            success: function (response) {
                                let userDetails = response['userDetails']
                                if(userDetails != null){
                                    $('#txtEmployeeNo').val(userDetails.employee_id)
                                    UpdateMoldingIpqcInspection()
                                }else{
                                    toastr.error('ID Number Not Registered!')
                                }
                            }
                        })
                        $('#txtScanUserId').val('')
                        $('#mdlScanQrCode').modal('hide')
                    }
                })
                // $('#txtSelectDocNoBDrawing').on('change', function() {
                //     if($('#txtSelectDocNoBDrawing').val() === null || $('#txtSelectDocNoBDrawing').val() === undefined){
                //         console.log('b drawing', 'disabled');
                //         $("#btnViewBDrawings").prop('disabled', true);
                //     }else{
                //         console.log('b drawing', 'enabled');
                //         $("#btnViewBDrawings").prop('disabled', false);
                //     }
                // });

                // $('#txtSelectDocNoInspStandard').on('change', function() {
                //     if($('#txtSelectDocNoInspStandard').val() === null || $('#txtSelectDocNoInspStandard').val() === undefined){
                //         console.log('b drawing', 'disabled');
                //         $("#btnViewInspStdDrawings").prop('disabled', true);
                //     }else{
                //         console.log('b drawing', 'enabled');
                //         $("#btnViewInspStdDrawings").prop('disabled', false);
                //     }
                // });

                // $('#txtSelectDocNoUD').on('change', function() {
                //     if($('#txtSelectDocNoUD').val() === null || $('#txtSelectDocNoUD').val() === undefined){
                //         console.log('b drawing', 'disabled');
                //         $("#btnViewUdDrawings").prop('disabled', true);
                //     }else{
                //         console.log('b drawing', 'enabled');
                //         $("#btnViewUdDrawings").prop('disabled', false);
                //     }
                // });

                // ViewDocument($('#txtSelectDocNoBDrawing').val(), $('#BDrawingDiv'), 'btnViewBDrawings');
                // ViewDocument($('#txtSelectDocNoInspStandard').val(), $('#InspStandardDiv'), 'btnViewInspStdDrawings');
                // ViewDocument($('#txtSelectDocNoUD').val(), $('#UDDiv'), 'btnViewUdDrawings');

                // $('#btnViewBDrawings').on('click', function(){
                //     redirect_to_drawing($('#txtSelectDocNoBDrawing').val());
                // });
                // $('#btnViewInspStdDrawings').on('click', function(){
                //     redirect_to_drawing($('#txtSelectDocNoInspStandard').val());
                // });
                // $('#btnViewUdDrawings').on('click', function(){
                //     redirect_to_drawing($('#txtSelectDocNoUD').val());
                // });

                // function ViewDocument(document_no, div_id, btn_id){
                //     let doc_no ='<button type="button" id="'+btn_id+'" class="btn btn-primary">';
                //         doc_no +=     '<i class="fa fa-file" data-bs-toggle="tooltip" data-bs-html="true" title="See Document in ACDCS"></i>';
                //         doc_no +='</button>';
                //     div_id.append(doc_no);
                // }

                // function redirect_to_drawing(drawing) {
                //     console.log('Drawing No.:',drawing)
                //     if( drawing  == 'N/A'){
                //         alert('Document No is Not Existing')
                //     }
                //     else{
                //         window.open("http://rapid/ACDCS/prdn_home_pats_ppd?doc_no="+drawing)
                //     }
                // }

                // $('#btnScanPo').on('click', function(e){
                //     e.preventDefault();
                //     $('#mdlScanQrCode').on('shown.bs.modal', function () {
                //         $('#txtScanQrCode').focus();
                //         const mdlScanQrCode = document.querySelector("#mdlScanQrCode");
                //         const inptQrCode = document.querySelector("#txtScanQrCode");
                //         let focus = false;

                //         mdlScanQrCode.addEventListener("mouseover", () => {
                //             if (inptQrCode === document.activeElement) {
                //                 focus = true;
                //             } else {
                //                 focus = false;
                //             }
                //         });

                //         mdlScanQrCode.addEventListener("click", () => {
                //             if (focus) {
                //                 inptQrCode.focus()
                //             }
                //         });
                //     });
                // });

                // $('#txtSelectPONo').on('change', function(e){
                //     let search_po_number_val = $('#txtSelectPONo').val();
                //     $.ajax({
                //         type: "get",
                //         url: "get_data_from_fs_production",
                //         data: {
                //             "po_number" : search_po_number_val
                //         },
                //         dataType: "json",
                //         beforeSend: function(){
                //         },
                //         success: function (response) {
                //             let fs_prod_data = response['fs_production_data'];
                //             if(fs_prod_data[0] == undefined){
                //                 toastr.error('PO does not exists')
                //             }else{
                //                     $('#txtSelectPONo').val(fs_prod_data[0]['po_num']);
                //                     $('#txtSearchPartCode').val(fs_prod_data[0]['part_code']);
                //                     $('#txtSearchMatName').val(fs_prod_data[0]['material_name']);
                //                     $('#txtScanQrCode').val('');
                //                     $('#mdlScanQrCode').modal('hide');

                //                     let mat_name = fs_prod_data[0]['material_name'];
                //                     mat_name = mat_name.replace(/ /g,'');

                //                     GetBDrawingFromACDCS(mat_name, 'B Drawing', $("#txtSelectDocNoBDrawing"));
                //                     GetInspStandardFromACDCS(mat_name, 'Inspection Standard', $("#txtSelectDocNoInspStandard"));
                //                     GetUDFromACDCS(mat_name, 'Urgent Direction', $("#txtSelectDocNoUD"));

                //                     dt1stStampingIpqcInspectionPending.draw();
                //                     dt1stStampingIpqcInspectionCompleted.draw();
                //                     dt1stStampingIpqcInspectionResetup.draw();
                //             }
                //         }
                //     });
                // });

                // $('#txtOutput').keyup(function(e){
                //     let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                //     $('#txtNGQty').val(ng_value);
                // });

                // // UPDATE STATUS OF DIESET REQUEST
                // $(document).on('click', '.btnSubmitIPQCData', function(e){
                //     e.preventDefault();
                //     let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                //     let first_stamping_prod_id = $(this).attr('fs_prod_data-id');
                //     let stamping_ipqc_status = $(this).attr('ipqc_data-status');
                //     $("#txtFsProductionsId").val(first_stamping_prod_id);
                //     $("#txtStampingIPQCId").val(stamping_ipqc_id);
                //     $("#txtStampingIPQCStatus").val(stamping_ipqc_status);
                //     $("#modalConfirmSubmitIPQCInspection").modal('show');
                //     console.log('sihehe');
                // });

                // // btnViewIPQCData
                // $(document).on('click', '.btnViewIPQCData',function(e){
                //     console.log('view');
                //     e.preventDefault();
                //     let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                //     let first_stamping_prod_id = $(this).attr('fs_prod_data-id');

                //     $.ajax({
                //         url: "get_data_from_fs_production",
                //         type: "get",
                //         data: {
                //             stamping_ipqc_id: stamping_ipqc_id,
                //             fs_prod_id: first_stamping_prod_id
                //         },
                //         dataType: "json",
                //         beforeSend: function(){
                //             $('#formIPQCInspectionData')[0].reset();
                //         },
                //         success: function(response){
                //             $('#formIPQCInspectionData input[name="_token"]').val('{{ csrf_token() }}');
                //             let fs_prod_data = response['fs_production_data'];

                //             $('#txtStampingIpqcId').val(stamping_ipqc_id);
                //             $('#txtFirstStampingProdId').val(first_stamping_prod_id);
                //             $('#txtPoNumber').val(fs_prod_data[0]['po_num']);
                //             $('#txtPartCode').val(fs_prod_data[0]['part_code']);
                //             $('#txtMaterialName').val(fs_prod_data[0]['material_name']);
                //             $('#txtProductionLot').val(fs_prod_data[0]['prod_lot_no']);
                //             $('#txtInput').val(fs_prod_data[0]['qc_samp']);

                //             let ipqc_data = response['fs_production_data'][0]['stamping_ipqc'];

                //             $('#txtOutput').val(ipqc_data['output']);
                //             $('#txtJudgement').val(ipqc_data['judgement']);
                //             $('#txtInspectorID').val(ipqc_data['ipqc_insp_name']['id']);
                //             $('#txtInspectorName').val(ipqc_data['ipqc_insp_name']['firstname'] +' '+ ipqc_data['ipqc_insp_name']['lastname']);

                //             if(ipqc_data['keep_sample'] == 1){
                //                 $('#txtKeepSample1').prop('checked', true);
                //             }else if(ipqc_data['keep_sample'] == 2){
                //                 $('#txtKeepSample2').prop('checked', true);
                //             }else{
                //                 $('input[name="keep_sample"]').prop('checked', false);
                //             }

                //             let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                //             $('#txtNGQty').val(ng_value);

                //             let mat_name = fs_prod_data[0]['material_name'];
                //                 mat_name = mat_name.replace(/ /g,'');

                //             $("#txtSelectDocNoBDrawing").val(ipqc_data['doc_no_b_drawing']);
                //             $("#txtSelectDocNoInspStandard").val(ipqc_data['doc_no_insp_standard']);
                //             $("#txtSelectDocNoUD").val(ipqc_data['doc_no_urgent_direction']);

                //             //disabled and readonly
                //             $("#frmSaveBtn").prop('hidden', true);
                //             $("#txtOutput").prop('disabled', true);
                //             $("#txtJudgement").prop('disabled', true);
                //             $("#txtSelectDocNoBDrawing").prop('disabled', true);
                //             $("#txtSelectDocNoInspStandard").prop('disabled', true);
                //             $("#txtSelectDocNoUD").prop('disabled', true);
                //             $("#btnilqcmlink").prop('disabled', true);
                //             $('input[name="keep_sample"]').attr('disabled', true);

                //             $("#txtEditUploadedFile").removeClass('d-none');
                //             $("#txtAddFile").addClass('d-none');
                //             $("#txtAddFile").removeAttr('required');
                //             $('#txtEditUploadedFile').val(ipqc_data['measdata_attachment']);

                //             let download ='<a href="download_file/'+ipqc_data['id']+'">';
                //                 download +='<button type="button" id="download_file" name="download_file" class="btn btn-primary btn-sm d-none">';
                //                 download +=     '<i class="fa-solid fa-file-arrow-down"></i>';
                //                 download +=         '&nbsp;';
                //                 download +=         'See Attachment';
                //                 download +='</button>';
                //                 download +='</a>';

                //             $('#AttachmentDiv').append(download);
                //             $("#download_file").removeClass('d-none');
                //             $('#modalIpqcInspection').modal('show');
                //         },
                //         error: function(data, xhr, status){
                //             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                //         }

                //     });
                // });

                // $(document).on('click', '.btnUpdateIPQCData',function(e){
                //     console.log('view');
                //     e.preventDefault();
                //     let stamping_ipqc_id = $(this).attr('ipqc_data-id');
                //     let first_stamping_prod_id = $(this).attr('fs_prod_data-id');

                //     $.ajax({
                //         url: "get_data_from_fs_production",
                //         type: "get",
                //         data: {
                //             stamping_ipqc_id: stamping_ipqc_id,
                //             fs_prod_id: first_stamping_prod_id
                //         },
                //         dataType: "json",
                //         beforeSend: function(){
                //             $('#formIPQCInspectionData')[0].reset();
                //         },
                //         success: function(response){
                //             $('#formIPQCInspectionData input[name="_token"]').val('{{ csrf_token() }}');
                //             let fs_prod_data = response['fs_production_data'];

                //             $('#txtStampingIpqcId').val(stamping_ipqc_id);
                //             $('#txtFirstStampingProdId').val(first_stamping_prod_id);
                //             $('#txtStampingCategory').val(fs_prod_data[0]['stamping_cat']);
                //             $('#txtPoNumber').val(fs_prod_data[0]['po_num']);
                //             $('#txtPartCode').val(fs_prod_data[0]['part_code']);
                //             $('#txtMaterialName').val(fs_prod_data[0]['material_name']);
                //             $('#txtProductionLot').val(fs_prod_data[0]['prod_lot_no']);
                //             $('#txtInput').val(fs_prod_data[0]['qc_samp']);

                //             //disabled and readonly
                //             $("#frmSaveBtn").prop('hidden', false);
                //             $("#txtOutput").prop('disabled', false);
                //             $("#txtJudgement").prop('disabled', false);
                //             $("#txtSelectDocNoBDrawing").prop('disabled', false);
                //             $("#txtSelectDocNoInspStandard").prop('disabled', false);
                //             $("#txtSelectDocNoUD").prop('disabled', false);
                //             $("#btnilqcmlink").prop('disabled', false);
                //             $('input[name="keep_sample"]').attr('disabled', false);

                //             $("#btnViewBDrawings").prop('disabled', true);
                //             $("#btnViewInspStdDrawings").prop('disabled', true);
                //             $("#btnViewUdDrawings").prop('disabled', true);

                //             if(fs_prod_data[0]['stamping_ipqc_data'] == 0){ //when fs_prod_id && stamping_ipqc_id is not existing in StampingIpqc Table //For Insert to StampingIpqc Table

                //                 $('#txtInspectorID').val(fs_prod_data[0]['ipqc_inspector_id']);
                //                 $('#txtInspectorName').val(fs_prod_data[0]['ipqc_inspector_name']);
                //                 $("#btnReuploadTriggerDiv").addClass("d-none");
                //                 $("#btnPartsDrawingAddRow").addClass("d-none");

                //                 $("#txtAddFile").removeClass('d-none');
                //                 $("#txtAddFile").attr('required', true);
                //                 $("#txtEditUploadedFile").addClass('d-none');
                //                 $("#download_file").addClass('d-none');

                //                 $("#txtSelectDocNoBDrawing").prop('required', true);
                //                 $("#txtSelectDocNoInspStandard").prop('required', true);
                //                 $("#txtSelectDocNoUD").prop('required', true);

                //                 if($('#txtKeepSample1').prop('checked')){
                //                     $('input[name="keep_sample"]').prop('required', false);
                //                 }else if($('#txtKeepSample1').prop('checked')){
                //                     $('input[name="keep_sample"]').prop('required', false);
                //                 }else{
                //                     $('input[name="keep_sample"]').prop('required', true);
                //                 }

                //             }else{
                //                 let ipqc_data = response['fs_production_data'][0]['stamping_ipqc'];

                //                 $('#txtOutput').val(ipqc_data['output']);
                //                 $('#txtJudgement').val(ipqc_data['judgement']);
                //                 $('#txtInspectorID').val(ipqc_data['ipqc_insp_name']['id']);

                //                 if(ipqc_data['keep_sample'] == 1){
                //                     $('#txtKeepSample1').prop('checked', true);
                //                 }else if(ipqc_data['keep_sample'] == 2){
                //                     $('#txtKeepSample2').prop('checked', true);
                //                 }else{
                //                     $('input[name="keep_sample"]').prop('checked', false);
                //                 }

                //                 $('#txtInspectorName').val(ipqc_data['ipqc_insp_name']['firstname'] +' '+ ipqc_data['ipqc_insp_name']['lastname']);

                //                 let ng_value = $('#txtInput').val() - $('#txtOutput').val();
                //                 $('#txtNGQty').val(ng_value);

                //                 $("#txtSelectDocNoBDrawing").val(ipqc_data['doc_no_b_drawing']);
                //                 $("#txtSelectDocNoInspStandard").val(ipqc_data['doc_no_insp_standard']);
                //                 $("#txtSelectDocNoUD").val(ipqc_data['doc_no_urgent_direction']);

                //                 $('input[name="keep_sample"]').attr('disabled', false);
                //                 $("#btnReuploadTriggerDiv").removeClass('d-none');
                //                 $("#btnReuploadTrigger").removeClass('d-none');
                //                 $("#btnReuploadTrigger").prop('checked', false);
                //                 $("#btnReuploadTriggerLabel").removeClass('d-none');
                //                 // }
                //                 $("#txtEditUploadedFile").removeClass('d-none');
                //                 $("#txtAddFile").addClass('d-none');
                //                 $("#txtAddFile").removeAttr('required');
                //                 $("#txtSelectDocumentNo").removeAttr('required');
                //                 $("#txtEditUploadedFile").removeAttr('required');
                //                 $('#txtEditUploadedFile').val(ipqc_data['measdata_attachment']);

                //                 $("#txtSelectDocNoBDrawing").prop('required', false);
                //                 $("#txtSelectDocNoInspStandard").prop('required', false);
                //                 $("#txtSelectDocNoUD").prop('required', false);

                //                 let download ='<a href="download_file/'+ipqc_data['id']+'">';
                //                     download +='<button type="button" id="download_file" name="download_file" class="btn btn-primary btn-sm d-none">';
                //                     download +=     '<i class="fa-solid fa-file-arrow-down"></i>';
                //                     download +=         '&nbsp;';
                //                     download +=         'See Attachment';
                //                     download +='</button>';
                //                     download +='</a>';

                //                 $('#AttachmentDiv').append(download);
                //                 $("#download_file").removeClass('d-none');
                //             }
                //             $('#modalIpqcInspection').modal('show');
                //             $('#txtScanQrCode').val('');
                //             $('#mdlScanQrCode').modal('hide');
                //         },
                //         error: function(data, xhr, status){
                //             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                //         }
                //     });
                // });

                // function GetBDrawingFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo){
                //     GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo);
                // };

                // function GetInspStandardFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo){
                //     GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo);
                // };

                // function GetUDFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo){
                //     GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo);
                // };

                // function GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo){
                //     let result = '<option value="" disabled selected>--Select Document No.--</option>';

                //     $.ajax({
                //         url: 'get_data_from_acdcs',
                //         method: 'get',
                //         data: {
                //             'doc_title': doc_title,
                //             'doc_type': doc_type
                //         },
                //         dataType: 'json',
                //         beforeSend: function() {
                //                 result = '<option value="0" disabled selected>--Loading--</option>';
                //                 cboElement.html(result);
                //         },
                //         success: function(response) {
                //             if (response['acdcs_data'].length > 0) {

                //                     result = '<option value="" disabled selected>--Select Document No.--</option>';
                //                 if(response['acdcs_data'][0].doc_type != 'B Drawing'){
                //                     result += '<option value="N/A"> N/A </option>';
                //                 }

                //                 for (let index = 0; index < response['acdcs_data'].length; index++) {
                //                     result += '<option value="' + response['acdcs_data'][index].doc_no + '">' + response['acdcs_data'][index].doc_no + '</option>';
                //                 }
                //             } else {
                //                 result = '<option value="0" selected disabled> -- No record found -- </option>';
                //             }
                //             cboElement.html(result);
                //         },
                //         error: function(data, xhr, status) {
                //             result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                //             cboElement.html(result);
                //             console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                //         }
                //     });
                // }

                // // ================================= RE-UPLOAD FILE =================================
                // $('#btnReuploadTrigger').on('click', function() {
                //     $('#btnReuploadTrigger').attr('checked', 'checked');
                //     if($(this).is(":checked")){
                //         $("#txtAddFile").removeClass('d-none');
                //         $("#txtAddFile").attr('required', true);
                //         $("#txtEditUploadedFile").addClass('d-none');
                //         $("#download_file").addClass('d-none');
                //     }
                //     else{
                //         $("#txtAddFile").addClass('d-none');
                //         $("#txtAddFile").removeAttr('required');
                //         $("#txtAddFile").val('');
                //         $("#txtEditUploadedFile").removeClass('d-none');
                //         $("#download_file").removeClass('d-none');
                //     }
                // });

                // $("#FrmConfirmSubmitIPQCInspection").submit(function(event) {
                //     event.preventDefault();
                //     $.ajax({
                //         url: "update_status_of_ipqc_inspection",
                //         method: "post",
                //         data: $('#FrmConfirmSubmitIPQCInspection').serialize(),
                //         dataType: "json",
                //         success: function (response) {
                //             let result = response['result'];
                //             if (result == 'Successful') {
                //                 dt1stStampingIpqcInspectionPending.draw();
                //                 dt1stStampingIpqcInspectionCompleted.draw();
                //                 dt1stStampingIpqcInspectionResetup.draw();
                //                 toastr.success('Successful!');
                //                 $("#modalConfirmSubmitIPQCInspection").modal('hide');
                //             }else{
                //                 toastr.error('Error!, Please Contanct ISS Local 208');
                //             }
                //         }
                //     });
                // });

                // $('#formIPQCInspectionData').submit(function(e){
                //     e.preventDefault();
                //     $('#modalScanQRSave').modal('show');
                // });

                // $(document).on('keyup','#txtScanUserId', function(e){
                //     if(e.keyCode == 13){
                //         validateUser($(this).val(), [0, 2, 5], function(result){
                //             if(result == true){
                //                 AddIpqcInspection();
                //             }
                //             else{ // Error Handler
                //                 toastr.error('User not authorize!');
                //             }
                //         });
                //         $(this).val('');
                //     }
                // });

                // function AddIpqcInspection(){
                //     let formData = new FormData($('#formIPQCInspectionData')[0]);
                //     console.log('formdata', formData);
                //     $.ajax({
                //         url: "add_ipqc_inspection",
                //         method: "post",
                //         data: formData,
                //         processData: false,
                //         contentType: false,
                //         dataType: "json",
                //         beforeSend: function(){
                //         },
                //         success: function (response) {
                //             let result = response['result'];
                //             if (result == 'Insert Successful' || result == 'Update Successful') {
                //                 toastr.success('Successful!');
                //                 $('#modalIpqcInspection').modal('hide');
                //                 $('#modalScanQRSave').modal('hide');
                //                 dt1stStampingIpqcInspectionPending.draw();
                //                 dt1stStampingIpqcInspectionCompleted.draw();
                //                 dt1stStampingIpqcInspectionResetup.draw();
                //             }
                //             else if(result == 'Duplicate'){
                //                 toastr.error('Request Already Submitted!');
                //             }
                //             else if(result == 'Session Expired') {
                //                 toastr.error('Session Expired!, Please Log-in again');
                //             }else if(result == 'Error'){
                //                 toastr.error('Error!, Please Contanct ISS Local 208');
                //             }
                //         },
                //         error: function(data, xhr, status){
                //             toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                //         }
                //     });
                // };
            });
        </script>
    @endsection
@endauth

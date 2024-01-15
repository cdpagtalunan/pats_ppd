@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'OQC Inspection')
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

            .scanner{
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

        <div class="content-wrapper"> <!-- Content Wrapper. Contains page content -->
            <section class="content-header"> <!-- Content Header (Page header) -->
                <div class="container-fluid"><!-- Container-fluid -->
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>OQC Inspection</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">OQC Inspection</li>
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
                                    <h3 class="card-title">OQC Table</h3>
                                </div>

                                <!-- Start Search PO No. -->
                                <div class="row p-3">
                                    <div class="col-3">
                                        <div class="input-group input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-dark" id="btnScanPo" data-toggle="modal" data-target="#mdlScanQrCode"><i class="fa fa-qrcode w-100"></i></button>
                                            </div>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>PO No.:</strong></span>
                                            </div>
                                            <input type="search" class="form-control" id="txtPoNumber" placeholder="---------------" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><Strong>Material Name:</Strong></span>
                                            </div>
                                            <input type="search" class="form-control" id="txtMaterialName" placeholder="---------------" readonly>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="input-group input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><strong>Po Qty:</strong></span>
                                            </div>
                                            <input type="text" class="form-control" id="txtPoQuantity" placeholder="---------------" readonly>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Search PO No. -->

                                <div class="card-body"><!-- Start Page Content -->
                                    <div style="float: right;">
                                    </div>
                                    <div class="table-responsive"><!-- Table responsive -->
                                        <table id="tblOqcInspection" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th class="w-25">Action</th>
                                                    <th>P.O No.</th>
                                                    <th>Prod. Lot</th>
                                                    <th>Quantity</th>
                                                    <th>Material Name</th>
                                                    <th>FY-WW</th>
                                                    <th>Date Inspected</th>
                                                    <th>From</th>
                                                    <th>To</th>
                                                    <th># of Sub</th>
                                                    <th>Lot No.</th>
                                                    <th>Lot Qty.</th>
                                                    <th>Sample Size</th>
                                                    <th>Mode of Defects</th>
                                                    <th>No. of Detective</th>
                                                    <th>Judgement</th>
                                                    <th>Inspector</th>
                                                    <th>Remarks</th>
                                                    <th>Family</th>
                                                    <th>Updated By</th>
                                                    <th>Update Date</th>
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
        <div class="modal fade" id="modalOqcInspection" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> OQC Inspection</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formOqcInspection" autocomplete="off">
                        @csrf

                        <input type="hidden" class="form-control form-control-sm" id="txtOqcInspectionId" name="oqc_inspection_id">
                        <input type="hidden" class="form-control form-control-sm" id="txtProdId" name="prod_id">
                        <input type="hidden" class="form-control form-control-sm" id="txtEmployeeNo" name="employee_no">
                        
                        <div class="row drawing input-group p-3">
                            <div class="input-group-prepend w-25">
                                <button type="button" class="btn btn-dark" id="btnViewRDrawings"><i class="fa fa-file" title="View"></i></button>
                                <span class="input-group-text w-100">B Drawing</span>
                            </div>
                            <input type="text" class="form-control txtdrawing" id="txtBDrawing" name="b_drawing" readonly>
                            <input type="text" class="form-control" id="txtBDrawingNo" name="b_drawing_no" readonly>
                            <input type="text" class="form-control" id="txtBDrawingRevision" name="b_drawing_revision" readonly>
                        </div>

                        <div class="modal-body viewDrawingFirst d-none p-4">
                            <div class="row"><!-- Start Row OQC Data -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <strong>OQC Data</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Assembly Line</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm assemblyLineDropdown" id="slctOqcInspectionAssemblyLine" name="oqc_inspection_assembly_line">
                                        </select>    
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Lot No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionLotNo" name="oqc_inspection_lot_no">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Application Date</strong></span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="dateOqcInspectionApplicationDate" name="oqc_inspection_application_date">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Application Time</strong></span>
                                        </div>
                                        <input type="time" class="form-control form-control-sm" id="timeOqcInspectionApplicationTime" name="oqc_inspection_application_time">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Product Category</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm" id="slctOqcInspectionProductCategory" name="oqc_inspection_product_category">
                                            <option selected disabled>--- Select ---</option>
                                            <option value="Automotive">Automotive</option>
                                            <option value="Non-Automotive">Non-Automotive</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <div class="card">
                                            <input type="hidden" id="txtPrintLotCounter" name="print_lot_counter" value="0">
                                            <span class="input-group-text w-100"><strong>Print Lot No.</strong></span>
                                            <div class="row mb-1 mt-1" id="divPrintLotFields">
                                                <div class="col-3">
                                                    <button class="btn btn-info btn-sm ml-4" id="btnAddPrintLot" title="Add Print Lot"><i class="fa fa-plus"></i></button>
                                                    <button class="btn btn-danger btn-sm d-none" id="btnRemovePrintLot" title="Remove Print Lot"><i class="fas fa-times"></i></button>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm mb-1" id="txtPrintLotNo_0" name="print_lot_no_0" placeholder="Print Lot No.">
                                                </div>
                                                <div class="col-4 mr-2">
                                                    <input type="number" class="form-control form-control-sm" id="txtPrintLotQty_0" name="print_lot_qty_0"  placeholder="Print Lot Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>P.O. No.</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionPoNo" name="oqc_inspection_po_no" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Material Name</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionMaterialName" name="oqc_inspection_material_name" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Customer</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionCustomer" name="oqc_inspection_customer">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>P.O. Qty.</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionPoQty" name="oqc_inspection_po_qty" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Family</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm familyDropdown" id="txtOqcInspectionFamily" name="oqc_inspection_family">
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <div class="card">
                                            <input type="hidden" id="txtReelLotCounter" name="reel_lot_counter" value="0">
                                            <span class="input-group-text w-100"><strong>Reel Lot No.</strong></span>
                                            <div class="row mb-1 mt-1" id="divReelLotFields">
                                                <div class="col-3">
                                                    <button class="btn btn-info btn-sm ml-4" id="btnAddReelLot" title="Add Reel Lot"><i class="fa fa-plus"></i></button>
                                                    <button class="btn btn-danger btn-sm d-none" id="btnRemoveReelLot" title="Remove Reel Lot"><i class="fas fa-times"></i></button>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm mb-1" id="txtReelLotNo_0" name="reel_lot_no_0" placeholder="Reel Lot No.">
                                                </div>
                                                <div class="col-4 mr-2">
                                                    <input type="number" class="form-control form-control-sm" id="txtReelLotQty_0" name="reel_lot_qty_0"  placeholder="Reel Lot Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.End Row OQC Data -->

                            <div class="row"><!-- Start Row Sampling Plan -->
                                <div class="row">
                                    <hr>
                                    <div class="col-sm-12">
                                        <strong>Sampling Plan</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Type of Inspection</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm inspectionTypeDropdown" id="slctOqcInspectionInspectionType" name="oqc_inspection_inspection_type">
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Severity of Inspection</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm severityInspectionDropdown" id="slctOqcInspectionInspectionSeverity" name="oqc_inspection_inspection_severity">
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Inspection Level</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm inspectionLevelDropdown" id="slctOqcInspectionInspectionLevel" name="oqc_inspection_inspection_level">
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Lot Qty.</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionLotQty" name="oqc_inspection_lot_qty">
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>AQL</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm aqlDropdown" id="slctOqcInspectionAql" name="oqc_inspection_aql">
                                        </select>    
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Sample Size</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionSampleSize" name="oqc_inspection_sample_size">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Accept</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionAccept" name="oqc_inspection_accept" readonly>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Reject</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionReject" name="oqc_inspection_reject" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row Sampling Plan -->

                            <div class="row"><!-- Start Row Visual Inspection -->
                                <div class="row">
                                    <hr>
                                    <div class="col-sm-12">
                                        <strong>Visual Inspection</strong>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Date Inspected</strong></span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="dateOqcInspectionDateInspected" name="oqc_inspection_date_inspected">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100"><strong>Work Week</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionWorkWeek" name="oqc_inspection_work_week">
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100"><strong>Fiscal Year</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionFiscalYear" name="oqc_inspection_fiscal_year">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-30">
                                            <span class="input-group-text w-100"><strong>Time Inspected</strong></span>
                                        </div>
                                        <input type="time" class="form-control form-control-sm mr-2" id="timeOqcInspectionTimeInspectedFrom" name="oqc_inspection_time_inspected_from">
                                        <input type="time" class="form-control form-control-sm" id="timeOqcInspectionTimeInspectedTo" name="oqc_inspection_time_inspected_to">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Shift</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm" id="slctOqcInspectionShift" name="oqc_inspection_shift">
                                            <option selected disabled>-- Select --</option>
                                            <option value="A">Shift A</option>
                                            <option value="B">Shift B</option>
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Submission</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm" id="slctOqcInspectionSubmission" name="oqc_inspection_submission">
                                            <option selected disabled>--- Select ---</option>
                                            <option value="1">1st</option>
                                            <option value="2">2nd</option>
                                            <option value="3">3rd</option>
                                        </select>
                                    </div>
                                    
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Inspector</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionInspector" name="oqc_inspection_inspector" readonly>
                                    </div>
                                </div>


                                <div class="col-sm-6 mt-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Coc Requirement</strong></span>
                                        </div>
                                        <select class="form-select form-control-sm" id="slctOqcInspectionCocRequirement" name="oqc_inspection_coc_requirement">
                                            <option selected disabled>-- Select --</option>
                                            <option value="1">Yes</option>
                                            <option value="2">No</option>
                                        </select>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Lot Inspected</strong></span>
                                        </div>
                                        <input type="number" class="form-control form-control-sm" id="txtOqcInspectionLotInspected" name="oqc_inspection_lot_inspected">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Lot Accepted</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionLotAccepted" name="oqc_inspection_lot_accepted" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Judgement</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionJudgement" name="oqc_inspection_judgement" readonly>
                                    </div>

                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>Remarks</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionRemarks" name="oqc_inspection_remarks">
                                    </div>

                                    <div class="input-group input-group-sm mb-3 d-none  mod-class">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong>No. of Defectives</strong></span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="txtOqcInspectionDefectiveNum" name="oqc_inspection_defective_num" readonly>
                                    </div>
                                </div>
                            </div><!-- /.End Row Visual Inspection -->

                            <div class="mb-2 d-none mod-class">
                                <div class="card">
                                    <input type="hidden" id="txtModCounter" name="mod_counter" value="0">
                                    <span class="input-group-text w-100"><strong>Mode of Defects</strong></span>
                                    <div class="row mb-1 mt-1" id="divModFields">
                                        <div class="col-2">
                                            <button class="btn btn-info btn-sm ml-5" id="btnAddMod" title="Add Mode of Defect"><i class="fa fa-plus"></i></button>
                                            <button class="btn btn-danger btn-sm d-none" id="btnRemoveMod" title="Remove  Mode of Defect"><i class="fas fa-times"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-select form-control-sm inspectionModDropdown_0 mb-1" id="txtMod_0" name="mod_0"  placeholder="Mode of Defect">
                                            </select>    
                                        </div>
                                        <div class="col-5 mr-1">
                                            <input type="number" class="form-control form-control-sm" id="txtModQty_0" name="mod_qty_0"  placeholder="Mode of Defect Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between viewDrawingFirst d-none">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="btnOqcInspection" class="btn btn-dark"><i 
                                id="iBtnOqcInspectionIcon" class="fa fa-check"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.End OQC Inspection Modal -->

        <!-- Start Scan Modal -->
        <div class="modal fade" id="mdlScanQrCode" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body mt-3">
                        <input type="text" class="scanner w-100 d-none" id="txtScanQrCode" name="scan_qr_code" value='{"po":"450244133600010","code":"108321601","name":"CT 6009-VE","mat_lot_no":"1","qty":88000,"output_qty":2500}' autocomplete="off">
                        <input type="text" class="scanner w-100 d-none" id="txtScanUserId" name="scan_user_id" autocomplete="off">
                        <div class="text-center text-secondary">Please scan the code.<br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            </div>
        </div><!-- /.End Scan Modal -->
        
        <!-- Start Print Lot & Reel Lot Modal -->
        <!-- <div class="modal fade" id="modalOqcInspectionPrintLotReelLotNo" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> Print Lot No. & Reel Lot No.</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-2">
                                <div class="card">
                                    <input type="hidden" id="txtPrintLotCounter" name="print_lot_counter" value="0">
                                    <span class="input-group-text w-100"><strong>Print Lot No.</strong></span>
                                    <div class="row mb-1 mt-1" id="divPrintLotFields">
                                        <div class="col-3">
                                            <button class="btn btn-info btn-sm ml-4" id="btnAddPrintLot" title="Add Print Lot"><i class="fa fa-plus"></i></button>
                                            <button class="btn btn-danger btn-sm d-none" id="btnRemovePrintLot" title="Remove Print Lot"><i class="fas fa-times"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control form-control-sm mb-1" id="txtPrintLotNo_0" name="print_lot_no_0" placeholder="Print Lot No.">
                                        </div>
                                        <div class="col-4 mr-2">
                                            <input type="number" class="form-control form-control-sm" id="txtPrintLotQty_0" name="print_lot_qty_0"  placeholder="Print Lot Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="card">
                                    <input type="hidden" id="txtReelLotCounter" name="reel_lot_counter" value="0">
                                    <span class="input-group-text w-100"><strong>Reel Lot No.</strong></span>
                                    <div class="row mb-1 mt-1" id="divReelLotFields">
                                        <div class="col-3">
                                            <button class="btn btn-info btn-sm ml-4" id="btnAddReelLot" title="Add Reel Lot"><i class="fa fa-plus"></i></button>
                                            <button class="btn btn-danger btn-sm d-none" id="btnRemoveReelLot" title="Remove Reel Lot"><i class="fas fa-times"></i></button>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control form-control-sm mb-1" id="txtReelLotNo_0" name="reel_lot_no_0" placeholder="Reel Lot No.">
                                        </div>
                                        <div class="col-4 mr-2">
                                            <input type="number" class="form-control form-control-sm" id="txtReelLotQty_0" name="reel_lot_qty_0"  placeholder="Reel Lot Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-dark btn-sm float-right w-25" id="btnSavePrintLotReelLot" data-bs-dismiss="modal"></i>Save</button>
                    </div>
                </div>
            </div>
        </div> --> <!-- /.End Print Lot & Reel Lot Modal -->
    @endsection

    @section('js_content')
        <script type="text/javascript">
            let getPoNo
            let checkedDrawCount
            let dataTableOQCInspection

            $(document).ready(function() {
                GetAQL($('.aqlDropdown'))
                GetFamily($('.familyDropdown'))
                GetMOD($('.inspectionModDropdown_0'))
                GeAssemblyLine($('.assemblyLineDropdown'))
                GetInspectionType($('.inspectionTypeDropdown'))
                GetInspectionLevel($('.inspectionLevelDropdown'))
                GetSeverityInspection($('.severityInspectionDropdown'))

                $('.select2bs4').select2({
                    theme: 'bootstrap-5'
                });

                $('#smartwizard').smartWizard({
                    selected        :   0,
                    theme           :   'arrows',
                    transitionEffect:   'fade',
                    autoAdjustHeight:   true,
                    showStepURLhash :   false,
                    keyNavigation   :   false,
                    // anchorSettings  : {
                    //     enableAllAnchors: true, 
                    //     markDoneStep: true,
                    // },
                });
                

                // ======================= START DATA TABLE =======================
                dataTableOQCInspection = $("#tblOqcInspection").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_oqc_inspection",
                        data: function (pamparam){
                            pamparam.poNo = getPoNo
                        },
                    },

                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "po_no" },
                        { "data" : "prod_lot" },
                        { "data" : "po_qty" },
                        { "data" : "material_name" },
                        { "data" : "fy_ww" },
                        { "data" : "date_inspected" },
                        { "data" : "time_ins_from" },
                        { "data" : "time_ins_to" },
                        { "data" : "submission" },
                        { "data" : "lot_no" },
                        { "data" : "lot_qty" },
                        { "data" : "sample_size" },
                        { "data" : "mod" },
                        { "data" : "num_of_defects" },
                        { "data" : "judgement" },
                        { "data" : "inspector" },
                        { "data" : "remarks" },
                        { "data" : "family" },
                        { "data" : "update_user" },
                        { "data" : "updated_at" }
                    ],
                    "columnDefs": [
                        // { className: "align-center", targets: [1, 2] },
                    ],
                });

                $('#btnScanPo').on('click', function(e){
                    e.preventDefault()
                    console.log('Show scan qr code field')
                    $('#mdlScanQrCode').modal('show')
                    $('#mdlScanQrCode').on('shown.bs.modal', function () {
                        $('#txtScanUserId').addClass('d-none')
                        $('#txtScanQrCode').removeClass('d-none')
                        $('#txtScanQrCode').focus()
                        const mdlScanQrCodeOqcInspection = document.querySelector("#mdlScanQrCode");
                        const inptQrCodeOqcInspection = document.querySelector("#txtScanQrCode");
                        let focus = false

                        mdlScanQrCodeOqcInspection.addEventListener("mouseover", () => {
                            if (inptQrCodeOqcInspection === document.activeElement) {
                                focus = true
                            } else {
                                focus = false
                            }
                        });

                        mdlScanQrCodeOqcInspection.addEventListener("click", () => {
                            if (focus) {
                                inptQrCodeOqcInspection.focus()
                            }
                        });
                    });
                });

                $('#txtScanQrCode').on('keypress',function(e){
                    if( e.keyCode == 13 ){
                        const scanQrCode = $('#txtScanQrCode').val()
                        let po = JSON.parse(scanQrCode)
                        getPoNo =  po.po
                        
                        $('#txtPoNumber').val(po.po)
                        $('#txtMaterialName').val(po.name)
                        $('#txtPoQuantity').val(po.qty)
                        $('#mdlScanQrCode').modal('hide')
                        dataTableOQCInspection.draw()
                    }
                });

                $(document).on('click', '.actionOqcInspection', function(e){
                    e.preventDefault()
                    getPo           = $(this).attr('prod-po')
                    getPoQty        = $(this).attr('prod-po-qty')
                    getOqcId        = $(this).attr('oqc_inspection-id')
                    getProdId       = $(this).attr('prod-id')
                    getDeviceName   = $(this).attr('prod-device-name')
                    
                    GetOqcInspectionById(
                        getPo,
                        getPoQty,
                        getOqcId,
                        getProdId,
                        getDeviceName
                    )
                    $('#txtProdId').val(getProdId)
                    $('#txtOqcInspectionId').val(getOqcId)
                    $('#modalOqcInspection').modal('show')
                });
                
                $('#btnViewRDrawings').click(function (e) { 
                    e.preventDefault();
                    window.open("http://rapid/ACDCS/prdn_home_pats_ppd?doc_no="+$('#txtBDrawingNo').val())
                    $('.viewDrawingFirst').removeClass('d-none')
                    $('.drawing').addClass('d-none')
                });

                $('#modalOqcInspection').on('hide.bs.modal', function() {
                    console.log('Hide OQC Inspection modal: hide scan fields')
                    $('#txtScanUserId').addClass('d-none')
                    $('#txtScanQrCode').addClass('d-none')
                    $('.viewDrawingFirst').addClass('d-none')
                    $('.drawing').removeClass('d-none')
                    dataTableOQCInspection.draw()
                });

                // ===================== SCRIPT FOR ADD PRINT LOT ===================
                let printLotCounter = 0;
                $('#btnAddPrintLot').on('click', function(e){
                    e.preventDefault()
                    printLotCounter++
                    if(printLotCounter > 0){
                        $('#btnRemovePrintLot').removeClass('d-none')
                    }
                    console.log('Print lot Row(+):', printLotCounter)

                    let html = '<div class="col-3 mb-1 divAddPrintLot_'+printLotCounter+'">'
                        html += '</div>'
                        html += '<div class="col-4 mb-1 divAddPrintLot_'+printLotCounter+'">'
                        html += '   <input type="text" class="form-control form-control-sm w-100" id="txtPrintLotNo_'+printLotCounter+'" name="print_lot_no_'+printLotCounter+'" placeholder="Print Lot No">'
                        html += '</div>'
                        html += '<div class="col-4 mb-1 divAddPrintLot_'+printLotCounter+'">'
                        html += '   <input type="number" class="form-control form-control-sm w-100" id="txtPrintLotQty_'+printLotCounter+'" name="print_lot_qty_'+printLotCounter+'" placeholder="Print Lot Qty">'

                    $('#txtPrintLotCounter').val(printLotCounter)
                    $('#divPrintLotFields').append(html)
                });
                // ================== SCRIPT FOR REMOVE PRINT LOT ======================
                $("#btnRemovePrintLot").on('click', function(e){
                    e.preventDefault()

                    if(printLotCounter > 0){
                        $('.divAddPrintLot_'+printLotCounter).remove()
                        printLotCounter--
                        $('#txtPrintLotCounter').val(printLotCounter).trigger('change')
                        console.log('Print lot Row(-):' + printLotCounter)
                    }

                    if(printLotCounter < 1){
                        $('#btnRemovePrintLot').addClass('d-none')
                    }
                });

                // ===================== SCRIPT FOR ADD REEL LOT ===================
                let reelLotCounter = 0;
                $('#btnAddReelLot').on('click', function(e){
                    e.preventDefault()
                    reelLotCounter++
                    if(reelLotCounter > 0){
                        $('#btnRemoveReelLot').removeClass('d-none')
                    }
                    console.log('Reel lot Row(+):', reelLotCounter)
                    let html = '   <div class="col-3 mb-1 divAddReelLot_'+reelLotCounter+'">'
                        html += '   </div>'
                        html += '   <div class="col-4 mb-1 divAddReelLot_'+reelLotCounter+'">'
                        html += '       <input type="text" class="form-control form-control-sm" id="txtReelLotNo_'+reelLotCounter+'" name="reel_lot_no_'+reelLotCounter+'" placeholder="Reel Lot No">'
                        html += '   </div>'
                        html += '   <div class="col-4 mb-1 divAddReelLot_'+reelLotCounter+'">'
                        html += '       <input type="number" class="form-control form-control-sm" id="txtReelLotQty_'+reelLotCounter+'" name="reel_lot_qty_'+reelLotCounter+'" placeholder="Reel Lot Qty">'
                        html += '   </div>'

                    $('#txtReelLotCounter').val(reelLotCounter)
                    $('#divReelLotFields').append(html)

                });
                // ================== SCRIPT FOR REMOVE REEL LOT ======================
                $("#btnRemoveReelLot").on('click', function(e){
                    e.preventDefault()

                    if(reelLotCounter > 0){
                        $('.divAddReelLot_'+reelLotCounter).remove()
                        reelLotCounter--
                        $('#txtReelLotCounter').val(reelLotCounter).trigger('change')
                        console.log('Reel lot Row(-):' + reelLotCounter)
                    }

                    if(reelLotCounter < 1){
                        $('#btnRemoveReelLot').addClass('d-none')
                    }
                });

                // ===================== SCRIPT FOR ADD MOD ===================
                let modCounter = 0;
                $('#btnAddMod').on('click', function(e){
                    e.preventDefault()
                    modCounter++
                    if(modCounter > 0){
                        $('#btnRemoveMod').removeClass('d-none')
                    }
                    console.log('Reel lot Row(+):', modCounter)
                    let html = '   <div class="col-2 mb-1 divAddMod_'+modCounter+'">'
                        html += '   </div>'
                        html += '   <div class="col-4 mb-1 divAddMod_'+modCounter+'">'
                        html += '       <select class="form-select form-control-sm inspectionModDropdown_'+modCounter+' mb-1" id="txtMod_'+modCounter+'" name="mod_'+modCounter+'"  placeholder="Mode of Defect"></select>'    
                        html += '   </div>'
                        html += '   <div class="col-5 mb-1 mr-1 divAddMod_'+modCounter+'">'
                        html += '       <input type="number" class="form-control form-control-sm" id="txtModQty_'+modCounter+'" name="mod_qty_'+modCounter+'" placeholder="Defect of Defect Qty">'
                        html += '   </div>'

                        
                    $('#txtModCounter').val(modCounter)
                    $('#divModFields').append(html)

                    GetMOD($('.inspectionModDropdown_'+modCounter+''))
                });
                // ================== SCRIPT FOR REMOVE MOD ======================
                $("#btnRemoveMod").on('click', function(e){
                    e.preventDefault()

                    if(modCounter > 0){
                        $('.divAddMod_'+modCounter).remove()
                        modCounter--
                        $('#txtModCounter').val(modCounter).trigger('change')
                        console.log('Reel lot Row(-):' + modCounter)
                    }

                    if(modCounter < 1){
                        $('#btnRemoveMod').addClass('d-none')
                    }
                });

                $('#txtOqcInspectionLotAccepted').on('keyup', function () {
                // $('#txtOqcInspectionLotAccepted').on('change', function () {
                    if($('#txtOqcInspectionLotAccepted').val() == '1' || $('#txtOqcInspectionLotAccepted').val() == ''){
                        $('.mod-class').addClass('d-none')
                        if($('#txtOqcInspectionLotAccepted').val() != ''){
                            $('#txtOqcInspectionJudgement').val('Accept')
                        }else{
                            $('#txtOqcInspectionJudgement').val('')
                        }
                    }else{
                        $('#txtOqcInspectionJudgement').val('Reject')
                        $('.mod-class').removeClass('d-none')
                    }
                });

                $('#formOqcInspection').submit(function (e) { 
                    e.preventDefault()
                    console.log('Save OQC Inspection')
                    $('#mdlScanQrCode').modal('show')
                    $('#mdlScanQrCode').on('shown.bs.modal', function () {
                        $('#txtScanQrCode').addClass('d-none')
                        $('#txtScanUserId').removeClass('d-none')
                        $('#txtScanUserId').focus()
                        const mdlScanUserId = document.querySelector("#mdlScanQrCode");
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
                });

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
                                    UpdateOqcInspection()
                                }else{
                                    toastr.error('ID Number Not Registered!')
                                }
                            }
                        });
                        $('#txtScanUserId').val('')
                        $('#mdlScanQrCode').modal('hide')
                    }
                });
            });

        </script>
    @endsection
@endauth

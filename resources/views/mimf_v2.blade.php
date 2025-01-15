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
            .input_hidden{
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
                                <ul class="nav nav-tabs p-2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mimfRequest" type="button" role="tab">Material Issuance Monitoring Table</button>
                                    </li>
                                    <li class="nav-item d-none tabMimfStampingMatrix" role="presentation">
                                        <button class="nav-link" id="stampingMatrix" data-bs-toggle="tab" data-bs-target="#mimfStampingMatrix" type="button" role="tab">MIMF Stamping Setting</button>
                                    </li>
                                </ul>

                                <div class="card-body"><!-- Start Page Content -->
                                    <div class="tab-content" id="myTabContent"> <!-- tab-content -->
                                        <div class="tab-pane fade show active" id="mimfRequest" role="tabpanel">
                                            <div class="col-12 input-group mb-3">
                                                <div class="col-5">
                                                    <label class="form-label">MIMF Status:</label>
                                                    <div class="input-group">
                                                        <select class="form-control" id="selectStatus" name="status">
                                                            <option selected disabled>--- Select Status ---</option>
                                                            <option value="1">Stamping</option>
                                                            <option value="2">Molding</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-7 d-flex justify-content-end mt-4">
                                                    <button button
                                                        type="button" class="btn btn-dark mb-3 d-none"
                                                        id="buttonAddMimf"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalMimf"
                                                        data-bs-keyboard="false">
                                                        <i class="fa fa-plus fa-md"></i>
                                                        New Request
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="table-responsive"><!-- Table responsive -->
                                                <table id="tblMimf" class="table table-sm table-bordered table-striped table-hover w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Control Number</th>
                                                            <th>Status</th>
                                                            <th>Date<br>Issuance</th>
                                                            <th>YEC P.O<br> Number</th>
                                                            <th>PMI P.O<br> Number</th>
                                                            <th>Prod'n<br>Quantity</th>
                                                            <th>Device<br>Code</th>
                                                            <th>Device<br>Name</th>
                                                            <th>PO<br>Balance</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div><!-- /.Table responsive -->
                                        </div>

                                        <div class="tab-pane fade d-none tabMimfStampingMatrix" id="mimfStampingMatrix" role="tabpanel">
                                            <div class="text-right">
                                                <button button type="button" class="btn btn-dark" id="buttonAddMimfStampingMatrix" data-bs-toggle="modal" data-bs-target="#modalMimfStampingMatrix" data-bs-keyboard="false"><i class="fa fa-plus fa-md"></i> New Matrix</button>
                                            </div>
                                            <div class="table-responsive mt-3">
                                                <table id="tableMimfStampingMatrix" class="table table-bordered table-hover nowrap w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Action</th>
                                                            <th>Item Code</th>
                                                            <th>Item Name</th>
                                                            <th>Pin / KG</th>
                                                            <th>Created By</th>
                                                            <th>Updated By</th>
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
                        <input type="text" class="col-2 input_hidden" id="txtMimfStatus" name="mimf_status" placeholder="Status" required readonly>
                        <input type="text" class="col-2 input_hidden" id="txtMimfCategory" name="mimf_category" placeholder="Category for Request" required readonly>
                        <input type="text" class="col-2 input_hidden mimfClass" id="txtMimfId" name="mimf_id" placeholder="For MIMF ID" readonly>
                        <input type="text" class="col-2 input_hidden mimfClass" id="txtMimfMatrixForStamping" name="mimf_matrix_for_stamping" placeholder="" readonly>
                        <input type="text" class="col-2 input_hidden mimfClass clearReceivedPo" id="txtPpsPoReceivedId" name="pps_po_rcvd_id" placeholder="For PO Received ID" readonly>
                        <input type="text" class="col-2 input_hidden mimfClass" id="txtCreateEdit" name="create_edit" placeholder="Check if CREATE or EDIT" readonly>
                        <div class="modal-body">
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input first uncheck" type="radio" name="category" id="radioBtnFirstCategory" value="1" required>
                                <label class="form-check-label" for="inlineRadio1">First</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input second uncheck" type="radio" name="category" id="radioBtnSecondCategory" value="2" required>
                                <label class="form-check-label" for="inlineRadio2">Second</label>
                            </div>

                            <div class="row"><!-- Start Row MIMF Data -->
                                <div class="col-6">
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
                                        <input type="text" class="form-control" id="txtMimfControlNo" name="mimf_control_no" readonly>
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

                                    <div class="input-group mb-3 d-none">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Created By</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfCreatedBy" name="mimf_created_by" value="@php echo Auth::user()->firstname.' '.Auth::user()->lastname; @endphp" readonly>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PO Received Order Quantity.">&nbsp;</i>
                                                    P.O Quantity
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
                                </div>
                            </div><!-- /.End Row MIMF Data -->

                            <div class="col-12 input-group border-top save-button">
                                <div class="col-6 mt-3">
                                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                                </div>
                                <div class="col-6 d-flex justify-content-end mt-3">
                                    <button type="submit" id="btnMimf" class="btn btn-dark">
                                        <i id="iBtnMimfIcon" cPpsRequestlass="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive p-3 d-none" id="tblPpsRequest">
                        <div class="card shadow">
                            <div class="modal-body">
                                <div class="col-12 d-flex justify-content-end">
                                    <button button
                                        type="button" class="btn btn-dark mb-3"
                                        id="buttonAddMimfPpsRequest"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalMimfPpsRequest"
                                        data-bs-keyboard="false">
                                        <i class="fa fa-plus fa-md"></i>
                                        New PPS Request
                                    </button>
                                </div>
                                <table id="tblMimfPpsRequest"
                                    class="table table-bordered table-hover w-100"
                                    style="font-size: 85%">
                                    <thead>
                                        <tr>
                                            <th>&nbsp;</th>
                                            <th>Rapid PPS Request Control No.</th>
                                            <th>Material Type</th>
                                            <th>Material Code</th>
                                            <th>Quantity <br> from Inventory</th>
                                            <th>Request Qty.</th>
                                            <th>Request Pins</th>
                                            <th>Needed <br> KGS/Quantity</th>
                                            <th>Virgin Material</th>
                                            <th>Recycled</th>
                                            <th>Prod'n</th>
                                            <th>Delivery</th>
                                            <th>Remark</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.End MIMF Modal -->

        <div class="modal fade" id="modalMimfPpsRequest" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i>Material Issuance Monitoring Issuance Request</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="post" id="formMimfPpsRequest" autocomplete="off">
                        @csrf
                        <div class="row p-3 input_hidden">
                            <input type="text" class="col-2" id="getMimfId" name="get_mimf_id" placeholder="For MIMF ID" readonly>
                            <input type="text" class="col-2" id="getMimfDeviceCode" name="get_device_code" placeholder="For MIMF ID" readonly>
                            <input type="text" class="col-2 reset-value" id="txtMimfMatrixForStampingIssuance" name="mimf_matrix_for_stamping_issuance" placeholder="" readonly>
                            <input type="text" class="col-2" id="getRequestStatus" name="get_request_status" placeholder="For MIMF STATUS" readonly>
                            <input type="text" class="col-2" id="getRequestCategory" name="get_request_category" placeholder="For MIMF CATEGORY" readonly>
                            <input type="text" class="col-2 reset-value" id="txtPpsWhseId" name="pps_whse_id" placeholder="For PPS Warehouse ID" readonly>
                            <input type="text" class="col-2 reset-value" id="txtMimfPpsRequestId" name="mimf_pps_request_id" placeholder="MIMF PPS Request ID" readonly>
                        </div>
                        <div class="modal-body">
                            <div class="row"><!-- Start Row MIMF Data -->
                                <div class="col-6">
                                    <div class="input-group mb-3 moldingOnly">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Product Category</strong></span>
                                        </div>
                                        <select class="form-control" id="slctMoldingProductCategory" name="molding_product_category" required>
                                            <option selected disabled value="">-----</option>
                                            <option value="1">Resin</option>
                                            <option value="2">Contact</option>
                                            <option value="3">ME</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Device -> Process on Matrix VS. PPS Warehouse Material Type.">&nbsp;</i>
                                                    Material Type
                                                </strong>
                                            </span>
                                        </div>
                                        <select class="form-control get-mimf-device" id="slctMimfMaterialType" name="mimf_material_type" required></select>
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
                                        <input type="text" class="form-control reset-value" id="txtMimfMaterialCode" name="mimf_material_code" readonly required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="PPS Warehouse Transaction.">&nbsp;</i>
                                                    Quantity from Inventory
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="txtMimfQuantityFromInventory" name="mimf_quantity_from_inventory" readonly>
                                    </div>

                                    <div class="input-group mb-3 stamping-molding-needed-kgs">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Request Quantity</strong></span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value auto-compute" id="txtRequestQuantity" name="request_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6">
                                        <span class="input-group-text moldingMultiplier d-none">x</span>
                                        <input type="text" class="form-control reset-value molding-reset-value moldingMultiplier d-none auto-compute" id="multiplier" name="multiplier" placeholder="multiplier" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6" readonly>
                                    </div>
                                    <div class="input-group stamping-molding-needed-kgs mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong id="exceptContactMe">
                                                    <i class="fa-solid fa-circle-question moldingNeededKGS d-none" data-bs-toggle="tooltip" data-bs-html="true" title="Request Quantity * Shot Weight(Die-Set) / No. of Cavity(Die-Set) / 1000.">&nbsp;</i>
                                                    <i class="fa-solid fa-circle-question stampingOnly" data-bs-toggle="tooltip" data-bs-html="true" title="Request Quantity / Pin KG(MIMF Stamping Setting) + 10%.">&nbsp;</i>
                                                    Needed KGS
                                                </strong>
                                                <strong class="d-none" id="contactMeOnly">
                                                    <i class="fa-solid fa-circle-question moldingMultiplier d-none" data-bs-toggle="tooltip" data-bs-html="true" title="Request Quantity * multiplier.">&nbsp;</i>
                                                    Needed Quantity
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="txtMimfNeededKgs" name="mimf_needed_kgs" readonly>
                                    </div>

                                    <div class="input-group second-stamping-pins-pcs mb-3 d-none">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Manually encode.">&nbsp;</i>
                                                    Request PINS/PCS
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value" id="txtMimfRequestPinsPcs" name="mimf_request_pins_pcs">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group mb-3 moldingOnly">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    Allowed Quantity
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="txtMimfMoldingAllowedQuantity" name="mimf_molding_allowed_quantity" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6" readonly>
                                        <span class="input-group-text moldingOnly d-none"><strong>Balance:</strong></span>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="leftQty" name="left_quantity" placeholder="Balance" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="6" readonly>
                                    </div>

                                    <div class="input-group mb-3 moldingOnly resinOnly d-none">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Needed KGS(MIMF) * Virgin Material(Matrix).">&nbsp;</i>
                                                    Virgin Material
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="txtMimfVirginMaterial" name="mimf_virgin_material" readonly>
                                    </div>

                                    <div class="input-group mb-3 moldingOnly resinOnly d-none">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100">
                                                <strong>
                                                    <i class="fa-solid fa-circle-question" data-bs-toggle="tooltip" data-bs-html="true" title="Needed KGS(MIMF) * Recycle(Matrix).">&nbsp;</i>
                                                    Recycled
                                                </strong>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control reset-value molding-reset-value" id="txtMimfRecycled" name="mimf_recycled" readonly>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Prod'n</strong></span>
                                        </div>
                                        <input type="date" class="form-control reset-value" id="dateMimfProdn" name="date_mimf_prodn">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Delivery</strong></span>
                                        </div>
                                        <input type="date" class="form-control reset-value" id="dateMimfDelivery" name="mimf_delivery">
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100"><strong class="ml-4">Remarks</strong></span>
                                        </div>
                                        <input type="text" class="form-control reset-value" id="txtMimfRemark" name="mimf_remark">
                                    </div>

                                    <div class="input-group mb-3 d-none">
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
                                    <button type="submit" id="btnMimfPpsRequest" class="btn btn-dark d-none">
                                        <i id="iBtnMimfPpsRequestIcon" class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                        <input type="text" class="col-2 input_hidden" id="txtMimfStampingMatrixId" name="mimf_stamping_matrix_id" readonly>
                        <input type="text" class="col-2 input_hidden" id="txtPpsWarehouseId" name="pps_warehouse_id" readonly>
                        <input type="text" class="col-2 input_hidden" id="txtMimfForStamping" name="mimf_for_stamping" readonly>

                        <div class="modal-body">
                            <div class="row"><!-- Start Row MIMF STAMPING MATRIX Data -->
                                <div class="col-6 mt-3">
                                    <div class="input-group mb-3 fixed">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Item Code</strong></span>
                                        </div>
                                        <select class="form-control select2bs5 ppsPoReceived selectValue" id="slctMimfStampingMatrixItemCode" name="mimf_stamping_matrix_item_code"></select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Item Name</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="txtMimfStampingMatrixItemName" name="mimf_stamping_matrix_item_name" readonly>
                                    </div>

                                </div>

                                <div class="col-6 mt-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend w-25">
                                            <span class="input-group-text w-100"><strong>Pin / KG</strong></span>
                                        </div>
                                            <input type="text" class="form-control" id="txtMimfStampingMatrixPinkg" name="mimf_stamping_matrix_pin_kg">
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
            let dataTableMimfPpsRequest
            let mimfCategory
            let mimfID
            let getMimfStat
            let getMimfCat
            let getMimfPoNo
            let updateAllowedQty

            $(document).ready(function() {
                $('.select2bs5').select2({
                    theme: 'bootstrap-5'
                })

                setTimeout(() => {
                    GetPpsPoReceivedItemCode($('.ppsPoReceived'))
                }, 300);

                $('#selectStatus').change(function (e) {
                    e.preventDefault();
                    mimfCategory = $('#selectStatus').val()
                    if(mimfCategory == 1){
                        console.log('Stamping: ', mimfCategory);
                        $('#txtMimfStatus').val('1')
                        $('.moldingOnly').addClass('d-none')
                        $('#slctMoldingProductCategory').attr('disabled', true)
                        $('.moldingMultiplier').addClass('d-none')
                        $('.moldingNeededKGS').addClass('d-none')

                        $('#txtMimfVirginMaterial').attr('required', true)
                        $('#txtMimfRecycled').attr('required', true)

                        $('.stampingOnly').removeClass('d-none')
                        $('.tabMimfStampingMatrix').removeClass('d-none')
                        $('#txtRequestQuantity').attr('readonly', false)
                    }else{
                        console.log('Molding: ', mimfCategory);
                        $('#txtMimfStatus').val('2')
                        $('.moldingOnly').removeClass('d-none')
                        $('#slctMoldingProductCategory').attr('disabled', false)
                        $('#txtMimfVirginMaterial').attr('required', false)
                        $('#txtMimfRecycled').attr('required', false)
                        $('#txtRequestQuantity').attr('readonly', true)

                        $('.stampingOnly').addClass('d-none')
                        $('.tabMimfStampingMatrix').addClass('d-none')
                    }
                    dataTableMimf.draw()
                    $('#buttonAddMimf').removeClass('d-none')
                })

                // =====================================================================
                // =========================== MIMF REQUEST ============================
                // =====================================================================
                // ======================= START MIMF DATA TABLE =======================
                dataTableMimf = $("#tblMimf").DataTable({
                    "processing"    : false,
                    "serverSide"    : true,
                    "destroy"       : true,
                    "ajax" : {
                        url: "view_mimf_v2",
                        data: function(param){
                            param.mimfCategory  =  mimfCategory
                        }
                    },

                    "columns":[
                        /*0*/{ "data" : "action", orderable:false, searchable:false },
                        /*1*/{ "data" : "control_no" },
                        /*2*/{ "data" : "category" },
                        /*3*/{ "data" : "date_issuance" },
                        /*4*/{ "data" : "yec_po_no" },
                        /*5*/{ "data" : "pmi_po_no" },
                        /*6*/{ "data" : "prodn_qty" },
                        /*7*/{ "data" : "device_code" },
                        /*8*/{ "data" : "device_name" },
                        /*9*/{ "data" : "po_balance" }
                    ],
                    "columnDefs": [
                        // "targets": 'invis',
                    ],
                    // drawCallback: function (data) {
                    //     const apiDataTable= this.api()
                    //     if(data.oAjaxData.mimfCategory == 1){
                    //         apiDataTable.columns([13,14]).visible(false)
                    //     }else{
                    //         apiDataTable.columns([13,14]).visible(true)
                    //     }
                    // }
                })

                $('#buttonAddMimf').click(function(event){
                    event.preventDefault()
                    $('#txtCreateEdit').val('create')
                    $('#txtMimfStatus').val($('#selectStatus').val())
                    $.ajax({
                        url: 'get_control_no_v2',
                        method: 'get',
                        data: {
                            'status': $('#txtMimfStatus').val()
                        },

                        beforeSend: function(){

                        },
                        success: function (response) {
                            let getNewControlNo = response['newControlNo']
                            $('#txtMimfControlNo').val(getNewControlNo)

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
                            'mimfCategory'  : $('#txtMimfStatus').val()
                        },
                        beforeSend: function(){
                        },
                        success: function(response){
                            if($('#txtMimfStatus').val() == 2){
                                let getPoReceivedPmiPoForMolding = response['getPoReceivedPmiPoForMolding']

                                if(getPoReceivedPmiPoForMolding.length > 0){
                                    $('#txtPpsPoReceivedId').val(getPoReceivedPmiPoForMolding[0].id)
                                    $('#txtMimfProdnQuantity').val(getPoReceivedPmiPoForMolding[0].OrderQty)
                                    $('#txtMimfDeviceCode').val(getPoReceivedPmiPoForMolding[0].ItemCode)
                                    $('#txtMimfDeviceName').val(getPoReceivedPmiPoForMolding[0].ItemName)
                                }else{
                                    $('.clearReceivedPo').val('')
                                }
                            }else{
                                let getPoReceivedPmiPoForStamping = response['getPoReceivedPmiPoForStamping']

                                if(getPoReceivedPmiPoForStamping.length > 0){
                                    $('#txtPpsPoReceivedId').val(getPoReceivedPmiPoForStamping[0].id)
                                    $('#txtMimfProdnQuantity').val(getPoReceivedPmiPoForStamping[0].OrderQty)
                                    $('#txtMimfDeviceCode').val(getPoReceivedPmiPoForStamping[0].ItemCode)
                                    $('#txtMimfDeviceName').val(getPoReceivedPmiPoForStamping[0].ItemName)
                                }else{
                                    $('.clearReceivedPo').val('')
                                }
                            }
                        }
                    })
                })

                $('#modalMimf').on('hidden.bs.modal', function() {
                    $('.uncheck').prop({disabled:false, checked:false })
                    $('.save-button').removeClass('d-none')
                    $('.mimfClass').val('')
                    $('#tblPpsRequest').addClass('d-none')
                    $('#txtMimfPmiPoNo').attr('readonly', false)
                })

                $(document).on('click', '.actionEditMimf', function(e){
                    e.preventDefault()

                    $('#txtCreateEdit').val('edit')
                    mimfID = $(this).attr('mimf-id')
                    mimfStatus = $(this).attr('mimf-status')
                    poReceivedID = $(this).attr('po_received-id')

                    $('#txtMimfId').val(mimfID)
                    $('#txtMimfStatus').val(mimfStatus)
                    $('#txtPpsPoReceivedId').val(poReceivedID)

                    $('#txtMimfPmiPoNo').prop('readonly', false)

                    GetMimfById(mimfID)
                })

                $('#formMimf').submit(function (e) {
                    e.preventDefault()
                    UpdateMimf()
                })

                // ================================================================================
                // =============================== MIMF PPS REQUEST ===============================
                // ================================================================================
                $('#modalMimfPpsRequest').on('shown.bs.modal', function(event){
                    let getMimfStampingMatrix   = $('#txtMimfMatrixForStamping').val()
                    let getID                   = $('#txtMimfId').val()
                        getMimfStat             = $('#txtMimfStatus').val()
                        getMimfPoNo             = $('#txtMimfPmiPoNo').val()
                        getMimfCat              = $('#txtMimfCategory').val()

                        $('#getMimfId').val(getID)
                        $('#getRequestStatus').val(getMimfStat)
                        $('#getRequestCategory').val(getMimfCat)
                        $('#getMimfDeviceCode').val($('#txtMimfDeviceCode').val())
                        $('#txtMimfMatrixForStampingIssuance').val(getMimfStampingMatrix)

                    if(getMimfStat == 1){
                        $('.resinOnly').addClass('d-none')
                        if(getMimfCat == 1){
                            $('.stamping-molding-needed-kgs').removeClass('d-none')
                            $('.second-stamping-pins-pcs').addClass('d-none')
                            $('#txtRequestQuantity').attr('readonly', false)
                        }else{
                            $('#txtRequestQuantity').attr('readonly', true)
                            $('.stamping-molding-needed-kgs').addClass('d-none')
                            $('.second-stamping-pins-pcs').removeClass('d-none')
                        }
                    }else{
                        $('.stamping-molding-needed-kgs').removeClass('d-none')
                        $('.second-stamping-pins-pcs').addClass('d-none')

                        if($('#slctMoldingProductCategory').val() == null) {
                            setTimeout(() => {
                                $('#slctMimfMaterialType').addClass('slct');
                            }, 300);
                        }
                    }

                    GetPpdMaterialType($('.get-mimf-device'))

                    if($('#slctMimfMaterialType').val() != '') {
                        setTimeout(() => {
                            GetQtyFromInventory($('#slctMimfMaterialType').val());
                        }, 300);
                    }
                })

                $('#slctMimfMaterialType').change(function (e) {
                    e.preventDefault();
                    $('#txtMimfMoldingAllowedQuantity').val('')
                    $('#leftQty').val('')

                    if($(this).val() != null){
                        GetQtyFromInventory($(this).val())
                        setTimeout(() => {
                            CheckRequestQtyForIssuance(
                                $('#txtMimfId').val(),
                                $('#txtMimfMaterialCode').val(),
                                $('#slctMoldingProductCategory').val(),
                                $('#txtMimfVirginMaterial').val(),
                                $('#txtMimfNeededKgs').val()
                            )                        
                        }, 555);
                    }
                    if($('#slctMimfMaterialType').val() != null){
                        $('.auto-compute').attr('readonly', false)
                        $('#txtMimfMoldingAllowedQuantity').attr('readonly', false)
                    }else{
                        $('.auto-compute').attr('readonly', true)
                        $('#txtMimfMoldingAllowedQuantity').attr('readonly', true)
                    }
                });

                $('#slctMoldingProductCategory').change(function (e) {
                    e.preventDefault();
                    let disabled = $('#slctMimfMaterialType')
                        $('#multiplier').val('')
                        $('#txtRequestQuantity').val('')
                        $('#txtMimfNeededKgs').val('0')
                        $('#txtMimfVirginMaterial').val('0')
                        $('#txtMimfRecycled').val('0')
                        $('#txtRequestQuantity').attr('readonly', false)
                        $('.auto-compute').attr('readonly', false)
                        $('#txtMimfMoldingAllowedQuantity').attr('readonly', false)

                    if($(this).val() == 1){
                        disabled.removeClass('slct');
                        $('#exceptContactMe').removeClass('d-none')
                        $('#contactMeOnly').addClass('d-none')
                        $('.resinOnly').removeClass('d-none')
                        $('.moldingNeededKGS').removeClass('d-none')
                        $('.moldingMultiplier').addClass('d-none')
                        $('#multiplier').attr('readonly', true)
                    }else if($(this).val() == 2 || $(this).val() == 3){
                        disabled.removeClass('slct');
                        $('#exceptContactMe').addClass('d-none')
                        $('#contactMeOnly').removeClass('d-none')
                        $('.resinOnly').addClass('d-none')
                        $('.moldingNeededKGS').addClass('d-none')
                        $('.moldingMultiplier').removeClass('d-none')
                    }else{
                        disabled.addClass('slct');
                        $('#exceptContactMe').removeClass('d-none')
                        $('#contactMeOnly').addClass('d-none')
                        $('#txtRequestQuantity').val('')
                        $('.resinOnly').addClass('d-none')
                        $('.moldingNeededKGS').addClass('d-none')
                        $('.moldingMultiplier').addClass('d-none')
                        $('#txtRequestQuantity').attr('readonly', true)
                        $('.auto-compute').attr('readonly', true)
                        $('#txtMimfMoldingAllowedQuantity').attr('readonly', true)
                    }
                });

                $('#txtMimfRequestPinsPcs').keypress(function (e) {
                    if(Number($('#txtMimfQuantityFromInventory').val()) < Number($('#txtMimfRequestPinsPcs').val())){
                        alert('Request PINS/PCS is greater than the Quantity from Inventory')
                        $('#btnMimfPpsRequest').addClass('d-none')
                    }else{
                        $('#btnMimfPpsRequest').removeClass('d-none')
                    }
                });

                $('#txtMimfRequestPinsPcs').keyup(function (e) {
                    if(Number($('#txtMimfQuantityFromInventory').val()) < Number($('#txtMimfRequestPinsPcs').val())){
                        alert('Request PINS/PCS is greater than the Quantity from Inventory')
                        $('#btnMimfPpsRequest').addClass('d-none')
                    }else{
                        $('#btnMimfPpsRequest').removeClass('d-none')
                    }
                });

                $('#txtMimfMoldingAllowedQuantity').keypress(function (e) {
                    updateAllowedQty = 1
                    CheckRequestQtyForIssuance(
                                $('#getMimfId').val(),
                                $('#txtMimfMaterialCode').val(),
                                $('#slctMoldingProductCategory').val(),
                                $('#txtMimfVirginMaterial').val(),
                                $('#txtMimfNeededKgs').val(),
                                updateAllowedQty
                            )      
                    // if($('#txtMimfProdnQuantity').val() < $('#txtMimfMoldingAllowedQuantity').val()){
                    //     alert('Allowed Quantity is greater than the P.O Quantity')
                    //     $('#btnMimfPpsRequest').addClass('d-none')
                    // }else{
                    //     $('#btnMimfPpsRequest').removeClass('d-none')
                    // }
                });

                $('#txtMimfMoldingAllowedQuantity').keyup(function (e) {
                    updateAllowedQty = 1
                    CheckRequestQtyForIssuance(
                                $('#getMimfId').val(),
                                $('#txtMimfMaterialCode').val(),
                                $('#slctMoldingProductCategory').val(),
                                $('#txtMimfVirginMaterial').val(),
                                $('#txtMimfNeededKgs').val(),
                                updateAllowedQty
                            )      
                    // if($('#txtMimfProdnQuantity').val() < $('#txtMimfMoldingAllowedQuantity').val()){
                    //     alert('Allowed Quantity is greater than the P.O Quantity')
                    //     $('#btnMimfPpsRequest').addClass('d-none')
                    // }else{
                    //     $('#btnMimfPpsRequest').removeClass('d-none')
                    // }
                });

                $(".auto-compute").keyup(function() {
                    let getPartialQuantity = $(this).val()
                    if(getPartialQuantity != ''){
                        $.ajax({
                            url: 'get_pps_request_partial_quantity',
                            method: 'get',
                            data: {
                                'getStatus'                 : $('#txtMimfStatus').val(),
                                'getPartialQuantity'        : getPartialQuantity,
                                'getMimfMatrixItemCode'     : $('#txtMimfDeviceCode').val(),
                                'getPpsRequestMaterialType' : $('#slctMimfMaterialType').val(),
                                'getMoldingProductCategory' : $('#slctMoldingProductCategory').val()
                            },
                            beforeSend: function(){
                            },
                            success: function(response){
                                let calculate = response['calculate'];
                                let getDeviceCode = response['getDeviceCode'];
                                let calcualateDieset = response['calcualateDieset'];
                                let virginMaterialComputation
                                let recyledComputation
                                let calculated

                                if($('#slctMoldingProductCategory').val() != null && $('#slctMoldingProductCategory').val() != 1){ 
                                    calculated = $('#txtRequestQuantity').val() * $('#multiplier').val()
                                    virginMaterialComputation = (calculated*getDeviceCode[0].virgin_percent)/100
                                    recyledComputation = (calculated*getDeviceCode[0].recycle_percent)/100

                                }else{
                                    calculated = calculate.toFixed(2)
                                    if($('#txtMimfStatus').val() == 2){
                                        virginMaterialComputation = (calculated*calcualateDieset[0].ppd_matrix_info.virgin_percent)/100
                                        recyledComputation = (calculated*calcualateDieset[0].ppd_matrix_info.recycle_percent)/100
                                    }
                                }
                                $('#txtMimfNeededKgs').val(calculated)
                                if(Number($('#txtMimfQuantityFromInventory').val()) < Number(calculated)){ //nmodify
                                    alert('Needed KGS is greater than the Quantity from Inventory')
                                    $('#btnMimfPpsRequest').addClass('d-none')
                                }else{
                                    $('#btnMimfPpsRequest').removeClass('d-none')
                                }

                                if($('#leftQty').val() != ''){
                                    setTimeout(() => {     
                                        if($('#slctMoldingProductCategory').val() == 1){
                                            if(Number($('#leftQty').val()) < Number($('#txtMimfVirginMaterial').val())){
                                                alert('Virgin Material is greater than the Balance Quantity')
                                                $('.auto-compute').val('0')
                                                $('#txtMimfVirginMaterial').val('0')
                                                $('#btnMimfPpsRequest').addClass('d-none')
                                            }else{
                                                $('#btnMimfPpsRequest').removeClass('d-none')
                                            }
                                        }else if($('#slctMoldingProductCategory').val() == 2 || $('#slctMoldingProductCategory').val() == 3){
                                            if(Number($('#leftQty').val()) < Number($('#txtMimfNeededKgs').val())){
                                                alert('Needed Quantity is greater than the Balance Quantity')
                                                $('.auto-compute').val('0')
                                                $('#txtMimfNeededKgs').val('0')
                                                $('#btnMimfPpsRequest').addClass('d-none')
                                            }else{
                                                $('#btnMimfPpsRequest').removeClass('d-none')
                                            }
                                        }else{
                                            console.log('STAMPING');
                                        }
                                    }, 300);
                                }

                                $('#txtMimfVirginMaterial').val(virginMaterialComputation.toFixed(2))
                                $('#txtMimfRecycled').val(recyledComputation.toFixed(2))
                            }
                        })
                    }else{
                        $('#txtMimfNeededKgs').val('0')
                        $('#txtMimfVirginMaterial').val('0')
                        $('#txtMimfRecycled').val('0')
                    }

                    if($('#txtMimfStatus').val() != 1){
                        setTimeout(() => {     
                            CheckRequestQtyForIssuance(
                                $('#txtMimfId').val(),
                                $('#txtMimfMaterialCode').val(),
                                $('#slctMoldingProductCategory').val(),
                                $('#txtMimfVirginMaterial').val(),
                                $('#txtMimfNeededKgs').val()
                            )
                        }, 500);
                    }
                })

                $(".auto-compute").keypress(function(){
                    $(this).val()
                    if($('#txtMimfStatus').val() != 1){
                        setTimeout(() => {     
                            CheckRequestQtyForIssuance(
                                $('#txtMimfId').val(),
                                $('#txtMimfMaterialCode').val(),
                                $('#slctMoldingProductCategory').val(),
                                $('#txtMimfVirginMaterial').val(),
                                $('#txtMimfNeededKgs').val()
                            )
                        }, 500);
                    }
                })

                $(document).on('click', '.actionMimfPpsRequest', function(e){
                    e.preventDefault()
                    mimfID = $(this).attr('mimf-id')
                    let balance = $(this).attr('balance')
                    let category = $(this).attr('mimf-category')
                    let status = $(this).attr('mimf-status')
                    let stampingMatrix = $(this).attr('mimf_stamping_matrix-id')

                    if(balance == '0'){
                        $('#buttonAddMimfPpsRequest').addClass('d-none')
                    }else{
                        $('#buttonAddMimfPpsRequest').removeClass('d-none')
                    }

                    $('#txtMimfId').val(mimfID)
                    $('#txtMimfCategory').val(category)
                    $('#txtMimfMatrixForStamping').val(stampingMatrix)

                    $('#tblPpsRequest').removeClass('d-none')
                    $('#txtMimfPmiPoNo').prop('readonly', true)
                    $('.save-button').addClass('d-none')

                    GetMimfById(mimfID)

                    // ======================= START DATA TABLE =======================
                    dataTableMimfPpsRequest = $("#tblMimfPpsRequest").DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "ajax" : {
                            url: "view_mimf_pps_request",
                            data: function (pamparam){
                                pamparam.mimfID = mimfID;
                                pamparam.category = category;
                                pamparam.status = status;
                            },
                        },

                        "columns":[
                            /*0*/{ "data" : "action", orderable:false, searchable:false },
                            /*1*/{ "data" : "pps_control_no"},
                            /*2*/{ "data" : "material_type" },
                            /*3*/{ "data" : "material_code" },
                            /*4*/{ "data" : "qty_invt" },
                            /*5*/{ "data" : "request_qty" },
                            /*6*/{ "data" : "request_pins_pcs" },
                            /*7*/{ "data" : "needed_kgs" },
                            /*8*/{ "data" : "virgin_material" },
                            /*9*/{ "data" : "recycled" },
                            /*10*/{ "data" : "prodn" },
                            /*11*/{ "data" : "delivery" },
                            /*12*/{ "data" : "remarks" },
                        ],
                        "columnDefs": [
                            // { visible: false, targets: 0 }
                        ],
                        drawCallback: function (data,mimfStatus) {
                            const apiDataTable= this.api()

                            if(data.json.input.status == 1){
                                if(data.json.input.category == 1){
                                    apiDataTable.column(6).visible(false)
                                    apiDataTable.columns([5,7]).visible(true)
                                }else{
                                    apiDataTable.column(6).visible(true)
                                    apiDataTable.columns([5,7]).visible(false)
                                }
                                apiDataTable.columns([8,9]).visible(false)
                            }else{
                                apiDataTable.column(6).visible(false)
                                apiDataTable.columns([5,7]).visible(true)
                                apiDataTable.columns([8,9]).visible(true)
                            }
                        }
                    });// END DATA TABLE
                })

                $(document).on('click', '.actionEditMimfPpsRequest', function(e){
                    e.preventDefault()
                    let mimfPpsRequestID = $(this).attr('mimf_pps_request-id')
                    $('#txtMimfPpsRequestId').val(mimfPpsRequestID)

                    GetMimfPpsRequestById(mimfPpsRequestID)
                })

                $('#formMimfPpsRequest').submit(function (e) {
                    e.preventDefault()
                    CreateUpdateMimfPpsRequest()
                })

                // ======================================================================================
                // ================================ MIMF STAMPING MATRIX ================================
                // ======================================================================================
                $('#stampingMatrix').click(function (e) {
                    e.preventDefault();
                    // ======================= START MIMF DATA TABLE =======================
                    dataTableMimfStampingMatrix = $("#tableMimfStampingMatrix").DataTable({
                        "processing"    : false,
                        "serverSide"    : true,
                        "destroy"       : true,
                        "ajax" : {
                            url: "view_mimf_stamping_matrix_v2",
                        },

                        "columns":[
                            { "data" : "action", orderable:false, searchable:false },
                            { "data" : "item_code" },
                            { "data" : "item_name" },
                            { "data" : "pin_kg" },
                            { "data" : "created_by" },
                            { "data" : "updated_by" },
                        ],
                        "columnDefs": [
                            // { className: "", targets: 0 },
                        ],
                    })
                });

                $('#buttonAddMimfStampingMatrix').click(function (e) {
                    e.preventDefault();
                    $('#txtMimfForStamping').val('1')
                });

                $('#slctMimfStampingMatrixItemCode').change(function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: "get_pps_po_recveived_item_code",
                        type: "get",
                        data: {
                            poReceivedDb : $('#slctMimfStampingMatrixItemCode').val(),
                        },
                        dataType: "json",
                        success: function (response) {
                            let getItemName = response['getItemName']
                            if(getItemName != undefined){
                                $('#txtMimfStampingMatrixItemName').val(getItemName.ItemName)
                                if(getItemName.po_received_to_pps_whse_info != null){
                                    $('#txtPpsWarehouseId').val(getItemName.po_received_to_pps_whse_info.id)
                                }else{
                                    $('#txtPpsWarehouseId').val('')
                                }
                            }
                        }
                    })
                })

                $('#slctMimfStampingMatrixPartNumber').on('change', function (e){
                    e.preventDefault();

                    $.ajax({
                        url: "get_pps_warehouse",
                        type: "get",
                        data: {
                            firstStampingPpsWhseDb : $('select[name="mimf_stamping_matrix_part_number"]').val(),
                        },
                        dataType: "json",
                        success: function (response) {
                            let getMaterialType = response['getMaterialType']
                            if(getMaterialType != undefined){
                                $('#txtMimfStampingMatrixMaterialType').val(getMaterialType[0].MaterialType)
                            }
                        }
                    })
                })

                $(document).on('click', '.actionEditMimfStampingMatrix', function(e){
                    e.preventDefault()
                    mimfStampingMatrixID = $(this).attr('mimf_stamping_matrix-id')
                    $('#txtMimfForStamping').val('2')
                    $('#txtMimfStampingMatrixId').val(mimfStampingMatrixID)

                    GetMimfStampingMatrixById(mimfStampingMatrixID)
                })

                $('#modalMimfStampingMatrix').on('hidden.bs.modal', function() {
                    $('#formMimfStampingMatrix')[0].reset()
                    $('.selectValue').val('').trigger('change')
                })

                $('#modalMimfPpsRequest').on('hidden.bs.modal', function() {
                    console.log('HIDE MODAL - Material Issuance Monitoring Issuance Request');
                    $('#multiplier').val('')
                    $('.reset-value').val('')
                    $('#txtRequestQuantity').val('')
                    $('#txtRequestQuantity').attr('readonly', true)
                    $('#txtMimfMoldingAllowedQuantity').attr('readonly', true)
                    $('#slctMimfMaterialType').val('').trigger('change')
                    $('#slctMoldingProductCategory').val('').trigger('change')
                })

                $('#formMimfStampingMatrix').submit(function (e) {
                    e.preventDefault()
                    UpdateMimfStampignMatrix()
                })
            })
        </script>
    @endsection
@endauth

@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Material Process')
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
                            <h1>Second Molding</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Second Molding</li>
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
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xl-3">
                                            <label class="form-label">PO Number</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Number" id="textSearchPMIPONumber">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="textSearchMaterialName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <label class="form-label">PO Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Quantity" id="textSearchPOQuantity" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xl-3">
                                            <label class="form-label">Target Output<small>(with allowance)</small></label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" id="textRequiredOutput" name="required_output" placeholder="Auto generated" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Second Molding</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="buttonAddSecondMolding"><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tableSecondMolding" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Device Name</th>
                                                    <th>Parts Code</th>
                                                    <th>PMI PO Number</th>
                                                    <th>Production Lot #</th>
                                                    <th>Material Name</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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

        <!-- MODALS -->
        <div class="modal fade" id="modalSecondMolding" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info-circle text-info"></i> Second Molding Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formSecondMolding" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textSecondMoldingId" name="second_molding_id">
                            <div class="row">
                                <div class="col-sm-5 border px-4">
                                    <div class="py-3 d-flex align-items-center">
                                        <span class="badge badge-secondary">1.</span> Second Molding Details
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device Name</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textDeviceName" name="device_name" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Parts Code</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textPartsCode" name="parts_code" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PMI PO Number</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textPMIPONumber" name="pmi_po_number" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Number</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textPONumber" name="po_number" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Quantity</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textPoQuantity" name="po_quantity" placeholder="Auto generated" readonly>
                                            </div>
                                            {{-- <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Required Output</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textRequiredOutput" name="required_output" placeholder="Auto generated" readonly>
                                            </div> --}}
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Machine #</span>
                                                </div>
                                                {{-- Added Chris For Multiple Machine--}}
                                                {{-- <input type="text" class="form-control form-control-sm" id="textMachineNumber" name="machine_number" placeholder="Machine #"> --}}
                                                <select class="form-control form-control-sm select2bs4" id="selMachineNumber" name="machine_number[]" placeholder="Machine #" multiple>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Material Lot #</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textMaterialLotNumber" name="material_lot_number" placeholder="Scan Machine Lot #" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumber" form-value="formMaterialLotNumber"><i class="fa fa-qrcode"></i></button>
                                                </div>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Material Name</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textMaterialName" readonly name="material_name" placeholder="Auto Generated">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">MATL Drawing # on Rapid</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textDrawingNumber" name="drawing_number" value="B137229-001" placeholder="Auto generated" readonly>
                                                <button style="width:30px" type="button" class="btn btn-sm py-0 btn-info table-btns" id="buttonViewBDrawing">
                                                    <i class="fa fa-file" title="View"></i>
                                                </button>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Revision # on Rapid</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="textRevisionNumber" name="revision_number" placeholder="Auto generated" readonly>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" style="width: 50%">Production Lot</span>
                                                <input type="text" class="form-control form-control-sm" style="width: 25%" id="textProductionLot" readonly name="production_lot" placeholder="Production Lot">
                                                <input type="text" class="form-control datetimepicker" style="width: 25%" id="textProductionLotTime" placeholder="07:30-04:30" name="textProductionLotTime">
                                            </div>
                                            <div>
                                                <span class="badge badge-secondary">2.</span> 
                                                <span data-bs-toggle="collapse" style="cursor: pointer" data-bs-target="#collapseScanLotNumbers" aria-expanded="false" aria-controls="collapseScanLotNumbers">
                                                    Scan Lot Numbers <i class="fas fa-angle-down"> </i>
                                                </span>
                                            </div>
                                            <div class="collapse" id="collapseScanLotNumbers">
                                                <div id="divMaterialLotNumbers">
                                                    <input type="hidden" class="form-control form-control-sm" id="textMaterialLotNumberChecking" name="material_lot_number_checking">
                                                    <div class="d-flex justify-content-end mb-3">
                                                        <button type="button" id="buttonAddLotNumber" disabled class="btn btn-sm btn-info" title="Add Lot #"><i class="fa fa-plus"></i> Add Lot #</button>
                                                    </div>
                                                    <div id="divLotNumberEightRow" row-count="1" camera-inspection-count="0">
                                                        <div class="input-group input-group-sm mb-3">
                                                            <span class="input-group-text" style="width: 30%" id="basic-addon1">CN171S-08#IN-VE - Lot #</span>
                                                            <input type="text" class="form-control form-control-sm" id="textLotNumberEight" name="lot_number_eight[]" style="width: 10%;" readonly placeholder="Lot #">
                                                            <input type="text" class="form-control form-control-sm" id="textLotNumberEightSizeCategory" name="lot_number_eight_size_category[]" style="width: 10%;" readonly placeholder="Sizing">
                                                            <input type="text" class="form-control form-control-sm" id="textLotNumberEightQuantity" name="lot_number_eight_quantity[]" style="width: 6%;" readonly placeholder="Quantity">
                                                            <input type="hidden" class="form-control form-control-sm" id="textLotNumberEightFirstMoldingId" name="lot_number_eight_first_molding_id" readonly placeholder="Lot # Id">
                                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberEight" name="formProductionLotNumberEight[]" form-value="formProductionLotNumberEight"><i class="fa fa-qrcode"></i></button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">CN171S-09#IN-VE - Lot #</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="textLotNumberNine" name="lot_number_nine" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                                        <input type="hidden" class="form-control form-control-sm" id="textLotNumberNineFirstMoldingId" name="lot_number_nine_first_molding_id" readonly placeholder="CN171S-09#IN-VE - Lot #">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberNine" form-value="formProductionLotNumberNine"><i class="fa fa-qrcode"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">CN171S-10#IN-VE - Lot #</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="textLotNumberTen" name="lot_number_ten" readonly placeholder="CN171S-08#IN-VE - Lot #">
                                                        <input type="hidden" class="form-control form-control-sm" id="textLotNumberTenFirstMoldingId" name="lot_number_ten_first_molding_id" readonly placeholder="CN171S-10#IN-VE - Lot #">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMaterialLotNumberTen" form-value="formProductionLotNumberTen"><i class="fa fa-qrcode"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="divContactLotNumbers">
                                                    <input type="hidden" class="form-control form-control-sm" id="textContactLotNumberChecking" name="contact_lot_number_checking">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">C/T Name/Lot #</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="textContactLotNumberOne" value="N/A" readonly name="contact_name_lot_number_one" placeholder="C/T Name/Lot #">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanContactLotNumberOne" form-value="formContactLotNumberOne"><i class="fa fa-qrcode"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <div class="input-group-prepend w-50">
                                                            <span class="input-group-text w-100" id="basic-addon1">C/T Name/Lot #</span>
                                                        </div>
                                                        <input type="text" class="form-control form-control-sm" id="textContactLotNumberSecond" value="N/A" readonly name="contact_name_lot_number_second" placeholder="C/T Name/Lot #">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanContactLotNumberSecond" form-value="formContactLotNumberSecond"><i class="fa fa-qrcode"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">ME Name/Lot #</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="textMELotNumberOne" value="N/A" readonly name="me_name_lot_number_one" placeholder="ME Name/Lot #">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMELotNumberOne" form-value="formMELotNumberOne"><i class="fa fa-qrcode"></i></button>
                                                    </div>
                                                </div>
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">ME Name/Lot #</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="textMELotNumberSecond" value="N/A" readonly name="me_name_lot_number_second" placeholder="ME Name/Lot #">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMELotNumberSecond" form-value="formMELotNumberSecond"><i class="fa fa-qrcode"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div data-bs-toggle="collapse" style="cursor: pointer" data-bs-target="#collapseAddShotsSamples" aria-expanded="false" aria-controls="collapseAddShotsSamples">
                                                <span class="badge badge-secondary">3.</span> Add Shots, Samples etc. <i class="fas fa-angle-down"> </i>
                                            </div>
                                            <div class="collapse" id="collapseAddShotsSamples">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">25 Shots </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm sumTotalMachineOutput" id="target_shots" name="target_shots" value="25" readonly>
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Adjustment Shots</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm sumTotalMachineOutput" id="adjustment_shots" name="adjustment_shots" min="0">
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">QC Samples</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm sumTotalMachineOutput" id="qc_samples" name="qc_samples" min="0">
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Prod Samples</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm sumTotalMachineOutput" id="prod_samples" name="prod_samples" min="0">
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">NG Count</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm sumTotalMachineOutput" readonly id="ng_count" name="ng_count" min="0">
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Shipment Output:</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm sumTotalMachineOutput" readonly id="shipment_output" name="shipment_output" min="0">
                                                </div>
        
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Total Machine Output</span>
                                                    </div>
                                                    <input type="number" class="form-control form-control-sm" id="total_machine_output" readonly name="total_machine_output" min="0">
                                                </div>
                                            
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend w-50">
                                                        <span class="input-group-text w-100" id="basic-addon1">Material Yield</span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm" id="material_yield" readonly name="material_yield" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                                <div class="input-group input-group-sm mb-3 justify-content-end align-items-center">
                                                    <button type="submit" class="btn btn-sm btn-success" id="buttonSaveSecondMoldingData"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="col border px-4">
                                        <div class="py-3 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center"><span class="badge badge-secondary">3.</span> Second Molding Stations</div>
                                            <button type="button" class="btn btn-primary btn-sm" disabled data-bs-toggle="modal" id="buttonAddStation" data-bs-target="#modalSecondMoldingStation" style="margin-bottom: 5px;">
                                                <i class="fa fa-plus" ></i> Add Station
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm small table-bordered table-hover" id="tableStation" style="width: 100%;">
                                                <thead>
                                                    <tr class="bg-light">
                                                        <th>Action</th>
                                                        <th>Station</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Input</th>
                                                        <th>NG Qty</th>
                                                        <th>Output</th>
                                                        <th>Remarks</th>
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
                                                        <th style="border-top: 1px solid #dee2e6; white-space: nowrap;">Total Count:</th>
                                                        <th style="border-top: 1px solid #dee2e6" title="Total NG Count of Station" class="text-danger"></th>
                                                        <th style="border-top: 1px solid #dee2e6" title="Total Visual Inspection" class="text-success"></th>
                                                        <th style="border-top: 1px solid #dee2e6"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="buttonSubmitSecondMolding">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="modalQrScanner" data-form-id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textQrScanner" class="hidden_scanner_input" class="" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan Material Lot #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalSecondMoldingStation" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formAddStation">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textSecondMoldingId" name="second_molding_id">
                            <input type="text" class="d-none" id="textSecondMoldingStationId" name="second_molding_station_id">
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station</span>
                                        </div>
                                        <select type="text" class="form-control form-control-sm" id="textStation" name="station" placeholder="Station">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="textDate" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                        </div>
                                        <select type="text" class="form-control form-control-sm" id="textOperatorName" name="operator_name" placeholder="Operator Name">
                                            {{-- <option value="{{ Auth::user()->id }}">{{ Auth::user()->firstname  .' '. Auth::user()->lastname }}</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text w-50" id="basic-addon1">Input</span>
                                        <input type="number" class="form-control form-control-sm w-50" id="textInputQuantity" name="input_quantity" min="0" value="0">
                                        {{-- <div class="input-group-text w-25">
                                            <input type="checkbox" id="checkPartial" value="1" name="partial" title=""><label class="form-check-label" for="checkPartial">&nbsp;Partial</label>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="textOutputQuantity" name="output_quantity" min="0" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="textNGQuantity" name="ng_quantity" readonly min="0" value="0" oninput="this.value = Math.abs(this.value)">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Yield</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="textStationYield" placeholder="0%" readonly name="station_yield" min="0" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                    </div>
                                    <textarea type="text" class="form-control form-control-sm" rows="2" id="textRemarks" name="remarks"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-between">
                                            <label>Total No. of NG: <span id="labelTotalNumberOfNG" style="color: green;">0</span></label>
                                            <button type="button" id="buttonAddModeOfDefect" disabled class="btn btn-sm btn-info" title="Add MOD"><i class="fa fa-plus"></i> Add MOD</button>
                                        </div>
                                        <br>
                                        <table class="table table-sm" id="tableSecondMoldingStationMOD">
                                            <thead>
                                                <tr>
                                                    <th style="width: 55%;">Mode of Defect</th>
                                                    <th style="width: 15%;">QTY</th>
                                                    <th style="width: 10%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="buttonSaveSecondMoldingStation"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalSecondMoldingPrintQr">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Print QR Code</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <center><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->errorCorrection('H')->generate('0')) !!}" id="imageBarcodePO" style="max-width: 200px;"><br></center>
                                <div id="bodyBarcodeDetails"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="buttonSecondMoldingPrintQrCode" class="btn btn-primary btn-sm"><i class="fa fa-print fa-xs"></i> Print</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        
    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){
                $('#textProductionLotTime').mask('00:00-00:00', {reverse: false});
                $('#textProductionLotTime').keyup(delay(function(e){
                    let textProductionLot = $('#textProductionLot').val();
                    let textProductionLotTime = $('#textProductionLotTime').val();
                    if(textProductionLotTime.length == 11){
                        let subTextProductionLot = textProductionLot.substr(0, 7);
                        let concattedProductionLot = `${subTextProductionLot}${textProductionLotTime}`;
                        $('#textProductionLot').val(concattedProductionLot)
                    }
                }, 400));
                
                let dataTablesSecondMolding, dataTablesSecondMoldingStation;
                $(document).on('keypress', '#textSearchPMIPONumber', function(e){
                    if(e.keyCode == 13){
                        getPOReceivedByPONumber($(this).val());
                        dataTablesSecondMolding.draw();
                    }
                });

                /**
                 * Validation for CN171S-07#IN-VE/CN171P-02#IN-VE/CN171S-02#MO-VE
                 * Start
                */
                $('#buttonAddSecondMolding').on('click', function(e){
                    let poNumber = $('#textSearchPMIPONumber').val();
                    let materialName = $('#textSearchMaterialName').val();
                    // let materialNameSubstring = materialName.substring(0,6);
                    
                    if(poNumber != "" && materialName != ""){
                        getMachineDropdown($('#selMachineNumber'), materialName); // Added Chris to get Data on matrix machine
                        getPOReceivedByPONumber(poNumber);
                        $('#divMaterialLotNumbers').removeClass('d-none');
                        $('#divContactLotNumbers').removeClass('d-none');
                        if(materialName == 'CN171S-07#IN-VE'){
                            // console.log('CN171S-07#IN-VE');
                            $('#divMaterialLotNumbers').removeClass('d-none');
                            $('#textMaterialLotNumberChecking').val(1);
                            $('#textDrawingNumber').val('B137229-001');
                        }else if (materialName == 'CN171P-02#IN-VE'){
                            // console.log('CN171P-02#IN-VE');
                            $('#divMaterialLotNumbers').addClass('d-none');
                            $('#textMaterialLotNumberChecking').val(2);
                            $('#textDrawingNumber').val('B137236-001');
                        }else if (materialName == 'CN171S-02#MO-VE'){
                            // console.log('CN171S-02#MO-VE');
                            $('#divMaterialLotNumbers').addClass('d-none');
                            $('#divContactLotNumbers').addClass('d-none');
                            $('#textContactLotNumberChecking').val(3);
                            $('#textDrawingNumber').val('B137232-001');
                        }
                        $('#buttonAddStation').prop('disabled', true);
                        setDisabledSecondMoldingRuncard(false);
                        $('#modalSecondMolding').modal('show');
                        dataTablesSecondMoldingStation.draw();
                        getMaterialProcessStation();
                        getDiesetDetailsByDeviceNameSecondMolding(materialName);
                    }
                    else{
                        toastr.error('Please input PO.')
                    }
                });
                /**
                 * Validation for CN171S-07#IN-VE/CN171P-02#IN-VE/CN171S-02#MO-VE
                 * End
                */

                /**
                 * View B Drawing
                 * Start
                */
                $("#buttonViewBDrawing").click(function(){
                    let docNo = $('#textDrawingNumber').val();
                    let docTitle = $('#textDeviceName').val();
                    let docType = "B Drawing";
                    $.ajax({
                        type: "GET",
                        url: "get_revision_number_based_on_drawing_number",
                        data: {
                            doc_number: docNo,
                            doc_title: docTitle,
                            doc_type: docType,
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response.length > 0){
                                $('#textRevisionNumber').val(response[0].rev_no);
                            }
                        }
                    });
                    redirectToACDCSDrawing(docNo, docTitle, docType)
                });
                /**
                 * View B Drawing
                 * End
                */

                /**
                 * QR Code Scanner
                 * Start
                */
                
                $('#buttonQrScanMaterialLotNumber, #buttonQrScanMaterialLotNumberNine, #buttonQrScanMaterialLotNumberTen, #buttonQrScanContactLotNumberOne, #buttonQrScanContactLotNumberSecond, #buttonQrScanMELotNumberOne, #buttonQrScanMELotNumberSecond').each(function(e){
                    $(this).on('click',function (e) {
                        let formValue = $(this).attr('form-value');
                        console.log('formValue ',formValue);
                        
                        $('#modalQrScanner').attr('data-form-id', formValue).modal('show');
                        $('#textQrScanner').val('');
                        setTimeout(() => {
                            $('#textQrScanner').focus();
                        }, 500);
                    });
                });

                /* For multiple lot numbers */
                let scannerRow = null;
                $("body").on("click","#buttonQrScanMaterialLotNumberEight",function(e){
                    let formValue = $(this).attr('form-value');
                    console.log('formValue ',formValue);
                    scannerRow = this;
                    
                    // for (let index = 0; index < $('button[name="formProductionLotNumberEight[]"]').length; index++) {
                    //     const size = $('input[name="lot_number_eight_size_category[]"]')[index];
                    //     const qty = $('input[name="lot_number_eight_quantity[]"]')[index];
                    //     console.log(`index: ${index} and size: ${$(size).attr('value')} qty: ${$(qty).attr('value')}`);
                    // }
                    
                    $('#modalQrScanner').attr({
                        'data-form-id':formValue,
                    }).modal('show');
                    $('#textQrScanner').val('');
                    setTimeout(() => {
                        $('#textQrScanner').focus();
                    }, 500);
                });

                $('#textQrScanner').keyup(delay(function(e){
                    let qrScannerValue = $('#textQrScanner').val();
                    let formId = $('#modalQrScanner').attr('data-form-id');
                    if( e.keyCode == 13 ){
                        $('#textQrScanner').val(''); // Clear after enter
                        switch (formId) {
                            case 'formMaterialLotNumber':
                                checkMaterialLotNumber(qrScannerValue);
                                break;
                            case 'formProductionLotNumberEight':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberEight', scannerRow);
                                break;
                            case 'formProductionLotNumberNine':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberNine');
                                break;
                            case 'formProductionLotNumberTen':
                                checkProductionLotNumberOfFirstMolding(qrScannerValue, 'formProductionLotNumberTen');
                                break;
                            case 'formContactLotNumberOne':
                                if(qrScannerValue != ''){
                                    $('#textContactLotNumberOne').val(qrScannerValue);
                                }else{
                                    $('#textContactLotNumberOne').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formContactLotNumberSecond':
                                if(qrScannerValue != ''){
                                    $('#textContactLotNumberSecond').val(qrScannerValue);
                                }else{
                                    $('#textContactLotNumberSecond').val('N/A');
                                    toastr.error('Please scan Contact lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberOne':
                                if(qrScannerValue != ''){
                                    $('#textMELotNumberOne').val(qrScannerValue);
                                }else{
                                    $('#textMELotNumberOne').val('N/A');
                                    toastr.error('Please scan ME lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            case 'formMELotNumberSecond':
                                if(qrScannerValue != ''){
                                    $('#textMELotNumberSecond').val(qrScannerValue);
                                }else{
                                    $('#textMELotNumberSecond').val('N/A');
                                    toastr.error('Please scan ME lot number.')
                                }
                                $('#modalQrScanner').modal('hide');
                                break;
                            default:
                                break;
                        }

                    }
                }, 100));
                /**
                 * QR Code Scanner
                 * End
                */

                /**
                 * DataTables of Second Molding
                 * Start
                */
                dataTablesSecondMolding = $("#tableSecondMolding").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_second_molding",
                        data: function (param){
                            param.pmi_po_number = $("#textSearchPMIPONumber").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "device_name" },
                        { "data" : "parts_code" },
                        { "data" : "pmi_po_number" },
                        { "data" : "production_lot" },
                        { "data" : "material_name" },
                    ],
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"},
                        {
                            "targets": [2],
                            "data": null,
                            "defaultContent": "---"
                        },
                    ],
                });
                /**
                 * DataTables of Second Molding
                 * End
                */

                /**
                 * Form of Second Molding to be use in Insert
                 * Start
                */
                $('#formSecondMolding').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    console.log(`response ${response['second_molding_id']}`);
                                    toastr.success('Successfully saved');
                                    dataTablesSecondMolding.draw();
                                    getSecondMoldingById(response['second_molding_id']);
                                }else if(response['sessionError']){
                                    toastr.error('Session Expired. Please re-login again.');
                                }else{
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

                                if(response['error']['parts_code'] === undefined){
                                    isResponseError('textPartsCode', false);
                                }
                                else{
                                    isResponseError('textPartsCode', true);
                                }

                                if(response['error']['pmi_po_number'] === undefined){
                                    isResponseError('textPMIPONumber', false);
                                }
                                else{
                                    isResponseError('textPONumber', true);
                                }

                                if(response['error']['po_number'] === undefined){
                                    isResponseError('textPONumber', false);
                                }
                                else{
                                    isResponseError('textPONumber', true);
                                }

                                if(response['error']['po_quantity'] === undefined){
                                    isResponseError('textPoQuantity', false);
                                }
                                else{
                                    isResponseError('textPoQuantity', true);
                                }
                                if(response['error']['required_output'] === undefined){
                                    isResponseError('textRequiredOutput', false);
                                }
                                else{
                                    isResponseError('textRequiredOutput', true);
                                }

                                if(response['error']['machine_number'] === undefined){
                                    isResponseError('textMachineNumber', false);
                                }
                                else{
                                    isResponseError('textMachineNumber', true);
                                }

                                if(response['error']['material_lot_number'] === undefined){
                                    isResponseError('textMaterialLotNumber', false);
                                }
                                else{
                                    isResponseError('textMaterialLotNumber', true);
                                }

                                if(response['error']['material_name'] === undefined){
                                    isResponseError('textMaterialName', false);
                                }
                                else{
                                    isResponseError('textMaterialName', true);
                                }

                                if(response['error']['drawing_number'] === undefined){
                                    isResponseError('textDrawingNumber', false);
                                }
                                else{
                                    isResponseError('textDrawingNumber', true);
                                }

                                if(response['error']['revision_number'] === undefined){
                                    isResponseError('textRevisionNumber', false);
                                }
                                else{
                                    isResponseError('textRevisionNumber', true);
                                }

                                if(response['error']['production_lot'] === undefined){
                                    isResponseError('textProductionLot', false);
                                }
                                else{
                                    isResponseError('textProductionLot', true);
                                }

                                if(response['error']['lot_number_eight'] === undefined){
                                    isResponseError('textLotNumberEight', false);
                                }
                                else{
                                    isResponseError('textLotNumberEight', true);
                                }
                                if(response['error']['lot_number_nine'] === undefined){
                                    isResponseError('textLotNumberNine', false);
                                }
                                else{
                                    isResponseError('textLotNumberNine', true);
                                }
                                if(response['error']['lot_number_ten'] === undefined){
                                    isResponseError('textLotNumberTen', false);
                                }
                                else{
                                    isResponseError('textLotNumberTen', true);
                                }
                                if(response['error']['contact_name_lot_number_one'] === undefined){
                                    isResponseError('textContactLotNumberOne', false);
                                }
                                else{
                                    isResponseError('textContactLotNumberOne', true);
                                }
                                if(response['error']['contact_name_lot_number_second'] === undefined){
                                    isResponseError('textContactLotNumberSecond', false);
                                }
                                else{
                                    isResponseError('textContactLotNumberSecond', true);
                                }
                                if(response['error']['me_name_lot_number_one'] === undefined){
                                    isResponseError('textMELotNumberOne', false);
                                }
                                else{
                                    isResponseError('textMELotNumberOne', true);
                                }
                                if(response['error']['me_name_lot_number_second'] === undefined){
                                    isResponseError('textMELotNumberSecond', false);
                                }
                                else{
                                    isResponseError('textMELotNumberSecond', true);
                                }
                            }
                        }
                    });
                });
                resetFormValuesOnModalClose('modalSecondMolding', 'formSecondMolding');
                /**
                 * Form of Second Molding to be use in Insert
                 * End
                */

                /**
                 * Get Second Molding Data to be use in Edit
                 * Start
                */
                function getSecondMoldingById(id, forEdit=false){
                    $.ajax({
                        type: "get",
                        url: "get_second_molding_by_id",
                        data: {
                            second_molding_id: id,
                        },
                        dataType: "json",
                        success: function (response) {
                            let responseData = response['data'];
                            if(response['data'].length > 0){
                                /* For multiple lot numbers */
                                if(forEdit){
                                    let arrayLotNumberEight = responseData[0].lot_number_eight.split(", ");
                                    let arrayLotNumberEightQuantity = responseData[0].lot_number_eight_quantity.split(", ");
                                    let arrayLotNumberEightCategory = responseData[0].lot_number_eight_size_category.split(", ");
                                    console.log('arrayLotNumberEight ', arrayLotNumberEight);
                                    console.log('arrayLotNumberEightQuantity ', arrayLotNumberEightQuantity);
                                    console.log('arrayLotNumberEightCategory ', arrayLotNumberEightCategory);

                                    $('#divLotNumberEightRow').attr('row-count', arrayLotNumberEight.length);
                                    $('#divLotNumberEightRow').attr('camera-inspection-count', arrayLotNumberEight.length);
                                    for (let i = 0; i < arrayLotNumberEight.length; i++) {
                                        if(i == 0){
                                            console.log(`i ${i}`);
                                            $('#divLotNumberEightRow').closest('div').find('input[name="lot_number_eight_first_molding_id"').val(responseData[0].lot_number_eight_first_molding_id)
                                            $('#divLotNumberEightRow').closest('div').find('input[name="lot_number_eight[]"').val(arrayLotNumberEight[i])
                                            $('#divLotNumberEightRow').closest('div').find('input[name="lot_number_eight_size_category[]"').val(arrayLotNumberEightCategory[i])
                                            $('#divLotNumberEightRow').closest('div').find('input[name="lot_number_eight_quantity[]"').val(arrayLotNumberEightQuantity[i])
                                        }else{
                                            console.log(`i ${i}`);
                                            let rowAddLotNumber = `
                                                <div class="input-group input-group-sm mb-3">
                                                    <span class="input-group-text" style="width: 30%" id="basic-addon1">CN171S-08#IN-VE - Lot #</span>
                                                    <input type="text" class="form-control form-control-sm" id="textLotNumberEight" name="lot_number_eight[]" value="${arrayLotNumberEight[i]}" style="width: 10%;" readonly placeholder="Lot #">
                                                    <input type="text" class="form-control form-control-sm" id="textLotNumberEightSizeCategory" name="lot_number_eight_size_category[]" value="${arrayLotNumberEightCategory[i]}" style="width: 10%;" readonly placeholder="Sizing">
                                                    <input type="text" class="form-control form-control-sm" id="textLotNumberEightQuantity" name="lot_number_eight_quantity[]" value="${arrayLotNumberEightQuantity[i]}" readonly placeholder="Quantity">
                                                    <input type="hidden" class="form-control form-control-sm" id="textLotNumberEightFirstMoldingId" name="lot_number_eight_first_molding_id" value="${responseData[0].lot_number_eight_first_molding_id}" readonly placeholder="Lot #">
                                                    <button class="btn btn-xs btn-danger buttonRemoveLotNumber" title="Remove" type="button"><i class="fa fa-times"></i></button>
                                                    <button class="btn btn-info" 
                                                        type="button" title="Scan code" 
                                                        id="buttonQrScanMaterialLotNumberEight" 
                                                        form-value="formProductionLotNumberEight"
                                                        name="formProductionLotNumberEight[]">
                                                        <i class="fa fa-qrcode"></i>
                                                    </button>
                                                </div>
                                            `;
                                            $("#divLotNumberEightRow").append(rowAddLotNumber);
                                        }
                                    }

                                    /**
                                     * Validation for Add Lot #(button)
                                     */
                                    rowCounter = parseInt($('#divLotNumberEightRow').attr('row-count'));
                                    console.log('rowCounter ', rowCounter);
                                    let cameraInspectionCount = parseInt($('#divLotNumberEightRow').attr('camera-inspection-count'));
                                    if(cameraInspectionCount != 0){
                                        if(rowCounter == cameraInspectionCount){
                                            $('#buttonAddLotNumber').prop('disabled', true);
                                        }else{
                                            $('#buttonAddLotNumber').prop('disabled', false);
                                        }
                                    }
                                }
                                
                                $('#textSecondMoldingId', $('#formSecondMolding')).val(responseData[0].id);
                                $('#textDeviceName', $('#formSecondMolding')).val(responseData[0].device_name);
                                $('#textPartsCode', $('#formSecondMolding')).val(responseData[0].parts_code);
                                $('#textPMIPONumber', $('#formSecondMolding')).val(responseData[0].pmi_po_number);
                                $('#textPONumber', $('#formSecondMolding')).val(responseData[0].po_number);
                                $('#textPoQuantity', $('#formSecondMolding')).val(responseData[0].po_quantity);
                                $('#textRequiredOutput', $('#formSecondMolding')).val(responseData[0].required_output);
                                let arrayMachine = responseData[0].machine_number.split(" , "); // Added by Chris
                                $('select[name="machine_number[]"]').val(arrayMachine).trigger('change') // Added by Chris
                                $('#textMaterialLotNumber', $('#formSecondMolding')).val(responseData[0].material_lot_number);
                                $('#textMaterialName', $('#formSecondMolding')).val(responseData[0].material_name);
                                $('#textDrawingNumber', $('#formSecondMolding')).val(responseData[0].drawing_number);
                                $('#textRevisionNumber', $('#formSecondMolding')).val(responseData[0].revision_number);
                                let textProductionLot = responseData[0].production_lot;
                                $('#textProductionLot', $('#formSecondMolding')).val(textProductionLot);
                                let subTextProductionLotTime = textProductionLot.substr(-11);
                                $('#textProductionLotTime', $('#formSecondMolding')).val(subTextProductionLotTime);
                                
                                // $('#textLotNumberEight', $('#formSecondMolding')).val(responseData[0].lot_number_eight);
                                $('#textLotNumberEightFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_eight_first_molding_id);
                                $('#textLotNumberNine', $('#formSecondMolding')).val(responseData[0].lot_number_nine);
                                $('#textLotNumberNineFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_nine_first_molding_id);
                                $('#textLotNumberTen', $('#formSecondMolding')).val(responseData[0].lot_number_ten);
                                $('#textLotNumberTenFirstMoldingId', $('#formSecondMolding')).val(responseData[0].lot_number_ten_first_molding_id);
                                $('#textContactLotNumberOne', $('#formSecondMolding')).val(responseData[0].contact_name_lot_number_one);
                                $('#textContactLotNumberSecond', $('#formSecondMolding')).val(responseData[0].contact_name_lot_number_second);
                                $('#textMELotNumberOne', $('#formSecondMolding')).val(responseData[0].me_name_lot_number_one);
                                $('#textMELotNumberSecond', $('#formSecondMolding')).val(responseData[0].me_name_lot_number_second);

                                $('#target_shots', $('#formSecondMolding')).val(responseData[0].target_shots);
                                $('#adjustment_shots', $('#formSecondMolding')).val(responseData[0].adjustment_shots);
                                $('#qc_samples', $('#formSecondMolding')).val(responseData[0].qc_samples);
                                $('#prod_samples', $('#formSecondMolding')).val(responseData[0].prod_samples);
                                $('#total_machine_output', $('#formSecondMolding')).val(responseData[0].total_machine_output);
                                $('#ng_count', $('#formSecondMolding')).val(responseData[0].ng_count);
                                $('#ng_count', $('#formSecondMolding')).css({'color': 'red', 'font-weight': 'bold'});
                                $('#shipment_output', $('#formSecondMolding')).val(responseData[0].shipment_output);
                                $('#shipment_output', $('#formSecondMolding')).css({'color': 'green', 'font-weight': 'bold'});
                                responseData[0].material_yield != null ? $('#material_yield', $('#formSecondMolding')).val(`${responseData[0].material_yield}%`) : '';

                                dataTablesSecondMoldingStation.draw();
                                $('#buttonAddStation').prop('disabled', false);
                            }
                        }
                    });
                }
                /**
                 * Get Second Molding Data to be use in Edit
                 * End
                */

                /**
                 * Edit of Second Molding to be use in Update
                 * Start
                */
                let id;
                $("#tableSecondMolding").on('click', '.actionEditSecondMolding', function(){
                    id = $(this).attr('second-molding-id');
                    let materialName = $('#textSearchMaterialName').val();
                    console.log(`actionEditSecondMolding id ${id}`)
                    setDisabledSecondMoldingRuncard(false);
                    getMachineDropdown($('#selMachineNumber'), materialName);
                    getSecondMoldingById(id, true);
                    getMaterialProcessStation();
                    $('#buttonAddStation').prop('disabled', false);
                });

                $("#tableSecondMolding").on('click', '.actionViewSecondMolding', function(){
                    id = $(this).attr('second-molding-id');
                    let materialName = $('#textSearchMaterialName').val();
                    console.log(`actionViewSecondMolding id ${id}`)
                    getMachineDropdown($('#selMachineNumber'), materialName);
                    getSecondMoldingById(id, true);
                    setDisabledSecondMoldingRuncard(true);
                    getMaterialProcessStation();
                    $('#buttonAddStation').prop('disabled', true);
                });
                /**
                 * Edit of Second Molding to be use in Update
                 * End
                */

                /**
                 * DataTables of Second Molding Station
                 * Start
                */
                dataTablesSecondMoldingStation = $("#tableStation").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_second_molding_station",
                        data: function (param){
                            param.sec_molding_runcard_id = $('#textSecondMoldingId', $('#formSecondMolding')).val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "station_name" },
                        { "data" : "date" },
                        { "data" : "concatted_operator_name",},
                        { "data" : "input_quantity" },
                        { "data" : "ng_quantity" },
                        { "data" : "output_quantity" },
                        { "data" : "remarks" },
                    ],
                    footerCallback: function (row, data, start, end, display) {
                        let api = this.api();

                        let countNGQuantity = 0;
                        let countVisualInspectionQuantity = 0;
                        if(data.length > 0){
                            for (let index = 0; index < data.length; index++) {
                                countNGQuantity += parseInt(data[index].ng_quantity);
                                if(data[index].station_name == "Visual Inspection"){
                                    countVisualInspectionQuantity += parseInt(data[index].output_quantity);
                                }
                            }
                        }
                        // console.log('countNGQuantity ', countNGQuantity);
                        $(api.column(5).footer()).html(`${countNGQuantity}`)
                        $(api.column(6).footer()).html(`${countVisualInspectionQuantity}`)
                    }

                });
                /**
                 * DataTables of Second Molding Station
                 * End
                */

                /**
                 * Get Id of Second Molding after click 
                 * to be use in Second Molding Station
                 * Start
                */
                $('#checkPartial').on('change',function (e) { 
                    if($('#checkPartial').is(':checked')){
                        console.log('checked');
                        $('#textInputQuantity', $('#formAddStation')).prop('readonly', false);
                    }else{
                        console.log('not checked');
                        $('#textInputQuantity', $('#formAddStation')).prop('readonly', true);
                    }
                });
                
                getUser($('#textOperatorName'));
                $('#buttonAddStation').click(function(){
                    let secondMoldingId = $('#textSecondMoldingId', $('#formSecondMolding')).val();
                    $('#textSecondMoldingId', $('#formAddStation')).val(secondMoldingId);
                    $('#labelTotalNumberOfNG', $('#formAddStation')).text(0);
                    $('#labelTotalNumberOfNG', $('#formAddStation')).val(0);
                    /* Get last shipment output for the input of next process*/
                    $.ajax({
                        type: "get",
                        url: "get_last_shipment_output",
                        data: {
                            second_molding_id: secondMoldingId
                        },
                        dataType: "json",
                        success: function (response) {
                            if(response['getShipmentOuputOfVisualInspection'].length > 0){
                                console.log('object 1 ', response['getShipmentOuputOfVisualInspection'][0].output_quantity);
                                $('#textInputQuantity', $('#formAddStation')).val(response['getShipmentOuputOfVisualInspection'][0].output_quantity).trigger('keyup');
                            }else{
                                if(response['data'].length > 0){
                                    console.log('object 2 ', response['data'][0].station);
                                    $('#textInputQuantity', $('#formAddStation')).val(response['data'][0].output_quantity).trigger('keyup');
                                    if(response['data'].length == 2){
                                        $('#textInputQuantity', $('#formAddStation')).prop('readonly', false);
                                    }else{
                                        $('#textInputQuantity', $('#formAddStation')).prop('readonly', true);
                                    }
                                }
                            }
                            

                            
                        }
                    });
                });
                /**
                 * Get Id of Second Molding after click 
                 * to be use in Second Molding Station
                 * End
                */

                /**
                 * Form of Second Molding Station to be use in Insert
                 * Start
                */
                $('#formAddStation').submit(function (e) {
                    e.preventDefault();
                    let data = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding_station",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            if(!response.validationHasError){
                                if(!response.hasError){
                                    toastr.success('Successfully saved');
                                    getSecondMoldingById(response['second_molding_id'], true);
                                    dataTablesSecondMoldingStation.draw();
                                    $('#modalSecondMoldingStation').modal('hide');
                                }else if(response['checkIfStationExist']){
                                    toastr.warning('Station already exist!');
                                }else if(response['stationOutputQuantityIsHigher']){
                                    toastr.warning('Station input quantity is higher than the last');
                                }
                                else if(response['sessionError']){
                                    toastr.error('Session Expired. Please re-login again.');
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
                /**
                 * Form of Second Molding Station to be use in Insert
                 * End
                */

                /**
                 * Auto compute NG Quantity onkeyup
                 * Start
                */
                $("#textOutputQuantity").keyup(function(){
                    let inputQuantity = parseInt($("#textInputQuantity").val());
                    let outputQuantity = parseInt($('#textOutputQuantity').val());
                    let totalNGQuantity = Math.abs(inputQuantity - outputQuantity);
                    /* Set NG Quantity */
                    if(isNaN(totalNGQuantity)){
                        $("#textNGQuantity").val(inputQuantity);
                    }else{
                        $("#textNGQuantity").val(totalNGQuantity);
                    }

                    /* Enable/Disable of Add MOD(button) */
                    if(parseInt($("#textNGQuantity").val()) > 0){
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }
                    else{
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }

                    /**
                     * Set label for Total No. of NG and
                     * Enable/Disable of Save(button) for Second Molding Station
                    */
                    if(parseInt($('#textNGQuantity').val()) !== parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                    }

                    /* Computation of Station Yield */
                    let stationYieldPercentage = parseFloat(outputQuantity / inputQuantity * 100);
                    if(isNaN(stationYieldPercentage)){
                        $("#textStationYield").val(`${0}%`);
                    }else{
                        $("#textStationYield").val(`${stationYieldPercentage.toFixed(2)}%`);
                    }
                }); 
                
                $("#textInputQuantity").keyup(function(){
                    let inputQuantity = parseInt($("#textInputQuantity").val());
                    let outputQuantity = parseInt($('#textOutputQuantity').val());
                    let totalNGQuantity = Math.abs(outputQuantity - inputQuantity);
                    /* Set NG Quantity */
                    if(isNaN(totalNGQuantity)){
                        $("#textNGQuantity").val(0);
                    }else{
                        $("#textNGQuantity").val(totalNGQuantity);
                    }

                    /* Enable/Disable of Add MOD(button) */
                    if(parseInt($("#textNGQuantity").val()) > 0){
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }
                    else{
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }

                    /**
                     * Set label for Total No. of NG and
                     * Enable/Disable of Save(button) for Second Molding Station
                    */
                    if(parseInt($('#textNGQuantity').val()) !== parseInt($('#labelTotalNumberOfNG').text())){
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                    }

                    /* Computation of Station Yield */
                    let stationYieldPercentage = parseFloat(outputQuantity / inputQuantity * 100);
                    if(isNaN(stationYieldPercentage)){
                        $("#textStationYield").val(`${0}%`);
                    }else{
                        $("#textStationYield").val(`${stationYieldPercentage.toFixed(2)}%`);
                    }
                });

                $("#tableSecondMoldingStationMOD").each(function(){
                    $(this).on('keyup', '.textMODQuantity', function(){
                        let totalNumberOfMOD = 0;
                        if($(this).val() == null || $(this).val() == ''){
                            $("#labelTotalNumberOfNG").css({color: 'red'});
                            $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                            // $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                        }else{
                            $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                                if($(this).val() != null || $(this).val() != ""){
                                    totalNumberOfMOD += parseFloat($(this).val());
                                }
                            });

                            if($("#textNGQuantity").val() != totalNumberOfMOD){
                                toastr.warning('Quantity of NG defect not tally!');
                                $("#labelTotalNumberOfNG").css({color: 'red'});
                                $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                            }
                            else{
                                $("#labelTotalNumberOfNG").css({color: 'green'});
                                $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                            }
                        }
                        $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                    })
                    
                });
                /**
                 * Auto compute NG Quantity onkeyup
                 * End
                */

                /**
                 * Add/Remove Mode Of Defect
                 * Start
                */
                $("#buttonAddModeOfDefect").click(function(){
                    let rowModeOfDefect = `
                        <tr>
                            <td>
                                <select class="form-control select2 select2bs5 selectMOD" name="mod_id[]">
                                    <option value="0">N/A</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="1" min="1">
                            </td>
                            <td>
                                <center><button class="btn btn-xs btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                            </td>
                        </tr>
                    `;
                    $("#tableSecondMoldingStationMOD tbody").append(rowModeOfDefect);
                    $('.select2bs5').select2({
                        theme: 'bootstrap-5'
                    });
                    getModeOfDefectForSecondMolding($("#tableSecondMoldingStationMOD tr:last").find('.selectMOD'));

                    let totalNumberOfMOD = 0;
                    $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                        if($(this).val() !== null || $(this).val() !== ""){
                            totalNumberOfMOD += parseInt($(this).val());
                        }
                    });

                    if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                        // toastr.warning('Mode of Defect NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }
                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                });

                $("#tableSecondMoldingStationMOD").on('click', '.buttonRemoveMOD', function(){
                    $(this).closest ('tr').remove();
                    let totalNumberOfMOD = 0;

                    $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                        if($(this).val() !== null || $(this).val() !== ""){
                            totalNumberOfMOD += parseInt($(this).val());
                        }
                    });

                    if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                        console.log('Mode of Defect NG Qty not tally!');
                        $('#labelTotalNumberOfNG').css({color: 'red'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                        $("#buttonAddModeOfDefect").prop('disabled', false);
                    }else{
                        $('#labelTotalNumberOfNG').css({color: 'green'})
                        $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                        $("#buttonAddModeOfDefect").prop('disabled', true);
                    }
                    $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                });
                /**
                 * Add/Remove Mode Of Defect
                 * End
                */ 

                /**
                 * Get Second Molding Data to be use in Edit
                 * Start
                */
                function getSecondMoldingStationById(id){
                    $.ajax({
                        type: "get",
                        async: false,
                        url: "get_second_molding_station_by_id",
                        data: {
                            second_molding_station_id: id,
                        },
                        dataType: "json",
                        success: function (response) {
                            let responseData = response['data'];
                            console.log('laravel relationship like ',responseData);
                            if(response['data'].length > 0){
                                $('#textSecondMoldingStationId', $('#formAddStation')).val(responseData[0].id); // Id from sec_molding_runcards(table)
                                $('#textSecondMoldingId', $('#formAddStation')).val(responseData[0].sec_molding_runcard_id); // Id from sec_molding_runcards(table)
                                $('#textStation', $('#formAddStation')).val(responseData[0].station).trigger('change');
                                $('#textDate', $('#formAddStation')).val(responseData[0].date);
                                $('#textInputQuantity', $('#formAddStation')).val(responseData[0].input_quantity);
                                $('#textOutputQuantity', $('#formAddStation')).val(responseData[0].output_quantity);
                                $('#textNGQuantity', $('#formAddStation')).val(responseData[0].ng_quantity);
                                $('#textStationYield', $('#formAddStation')).val(responseData[0].station_yield);
                                $('#textRemarks', $('#formAddStation')).val(responseData[0].remarks);
                                let rowModeOfDefect = '';
                                if(responseData[0].sec_molding_runcard_station_mod_id != null){
                                    for (let i = 0; i < response['data'].length; i++) {
                                        rowModeOfDefect = `
                                            <tr>
                                                <td>
                                                    <select class="form-control select2 select2bs5 selectMOD" name="mod_id[]">
                                                        <option value="0">N/A</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control textMODQuantity" name="mod_quantity[]" value="${response['data'][i]['mod_quantity']}" min="1">
                                                </td>
                                                <td>
                                                    <center><button class="btn btn-xs btn-danger buttonRemoveMOD" title="Remove" type="button"><i class="fa fa-times"></i></button></center>
                                                </td>
                                            </tr>
                                        `;
                                        $("#tableSecondMoldingStationMOD tbody").append(rowModeOfDefect);
                                        $('.select2bs5').select2({
                                            theme: 'bootstrap-5'
                                        });
                                        getModeOfDefectForSecondMolding($("#tableSecondMoldingStationMOD tr:last").find('.selectMOD'), response['data'][i]['mod_id']);

                                        let totalNumberOfMOD = 0;
                                        $('#tableSecondMoldingStationMOD .textMODQuantity').each(function() {
                                            if($(this).val() !== null || $(this).val() !== ""){
                                                totalNumberOfMOD += parseInt($(this).val());
                                            }
                                        });

                                        if(parseInt($('#textNGQuantity').val()) !== totalNumberOfMOD){
                                            // toastr.warning('Mode of Defect NG Qty not tally!');
                                            $('#labelTotalNumberOfNG').css({color: 'red'})
                                            $("#buttonSaveSecondMoldingStation").prop('disabled', true);
                                            $("#buttonAddModeOfDefect").prop('disabled', false);
                                        }else{
                                            $('#labelTotalNumberOfNG').css({color: 'green'})
                                            $("#buttonSaveSecondMoldingStation").prop('disabled', false);
                                            $("#buttonAddModeOfDefect").prop('disabled', true);
                                        }
                                        $("#labelTotalNumberOfNG").text(totalNumberOfMOD);
                                    }
                                }
                            }
                        }
                    });
                }
                /**
                 * Get Second Molding Data to be use in Edit
                 * End
                */
                
                /**
                 * Edit of Second Molding Station to be use in Update
                 * Start
                */
                let secondMoldingStationId;
                $("#tableStation").on('click', '.actionEditSecondMoldingStation', function(){
                    secondMoldingStationId = $(this).attr('second-molding-station-id');
                    getMaterialProcessStation();
                    getSecondMoldingStationById(secondMoldingStationId);
                });

                $("#tableStation").on('click', '.actionViewSecondMoldingStation', function(){
                    secondMoldingStationId = $(this).attr('second-molding-station-id');
                    getMaterialProcessStation();
                    getSecondMoldingStationById(secondMoldingStationId);
                    $('#textStation').prop('disabled', true);
                    $('#textDate').prop('disabled', true);
                    $('#textOperatorName').prop('disabled', true);
                    $('#textInputQuantity').prop('disabled', true);
                    $('#textOutputQuantity').prop('disabled', true);
                    $('#textRemarks').prop('disabled', true);
                    $('#buttonAddModeOfDefect').prop('disabled', true);
                    $('#buttonSaveSecondMoldingStation').prop('disabled', true);

                    $('#tableSecondMoldingStationMOD .buttonRemoveMOD, .textMODQuantity, .selectMOD').each(function() {
                        $(this).prop('disabled', true);
                    });
                });
                /**
                 * Edit of Second Molding Station to be use in Update
                 * End
                */

                /**
                 * Complete Second Molding for Assembly
                 * Start
                */
                $('#buttonSubmitSecondMolding').click(function(){
                    console.log(`buttonSubmitSecondMolding clicked`);
                    $.ajax({
                        type: "POST",
                        url: "complete_second_molding",
                        data: {
                            'second_molding_id': $('#textSecondMoldingId').val(),
                            "_token": "{{ csrf_token() }}",
                        },
                        dataType: "json",
                        success: function (response) {
                            if(!response.hasError){
                                toastr.success('Successfully saved');
                                dataTablesSecondMolding.draw();
                                $('#modalSecondMolding').modal('hide');
                            }
                        }
                    });
                });
                /**
                 * Complete Second Molding for Assembly
                 * End
                */

                /**
                 * Print QR Code for Assembly
                 * Start
                */
                $('#tableSecondMolding').on('click', '.buttonPrintSecondMolding',function(e){
                    e.preventDefault();
                    let secondMoldingId = $(this).attr('second-molding-id');
                    console.log('buttonPrintSecondMolding clicked');
                    $.ajax({
                        type: "get",
                        url: "get_second_molding_qr_code",
                        data: {
                            "second_molding_id" : secondMoldingId
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            $("#imageBarcodePO").attr('src', response['qr_code']);
                            $("#bodyBarcodeDetails").html(response['label']);
                            img_barcode_PO_text_hidden = response['label_hidden'];
                            $('#modalSecondMoldingPrintQr').modal('show');
                        }
                    });
                });

                $('#buttonSecondMoldingPrintQrCode').on('click', function(){
                    popup = window.open();
                    let content = '';
                    content += '<html>';
                    content += '<head>';
                    content += '<title></title>';
                    content += '<style type="text/css">';
                    content += '@media print { .pagebreak { page-break-before: always; } }';
                    content += '</style>';
                    content += '</head>';
                    content += '<body>';
                    content += '<table style="margin-left: -5px; margin-top: 18px;">';
                        content += '<tr style="width: 290px;">';
                            content += '<td style="vertical-align: bottom;">';
                                content += '<img src="' + img_barcode_PO_text_hidden[0]['img'] + '" style="min-width: 75px; max-width: 75px;">';
                            content += '</td>';
                            content += '<td style="font-size: 10px; font-family: Calibri;">' + img_barcode_PO_text_hidden[0]['text'] + '</td>';
                        content += '</tr>';
                    content += '</table>';
                    content += '<br>';
                    content += '</body>';
                    content += '</html>';
                    popup.document.write(content);
                    popup.focus(); //required for IE
                    popup.print();
                    popup.close();
                });
                /**
                 * Print QR Code for Assembly
                 * End
                */

                $("#buttonAddLotNumber").click(function(){
                    let rowCounter = parseInt($('body').find($('#divLotNumberEightRow')).attr('row-count'));
                    rowCounter ++;
                    $('body').find($('#divLotNumberEightRow')).attr('row-count', rowCounter)
                    let rowAddLotNumber = `
                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" style="width: 30%" id="basic-addon1">CN171S-08#IN-VE - Lot #</span>
                            <input type="text" class="form-control form-control-sm" id="textLotNumberEight" name="lot_number_eight[]" style="width: 10%;" readonly placeholder="Lot #">
                            <input type="text" class="form-control form-control-sm" id="textLotNumberEightSizeCategory" name="lot_number_eight_size_category[]" style="width: 10%;" readonly placeholder="Sizing">
                            <input type="text" class="form-control form-control-sm" id="textLotNumberEightQuantity" name="lot_number_eight_quantity[]" value="0" readonly placeholder="Quantity">
                            <input type="hidden" class="form-control form-control-sm" id="textLotNumberEightFirstMoldingId" name="lot_number_eight_first_molding_id" readonly placeholder="Lot #">
                            <button class="btn btn-xs btn-danger buttonRemoveLotNumber" title="Remove" type="button"><i class="fa fa-times"></i></button>
                            <button class="btn btn-info" 
                                type="button" title="Scan code" 
                                id="buttonQrScanMaterialLotNumberEight" 
                                form-value="formProductionLotNumberEight"
                                name="formProductionLotNumberEight[]">
                                <i class="fa fa-qrcode"></i>
                            </button>
                        </div>
                    `;
                    $("#divLotNumberEightRow").append(rowAddLotNumber);

                    /**
                     * Validation for Add Lot #(button)
                     */
                    let cameraInspectionCount = parseInt($('#divLotNumberEightRow').attr('camera-inspection-count'));
                    if(cameraInspectionCount != 0){
                        if(rowCounter == cameraInspectionCount){
                            $('#buttonAddLotNumber').prop('disabled', true);
                        }else{
                            $('#buttonAddLotNumber').prop('disabled', false);
                        }
                    }
                });

                $("#divLotNumberEightRow").on('click', '.buttonRemoveLotNumber', function(){
                    let rowCounter = parseInt($('body').find($('#divLotNumberEightRow')).attr('row-count'));
                    rowCounter --;
                    $('body').find($('#divLotNumberEightRow')).attr('row-count', rowCounter)
                    $(this).closest ('div').remove();

                    /**
                     * Validation for Add Lot #(button)
                     */
                    let cameraInspectionCount = parseInt($('#divLotNumberEightRow').attr('camera-inspection-count'));
                    if(cameraInspectionCount != 0){
                        if(rowCounter == cameraInspectionCount){
                            $('#buttonAddLotNumber').prop('disabled', true);
                        }else{
                            $('#buttonAddLotNumber').prop('disabled', false);
                        }
                    }
                });
                
            });
        </script>
    @endsection
@endauth

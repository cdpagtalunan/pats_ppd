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
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Number</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Number" id="textSearchPONumber">
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Material Name</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Material Name" id="textSearchMaterialName" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">PO Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="PO Quantity" id="textSearchPOQuantity" readonly>
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
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Production</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="buttonAddSecondMoldingData"><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tblProd" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>PO Number</th>
                                                    <th>Production Lot No.</th>
                                                    <th>Parts Code</th>
                                                    <th>Material Name</th>
                                                    <th>PO Quantity</th>
                                                    <th>Shipment Output</th>
                                                    <th>Material Lot #</th>
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
        <div class="modal fade" id="modalSecondMoldingData" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Data</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formSecondMolding" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" id="textSecondMoldingDataId" name="id">
                            <div class="row">
                                <div class="col-sm-4 border px-4">
                                    <div class="py-3">
                                        <span class="badge badge-secondary">1.</span> Runcard Details
                                    </div>
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
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Machine #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMachineNumber" name="machine_number" placeholder="Machine #">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Machine Lot #</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMachineLotNumber" name="machine_lot_number" placeholder="Scan Machine Lot #" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="button" title="Scan code" id="buttonQrScanMachineLotNumber"><i class="fa fa-qrcode"></i></button>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Machine Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textMachineName" name="machine_name" placeholder="Auto Generated" readonly>
                                        <div class="input-group-append">
                                        </div>
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
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Production Lot</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="textProductionLot" name="production_lot" placeholder="Production Lot">
                                    </div>
                                    <div class="input-group input-group-sm mb-3 justify-content-end align-items-center">
                                        <button type="submit" class="btn btn-sm btn-success" id="buttonSaveSecondMoldingData"><i class="fa-solid fa-floppy-disk"></i> Save</button>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="col border px-4 border">
                                        <div class="py-3">
                                            <div style="float: left;">
                                                <span class="badge badge-secondary">2.</span> Stations
                                            </div>
                                            <div style="float: right;">
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" type="button" data-bs-target="#modalAddStation" style="margin-bottom: 5px;">
                                                    <i class="fa fa-plus" ></i> Add Station
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-sm small table-bordered table-hover" id="tableStation" style="width: 100%;">
                                                    <thead>
                                                        <tr class="bg-light">
                                                            <th></th>
                                                            <!-- <th></th> -->
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
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="modalEmployeeNumberScanner" data-formid="" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <input type="text" id="textMaterialLotNumberScanner" class="hidden_scanner_input" class="" autocomplete="off">
                        <div class="text-center text-secondary">
                            Please scan Material Lot #
                            <br><br>
                            <h1><i class="fa fa-qrcode fa-lg"></i></h1>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAddStation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content modal-lg">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Stations</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAddStation">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Station</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="text_station" name="text_station" placeholder="Station">
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" id="text_date" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                        <div class="input-group-prepend w-50">
                                            <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm" id="text_operator_name" name="operator_name">
                                    </div>
                                </div>
                            </div>

            
                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_input" name="quantity_input" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_ng" name="quantity_ng" min="0" value="0"="true">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm" id="text_quantity_input" name="quantity_output" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm" id="text_remarks" name="remarks">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="buttonSecondMoldingStation" disabled="true">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('js_content')
        <script>
            $(document).ready(function(){
                $(document).on('keypress', '#textSearchPONumber', function(e){
                    if(e.keyCode == 13){
                        $.ajax({
                            type: "get",
                            url: "get_search_po_for_molding",
                            data: {
                                "po" : $(this).val()
                            },
                            dataType: "json",
                            beforeSend: function(){},
                            success: function (response) {
                                if(response.length > 0){
                                    $('#textSearchMaterialName').val(response[0]['ItemName']);
                                    $('#textSearchPOQuantity').val(response[0]['OrderQty']);

                                    $('#textDeviceName', $('#formSecondMolding')).val(response[0]['ItemName']);
                                    $('#textPartsCode', $('#formSecondMolding')).val(response[0]['ItemCode']);
                                    $('#textPONumber', $('#formSecondMolding')).val(response[0]['OrderNo']);
                                    $('#textPoQuantity', $('#formSecondMolding')).val(response[0]['OrderQty']);
                                }
                                else{
                                    toastr.error('No PO Found on Rapid PO Receive.')
                                }
                            },
                            error: function(data, xhr, status){
                                toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                            }
                        });
                    }
                });

                $('#buttonAddSecondMoldingData').on('click', function(e){
                    let poNumber = $('#textSearchPONumber').val();
                    if(poNumber != "" && $('#textSearchMaterialName').val() != ""){
                        $('#modalSecondMoldingData').modal('show');
                    }
                    else{
                        toastr.error('Please input PO.')
                    }
                });

                $('#buttonQrScanMachineLotNumber').on('click', function(e){
                    $('#modalEmployeeNumberScanner').attr('data-formid','scanMachineLotNumber').modal('show');
                    $('#textMaterialLotNumberScanner').val('');
                    setTimeout(() => {
                        $('#textMaterialLotNumberScanner').focus();
                    }, 500);
                });

                $(document).on('keyup','#textMaterialLotNumberScanner',function(e){
                    let value = $('#textMaterialLotNumberScanner').val();
                    if( e.keyCode == 13 ){
                        $.ajax({
                            type: "get",
                            url: "check_material_lot_number",
                            data: {
                                material_lot_number: value,
                            },
                            dataType: "json",
                            success: function (response) {
                                $('#textMachineLotNumber').val('');
                                $('#textMachineName').val('');
                                $('#textMaterialLotNumberScanner').val('');
                                if(response[0] != undefined){
                                    $('#textMachineLotNumber').val(response[0].machine_lot_number);
                                    $('#textMachineName').val(response[0].machine_name);
                                    $('#modalEmployeeNumberScanner').modal('hide');
                                }else{
                                    toastr.error('Incorrect machine lot number.')
                                }
                            }
                        });
                    }
                });

                function redirectToACDCSDrawing(docNo, docTitle, docType) {
                    if (docTitle == '' )
                        alert('No Document')
                    else{
                        window.open(`http://rapid/ACDCS/prdn_home_pats_ppd_molding?doc_no=${docNo}&doc_title=${docTitle}&doc_type=${docType}`)
                    }
                }

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
                
                $('#formSecondMolding').submit(function (e) { 
                    e.preventDefault();
                    let data = $(this).serialize();
                    console.log('data ', data);
                    $.ajax({
                        type: "POST",
                        url: "save_second_molding",
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            
                        }
                    });
                });













                // dtDatatableProd = $("#tblProd").DataTable({
                //     "processing" : true,
                //     "serverSide" : true,
                //     "ajax" : {
                //         url: "view_first_stamp_prod",
                //             data: function (param){
                //             param.po = $("#textSearchPONumber").val();
                //             param.stamp_cat = 1;
                //         }
                //     },
                //     fixedHeader: true,
                //     "columns":[

                //         { "data" : "action", orderable:false, searchable:false },
                //         { "data" : "label" },
                //         { "data" : "po_num" },
                //         { "data" : "prod_lot_no" },
                //         { "data" : "part_code" },
                //         { "data" : "material_name" },
                //         { "data" : "po_qty" },
                //         { "data" : "ship_output" },
                //         { "data" : "material" },
                //     ],
                //     "columnDefs": [
                //         {"className": "dt-center", "targets": "_all"},
                //         {
                //             "targets": [7],
                //             "data": null,
                //             "defaultContent": "---"
                //         },
                //     ],
                // });//end of dataTableDevices
            });
        </script>
    @endsection
@endauth

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
            
            .checked-ok { background: #5cec4c!important; }
        </style>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>IQC Inspection</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">IQC Inspection</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-12">
                            <!-- general form elements -->
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">2nd Stamping Table</h3>
                                </div>
                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <br><br>
                                    {{-- TABS --}}
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="Pending-tab" data-bs-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="true">On-going</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="Completed-tab" data-bs-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">Inspected</a>
                                        </li>
                                    </ul> <br>
                                    <div class="tab-content" id="myTabContent">
                                        {{-- Pending Tab --}}
                                        <button  class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modalVerifyData" id="btnVerifyScanLotNumber"><i
                                            class="fa-solid fa-qrcode"></i>&nbsp; Validation of Lot #
                                        </button><br><br>
                                        <div class="tab-pane fade show active" id="menu1" role="tabpanel" aria-labelledby="menu1-tab">
                                            <div class="table-responsive">
                                                <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                <table id="tblWhsDetails" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><center><i  class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            {{-- <th>Date Inspected</th> --}}
                                                            {{-- <th>Time Inspected</th> --}}
                                                            {{-- <th>App Ctrl No.</th> --}}
                                                            {{-- <th>Classification</th> --}}
                                                            {{-- <th>Family</th> --}}
                                                            <th>PO</th>
                                                            <th>Supplier</th>
                                                            <th>Part Code</th>
                                                            <th>Part Name</th>
                                                            <th>Lot No.</th>
                                                            {{-- <th>Lot Qty.</th> --}}
                                                            {{-- <th>Total Lot Size</th> --}}
                                                            {{-- <th>AQL</th> --}}
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="menu2-tab">
                                            <div class="table-responsive">
                                                <!-- style="max-height: 600px; overflow-y: auto;" -->
                                                <table id="tblIqcInspected" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><center><i  class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Date Inspected</th>
                                                            <th>Time Inspected</th>
                                                            <th>App Ctrl No.</th>
                                                            {{-- <th>Classification</th> --}}
                                                            {{-- <th>Family</th> --}}
                                                            {{-- <th>Category</th> --}}
                                                            <th>Supplier</th>
                                                            <th>Part Code</th>
                                                            <th>Part Name</th>
                                                            <th>Lot No.</th>
                                                            <th>Lot Qty.</th>
                                                            {{-- <th>AQL</th> --}}
                                                            <th>Inspector</th>
                                                            <th>Date Created</th>
                                                            <th>Date Updated</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--- Modal modalSaveIqcInspection formSaveIqcInspection-->
        @include('component.modal')

        <div class="modal fade" id="modalModeOfDefect" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-edit"></i> Mode of Defects Details</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 mt-2">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Lot No.</span>
                                    </div>
                                    <select class="form-control select2bs4" name="mod_lot_no" id="mod_lot_no" style="width: 50%;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Mode of Defect</span>
                                    </div>
                                    <select class="form-control select2bs4" name="mode_of_defect" id="mode_of_defect" style="width: 50%;">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Quantity</span>
                                    </div>
                                    <input class="form-control" type="number" name="mod_quantity" id="mod_quantity" value="0" min =0>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-sm btn-danger" id="btnRemoveModLotNumber" disabled><i class="fas fa-trash-alt"></i> Remove </a></button>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-sm btn-primary" id="btnAddModLotNumber"><i class="fas fa-plus"></i>Add</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mt-3">
                                <table id="tblModeOfDefect" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Counter</th>
                                            <th>Lot No.</th>
                                            <th>Mode of Defects</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        {{-- <button type="button" class="btn btn-sm btn-primary" id="btnSaveComputation"><i class="fas fa-save"></i> Compute</button> --}}
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- MODALS -->
         <div class="modal fade" id="modalVerifyData">
            <div class="modal-dialog modal-dialog-center">
                <div class="modal-content modal-sm">
                    <div class="modal-body">
                        <input type="text" class="scanner w-100 hidden_scanner_input" id="txtScanVerifyData" name="scan_packing_lot_number" autocomplete="off">
                        {{-- <input type="text" class="scanner w-100 " id="txtScanVerifyData" name="scan_packing_lot_number" autocomplete="off"> --}}
                        <div class="text-center text-secondary"><span id="modalScanLotNumberIdText">Scan Lot Number</span><br><br><h1><i class="fa fa-qrcode fa-lg"></i></h1></div>
                    </div>
                </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


    @endsection
    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function () {
                const tbl = {
                    iqcInspection:'#tblIqcInspection',
                    iqcWhsDetails :'#tblWhsDetails',
                    iqcInspected:'#tblIqcInspected'
                };

                $(tbl.iqcWhsDetails).on('click','#btnEditIqcInspection', editReceivingDetails);
                $(tbl.iqcInspected).on('click','#btnEditIqcInspection', editIqcInspection);

                $('#btnLotNo').click(function (e) {
                    e.preventDefault();
                    $('#modalLotNo').modal('show');
                });

                $('#btnMod').click(function (e) {
                    e.preventDefault();
                    $('#modalModeOfDefect').modal('show');
                });

                $('#btnAddModLotNumber').click(function (e) {
                    e.preventDefault();

                    /* Selected Value */
                    let selectedLotNo = $('#mod_lot_no').val();
                    let selectedMod = $('#mode_of_defect').val();
                    let selectedLotQty = $('#mod_quantity').val();

                    if(selectedLotNo === null || selectedMod === null || selectedLotQty <= 0){
                        toastr.error('Error: Please Fill up all fields !');
                        return false;
                    }

                    /* Counter and Disabled Removed Button */
                    arrCounter.ctr++;
                    disabledEnabledButton(arrCounter.ctr)

                    /* Get selected array to the table */
                    var html_body  = '<tr>';
                        html_body += '<td>'+arrCounter.ctr+'</td>';
                        html_body += '<td>'+selectedLotNo+'</td>';
                        html_body += '<td>'+selectedMod+'</td>';
                        html_body += '<td>'+selectedLotQty+'</td>';
                        html_body += '</tr>';
                    $('#tblModeOfDefect tbody').append(html_body);

                    arrTableMod.lotNo.push(selectedLotNo);
                    arrTableMod.modeOfDefects.push(selectedMod);
                    arrTableMod.lotQty.push(selectedLotQty);
                    console.log('click',arrTableMod.lotQty);
                    // console.log('check',arrTableMod);
                });

                btn.saveComputation.click(function (e) {
                    e.preventDefault();
                    $('#modalModeOfDefect').modal('hide');
                    form.iqcInspection.find('#no_of_defects').val(arrTableMod.lotQty.reduce(getSum, 0));
                });

                btn.removeModLotNumber.click(function() {
                    arrCounter.ctr --;
                    disabledEnabledButton(arrCounter.ctr)

                    $('#tblModeOfDefect tr:last').remove();
                    arrTableMod.lotNo.splice(arrCounter.ctr, 1);
                    arrTableMod.modeOfDefects.splice(arrCounter.ctr, 1);
                    arrTableMod.lotQty.splice(arrCounter.ctr, 1);
                    console.log('deleted',arrTableMod.lotQty);
                    // console.log(arrTableMod);
                });

                form.iqcInspection.find('#accepted').keyup(function() {
                    divDisplayNoneClass($(this).val());
                });

                form.iqcInspection.find('#iqc_coc_file_download').click(function (e) {
                    e.preventDefault();
                    let iqc_inspection_id = form.iqcInspection.find('#iqc_inspection_id').val();
                    window.open('view_coc_file_attachment/'+iqc_inspection_id);

                });

                form.iqcInspection.find('#isUploadCoc').change(function (e) {
                    e.preventDefault();
                    $('#iqc_coc_file').val('');
                    if ($(this).is(':checked')) {
                        form.iqcInspection.find('#iqc_coc_file').prop('required',true);
                        form.iqcInspection.find('#fileIqcCocUpload').removeClass('d-none',true);
                        form.iqcInspection.find('#fileIqcCocDownload').addClass('d-none',true);
                    }else{
                        form.iqcInspection.find('#iqc_coc_file').prop('required',false);
                        form.iqcInspection.find('#fileIqcCocUpload').addClass('d-none',true);
                        form.iqcInspection.find('#fileIqcCocDownload').removeClass('d-none',true);
                    }
                });
                $('#txtScanUserId').on('keyup', function(e){
                    if(e.keyCode == 13){
                        // console.log($(this).val());
                        validateUser($(this).val(), [2,5], function(result){
                            if(result == true){
                                // console.log('true');
                                // submitProdData($(this).val());
                                // console.log('', $('#txtKeepSample1').val());
                                saveIqcInspection();
                            }
                            else{ // Error Handler
                                toastr.error('User not authorize!');
                            }
                        });
                        $(this).val('');
                    }
                });
                /*Submit*/
                $(form.iqcInspection).submit(function (e) {
                    e.preventDefault();
                    // saveIqcInspection();
                    $('#modalScanQRSave').modal('show');
                });

                $('#modalVerifyData').on('shown.bs.modal', function () {
                    $('#txtScanVerifyData').focus();
                });

                $('#txtScanVerifyData').on('keyup', function(e){
                    if(e.keyCode == 13){
                        try{
                            scannedItem = JSON.parse($(this).val());
                            console.log('scannedItem', scannedItem);
                            $('#tblWhsDetails tbody tr').each(function(index, tr){
                                let lot_no = $(tr).find('td:eq(6)').text().trim().toUpperCase();

                                let powerOff = $(this).find('td:nth-child(1)').children().children();

                                // console.log('tblWhsDetails', lot_no);
                                // console.log('scannedItem', scannedItem['lot_no']);
                                if(scannedItem['new_lot_no'] === lot_no){
                                    $(tr).addClass('checked-ok');
                                    powerOff.removeAttr('style');
                                    $('#modalVerifyData').modal('hide');
                                }
                                // console.log(lot_no);
                            })
                        }
                        catch (e){
                            toastr.error('Invalid Sticker');
                            console.log(e);
                        }
                        $(this).val('');
                    }
                });

            });
        </script>
    @endsection
@endauth

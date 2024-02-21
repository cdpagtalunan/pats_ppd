@php $layout = 'layouts.admin_layout'; @endphp

@auth
@extends($layout)

@section('title', 'Dashboard')

@section('content_page')
    <style>
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
            font-size: 15px;
            text-align: center;
            vertical-align: middle;
        }

        table#tblFVIRuncards thead th{
            padding: 4px 4px;
            margin: 1px 1px;
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Visual Inspection</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Visual Inspection</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">1. Scan PO Number</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>PO Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-primary btnSearchPO"
                                                    title="Click to Scan PO Code"><i
                                                        class="fa fa-qrcode"></i></button>
                                            </div>
                                            <input type="text" class="form-control" id="txtSearchPO" readonly="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Device Name</label>
                                        <input type="text" class="form-control" id="txtDeviceName" name=""
                                            readonly="">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Device Code</label>
                                        <input type="text" class="form-control" id="txtDeviceCode"
                                            readonly="">
                                    </div>
                                    <div class="col-sm-1">
                                        <label>PO Qty</label>
                                        <input type="text" class="form-control" id="txtPoQty" readonly="">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">2. Document Reference Check / Visual Inspection</h3>
                                <button class="btn btn-primary btn-sm" style="float: right;" id="btnAddFVI"><i class="fa fa-plus"></i> Add Visual Inspection</button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover w-100" id="tblVisualInspection">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Lot #</th>
                                                <th>Total Lot Qty</th>
                                                <th>FVI - Total NG</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <div class="modal fade" id="modalFVI" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true" data-bs-backdrop="static" style="overflow-y: auto;">
        <div class="modal-dialog modal-xl modal-xl-custom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-info-circle text-info"></i> Visual Inspection Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4 border px-4">
                            <form id="formEditFVIDetails">
                                <div class="row">
                                    <input type="text" id="txtHiddenFviId" name="fvi_id">
                                    <div class="col pt-3">
                                        <span class="badge badge-secondary">1.</span> Visual Inspection Details
                                        <button type="button" id="btn_edit_material_details_primary" class="btn btn-sm btn-link float-right"><i class="fa fa-edit"></i> Edit</button>
                                    </div>

                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO #</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIPoNum" name="txt_po_number" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">PO Qty</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtFVIPoQTy"
                                                    readonly name="txt_po_qty">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <br> -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device
                                                        Name</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIDevName" readonly name="txt_use_for_device">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Device
                                                        Code</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIDevCode" name="txt_device_code" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Lot
                                                        No.</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm" id="txtFVILotNo"
                                                    name="txt_lot_no" placeholder="Auto generated" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100"
                                                        id="basic-addon1">Remarks</span>
                                                </div>
                                                <textarea class="form-control form-control-sm" id="txtFVIRemarks"
                                                    name="txt_remarks" rows="5" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100">Assembly Line</span>
                                                </div>
                                                <select class="form-control select2 select2bs4 sel-assembly-lines"
                                                    id="selFVIAssLine" name="sel_assembly_line" disabled>
                                                    <option value=""> N/A </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100" id="basic-addon1">Created
                                                        At</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txt_created_at" name="txtFVICreatedAt" readonly="true"
                                                    placeholder="Auto generated">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="input-group input-group-sm mb-3">
                                                <div class="input-group-prepend w-50">
                                                    <span class="input-group-text w-100">Application Date/Time</span>
                                                </div>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="txtFVIAppDT" name="application_datetime"
                                                    readonly="true" placeholder="Auto generated">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col border py-3 px-4 border-left-0 border-bottom-0">
                                    <div class="mb-3">
                                        <span class="badge badge-secondary">2.</span> Runcards
                                        <button class="btn btn-primary btn-sm float-right" id="btnAddFVIRuncard" ><i class="fa fa-plus" ></i> Add Runcard</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm small table-bordered table-hover" id="tblFVIRuncards" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Runcard #</th>
                                                    <th>Date Time</th>
                                                    <th>Operator Name</th>
                                                    <th>Input</th>
                                                    <th>Output</th>
                                                    <th>NG QTY</th>
                                                    <th>Runcard MOD</th>
                                                    <th>Remarks</th>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalFVIRuncard" tabindex="-1" role="dialog"
        aria-labelledby="cnptsmodal" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-object-group text-info"></i> Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- <br> -->
                    <!-- <h5 class="modal-title h5OIHeaderTitle">Overall Inspection - <span>0</span> Selected Runcards</h5> -->
                </div>
                <div class="modal-body">
                    <form id="formFVIRuncard">
                        <div class="row">
                            <div class="col">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100" id="basic-addon1">Process</span>
                                    </div>
                                    <input type="text" name="process_name" class="form-control form-control-sm"
                                        id="txtRuncardProcess" readonly value="Final Visual">
                                </div>
                                <div class="row" style="display: block;">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Runcard</span>
                                            </div>

                                            <input class="form-control" id="txtRuncardNumber" readonly>

                                            <div class="input-group-append">
                                                <button class="btn btn-info" type="button" title="Scan code"
                                                    id="btnScanQrRuncardNumber"><i
                                                        class="fa fa-qrcode"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Date</span>
                                            </div>
                                            <input type="date" class="form-control form-control-sm" id="txtRuncardDate"
                                                name="date" readonly value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="display: block;">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Operator Name</span>
                                            </div>
                                            {{-- <select class="form-control selectUser select2"
                                                id="sel_edit_prod_runcard_terminal_area" name="terminal_area" readonly>
                                                <option value=""> N/A </option>
                                            </select> --}}
                                            <input type="text" class="form-control form-control-sm" id="txtOpertaorName" name="operator_name">
                                            <!-- <div class="input-group-append">
                                          <button class="btn btn-info" type="button" title="Scan code" id="btn_scan_add_runcard_operator_code"><i class="fa fa-qrcode"></i></button>
                                        </div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Input</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txt_edit_prod_runcard_station_input" name="qty_input" readonly
                                                required min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Output</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txt_edit_prod_runcard_station_output" name="qty_output" readonly
                                                required min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">NG Qty</span>
                                            </div>
                                            <input type="number" class="form-control form-control-sm"
                                                id="txt_edit_prod_runcard_station_ng" name="qty_ng" min="0" value="0"
                                                readonly="true" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Type of NG</span>
                                            </div>
                                            <!-- <input type="number" class="form-control form-control-sm" id="txt_edit_prod_runcard_station_ng" name="qty_ng" min="0" value="0" readonly="true" required> -->
                                            <select class="form-control" id="selEdit_type_of_ng" name="type_of_ng">
                                                <option value="0">_</option>
                                                <option value="1">Rework</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-3">
                                            <div class="input-group-prepend w-50">
                                                <span class="input-group-text w-100" id="basic-addon1">Remarks</span>
                                            </div>
                                            <textarea class="form-control form-control-sm" id="txt_fvi_remarks"
                                                name="remarks" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <div style="float: left;">
                                        <label>Total No. of NG: <span id="pRCStatTotNoOfNG"
                                                style="color: green;">0</span></label>
                                    </div>
                                    <div style="float: right;">
                                        <button type="button" id="btnAddMODTable" class="btn btn-xs btn-info"
                                            title="Add MOD"><i class="fa fa-plus"></i> Add MOD</button>
                                    </div>
                                    <br><br>
                                    <table class="table table-sm" id="tblEditProdRunStaMOD">
                                        <thead>
                                            <tr>
                                                <th style="width: 70%;">MOD</th>
                                                <th style="width: 20%;">QTY</th>
                                                <!-- <th style="width: 20%;">Type of NG</th> -->
                                                <th style="width: 10%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <tr>
                                          <td>
                                            <select class="form-control select2 select2bs4 selectMOD" id="selEditProdRunMod" name="mod[]">
                                              <option value="">N/A</option>
                                            </select>
                                          </td>
                                          <td>
                                            <input type="number" class="form-control txtEditProdRunStaMODQty" name="mod_qty[]">
                                          </td>
                                          <td></td>
                                        </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     
@endsection

@section('js_content')
<script>
    $(document).ready(function(){
        $('#btnAddFVI').on('click', function(){
            $('#modalFVI').modal('show');
        });

        $('#btnAddFVIRuncard').on('click', function(e){
            e.preventDefault();
            $('#modalFVIRuncard').modal('show');
        });
    });
</script>
@endsection
@endauth
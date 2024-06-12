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

    @section('title', 'Packing List')

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
                            <h1>Packing List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Packing List</li>
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
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Packing List Table</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    <div style="float: right;">
                                        {{-- <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalExportPackingList" id="btnExportPackingList">
                                                <i class="fa-solid fa-plus"></i> Export Packing List
                                        </button> --}}
                                        <button class="btn btn-primary" id="btnExportPackingList">
                                            <i class="fa-solid fa-file-export"></i> Export Packing List (PDF)
                                            {{-- </a> --}}
                                        </button>


                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalAddPackingList" id="btnShowAddPackingList"><i
                                                class="fas fa-clipboard-list"></i> Add Packing List
                                        </button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        {{-- <!-- style="max-height: 600px; overflow-y: auto;" --> --}}
                                        <table id="tblPackingListDetails" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Ctrl #</th>
                                                    <th>PO</th>
                                                    {{-- <th>Material Name</th> --}}
                                                    {{-- <th>Lot #</th> --}}
                                                    {{-- <th>Shipment Output</th> --}}
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
        </div>

    <!-- MODALS -->

    <div class="modal fade" id="modalExportPackingList">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title">Generate Packing List</h4>
                    <button type="button" style="color: #fff;" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
                        <button id="btnExportFile" class="btn btn-primary"><i id="iBtnDownloadPackingList" class="fas fa-file-download"></i> Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

     {{-- * ADD --}}
     <div class="modal fade" id="modalAddPackingList" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Packing List</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formPackingList" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtPackingListId" name="packing_list_id">
                        <div class="col-sm-12">
                            <strong>Packing List Details</strong>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                {{-- <input type="text" class="form-control" id="textSearchPackingListDetails" name="search_packing_list_details" autocomplete="off"> --}}
                                <select class="form-control select2" id="selPackingListDetails" name="search_packing_list_details[]" multiple>
                                </select>
                            </div>
                            {{-- <div class="col-sm-6">
                                <button class="btn btn-primary searchBtn" id="btnSearchPO">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div> --}}

                            <div class="col-sm-6">
                                <button class="btn btn-primary searchBtn" id="btnSearchPO">
                                    <i class="fa fa-plus"></i>
                                    Add PO
                                </button>
                            </div>
                        </div>
                        <br>

                            <div class="table-responsive">
                                <table id="tblProductionListDetails" class="table table-sm table-bordered table-striped table-hover"style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%"><center>Id</center></th>
                                            <th style="width: 3%"><center>Box #</center></th>
                                            <th>Status</th>
                                            <th>PO</th>
                                            <th>Material Name</th>
                                            <th>Production Lot #</th>
                                            <th>Product Code</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Ctrl #</label>
                                    <input type="text" class="form-control form-control-sm" name="ctrl_num" id="txtCtrlNumber" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label for="textPickUpDateAndTime">Pick-up Time & Date</label>
                                    <input type="datetime-local" class="form-control" id="textPickUpDateAndTime" name="pickup_date_and_time">
                                {{-- <input type="text" class="form-control datetimepicker" name="pick_up_time_and_date" id="textPickUpTimeAndDate" autocomplete="off" placeholder="yyyy-mm-dd" aria-label="Default" aria-describedby="inputGroup-sizing-default"> --}}
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Carrier</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="carrier" id="textCarrier" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectCarrier" name="carrier">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">From :</label>
                                    <input type="text" class="form-control form-control-sm" name="ship_from" id="textShipFrom" readonly value="PRICON">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">To :</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="ship_to" id="textShipTo" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectCustomer" name="ship_to">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Port of Loading :</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="port_of_loading" id="textPortOfLoading" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectPortOfLoading" name="loading_port">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Port of Destination :</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="port_of_destination" id="textPortOfDestination" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectPortOfDestination" name="destination_port">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Prepared by :</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="port_of_destination" id="textPortOfDestination" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectPreparedBy" name="prepared_by">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Checked by :</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="port_of_destination" id="textPortOfDestination" autocomplete="off"> --}}
                                    <select class="form-select select2" id="selectCheckedBy" name="checked_by">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">CC:</label>
                                    {{-- <input type="text" class="form-control form-control-sm" name="port_of_destination" id="textPortOfDestination" autocomplete="off"> --}}
                                    <select class="form-control select2 selectCcName" id="selectCarbonCopy" name="carbon_copy[]" multiple>
                                        <!-- Auto Generated -->
                                    </select>

                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <p><label for="txtSoldTo">Sold to</label></p>
                                    <textarea id="txtSoldTo" name="sold_to" rows="3" cols="50">SANNO PHILS. MANUFACTURING CORP. Special Export Processing Zone, Gateway Business Park, Javalera, Gen. Trias, Cavite, Philippines </textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <p><label for="txtShipTo">Ship to</label></p>
                                    <textarea id="txtShipTo" name="ship_to" rows="3" cols="50">SANNO PHILS. MANUFACTURING CORP. Special Export Processing Zone, Gateway Business Park, Javalera, Gen. Trias, Cavite, Philippines	</textarea>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnSavePackingListDetails" class="btn btn-primary"><i id="btnSavePackingListDetailsIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

     {{-- * view --}}
     <div class="modal fade" id="modalViewPackingListDetails" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i>Packing List Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtPackingListCtrlId" name="packing_details_ctrl_no">
                        <div class="col-sm-12">
                            <strong>Packing List Details</strong>
                        </div>
                        <hr>

                            <div class="table-responsive">
                                <table id="tblViewPackingListDetails" class="table table-sm table-bordered table-striped table-hover"style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Status</th>
                                            <th style="width: 3%"><center>Box #</center></th>
                                            <th>PO</th>
                                            <th>Material Name</th>
                                            <th>Production Lot #</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Ctrl #</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_ctrl_num" id="getTextCtrlNumber" readonly>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="textPickUpDateAndTime">Pick-up Time & Date</label>
                                        {{-- <input type="text" class="form-control" name="edit_pickup_date_and_time" id="getTextPickUpDateAndTime" readonly> --}}
                                        <input type="datetime-local" class="form-control" id="getTextPickUpDateAndTime" name="edit_pickup_date_and_time" readonly>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Carrier</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_carrier" id="getTextCarrier" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">From :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_ship_from" id="getTextShipFrom" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">To :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_ship_to" id="getTextShipTo" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Port of Loading :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_port_of_loading" id="getTextPortOfLoading" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Port of Destination :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_port_of_destination" id="getTextPortOfDestination" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Prepared by :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_prepared_by" id="getPreparedBy" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Checked by :</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_checked_by" id="getCheckedBy" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">CC:</label>
                                        <input type="text" class="form-control form-control-sm" name="edit_carbon_copy" id="getCarbonCopy" readonly>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" id="btnSavePackingListDetails" class="btn btn-primary"><i id="btnSavePackingListDetailsIcon"class="fa fa-check"></i> Save</button> --}}
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

                $('.select2').select2({
                    theme: 'bootstrap-5'
                });

        // $('.datetimepicker').datepicker({
        //                         format: 'yyyy-mm-dd',
        //                         // format: 'yyyy-mm-dd',
        //                         forceParse: false, // prevent from clearing existing values from input when no date selected
        //                         autoclose: true, // autoclose date after selecting date
        //                         clearBtn: true, // include clear button
        //                         // daysOfWeekDisabled: [0, 6], // disabled weekends
        //                         todayHighlight: true,
        //                         // daysOfWeekHighlighted: [1,2,3,4,5],
        //                         // datesDisabled: disabledDays,

        // });+
        $(document).ready(function(){

            // $(document).on('click', '.searchBtn',function(e){
            //     e.preventDefault();
            //         // dtProductionDetails.columns(0).visible(false);
            //         let search_data = $('#selPackingListDetails').val();
            //         $.ajax({
            //             type: "get",
            //             url: "get_data_from_production",
            //             data: {
            //                 "search_data" : search_data
            //             },
            //             dataType: "json",
            //             beforeSend: function(){
            //             },
            //             success: function (response) {
            //                 let productionData = response['productionData'];
            //                 // console.log(productionData);
            //                 if(productionData > 0){
            //                     // $('#selPackingListDetails').val(productionData[0]['po_num']);
            //                     const po_no_array = [];
            //                     for (let index = 0; index < response['productionData'].length; index++) {
            //                         // const element = array[index];
            //                         po_no_array.push(`${response['productionData'][x].po_no}`);
            //                     }
            //                     GetPOFromProductionData($("#selPackingListDetails"), po_no_array);
            //                     dtProductionDetails.draw();
            //                 }else{
            //                     dtProductionDetails.draw();
            //                 }
            //             }
            //         });
            // });

            $(document).on('click', '.searchBtn',function(e){
                e.preventDefault();
                dtProductionDetails.draw();
            });

            $('#selPackingListDetails').change( function(e){
                e.preventDefault();
                dtProductionDetails.draw();
            });

            GetPOFromProductionData($("#selPackingListDetails"));
            // GetBDrawingFromACDCS(mat_name, 'B Drawing', $("#txtSelectDocNoBDrawing"));

            // function GetBDrawingFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo){
            //         GetDocumentNoFromACDCS(doc_title, doc_type, cboElement, IpqcDocumentNo);
            //     };

            function GetPOFromProductionData(cboElement, currentPO = null){
                $.ajax({
                    url: 'get_po_from_production',
                    method: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if (response['productionData'].length > 0){
                            result = "";
                            for (let index = 0; index < response['productionData'].length; index++) {
                                result += '<option value="' + response['productionData'][index].po_no + '">' + response['productionData'][index].po_no + '</option>';
                            }
                        } else {
                            result = '<option value="0" selected disabled> -- No record found -- </option>';
                        }
                        cboElement.html(result);
                    },
                    error: function(data, xhr, status) {
                        result = '<option value="0" selected disabled> -- Reload Again -- </option>';
                        cboElement.html(result);
                        console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
                });
            }

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
                        console.log(response['packing_list_data']);
                        // function unique(array) {
                        let control_no = $.grep(response['packing_list_data'], function(el, index){
                                            return index === $.inArray(el, response['packing_list_data']);
                                        });
                        // }
                        // console.log(response['packing_list_data']);
                        console.log(control_no);

                        if (control_no.length > 0) {
                                result = '<option value="" disabled selected>--Select Control No.--</option>';
                            for (let index = 0; index < control_no.length; index++) {
                                    // let control_no = control_no[index].control_no;
                                    // let sub_control_no = control_no.substring(0, 12);
                                result += '<option value="' + control_no[index] + '">' + control_no[index] + '</option>';
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
                let CtrlNo = $('#txtCtrlNo').val();
                // window.location.href = "view_pdf/"+CtrlNo;\
                window.open(`view_pdf/${CtrlNo}`, '_blank');
                $('#modalExportPackingList').modal('hide');
            });

            getCustomer($('#selectCustomer'));
            getCarrier($('#selectCarrier'));
            getPortOfLoading($('#selectPortOfLoading'));
            getPortOfDestination($('#selectPortOfDestination'));
            getPreparedByUser($('#selectPreparedBy'));
            getCheckedByUser($('#selectCheckedBy'));
            getCarbonCopyUser($('.selectCcName'));

            dtProductionDetails = $("#tblProductionListDetails").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_production_data",
                    data: function(param){
                    param.search_data =  $('#selPackingListDetails').val();
                    }
                },
                fixedHeader: true,
                "columns":[
                    { "data"  : 'DT_RowIndex'},
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "status"},
                    { "data" : "po_no"},
                    { "data" : "oqc_info.stamping_production_info.material_name"},
                    { "data" : "oqc_info.stamping_production_info.prod_lot_no"},
                    // { "data" : "stamping_production_info.material_lot_no"},
                    { "data" : "oqc_info.stamping_production_info.part_code"},
                    { "data" : "oqc_info.stamping_production_info.ship_output"},
                ],
            });

            dtPackingListDetails = $("#tblPackingListDetails").DataTable({
                "processing" : true,
                "serverSide" : true,
                "ajax" : {
                    url: "view_packing_list_data",
                    data: function(param){
                    param.search_data =  $('#selPackingListDetails').val();
                    }
                },
                fixedHeader: true,
                "columns":[
                    // { "data"  : 'DT_RowIndex'},
                    { "data" : "action", orderable:false, searchable:false },
                    { "data" : "status"},
                    { "data" : "control_no"},
                    // { "data" : "box_no"},
                    { "data" : "po"},
                    // { "data" : "mat_name"},
                    // { "data" : "lot_no"},
                    // { "data" : "quantity"},
                ],
            });


            // $(document).on('click', '.searchBtn',function(e){
            //     e.preventDefault();
            //         // dtProductionDetails.columns(0).visible(false);
            //         let search_data = $('#textSearchPackingListDetails').val();
            //         $.ajax({
            //             type: "get",
            //             url: "get_data_from_production",
            //             data: {
            //                 "search_data" : search_data
            //             },
            //             dataType: "json",
            //             beforeSend: function(){
            //             },
            //             success: function (response) {
            //                 let productionData = response['productionData'];
            //                 // console.log(productionData);
            //                 if(productionData > 0){
            //                     $('#textSearchPackingListDetails').val(productionData[0]['po_num']);
            //                     dtProductionDetails.draw();
            //                 }else{
            //                     dtProductionDetails.draw();
            //                 }
            //             }
            //         });
            // });

            let packing_list_data_array = [];

            $("#modalAddPackingList").on('hide.bs.modal', function(){
                packing_list_data_array = [];
                $('#textSearchPackingListDetails').val('');
                $("#formPackingList").trigger("reset");
                dtProductionDetails.draw();
            });
                $('#tblProductionListDetails tbody').on( 'dblclick', 'tr', function (){
                    let data = dtProductionDetails.row(this).data();
                    let array_data = Object.entries(data);

                    console.log(`data`, data['oqc_id']);

                    packing_list_data_array.push(data['oqc_id']);
                    console.log('packing_list_data_array ', packing_list_data_array);
                    // $(this).toggleClass('selected');

                    console.log(data['id']);

                    if($(this).toggleClass('selected')){
                        if($(this).hasClass('selected')){
                            // alert('hooy');
                            $(`.packing_${data['id']}`).removeClass('d-none');
                            $(`.packing_${data['id']}`).removeAttr('disabled');
                        }else{
                            // alert('hooray');
                            $(`.packing_${data['id']}`).addClass('d-none');
                            $(`.packing_${data['id']}`).attr('disabled');
                        }
                    }
                    console.log(packing_list_data_array);
                })

                $('#formPackingList').submit(function (e){
                    e.preventDefault();
                    const filtered_packing_list_data_array = Array.from(new Set(packing_list_data_array));
                    let data = {
                        'packing_list_data_array' : filtered_packing_list_data_array
                        }

                    $.ajax({
                        type: "POST",
                        url: "add_packing_list_details",
                        data: $(this).serialize() + '&' + $.param(data),
                        dataType: "json",
                        success: function (response) {
                            if(response['validation'] == 1){
                                    toastr.error('Saving data failed!');
                                    if(response['error']['ctrl_num'] === undefined){
                                        $("#txtCtrlNumber").removeClass('is-invalid');
                                        $("#txtCtrlNumber").attr('title', '');
                                    }
                                    else{
                                        $("#txtCtrlNumber").addClass('is-invalid');
                                        $("#txtCtrlNumber").attr('title', response['error']['ctrl_num']);
                                    }
                                    if(response['error']['pickup_date_and_time'] === undefined){
                                        $("#textPickUpDateAndTime").removeClass('is-invalid');
                                        $("#textPickUpDateAndTime").attr('title', '');
                                    }
                                    else{
                                        $("#textPickUpDateAndTime").addClass('is-invalid');
                                        $("#textPickUpDateAndTime").attr('title', response['error']['pickup_date_and_time']);
                                    }
                                    if(response['error']['carrier'] === undefined){
                                        $("#selectCarrier").removeClass('is-invalid');
                                        $("#selectCarrier").attr('title', '');
                                    }
                                    else{
                                        $("#selectCarrier").addClass('is-invalid');
                                        $("#selectCarrier").attr('title', response['error']['carrier']);
                                    }
                                    if(response['error']['ship_from'] === undefined){
                                        $("#textShipFrom").removeClass('is-invalid');
                                        $("#textShipFrom").attr('title', '');
                                    }
                                    else{
                                        $("#textShipFrom").addClass('is-invalid');
                                        $("#textShipFrom").attr('title', response['error']['ship_from']);
                                    }
                                    if(response['error']['ship_to'] === undefined){
                                        $("#selectCustomer").removeClass('is-invalid');
                                        $("#selectCustomer").attr('title', '');
                                    }
                                    else{
                                        $("#selectCustomer").addClass('is-invalid');
                                        $("#selectCustomer").attr('title', response['error']['ship_to']);
                                    }
                                    if(response['error']['loading_port'] === undefined){
                                        $("#selectPortOfLoading").removeClass('is-invalid');
                                        $("#selectPortOfLoading").attr('title', '');
                                    }
                                    else{
                                        $("#selectPortOfLoading").addClass('is-invalid');
                                        $("#selectPortOfLoading").attr('title', response['error']['loading_port']);
                                    }
                                    if(response['error']['destination_port'] === undefined){
                                        $("#selectPortOfDestination").removeClass('is-invalid');
                                        $("#selectPortOfDestination").attr('title', '');
                                    }
                                    else{
                                        $("#selectPortOfDestination").addClass('is-invalid');
                                        $("#selectPortOfDestination").attr('title', response['error']['destination_port']);
                                    }
                                    if(response['error']['prepared_by'] === undefined){
                                        $("#selectPreparedBy").removeClass('is-invalid');
                                        $("#selectPreparedBy").attr('title', '');
                                    }
                                    else{
                                        $("#selectPreparedBy").addClass('is-invalid');
                                        $("#selectPreparedBy").attr('title', response['error']['prepared_by']);
                                    }
                                    if(response['error']['checked_by'] === undefined){
                                        $("#selectCheckedBy").removeClass('is-invalid');
                                        $("#selectCheckedBy").attr('title', '');
                                    }
                                    else{
                                        $("#selectCheckedBy").addClass('is-invalid');
                                        $("#selectCheckedBy").attr('title', response['error']['checked_by']);
                                    }
                                    if(response['error']['carbon_copy'] === undefined){
                                        $("#selectCarbonCopy").removeClass('is-invalid');
                                        $("#selectCarbonCopy").attr('title', '');
                                    }
                                    else{
                                        $("#selectCarbonCopy").addClass('is-invalid');
                                        $("#selectCarbonCopy").attr('title', response['error']['carbon_copy']);
                                    }
                            }else if(response['result'] == 0){
                                $("#formPackingList")[0].reset();
                                toastr.success('Succesfully saved!');
                                $('#modalAddPackingList').modal('hide');
                                dtPackingListDetails.draw();
                            }
                                $("#btnSavePackingListDetailsIcon").removeClass('spinner-border spinner-border-sm');
                                $("#btnSavePackingListDetails").removeClass('disabled');
                                $("#btnSavePackingListDetailsIcon").addClass('fa fa-check');
                            },
                            error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });

                //
                // let dtViewPackingListDetails;
                $(document).on('click', '.btnEditPackingListDetails', function(e){
                    // alert('xd');
                    e.preventDefault();
                    let packingDetailsCtrlNo =  $(this).attr('data-ctrl-no');

                    $('#txtPackingListCtrlId').val(packingDetailsCtrlNo);
                    // console.log(packingDetailsCtrlNo);
                    getPackingListDetails(packingDetailsCtrlNo);

                    $('#modalViewPackingListDetails').modal('show');
                    dtViewPackingListDetails.draw();
                });

                let dtViewPackingListDetails = $("#tblViewPackingListDetails").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "get_packing_list_details_by_ctrl",
                        data: function(param){
                        param.packing_list_ctrl_no =  $("#txtPackingListCtrlId").val();
                        }
                    },
                    fixedHeader: true,
                    "columns":[
                        // { "data"  : 'DT_RowIndex'},
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status"},
                        { "data" : "box_no"},
                        { "data" : "po_no"},
                        { "data" : "mat_name"},
                        { "data" : "lot_no"},
                        { "data" : "quantity"},
                    ],
                });

        });

        </script>
    @endsection
@endauth

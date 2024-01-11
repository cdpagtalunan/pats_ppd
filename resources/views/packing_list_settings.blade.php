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
                            <h1>Packing List Details Settings</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Packing List Details Settings</li>
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
                                    <h3 class="card-title">Packing List Details Settings</h3>
                                </div>

                                <!-- Start Page Content -->
                                <div class="card-body">
                                    
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#customerDetailsTab" type="button" role="tab">Customer Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#carrierDetailsTab" type="button" role="tab">Carrier Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#loadingPortTab" type="button" role="tab">Loading Port Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#destinationPortTab" type="button" role="tab">Destination Port Details</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="customerDetailsTab" role="tabpanel">
                                            <div style="float: right;">
                                                <button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalAddCustomerDetails" id="btnAddCustomerDetails"><i
                                                        class="fas fa-city"></i> Add Customer Details 
                                                </button>
                                            </div> <br><br>
                                            <div class="table-responsive">
                                                <table id="tblCustomerDetails" class="table table-sm table-bordered table-striped table-hover"
                                                    style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th><center><i class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Company Name</th>
                                                            <th>Company Address</th>
                                                            <th>Company Contact</th>
                                                            <th>Contact Person</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="carrierDetailsTab" role="tabpanel" aria-labelledby="tabCarrierDetails">
                                            <div style="float: right;">
                                                <div class="text-right mt-4">                   
                                                    <button type="button" class="btn btn-primary mb-3" id="btnAddCarrierDetails" data-bs-toggle="modal" data-bs-target="#modalAddCarierDetails"><i class="fa fa-plus fa-md"></i> Add Carrier Details</button>
                                                </div>
                                            </div> <br><br>
                                            <div class="table-responsive">
                                                <table id="tblCarrierDetails" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                                    <thead>
                                                            <th style="width: 5%"><center><i class="fa fa-cog"></i></center></th>
                                                            <th style="width: 15%">Status</th>
                                                            <th style="width: 80%">Carrier Name</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="loadingPortTab" role="tabpanel" aria-labelledby="loadingPortTab">
                                            <div style="float: right;">
                                                <div class="text-right mt-4">                   
                                                    <button type="button" class="btn btn-primary mb-3" id="btnLoadingPortDetailsId" data-bs-toggle="modal" data-bs-target="#modaladdLoadingPortDetails"><i class="fa fa-plus fa-md"></i> Add Loading Port</button>
                                                </div>
                                            </div> <br><br>
                                            <div class="table-responsive">
                                                <table id="tblLoadingPort" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                                    <thead>
                                                            <th><center><i class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Loading Port</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="destinationPortTab" role="tabpanel" aria-labelledby="destinationPortTab">
                                            <div style="float: right;">
                                                <div class="text-right mt-4">                   
                                                    <button type="button" class="btn btn-primary mb-3" id="btnDestinationPortDetails" data-bs-toggle="modal" data-bs-target="#modaladdDestinationPortDetails"><i class="fa fa-plus fa-md"></i> Add Destination Port</button>
                                                </div>
                                            </div> <br><br>
                                            <div class="table-responsive">
                                                <table id="tblDestinationPort" class="table table-sm table-bordered table-striped table-hover" style="width: 100%;">
                                                    <thead>
                                                            <th><center><i class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Destination Port</th>
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

    <!-- MODALS -->
     {{-- * ADD --}}
     <div class="modal fade" id="modalAddCustomerDetails" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Customer Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddCustomerDetails" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtCustomerDetailsId" name="customer_details_id">
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control form-control-sm" name="company_name" id="txtCompanyName" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="txtShipTo">Company Address</label>
                                    <textarea class="form-control form-control-sm" id="txtCompanyAddress" name="company_address" rows="2" cols="50"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Company Contact No</label>
                                    <input type="text" class="form-control form-control-sm" name="company_contact_no" id="txtCompanyContactNo" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Company Contact Person</label>
                                    <input type="text" class="form-control form-control-sm" name="company_contact_person" id="txtCompanyContactPerson" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddCompanyDetails" class="btn btn-primary"><i id="btnAddCompanyDetailsIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

     {{-- * ADD --}}
     <div class="modal fade" id="modalAddCarierDetails" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Carrier Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddCarrierDetails" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtCarrierDetailsId" name="Carrier_details_id">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Carrier Name</label>
                                    <input type="text" class="form-control form-control-sm" name="carrier_name" id="txtCarrierName" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddCarrierDetails" class="btn btn-primary"><i id="btnAddCarrierDetailsIcon"
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
                            
        // });

        // CUSTOMER DETAILS START
                dtCustomerDetails = $("#tblCustomerDetails").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_company_details",
                    },
                    fixedHeader: true,
                    "columns":[

                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status" },
                        { "data" : "company" },
                        { "data" : "company_address" },
                        { "data" : "company_contact_no" },
                        { "data" : "contact_person" },
                    ],
                });

                
                $('#formAddCustomerDetails').submit(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "add_customer_details",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response){
                            if(response['validation'] == 1){
                                toastr.error('Saving data failed!');
                                if(response['error']['company_name'] === undefined){
                                    $("#txtCompanyName").removeClass('is-invalid');
                                    $("#txtCompanyName").attr('title', '');
                                }
                                else{
                                    $("#txtCompanyName").addClass('is-invalid');
                                    $("#txtCompanyName").attr('title', response['error']['company_name']);
                                }
                                if(response['error']['company_contact_no'] === undefined){
                                    $("#txtCompanyContactNo").removeClass('is-invalid');
                                    $("#txtCompanyContactNo").attr('title', '');
                                }
                                else{
                                    $("#txtCompanyContactNo").addClass('is-invalid');
                                    $("#txtCompanyContactNo").attr('title', response['error']['company_contact_no']);
                                }
                                if(response['error']['company_address'] === undefined){
                                    $("#txtCompanyAddress").removeClass('is-invalid');
                                    $("#txtCompanyAddress").attr('title', '');
                                }
                                else{
                                    $("#txtCompanyAddress").addClass('is-invalid');
                                    $("#txtCompanyAddress").attr('title', response['error']['company_address']);
                                }
                                if(response['error']['company_contact_person'] === undefined){
                                    $("#txtCompanyContactPerson").removeClass('is-invalid');
                                    $("#txtCompanyContactPerson").attr('title', '');
                                }
                                else{
                                    $("#txtCompanyContactPerson").addClass('is-invalid');
                                    $("#txtCompanyContactPerson").attr('title', response['error']['company_contact_person']);
                                }
                            }else if(response['result'] == 0){
                                $("#formAddCustomerDetails")[0].reset();
                                toastr.success('Succesfully saved!');
                                $('#modalAddCustomerDetails').modal('hide');
                                dtCustomerDetails.draw();
                            }

                            $("#btnAddCompanyDetailsIcon").removeClass('spinner-border spinner-border-sm');
                            $("#btnAddCompanyDetails").removeClass('disabled');
                            $("#btnAddCompanyDetailsIcon").addClass('fa fa-check');
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });

                $(document).on('click', '.btnEditCustomerDetails', function(){
                    $('#modalAddCustomerDetails').modal('show');
                    let customerDetailsId = $(this).attr('data-id');
                    $('#txtCustomerDetailsId').val(customerDetailsId);
                    console.log(customerDetailsId);

                    getCustomerDetailsId(customerDetailsId);
                });

        //CUSTOMER DETAILS END 
        
        // CARRIER DETAILS START
                dtCarrierDetails = $("#tblCarrierDetails").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_carrier_details",
                    },
                    fixedHeader: true,
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status"},
                        { "data" : "carrier_name"},
                    ],
                });

                $('#formAddCarrierDetails').submit(function(e){
                    e.preventDefault();
                    $.ajax({
                        type: "post",
                        url: "add_carrier_details",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(response){
                            if(response['validation'] == 1){
                                toastr.error('Saving data failed!');
                                if(response['error']['carrier_name'] === undefined){
                                    $("#txtCarrierName").removeClass('is-invalid');
                                    $("#txtCarrierName").attr('title', '');
                                }
                                else{
                                    $("#txtCarrierName").addClass('is-invalid');
                                    $("#txtCarrierName").attr('title', response['error']['carrier_name']);
                                }
                            }else if(response['result'] == 0){
                                $("#formAddCarrierDetails")[0].reset();
                                toastr.success('Succesfully saved!');
                                $('#modalAddCarierDetails').modal('hide');
                                dtCarrierDetails.draw();
                            }

                            $("#btnAddCarrierDetailsIcon").removeClass('spinner-border spinner-border-sm');
                            $("#btnAddCarrierDetails").removeClass('disabled');
                            $("#btnAddCarrierDetailsIcon").addClass('fa fa-check');
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                });
        // CARRIER DETAILS END 

                dtLoadingPortDetails = $("#tblLoadingPort").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_loading_port_details",
                    },
                    fixedHeader: true,
                    "columns":[

                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status"},
                        { "data" : "loading_port"},
                    ],
                });

                dtDestinationPortDetails = $("#tblDestinationPort").DataTable({
                    "processing" : true,
                    "serverSide" : true,
                    "ajax" : {
                        url: "view_destination_port_details",
                    },
                    fixedHeader: true,
                    "columns":[

                        { "data" : "action", orderable:false, searchable:false },
                        { "data" : "status"},
                        { "data" : "destination_port"},
                    ],
                });

        </script>
    @endsection
@endauth

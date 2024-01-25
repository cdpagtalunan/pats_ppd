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

    @section('title', 'Packing List Settings')

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
                                                            <th style="width: 10%"><center><i class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th style="width: 20%">Company Name</th>
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
                                                            <th style="width: 10%"><center><i class="fa fa-cog"></i></center></th>
                                                            <th style="width: 10%"><center>Status</center></th>
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
                                                            <th><center>Status</center></th>
                                                            <th>Loading Port</th>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="destinationPortTab" role="tabpanel" aria-labelledby="destinationPortTab">
                                            <div style="float: right;">
                                                <div class="text-right mt-4">                   
                                                    <button type="button" class="btn btn-primary mb-3" id="btnDestinationPortDetails" data-bs-toggle="modal" data-bs-target="#modalAddDestinationPortDetails"><i class="fa fa-plus fa-md"></i> Add Destination Port</button>
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
                        <input type="hidden" id="txtCarrierDetailsId" name="carrier_details_id">
                        
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

    <div class="modal fade" id="modaladdLoadingPortDetails" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Loading Port Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formaddLoadingPortDetails" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtLoadingPortDetailsId" name="loading_port_details_id">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Loading Port</label>
                                    <input type="text" class="form-control form-control-sm" name="loading_port" id="txtLoadingPort" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddLoadingPortDetails" class="btn btn-primary"><i id="btnAddLoadingPortDetailsIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalAddDestinationPortDetails" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Destination Port Details</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formaddDestinationPortDetails" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="txtDestinationPortDetailsId" name="destination_port_details_id">
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Destination Port</label>
                                    <input type="text" class="form-control form-control-sm" name="destination_port" id="txtDestinationPort" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddDestinationPortDetails" class="btn btn-primary"><i id="btnAddDestinationPortDetailsIcon"
                                class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modalEditCompanyDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="editCompanyDetailsStatusTitle"><i class="fas fa-info-circle"></i> Edit Company Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textEditCompanyDetailsStatusId">
                    <h3>Are you sure you want to deactivate this Company?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonEditCompanyDetailsStatus" class="btn btn-danger"><i id="iBtnEditCompanyDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalRestoreCompanyDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="restoreCompanyDetailsStatusTitle"><i class="fas fa-info-circle"></i> Restore Company Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textRestoreCompanyDetailsStatusId">
                    <h3>Are you sure you want to restore this Company?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonRestoreCompanyDetailsStatus" class="btn btn-primary"><i id="iBtnRestoreCompanyDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalEditCarrierDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="editCarrierDetailsStatusTitle"><i class="fas fa-info-circle"></i> Edit Carrier Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textEditCarrierDetailsStatusId">
                    <h3>Are you sure you want to deactivate this Carrier?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonEditCarrierDetailsStatus" class="btn btn-danger"><i id="iBtnEditCarrierDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalRestoreCarrierDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="restoreCarrierDetailsStatusTitle"><i class="fas fa-info-circle"></i> Restore Carrier Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textRestoreCarrierDetailsStatusId">
                    <h3>Are you sure you want to restore this Carrier?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonRestoreCarrierDetailsStatus" class="btn btn-primary"><i id="iBtnRestoreCarrierDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    
    <div class="modal fade" id="modalEditLoadingPortDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="editLoadingPortDetailsStatusTitle"><i class="fas fa-info-circle"></i> Edit LoadingPort Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textEditLoadingPortDetailsStatusId">
                    <h3>Are you sure you want to deactivate this Loading Port?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonEditLoadingPortDetailsStatus" class="btn btn-danger"><i id="iBtnEditLoadingPortDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalRestoreLoadingPortDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="restoreLoadingPortDetailsStatusTitle"><i class="fas fa-info-circle"></i> Restore LoadingPort Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textRestoreLoadingPortDetailsStatusId">
                    <h3>Are you sure you want to restore this LoadingPort?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonRestoreLoadingPortDetailsStatus" class="btn btn-primary"><i id="iBtnRestoreLoadingPortDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalEditDestinationPortDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title" id="editDestinationPortDetailsStatusTitle"><i class="fas fa-info-circle"></i> Edit DestinationPort Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textEditDestinationPortDetailsStatusId">
                    <h3>Are you sure you want to deactivate this Destination Port?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonEditDestinationPortDetailsStatus" class="btn btn-danger"><i id="iBtnEditDestinationPortDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    <div class="modal fade" id="modalRestoreDestinationPortDetailsStatus" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title" id="restoreDestinationPortDetailsStatusTitle"><i class="fas fa-info-circle"></i> Restore DestinationPort Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <input type="hidden" id="textRestoreDestinationPortDetailsStatusId">
                    <h3>Are you sure you want to restore this Destination Port?</h3>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="buttonRestoreDestinationPortDetailsStatus" class="btn btn-primary"><i id="iBtnRestoreDestinationPortDetailsIcon" class="fa fa-check"></i> Yes</button>
                </div>

            </div>
        </div>
    </div> 

    

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

        $(document).ready(function(){
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

            $(document).on('click', '.btnEditCustomerDetailsStatus',function(){
                $('#modalEditCompanyDetailsStatus').modal('show');
                let customerDetailsId = $(this).attr('data-id')
                $('#textEditCompanyDetailsStatusId').val(customerDetailsId);
            });

            $('#buttonEditCompanyDetailsStatus').on('click', function(){
                let companyDetailsId = $('#textEditCompanyDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "edit_company_details_status",
                    data: {
                        'company_details_id' : companyDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Company Deactivated!');
                        $('#modalEditCompanyDetailsStatus').modal('hide');
                        dtCustomerDetails.draw();
                    }
                });
            });

            $(document).on('click', '.btnRestoreCustomerDetailsStatus', function(){
                $('#modalRestoreCompanyDetailsStatus').modal('show');
                let customerDetailsId = $(this).attr('data-id')
                $('#textRestoreCompanyDetailsStatusId').val(customerDetailsId);
            });

            $('#buttonRestoreCompanyDetailsStatus').on('click', function(){
                let companyDetailsId = $('#textRestoreCompanyDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "restore_company_status",
                    data: {
                        'company_details_id' : companyDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Company Reactivated!');
                        $('#modalRestoreCompanyDetailsStatus').modal('hide');
                        dtCustomerDetails.draw();
                    }
                });
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

            $(document).on('click', '.btnEditCarrierDetails', function(){
                $('#modalAddCarierDetails').modal('show');
                let carrierDetailsId = $(this).attr('data-id');
                $('#txtCarrierDetailsId').val(carrierDetailsId);
                console.log(carrierDetailsId);

                getCarrierDetailsId(carrierDetailsId);
            });

            $(document).on('click', '.btnEditCarrierDetailsStatus', function(){
                $('#modalEditCarrierDetailsStatus').modal('show');
                let carrierDetailsId = $(this).attr('data-id');
                $('#textEditCarrierDetailsStatusId').val(carrierDetailsId);
            });

            $('#buttonEditCarrierDetailsStatus').on('click', function(){
                let carrierDetailsId = $('#textEditCarrierDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "edit_carrier_details_status",
                    data: {
                        'carrier_details_id' : carrierDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Carrier Deactivated!');
                        $('#modalEditCarrierDetailsStatus').modal('hide');
                        dtCarrierDetails.draw();
                    }
                });
            });

            $(document).on('click', '.btnRestoreCarrierDetailsStatus', function(){
                $('#modalRestoreCarrierDetailsStatus').modal('show');
                let customerDetailsId = $(this).attr('data-id')
                $('#textRestoreCarrierDetailsStatusId').val(customerDetailsId);
            });

            $('#buttonRestoreCarrierDetailsStatus').on('click', function(){
                let carrierDetailsId = $('#textRestoreCarrierDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "restore_carrier_status",
                    data: {
                        'carrier_details_id' : carrierDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Carrier Reactivated!');
                        $('#modalRestoreCarrierDetailsStatus').modal('hide');
                        dtCarrierDetails.draw();
                    }
                });
            });

            // CARRIER DETAILS END 

            // LOADING PORT DETAILS START

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

            $('#formaddLoadingPortDetails').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "add_loading_port_details",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if(response['validation'] == 1){
                            toastr.error('Saving data failed!');
                            if(response['error']['loading_port'] === undefined){
                                $("#txtLoadingPort").removeClass('is-invalid');
                                $("#txtLoadingPort").attr('title', '');
                            }
                            else{
                                $("#txtLoadingPort").addClass('is-invalid');
                                $("#txtLoadingPort").attr('title', response['error']['loading_port']);
                            }
                        }else if(response['result'] == 0){
                            $("#formaddLoadingPortDetails")[0].reset();
                            toastr.success('Succesfully saved!');
                            $('#modaladdLoadingPortDetails').modal('hide');
                            dtLoadingPortDetails.draw();
                        }
                        $("#btnAddLoadingPortDetailsIcon").removeClass('spinner-border spinner-border-sm');
                        $("#btnAddLoadingPortDetails").removeClass('disabled');
                        $("#btnAddLoadingPortDetailsIcon").addClass('fa fa-check');
                    },
                    error: function(data, xhr, status){
                        toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
                    
                });
            });

            $(document).on('click', '.btnEditLoadingPortDetails', function(){
                $('#modaladdLoadingPortDetails').modal('show');
                let loadingPortDetailsId = $(this).attr('data-id');
                $('#txtLoadingPortDetailsId').val(loadingPortDetailsId);
                console.log(loadingPortDetailsId);

                getLoadingPortDetailsId(loadingPortDetailsId);
            });

            $(document).on('click', '.btnEditLoadingPortDetailsStatus', function(){
                $('#modalEditLoadingPortDetailsStatus').modal('show');
                let loadingPortDetailsId = $(this).attr('data-id');
                $('#textEditLoadingPortDetailsStatusId').val(loadingPortDetailsId);
            });

            $('#buttonEditLoadingPortDetailsStatus').on('click', function(){
                let loadingPortDetailsId = $('#textEditLoadingPortDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "edit_loading_port_details_status",
                    data: {
                        'loading_port_details_id' : loadingPortDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Loading Port Deactivated!');
                        $('#modalEditLoadingPortDetailsStatus').modal('hide');
                        dtLoadingPortDetails.draw();
                    }
                });
            });

            $(document).on('click', '.btnRestoreLoadingPortDetailsStatus', function(){
                $('#modalRestoreLoadingPortDetailsStatus').modal('show');
                let customerDetailsId = $(this).attr('data-id')
                $('#textRestoreLoadingPortDetailsStatusId').val(customerDetailsId);
            });

            $('#buttonRestoreLoadingPortDetailsStatus').on('click', function(){
                let loadingPortDetailsId = $('#textRestoreLoadingPortDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "restore_loading_port_status",
                    data: {
                        'loading_port_details_id' : loadingPortDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Loading Port Reactivated!');
                        $('#modalRestoreLoadingPortDetailsStatus').modal('hide');
                        dtLoadingPortDetails.draw();
                    }
                });
            });

            // LOADING PORT DETAILS END

            // DESTINATION PORT DETAILS START

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

            $('#formaddDestinationPortDetails').submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "add_destination_port_details",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function (response) {
                        if(response['validation'] == 1){
                            toastr.error('Saving data failed!');
                            if(response['error']['loading_port'] === undefined){
                                $("#txtDestinationPort").removeClass('is-invalid');
                                $("#txtDestinationPort").attr('title', '');
                            }
                            else{
                                $("#txtDestinationPort").addClass('is-invalid');
                                $("#txtDestinationPort").attr('title', response['error']['loading_port']);
                            }
                        }else if(response['result'] == 0){
                            $("#formaddDestinationPortDetails")[0].reset();
                            toastr.success('Succesfully saved!');
                            $('#modalAddDestinationPortDetails').modal('hide');
                            dtDestinationPortDetails.draw();
                        }
                        $("#btnAddDestinationPortDetailsIcon").removeClass('spinner-border spinner-border-sm');
                        $("#btnAddDestinationPortDetails").removeClass('disabled');
                        $("#btnAddDestinationPortDetailsIcon").addClass('fa fa-check');
                    },
                    error: function(data, xhr, status){
                        toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    }
                });
            });

            $(document).on('click', '.btnEditDestinationPortDetails', function(){
                $('#modalAddDestinationPortDetails').modal('show');
                let destinationPortDetailsId = $(this).attr('data-id');
                $('#txtDestinationPortDetailsId').val(destinationPortDetailsId);
                console.log(destinationPortDetailsId);

                getDestinationPortDetailsId(destinationPortDetailsId);
            });

            $(document).on('click', '.btnEditDestinationPortDetailsStatus', function(){
                $('#modalEditDestinationPortDetailsStatus').modal('show');
                let destinationPortDetailsId = $(this).attr('data-id');
                $('#textEditDestinationPortDetailsStatusId').val(destinationPortDetailsId);
            });

            $('#buttonEditDestinationPortDetailsStatus').on('click', function(){
                let destinationPortDetailsId = $('#textEditDestinationPortDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "edit_destination_port_details_status",
                    data: {
                        'destination_port_details_id' : destinationPortDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Loading Port Deactivated!');
                        $('#modalEditDestinationPortDetailsStatus').modal('hide');
                        dtDestinationPortDetails.draw();
                    }
                });
            });

            $(document).on('click', '.btnRestoreDestinationPortDetailsStatus', function(){
                $('#modalRestoreDestinationPortDetailsStatus').modal('show');
                let destinationPortDetailsId = $(this).attr('data-id');
                $('#textRestoreDestinationPortDetailsStatusId').val(destinationPortDetailsId);
            });

            $('#buttonRestoreDestinationPortDetailsStatus').on('click', function(){
                let destinationPortDetailsId = $('#textRestoreDestinationPortDetailsStatusId').val();
                $.ajax({
                    type: "get",
                    url: "restore_destination_port_status",
                    data: {
                        'destination_port_details_id' : destinationPortDetailsId
                    },
                    dataType: "json",
                    success: function (response) {
                        toastr.success('Loading Port Deactivated!');
                        $('#modalRestoreDestinationPortDetailsStatus').modal('hide');
                        dtDestinationPortDetails.draw();
                    }
                });
            });
            // DESTINATION PORT DETAILS END 
        }); 

        </script>
    @endsection
@endauth

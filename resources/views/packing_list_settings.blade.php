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
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#destinationPortTab" type="button" role="tab">Loading Port Details</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#loadingPortTab" type="button" role="tab">Destination Port Details</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="customerDetailsTab" role="tabpanel">
                                            <div style="float: right;">
                                                <button style="margin-top: 10px; margin-bottom: 10px;" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalAddCustomerDetails" id="btnAddCustomerDetails"><i
                                                        class="fas fa-city"></i> Add Shipment Details 
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
                                                            <th><center><i class="fa fa-cog"></i></center></th>
                                                            <th>Status</th>
                                                            <th>Carrier Name</th>
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
                                <input type="text" class="form-control" id="textSearchPackingListDetails" name="search_packing_list_details" autocomplete="off">
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-primary searchBtn" id="btnShowAddPackingList">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                        <br>
                        
                            <div class="table-responsive">
                                <table id="tblPackingListDetails" class="table table-sm table-bordered table-striped table-hover"style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>PO</th>
                                            <th>Various Contact for Plating Raw Material</th>
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
                                    <input type="text" class="form-control form-control-sm" name="carrier" id="textCarrier" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">From :</label>
                                    <input type="text" class="form-control form-control-sm" name="ship_from" id="textShipFrom" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">To :</label>
                                    <input type="text" class="form-control form-control-sm" name="ship_to" id="textShipTo" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="saveProdData" class="btn btn-primary"><i
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

        dtIpqcInspection = $("#tblCustomerDetails").DataTable({
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
       
        </script>
    @endsection
@endauth

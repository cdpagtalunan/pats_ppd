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
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>OQC Lot Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">OQC Lot Application</li>
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
                                <h3 class="card-title">2. Application of Lot</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered table-hover w-100" id="tblOQCLotApp">
                                        <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Status</th>
                                                <th>Submission</th>
                                                <th>Lot #</th>
                                                <th>Sub Lot #</th>
                                                <th>Required Lot Qty</th>
                                                <th>Lot Qty Applied</th>
                                                <th>Applied By</th>
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
@endsection

@section('js_content')
<script>
    var dtOQCLotApp;
    $(document).ready(function(){
        // dtOQCLotApp = $("#tblOQCLotApp").DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax": {
        //         url: "view_oqc_lot_app",
        //         data: function (param) {
        //             param.po = $("#txtSearchPO").val();
        //         }
        //     },
        //     fixedHeader: true,
        //     "columns": [
        //         { data: "action", orderable:false, searchable:false }
        //     ],
        // }); //end of dataTableDevices
    });
</script>
@endsection
@endauth
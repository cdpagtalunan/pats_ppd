@php $layout = 'layouts.admin_layout'; @endphp
@auth
    @extends($layout)
    @section('title', 'Stamping Working Report')
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
        </style>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Stamping Working Report</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Stamping Working Report</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h3 class="card-title">Stamping Working Report</h3>
                                </div>
                                <div class="card-body">
                                    <div style="float: right;">
                                        <button class="btn btn-primary" id="buttonAddStampingWorkingReport" data-bs-toggle='modal' data-bs-target='#modalStampingWorkingReport'><i class="fa-solid fa-plus"></i> Add</button>
                                    </div> <br><br>
                                    <div class="table-responsive">
                                        <!-- style="max-height: 600px; overflow-y: auto;" -->
                                        <table id="tableStampingWorkingReport" class="table table-sm table-bordered table-striped table-hover"
                                            style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>Machine No.</th>
                                                    <th>Time</th>
                                                    <th>Work Details</th>
                                                    <th>Sequence No.</th>
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

        <div class="modal fade" id="modalStampingWorkingReport" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-xl-custom">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-info-circle text-info"></i> Stamping Working Report Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formStampingWorkingReport" autocomplete="off">
                        @csrf
                        <div class="modal-body">
                            <input type="text" class="d-none" id="textStampingWorkingReportId" name="stamping_working_report_id">
                            <div class="row">
                                <div class="col-3 border px-4">
                                    <div class="py-3 d-flex align-items-center">
                                        <span class="badge badge-secondary">1.</span>&nbsp;Work Details
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <span>A</span>
                                        </div>
                                        <div class="col-10">
                                            <span>Other Activities</span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <span>A1</span>
                                        </div>
                                        <div class="col-10">
                                            <div class="row flex-column">
                                                <span>A1 - Meeting</span>
                                                <span>A2 - 7s</span>
                                                <span>A3 - Shipment preparation</span>
                                            </div>
                                        </div>
                                    </div>


                                    
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <span>B</span>
                                        </div>
                                        <div class="col-10">
                                            <div class="row flex-column">
                                                <span>B-1 Waiting for materials</span>
                                                <span>A2 - 7s</span>
                                                <span>A3 - Shipment preparation</span>
                                            </div>
                                        </div>
                                    </div>


                                    
                                </div>
                                <div class="col-sm-6">
                                    <div class="col border px-4 border">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" id="buttonSubmitStampingWorkingReport">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endsection
@endauth
@extends('layouts.admin_layout')

@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Traceability Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">Traceability Report</li>
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
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card">
                            <div class="card-header">
                                Molding Traceability Report
                            </div>
                            <!-- Start Page Content -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="form-group col-sm-6 flex-column">
                                            <label for="deviceName">Device Name</label>
                                            <select class="form-control form-control"  id="txtdeviceName" name="deviceName" required>
                                                <option value="0" selected disabled>--Select--</option>
                                                <option value="CN171P-02">CN171P-02#IN-VE</option>
                                                <option value="CN171S-07">CN171S-07#IN-VE</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6 flex-column">
                                            <label for="search_po">PO # to be Extracted</label>
                                            <input class="form-control" type="text" name="search_po" id="searchPONumber" autocomplete="off" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                        
                                    </div>
                                    

                                    <div class="row">
                                        <div class="form-group col-sm-6 flex-column">
                                            <label for="date_from">Production Date From:</label>
                                            <input type="text" class="form-control datePickerFrom" name="date_molding_from" id="txtMoldingDatePickerFrom" autocomplete="off" placeholder="yyyy-mm-dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                        </div>
    
                                        <div class="form-group col-sm-6 flex-column">
                                            <label for="date_to">Production Date To:</label>
                                            <input type="text" class="form-control datePickerTo" name="date_molding_to" id="txtMoldingDatePickerTo" autocomplete="off" placeholder="yyyy-mm-dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->
                                <div>
                                    <button style="float: right;" type="submit" id="btnExportReport" class="btn btn-dark"><i id="BtnExportReportIcon" class="fa fa-check"></i> Export</button>
                                </div>
                            </div>
                            <!-- !-- End Page Content -->
                        </div>
                    
                        <!-- /.card -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#txtMoldingDatePickerFrom').datepicker({
                        format: 'yyyy-mm-dd',
                        // format: 'yyyy-mm-dd',
                        forceParse: false, // prevent from clearing existing values from input when no date selected
                        autoclose: true, // autoclose date after selecting date
                        clearBtn: true, // include clear button
                        // daysOfWeekDisabled: [0, 6], // disabled weekends
                        todayHighlight: true,
                        // daysOfWeekHighlighted: [1,2,3,4,5],
                        // datesDisabled: disabledDays,
                    
            });

            
            $('#txtMoldingDatePickerTo').datepicker({
                        format: 'yyyy-mm-dd',
                        // format: 'yyyy-mm-dd',
                        forceParse: false, // prevent from clearing existing values from input when no date selected
                        autoclose: true, // autoclose date after selecting date
                        clearBtn: true, // include clear button
                        // daysOfWeekDisabled: [0, 6], // disabled weekends
                        todayHighlight: true,
                        // daysOfWeekHighlighted: [1,2,3,4,5],
                        // datesDisabled: disabledDays,
                    
            });

            $('#btnExportReport').on('click', function(e){
                console.log('clicked');
                let po_number = $('#searchPONumber').val();
                let date_from = $('#txtMoldingDatePickerFrom').val();
                let date_to = $('#txtMoldingDatePickerTo').val();
                let device_name = $('#txtdeviceName').val();
                // alert(material);

                window.location.href = `export_molding_traceability_report/${po_number}/${date_from}/${date_to}/${device_name}`;
                // $('#modalExportTraceabilityReport').modal('hide');
                $('#searchPONumber').val("");
                $('#txtMoldingDatePickerFrom').val("");
                $('#txtMoldingDatePickerTo').val("");
            });

            $(document).on('click','#modalExportTraceability',function(e){
                $('#searchPONumber').val("");
                $('#txtMoldingDatePickerFrom').val("");
                $('#txtMoldingDatePickerTo').val("");
            });

        });

    </script>
@endsection


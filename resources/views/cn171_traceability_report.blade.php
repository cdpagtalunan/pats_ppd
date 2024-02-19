@extends('layouts.admin_layout')

@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
            <div class="container-fluid">
                {{-- <button class="btn btn-info bgfp" id="modalExportTraceabilityReport" data-toggle="modal" data-target="#modalExportReport"><i class="fas fa-file-download"></i> Export Traceability Report</button> --}}
                <button class="btn btn-info bgfp" id="modalExportTraceability" data-bs-toggle="modal" data-bs-target="#modalExportTraceabilityReport"><i class="fas fa-file-download"></i> Export Traceability Report</button>
                
            </div>

    </div>


           <!-- MODALS -->
        <div class="modal fade" id="modalExportTraceabilityReport" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark">
                        <h4 class="modal-title"><i class="fab fa-stack-overflow"></i> Export Report</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column">
                                        <label>PO # to be Extracted</label>
                                        <input type="text" name="search_po" id="searchPONumber" autocomplete="off">
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="form-group col-sm-6 flex-column">
                                        <label for="date_from">Production Date From:</label>
                                        <input type="text" class="form-control datePickerFrom" name="date_from" id="txtViewDatePickerFrom" autocomplete="off" placeholder="yyyy-mm-dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="form-group col-sm-6 flex-column">
                                        <label for="date_to">Production Date To:</label>
                                        <input type="text" class="form-control datePickerTo" name="date_to" id="txtViewDatePickerTo" autocomplete="off" placeholder="yyyy-mm-dd" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="btnExportReport" class="btn btn-dark"><i id="BtnExportReportIcon" class="fa fa-check"></i> Export</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#txtViewDatePickerFrom').datepicker({
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

            
            $('#txtViewDatePickerTo').datepicker({
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
                let po_number = $('#searchPONumber').val();
                let date_from = $('#txtViewDatePickerFrom').val();
                let date_to = $('#txtViewDatePickerTo').val();

                // console.log(date_from);
                // console.log(date_to);
                $('#modalExportTraceabilityReport').modal('hide');

                window.location.href = `export_cn171_traceability_report/${po_number}/${date_from}/${date_to}`;
                $('#modalExportTraceabilityReportLive').modal('hide');
            });

            $(document).on('click','#modalExportTraceability',function(e){
                $('#searchPONumber').val("");
                $('#txtViewDatePickerFrom').val("");
                $('#txtViewDatePickerTo').val("");
                $('#modalExportTraceabilityReport').attr('data-formid', '').modal('show');
            });

        });

    </script>
@endsection


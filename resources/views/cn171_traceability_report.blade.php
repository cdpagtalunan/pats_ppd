@extends('layouts.admin_layout')

@section('title', 'Dashboard')
@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
            <div class="container-fluid">
                {{-- <button class="btn btn-info bgfp" id="modalExportTraceabilityReport" data-toggle="modal" data-target="#modalExportReport"><i class="fas fa-file-download"></i> Export Traceability Report</button> --}}
                <button class="btn btn-info bgfp" id="modalExportTraceabilityTest" data-bs-toggle="modal" data-bs-target="#modalExportTraceabilityReport"><i class="fas fa-file-download"></i> Export Traceability Report</button>
                
            </div>

    </div>


           <!-- MODALS -->
        <div class="modal fade" id="modalExportTraceabilityReport">
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
            $('#btnExportReport').on('click', function(e){
                let po_number = $('#searchPONumber').val();

                window.location.href = `export_cn171_traceability_report/${po_number}`;
                $('#modalExportTraceabilityReportLive').modal('hide');
            });
        });

    


    </script>
@endsection


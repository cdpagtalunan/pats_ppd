@extends('layouts.admin_layout')

@section('title', 'Export OQC Inspection Record')

@section('content_page')
    <style type="text/css">
    </style>
    @php
        date_default_timezone_set('Asia/Manila');
    @endphp
    <div class="content-wrapper">
        <section class="content p-3">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Export OQC Inspection Record</h5>
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('message') }}</strong>
                                    </div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">PO Number:</span>
                                    </div>
                                    <select class="form-control select2bs5 searchPO" name="search_po_number" id="txtSearchPoNumber"></select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">Process Type:</span>
                                    </div>
                                    <select class="form-control" name="search_process_type" id="txtSearchProcessType">
                                        <option selected disabled> --- Select Process Type --- </option>
                                        <option value="1">First Stamping</option>
                                        <option value="2">Second Stamping</option>
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">From:</span>
                                    </div>
                                    <input type="date" class="form-control" name="from" id="txtSearchFrom" max="<?= date('Y-m-d'); ?>">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">To:</span>
                                    </div>
                                    <input type="date" class="form-control" name="to" id="txtSearchTo" max="<?= date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark float-right" id="btnExportOqcInspectionRecord"><i class="fas fa-file-excel"></i> Export Report</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js_content')
    <script>
        $(document).ready(function(){    
            $('.select2bs5').select2({
                theme: 'bootstrap-5'
            });

            SearchPO($('.searchPO'));

            $('#btnExportOqcInspectionRecord').on('click', function(){
                // let getRecord = $('#txtSearchPoNumber').val();

                let processType = $('#txtSearchProcessType').val();
                let po = $('#txtSearchPoNumber').val();
                let from = $('#txtSearchFrom').val();
                let to = $('#txtSearchTo').val();

                if(po == null){
                    console.log('po',po)
                    alert('Select PO');
                }else if(processType == null){
                    console.log('processType',processType)
                    alert('Select Process Type');
                }else if(from == ''){
                    console.log('from',from)
                    alert('Select Date From');
                }else if(to == ''){
                    console.log('to',to)
                    alert('Select Date To');
                }else{
                    window.location.href = `export_oqc_inspection/${po}/${processType}/${from}/${to}`;
                    $('.alert').remove();
                }
            });

            function SearchPO(cboElement){
                let result = '';
                $.ajax({
                    url: 'search_oqc_inspection_po_no',
                    method: 'get',
                    dataType: 'json',
                    beforeSend: function(){
                        result = '<option selected disabled> -- Loading -- </option>';
                        cboElement.html(result);
                    },
                    success: function(response){
                        if(response['getOqcInspectionPoNo'].length > 0){
                            result = '<option selected disabled> --- Select PO Number ---</option>';
                            for(let index = 0; index < response['getOqcInspectionPoNo'].length; index++){
                                result += '<option value="' + response['getOqcInspectionPoNo'][index].po_no + '">' + response['getOqcInspectionPoNo'][index].po_no + '</option>';
                            }
                        }
                        else{
                            result = '<option value="0" selected disabled> No record found </option>';
                        }
                        cboElement.html(result);
                    }
                });
            }
        });
    </script>
@endsection
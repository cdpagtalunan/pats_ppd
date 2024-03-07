@extends('layouts.admin_layout')

@section('title', 'Export IQC Inspection Record')

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
                                <h5>Export IQC Inspection Record</h5>
                            </div>
                            <div class="card-body">
                                @if(session()->has('message'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session()->get('message') }}</strong>
                                    </div>
                                @endif
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend w-50">
                                        <span class="input-group-text w-100">Material Name:</span>
                                    </div>
                                    <select class="form-control select2bs5 searcMaterialName" name="search_material_name" id="txtSearchMaterialName"></select>
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
                                <button class="btn btn-dark float-right" id="btnExportIqcInspectionRecord"><i class="fas fa-file-excel"></i> Export Report</button>
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

            SearchMaterialName($('.searcMaterialName'));

            $('#btnExportIqcInspectionRecord').on('click', function(){
                let processType = $('#txtSearchProcessType').val();
                let materialName = $('#txtSearchMaterialName').val();
                let from = $('#txtSearchFrom').val();
                let to = $('#txtSearchTo').val();

                if(materialName == null){
                    console.log('materialName',materialName)
                    alert('Select Material Name');
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
                    window.location.href = `export_iqc_inspection/${materialName}/${processType}/${from}/${to}`;
                    $('.alert').remove();
                }
            });

            function SearchMaterialName(cboElement){
                let result = '';
                $.ajax({
                    url: 'search_iqc_inspection_material_name',
                    method: 'get',
                    dataType: 'json',
                    beforeSend: function(){
                        result = '<option selected disabled> -- Loading -- </option>';
                        cboElement.html(result);
                    },
                    success: function(response){
                        if(response['getIqcInspectionMaterialName'].length > 0){
                            result = '<option selected disabled> --- Select Material Name ---</option>';
                            for(let index = 0; index < response['getIqcInspectionMaterialName'].length; index++){
                                result += '<option value="' + response['getIqcInspectionMaterialName'][index].partname + '">' + response['getIqcInspectionMaterialName'][index].partname + '</option>';
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
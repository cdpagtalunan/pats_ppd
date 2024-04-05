<!-- jQuery -->
<script src="{{ asset('public/template/jquery/js/jquery.min.js') }}"></script>

<!-- Bootstrap 5 -->
<script src="{{ asset('public/template/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('public/template/bootstrap/js/popper.min.js') }}"></script>

<!-- AdminLTE -->
<script src="{{ asset('public/template/adminlte/js/adminlte.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('public/template/datatables/js/datatables.min.js') }}"></script>
{{-- <script src="{{ asset('/template/datatables/js/dataTables.bootstrap5.min.js') }}"></script> --}}

<!-- Select2 -->
<script src="{{ asset('public/template/select2/js/select2.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('public/template/toastr/js/toastr.min.js') }}"></script>

<script src="{{ asset('public/template/sweetalert/js/sweetalert2.min.js') }}"></script>

<!-- Bootstrap Datetimepicker -->
<script src="{{ asset('public/template/datetimepicker/js/datetimepicker.js') }}"></script>

<!-- Datepicker -->
<script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>

<!-- smartWizard -->
<script src="{{ asset('public/js/jquery.smartWizard.min.js') }}"></script>

<script src="{{ asset('public/template/moment/moment.min.js') }}"></script>


<script src="{{ asset('public/template/jquerymask/js/jquery.mask.min.js') }}"></script> <!-- Only use for Second Molding -->
<script src="{{ asset('public/template/jquerytimepicker/js/jquery.timepicker.js') }}"></script> <!-- Only use for Second Molding -->
<script src="{{ asset('public/template/thirsttrap/js/thirsttrap2.js') }}"></script> <!-- Only use for Second Molding -->


<!-- Custom JS -->
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "5000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "iconClass":  "toast-custom"
    };
</script>

<script src="{{ asset('public/js/main/Common.js') }}" async></script>
<script src="{{ asset('public/js/main/User.js') }}" async></script>

<script src="{{ asset('public/js/main/UserLevel.js') }}" async></script>
<script src="{{ asset('public/js/main/Device.js') }}" async></script>
<script src="{{ asset('public/js/main/MaterialProcess.js') }}" async></script>
<script src="{{ asset('public/js/main/OqcInspection.js') }}" async></script>

<!-- STAMPING JS -->
<script src="{{ asset('public/js/main/Stamping.js') }}" async></script>
<script src="{{ asset('public/js/main/StampingChecksheet.js') }}" async></script>
<script src="{{ asset('public/js/main/StampingHistory.js') }}" async></script>

<!-- PACKING LIST JS -->
<script src="{{ asset('public/js/main/CustomerDetails.js') }}" async></script>
<script src="{{ asset('public/js/main/CarrierDetails.js') }}" async></script>
<script src="{{ asset('public/js/main/LoadingPortDetails.js') }}" async></script>
<script src="{{ asset('public/js/main/DestinationPortDetails.js') }}" async></script>
<script src="{{ asset('public/js/main/PackingList.js') }}" async></script>
<script src="{{ asset('public/js/main/ReceivingDetails.js') }}" async></script>
<script src="{{ asset('public/js/main/PackingDetails.js') }}" async></script>

{{-- IQC --}}
<script src="{{ asset('public/js/main/IqcInspection.js') }}" async></script>

{{-- MOLDING --}}
<script src="@php echo asset("public/js/main/FirstMolding.js?".date("YmdHis")) @endphp"></script>
<script src="@php echo asset("public/js/main/MoldingIpqcInspection.js?".date("YmdHis")) @endphp"></script>

{{-- Second Molding --}}
<script src="@php echo asset("public/js/main/SecondMolding.js?".date("YmdHis")) @endphp"></script>
<script src="@php echo asset("public/js/main/StampingWorkingReport.js?".date("YmdHis")) @endphp"></script>

{{-- Production History --}}
<script src="@php echo asset("public/js/main/ProductionHistory.js?".date("YmdHis")) @endphp"></script>

{{-- PPC --}}
<script src="@php echo asset("public/js/main/Mimf.js?".date("YmdHis")) @endphp"></script>

{{-- PressStampingMachineChecksheet --}}
<script src="@php echo asset("public/js/main/PressStampingMachineChecksheet.js?".date("YmdHis")) @endphp"></script>

{{-- ASSEMBLY FVI --}}
<script src="{{ asset('public/js/main/AssemblyFVI.js') }}" async></script>

<script src="@php echo asset("public/js/main/MachineParameter.js?".date("YmdHis")) @endphp"></script>






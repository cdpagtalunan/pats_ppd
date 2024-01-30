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

<!-- Datepicker -->
<script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>

<!-- smartWizard -->
<script src="{{ asset('public/js/jquery.smartWizard.min.js') }}"></script>

<script src="{{ asset('public/template/moment/moment.min.js') }}"></script>

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
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "iconClass":  "toast-custom"
    };
</script>

<script src="{{ asset('public/js/main/Common.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/User.js?1234567') }}" async></script>

<script src="{{ asset('public/js/main/UserLevel.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/Device.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/MaterialProcess.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/OqcInspection.js?1234567') }}" async></script>


<script src="{{ asset('public/js/main/Stamping.js?1234567') }}" async></script>

<!-- PACKING LIST JS -->
<script src="{{ asset('public/js/main/CustomerDetails.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/CarrierDetails.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/LoadingPortDetails.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/DestinationPortDetails.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/PackingList.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/ReceivingDetails.js?1234567') }}" async></script>
<script src="{{ asset('public/js/main/PackingDetails.js?1234567') }}" async></script>

{{-- IQC --}}
<script src="{{ asset('public/js/main/IqcInspection.js?1234567') }}"></script>

{{-- MOLDING --}}
<script src="{{ asset('public/js/main/FirstMolding.js?987654') }}"></script>

{{-- Second Molding --}}
<script src="@php echo asset("public/js/main/SecondMolding.js?".date("YmdHis")) @endphp"></script>


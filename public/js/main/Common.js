function resetFormValues() {
    // Reset values
    $("#formAddUser")[0].reset();

    // Reset hidden input fields
    // $("select[name='user_level']", $('#formAddUser')).val(0).trigger('change');

    // Remove invalid & title validation
    $('div').find('input').removeClass('is-invalid');
    $("div").find('input').attr('title', '');
    $('div').find('select').removeClass('is-invalid');
    $("div").find('select').attr('title', '');
}

$("#modalAddUser").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetFormValues();
});

var invalidChars = ["-","+","e"];
$('input[type="number"]').on('keydown', function(e){
    if (invalidChars.includes(e.key)) {
        e.preventDefault();
    }
});


// * RESET
function resetDeviceAddValues() {
    // Reset values
    $("#formAddDevice")[0].reset();

    console.log('resetDeviceAddValues');
    // Reset hidden input fields
    // $("select[name='user_level']", $('#formAddUser')).val(0).trigger('change');

    // Remove invalid & title validation
    $("#txtAddDeviceName").removeClass('is-invalid');
    $("#txtAddDeviceName").attr('title', '');
    $("#txtAddDeviceCode").removeClass('is-invalid');
    $("#txtAddDeviceCode").attr('title', '');
    $("#selStampStep").removeClass('is-invalid');
    $("#selStampStep").attr('title', '');
}

$("#modalAddDevice").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetDeviceAddValues();
});


function resetMatProcValues() {
    // Reset values
    $("#formAddMatProc")[0].reset();

    // Reset hidden input fields
    $("#selAddMatProcProcess").val("").trigger('change');
    $("#selAddMatProcMachine").val("").trigger('change');
    $('select[name="material_name[]"]').val(0).trigger('change');
    $('#txtAddMatProcId').val('');
    $('#txtAddMatProcStep').prop('readonly', true);
}

$("#modalAddMatProc").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetMatProcValues();
});

function resetFormProcessValues() {
    // Reset values
    $("#formProcess")[0].reset();
}

$("#modalAddProcess").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetFormProcessValues();
});

function resetFormProdValues() {
    // Reset values
    $("#formProdData")[0].reset();
    $('#formProdData').find('input').removeClass('is-invalid'); // remove all invalid
    $('#saveProdData').show();

}

$("#modalMachineOp").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetFormProdValues();
});

/* Select 2 Attr */

$('.select2bs4').each(function () {
    $(this).select2({
        theme: 'bootstrap-5',
        dropdownParent: $(this).parent(),
    });
});

$(this).on('select2:open', function(e) {
    setTimeout(function () {
        document.querySelector('input.select2-search__field').focus();
    }, 0);
});

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
    $('.appendDiv').remove();
    $('#btnRemoveMatNo').addClass('d-none');
    $('#divProdLotInput').removeClass('d-none');
    $('#divProdLotView').addClass('d-none');
    $('select[name="opt_name[]"]').val(0).trigger('change');

    // $('input',)
    $('#txtProdSamp').prop('readonly', false);
    $('#txtTtlMachOutput').prop('readonly', false);
    $('#txtProdDate').prop('readonly', false);

    $('#selOperator').prop('disabled', false);
    $('#txtOptShift').prop('readonly', false);
    $('#txtInptCoilWeight').prop('readonly', false);
    $('#txtSetupPin').prop('readonly', false);
    $('#txtAdjPin').prop('readonly', false);
    $('#txtQcSamp').prop('readonly', false);
    $('#selOperator').prop('readonly', false);
    $('#txtTargetOutput').prop('readonly', false);
    $('#prodLotNoExt1').prop('readonly', false);
    $('#prodLotNoExt2').prop('readonly', false);
    // $('.matNo').prop('readonly', false);
    $('input[name="cut_point"]').prop('disabled', false);
    $('#radioCutPointWithout').prop('checked', true);



    // $('#radioIQC').attr('checked', false);
    // $('#radioMassProd').attr('checked', false);
}

$("#modalMachineOp").on('hidden.bs.modal', function () {
    console.log('hidden.bs.modal');
    resetFormProdValues();
});

function validateUser(userId, validPosition, callback){ // this function will accept scanned id and validPosition based on user table (number only)
    $.ajax({
        type: "get",
        url: "validate_user",
        data: {
            'id'    : userId,
            'pos'   : validPosition
        },
        dataType: "json",
        success: function (response) {
            let value1
            if(response['result'] == 1){
                value1 = true;
            }
            else{
                value1 = false;
            }

            callback(value1);
        }
    });
}
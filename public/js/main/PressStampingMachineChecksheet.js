const saveDailyChecksheet = (scannedId) => {
    let data = $.param({'scanned_id': scannedId}) + "&" + $('#formAddDailyChecksheet').serialize();

    $.ajax({
        type: "post",
        url: "add_daily_checksheet",
        data: data,
        dataType: "json",
        success: function (response) {
            if(response['result'] == true){
                $('#modalScanQRSave').modal('hide');
                $('#modalAddChecksheet').modal('hide');
                dtDailyChecksheet.draw();
                toastr.success('Transaction Successful!');
            }
        },
        error: function(data, xhr, status){
            toastr.error(`${data.responseJSON.msg}`);
        }
    });
}

const getDailyChecksheet = (id, checkFunction) => {
    $.ajax({
        type: "get",
        url: "get_daily_checksheet_data",
        data: {
            "id" : id,
            "fn" : checkFunction
        },
        dataType: "json",
        beforeSend: function (){
            getMachineForChecksheet($('#selMachine'));
            if(checkFunction == 0){
                $('#btnSave').hide();
                $('input', $('#formAddChecksheet')).prop('disabled', true);
                $('#txtRemarks', $('#formAddChecksheet')).prop('disabled', true);
                $('select', $('#formAddChecksheet')).prop('disabled', true);
            }
        },
        success: function (response) {
            $('#modalAddChecksheet').modal('show');

            $('#txtCheckId').val(`${response['id']}`);
            $('#txtCheckBy').val(`${response['firstname']} ${response['lastname']}`);
            $('#txtCheckDate').val(response['date']);
            $('#txtCheckCondBy').val(response['conducted_by']);
            $('#txtShift').val(response['shift']);
            $('#selMachine').val(response['machine_id']).trigger('change');
            $('#txtRemarks').val(response['remarks']);
            // $("input[name=checkA1_1]").val();
            $(`input:radio[name="checkA1_1"][value="${response['checksheet_A_1_1']}"]`).prop('checked', true);
            $(`input:radio[name="checkA1_2"][value="${response['checksheet_A_1_2']}"]`).prop('checked', true);
            $(`input:radio[name="checkA1_3"][value="${response['checksheet_A_1_3']}"]`).prop('checked', true);
            $(`input:radio[name="checkA1_4"][value="${response['checksheet_A_1_4']}"]`).prop('checked', true);
            $(`input:radio[name="checkA1_5"][value="${response['checksheet_A_1_5']}"]`).prop('checked', true);
            $(`input:radio[name="checkA1_6"][value="${response['checksheet_A_1_6']}"]`).prop('checked', true);

            $(`input:radio[name="checkA2_1"][value="${response['checksheet_A_2_1']}"]`).prop('checked', true);
            $(`input:radio[name="checkA2_2"][value="${response['checksheet_A_2_2']}"]`).prop('checked', true);
            $(`input:radio[name="checkA2_3"][value="${response['checksheet_A_2_3']}"]`).prop('checked', true);
            $(`input:radio[name="checkA2_4"][value="${response['checksheet_A_2_4']}"]`).prop('checked', true);

            $(`input:radio[name="checkA3_1"][value="${response['checksheet_A_3_1']}"]`).prop('checked', true);
            
        },
        error: function(data, xhr, status){
            alert('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}
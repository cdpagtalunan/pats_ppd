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
                $('#modalAddDailyChecksheet').modal('hide');
                dtDailyChecksheet.draw();
                toastr.success('Transaction Successful!');
            }
        },
        error: function(data, xhr, status){
            toastr.error(`${data.responseJSON.msg}`);
        }
    });
}

const getDailyChecksheet = (dailyCheckSheetId, checkStatus) => {
    $.ajax({
        type: "get",
        url: "get_daily_checksheet_data",
        data: {
            "id" : dailyCheckSheetId,
            "stat" : checkStatus
        },
        dataType: "json",
        beforeSend: function (){
            getMachineForChecksheet($('#selMachine'));
            // console.log(checkStatus);
            if(checkStatus == 0){
                $('#btnCheck').prop('hidden', false);
                $('#btnSave').hide();
                $('#btnConform').hide();
                $('input', $('#formAddDailyChecksheet')).prop('disabled', true);
                $('select', $('#formAddDailyChecksheet')).prop('disabled', true);
            }else if(checkStatus == 1){
                $('#btnConform').prop('hidden', false);
                $('#btnSave').hide();
                $('#btnCheck').hide();
                $('input', $('#formAddDailyChecksheet')).prop('disabled', true);
                $('select', $('#formAddDailyChecksheet')).prop('disabled', true);
            }else{
                $('#btnSave').hide();
                $('#btnCheck').hide();
                $('#btnConform').hide();
                $('input', $('#formAddDailyChecksheet')).prop('disabled', true);
                $('select', $('#formAddDailyChecksheet')).prop('disabled', true);
            }
        },
        success: function (response) {
            $('#modalAddDailyChecksheet').modal('show');

            if(response['checked_by_engineer'] != null){
                $('#txtCheckedBy').val(`${response['checked_by_engineer']}`);
            }

            if(response['conformed_by_qc'] != null){
                $('#txtConformedByQC').val(`${response['conformed_by_qc']}`);
            }

            $('#txtunitNo').val(response['unit_no']).trigger('change');
            $('#selMachine').val(response['machine_id']).trigger('change');
            $('#txtConformedBy').val(`${response['conformed_by']}`);
            $('#txtConductedBy').val(`${response['conducted_by_operator']}`);
            $('#txtCheckDate').val(`${response['date']}`);
            $('#txtCheckTime').val(`${response['time']}`);
            $('#txtMonth').val(`${response['month']}`);
            $('#txtCheckDiv').val(`${response['division']}`);
            $('#txtArea').val(`${response['area']}`);
            $('#txtActualMeasurement').val(`${response['actual_measurement_d1']}`);
            $('#txtActualMeasurement2').val(`${response['actual_measurement_d2']}`);

            $(`input:radio[name="result_1"][value="${response['result_d1']}"]`).prop('checked', true);
            $(`input:radio[name="result_2"][value="${response['result_d2']}"]`).prop('checked', true);
            $(`input:radio[name="result_3"][value="${response['result_d3']}"]`).prop('checked', true);
            $(`input:radio[name="result_4"][value="${response['result_d4']}"]`).prop('checked', true);
            $(`input:radio[name="result_5"][value="${response['result_d5']}"]`).prop('checked', true);
            $(`input:radio[name="result_6"][value="${response['result_d6']}"]`).prop('checked', true);
            $(`input:radio[name="result_7"][value="${response['result_d7']}"]`).prop('checked', true);
            $(`input:radio[name="result_8"][value="${response['result_d8']}"]`).prop('checked', true);
            $(`input:radio[name="result_9"][value="${response['result_d9']}"]`).prop('checked', true);
            $(`input:radio[name="result_10"][value="${response['result_d10']}"]`).prop('checked', true);
            $(`input:radio[name="result_11"][value="${response['result_d11']}"]`).prop('checked', true);
            $(`input:radio[name="result_12"][value="${response['result_d12']}"]`).prop('checked', true);
            $(`input:radio[name="result_13"][value="${response['result_d13']}"]`).prop('checked', true);
            
        },
        error: function(data, xhr, status){
            alert('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const saveWeeklyChecksheet = (scannedId) => {
    let data = $.param({'scanned_id': scannedId}) + "&" + $('#formAddWeeklyChecksheet').serialize();

    $.ajax({
        type: "post",
        url: "add_weekly_checksheet",
        data: data,
        dataType: "json",
        success: function (response) {
            if(response['result'] == true){
                $('#modalScanQrSaveWeekly').modal('hide');
                $('#modalAddWeeklyChecksheet').modal('hide');
                dtWeeklyChecksheet.draw();
                toastr.success('Transaction Successful!');
            }
        },
        error: function(data, xhr, status){
            toastr.error(`${data.responseJSON.msg}`);
        }
    });
}


const getWeeklyChecksheet = (weeklyChecksheetId, weeklyChecksheetStatus) => {
    $.ajax({
        type: "get",
        url: "get_weekly_checksheet_data",
        data: {
            "id" : weeklyChecksheetId,
            "stat" : weeklyChecksheetStatus
        },
        dataType: "json",
        beforeSend: function (){
            getMachineForChecksheet($('#selWeeklyMachine'));
            // console.log(weeklyChecksheetStatus);
            if(weeklyChecksheetStatus == 0){
                $('#btnWeeklyCheck').prop('hidden', false);
                $('#btnWeeklySave').hide();
                $('#btnWeeklyConform').hide();
                $('input', $('#formAddWeeklyChecksheet')).prop('disabled', true);
                $('select', $('#formAddWeeklyChecksheet')).prop('disabled', true);
            }else if(weeklyChecksheetStatus == 1){
                $('#btnWeeklyConform').prop('hidden', false);
                $('#btnWeeklySave').hide();
                $('#btnWeeklyCheck').hide();
                $('input', $('#formAddWeeklyChecksheet')).prop('disabled', true);
                $('select', $('#formAddWeeklyChecksheet')).prop('disabled', true);
            }else{
                $('#btnWeeklySave').hide();
                $('#btnWeeklyCheck').hide();
                $('#btnWeeklyConform').hide();
                $('input', $('#formAddWeeklyChecksheet')).prop('disabled', true);
                $('select', $('#formAddWeeklyChecksheet')).prop('disabled', true);
            }
        },
        success: function (response) {
            $('#modalAddWeeklyChecksheet').modal('show');
            // console.log(response['machine_id']);
            if(response['checked_by_engineer'] != null){
                $('#txtWeeklyCheckedBy').val(`${response['checked_by_engineer']}`);
            }
            if(response['conformed_by_qc'] != null){
                $('#txtWeeklyConformedByQC').val(`${response['conformed_by_qc']}`);
            }

            $('#txtWeeklyUnitNo').val(response['unit_no']).trigger('change');
            $('#selWeeklyMachine').val(response['machine_id']).trigger('change');
            $('#txtWeeklyConformedBy').val(`${response['conformed_by']}`);
            $('#txtWeeklyConductedBy').val(`${response['conducted_by_operator']}`);
            $('#txtWeeklyCheckDate').val(`${response['date']}`);
            $('#txtWeeklyCheckTime').val(`${response['time']}`);
            $('#txtWeeklyMonth').val(`${response['month']}`);
            $('#txtWeeklyCheckDiv').val(`${response['division']}`);
            $('#txtWeeklyArea').val(`${response['area']}`);
            $('#txtWeek').val(`${response['week']}`);

            $(`input:radio[name="result_w1"][value="${response['result_w1']}"]`).prop('checked', true);
            $(`input:radio[name="result_w2"][value="${response['result_w2']}"]`).prop('checked', true);
            $(`input:radio[name="result_w3"][value="${response['result_w3']}"]`).prop('checked', true);
            
        },
        error: function(data, xhr, status){
            alert('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

// const getWeeklyMachineForChecksheet = (cboElement) => {
//     $.ajax({
//         type: "get",
//         url: "get_weekly_machine",
//         // data: "",
//         dataType: "json",
//         success: function (response) {
//             let result;

//             result += `<option value="0" selected disabled>-- Select --</option>`;
//             for(let x = 0; x< response.length; x++){
//                 result += `<option value="${response[x]['id']}">${response[x]['machine_name']}</option>`;
//             }

//             cboElement.html(result);
//         }
//     });
// }
// 

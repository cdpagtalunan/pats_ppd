const saveAssemblyPreProdData = (scannedId) => {
    let data = $.param({'scanned_id': scannedId}) + "&" + $('#formAddAssemblyPreProd').serialize();

    $.ajax({
        type: "post",
        url: "add_assembly_pre_prod",
        data: data,
        dataType: "json",
        success: function (response) {
            if(response['result'] == true){
                $('#modalScanQRSave').modal('hide');
                $('#modalAddAssemblyPreProd').modal('hide');
                $("#formAddAssemblyPreProd")[0].reset();
                dtAssemblyPreProd.draw();
                toastr.success('Transaction Successful!');
            }
        },
        error: function(data, xhr, status){
            toastr.error(`${data.responseJSON.msg}`);
        }
    });
}

const getAssemblyPreProd = (assemblyPreProdId, assemblyPreProdStatus) => {
    $.ajax({
        type: "get",
        url: "get_assembly_pre_prod",
        data: {
            "id" : assemblyPreProdId,
            "stat" : assemblyPreProdStatus
        },
        dataType: "json",
        beforeSend: function (){

        },
        success: function (response) {

            if(assemblyPreProdStatus == 0){
                $('#btnCheck').prop('hidden', false);
                $('#btnSave').hide();
                $('#btnConform').hide();
                $('input', $('#formAddAssemblyPreProd')).prop('disabled', true);
            }else if(assemblyPreProdStatus == 1){
                $('#btnConform').prop('hidden', false);
                $('#btnSave').hide();
                $('#btnCheck').hide();
                $('input', $('#formAddAssemblyPreProd')).prop('disabled', true);
            }else if(assemblyPreProdStatus == 2){
                $('#btnSave').hide();
                $('#btnCheck').hide();
                $('#btnConform').hide();
                $('input', $('#formAddAssemblyPreProd')).prop('disabled', true);
            }

            $('#modalAddAssemblyPreProd').modal('show');
            // console.log(response['machine_id']);
            let year = response['date'].split("-");
            

            // console.log(year[0]);

                $('#txtEquipmentName').val(`${response['equipment_name']}`);
                $('#txtMachineCode').val(`${response['machine_code']}`);
                $('#txtYear').val(year[0]);
                $('#txtCreationDate').val(`${response['date']}`);
                $('#txtMonth').val(`${response['month']}`);
                $('#txtShift').val(`${response['shift']}`);
                $('#txtCheckDate').val(`${response['date']}`);
                $('#txtCheckTime').val(`${response['time']}`);
                $('#txtRemarks').val(`${response['remarks']}`);
                $('#txtValue1Id').val(`${response['value_1']}`);
                $('#txtValue2Id').val(`${response['value_2']}`);
                $('#txtValue3Id').val(`${response['value_3']}`);
                $('#txtValue4Id').val(`${response['value_4']}`);
                $('#txtValue5Id').val(`${response['value_5']}`);
                $('#txtValue6Id').val(`${response['value_6']}`);

                $('#txtConductedByOperator').val(`${response['conducted_by_operator']}`);
                if(response['checked_by_engineer'] != null){
                    $('#txtCheckByTechEng').val(`${response['checked_by_engineer']}`);
                }

                if(response['conformed_by_qc'] != null){
                    $('#txtConformByQc').val(`${response['conformed_by_qc']}`);
                }

                $(`input:radio[name="check_1"][value="${response['check_1']}"]`).prop('checked', true);
                $(`input:radio[name="check_2"][value="${response['check_2']}"]`).prop('checked', true);
                $(`input:radio[name="check_3"][value="${response['check_3']}"]`).prop('checked', true);
                $(`input:radio[name="judgement_1"][value="${response['judgment_1']}"]`).prop('checked', true);
                $(`input:radio[name="judgement_2"][value="${response['judgment_2']}"]`).prop('checked', true);
                $(`input:radio[name="judgment_3"][value="${response['judgment_3']}"]`).prop('checked', true);
                $(`input:radio[name="judgment_5"][value="${response['judgment_5']}"]`).prop('checked', true);
                $(`input:radio[name="judgment_6"][value="${response['judgment_6']}"]`).prop('checked', true);

                // $('#btnSave').hide();
                            
        },
        error: function(data, xhr, status){
            alert('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const getIssueLogs = (issueLogsId) => {
    $.ajax({
        type: "get",
        url: "get_issue_logs",
        data: {
            "id" : issueLogsId
        },
        dataType: "json",
        beforeSend: function (){

        },
        success: function (response) {
            $('#modalAddIssue').modal('show');

                $('#txtIssue').val(`${response['issue']}`);
                $('#txtIssueDate').val(`${response['date']}`);
                            
        },
        error: function(data, xhr, status){
            alert('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}
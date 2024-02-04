const resetFormValuesOnModalClose = (modalId, formId) => {
    $(`#${modalId}`).on('hidden.bs.modal', function () {
        // Reset form values
        $(`#${formId}`)[0].reset();
        console.log(`modalId ${modalId}`);
        console.log(`formId ${formId}`);

        // Remove invalid & title validation
        $('div').find('input').removeClass('is-invalid');
        $("div").find('input').attr('title', '');
        
        $("#tableSecondMoldingStationMOD tbody").html(''); // Clear Mode of Defect table
    });
}

const isResponseError = (elementId, boolean) => {
    if(boolean == true){
        $(`#${elementId}`).addClass('is-invalid');
        $(`#${elementId}`).attr('title', '');
    }else{
        $(`#${elementId}`).removeClass('is-invalid');
        $(`#${elementId}`).attr('title', '');
    }
}

const delay = (fn, ms) => {
    let timer = 0
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

const redirectToACDCSDrawing = (docNo, docTitle, docType)  => {
    if (docTitle == '' )
        alert('No Document')
    else{
        window.open(`http://rapid/ACDCS/prdn_home_pats_ppd_molding?doc_no=${docNo}&doc_title=${docTitle}&doc_type=${docType}`)
    }
}

const getPOReceivedByPONumber = (poNumber) => {
    $.ajax({
        type: "get",
        url: "get_po_received_by_po_number",
        data: {
            "po_number" : poNumber
        },
        dataType: "json",
        beforeSend: function(){},
        success: function (response) {
            if(response.length > 0){
                $('#textSearchMaterialName').val(response[0]['ItemName']);
                $('#textSearchPOQuantity').val(response[0]['OrderQty']);
                $('#textDeviceName', $('#formSecondMolding')).val(response[0]['ItemName']);
                $('#textPartsCode', $('#formSecondMolding')).val(response[0]['ItemCode']);
                $('#textPONumber', $('#formSecondMolding')).val(response[0]['OrderNo']);
                $('#textPMIPONumber', $('#formSecondMolding')).val(response[0]['ProductPONo']);
                $('#textPoQuantity', $('#formSecondMolding')).val(response[0]['OrderQty']);
                let poQuantity = parseInt(response[0]['OrderQty']);
                let poQuantityPercentage =  poQuantity * 5 * 0.05;
                let sumOfPoPercentagePoQty = poQuantity + poQuantityPercentage;
                $('#textRequiredOutput', $('#formSecondMolding')).val(sumOfPoPercentagePoQty);
            }
            else{
                toastr.error('No PO Found')
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const checkMaterialLotNumber = (qrScannerValue) => {
    $.ajax({
        type: "get",
        url: "check_material_lot_number",
        data: {
            material_lot_number: qrScannerValue,
        },
        dataType: "json",
        success: function (response) {
            $('#textMaterialLotNumber').val('');
            $('#textMaterialName').val('');
            if(response[0] != undefined){
                $('#textMaterialLotNumber').val(response[0].material_lot_number);
                $('#textMaterialName').val(response[0].material_name);
                $('#modalQrScanner').modal('hide');
            }else{
                toastr.error('Incorrect material lot number.')
            }
        }
    });
}

const checkProductionLotNumberOfFirstMolding = (qrScannerValue, formValue) => {
    let textLotNumberValue= '';
    let textLotNumberIdValue = '';
    let firstMoldingDeviceId;
    if(formValue == 'formProductionLotNumberEight'){
        textLotNumberValue = 'textLotNumberEight';
        textLotNumberIdValue = 'textLotNumberEightFirstMoldingId';
        firstMoldingDeviceId = 1;
    }else if(formValue == 'formProductionLotNumberNine'){
        textLotNumberValue = 'textLotNumberNine';
        textLotNumberIdValue = 'textLotNumberNineFirstMoldingId';
        firstMoldingDeviceId = 2;
    }else if(formValue == 'formProductionLotNumberTen'){
        textLotNumberValue = 'textLotNumberTen';
        textLotNumberIdValue = 'textLotNumberTenFirstMoldingId';
        firstMoldingDeviceId = 3;
    }
    $.ajax({
        type: "get",
        url: "check_material_lot_number_of_first_molding",
        data: {
            production_lot_number: qrScannerValue,
        },
        dataType: "json",
        success: function (response) {
            let data = response;
            $(`#${textLotNumberValue}`).val('');
            $(`#${textLotNumberIdValue}`).val('');
            if(data.length > 0){
                if(data[0].first_molding_device_id == firstMoldingDeviceId){
                    $(`#${textLotNumberValue}`).val(data[0].production_lot);
                    $(`#${textLotNumberIdValue}`).val(data[0].first_molding_device_id);
                    $('#modalQrScanner').modal('hide');
                }else{
                    toastr.error('Incorrect material lot number.')
                }
            }else{
                toastr.error('Incorrect material lot number.')
            }
        }
    });
}

const getMaterialProcessStation = () => {
    $.ajax({
        type: "get",
        url: "get_material_process_station",
        async: false,
        data: {
            device_name: $('#textSearchMaterialName').val(),
        },
        dataType: "json",
        success: function (response) {
            let result = '';
            if(response['data'].length > 0){
                for (let i = 0; i < response['data'].length; i++) {
                    result += `<option value="${response['data'][i].station_id}">${response['data'][i].station_name}</option>`;
                }
            }else{
                result += '<option value=""> - No data found - </option>';
            }
            $('#textStation').html(result);
        }
    });
}

const getModeOfDefectForSecondMolding = (elementId) => {
    let result = `<option value="0" selected> N/A </option>`;
    $.ajax({
        url: 'get_mode_of_defect_for_second_molding',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = `<option value="0" selected disabled> - Loading - </option>`;
            elementId.html(result);
        },
        success: function(response){
            result = '';
            if(response['data'].length > 0){
                for(let index = 0; index < response['data'].length; index++){
                    result += `<option value="${response['data'][index].id}">${response['data'][index].defects}</option>`;
                }
            }
            else{
                result = `<option value="0" selected disabled> - No data found - </option>`;
            }
            elementId.html(result);
        },
        error: function(data, xhr, status){
            result = `<option value="0" selected disabled> - Reload Again - </option>`;
            elementId.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const getModeOfDefectForSecondMoldingEdit = (elementId, modeOfDefectId) => {
    let result = `<option value="0" selected> N/A </option>`;
    $.ajax({
        url: 'get_mode_of_defect_for_second_molding',
        method: 'get',
        dataType: 'json',
        beforeSend: function(){
            result = `<option value="0" selected disabled> - Loading - </option>`;
            elementId.html(result);
        },
        success: function(response){
            result = '';
            if(response['data'].length > 0){
                for(let index = 0; index < response['data'].length; index++){
                    result += `<option value="${response['data'][index].id}">${response['data'][index].defects}</option>`;
                }
            }
            else{
                result = `<option value="0" selected disabled> - No data found - </option>`;
            }
            elementId.html(result);
            elementId.val(modeOfDefectId).trigger('change');
        },
        error: function(data, xhr, status){
            result = `<option value="0" selected disabled> - Reload Again - </option>`;
            elementId.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

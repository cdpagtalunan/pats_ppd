const resetFormValuesOnModalClose = (modalId, formId) => {
    $(`#${modalId}`).on('hidden.bs.modal', function () {
        // Reset form values
        $(`#${formId}`)[0].reset();
        console.log(`modalId ${modalId}`);
        console.log(`formId ${formId}`);
    
        // Remove invalid & title validation
        $('div').find('input').removeClass('is-invalid');
        $("div").find('input').attr('title', '');
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
                $('#textPoQuantity', $('#formSecondMolding')).val(response[0]['OrderQty']);
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

const checkMaterialLotNumberOfFirstMolding = (qrScannerValue, formValue) => {
    let textLotNumberValue= '';
    let textLotNumberIdValue = '';
    let firstMoldingDeviceId;
    if(formValue == 'formMaterialLotNumberEight'){
        textLotNumberValue = 'textLotNumberEight';
        textLotNumberIdValue = 'textLotNumberEightFirstMoldingId';
        firstMoldingDeviceId = 1;
    }else if(formValue == 'formMaterialLotNumberNine'){
        textLotNumberValue = 'textLotNumberNine';
        textLotNumberIdValue = 'textLotNumberNineFirstMoldingId';
        firstMoldingDeviceId = 2;
    }else if(formValue == 'formMaterialLotNumberTen'){
        textLotNumberValue = 'textLotNumberTen';
        textLotNumberIdValue = 'textLotNumberTenFirstMoldingId';
        firstMoldingDeviceId = 3;
    }
    $.ajax({
        type: "get",
        url: "check_material_lot_number_of_first_molding",
        data: {
            material_lot_number: qrScannerValue,
        },
        dataType: "json",
        success: function (response) {
            let data = response;
            $(`#${textLotNumberValue}`).val('');
            $(`#${textLotNumberIdValue}`).val('');
            if(data.length > 0){
                if(data[0].first_molding_device_id == firstMoldingDeviceId){
                    $(`#${textLotNumberValue}`).val(data[0].contact_lot_number);
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
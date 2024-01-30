function resetFormValuesOnModalClose(modalId, formId){
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

function isResponseError(elementId, boolean){
    if(boolean == true){
        $(`#${elementId}`).addClass('is-invalid');
        $(`#${elementId}`).attr('title', '');
    }else{
        $(`#${elementId}`).removeClass('is-invalid');
        $(`#${elementId}`).attr('title', '');
    }
}

function delay(fn, ms) {
    let timer = 0
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

function redirectToACDCSDrawing(docNo, docTitle, docType) {
    if (docTitle == '' )
        alert('No Document')
    else{
        window.open(`http://rapid/ACDCS/prdn_home_pats_ppd_molding?doc_no=${docNo}&doc_title=${docTitle}&doc_type=${docType}`)
    }
}

function getWarehouseTransactionByPONumber(poNumber){
    $.ajax({
        type: "get",
        url: "get_search_po_for_molding",
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
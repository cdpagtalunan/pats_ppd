function getReceivingDetailsId(receivingDetailsId){
    $.ajax({
        type: "get",
        url: "get_receiving_details",
        data: {
            "receiving_details_id" : receivingDetailsId,
        },
        dataType: "json",
        success: function (response) {

			if(response['receivingDetails'].length > 0){
                    // $('#txtSannoLotNo').val(response['receivingDetails'][0]['sanno_lot_no'])
                    // $('#txtSannoQty').val(response['receivingDetails'][0]['sanno_quantity'])
                    $('#txtPackingCtrlNo').val(response['receivingDetails'][0]['control_no'])
                    $('#txtPmiMaterialName').val(response['receivingDetails'][0]['mat_name'])
                    $('#txtPmiLotNo').val(response['receivingDetails'][0]['lot_no'])
                    $('#txtPmiQty').val(response['receivingDetails'][0]['quantity']);
			}
			
        }
    });
}

const printReceivingData = async (id) => {
    await $.ajax({
        type: "get",
        url: "print_receiving_qr_code",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {
            response['label_hidden'][0]['id'] = id;
            $("#img_barcode_PO").attr('src', response['qrCode']);
            $("#img_barcode_PO_text").html(response['label']);
            img_barcode_PO_text_hidden = response['label_hidden'];
            $('#modalPrintQr').modal('show');
            console.log(response);


        }
    });
}

const changePrintStatus = (printedId) => {
    $.ajax({
        type: "get",
        url: "change_print_status",
        data: {
            id: printedId
        },
        dataType: "dataType",
        success: function (response) {
            
        }
    });
}

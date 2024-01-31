function getOqcDetailsbyId(oqcDetailsId){
    $.ajax({
        type: "get",
        url: "get_oqc_details",
        data: {
            "oqc_details_id" : oqcDetailsId,
        },
        dataType: "json",
        success: function (response) {

			if(response['oqcData'] != null){
                    $('#txtPONumber').val(response['oqcData']['stamping_production_info']['po_num'])
                    $('#txtPOQuantity').val(response['oqcData']['stamping_production_info']['ship_output'])
                    $('#txtPartsName').val(response['oqcData']['stamping_production_info']['material_name'])
                    $('#txtProdLotNumber').val(response['oqcData']['stamping_production_info']['prod_lot_no'])
                    $('#txtDrawingNumber').val(response['oqcData']['stamping_production_info']['drawing_no'])
                    $('#txtNumberOfCuts').val(response['oqcData']['stamping_production_info']['no_of_cuts'])
			}else{
                toastr.warning('warning messages');
            }
			
        }
    });
}

const generatePackingQr = async (id) => {
    await $.ajax({
        type: "get",
        url: "generate_packing_qr",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {
            response['label_hidden'][0]['id'] = id;
            $("#img_barcode_PO").attr('src', response['qrCode']);
            $("#img_barcode_PO_text").html(response['label']);
            img_barcode_PO_text_hidden = response['label_hidden'];
            $('#modalGeneratePackingDetailsQr').modal('show');
            console.log(response);
        }
    });
}

const changePrintingStatus = (printedId) => {
    // alert(printedId);
    $.ajax({
        type: "get",
        url: "change_printing_status",
        data: {
            id: printedId
        },
        dataType: "dataType",
        success: function (response) {
            
        }
    });
}

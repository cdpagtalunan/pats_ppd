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

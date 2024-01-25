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
			}else{
                toastr.warning('warning messages');
            }
			
        }
    });
}
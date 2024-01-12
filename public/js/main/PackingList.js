function getCarrier(cboElement){
	let result = '<option value="0" disabled selected>Select One</option>';
	$.ajax({
		url: 'get_carrier_data',
		method: 'get',
		dataType: 'json',
		beforeSend: function(){
			result = '<option value="0" disabled>Loading</option>';
			cboElement.html(result);
		},
		success: function(response){
			let disabled = '';
			if(response['carrierDetails'].length > 0){
				result = '<option value="0" disabled selected>Select One</option>';
				for(let index = 0; index < response['carrierDetails'].length; index++){
                    result += '<option value="' + response['carrierDetails'][index].id + '">' + response['carrierDetails'][index].carrier_name + '</option>';
				}
			}
			else{
				result = '<option value="0" disabled>No User Role found</option>';
			}
			cboElement.html(result);
		},
		error: function(data, xhr, status){
			result = '<option value="0" disabled>Reload Again</option>';
			cboElement.html(result);
            console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
	});
}
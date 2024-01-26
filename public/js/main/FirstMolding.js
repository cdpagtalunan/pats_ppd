const formModal = {
    firstMolding  : $("#formFirstMolding"),
}

const dt = {
    firstMolding : "",
}

const getFirstModlingDevices = function (){
    $.ajax({
        type: "GET",
        url: "get_first_molding_devices",
        data: "data",
        dataType: "json",
        success: function (response) {
            let first_molding_device_id = response['id'];
            let device_name = response['value'];
            let result = '';

            if(response['id'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < first_molding_device_id.length; index++){
                    result += '<option value="' +first_molding_device_id[index]+'">'+device_name[index]+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            $('select[name="global_device_name"]').html(result);
        }
    });
}

function saveFirstMolding(){
    $.ajax({
        type: "POST",
        url: "save_first_molding",
        data: formModal.firstMolding.serialize(),
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response['result'] === 1){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Saved Successfully !",
                    showConfirmButton: false,
                    timer: 1500
                });
                dt.firstMolding.draw();
                $('#modalFirstMolding').modal('hide');
            }
        },error: function (data, xhr, status){
            if(data.status === 422){
                let errors = data.responseJSON.errors ;
                errorHandler( errors.contact_lot_number,formModal.firstMolding.find('#contact_lot_number') );
                errorHandler( errors.production_lot,formModal.firstMolding.find('#production_lot') );
            }else{
                toastr.error(`Error: ${data.status}`);
            }

        }
    });
}
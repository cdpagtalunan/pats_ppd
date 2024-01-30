var dt = {
    firstMolding : "",
    firstMoldingStation : "",
}

var formModal = {
    firstMolding  : $("#formFirstMolding"),
    firstMoldingStation  : $("#formFirstMoldingStation"),
}
var table = {
    FirstMoldingDetails: $("#tblFirstMoldingDetails"),
    FirstMoldingStationDetails: $("#tblFirstMoldingStationDetails"),
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


const editFirstMolding = function (){
    let first_molding_id = $(this).attr('first-molding-id');
    $.ajax({
        type: "GET",
        url: "get_molding_details",
        data: {"first_molding_id" : first_molding_id},
        dataType: "json",
        success: function (response) {

            let data = response['first_molding'][0];

            formModal.firstMolding.find('#first_molding_id').val(data.id);
            formModal.firstMolding.find('#contact_lot_number').val(data.contact_lot_number);
            formModal.firstMolding.find('#production_lot').val(data.production_lot);
            formModal.firstMolding.find('#remarks').val(data.remarks);
            formModal.firstMolding.find('#created_at').val(data.created_at);
            dt.firstMoldingStation.draw();
            $('#modalFirstMolding').modal('show');
            if(data.status === 1){
                $('#btnFirstMoldingStation').prop('disabled',true);
                $('#btnSubmitFirstMoldingStation').prop('disabled',true);
                $('#btnSubmitFirstMoldingStation').prop('disabled',true);
                $('#btnRuncardDetails').addClass('d-none',true);
            }else{
                $('#btnFirstMoldingStation').prop('disabled',false);
                $('#btnSubmitFirstMoldingStation').prop('disabled',false);
                $('#btnRuncardDetails').removeClass('d-none',true);
            }
        },error: function (data, xhr, status){
            toastr.error(`Error: ${data.status}`);
        }
    });
}
const editFirstMoldingStation = function (){
    let first_molding_station_id = $(this).attr('first-molding-station-id');
    // console.log(first_molding_station_id)
    // return;
    $.ajax({
        type: "GET",
        url: "get_first_molding_station_details",
        data: {"first_molding_station_id" : first_molding_station_id},
        dataType: "json",
        success: function (response) {

            let data = response['first_station_molding'][0];
            console.log(data)
            formModal.firstMoldingStation.find('#first_molding_id').val(data.first_molding_id);
            formModal.firstMoldingStation.find('#first_molding_detail_id').val(data.id);
            formModal.firstMoldingStation.find('#date').val(data.date);
            formModal.firstMoldingStation.find('#operator_name').val(data.operator_name);
            formModal.firstMoldingStation.find('#input').val(data.input);
            formModal.firstMoldingStation.find('#ng_qty').val(data.ng_qty);
            formModal.firstMoldingStation.find('#output').val(data.output);
            formModal.firstMoldingStation.find('#remarks').val(data.remarks);

            setTimeout(() => {
                formModal.firstMoldingStation.find('#station').val(data.station);
            }, 300);

            $('#modalFirstMoldingStation').modal('show');
            getStation();
        },error: function (data, xhr, status){
            toastr.error(`Error: ${data.status}`);
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

const savefirstMoldingStation = function (){
    $.ajax({
        type: "POST",
        url: "save_first_molding_station",
        data: formModal.firstMoldingStation.serialize(),
        dataType: "json",
        success: function (response) {
            if(response['result'] === 1){
                $('#modalFirstMoldingStation').modal('hide');
                formModal.firstMoldingStation[0].reset();
                dt.firstMoldingStation.draw();
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Saved Successfully !",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        },error: function (data, xhr, status){
            let errors = data.responseJSON.errors ;
            if(data.status === 422){
                toastr.error(`Saving Failed, Please fill up all required fields`);
                errorHandler( errors.first_molding_id,formModal.firstMoldingStation.find('#first_molding_id') );
                errorHandler( errors.station,formModal.firstMoldingStation.find('#station') );
                errorHandler( errors.date,formModal.firstMoldingStation.find('#date') );
                errorHandler( errors.operator_name,formModal.firstMoldingStation.find('#operator_name') );
                errorHandler( errors.input,formModal.firstMoldingStation.find('#input') );
                errorHandler( errors.ng_qty,formModal.firstMoldingStation.find('#ng_qty') );
                errorHandler( errors.output,formModal.firstMoldingStation.find('#output') );
            }else{
                toastr.error(`Error: ${data.status}`);
            }

        }
    });
}


const getStation = function (){
    $.ajax({
        type: "GET",
        url: "get_stations",
        data: "data",
        dataType: "json",
        success: function (response) {
            let id = response['id'];
            let value = response['value'];
            let result = '';
            console.log(response)
            if(response['id'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < id.length; index++){
                    result += '<option value="' +id[index]+'">'+value[index]+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            $('select[name="station"]').html(result);
        }
    });
}



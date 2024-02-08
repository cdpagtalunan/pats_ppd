const saveChecksheet = () => {
    $.ajax({
        type: "post",
        url: "save_checksheet",
        data: $('#formAddChecksheet').serialize(),
        dataType: "json",
        success: function (response) {
            
        }
    });
}

const getMachineForChecksheet = (cboElement) => {
    $.ajax({
        type: "get",
        url: "get_machine_dropdown",
        // data: "",
        dataType: "json",
        success: function (response) {
            let result;

            result += `<option value="0" selected disabled>-- Select --</option>`;
            for(let x = 0; x< response.length; x++){
                result += `<option value="${response[x]['id']}">${response[x]['machine_name']}</option>`;
            }

            cboElement.html(result);
        }
    });
}
const getOperatorList = (cboElement) => {
    $.ajax({
        type: "get",
        url: "get_optr_list",
        data: "",
        dataType: "json",
        success: function (response) {
            console.log(response);
            let result = "";
            for(let x = 0; x<response.length; x++){
                result += `<option value="${response[x]['id']}">${response[x]['firstname']} ${response[x]['lastname']}</option>`;
            }

            cboElement.html(result);
        }
    });
}

const getMaterialList = (cboElement) => {
    $.ajax({
        type: "get",
        url: "get_material_list",
        data: "",
        dataType: "json",
        success: function (response) {
            console.log(response);
            let result = "";
            for (let x = 0; x < response.length; x++) {
                result += `<option value="${response[x]['id']}">${response[x]['firstname']} ${response[x]['lastname']}</option>`;
            }

            cboElement.html(result);
        }
    });
}

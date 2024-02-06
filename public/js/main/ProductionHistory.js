// const getOperatorList = (cboElement) => {
//     $.ajax({
//         type: "get",
//         url: "get_optr_list",
//         data: "",
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//             let result = "";
//             for(let x = 0; x<response.length; x++){
//                 result += `<option value="${response[x]['id']}">${response[x]['firstname']} ${response[x]['lastname']}</option>`;
//             }

//             cboElement.html(result);
//         }
//     });
// }

// const getMaterialList = (cboElement) => {
//     $.ajax({
//         type: "get",
//         url: "get_material_list",
//         data: "",
//         dataType: "json",
//         success: function (response) {
//             console.log(response);
//             let result = "";
//             for (let x = 0; x < response.length; x++) {
//                 result += `<option value="${response[x]['id']}">${response[x]['firstname']} ${response[x]['lastname']}</option>`;
//             }

//             cboElement.html(result);
//         }
//     });
// }

// const getMachineDropdown = (cboElement, materialName) => {
//     $.ajax({
//         type: "get",
//         url: "get_machine",
//         data: {
//             "material_name" : materialName
//         },
//         dataType: "json",
//         success: function (response) {
//             let result = '';
//             console.log(response['machine']);
//             if(response['machine'].length > 0){
//                 for(let index = 0; index < response['machine'].length; index++){
//                     result += `<option value="${response['machine'][index].machine_name}">${response['machine'][index].machine_name}</option>`;
//                 }
//             }

//             cboElement.html(result);

//         }
//     });
// }

function AddProdnHistory() {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "3000",
        "timeOut": "3000",
        "extendedTimeOut": "3000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
    };

    $.ajax({
        url: "add_prodn_history",
        method: "post",
        data: $('#formProductionHistory').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnAddUserIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnSubmit").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#modalProductionHistory").modal('hide');
                $("#formProductionHistory")[0].reset();
                ProductionHistory.draw();
                toastr.success('Production History was succesfully saved!');
            }
            else {
                toastr.error('Saving Production History Failed!');

                if (JsonObject['error']['machine_no'] === undefined) {
                    $("#machine_no").removeClass('is-invalid');
                    $("#machine_no").attr('title', '');
                }else {
                    $("#machine_no").addClass('is-invalid');
                    $("#machine_no").attr('title', JsonObject['error']['machine_no']);
                }

                if (JsonObject['error']['standard_para_date'] === undefined) {
                    $("#standard_para_date").removeClass('is-invalid');
                    $("#standard_para_date").attr('title', '');
                }else {
                    $("#standard_para_date").addClass('is-invalid');
                    $("#standard_para_date").attr('title', JsonObject['error']['standard_para_date']);
                }



            }

            $("#ibtnSubmitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmit").removeAttr('disabled');
            $("#ibtnSubmitIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmit").removeAttr('disabled');
            $("#ibtnSubmitIcon").addClass('fa fa-check');
        }
    });
}

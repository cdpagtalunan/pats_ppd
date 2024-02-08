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
            // $("#btnSubmit").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                $("#modalProductionHistory").modal('hide');
                // $("#formProductionHistory")[0].reset();
                $("#prodn_stime").val('');
                $("#machine_no").val('');
                $("#standard_para_date").val('');
                $("#standard_para_attach").val('');
                $("#act_cycle_time").val('');
                $("#shot_weight").val('');
                $("#product_weight").val('');
                $("#screw_most_fwd").val('');
                $("#ccd_setting_s1").val('');
                $("#ccd_setting_s2").val('');
                $("#ccd_setting_ng").val('');
                $("#changes_para").val('');
                $("#remarks").val('');
                $("#opt_id").val('');
                $("#opt_name").val('');
                $("#opt_name").val('');

                // $("#ibtnSubmitIcon").removeClass('fa fa-spinner fa-pulse');
                // $("#btnSubmit").removeAttr('disabled');
                // $("#ibtnSubmitIcon").addClass('fa fa-check');

                ProductionHistory.draw();
                toastr.success('Production History was succesfully saved!');
            }
            else {
                toastr.error('Saving Productionsss History Failed!');
                if (JsonObject['error']['prodn_stime'] === undefined) {
                    $("#prodn_stime").removeClass('is-invalid');
                    $("#prodn_stime").attr('title', '');
                } else {
                    $("#prodn_stime").addClass('is-invalid');
                    $("#prodn_stime").attr('title', JsonObject['error']['prodn_stime']);
                }
                // if (JsonObject['error']['machine_no'] === undefined) {
                //     $("#machine_no").removeClass('is-invalid');
                //     $("#machine_no").attr('title', '');
                // }else {
                //     $("#machine_no").addClass('is-invalid');
                //     $("#machine_no").attr('title', JsonObject['error']['machine_no']);
                // }
                if (JsonObject['error']['standard_para_date'] === undefined) {
                    $("#standard_para_date").removeClass('is-invalid');
                    $("#standard_para_date").attr('title', '');
                }else {
                    $("#standard_para_date").addClass('is-invalid');
                    $("#standard_para_date").attr('title', JsonObject['error']['standard_para_date']);
                }
                if (JsonObject['error']['act_cycle_time'] === undefined) {
                    $("#act_cycle_time").removeClass('is-invalid');
                    $("#act_cycle_time").attr('title', '');
                } else {
                    $("#act_cycle_time").addClass('is-invalid');
                    $("#act_cycle_time").attr('title', JsonObject['error']['act_cycle_time']);
                }
                if (JsonObject['error']['shot_weight'] === undefined) {
                    $("#shot_weight").removeClass('is-invalid');
                    $("#shot_weight").attr('title', '');
                } else {
                    $("#shot_weight").addClass('is-invalid');
                    $("#shot_weight").attr('title', JsonObject['error']['shot_weight']);
                }
                if (JsonObject['error']['product_weight'] === undefined) {
                    $("#product_weight").removeClass('is-invalid');
                    $("#product_weight").attr('title', '');
                } else {
                    $("#product_weight").addClass('is-invalid');
                    $("#product_weight").attr('title', JsonObject['error']['product_weight']);
                }
                if (JsonObject['error']['screw_most_fwd'] === undefined) {
                    $("#screw_most_fwd").removeClass('is-invalid');
                    $("#screw_most_fwd").attr('title', '');
                } else {
                    $("#screw_most_fwd").addClass('is-invalid');
                    $("#screw_most_fwd").attr('title', JsonObject['error']['screw_most_fwd']);
                }
                if (JsonObject['error']['ccd_setting_s1'] === undefined) {
                    $("#ccd_setting_s1").removeClass('is-invalid');
                    $("#ccd_setting_s1").attr('title', '');
                } else {
                    $("#ccd_setting_s1").addClass('is-invalid');
                    $("#ccd_setting_s1").attr('title', JsonObject['error']['ccd_setting_s1']);
                }
                if (JsonObject['error']['ccd_setting_s2'] === undefined) {
                    $("#ccd_setting_s2").removeClass('is-invalid');
                    $("#ccd_setting_s2").attr('title', '');
                } else {
                    $("#ccd_setting_s2").addClass('is-invalid');
                    $("#ccd_setting_s2").attr('title', JsonObject['error']['ccd_setting_s2']);
                }
                if (JsonObject['error']['ccd_setting_ng'] === undefined) {
                    $("#ccd_setting_ng").removeClass('is-invalid');
                    $("#ccd_setting_ng").attr('title', '');
                } else {
                    $("#ccd_setting_ng").addClass('is-invalid');
                    $("#ccd_setting_ng").attr('title', JsonObject['error']['ccd_setting_ng']);
                }
                if (JsonObject['error']['remarks'] === undefined) {
                    $("#remarks").removeClass('is-invalid');
                    $("#remarks").attr('title', '');
                } else {
                    $("#remarks").addClass('is-invalid');
                    $("#remarks").attr('title', JsonObject['error']['remarks']);
                }
                if (JsonObject['error']['opt_id'] === undefined) {
                    $("#opt_name").removeClass('is-invalid');
                    $("#opt_name").attr('title', '');
                } else {
                    $("#opt_name").addClass('is-invalid');
                    $("#opt_name").attr('title', JsonObject['error']['opt_id']);
                }

                if (JsonObject['error']['shots'] === undefined) {
                    $("#shots").removeClass('is-invalid');
                    $("#shots").attr('title', '');
                } else {
                    $("#shots").addClass('is-invalid');
                    $("#shots").attr('title', JsonObject['error']['shots']);
                }
                if (JsonObject['error']['prodn_etime'] === undefined) {
                    $("#prodn_etime").removeClass('is-invalid');
                    $("#prodn_etime").attr('title', '');
                } else {
                    $("#prodn_etime").addClass('is-invalid');
                    $("#prodn_etime").attr('title', JsonObject['error']['prodn_etime']);
                }
                if (JsonObject['error']['qc_id'] === undefined) {
                    $("#qc_name").removeClass('is-invalid');
                    $("#qc_name").attr('title', '');
                } else {
                    $("#qc_name").addClass('is-invalid');
                    $("#qc_name").attr('title', JsonObject['error']['qc_id']);
                }
                if (JsonObject['error']['material_lot'] === undefined) {
                    $("#material_lotno").removeClass('is-invalid');
                    $("#material_lotno").attr('title', '');
                } else {
                    $("#material_lotno").addClass('is-invalid');
                    $("#material_lotno").attr('title', JsonObject['error']['material_lot']);
                }




            }

            // $("#ibtnSubmitIcon").removeClass('fa fa-spinner fa-pulse');
            // $("#btnSubmit").removeAttr('disabled');
            // $("#ibtnSubmitIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#ibtnSubmitIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnSubmit").removeAttr('disabled');
            $("#ibtnSubmitIcon").addClass('fa fa-check');
        }
    });
}

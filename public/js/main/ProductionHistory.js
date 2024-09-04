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
                // $("#modalProductionHistory").modal('hide');
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

                // ProductionHistory.draw();
                toastr.success('Production History was succesfully saved!');
            }else {
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

                // if (JsonObject['error']['shots'] === undefined) {
                //     $("#shots").removeClass('is-invalid');
                //     $("#shots").attr('title', '');
                // } else {
                //     $("#shots").addClass('is-invalid');
                //     $("#shots").attr('title', JsonObject['error']['shots']);
                // }
                // if (JsonObject['error']['prodn_etime'] === undefined) {
                //     $("#prodn_etime").removeClass('is-invalid');
                //     $("#prodn_etime").attr('title', '');
                // } else {
                //     $("#prodn_etime").addClass('is-invalid');
                //     $("#prodn_etime").attr('title', JsonObject['error']['prodn_etime']);
                // }
                // if (JsonObject['error']['qc_id'] === undefined) {
                //     $("#qc_name").removeClass('is-invalid');
                //     $("#qc_name").attr('title', '');
                // } else {
                //     $("#qc_name").addClass('is-invalid');
                //     $("#qc_name").attr('title', JsonObject['error']['qc_id']);
                // }
                // if (JsonObject['error']['material_lot'] === undefined) {
                //     $("#material_lotno").removeClass('is-invalid');
                //     $("#material_lotno").attr('title', '');
                // } else {
                //     $("#material_lotno").addClass('is-invalid');
                //     $("#material_lotno").attr('title', JsonObject['error']['material_lot']);
                // }




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

const getFirstModlingDevicesForHistory = () => {
    $.ajax({
        type: "GET",
        url: "get_first_molding_devices_for_history",
        data: "data",
        dataType: "json",
        success: function (response) {
            let first_molding_device_data = response['data'];
            // let device_name = response['value'];
            let result = '';

            if(first_molding_device_data.length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < first_molding_device_data.length; index++){
                    result += '<option value="' +first_molding_device_data[index]['id']+'">'+first_molding_device_data[index]['device_name']+'</option>';
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>';
            }
            $('select[name="global_device_name"]').html(result);
        }
    });
}

const getProdHistoryById = (pId, btnFunction, firstMoldingDevId) => {
    // 0= viewing, 1-edit
    /*
        * firstMoldingDevId => for viewing purposes only.
        * check getFirstMoldingDeviceById() on blade for reference
    */
    $.ajax({
        type: "get",
        url: "get_prodn_history_by_id",
        data: {
            "id" : pId
        },
        dataType: "json",
        beforeSend: function(){
            if(btnFunction == 0){
                console.log(btnFunction);
                $('#prodn_stime', $('#formProductionHistory')).prop('readonly', true);
                $('#standard_para_date', $('#formProductionHistory')).prop('readonly', true);
                $('#act_cycle_time', $('#formProductionHistory')).prop('readonly', true);
                $('#shot_weight', $('#formProductionHistory')).prop('readonly', true);
                $('#product_weight', $('#formProductionHistory')).prop('readonly', true);
                $('#screw_most_fwd', $('#formProductionHistory')).prop('readonly', true);
                $('#ccd_setting_s1', $('#formProductionHistory')).prop('readonly', true);
                $('#ccd_setting_s2', $('#formProductionHistory')).prop('readonly', true);
                $('#ccd_setting_ng', $('#formProductionHistory')).prop('readonly', true);
                $('#changes_para', $('#formProductionHistory')).prop('readonly', true);
                $('#shots', $('#formProductionHistory')).prop('readonly', true);
                $('#remarks', $('#formProductionHistory')).prop('readonly', true);
                $('#prodn_etime', $('#formProductionHistory')).prop('readonly', true);
                $('#machine_no', $('#formProductionHistory')).prop('readonly', true);
                $('#btnScanQrMaterialLotNo', $('#formProductionHistory')).prop('disabled', true);
                $('#btnScanQrPMaterialLotNo', $('#formProductionHistory')).prop('disabled', true);
                $('#btnSubmit',  $('#formProductionHistory')).hide();
                $('.divBtnMultiples').attr('style', 'display: none !important');

            }
        },
        success: function (data) {
            let prodPartsMat; //collection

            //get machine
            getMachineDropdown($('#machine_no'), $('#device_name').val());
            $('#prodn_history_id').val(pId);
            $('#prodn_date').val(data['prodHistory']['prodn_date']);
            $('#prodn_stime').val(data['prodHistory']['prodn_stime']);
            $('#shift').val(data['prodHistory']['shift']);
            $('#machine_no').val(data['prodHistory']['machine_no']);
            $('#standard_para_date').val(data['prodHistory']['standard_para_date']);
            $('#standard_para_attach').val(data['prodHistory']['standard_para_attach']);
            $('#act_cycle_time').val(data['prodHistory']['act_cycle_time']);
            $('#shot_weight').val(data['prodHistory']['shot_weight']);
            $('#product_weight').val(data['prodHistory']['product_weight']);
            $('#screw_most_fwd').val(data['prodHistory']['screw_most_fwd']);
            $('#ccd_setting_s1').val(data['prodHistory']['ccd_setting_s1']);
            $('#ccd_setting_s2').val(data['prodHistory']['ccd_setting_s2']);
            $('#ccd_setting_ng').val(data['prodHistory']['ccd_setting_ng']);
            $('#changes_para').val(data['prodHistory']['changes_para']);
            $("#remarks").val(data['prodHistory']['remarks']).trigger('change');
            $('#opt_name').val(data['prodHistory']['operator_info']['firstname']+' '+data['prodHistory']['operator_info']['lastname']);
            $('#opt_id').val(data['prodHistory']['opt_id']);

            if (data['prodHistory']['qc_info'] != null){
                $('#qc_name').val(data['prodHistory']['qc_info']['firstname']+' '+data['prodHistory']['qc_info']['lastname']);
            }else{
                $('#qc_name').val('');
            }
            $('#qc_id').val(data['prodHistory']['qc_id']);

            $('#shots').val(data['prodHistory']['shots']);
            $('#prodn_etime').val(data['prodHistory']['prodn_etime']);

            $('#material_lotno').val(data['prodHistory']['material_lot']);

            $('#shots').prop('readonly',false);
            $('#prodn_etime').prop('readonly',false);

            $('#btnScanQrQCID').prop('disabled',false);
            $('#btnScanQrMaterialLotNo').prop('disabled',false);
            $('#btnScanQrPMaterialLotNo').prop('disabled',false);

            if(data['prodHistoryPartMat'].length != 0){
                if(firstMoldingDevId == 4 || firstMoldingDevId == 5){ // CN171P-02#IN-VE, CN171S-07#IN-VE
                    prodPartsMat = data['prodHistory']['prod_history_parts_mat_details'];
                    for(let x = 0; x < data['prodHistoryPartMat'].length; x++){
                        for(let y = 1; y < data['prodHistoryPartMat'][x]['count_pm']; y++){ // for clicking the add btn for multiple
                            $(`#btnAddPmLotNo${data['prodHistoryPartMat'][x]['pm_group']}`).click();
                        }

                        for(let z = 0; z < data['collection'][data['prodHistoryPartMat'][x]['pm_group']].length; z++){
                            // pmat_lot_no-2_0_0
                            let data1 = data['collection'][data['prodHistoryPartMat'][x]['pm_group']][z];
                            console.log('pm_group',`pmat_lot_no-${data['prodHistoryPartMat'][x]['pm_group']}_${z}`);
                            $(`#pmat_lot_no-${data['prodHistoryPartMat'][x]['pm_group']}_${z}`).val(data1['pm_lot_no']);
                        }

                    }
                }
                else{
                    for(let x = 0; x < data['collection'][1].length; x++){
                        if(x != $('#pmLot1Counter').val()){
                            $('#btnAddPmLotNo1').click();
                        }

                        $(`#pmat_lot_no_${x}`).val(data['collection'][1][x]['pm_lot_no']);
                    }
                }
            }


            $('#modalProductionHistory').modal('show');

        }
    });
}


function getMaterialProcessForInputs(id){
    $.ajax({
        type: "get",
        url: "get_mat_proc_for_add",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {

            let materialOption;
            let machineOption;
            let processOption;
            // $('#txtAddMatProcStep').val(response.count);

            for(let x = 0; x < response.material_details.length; x++){
                materialOption += `<option value="${response.material_details[x]['id']}">${response.material_details[x]['MaterialType']}</option>`;
            }

            machineOption += `<option value="" selected disabled>--Select Process--</option>`
            for(let y = 0; y < response.machine_details.length; y++){
                machineOption += `<option value="${response.machine_details[y]['machine_code_number']}">${response.machine_details[y]['machine_code_number']} (${response.machine_details[y]['machine_name']})</option>`;
            }
            processOption += `<option value="" selected disabled>--Select Process--</option>`
            for(let z = 0; z < response.process.length; z++){
                processOption += `<option value="${response.process[z]['id']}">${response.process[z]['process_name']}</option>`;
            }
            
            $('#selAddMatProcMatName').html(materialOption);
            $('#selAddMatProcMachine').html(machineOption);
            $('#selAddMatProcProcess').html(processOption);

            // $('#modalAddMatProc').modal('show');
        }
    });
}

const getStepCount = (id) => {
    $.ajax({
        type: "get",
        url: "get_step",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {

          
            $('#txtAddMatProcStep').val(response.count);
        }
    });
}

const AddMaterialProcess = () => {
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
        url: "add_material_process",
        method: "post",
        data: $('#formAddMatProc').serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#iBtnAddMatProcIcon").addClass('fa fa-spinner fa-pulse');
            $("#btnAddMatProc").prop('disabled', 'disabled');
        },
        success: function (JsonObject) {
            if (JsonObject['result'] == 1) {
                // $("#txtAddMatProcStep").focus();

                // $("#txtAddMatProcDevId").val(selectedDeviceId);
                // $("#txtAddMatProcDeviceName").val(selectedDeviceName);

                $('#modalAddMatProc').modal('hide');

                dataTableMatProcess.draw();
                toastr.success('Material Process was succesfully saved!');
            } else if (JsonObject['result'] == 0) {

                if (JsonObject['error'] != null) {
                    toastr.error('Saving Material Process Failed!');
                    if (JsonObject['error']['step'] === undefined) {
                        $("#txtAddMatProcStep").removeClass('is-invalid');
                        $("#txtAddMatProcStep").attr('title', '');
                    } else {
                        $("#txtAddMatProcStep").addClass('is-invalid');
                        $("#txtAddMatProcStep").attr('title', JsonObject['error']['step']);
                    }

                    if (JsonObject['error']['sub_station_id'] === undefined) {
                        $("#selAddMatProcSubStationId").removeClass('is-invalid');
                        $("#selAddMatProcSubStationId").attr('title', '');
                    } else {
                        $("#selAddMatProcSubStationId").addClass('is-invalid');
                        $("#selAddMatProcSubStationId").attr('title', JsonObject['error']['sub_station_id']);
                    }
                } else {
                    let troubleMachines = '';
                    if (JsonObject['trouble_machines'].length > 0) {
                        troubleMachines = JsonObject['trouble_machines'].join();
                        // for(let index = 0; index < JsonObject['trouble_machines'].length; index++){
                        //   troubleMachines += JsonObject['trouble_machines'][index] + '';
                        // }

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "900",
                            "hideDuration": "3000",
                            "timeOut": "10000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut",
                        };
                        toastr.error('Machine/Equipment (' + troubleMachines + ') is for repair/damaged. <br>Kindly coordinate with Eng\'g. Thank you!');

                        // toastr.warning(troubleMachines);
                    }
                }
            } else if (JsonObject['result'] == 2) {
                toastr.error('Duplicate Material Process!');
                $("#txtAddMatProcStep").addClass('is-invalid');
                $("#selAddMatProcSubStationId").addClass('is-invalid');
            } else {
                toastr.error('Saving Material Process Failed!');
            }

            $("#iBtnAddMatProcIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMatProc").removeAttr('disabled');
            $("#iBtnAddMatProcIcon").addClass('fa fa-check');
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
            $("#iBtnAddMatProcIcon").removeClass('fa fa-spinner fa-pulse');
            $("#btnAddMatProc").removeAttr('disabled');
            $("#iBtnAddMatProcIcon").addClass('fa fa-check');
        }
    });
}

const ChangeDeviceStatus = () => {
    $.ajax({
        type: "post",
        url: "change_device_stat",
        data: $('#formChangeDeviceStat').serialize(),
        dataType: "json",
        success: function (response) {
            if(response['result'] == 1){
                toastr.success(`${response['msg']}`);
                $('#modalChangeDeviceStat').modal('hide');
                dataTableDevices.draw();
            }
        },
        error: function (data, xhr, status) {
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const GetMatProcByIdToEdit = (id, selectedDeviceName) => {
    $.ajax({
        type: "get",
        url: "get_mat_proc_data",
        data: {
            "id": id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#txtAddMatProcId').val(response['matDetails']['id'])
            $('#txtAddMatProcStep').val(response['matDetails']['step']);
            $('#txtAddMatProcStep').prop('readonly', false);
            $('#txtAddMatProcDeviceName').val(selectedDeviceName);
            $('#selAddMatProcMachine').val(response['matDetails']['machine_code']).trigger('change');
            $('#selAddMatProcProcess').val(response['matDetails']['process']).trigger('change');

            console.log(response['matDetails']['material_details']);
            let matArrayId = [];
            for(let x = 0; x < response['matDetails']['material_details'].length; x++){
                matArrayId.push(response['matDetails']['material_details'][x]['id']);
            }
            $('select[name="material_name[]"]').val(matArrayId).trigger('change')


        }
    });
}

const ChangeMatProcStat = () => {
    // console.log($('#formChangeMatProcStat').serialize());
    $.ajax({
        type: "post",
        url: "change_mat_proc_status",
        data: $('#formChangeMatProcStat').serialize(),
        dataType: "json",
        success: function (response) {
            if(response['result'] == 1){
                toastr.success(`${response['msg']}`);
                dataTableMatProcess.draw();
                $('#modalChangeMatProcStat').modal('hide');
            }
        }
    });
}



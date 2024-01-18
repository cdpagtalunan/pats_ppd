const submitProdData = async (scannedId) => {
    console.log(scannedId);
    $('input[name="status"]').prop('disabled', false);

    let data = $.param({'scanned_id': scannedId }) + "&" + $('#formProdData').serialize();
    await $.ajax({
        type: "post",
        url: "save_prod_data",
        // data: $('#formProdData').serialize(),
        data: data,
        dataType: "json",
       
        success: function (response) {
            if(response['result'] == 1){
                $('#modalProdData').modal('hide');
                $('#modalScanQRSave').modal('hide');
                dtDatatableProd.draw();
                toastr.success(`${response['msg']}`);
            }
            else{ // ! ERROR HANDLER
                toastr.error('Please input required fields.');
                if(response['error']['mat_lot_no'] === undefined){
                    $('#txtMatLotNo').removeClass('is-invalid');
                    $('#txtMatLotNo').attr('title', '');
                }
                else{
                    $('#txtMatLotNo').addClass('is-invalid');
                    $('#txtMatLotNo').attr('title', response['error']['mat_lot_no']);
                }
                if(response['error']['opt_shift'] === undefined){
                    $('#txtOptShift').removeClass('is-invalid');
                    $('#txtOptShift').attr('title', '');
                }
                else{
                    $('#txtOptShift').addClass('is-invalid');
                    $('#txtOptShift').attr('title', response['error']['opt_shift']);
                }
                if(response['error']['prod_date'] === undefined){
                    $('#txtProdDate').removeClass('is-invalid');
                    $('#txtProdDate').attr('title', '');
                }
                else{
                    $('#txtProdDate').addClass('is-invalid');
                    $('#txtProdDate').attr('title', response['error']['prod_date']);
                }
                if(response['error']['prod_lot_no'] === undefined){
                    $('#txtProdLotNo').removeClass('is-invalid');
                    $('#txtProdLotNo').attr('title', '');
                }
                else{
                    $('#txtProdLotNo').addClass('is-invalid');
                    $('#txtProdLotNo').attr('title', response['error']['prod_lot_no']);
                }
                if(response['error']['inpt_coil_weight'] === undefined){
                    $('#txtInptCoilWeight').removeClass('is-invalid');
                    $('#txtInptCoilWeight').attr('title', '');
                }
                else{
                    $('#txtInptCoilWeight').addClass('is-invalid');
                    $('#txtInptCoilWeight').attr('title', response['error']['inpt_coil_weight']);
                }
                if(response['error']['setup_pins'] === undefined){
                    $('#txtSetupPin').removeClass('is-invalid');
                    $('#txtSetupPin').attr('title', '');
                }
                else{
                    $('#txtSetupPin').addClass('is-invalid');
                    $('#txtSetupPin').attr('title', response['error']['setup_pins']);
                }
                if(response['error']['adj_pins'] === undefined){
                    $('#txtAdjPin').removeClass('is-invalid');
                    $('#txtAdjPin').attr('title', '');
                }
                else{
                    $('#txtAdjPin').addClass('is-invalid');
                    $('#txtAdjPin').attr('title', response['error']['adj_pins']);
                }
                if(response['error']['qc_samp'] === undefined){
                    $('#txtQcSamp').removeClass('is-invalid');
                    $('#txtQcSamp').attr('title', '');
                }
                else{
                    $('#txtQcSamp').addClass('is-invalid');
                    $('#txtQcSamp').attr('title', response['error']['qc_samp']);
                }
                if(response['error']['prod_samp'] === undefined){
                    $('#txtProdSamp').removeClass('is-invalid');
                    $('#txtProdSamp').attr('title', '');
                }
                else{
                    $('#txtProdSamp').addClass('is-invalid');
                    $('#txtProdSamp').attr('title', response['error']['prod_samp']);
                }
                if(response['error']['ttl_mach_output'] === undefined){
                    $('#txtTtlMachOutput').removeClass('is-invalid');
                    $('#txtTtlMachOutput').attr('title', '');
                }
                else{
                    $('#txtTtlMachOutput').addClass('is-invalid');
                    $('#txtTtlMachOutput').attr('title', response['error']['ttl_mach_output']);
                }
                if(response['error']['ng_count'] === undefined){
                    $('#txtNGCount').removeClass('is-invalid');
                    $('#txtNGCount').attr('title', '');
                }
                else{
                    $('#txtNGCount').addClass('is-invalid');
                    $('#txtNGCount').attr('title', response['error']['ng_count']);
                }
                
            }
            $('input[name="status"]').prop('disabled', true);

        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const getProdDataById = async (id, btnFunction) => {
    await $.ajax({
        type: "get",
        url: "get_prod_data_view",
        data: {
            "id" : id
        },
        beforeSend: function(){
            $('#divProdLotView').removeClass('d-none');
            $('#divProdLotInput').addClass('d-none');
            getOperatorList($('.selOpName'));

        },
        dataType: "json",
        success: function (response) {
            var counter = 0;
            $('#modalProdData').modal('show');
            $('#txtProdDataId').val(response['id'])
            $('#txtPoNumber').val(response['po_num'])
            $('#txtPoQty').val(response['po_qty'])
            $('#txtPartCode').val(response['part_code'])
            $('#txtMatName').val(response['material_name'])
            // $('#txtMatLotNo').val(response['material_lot_no'])
            $('#txtDrawingNo').val(response['drawing_no'])
            $('#txtDrawingRev').val(response['drawing_rev'])
            // $('#txtOptName').val(response['user']['firstname']+" "+response['user']['lastname'])
            $('#txtOptShift').val(response['shift'])
            $('#txtProdDate').val(response['prod_date'])
            // $('#txtProdLotNo').val(response['prod_lot_no'])
            $('#txtInptCoilWeight').val(response['input_coil_weight'])
            $('#txtTargetOutput').val(response['ppc_target_output'])
            $('#txtPlannedLoss').val(response['planned_loss'])
            $('#txtSetupPin').val(response['set_up_pins'])
            $('#txtAdjPin').val(response['adj_pins'])
            $('#txtQcSamp').val(response['qc_samp'])
            $('#txtProdSamp').val(response['prod_samp'])
            $('#txtTtlMachOutput').val(response['total_mach_output'])
            $('#txtShipOutput').val(response['ship_output'])
            $('#txtMatYield').val(response['mat_yield'])

            $('#txtProdLotView').val(response['prod_lot_no']);
            $('#txtNGCount').val(response['ng_count']);

            let arrayOperators = response['operator'].split(", ");

       
            $('#selOperator').val(arrayOperators).trigger('change');

            if(response['status'] == 0){
                $('#radioIQC').prop('checked', true);
                $('#radioMassProd').prop('checked', false);
                $('#radioResetup').prop('checked', false);
                $('.matNo').prop('readonly', true);
                
            }
            else if(response['status'] == 3){
                $('#radioIQC').prop('checked', false);
                $('#radioMassProd').prop('checked', false);
                $('#radioResetup').prop('checked', true);
            }
            else{
                $('#radioIQC').prop('checked', false);
                $('#radioMassProd').prop('checked', true);
                $('#radioResetup').prop('checked', false);

                $('.matNo').prop('readonly', true);

            }
            $('input[name="cut_point"]').prop('disabled', true);

            if(response['cut_off_point'] == 0){ // without cutpoints
                $('#radioCutPointWithout').prop('checked', true);
                // $('#radioCutPointWith').prop('checked', false);

            }else{ // with cutpoints
                // $('#radioCutPointWithout').prop('checked', false);
                $('#radioCutPointWith').prop('checked', true);
                $('#txtNoCut').val(response['no_of_cuts'])
            }

            $(`#txtTtlMachOutput_0`).val(response['material_lot_no']);

            // let arrayMatLotNo = response['material_lot_no'].split(", ");
            // for(let x = 0; x < arrayMatLotNo.length; x++){
            //     if($('#multipleCounter').val() != counter){
            //         $('#btnAddMatNo').click();
            //     }
            //     $(`#txtTtlMachOutput_${x}`).val(arrayMatLotNo[x]);
            //     counter++
            // }
            if(btnFunction == 0){
                $('#saveProdData').hide();

                $('#formProdData :input').attr('readonly','readonly');
                $('#selOperator').prop('disabled', true);
            }
            else if(btnFunction == 1){ // FOR MASS PROD INPUTTING
                $('#selOperator').prop('disabled', true);
                $('#txtOptShift').prop('readonly', true);
                $('#txtInptCoilWeight').prop('readonly', true);
                $('#txtSetupPin').prop('readonly', true);
                $('#txtAdjPin').prop('readonly', true);
                $('#txtQcSamp').prop('readonly', true);
                $('#txtTargetOutput').prop('readonly', true);
                $('#txtNGCount').prop('readonly', true);

                $('#saveProdData').show();
            }
            else if(btnFunction == 2){ // For Resetup
                setTimeout(() => {
                    $('#txtSetupPin').prop('readonly', false);
                    $('#txtAdjPin').prop('readonly', false);
                    $('#txtQcSamp').prop('readonly', false);
    
                }, 200);
    

                $('#formProdData').find('input').prop('readonly', true);
                $('#selOperator').prop('disabled', true);
                $('#txtNGCount').prop('readonly', false);

            }
            
        }
    });
}

const printProdData = async (id) => {
    await $.ajax({
        type: "get",
        url: "print_qr_code",
        data: {
            "id" : id
        },
        dataType: "json",
        success: function (response) {
            response['label_hidden'][0]['id'] = id;
            $("#img_barcode_PO").attr('src', response['qrCode']);
            $("#img_barcode_PO_text").html(response['label']);
            img_barcode_PO_text_hidden = response['label_hidden'];
            $('#modalPrintQr').modal('show');
            console.log(response);


        }
    });
}

const checkMatrix = async (code, name) => {
    await $.ajax({
        type: "get",
        url: "check_matrix",
        data: {
            "code" : code,
            "name" : name
        },
        dataType: "json",
        success: function (response) {
            if(response['result'] == 2){
                toastr.error(`${response['msg']}`);
            }
            else{
                $('#txtPoNumber').val(prodData['poReceiveData']['OrderNo']);
                $('#txtPoQty').val(prodData['poReceiveData']['OrderQty']);
                $('#txtPartCode').val(prodData['poReceiveData']['ItemCode']);
                $('#txtMatName').val(prodData['poReceiveData']['ItemName']);
                $('#txtDrawingNo').val(prodData['drawings']['drawing_no']);
                $('#txtDrawingRev').val(prodData['drawings']['rev']);
                // $('#txtOptName').val($('#globalSessionName').val());
                $('#modalProdData').modal('show');
            }
            
        }
    });
}

const getProdLotNoCtrl = () => {
    $.ajax({
        type: "get",
        url: "get_prod_lot_no_ctrl",
        data: "",
        dataType: "json",
        beforeSend: function(){
            getOperatorList($('.selOpName'));

        },
        success: function (response) {
            $('#txtCtrlCounter').val(response['ctrl']);
            $('#prodLotNoAuto').val(`${prodData['drawings']['rev']}${response['year']}${response['month']}${response['day']}-${response['ctrl']}`)
        }
    });
}

const getOperatorList = (cboElement) => {
    $.ajax({
        type: "get",
        url: "get_operator_list",
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

const changePrintCount = (printedId) => {
    $.ajax({
        type: "get",
        url: "change_print_count",
        data: {
            id: printedId
        },
        dataType: "dataType",
        success: function (response) {
            
        }
    });
}

// const getHistoryDetails = async (id) => {
//     // await $.ajax({
//     //     type: "get",
//     //     url: "get_history_details",
//     //     data: {
//     //         "id" : id,
//     //     },
//     //     dataType: "json",
//     //     success: function (response) {
//         // dtDatatableHistory.draw();


//             // $('#modalHistory').modal('show');
//     //     }
//     // });
// }
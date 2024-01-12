const submitProdData = async () => {
    await $.ajax({
        type: "post",
        url: "save_prod_data",
        data: $('#formProdData').serialize(),
        dataType: "json",
        success: function (response) {
            if(response['result'] == 1){
                $('#modalMachineOp').modal('hide');
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
                
            }
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
        }
    });
}

const getProdDataToView = async (id) => {
    await $.ajax({
        type: "get",
        url: "get_prod_data_view",
        data: {
            "id" : id
        },
        beforeSend: function(){
            $('#divProdLotView').removeClass('d-none');
            $('#divProdLotInput').addClass('d-none');

        },
        dataType: "json",
        success: function (response) {
            var counter = 0;
            $('#modalMachineOp').modal('show');
            $('#saveProdData').hide();
            
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

            let arrayMatLotNo = response['material_lot_no'].split(", ");
            let arrayOperators = response['operator'].split(", ");

            for(let x = 0; x < arrayMatLotNo.length; x++){
                if($('#multipleCounter').val() != counter){
                    $('#btnAddMatNo').click();
                }
                $(`#txtTtlMachOutput_${x}`).val(arrayMatLotNo[x]);
                counter++
            }
            $('#selOperator').val(arrayOperators).trigger('change');
            
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
            console.log(response);
            $("#img_barcode_PO").attr('src', response['qrCode']);
            $("#img_barcode_PO_text").html(response['label']);
            img_barcode_PO_text_hidden = response['label_hidden'];
            $('#modalPrintQr').modal('show');

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
                $('#modalMachineOp').modal('show');
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
        success: function (response) {
            $('#txtCtrlCounter').val(response['ctrl']);
            $('#prodLotNoAuto').val(`${prodData['drawings']['rev']}${response['year']}${response['month']}${response['day']}-${response['ctrl']}`)
        }
    });
}

const getOperatorList = async (cboElement) => {
    await $.ajax({
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
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
        dataType: "json",
        success: function (response) {
            $('#modalMachineOp').modal('show');
            $('#saveProdData').hide();
            
            $('#txtPoNumber').val(response['po_num'])
            $('#txtPoQty').val(response['po_qty'])
            $('#txtPartCode').val(response['part_code'])
            $('#txtMatName').val(response['material_name'])
            $('#txtMatLotNo').val(response['material_lot_no'])
            $('#txtDrawingNo').val(response['drawing_no'])
            $('#txtDrawingRev').val(response['drawing_rev'])
            $('#txtOptName').val(response['user']['name'])
            $('#txtOptShift').val(response['shift'])
            $('#txtProdDate').val(response['prod_date'])
            $('#txtProdLotNo').val(response['prod_lot_no'])
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
        }
    });
}

const printProdData = (data) => {
    console.log(data);
}
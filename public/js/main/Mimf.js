function GetPpsWarehouse(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_pps_warehouse",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['getPartName'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['getPartName'].length; index++){
                    result += '<option value="' + response['getPartName'][index].id +'">'+ response['getPartName'][index].PartNumber +'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

function UpdateMimf(){
	$.ajax({
        url: "update_mimf",
        method: "post",
        data: $('#formMimf').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnMimfIcon").addClass('spinner-border spinner-border-sm')
            $("#btnMimf").addClass('disabled')
            $("#iBtnMimfIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['mimf_control_no'] === undefined){
                    $("#txtMimfControlNo").removeClass('is-invalid')
                    $("#txtMimfControlNo").attr('title', '')
                }
                else{
                    $("#txtMimfControlNo").addClass('is-invalid');
                    $("#txtMimfControlNo").attr('title', response['error']['mimf_control_no'])
                }

                if(response['error']['mimf_pmi_po_no'] === undefined){
                    $("#txtMimfPmiPoNo").removeClass('is-invalid')
                    $("#txtMimfPmiPoNo").attr('title', '')
                }
                else{
                    $("#txtMimfPmiPoNo").addClass('is-invalid')
                    $("#txtMimfPmiPoNo").attr('title', response['error']['mimf_pmi_po_no'])
                }

                if(response['error']['mimf_date_issuance'] === undefined){
                    $("#dateMimfDateOfInssuance").removeClass('is-invalid')
                    $("#dateMimfDateOfInssuance").attr('title', '')
                }
                else{
                    $("#dateMimfDateOfInssuance").addClass('is-invalid')
                    $("#dateMimfDateOfInssuance").attr('title', response['error']['mimf_date_issuance'])
                }

                if(response['error']['mimf_prodn_quantity'] === undefined){
                    $("#txtMimfProdnQuantity").removeClass('is-invalid')
                    $("#txtMimfProdnQuantity").attr('title', '')
                }
                else{
                    $("#txtMimfProdnQuantity").addClass('is-invalid')
                    $("#txtMimfProdnQuantity").attr('title', response['error']['mimf_prodn_quantity'])
                }

                if(response['error']['mimf_device_code'] === undefined){
                    $("#txtMimfDeviceCode").removeClass('is-invalid')
                    $("#txtMimfDeviceCode").attr('title', '')
                }
                else{
                    $("#txtMimfDeviceCode").addClass('is-invalid')
                    $("#txtMimfDeviceCode").attr('title', response['error']['mimf_device_code'])
                }

                if(response['error']['mimf_device_name'] === undefined){
                    $("#txtMimfDeviceName").removeClass('is-invalid')
                    $("#txtMimfDeviceName").attr('title', '')
                }
                else{
                    $("#txtMimfDeviceName").addClass('is-invalid')
                    $("#txtMimfDeviceName").attr('title', response['error']['mimf_device_name'])
                }

                if(response['error']['mimf_material_code'] === undefined){
                    $("#txtMimfMaterialCode").removeClass('is-invalid')
                    $("#txtMimfMaterialCode").attr('title', '')
                }
                else{
                    $("#txtMimfMaterialCode").addClass('is-invalid')
                    $("#txtMimfMaterialCode").attr('title', response['error']['mimf_material_code'])
                }

                if(response['error']['mimf_material_type'] === undefined){
                    $("#txtMimfMaterialType").removeClass('is-invalid')
                    $("#txtMimfMaterialType").attr('title', '')
                }
                else{
                    $("#txtMimfMaterialType").addClass('is-invalid')
                    $("#txtMimfMaterialType").attr('title', response['error']['mimf_material_type'])
                }

                if(response['error']['mimf_quantity_from_inventory'] === undefined){
                    $("#txtMimfQuantityFromInventory").removeClass('is-invalid')
                    $("#txtMimfQuantityFromInventory").attr('title', '')
                }
                else{
                    $("#txtMimfQuantityFromInventory").addClass('is-invalid')
                    $("#txtMimfQuantityFromInventory").attr('title', response['error']['mimf_quantity_from_inventory'])
                }

                if(response['error']['mimf_needed_kgs'] === undefined){
                    $("#txtMimfNeededKgs").removeClass('is-invalid')
                    $("#txtMimfNeededKgs").attr('title', '')
                }
                else{
                    $("#txtMimfNeededKgs").addClass('is-invalid')
                    $("#txtMimfNeededKgs").attr('title', response['error']['mimf_needed_kgs'])
                }

                if(response['error']['mimf_virgin_material'] === undefined){
                    $("#txtMimfVirginMaterial").removeClass('is-invalid')
                    $("#txtMimfVirginMaterial").attr('title', '')
                }
                else{
                    $("#txtMimfVirginMaterial").addClass('is-invalid')
                    $("#txtMimfVirginMaterial").attr('title', response['error']['mimf_virgin_material'])
                }

                if(response['error']['mimf_recycled'] === undefined){
                    $("#txtMimfRecycled").removeClass('is-invalid')
                    $("#txtMimfRecycled").attr('title', '')
                }
                else{
                    $("#txtMimfRecycled").addClass('is-invalid')
                    $("#txtMimfRecycled").attr('title', response['error']['mimf_recycled'])
                }

                if(response['error']['date_mimf_prodn'] === undefined){
                    $("#dateMimfProdn").removeClass('is-invalid')
                    $("#dateMimfProdn").attr('title', '')
                }
                else{
                    $("#dateMimfProdn").addClass('is-invalid')
                    $("#dateMimfProdn").attr('title', response['error']['date_mimf_prodn'])
                }

                if(response['error']['mimf_delivery'] === undefined){
                    $("#txtMimfDelivery").removeClass('is-invalid')
                    $("#txtMimfDelivery").attr('title', '')
                }
                else{
                    $("#txtMimfDelivery").addClass('is-invalid')
                    $("#txtMimfDelivery").attr('title', response['error']['mimf_delivery'])
                }

                if(response['error']['mimf_remark'] === undefined){
                    $("#txtMimfRemark").removeClass('is-invalid')
                    $("#txtMimfRemark").attr('title', '')
                }
                else{
                    $("#txtMimfRemark").addClass('is-invalid')
                    $("#txtMimfRemark").attr('title', response['error']['mimf_remark'])
                }

                if(response['error']['created_by'] === undefined){
                    $("#txtCreatedBy").removeClass('is-invalid')
                    $("#txtCreatedBy").attr('title', '')
                }
                else{
                    $("#txtCreatedBy").addClass('is-invalid')
                    $("#txtCreatedBy").attr('title', response['error']['created_by'])
                }
            }else if(response['hasError'] == 0){
                $("#formMimf")[0].reset()
                $('#modalMimf').modal('hide')
                dataTableMimf.draw()
                toastr.success('Succesfully saved!')
            }else{
                alert('Control No. "'+$("#txtMimfControlNo").val()+'" is already exist! '+"\n\n"+' Please refresh the browser to process the request once again.')
            }

            $("#iBtnMimfIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnMimf").removeClass('disabled')
            $("#iBtnMimfIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetMimfById(mimfID,whseID,matrixID,poReceivedID,ppdMimfStampingMatrixID){
	$.ajax({
        url: "get_mimf_by_id",
        method: "get",
        data: {
            'mimfID'        :   mimfID,
            'whseID'        :   whseID,
            'matrixID'      :   matrixID,
            'dieSetID'      :   dieSetID,
            'poReceivedID'  :   poReceivedID,
            'ppdMimfStampingMatrixID'  :   ppdMimfStampingMatrixID
        },
        dataType: "json",
        beforeSend: function(){
            
        },

        success: function(response){
            let getMimfToEdit   = response['getMimfToEdit']
            console.log(getMimfToEdit)
            if(getMimfToEdit.length > 0){
                $('#txtMimfControlNo').val(getMimfToEdit[0].control_no)
                $('#txtMimfPmiPoNo').val(getMimfToEdit[0].pmi_po_no)
                $('#dateMimfDateOfInssuance').val(getMimfToEdit[0].date_issuance)
                $('#txtMimfProdnQuantity').val(getMimfToEdit[0].prodn_qty)
                $('#txtMimfDeviceCode').val(getMimfToEdit[0].device_code)
                $('#txtMimfDeviceName').val(getMimfToEdit[0].device_name)
                $('#txtMimfMaterialCode').val(getMimfToEdit[0].material_code)
                $('#txtMimfMaterialType').val(getMimfToEdit[0].material_type)
                $('#txtMimfQuantityFromInventory').val(getMimfToEdit[0].qty_invt)
                $('#txtMimfNeededKgs').val(getMimfToEdit[0].needed_kgs)
                $('#txtMimfVirginMaterial').val(getMimfToEdit[0].virgin_material)
                $('#txtMimfRecycled').val(getMimfToEdit[0].recycled)
                $('#dateMimfProdn').val(getMimfToEdit[0].prodn)
                $('#txtMimfDelivery').val(getMimfToEdit[0].delivery)
                $('#txtMimfRemark').val(getMimfToEdit[0].remarks)
            }
        },
    })
}

function UpdateMimfStampignMatrix(){
	$.ajax({
        url: "update_mimf_stamping_matrix",
        method: "post",
        data: $('#formMimfStampingMatrix').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnMimfStampingMatrixIcon").addClass('spinner-border spinner-border-sm')
            $("#btnMimfStampingMatrix").addClass('disabled')
            $("#iBtnMimfStampingMatrixIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['mimf_stamping_matrix_item_code'] === undefined){
                    $("#txtMimfStampingMatrixItemCode").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixItemCode").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixItemCode").addClass('is-invalid')
                    $("#txtMimfStampingMatrixItemCode").attr('title', response['error']['mimf_stamping_matrix_item_code'])
                }

                if(response['error']['mimf_stamping_matrix_item_name'] === undefined){
                    $("#txtMimfStampingMatrixItemName").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixItemName").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixItemName").addClass('is-invalid')
                    $("#txtMimfStampingMatrixItemName").attr('title', response['error']['mimf_stamping_matrix_item_name'])
                }

                if(response['error']['mimf_stamping_matrix_pin_kg'] === undefined){
                    $("#txtMimfStampingMatrixPinkg").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixPinkg").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixPinkg").addClass('is-invalid')
                    $("#txtMimfStampingMatrixPinkg").attr('title', response['error']['mimf_stamping_matrix_pin_kg'])
                }

                if(response['error']['mimf_stamping_matrix_part_code'] === undefined){
                    $("#txtMimfStampingMatrixPartCode").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixPartCode").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixPartCode").addClass('is-invalid')
                    $("#txtMimfStampingMatrixPartCode").attr('title', response['error']['mimf_stamping_matrix_part_code'])
                }

                if(response['error']['mimf_stamping_matrix_material_name'] === undefined){
                    $("#txtMimfStampingMatrixNeededKgs").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixNeededKgs").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixNeededKgs").addClass('is-invalid')
                    $("#txtMimfStampingMatrixNeededKgs").attr('title', response['error']['mimf_stamping_matrix_material_name'])
                }

                if(response['error']['mimf_stamping_matrix_created_by'] === undefined){
                    $("#txtMimfStampingMatrixCreatedBy").removeClass('is-invalid')
                    $("#txtMimfStampingMatrixCreatedBy").attr('title', '')
                }
                else{
                    $("#txtMimfStampingMatrixCreatedBy").addClass('is-invalid')
                    $("#txtMimfStampingMatrixCreatedBy").attr('title', response['error']['mimf_stamping_matrix_created_by'])
                }
            }else if(response['hasError'] == 0){
                $("#formMimfStampingMatrix")[0].reset()
                $('#modalMimfStampingMatrix').modal('hide')
                dataTableMimfStampingMatrix.draw()
                toastr.success('Succesfully saved!')
            }else{
                alert('')
            }

            $("#iBtnMimfStampingMatrixIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnMimfStampingMatrix").removeClass('disabled')
            $("#iBtnMimfStampingMatrixIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetMimfStampingMatrixById(mimfStampingMatrixID){
	$.ajax({
        url: "get_mimf_stamping_matrix_by_id",
        method: "get",
        data: {
            'mimfStampingMatrixID'  :   mimfStampingMatrixID,
        },
        dataType: "json",
        beforeSend: function(){
            
        },

        success: function(response){
            let getMimfStampingMatrixToEdit   = response['getMimfStampingMatrixToEdit']
            console.log(getMimfStampingMatrixToEdit)
            if(getMimfStampingMatrixToEdit.length > 0){
                $('#txtMimfStampingMatrixItemCode').val(getMimfStampingMatrixToEdit[0].item_code)
                $('#txtMimfStampingMatrixItemName').val(getMimfStampingMatrixToEdit[0].item_name)
                $('#txtMimfStampingMatrixPinkg').val(getMimfStampingMatrixToEdit[0].pin_kg)
                $('#txtMimfStampingMatrixPartCode').val(getMimfStampingMatrixToEdit[0].part_code)
                $('#txtMimfStampingMatrixMaterialName').val(getMimfStampingMatrixToEdit[0].material_name)
            }
        },
    })
}
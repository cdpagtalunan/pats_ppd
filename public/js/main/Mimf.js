// function GetPmiPo(cboElement){
//     let result = '<option value="">N/A</option>'

//     $.ajax({
//         url: "get_pmi_po",
//         method: "get",
//         dataType: "json",

//         beforeSend: function(){
//             result = '<option value="" selected disabled> -- Loading -- </option>'
//             cboElement.html(result);
//         },
//         success: function(response){
//             result = '';

//             if(response['getPoReceivedPmiPo'].length > 0){
//                 result = '<option selected disabled> --- Select --- </option>';
//                 for(let index = 0; index < response['getPoReceivedPmiPo'].length; index++){
//                     result += '<option value="' + response['getPoReceivedPmiPo'][index].OrderNo +'">'+ response['getPoReceivedPmiPo'][index].OrderNo +'</option>'
//                 }
//             }
//             else{
//                 result = '<option value="0" selected disabled> No record found </option>'
//             }
//             cboElement.html(result)
//         }
//     })
// }

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
                    // $("#slctMimfPmiPoNo").removeClass('is-invalid')
                    // $("#slctMimfPmiPoNo").attr('title', '')
                }
                else{
                    $("#txtMimfPmiPoNo").addClass('is-invalid')
                    $("#txtMimfPmiPoNo").attr('title', response['error']['mimf_pmi_po_no'])
                    // $("#slctMimfPmiPoNo").addClass('is-invalid')
                    // $("#slctMimfPmiPoNo").attr('title', response['error']['mimf_pmi_po_no'])
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

                if(response['error']['mimf_prodn'] === undefined){
                    $("#txtMimfProdn").removeClass('is-invalid')
                    $("#txtMimfProdn").attr('title', '')
                }
                else{
                    $("#txtMimfProdn").addClass('is-invalid')
                    $("#txtMimfProdn").attr('title', response['error']['mimf_prodn'])
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

function GetMimfById(mimfID){
	$.ajax({
        url: "get_mimf_by_id",
        method: "get",
        data: {
            'mimfID'    :   mimfID,
        },
        dataType: "json",
        beforeSend: function(){
            
        },

        success: function(response){
            let getMimfToEdit            = response['getMimfToEdit']
            console.log(getMimfToEdit)
            if(getMimfToEdit.length > 0){
                $('#txtMimfControlNo').val(getMimfToEdit[0].control_no)
                $('#slctMimfPmiPoNo').val(getMimfToEdit[0].po_no)
                $('#mimf_date_issuance').val(getMimfToEdit[0].date_issuance)
                $('#txtMimfProdnQuantity').val(getMimfToEdit[0].prodn_qty)
                $('#txtMimfDeviceCode').val(getMimfToEdit[0].device_code)
                $('#txtMimfDeviceName').val(getMimfToEdit[0].device_name)
                $('#txtMimfMaterialCode').val(getMimfToEdit[0].material_code)
                $('#txtMimfMaterialType').val(getMimfToEdit[0].material_type)
                $('#txtMimfQuantityFromInventory').val(getMimfToEdit[0].qty_invt)
                $('#txtMimfNeededKgs').val(getMimfToEdit[0].needed_kgs)
                $('#txtMimfVirginMaterial').val(getMimfToEdit[0].virgin_material)
                $('#txtMimfRecycled').val(getMimfToEdit[0].recycled)
                $('#txtMimfProdn').val(getMimfToEdit[0].prodn)
                $('#txtMimfDelivery').val(getMimfToEdit[0].delivery)
                $('#txtMimfRemark').val(getMimfToEdit[0].remarks)
            }
        },
    })
}
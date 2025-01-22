function GetPpsPoReceivedItemCode(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_pps_po_recveived_item_code",
        method: "get",
        data: {
            poReceivedDb : $('#slctMimfStampingMatrixItemCode').val(),
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['getItemCode'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['getItemCode'].length; index++){
                    result += '<option value="' + response['getItemCode'][index].ItemCode +'">'+ response['getItemCode'][index].ItemCode +'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }

            cboElement.html(result)
        }
    })
}

function GetPpdMaterialType(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_ppd_material_type",
        method: "get",
        data: {
            getMimfDeviceName   : $('#txtMimfDeviceName').val(),
            getMimfStatus       : $('#txtMimfStatus').val(),
            getMimfCategory     : $('#txtMimfCategory').val()
        },
        dataType: "json",

        beforeSend: function(){
            result = '<option selected disabled> -- No Results Found! -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';
            let getDevice = response['getDeviceName'].material_details;
            console.log('object',response['getDeviceName']);
            if(getDevice.length > 0){
                result = '<option selected value="" disabled> --- Select --- </option>';
                for(let index = 0; index < response['getDeviceName'].material_details.length; index++){
                    if(getDevice.length == 1){
                        $('#slctMimfMaterialType').addClass('slct');
                        $('#slctMimfMaterialType').attr('readonly', true);
                        result += '<option selected value="' + getDevice[index].material_type +'">'+ getDevice[index].material_type +'</option>'
                    }else{
                        $('#slctMimfMaterialType').attr('readonly', false);
                        $('#slctMimfMaterialType').removeClass('slct');
                        result += '<option value="' + getDevice[index].material_type +'">'+ getDevice[index].material_type +'</option>'
                    }
                }

                if($('#txtMimfStatus').val() == 1){
                    if($('#txtMimfCategory').val() == 1 && getDevice[0].stamping_pps_warehouse_info == null){
                        $('#btnMimfPpsRequest').addClass('d-none')
                        alert('Material Type & Material Code is not found in MIMF Stamping Setting!')
                    }else{
                        $('#btnMimfPpsRequest').removeClass('d-none')
                    }
                }else{
                    $('#btnMimfPpsRequest').removeClass('d-none')
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
        url: "update_mimf_v2",
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

                if(response['error']['mimf_created_by'] === undefined){
                    $("#txtMimfCreatedBy").removeClass('is-invalid')
                    $("#txtMimfCreatedBy").attr('title', '')
                }
                else{                    
                    $("#txtMimfCreatedBy").addClass('is-invalid')
                    $("#txtMimfCreatedBy").attr('title', response['error']['mimf_created_by'])
                }
            }else if(response['result'] == 0){
                alert('Device Name: "'+$("#txtMimfDeviceName").val()+'" is not found on Matrix.')
            }else if(response['result'] == 1){
                alert('Control No. "'+$("#txtMimfControlNo").val()+'" is already exist! '+"\n\n"+' Please refresh the browser to process the request once again.')
            }else if(response['result'] == 2){
                alert('It is not allowed to change the PMI PO Number in the current Control Number!')
            }else if(response['result'] == 3){
                alert('PMI Po No. "'+$("#txtMimfPmiPoNo").val()+'" is already exist!')
            }else if(response['result'] == 4){
                alert('Device Code: "'+$("#txtMimfDeviceCode").val()+'" '+"\n"+'Device Name: "'+$("#txtMimfDeviceName").val()+'" '+"\n"+'is not found on MIMF Stamping Matrix')
            }else if(response['result'] == 5){
                alert('')
            }else{
                $('.mimfClass').removeClass('is-invalid')
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

function GetMimfById(mimfID,poReceivedID){
	$.ajax({
        url: "get_mimf_by_id_v2",
        method: "get",
        data: {
            'mimfID'        :   mimfID,
            'poReceivedID'  :   poReceivedID,
        },
        dataType: "json",
        beforeSend: function(){
            $('.mimfClass').removeClass('is-invalid')
        },

        success: function(response){
            let getMimfToEdit   = response['getMimfToEdit']
            if(getMimfToEdit.length > 0){
                if(getMimfToEdit[0].category == 1){
                    $('.first').prop('checked', true)
                    $('.second').prop('disabled', true)
                }else{
                    $('.first').prop('disabled', true)
                    $('.second').prop('checked', true)
                }         

                $('#txtMimfControlNo').val(getMimfToEdit[0].control_no)
                $('#txtMimfPmiPoNo').val(getMimfToEdit[0].pmi_po_no)
                $('#dateMimfDateOfInssuance').val(getMimfToEdit[0].date_issuance)
                $('#txtMimfProdnQuantity').val(getMimfToEdit[0].prodn_qty)
                $('#txtMimfDeviceCode').val(getMimfToEdit[0].device_code)
                $('#txtMimfDeviceName').val(getMimfToEdit[0].device_name)
            }
        },
    })
}

function GetQtyFromInventory(ppsWarehouseInventory){
	$.ajax({
        url: "get_pps_warehouse_inventory",
        method: "get",
        data: {
            'ppsWarehouseInventory' :   ppsWarehouseInventory,
        },
        dataType: "json",
        beforeSend: function(){
        
        },

        success: function(response){
            let getInventory   = response['getInventory']
            let totalBalanace   = response['totalBalanace']
            let result   = response['result']
            console.log('getInventory: ', getInventory);
            if(getInventory != undefined){
                if(getInventory.length > 0){
                    $('#txtMimfMaterialCode').val(getInventory[0].PartNumber)
                    if(getInventory[0].pps_warehouse_transaction_info != null){
                        $('#txtMimfQuantityFromInventory').val(totalBalanace)
                        $('#txtPpsWhseId').val(getInventory[0].id)
                    }
                }else{
                    $('#txtMimfMaterialCode').val('')
                    $('#txtMimfQuantityFromInventory').val('')
                    $('#txtRequestQuantity').val('')
                    $('#txtMimfNeededKgs').val('')
                    $('#txtMimfRequestPinsPcs').val('')
                    $('#txtMimfVirginMaterial').val('')
                    $('#txtMimfRecycled').val('')    
                    alert('Material Type not found!!')
                }
            }else{
                $('#txtMimfMaterialCode').val('')
                $('#txtMimfQuantityFromInventory').val('')
                $('#txtRequestQuantity').val('')
                $('#txtMimfNeededKgs').val('')
                $('#txtMimfRequestPinsPcs').val('')
                $('#txtMimfVirginMaterial').val('')
                $('#txtMimfRecycled').val('')
                
                if($('#slctMimfMaterialType').val() != null){
                    alert('Material Type not found!')
                }
            }

            if(result == 0){
                $('#txtPpsWhseId').val('')
            }
        },
    })
}

function CheckRequestQtyForIssuance(getMimfId,getPartnumber,productCategory,virginMaterial,neededQuantity,updateAllowedQty){
    $.ajax({
        url: "check_request_qty_for_issuance",
        method: "get",
        data: {
            'getMimfId'         :   getMimfId,
            'getPartnumber'     :   getPartnumber,
            'productCategory'   :   productCategory,
            'virginMaterial'    :   virginMaterial,
            'neededQuantity'    :   neededQuantity,
            'updateAllowedQty'  :   updateAllowedQty
        },
        dataType: "json",

        beforeSend: function(){
        },
        success: function(response){
            // let checkTotalRequestQty    = response['checkTotalRequestQty'];
            // let totalRequestQty

            let allowedQuantity         = response['allowedQuantity']
            let newBalance
            let checker
            if(allowedQuantity.length > 0){
                // totalRequestQty         = Number(allowedQuantity[0].allowed_quantity) - Number(checkTotalRequestQty);
                // $('#leftQty').val(totalRequestQty)

                // $('#leftQty').val(allowedQuantity[0].balance)
                
                if(updateAllowedQty == undefined){
                    $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                    if(productCategory == 1){
                        newBalance = allowedQuantity[0].balance - virginMaterial
                        checker = newBalance < 0 ? "Negative" : newBalance > 0 ? "Positive" : "Zero";
    
                    }else if(productCategory == 2 || productCategory == 3){
                        newBalance = allowedQuantity[0].balance - neededQuantity
                        checker = newBalance < 0 ? "Negative" : newBalance > 0 ? "Positive" : "Zero";
                    }
    
                    if(checker == 'Positive'){
                        $('#leftQty').val(newBalance)
                    }else{
                        $('#leftQty').val(allowedQuantity[0].balance)
                    }
                    console.log('qwewq');
                }else{
                    if(allowedQuantity[0].allowed_quantity == $('#txtMimfMoldingAllowedQuantity').val()){
                        $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                        $('#leftQty').val(allowedQuantity[0].balance)
                        console.log('0');
                    }else{
                        // if(allowedQuantity[0].allowed_quantity == $('#txtMimfMoldingAllowedQuantity').val()){
                        //     $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                        //     $('#leftQty').val(allowedQuantity[0].balance)
                        // }else if(allowedQuantity[0].allowed_quantity > $('#txtMimfMoldingAllowedQuantity').val()){
                        //     if(Number($('#txtMimfMoldingAllowedQuantity').val()) < allowedQuantity[0].balance){
                        //         alert('Current Balance is greater than the Allowed Quantity')
                        //         $('#btnMimfPpsRequest').addClass('d-none')
                        //         $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                        //         $('#leftQty').val(allowedQuantity[0].balance)    
                        //     }else if(Number($('#txtMimfMoldingAllowedQuantity').val()) == allowedQuantity[0].balance){
                        //         $('#btnMimfPpsRequest').removeClass('d-none')
                        //         $('#leftQty').val('0')
                        //     }else{
                        //         $('#btnMimfPpsRequest').removeClass('d-none')
                        //         $('#leftQty').val(Number($('#txtMimfMoldingAllowedQuantity').val()) - Number(allowedQuantity[0].balance))
                        //     }
                        // }else{
                        //     if(Number($('#txtMimfMoldingAllowedQuantity').val()) < allowedQuantity[0].balance){
                        //         alert('Current Balance is greater than the Allowed Quantity')
                        //         $('#btnMimfPpsRequest').addClass('d-none')
                        //         $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                        //         $('#leftQty').val(allowedQuantity[0].balance)    
                        //     }else if(Number($('#txtMimfMoldingAllowedQuantity').val()) == allowedQuantity[0].balance){
                        //         $('#btnMimfPpsRequest').removeClass('d-none')
                        //         $('#leftQty').val('0')
                        //     }else{
                        //         $('#btnMimfPpsRequest').removeClass('d-none')
                        //         $('#leftQty').val(Number($('#txtMimfMoldingAllowedQuantity').val()) + Number(allowedQuantity[0].balance))
                        //     }
                        // }

                        if(allowedQuantity[0].allowed_quantity == $('#txtMimfMoldingAllowedQuantity').val()){
                            console.log('1');
                            $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                            $('#leftQty').val(allowedQuantity[0].balance)
                        }else{
                            if(allowedQuantity[0].allowed_quantity > $('#txtMimfMoldingAllowedQuantity').val()){
                                $('#btnMimfPpsRequest').removeClass('d-none')
                                let computedBalance = Number(allowedQuantity[0].allowed_quantity - allowedQuantity[0].balance)
                                console.log('2');
                                $('#leftQty').val(Number($('#txtMimfMoldingAllowedQuantity').val()) - computedBalance)
                            }else{
                                console.log('3');
                                $('#btnMimfPpsRequest').removeClass('d-none')
                                $('#leftQty').val(Number($('#txtMimfMoldingAllowedQuantity').val()) + Number(allowedQuantity[0].balance - allowedQuantity[0].allowed_quantity))
                            }
    
                            if(Number($('#txtMimfMoldingAllowedQuantity').val()) < allowedQuantity[0].balance){
                                console.log('4');
                                alert('Current Balance is greater than the Allowed Quantity')
                                $('#btnMimfPpsRequest').addClass('d-none')
                                $('#txtMimfMoldingAllowedQuantity').val(allowedQuantity[0].allowed_quantity)
                                $('#leftQty').val(allowedQuantity[0].balance)    
                            }else if(Number($('#txtMimfMoldingAllowedQuantity').val()) == allowedQuantity[0].balance){
                                console.log('5');
                                $('#btnMimfPpsRequest').removeClass('d-none')
                                $('#leftQty').val('.0')
                            }else{
                                console.log('6');
                            }
                        } 
                    }
                }
                if(productCategory == 1 && allowedQuantity[0].balance < $('#txtMimfVirginMaterial').val()){
                    alert('Virgin Material is greater than the Balance Quantity')
                    $('.auto-compute').val('0')
                    $('#txtMimfVirginMaterial').val('.0')
                    $('#txtMimfNeededKgs').val('.0')
                    $('#btnMimfPpsRequest').addClass('d-none')
                }else{
                    $('#btnMimfPpsRequest').removeClass('d-none')
                }
                if(productCategory != 1 && allowedQuantity[0].balance < $('#txtMimfNeededKgs').val()){
                    alert('Needed Quantity is greater than the Balance Quantity')
                    $('.auto-compute').val('0')
                    $('#txtMimfNeededKgs').val('.0')
                    $('#btnMimfPpsRequest').addClass('d-none')
                }else{
                    $('#btnMimfPpsRequest').removeClass('d-none')
                }

            }else{
                $('#leftQty').val($('#txtMimfMoldingAllowedQuantity').val())
                if(productCategory == 1 && Number($('#leftQty').val()) < Number($('#txtMimfVirginMaterial').val())){
                    alert('Virgin Material is greater than the Balance Quantity')
                    $('.auto-compute').val('0')
                    $('#txtMimfVirginMaterial').val('.0')
                    $('#txtMimfNeededKgs').val('.0')
                    $('#btnMimfPpsRequest').addClass('d-none')
                }else{
                    $('#btnMimfPpsRequest').removeClass('d-none')
                }
                if(productCategory != 1 && Number($('#leftQty').val()) < Number($('#txtMimfNeededKgs').val())){
                    alert('Needed Quantity is greater than the Balance Quantity')
                    $('.auto-compute').val('0')
                    $('#txtMimfNeededKgs').val('.0')
                    $('#btnMimfPpsRequest').addClass('d-none')
                }else{
                    $('#btnMimfPpsRequest').removeClass('d-none')
                }
            }
        }
    })
}

function CreateUpdateMimfPpsRequest(){
	$.ajax({
        url: "create_update_mimf_pps_request",
        method: "post",
        data: $('#formMimfPpsRequest').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnMimfPpsRequestIcon").addClass('spinner-border spinner-border-sm')
            $("#btnMimfPpsRequest").addClass('disabled')
            $("#iBtnMimfPpsRequestIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['result'] == 0){
                alert('Material Type: '+$('#slctMimfMaterialType').val()+' '+"\n"+'Material Code: '+$('#txtMimfMaterialCode').val()+' '+"\n\n"+'is not found on PPS Dieset System')
            }else if(response['result'] == 1){
                alert('Material Type: '+$('#slctMimfMaterialType').val()+' '+"\n"+'Material Code: '+$('#txtMimfMaterialCode').val()+' '+"\n\n"+'is not found on PPS Item List')
            }else if(response['validationHasError'] == 1){                
                toastr.error('Saving failed!')

                if(response['error']['mimf_material_type'] === undefined){
                    $("#slctMimfMaterialType").removeClass('is-invalid')
                    $("#slctMimfMaterialType").attr('title', '')
                }
                else{
                    $("#slctMimfMaterialType").addClass('is-invalid');
                    $("#slctMimfMaterialType").attr('title', response['error']['mimf_material_type'])
                }

                if(response['error']['mimf_material_code'] === undefined){
                    $("#txtMimfMaterialCode").removeClass('is-invalid')
                    $("#txtMimfMaterialCode").attr('title', '')
                }
                else{
                    $("#txtMimfMaterialCode").addClass('is-invalid')
                    $("#txtMimfMaterialCode").attr('title', response['error']['mimf_material_code'])
                }

                if(response['error']['mimf_quantity_from_inventory'] === undefined){
                    $("#txtMimfQuantityFromInventory").removeClass('is-invalid')
                    $("#txtMimfQuantityFromInventory").attr('title', '')
                }
                else{
                    $("#txtMimfQuantityFromInventory").addClass('is-invalid')
                    $("#txtMimfQuantityFromInventory").attr('title', response['error']['mimf_quantity_from_inventory'])
                }

                if(response['error']['request_quantity'] === undefined){
                    $("#txtRequestQuantity").removeClass('is-invalid')
                    $("#txtRequestQuantity").attr('title', '')
                }
                else{
                    $("#txtRequestQuantity").addClass('is-invalid')
                    $("#txtRequestQuantity").attr('title', response['error']['request_quantity'])
                }

                if(response['error']['mimf_needed_kgs'] === undefined){
                    $("#txtMimfNeededKgs").removeClass('is-invalid')
                    $("#txtMimfNeededKgs").attr('title', '')
                }
                else{
                    $("#txtMimfNeededKgs").addClass('is-invalid')
                    $("#txtMimfNeededKgs").attr('title', response['error']['mimf_needed_kgs'])
                }

                if(response['error']['mimf_request_pins_pcs'] === undefined){
                    $("#txtMimfRequestPinsPcs").removeClass('is-invalid')
                    $("#txtMimfRequestPinsPcs").attr('title', '')
                }
                else{
                    $("#txtMimfRequestPinsPcs").addClass('is-invalid')
                    $("#txtMimfRequestPinsPcs").attr('title', response['error']['mimf_request_pins_pcs'])
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
                    $("#dateMimfDelivery").removeClass('is-invalid')
                    $("#dateMimfDelivery").attr('title', '')
                }
                else{
                    $("#dateMimfDelivery").addClass('is-invalid')
                    $("#dateMimfDelivery").attr('title', response['error']['mimf_delivery'])
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
            }else{
                $('.reset-value').removeClass('is-invalid')
                $("#formMimfPpsRequest")[0].reset()
                $('#modalMimfPpsRequest').modal('hide')
                dataTableMimfPpsRequest.draw()
                toastr.success('Succesfully saved!')
            }

            $("#iBtnMimfPpsRequestIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnMimfPpsRequest").removeClass('disabled')
            $("#iBtnMimfPpsRequestIcon").addClass('fa fa-check')
        },
        error: function(data, xhr, status){
            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status)
        }
    })
}

function GetMimfPpsRequestById(mimfPpsRequestID){
	$.ajax({
        url: "get_mimf_pps_request_by_id",
        method: "get",
        data: {
            'mimfPpsRequestID'  :   mimfPpsRequestID,
        },
        dataType: "json",
        beforeSend: function(){
            GetPpdMaterialType($('.get-mimf-device'))
        },

        success: function(response){
            let getMimfPpsRequestToEdit             = response['getMimfPpsRequestToEdit']
            let getMimfPpsRequestAllowedQtyToEdit   = response['getMimfPpsRequestAllowedQtyToEdit']
            if(getMimfPpsRequestToEdit.length > 0){
                setTimeout(() => {
                    $('#txtPpsWhseId').val(getMimfPpsRequestToEdit[0].pps_whse_id)
                    $("select[name='molding_product_category']").val(getMimfPpsRequestToEdit[0].product_category).trigger('change')
                    $("select[name='mimf_material_type']").val(getMimfPpsRequestToEdit[0].material_type)
                    $("input[name='mimf_material_code']").val(getMimfPpsRequestToEdit[0].material_code)
                    $('#txtMimfQuantityFromInventory').val(getMimfPpsRequestToEdit[0].qty_invt)
                    $('#txtMimfNeededKgs').val(getMimfPpsRequestToEdit[0].needed_kgs)
                    $('#txtRequestQuantity').val(getMimfPpsRequestToEdit[0].request_qty)
                    $('#multiplier').val(getMimfPpsRequestToEdit[0].multiplier)
                    $('#txtMimfRequestPinsPcs').val(getMimfPpsRequestToEdit[0].request_pins_pcs)
                    $('#txtMimfVirginMaterial').val(getMimfPpsRequestToEdit[0].virgin_material)
                    $('#txtMimfRecycled').val(getMimfPpsRequestToEdit[0].recycled)
                    $('#dateMimfProdn').val(getMimfPpsRequestToEdit[0].prodn)
                    $('#dateMimfDelivery').val(getMimfPpsRequestToEdit[0].delivery)
                    $('#txtMimfRemark').val(getMimfPpsRequestToEdit[0].remarks)
                }, 1000);

                if(getMimfPpsRequestAllowedQtyToEdit.length > 0){
                    $('#txtMimfMoldingAllowedQuantity').val(getMimfPpsRequestAllowedQtyToEdit[0].allowed_quantity)
                    $('#leftQty').val(getMimfPpsRequestAllowedQtyToEdit[0].balance)
                    $('#txtMimfMoldingAllowedQuantity').attr('readonly', false)
                    $('.auto-compute').attr('readonly', false)
                }
            }

        },
    })
}

function UpdateMimfStampignMatrix(){
	$.ajax({
        url: "update_mimf_stamping_matrix_v2",
        method: "post",
        data: $('#formMimfStampingMatrix').serialize(),
        dataType: "json",
        beforeSend: function(){
            $('.mimfClass').removeClass('is-invalid')
            $("#iBtnMimfStampingMatrixIcon").addClass('spinner-border spinner-border-sm')
            $("#btnMimfStampingMatrix").addClass('disabled')
            $("#iBtnMimfStampingMatrixIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['mimf_stamping_matrix_item_code'] === undefined){
                    $("#slctMimfStampingMatrixItemCode").removeClass('is-invalid')
                    $("#slctMimfStampingMatrixItemCode").attr('title', '')
                }
                else{
                    $("#slctMimfStampingMatrixItemCode").addClass('is-invalid')
                    $("#slctMimfStampingMatrixItemCode").attr('title', response['error']['mimf_stamping_matrix_item_code'])
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
            }else if(response['result'] == 0){
                alert('Item Code is not found in PPS Wharehouse')
            }else if(response['result'] == 1){
                alert('Data is already exists')
            }else{
                alert('It is not allowed to change the Item Code. '+"\n"+'Only PIN/KG can change.')
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
            console.log('getMimfStampingMatrixToEdit: ', getMimfStampingMatrixToEdit);
            if(getMimfStampingMatrixToEdit.length > 0){
                setTimeout(() => {     
                    $('select[name="mimf_stamping_matrix_item_code"]').val(getMimfStampingMatrixToEdit[0].stamping_pps_whse_info.PartNumber).trigger('change')
                    $('input[name="mimf_stamping_matrix_item_name"]').val(getMimfStampingMatrixToEdit[0].stamping_pps_whse_info.MaterialType)
                    $('#txtMimfStampingMatrixPinkg').val(getMimfStampingMatrixToEdit[0].pin_kg)
                }, 300);
            }
        },
    })
}
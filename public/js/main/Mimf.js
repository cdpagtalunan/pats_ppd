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
                    $("#slctMimfPmiPoNo").removeClass('is-invalid')
                    $("#slctMimfPmiPoNo").attr('title', '')
                }
                else{
                    $("#slctMimfPmiPoNo").addClass('is-invalid')
                    $("#slctMimfPmiPoNo").attr('title', response['error']['mimf_pmi_po_no'])
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

function GetOqcInspectionById(getPo,
    getPoQty,
    getOqcId,
    getProdId,
    getProdLotNo,
    getMaterialName,
    getProdShipOutput
){
	$.ajax({
        url: "get_oqc_inspection_by_id",
        method: "get",
        data: {
            'getPo'             : getPo,
            'getOqcId'          : getOqcId,
            'getPoQty'          : getPoQty,
            'getProdId'         : getProdId,
            'getProdLotNo'      : getProdLotNo,
            'getMaterialName'   : getMaterialName,
            'getProdShipOutput' : getProdShipOutput,
        },
        dataType: "json",
        beforeSend: function(){
            GetAQL($('.aqlDropdown'))
            GetFamily($('.familyDropdown'))
            GetCustomer($('.customerDropdown'))
            GeStampingLine($('.stampingLineDropdown'))
            GetInspectionType($('.inspectionTypeDropdown'))
            GetInspectionLevel($('.inspectionLevelDropdown'))
            GetSeverityInspection($('.severityInspectionDropdown'))
        },

        success: function(response){
            let getInspector            = response['getInspector']
            let getOqcInspectionData    = response['getOqcInspectionData']
            let firstStampingProduction = response['firstStampingProduction']

            if(firstStampingProduction[0].stamping_ipqc != null){
                if(firstStampingProduction[0].stamping_ipqc.bdrawing_active_doc_info[0] != null){
                    $('#txtBDrawing').val(firstStampingProduction[0].stamping_ipqc.bdrawing_active_doc_info[0].doc_title)
                    $('#txtBDrawingNo').val(firstStampingProduction[0].stamping_ipqc.bdrawing_active_doc_info[0].doc_no)
                    $('#txtBDrawingRevision').val(firstStampingProduction[0].stamping_ipqc.bdrawing_active_doc_info[0].rev_no)
                }

                if(firstStampingProduction[0].stamping_ipqc.ud_drawing_active_doc_info[0] != null){
                    $('#txtUdDrawing').val(firstStampingProduction[0].stamping_ipqc.ud_drawing_active_doc_info[0].doc_title)
                    $('#txtUdDrawingNo').val(firstStampingProduction[0].stamping_ipqc.ud_drawing_active_doc_info[0].doc_no)
                    $('#txtUdDrawingRevision').val(firstStampingProduction[0].stamping_ipqc.ud_drawing_active_doc_info[0].rev_no)
                }

                if(firstStampingProduction[0].stamping_ipqc.insp_std_drawing_active_doc_info[0] != null){
                    $('#txtInspStdDrawing').val(firstStampingProduction[0].stamping_ipqc.insp_std_drawing_active_doc_info[0].doc_title)
                    $('#txtInspStdDrawingNo').val(firstStampingProduction[0].stamping_ipqc.insp_std_drawing_active_doc_info[0].doc_no)
                    $('#txtInspStdDrawingRevision').val(firstStampingProduction[0].stamping_ipqc.insp_std_drawing_active_doc_info[0].rev_no)
                }
            }

            $('#txtOqcInspectionPoNo').val(getPo)
            $('#txtOqcInspectionPoQty').val(getPoQty)
            if($('#txtStatus').val() == '1'){
                $('#txtOqcInspectionLotNo').val(getProdLotNo)
            }else{
                $('#txtOqcInspectionLotNo').val(firstStampingProduction[0].material_lot_no+'/'+getProdLotNo)
            }
            $('#txtOqcInspectionLotQty').val(getProdShipOutput)
            $('#txtOqcInspectionMaterialName').val(getMaterialName)

            if(getOqcInspectionData.length > 0){
                $('#slctOqcInspectionStampingLine').val(getOqcInspectionData[0].stamping_line)
                $('#dateOqcInspectionApplicationDate').val(getOqcInspectionData[0].app_date)
                $('#timeOqcInspectionApplicationTime').val(getOqcInspectionData[0].app_time)
                $('#slctOqcInspectionProductCategory').val(getOqcInspectionData[0].prod_category)
                $('#slctOqcInspectionCustomer').val(getOqcInspectionData[0].customer)
                $('#txtOqcInspectionFamily').val(getOqcInspectionData[0].family)
                $('#slctOqcInspectionInspectionType').val(getOqcInspectionData[0].type_of_inspection)
                $('#slctOqcInspectionInspectionSeverity').val(getOqcInspectionData[0].severity_of_inspection)
                $('#slctOqcInspectionInspectionLevel').val(getOqcInspectionData[0].inspection_lvl)
                $('#slctOqcInspectionAql').val(getOqcInspectionData[0].aql)
                $('#txtOqcInspectionSampleSize').val(getOqcInspectionData[0].sample_size)
                $('#txtOqcInspectionAccept').val(getOqcInspectionData[0].accept)
                $('#txtOqcInspectionReject').val(getOqcInspectionData[0].reject)
                $('#dateOqcInspectionDateInspected').val(getOqcInspectionData[0].date_inspected)
                $('#txtOqcInspectionWorkWeek').val(getOqcInspectionData[0].ww)
                $('#txtOqcInspectionFiscalYear').val(getOqcInspectionData[0].fy)
                $('#timeOqcInspectionTimeInspectedFrom').val(getOqcInspectionData[0].time_ins_from)
                $('#timeOqcInspectionTimeInspectedTo').val(getOqcInspectionData[0].time_ins_to)
                $('#slctOqcInspectionShift').val(getOqcInspectionData[0].shift)
                $('#txtOqcInspectionInspector').val(getOqcInspectionData[0].inspector)
                $('#slctOqcInspectionCocRequirement').val(getOqcInspectionData[0].coc_req)
                $('#txtOqcInspectionJudgement').val(getOqcInspectionData[0].judgement)
                $('#txtOqcInspectionLotInspected').val(getOqcInspectionData[0].lot_inspected)
                $('#slctOqcInspectionLotAccepted').val(getOqcInspectionData[0].lot_accepted)
                $('#txtOqcInspectionRemarks').val(getOqcInspectionData[0].remarks)
                
                if(getOqcInspectionData[0].lot_accepted == 0){
                    GetMOD($('.inspectionModDropdown_0'))
                    $('.mod-class').removeClass('d-none')

                    if($('#txtCheckButton').val() == 'view'){
                        $('#slctOqcInspectionSubmission').val(getOqcInspectionData[0].submission)
                    }else{
                        $('#slctOqcInspectionSubmission').val(Number(getOqcInspectionData[0].submission)+1)
                    }
                }else{
                    $('.mod-class').addClass('d-none')
                    $('#slctOqcInspectionSubmission').val(getOqcInspectionData[0].submission)
                }

                for (let getPrintLot = 0; getPrintLot < getOqcInspectionData[0].print_lot_oqc_inspection_info.length; getPrintLot++) {
                    if(getPrintLot>0){
                        $('#btnAddPrintLot').trigger('click')
                    }else{
                        for (let getPrintLot = 0; getPrintLot < getOqcInspectionData[0].print_lot_oqc_inspection_info.length; getPrintLot++) {
                            $('#btnRemovePrintLot').trigger('click')
                        }
                    }
                    $(`#txtPrintLotNo_${getPrintLot}`).val(getOqcInspectionData[0].print_lot_oqc_inspection_info[getPrintLot]['print_lot_no'])
                    $(`#txtPrintLotQty_${getPrintLot}`).val(getOqcInspectionData[0].print_lot_oqc_inspection_info[getPrintLot]['print_lot_qty'])
                }

                for (let getReelLot = 0; getReelLot < getOqcInspectionData[0].reel_lot_oqc_inspection_info.length; getReelLot++) {
                    if(getReelLot>0){
                        $('#btnAddReelLot').trigger('click')
                    }else{
                        for (let getReelLot = 0; getReelLot < getOqcInspectionData[0].reel_lot_oqc_inspection_info.length; getReelLot++) {
                            $('#btnRemoveReelLot').trigger('click')
                        }
                    }
                    $(`#txtReelLotNo_${getReelLot}`).val(getOqcInspectionData[0].reel_lot_oqc_inspection_info[getReelLot]['reel_lot_no'])
                    $(`#txtReelLotQty_${getReelLot}`).val(getOqcInspectionData[0].reel_lot_oqc_inspection_info[getReelLot]['reel_lot_qty'])
                }

                let countDefects = 0
                for (let mod = 0; mod < getOqcInspectionData[0].mod_oqc_inspection_info.length; mod++) {
                    countDefects +=  parseInt(getOqcInspectionData[0].mod_oqc_inspection_info[mod]['mod_qty'])
                    if(mod>0){
                        $('#btnAddMod').trigger('click')
                    }else{
                        for (let mod = 0; mod < getOqcInspectionData[0].mod_oqc_inspection_info.length; mod++) {
                            $('#btnRemoveMod').trigger('click')
                        }
                    }

                    setTimeout(() => {
                        $(`#txtMod_${mod}`).val(getOqcInspectionData[0].mod_oqc_inspection_info[mod]['mod']).trigger('change')
                        $(`#txtModQty_${mod}`).val(getOqcInspectionData[0].mod_oqc_inspection_info[mod]['mod_qty'])
                    }, 400);

                    $('#txtOqcInspectionDefectiveNum').val(countDefects)
                }

                let percentage = (firstStampingProduction[0].ship_output-countDefects)/firstStampingProduction[0].ship_output*100
                $('#txtOqcInspectionYield').val(percentage.toFixed(2)+'%')
            }else{
                $('#txtOqcInspectionInspector').val(getInspector.firstname+' '+getInspector.lastname)
            }
        },
    })
}

function GeStampingLine(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_stamping_line",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result)
        },
        success: function(response){
            result = ''

            if(response['collectStampingLine'].length > 0){
                result = '<option selected disabled> --- Select --- </option>'
                for(let index = 0; index < response['collectStampingLine'].length; index++){
                    result += '<option value="' + response['collectStampingLine'][index].id+'">'+ response['collectStampingLine'][index].stamping_line+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result);
        }
    })
}

function GetFamily(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_family",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectFamily'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectFamily'].length; index++){
                    result += '<option value="' + response['collectFamily'][index].id+'">'+ response['collectFamily'][index].family+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result);
        }
    })
}

function GetInspectionType(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_inspection_type",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectInspectionType'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectInspectionType'].length; index++){
                    result += '<option value="' + response['collectInspectionType'][index].id+'">'+ response['collectInspectionType'][index].inspection_type+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

function GetInspectionLevel(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_inspection_level",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectInspectionLevel'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectInspectionLevel'].length; index++){
                    result += '<option value="' + response['collectInspectionLevel'][index].id+'">'+ response['collectInspectionLevel'][index].inspection_level+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

function GetSeverityInspection(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_severity_inspection",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectSeverityInspection'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectSeverityInspection'].length; index++){
                    result += '<option value="' + response['collectSeverityInspection'][index].id+'">'+ response['collectSeverityInspection'][index].severity_inspection+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

function GetAQL(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_aql",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = ''

            if(response['collectAql'].length > 0){
                result = '<option selected disabled> --- Select --- </option>'
                for(let index = 0; index < response['collectAql'].length; index++){
                    result += '<option value="' + response['collectAql'][index].id+'">'+ response['collectAql'][index].aql+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result);
        }
    })
}

function GetMOD(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_inspection_mod",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectMod'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectMod'].length; index++){
                    result += '<option value="' + response['collectMod'][index].id+'">'+ response['collectMod'][index].mode_of_defect+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

function GetCustomer(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_inspection_customer",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result);
        },
        success: function(response){
            result = '';

            if(response['collectCustomer'].length > 0){
                result = '<option selected disabled> --- Select --- </option>';
                for(let index = 0; index < response['collectCustomer'].length; index++){
                    result += '<option value="' + response['collectCustomer'][index].id+'">'+ response['collectCustomer'][index].customer+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}

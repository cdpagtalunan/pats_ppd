function UpdateOqcInspection(){
	$.ajax({
        url: "update_oqc_inspection",
        method: "post",
        data: $('#formOqcInspection').serialize(),
        dataType: "json",
        beforeSend: function(){
            $("#iBtnOqcInspectionIcon").addClass('spinner-border spinner-border-sm')
            $("#btnOqcInspection").addClass('disabled')
            $("#iBtnOqcInspectionIcon").removeClass('fa fa-check')
        },
        success: function(response){
            if(response['validationHasError'] == 1){
                toastr.error('Saving failed!')

                if(response['error']['oqc_inspection_assembly_line'] === undefined){
                    $("#slctOqcInspectionAssemblyLine").removeClass('is-invalid')
                    $("#slctOqcInspectionAssemblyLine").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionAssemblyLine").addClass('is-invalid');
                    $("#slctOqcInspectionAssemblyLine").attr('title', response['error']['oqc_inspection_assembly_line'])
                }

                if(response['error']['oqc_inspection_lot_no'] === undefined){
                    $("#txtOqcInspectionLotNo").removeClass('is-invalid')
                    $("#txtOqcInspectionLotNo").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionLotNo").addClass('is-invalid')
                    $("#txtOqcInspectionLotNo").attr('title', response['error']['oqc_inspection_lot_no'])
                }

                if(response['error']['oqc_inspection_application_date'] === undefined){
                    $("#dateOqcInspectionApplicationDate").removeClass('is-invalid')
                    $("#dateOqcInspectionApplicationDate").attr('title', '')
                }
                else{
                    $("#dateOqcInspectionApplicationDate").addClass('is-invalid')
                    $("#dateOqcInspectionApplicationDate").attr('title', response['error']['oqc_inspection_application_date'])
                }

                if(response['error']['oqc_inspection_application_time'] === undefined){
                    $("#timeOqcInspectionApplicationTime").removeClass('is-invalid')
                    $("#timeOqcInspectionApplicationTime").attr('title', '')
                }
                else{
                    $("#timeOqcInspectionApplicationTime").addClass('is-invalid')
                    $("#timeOqcInspectionApplicationTime").attr('title', response['error']['oqc_inspection_application_time'])
                }

                if(response['error']['oqc_inspection_product_category'] === undefined){
                    $("#slctOqcInspectionProductCategory").removeClass('is-invalid')
                    $("#slctOqcInspectionProductCategory").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionProductCategory").addClass('is-invalid')
                    $("#slctOqcInspectionProductCategory").attr('title', response['error']['oqc_inspection_product_category'])
                }

                if(response['error']['oqc_inspection_po_no'] === undefined){
                    $("#txtOqcInspectionPoNo").removeClass('is-invalid')
                    $("#txtOqcInspectionPoNo").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionPoNo").addClass('is-invalid')
                    $("#txtOqcInspectionPoNo").attr('title', response['error']['oqc_inspection_po_no'])
                }

                if(response['error']['oqc_inspection_material_name'] === undefined){
                    $("#txtOqcInspectionMaterialName").removeClass('is-invalid')
                    $("#txtOqcInspectionMaterialName").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionMaterialName").addClass('is-invalid')
                    $("#txtOqcInspectionMaterialName").attr('title', response['error']['oqc_inspection_material_name'])
                }

                if(response['error']['oqc_inspection_customer'] === undefined){
                    $("#txtOqcInspectionCustomer").removeClass('is-invalid')
                    $("#txtOqcInspectionCustomer").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionCustomer").addClass('is-invalid')
                    $("#txtOqcInspectionCustomer").attr('title', response['error']['oqc_inspection_customer'])
                }

                if(response['error']['oqc_inspection_po_qty'] === undefined){
                    $("#txtOqcInspectionPoQty").removeClass('is-invalid')
                    $("#txtOqcInspectionPoQty").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionPoQty").addClass('is-invalid')
                    $("#txtOqcInspectionPoQty").attr('title', response['error']['oqc_inspection_po_qty'])
                }

                if(response['error']['oqc_inspection_family'] === undefined){
                    $("#txtOqcInspectionFamily").removeClass('is-invalid')
                    $("#txtOqcInspectionFamily").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionFamily").addClass('is-invalid')
                    $("#txtOqcInspectionFamily").attr('title', response['error']['oqc_inspection_family'])
                }

                if(response['error']['oqc_inspection_inspection_type'] === undefined){
                    $("#slctOqcInspectionInspectionType").removeClass('is-invalid')
                    $("#slctOqcInspectionInspectionType").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionInspectionType").addClass('is-invalid')
                    $("#slctOqcInspectionInspectionType").attr('title', response['error']['oqc_inspection_inspection_type'])
                }

                if(response['error']['oqc_inspection_inspection_severity'] === undefined){
                    $("#slctOqcInspectionInspectionSeverity").removeClass('is-invalid')
                    $("#slctOqcInspectionInspectionSeverity").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionInspectionSeverity").addClass('is-invalid')
                    $("#slctOqcInspectionInspectionSeverity").attr('title', response['error']['oqc_inspection_inspection_severity'])
                }

                if(response['error']['oqc_inspection_inspection_level'] === undefined){
                    $("#slctOqcInspectionInspectionLevel").removeClass('is-invalid')
                    $("#slctOqcInspectionInspectionLevel").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionInspectionLevel").addClass('is-invalid')
                    $("#slctOqcInspectionInspectionLevel").attr('title', response['error']['oqc_inspection_inspection_level'])
                }

                if(response['error']['oqc_inspection_lot_qty'] === undefined){
                    $("#txtOqcInspectionLotQty").removeClass('is-invalid')
                    $("#txtOqcInspectionLotQty").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionLotQty").addClass('is-invalid')
                    $("#txtOqcInspectionLotQty").attr('title', response['error']['oqc_inspection_lot_qty'])
                }

                if(response['error']['oqc_inspection_aql'] === undefined){
                    $("#slctOqcInspectionAql").removeClass('is-invalid')
                    $("#slctOqcInspectionAql").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionAql").addClass('is-invalid')
                    $("#slctOqcInspectionAql").attr('title', response['error']['oqc_inspection_aql'])
                }

                if(response['error']['oqc_inspection_sample_size'] === undefined){
                    $("#txtOqcInspectionSampleSize").removeClass('is-invalid')
                    $("#txtOqcInspectionSampleSize").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionSampleSize").addClass('is-invalid')
                    $("#txtOqcInspectionSampleSize").attr('title', response['error']['oqc_inspection_sample_size'])
                }

                if(response['error']['oqc_inspection_accept'] === undefined){
                    $("#txtOqcInspectionAccept").removeClass('is-invalid')
                    $("#txtOqcInspectionAccept").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionAccept").addClass('is-invalid')
                    $("#txtOqcInspectionAccept").attr('title', response['error']['oqc_inspection_accept'])
                }

                if(response['error']['oqc_inspection_reject'] === undefined){
                    $("#txtOqcInspectionReject").removeClass('is-invalid')
                    $("#txtOqcInspectionReject").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionReject").addClass('is-invalid')
                    $("#txtOqcInspectionReject").attr('title', response['error']['oqc_inspection_reject'])
                }

                if(response['error']['oqc_inspection_date_inspected'] === undefined){
                    $("#dateOqcInspectionDateInspected").removeClass('is-invalid')
                    $("#dateOqcInspectionDateInspected").attr('title', '')
                }
                else{
                    $("#dateOqcInspectionDateInspected").addClass('is-invalid')
                    $("#dateOqcInspectionDateInspected").attr('title', response['error']['oqc_inspection_date_inspected'])
                }

                if(response['error']['oqc_inspection_work_week'] === undefined){
                    $("#txtOqcInspectionWorkWeek").removeClass('is-invalid')
                    $("#txtOqcInspectionWorkWeek").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionWorkWeek").addClass('is-invalid')
                    $("#txtOqcInspectionWorkWeek").attr('title', response['error']['oqc_inspection_work_week'])
                }

                if(response['error']['oqc_inspection_fiscal_year'] === undefined){
                    $("#txtOqcInspectionFiscalYear").removeClass('is-invalid')
                    $("#txtOqcInspectionFiscalYear").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionFiscalYear").addClass('is-invalid')
                    $("#txtOqcInspectionFiscalYear").attr('title', response['error']['oqc_inspection_fiscal_year'])
                }

                if(response['error']['oqc_inspection_time_inspected_from'] === undefined){
                    $("#timeOqcInspectionTimeInspectedFrom").removeClass('is-invalid')
                    $("#timeOqcInspectionTimeInspectedFrom").attr('title', '')
                }
                else{
                    $("#timeOqcInspectionTimeInspectedFrom").addClass('is-invalid')
                    $("#timeOqcInspectionTimeInspectedFrom").attr('title', response['error']['oqc_inspection_time_inspected_from'])
                }

                if(response['error']['oqc_inspection_time_inspected_to'] === undefined){
                    $("#timeOqcInspectionTimeInspectedTo").removeClass('is-invalid')
                    $("#timeOqcInspectionTimeInspectedTo").attr('title', '')
                }
                else{
                    $("#timeOqcInspectionTimeInspectedTo").addClass('is-invalid')
                    $("#timeOqcInspectionTimeInspectedTo").attr('title', response['error']['oqc_inspection_time_inspected_to'])
                }

                if(response['error']['oqc_inspection_shift'] === undefined){
                    $("#slctOqcInspectionShift").removeClass('is-invalid')
                    $("#slctOqcInspectionShift").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionShift").addClass('is-invalid')
                    $("#slctOqcInspectionShift").attr('title', response['error']['oqc_inspection_shift'])
                }

                if(response['error']['oqc_inspection_inspector'] === undefined){
                    $("#txtOqcInspectionInspector").removeClass('is-invalid')
                    $("#txtOqcInspectionInspector").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionInspector").addClass('is-invalid')
                    $("#txtOqcInspectionInspector").attr('title', response['error']['oqc_inspection_inspector'])
                }

                if(response['error']['oqc_inspection_submission'] === undefined){
                    $("#slctOqcInspectionSubmission").removeClass('is-invalid')
                    $("#slctOqcInspectionSubmission").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionSubmission").addClass('is-invalid')
                    $("#slctOqcInspectionSubmission").attr('title', response['error']['oqc_inspection_submission'])
                }

                if(response['error']['oqc_inspection_coc_requirement'] === undefined){
                    $("#slctOqcInspectionCocRequirement").removeClass('is-invalid')
                    $("#slctOqcInspectionCocRequirement").attr('title', '')
                }
                else{
                    $("#slctOqcInspectionCocRequirement").addClass('is-invalid')
                    $("#slctOqcInspectionCocRequirement").attr('title', response['error']['oqc_inspection_coc_requirement'])
                }

                if(response['error']['oqc_inspection_judgement'] === undefined){
                    $("#txtOqcInspectionJudgement").removeClass('is-invalid')
                    $("#txtOqcInspectionJudgement").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionJudgement").addClass('is-invalid')
                    $("#txtOqcInspectionJudgement").attr('title', response['error']['oqc_inspection_judgement'])
                }

                if(response['error']['oqc_inspection_lot_inspected'] === undefined){
                    $("#txtOqcInspectionLotInspected").removeClass('is-invalid')
                    $("#txtOqcInspectionLotInspected").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionLotInspected").addClass('is-invalid')
                    $("#txtOqcInspectionLotInspected").attr('title', response['error']['oqc_inspection_lot_inspected'])
                }

                if(response['error']['oqc_inspection_lot_accepted'] === undefined){
                    $("#txtOqcInspectionLotAccepted").removeClass('is-invalid')
                    $("#txtOqcInspectionLotAccepted").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionLotAccepted").addClass('is-invalid')
                    $("#txtOqcInspectionLotAccepted").attr('title', response['error']['oqc_inspection_lot_accepted'])
                }

                if(response['error']['oqc_inspection_defective_num'] === undefined){
                    $("#txtOqcInspectionDefectiveNum").removeClass('is-invalid')
                    $("#txtOqcInspectionDefectiveNum").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionDefectiveNum").addClass('is-invalid')
                    $("#txtOqcInspectionDefectiveNum").attr('title', response['error']['oqc_inspection_defective_num'])
                }

                if(response['error']['oqc_inspection_remarks'] === undefined){
                    $("#txtOqcInspectionRemarks").removeClass('is-invalid')
                    $("#txtOqcInspectionRemarks").attr('title', '')
                }
                else{
                    $("#txtOqcInspectionRemarks").addClass('is-invalid')
                    $("#txtOqcInspectionRemarks").attr('title', response['error']['oqc_inspection_remarks'])
                }
            }else if(response['hasError'] == 0){
                $("#formOqcInspection")[0].reset()
                $('#modalOqcInspection').modal('hide')
                toastr.success('Succesfully saved!')
                dataTableOQCInspection.draw()
            }
            // else{
            // }

            $("#iBtnOqcInspectionIcon").removeClass('spinner-border spinner-border-sm')
            $("#btnOqcInspection").removeClass('disabled')
            $("#iBtnOqcInspectionIcon").addClass('fa fa-check')
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
    getDeviceName
){
	$.ajax({
        url: "get_oqc_inspection_by_id",
        method: "get",
        data: {
            'getPo'         : getPo,
            'getOqcId'      : getOqcId,
            'getPoQty'      : getPoQty,
            'getProdId'     : getProdId,
            'getDeviceName' : getDeviceName,
        },
        dataType: "json",
        success: function(response){
            let getOqcInspectionData    = response['getOqcInspectionData']
            let activeDoc               = response['activeDoc']

            $('#txtBDrawing').val(activeDoc[0].material_name)
            $('#txtBDrawingNo').val(activeDoc[0].acdcs_active_doc_info[0].doc_no)
            $('#txtBDrawingRevision').val(activeDoc[0].acdcs_active_doc_info[0].rev_no)

            if(getOqcInspectionData.length > 0){
                $('#slctOqcInspectionAssemblyLine').val(getOqcInspectionData[0].assembly_line)
                $('#txtOqcInspectionLotNo').val(getOqcInspectionData[0].lot_no)
                $('#dateOqcInspectionApplicationDate').val(getOqcInspectionData[0].app_date)
                $('#timeOqcInspectionApplicationTime').val(getOqcInspectionData[0].app_time)
                $('#slctOqcInspectionProductCategory').val(getOqcInspectionData[0].prod_category)
                $('#txtOqcInspectionPoNo').val(getOqcInspectionData[0].po_no)
                $('#txtOqcInspectionMaterialName').val(getOqcInspectionData[0].device_name)
                $('#txtOqcInspectionCustomer').val(getOqcInspectionData[0].customer)
                $('#txtOqcInspectionPoQty').val(getOqcInspectionData[0].po_qty)
                $('#txtOqcInspectionFamily').val(getOqcInspectionData[0].family)
                $('#slctOqcInspectionInspectionType').val(getOqcInspectionData[0].type_of_inspection)
                $('#slctOqcInspectionInspectionSeverity').val(getOqcInspectionData[0].severity_of_inspection)
                $('#slctOqcInspectionInspectionLevel').val(getOqcInspectionData[0].inspection_lvl)
                $('#txtOqcInspectionLotQty').val(getOqcInspectionData[0].lot_qty)
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
                $('#slctOqcInspectionSubmission').val(getOqcInspectionData[0].submission)
                $('#slctOqcInspectionCocRequirement').val(getOqcInspectionData[0].coc_req)
                $('#txtOqcInspectionJudgement').val(getOqcInspectionData[0].judgement)
                $('#txtOqcInspectionLotInspected').val(getOqcInspectionData[0].lot_inspected)
                $('#txtOqcInspectionLotAccepted').val(getOqcInspectionData[0].lot_accepted)
                $('#txtOqcInspectionRemarks').val(getOqcInspectionData[0].remarks)

                if(getOqcInspectionData[0].lot_accepted == '0'){
                    $('.mod-class').removeClass('d-none')
                }

                console.log('Print Lot No:',getOqcInspectionData[0].print_lot_oqc_inspection_info)
                console.log('Reel Lot No:',getOqcInspectionData[0].reel_lot_oqc_inspection_info)
                console.log('MOD:',getOqcInspectionData[0].mod_oqc_inspection_info)

                for (let getPrintLot = 0; getPrintLot < getOqcInspectionData[0].print_lot_oqc_inspection_info.length; getPrintLot++) {
                    if(getPrintLot>0){
                        $('#btnAddPrintLot').trigger('click')
                    }else{
                        $('#btnRemovePrintLot').trigger('click')
                    }
                    $(`#txtPrintLotNo_${getPrintLot}`).val(getOqcInspectionData[0].print_lot_oqc_inspection_info[getPrintLot]['print_lot_no'])
                    $(`#txtPrintLotQty_${getPrintLot}`).val(getOqcInspectionData[0].print_lot_oqc_inspection_info[getPrintLot]['print_lot_qty'])
                }

                for (let getReelLot = 0; getReelLot < getOqcInspectionData[0].reel_lot_oqc_inspection_info.length; getReelLot++) {
                    if(getReelLot>0){
                        $('#btnAddReelLot').trigger('click')
                    }else{
                        $('#btnRemoveReelLot').trigger('click')
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
                        $('#btnRemoveMod').trigger('click')
                    }
                    
                    setTimeout(() => {     
                        $(`#txtMod_${mod}`).val(getOqcInspectionData[0].mod_oqc_inspection_info[mod]['mod']).trigger('change')
                        $(`#txtModQty_${mod}`).val(getOqcInspectionData[0].mod_oqc_inspection_info[mod]['mod_qty'])
                    }, 400);

                    $('#txtOqcInspectionDefectiveNum').val(countDefects)
                }
            }else{
                $('#txtOqcInspectionPoNo').val(getPo)
                $('#txtOqcInspectionPoQty').val(getPoQty)
                $('#txtOqcInspectionMaterialName').val(getDeviceName)
            }

        },
    })
}

function GeAssemblyLine(cboElement){
    let result = '<option value="">N/A</option>'

    $.ajax({
        url: "get_oqc_assembly_line",
        method: "get",
        dataType: "json",

        beforeSend: function(){
            result = '<option value="" selected disabled> -- Loading -- </option>'
            cboElement.html(result)
        },
        success: function(response){
            result = ''

            if(response['collectAssemblyLine'].length > 0){
                result = '<option selected disabled> --- Select --- </option>'
                for(let index = 0; index < response['collectAssemblyLine'].length; index++){
                    result += '<option value="' + response['collectAssemblyLine'][index].assembly_line+'">'+ response['collectAssemblyLine'][index].assembly_line+'</option>'
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
                    result += '<option value="' + response['collectFamily'][index].family+'">'+ response['collectFamily'][index].family+'</option>'
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
                    result += '<option value="' + response['collectInspectionType'][index].inspection_type+'">'+ response['collectInspectionType'][index].inspection_type+'</option>'
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
                    result += '<option value="' + response['collectInspectionLevel'][index].inspection_level+'">'+ response['collectInspectionLevel'][index].inspection_level+'</option>'
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
                    result += '<option value="' + response['collectSeverityInspection'][index].severity_inspection+'">'+ response['collectSeverityInspection'][index].severity_inspection+'</option>'
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
                    result += '<option value="' + response['collectAql'][index].aql+'">'+ response['collectAql'][index].aql+'</option>'
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
                    result += '<option value="' + response['collectMod'][index].mode_of_defect+'">'+ response['collectMod'][index].mode_of_defect+'</option>'
                }
            }
            else{
                result = '<option value="0" selected disabled> No record found </option>'
            }
            cboElement.html(result)
        }
    })
}
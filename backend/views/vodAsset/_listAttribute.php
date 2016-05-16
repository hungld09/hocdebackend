<table id='listAttributes'></table>
<script>
var lastsel;
jQuery("#listAttributes").jqGrid({ 
        url:'<?php echo CController::createUrl('vodAttribute/getListAttributes?id='.$model->id.'&categories=')?>'+$("#VodAsset_categories").val(), 
        datatype: "json", 
        colNames:['Name','Data Type','Value'], 
        colModel:[ 
            {name:'display_name',index:'t.display_name', width:350, classes:'colStyle',align:'center'},  
            {name:'data_type',index:'t.data_type', width:250, classes:'colStyle',align:'center'},
            {name:'value',index:'value',editable:true,editrules:{custom:true, custom_func:checkValue}, width:150,align:'center', width:250},
          
        ],
        sortname: 't.display_name', 
        editurl: '<?php echo CController::createUrl('updateAttributeValue?vod_asset_id='.$model->id)?>',
        viewrecords: true, 
        sortorder: "asc", 
        caption:"List Attributes",
        onSelectRow: function(id){ if(id && id!==lastsel){ 
                jQuery('#listAttributes').jqGrid('restoreRow',lastsel); 
                jQuery('#listAttributes').jqGrid('editRow',id,true,pickdates); 
                lastsel=id; 
                

            } 
        }
        });
function pickdates(id){ 
    if ($('#listAttributes').getCell(id, 'data_type')=='datetime') {
    jQuery("#"+id+"_value","#listAttributes").datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional[''], {'timeFormat':'hh:mm:ss','dateFormat':'yy-mm-dd','showSecond':true}));  
    $("#"+id+"_value").blur();
    }
}

function selectAttributeForCategories() {
    $('#listAttributes').setGridParam({postData:{series:''}}); 
    if ($("#VodAsset_categories").val()!='')
        $('#listAttributes').setGridParam({postData:{categories:$("#VodAsset_categories").val()}}); 
    else $('#listAttributes').setGridParam({postData:{categories:'null'}}); 
    $("#listAttributes").trigger('reloadGrid');
}

function selectAttributeForSeries() {
        $('#listAttributes').setGridParam({postData:{categories:null}}); 
        $('#listAttributes').setGridParam({postData:{series:$("#VodAsset_vod_series_id option:selected").val()}}); 
        $("#listAttributes").trigger('reloadGrid');
}

function checkValue(value){ 
    var dataType = $('#listAttributes').getCell(lastsel, 'data_type');
    var result = null;
    switch (dataType) {
    case 'int': result = checkInt(value); break;
    case 'datetime': result = checkDate(value); break;
    case 'double': result = checkFloat(value); break;
    default: result = null;
    }
    
    if (result!=null) {
        return [false,result,""]; 
    }else return [true];
}
</script>
<!-- <div id="category_info" class='form-actions'> -->
<?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vod-asset-form-for-series-info',
                        'enableAjaxValidation'=>false,
                ));
?>
    
</span>
<fieldset>
    <legend class="legend">
                <b id='legend'>
                    <?php 
                        echo Chtml::label("Categories Info", '', array('id'=>'forCategoriesInfo'));
                    ?></b>
    </legend>  
    <table>
        <tr style="height: 50px">
            <td>
                <span id="category_info_display">
                    <table id="listCategories"></table> 
                <?php
                $models = VodCategory::model()->findAllByAttributes(array("level" => "0", 'status'=>1), array("order" => "order_number ASC"));
                $items = array();
                foreach ($models as $model2) {
                    $model2->path_name = $model2->display_name;
                    $items = array_merge($items, $model2->getListed());
                }

                $responce = array();
                $i = 0;
                foreach ($items as $item) {
                    foreach ($items as $item2) {
                        if (($item2->id != $item->id) && stripos('/' . $item2->path . '/', '/' . $item->id . '/') !== FALSE)
                            $item->children .= $item2->id . ',';
                    }
                    $category = array('id' => $item->id, 'children' => $item->children, 'category' => $item->display_name, 'level' => $item->level, 'parent' => $item->parent_id, 'isLeaf' => ($item->vodCategories == Null), 'expanded' => true, 'loaded' => false);
                    array_push($responce, $category);
                }
                $responce = array('response' => $responce);

                    echo $form->hiddenField($model,'categories');  
                    echo CHtml::hiddenField('categoriesBeforeSubmit',$model->categories,array('id'=>'VodAsset_categoriesBeforeSubmit'));
                ?> 
                </span>
            </td>
        </tr>
        <?php $this->endWidget();?>
    </table>  
    
     <?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:left; cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'$("#series_info_display").hide();                  
                                                            $("#nextInSeriesDisplay").hide(); 
                                                            $("#previousInSeriesDisplay").hide(); 
                                                            $("#category_info_display").show();
                                                            $("#forSeriesInfo").hide();
                                                            $("#forCategoriesInfo").show();
                                                            var listCategories = jQuery("#listCategories").getCol("enbl",true);
                                                            for (i=0; i < listCategories.length; i++){ 
                                                                $("#checked2_"+listCategories[i].id).attr("disabled", false);
                                                            }
                                                            $("#isSeriesInput").show();
                                                            $("#seriesInfoEdit").hide();
                                                            $("#seriesInfoSubmit").show();
                                                            $("#seriesInfoCancel").show();
                                                            loadForUpdate();
                                                           ',
                                               'id'=>'seriesInfoEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:left; display:none;cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                           $("#isSeriesInput").hide();
                                                           $("#seriesInfoEdit").show();
                                                           $("#seriesInfoSubmit").hide();
                                                           $("#seriesInfoCancel").hide(); 
                                                           if (!$("#VodAsset_is_series").is(":checked")) {
                                                           
                                                               
                                                                $("#forSeriesInfo").hide();
                                                                $("#forCategoriesInfo").show();
                                                                $("#category_info_display").show();
                                                                $("#inSeriesStatus").val(0);
                                                                sendCategoryInfo();
                                                            } else {
                                                                if ($("#VodAsset_previous_in_series_id option:selected").val()!="") {
                                                                    $("#previousNameLabel").text($("#VodAsset_previous_in_series_id option:selected").text());
                                                                } else $("#previousNameLabel").text("Not Have Previous Asset");
                                                                $("#loader").show();
                                                                $("#nextNameLabel").text(\'\');
                                                                $("#series_info_display").show();                  
                                                                $("#nextInSeriesDisplay").show(); 
                                                                $("#previousInSeriesDisplay").show();
                                                                $("#seriesNameLabel").text($("#VodAsset_vod_series_id option:selected").text());
                                                                
                                                                $("#series_select").hide();
                                                                $("#previousInSeriesInput").hide();
                                                                $("#forSeriesInfo").show();
                                                                $("#forCategoriesInfo").hide();
                                                                $("#category_info_display").hide();
                                                                $("#inSeriesStatus").val(1);
                                                                sendSeriesInfo();
                                                            }
                                                           
                                                            
                                                            ',
                                               'id'=>'seriesInfoSubmit'             
                                                            
                ));
          
          echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:left; display:none;margin-left:10px;cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                            $("#isSeriesInput").hide();
                                                            $("#seriesInfoEdit").show();
                                                            $("#seriesInfoSubmit").hide();
                                                            $("#seriesInfoCancel").hide();
                                                            $("#series_select").hide();
                                                            $("#previousInSeriesInput").hide();
                                                            if ($("#inSeriesStatus").val()==1) {
                                                                $("#series_info_display").show();                                    
                                                                $("#nextInSeriesDisplay").show();
                                                                $("#previousInSeriesDisplay").show();
                                                                $("#category_info_display").hide();
                                                                $("#forSeriesInfo").show();
                                                                $("#forCategoriesInfo").hide();
                                                                } 
                                                            else {
                                                                
                                                                $("#forSeriesInfo").hide();
                                                                $("#forCategoriesInfo").show();
                                                                $("#category_info_display").show();
                                                                $("#VodAsset_categories").val($("#VodAsset_categoriesBeforeSubmit").val());
                                                                restore();
                                                         
                                                            }
                                                           ',
                                               'id'=>'seriesInfoCancel'             
                                                            
                ));
    ?>
    
</fieldset>
<script>
    function sendCategoryInfo() {
    
        $.ajax({
          url:"<?php echo Yii::app()->createUrl('vodAsset/updateCategoryInfo') ?>",
          data: {categories:$('#VodAsset_categories').val(), id: "<?php echo $model->id?>" },
          type: 'POST',
          success: function(){
              $("#VodAsset_categoriesBeforeSubmit").val($("#VodAsset_categories").val());
              var listCategories = jQuery("#listCategories").getCol("enbl",true);
              for (i=0; i < listCategories.length; i++){ 
                $("#checked2_"+listCategories[i].id).attr("disabled", true);
              }
              $('#listAttributes').setGridParam({postData:{categories:$("#VodAsset_categories").val()}}); 
              $("#listAttributes").trigger("reloadGrid");
          }
        });
    }
    jQuery("#listCategories").jqGrid({
        datastr: '<?php echo json_encode($responce)?>',
        datatype: "jsonstring",
        height: "auto",
        colNames: ["","",""],
        colModel: [
            //{name: "id",width:1, hidden:true, key:true},
            {name: "category", width:200, resizable: false, sortable: false},
            {name: "children", width:20, resizable: false,hidden:true, sortable: false},
            {name:'enbl',width: 60, align:'center', formatter:checkboxFormatter2, editoptions:{value:'1:0'}, formatoptions:{disabled:false}}
        ],
     
        treeGrid: true,
        treeGridModel: "adjacency",
        caption: "Vod Categories",
        ExpandColumn: "category",
        ExpandColClick: true,
        //autowidth: true,
        rowNum: 10000,
        //ExpandColClick: true,
        treeIcons: {leaf:'ui-icon-document-b'},
        jsonReader: {
            repeatitems: false,
            root: "response"
        }
    });   
$('#listCategories_category').hide();
$('#listCategories_enbl').hide();
$('.ui-jqgrid tr.jqgrow td').css('border','none');

function checkboxFormatter2(cellvalue, options, rowObject) {
                           return "<input type='checkbox' id='checked2_"+rowObject.id+"' onclick='checkCategory2("+rowObject.id+");'/>";
}
function checkCategory2(rowId) {
    var categories = $("#VodAsset_categories").val();
    if (($("#checked2_"+rowId).is(":checked"))) {
        var record = jQuery('#listCategories').getRowData(rowId);
        var parentNodes = jQuery("#listCategories").getNodeAncestors(record);   
        for (i = 0; i < parentNodes.length; i++) {
            $("#checked2_"+parentNodes[i]._id_).attr('checked', true);
            if (categories.indexOf(' '+parentNodes[i]._id_+',')==-1){
                $("#VodAsset_categories").val($("#VodAsset_categories").val()+' '+ parentNodes[i]._id_ +',');
            }
        }
        $("#VodAsset_categories").val($("#VodAsset_categories").val()+' '+ rowId +',');
    } else {
        var record = jQuery('#listCategories').getRowData(rowId);
        var childrenNodes = record.children.split(",");
        for (i = 0; i < childrenNodes.length; i++) 
            if (childrenNodes[i]!=''){       
            $("#checked2_"+childrenNodes[i]).attr('checked', false);
            categories = categories.replace(' '+ childrenNodes[i]+',','');
            }
        categories = categories.replace(' '+ rowId+',','');
        $("#VodAsset_categories").val(categories);
    }

}
restore();
function restore() {
    var listCategories = jQuery('#listCategories').getCol('enbl',true);
    for (i=0; i < listCategories.length; i++){ 
        $("#checked2_"+listCategories[i].id).attr('checked', false);
        $("#checked2_"+listCategories[i].id).attr('disabled', true);
    }
    
    var categories = $("#VodAsset_categories").val();
    var listCategories =  categories.split(',');
    
    for (i=0; i < listCategories.length; i++) if($.trim(listCategories[i])!='') {
        $("#checked2_"+$.trim(listCategories[i])).attr('checked', true);
        var record = jQuery('#listCategories').getRowData($.trim(listCategories[i]));
        var parentNodes = jQuery("#listCategories").getNodeAncestors(record);   
        for (j = 0; j < parentNodes.length; j++) {
            $("#checked2_"+parentNodes[j]._id_).attr('checked', true);
            if (categories.indexOf(' '+parentNodes[j]._id_+',')==-1){
                $("#VodAsset_categories").val($("#VodAsset_categories").val()+' '+ parentNodes[j]._id_ +',');
            }
        }
    }
}
</script>
<!-- </div> -->
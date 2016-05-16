
<?php
$this->breadcrumbs=array(
	'Vod Assets'=>array('admin'),
	'Manage',
);

$this->menu=array(
	
    array('label'=>'Tạo phim mới', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vod-asset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage videos</h1>
<br/>
<br/>


<div style="width: 25%; float: left">
    <table id="listCategories"></table> 
    <br/>
    <div style="text-align: center">
        <?php
        echo CHtml::button('Search By Categories', array('onclick'=>'js:$("#gs_categories").val($("#categories2").val());
                                                         $("#listAssets")[0].triggerToolbar();'));
        ?>    
    </div>
</div>
<div style="width: 75%; float: left">
<?php 
 
$this->renderPartial('_listAsset',array('model'=>$model,'page'=>1));


?>
<div style="text-align: right">
    <?php echo CHtml::image(Yii::app()->baseUrl . '/images/loader.gif', '', array('width'=>'20px','class' => 'editField','id'=> 'loaderAsset'));?>
</div>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'categoryDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Select Category',
        'autoOpen'=>false,
        'minWidth'=>400,
        'minHeight'=>300,
        'modal'=>true
    ),
));
?>
    
 <table id="listCategoriesForAdd"></table> 
 <br/>
<?php

echo CHtml::hiddenField('categories');   
echo CHtml::hiddenField('categories2'); 
echo CHtml::ajaxSubmitButton('Submit', CController::createUrl('addIntoCategory'),array('success'=>'function(){$("#messageDialog").dialog("open");resetSelect(); }',
                        'data'=>array('categories'=>'js:$("#categories").val()','assets'=>'js:$.cookie("jqsel_grid_id")'),'type' =>'POST'),array('type'=>'submit','onclick'=>'$("#categoryDialog").dialog("close");'));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
 <br/>
 <?php
echo CHtml::button('Add Into Category', array(
   'onclick'=>' if (!$("#categoryDialog").dialog("isOpen"))
                $("#categoryDialog").dialog("open"); else  $("#categoryDialog").dialog("close");
               return false;', 'id'=>'addBtn'
        ));?> &nbsp;
<input onclick="active();" name="yt2" type="button" value="Active">
<input onclick="inactive();" name="yt2" type="button" value="Inactive">
<?php 
//echo CHtml::button('Add Into Package', array(
//   'onclick'=>' if (!$("#packageDialog").dialog("isOpen"))
//                $("#packageDialog").dialog("open"); else  $("#packageDialog").dialog("close");
//               return false;', 'id'=>'addPackageBtn'
//));
?>
        
<?php 
$models = VodCategory::model()->findAllByAttributes(array("level"=>"0"),array("order"=>"order_number ASC"));
                $items = array(); 
                      foreach ($models as $model2) {
                          $model2->path_name = $model2->display_name;
                          $items = array_merge($items,$model2->getListed());
                      }
                      
$responce = array();


$i=0;

foreach ($items as $item) { 
    foreach ($items as $item2) {
        if (($item2->id != $item->id) && stripos('/'.$item2->path.'/', '/'.$item->id.'/')!==FALSE) $item->children .= $item2->id.',';
    }   
    $category = array('id'=>$item->id,'children'=>$item->children,'category'=>$item->display_name,'level'=>$item->level,'parent'=>$item->parent_id,'isLeaf'=>($item->vodCategories==Null),'expanded'=>true,'loaded'=>false);
    array_push($responce, $category);
    
}
$responce = array('response'=>$responce);
?>
</div>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'messageDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Add Into Category Succesfully',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
				
        
    ),
));
?>
<div id="dialog-message" title="Add Into Categories">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		You have added into categories successfully.
	</p>
	
</div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'messagePackageDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Add Into Package Succesfully',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
				
        
    ),
));
?>
<div id="dialog-message" title="Add Into Packages">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		You have added into packages successfully.
	</p>
	
</div>
<?php 
$this->endWidget('zii.wigets.jui.CJuiDialog'); 
?>



<script>
//$(document).click(function(e){
//           if (!$(e.target).parents().filter('.ui-dialog').length && e.target.id!='addBtn') {
//                      $("#categoryDialog").dialog("close"); 
//            
//           }
//           if (!$(e.target).parents().filter('.ui-dialog').length && e.target.id!='addPackageBtn') {
//                      $("#packageDialog").dialog("close"); 
//            
//           }
//
//}); 

  
    
    
    
    jQuery("#listCategories").jqGrid({
        datastr: '<?php echo json_encode($responce)?>',
        datatype: "jsonstring",
        height: "auto",
        colNames: ["","",""],
        colModel: [
            //{name: "id",width:1, hidden:true, key:true},
            {name: "category", width:200, resizable: false, sortable: false},
            {name: "children", width:200, resizable: false,hidden:true, sortable: false},
            {name:'enbl',width: 60, align:'center', formatter:checkboxFormatter2, editoptions:{value:'1:0'}, formatoptions:{disabled:false}}
        ],
        height:'auto',
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
        },
        beforeSelectRow: function() {return false;}
    });   
$('#listCategories_category').hide();
$('#listCategories_enbl').hide();
$('.ui-jqgrid tr.jqgrow td').css('border','none');
//function addCategory(){
    jQuery("#listCategoriesForAdd").jqGrid({
            datastr: '<?php echo json_encode($responce)?>',
            datatype: "jsonstring",
            height: "auto",
            colNames: ["","",""],
            colModel: [ 
                {name: "category", width:250, resizable: false, sortable: false},
                {name: "children", width:250, resizable: false,hidden:true, sortable: false},
                {name:'enbl',width: 60, align:'center', formatter:checkboxFormatter, editoptions:{value:'1:0'}, formatoptions:{disabled:false}}

            ],
            height:'auto',
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
            },
            beforeSelectRow: function() {return false;}
            
        }); 
// }

function checkboxFormatter(cellvalue, options, rowObject) {
   
                           return "<input type='checkbox' id='checked_"+rowObject.id+"' onclick='checkCategory("+rowObject.id+");'/>";
}
function checkCategory(rowId) {
    var categories = $("#categories").val();
    if (($("#checked_"+rowId).is(":checked"))) {
        var record = jQuery('#listCategoriesForAdd').getRowData(rowId);
        var parentNodes = jQuery("#listCategoriesForAdd").getNodeAncestors(record);   
        for (i = 0; i < parentNodes.length; i++) {
            $("#checked_"+parentNodes[i]._id_).attr('checked', true);
            if (categories.indexOf(' '+parentNodes[i]._id_+',')==-1){
                $("#categories").val($("#categories").val()+' '+ parentNodes[i]._id_ +',');
            }
        }
        $("#categories").val($("#categories").val()+' '+ rowId +',');
    } else {
        var record = jQuery('#listCategoriesForAdd').getRowData(rowId);
        var childrenNodes = record.children.split(",");
        for (i = 0; i < childrenNodes.length; i++) 
            if (childrenNodes[i]!=''){       
            $("#checked_"+childrenNodes[i]).attr('checked', false);
            categories = categories.replace(' '+ childrenNodes[i]+',','');
            }
        categories = categories.replace(' '+ rowId+',','');
        $("#categories").val(categories);
    }

}

function checkboxFormatter2(cellvalue, options, rowObject) {
   
                           return "<input type='checkbox' id='checked2_"+rowObject.id+"' onclick='checkCategory2("+rowObject.id+");'/>";
}

function checkCategory2(rowId) {
    var categories = $("#categories2").val();
    if (($("#checked2_"+rowId).is(":checked"))) {
        var record = jQuery('#listCategories').getRowData(rowId);
        var parentNodes = jQuery("#listCategories").getNodeAncestors(record);   
        for (i = 0; i < parentNodes.length; i++) {
            $("#checked2_"+parentNodes[i]._id_).attr('checked', true);
//            if (categories.indexOf(' '+parentNodes[i]._id_+',')==-1){
//                $("#categories2").val($("#categories2").val()+' '+ parentNodes[i]._id_ +',');
//            }
        }
        $("#categories2").val($("#categories2").val()+' '+ rowId +',');
    } else {
        var record = jQuery('#listCategories').getRowData(rowId);
        var childrenNodes = record.children.split(",");
        for (i = 0; i < childrenNodes.length; i++) 
            if (childrenNodes[i]!=''){       
            $("#checked2_"+childrenNodes[i]).attr('checked', false);
            categories = categories.replace(' '+ childrenNodes[i]+',','');
            }
        categories = categories.replace(' '+ rowId+',','');
        $("#categories2").val(categories);
    }

}

$("#listCategoriesForAdd_category").hide();
$("#listCategoriesForAdd_enbl").hide();

function resetSelect() {
    $("#listAssets").resetSelection();
    $("#listCategoriesForAdd").resetSelection();
    $("#listCategories").resetSelection();
    $.cookie("jqsel_grid_id",null);
}
</script>
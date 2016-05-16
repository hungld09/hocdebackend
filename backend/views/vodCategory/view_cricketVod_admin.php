<?php
$this->breadcrumbs=array(
	'Vod Categories'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create VodCategory', 'url'=>array('create')),
//	array('label'=>'Delete VodCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VodCategory', 'url'=>array('admin')),
);
?>

<h1>VodCategory #<?php echo $model->id; ?></h1>
<h2 style="text-align: center; font-size: x-large; color: blue">
    
    <?php 
     $this->renderPartial('_display_name',array(
	'model'=>$model,
     ));
       
     
    ?>
</h2>

<?php 
//    $this->renderPartial('_basic_info',array(
//	'model'=>$model,
//));
?>
<!--<br/>-->
<?php 
    $this->renderPartial('_description',array(
	'model'=>$model,
));
?>

<br/>
<fieldset style="width: 60%;">
    <legend class="legend"><b>Parent</b></legend>
    <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderParent','style'=>'display:none'));?>
    <div id='parentDisplay'>
        <img class="img_date" src="<?php echo Yii::app()->baseUrl.'/images/tree.png'?>" width="25px"/>
        <b>Path:</b> 
        <span id='pathDisplay'><?php echo $model->path_name;?> </span> 
    </div>
    <div id='parentEdit' class="editField">
        <?php
        $model2 = VodCategory::model()->findAllByAttributes(array("level" => 0));

        $items = array();
        foreach ($model2 as $model3) {

            $model3->path_name = $model3->display_name;
            $items = array_merge($items, $model3->getListed($model->id));
        }

        echo CHtml::activeDropDownList($model, 'parent_id', CHtml::listData($items, 'id', 'path_name'), array('empty' => 'Chọn chuyên mục cha'));
        ?>
    </div>    
        <?php
        echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', array('style' => 'vertical-align: bottom; float:right; cursor:pointer',
            'onclick' => '$("#freeDisplay").hide(); 
                                                            $("#parentDisplay").hide();
                                                            $("#parentEdit").show();
                                                            $("#parentBtnEdit").hide();
                                                            $("#parentBtnSubmit").show();
                                                            $("#parentBtnCancel").show();   
                                                                
                                                           ',
            'id' => 'parentBtnEdit'
        ));
        echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer',
            'onclick' => '$("#freeDisplay").show(); 
                                                            $("#parentDisplay").show();
                                                            $("#parentEdit").hide();
                                                            $("#parentBtnEdit").show();
                                                            $("#loaderParent").show();
                                                            $("#parentBtnSubmit").hide();
                                                            $("#parentBtnCancel").hide();
                                                            sendParent();
                                                                
                                                                
                                                           ',
            'id' => 'parentBtnSubmit'
        ));
        echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer',
            'onclick' => '
                                                            $("#parentDisplay").show();
                                                            $("#parentEdit").hide();
                                                            $("#parentBtnEdit").show();
                                                            $("#parentBtnSubmit").hide();
                                                            $("#parentBtnCancel").hide();
                                                           ',
            'id' => 'parentBtnCancel'
        ));
        ?>
       
</fieldset>
<br/>
<fieldset>
    <legend class="legend"><b>Other Info</b></legend>
    <table>
        <tr>
            <td class="rowDate">
                  <img class="img_date" src="<?php echo Yii::app()->baseUrl.'/images/calendar-icon.png'?>" width="20px"/>
                  <b >Create Date:</b> <?php echo date('d/m/Y',strtotime($model->create_date));?>
            </td>

        </tr>   
    </table>
</fieldset>
<br/>
<label><b>List Asset In Category</b></label><br/><br/>
<?php
$this->renderPartial('_listAsset',array('model'=>$model));
?>
<br/>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'removeDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Remove Assets',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {removeAsset();}','Cancel'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
				
        
    ),
));
?>
<div id="dialog-message" title="Remove Assets">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Are you sure you want to remove all selected assets from this category?
	</p>
	
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'selectDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Please Select Assets',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
				
        
    ),
));
?>
<div id="dialog-message" title="Please Select Assets">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Please selecte assets to remove from this category?
	</p>
	
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
echo CHtml::button('Remove From Category', array(
   'onclick'=>'js:
                    $("#removeDialog").dialog( "open" );
                   
                '
));
?>
<script>
function removeAsset() {
     
    if ($.cookie("jqsel_grid_id") != null && $.cookie("jqsel_grid_id")!='') {
            $.ajax({
                    type: "POST",
                    url: "<?php echo CController::createUrl('removeAssets') ?>",
                    data: {ids: $.cookie("jqsel_grid_id"),id:<?echo $model->id?>},
                    success: function() { 
                        $("#removeDialog").dialog( "close" );
                        $("#listAssets").trigger('reloadGrid');
                    }
            });
    }
    else
    {
        $("#removeDialog").dialog( "close" );
        $("#selectDialog").dialog( "open" );
    }
    this.blur();
    return false;
}

function sendParent() {
   
    $.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodCategory/updateParent') ?>",
 data: {
        parent:$('#VodCategory_parent_id').val(),
        id: "<?php echo $model->id?>" },
 type: 'POST',
 success: function(data){
      $("#loaderParent").hide();
      $("#pathDisplay").text(data);
 }
});
    }

</script>


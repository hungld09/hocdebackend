
<fieldset>
    <legend class="legend"><b>Short Description</b>
    <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderShortDescription','style'=>'display:none'));?>
    </legend>
        <div id="short_description_display">
            <?php 
                echo $model->short_description;  
           
            ?>
        </div>    
        <div id="short_description_input" style="display:none">
            <?php
                $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vod-asset-form-for-short_description',
                        'enableAjaxValidation'=>false,
                ));
		echo $form->textArea($model,'short_description',array('class'=>'textinput','maxlength'=>300));
		echo $form->error($model,'short_description');
                $this->endWidget();
                
            ?>
         </div>    
    <?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; cursor:pointer', 
//                                             'onclick' => ' if (!$("#shortDescriptionDialog").dialog("isOpen"))
//                                                            $("#shortDescriptionDialog").dialog("open"); else  $("#shortDescriptionDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'$("#short_description_display").hide(); 
                                                            $("#short_description_input").show();
                                                            $("#shortDescriptionEdit").hide();
                                                            $("#shortDescriptionSubmit").show();
                                                            $("#shortDescriptionCancel").show(); 
                                                            $("#VodAsset_short_description").focus();
                                                           ',
                                               'id'=>'shortDescriptionEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer', 
//                                             'onclick' => ' if (!$("#shortDescriptionDialog").dialog("isOpen"))
//                                                            $("#shortDescriptionDialog").dialog("open"); else  $("#shortDescriptionDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'$("#short_description_display").show(); 
                                                            $("#short_description_input").hide();
                                                            $("#shortDescriptionEdit").show();
                                                            $("#shortDescriptionSubmit").hide(); 
                                                            $("#shortDescriptionCancel").hide(); 
                                                            sendShortDescription();
                                                            $("#loaderShortDescription").show();
                                                               
                                                            
                                                           ',
                                               'id'=>'shortDescriptionSubmit'             
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                            $("#short_description_display").show(); 
                                                            $("#short_description_input").hide();
                                                            $("#shortDescriptionEdit").show();
                                                            $("#shortDescriptionSubmit").hide(); 
                                                            $("#shortDescriptionCancel").hide(); 
                                                           ',
                                               'id'=>'shortDescriptionCancel'             
                                                            
          ));
    ?>
</fieldset>


<script>
    function sendShortDescription() {
    
                    $.ajax({
  url:"<?php echo Yii::app()->createUrl('admin/vodAsset/updateShortDescription') ?>",
 data: {shortDescription:$('#VodAsset_short_description').val(), id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#short_description_display").text(data);
      $("#loaderShortDescription").hide();
  }
});
    }
</script>


<fieldset >
    <legend class="legend"><b>Description</b>
    <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderDescription','style'=>'display:none'));?>
    </legend>
        <div id="description_display">
            <?php 
                echo $model->description;  
           
            ?>
        </div>    
        <div id="description_input" style="display:none">
            <?php
                $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vod-asset-form-for-description',
                        'enableAjaxValidation'=>false,
                ));
		echo $form->textArea($model,'description',array('class'=>'textinput','maxlength'=>3000));
		echo $form->error($model,'description');
                $this->endWidget();
                
            ?>
         </div>    
    <?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right;cursor:pointer', 
//                                             'onclick' => ' if (!$("#DescriptionDialog").dialog("isOpen"))
//                                                            $("#DescriptionDialog").dialog("open"); else  $("#DescriptionDialog").dialog("close");
//                                                           return false;', 'id' => 'editDescriptionBtn'
                                               'onclick' =>'$("#description_display").hide(); 
                                                            $("#description_input").show();
                                                            $("#DescriptionEdit").hide();
                                                            $("#DescriptionSubmit").show();
                                                            $("#DescriptionCancel").show();
                                                            $("#VodAsset_description").focus();
                                                           ',
                                               'id'=>'DescriptionEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer', 
//                                             'onclick' => ' if (!$("#DescriptionDialog").dialog("isOpen"))
//                                                            $("#DescriptionDialog").dialog("open"); else  $("#DescriptionDialog").dialog("close");
//                                                           return false;', 'id' => 'editDescriptionBtn'
                                               'onclick' =>'$("#description_display").show(); 
                                                            $("#description_input").hide();
                                                            $("#DescriptionEdit").show();
                                                            $("#DescriptionSubmit").hide();
                                                            $("#DescriptionCancel").hide();
                                                            $("#loaderDescription").show();
                                                   
                                                            sendDescription();
                                                               
                                                            
                                                           ',
                                               'id'=>'DescriptionSubmit'             
                                                            
           ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                            $("#description_display").show(); 
                                                            $("#description_input").hide();
                                                            $("#DescriptionEdit").show();
                                                            $("#DescriptionSubmit").hide();
                                                            $("#DescriptionCancel").hide();
                                                           ',
                                               'id'=>'DescriptionCancel'             
                                                            
            ));
    ?>
</fieldset>



<script>
    function sendDescription() {
    
                    $.ajax({
  url:"<?php echo Yii::app()->createUrl('admin/vodAsset/updateDescription') ?>",
 data: {description:$('#VodAsset_description').val(), id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#description_display").text(data);
      $("#loaderDescription").hide();
  }
});
    }
</script>


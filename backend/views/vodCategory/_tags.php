
<fieldset >
    <legend class="legend"><img style="vertical-align:middle" src="<?php echo Yii::app()->baseUrl.'/images/search.png'?>" /><b>Tags</b>
    <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderTags','style'=>'display:none'));?>
    </legend>
        <div id="tags_display">
            <?php 
                
                echo $model->tags;  
           
            ?>
        </div>    
        <div id="tags_input" style="display:none">
            <?php
                $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vod-category-form-for-tags',
                        'enableAjaxValidation'=>false,
                ));
		echo $form->textArea($model,'tags',array('class'=>'textinput','maxlength'=>500));
		echo $form->error($model,'tags');
                $this->endWidget();
                
            ?>
         </div>    
    <?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right;cursor:pointer', 
//                                             'onclick' => ' if (!$("#TagsDialog").dialog("isOpen"))
//                                                            $("#TagsDialog").dialog("open"); else  $("#TagsDialog").dialog("close");
//                                                           return false;', 'id' => 'editTagsBtn'
                                               'onclick' =>'$("#tags_display").hide(); 
                                                            $("#tags_input").show();
                                                            $("#TagsEdit").hide();
                                                            $("#TagsSubmit").show();
                                                            $("#TagsCancel").show();
                                                            $("#VodCategory_tags").focus();
                                                           ',
                                               'id'=>'TagsEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer',
//                                             'onclick' => ' if (!$("#TagsDialog").dialog("isOpen"))
//                                                            $("#TagsDialog").dialog("open"); else  $("#TagsDialog").dialog("close");
//                                                           return false;', 'id' => 'editTagsBtn'
                                               'onclick' =>'$("#tags_display").show(); 
                                                            $("#tags_input").hide();
                                                            $("#TagsEdit").show();
                                                            $("#TagsCancel").hide();
                                                            $("#TagsSubmit").hide();
                                                            $("#loaderTags").show();
                                                            sendTags();
                                                               
                                                            
                                                           ',
                                               'id'=>'TagsSubmit'             
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer', 
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                           $("#tags_display").show(); 
                                                            $("#tags_input").hide();
                                                            $("#TagsEdit").show();
                                                            $("#TagsSubmit").hide(); 
                                                            $("#TagsCancel").hide();
                                                           ',
                                               'id'=>'TagsCancel'             
                                                            
          ));
    ?>
</fieldset>



<script>
    function sendTags() {
    
        $.ajax({
          url:"<?php echo Yii::app()->createUrl('admin/vodCategory/updateTags') ?>",
         data: {tags:$('#VodCategory_tags').val(), id: "<?php echo $model->id?>" },
         type: 'POST',
          success: function(data){
              $("#tags_display").text(data);
              $("#loaderTags").hide();
          }
        });
    }
</script>


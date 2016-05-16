<fieldset id="basic_info_display">
    <legend class="legend"><b>Basic Info</b>
        <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderBasicInfo','style'=>'display:none'));?>
    </legend>
    <?php 
          
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer', 
                                            
                                               'onclick' =>'
                                                            $("#activeDisplay").show();
                                                            $("#activeEdit").hide();
                                                            $("#basicInfoEdit").show();                                                        
                                                            $("#loaderBasicInfo").show();
                                                            $("#basicInfoSubmit").hide();
                                                            $("#basicInfoCancel").hide();
                                                            sendBasicInfo();
                                                           ',
                                               'id'=>'basicInfoSubmit'             
                                                            
            ));
           echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer', 
                                            
                                               'onclick' =>'
                                                            $("#activeDisplay").show();
                                                            $("#activeEdit").hide();
                                                            $("#basicInfoEdit").show();
                                                            $("#basicInfoSubmit").hide();
                                                            $("#basicInfoCancel").hide();
                                                           ',
                                               'id'=>'basicInfoCancel'             
                                                            
            ));
    ?>


<script>
    
   
function sendBasicInfo() {
   
$.ajax({
 url:"<?php echo Yii::app()->createUrl('vodCategory/updateBasicInfo') ?>",
 data: {vod_attribute_set_id: $("#VodCategory_vod_attribute_set_id").val(),
        image_url: $("#VodCategory_image_url").val(),
        status:$('#VodCategory_status').is(":checked"),
        id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#basic_info_display").replaceWith(data);
  }
});
    }
</script>
</fieldset>

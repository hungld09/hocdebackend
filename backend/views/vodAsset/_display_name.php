<?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderDisplayName','style'=>'display:none'));?>

    <span id='displayNameDisplay'>
    <?php
     echo $model->display_name; 
    ?>
    </span>
    <span id='displayNameEdit' class='editField'>
    <?php
     echo CHtml::activeTextField($model, 'display_name',array('style'=>'color: blue;; font-size:x-large!important')); 
    ?>
    </span>
  
<?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom;  cursor:pointer', 
                                         
                                               'onclick' =>' 
                                                            $("#displayNameDisplay").hide(); 
                                                            $("#displayNameEdit").show(); 
                                                            $("#activeDisplay").hide();
                                                            $("#activeEdit").show();
                                                            $("#displayEdit").hide();
                                                            $("#displaySubmit").show();
                                                            $("#displayCancel").show();
                                                           ',
                                               'id'=>'displayEdit'            
                                                            
          ));
          
           echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom;  display:none;margin-right:10px;cursor:pointer', 
                                            
                                               'onclick' =>'
                                                            
                                                            $("#displayNameDisplay").show(); 
                                                            $("#displayNameEdit").hide();  
                                                            $("#displayEdit").show();
                                                            $("#displaySubmit").hide();
                                                            $("#displayCancel").hide();
                                                           ',
                                               'id'=>'displayCancel'             
                                                            
            ));
           echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom;  display:none;cursor:pointer', 
                                            
                                               'onclick' =>'
                                                            
                                                            $("#displayNameDisplay").show(); 
                                                            $("#displayNameEdit").hide();                                                      
                                                            $("#loaderDisplayName").show();
                                                            $("#displayEdit").show();
                                                            $("#displaySubmit").hide();
                                                            $("#displayCancel").hide();
                                                            sendDisplayName();
                                                               
                                                            
                                                           ',
                                               'id'=>'displaySubmit'             
                                                            
            ));
    ?>


<script>
    
   
function sendDisplayName() {
   
$.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/updateDisplayName') ?>",
 data: {
        display_name: $("#VodAsset_display_name").val(),
        id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#loaderDisplayName").hide();
      $("#displayNameDisplay").text(data);
  }
});
    }
</script>
<div class="form-actions">
<fieldset id="basic_info_display">
    <legend class="legend">
<!--     <b>Basic Info</b> -->
        <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'loaderImage','id'=>'loaderBasicInfo','style'=>'display:none'));?>
    </legend>
    <table>
         <?php
            $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'vod-asset-form-for-basic-info',
                        'enableAjaxValidation'=>false,
                ));
         ?>
        <tr>
        	<td style="width:10%">
                <span id="activeDisplay">
                <?php if ($model->status) 
                            echo CHtml::image(Yii::app()->baseUrl.'/images/is_active-icon.jpg','');                  
                ?> 
                </span>
                <span id="activeChecked" class="editField">
                     <?php
                     echo CHtml::image(Yii::app()->baseUrl.'/images/is_active-icon.jpg','');
                     echo $form->checkBox($model, 'status',array('style'=>'vertical-align:top'));
                     ?>
                </span>
            </td>
            <td style="width:10%">
                 <div id="freeDisplay">
                <?php if ($model->is_free) 
                            echo CHtml::image(Yii::app()->baseUrl.'/images/free-icon.png','',array('style'=>'vertical-align: middle'));
                      else  {
                          echo CHtml::image(Yii::app()->baseUrl.'/images/not-free-icon.gif','',array('width'=>38,'style'=>'vertical-align: middle'));
                      }
                ?>    
                </div> 
                <div id="freeChecked" class="editField">
                     <?php
                     echo CHtml::image(Yii::app()->baseUrl.'/images/free-icon.png','',array('style'=>'vertical-align: middle'));
                     echo $form->checkBox($model, 'is_free',array('onclick'=>'$("#priceInput").toggle();'));
                     ?>
                </div>
            </td>
            <td style="width:10%">
                <div id="priceDisplay">
                &nbsp;
                <?php if (!$model->is_free) {                     
                          echo CHtml::image(Yii::app()->baseUrl.'/images/money-icon.png','',array('width'=>25,'style'=>'vertical-align: middle'));
                          echo ' '.floor($model->price);
                      }
                ?> 
                </div>
                <div id="priceInput" class="editField">
                     <?php
                     echo CHtml::image(Yii::app()->baseUrl.'/images/money-icon.png','',array('width'=>25,'style'=>'vertical-align: middle'));
                     echo $form->textField($model, 'price',array('style'=>'width:100px'));
                     ?>
                </div>
            </td>
        <?php 
        $this->endWidget();
        ?>
	        <td style="width:15%">
			    Phim nhiều tập
				<div id="isSeriesDisplay">
				<?php 
				    echo $form->checkBox($model,'is_series_disabled',array('checked' => ($model->is_series==1)?true:false, 'disabled' => "disabled"));
				?>
				</div>
				<div id="isSeriesChecked" class="editField">
					<?php
				    echo $form->checkBox($model,'is_series',array('checked' => ($model->is_series==1)?true:false));
					?>
				</div>
			</td>
			<td style="width:45%">
    <?php 
          echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; cursor:pointer', 
//                                             'onclick' => ' if (!$("#basicInfoDialog").dialog("isOpen"))
//                                                            $("#basicInfoDialog").dialog("open"); else  $("#basicInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editbasicInfoBtn'
                                               'onclick' =>'$("#freeDisplay").hide(); 
                                                            $("#activeDisplay").hide();
                                                            $("#priceDisplay").hide();
                                                            $("#isSeriesDisplay").hide();
                                                            $("#isSeriesChecked").show();
                                                            $("#freeChecked").show();
                                                            $("#activeChecked").show();
                                                            $("#VodAsset_honor").msDropDown();
                                                            if (!$("#VodAsset_is_free").is(":checked"))
                                                               $("#priceInput").show();
                                                            $("#basicInfoEdit").hide();
                                                            $("#basicInfoSubmit").show();
                                                            $("#basicInfoCancel").show();
                                                           ',
                                               'id'=>'basicInfoEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer', 
//                                             'onclick' => ' if (!$("#basicInfoDialog").dialog("isOpen"))
//                                                            $("#basicInfoDialog").dialog("open"); else  $("#basicInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editbasicInfoBtn'
                                               'onclick' =>'$("#freeDisplay").show(); 
                                                            $("#activeDisplay").show();
                                                            $("#priceDisplay").show();
                            								$("#isSeriesDisplay").show();
                                                            $("#isSeriesChecked").hide();
                                                            $("#freeChecked").hide();
                                                            $("#activeChecked").hide();
                                                            $("#priceInput").hide();
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
//                                             'onclick' => ' if (!$("#seriesInfoDialog").dialog("isOpen"))
//                                                            $("#seriesInfoDialog").dialog("open"); else  $("#seriesInfoDialog").dialog("close");
//                                                           return false;', 'id' => 'editShortDescriptionBtn'
                                               'onclick' =>'
                                                            $("#freeDisplay").show(); 
                                                            $("#multibitrateDisplay").show();
                                                            $("#activeDisplay").show();
                                                            $("#priceDisplay").show();
                                                            $("#freeChecked").hide();
                                                            $("#activeChecked").hide();
                                                            $("#priceInput").hide();
                                                            $("#basicInfoEdit").show();
                                                            $("#basicInfoSubmit").hide();
                                                            $("#basicInfoCancel").hide();
                                                            $("#honorEdit").hide();
                                                           ',
                                               'id'=>'basicInfoCancel'             
                                                            
            ));
    ?>
</td>
</tr>
    </table>
    
</fieldset>
</div>

<script>
    
 $("#VodAsset_honor option").each(function () {
    if ($(this).val() == <?php echo $model->honor?>) {
        $(this).attr('selected', true);
    }
 });
    
 function sendBasicInfo() {
                    $.ajax({
 url:"<?php echo Yii::app()->createUrl('vodAsset/updateBasicInfo') ?>",
 data: {isFree:$("#VodAsset_is_free").is(":checked"), 
        status:$('#VodAsset_status').is(":checked"),
        price:$('#VodAsset_price').val(),
        is_series:$('#VodAsset_is_series').is(":checked"),
        id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#basic_info_display").replaceWith(data);
  }
});
    }
</script>
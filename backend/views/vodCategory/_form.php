<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vod-category-form',
	'enableAjaxValidation'=>false,
        'enableClientValidation'=>true
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<h2>
            <div class="row">
                <?php
                echo CHtml::image(Yii::app()->baseUrl . '/images/display_name.png', '', array('style' => 'vertical-align: middle; float:left; margin-right:4px;margin-top:-7px'));
                echo $form->labelEx($model, 'display_name', array('style' => 'width:12%;float:left'));
                ?>
                <?php
                echo $form->textField($model, 'display_name', array('size' => 60, 'maxlength' => 200, 
                                                'onChange' => 'js:$("#VodCategory_code_name").val(getCodeName($("#VodCategory_display_name").val()));', 
                                                'style' => 'float:left;'))
                ?>
                <?php echo $form->error($model, 'display_name'); ?>
            </div>
        </h2>
       
        <br/><br/>
        <span id="activeEdit">
        <?php
        echo CHtml::image(Yii::app()->baseUrl . '/images/is_active-icon.jpg', '').' ';
        echo $form->checkBox($model, 'status', array('style' => 'vertical-align:baseline'));
        ?>
        
	<br/>
        <fieldset style="width: 80%;">
            <legend class="legend"><b>Description</b></legend>
            <div>
                    <?php

                        echo $form->textArea($model,'description',array('class'=>'textinput','maxlength'=>3000));
                        echo $form->error($model,'description');


                    ?>
            </div>
        </fieldset>
        <br/>
        <fieldset style="width: 60%;">
            <legend class="legend"><img style="vertical-align:middle" src="<?php echo Yii::app()->baseUrl . '/images/search.png' ?>"/><b>Tags</b>
            </legend>

        </fieldset>
	<fieldset style="width: 60%;">
            <legend class="legend"><b>Parent</b></legend>
                <?php


                  $model2 = VodCategory::model()->findAllByAttributes(array("level"=>0));

                  $items = array(); 
                      foreach ($model2 as $model3) {

                          $model3->path_name = $model3->display_name;
                          $items = array_merge($items,$model3->getListed($model->id));
                      }
                      
                  echo $form->DropDownList($model,'parent_id', CHtml::listData($items,'id','path_name'),array('empty'=>'Chọn chuyên mục cha'));


                     
 
                ?>
         
		<?php echo $form->error($model,'parent_id'); ?>
        </fieldset>
        


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
</div> 

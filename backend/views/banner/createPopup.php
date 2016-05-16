<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
	    )
	);
?>
<h3>Create Popup</h3>
<br/><br/>
	<?php echo $form->errorSummary($model); ?>
                
	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'time',array('class'=>'span5')); ?>
	<?php echo $form->textAreaRow($model,'content',array('rows'=>6, 'cols'=>100, 'class'=>'ckeditor')); 
				//echo $form->textAreaRow($model,'content',array('rows'=>2, 'cols'=>500)); 
	?>
	<?php // echo $form->textFieldRow($model,'width',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'height',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'height',array('class'=>'span5')); ?>
	
<br/><br/>
	<?php 
                     echo CHtml::image(Yii::app()->baseUrl.'/images/is_active-icon.jpg','',array('width'=>50,'style'=>'vertical-align: middle'));
                     echo $form->checkBox($model, 'status',array('style'=>'vertical-align:top; margin-left:20px'));
                ?> 

	<br/><br/>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	<?php $this->endWidget(); ?>
	
<?php
$this->menu=array(
	array('label'=>'Manage Popup', 'url'=>array('popup')),
);
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
));
$this->menu=array(
	array('label'=>'List Popup','url'=>array('popup')),
);
?>
<h3>Update Popup</h3>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>200)); ?>
                
	<?php echo $form->textAreaRow($model,'content',array('rows'=>6, 'cols'=>100, 'class'=>'ckeditor')); 
	?>
	<br/><br/>
<?php 
                     echo CHtml::image(Yii::app()->baseUrl.'/images/is_active-icon.jpg','',array('width'=>50,'style'=>'vertical-align: middle'));
                     echo $form->checkBox($model, 'status',array('style'=>'vertical-align:top; margin-left:20px'));
                ?> 
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
	array('label'=>'Create Popup','url'=>array('createPopup')),
);
?>


<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'upload-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
	    )
	);
	$this->menu=array(
	array('label'=>'List Banner','url'=>array('admin')),
);
?>
<h3>Update Banner</h3>
<br/>
	<?php echo $form->errorSummary($model); ?>
                
	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'time',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'width',array('class'=>'span5')); ?>
	<?php echo $form->textFieldRow($model,'height',array('class'=>'span5')); ?>
<br/><br/>
	<?php 
                     echo CHtml::image(Yii::app()->baseUrl.'/images/is_active-icon.jpg','',array('width'=>50,'style'=>'vertical-align: middle'));
                     echo $form->checkBox($model, 'status',array('style'=>'vertical-align:top; margin-left:20px'));
                ?> 
<br/><br/>
<?php echo CHtml::image($model->getBanner());?>
	<br/><br/>
	<?php 
	echo $form->labelEx($model, 'picture');
	echo $form->fileField($model, 'picture');
	echo $form->error($model, 'picture');
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
	array('label'=>'Manage Banner', 'url'=>array('admin')),
	array('label'=>'Create Banner','url'=>array('create')),
);
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'type',array('class'=>'span5','maxlength'=>2)); ?>

	<?php echo $form->textFieldRow($model,'source',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'destination',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'message',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'received_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sending_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'mo_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subscriber_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'mt_status',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'mo_status',array('class'=>'span5','maxlength'=>200)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

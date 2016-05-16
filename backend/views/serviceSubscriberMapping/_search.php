<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'service_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'subscriber_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'description',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'activate_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'expiry_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_active',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modify_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_deleted',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pending_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'view_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'download_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'gift_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sent_notification',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'recur_retry_times',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'partner_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'watching_time',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

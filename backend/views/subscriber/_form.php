<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'subscriber-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'subscriber_number',array('class'=>'span5','maxlength'=>45)); ?>

	<?php /*echo $form->textFieldRow($model,'user_name',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php echo $form->textAreaRow($model,'status_log',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'full_name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'last_login_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'last_login_session',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'birthday',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'sex',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'avatar_url',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'yahoo_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'skype_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'google_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'zing_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'facebook_id',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'create_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modify_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'client_app_type',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'using_promotion',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'auto_recurring',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'reserve_column',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'verification_code',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point1',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point2',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point3',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'point4',array('class'=>'span5')); */?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

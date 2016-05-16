<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'report-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'report_name',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'report_parent_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'isReport',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'isRoot',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'template_file',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'type',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
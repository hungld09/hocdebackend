<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'vod-asset-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="form-actions">
	<?php echo $form->errorSummary($model); ?>

	<?php //echo $form->textFieldRow($model,'code_name',array('class'=>'span5','maxlength'=>200)); ?>

	<?php echo $form->textFieldRow($model,'display_name',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'original_title',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'display_name_ascii',array('class'=>'span5','maxlength'=>200)); ?>

	<?php 
	/*echo $form->textFieldRow($model,'original_title',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'tags',array('class'=>'span5','maxlength'=>500)); ?>

	<?php echo $form->textFieldRow($model,'actors',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'director',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'release_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'imdb_url',array('class'=>'span5','maxlength'=>1000)); ?>

	<?php echo $form->textFieldRow($model,'imdb_rating',array('class'=>'span5','maxlength'=>10)); */?>

	<?php echo $form->textAreaRow($model,'short_description',array('rows'=>2, 'cols'=>50, 'class'=>'span8')); ?>
	<?php echo $form->textAreaRow($model,'description',array('rows'=>3, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'director',array('class'=>'span5','maxlength'=>200)); ?>
	<?php echo $form->textFieldRow($model,'actors',array('class'=>'span5','maxlength'=>1000)); ?>
	<?php echo $form->textFieldRow($model,'duration',array('class'=>'span5','maxlength'=>200)); ?>
	<?php
		echo $form->label($model, 'content_provider_id');
		$arrCP = ContentProvider::getAllCPName();
		echo $form->dropDownList($model,'content_provider_id', $arrCP, array('class'=>'span5'));
	?>

	<?php /* echo $form->textFieldRow($model,'view_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'like_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'dislike_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rating',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'rating_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'comment_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'favorite_count',array('class'=>'span5')); */
	?>

	<?php //echo $form->textFieldRow($model,'is_series',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'episode_count',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'duration',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'is_free',array('class'=>'span5')); ?>

	<?php /*echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'price_download',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'price_gift',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'image_count',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'expiry_date',array('class'=>'span5')); */?>

	<?php //echo $form->textFieldRow($model,'status',array('class'=>'span5')); ?>

	<?php /* echo $form->textFieldRow($model,'create_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'modify_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_user_id',array('class'=>'span5','maxlength'=>11)); ?>

	<?php echo $form->textFieldRow($model,'modify_user_id',array('class'=>'span5','maxlength'=>11)); ?>

	<?php echo $form->textFieldRow($model,'honor',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'content_provider_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'using_duration',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'approve_date',array('class'=>'span5')); */?>

	<?php //echo $form->textFieldRow($model,'order_number',array('class'=>'span5')); ?>

	</div>
	<div>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>$model->isNewRecord ? 'Create' : 'Save content',
	)); ?>
</div>

<?php $this->endWidget(); ?>

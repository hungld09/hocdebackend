<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vod-episode-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<table>
    <tr>
        <td>
            <?php echo $form->labelEx($model,'display_name'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'display_name',array('size'=>60,'maxlength'=>200)); ?>
        </td>
    </tr>
            <?php echo $form->error($model,'display_name'); ?>
      

    <tr>
        <td>
            <?php echo $form->labelEx($model,'vod_asset_id'); ?>
        </td>
        <td>
            <?php
            	$vodAsset = VodAsset::model()->findByPk($_REQUEST['vod_asset_id']);
            	$vodAssetName = "";
            	if($vodAsset != NULL) {
					$vodAssetName = $vodAsset->display_name;
				}
            	echo $form->hiddenField($model,'vod_asset_id',array('value'=>$_REQUEST['vod_asset_id']));
            	echo $form->textField($model,'vod_asset_name',array('value'=>$vodAssetName, 'disabled'=>'disabled')); ?>
        </td>
    </tr>	
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeFrom'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episodeFrom'); ?>
        </td>
        <td>
            <?php echo $form->labelEx($model,'episodeTo'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episodeTo'); ?>
        </td>
    </tr>	
    
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeFileName_low'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episodeFileName_low', array('style' => 'width:300px')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeFileName_normal'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episodeFileName_normal', array('style' => 'width:300px')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeFileName_high'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episodeFileName_high', array('style' => 'width:300px')); ?>
        </td>
    </tr>
</table>

        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>


        
<?php $this->endWidget(); ?>

</div><!-- form -->
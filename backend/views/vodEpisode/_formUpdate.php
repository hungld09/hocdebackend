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
	        	$vodAsset = VodAsset::model()->findByPk($model->vod_asset_id);
	        	$vodAssetName = "";
	        	if($vodAsset != NULL) {
	        		$vodAssetName = $vodAsset->display_name;
	        	}
            	echo $form->hiddenField($model,'vod_asset_id',array('value'=>$model->vod_asset_id));
            	echo $form->textField($model,'vod_asset_name',array('value'=>$vodAssetName, 'disabled'=>'disabled')); 
            ?>
        </td>
    </tr>	
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episode_order'); ?>
        </td>
        <td>
            <?php echo $form->textField($model,'episode_order'); ?>
        </td>
    </tr>	
    <?php echo $form->error($model,'episode_order'); ?>
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeStreamUrl_low'); ?>
        </td>
        <td>
            <?php
            	$arrStream = VodStream::model()->findAllByAttributes(array('vod_episode_id'=>$model->id));
            	$stream_low = $arrStream[0];
            	$stream_low->stream_low = $stream_low->stream_url;
            	echo $form->textField($stream_low,'stream_low', array('style' => 'width:500px'));
            	$stream_low->id_low = $stream_low->id;
            	echo $form->hiddenField($stream_low,'id_low', array('style' => 'width:500px')); 
            ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeStreamUrl_normal'); ?>
        </td>
        <td>
            <?php
	            $stream_normal = $arrStream[1];
	            $stream_normal->stream_normal = $stream_normal->stream_url;
	            echo $form->textField($stream_normal,'stream_normal', array('style' => 'width:500px'));
	            $stream_normal->id_normal = $stream_normal->id;
	            echo $form->hiddenField($stream_normal,'id_normal', array('style' => 'width:500px'));
            ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeStreamUrl_high'); ?>
        </td>
        <td>
            <?php 
	            $stream_high = $arrStream[2];
	            $stream_high->stream_high = $stream_high->stream_url;
	            echo $form->textField($stream_high,'stream_high', array('style' => 'width:500px'));
	            $stream_high->id_high = $stream_high->id;
	            echo $form->hiddenField($stream_high,'id_high', array('style' => 'width:500px'));
            ?>
        </td>
    </tr>	
</table>

        <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>


        
<?php $this->endWidget(); ?>

</div><!-- form -->
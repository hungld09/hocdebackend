<?php
$this->breadcrumbs=array(
	'Vod Episodes'=>array('index'),
	$model->id,
);

$this->menu=array(
// 	array('label'=>'List VodEpisode', 'url'=>array('index')),
// 	array('label'=>'Create VodEpisode', 'url'=>array('create')),
	array('label'=>'Chỉnh sửa tập phim', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete VodEpisode', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage VodEpisode', 'url'=>array('admin')),
);
?>

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
            <?php echo $form->textField($model,'display_name',array('size'=>60,'maxlength'=>200, 'disabled'=>'disabled')); ?>
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
            <?php echo $form->textField($model,'episode_order', array('disabled'=>'disabled')); ?>
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
                $servers_streaming = StreamingServer::model()->findAll();
                $server = $servers_streaming[0]->url;
            	$stream_low = $arrStream[0];
            	$stream_low->stream_low = 'http://'.$server.':1935/vod/_definst_/'.$stream_low->stream_url;
            	echo $form->textField($stream_low,'stream_low', array('style' => 'width:500px', 'disabled'=>'disabled'));
            	$stream_low->id_low = $stream_low->id;
            	echo $form->hiddenField($stream_low,'id_low', array('style' => 'width:500px')); 
            ?><br>
            <?php
            $stream_low->stream_low = 'rtsp://'.$server.'/vod/_definst_/'.$stream_low->stream_url;
            echo $form->textField($stream_low,'stream_low', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
            <?php
            $stream_low->stream_low = 'http://'.$server.'/vod/'.$stream_low->stream_url;
            echo $form->textField($stream_low,'stream_low', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeStreamUrl_normal'); ?>
        </td>
        <td>
            <?php
	            $stream_normal = $arrStream[1];
	            $stream_normal->stream_normal = 'http://'.$server.':1935/vod/_definst_/'.$stream_normal->stream_url;
	            echo $form->textField($stream_normal,'stream_normal', array('style' => 'width:500px', 'disabled'=>'disabled'));
	            $stream_normal->id_normal = $stream_normal->id;
	            echo $form->hiddenField($stream_normal,'id_normal', array('style' => 'width:500px'));
            ?><br>
            <?php
            $stream_normal->stream_normal = 'rtsp://'.$server.'/vod/_definst_/'.$stream_normal->stream_url;
            echo $form->textField($stream_normal,'stream_normal', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
            <?php
            $stream_normal->stream_normal = 'http://'.$server.'/vod/'.$stream_normal->stream_url;
            echo $form->textField($stream_normal,'stream_normal', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo $form->labelEx($model,'episodeStreamUrl_high'); ?>
        </td>
        <td>
            <?php 
	            $stream_high = $arrStream[2];
	            $stream_high->stream_high = 'http://'.$server.':1935/vod/_definst_/'.$stream_high->stream_url;
	            echo $form->textField($stream_high,'stream_high', array('style' => 'width:500px', 'disabled'=>'disabled'));
	            $stream_high->id_high = $stream_high->id;
	            echo $form->hiddenField($stream_high,'id_high', array('style' => 'width:500px'));
            ?><br>
            <?php
            $stream_high->stream_high = 'rtsp://'.$server.'/vod/_definst_/'.$stream_high->stream_url;
            echo $form->textField($stream_high,'stream_high', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
            <?php
            $stream_high->stream_high = 'http://'.$server.'/vod/'.$stream_high->stream_url;
            echo $form->textField($stream_high,'stream_high', array('style' => 'width:500px', 'disabled'=>'disabled'));
            ?><br>
        </td>
    </tr>	
</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
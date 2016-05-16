<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_id')); ?>:</b>
	<?php echo CHtml::encode($data->service_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vod_asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->vod_asset_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vod_episode_id')); ?>:</b>
	<?php echo CHtml::encode($data->vod_episode_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscriber_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscriber_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('service_number')); ?>:</b>
	<?php echo CHtml::encode($data->service_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('channel_type')); ?>:</b>
	<?php echo CHtml::encode($data->channel_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('using_type')); ?>:</b>
	<?php echo CHtml::encode($data->using_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_type')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('error_code')); ?>:</b>
	<?php echo CHtml::encode($data->error_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('req_id')); ?>:</b>
	<?php echo CHtml::encode($data->req_id); ?>
	<br />

	*/ ?>

</div>
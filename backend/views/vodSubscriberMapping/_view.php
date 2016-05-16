<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vod_episode_id')); ?>:</b>
	<?php echo CHtml::encode($data->vod_episode_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vod_asset_id')); ?>:</b>
	<?php echo CHtml::encode($data->vod_asset_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscriber_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscriber_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activate_date')); ?>:</b>
	<?php echo CHtml::encode($data->activate_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('expiry_date')); ?>:</b>
	<?php echo CHtml::encode($data->expiry_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modify_date')); ?>:</b>
	<?php echo CHtml::encode($data->modify_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delete_date')); ?>:</b>
	<?php echo CHtml::encode($data->delete_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modify_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->modify_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delete_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->delete_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('using_type')); ?>:</b>
	<?php echo CHtml::encode($data->using_type); ?>
	<br />

	*/ ?>

</div>
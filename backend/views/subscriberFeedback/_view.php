<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscriber_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscriber_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo CHtml::encode($data->content); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status_log')); ?>:</b>
	<?php echo CHtml::encode($data->status_log); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('is_responsed')); ?>:</b>
	<?php echo CHtml::encode($data->is_responsed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response_date')); ?>:</b>
	<?php echo CHtml::encode($data->response_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->response_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response_detail')); ?>:</b>
	<?php echo CHtml::encode($data->response_detail); ?>
	<br />

	*/ ?>

</div>
<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source')); ?>:</b>
	<?php echo CHtml::encode($data->source); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destination')); ?>:</b>
	<?php echo CHtml::encode($data->destination); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('message')); ?>:</b>
	<?php echo CHtml::encode($data->message); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('received_time')); ?>:</b>
	<?php echo CHtml::encode($data->received_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sending_time')); ?>:</b>
	<?php echo CHtml::encode($data->sending_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('mo_id')); ?>:</b>
	<?php echo CHtml::encode($data->mo_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subscriber_id')); ?>:</b>
	<?php echo CHtml::encode($data->subscriber_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mt_status')); ?>:</b>
	<?php echo CHtml::encode($data->mt_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mo_status')); ?>:</b>
	<?php echo CHtml::encode($data->mo_status); ?>
	<br />

	*/ ?>

</div>
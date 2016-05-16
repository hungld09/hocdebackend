<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_name')); ?>:</b>
	<?php echo CHtml::encode($data->report_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('report_parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->report_parent_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isReport')); ?>:</b>
	<?php echo CHtml::encode($data->isReport); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isRoot')); ?>:</b>
	<?php echo CHtml::encode($data->isRoot); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('template_file')); ?>:</b>
	<?php echo CHtml::encode($data->template_file); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	*/ ?>

</div>
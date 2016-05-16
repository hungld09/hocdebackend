<?php
$this->breadcrumbs=array(
	'Sms Messages'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SmsMessage','url'=>array('index')),
	array('label'=>'Create SmsMessage','url'=>array('create')),
	array('label'=>'Update SmsMessage','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SmsMessage','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SmsMessage','url'=>array('admin')),
);
?>

<h1>View SmsMessage #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'type',
		'source',
		'destination',
		'message',
		'received_time',
		'sending_time',
		'mo_id',
		'subscriber_id',
		'mt_status',
		'mo_status',
	),
)); ?>

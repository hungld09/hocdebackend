<?php
$this->breadcrumbs=array(
	'Service Subscriber Mappings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServiceSubscriberMapping','url'=>array('index')),
	array('label'=>'Create ServiceSubscriberMapping','url'=>array('create')),
	array('label'=>'Update ServiceSubscriberMapping','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete ServiceSubscriberMapping','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceSubscriberMapping','url'=>array('admin')),
);
?>

<h1>View ServiceSubscriberMapping #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_id',
		'subscriber_id',
		'description',
		'activate_date',
		'expiry_date',
		'is_active',
		'create_date',
		'modify_date',
		'is_deleted',
		'pending_date',
		'view_count',
		'download_count',
		'gift_count',
		'sent_notification',
		'recur_retry_times',
		'partner_id',
		'watching_time',
	),
)); ?>

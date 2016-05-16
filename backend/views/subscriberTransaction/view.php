<?php
$this->breadcrumbs=array(
	'Subscriber Transactions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SubscriberTransaction','url'=>array('index')),
	array('label'=>'Create SubscriberTransaction','url'=>array('create')),
	array('label'=>'Update SubscriberTransaction','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SubscriberTransaction','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubscriberTransaction','url'=>array('admin')),
);
?>

<h1>View SubscriberTransaction #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_id',
		'vod_asset_id',
		'vod_episode_id',
		'subscriber_id',
		'create_date',
		'status',
		'service_number',
		'description',
		'cost',
		'channel_type',
		'event_id',
		'using_type',
		'purchase_type',
		'error_code',
		'req_id',
	),
)); ?>

<?php
$this->breadcrumbs=array(
	'Subscriber Feedbacks'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List SubscriberFeedback','url'=>array('index')),
	array('label'=>'Create SubscriberFeedback','url'=>array('create')),
	array('label'=>'Update SubscriberFeedback','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SubscriberFeedback','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubscriberFeedback','url'=>array('admin')),
);
?>

<h1>View SubscriberFeedback #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subscriber_id',
		'content',
		'title',
		'create_date',
		'status',
		'status_log',
		'is_responsed',
		'response_date',
		'response_user_id',
		'response_detail',
	),
)); ?>

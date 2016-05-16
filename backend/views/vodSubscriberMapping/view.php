<?php
$this->breadcrumbs=array(
	'Vod Subscriber Mappings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List VodSubscriberMapping','url'=>array('index')),
	array('label'=>'Create VodSubscriberMapping','url'=>array('create')),
	array('label'=>'Update VodSubscriberMapping','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete VodSubscriberMapping','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VodSubscriberMapping','url'=>array('admin')),
);
?>

<h1>View VodSubscriberMapping #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vod_episode_id',
		'vod_asset_id',
		'subscriber_id',
		'description',
		'activate_date',
		'expiry_date',
		'is_active',
		'create_date',
		'modify_date',
		'is_deleted',
		'delete_date',
		'create_user_id',
		'modify_user_id',
		'delete_user_id',
		'using_type',
	),
)); ?>

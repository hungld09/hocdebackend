<?php
$this->breadcrumbs=array(
	'Subscriber Transactions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SubscriberTransaction','url'=>array('index')),
	array('label'=>'Create SubscriberTransaction','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('subscriber-transaction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Subscriber Transactions</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'subscriber-transaction-grid-admin',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'service_id',
		'vod_asset_id',
		'vod_episode_id',
		'subscriber_id',
		'create_date',
		/*
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
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

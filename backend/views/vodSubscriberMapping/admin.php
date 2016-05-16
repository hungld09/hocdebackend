<?php
$this->breadcrumbs=array(
	'Vod Subscriber Mappings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List VodSubscriberMapping','url'=>array('index')),
	array('label'=>'Create VodSubscriberMapping','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vod-subscriber-mapping-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vod Subscriber Mappings</h1>

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
	'id'=>'vod-subscriber-mapping-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'vod_episode_id',
		'vod_asset_id',
		'subscriber_id',
		'description',
		'activate_date',
		/*
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
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

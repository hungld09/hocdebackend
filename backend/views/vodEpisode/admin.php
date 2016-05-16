<?php
$this->breadcrumbs=array(
	'Vod Episodes'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List VodEpisode', 'url'=>array('index')),
	array('label'=>'Create VodEpisode', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vod-episode-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vod-episode-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'vod_asset_id',
//		'code_name',
		'display_name',
		'status',
//		'description',
		/*
		'description_ascii',
		'tags',
		'tags_ascii',
		'episode_order',
		'price',
		'is_free',
		'create_date',
		'create_user_id',
		'modify_date',
		'modify_user_id',
		'view_count',
		'comment_count',
		'favorite_count',
		'vod_stream_count',
		'like_count',
		'dislike_count',
		'duration',
		'rating',
		'rating_count',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

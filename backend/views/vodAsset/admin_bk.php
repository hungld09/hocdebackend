<?php
$this->breadcrumbs=array(
	'Vod Assets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List VodAsset','url'=>array('index')),
	array('label'=>'Create VodAsset','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vod-asset-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vod Assets</h1>

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
	'id'=>'vod-asset-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'code_name',
		'display_name',
		'display_name_ascii',
		'original_title',
		'tags',
		/*
		'actors',
		'director',
		'release_date',
		'imdb_url',
		'imdb_rating',
		'short_description',
		'description',
		'view_count',
		'like_count',
		'dislike_count',
		'rating',
		'rating_count',
		'comment_count',
		'favorite_count',
		'is_series',
		'episode_count',
		'duration',
		'is_multibitrate',
		'vod_stream_count',
		'is_free',
		'price',
		'price_download',
		'price_gift',
		'image_count',
		'expiry_date',
		'status',
		'create_date',
		'modify_date',
		'create_user_id',
		'modify_user_id',
		'honor',
		'content_provider_id',
		'using_duration',
		'approve_date',
		'order_number',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<div id="info" class='form-actions'>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'display_name',
		'short_description',
		'description',
		'director',
		'actors',
// 		'view_count',
// 		'like_count',
// 		'dislike_count',
// 		'rating',
// 		'rating_count',
// 		'comment_count',
// 		'favorite_count',
// 		'is_series',
// 		'episode_count',
// 		'duration',
// 		'is_free',
// 		'price',
// 		'price_download',
// 		'price_gift',
// 		'status',
// 		'create_date',
// 		'modify_date',
// 		'honor',
// 		'content_provider_id',
// 		'using_duration',
// 		'approve_date',
// 		'order_number',
	),
)); 

echo CHtml::button('Chỉnh sửa', array('submit'=>array('vodAsset/update?id='.$model->id)));
?>
<br/>
<?php 
$this->renderPartial('_basic_info', array('model'=>$model));
?>
</div>
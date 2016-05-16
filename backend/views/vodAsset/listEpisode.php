<?php
$this->breadcrumbs=array(
	'Vod Episodes'=>array('index'),
	'Manage',
);
?>

<?php 
echo CHtml::button('Thêm tập phim', array('submit'=>array('vodEpisode/create/vod_asset_id/'.$vod_asset_id)));
?>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'episode-grid',
	'type'=>'striped bordered',
	'dataProvider'=>$model,
// 	'filter'=>$model,
	'columns'=>array(
//		'id',
// 		'vod_asset_id',
//		'code_name',
		'display_name',
        array(
            'header' => 'Trạng thái',
            'type' => 'raw',
            'value' => function ($data) {
                return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.'status'.'" href="'.Yii::app()->createUrl('vodAsset/changeStatus', array('id'=>$data->id,'vodId'=>$data->vod_asset_id)).'" class="glyphicon glyphicon-'.($data->status ? 'ok' : 'remove').'">'.($data->status ? "active" : "inactive").'</a>';
            },
            'headerHtmlOptions' => array(
                'width' => '15%',
            ),
        ),
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
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{view}{update}',
			'buttons'=>array(
				'view'=>
				array(
						'url'=>'Yii::app()->createUrl("vodEpisode/view", array("id"=>$data->id))',
				),
				'update'=>
				array(
						'url'=>'Yii::app()->createUrl("vodEpisode/update", array("id"=>$data->id))',
				),
			),
		),
	),
)); ?>

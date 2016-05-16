<?php
/* @var $this BannerController */
/* @var $model Banner */

$this->breadcrumbs=array(
	'Popup'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create Popup','url'=>array('createPopup')),
);
?>
<h1>Manage Popup</h1>
<?php
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'banner-grid',
	'dataProvider'=>Banner::model()->getListPopup(),
	'columns'=>array(
		array(
				'name' => 'title',
				'type'=>'html',
				'value' => '$data->title',
				'htmlOptions'=>array('width'=>'25%'),
		),
		array(
				'name' => 'url',
				'type'=>'html',
				'value' => '$data->url',
				'htmlOptions'=>array('width'=>'20%'),
		),
		array(
				'name' => 'content',
				'type'=>'html',
				'value' => '$data->content',
				'htmlOptions'=>array('width'=>'25%'),
		),
		array(
				'name' => 'status',
				'type'=>'html',
				'value' => '$data->getStatus()',
				'htmlOptions'=>array('width'=>'10%'),
		),
		array(
				'name' => 'count_click',
				'type'=>'html',
				'value' => '$data->count_click',
				'htmlOptions'=>array('width'=>'10%'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons'=>array(
				'delete'=>
				array(
						'url'=>'Yii::app()->createUrl("banner/delete", array("id"=>$data->id))',
				),
			),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}',
			'buttons'=>array(
				'update'=>
				array(
						'url'=>'Yii::app()->createUrl("banner/update", array("id"=>$data->id))',
				),
			),
		),
	),
));
?>

<?php
$this->breadcrumbs=array(
	'Streaming Log'=>array('index'),
	'Manage',
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'streaming-log-grid-info',
	'type'=>'striped bordered',
	'dataProvider'=>$model,
// 	'filter'=>$model,
	'columns'=>array(
// 		'id',
// 		'subscriber_id',
		array(
				'name'=>'create_date',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'120px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'vod_stream_id',
				'value'=>'$data->getVodName()',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'500px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'channel_type',
// 				'value'=>'$data->getVodName()',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'500px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'status',
				'value'=>'$data->getStatusLabel()',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'90px', 'style' => 'max-height:50px;'),
		),
	),
)); ?>

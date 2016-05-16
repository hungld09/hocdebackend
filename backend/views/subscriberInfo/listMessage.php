<?php
$this->breadcrumbs=array(
	'Sms Messages'=>array('index'),
	'Manage',
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sms-message-grid-info',
	'type'=>'striped bordered',
	'dataProvider'=>$model,
// 	'filter'=>$model,
	'columns'=>array(
// 		'id',
		array(
				'name'=>'received_time',
				// 			'value'=>$model->html_content,
// 				'value'=> 'CHtml::encode(substr(intval($data->cost), 0, 30))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'60px', 'width'=>'90px', 'style' => 'max-height:50px;'),
		),
		'source',
		'destination',
		'message',
		'type',
		/*
		'sending_time',
		'mo_id',
		'subscriber_id',
		'mt_status',
		'mo_status',
		*/
// 		array(
// 			'class'=>'bootstrap.widgets.TbButtonColumn',
// 		),
	),
)); ?>
